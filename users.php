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
                <td><?= $user['email']; ?></td>
            </tr>
            <?php $i++; ?>
            <?php endforeach; ?>
        </table>
    </div>
    </form>
</body>
</html>
