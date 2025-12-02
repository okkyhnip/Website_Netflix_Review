<?php session_start(); ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Member - NetflixReview+</title>

    <style>
        body {
            margin: 0;
            padding: 0;
            background: #000;
            font-family: Arial, sans-serif;
            color: white;
        }

        .register-container {
            width: 100%;
            height: 100vh;
            background: url('netflix-bg.jpg') no-repeat center/cover;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .register-box {
            width: 400px;
            background: rgba(0,0,0,0.8);
            padding: 35px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(255,255,255,0.1);
            backdrop-filter: blur(5px);
            animation: fadeIn 0.8s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 28px;
            font-weight: bold;
        }

        .input-box {
            width: 100%;
            padding: 12px;
            margin-top: 10px;
            background: #222;
            border: none;
            outline: none;
            border-radius: 5px;
            color: white;
            font-size: 15px;
        }

        .input-box:focus {
            border: 1px solid #e50914;
        }

        .button {
            width: 100%;
            padding: 12px;
            margin-top: 20px;
            background: #e50914;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: 0.2s;
        }

        .button:hover {
            background: #b00610;
        }

        .login-text {
            text-align: center;
            margin-top: 18px;
            color: #bbb;
        }

        .login-text a {
            color: #e50914;
            text-decoration: none;
        }

        .login-text a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

<div class="register-container">
    <div class="register-box">

        <h2>Buat Akun Member</h2>

        <form action="simpan_register.php" method="POST">
            <input class="input-box" type="text" name="username" placeholder="Masukkan Username" required>

            <input class="input-box" type="password" name="password" placeholder="Masukkan Password" required>

            <button class="button" type="submit">Daftar</button>
        </form>

        <p class="login-text">
            Sudah punya akun?  
            <a href="login.php">Login</a>
        </p>

        <!-- TOMBOL KEMBALI KE BERANDA -->
        <a href="beranda.php" class="button" style="background:#555; margin-top:10px; text-align:center; display:block; text-decoration:none;">
            Kembali ke Beranda
        </a>

    </div>
</div>

</body>
</html>

