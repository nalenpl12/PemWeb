<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "pemweb";

$koneksi = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Ambil data profile dari database
$sql = "SELECT * FROM profile ORDER BY id DESC LIMIT 1"; // ambil data terbaru
$result = mysqli_query($koneksi, $sql);
$data = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Pengguna</title>
</head>

<body>
    <div class="container">
        <div class="profile-header">
            <div class="profile-picture">
                <?php echo strtoupper(substr($data['nama'], 0, 1)); ?>
            </div>
            <div class="profile-info">
                <h2><?php echo $data['nama']; ?></h2>
                <a href="EditProfil.php">Edit Profil</a>
            </div>
        </div>

        <div class="box">
            <h3>Informasi pengguna</h3>
            <p><strong>Alamat email:</strong> <?php echo $data['email']; ?></p>
            <p><strong>Nomor telepon:</strong> <?php echo $data['nomor']; ?></p>
            <p><strong>Alamat rumah:</strong> <?php echo $data['alamat']; ?></p>
        </div>

        <div class="box">
            <h3>Pengaduan & Saran</h3>
            <p><a href="#">Daftar Aduanmu</a></p>
            <p><a href="#">Daftar Saranmu</a></p>
        </div>

        <div class="box">
            <h3>Akun</h3>
            <p><a href="FormLogin.php"> Keluar dari akun</a></p>
        </div>
    </div>
</body>

<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 20px;
        background-color: #f5f5f5;
    }

    .container {
        max-width: 800px;
        margin: auto;
        background: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .profile-header {
        display: flex;
        align-items: center;
    }

    .profile-picture {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background-color: #ccc;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 24px;
        font-weight: bold;
        margin-right: 15px;
    }

    .profile-info {
        font-size: 18px;
    }

    .box {
        background: #fff;
        padding: 15px;
        margin-top: 10px;
        border-radius: 5px;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
    }

    .box h3 {
        margin: 0 0 10px;
    }

    a {
        color: blue;
        text-decoration: none;
    }

    a:hover {
        text-decoration: underline;
    }
</style>

</html>