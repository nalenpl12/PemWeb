<?php
session_start();
include 'db.php';

$user_id = $_SESSION['user_id'];

// tambahkan telepon dan alamat
$query = "SELECT nama, email, telepon, alamat FROM users WHERE id = '$user_id'";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query error: " . mysqli_error($conn));
}

$user = mysqli_fetch_assoc($result);

$nama = $user['nama'];
$email = $user['email'];
$telepon = $user['telepon'];
$alamat = $user['alamat'];

// inisial untuk avatar
$inisial = strtoupper(substr($nama, 0, 1));

// tampilkan xxxxx jika kosong
$tampilTelepon = !empty($telepon) ? htmlspecialchars($telepon) : 'xxxxx';
$tampilAlamat = !empty($alamat) ? htmlspecialchars($alamat) : 'xxxxx';
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Beranda - Pengaduan Infrastruktur</title>
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
            margin-bottom: 5px;
            align-items: center;
        }

        .body {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            align-items: center;
            margin-top: 20px;
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

        .left {
            width: 55%;
            padding: 30px;
        }

        .header-right {
            font-weight: 500;
            font-size: 15px;
            display: flex;
            align-items: center;
            gap: 70px;
            padding: 30px;
        }

        .informasi p {
            margin-top: 10px;
            font-size: 15px;
            font-weight: 500;
        }

        .informasi h3 {
            margin-top: 20px;
            font-size: 20px;
            font-weight: bold;
        }

        .informasi button,
        .aduan button {
            background-color: #0d6efd;
            box-shadow: 0 5px 5px rgba(0, 0, 0, 0.5);
            font-size: 13px;
            margin-top: 15px;
            margin-right: 10px;
            padding: 8px 30px;
            border: none;
            border-radius: 8px;
            color: white;
            cursor: pointer;
            font-weight: 500;
            transition: background-color 0.3s ease;
        }

        .akun button {
            background-color: rgb(255, 12, 12);
            box-shadow: 0 5px 5px rgba(0, 0, 0, 0.5);
            font-size: 13px;
            margin-top: 15px;
            margin-right: 10px;
            padding: 8px 30px;
            border: none;
            border-radius: 8px;
            color: white;
            cursor: pointer;
            font-weight: 500;
            transition: background-color 0.3s ease;
        }

        .akun button:hover {
            background-color: rgb(152, 16, 16);
        }

        .informasi button:hover,
        .aduan button:hover {
            background-color: #00295f;
        }

        .user {
            font-weight: 500;
            font-size: 15px;
            display: flex;
            align-items: center;
            gap: 50px;
        }

        .avatar {
            width: 80px;
            height: 80px;
            background-color: #ccc;
            border-radius: 50%;
            font-size: 36px;
            color: #000;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
        }

        .right {
            display: flex;
            align-items: center;
            gap: 30px;
            text-align: left;
            margin: 30px 30px 0;
        }

        .right img {
            max-width: 80%;
            height: auto;
        }

        h3 {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="top-section">
            <div class="header">
                <div class="header-left">
                    <a href="Beranda.html"><img src="img/Sidoarjo.png" alt="Logo Desa" width="100" height="97"></a>
                    <div class="text-content">
                        <h2>WEBSITE RESMI PENGADUAN INFRASTRUKTUR<br>DESA PEKARUNGAN</h2>
                        <p>Kecamatan Sukodono, Kabupaten Sidoarjo, Provinsi Jawa Timur</p>
                    </div>
                </div>
                <div class="header-right">
                    <a href="Beranda.html"><span>Beranda</span></a>
                    <a href="Profile.php"><img src="img/User.png" alt="User Icon" width="50" height="50"></a>
                </div>
            </div>
            <div class="body">
                <div class="left">
                    <div class="user">
                        <div class="avatar"><?php echo $inisial; ?></div>
                        <h2><?php echo htmlspecialchars($nama); ?></h2>
                    </div>
                    <div class="informasi">
                        <h3>Informasi Pengguna</h3>
                        <p>Alamat Email: <?php echo htmlspecialchars($email); ?></p>
                        <p>Nomor Telepon: <?php echo $tampilTelepon; ?></p>
                        <p>Alamat Rumah: <?php echo $tampilAlamat; ?></p>
                        <button class="btnbiru" onclick="location.href='EditProfile.php'">Ubah Profil</button>
                    </div>
                    <div class="aduan">
                        <h3>Aduan dan Saran</h3>
                        <button class="btnbiru" onclick="location.href='DataAduan.php'">Daftar Aduan</button>
                        <button class="btnbiru" onclick="location.href='FormStatusUsulanPembangunan.php'">Status Usulan</button>
                        <button class="btnbiru" onclick="location.href='StatusAduan.php'">Status Aduan</button>
                    </div>
                    <div class="akun">
                        <h3>Akun</h3>
                        <button class="btnmerah" onclick="location.href='Logout.php'">Keluar dari Akun</button>
                    </div>
                </div>
                <div class="right">
                    <img src="img/Profile01.png" alt="Ilustrasi Profil">
                </div>
            </div>

        </div>
</body>

</html>