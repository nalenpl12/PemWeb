<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: FormLogin.php");
    exit();
}

$nama = $_SESSION['nama'];
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(to bottom, #0366d6, #d0e5f9);
            margin: 0;
            padding: 0;
        }

        .navbar {
            background-color: #004ba0;
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar h1 {
            margin: 0;
            font-size: 20px;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }

        .container {
            padding: 30px;
        }

        .card {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
        }

        .card h2 {
            margin-top: 0;
            color: #004ba0;
        }

        .logout-btn {
            background-color: red;
            color: white;
            padding: 8px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="navbar">
        <h1>Selamat Datang, Admin <?= htmlspecialchars($nama) ?></h1>
        <a href="Logout.php" class="logout-btn">Keluar</a>
    </div>
    <div class="container">
        <div class="card">
            <h2>Kelola Pengaduan</h2>
            <p>Lihat dan tanggapi semua pengaduan dari pengguna.</p>
            <a href="KelolaPengaduan.php">Masuk ke Manajemen Pengaduan</a>
        </div>

        <div class="card">
            <h2>Data Pengguna</h2>
            <p>Lihat informasi semua pengguna sistem.</p>
            <a href="DataPengguna.php">Lihat Daftar Pengguna</a>
        </div>

        <!-- Tambahkan modul lain sesuai kebutuhan -->
    </div>
</body>

</html>