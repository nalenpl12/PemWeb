<?php
$host = "localhost";
$user = "root";
$pass = ""; // ganti kalau pakai password
$dbname = "pemweb";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
