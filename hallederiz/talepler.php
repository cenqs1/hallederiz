<?php

session_start();
include("database.php");
 global $baglanti;

$sql = "SELECT * FROM talepler ORDER BY id DESC";

$sonuc = mysqli_query($baglanti,$sql);

?>

<!DOCTYPE html>
<html lang="tr">
<head>

<meta charset="UTF-8">

    <header>

        <div class="logo">HALLEDERİZ</div>

        <nav>
            <a href="panel.php">Panel</a>
            <a href="talep_olustur.php">Talep Oluştur</a>
            <a href="benim_taleplerim.php">Benim Taleplerim</a>
            <a href="index.php">Çıkış Yap</a>
        </nav>

    </header>

<title>Talepler</title>

<link rel="stylesheet" href="assets/style.css">

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

</head>
<body>

<div class="container">

<h1 class="baslik">Son Talepler</h1>

<?php

while($talep = mysqli_fetch_assoc($sonuc)){

?>

<div class="kart">

<div class="kategori">
<?php echo $talep["kategori"]; ?>
</div>

<h2>
<?php echo $talep["baslik"]; ?>
</h2>

<p>
<?php echo $talep["aciklama"]; ?>
</p>

<div class="butce">

Bütçe:
<?php echo $talep["butce"]; ?> ₺
<a href="teklif_ver.php?id=<?php echo $talep["id"]; ?>" class="btn">
    Teklif Ver
</a>
</div>

</div>

<?php } ?>

</div>

</body>
</html>