<?php
session_start();

// Periksa apakah data POST diterima
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    // Jika tidak ada data POST, alihkan ke halaman register
    header("Location: login.php");
    exit;
}

// Ambil data dari form dan sanitasi
$username = htmlspecialchars($_POST["username"]);
$password = htmlspecialchars($_POST["password"]);

// --- BAGIAN PENANGANAN FILE JSON ---

// Nama file database
$file_name = "users.json";

// Jika file users.json tidak ada, buat baru
if (!file_exists($file_name)) {
    // Menggunakan LOCK_EX untuk mencegah race condition saat menulis file
    file_put_contents($file_name, "[]", LOCK_EX);
}

// Baca file users.json
$json_data = file_get_contents($file_name);
$data = json_decode($json_data, true);

// Periksa apakah username sudah ada
foreach ($data as $user) {
    if ($user["username"] == $username) {
        // --- GAGAL REGISTRASI: Username sudah dipakai ---
        $_SESSION['status'] = 'error';
        $_SESSION['status_text'] = 'Username "' . $username . '" sudah digunakan. Silakan pilih username lain.';
        header("Location: login.php");
        exit;
    }
}

// Tambah user baru (TIDAK ADA HASHING, disarankan menggunakan password_hash() untuk keamanan)
$data[] = [
    "username" => $username,
    // CATATAN: Dalam aplikasi nyata, gunakan password_hash() untuk mengamankan password!
    "password" => $password 
];

// Simpan ulang ke file
if (file_put_contents($file_name, json_encode($data, JSON_PRETTY_PRINT), LOCK_EX) === false) {
    // --- GAGAL REGISTRASI: Gagal menyimpan file ---
    $_SESSION['status'] = 'error';
    $_SESSION['status_text'] = 'Terjadi kesalahan saat menyimpan data. Coba lagi.';
    header("Location: login.php");
    exit;
}


// --- SUKSES REGISTRASI ---
// Set SweetAlert2 untuk sukses
$_SESSION['status'] = 'success';
$_SESSION['status_text'] = 'Akun Anda berhasil didaftarkan! Silakan masuk untuk memulai.';

// Opsi: Otomatis login (jika Anda ingin melakukannya)
// $_SESSION["login"] = true;
// $_SESSION["username"] = $username;

// Alihkan kembali ke halaman login/register 
header("Location: login.php"); 
exit;
?>