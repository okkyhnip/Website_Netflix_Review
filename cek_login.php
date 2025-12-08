<?php
session_start();

$username = $_POST["username"];
$password = $_POST["password"];

// ===== CEK LOGIN ADMIN =====
if ($username === "admin" && $password === "admin123") {
    $_SESSION["admin"] = true;
    $_SESSION["username"] = $username;

    header("Location: admin_dashboard.php");
    exit;
}

// ===== CEK LOGIN MEMBER BIASA =====
$data = json_decode(file_get_contents("users.json"), true);

foreach ($data as $user) {
    if ($user["username"] == $username && $user["password"] == $password) {

        $_SESSION["login"] = true;
        $_SESSION["username"] = $username;

        header("Location: beranda.php");
        exit;
    }
}

// Jika gagal login
header("Location: login.php?error=1");
exit;