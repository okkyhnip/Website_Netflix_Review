<?php
$data = json_decode(file_get_contents("data/transaksi.json"), true);
$id = $_GET["id"];

$trx = null;
foreach ($data as $t) {
    if ($t["id"] == $id) $trx = $t;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Detail Transaksi</title>
<link rel="stylesheet" href="style.css">
</head>

<body>

<div class="admin-box">
    <h2>Detail Transaksi</h2>

    <p><b>ID:</b> <?= $trx["id"] ?></p>
    <p><b>Nominal:</b> Rp <?= number_format($trx["nominal"], 0, ',', '.') ?></p>
    <p><b>Status:</b> <?= $trx["status"] ?></p>
    <p><b>Tanggal:</b> <?= $trx["tanggal"] ?></p>

    <h3>Bukti Pembayaran:</h3>
    <img src="<?= $trx["bukti"] ?>" style="width:250px; border-radius:10px;">

    <br><br>
    <a href="verifikasi.php?id=<?= $trx["id"] ?>" class="button">Verifikasi Pembayaran</a>
</div>

</body>
</html>
