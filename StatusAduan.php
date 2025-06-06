<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: FormLogin.php");
    exit();
}

$id_user = $_SESSION['user_id'];
$user = $_SESSION['nama'];

// Ambil data pengaduan user
$query = "SELECT * FROM pengaduan_infrastruktur WHERE id_user = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_user);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Status Pengaduan</title>
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
            margin: 30px 30px 30px;
        }

        .form-body {
            display: flex;
            margin-left: 30px;
            margin-right: 30px;
            margin-bottom: 5px;
        }

        h2 {
            margin-bottom: 20px;
            color: #000;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
        }

        .deskripsi {
            max-width: 300px;
            word-break: break-word;
            white-space: normal;
            height: 70px;
            display: block;
            overflow-y: auto;
            padding: 2px;
            white-space: pre-wrap;
            word-break: break-word;
        }


        table,
        th,
        td {
            border: 1px solid #999;
        }

        th,
        td {
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #e0e0e0;
        }

        .status {
            font-weight: bold;
            padding: 5px 10px;
            border-radius: 6px;
            display: inline-block;
        }

        .status.Diajukan {
            background-color: #ffc107;
            color: #000;
        }

        .status.Diproses {
            background-color: #0d6efd;
            color: #fff;
        }

        .status.Selesai {
            background-color: #28a745;
            color: #fff;
        }

        .buttons {
            display: flex;
            gap: 20px;
            margin-top: 30px;
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

        .btn-blue:hover {
            background-color: #00295f;
        }

        .btn-red:hover {
            background-color: rgb(152, 16, 16);
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
        <div class="title">
            Status Pengaduanmu <?= htmlspecialchars($user); ?>
        </div>
        <div class="form-body">
            <table>
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Waktu</th>
                        <th>Lokasi</th>
                        <th>Jenis Infrastruktur</th>
                        <th>Deskripsi</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['tanggal']); ?></td>
                                <td><?= htmlspecialchars($row['waktu']); ?></td>
                                <td><?= htmlspecialchars($row['lokasi']); ?></td>
                                <td><?= htmlspecialchars($row['jenis']); ?></td>
                                <td>
                                    <div class="deskripsi"><?= htmlspecialchars($row['deskripsi']); ?></div>
                                </td>
                                <td><span
                                        class="status <?= htmlspecialchars($row['status']); ?>"><?= htmlspecialchars($row['status']); ?></span>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6">Belum ada data pengaduan.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="buttons">
            <button class="btn-red" onclick="window.location.href='Beranda.html'">Beranda</button>
            <button class="btn-blue" onclick="window.location.href='form_pengaduan.php'">Buat Aduan</button>
        </div>
    </div>
</body>

</html>