<form action="create.php" method="POST">
Nama: <input type="text" name="nama"><br>
Alamat Email: <input type="email" name="email"><br>
Nomor Telepon: <input type="number" name="nomor"><br>
Tempat Tinggal: <input type="text" name="tempat"><br>
<input type="submit" name="submit" value="Tambah Data">
</form>
<?php
include 'koneksi.php';
if(isset($_POST['submit'])){
$nama = $_POST['nama'];
$mail = $_POST['email'];
$nomor = $_POST['nomor'];
$tempat = $_POST['tempat'];
$query = "INSERT INTO editprofile (nama, email, nomor, tempat)
VALUES ('$nama', '$mail', '$nomor', '$tempat')";
mysqli_query($koneksi, $query);
echo "Data berhasil ditambahkan.";
}
?>