<?php

require 'functions.php'; //artinya manggil file function atau bisa juga include

//untuk menentukan apa yang tampil di database
/// Persiapkan query untuk menampilkan semua resep
$query = "SELECT * FROM recipes ORDER BY idresep DESC";

// Persiapkan statement
$stmt = mysqli_prepare($conn, $query);

// Eksekusi statement
mysqli_stmt_execute($stmt);

// Ambil hasil query
$result = mysqli_stmt_get_result($stmt);
$recipes = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Tombol cari ditekan
if (isset($_POST["search"])) {
    $keyword = $_POST["keyword"];
    $recipes = search($keyword);
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/wholerecipes.css">
        <title>Recipes-Cooking Diary</title>
    </head>
    <body>
        <header>
            <div class="container">
                <div class="logo">
                    <h5>Cooking<span> Diary!</span> Recipes</h5>
                </div>
                <nav>
                    <ul class="nav-list">
                        <li><a href="index.php" class="nav-links">HOME</a></li>
                        <li><a href="about.php" target="_blank" class="nav-links">ABOUT</a></li>
                        <li><a href="wholerecipes.php" target="_blank" class="nav-links">RECIPES</a></li>
                        <li><a href="upload.php" target="_blank" class="nav-links">UPLOAD FOOD RECIPES</a></li>
                        <li><a href="myrecipe6.php" target="_blank" class="nav-links">MY RECIPE BOOK</a></li>
                        <li><a href="#footer" class="nav-links">CONTACT</a></li>
                    </ul>
                </nav>
            </div>
        </header>

        <section class="hero">
            <div class="hero-section">
                <h2>Welcome to Our Recipe Collection!</h2>
                <p>Cari Berbagai Resep untuk Kreasi Makananmu Disini...</p>

                <form action="" method="post" class="search-box">
                    <input type="text" name = "keyword"id="keyword" autofocus placeholder="Mau Cari Resep Apa??" autocomplete="off">
                    <button type="submit" name="search" id="searching-button"></button>
                </form>
            </div>
        </section>  

        <!--Recipe Section-->
        <section id="container-wholerecipes" class="recipes">
            <h1>Featured Recipes</h1>
            <div class="recipe-section">
            <?php $i = 1; ?>
            <?php foreach($recipes as $row) :?>
                <div class="recipe-card">
                    <img src="image/<?= $row["foodpict"]; ?>" alt="<?= $row["judulresep"]; ?>">
                    <h2><?= $row["judulresep"]; ?></h2>
                    <p><?= $row["tipefood"]; ?></p>
                    <a href="viewrecipe.php?idresep=<?= $row["idresep"];?>">View Recipe</a>
                </div>
            <?php $i++; ?>
            <?php endforeach; ?>
            </div>
            
        </section>

        <footer id="footer">
            <div>
                <address>Copyright &copy 2024 Cooking Diary</address>
                <address><a href ="mailto:222212787@stis.ac.id">Created by Nazlya Rahma Susanto (222212787@stis.ac.id)</a>
            </div>
        </footer>
        <script src="js/wholerecipes.js"></script>
    </body>
</html>