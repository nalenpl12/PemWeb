<?php
//Koneksi ke Database
include 'config/koneksi.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Aduan Infrastruktur</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            background: linear-gradient(to left, #FFECDB, #77CDFF);
        }
    </style>

</head>

<body class="font-sans min-h-screen">

    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-center text-gray-800 mb-8">Data Aduan Masyarakat</h1>

        <!-- Pesan Sukses -->
        <?php if (isset($_SESSION['sukses'])): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6 text-center">
                <?= $_SESSION['sukses']; ?>
                <?php unset($_SESSION['sukses']); ?>
            </div>
        <?php endif; ?>

        <div class="overflow-x-auto bg-white rounded-lg shadow-lg"">
            <table class=" min-w-full text-sm text-left text-gray-700">
            <thead class="bg-blue-500 text-white text-sm uppercase tracking-wider">
                <tr>
                    <th class="py-3 px-4 text-left">No</th>
                    <th class="py-3 px-4 text-left">Nama</th>
                    <th class="py-3 px-4 text-left">No HP</th>
                    <th class="py-3 px-4 text-left">Alamat</th>
                    <th class="py-3 px-4 text-left">Tanggal</th>
                    <th class="py-3 px-4 text-left">Jam</th>
                    <th class="py-3 px-4 text-left">Lokasi</th>
                    <th class="py-3 px-4 text-left">Kategori</th>
                    <th class="py-3 px-4 text-left">Deskripsi</th>
                    <th class="py-3 px-4 text-center">Aksi</th>
                </tr>
            </thead>

            <?php
            $no = 1;
            $q1 = mysqli_query($koneksi, "SELECT * FROM aduan ORDER BY tanggal DESC, jam DESC");
            while ($row = mysqli_fetch_assoc($q1)) {
                echo "<tr class='border-t'>";
                echo "<td class='py-2 px-4'>{$no}</td>";
                echo "<td class='py-2 px-4'>{$row['nama']}</td>";
                echo "<td class='py-2 px-4'>{$row['nohp']}</td>";
                echo "<td class='py-2 px-4'>{$row['alamat']}</td>";
                echo "<td class='py-2 px-4'>{$row['tanggal']}</td>";
                echo "<td class='py-2 px-4'>{$row['jam']}</td>";
                echo "<td class='py-2 px-4'>{$row['lokasi']}</td>";
                echo "<td class='py-2 px-4'>{$row['kategori']}</td>";
                echo "<td class='py-2 px-4'>{$row['deskripsi']}</td>";
                echo "<td class='py-2 px-4'>
                    <div class='flex flex-col md:flex-row items-center gap-2 justify-center'>
                        <a href=\"form_pengaduan.php?op=edit&id_aduan={$row['id_aduan']}\" 
                           class=\"bg-yellow-400 hover:bg-yellow-500 text-white font-semibold py-1 px-3 rounded transition duration-200\">
                            Edit
                        </a>
                        <a href=\"form_pengaduan.php?op=delete&id_aduan={$row['id_aduan']}\" 
                           onclick=\"return confirm('Yakin ingin menghapus data ini?')\"
                           class=\"bg-red-500 hover:bg-red-600 text-white font-semibold py-1 px-3 rounded transition duration-200\">
                            Delete
                         </a>
                    </div>
                          </td>";
                        echo "</tr>";
                        $no++;
                    }
                    ?>
                </tbody>
            </table>

            <div class="mb-4">
                <a href="form_pengaduan.php"
                    class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded shadow-lg transition duration-200">
                    + Tambah Pengaduan
                </a>
            </div>
        </div>
    </div>

</body>

</html>