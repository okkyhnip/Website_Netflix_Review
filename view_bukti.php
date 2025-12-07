<?php
session_start();

// path file transaksi
$dataFile = __DIR__ . '/data/transaksi.json';

// baca data
$data = [];
if (is_file($dataFile)) {
    $raw = file_get_contents($dataFile);
    $decoded = json_decode($raw, true);
    if (is_array($decoded)) $data = $decoded;
}

// jika ada id di query -> tampilkan detail trx tersebut
$id = isset($_GET['id']) ? $_GET['id'] : null;

// helper: cari transaksi berdasarkan id
function find_trx_by_id($data, $id) {
    foreach ($data as $t) {
        if (isset($t['id']) && $t['id'] == $id) return $t;
    }
    return null;
}

// jika id dikirim -> show single detail
if ($id !== null) {
    $trx = find_trx_by_id($data, $id);
    if (!$trx) {
        $notfound = true;
    } else {
        $notfound = false;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<title>Detail Bukti Transaksi</title>
<style>
body{background:#000;color:#fff;font-family:Arial;padding:30px}
.box{background:#111;padding:20px;border-radius:10px;max-width:900px;margin:auto}
.row{display:flex;gap:20px;flex-wrap:wrap}
.col{flex:1}
img.bukti{max-width:100%;border-radius:8px;border:2px solid #222}
.btn{display:inline-block;padding:8px 14px;border-radius:6px;text-decoration:none;color:#fff;background:#e50914;margin-right:8px}
.small{color:#bbb;font-size:14px}
.table{width:100%;border-collapse:collapse;margin-top:12px}
.table td{padding:8px;border-bottom:1px solid #222}
.link-back{color:#fff;text-decoration:underline}
</style>
</head>
<body>
<div class="box">
    <a class="link-back" href="beranda.php">&larr; Kembali</a>
    <h2>Detail Transaksi</h2>

<?php if (isset($notfound) && $notfound): ?>
    <p class="small">Transaksi tidak ditemukan.</p>

<?php elseif ($id !== null): ?>
    <?php
        // tampilkan detail transaksi
        $user = htmlspecialchars($trx['user'] ?? '—');
        $id_html = htmlspecialchars($trx['id'] ?? '—');
        $nominal = isset($trx['nominal']) ? number_format($trx['nominal'],0,',','.') : '—';
        $status = htmlspecialchars($trx['status'] ?? '—');
        $tanggal = htmlspecialchars($trx['tanggal'] ?? '—');
        $bukti = isset($trx['bukti']) ? $trx['bukti'] : '';
        $buktiExists = $bukti && file_exists(__DIR__ . '/' . $bukti);
    ?>
    <div class="row">
        <div class="col" style="flex:0 0 360px;">
            <?php if ($buktiExists): ?>
                <img class="bukti" src="<?= htmlspecialchars($bukti) ?>" alt="Bukti Transfer">
            <?php else: ?>
                <div style="background:#222;padding:30px;border-radius:8px;text-align:center;color:#aaa">Belum ada bukti transfer</div>
            <?php endif; ?>
        </div>

        <div class="col">
            <table class="table">
                <tr><td><strong>ID</strong></td><td><?= $id_html ?></td></tr>
                <tr><td><strong>User</strong></td><td><?= $user ?></td></tr>
                <tr><td><strong>Nominal</strong></td><td>Rp <?= $nominal ?></td></tr>
                <tr><td><strong>Status</strong></td><td><?= $status ?></td></tr>
                <tr><td><strong>Tanggal</strong></td><td><?= $tanggal ?></td></tr>
            </table>

            <div style="margin-top:12px;">
                <?php if ($buktiExists): ?>
                    <a class="btn" href="<?= htmlspecialchars($bukti) ?>" target="_blank">Buka File Bukti</a>
                <?php endif; ?>
            </div>
        </div>
    </div>

<?php else: ?>
    <!-- jika tidak ada id -> tampilkan daftar transaksi milik user (berdasarkan session username) -->
    <h3>Riwayat Transaksi Saya</h3>
    <?php
        $username = $_SESSION['username'] ?? null;
        $myList = [];

        if ($username !== null) {
            foreach ($data as $t) {
                if (isset($t['user']) && $t['user'] == $username) $myList[] = $t;
            }
        } else {
            // jika tidak login, tampilkan semua (atau kosong)
            $myList = [];
        }
    ?>

    <?php if (empty($myList)): ?>
        <p class="small">Belum ada transaksi yang terdaftar untuk akun kamu.</p>
    <?php else: ?>
        <?php foreach ($myList as $m): ?>
            <div style="background:#0a0a0a;padding:12px;border-radius:8px;margin-bottom:8px">
                <strong>ID:</strong> <?= htmlspecialchars($m['id'] ?? '') ?> &nbsp; | &nbsp;
                <strong>Nominal:</strong> Rp <?= isset($m['nominal']) ? number_format($m['nominal'],0,',','.') : '0' ?> &nbsp; | &nbsp;
                <strong>Status:</strong> <?= htmlspecialchars($m['status'] ?? '') ?>
                <div style="margin-top:8px">
                    <?php if (!empty($m['bukti']) && file_exists(__DIR__ . '/' . $m['bukti'])): ?>
                        <a class="btn" href="<?= htmlspecialchars($m['bukti']) ?>" target="_blank">Buka Bukti</a>
                    <?php endif; ?>
                    <a class="btn" href="view_bukti.php?id=<?= urlencode($m['id']) ?>">Detail</a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

<?php endif; ?>

</div>
</body>
</html>