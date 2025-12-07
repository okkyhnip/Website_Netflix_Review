<?php
require 'admin_protect.php'; // pastikan admin_protect.php ada dan memeriksa session admin

$dataFile = __DIR__ . '/data/transaksi.json';
$buktiDir  = __DIR__ . '/bukti/';

// load data
$data = [];
if (is_file($dataFile)) {
    $raw = file_get_contents($dataFile);
    $decoded = json_decode($raw, true);
    if (is_array($decoded)) $data = $decoded;
}

// buat CSRF token sederhana
if (empty($_SESSION['csrf_token'])) $_SESSION['csrf_token'] = bin2hex(random_bytes(16));

?>
<html>
<html lang="id">
<head>
<meta charset="utf-8">
<title>Admin - Kelola Bukti</title>
<link rel="stylesheet" href="admin.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<div class="admin-wrap">
    <header class="admin-header">
        <h1>Admin Panel — Kelola Bukti Donasi</h1>
        <div>
            <a href="admin_dashboard.php" class="btn">Dashboard</a>
            <a href="admin_transaksi.php" class="btn">Semua Transaksi</a>
            <a href="admin_logout.php" class="btn danger">Logout</a>
        </div>
    </header>

    <main>
        <div style="margin-bottom: 20px;">
    <a href="admin_dashboard.php" class="btn">← Kembali ke Dashboard</a>
</div>
        <h2>Daftar Bukti Transfer</h2>
        <?php if (empty($data)): ?>
            <div class="empty">Belum ada transaksi.</div>
        <?php else: ?>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Nominal</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Bukti</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($data as $t): 
                    $id = htmlspecialchars($t['id'] ?? '');
                    $user = htmlspecialchars($t['user'] ?? '-');
                    $nom = isset($t['nominal']) ? 'Rp '.number_format($t['nominal'],0,',','.') : '-';
                    $status = htmlspecialchars($t['status'] ?? 'pending');
                    $tanggal = htmlspecialchars($t['tanggal'] ?? '-');
                    $bukti = isset($t['bukti']) ? $t['bukti'] : '';
                    $buktiExists = $bukti && is_file(__DIR__ . '/' . $bukti);
                ?>
                    <tr>
                        <td><?= $id ?></td>
                        <td><?= $user ?></td>
                        <td><?= $nom ?></td>
                        <td class="status <?= $status ?>"><?= ucfirst($status) ?></td>
                        <td><?= $tanggal ?></td>
                        <td>
                            <?php if ($buktiExists): ?>
                                <a href="<?= htmlspecialchars($bukti) ?>" target="_blank">
                                    <img src="<?= htmlspecialchars($bukti) ?>" class="thumb" alt="bukti">
                                </a>
                            <?php else: ?>
                                <span class="small">Tidak ada bukti</span>
                            <?php endif; ?>
                        </td>
                        <td class="actions">
                            <a class="btn small" href="view_bukti.php?id=<?= urlencode($t['id']) ?>" target="_blank">Detail</a>

                            <form method="post" class="inline" onsubmit="return confirmAction(event,'verify','<?= addslashes($id) ?>')">
                                <input type="hidden" name="action" value="verify">
                                <input type="hidden" name="id" value="<?= $id ?>">
                                <input type="hidden" name="csrf" value="<?= $_SESSION['csrf_token'] ?>">
                                <button class="btn success" type="submit">Verifikasi</button>
                            </form>

                            <form method="post" class="inline" onsubmit="return confirmAction(event,'reject','<?= addslashes($id) ?>')">
                                <input type="hidden" name="action" value="reject">
                                <input type="hidden" name="id" value="<?= $id ?>">
                                <input type="hidden" name="csrf" value="<?= $_SESSION['csrf_token'] ?>">
                                <button class="btn warn" type="submit">Tolak</button>
                            </form>

                            <?php if ($buktiExists): ?>
                            <form method="post" class="inline" onsubmit="return confirmAction(event,'delete_bukti','<?= addslashes($id) ?>')">
                                <input type="hidden" name="action" value="delete_bukti">
                                <input type="hidden" name="id" value="<?= $id ?>">
                                <input type="hidden" name="csrf" value="<?= $_SESSION['csrf_token'] ?>">
                                <button class="btn danger" type="submit">Hapus Bukti</button>
                            </form>
                            <?php endif; ?>

                            <form method="post" class="inline" onsubmit="return confirmAction(event,'delete_trx','<?= addslashes($id) ?>')">
                                <input type="hidden" name="action" value="delete_trx">
                                <input type="hidden" name="id" value="<?= $id ?>">
                                <input type="hidden" name="csrf" value="<?= $_SESSION['csrf_token'] ?>">
                                <button class="btn neutral" type="submit">Hapus Transaksi</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </main>
</div>

<script>
function confirmAction(evt, action, id){
    evt.preventDefault();
    let titles = {
        'verify': 'Verifikasi transaksi?',
        'reject': 'Tandai ditolak?',
        'delete_bukti': 'Hapus bukti?',
        'delete_trx': 'Hapus transaksi?'
    };
    let text = (action === 'verify') ? 'Bukti akan dianggap valid dan status akan diubah.' : 'Aksi ini tidak bisa dibatalkan.';
    Swal.fire({
        title: titles[action] || 'Konfirmasi',
        text: text,
        icon: action === 'verify' ? 'question' : 'warning',
        showCancelButton: true,
        confirmButtonColor: '#E50914',
        confirmButtonText: 'Ya, lanjutkan',
        cancelButtonText: 'Batal'
    }).then(res=>{
        if (res.isConfirmed) {
            // submit the form that contains the clicked button
            evt.target.submit();
        }
    });
    return false;
}
</script>
</body>
</html>