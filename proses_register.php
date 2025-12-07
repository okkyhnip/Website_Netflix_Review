<?php
$username = $_POST["username"];
$password = $_POST["password"];

if (!file_exists("users.json")) {
    file_put_contents("users.json", json_encode([]));
}

$data = json_decode(file_get_contents("users.json"), true);

// Cek apakah username sudah ada
foreach ($data as $user) {
    if ($user["username"] == $username) {
        header("Location: register.php?error=Username sudah dipakai!");
        exit;
    }
}

// Simpan user baru
$data[] = [
    "username" => $username,
    "password" => $password
];

file_put_contents("users.json", json_encode($data, JSON_PRETTY_PRINT));

header("Location: beranda.php");
exit;
