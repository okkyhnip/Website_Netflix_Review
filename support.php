<html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Support Developer</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<header class="header">
    <div class="logo">NetflixReview+</div>
    <nav>
        <a href="index.php">Beranda</a>
    </nav>
</header>

<div class="support-box">
    <h2>Support Developer</h2>
    <p>Pilih nominal untuk mendukung developer:</p>

    <form action="confirm.php" method="POST">

    <label>Nominal Support:</label>
    <select name="nominal" class="input-box" onchange="toggleCustom(this.value)">
        <option value="5000">Rp 5.000</option>
        <option value="10000">Rp 10.000</option>
        <option value="20000">Rp 20.000</option>
        <option value="custom">Nominal Lain</option>
    </select>

    <input type="number" name="customAmount" id="customAmount" class="input-box"
        placeholder="Tulis nominal sendiri" style="display:none; margin-top:5px;">

    <label style="margin-top:15px;">Metode Pembayaran:</label>
    <select name="metode" class="input-box" required>
        <option value="DANA (089507062787)">DANA – 089507062787</option>
        <option value="OVO (082211386573)">OVO – 082211386573</option>
        <option value="GoPay (085811370283)">GoPay – 085811370283</option>
        <option value="ShopeePay (082114779178)">ShopeePay – 082114779178</option>
        <option value="BCA (1234567890)">Bank BCA – 1234567890</option>
        <option value="BRI (9876543210)">Bank BRI – 9876543210</option>
        <option value="BNI (9988776655)">Bank BNI – 9988776655</option>
        <option value="QRIS">QRIS (scan barcode)</option>
    </select>

    <button class="button" type="submit">Lanjut</button>
    <button class="button" type="button" style="background:#555;margin-left:8px;" onclick="window.location.href='beranda.php'">Batal</button>
</form>

</div>

<script>
function toggleCustom(value){
    document.getElementById("customAmount").style.display =
        value === "custom" ? "block" : "none";
}
</script>



</body>
</html>
