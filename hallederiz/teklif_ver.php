<?php

session_start();
include("database.php");
global $baglanti;

if(!isset($_SESSION["kullanici_id"])){

    header("Location:giris.php");
    exit();

}

if($_SESSION["rol"] == "isveren"){

    header("Location:panel.php");
    exit();

}

if(!isset($_GET["id"])){

    header("Location:talepler.php");
    exit();

}

$talep_id = $_GET["id"];

if(isset($_POST["gonder"])){

    $kullanici_id = $_SESSION["kullanici_id"];
    $teklif = $_POST["teklif"];
    $fiyat = $_POST["fiyat"];

    $demo_yolu = "";

if(isset($_FILES["demo_dosya"])){

    $dosya_adi = time() . "_" . $_FILES["demo_dosya"]["name"];

    $hedef_klasor = "uploads/demo/";

    $hedef_yol = $hedef_klasor . $dosya_adi;

    move_uploaded_file(
        $_FILES["demo_dosya"]["tmp_name"],
        $hedef_yol
    );

    $demo_yolu = $hedef_yol;
}
   $sql = "INSERT INTO teklifler
(talep_id,kullanici_id,teklif,fiyat,demo_dosya)

VALUES

('$talep_id','$kullanici_id','$teklif','$fiyat','$demo_yolu')";
    $ekle = mysqli_query($baglanti,$sql);

    if($ekle){

echo "<div class='basari-mesaj'>
✅ Teklif başarıyla gönderildi
</div>";
    }else{

        echo "<div class='hata-mesaj'>
❌ Teklif gönderilirken bir hata oluştu
</div>";

    }

}

?>

<!DOCTYPE html>
<html lang="tr">
<head>

<meta charset="UTF-8">

<title>Teklif Ver</title>

<link rel="stylesheet" href="assets/style.css">

</head>
<body>

<div class="form-kutu">

<h1>Teklif Ver</h1>

<form method="POST" enctype="multipart/form-data">
<textarea
name="teklif"
placeholder="Teklif mesajın..."
class="input"
style="height:140px;"></textarea>

<input type="text"
name="fiyat"
placeholder="Fiyat"
class="input">

<label class="demo-label">Demo Dosyası Yükle</label>

<div class="dosya-alani">

    <label for="demo_dosya" class="dosya-btn">
        Dosya Seç
    </label>

    <span id="dosya-adi">
        Henüz dosya seçilmedi
    </span>

    <input
        type="file"
        name="demo_dosya"
        id="demo_dosya"
        hidden
    >

</div>

<button type="submit"
name="gonder"
class="btn2">

Teklif Gönder

</button>

</form>

</div>
<script>

document
.getElementById("demo_dosya")
.addEventListener("change", function(){

    const dosyaAdi =
    this.files[0]?.name ||
    "Henüz dosya seçilmedi";

    document
    .getElementById("dosya-adi")
    .innerText = dosyaAdi;

});

</script>
</body>
</html>