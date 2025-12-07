<?php
session_start();

// path file transaksi (gunakan __DIR__ agar path selalu benar)
$dataFile = __DIR__ . '/data/transaksi.json';
$buktiDir  = __DIR__ . '/bukti/';

// pastikan folder bukti ada
if (!is_dir($buktiDir)) {
    mkdir($buktiDir, 0755, true);
}

// baca data transaksi dengan aman
$data = [];
if (is_file($dataFile)) {
    $raw = file_get_contents($dataFile);
    $decoded = json_decode($raw, true);
    if (is_array($decoded)) {
        $data = $decoded;
    } else {
        // file ada tapi rusak/format tidak benar -> fallback ke array kosong
        $data = [];
    }
} else {
    // jika file belum ada, buat file kosong dengan array []
    file_put_contents($dataFile, json_encode([], JSON_PRETTY_PRINT));
    $data = [];
}

// ambil id transaksi jika dikirim via GET (opsional)
$id = isset($_GET['id']) ? $_GET['id'] : null;

// cari transaksi berdasarkan id (jika ada)
$trx = null;
if ($id !== null) {
    foreach ($data as $t) {
        if (isset($t['id']) && $t['id'] == $id) {
            $trx = $t;
            break;
        }
    }
} else {
    // fallback: ambil transaksi terakhir (jika ada)
    if (!empty($data)) {
        $tmp = $data;
        $trx = end($tmp);
    }
}

// jika tidak ketemu trx, beri pesan (tapi tetap tampilkan form upload)
if ($trx === null) {
    $infoMsg = "Transaksi tidak ditemukan. Upload bukti akan dikaitkan ke transaksi terakhir jika ada.";
} else {
    $infoMsg = "Meng-upload bukti untuk transaksi ID: " . htmlspecialchars($trx['id']);
}

// inisialisasi status untuk SweetAlert
$success = false;
$successMsg = '';
$error = '';

// proses upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['bukti'])) {
    $file = $_FILES['bukti'];

    // validasi dasar
    if ($file['error'] !== UPLOAD_ERR_OK) {
        $error = "Upload error: " . $file['error'];
    } else {
        $allowed = ['jpg','jpeg','png','pdf'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, $allowed)) {
            $error = "Tipe file tidak diizinkan. Hanya JPG/JPEG/PNG/PDF.";
        } elseif ($file['size'] > 2 * 1024 * 1024) {
            $error = "Ukuran file maksimal 2MB.";
        } else {
            // buat nama file unik
            try {
                $safeName = time() . '_' . bin2hex(random_bytes(6)) . '.' . $ext;
            } catch (Exception $e) {
                // fallback jika random_bytes gagal
                $safeName = time() . '_' . mt_rand(1000,9999) . '.' . $ext;
            }
            $dest = $buktiDir . $safeName;

            if (move_uploaded_file($file['tmp_name'], $dest)) {
                // update transaksi terkait: cari index di array
                $updated = false;
                if ($id !== null) {
                    foreach ($data as &$t) {
                        if (isset($t['id']) && $t['id'] == $id) {
                            $t['bukti'] = 'bukti/' . $safeName; // path relatif untuk <img src="...">
                            $t['status'] = 'Menunggu Verifikasi';
                            $updated = true;
                            break;
                        }
                    }
                    unset($t);
                }

                // jika tidak ada id, update transaksi terakhir
                if (!$updated && !empty($data)) {
                    $lastIndex = count($data) - 1;
                    $data[$lastIndex]['bukti'] = 'bukti/' . $safeName;
                    $data[$lastIndex]['status'] = 'Menunggu Verifikasi';
                    $updated = true;
                }

                // jika data kosong (tidak ada transaksi sama sekali), buat entri minimal (opsional)
                if (!$updated) {
                    $newTrx = [
                        'id' => 'trx_' . time(),
                        'user' => $_SESSION['username'] ?? 'guest',
                        'nominal' => 0,
                        'bukti' => 'bukti/' . $safeName,
                        'status' => 'Menunggu Verifikasi',
                        'tanggal' => date('Y-m-d H:i:s')
                    ];
                    $data[] = $newTrx;
                }

                // simpan kembali ke file json
                file_put_contents($dataFile, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

                // set sukses (tampilkan SweetAlert di HTML)
                $success = true;
                $successMsg = "Bukti transfer berhasil dikirim. Terima kasih atas dukunganmu!";
            } else {
                $error = "Gagal memindahkan file.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<title>Upload Bukti Transfer</title>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
body{background:#000;color:#fff;font-family:Arial;padding:30px;text-align:center}
.form-box{background:#111;padding:20px;border-radius:10px;display:inline-block;max-width:420px}
input[type=file]{color:#000}
.btn{background:#E50914;border:none;color:#fff;padding:10px 18px;border-radius:6px;cursor:pointer}
.info{color:#ccc;margin-bottom:12px}
.err{color:#ff8a8a;margin-top:12px}
a.back-link{display:inline-block;margin-top:12px;color:#fff;text-decoration:underline}
</style>
</head>
<body>
<div class="form-box">
    <h2>Upload Bukti Transfer</h2>
    <p class="info"><?= htmlspecialchars($infoMsg) ?></p>

        <form method="post" enctype="multipart/form-data">
        <input type="file" name="bukti" required><br><br>
        <button class="btn" type="submit">Kirim Bukti</button>
    </form>

    <?php if (!empty($error)): ?>
        <p class="err"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <div style="margin-top:14px">
        <a class="back-link" href="beranda.php">Kembali ke Beranda</a>
    </div>

    <?php
    // TOMBOL LIHAT BUKTI: jika transaksi (trx) punya bukti file, tampilkan tombol.
    // catatan: $trx di-set di atas saat baca data
    if ($trx !== null && !empty($trx['bukti'])):
        $buktiPath = htmlspecialchars($trx['bukti']);
        // cek file ada
        if (file_exists(__DIR__ . '/' . $trx['bukti'])):
    ?>
        <div style="margin-top:12px;">
            <!-- buka file bukti langsung di tab baru -->
            <a href="<?= $buktiPath ?>" target="_blank" class="btn" style="background:#2ecc71; text-decoration:none; display:inline-block;">
                Lihat Bukti Saya (Buka File)
            </a>
<br></br>
            <!-- buka halaman detail transaksi -->
            <a href="view_bukti.php?id=<?= urlencode($trx['id']) ?>" class="btn" style="background:#3498db; margin-left:8px; text-decoration:none; display:inline-block;">
                Lihat Detail Transaksi
            </a>
        </div>
    <?php
        endif;
    endif;
    ?>

    <?php if (!empty($error)): ?>
        <p class="err"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <div style="margin-top:14px">
        <a class="back-link" href="beranda.php">Kembali ke Beranda</a>
    </div>
</div>

<?php if ($success): ?>
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: <?= json_encode($successMsg) ?>,
        confirmButtonColor: '#E50914',
        allowOutsideClick: false
    }).then(() => {
        // redirect ke beranda setelah user klik OK
        window.location.href = 'beranda.php';
    });
</script>
<?php elseif (!empty($error)): ?>
<script>
    Swal.fire({
        icon: 'error',
        title: 'Gagal Upload',
        text: <?= json_encode($error) ?>,
        confirmButtonColor: '#E50914'
    });
</script>
<?php endif; ?>

</body>
</html>