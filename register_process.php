<?php
require 'db.php';

$nama = $_POST['nama'];
$email = $_POST['email'];
$password = $_POST['password'];
$confirm = $_POST['confirm_password'];

// Cek apakah user/email sudah ada
$check = $conn->prepare("SELECT * FROM users WHERE nama = ? OR email = ?");
$check->bind_param("ss", $nama, $email);
$check->execute();
$result = $check->get_result();

if ($result->num_rows > 0) {
    header("Location: FormLogin.php?registerError=userexists");
    exit;
}

// Cek konfirmasi password
if ($password !== $confirm) {
    header("Location: FormLogin.php?registerError=passwordmismatch");
    exit;
}

// Hash password
$hashed = password_hash($password, PASSWORD_DEFAULT);

// Simpan ke database
$sql = "INSERT INTO users (nama, email, password) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $nama, $email, $hashed);

if ($stmt->execute()) {
    header("Location: FormLogin.php?success=registered");
    exit;
} else {
    echo "Gagal daftar: " . $stmt->error;
}
?>