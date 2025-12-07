<?php
session_start();

// CEK LOGIN
if (!isset($_SESSION["login"]) || $_SESSION["login"] !== true) {
    header("Location: login.php");
    exit;
}

// ===========================
// DATA FILM
// ===========================
$films = [
    "agak_laen" => [
        "judul" => "Agak Laen (2024)",
        "genre" => "Horror Comedy",
        "tahun" => "2024",
        "durasi" => "1 Jam 55 Menit",
        "rating" => "9.0",
        "poster" => "agak laen.jpg",
        "ringkas" => "Film Agak Laen memadukan humor khas mereka dengan horor yang ringan.",
        "review" => "Agak Laen sukses memadukan komedi spontan dengan suasana horor yang menghibur. Cerita berjalan cepat dan dialognya natural.",
        "reviewer" => "Admin Netflix Review",
        "tanggal" => "1 Desember 2025",
        "trailer" => "https://www.youtube.com/embed/0YLSPyGA4h0"
    ],

        "warkop" => [
        "judul" => "Warkop DKI Reborn",
        "genre" => "Comedy",
        "tahun" => "2016",
        "durasi" => "1 Jam 40 Menit",
        "rating" => "8.5",
        "poster" => "warkop dki.jpg",
        "ringkas" => "Komedi legendaris Warkop dibawa kembali dengan versi modern.",
        "review" => "Film ini berhasil menghadirkan komedi yang segar dengan karakter khas Warkop.",
        "reviewer" => "Admin Netflix Review",
        "tanggal" => "5 Desember 2025",
        "trailer" => "https://www.youtube.com/embed/T0ki7KwvO1Q"
    ],

    "pengabdi_setan" => [
        "judul" => "Pengabdi Setan",
        "genre" => "Horror",
        "tahun" => "2017",
        "durasi" => "1 Jam 47 Menit",
        "rating" => "8.7",
        "poster" => "pengabdi setan.jpg",
        "ringkas" => "Salah satu horor Indonesia terbaik dengan atmosfer mencekam.",
        "review" => "Film horor dengan nuansa gelap dan jump scare efektif, membuat penonton tegang sepanjang film.",
        "reviewer" => "Admin Netflix Review",
        "tanggal" => "10 Desember 2025",
        "trailer" => "https://youtube.com/embed/8LIHcd7WfWI"
    ],

    "the_raid" => [
        "judul" => "The Raid",
        "genre" => "Action",
        "tahun" => "2011",
        "durasi" => "1 Jam 41 Menit",
        "rating" => "9.2",
        "poster" => "The Raid.jpg",
        "ringkas" => "Aksi laga intens dari Indonesia yang mendapat pujian internasional.",
        "review" => "The Raid menawarkan aksi yang tak henti-hentinya dengan koreografi pertarungan yang luar biasa.",
        "reviewer" => "Admin Netflix Review",
        "tanggal" => "15 Desember 2025",
        "trailer" => "https://www.youtube.com/embed/m6Q7KnXpNOg?"
    ],

    "abadi_nan_jaya" => [
        "judul" => "Abadi Nan Jaya",
        "genre" => "Thriller, Horor",
        "tahun" => "2025",
        "durasi" => "2 Jam 3 Menit",
        "rating" => "7.0",
        "poster" => "abadi nan jaya.jpg",
        "ringkas" => "Film thriller horor yang mengangkat cerita mistis di Indonesia.",
        "review" => "Abadi Nan Jaya menyajikan cerita yang menarik dengan elemen horor yang kental.",
        "reviewer" => "Admin Netflix Review",
        "tanggal" => "20 Desember 2025",
        "trailer" => "https://www.youtube.com/embed/K2KM_C_m8hA"
    ],

    "waktu_maghrib" => [
        "judul" => "Waktu Maghrib",
        "genre" => "Horror, Thriller",
        "tahun" => "2018",
        "durasi" => "1 Jam 50 Menit",
        "rating" => "5.8",
        "poster" => "Waktu Maghrib.jpg",
        "ringkas" => "Film horor yang berlatar waktu maghrib dengan cerita yang unik.",
        "review" => "Waktu Maghrib memiliki konsep menarik, namun eksekusinya kurang maksimal.",
        "reviewer" => "Admin Netflix Review",
        "tanggal" => "25 Desember 2025",
        "trailer" => "https://www.youtube.com/embed/ccfaKsknHqs"
    ],

    "the_mist" => [
        "judul" => "The Mist",
        "genre" => "Horror, Sci-Fi",
        "tahun" => "2007",
        "durasi" => "2 Jam 6 Menit",
        "rating" => "7.1",
        "poster" => "the mist.jpg",
        "ringkas" => "Film horor fiksi ilmiah tentang makhluk misterius dalam kabut tebal.",
        "review" => "The Mist berhasil menciptakan suasana mencekam dengan konsep yang unik.",
        "reviewer" => "Admin Netflix Review",
        "tanggal" => "30 Desember 2025",
        "trailer" => "https://www.youtube.com/embed/LhCKXJNGzN8"
    ],

    "pabrik_gula" => [
        "judul" => "Pabrik Gula",
        "genre" => "Drama, Thriller",
        "tahun" => "2025",
        "durasi" => "1 Jam 33 Menit",
        "rating" => "6.9",
        "poster" => "Pabrik Gula.jpg",
        "ringkas" => "Drama thriller yang mengangkat isu sosial di Indonesia.",
        "review" => "Pabrik Gula menyajikan cerita yang kuat dengan karakter yang mendalam.",
        "reviewer" => "Admin Netflix Review",
        "tanggal" => "31 Maret 2025",
        "trailer" => "https://www.youtube.com/embed/Uvp2ZBK7Vnc"
    ],

    "merah_putih" => [
        "judul" => "Merah Putih One For All",
        "genre" => "Adventure",
        "tahun" => "2025",
        "durasi" => "2 Jam 15 Menit",
        "rating" => "10",
        "poster" => "merahputih.jpg",
        "ringkas" => "Film petualangan epik yang mengisahkan perjuangan kemerdekaan Indonesia.",
        "review" => "Merah Putih One For All adalah film yang menginspir
asi dengan visual yang memukau dan cerita yang menggugah.",
        "reviewer" => "Admin Netflix Review",
        "tanggal" => "17 Agustus 2025",
        "trailer" => "https://www.youtube.com/embed/6jdG2WQEgyI"
    ],
];

// ===========================
// AMBIL ID FILM
// ===========================
$id = $_GET["id"] ?? null;

if ($id === null || !isset($films[$id])) {
    die("<h2 style='color:white; text-align:center;'>Film tidak ditemukan!</h2>");
}

$film = $films[$id];
?>
<!DOCTYPE html>
<html>
<head>
    <title><?= $film["judul"] ?></title>
    <style>
        body {
            background: #141414;
            color: white;
            font-family: Arial;
            margin: 0;
        }
        .container {
            width: 90%;
            max-width: 900px;
            margin: 40px auto;
        }
        .poster-big {
            width: 100%;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        .info-box {
            background: #1f1f1f;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 25px;
        }
        .trailer {
            width: 100%;
            height: 380px;
            border-radius: 10px;
        }
        a {
            color: #e50914;
            text-decoration: none;
            font-size: 18px;
        }
        a:hover {
            color: #ff2424;
        }

        .coment-box {
            background: #1f1f1f;
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
        }
        .coment-box textarea {
            width: 100%;
            padding: 10px;
            border-radius: 6px;
            border: none;
            resize: vertical;
            font-size: 16px;
        }
        .coment-box button {
            margin-top: 10px;
            padding: 10px 20px;
            background: #e50914;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
        }
        .coment-box button:hover {
            background: #ff2424;
        }
        
    </style>
</head>
<body>

<div class="container">

    <a href="beranda.php">&larr; Kembali ke Beranda</a>

    <h1><?= $film["judul"] ?></h1>

    <img src="<?= $film["poster"] ?>" class="poster-big">

    <div class="info-box">
        <h2>Informasi Film</h2>
        <p><b>Genre:</b> <?= $film["genre"] ?></p>
        <p><b>Tahun:</b> <?= $film["tahun"] ?></p>
        <p><b>Durasi:</b> <?= $film["durasi"] ?></p>
        <p><b>Rating:</b> ⭐ <?= $film["rating"] ?>/10</p>
    </div>

    <div class="info-box">
        <h2>Ringkasan Review</h2>
        <p><?= $film["ringkas"] ?></p>
    </div>

    <div class="info-box">
        <h2>Review Lengkap</h2>
        <p><?= $film["review"] ?></p>
        <p><b>Reviewer:</b> <?= $film["reviewer"] ?></p>
        <p><b>Tanggal:</b> <?= $film["tanggal"] ?></p>
    </div>

    <h2>Trailer</h2>
    <iframe class="trailer" src="<?= $film["trailer"] ?>" allowfullscreen></iframe>
</div>

<!-- ========================== -->
<!-- SISTEM KOMENTAR LOCALSTORAGE -->
<!-- ========================== -->

<style>
.comment-section {
    background: #1f1f1f;
    padding: 20px;
    border-radius: 10px;
    margin: 25px auto;
    width: 90%;
    max-width: 900px;
}
.comment-section textarea {
    width: 100%;
    padding: 12px;
    border-radius: 6px;
    border: none;
    resize: vertical;
    font-size: 16px;
    background: #2a2a2a;
    color: white;
}
.comment-section button {
    margin-top: 10px;
    padding: 10px 18px;
    background: #e50914;
    color: white;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-size: 15px;
}
.comment-item {
    background: #2b2b2b;
    padding: 12px;
    border-radius: 8px;
    margin-top: 15px;
}
.comment-author {
    font-weight: bold;
    color: #ff4b4b;
}
.comment-time {
    font-size: 12px;
    color: #aaa;
}
</style>

<div class="comment-section">
    <h2>Komentar Pengguna</h2>

    <textarea id="commentInput" rows="3" placeholder="Tulis komentar..."></textarea>
    <button id="sendComment">Kirim</button>

    <div id="commentList"></div>
</div>

<script>
// Ambil ID film dari PHP
const filmID = "comments_<?= $id ?>";

// Load komentar dari localStorage
function loadComments() {
    let data = localStorage.getItem(filmID);
    let comments = data ? JSON.parse(data) : [];

    const list = document.getElementById("commentList");
    list.innerHTML = "";

    if (comments.length === 0) {
        list.innerHTML = "<p style='color:#999;'>Belum ada komentar.</p>";
        return;
    }

    comments.forEach((c, index) => {
        const div = document.createElement("div");
        div.className = "comment-item";

        let deleteBtn = "";
        if (c.name === "<?= $_SESSION['username'] ?>") {
            deleteBtn = `<button class="delete-btn" onclick="deleteComment(${index})">Hapus</button>`;
        }

        div.innerHTML = `
            <div class="comment-author">${c.name}</div>
            <div class="comment-time">${c.time}</div>
            <div>${c.text}</div>
            ${deleteBtn}
        `;

        list.appendChild(div);
    });
}

// Hapus komentar
function deleteComment(index) {
    if (!confirm("Yakin ingin menghapus komentar ini?")) return;

    let data = localStorage.getItem(filmID);
    let comments = data ? JSON.parse(data) : [];

    comments.splice(index, 1); // hapus 1 komentar berdasarkan index

    localStorage.setItem(filmID, JSON.stringify(comments));
    loadComments();
}

// Simpan komentar
document.getElementById("sendComment").addEventListener("click", function() {
    let text = document.getElementById("commentInput").value.trim();
    if (!text) return alert("Komentar masih kosong!");

    let name = "<?= $_SESSION['username'] ?>"; // ← otomatis ambil user login

    let newComment = {
        name: name,
        text: text,
        time: new Date().toLocaleString()
    };

    let data = localStorage.getItem(filmID);
    let comments = data ? JSON.parse(data) : [];
    comments.push(newComment);

    localStorage.setItem(filmID, JSON.stringify(comments));

    document.getElementById("commentInput").value = "";
    loadComments();
});

// Load saat halaman dibuka
loadComments();
</script>

</body>
</html>