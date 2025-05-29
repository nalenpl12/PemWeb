<?php
session_start();
require 'db.php';

$identifier = $_POST['identifier'];
$password = $_POST['password'];

// Ambil user berdasarkan nama atau email
$sql = "SELECT * FROM users WHERE nama = ? OR email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $identifier, $identifier);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: FormLogin.php?error=usernotfound");
    exit;
}

$user = $result->fetch_assoc();

if (password_verify($password, $user['password'])) {
    // Simpan data sesi
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['nama'] = $user['nama'];
    $_SESSION['role'] = $user['role']; // role: 'user' atau 'admin'

    // Arahkan berdasarkan role
    if ($user['role'] === 'admin') {
        header("Location: admin_dashboard.php");
    } else {
        header("Location: Beranda.html");
    }
    exit;
} else {
    header("Location: FormLogin.php?error=wrongpassword");
    exit;
}
?>