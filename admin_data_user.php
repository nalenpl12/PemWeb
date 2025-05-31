<?php
session_start();
include 'db.php';

// Cek login admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: FormLogin.php");
    exit();
}

$admin_id = $_SESSION['user_id'];

// Hapus user (kecuali admin sendiri)
if (isset($_GET['hapus'])) {
    $id_hapus = $_GET['hapus'];
    if ($id_hapus != $admin_id) {
        $hapus = $conn->prepare("DELETE FROM users WHERE id = ?");
        $hapus->bind_param("i", $id_hapus);
        $hapus->execute();
        header("Location: admin_data_user.php?success=deleted");
        exit();
    }
}

// Ambil semua user (kecuali admin)
$query = "SELECT * FROM users WHERE role = 'user'";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Data Pengguna</title>
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
            border: none;
            padding: 6px 12px;
            cursor: pointer;
            border-radius: 5px;
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
            Data Pengguna Website Pengaduan Desa Pekarungan
        </div>
        <?php if (isset($_GET['success']) && $_GET['success'] === 'deleted'): ?>
            <div class="success-message">✅ Pengguna berhasil dihapus beserta data terkaitnya.</div>
        <?php endif; ?>
        <div class="form-body">
            <table>
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>No. Telepon</th>
                        <th>Alamat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($user = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= htmlspecialchars($user['nama']); ?></td>
                            <td><?= htmlspecialchars($user['email']); ?></td>
                            <td><?= $user['telepon'] ?: '-'; ?></td>
                            <td><?= $user['alamat'] ?: '-'; ?></td>
                            <td>
                                <?php if ($user['id'] != $admin_id): ?>
                                    <a href="?hapus=<?= $user['id']; ?>" class="btn-delete"
                                        onclick="return confirm('Yakin ingin menghapus pengguna ini? Semua datanya akan ikut terhapus.')">Hapus</a>
                                <?php else: ?>
                                    <span style="color: gray;">(Admin)</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
        <div class="buttons">
            <button class="btn-red" onclick="window.location.href='admin_dashboard.php'">Kembali</button>
        </div>
    </div>
</body>

</html>