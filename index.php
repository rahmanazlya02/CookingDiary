<?php
require 'functions.php'; //artinya manggil file function atau bisa juga include

//untuk menentukan apa yang tampil di database
//order by desc agar yg tmpil duluan itu yg terakhir diinputkan
$recipes = query("SELECT * FROM recipes ORDER BY idresep DESC");

//tombol cari ditekan
if (isset($_POST["search"])) {
    $keyword = $_POST["keyword"];
    $recipes = search($keyword);
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE-edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="keywords" content="cooking, cooking diary, food recipes, food, dish, masak, resep, resep makanan">
        <meta name="description" content="Cooking Diary web">
        <title>Cooking Diary Web</title>
        <link rel="icon" type="image/png" href="assets/diary.png">
        <!-----------Local Stylesheet Link----------->
        <link rel="stylesheet" href="css/indexstyle.css">
        <!-----------BoxIcon Stylesheet Link----------->
        <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    </head>

    <body>
        <header>
            <!-------PreNav Text Start-------->
            <div id="prenav-text">
                <div class="flex-row">
                    <div class="contact-info">Phone no: <span>+00 1234 567</span> or email us at: 
                        <span><a href ="mailto:222212787@stis.ac.id">222212787@stis.ac.id</a>
                        </span>
                    </div>
                </div>
            </div>
            <!-------Navbar Start-------->
            <nav id="navbar" class="navbar flex-row">
                <div class="nav-icon menu-btn-wrapper">
                    <i id="menu-btn" class="menu-btn bx bx-menu"></i>
                </div>
    
                <div class="logo">
                    <h5>Cooking<span> Diary!</span></h5>
                </div>
                <ul id="nav-items" class="nav-items">
                    <li><a href="index.php" class="nav-links">HOME</a></li>
                    <li><a href="about.php" class="nav-links">ABOUT</a></li>
                    <li><a href="wholerecipes.php" class="nav-links">RECIPES</a></li>
                    <li><a href="upload.php" class="nav-links">UPLOAD FOOD RECIPES</a></li>
                    <li><a href="myrecipe6.php" class="nav-links">MY RECIPE BOOK</a></li>
                    <li><a href="#footer" class="nav-links">CONTACT</a></li>
                </ul>

                <ul class="nav-btns">
                    <div class="search-btn-wrapper nav-icon">
                        <i class="searchbtn bx bx-search-alt-2"></i>
                        <div id="search-form" class="search-form">
                            <form action="wholerecipes.php" method="post">
                                <input type="search" name="keyword" class="search-data" placeholder="Mau cari resep apa?" autocomplete="off">
                                <button type="submit" name="search" class="bx bx-search-alt-2"></button>
                            </form>
                        </div>
                    </div>

                    <div class="nav-icon">
                        <i class="darkbtn bx bx-moon"></i>
                    </div>
                </ul>
            </nav>
            <!--------Navbar End--------->
        </header>

        <!------Home Section------>
        <section id="home">
            <div class="homepart">
                <div class="slide slide1">
                    <div class="content">
                        <p class="sub-heading">Your Food Recipe Collection</p>
                        <h1 class="heading">COOKING DIARY</h1>
                        <p class="sub-heading">Make Your Own Food Creation!</p>
                    </div>
                </div>
            </div>
        </section>

        <footer id="footer">
            <div>
                <address>Copyright &copy 2024 Cooking Diary</address>
                <address><a href ="mailto:222212787@stis.ac.id">Created by Nazlya Rahma Susanto (222212787@stis.ac.id)</a>
            </div>
        </footer>

        <script src="js/myscript.js">
        </script>
    </body>
</html>