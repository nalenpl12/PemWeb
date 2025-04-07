<?php
//Koneksi ke Database
$host       = "localhost";
$user       = "root";
$password   = "";
$database   = "pengaduan";

// Koneksi menggunakan MySQLi
$koneksi = mysqli_connect($host, $user, $password, $database);
if (!$koneksi) { // Cek Koneksi
    die("Koneksi gagal: " . mysqli_connect_error());
}

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

//Cek operasi yang dilakukan
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
    <title>Pengaduan Infrastruktur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        .mx-auto {
            width: 910px;
        }

        .card {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="mx-auto">
        <div class="card">
            <!--Memasukkan Data-->
            <div class="card-header">
                Create / Edit Data
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
                            value="<?php echo htmlspecialchars($nama ?? ''); ?>" placeholder="Masukkan Nama">
                    </div>

                    <div class="mb-3">
                        <label for="nohp" class="form-label">No Hp</label>
                        <input type="number" class="form-control" id="nohp" name="nohp"
                            value="<?php echo htmlspecialchars($nohp ?? ''); ?>" placeholder="Masukkan No Hp">
                    </div>

                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat Pelapor</label>
                        <input type="text" class="form-control" id="alamat" name="alamat"
                            value="<?php echo htmlspecialchars($alamat ?? ''); ?>" placeholder="Masukkan Alamat">
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
                        <select class="form-control" id="kategori" name="kategori">
                            <option value="">- Pilih Kategori -</option>
                            <option value="Jalan" <?php if ($kategori == "jalan")
                                echo "selected"; ?>>Jalan</option>
                            <option value="Jembatan" <?php if ($kategori == "jembatan")
                                echo "selected"; ?>>Jembatan
                            </option>
                            <option value="Saluran" <?php if ($kategori == "saluran")
                                echo "selected"; ?>>Saluran Air
                            </option>
                            <option value="Lampu" <?php if ($kategori == "lampu")
                                echo "selected"; ?>>Lampu Jalan</option>
                            <option value="Fasilitas" <?php if ($kategori == "fasilitas")
                                echo "selected"; ?>>Fasilitas
                                Umum</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi Pengaduan</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi"
                            rows="3"><?php echo htmlspecialchars($deskripsi ?? ''); ?></textarea>
                    </div>

                    <div class="col-12">
                        <input type="submit" name="submit" value="Kirim Aduan" class="btn btn-primary">
                    </div>
                </form>
        </di>

    <!--Mengeluarkan Data-->
    <div class="card">
        <div class="card-header text-white bg-secondary">
            Data Pengaduan
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nama</th>
                        <th scope="col">No HP</th>
                        <th scope="col">Alamat</th>
                        <th scope="col">Tanggal</th>
                        <th scope="col">Jam</th>
                        <th scope="col">Lokasi</th>
                        <th scope="col">Kategori</th>
                        <th scope="col">Deskripsi</th>
                        <th scope="col">Aksi</th>
                    </tr>
                    </thead>
                <tbody>
                    <?php
                    $sql2 = "SELECT * FROM aduan ORDER by id_aduan DESC";
                    $q2 = mysqli_query($koneksi, $sql2);
                    $urut = 1;
                    while ($row2 = mysqli_fetch_array($q2)) {
                        $id_aduan = $row2['id_aduan'];
                        $nama = $row2['nama'];
                        $nohp = $row2['nohp'];
                        $alamat = $row2['alamat'];
                        $tanggal = $row2['tanggal'];
                        $jam = $row2['jam'];
                        $lokasi = $row2['lokasi'];
                        $kategori = $row2['kategori'];
                        $deskripsi = $row2['deskripsi'];
                        ?>
                        <tr>
                            <th scope="row"><?php echo $urut++ ?></th>
                            <td scope="row"><?php echo $nama ?></td>
                            <td scope="row"><?php echo $nohp ?></td>
                            <td scope="row"><?php echo $alamat ?></td>
                            <td scope="row"><?php echo $tanggal ?></td>
                            <td scope="row"><?php echo $jam ?></td>
                            <td scope="row"><?php echo $lokasi ?></td>
                            <td scope="row"><?php echo $kategori ?></td>
                            <td scope="row"><?php echo $deskripsi ?></td>
                            <td scope="row">
                                <a href="form_pengaduan.php?op=edit&id_aduan=<?php echo $id_aduan ?>"><button type="button"class="btn btn-warning custom-btn">Edit</button></a>
                                <a href="form_pengaduan.php?op=delete&id_aduan=<?php echo $id_aduan ?>"onclick="return confirm('Yakin ingin menghapus data ini?')"><button type="button"class="btn btn-danger custom-btn">Delete</button></a>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    </div>
</body>

</html>