<?php

include("database.php");

if(isset($_POST["kayitol"])){

    global $baglanti;

    $adsoyad = $_POST["adsoyad"];
    $email = $_POST["email"];
    $sifre = $_POST["sifre"];
    $rol = $_POST["rol"];

    $sql = "INSERT INTO kullanicilar(adsoyad,email,sifre,rol)
            VALUES('$adsoyad','$email','$sifre','$rol')";

    $ekle = mysqli_query($baglanti, $sql);

    if($ekle){
        echo "Kayıt başarılı";
    }else{
        echo "SQL Hatası: " . mysqli_error($baglanti);
    }
}

?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kayıt Ol</title>

    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<div class="form-kutu">

    <h1>Kayıt Ol</h1>

    <form method="POST">

        <input type="text" name="adsoyad" placeholder="Ad Soyad" class="input" required>

        <input type="email" name="email" placeholder="E-Mail" class="input" required>

        <input type="password" name="sifre" placeholder="Şifre" class="input" required>

        <select name="rol" class="input" required>
            <option value="">Hesap türü seç</option>
            <option value="isveren">İşveren</option>
            <option value="hizmetveren">Hizmet Veren</option>
        </select>

        <button type="submit" name="kayitol" class="btn2">
            Kayıt Ol
        </button>

    </form>

</div>

</body>
</html>