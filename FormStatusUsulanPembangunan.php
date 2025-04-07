<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Status Usulan Pembangunan</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap">
  <style>
    :root {
      --primary: #166534;
      --secondary: #22c55e;
      --light: #f0fdf4;
      --dark: #064e3b;
      --bg-color: #e9f5ee;
      --card-bg: white;
      --shadow: rgba(0, 0, 0, 0.1);
    }

    body {
      font-family: 'Poppins', sans-serif;
      background-color: var(--bg-color);
      margin: 0;
      padding: 20px;
      display: flex;
      justify-content: center;
      align-items: flex-start;
      min-height: 100vh;
    }

    .container {
      background-color: var(--card-bg);
      padding: 40px;
      width: 100%;
      max-width: 1200px;
      border-radius: 16px;
      box-shadow: 0 8px 24px var(--shadow);
    }

    h2 {
      text-align: center;
      color: var(--primary);
      margin-bottom: 30px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    th, td {
      border: 1px solid #ccc;
      padding: 14px;
      text-align: left;
    }

    th {
      background-color: var(--primary);
      color: white;
    }

    tr:nth-child(even) {
      background-color: var(--light);
    }

    .action-buttons {
      display: flex;
      gap: 8px;
      flex-wrap: wrap;
    }

    .delete-btn {
      background-color: #dc2626;
      color: white;
      padding: 8px 14px;
      border-radius: 6px;
      text-decoration: none;
      font-weight: 600;
      transition: 0.3s;
    }

    .delete-btn:hover {
      background-color: #b91c1c;
    }

    .edit-btn {
      background-color: #facc15;
      color: black;
    }

    .back-btn {
      display: inline-block;
      margin-top: 30px;
      background-color: #1e3a8a;
      color: white;
      padding: 12px 24px;
      border-radius: 8px;
      text-decoration: none;
      font-weight: 600;
      transition: 0.3s;
    }

    .back-btn:hover {
      background-color: #172554;
    }

    form {
      margin-bottom: 30px;
    }

    form input, form textarea, form button {
      display: block;
      width: 100%;
      margin-bottom: 15px;
      padding: 10px;
      border-radius: 6px;
      border: 1px solid #ccc;
      font-family: 'Poppins', sans-serif;
    }

    form button {
      background-color: var(--primary);
      color: white;
      font-weight: 600;
      cursor: pointer;
    }

    form button:hover {
      background-color: var(--dark);
    }

    @media (max-width: 600px) {
      .action-buttons {
        flex-direction: column;
      }
    }
  </style>
</head>
<body>
<div class="container">
  <h2>Status Usulan Pembangunan</h2>

  <?php
  $host = "localhost";
  $user = "root";
  $pass = "";
  $db   = "UsulanPembangunan_Data";

  $koneksi = mysqli_connect($host, $user, $pass, $db);
  if (!$koneksi) {
      die("Koneksi gagal: " . mysqli_connect_error());
  }

  // Hapus
  if (isset($_GET['hapus'])) {
      $idHapus = $_GET['hapus'];
      $deleteQuery = "DELETE FROM usulan WHERE id = $idHapus";
      if (mysqli_query($koneksi, $deleteQuery)) {
          mysqli_query($koneksi, "SET @count = 0");
          mysqli_query($koneksi, "UPDATE usulan SET id = @count := @count + 1");
          mysqli_query($koneksi, "ALTER TABLE usulan AUTO_INCREMENT = 1");

          echo "<script>alert('Data berhasil dihapus!'); window.location.href='formstatususulanpembangunan.php';</script>";
      }
  }

  // Ambil data untuk edit
  $editData = null;
  if (isset($_GET['edit'])) {
      $idEdit = $_GET['edit'];
      $result = mysqli_query($koneksi, "SELECT * FROM usulan WHERE id = $idEdit");
      $editData = mysqli_fetch_assoc($result);
  }

  // Update
  if (isset($_POST['update'])) {
      $id = $_POST['id'];
      $nama = $_POST['namaPelapor'];
      $lokasi = $_POST['lokasi'];
      $jenis = $_POST['jenis'];
      $deskripsi = $_POST['deskripsi'];
      $estimasi = $_POST['estimasi'];

      $queryUpdate = "UPDATE usulan SET 
          namaPelapor = '$nama',
          lokasi = '$lokasi',
          jenis = '$jenis',
          deskripsi = '$deskripsi',
          estimasi = '$estimasi'
          WHERE id = $id";

      if (mysqli_query($koneksi, $queryUpdate)) {
          echo "<script>alert('Data berhasil diupdate!'); window.location.href='formstatususulanpembangunan.php';</script>";
      } else {
          echo "<script>alert('Gagal update data');</script>";
      }
  }
  ?>

  <?php if ($editData): ?>
    <form method="POST">
      <h3>Edit Usulan ID: <?= $editData['id'] ?></h3>
      <input type="hidden" name="id" value="<?= $editData['id'] ?>">
      <input type="text" name="namaPelapor" value="<?= $editData['namaPelapor'] ?>" placeholder="Nama Pengusul" required>
      <input type="text" name="lokasi" value="<?= $editData['lokasi'] ?>" placeholder="Lokasi" required>
      <input type="text" name="jenis" value="<?= $editData['jenis'] ?>" placeholder="Jenis" required>
      <textarea name="deskripsi" placeholder="Deskripsi" required><?= $editData['deskripsi'] ?></textarea>
      <input type="date" name="estimasi" value="<?= $editData['estimasi'] ?>" required>
      <button type="submit" name="update">Simpan Perubahan</button>
    </form>
  <?php endif; ?>

  <table>
    <thead>
      <tr>
        <th>ID Usulan</th>
        <th>Nama Pengusul</th>
        <th>Lokasi</th>
        <th>Kategori</th>
        <th>Deskripsi</th>
        <th>Estimasi Waktu</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $query = "SELECT * FROM usulan";
      $result = mysqli_query($koneksi, $query);

      if (mysqli_num_rows($result) > 0) {
          while ($row = mysqli_fetch_assoc($result)) {
              echo "<tr>";
              echo "<td>" . $row['id'] . "</td>";
              echo "<td>" . $row['namaPelapor'] . "</td>";
              echo "<td>" . $row['lokasi'] . "</td>";
              echo "<td>" . $row['jenis'] . "</td>";
              echo "<td>" . $row['deskripsi'] . "</td>";
              echo "<td>" . $row['estimasi'] . "</td>";
              echo "<td>
                      <div class='action-buttons'>
                        <a class='delete-btn' href='formstatususulanpembangunan.php?hapus=" . $row['id'] . "' onclick='return confirm(\"Apakah Anda yakin ingin menghapus data ini?\");'>Hapus</a>
                        <a class='delete-btn edit-btn' href='formstatususulanpembangunan.php?edit=" . $row['id'] . "'>Edit</a>
                      </div>
                    </td>";
              echo "</tr>";
          }
      } else {
          echo "<tr><td colspan='7'>Belum ada usulan.</td></tr>";
      }

      mysqli_close($koneksi);
      ?>
    </tbody>
  </table>

  <a href="formusulanpembangunan.php" class="back-btn">+ Buat Usulan Baru</a>
</div>
</body>
</html>
