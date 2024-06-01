<?php

session_start();

if( !isset($_SESSION["login"]) ) {
    header("Location: login.php");
    exit;
}

require 'functions.php';

//Ambil data di URL
$idresep = $_GET["idresep"];

// Query data resep berdasarkan id
$resep = query("SELECT * FROM recipes WHERE idresep = ?", "i", array($idresep))[0];

//cek apakah tombol submit sudah ditekan atau bellum
if( isset($_POST["submit"]) ) {

    //cek apakah data berhasil diubah atau tidak
    if(ubah($_POST) > 0) {
        echo "
            <script>
                alert('data berhasil diubah!');
                document.location.href='myrecipe6.php';
            </script>
        ";
    } else {
        echo "
            <script>
                alert('data gagal diubah!');
                document.location.href='myrecipe6.php';
            </script>
    ";
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Edit Resep Makanan</title>
        <link rel="stylesheet" href="css/upload.css">
        
    </head>

    <body>
        <header>
        <div class="container-header">
            <div class="logo">
                <h5>Cooking<span> Diary!</span></h5>
            </div>
            <nav id="nav-bar">
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
        <div id="main-content">
            <div class="container">
        <h1>Edit Resep Makanan</h1>

            <div class="form-container">
                <form action="" method="post" enctype="multipart/form-data">
                <input type="hidden" name="idresep" value="<?=$resep["idresep"]; ?>">
                <input type="hidden" name="oldPict" value="<?=$resep["foodpict"]; ?>">
            
                <label for="judulresep">Judul Resep: </label>
                <input type="text" name="judulresep" id="judulresep" required 
                    value = "<?= $resep["judulresep"]; ?>"><br><br>

                <label for="timecook">Durasi Memasak (menit): </label>
                <input type="text" name="timecook" id="timecook" required
                    value = "<?= $resep["timecook"]; ?>"><br><br>

                <label for="tipefood">Tipe Makanan: </label>
                <input type="text" name="tipefood" id="tipefood" required
                    value = "<?= $resep["tipefood"]; ?>"><br><br>

                <label for="bahanresep">Bahan-Bahan: </label>
                <textarea name="bahanresep" id="bahanresep" required
                    rows="3" cols="60"><?= $resep["bahanresep"]; ?></textarea><br><br>

                <label for="petunjuk">Petunjuk: </label>
                <textarea name="petunjuk" id="petunjuk" required
                    rows="5" cols="60"><?= $resep["petunjuk"]; ?></textarea><br><br>

                <label for="foodpict">Foto Makanan: </label>
                <img src="image/<?= $resep['foodpict']; ?>" width="100"><br>
                <input type="file" name="foodpict" id="foodpict"><br><br>

                <button type="submit" name="submit">Simpan Edit Resep</button>
                </form>
            </div>
            </div>
        </div>
        <footer id="footer">
            <div>
                <address>Copyright &copy 2024 Cooking Diary</address>
                <address><a href ="mailto:222212787@stis.ac.id">Created by Nazlya Rahma Susanto (222212787@stis.ac.id)</a>
            </div>
        </footer>
    </body>
</html>