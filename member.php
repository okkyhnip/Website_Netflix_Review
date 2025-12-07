<?php 
session_start();

// Cek apakah user sudah login
if(!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Beranda Member - NetflixReview+</title>

    <style>
        body {
            margin: 0;
            padding: 0;
            background: #141414;
            color: white;
            font-family: Arial, sans-serif;
        }

        /* Header */
        .header {
            width: 100%;
            padding: 15px 40px;
            background: #000;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .logo {
            font-size: 28px;
            font-weight: bold;
            color: #e50914;
        }

        /* Profile Box */
        .profile-box {
            position: relative;
            display: inline-block;
            cursor: pointer;
        }

        .profile-box img {
            width: 42px;
            height: 42px;
            border-radius: 5px;
        }

        .profile-name {
            margin-left: 10px;
            font-size: 16px;
            display: inline-block;
            vertical-align: middle;
        }

        /* Dropdown */
        .dropdown-menu {
            display: none;
            position: absolute;
            right: 0;
            background: #222;
            width: 180px;
            margin-top: 10px;
            border-radius: 6px;
            overflow: hidden;
        }

        .dropdown-menu a {
            display: block;
            padding: 12px;
            color: white;
            text-decoration: none;
            transition: 0.2s;
        }

        .dropdown-menu a:hover {
            background: #333;
        }

        /* Film Section */
        .container {
            padding: 30px;
        }

        .section-title {
            font-size: 26px;
            margin-bottom: 15px;
        }

    </style>

    <script>
        function toggleMenu() {
            const menu = document.getElementById("menuDropdown");
            menu.style.display = menu.style.display === "block" ? "none" : "block";
        }

        window.onclick = function(e) {
            if (!e.target.closest(".profile-box")) {
                document.getElementById("menuDropdown").style.display = "none";
            }
        }
    </script>

</head>

<body>

<!-- HEADER -->
<div class="header">
    <div class="logo">NetflixReview+</div>

    <div class="profile-box" onclick="toggleMenu()">
        <img src="profil-default.png" alt="Foto Profil">

        <span class="profile-name">
            <?php echo $_SESSION["user"]; ?>
        </span>

        <!-- Dropdown menu -->
        <div class="dropdown-menu" id="menuDropdown">
            <a href="profile.php">Lihat Profil</a>
            <a href="logout.php">Logout</a>
        </div>
    </div>
</div>

<!-- CONTENT -->
<div class="container">
    <h2 class="section-title">Selamat datang, <?php echo $_SESSION["user"]; ?>!</h2>
    <p>Nikmati rekomendasi film terbaik khusus untuk member.</p>

    <!-- Kamu bisa taruh bagian rekomendasi film di sini -->
</div>

</body>
</html>
