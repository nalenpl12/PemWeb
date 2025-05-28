<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: FormLogin.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_user = $_SESSION['user_id'];
    $tanggal = $_POST['tanggal'];
    $waktu = $_POST['waktu'];
    $lokasi = $_POST['lokasi'];
    $jenis = $_POST['jenis'];
    $deskripsi = $_POST['deskripsi'];

    $gambar_paths = [];
    $upload_dir = 'uploads/';

    for ($i = 0; $i < 5; $i++) {
        if (isset($_FILES['gambar']['name'][$i]) && $_FILES['gambar']['name'][$i] !== '') {
            $file_tmp = $_FILES['gambar']['tmp_name'][$i];
            $file_name = time() . '_' . basename($_FILES['gambar']['name'][$i]);
            $target_path = $upload_dir . $file_name;

            if (move_uploaded_file($file_tmp, $target_path)) {
                $gambar_paths[] = $file_name;
            } else {
                $gambar_paths[] = null;
            }
        } else {
            $gambar_paths[] = null;
        }
    }

    $stmt = $conn->prepare("INSERT INTO pengaduan_infrastruktur (id_user, tanggal, waktu, lokasi, jenis, deskripsi, gambar_1, gambar_2, gambar_3, gambar_4, gambar_5) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param(
        "issssssssss",
        $id_user,
        $tanggal,
        $waktu,
        $lokasi,
        $jenis,
        $deskripsi,
        $gambar_paths[0],
        $gambar_paths[1],
        $gambar_paths[2],
        $gambar_paths[3],
        $gambar_paths[4]
    );

    if ($stmt->execute()) {
        header("Location: form_pengaduan.php?success=sent");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pengaduan Infrastruktur</title>
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
            margin: 30px 30px 0;
        }

        .form-body {
            display: flex;
            margin-left: 30px;
            margin-right: 30px;
            margin-bottom: 5px;
            margin-top: 15px;
            gap: 30px;
        }

        .box-left {
            width: 100%;
            max-width: 250px;
        }

        .box-right {
            padding-left: 30px;
            width: 100%;
            max-width: 400px;
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

        .box-right textarea {
            height: 219px;
            width: 100%;
            border: 2px solid #ccc;
            box-sizing: border-box;
            padding: 10px;
            margin-top: 5px;
            border-radius: 8px;
        }

        .buttons {
            display: flex;
            gap: 20px;
            margin-top: 5px;
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
            max-width: 400px;
            height: auto;
        }

        .success-message {
            background-color: #d4edda;
            color:rgb(5, 187, 47);
            border: 1px solid #c3e6cb;
            padding: 12px 20px;
            margin: 20px 30px;
            border-radius: 8px;
            font-weight: 500;
            animation: fadeOut 0.5s ease-out 3s forwards;
        }

        @keyframes fadeOut {
            to {
                opacity: 0;
                visibility: hidden;
                height: 0;
                padding: 0;
                margin: 0;
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
                    <a href="StatusAduan.php"><span>Status Aduan</span></a>
                    <a href="Profile.php"><img src="img/User.png" alt="User Icon" width="50" height="50"></a>
                </div>
            </div>
        </div>
        <?php if (isset($_GET['success']) && $_GET['success'] == 'sent'): ?>
            <div class="success-message">Pengaduan berhasil dikirim.</div>
        <?php endif; ?>
        <form method="POST" enctype="multipart/form-data">
            <div class="title">
                Laporkan Infrastruktur Desa Pekarungan
            </div>
            <div class="form-body">
                <div class="box-left">
                    <label for="tanggal">Tanggal Kejadian</label>
                    <input type="date" name="tanggal" id="tanggal" required>

                    <label for="waktu">Waktu Kejadian</label>
                    <input type="time" name="waktu" id="waktu" required>

                    <label for="lokasi">Lokasi Kejadian (jalan & RT/RW)</label>
                    <input type="text" name="lokasi" id="lokasi" required>

                    <label for="jenis">Jenis Infrastruktur</label>
                    <select name="jenis" id="jenis" required>
                        <option value="">-- Pilih --</option>
                        <option value="Jalan">Jalan</option>
                        <option value="Jembatan">Jembatan</option>
                        <option value="Saluran Air">Saluran Air</option>
                        <option value="Lampu Jalan">Lampu Jalan</option>
                        <option value="Fasilitas Umum">Fasilitas Umum</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>
                <div class="box-right">
                    <label for="deskripsi">Deskripsi Pengaduan (optional)</label>
                    <textarea name="deskripsi" id="deskripsi"></textarea>

                    <label for="gambar">Bukti Pendukung (maks. 5 gambar)</label>
                    <input type="file" name="gambar[]" id="gambar" accept="image/*" multiple>
                </div>
                <div class="illustration">
                    <img src="img/pengaduan.png" alt="Ilustrasi Form">
                </div>
            </div>
            <div class="buttons">
                <button type="button" class="btn-red" onclick="window.location.href='Beranda.html'">Kembali</button>
                <button type="submit" class="btn-blue">Kirim</button>
            </div>
        </form>
    </div>
</body>

</html>