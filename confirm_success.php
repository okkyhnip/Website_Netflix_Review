<?php
$nominal = $_POST["nominal"];
$folder = "bukti/";

if (!is_dir($folder)) mkdir($folder);

$filename = time() . "_" . $_FILES["bukti"]["name"];
$path = $folder . $filename;

move_uploaded_file($_FILES["bukti"]["tmp_name"], $path);

// DATA TRANSAKSI
$transaksi = [
    "id" => uniqid("TRX"),
    "nominal" => $nominal,
    "bukti" => $path,
    "status" => "Pending",
    "tanggal" => date("Y-m-d H:i:s")
];

$file = "data/transaksi.json";
if (!is_dir("data")) mkdir("data");

if (!file_exists($file)) file_put_contents($file, "[]");

$data = json_decode(file_get_contents($file), true);
$data[] = $transaksi;

file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Konfirmasi Berhasil</title>
<link rel="stylesheet" href="style.css">
</head>

<body>

<div class="success-box">
    <h2>Konfirmasi Berhasil!</h2>
    <p>ID Transaksi:</p>
    <h3><?= $transaksi["id"] ?></h3>

    <p>Nominal: Rp <?= number_format($nominal, 0, ',', '.') ?></p>

    <img src="<?= $path ?>" class="bukti-img"><br>

    <a href="beranda.php" class="button">Kembali ke Beranda</a>
</div>

</body>
</html>
