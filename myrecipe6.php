<?php

session_start();
require 'functions.php'; //artinya manggil file function atau bisa juga include

// Cek apakah cookie ada dan valid
if(!isset($_SESSION["login"]) && isset($_COOKIE['id']) && isset($_COOKIE['key'])) {
    $id = $_COOKIE['id'];
    $key = $_COOKIE['key'];

    // Ambil username berdasarkan id
    $query = "SELECT username FROM members WHERE idmember = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);

    // Cek cookie dan username
    if($key === hash('sha256', $row['username'])) {
        $_SESSION['login'] = true;
        $_SESSION["username"] = $row['username'];
        $_SESSION["idmember"] = $id;
    }
}

if( !isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

// Inisialisasi variabel $keyword
$keyword = isset($_POST["keyword"]) ? $_POST["keyword"] : "";

// Cek apakah user adalah admin
$username = $_SESSION["username"];
// Verifikasi status admin
$isAdmin = ($username == "adminCookDy" && isset($_SESSION["password"]) && $_SESSION["password"] == "adminCookDy1");
//$isAdmin = ($_SESSION["username"] == "adminCookDy" && isset($_COOKIE['key']) && $_COOKIE['key'] === hash('sha256', "admincookdy"));
// Mengambil jumlah member dari tabel members
$queryTotalMembers = "SELECT COUNT(*) AS total FROM members";
$stmtTotalMembers = mysqli_prepare($conn, $queryTotalMembers);
mysqli_stmt_execute($stmtTotalMembers);
$resultTotalMembers = mysqli_stmt_get_result($stmtTotalMembers);
$totalMembers = mysqli_fetch_assoc($resultTotalMembers)['total'];

if ($isAdmin) {
    // Mengurangi jumlah member jika user adalah admin
    $totalMembers--;
}

if ($isAdmin) {
    // Debugging untuk admin
    error_log("Admin logged in: displaying all recipes");
   // Jika admin, ambil semua resep
   if ($keyword) {
       $recipes = search($keyword);
   } else {
       $queryAllRecipes = "SELECT * FROM recipes JOIN members ON members.idmember = recipes.idmember ORDER BY idresep DESC";
       $recipes = query($queryAllRecipes);
   }
   $queryTotalRecipes = "SELECT COUNT(*) AS total FROM recipes";
   $stmtTotalRecipes = mysqli_prepare($conn, $queryTotalRecipes);
   mysqli_stmt_execute($stmtTotalRecipes);
   $resultTotalRecipes = mysqli_stmt_get_result($stmtTotalRecipes);
   $totalRecipes = mysqli_fetch_assoc($resultTotalRecipes)['total'];
   //$totalMembers = query("SELECT COUNT(*) AS total FROM members")[0]['total'];
} else {
    // Debugging untuk user
    error_log("User logged in: displaying user's recipes");
    //untuk menentukan apa yang tampil di database
    //order by desc agar yg tmpil duluan itu yg terakhir diinputkan
    $idmember = $_SESSION["idmember"];
    if ($keyword) {
        $recipes = searchmy($keyword);
    } else {
        $queryUserRecipes = "SELECT * FROM recipes JOIN members ON members.idmember = recipes.idmember WHERE members.idmember = ? ORDER BY idresep DESC";
        $stmtUserRecipes = mysqli_prepare($conn, $queryUserRecipes);
        mysqli_stmt_bind_param($stmtUserRecipes, "i", $idmember);
        mysqli_stmt_execute($stmtUserRecipes);
        $recipes = mysqli_stmt_get_result($stmtUserRecipes);
    }
    $queryTotalUserRecipes = "SELECT COUNT(*) AS total FROM recipes WHERE idmember = ?";
    $stmtTotalUserRecipes = mysqli_prepare($conn, $queryTotalUserRecipes);
    mysqli_stmt_bind_param($stmtTotalUserRecipes, "i", $idmember);
    mysqli_stmt_execute($stmtTotalUserRecipes);
    $resultTotalUserRecipes = mysqli_stmt_get_result($stmtTotalUserRecipes);
    $totalRecipes = mysqli_fetch_assoc($resultTotalUserRecipes)['total'];
    //$totalMembers = 1; // Hanya 1 member yaitu user yang login
}

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/myrecipe.css">
        <title>Daftar Resep</title>
    </head>

    <body>
        <br>
        <h1><?= $_SESSION["username"];?>'s Recipes Book</h1>
        <br>

        <form action="" method="post">
            <input type="text" name="keyword" size="35" autofocus
            placeholder="Cari Resep Buatanku" autocomplete="off" id="keyword">
            <button type="submit" name="searchmy" id="mysearch-button"></button>
            <br>
        </form>

        <div class="button-container">
            <a href="logout.php" class="button">Logout</a>
            <a href="upload.php" class="button">Upload</a>
        </div>

        <!-- Menampilkan ringkasan -->
        <?php if ($isAdmin) : ?>
        <div class="summary">
            <p>Total Recipes: <?= $totalRecipes; ?></p>
            <p>Total Members: <?= $totalMembers; ?></p>
        </div> 
        <?php else : ?>
        <div class="summary">
            <p>Total Recipes: <?= $totalRecipes; ?></p>
        </div>
        <?php endif; ?>

        <div id="container-myrecipe">
        <table border="1" cellpadding="10" cellspacing="0">
            <tr>
                <th>No.</th>
                <?php if ($isAdmin) : ?>
                    <th>Member ID</th> <!-- Hanya tampil jika admin -->
                    <th>Username</th>
                <?php endif; ?>
                <th>Recipe Name</th>
                <th>Cooking Time</th>
                <th>Food Category</th>
                <th width="150">Ingredients</th>
                <th width="300">Directions</th>
                <th>Recipe Image</th>
                <th>Aksi</th>
            </tr>
            <?php $i = 1; ?>
            <?php foreach( $recipes as $row ) : ?>
            <!--foreach untuk looping array-->
            <tr>
                <td class="nomor"><?= $i;?>.</td>
                <?php if ($isAdmin) : ?>
                    <td><?= $row["idmember"]; ?></td>
                    <td><?= $row["username"]; ?></td> <!-- Hanya tampil jika admin -->
                <?php endif; ?>
                <td><?= $row["judulresep"]; ?></td>
                <td><?= $row["timecook"]; ?></td>
                <td><?= $row["tipefood"]; ?></td>
                <td><?= $row["bahanresep"]; ?></td>
                <td><?= $row["petunjuk"]; ?></td>
                <td>
                    <img src="image/<?= $row["foodpict"]; ?>" width="100">
                </td>
                <td>
                    <a href="viewrecipe.php?idresep=<?= $row["idresep"];?>"><img src='assets/view.png' 
                    style='width:30px;height:30px;'></a>
                    <a href="ubah.php?idresep=<?= $row["idresep"];?>"><img src='assets/edit.png' 
                    style='width:30px;height:30px;'></a>
                    <a href="hapus.php?idresep=<?= $row["idresep"]; ?>" onclick="
                    return confirm('yakin hapus resep?');"><img src='assets/remove.png' 
                    style='width:27px;height:27px;'></a>
                </td>
            </tr>
            <?php $i++; ?>
            <?php endforeach; ?>
        </table>
        </div>
        <script src="js/myrecipes.js"></script>
    </body>
</html>
