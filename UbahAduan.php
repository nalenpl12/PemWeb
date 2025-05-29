<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: FormLogin.php");
    exit();
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: DataAduan.php");
    exit();
}

$id_aduan = $_GET['id'];
$id_user = $_SESSION['user_id'];

// Ambil data aduan yang dimiliki user
$query = "SELECT * FROM pengaduan_infrastruktur WHERE id = ? AND id_user = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $id_aduan, $id_user);
$stmt->execute();
$result = $stmt->get_result();
$aduan = $result->fetch_assoc();

if (!$aduan) {
    header("Location: DataAduan.php");
    exit();
}

// Update jika form dikirim
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tanggal = $_POST['tanggal'];
    $waktu = $_POST['waktu'];
    $lokasi = $_POST['lokasi'];
    $jenis = $_POST['jenis'];
    $deskripsi = $_POST['deskripsi'];

    $update = $conn->prepare("UPDATE pengaduan_infrastruktur SET tanggal = ?, waktu = ?, lokasi = ?, jenis = ?, deskripsi = ? WHERE id = ? AND id_user = ?");
    $update->bind_param("sssssii", $tanggal, $waktu, $lokasi, $jenis, $deskripsi, $id_aduan, $id_user);

    if ($update->execute()) {
        header("Location: DataAduan.php");
        exit();
    } else {
        echo "Gagal memperbarui data.";
    }
} 
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Ubah Aduan</title>
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

        .attention {
            font-size: 15px;
            font-weight: 500;
            color: rgb(0, 0, 0);
            margin: 10px 30px;
            width: 100%;
            max-width: 50%;
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

        .box-right textarea {
            height: 226px;
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
        <form method="POST" enctype="multipart/form-data">
            <div class="title">
                Laporkan Infrastruktur Desa Pekarungan
            </div>
            <div class="attention">
                <p>Silakan isi form di bawah ini untuk melaporkan infrastruktur yang perlu diperbaiki. <br>Pastikan
                    informasi yang diberikan akurat dan lengkap.</p>
            </div>
            <div class="form-body">
                <div class="box-left">
                    <label for="tanggal">Tanggal Kejadian</label>
                    <input type="date" name="tanggal" id="tanggal" value="<?= $aduan['tanggal'] ?>" required>

                    <label for="waktu">Waktu Kejadian</label>
                    <input type="time" name="waktu" id="waktu" value="<?= $aduan['waktu'] ?>" required>

                    <label for="lokasi">Lokasi Kejadian</label>
                    <input type="text" name="lokasi" id="lokasi" value="<?= $aduan['lokasi'] ?>" required>

                    <label for="jenis">Jenis Infrastruktur</label>
                    <select name="jenis" id="jenis" required>
                        <?php
                        $options = ['Jalan', 'Jembatan', 'Saluran Air', 'Lampu Jalan', 'Fasilitas Umum', 'Lainnya'];
                        foreach ($options as $opt) {
                            $selected = ($aduan['jenis'] === $opt) ? 'selected' : '';
                            echo "<option value='$opt' $selected>$opt</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="box-right">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi"><?= htmlspecialchars($aduan['deskripsi']) ?></textarea>
                </div>
                <div class="illustration">
                    <img src="img/pengaduan.png" alt="Ilustrasi Form">
                </div>
            </div>
            <div class="buttons">
                <button type="button" class="btn-red" onclick="window.location.href='DataAduan.php'">Batal</button>
                <button type="submit" class="btn-blue">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</body>

</html>