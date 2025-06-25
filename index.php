<?php

include 'koneksi.php';

function formatTanggal($tanggal) {
    return date('d-m-Y', strtotime($tanggal));
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Manajemen Anggota Gym</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f0f4f8; 
        }
        .container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        .header {
            background-image: linear-gradient(to right, #4ade80, #22c55e); /* Gradien hijau */
            color: #ffffff;
            padding: 24px;
            border-radius: 8px;
            margin-bottom: 24px;
            text-align: center;
        }
        .table-custom {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .table-custom th, .table-custom td {
            padding: 12px 15px;
            border-bottom: 1px solid #e2e8f0;
            text-align: left;
        }
        .table-custom th {
            background-color: #edf2f7; 
            font-weight: 600;
            color: #2d3748;
            text-transform: uppercase;
            font-size: 0.85rem;
        }
        .table-custom tr:hover {
            background-color: #f7fafc;
        }
        .action-link {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            margin-right: 8px;
            transition: background-color 0.2s ease;
        }
        .edit-link {
            background-color: #3b82f6;
            color: #ffffff;
        }
        .edit-link:hover {
            background-color: #2563eb;
        }
        .hapus-link {
            background-color: #ef4444; 
            color: #ffffff;
        }
        .hapus-link:hover {
            background-color: #dc2626;
        }
        .add-button {
            display: inline-block;
            background-image: linear-gradient(to right, #4299e1, #3182ce); 
            color: #ffffff;
            padding: 12px 24px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            box-shadow: 0 4px 10px rgba(66, 153, 225, 0.3);
        }
        .add-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(66, 153, 225, 0.4);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 class="text-4xl font-bold mb-2">Sistem Manajemen Anggota Gym</h1>
            <p class="text-lg">Daftar Anggota Saat Ini</p>
        </div>

        <div class="flex justify-end mb-6">
            <a href="tambah.php" class="add-button">
                + Tambah Anggota Baru
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th>ID Anggota</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>Jenis Paket</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Berakhir</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM db_anggota ORDER BY id_anggota DESC";
                    $result = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['id_anggota']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['nama']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['alamat']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['jenis_paket']) . "</td>";
                            echo "<td>" . formatTanggal($row['tanggal_mulai']) . "</td>";
                            echo "<td>" . formatTanggal($row['tanggal_berakhir']) . "</td>";
                            echo "<td>";
                            echo "<a href='edit.php?id=" . htmlspecialchars($row['id_anggota']) . "' class='action-link edit-link'>Edit</a>";
                            echo "<a href='hapus.php?id=" . htmlspecialchars($row['id_anggota']) . "' class='action-link hapus-link' onclick='return confirm(\"Apakah Anda yakin ingin menghapus data ini?\")'>Hapus</a>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7' class='text-center py-4'>Tidak ada data anggota.</td></tr>";
                    }

                    mysqli_close($conn);
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
