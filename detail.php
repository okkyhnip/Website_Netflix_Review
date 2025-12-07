<?php
session_start();

/* ================================
  CEK LOGIN
================================ */
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    
    // Simpan halaman tujuan agar setelah login balik ke detail film
    if (isset($_GET['id'])) {
        $_SESSION['redirect_after_login'] = "detail.php?id=" . $_GET['id'];
    }

    header("Location: login.php");
    exit();
}

/* ================================
  LOAD DATA FILM
================================ */
$dataFile = "data_film.json";
$data = [];

if (file_exists($dataFile)) {
    $json = file_get_contents($dataFile);
    $data = json_decode($json, true) ?: [];
}

$id = isset($_GET['id']) ? (int) $_GET['id'] : -1;

if (!isset($data[$id])) {
    header("Location: index.php");
    exit();
}

$item = $data[$id];
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Detail - <?= htmlspecialchars($item['judul']) ?></title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
  <div class="header">
    <div>
      <h1><?= htmlspecialchars($item['judul']) ?></h1>
      <p class="sub">oleh <?= htmlspecialchars($item['reviewer'] ?? 'Anon') ?> — <?= htmlspecialchars($item['tanggal'] ?? '') ?></p>
    </div>
    <div>
      <a class="button" href="index.php">Kembali</a>
      <a class="button" href="logout.php" style="background:#555;margin-left:8px;">Logout</a>
    </div>
  </div>

  <div class="detail-grid">
    <div>
      <?php if (!empty($item['poster'])): ?>
        <img class="poster-large" src="<?= htmlspecialchars($item['poster']) ?>" 
             alt="Poster <?= htmlspecialchars($item['judul']) ?>" 
             onerror="this.style.display='none'">
      <?php else: ?>
        <div style="background:#111;padding:30px;border-radius:6px;color:#777;text-align:center;">
            No Poster
        </div>
      <?php endif; ?>
    </div>

    <div>
      <div class="card">
        <div class="card-body">
          <p>
            <span class="badge"><?= htmlspecialchars($item['genre'] ?? '-') ?></span>
            <span class="badge"><?= htmlspecialchars($item['tahun'] ?? '-') ?></span>
            <span class="badge"><?= htmlspecialchars($item['durasi'] ?? '-') ?></span>

            <span style="float:right;font-weight:700;">
              <?= htmlspecialchars($item['rating'] ?? '-') ?>/10
            </span>
          </p>

          <h3 style="margin-top:8px;">Review</h3>
          <p style="white-space:pre-wrap;"><?= htmlspecialchars($item['review']) ?></p>

          <p style="margin-top:12px;color:#bfbfbf;">
            <strong>Reviewer:</strong> <?= htmlspecialchars($item['reviewer']) ?>
          </p>

          <p style="margin-top:4px;color:#bfbfbf;">
            <strong>Tanggal:</strong> <?= htmlspecialchars($item['tanggal']) ?>
          </p>

        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>