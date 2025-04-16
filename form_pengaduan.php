<?php
//Koneksi ke Database
include 'config/koneksi.php';

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
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            display: grid;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            padding: 20px;

        }

        .container {
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            width: 90%;
            max-width: 700px;
        }

        h2 {
            text-align: center;
            color: #333;
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
            background-color: #888;
            /* abu-abu */
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
            background-color: #666;
        }

        button:hover {
            background-color: dodgerblue;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Form Pengaduan Infrastruktur</h2>

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
                    <option value="Saluran Air" <?= $kategori == 'Saluran Air' ? 'selected' : '' ?>>Saluran Air</option>
                    <option value="Lampu Jalan" <?= $kategori == 'Lampu Jalan' ? 'selected' : '' ?>>Lampu Jalan</option>
                    <option value="Fasilitas Umum" <?= $kategori == 'Fasilitas Umum' ? 'selected' : '' ?>>Fasilitas Umum
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