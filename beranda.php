<?php
session_start();


// ===============================
// DATA FILM (bisa pindah ke DB nanti)
// ===============================
$films = [
    ["id"=>"agak_laen", "judul"=>"Agak Laen", "genre"=>"Horror Comedy", "rating"=>"9.0", "poster"=>"agak laen.jpg"],
    ["id"=>"warkop", "judul"=>"Warkop DKI Reborn", "genre"=>"Comedy", "rating"=>"8.5", "poster"=>"warkop dki.jpg"],
    ["id"=>"pengabdi_setan", "judul"=>"Pengabdi Setan", "genre"=>"Horror", "rating"=>"8.7", "poster"=>"pengabdi setan.jpg"],
    ["id"=>"the_raid", "judul"=>"The Raid", "genre"=>"Action", "rating"=>"9.2", "poster"=>"The Raid.jpg"],
    ["id"=>"abadi_nan_jaya", "judul"=>"Abadi Nan Jaya", "genre"=>"Thriller Horror", "rating"=>"7.0", "poster"=>"abadi nan jaya.jpg"],
    ["id"=>"waktu_maghrib", "judul"=>"Waktu Maghrib", "genre"=>"Horror Thriller", "rating"=>"5.8", "poster"=>"Waktu Maghrib.jpg"],
    ["id"=>"the_mist", "judul"=>"The Mist", "genre"=>"Horror Sci-Fi", "rating"=>"7.1", "poster"=>"the mist.jpg"],
    ["id"=>"pabrik_gula", "judul"=>"Pabrik Gula", "genre"=>"Industries Thriller", "rating"=>"6.0", "poster"=>"Pabrik Gula.jpg"],
    ["id"=>"merah_putih", "judul"=>"Merah Putih One For All", "genre"=>"Adventure", "rating"=>"10", "poster"=>"merahputih.jpg"],
];


// ===============================
// FILTER SYSTEM (GENRE + SEARCH)
// ===============================
$genre  = isset($_GET['genre']) ? strtolower($_GET['genre']) : '';
$search = isset($_GET['search']) ? strtolower($_GET['search']) : '';

$filtered = array_filter($films, function($film) use ($genre, $search) {

    // Filter genre
    if (!empty($genre) && stripos(strtolower($film['genre']), $genre) === false) {
        return false;
    }

    // Filter search (judul)
    if (!empty($search) && stripos(strtolower($film['judul']), $search) === false) {
        return false;
    }

    return true;
});

?>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>NetflixReview+ – Beranda</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="logo.png" type="image/x-icon">

    <style>
        .profile-box:hover { 
            background:#333;
            cursor:pointer; }
        .profile-box img { 
            width:35px;
            height:35px;
            border-radius:50%;
            object-fit:cover; 
        }
        .profile-name { 
            color:white; 
            font-weight:bold; }
        nav a { margin-left: 15px; }

        .filter-bar {
            width:100%;
            background:#111;
            padding:10px 20px;
            display:flex;
            flex-wrap: wrap;     /* WAJIB supaya tidak overflow */
            align-items:center;
            gap:20px;
            border-bottom:1px solid #333;
            box-sizing: border-box;
        }


        .genre-tabs {
            display: flex;
            gap: 10px;
        }

        .filter-bar form {
            margin-align: auto;  PINDAHKAN SEARCH KE KANAN
            display: flex;
            gap: 10px;
        }

        .filter-form {
            display:flex;
            gap:10px; }
        .genre-select, .search-input {
            padding:8px;
            border-radius:5px;
            border:none;
            font-size:14px; 
        }
        .search-btn { 
            padding:8px 15px;
            border:none;
            background:red;
            color:white;
            border-radius:5px;
            cursor:pointer;
        }
        .search-btn:hover { 
            background:#b70000;
        }
        .genre-tabs {
            display: flex;
            gap: 10px;
        
        }
        .tab {
            padding: 15px 20px;
            background: #222;
            color: white;
            border-radius: 6px;
            text-decoration: none;
        }

        .tab:hover {
            background: #333;
        }

        .tab.active {
            background: red;
        }

/* ===== Desain Netflix ===== */
body{
    font-family: Arial, sans-serif;
    background: #000;
}

.donasi-container{
    text-align: center;
    margin: 40px auto;
    background: #111;
    padding: 30px;
    width: 80%;
    border-radius: 12px;
    border: 2px solid #E50914;
}

.donasi-container h2{
    color: #fff;
    font-size: 28px;
}

.donasi-container p{
    color: #ccc;
    font-size: 16px;
}

.btn-donate{
    background: #E50914;
    border: none;
    padding: 13px 28px;
    color: #fff;
    border-radius: 8px;
    cursor: pointer;
    font-size: 18px;
    transition: .3s;
}

.btn-donate:hover{
    background: #B20710;
}

.thank{
    color:#888;
    margin-top:10px;
}

/* ===== Progress Bar ===== */
.progress-box{
    width: 80%;
    height: 12px;
    background: #333;
    margin: auto;
    border-radius: 6px;
    overflow: hidden;
}

.progress{
    height: 100%;
    background: #E50914;
    transition: width .5s ease;
}

/* ===== Popup ===== */
.popup{
    display:none;
    position:fixed;
    top:0; left:0;
    width:100%;
    height:100%;
    background: rgba(0,0,0,0.8);
}

.popup-content{
    background:#111;
    width:300px;
    margin:120px auto;
    text-align:center;
    padding:20px;
    border-radius:10px;
    border:2px solid #E50914;
    animation: fadeIn .4s;
}

.popup-content h3{
    color:white;
    margin-bottom:10px;
}

.popup-content img{
    width:220px;
    margin:15px 0;
}

.btn-popup{
    background:#E50914;
    padding:10px 20px;
    text-decoration:none;
    color:white;
    font-weight:bold;
    border-radius:6px;
    display:inline-block;
    transition:.3s;
}

.btn-popup:hover{
    background:#B20710;
}

.close{
    float:right;
    font-size:24px;
    cursor:pointer;
    color:white;
}

@keyframes fadeIn{
    from{opacity:0; transform:scale(.8);}
    to{opacity:1; transform:scale(1);}
}

    </style>

</head>

<body>

<!-- HEADER -->
<header class="header">
<a href="beranda.php" class="logo" style="text-decoration:none;">
    NetflixReview+
</a>

    <nav style="display:flex;align-items:center;gap:15px;">

        <?php if (!isset($_SESSION['login'])): ?>
            
            <a href="login.php" class="login-btn">Login</a>

        <?php else: ?>

            <a href="profile.php" class="profile-box"
                style="text-decoration:none;display:flex;align-items:center;gap:10px;">
                <img src="avatars/<?php echo !empty($_SESSION['avatar']) ? $_SESSION['avatar'] : 'default.jpg'; ?>">
                <span class="profile-name"><?php echo htmlspecialchars($_SESSION['username']); ?></span>
            </a>

            <a href="logout.php" style="color:#f33;">
                <img src="logout.png" alt="Logout" style="width:26px;height:26px;">
            </a>

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


<!-- FILTER BAR -->
<div class="filter-bar">
    <div class="genre-tabs">
        <a href="beranda.php" class="tab <?= empty($genre)?'active':'' ?>">All</a>
        <a href="?genre=Action" class="tab <?= $genre=='action'?'active':'' ?>">Action</a>
        <a href="?genre=Horror" class="tab <?= $genre=='horror'?'active':'' ?>">Horror</a>
        <a href="?genre=Adventure" class="tab <?= $genre=='adventure'?'active':'' ?>">Adventure</a>
        <a href="?genre=Comedy" class="tab <?= $genre=='comedy'?'active':'' ?>">Comedy</a>
    </div>

    <form action="beranda.php" method="GET">
        <input type="text" name="search" placeholder="Cari film..." class="search-input">
        <button type="submit" class="search-btn">Cari</button>
    </form>
</div>




<!-- HERO SECTION -->
<div class="hero">
    <div class="hero-text">
        <h1>Selamat Datang di NetflixReview+</h1>
        <p>Tempat kamu mencari rekomendasi film terbaik sebelum menonton!</p>

        <?php if (!isset($_SESSION['login'])): ?>
            <a href="login.php" class="hero-btn">Gabung Member</a>
        <?php else: ?>
            <a href="beranda.php" class="hero-btn">Jelajahi Film</a>
        <?php endif; ?>

    </div>
</div>



<!-- LIST FILM (HASIL FILTER) -->
<section class="container">
    <h2 class="section-title">Daftar Film</h2>

    <div class="film-list">

        <?php if (empty($filtered)): ?>
            <p style="color:white;font-size:18px;margin:20px 0;">❌ Tidak ada film ditemukan.</p>
        <?php endif; ?>

        <?php foreach ($filtered as $film): ?>
        <a href="film_detail.php?id=<?= $film['id'] ?>" class="film-card">
            <img src="<?= $film['poster'] ?>" class="poster">
            <div class="film-info">
                <h3><?= $film['judul'] ?></h3>
                <p><?= $film['genre'] ?></p>
                <span class="rating">⭐ <?= $film['rating'] ?></span>
            </div>
        </a>
        <?php endforeach; ?>

    </div>
</section>

<!-- SUPPORT SECTION -->
<!-- ====== SECTION DONASI ====== -->
<section class="donasi-container">
    <h2>Dukung Developer ❤️</h2>
    <p>Bantu kami mengembangkan NetflixReview+ agar selalu update!</p>

<script>
function goDonate() {
    // Ganti link dengan link Saweria kamu
    window.open('https://saweria.co/netflixreview', '_blank');  
    setTimeout(function(){
        window.location.href = 'beranda.php';  
    }, 8000); // kembali dalam 8 detik
}
</script>

    <!-- Progress Bar -->
    <div class="progress-box">
        <div class="progress" style="width:40%"></div>
    </div>
    <small>Rp 40.000 terkumpul dari Rp 100.000 🎯</small><br><br>

    <!-- Tombol Donasi -->
    <button class="btn-donate" onclick="openPopup()">Donasi Sekarang</button>
    <a href="upload_bukti.php" class="btn-donate" 
    style="background:#0f0;display:block;margin:20px auto 0;width:200px;text-align:center;">
    Upload Bukti Transfer
</a>
    <p class="thank">Terima kasih atas dukunganmu 🙌</p>
</section>


<!-- ===== POPUP QR ===== -->
<div class="popup" id="popupQR">
    <div class="popup-content">
        <span class="close" onclick="closePopup()">&times;</span>
        <h3>Scan QR untuk Donasi</h3>

        <!-- GANTI QR DI SINI -->
        <img src="qr.png"
            alt="QR Code Donasi Saweria">

        <a href="https://saweria.co/netflixreview" target="_blank" class="btn-popup">Donasi via Saweria</a>
    </div>
</div>

<script>
function openPopup(){
    document.getElementById("popupQR").style.display = "block";
}

function closePopup(){
    document.getElementById("popupQR").style.display = "none";
}
</script>
</body>
</html>
