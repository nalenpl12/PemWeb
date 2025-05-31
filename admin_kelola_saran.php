<?php
session_start();
include 'db.php';

// Cek apakah admin sudah login
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: FormLogin.php");
    exit();
}

// Proses hapus data saran jika diminta
if (isset($_GET['hapus'])) {
    $id_hapus = intval($_GET['hapus']);
    $hapus = $conn->prepare("DELETE FROM saran_pembangunan WHERE id = ?");
    $hapus->bind_param("i", $id_hapus);
    $hapus->execute();
    header("Location: admin_kelola_saran.php?success=deleted");
    exit();
}

// Ambil semua data saran dari user
$query = "SELECT saran_pembangunan.*, users.nama FROM saran_pembangunan JOIN users ON saran_pembangunan.id_user = users.id ORDER BY saran_pembangunan.id ASC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Kelola Saran Pembangunan</title>
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
            margin: 30px 30px 30px;
        }

        .form-body {
            display: flex;
            margin-left: 30px;
            margin-right: 30px;
            margin-bottom: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .deskripsi {
            max-width: 200px;
            word-break: break-word;
            white-space: normal;
            height: 70px;
            display: block;
            overflow-y: auto;
            padding: 2px;
            white-space: pre-wrap;
            word-break: break-word;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #e3f2fd;
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

        .btn-red:hover {
            background-color: rgb(152, 16, 16);
        }

        .btn-delete {
            background-color: red;
            color: white;
            padding: 6px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn-delete:hover {
            background-color: darkred;
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
                    <img src="img/Sidoarjo.png" alt="Logo Desa" width="100" height="97">
                    <div class="text-content">
                        <h2>ADMIN WEBSITE RESMI PENGADUAN INFRASTRUKTUR<br>DESA PEKARUNGAN</h2>
                        <p>Kecamatan Sukodono, Kabupaten Sidoarjo, Provinsi Jawa Timur</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="title">
            Data Saran Pembangunan Infrastruktur Desa Pekarungan
        </div>
        <?php if (isset($_GET['success']) && $_GET['success'] === 'deleted'): ?>
            <div class="success-message">Saran berhasil dihapus.</div>
        <?php endif; ?>
        <div class="form-body">
            <table>
                <thead>
                    <tr>
                        <th>Nama Pengguna</th>
                        <th>Jenis Pembangunan</th>
                        <th>Lokasi RT/RW</th>
                        <th>Lokasi Detail</th>
                        <th>Deskripsi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($result) > 0): ?>
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['nama']) ?></td>
                                <td><?= htmlspecialchars($row['jenis_pembangunan']) ?></td>
                                <td><?= htmlspecialchars($row['lokasi_rt_rw']) ?></td>
                                <td><?= htmlspecialchars($row['lokasi_detail']) ?></td>
                                <td>
                                    <div class="deskripsi"><?= htmlspecialchars($row['deskripsi']) ?></div>
                                </td>
                                <td>
                                    <a href="?hapus=<?= $row['id'] ?>" class="btn-delete"
                                        onclick="return confirm('Yakin ingin menghapus saran ini?')">Hapus</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6">Belum ada data saran pembangunan.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="buttons">
            <button class="btn-red" onclick="window.location.href='admin_dashboard.php'">Kembali</button>
        </div>
    </div>
</body>

</html>