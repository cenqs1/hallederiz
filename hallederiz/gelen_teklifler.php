<?php

session_start();
include(__DIR__ . "/database.php");
global $baglanti;

if(!isset($_SESSION["kullanici_id"])){

    header("Location:giris.php");
    exit();

}

$kullanici_id = $_SESSION["kullanici_id"];

$sql = "

SELECT 
teklifler.*,
talepler.baslik,
kullanicilar.adsoyad

FROM teklifler

INNER JOIN talepler
ON teklifler.talep_id = talepler.id

INNER JOIN kullanicilar
ON teklifler.kullanici_id = kullanicilar.id

WHERE talepler.kullanici_id = '$kullanici_id'

ORDER BY teklifler.id DESC

";

$sonuc = mysqli_query($baglanti,$sql);

?>

<!DOCTYPE html>
<html lang="tr">
<head>

<meta charset="UTF-8">

<title>Gelen Teklifler</title>

<link rel="stylesheet" href="assets/style.css">

</head>
<body>

<header>

    <div class="logo">HALLEDERİZ</div>

    <nav>

        <a href="panel.php">Panel</a>
        <a href="talepler.php">Talepler</a>
        <a href="benim_taleplerim.php">Benim Taleplerim</a>
        <a href="index.php">Çıkış Yap</a>

    </nav>

</header>

<div class="container">

<h1 class="baslik">
Gelen Teklifler
</h1>

<?php while($teklif = mysqli_fetch_assoc($sonuc)){ ?>

<div class="kart">

    <div class="kategori">
        <?php echo $teklif["baslik"]; ?>
    </div>

    <h2>
        Teklif Veren:
        <?php echo $teklif["adsoyad"]; ?>
    </h2>

    <p>
        <?php echo $teklif["teklif"]; ?>
    </p>

    <div class="butce">
        Teklif:
        <?php echo $teklif["fiyat"]; ?> ₺
    </div>

    <br>

    <a class="btn" href="sohbet.php?id=<?php echo $teklif["kullanici_id"]; ?>">
        Sohbet Et
    </a>

</div>

<?php } ?>

</div>

</body>
</html>