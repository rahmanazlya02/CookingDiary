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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Page | CookingDiary</title>

    <link rel="stylesheet" href="css/about.css">
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
    <header>
        <img class="logos" src="assets/diary.png" alt="Logo CookingDiary">
        <h1>About Cooking Diary</h1>
        <p>Temukan dan Kumpulkan Resep Makanan Anda</p>
    </header>
    
    <!--------Navbar Start--------->
    <nav id="navbar">
        <div class="nav-icon menu-btn-wrapper">
            <i id="menu-btn" class="menu-btn bx bx-menu"></i>
        </div>
        <ul id="nav-items" class="nav-items">
            <li><a href="index.php" class="nav-links">HOME</a></li>
            <li><a href="about.php"  class="nav-links">ABOUT</a></li>
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

    <section>
        <h2>Mau Masak Apa Hari Ini?</h2>
        <p>Apakah Anda sering kebingungan memilih menu masakan untuk hari ini? Jika iya, jangan khawatir lagi! Kami hadir untuk membantu Anda menemukan inspirasi resep yang lezat 
            dan mudah untuk disajikan setiap harinya. Selamat datang di situs web kami yang penuh dengan beragam resep makanan dari seluruh penjuru dunia. Apapun selera dan keinginan Anda, 
            pasti ada sesuatu yang cocok di sini.</p>
    </section>

    <article>
        <h2>What Can You Do With Cooking Diary??</h2>
        <div class="image-container">
            <img src="assets/lookresep.png" alt="cooking">
            <img src="assets/takefoodpict.png" alt="taking food pict">
        </div>
        <p>Website kami menyediakan fitur-fitur untuk berbagi pengalaman memasak, foto hasil masakan Anda, dan tips masak-memasak dengan sesama pengguna situs kami.</p>
        <ol>
            <li><b>RECIPES: </b>Cari Resep dari resep-resep yang telah diunggah oleh para pengguna Web Cooking Diary</li>
            <li><b>UPLOAD FOOD RECIPES:</b> Tulis resep yang Anda miliki dan unggah bersama foto hasil masakan Anda</li>
            <li><b>MY RECIPE BOOK:</b> Kumpulan resep makanan kreasi Anda setelah mendaftar menjadi anggota situs Cooking Diary</li>
            <li><b>CONTACT:</b> Hubungi kami apabila menemukan kendala atau ingin mengetahui informasi lain terkait situs web Cooking Diary kami ini ya...</li>
        </ol>
        <p>YUKKK, gabung dengan komunitas Cooking Diary yang bersemangat dalam menciptakan dan menikmati hidangan-hidangan lezat kreasi Anda...!</p>
    </article>

    <aside>
        <img src="assets/cookingtogether.png" alt="Search for Recipes">
        <h2>Cobain Resep Terbaru Nih!</h1>
        <p>Apakah Anda bosan dengan menu masakan yang itu-itu saja? Kami punya solusinya! Temukan dan cobalah resep terbaru yang kami hadirkan untuk menginspirasi Anda dalam 
            memasak hidangan-hidangan kreatif dan segar. Situs kami adalah tempat terbaik untuk menemukan ide-ide baru yang akan memikat lidah Anda.</p>
        <img src="assets/foods.png" alt="tasty food"> 
        <p>Jangan lewatkan resep terbaru yang selalu kami update secara berkala. Kunjungi situs kami secara rutin untuk mendapatkan inspirasi masakan terkini dan jadilah yang pertama 
            mencoba kreasi masakan yang sedang tren.</p>
    </aside>

    <footer id="footer">
        <address>Copyright &copy 2024</address>
        <address><a href ="mailto:222212787@stis.ac.id">Created by Nazlya Rahma Susanto (222212787@stis.ac.id)</a>
        </address>    
    </footer>

    <script src="js/myscript.js">
    </script>
</body>
</html>