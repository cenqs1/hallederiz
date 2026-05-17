<?php
session_start();
include("database.php");
global $baglanti;

if(!isset($_SESSION["kullanici_id"])){
    header("Location:giris.php");
    exit();
}

$benim_id = $_SESSION["kullanici_id"];

$sql = "
SELECT 
    kullanicilar.id,
    kullanicilar.adsoyad,
    MAX(mesajlar.tarih) AS son_tarih

FROM mesajlar

INNER JOIN kullanicilar
ON (
    CASE 
        WHEN mesajlar.gonderen_id = '$benim_id' 
        THEN mesajlar.alici_id = kullanicilar.id
        ELSE mesajlar.gonderen_id = kullanicilar.id
    END
)

WHERE mesajlar.gonderen_id = '$benim_id'
OR mesajlar.alici_id = '$benim_id'

GROUP BY kullanicilar.id, kullanicilar.adsoyad
ORDER BY son_tarih DESC
";

$sonuc = mysqli_query($baglanti, $sql);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Mesajlarım - HALLEDERİZ</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<header>
    <div class="logo">HALLEDERİZ</div>

    <nav>
        <a href="panel.php">Panel</a>
        <a href="mesajlarim.php">Mesajlarım</a>
        <a href="index.php">Çıkış Yap</a>
    </nav>
</header>

<div class="container">

    <h1 class="baslik">Mesajlarım</h1>

    <?php while($kisi = mysqli_fetch_assoc($sonuc)){ ?>

        <div class="kart">
            <h2><?php echo $kisi["adsoyad"]; ?></h2>
            <p>Son mesaj tarihi: <?php echo $kisi["son_tarih"]; ?></p>

            <a class="btn" href="sohbet.php?id=<?php echo $kisi["id"]; ?>">
                Sohbeti Aç
            </a>
        </div>

    <?php } ?>

</div>

</body>
</html>