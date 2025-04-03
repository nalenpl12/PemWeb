<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Usulan Pembangunan</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }

        .container {
            width: 100%;
            max-width: 400px;
            padding: 25px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h2 {
            margin-bottom: 15px;
            font-size: 20px;
            color: #333;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            margin-bottom: 15px;
            width: 100%;
        }

        label {
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 5px;
            color: #555;
            text-align: left;
            width: 100%;
        }

        input, select, textarea, button {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
            box-sizing: border-box;
        }

        textarea {
            resize: none;
            height: 80px;
        }

        button {
            background-color: #3b82f6;
            color: white;
            font-weight: bold;
            cursor: pointer;
            border: none;
            transition: background 0.3s ease-in-out;
            margin-top: 10px;
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
            text-align: left
        }

        select {
            font-size: 14px;
        }

        .form-group input, .form-group select, .form-group textarea {
            margin-top: 5px;
        }

        .form-group button {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Form Usulan Pembangunan</h2>
        <form action="" method="POST" onsubmit="return validateForm()">
            <div class="form-group">
                <label for="namaPelapor">Nama Pelapor</label>
                <input type="text" id="namaPelapor" name="namaPelapor" required placeholder="Masukkan nama lengkap">
            </div>

            <div class="form-group">
                <label for="noHp">Nomor HP</label>
                <input type="text" id="noHp" name="noHp" required placeholder="Masukkan nomor HP aktif">
                <div id="error-noHp" class="error"></div>
            </div>

            <div class="form-group">
                <label for="lokasi">Lokasi Pembangunan</label>
                <input type="text" id="lokasi" name="lokasi" required placeholder="Masukkan lokasi pembangunan">
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
                <input type="text" id="jenisLain" name="jenisLain" placeholder="Masukkan jenis pembangunan lainnya">
            </div>

            <div class="form-group">
                <label for="deskripsi">Deskripsi Usulan</label>
                <textarea id="deskripsi" name="deskripsi" required placeholder="Jelaskan alasan dan kebutuhan pembangunan"></textarea>
            </div>

            <div class="form-group">
                <label for="estimasi">Estimasi Waktu Pelaksanaan</label>
                <input type="date" id="estimasi" name="estimasi" required>
            </div>

            <button type="submit" name="submit">Kirim Usulan</button>
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
        if (isset($_POST['submit'])) {
            $namaPelapor = $_POST['namaPelapor'];
            $noHp = $_POST['noHp'];
            $lokasi = $_POST['lokasi'];
            $jenis = $_POST['jenis'];
            if ($jenis == "Lainnya") {
                $jenis = $_POST['jenisLain'];
            }
            $deskripsi = $_POST['deskripsi'];
            $estimasi = $_POST['estimasi'];

            $query = "INSERT INTO usulan (namaPelapor, noHp, lokasi, jenis, deskripsi, estimasi) 
                      VALUES ('$namaPelapor', '$noHp', '$lokasi', '$jenis', '$deskripsi', '$estimasi')";

            if (mysqli_query($koneksi, $query)) {
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
                errorMsg.textContent = 'Nomor HP hanya boleh mengandung angka.';
                return false;
            }

            if (noHp.length < 10 || noHp.length > 15) {
                errorMsg.textContent = 'Nomor HP harus antara 10 hingga 15 digit.';
                return false;
            }

            return true;
        }
    </script>
</body>
</html>
