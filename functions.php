<?php
//koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "cookingdiary");

function query($query, $types = null, $params = null) {
    global $conn;
    $stmt = mysqli_prepare($conn, $query);

    if ($types && $params) {
        // Bind parameters
        mysqli_stmt_bind_param($stmt, $types, ...$params);
    }

    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);

    return $rows;
}

function tambah($data) {
    global $conn;
    //ambil data dari tiap elemen dalam form
    $judulresep = htmlspecialchars($data["judulresep"]);
    $timecook = htmlspecialchars($data["timecook"]);
    $tipefood = htmlspecialchars($data["tipefood"]);
    $bahanresep = htmlspecialchars($data["bahanresep"]);
    $petunjuk = htmlspecialchars($data["petunjuk"]);
    $idmember = $_SESSION["idmember"];
        
    //upload gambar
    $foodpict = upload();
    if( !$foodpict ) {
        return false;
    }    

    //query insert data dengan prepared statement
    $query = "INSERT INTO recipes (judulresep, timecook, tipefood, bahanresep, petunjuk, foodpict, idmember) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ssssssi", $judulresep, $timecook, $tipefood, $bahanresep, $petunjuk, $foodpict, $idmember);
    mysqli_stmt_execute($stmt);    

    return mysqli_stmt_affected_rows($stmt);
}

function upload(){
    $namaFile = $_FILES['foodpict']['name'];
    $ukuranFile = $_FILES['foodpict']['size'];
    $eror = $_FILES['foodpict']['error'];
    $tmpName = $_FILES['foodpict']['tmp_name'];

    //cek apakah tidak ada gambar diupload
    //4 u=itu untuk tidak ada gambar yg diupload
    if( $eror === 4 ){
        echo "<script>
                alert('Pilih Gambar Terlebih Dahulu');
             </script>";
        return false;
    }

    //cek apakah yg diupload itu gambar atau bukan 
    //jdi yg boleh diupload hanya ekstensi gambar
    $ekstensiPictValid = ['jpg','jpeg','png'];
    //$ekstensiPict = explode('.',$namaFile);
    $ekstensiPict = pathinfo($namaFile, PATHINFO_EXTENSION);
    //$ekstensiPict = strtolower(end($ekstensiPict));
    if( !in_array(strtolower($ekstensiPict), $ekstensiPictValid) ) {
        echo "<script>
                alert('Periksa kembali ekstensi gambar Anda!');
             </script>";
        return false;
    }

    //cek jika ukurannya terlalu besar 
    if($ukuranFile > 5000000) {
        echo "<script>
                alert('Ukuran Gambar terlalu Besar! Maksimal 5MB.');
             </script>";
        return false;
    }

    //lolos pengecekan, gambar siap diupload
    //generate nma gmbar baru
    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $ekstensiPict;
    move_uploaded_file($tmpName, 'image/'. $namaFileBaru);

    return $namaFileBaru;

}


function hapus($idresep) {
    global $conn;
    $result = mysqli_query($conn, "SELECT foodpict FROM recipes WHERE idresep = $idresep");
    $file = mysqli_fetch_assoc($result);
    $namaFile = implode('.',$file);
    $location = "image/$namaFile";
    if(file_exists($location)) {
        unlink('image/'.$namaFile);
    }
    mysqli_query($conn, "DELETE FROM recipes WHERE idresep= $idresep");
    header("Location: myrecipe6.php");
    exit;
    return mysqli_affected_rows($conn);
}

function ubah($data) {
    global $conn;
    //ambil data dari tiap elemen dalam form
    $idresep = $data["idresep"];
    $judulresep = htmlspecialchars($data["judulresep"]);
    $timecook = htmlspecialchars($data["timecook"]);
    $tipefood = htmlspecialchars($data["tipefood"]);
    $bahanresep = htmlspecialchars($data["bahanresep"]);
    $petunjuk = htmlspecialchars($data["petunjuk"]);
    $oldPict = htmlspecialchars($data["oldPict"]);    

    //cek apakah user pilih gambar baru atau tidak
    if ($_FILES['foodpict']['error']===4) {
        $foodpict = $oldPict;
    } else {
        $result = mysqli_query($conn, "SELECT foodpict FROM recipes WHERE idresep = $idresep");
        $file = mysqli_fetch_assoc($result);
        $namaFile = implode('.', $file);
        unlink('image/'.$namaFile);
        $foodpict = upload();
    }    

    //query update data dengan prepared statement
    $query = "UPDATE recipes SET judulresep = ?, timecook = ?, tipefood = ?, bahanresep = ?, petunjuk = ?, foodpict = ? WHERE idresep = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ssssssi", $judulresep, $timecook, $tipefood, $bahanresep, $petunjuk, $foodpict, $idresep);
    mysqli_stmt_execute($stmt);

    return mysqli_stmt_affected_rows($stmt);
}

function search($keyword) {
    $query = "SELECT * FROM recipes WHERE
                judulresep LIKE '%$keyword%' OR 
                timecook LIKE '%$keyword%' OR
                tipefood LIKE '%$keyword%' OR 
                bahanresep LIKE '%$keyword%'
             ";
    return query($query);
}

function searchmy($keyword) {
    $idmember = $_SESSION["idmember"];
    $query = "SELECT * FROM recipes WHERE
                (judulresep LIKE '%$keyword%' OR 
                timecook LIKE '%$keyword%' OR
                tipefood LIKE '%$keyword%' OR 
                bahanresep LIKE '%$keyword%') AND
                idmember = $idmember
             ";
    return query($query);
}

function registrasi($data) {
    global $conn;

    $username = strtolower(stripslashes($data["username"]));
    $email = htmlspecialchars($data["email"]);
    $password = mysqli_real_escape_string($conn, $data["password"]);
    $password2 = mysqli_real_escape_string($conn, $data["password2"]);

    // Validasi email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>
                alert('Email tidak valid! Harap masukkan email yang benar.');
             </script>";
        return false;
    }
   
    //cek username sudah ada atau belum
    $query = "SELECT username FROM members WHERE username = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    if (mysqli_stmt_num_rows($stmt) > 0) {
        echo "<script>
                alert('Username yang dipilih sudah terdaftar! Coba username Lain.');
            </script>";
        return false;
    }

    //cek konfirmasi password
    if ($password !== $password2) {
        echo "<script>
                alert('Konfirmasi Password tidak sesuai! Harap Periksa Kembali');
            </script>";
        return false;
    } 

    //amankan password
    $password = password_hash($password, PASSWORD_DEFAULT);
    
    //tambahkan user baru ke database
    $query = "INSERT INTO members (username, email, password) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "sss", $username, $email, $password);
    mysqli_stmt_execute($stmt);

    return mysqli_stmt_affected_rows($stmt);
}

?>