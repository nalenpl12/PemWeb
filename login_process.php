<?php
session_start();
require 'db.php';

$nama = $_POST['nama'];
$password = $_POST['password'];

// Ambil user dari database
$sql = "SELECT * FROM users WHERE nama = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $nama);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    if (password_verify($password, $user['password'])) {
        // Login berhasil
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['nama'] = $user['nama'];
        header("Location: dashboard.php");
        exit;
    } else {
        echo "Password salah!";
    }
} else {
    echo "Akun tidak ditemukan!";
}
?>
