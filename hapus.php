<?php

session_start();

if( !isset($_SESSION["login"]) ) {
    header("Location: login.php");
    exit;
}

require 'functions.php';

$idresep = $_GET["idresep"];

if(hapus($idresep) > 0) {
    echo "
    <script>
        alert('data berhasil dihapus');
        document.location.href='myrecipe6.php';
    </script>
    ";
} else {
    echo "
    <script>
        alert('data gagal dihapus');
        document.location.href='myrecipe6.php';
    </script>
";
}

?>