<?php
require 'db.php';

$nama = $_POST['nama'];
$email = $_POST['email'];
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
$sql = "INSERT INTO users (nama, email, password) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $nama, $email, $hashed);

if ($stmt->execute()) {
    // Redirect ke form login dengan pesan sukses
    header("Location: FormLogin.php?success=registered");
    exit;
} else {
    echo "Gagal daftar: " . $stmt->error;
}

?>
