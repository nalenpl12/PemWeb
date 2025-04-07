<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Desa Sukodono</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f2f2f2;
        }

        header {
            background-color: #007BFF;
            color: white;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        header h1 {
            font-size: 1.5rem;
        }

        .profile {
            font-size: 0.9rem;
        }

        .container {
            padding: 40px;
            max-width: 1000px;
            margin: auto;
        }

        .menu {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }

        .menu a {
            text-decoration: none;
            color: white;
            background-color: #007BFF;
            padding: 30px;
            text-align: center;
            border-radius: 10px;
            font-weight: bold;
            transition: background 0.3s ease;
        }

        .menu a:hover {
            background-color: #0056b3;
        }

        footer {
            text-align: center;
            padding: 15px;
            color: #666;
            font-size: 0.9rem;
            margin-top: 50px;
        }
    </style>
</head>

<body>
    <header>
        <h1>Dashboard Desa Sukodono</h1>
        <div class="profile">👤 Profil</div>
    </header>

    <div class="container">
        <p>Silakan pilih menu di bawah ini untuk melanjutkan:</p>
        <div class="menu">
            <a href="formusulanpembangunan.php">Usulan Pembangunan</a>
            <a href="formstatususulanpembangunan.php">Status Usulan</a>
            <a href="FormPengaduanUser.html">Pengaduan Infrastruktur</a>
            <a href="FormStatusPengaduan.html">Status Pengaduan</a>
        </div>
    </div>

    <footer>
        &copy; 2025 Desa Sukodono. Semua hak dilindungi.
    </footer>
</body>

</html>
