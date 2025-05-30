<?php
session_start();
include 'db.php';

// Pastikan user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: FormLogin.php");
    exit();
}

$id_user = $_SESSION['user_id'];

// Pastikan ada parameter ID yang dikirim
if (isset($_GET['id'])) {
    $id_saran = $_GET['id'];

    // Cek apakah data saran milik user yang sedang login
    $query = "DELETE FROM saran_pembangunan WHERE id = ? AND id_user = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $id_saran, $id_user);

    if ($stmt->execute()) {
        header("Location: DataSaran.php?success=deleted");
        exit();
    } else {
        echo "Gagal menghapus data.";
    }
} else {
    echo "ID tidak ditemukan.";
}
?>