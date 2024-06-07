<?php
require 'functions.php';

//Ambil data di URL
$idresep = $_GET["idresep"];

//query data resep berdasarkan id 
$recipe = query("SELECT recipes.*, members.email AS email
                 FROM recipes
                 JOIN members ON members.idmember = recipes.idmember
                 WHERE recipes.idresep = $idresep")[0];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="cooking, cooking diary, food recipes, food, dish, masak, resep, resep makanan">
    <meta name="description" content="Cooking Diary web">
    <title>Dish Details | CookingDiary</title>
    <link rel="icon" type="image/png" href="assets/diary.png">
    <link rel="stylesheet" href="css/viewrecipe.css">
</head>
<body>

<div class="container">
        <div class="recipe-card">
            <h1 class="recipe-title"><?php echo $recipe['judulresep']; ?></h1>
            <div class="image-container">
            <img class="recipe-image" src="image/<?php echo $recipe['foodpict']; ?>" alt="Dish Image">
            </div>
            <h2 style="font-size: 22px;">Recipe Detail </h2>
            <div class="recipe-info">
                <span><?php echo $recipe['timecook']; ?></span>
                <span><?php echo $recipe['tipefood']; ?></span>
            </div>
            <div class="recipe-content">
            <h3 class="text-blue-600">Ingredients :</h3>
                <p>
                    <?php echo $recipe['bahanresep']; ?>
                </p>
            <h3 class="text-blue-600 mt-4">Directions :</h3>
            <p>
                <?php echo $recipe['petunjuk']; ?>
            </p>
        </div>
        <div class="recipe-member">
            <h3>Recipe by :</h3>
            <p><a href="mailto:<?= $recipe['email']; ?>"><?= $recipe['email']; ?></a></p>
        </div>
    </div>
</div>

</body>
</html>
