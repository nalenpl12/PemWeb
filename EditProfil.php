<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "pemweb";

$koneksi = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST["nama"];
    $email = $_POST["email"];
    $nomor = $_POST["nomor"];
    $alamat = $_POST["alamat"];

    $sql = "UPDATE profile SET nama='$nama', email='$email', nomor='$nomor', alamat='$alamat' WHERE id='$id'";
    $query = mysqli_query($koneksi, $sql);

    if ($query) {
        echo "<script>
            alert('Perubahan berhasil disimpan!');
            window.location.href = 'profile.php';
        </script>";
    } else {
        echo "Gagal menyimpan data: " . mysqli_error($koneksi);
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil</title>
    
</head>

<body>
    <div class="container">
        <h2>Edit Profil</h2>
        <form action="EditProfil.php" method="POST">
            <div class="form-group">
                <label for="name">Nama:</label>
                <input type="text" id="nama" name="nama" required>
            </div>
            <div class="form-group">
                <label for="email">Alamat Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="phone">Nomor Telepon:</label>
                <input type="number" id="nomor" name="nomor" required>
            </div>
            <div class="form-group">
                <label for="alamat">Alamat Rumah:</label>
                <input type="text" id="alamat" name="alamat" required>
            </div>
            <div class="form-group">
                <button type="submit">Simpan Perubahan</button>
            </div>
        </form>
        <a href="profile.php">Batal</a>
    </div>
</body>

<style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }

        .container {
            max-width: 800px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 10px;
        }

        .form-group label {
            display: block;
            font-weight: bold;
        }

        .form-group input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .form-group button {
            background-color: blue;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .form-group button:hover {
            background-color: darkblue;
        }
    </style>
</html>