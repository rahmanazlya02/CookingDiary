<?php
session_start();
require 'functions.php';
//$idmember = $_SESSION["idmember"];

if( !isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

//cek apakah tombol submit sudah ditekan atau bellum
if( isset($_POST["submit"]) ) {
    //tambah($_POST);
    //cek apakah data berhasil ditambahkan atau tidak
    if(tambah($_POST) > 0) {
        echo "
            <script>
                alert('data berhasil ditambahkan');
                document.location.href='myrecipe6.php';
            </script>
        ";
    } else {
        echo "
            <script>
                alert('data gagal ditambahkan');
                document.location.href='myrecipe6.php';
            </script>
    ";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resep Makanan</title>
    <link rel="stylesheet" href="css/upload.css">
</head>
<body>
    <div class="container">
        <h1>Upload Resep Makanan Kreasi Anda</h1>

        <!-- Formulir Tambah Resep -->
        <div class="form-container">
            <form action="" method="post" enctype="multipart/form-data" id="formTambahResep" >
                <label for="judulresep">Judul Resep:</label>
                <input type="text" id="judulresep" name="judulresep" required><br><br>
                <label for="timecook">Waktu Memasak (menit):</label>
                <input type="text" id="timecook" name="timecook" required><br><br>
                <label for="tipefood">Tipe Makanan:</label>
                <input type="text" id="tipefood" name="tipefood" required><br><br>
                <label for="bahanresep">Bahan-bahan:</label>
                <textarea id="bahanresep" name="bahanresep" rows="2" required></textarea><br><br>
                <label for="petunjuk">Petunjuk:</label>
                <textarea id="petunjuk" name="petunjuk" rows="3" required></textarea><br><br>
                <label for="foodpict">Gambar Resep:</label>
                <input type="file" id="foodpict" name="foodpict"><br><br>
                <button type="submit" name="submit">Upload Resep</button>
            </form>
        </div>
    </div>

</body>
</html>