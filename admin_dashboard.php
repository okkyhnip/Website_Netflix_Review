<?php
require "admin_protect.php";
?>
<!DOCTYPE html>
<html>
<head>
<title>Admin Dashboard</title>
<style>
body{background:#000;color:#fff;font-family:Arial;padding:40px}
.card{
    background:#111;padding:20px;border-radius:10px;margin-bottom:20px;
}
a.btn{
    display:inline-block;
    padding:10px 15px;
    background:#E50914;
    color:#fff;
    text-decoration:none;
    border-radius:6px;
    margin-right:10px;
}
</style>
</head>
<body>

<h1>Admin Dashboard</h1>
<p>Halo, <?= htmlspecialchars($_SESSION['username']) ?>!</p>

<div class="card">
    <h3>Menu Admin</h3>
    <a class="btn" href="admin_bukti.php">Kelola Bukti Transfer</a>
    <a class="btn" href="admin_transaksi.php">Semua Transaksi</a>
    <a class="btn" href="login.php">Logout</a>
</div>

</body>
</html>
