<?php

session_start();
include("database.php");
global $baglanti;

if(isset($_POST["giris"])){

    $email = $_POST["email"];
    $sifre = $_POST["sifre"];

    $sql = "SELECT * FROM kullanicilar
    WHERE email='$email' AND sifre='$sifre'";

    $sorgu = mysqli_query($baglanti, $sql);

    if(mysqli_num_rows($sorgu) > 0){

        $kullanici = mysqli_fetch_assoc($sorgu);

        $_SESSION["kullanici_id"] = $kullanici["id"];
        $_SESSION["adsoyad"] = $kullanici["adsoyad"];
        $_SESSION["rol"] = $kullanici["rol"];

        if($_SESSION["rol"] == "admin"){

            header("Location: admin_panel.php");
            exit();

        }

        header("Location: panel.php");
        exit();

    }else{

        echo "<div class='hata-mesaj'>
            E-mail veya şifre hatalı!
        </div>";

    }

}

?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Giriş Yap - HALLEDERİZ</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<div class="form-kutu">

    <h1>Giriş Yap</h1>

    <form method="POST">

        <input type="email" name="email" placeholder="E-Mail" class="input">

        <input type="password" name="sifre" placeholder="Şifre" class="input">

        <button type="submit" name="giris" class="btn2">
            Giriş Yap
        </button>

    </form>

</div>

</body>
</html>