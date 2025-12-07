<?php session_start(); ?>
<html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Member - NetflixReview+</title>

    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

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
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), 
            url('https://placehold.co/1920x1080/000000/ff0000?text=Netflix_Review+') no-repeat center/cover;
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
        }

        h2 { text-align: center; margin-bottom: 20px; font-size: 28px; }

        .input-box {
            width: 100%;
            padding: 12px;
            margin-top: 10px;
            background: #222;
            border: none;
            border-radius: 5px;
            color: white;
        }

        .button {
            width: 100%;
            padding: 12px;
            margin-top: 20px;
            background: #e50914;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .login-text { text-align: center; margin-top: 18px; }
        .login-text a { color: #e50914; text-decoration: none; }
        .login-text a:hover { text-decoration: underline; }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 15px;
            color: #bbb;
        }
    </style>
</head>

<body>

<div class="register-container">
    <div class="register-box">

        <h2>Buat Akun Member</h2>

        <!-- FORM -> simpan_register.php -->
        <form action="simpan_register.php" method="POST">
            <input class="input-box" type="text" name="username" placeholder="Masukkan Username" required>
            <input class="input-box" type="password" name="password" placeholder="Masukkan Password" required>
            <button class="button" type="submit">Daftar</button>
        </form>

        <p class="login-text">
            Sudah punya akun?  
            <a href="login.php">Login</a>
        </p>

        <a href="login.php" class="back-link">&#8592; Kembali ke Halaman Login</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php 
if(isset($_SESSION['status'])) {
    echo "
    <script>
    Swal.fire({
        icon: '{$_SESSION['status']}',
        title: '{$_SESSION['status_title']}',
        text: '{$_SESSION['status_text']}',
        confirmButtonColor: '#e50914'
    });
    </script>
    ";
    unset($_SESSION['status'], $_SESSION['status_text'], $_SESSION['status_title']);
}
?>
</body>
</html>