<?php
session_start();

$username = $_POST["username"];
$password = $_POST["password"];

// baca file user
$data = json_decode(file_get_contents("users.json"), true);

// cocokkan user
foreach ($data as $user) {
    if ($user["username"] == $username && $user["password"] == $password) {

        // SIMPAN SESSION
        $_SESSION["login"] = true;
        $_SESSION["username"] = $username;

        header("Location: beranda.php");
        exit;
    }
}

// kalau gagal
header("Location: login.php?error=1");
exit;
