<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit();
}

$upload_folder = "avatars/";
$allowed_types = ['jpg', 'jpeg', 'png', 'gif'];

// Update Username
if (!empty($_POST['username'])) {
    $_SESSION['username'] = htmlspecialchars($_POST['username']);
}

// Upload Avatar Jika Ada File Diupload
if (!empty($_FILES['avatar']['name'])) {
    $ext = strtolower(pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION));

    if (in_array($ext, $allowed_types)) {
        $new_name = "avatar_" . time() . ".$ext";
        $target = $upload_folder . $new_name;

        if (move_uploaded_file($_FILES['avatar']['tmp_name'], $target)) {
            $_SESSION['avatar'] = $new_name;
        }
    }
}

header("Location: beranda.php");
exit();
?>
