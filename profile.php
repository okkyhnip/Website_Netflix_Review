<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Profil - NetflixReview+</title>
    <style>
        body {
            background: #000;
            color: white;
            font-family: Arial;
            text-align: center;
            padding-top: 80px;
        }
        .form-box {
            background: #222;
            padding: 25px;
            border-radius: 10px;
            width: 350px;
            margin: auto;
        }
        img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            margin-bottom: 10px;
            object-fit: cover;
        }
        input[type="text"], input[type="file"] {
            width: 90%;
            padding: 10px;
            margin: 10px 0;
            background: #333;
            border: none;
            color: white;
            border-radius: 5px;
        }
        button {
            width: 100%;
            background: red;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }
        a { color: #ccc; text-decoration:none; display:block; margin-top:10px; }
    </style>
</head>
<body>

<h2>Edit Profil Kamu</h2>

<div class="form-box">
    <form action="profile_save.php" method="POST" enctype="multipart/form-data">
        
        <!-- Avatar Preview -->
        <?php
        $avatar = isset($_SESSION['avatar']) ? $_SESSION['avatar'] : "default.jpg";
        ?>
        <img src="avatars/<?php echo $avatar; ?>" alt="Avatar">


        <!-- Upload Avatar -->
        <br><label style="font-size:14px;">Ganti Foto Profil:</label></br>
        <input type="file" name="avatar" accept="image/*">

        <!-- Username Update -->
        <label style="font-size:14px;">Ganti Username:</label>
        <input type="text" name="username" value="<?php echo $_SESSION['username']; ?>" required>

        <button type="submit">Simpan Perubahan</button>
        <a href="beranda.php">Batal</a>
    </form>
</div>

</body>
</html>