<?php
require 'db.php';

$nama = $_POST['nama'];
$password = $_POST['password'];
$confirm = $_POST['confirm_password'];

// Cek konfirmasi password
if ($password !== $confirm) {
    echo "Password dan konfirmasi tidak cocok!";
    exit;
}

// Hash password
$hashed = password_hash($password, PASSWORD_DEFAULT);

// Simpan ke database
$sql = "INSERT INTO users (nama, password) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $nama, $hashed);

if ($stmt->execute()) {
    echo "Registrasi berhasil. <a href='FormLogin.php'>Login sekarang</a>";
} else {
    echo "Gagal daftar: " . $conn->error;
}
?>
