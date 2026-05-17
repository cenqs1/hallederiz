<?php

session_start();
include("database.php");
global $baglanti;

if(!isset($_SESSION["kullanici_id"])){

    header("Location:giris.php");
    exit();

}

if($_SESSION["rol"] != "isveren"){

    header("Location:panel.php");
    exit();

}

if(isset($_POST["paylas"])){

    $kullanici_id = $_SESSION["kullanici_id"];
    $baslik = $_POST["baslik"];
    $aciklama = $_POST["aciklama"];
    $kategori = $_POST["kategori"];
    $butce = $_POST["butce"];

    $sql = "INSERT INTO talepler
    (kullanici_id,baslik,aciklama,kategori,butce)
    VALUES
    ('$kullanici_id','$baslik','$aciklama','$kategori','$butce')";

    $ekle = mysqli_query($baglanti,$sql);

    if($ekle){
        echo "Talep paylaşıldı ";
    }else{
        echo "Hata oluştu";
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>

<meta charset="UTF-8">
<header>

        <div class="logo">HALLEDERİZ</div>

        <nav>
            <a href="panel.php">Panel</a>
            <a href="talepler.php">Tüm Talepler</a>
            <a href="benim_taleplerim.php">Benim Taleplerim</a>
            <a href="index.php">Çıkış Yap</a>
        </nav>

    </header>

<link rel="stylesheet" href="assets/style.css">
<title>Talep Oluştur</title>

<style>

.container{

    width:90%;
    margin:50px auto;

}

.baslik{

    font-size:45px;
    margin-bottom:35px;
    color:#f4c542;

}

.kart{

    background:rgba(255,255,255,0.06);
    padding:25px;
    border-radius:20px;
    margin-bottom:25px;
    backdrop-filter:blur(10px);
    transition:0.3s;

}

.kart:hover{

    transform:translateY(-5px);

}

.kart h2{

    margin-bottom:15px;
    color:white;

}

.kategori{

    display:inline-block;
    background:#f4c542;
    color:black;
    padding:8px 14px;
    border-radius:999px;
    font-size:14px;
    margin-bottom:15px;
    font-weight:bold;

}

.butce{

    margin-top:18px;
    font-size:18px;
    color:#f4c542;
    font-weight:bold;

}

</style>



<link rel="stylesheet" href="assets/style.css">

</head>
<body>

<div class="form-kutu">

<h1>Yeni Talep</h1>

<form method="POST">

<input type="text"
name="baslik"
placeholder="İş Başlığı"
class="input">

<textarea
name="aciklama"
placeholder="İş detayını yaz..."
class="input"
style="height:140px;"></textarea>

<input type="text"
name="kategori"
placeholder="Kategori"
class="input">

<input type="text"
name="butce"
placeholder="Bütçe"
class="input">

<button type="submit"
name="paylas"
class="btn2">

Talebi Paylaş

</button>

</form>

</div>

</body>
</html>