<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: login.php");
    exit;
}

// file data
$dataFile = "data_film.json";

// ambil input dan trim
$judul = isset($_POST['judul']) ? trim($_POST['judul']) : '';
$genre = isset($_POST['genre']) ? trim($_POST['genre']) : '';
$tahun = isset($_POST['tahun']) ? trim($_POST['tahun']) : '';
$durasi = isset($_POST['durasi']) ? trim($_POST['durasi']) : '';
$poster = isset($_POST['poster']) ? trim($_POST['poster']) : '';
$rating = isset($_POST['rating']) ? (int) $_POST['rating'] : 0;
$review = isset($_POST['review']) ? trim($_POST['review']) : '';
$reviewer = isset($_POST['reviewer']) ? trim($_POST['reviewer']) : 'Anon';

// validasi sederhana
if ($judul === '' || $genre === '' || $tahun === '' || $rating < 1 || $rating > 10 || $review === '') {
    // kembali ke form jika ada field wajib kosong
    header("Location: tambah.php");
    exit;
}

// baca data lama
$data = [];
if (file_exists($dataFile)) {
    $json = file_get_contents($dataFile);
    $data = json_decode($json, true) ?: [];
}

// siapkan item baru
$baru = [
    "judul" => $judul,
    "genre" => $genre,
    "tahun" => $tahun,
    "durasi" => $durasi,
    "poster" => $poster,
    "rating" => $rating,
    "review" => $review,
    "reviewer" => $reviewer,
    "tanggal" => date("Y-m-d H:i:s")
];

// tambahkan dan simpan dengan lock
$data[] = $baru;
$fp = fopen($dataFile, 'c+');
if ($fp) {
    flock($fp, LOCK_EX);
    ftruncate($fp, 0);
    rewind($fp);
    fwrite($fp, json_encode($data, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES));
    fflush($fp);
    flock($fp, LOCK_UN);
    fclose($fp);
}

header("Location: index.php");
exit;
