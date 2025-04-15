<?php
//Koneksi ke Database
include 'config/koneksi.php';

//Inisialisasi Variabel
$nama       = "";
$nohp       = "";
$alamat     = "";
$tanggal    = "";
$jam        = "";
$lokasi     = "";
$kategori   = "";
$deskripsi  = "";
$error      = "";
$sukses     = "";

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
        $nama       = $row1['nama'];
        $nohp       = $row1['nohp'];
        $alamat     = $row1['alamat'];
        $tanggal    = $row1['tanggal'];
        $jam        = $row1['jam'];
        $lokasi     = $row1['lokasi'];
        $kategori   = $row1['kategori'];
        $deskripsi  = $row1['deskripsi'];
    } else {
        $error = "Data tidak ditemukan";
    }
}

//Tambah atau Edit Data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama       = $_POST['nama'];
    $nohp       = $_POST['nohp'];
    $alamat     = $_POST['alamat'];
    $tanggal    = $_POST['tanggal'];
    $jam        = $_POST['jam'];
    $lokasi     = $_POST['lokasi'];
    $kategori   = $_POST['kategori'];
    $deskripsi  = $_POST['deskripsi'];

    if ($q1) {
        header("Location: StatusAduan.php");
        exit;
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
                    $sukses = "Data berhasil diupdate!";
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
                $sukses = "Pengaduan berhasil dikirim!";
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
    <title>Form Pengaduan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        .mx-auto {
            width: 600px;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background: white;
        }

        .btn-container {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            margin-top: 15px;
        }

        .btn-container .btn {
            width: 50%;
        }

        .card-header {
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="mx-auto">
        <h2>Form Pengaduan Infrastruktur</h2>
        <div class="card">
            <!--Memasukkan Data-->
            <div class="card-header">
                Buat Aduan Baru
            </div>
            <div class="card-body">
                <?php if ($error) {
                    ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error ?>
                    </div>
                    <?php
                }
                ?>

                <?php if ($sukses) {
                    ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $sukses ?>
                    </div>
                    <?php
                }
                ?>

                <form action="" method="POST">

                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama"
                            value="<?php echo htmlspecialchars($nama ?? ''); ?>" placeholder="Masukkan Nama" required>
                    </div>

                    <div class="mb-3">
                        <label for="nohp" class="form-label">No Hp</label>
                        <input type="number" class="form-control" id="nohp" name="nohp"
                            value="<?php echo htmlspecialchars($nohp ?? ''); ?>" placeholder="Masukkan No Hp" required>
                    </div>

                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat Pelapor</label>
                        <input type="text" class="form-control" id="alamat" name="alamat"
                            value="<?php echo htmlspecialchars($alamat ?? ''); ?>" placeholder="Masukkan Alamat"
                            required>
                    </div>

                    <div class="mb-3">
                        <label for="tanggal" class="form-label">Tanggal Kejadian</label>
                        <input type="date" class="form-control" id="tanggal" name="tanggal"
                            value="<?php echo htmlspecialchars($tanggal ?? ''); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="jam" class="form-label">Jam Kejadian</label>
                        <input type="time" class="form-control" id="jam" name="jam"
                            value="<?php echo htmlspecialchars($jam ?? ''); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="lokasi" class="form-label">Lokasi Kejadian</label>
                        <input type="text" class="form-control" id="lokasi" name="lokasi"
                            value="<?php echo htmlspecialchars($lokasi ?? ''); ?>"
                            placeholder="Masukkan Lokasi Kejadian">
                    </div>

                    <div class="mb-3">
                        <label for="kategori" class="form-label">Kategori Pengaduan</label>
                        <select class="form-select" id="kategori" name="kategori">
                            <option value="">- Pilih Kategori -</option>
                            <option value="Jalan" <?php if ($kategori == "Jalan")
                                echo "selected"; ?>>Jalan</option>
                            <option value="Jembatan" <?php if ($kategori == "Jembatan")
                                echo "selected"; ?>>Jembatan</option>
                            <option value="Saluran" <?php if ($kategori == "Saluran")
                                echo "selected"; ?>>Saluran Air</option>
                            <option value="Lampu" <?php if ($kategori == "Lampu")
                                echo "selected"; ?>>Lampu Jalan</option>
                            <option value="Fasilitas" <?php if ($kategori == "Fasilitas")
                                echo "selected"; ?>>Fasilitas Umum</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi Pengaduan</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi"
                            rows="3"><?php echo htmlspecialchars($deskripsi ?? ''); ?></textarea>
                    </div>

                    <div class="btn-container">
                        <button type="submit" name="submit" class="btn btn-primary">Kirim Aduan</button>
                        <a href="DataAduan.php" class="btn btn-secondary">Lihat Status Aduan</a>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>

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

</body>

</html>