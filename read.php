<?php
include 'koneksi.php';
$query = "SELECT * FROM editprofile";
$result = mysqli_query($koneksi, $query);
echo "<table border='1'>
<tr>
<th>nama</th>
<th>email</th>
<th>nomor</th>
<th>tempat</th>
</tr>";

while($data = mysqli_fetch_assoc($result)){
echo "<tr>
<td>".$data['nama']."</td>
<td>".$data['email']."</td>
<td>".$data['nomor']."</td>
<td>".$data['tempat']."</td>
<td><a href='update.php?id=".$data['id']."'>Edit</a> | <a
href='delete.php?id=".$data['id']."'>Hapus</a></td>
</tr>";
}
echo "</table>";
?>
