<?php
include 'koneksi.php';

// Ambil semua data aduan
$sql = "SELECT * FROM aduan ORDER BY tanggal DESC, jam DESC";
$result = mysqli_query($koneksi, $sql);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Status Aduan Infrastruktur</title>
    <style>
        body {
            background: linear-gradient(to right, #FFECDB, #77CDFF);
            font-family: Arial, sans-serif;
            padding: 20px;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .badge {
            border-radius: 5px;
            font-size: 0.85em;
            padding: 5px 10px;
            background-color: darkgrey;
        }

        .status-belum {
            background-color: #6c757d;
            /* abu */
        }

        .btn-kembali {
            display: inline-block;
            background-color: #e2e2e2;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 6px;
            font-size: 14px;
            text-align: center;
            margin-top: 10px;
        }

        th,td {
            padding: 12px 15px;
            border: 1px solid #ccc;
            text-align: center;
        }

        th {
            background-color: #2563EB;
        }

        tr:nth-child(even) {
            background-color: #f0f7ff;
        }

        .btn-kembali:hover {
            background-color: #5a6268;
        }

        thead th {
            background-color: #2563EB;
            color: white;
            padding: 12px;
            border: 1px solid #ccc;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2 class="mb-4 text-center">Status Pengaduan Infrastruktur</h2>

        <?php if (mysqli_num_rows($result) > 0): ?>
            <table>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Lokasi</th>
                    <th>Kategori</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                </tr>
                </thead>

                <tbody>
                    <?php
                    $no = 1;
                    while ($row = mysqli_fetch_assoc($result)):
                        $status = $row['status'] ?? 'Diajukan'; // default status
                        ?>

                        <tr>
                            <td class="text-center"><?= $no++; ?></td>
                            <td><?= htmlspecialchars($row['nama']); ?></td>
                            <td><?= htmlspecialchars($row['lokasi']); ?></td>
                            <td><?= htmlspecialchars($row['kategori']); ?></td>
                            <td><?= htmlspecialchars($row['tanggal']) . ' ' . htmlspecialchars($row['jam']); ?></td>
                            <td class="text-center">
                                <span class="badge <?= $badgeClass ?>">
                                    <?= $status ?>
                                </span>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>

            </table>

            <a href="form_pengaduan.php"
                style="display: inline-block; padding: 10px 20px; background-color: #e2e2e2; color: #333; border-radius: 5px; text-decoration: none; font-weight: bold;">
                Kembali
            </a>

        </div>

    <?php else: ?>
        <div class="alert alert-info text-center">
            Belum ada data pengaduan yang masuk.
        </div>
    <?php endif; ?>
    </div>
</body>

</html>