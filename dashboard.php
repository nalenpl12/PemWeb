<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: FormLogin.html");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>
    <h2>Selamat datang, <?php echo $_SESSION['nama']; ?>!</h2>
    <p>Ini adalah halaman dashboard.</p>
    <a href="logout.php">Logout</a>
</body>
</html>
