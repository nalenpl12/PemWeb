<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: FormLogin.php");
    exit();
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_aduan = $_GET['id'];
    $id_user = $_SESSION['user_id'];

    $cek = mysqli_query($conn, "SELECT * FROM pengaduan_infrastruktur WHERE id = '$id_aduan' AND id_user = '$id_user'");
    if (mysqli_num_rows($cek) > 0) {
        $hapus = mysqli_query($conn, "DELETE FROM pengaduan_infrastruktur WHERE id = '$id_aduan' AND id_user = '$id_user'");
        if ($hapus) {
            header("Location: DataAduan.php?success=deleted");
            exit();
        } else {
            header("Location: DataAduan.php?error=gagalhapus");
            exit();
        }
    } else {
        header("Location: DataAduan.php?error=tidaksesuai");
        exit();
    }
} else {
    header("Location: DataAduan.php");
    exit();
}
