<?php
require 'admin_protect.php';
$dataFile = __DIR__ . '/data/transaksi.json';
$data = [];
if (is_file($dataFile)) {
    $raw = file_get_contents($dataFile);
    $decoded = json_decode($raw, true);
    if (is_array($decoded)) $data = $decoded;
}

// pencarian sederhana via GET ?q=...
$q = isset($_GET['q']) ? trim($_GET['q']) : '';
$filtered = [];
if ($q === '') $filtered = $data;
else {
    foreach ($data as $t) {
        if (stripos(($t['id'] ?? '') . ' ' . ($t['user'] ?? '') . ' ' . ($t['status'] ?? ''), $q) !== false) {
            $filtered[] = $t;
        }
    }
}
?>
<html>
<html lang="id">
<head>
<meta charset="utf-8">
<div style="margin-bottom: 20px;">
    <a href="admin_dashboard.php" class="btn">← Kembali ke Dashboard</a>
</div>
<title>Admin - Semua Transaksi</title>
<link rel="stylesheet" href="admin.css">
</head>
<body>
<div class="admin-wrap">
    <header class="admin-header">
        <h1>Semua Transaksi</h1>
        <div>
            <a href="admin_dashboard.php" class="btn">Dashboard</a>
            <a href="admin_bukti.php" class="btn">Kelola Bukti</a>
        </div>
    </header>

    <main>
        <form method="get" style="margin-bottom:12px">
            <input type="text" name="q" placeholder="Cari ID / user / status..." value="<?= htmlspecialchars($q) ?>" class="search">
            <button class="btn">Cari</button>
        </form>

        <?php if (empty($filtered)): ?>
            <div class="empty">Tidak ada hasil.</div>
        <?php else: ?>
            <table class="admin-table">
                <thead><tr><th>ID</th><th>User</th><th>Nominal</th><th>Status</th><th>Tanggal</th><th>Aksi</th></tr></thead>
                <tbody>
                <?php foreach ($filtered as $t): ?>
                    <tr>
                        <td><?= htmlspecialchars($t['id'] ?? '') ?></td>
                        <td><?= htmlspecialchars($t['user'] ?? '-') ?></td>
                        <td><?= isset($t['nominal']) ? 'Rp '.number_format($t['nominal'],0,',','.') : '-' ?></td>
                        <td><?= htmlspecialchars($t['status'] ?? 'pending') ?></td>
                        <td><?= htmlspecialchars($t['tanggal'] ?? '-') ?></td>
                        <td><a class="btn" href="view_bukti.php?id=<?= urlencode($t['id']) ?>">Detail</a></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

    </main>
</div>
</body>
</html>
