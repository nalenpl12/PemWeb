<?php
include 'koneksi.php';
$query = "SELECT * FROM aduan";
$result = mysqli_query($koneksi, $query);

echo "<table border='1'>
<tr>
<th>ID</th>
<th>Nama</th>
<th>No HP</th>
<th>Alamat</th>
<th>Tanggal</th>
<th>Jam</th>
<th>Lokasi</th>
<th>Kategori</th>
while($data = mysqli_fetch_assoc($result)){
echo "<tr>
<td>".$data['id']."</td>
<td>".$data['nama']."</td>
<td>".$data['nohp']."</td>
<td>".$data['alamat']."</td>
<td>".$data['tanggal']."</td>
<td>".$data['jam']."</td>
<td>".$data['lokasi']."</td>
<td>".$data['kategori']."</td>

<td><a href='update.php?id=".$data['id']."'>Edit</a> | <a
href='delete.php?id=".$data['id']."'>Hapus</a></td>
</tr>";
}
echo "</table>";
?>

