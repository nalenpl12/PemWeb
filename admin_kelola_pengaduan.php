<?php
session_start();
include 'db.php';

// Cek jika admin belum login
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: FormLogin.php");
    exit();
}

// Handle perubahan status
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ubah_status'])) {
    $id_aduan = $_POST['id_aduan'];
    $status_baru = $_POST['status'];

    $update = $conn->prepare("UPDATE pengaduan_infrastruktur SET status = ? WHERE id = ?");
    $update->bind_param("si", $status_baru, $id_aduan);
    $update->execute();
    header("Location: admin_kelola_pengaduan.php?success=updated");
    exit();
}

// Handle hapus
if (isset($_GET['hapus'])) {
    $id_hapus = $_GET['hapus'];
    $hapus = $conn->prepare("DELETE FROM pengaduan_infrastruktur WHERE id = ?");
    $hapus->bind_param("i", $id_hapus);
    $hapus->execute();
    header("Location: admin_kelola_pengaduan.php?success=deleted");
    exit();
}

// Ambil semua data pengaduan + nama user
$query = "
    SELECT p.*, u.nama 
    FROM pengaduan_infrastruktur p
    JOIN users u ON p.id_user = u.id
    ORDER BY p.tanggal DESC
";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Kelola Pengaduan</title>
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

        select,
        button {
            padding: 6px 10px;
            border-radius: 5px;
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
            border: none;
            padding: 6px 10px;
            cursor: pointer;
            border-radius: 5px;
        }

        .btn-delete:hover {
            background-color: darkred;
        }

        .btn-update {
            background-color: #0d6efd;
            color: white;
            border: none;
            padding: 6px 10px;
            cursor: pointer;
            border-radius: 5px;
        }

        .btn-update:hover {
            background-color: #003ea8;
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
            Data Pengaduan Infrastruktur Desa Pekarungan
        </div>
        <?php if (isset($_GET['success']) && $_GET['success'] === 'updated'): ?>
            <div class="success-message">✅ Status berhasil diperbarui.</div>
        <?php elseif (isset($_GET['success']) && $_GET['success'] === 'deleted'): ?>
            <div class="success-message">✅ Data berhasil dihapus.</div>
        <?php endif; ?>
        <div class="form-body">
            <table>
                <thead>
                    <tr>
                        <th>Nama User</th>
                        <th>Tanggal</th>
                        <th>Waktu</th>
                        <th>Lokasi</th>
                        <th>Jenis</th>
                        <th>Deskripsi</th>
                        <th>Bukti Gambar</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['nama']); ?></td>
                                <td><?= $row['tanggal']; ?></td>
                                <td><?= $row['waktu']; ?></td>
                                <td><?= $row['lokasi']; ?></td>
                                <td><?= $row['jenis']; ?></td>
                                <td>
                                    <div class="deskripsi"><?= $row['deskripsi']; ?></div>
                                </td>
                                <td>
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <?php if (!empty($row["gambar_$i"])): ?>
                                            <a href="#" onclick="showImage('uploads/<?= $row["gambar_$i"] ?>'); return false;">Lihat
                                                Gambar
                                                <?= $i ?></a><br>
                                        <?php endif; ?>
                                    <?php endfor; ?>
                                </td>

                                <td>
                                    <form method="POST" style="display: flex; gap: 5px;">
                                        <input type="hidden" name="id_aduan" value="<?= $row['id']; ?>">
                                        <select name="status">
                                            <option value="Diajukan" <?= $row['status'] === 'Diajukan' ? 'selected' : ''; ?>>
                                                Diajukan
                                            </option>
                                            <option value="Diproses" <?= $row['status'] === 'Diproses' ? 'selected' : ''; ?>>
                                                Diproses
                                            </option>
                                            <option value="Selesai" <?= $row['status'] === 'Selesai' ? 'selected' : ''; ?>>Selesai
                                            </option>
                                        </select>
                                        <button type="submit" name="ubah_status" class="btn-update">Ubah</button>
                                    </form>
                                </td>
                                <td>
                                    <a href="?hapus=<?= $row['id']; ?>"
                                        onclick="return confirm('Yakin ingin menghapus data ini?')" class="btn-delete">Hapus</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8">Belum ada data pengaduan.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="buttons">
            <button class="btn-red" onclick="window.location.href='admin_dashboard.php'">Kembali</button>
        </div>
        <!-- Modal Gambar -->
        <div id="imageModal"
            style="display: none; position: fixed; z-index: 1000; top:0; left:0; width:100%; height:100%; background-color: rgba(0,0,0,0.6); justify-content: center; align-items: center;">
            <div style="position: relative;">
                <img id="modalImage" src="" alt="Gambar"
                    style="max-width:90vw; max-height:90vh; border: 5px solid white; border-radius: 8px;">
                <span onclick="hideImage()"
                    style="position:absolute; top:-10px; right:-10px; background: white; color: red; font-weight: bold; padding: 5px 10px; cursor: pointer; border-radius: 50%;">X</span>
            </div>
        </div>
        <script>
            function showImage(src) {
                document.getElementById("modalImage").src = src;
                document.getElementById("imageModal").style.display = "flex";
            }

            function hideImage() {
                document.getElementById("imageModal").style.display = "none";
                document.getElementById("modalImage").src = '';
            }
        </script>
    </div>
</body>

</html>