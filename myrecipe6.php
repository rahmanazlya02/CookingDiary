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
$idmember = null; // Inisialisasi $idmember dengan null

// Cek apakah parameter idmember ada di URL
if (isset($_GET['idmember'])) {
    $idmember = intval($_GET['idmember']);
}

// Cek apakah user adalah admin
$username = $_SESSION["username"];
// Verifikasi status admin
//$isAdmin = ($_SESSION["username"] == "adminCookDy");
$isAdmin = ($_SESSION["username"] == "adminCookDy" && isset($_COOKIE['key']) && $_COOKIE['key'] === hash('sha256', "admincookdy"));
// Mengambil jumlah member dari tabel members
$queryTotalMembers = "SELECT COUNT(*) AS total FROM members";
$stmtTotalMembers = mysqli_prepare($conn, $queryTotalMembers);
mysqli_stmt_execute($stmtTotalMembers);
$resultTotalMembers = mysqli_stmt_get_result($stmtTotalMembers);
$totalMembers = mysqli_fetch_assoc($resultTotalMembers)['total'];

if ($isAdmin) {
    // Debugging untuk admin
    error_log("Admin logged in: displaying all recipes");
   // Jika admin dan ada idmember di URL, ambil resep dari pengguna tersebut
   if ($idmember) {
    $queryUserRecipes = "SELECT recipes.*, members.username FROM recipes JOIN members ON members.idmember = recipes.idmember WHERE recipes.idmember = ? ORDER BY idresep DESC";
    $stmtUserRecipes = mysqli_prepare($conn, $queryUserRecipes);
    mysqli_stmt_bind_param($stmtUserRecipes, "i", $idmember);
    mysqli_stmt_execute($stmtUserRecipes);
    $recipes = mysqli_stmt_get_result($stmtUserRecipes);
    } elseif ($keyword) {
    $recipes = search($keyword);
    } else { // Jika admin, ambil semua resep
        $queryAllRecipes = "SELECT recipes.*, members.username FROM recipes JOIN members ON members.idmember = recipes.idmember ORDER BY idresep DESC";
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
        $queryUserRecipes = "SELECT recipes.*, members.username FROM recipes JOIN members ON members.idmember = recipes.idmember WHERE members.idmember = ? ORDER BY idresep DESC";
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
        <header>
        <div class="container">
            <div class="logo">
                <h5>Cooking<span> Diary!</span></h5>
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
            <?php if ($isAdmin) : ?>
            <a href="users.php" class="button">Users</a>
            <?php endif; ?>
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
                <th width="50">No.</th>
                <?php if ($isAdmin) : ?>
                    <th>Member ID</th> <!-- Hanya tampil jika admin -->
                    <th>Username</th>
                <?php endif; ?>
                <th width="120">Recipe Name</th>
                <th width="100">Cooking Time</th>
                <th width="120">Food Category</th>
                <th width="350">Ingredients</th>
                <th width="350">Directions</th>
                <th width="150">Recipe Image</th>
                <th width="50">Aksi</th>
            </tr>
            <?php $i = 1; ?>
            <?php foreach( $recipes as $row ) : ?>
            <!--foreach untuk looping array-->
            <tr>
                <td class="center-content"><?= $i;?>.</td>
                <?php if ($isAdmin) : ?>
                    <td class="center-content"><?= $row["idmember"]; ?></td>
                    <td class="center-content"><?= isset($row["username"]) ? $row["username"] : 'N/A'; ?></td> <!-- Hanya tampil jika admin -->
                <?php endif; ?>
                <td class="center-content"><?= $row["judulresep"]; ?></td>
                <td class="center-content"><?= $row["timecook"]; ?></td>
                <td class="center-content"><?= $row["tipefood"]; ?></td>
                <td class="justify-content"><?= $row["bahanresep"]; ?></td>
                <td class="justify-content"><?= $row["petunjuk"]; ?></td>
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
        <footer id="footer">
            <div>
                <address>Copyright &copy 2024 Cooking Diary</address>
                <address><a href ="mailto:222212787@stis.ac.id">Created by Nazlya Rahma Susanto (222212787@stis.ac.id)</a>
            </div>
        </footer>
        <script src="js/myrecipes.js"></script>
    </body>
</html>
