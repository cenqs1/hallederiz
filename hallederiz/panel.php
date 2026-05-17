<?php
session_start();
global $baglanti;  
if(!isset($_SESSION["kullanici_id"])){
    header("Location: giris.php");
    exit();
}

$adsoyad = $_SESSION["adsoyad"];
$rol = $_SESSION["rol"];
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Panel - HALLEDERİZ</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<header>
    <div class="logo">HALLEDERİZ</div>

    <nav>
        <a href="panel.php">Panel</a>

        <?php if($rol == "isveren"){ ?>
            <a href="talep_olustur.php">Talep Oluştur</a>
            <a href="benim_taleplerim.php">Benim Taleplerim</a>
            <a href="gelen_teklifler.php">Gelen Teklifler</a>
            <a href="mesajlarim.php">Mesajlarım</a>
        <?php } else { ?>
            <a href="talepler.php">Tüm Talepler</a>
            <a href="gelen_teklifler.php">Verdiğim Teklifler</a>
            <a href="mesajlarim.php">Mesajlarım</a>
        <?php } ?>

        <a href="profil.php">Profilim</a>
        <a href="kullanici_ara.php">Kullanıcı Ara</a>
        <a href="index.php">Çıkış Yap</a>
    </nav>
</header>

<div class="container">

    <div class="panel-ust">
        <div>
            <h1 class="baslik">
                Merhaba, <?php echo $adsoyad; ?>
            </h1>

        </div>

        <div class="panel-durum">
            <span>Aktif Panel</span>
        </div>
    </div>

    <div class="kart">
        <h2>Şu an ne yapmak istiyorsun?</h2>

        <?php if($rol == "isveren"){ ?>

            <p>Buradan yeni talep oluşturabilir, taleplerini ve gelen teklifleri takip edebilirsin.</p>
            <br>

            <a href="talep_olustur.php" class="btn">Talep Oluştur</a>
            <a href="benim_taleplerim.php" class="btn">Benim Taleplerim</a>
            <a href="gelen_teklifler.php" class="btn">Gelen Teklifler</a>

        <?php } else { ?>

            <p>Buradan açık talepleri inceleyebilir ve uygun işlere teklif verebilirsin.</p>
            <br>

            <a href="talepler.php" class="btn">Talepleri Gör</a>
            <a href="gelen_teklifler.php" class="btn">Verdiğim Teklifler</a>

        <?php } ?>
    </div>

    <div class="istatistik-alani">

        <?php if($rol == "isveren"){ ?>

            <div class="istatistik-kart">
                <h2>3</h2>
                <p>Yayınladığın Talep</p>
            </div>

            <div class="istatistik-kart">
                <h2>8</h2>
                <p>Gelen Teklif</p>
            </div>

            <div class="istatistik-kart">
                <h2>2</h2>
                <p>Yeni Mesaj</p>
            </div>

        <?php } else { ?>

            
            <a href="talepler.php" class="istatistik-kart">
    <h2>12</h2>
    <p>Açık Talep</p>
</a>

<a href="gelen_teklifler.php" class="istatistik-kart">
    <h2>5</h2>
    <p>Verdiğin Teklif</p>
</a>

<a href="mesajlarim.php" class="istatistik-kart">
    <h2>2</h2>
    <p>Yeni Mesaj</p>
</a>

        <?php } ?>

    </div>
<div class="populer-alan">

    <h2>En Çok Etkileşim Alan Talepler</h2>

    <div class="teklif-listesi">

<?php

include("database.php");

$sql = "
SELECT talepler.*, COUNT(teklifler.id) as teklif_sayisi
FROM talepler
LEFT JOIN teklifler ON talepler.id = teklifler.talep_id
GROUP BY talepler.id
ORDER BY teklif_sayisi DESC
LIMIT 5
";

$sonuc = mysqli_query($baglanti, $sql);

while($row = mysqli_fetch_assoc($sonuc)){

?>

<a href="teklif_ver.php?id=<?php echo $row['id']; ?>" class="teklif-kutu">

    <div>
        <h3><?php echo $row['baslik']; ?></h3>

        <p>
            <?php echo substr($row['aciklama'],0,80); ?>...
        </p>
    </div>

    <span>
        <?php echo $row['teklif_sayisi']; ?> Teklif
    </span>

</a>

<?php } ?>

    </div>

</div>

</div>

</body>
</html>