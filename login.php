<?php

session_start();
require 'functions.php';

//cek apakah tombol sign in sudah ditekan atau belum
if( isset($_POST["register"]) ) {
    if(registrasi($_POST) > 0) {
        echo "<script>
                alert('Akun Anda telah berhasil dibuat!');
              </script>";
    } else {
        echo mysqli_error($conn);
    }
}


//cek cookie ada nggak 
if( isset($_COOKIE['id'])  && isset($_COOKIE['key'])) {
    $id = $_COOKIE['id'];
    $key = $_COOKIE['key'];

    //ambil username berdasarkan id 
    $query = "SELECT username FROM members WHERE idmember = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) > 0) {
        mysqli_stmt_bind_result($stmt, $username);
        mysqli_stmt_fetch($stmt);

        //cek cookie dan username
        if( $key === hash('sha256', $username) ) {
            $_SESSION['login'] = true;
            $_SESSION["username"] = $username;
            $_SESSION["idmember"] = $id;
        }
    }
}


if( isset($_SESSION["login"]) ) {
    header("Location: myrecipe6.php");
    exit;
}


if(isset($_POST["login"])) {

    $username = $_POST["username"];
    $password = $_POST["password"];

    $query = "SELECT * FROM members WHERE username = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    //cek username
    if( mysqli_num_rows($result) === 1) {

        //cek password
        $row = mysqli_fetch_assoc($result);
        if(password_verify($password, $row["password"])) {
            //set session
            $_SESSION["login"] = true;
            $_SESSION["username"] = $username;
            $_SESSION["password"] = $password;
            $_SESSION["idmember"] = $row['idmember'];

           // Set session untuk admin
           if ($row['username'] === 'adminCookDy') {
            $_SESSION["isAdmin"] = true;
        }
            //cek remember me
            if( isset($_POST['remember'])) {
                //buat cookie
                setcookie('id', $row['idmember'], time()+60*60*24); //Cookie valid for 1 day
                setcookie('key', hash('sha256', $row['username']), time()+60*60*24);
            }

            header("Location: myrecipe6.php");
            exit;
        } else {
            // jika password salah
            echo "<script>
                alert('Username atau Password salah! harap periksa kembali.');
            </script>";
        }
    } else {
        // jika username belum terdaftar
        echo "<script>
                alert('Username belum terdaftar! Silahkan registrasi akun terlebih dahulu.');
            </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/logstyles.css">
        <title>Login Page | CookingDiary</title>
    </head>

    <body>
        <!--SIGN UP FORM-->
        <div class="container" id="container">
            <div class="form-container sign-up">
                <form action="" method="post">
                    <h1 style="text-align: center;">Create Account</h1>
                    <span>Use your email for registration</span>
                    <input type="text" name="username" id="username" placeholder="Username">
                    <input type="email" name="email" id="email" placeholder="Email">
                    <input type="password" name="password" id="password" placeholder="Password">
                    <input type="password" name="password2" id="password2" placeholder="Confirm Your Password">
                    <button type="submit" name="register">Sign Up</button>
                </form>
            </div>
            <!--lOGIN FORM-->
            <div class="container" id="container">
                <div class="form-container sign-in">
                    <form action="" method="post">
                        <h1>Login</h1>
                        <?php if( isset($error)) : ?>
                        <p style="color:red; font-style:italic">Username atau password salah!</p>
                        <?php endif; ?>

                        <span>Use your username and password</span>
                        <input type="text" id="username" name="username" placeholder="Username">
                        <input type="password" id="password" name="password" placeholder="Password">
                        <label for="remember" style="font-size: 11px; margin-left:5px;">Remember Me?</label>
                        <input type="checkbox" name="remember" id="remember">
                        <!--<a href="#">Forget Your Password?</a>-->
                        <button type="submit" name="login">Login</button>
                    </form>
                </div>
                <div class="toggle-container">
                    <div class="toggle">
                        <div class="toggle-panel
                        toggle-left">
                            <h1>Welcome Back!</h1>
                            <p>Enter your personal details to use 
                                all of site features</p>
                            <button class="hidden" id="login">Sign In
                            </button>
                        </div>
                        <div class="toggle-panel
                        toggle-right">
                            <h1>Hello, Friend!</h1>
                            <p>Don't have an account? <br>
                                Register with your personal details to use all of site features</p>
                            <button class="hidden" id="register">Sign Up
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="js/login.js">
        </script>
    </body>
</html>