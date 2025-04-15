<?php
//Koneksi ke Database
include 'config/koneksi.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Pengaduan Infrastruktur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    <div class="card-header">
        <div class="card-header text-white bg-secondary">
            Data Pengaduan
        </div>

        <div class="card-body">
            <table class="table">
                <thead class="table-dark">
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
                                <a href="form_pengaduan.php?op=edit&id_aduan=<?php echo $id_aduan ?>"> <button type="button" class="btn btn-warning custom-btn">Edit</button></a>
                                <a href="form_pengaduan.php?op=delete&id_aduan=<?php echo $id_aduan ?>" onclick="return confirm('Yakin ingin menghapus data ini?')"> <button type="button" class="btn btn-danger custom-btn">Delete</button></a>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
            <div class="mb-3">
                <a href="form_pengaduan.php" class="btn btn-primary">+ Tambah Pengaduan Baru</a>
            </div>
        </div>
    </div>
</body>

</html>