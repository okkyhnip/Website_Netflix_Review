<?php
$nominal = $_POST['nominal'];
$custom = $_POST['customAmount'] ?? null;
$metode = $_POST["metode"];


if ($nominal == "custom" && $custom != null) {
    $nominal = $custom;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Konfirmasi Pembayaran</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<header class="header">
    <div class="logo">NetflixReview+</div>
</header>

<div class="confirm-box">

    <h2>Konfirmasi Pembayaran</h2>
    <p>Nominal yang harus dibayar:</p>
    <h3 style="color:#e50914;">Rp <?= number_format($nominal, 0, ',', '.') ?></h3>
    <p>Metode Pembayaran:</p>
    <h3 style="color:#0af;"><?= $metode ?></h3>

    <form action="confirm_success.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="nominal" value="<?= $nominal ?>">

        <label>Upload Bukti Pembayaran:</label>
        <input type="file" class="input-box" name="bukti" required accept="image/*">

        <button class="button" type="submit">Kirim Konfirmasi</button>
        <input type="hidden" name="metode" value="<?= $metode ?>">

        <button class="button" type="button" style="background:#555;margin-left:8px;" onclick="window.location.href='support.php'">Batal</button>

    </form>

</div>

</body>
</html>
