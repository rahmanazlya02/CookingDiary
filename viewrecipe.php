<?php
require 'functions.php';

//Ambil data di URL
$idresep = $_GET["idresep"];

//query data mahasiswa berdasarkan id 
$recipe = query("SELECT * FROM recipes WHERE idresep = $idresep")[0];


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dish Details</title>
    <!--<link href="../styles/main.css" rel="stylesheet" type="text/css">-->
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
    </div>
</div>

</body>
</html>