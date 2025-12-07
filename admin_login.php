<?php
session_start();

// akun admin (bisa dipindah ke database nanti)
$ADMIN_USER = "admin";
$ADMIN_PASS = "admin123"; // ganti!

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    if ($user === $ADMIN_USER && $pass === $ADMIN_PASS) {
        $_SESSION['admin'] = true;
        $_SESSION['admin_user'] = $user;
        header("Location: admin_dashboard.php");
        exit;
    } else {
        $error = "Username atau password salah.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Login Admin</title>
<style>
body{background:#000;color:#fff;font-family:Arial;padding:40px;text-align:center}
.box{background:#111;padding:20px;border-radius:10px;display:inline-block}
input{padding:8px;width:200px;margin-bottom:10px}
button{padding:10px 15px;background:#E50914;border:none;color:#fff;border-radius:6px;cursor:pointer}
</style>
</head>
<body>
<div class="box">
    <h2>Login Admin</h2>
    <form method="post">
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit">Login</button>
    </form>
    <?php if(!empty($error)): ?>
        <p style="color:#f99"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
</div>
</body>
</html>
