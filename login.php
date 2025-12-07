<?php session_start(); ?>
<html>
<head>
    <title>Login Member - Netflix Review</title>
    <link rel="stylesheet" href="style.css">

    <style>
        body {
            background: #000;
            font-family: Arial, sans-serif;
            color: white;
            margin: 0;
            padding: 0;
        }

        .login-container {
            width: 100%;
            height: 100vh;
            background: url('netflix-bg.jpg') no-repeat center center/cover;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-box {
            width: 380px;
            background: rgba(0,0,0,0.75);
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(255,255,255,0.1);
            backdrop-filter: blur(3px);
            animation: fadeIn .8s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .login-box h2 {
            text-align: center;
            margin-bottom: 25px;
            font-size: 28px;
            letter-spacing: 1px;
        }

        .input-box {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: none;
            outline: none;
            border-radius: 5px;
            background: #333;
            color: white;
            font-size: 15px;
        }

        .button {
            width: 100%;
            padding: 12px;
            background: #e50914;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 10px;
            transition: 0.2s;
        }

        .button:hover {
            background: #b00610;
        }

        .error {
            color: #ff3b3b;
            text-align: center;
            margin-bottom: 15px;
        }

        .register-text {
            text-align: center;
            margin-top: 15px;
            color: #bbb;
        }

        .register-text a {
            color: #e50914;
        }
    </style>
</head>

<body>

<div class="login-container">
    <div class="login-box">

        <h2>Login Member</h2>

        <?php if(isset($_GET["error"])): ?>
            <p class="error">Username atau password salah!</p>
        <?php endif; ?>

        <form action="cek_login.php" method="POST">
            <input class="input-box" type="text" name="username" placeholder="Username" required>
            <input class="input-box" type="password" name="password" placeholder="Password" required>

            <!-- TOMBOL LOGIN YANG BENAR -->
            <button class="button" type="submit">Login</button>
        </form>

        <p class="register-text">
            Belum punya akun?  
            <a href="register.php">Daftar di sini</a>
        </p>
        
        <!-- TOMBOL KEMBALI KE BERANDA -->
        <a href="beranda.php" class="button" style="background:#555; margin-top:10px; text-align:center; display:block; text-decoration:none;">
            Kembali ke Beranda
        </a>

    </div>
</div>
<!-- Masukkan SweetAlert2 CDN di head atau sebelum script ini -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php
// Pastikan session sudah di-start di bagian atas login.php
if (session_status() === PHP_SESSION_NONE) session_start();

if (!empty($_SESSION['status'])) {
    // Ambil & escape text
    $status = $_SESSION['status']; // 'success' atau 'error'
    $text = isset($_SESSION['status_text']) ? htmlspecialchars($_SESSION['status_text'], ENT_QUOTES) : '';

    // Hapus session agar alert tidak selalu muncul setelah refresh
    unset($_SESSION['status'], $_SESSION['status_text']);

    // Cetak JS untuk SweetAlert
    if ($status === 'success') {
        echo "
        <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: '{$text}',
            confirmButtonText: 'OK',
            allowOutsideClick: false
        }).then(function() {
            // arahkan ke login.php (replace agar tidak bisa back ke register)
            window.location.replace('login.php');
        });
        </script>
        ";
    } else {
        // status error
        echo "
        <script>
        Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: '{$text}',
            confirmButtonText: 'OK'
        }).then(function() {
            // kembali ke halaman sebelumnya (biasanya form register)
            window.history.back();
        });
        </script>
        ";
    }
}
?>

</body>
</html>
