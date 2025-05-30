<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: FormLogin.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_user = $_SESSION['user_id'];
    $jenis_pembangunan = $_POST['jenis'];
    $lokasi_rt_rw = $_POST['lokasi_rt'];
    $lokasi_detail = $_POST['lokasi_detail'];
    $deskripsi = $_POST['deskripsi'];

    $stmt = $conn->prepare("INSERT INTO saran_pembangunan (id_user, jenis_pembangunan, lokasi_rt_rw, lokasi_detail, deskripsi) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issss", $id_user, $jenis_pembangunan, $lokasi_rt_rw, $lokasi_detail, $deskripsi);

    if ($stmt->execute()) {
        header("Location: form_saran.php?success=sent");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Form Saran Pembangunan</title>
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

        .title {
            font-size: 30px;
            font-weight: 700;
            color: rgb(0, 0, 0);
            margin: 15px 30px 0;
        }

        .form-body {
            display: flex;
            margin-left: 30px;
            margin-right: 30px;
            margin-bottom: 5px;
            gap: 30px;
        }

        .box-left {
            width: 100%;
            max-width: 300px;
        }

        .box-right {
            padding-left: 30px;
            width: 100%;
            max-width: 450px;
        }

        .box-left,
        .box-right,
        .illustration {
            flex: 1;
        }

        label {
            font-weight: bold;
            margin-top: 20px;
            margin-bottom: 5px;
            display: block;
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border-radius: 8px;
            border: 2px solid #ccc;
            box-sizing: border-box;
        }

        textarea {
            height: 50px;
        }

        .box-right textarea {
            height: 150px;
        }

        .form-note {
            color: red;
            font-size: 13px;
            margin-top: 10px;
        }

        .buttons {
            display: flex;
            gap: 20px;
            margin-top: 25px;
            margin-left: 30px;
            margin-right: 30px;
            margin-bottom: 30px;
        }

        .buttons button {
            padding: 10px 10px;
            font-weight: bold;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            width: 150px;
        }

        .btn-blue {
            background-color: #0d6efd;
            width: 100%;
            text-align: center;
            box-shadow: 0 5px 5px rgba(0, 0, 0, 0.5);
            border: none;
            border-radius: 8px;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-red {
            background-color: rgb(255, 12, 12);
            width: 100%;
            text-align: center;
            box-shadow: 0 5px 5px rgba(0, 0, 0, 0.5);
            border: none;
            border-radius: 8px;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-yellow {
            background-color: orange;
            width: 100%;
            text-align: center;
            box-shadow: 0 5px 5px rgba(0, 0, 0, 0.5);
            border: none;
            border-radius: 8px;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-yellow:hover {
            background-color: rgb(182, 121, 8);
        }

        .btn-blue:hover {
            background-color: #00295f;
        }

        .btn-red:hover {
            background-color: rgb(152, 16, 16);
        }

        .illustration {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .illustration img {
            width: 100%;
            max-width: 300px;
            height: auto;
        }

        .success-message {
            background-color: #d4edda;
            color: rgb(5, 187, 47);
            border: 1px solid #c3e6cb;
            padding: 12px 20px;
            margin: 20px 30px;
            border-radius: 8px;
            font-weight: 600;
            animation: fadeOut 0.5s ease-out 3s forwards;
        }

        @keyframes fadeOut {

            0%,
            70% {
                opacity: 1;
            }

            100% {
                opacity: 0;
                display: none;
            }
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
                    <a href="Profile.php"><img src="img/User.png" alt="User Icon" width="50" height="50"></a>
                </div>
            </div>
        </div>
        <?php if (isset($_GET['success']) && $_GET['success'] == 'sent'): ?>
            <div class="success-message">Saran Pembangunan berhasil dikirim.</div>
        <?php endif; ?>
        <form method="POST" enctype="multipart/form-data">
            <div class="title">
                Saran Pembangunan Infrastruktur
            </div>
            <div class="form-body">
                <div class="box-left">
                    <label for="jenis">Jenis Pembangunan</label>
                    <select name="jenis" id="jenis" required>
                        <option value="">-- Pilih --</option>
                        <option value="Jalan Raya">Jalan Raya</option>
                        <option value="Jembatan">Jembatan</option>
                        <option value="Fasilitas Umum">Fasilitas Umum</option>
                        <option value="Saluran Air">Saluran Air</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                    <label for="lokasi_rt">Lokasi Pembangunan (RT/RW)</label>
                    <input type="text" name="lokasi_rt" id="lokasi_rt" required>
                    <label for="lokasi_detail">Lokasi Lebih Detail</label>
                    <textarea name="lokasi_detail" id="lokasi_detail" required></textarea>
                </div>
                <div class="box-right">
                    <label for="deskripsi">Deskripsi (optional)</label>
                    <textarea name="deskripsi" id="deskripsi"></textarea>

                    <div class="form-note">
                        Catatan!!!: Untuk saran pembangunan infrastruktur tidak bisa dibangun secara langsung, namun
                        saran yang diberikan pasti akan ditampung terlebih dahulu dalam sistem dan dipilih berdasarkan
                        skala prioritas pembangunan desa dan kondisi keuangan desa.
                    </div>
                </div>
                <div class="illustration">
                    <img src="img/saran.png" alt="Ilustrasi Saran">
                </div>
            </div>
            <div class="buttons">
                <button type="button" class="btn-red" onclick="window.location.href='Beranda.html'">Kembali</button>
                <button type="submit" class="btn-blue">Kirim</button>
                <button class="btn-yellow" onclick="window.location.href='DataSaran.php'">Daftar Saran</button>
            </div>
        </form>
    </div>
</body>

</html>