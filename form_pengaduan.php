<?php
//Koneksi ke Database
include 'koneksi.php';

//Inisialisasi Variabel
$nama = "";
$nohp = "";
$alamat = "";
$tanggal = "";
$jam = "";
$lokasi = "";
$kategori = "";
$deskripsi = "";
$error = "";
$sukses = "";

//Definisikan $op untuk menghindari warning
$op = isset($_GET['op']) ? $_GET['op'] : "";

//Hapus Data
if ($op == 'delete' && isset($_GET['id_aduan'])) {
    $id_aduan = $_GET['id_aduan'];
    $sql1 = "DELETE FROM aduan where id_aduan = '$id_aduan'";
    $q1 = mysqli_query($koneksi, $sql1);
    if ($q1) {
        $sukses = "Berhasil hapus data";
    } else {
        $error = "Gagal menghapus data";
    }
}

//Ambil data untuk Edit
if ($op == 'edit' && isset($_GET['id_aduan'])) {
    $id_aduan = $_GET['id_aduan'];
    $sql1 = "SELECT * FROM aduan WHERE id_aduan = '$id_aduan'";
    $q1 = mysqli_query($koneksi, $sql1);
    if ($row1 = mysqli_fetch_array($q1)) {
        $nama = $row1['nama'];
        $nohp = $row1['nohp'];
        $alamat = $row1['alamat'];
        $tanggal = $row1['tanggal'];
        $jam = $row1['jam'];
        $lokasi = $row1['lokasi'];
        $kategori = $row1['kategori'];
        $deskripsi = $row1['deskripsi'];
    } else {
        $error = "Data tidak ditemukan";
    }
}

//Tambah atau Edit Data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $nohp = $_POST['nohp'];
    $alamat = $_POST['alamat'];
    $tanggal = $_POST['tanggal'];
    $jam = $_POST['jam'];
    $lokasi = $_POST['lokasi'];
    $kategori = $_POST['kategori'];
    $deskripsi = $_POST['deskripsi'];

    if (!preg_match('/^\d+$/', $nohp)) {
        $error = "Nomor HP hanya boleh berisi angka!";
    }

    if ($nama && $nohp && $alamat && $tanggal && $jam && $lokasi && $kategori && $deskripsi) {
        if ($op == 'edit') {
            // Pastikan id_aduan tersedia
            if (isset($_GET['id_aduan'])) {
                $id_aduan = $_GET['id_aduan'];

                //Untuk Update
                $sql1 = "UPDATE aduan SET nama = '$nama', nohp = '$nohp', alamat = '$alamat', tanggal = '$tanggal', jam = '$jam', lokasi = '$lokasi', kategori = '$kategori', deskripsi = '$deskripsi' WHERE id_aduan = '$id_aduan'";
                $q1 = mysqli_query($koneksi, $sql1);
                if ($q1) {
                    echo "<script>alert('Data berhasil diupdate!'); window.location.href='StatusAduan.php';</script>";
                    exit;
                } else {
                    $error = "Gagal memperbarui data!";
                }
            } else {
                $error = "ID Aduan tidak ditemukan!";
            }
        } else {
            //untuk insert
            $sql1 = "INSERT INTO aduan (nama, nohp, alamat, tanggal, jam, lokasi, kategori, deskripsi) VALUES ('$nama', '$nohp', '$alamat', '$tanggal', '$jam', '$lokasi', '$kategori', '$deskripsi')";
            $q1 = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $SESSION['sukses'] = "Pengaduan berhasil dikirim!";
                header("Location: StatusAduan.php");
                exit;
            } else {
                $error = "Gagal memasukkan data!";
            }
        }

    } else {
        $error = "Silakan isi semua data!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pengaduan Infrastruktur</title>
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
            margin-bottom: 20px;
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

        .form-group {
            display: flex;
            flex-direction: column;
            margin-bottom: 15px;
            margin-top: 5px;
        }

        form {
            display: grid;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            width: 500px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
            background-color: #fff;
        }

        button {
            margin-top: 18px;
            background-color: dodgerblue;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }

        .button-link {
            display: inline-block;
            padding: 10px 15px;
            background-color: #0d6efd;
            color: white;
            border: none;
            border-radius: 4px;
            text-align: center;
            text-decoration: none;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        a.button-link:hover {
            background-color: #0d6efd;
        }

        button:hover {
            background-color: dodgerblue;
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

            <div class="alert error"><?php echo $error; ?></div>
            <?php ; ?>

            <?php if ($sukses): ?>
                <div class="alert success"><?php echo $sukses; ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="form-group">
                    <label for="nama">Nama Pelapor:</label>
                    <input type="text" name="nama" id="nama" value="<?= htmlspecialchars($nama) ?>" required>
                </div>

                <div class="form-group">
                    <label for="nohp">Nomor HP:</label>
                    <input type="text" name="nohp" id="nohp" value="<?= htmlspecialchars($nohp) ?>" required
                        pattern="^[0-9]{10,15}$" title="Nomor HP hanya boleh berisi angka (10–15 digit)">
                </div>

                <div class="form-group">
                    <label for="alamat">Alamat:</label>
                    <textarea name="alamat" id="alamat" rows="3" required><?= htmlspecialchars($alamat) ?></textarea>
                </div>

                <div class="form-group">
                    <label for="tanggal">Tanggal Kejadian:</label>
                    <input type="date" name="tanggal" id="tanggal" value="<?= htmlspecialchars($tanggal) ?>" required>
                </div>

                <div class="form-group">
                    <label for="jam">Jam Kejadian:</label>
                    <input type="time" name="jam" id="jam" value="<?= htmlspecialchars($jam) ?>" required>
                </div>

                <div class="form-group">
                    <label for="lokasi">Lokasi Kejadian:</label>
                    <input type="text" name="lokasi" id="lokasi" value="<?= htmlspecialchars($lokasi) ?>" required>
                </div>

                <div class="form-group">
                    <label for="kategori">Jenis Infrastruktur:</label>
                    <select name="kategori" id="kategori" required>
                        <option value="">-- Pilih Kategori --</option>
                        <option value="Jalan" <?= $kategori == 'Jalan' ? 'selected' : '' ?>>Jalan</option>
                        <option value="Jembatan" <?= $kategori == 'Jembatan' ? 'selected' : '' ?>>Jembatan</option>
                        <option value="Saluran Air" <?= $kategori == 'Saluran Air' ? 'selected' : '' ?>>Saluran Air
                        </option>
                        <option value="Lampu Jalan" <?= $kategori == 'Lampu Jalan' ? 'selected' : '' ?>>Lampu Jalan
                        </option>
                        <option value="Fasilitas Umum" <?= $kategori == 'Fasilitas Umum' ? 'selected' : '' ?>>Fasilitas
                            Umum
                        </option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="deskripsi" class="form-label">Deskripsi Pengaduan</label>
                    <textarea class="form-control" id="deskripsi" name="deskripsi"
                        rows="3"><?php echo htmlspecialchars($deskripsi ?? ''); ?></textarea>
                </div>

                <div class="form-group">
                    <button type="submit">Kirim Pengaduan</button>
                    <a href="DataAduan.php" class="button-link">Lihat Data Aduan</a>
                    <a href="Beranda.html" class="button-link" style="background-color:#ccc;">Kembali ke Beranda</a>

                </div>
            </form>

            <script>
                //Validasi Nama: hanya huruf dan spasi
                document.addEventListener("DOMContentLoaded", function () {
                    const namaInput = document.getElementById("nama");
                    const namaWarning = document.createElement("div");
                    namaWarning.classList.add("text-danger", "mt-1");
                    namaInput.parentNode.appendChild(namaWarning);

                    namaInput.addEventListener("input", function () {
                        const pattern = /^[a-zA-Z\s]*$/;
                        const input = this.value;

                        if (!pattern.test(input)) {
                            namaWarning.textContent = "Nama hanya boleh terdiri dari huruf dan spasi.";
                            this.setCustomValidity("Invalid");
                        } else {
                            namaWarning.textContent = "";
                            this.setCustomValidity("");
                        }
                    });
                });
            </script>

            <script>
                // Validasi nohp
                document.addEventListener("DOMContentLoaded", function () {
                    const nohpInput = document.getElementById("nohp");
                    const warningNohp = document.createElement("div");
                    warningNohp.style.color = "red";
                    nohpInput.parentNode.appendChild(warningNohp);

                    nohpInput.addEventListener("input", function () {
                        const pattern = /^[0-9]*$/;
                        const input = this.value;

                        if (!pattern.test(input)) {
                            warningNohp.textContent = "Nomor HP hanya boleh berisi angka.";
                            this.setCustomValidity("Invalid");
                        } else {
                            warningNohp.textContent = "";
                            this.setCustomValidity("");
                        }
                    });
                });
            </script>
</body>

</html>