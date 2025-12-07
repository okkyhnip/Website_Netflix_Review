<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

// baca data film
$dataFile = "data_film.json";
$data = [];
if (file_exists($dataFile)) {
    $data = json_decode(file_get_contents($dataFile), true) ?: [];
}

// urutkan berdasarkan rating tertinggi
usort($data, function ($a, $b) {
    return ($b['rating'] ?? 0) <=> ($a['rating'] ?? 0);
});
?>
<html>
<head>
    <meta charset="utf-8">
    <title>Daftar Film - Netflix Review</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="container">

    <!-- HEADER -->
    <div class="header">
    <div>
        <h1>Netflix Review</h1>
        <p class="sub">Rekomendasi & Review dari Komunitas</p>
    </div>

    <div style="display:flex;align-items:center;gap:15px;">
        <div class="user-box">
            <img src="avatars/<?php echo $_SESSION['user']['avatar']; ?>" class="avatar">
            <span class="username"><?php echo $_SESSION['user']['username']; ?></span>
        </div>

        <!-- Tombol Edit Profil -->
        <a class="button" href="edit_profile.php" style="background:#008cff;">Edit Profil</a>

        <!-- Tambah Review -->
        <a class="button" href="tambah.php">+ Tambah Review</a>

        <!-- Logout -->
        <a class="button" href="logout.php" style="background:#555;">Logout</a>
    </div>
</div>

            <a class="button" href="tambah.php">+ Tambah Review</a>
            <a class="button" href="logout.php" style="background:#555;">Logout</a>
        </div>
    </div>    

    <!-- Jika belum ada film -->
    <?php if (empty($data)): ?>
        <p style="text-align:center;color:#aaa;margin-top:20px;">
            Belum ada review. Jadilah yang pertama menambahkan!
        </p>
    <?php endif; ?>

    <!-- GRID LIST -->
    <div class="grid">
        <?php foreach ($data as $index => $item): ?>
            <div class="card">

                <!-- Poster -->
                <?php if (!empty($item['poster'])): ?>
                    <img class="poster" src="<?= htmlspecialchars($item['poster']) ?>" alt=""
                    onerror="this.style.display='none'">
                <?php else: ?>
                    <div class="poster no-poster">Tidak ada poster</div>
                <?php endif; ?>

                <div class="card-body">
                    <h3 class="title"><?= htmlspecialchars($item['judul']) ?></h3>

                    <div class="meta">
                        <span class="badge"><?= htmlspecialchars($item['genre']) ?></span>
                        <span class="badge"><?= htmlspecialchars($item['tahun']) ?></span>
                        <span class="badge"><?= htmlspecialchars($item['durasi']) ?></span>
                        <span class="rating-number"><?= htmlspecialchars($item['rating']) ?>/10</span>
                    </div>

                    <p class="snippet">
                        <?= htmlspecialchars(mb_substr($item['review'], 0, 120)) ?>...
                    </p>

                    <a class="button detail-btn" href="detail.php?id=<?= $index ?>">Lihat Detail</a>
                </div>

            </div>
        <?php endforeach; ?>
    </div>

    <div class="footer">Total review: <?= count($data) ?></div>

</div>

</body>
</html>