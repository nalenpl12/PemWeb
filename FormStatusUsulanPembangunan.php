<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Usulan Pembangunan</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }

        .container {
            width: 80%;
            max-width: 800px;
            padding: 30px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.15);
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #3b82f6;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        a, .delete-btn {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 15px;
            background-color: #3b82f6;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
        }

        .delete-btn {
            background-color: #ef4444;
            margin: 0;
            padding: 5px 10px;
            font-size: 12px;
        }

        .delete-btn:hover {
            background-color: #dc2626;
        }

        a:hover {
            background-color: #2563eb;
        }zend_logo_guid
    </style>
</head>
<body>
    <div class="container">
        <h2>Status Pengaduan Infrastruktur</h2>

        <?php
        $host = "localhost";
        $user = "root";
        $pass = ""; 
        $db   = "UsulanPembangunan_Data";

        $koneksi = mysqli_connect($host, $user, $pass, $db);
        if (!$koneksi) {
            die("Koneksi gagal: " . mysqli_connect_error());
        }
        if (isset($_GET['hapus'])) {
            $idHapus = $_GET['hapus'];
            $deleteQuery = "DELETE FROM usulan WHERE id = $idHapus";

            if (mysqli_query($koneksi, $deleteQuery)) {
                echo "<script>alert('Data berhasil dihapus!'); window.location.href='FormStatusPengaduan.php';</script>";
            } else {
                echo "<script>alert('Gagal menghapus data: " . mysqli_error($koneksi) . "');</script>";
            }
        }
        ?>
        <table>
            <thead>
                <tr>
                    <th>ID Pengaduan</th>
                    <th>Nama Pelapor</th>
                    <th>Lokasi Kejadian</th>
                    <th>Kategori</th>
                    <th>Deskripsi</th>
                    <th>Estimasi Waktu</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT * FROM usulan";
                $result = mysqli_query($koneksi, $query);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['namaPelapor'] . "</td>";
                        echo "<td>" . $row['lokasi'] . "</td>";
                        echo "<td>" . $row['jenis'] . "</td>";
                        echo "<td>" . $row['deskripsi'] . "</td>";
                        echo "<td>" . $row['estimasi'] . "</td>";
                        echo "<td><a class='delete-btn' href='FormStatusPengaduan.php?hapus=" . $row['id'] . "' onclick='return confirm(\"Apakah Anda yakin ingin menghapus data ini?\");'>Hapus</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>Belum ada pengaduan.</td></tr>";
                }

                mysqli_close($koneksi); 
                ?>
            </tbody>
        </table>

        <a href="formusulanpembangunan.php">Buat Usulan Baru</a>
    </div>
</body>
</html>
