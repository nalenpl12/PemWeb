<?php
session_start();
require 'db.php';

$identifier = $_POST['identifier'];
$password = $_POST['password'];

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
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['nama'] = $user['nama'];
    header("Location: dashboard.php");
    exit;
} else {
    header("Location: FormLogin.php?error=wrongpassword");
    exit;
}
?>
