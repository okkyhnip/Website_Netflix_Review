<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit;
}
?>

<html>
<head>
<title>Donasi</title>
</head>
<body style="text-align:center;">

<h2>Donasi ke NetflixReview+</h2>
<p>Klik tombol di bawah untuk melakukan donasi melalui Saweria</p>

<a href="https://saweria.co/kode_saweriakamu" target="_blank">
    <button>Donasi Sekarang</button>
</a>

<br><br>

<!-- Setelah donasi klik upload bukti -->
<a href="upload_bukti.php">
    <button>Upload Bukti Transfer</button>
</a>

</body>
</html>
