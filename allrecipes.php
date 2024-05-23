<?php
require 'functions.php';
$keyword = $_GET["keyword"];
$query = "SELECT * FROM recipes WHERE
        judulresep LIKE ? OR 
        timecook LIKE ? OR
        tipefood LIKE ? OR 
        bahanresep LIKE ?
        ";

// Persiapkan statement
$stmt = mysqli_prepare($conn, $query);

// Bind parameter ke query
$keyword_like = "%$keyword%";
mysqli_stmt_bind_param($stmt, "ssss", $keyword_like, $keyword_like, $keyword_like, $keyword_like);

// Eksekusi statement
mysqli_stmt_execute($stmt);

// Ambil hasil query
$result = mysqli_stmt_get_result($stmt);
$recipes = mysqli_fetch_all($result, MYSQLI_ASSOC);

?>

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