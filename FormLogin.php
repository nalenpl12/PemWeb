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
            background: linear-gradient(to bottom, #FFECDB, #77CDFF);
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
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.9);
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
            background-color: #00295f;
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

        #registerForm {
            display: none;
        }

        .success-message,
        .error-message {
            font-weight: bold;
            margin-bottom: 15px;
            text-align: center;
            padding: 10px;
            border-radius: 6px;
            opacity: 1;
            transition: opacity 1s ease-out;
        }

        .success-message {
            color: green;
            background-color: #e6f5e6;
        }

        .error-message {
            color: red;
            background-color: #fce4e4;
        }

        .fade-out {
            opacity: 0;
            transition: opacity 1s ease-out;
        }

        .alert {
            background-color: #ffe0e0;
            color: #b30000;
            padding: 10px 15px;
            border: 1px solid #ffcccc;
            border-radius: 5px;
            margin-bottom: 15px;
            animation: fadeOut 3s forwards;
            font-size: 14px;
            font-weight: bold;
        }

        @keyframes fadeOut {
            0% {
                opacity: 1;
            }

            70% {
                opacity: 1;
            }

            100% {
                opacity: 0;
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- LEFT -->
        <div class="left-panel">
            <h2>Selamat Datang di<br>Sistem Pengaduan Infrastruktur<br>Desa Pekarungan</h2>
            <img src="img/Architect.png" alt="Ilustrasi">
        </div>

        <!-- RIGHT -->
        <div class="right-panel">
            <!-- LOGIN FORM -->
            <div id="loginForm">
                <h2>MASUK</h2>
                <?php
                if (isset($_GET['error'])) {
                    $message = '';
                    if ($_GET['error'] == 'usernotfound') {
                        $message = 'Pengguna tidak ditemukan.';
                    } elseif ($_GET['error'] == 'wrongpassword') {
                        $message = 'Password atau Nama Pengguna salah.';
                    }

                    if ($message != '') {
                        echo "<div class='error-message'>$message</div>";
                    }
                }
                ?>
                <?php
                if (isset($_GET['success']) && $_GET['success'] == 'registered') {
                    echo "<div class='success-message'>Registrasi berhasil! Silakan Masuk.</div>";
                }
                ?>
                <?php
                if (isset($_GET['registerError'])) {
                    $message = '';
                    if ($_GET['registerError'] == 'userexists') {
                        $message = 'Pengguna atau email sudah tersedia.';
                    } elseif ($_GET['registerError'] == 'passwordmismatch') {
                        $message = 'Password tidak sesuai.';
                    }

                    if ($message !== '') {
                        echo "<div class='alert fade-out'>$message</div>";
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
                <h2>BUAT AKUN</h2>
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
        setTimeout(() => {
            const success = document.querySelector('.success-message');
            const error = document.querySelector('.error-message');

            if (success) {
                success.classList.add('fade-out');
                setTimeout(() => success.remove(), 1000); // Hapus setelah transisi selesai
            }

            if (error) {
                error.classList.add('fade-out');
                setTimeout(() => error.remove(), 1000);
            }
        }, 2000);
        setTimeout(() => {
            const alert = document.querySelector('.alert');
            if (alert) {
                alert.style.transition = 'opacity 0.5s ease-out';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            }
        }, 2000);
    </script>
</body>

</html>