<?php
session_start();
?>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>NetflixReview+ – Beranda</title>
    <link rel="stylesheet" href="style.css">

    <style>
        /* MINI CSS UNTUK PROFIL DI HEADER */
        .profile-box {
            display: flex;
            align-items: center;
            gap: 10px;
            background: #222;
            padding: 6px 12px;
            border-radius: 20px;
        }
        .profile-box img {
            width: 32px;
            height: 32px;
            border-radius: 50%;
        }
        .profile-name {
            font-weight: bold;
            color: #fff;
        }
        nav a {
            margin-left: 15px;
        }

        .running-text-box {
    width: 100%;
    background: #b30000;
    color: white;
    overflow: hidden;
    padding: 10px 0;
    font-size: 18px;
    font-weight: bold;
}

.running-text {
    display: inline-block;
    white-space: nowrap;
    animation: running 12s linear infinite;
}

@keyframes running {
    from { transform: translateX(100%); }
    to { transform: translateX(-100%); }
}
    </style>
</head>

<body>

<!-- HEADER -->
<header class="header">
    <div class="logo">NetflixReview+</div>
    
    <nav>
        <a href="index.php">Beranda</a>

        <?php if (!isset($_SESSION['login'])): ?>
            <!-- JIKA BELUM LOGIN -->
            <a href="login.php" class="login-btn">Login</a>

        <?php else: ?>
            <!-- JIKA SUDAH LOGIN -->
            <div class="profile-box">
                <img src="img/default_profile.png">
                <span class="profile-name">
                    <?php echo htmlspecialchars($_SESSION['username']); ?>
                </span>
            </div>
            <a href="logout.php" style="color:#f33;">Logout</a>
        <?php endif; ?>
    </nav>
</header>

<!-- RUNNING TEXT -->
<?php if (isset($_SESSION['login'])): ?>
<marquee behavior="scroll" direction="left" scrollamount="6" 
style="background:#b30000;color:white;padding:10px 0;font-weight:bold;font-size:18px;">
    👋 Hai <?php echo htmlspecialchars($_SESSION['username']); ?>! 
    Selamat datang di NetflixReview+ — Nikmati rekomendasi film terbaik 🎬🔥
</marquee>
<?php endif; ?>

<!-- HERO SECTION -->
<div class="hero">
    <div class="hero-text">
        <h1>Selamat Datang di NetflixReview+</h1>
        <p>Tempat kamu mencari rekomendasi film terbaik sebelum menonton!</p>
        <a href="login.php" class="hero-btn">Gabung Member</a>
    </div>
</div>

<!-- REKOMENDASI FILM -->
<section class="container">
    <h2 class="section-title">Rekomendasi Film Populer</h2>

    <div class="film-list">

        <!-- Film 1 -->
        <a href="film_detail.php?id=agak_laen" class="film-card">
            <img src="agak laen.jpg" class="poster">
            <div class="film-info">
                <h3>Agak Laen (2024)</h3>
                <p>Horror Comedy</p>
                <span class="rating">⭐ 9.0</span>
            </div>
        </a>

        <!-- Film 2 -->
        <a href="film_detail.php?id=warkop" class="film-card">
            <img src="warkop dki.jpg" class="poster">
            <div class="film-info">
                <h3>Warkop DKI Reborn</h3>
                <p>Comedy</p>
                <span class="rating">⭐ 8.5</span>
            </div>
        </a>

        <!-- Film 3 -->
        <a href="film_detail.php?id=pengabdi_setan" class="film-card">
            <img src="pengabdi setan.jpg" class="poster">
            <div class="film-info">
                <h3>Pengabdi Setan</h3>
                <p>Horror</p>
                <span class="rating">⭐ 8.7</span>
            </div>
        </a>

        <!-- Film 4 -->
        <a href="film_detail.php?id=the_raid" class="film-card">
            <img src="The Raid.jpg" class="poster">
            <div class="film-info">
                <h3>The Raid</h3>
                <p>Action</p>
                <span class="rating">⭐ 9.2</span>
            </div>
        </a>

        <!-- Film 5 -->
        <a href="film_detail.php?id=abadi_nan_jaya" class="film-card">
            <img src="abadi nan jaya.jpg" class="poster">
            <div class="film-info">
                <h3>Abadi Nan Jaya</h3>
                <p>Thriller, Horor</p>
                <span class="rating">⭐ 7.0</span>
            </div>
        </a>

        <!-- Film 6 -->
        <a href="film_detail.php?id=Waktu_Maghrib" class="film-card">
            <img src="Waktu Maghrib.jpg" class="poster">
            <div class="film-info">
                <h3>Waktu Maghrib</h3>
                <p>Horor, Psikologis, Thriller</p>
                <span class="rating">⭐ 5.8</span>
            </div>
        </a>

        <!-- Film 7 -->
        <a href="film_detail.php?id=the_mist" class="film-card">
            <img src="the mist.jpg" class="poster">
            <div class="film-info">
                <h3>The Mist</h3>
                <p>Horror, Sci-Fi</p>
                <span class="rating">⭐ 7.1</span>
            </div>
        </a>

        <!-- Film 8 -->
        <a href="film_detail.php?id=pabrik_gula" class="film-card">
            <img src="Pabrik Gula.jpg" class="poster">
            <div class="film-info">
                <h3>Pabrik Gula</h3>
                <p>Industri Manufaktur, Agro</p>
                <span class="rating">⭐ 6.0</span>
            </div>
        </a>

    </div>
</section>

<!-- SUPPORT DEVELOPER -->
<section class="support-box">
    <h2>Dukung Developer</h2>
    <p>Bantu perkembangan NetflixReview+ agar semakin baik dengan memberikan support melalui donasi.</p>
    <a href="support.php" class="support-btn">Dukung Sekarang</a>
</section>

</body>
</html>