<?php

include 'koneksi.php'; 

$message = ''; 
$anggota = null; 

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id_anggota = htmlspecialchars($_GET['id']);

    $sql_get = "SELECT * FROM db_anggota WHERE id_anggota = ?";
    if ($stmt_get = mysqli_prepare($conn, $sql_get)) {
        mysqli_stmt_bind_param($stmt_get, "i", $id_anggota);
        mysqli_stmt_execute($stmt_get);
        $result_get = mysqli_stmt_get_result($stmt_get);

        if (mysqli_num_rows($result_get) == 1) {
            $anggota = mysqli_fetch_assoc($result_get);
        } else {
            $message = "<div class='bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4' role='alert'>Data anggota tidak ditemukan.</div>";
        }
        mysqli_stmt_close($stmt_get);
    } else {
        $message = "<div class='bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4' role='alert'>Error prepared statement (get): " . mysqli_error($conn) . "</div>";
    }
} else {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && $anggota) {
    $nama = htmlspecialchars($_POST['nama']);
    $alamat = htmlspecialchars($_POST['alamat']);
    $jenis_paket = htmlspecialchars($_POST['jenis_paket']);
    $tanggal_mulai = htmlspecialchars($_POST['tanggal_mulai']);
    $tanggal_berakhir = htmlspecialchars($_POST['tanggal_berakhir']);
    $id_anggota_post = htmlspecialchars($_POST['id_anggota']); 

    $sql_update = "UPDATE db_anggota SET nama = ?, alamat = ?, jenis_paket = ?, tanggal_mulai = ?, tanggal_berakhir = ? WHERE id_anggota = ?";

    if ($stmt_update = mysqli_prepare($conn, $sql_update)) {
        mysqli_stmt_bind_param($stmt_update, "sssssi", $nama, $alamat, $jenis_paket, $tanggal_mulai, $tanggal_berakhir, $id_anggota_post);

        if (mysqli_stmt_execute($stmt_update)) {
            $message = "<div class='bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4' role='alert'>Data anggota berhasil diperbarui!</div>";

            $anggota['nama'] = $nama;
            $anggota['alamat'] = $alamat;
            $anggota['jenis_paket'] = $jenis_paket;
            $anggota['tanggal_mulai'] = $tanggal_mulai;
            $anggota['tanggal_berakhir'] = $tanggal_berakhir;
        } else {
            $message = "<div class='bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4' role='alert'>Error: " . mysqli_error($conn) . "</div>";
        }

        mysqli_stmt_close($stmt_update);
    } else {
        $message = "<div class='bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4' role='alert'>Error prepared statement (update): " . mysqli_error($conn) . "</div>";
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Anggota Gym</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f0f4f8;
        }
        .container {
            max-width: 800px;
            margin: 40px auto;
            padding: 30px;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        .header {
            background-image: linear-gradient(to right,rgb(53, 125, 225),rgb(89, 112, 207));
            color: #ffffff;
            padding: 24px;
            border-radius: 8px;
            margin-bottom: 24px;
            text-align: center;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #4a5568;
        }
        .form-input, .form-select, .form-textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #cbd5e0;
            border-radius: 8px;
            font-size: 1rem;
            box-sizing: border-box;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }
        .form-input:focus, .form-select:focus, .form-textarea:focus {
            outline: none;
            border-color: #4299e1;
            box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.2);
        }
        .button-submit {
            background-image: linear-gradient(to right, #4299e1, #3182ce);
            color: #ffffff;
            padding: 12px 24px;
            border-radius: 10px;
            border: none;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            box-shadow: 0 4px 10px rgba(66, 153, 225, 0.3);
        }
        .button-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(66, 153, 225, 0.4);
        }
        .button-back {
            display: inline-block;
            background-color: #a0aec0;
            color: #ffffff;
            padding: 12px 24px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            margin-left: 10px;
            transition: background-color 0.2s ease;
        }
        .button-back:hover {
            background-color: #718096;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 class="text-3xl font-bold">Edit Anggota Gym</h1>
        </div>

        <?php echo $message; ?>

        <?php if ($anggota): ?>
            <form action="edit.php?id=<?php echo htmlspecialchars($anggota['id_anggota']); ?>" method="post">
                <input type="hidden" name="id_anggota" value="<?php echo htmlspecialchars($anggota['id_anggota']); ?>">

                <div class="form-group">
                    <label for="nama" class="form-label">Nama:</label>
                    <input type="text" id="nama" name="nama" class="form-input" value="<?php echo htmlspecialchars($anggota['nama']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="alamat" class="form-label">Alamat:</label>
                    <textarea id="alamat" name="alamat" class="form-textarea" rows="3" required><?php echo htmlspecialchars($anggota['alamat']); ?></textarea>
                </div>
                <div class="form-group">
                    <label for="jenis_paket" class="form-label">Jenis Paket:</label>
                    <select id="jenis_paket" name="jenis_paket" class="form-select" required>
                        <option value="Reguler" <?php echo ($anggota['jenis_paket'] == 'Reguler') ? 'selected' : ''; ?>>Reguler</option>
                        <option value="Premium" <?php echo ($anggota['jenis_paket'] == 'Premium') ? 'selected' : ''; ?>>Premium</option>
                        <option value="VIP" <?php echo ($anggota['jenis_paket'] == 'VIP') ? 'selected' : ''; ?>>VIP</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="tanggal_mulai" class="form-label">Tanggal Mulai:</label>
                    <input type="date" id="tanggal_mulai" name="tanggal_mulai" class="form-input" value="<?php echo htmlspecialchars($anggota['tanggal_mulai']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="tanggal_berakhir" class="form-label">Tanggal Berakhir:</label>
                    <input type="date" id="tanggal_berakhir" name="tanggal_berakhir" class="form-input" value="<?php echo htmlspecialchars($anggota['tanggal_berakhir']); ?>" required>
                </div>
                <div class="flex justify-end mt-6">
                    <button type="submit" class="button-submit">Perbarui Data</button>
                    <a href="index.php" class="button-back">Kembali</a>
                </div>
            </form>
        <?php else: ?>
            <div class="text-center py-8">
                <p class="text-gray-600">Terjadi kesalahan atau data tidak ditemukan. Silakan kembali ke halaman utama.</p>
                <a href="index.php" class="button-back mt-4">Kembali</a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
