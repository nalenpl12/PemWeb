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
      background: linear-gradient(to bottom, #004e92,rgb(112, 224, 255));
      font-family: Arial, sans-serif;
    }

    .container {
      max-width: 600px;
      width: 100%;
      padding: 25px;
      background: #e0f7ff;
      border-radius: 12px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    h2 {
      margin-bottom: 15px;
      font-size: 20px;
      color: #004e92; 
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
      color: #004e92; 
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
      background-color: #10b981;
      color: white;
      font-weight: bold;
      border-radius: 6px;
      padding: 10px;
      text-decoration: none;
      transition: background 0.3s ease;
    }

    .form-buttons .view-status:hover {
      background-color: #059669;
    }

    button {
      width: 100%;
      padding: 10px;
      background-color: #3b82f6;
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
        <label for="jalan">Alamat Jalan</label>
        <input type="text" id="jalan" name="jalan" required>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label for="rtrw">RT / RW</label>
          <input type="text" id="rtrw" name="rtrw" required>
        </div>
        <div class="form-group">
          <label for="kodepos">Kode Pos</label>
          <input type="text" id="kodepos" name="kodepos" required>
        </div>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label for="kelurahan">Kelurahan</label>
          <input type="text" id="kelurahan" name="kelurahan" required>
        </div>
        <div class="form-group">
          <label for="kecamatan">Kecamatan</label>
          <input type="text" id="kecamatan" name="kecamatan" required>
        </div>
      </div>

      <div class="form-row">
        <div class="form-group">
          <label for="kota">Kota / Kabupaten</label>
          <input type="text" id="kota" name="kota" required>
        </div>
        <div class="form-group">
          <label for="provinsi">Provinsi</label>
          <input type="text" id="provinsi" name="provinsi" required>
        </div>
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

      <div class="form-group" id="jenisLainnya">
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

    // Hapus data
    $hapus = mysqli_query($koneksi, "DELETE FROM usulan WHERE id = $id");

    if ($hapus) {
        // Setelah delete, reset ulang ID agar rapat
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
    
        $jalan     = $_POST['jalan'];
        $rtrw      = $_POST['rtrw'];
        $kelurahan = $_POST['kelurahan'];
        $kecamatan = $_POST['kecamatan'];
        $kota      = $_POST['kota'];
        $provinsi  = $_POST['provinsi'];
        $kodepos   = $_POST['kodepos'];
    
        $lokasi = $jalan . ', RT/RW ' . $rtrw . ', Kel. ' . $kelurahan . ', Kec. ' . $kecamatan . ', ' . $kota . ', ' . $provinsi . ' - ' . $kodepos;
    
        $jenis = $_POST['jenis'];
        if ($jenis == "Lainnya") {
            $jenis = $_POST['jenisLain'];
        }
    
        $deskripsi = $_POST['deskripsi'];
        $estimasi = $_POST['estimasi'];
    
        // Reset ID (hati-hati! ini bisa mengubah data ID yang sudah ada)
        mysqli_query($koneksi, "SET @count = 0");
        mysqli_query($koneksi, "UPDATE usulan SET id = @count := @count + 1");
        mysqli_query($koneksi, "ALTER TABLE usulan AUTO_INCREMENT = 1");
    
        // Insert ke tabel usulan
        $query_usulan = "INSERT INTO usulan (namaPelapor, noHp, lokasi, jenis, deskripsi, estimasi) 
                         VALUES ('$namaPelapor', '$noHp', '$lokasi', '$jenis', '$deskripsi', '$estimasi')";

        if (mysqli_query($koneksi, $query_usulan) && mysqli_query($koneksi, $query_lokasi)) {
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

      if (jenis === "Lainnya") {
        jenisLainnya.style.display = "block";
      } else {
        jenisLainnya.style.display = "none";
      }
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
