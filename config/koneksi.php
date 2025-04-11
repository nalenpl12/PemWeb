<?php
//Konfigurasi Database
$host = "localhost";
$user = "root";
$password = "";
$database = "pengaduan";

// Koneksi menggunakan MySQLi
$koneksi = mysqli_connect($host, $user, $password, $database);
if (!$koneksi) { // Cek Koneksi
die("Koneksi gagal: " . mysqli_connect_error());
}
?>
