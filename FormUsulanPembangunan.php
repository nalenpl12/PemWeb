<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Form Usulan Pembangunan</title>
  <style>
    body {
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 30px;
  margin: 0;
  background: linear-gradient(to bottom, #FFECDB, #77CDFF);
  font-family: Arial, sans-serif;
}

.container {
  max-width: 600px;
  width: 100%;
  padding: 25px;
  background: #ffffff;
  border-radius: 12px;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
}

h2 {
  margin-bottom: 15px;
  font-size: 22px;
  color: #333;
  text-align: center;
}

.form-group {
  margin-bottom: 15px;
  width: 100%;
}

.form-group label {
  font-weight: bold;
  font-size: 14px;
  display: block;
  margin-bottom: 5px;
  color: #333;
}

.form-group input,
.form-group select,
.form-group textarea {
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 6px;
  font-size: 14px;
  box-sizing: border-box;
  background-color: #fff;
}

.form-row {
  display: flex;
  gap: 10px;
}

.form-row .form-group {
  flex: 1;
}

textarea {
  resize: none;
  height: 80px;
}

.form-buttons {
  display: flex;
  gap: 10px;
  margin-top: 10px;
}

.form-buttons button,
.form-buttons .view-status {
  flex: 1;
  text-align: center;
}

.form-buttons .view-status {
  background-color: #0d6efd;
  color: white;
  font-weight: bold;
  border-radius: 6px;
  padding: 10px;
  text-decoration: none;
  transition: background 0.3s ease;
}

.form-buttons .view-status:hover {
  background-color: #0b5ed7;
}

button {
  width: 100%;
  padding: 10px;
  background-color: dodgerblue;
  color: white;
  font-weight: bold;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  transition: background 0.3s ease;
}

button:hover {
  background-color: #eb5d25;
}

.error {
  color: red;
  font-size: 12px;
  margin-top: 5px;
}


    #jenisLainnya {
      display: none;
    }
  </style>
</head>
<body>
<div class="container">
  <h2>Form Usulan Pembangunan</h2>
  <form action="" method="POST" onsubmit="return validateForm()">
    <div class="form-group">
      <label for="namaPelapor">Nama Pelapor</label>
      <input type="text" id="namaPelapor" name="namaPelapor" required>
    </div>

    <div class="form-group">
      <label for="noHp">Nomor HP</label>
      <input type="text" id="noHp" name="noHp" required>
      <div id="error-noHp" class="error"></div>
    </div>

    <div class="form-group">
      <label for="rtrw">RT / RW</label>
      <input type="text" id="rtrw" name="rtrw" required>
    </div>

    <div class="form-group">
      <label for="jenis">Jenis Pembangunan</label>
      <select id="jenis" name="jenis" required onchange="checkJenis()">
        <option value="" disabled selected>Pilih jenis pembangunan</option>
        <option value="Jalan Raya">Jalan Raya</option>
        <option value="Jembatan">Jembatan</option>
        <option value="Saluran Air">Saluran Air</option>
        <option value="Fasilitas Umum">Fasilitas Umum</option>
        <option value="Lainnya">Lainnya</option>
      </select>
    </div>

    <div class="form-group" id="jenisLainnya" style="display: none;">
      <label for="jenisLain">Jenis Pembangunan (Lainnya)</label>
      <input type="text" id="jenisLain" name="jenisLain">
    </div>

    <div class="form-group">
      <label for="deskripsi">Deskripsi Usulan</label>
      <textarea id="deskripsi" name="deskripsi" required></textarea>
    </div>

    <div class="form-group">
      <label for="estimasi">Estimasi Waktu Pelaksanaan</label>
      <input type="date" id="estimasi" name="estimasi" required>
    </div>

    <div class="form-buttons">
      <button type="submit" name="submit">Kirim Usulan</button>
      <a href="formstatususulanpembangunan.php" class="view-status">Lihat Status</a>
    </div>
  </form>

  <div class="form-buttons">
    <a href="beranda.html" class="view-status" style="background-color: #ff9800;">Kembali ke Beranda</a>
  </div>

  <?php
  $host = "localhost";
  $user = "root";
  $pass = "";
  $db   = "UsulanPembangunan_Data";
  $koneksi = mysqli_connect($host, $user, $pass, $db);
  if (!$koneksi) {
      die("Koneksi gagal: " . mysqli_connect_error());
  }

  if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $hapus = mysqli_query($koneksi, "DELETE FROM usulan WHERE id = $id");
    if ($hapus) {
        mysqli_query($koneksi, "SET @count = 0");
        mysqli_query($koneksi, "UPDATE usulan SET id = @count := @count + 1");
        mysqli_query($koneksi, "ALTER TABLE usulan AUTO_INCREMENT = 1");
        echo "<script>alert('Data berhasil dihapus dan ID direset!'); window.location.href='formstatususulanpembangunan.php';</script>";
    } else {
        echo "Gagal menghapus data.";
    }
  }

  if (isset($_POST['submit'])) {
    $namaPelapor = $_POST['namaPelapor'];
    $noHp = $_POST['noHp'];
    $rtrw = $_POST['rtrw'];
    $lokasi = 'RT/RW ' . $rtrw;

    $jenis = $_POST['jenis'];
    if ($jenis == "Lainnya") {
        $jenis = $_POST['jenisLain'];
    }

    $deskripsi = $_POST['deskripsi'];
    $estimasi = $_POST['estimasi'];

    mysqli_query($koneksi, "SET @count = 0");
    mysqli_query($koneksi, "UPDATE usulan SET id = @count := @count + 1");
    mysqli_query($koneksi, "ALTER TABLE usulan AUTO_INCREMENT = 1");

    $query_usulan = "INSERT INTO usulan (namaPelapor, noHp, lokasi, jenis, deskripsi, estimasi) 
                     VALUES ('$namaPelapor', '$noHp', '$lokasi', '$jenis', '$deskripsi', '$estimasi')";

    if (mysqli_query($koneksi, $query_usulan)) {
        echo "<script>alert('Usulan berhasil dikirim!'); window.location.href='formusulanpembangunan.php';</script>";
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
  }
  mysqli_close($koneksi);
  ?>
</div>

<script>
  function checkJenis() {
    var jenis = document.getElementById("jenis").value;
    var jenisLainnya = document.getElementById("jenisLainnya");
    jenisLainnya.style.display = (jenis === "Lainnya") ? "block" : "none";
  }

  function validateForm() {
    var noHp = document.getElementById('noHp').value;
    var errorMsg = document.getElementById('error-noHp');
    var regex = /^[0-9]+$/;

    if (!regex.test(noHp)) {
      errorMsg.textContent = 'Nomor HP hanya boleh angka.';
      return false;
    }

    if (noHp.length < 10 || noHp.length > 15) {
      errorMsg.textContent = 'Panjang nomor HP harus antara 10-15 digit.';
      return false;
    }

    return true;
  }
</script>
</body>
</html>
