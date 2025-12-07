<?php
require 'admin_protect.php';

$dataFile = __DIR__ . '/data/transaksi.json';

// basic checks
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: admin_bukti.php');
    exit;
}
if (!isset($_POST['csrf']) || !hash_equals($_SESSION['csrf_token'] ?? '', $_POST['csrf'])) {
    $_SESSION['flash'] = ['type'=>'error','msg'=>'Token keamanan tidak valid.'];
    header('Location: admin_bukti.php');
    exit;
}
$action = $_POST['action'] ?? '';
$id = $_POST['id'] ?? '';

if ($id === '') {
    $_SESSION['flash'] = ['type'=>'error','msg'=>'ID transaksi tidak ditemukan.'];
    header('Location: admin_bukti.php');
    exit;
}

// load data
$data = [];
if (is_file($dataFile)) {
    $raw = file_get_contents($dataFile);
    $tmp = json_decode($raw, true);
    if (is_array($tmp)) $data = $tmp;
}

$found = false;
for ($i=0;$i<count($data);$i++){
    if (isset($data[$i]['id']) && $data[$i]['id'] == $id) {
        $found = true;
        $idx = $i;
        break;
    }
}

if (!$found) {
    $_SESSION['flash'] = ['type'=>'error','msg'=>"Transaksi {$id} tidak ditemukan."];
    header('Location: admin_bukti.php');
    exit;
}

// perform action
$successMsg = '';
switch ($action) {
    case 'verify':
        $data[$idx]['status'] = 'success';
        $successMsg = "Transaksi {$id} diverifikasi.";
        break;

    case 'reject':
        $data[$idx]['status'] = 'rejected';
        $successMsg = "Transaksi {$id} ditandai ditolak.";
        break;

    case 'delete_bukti':
        if (!empty($data[$idx]['bukti'])) {
            $filePath = __DIR__ . '/' . $data[$idx]['bukti'];
            if (is_file($filePath)) @unlink($filePath);
        }
        $data[$idx]['bukti'] = '';
        $data[$idx]['status'] = 'pending';
        $successMsg = "Bukti untuk transaksi {$id} dihapus.";
        break;

    case 'delete_trx':
        if (!empty($data[$idx]['bukti'])) {
            $filePath = __DIR__ . '/' . $data[$idx]['bukti'];
            if (is_file($filePath)) @unlink($filePath);
        }
        array_splice($data, $idx, 1);
        $successMsg = "Transaksi {$id} dihapus.";
        break;

    default:
        $_SESSION['flash'] = ['type'=>'error','msg'=>'Aksi tidak dikenali.'];
        header('Location: admin_bukti.php');
        exit;
}

// simpan
file_put_contents($dataFile, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

$_SESSION['flash'] = ['type'=>'success','msg'=>$successMsg];
header('Location: admin_bukti.php');
exit;
