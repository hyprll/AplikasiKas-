<?php


require 'koneksi/koneksi.php';
session_start();
$errorUsername = '';
$errorPassword = '';
if (isset($_SESSION['submit'])) {
    header('Location:http://localhost/aplikasi_kas');
}

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $sql = "select * from user where username = '$username'";
    $result = $connect->query($sql);
    $res = $result->fetch_assoc();

    if ($res != NULL) {
        if ($res['password'] == $password) {
            $_SESSION['username'] = $username;
            $_SESSION['id_user'] = $res["id_user"];
            $_SESSION['role'] = $res["role"];
            $_SESSION['submit'] = true;
            header('Location:http://localhost/aplikasi_kas');
        } else {
            $errorPassword = 'Password Salah';
        }
    } else {
        $errorUsername = 'Username Tidak Terdaftar';
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In & Sign up</title>
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <link rel="stylesheet" href="font-awesome/css/font-awesome.css">
    <script src="https://kit.fontawesome.com/d1a508a7c1.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Sniglet&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300&family=Pacifico&display=swap" rel="stylesheet">
    <link rel="icon" href="assets/img/logo.png">
</head>

<body>
    <section>
        <div class="container">
            <div class="user singinbox">
                <div class="imgbox"><img src="assets/img/estetik3.jpg"></div>
                <div class="formbox">
                    <form action="" method="POST">
                        <h2>Log in</h2>
                        <p id="js">
                            <?= ($errorUsername != '') ? $errorUsername : '' ?>
                        </p>
                        <p id="js">
                            <?= ($errorPassword != '') ? $errorPassword : '' ?>
                        </p>
                        <input type="text" name="username" placeholder="Username" required="required" id="username">
                        <input type="password" name="password" placeholder="Password" required="required" id="password">
                        <div class="btn-flex">
                            <button type="submit" name="submit" value="Login" onclick="return validate()">Login</button>
                            <button type="reset" value="reset" style="background: red;">Reset</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </section>
    <script type="text/javascript">
        function toggleForm() {
            var container = document.querySelector('.container');
            container.classList.toggle('active')
        }
    </script>
</body>

</html>