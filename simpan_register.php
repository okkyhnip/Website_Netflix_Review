<?php
session_start();

// ambil data dari form
$username = $_POST["username"];
$password = $_POST["password"];

// jika file users.json tidak ada, buat baru
if (!file_exists("users.json")) {
    file_put_contents("users.json", "[]");
}

// baca file users.json
$data = json_decode(file_get_contents("users.json"), true);

// cek apakah username sudah ada
foreach ($data as $user) {
    if ($user["username"] == $username) {
        header("Location: register.php?error=Username sudah dipakai");
        exit;
    }
}

// tambah user baru
$data[] = [
    "username" => $username,
    "password" => $password
];

// simpan ulang ke file
file_put_contents("users.json", json_encode($data, JSON_PRETTY_PRINT));

// otomatis login setelah daftar
$_SESSION["login"] = true;
$_SESSION["username"] = $username;

// pindah ke beranda
header("Location: beranda.php?success=1");
exit;
?>
