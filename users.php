<?php
session_start();
require 'functions.php';

// Cek apakah user sudah login
if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

// Ambil data pengguna dari database
$queryUsers = "SELECT idmember, username, email FROM members";
$users = query($queryUsers);

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/myrecipe.css">
    <title>Daftar Members | CookingDiary</title>
</head>
<body>
    <header>
        <div class="container">
            <div class="logo">
                <h5>Cooking<span> Diary!</span> Recipes</h5>
                </div>
                <nav id = "nav-bar">
                    <ul class="nav-list">
                        <li><a href="index.php" class="nav-links">HOME</a></li>
                        <li><a href="about.php" class="nav-links">ABOUT</a></li>
                        <li><a href="wholerecipes.php" class="nav-links">RECIPES</a></li>
                        <li><a href="upload.php" class="nav-links">UPLOAD FOOD RECIPES</a></li>
                        <li><a href="myrecipe6.php" class="nav-links">MY RECIPE BOOK</a></li>
                        <li><a href="#footer" class="nav-links">CONTACT</a></li>
                    </ul>
                </nav>
        </div>
    </header>
    <br><br><br><br>
    <img class="logos" src="assets/diary.png" alt="Logo CookingDiary">
    <h1>Daftar Members Cooking Diary</h1>
    <div class="button-container-users">
        <a href="myrecipe6.php" class="button">Back to Recipes</a>
    </div>
    <form action="" method="post">
    <div id="container-users">
        <table border="1" cellpadding="10" cellspacing="0">
            <tr>
                <th width="10">No.</th>
                <th>ID User</th>
                <th>Username</th>
                <th>Email</th>
            </tr>
            <?php $i = 1; ?>
            <?php foreach ($users as $user) : ?>
            <tr>
                <td class="nomor"><?= $i;?>.</td>
                <td><a href="myrecipe6.php?idmember=<?= $user['idmember']; ?>"><?= $user['idmember']; ?></a></td>
                <td><a href="myrecipe6.php?idmember=<?= $user['idmember']; ?>"><?= $user['username']; ?></a></td>
                <td><a href="mailto:<?= $user['email']; ?>"><?= $user['email']; ?></a></td>
            </tr>
            <?php $i++; ?>
            <?php endforeach; ?>
        </table>
    </div>
    </form>
    <footer id="footer">
            <div>
                <address>Copyright &copy 2024 Cooking Diary</address>
                <address><a href ="mailto:222212787@stis.ac.id">Created by Nazlya Rahma Susanto (222212787@stis.ac.id)</a>
            </div>
    </footer>
</body>
</html>
