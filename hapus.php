<?php

include 'koneksi.php'; 

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id_anggota = htmlspecialchars($_GET['id']);

    $sql = "DELETE FROM db_anggota WHERE id_anggota = ?";

    if ($stmt = mysqli_prepare($conn, $sql)) {

        mysqli_stmt_bind_param($stmt, "i", $id_anggota);

        if (mysqli_stmt_execute($stmt)) {
            header("Location: index.php?status=deleted");
            exit();
        } else {
            header("Location: index.php?status=error_delete");
            exit();
        }

        mysqli_stmt_close($stmt);
    } else {
        header("Location: index.php?status=error_prepare");
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}

mysqli_close($conn);
?>
