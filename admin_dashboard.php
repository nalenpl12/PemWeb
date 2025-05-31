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
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', sans-serif;
        }

        body {
            position: relative;
            background: linear-gradient(to bottom, #0366d6, #d0e5f9);
            min-height: 130px;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .container {
            background: linear-gradient(to bottom, #AFDDFF 10%, #FBFFFF 37%);
            border-radius: 20px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15);
            width: 100%;
            max-width: 2000px;
            text-align: left;
        }

        .header {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            margin-bottom: 15px;
            align-items: center;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 30px;
            text-align: left;
            margin: 30px 30px 0;
        }

        .header-left h2 {
            color: #004ba0;
            font-size: 20px;
            font-weight: bold;
        }

        .header-left p {
            color: #202020;
            font-size: 15px;
            margin-top: 2px;
        }

        .header-right {
            font-weight: 500;
            font-size: 15px;
            display: flex;
            align-items: center;
            gap: 70px;
            padding: 30px;
        }

        .form-content {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 30px;
            margin: 30px;
        }

        .form-body {
            display: flex;
            width: 100%;
            flex-direction: column;
            flex: 2;
        }

        .form-body_1,
        .form-body_2,
        .form-body_3 {
            display: flex;
            width: 100%;
            margin-bottom: 5px;
            margin-top: 5px;
            gap: 30px;
        }

        .card {
            width: 100%;
            max-width: 390px;
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 2px;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
        }

        .card h2 {
            margin-top: 0;
            color: #004ba0;
        }

        .logout-btn {
            background-color: rgb(255, 12, 12);
            width: 100px;
            text-align: center;
            font-weight: bold;
            box-shadow: 0 5px 5px rgba(0, 0, 0, 0.5);
            color: white;
            padding: 8px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .logout-btn:hover {
            background-color: rgb(152, 16, 16);
        }

        .illustration {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .illustration img {
            width: 100%;
            max-width: 500px;
            height: auto;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="top-section">
            <div class="header">
                <div class="header-left">
                    <img src="img/Sidoarjo.png" alt="Logo Desa" width="100" height="97">
                    <div class="text-content">
                        <h2>ADMIN WEBSITE RESMI PENGADUAN INFRASTRUKTUR<br>DESA PEKARUNGAN</h2>
                        <p>Kecamatan Sukodono, Kabupaten Sidoarjo, Provinsi Jawa Timur</p>
                    </div>
                </div>
                <div class="header-right">
                    <form action="logout.php" method="post">
                        <button type="submit" class="logout-btn">Logout</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="form-content">
            <div class="form-body">
                <div class="form-body_1">
                    <div class="card">
                        <h2>Kelola Pengaduan</h2>
                        <p>Lihat semua pengaduan dari pengguna.</p>
                        <a href="admin_kelola_pengaduan.php">Masuk ke Manajemen Pengaduan</a>
                    </div>
                    <div class="card">
                        <h2>Data Pengguna</h2>
                        <p>Lihat informasi semua pengguna sistem.</p>
                        <a href="admin_data_user.php">Lihat Daftar Pengguna</a>
                    </div>
                </div>
                <div class="form-body_2">
                    <div class="card">
                        <h2>Kelola Saran Pembangunan</h2>
                        <p>Lihat semua saran pembangunan dari pengguna.</p>
                        <a href="admin_kelola_saran.php">Lihat Statistik</a>
                    </div>
                    <div class="card">
                        <h2>Pengaturan Sistem</h2>
                        <p>Kelola pengaturan sistem dan konfigurasi.</p>
                        <a href="#">Masuk ke Pengaturan</a>
                    </div>
                </div>
                <div class="form-body_3">
                    <div class="card">
                        <h2>Profil Admin</h2>
                        <p>Informasi tentang admin yang sedang login.</p>
                        <p>Nama: <?php echo htmlspecialchars($nama); ?></p>
                    </div>
                </div>
            </div>
            <div class="illustration">
                <img src="img/admin.png" alt="Ilustrasi Form">
            </div>
        </div>
    </div>
</body>

</html>