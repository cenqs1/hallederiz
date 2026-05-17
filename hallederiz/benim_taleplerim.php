<?php
session_start();
include(__DIR__ . "/database.php");
global $baglanti;

if(!isset($_SESSION["kullanici_id"])){
    header("Location: giris.php");
    exit();
}

$kullanici_id = $_SESSION["kullanici_id"];

$sql = "SELECT * FROM talepler 
        WHERE kullanici_id='$kullanici_id'
        ORDER BY id DESC";

$sonuc = mysqli_query($baglanti, $sql);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Benim Taleplerim</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<header>
    <div class="logo">HALLEDERİZ</div>
    <nav>
        <a href="panel.php">Panel</a>
        <a href="talep_olustur.php">Talep Oluştur</a>
        <a href="talepler.php">Tüm Talepler</a>
        <a href="index.php">Çıkış Yap</a>
    </nav>
</header>

<div class="container">
    <h1 class="baslik">Benim Taleplerim</h1>

    <?php while($talep = mysqli_fetch_assoc($sonuc)){ ?>
        <div class="kart">
            <div class="kategori"><?php echo $talep["kategori"]; ?></div>

            <h2><?php echo $talep["baslik"]; ?></h2>
            <p><?php echo $talep["aciklama"]; ?></p>

            <div class="butce">
                Bütçe: <?php echo $talep["butce"]; ?> ₺
            </div>

            <br>

            <a href="talep_sil.php?id=<?php echo $talep["id"]; ?>" class="btn"
               onclick="return confirm('Bu talebi silmek istediğine emin misin?')">
                Sil
            </a>
        </div>
    <?php } ?>
</div>

</body>
</html>