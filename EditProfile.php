<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: Login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Ambil data user saat ini
$query = "SELECT * FROM users WHERE id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = trim($_POST['nama']);
    $email = trim($_POST['email']);
    $telepon = trim($_POST['telepon']);
    $alamat = trim($_POST['alamat']);

    // Update data user
    $update = "UPDATE users SET nama = ?, email = ?, telepon = ?, alamat = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $update);
    mysqli_stmt_bind_param($stmt, "ssssi", $nama, $email, $telepon, $alamat, $user_id);

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['user_nama'] = $nama;
        header("Location: Profile.php");
        exit();
    } else {
        echo "Gagal update: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Edit Profil</title>
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

        .left h2 {
            margin-bottom: 20px;
            color: #004ba0;
        }

        label {
            display: block;
            font-weight: bold;
            margin-top: 20px;
        }

        input[type="text"],
        input[type="email"],
        input[type="tel"] {
            width: 100%;
            padding: 12px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 14px;
        }

        .buttons {
            margin-top: 30px;
            display: flex;
            gap: 20px;
        }

        .buttons button {
            padding: 10px 25px;
            font-size: 14px;
            font-weight: bold;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }

        .btn-red {
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

        .btn-blue {
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

        .btn-red:hover {
            background-color: rgb(152, 16, 16);
        }

        .btn-blue:hover {
            background-color: #00295f;
        }

        .illustration img {
            max-width: 80%;
            height: auto;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="header">
            <div class="header-left">
                <a href="Beranda.html"><img src="img/Sidoarjo.png" alt="Logo Desa" width="100" height="97"></a>
                <div class="text-content">
                    <h2>WEBSITE RESMI PENGADUAN INFRASTRUKTUR<br>DESA PEKARUNGAN</h2>
                    <p>Kecamatan Sukodono, Kabupaten Sidoarjo, Provinsi Jawa Timur</p>
                </div>
            </div>
        </div>
        <div class="body">
            <div class="left">
                <h2>Ubah Informasi Pengguna</h2>
                <form method="POST">
                    <label for="nama">Nama Baru</label>
                    <input type="text" id="nama" name="nama" value="<?= htmlspecialchars($user['nama']) ?>" required>

                    <label for="email">Alamat Email</label>
                    <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>"
                        required>

                    <label for="telepon">Nomor Telepon</label>
                    <input type="tel" id="telepon" name="telepon"
                        value="<?= htmlspecialchars($user['telepon'] ?? '') ?>" required>

                    <label for="alamat">Alamat Rumah</label>
                    <input type="text" id="alamat" name="alamat" value="<?= htmlspecialchars($user['alamat'] ?? '') ?>"
                        required>

                    <div class="buttons">
                        <button type="button" class="btn-red"
                            onclick="window.location.href='Profile.php'">Batal</button>
                        <button type="submit" class="btn-blue">Simpan</button>
                    </div>
                </form>
            </div>
            <div class="right">
                <div class="illustration">
                    <img src="img/EditProfile.png" alt="Ilustrasi Edit Profil">
                </div>
            </div>
        </div>

</body>

</html>