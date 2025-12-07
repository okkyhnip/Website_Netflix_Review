<?php
$data = json_decode(file_get_contents("data/transaksi.json"), true);
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Admin – Daftar Transaksi</title>
<link rel="stylesheet" href="style.css">
</head>

<body>

<div class="admin-box">
    <h2>Daftar Transaksi Support</h2>

    <table border="1" cellpadding="10" style="width:100%; color:white;">
        <tr>
            <th>ID</th>
            <th>Nominal</th>
            <th>Status</th>
            <th>Tanggal</th>
            <th>Aksi</th>
        </tr>

        <?php foreach($data as $trx): ?>
        <tr>
            <td><?= $trx["id"] ?></td>
            <td>Rp <?= number_format($trx["nominal"],0,',','.') ?></td>
            <td><?= $trx["status"] ?></td>
            <td><?= $trx["tanggal"] ?></td>
            <td>
                <a href="admin_detail.php?id=<?= $trx["id"] ?>" class="button-small">Detail</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>

</body>
</html>
