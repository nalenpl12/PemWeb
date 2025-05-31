<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: FormLogin.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Ambil data user untuk menampilkan nama
$query_user = "SELECT nama FROM users WHERE id = ?";
$stmt_user = $conn->prepare($query_user);
$stmt_user->bind_param("i", $user_id);
$stmt_user->execute();
$result_user = $stmt_user->get_result();
$user_data = $result_user->fetch_assoc();
$nama_user = $user_data['nama'];

// Ambil data pengaduan milik user
$query = "SELECT * FROM pengaduan_infrastruktur WHERE id_user = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Aduan</title>
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

        table,
        th,
        td {
            border: 1px solid #999;
        }

        th,
        td {
            padding: 5px;
            text-align: center;
        }

        th {
            background-color: #e0e0e0;
        }

        .actions a {
            margin: 0 5px;
            text-decoration: none;
            color: blue;
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

        .btn-yellow:hover {
            background-color: rgb(182, 121, 8);
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
                    <a href="StatusAduan.php"><span>Status Aduan</span></a>
                    <a href="Profile.php"><img src="img/User.png" alt="User Icon" width="50" height="50"></a>
                </div>
            </div>
        </div>
        <div class="title">
            Data Pengaduanmu <?php echo htmlspecialchars($nama_user); ?>
        </div>
        <?php if (isset($_GET['success']) && $_GET['success'] === 'deleted'): ?>
            <div class="success-message">Data berhasil dihapus!</div>
        <?php endif; ?>
        <div class="form-body">
            <table>
                <thead>
                    <tr>
                        <th>Tanggal Kejadian</th>
                        <th>Waktu Kejadian</th>
                        <th>Lokasi Kejadian</th>
                        <th>Jenis Infrastruktur</th>
                        <th>Deskripsi</th>
                        <th>Bukti Pendukung</th>
                        <th>Aksi</th>
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
                                    <div class="deskripsi"><?= nl2br(htmlspecialchars($row['deskripsi'])); ?></div>
                                </td>
                                <td>
                                    <?php
                                    for ($i = 1; $i <= 5; $i++) {
                                        $gambar = $row['gambar_' . $i];
                                        if (!empty($gambar)) {
                                            echo "<a href='uploads/$gambar' target='_blank'>Gambar $i</a><br>";
                                        }
                                    }
                                    ?>
                                </td>
                                <td class="actions">
                                    <a href="UbahAduan.php?id=<?= $row['id']; ?>">Ubah</a> |
                                    <a href="hapus_aduan.php?id=<?= $row['id'] ?>"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7">Belum ada data pengaduan.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="buttons">
            <button class="btn-red" onclick="window.location.href='Beranda.html'">Beranda</button>
            <button class="btn-yellow" onclick="window.print()">Cetak</button>
            <button class="btn-blue" onclick="window.location.href='form_pengaduan.php'">Buat Aduan</button>
        </div>
    </div>
</body>

</html>