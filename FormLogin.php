<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Login & Register</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #ffefe2;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            display: flex;
            width: 900px;
            height: 540px;
            background-color: #fff;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            border-radius: 16px;
            overflow: hidden;
        }

        .left-panel {
            flex: 1;
            background-color: #0d66b3;
            color: white;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .left-panel h2 {
            font-size: 24px;
            line-height: 1.8;
        }

        .left-panel img {
            max-width: 100%;
            margin-top: 20px;
        }

        .right-panel {
            flex: 1;
            background-color: #fff7dd;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .right-panel h2 {
            color: #0d66b3;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            border: none;
            background-color: #eaeaea;
            border-bottom: 2px solid black;
        }

        button {
            background-color: #0d66b3;
            color: white;
            padding: 10px;
            border: none;
            width: 100%;
            cursor: pointer;
            border-radius: 5px;
            font-weight: bold;
        }

        button:hover {
            background-color: #084b8a;
        }

        p {
            font-size: 14px;
            margin-top: 15px;
            text-align: center;
        }

        a {
            color: #0d66b3;
            text-decoration: none;
        }

        .error-message {
            color: red;
            margin-bottom: 15px;
            font-weight: bold;
        }

        #registerForm {
            display: none;
        }

        .success-message {
            color: green;
            margin-bottom: 15px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- LEFT -->
        <div class="left-panel">
            <h2>Selamat Datang di<br>sistem Pengaduan Infrastruktur<br>Desa Pekarungan</h2>
            <img src="img/Architect.png" alt="Ilustrasi"> <!-- Ganti src sesuai nama file kamu -->
        </div>

        <!-- RIGHT -->
        <div class="right-panel">
            <?php
            if (isset($_GET['success']) && $_GET['success'] == 'registered') {
                echo "<div class='success-message'>Registrasi berhasil! Silakan Masuk.</div>";
            }
            ?>
            <!-- LOGIN FORM -->
            <div id="loginForm">
                <h2>MASUK</h2>

                <?php
                if (isset($_GET['error'])) {
                    $message = '';
                    if ($_GET['error'] == 'usernotfound') {
                        $message = 'User tidak ditemukan.';
                    } elseif ($_GET['error'] == 'wrongpassword') {
                        $message = 'Password salah.';
                    }
                    if ($message != '') {
                        echo "<div class='error-message'>$message</div>";
                    }
                }
                ?>

                <form action="login_process.php" method="POST">
                    <div class="form-group">
                        <input type="text" name="identifier" placeholder="Nama Pengguna atau Email" required>
                    </div>

                    <div class="form-group">
                        <input type="password" name="password" placeholder="Kata Sandi" required>
                    </div>

                    <button type="submit">Masuk</button>
                </form>
                <p>Belum punya akun? <a href="#" onclick="showRegister()">Buat Akun</a></p>
            </div>

            <!-- REGISTER FORM -->
            <div id="registerForm">
                <h2>Buat Akun</h2>
                <form action="register_process.php" method="POST">
                    <div class="form-group">
                        <input type="text" name="nama" placeholder="Nama Lengkap" required>
                    </div>

                    <div class="form-group">
                        <input type="email" name="email" placeholder="Email" required>
                    </div>

                    <div class="form-group">
                        <input type="password" name="password" placeholder="Password" required>
                    </div>

                    <div class="form-group">
                        <input type="password" name="confirm_password" placeholder="Konfirmasi Password" required>
                    </div>

                    <button type="submit">Daftar</button>
                </form>
                <p>Sudah punya akun? <a href="#" onclick="showLogin()">Login</a></p>
            </div>
        </div>
    </div>

    <script>
        function showRegister() {
            document.getElementById("loginForm").style.display = "none";
            document.getElementById("registerForm").style.display = "block";
        }

        function showLogin() {
            document.getElementById("registerForm").style.display = "none";
            document.getElementById("loginForm").style.display = "block";
        }
    </script>
</body>

</html>