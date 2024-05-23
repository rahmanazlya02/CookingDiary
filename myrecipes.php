<?php
session_start();
require 'functions.php';
// Periksa apakah session "username" telah terdefinisi
$username = isset($_SESSION["username"]) ? $_SESSION["username"] : "";

// Ambil keyword pencarian dari parameter GET
$keyword = isset($_GET["keyword"]) ? $_GET["keyword"] : "";
$idmember = $_SESSION["idmember"];

// Cek apakah pengguna adalah admin
//$username = $_SESSION["username"];
$isAdmin = ($username == "adminCookDy" && $_SESSION["password"] == "adminCookDy1");

// Buat query berdasarkan peran pengguna
if ($isAdmin) {
    // Jika admin, cari resep dari seluruh pengguna
    $query = "SELECT recipes.*, members.username 
            FROM recipes 
            JOIN members ON recipes.idmember = members.idmember
            WHERE
            (recipes.judulresep LIKE ? OR 
            recipes.timecook LIKE ? OR
            recipes.tipefood LIKE ? OR 
            recipes.bahanresep LIKE ?)";
} else {
    // Jika bukan admin, cari resep hanya dari pengguna yang login
    $query = "SELECT * FROM recipes WHERE
                (judulresep LIKE ? OR 
                timecook LIKE ? OR
                tipefood LIKE ? OR 
                bahanresep LIKE ?) AND 
                idmember = ?";
}

// Eksekusi query dengan prepared statement
$stmt = mysqli_prepare($conn, $query);
$searchTerm = "%$keyword%"; // Add wildcard for LIKE comparison
if ($isAdmin) {
    mysqli_stmt_bind_param($stmt, "ssss", $searchTerm, $searchTerm, $searchTerm, $searchTerm);
} else {
    mysqli_stmt_bind_param($stmt, "ssssi", $searchTerm, $searchTerm, $searchTerm, $searchTerm, $idmember);
}
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$recipes = mysqli_fetch_all($result, MYSQLI_ASSOC);

?>

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