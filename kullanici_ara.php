<?php

session_start();
include("database.php");
global $baglanti;

$arama = "";

if(isset($_GET["arama"])){

    $arama = $_GET["arama"];

}

?>

<!DOCTYPE html>
<html lang="tr">
<head>

<meta charset="UTF-8">

<title>Kullanıcı Ara</title>

<link rel="stylesheet" href="assets/style.css">

<style>

.arama-kutu{

    width:80%;
    margin:40px auto;

}

.kullanici-kart{

    display:flex;
    justify-content:space-between;
    align-items:center;

    background:rgba(255,255,255,0.04);

    border:1px solid rgba(44,255,143,0.2);

    border-radius:18px;

    padding:20px;

    margin-bottom:20px;

}

.kullanici-sol{

    display:flex;
    align-items:center;
    gap:20px;

}

.kullanici-foto{

    width:80px;
    height:80px;

    border-radius:50%;
    object-fit:cover;

    border:2px solid #2cff8f;

}

.kullanici-bos{

    width:80px;
    height:80px;

    border-radius:50%;

    border:2px solid #2cff8f;

    display:flex;
    align-items:center;
    justify-content:center;

    color:#2cff8f;

}

.profil-btn{

    padding:12px 18px;

    background:#2cff8f;

    color:black;

    text-decoration:none;

    border-radius:10px;

    font-weight:bold;

}

.arama-bos{

    text-align:center;
    color:#888;
    margin-top:80px;
    font-size:22px;

}

</style>

</head>
<body>

<header>

    <div class="logo">HALLEDERİZ</div>

    <nav>

        <a href="panel.php">Panel</a>
        <a href="profil.php">Profilim</a>

    </nav>

</header>

<div class="arama-kutu">

<form method="GET">

<input
type="text"
name="arama"
placeholder="Kullanıcı, uzmanlık veya şehir ara..."
class="input"
value="<?php echo $arama; ?>">

<br><br>

<button class="btn">
Ara
</button>

</form>

<br><br>

<?php

if($arama != ""){

$sql = "SELECT * FROM kullanicilar
WHERE adsoyad LIKE '%$arama%'
OR uzmanlik LIKE '%$arama%'
OR sehir LIKE '%$arama%'";

$sonuc = mysqli_query($baglanti,$sql);

if(mysqli_num_rows($sonuc) > 0){

while($row = mysqli_fetch_assoc($sonuc)){

?>

<div class="kullanici-kart">

    <div class="kullanici-sol">

        <?php if($row["profil_foto"] != ""){ ?>

            <img
            src="<?php echo $row["profil_foto"]; ?>"
            class="kullanici-foto">

        <?php } else { ?>

            <div class="kullanici-bos">
                Foto
            </div>

        <?php } ?>

        <div>

            <h2>
                <?php echo $row["adsoyad"]; ?>
            </h2>

            <p>
                <?php echo $row["uzmanlik"]; ?>
            </p>

            <p>
                📍 <?php echo $row["sehir"]; ?>
            </p>

        </div>

    </div>

    <a
    href="profil_gor.php?id=<?php echo $row["id"]; ?>"
    class="profil-btn">

    Profili Gör

    </a>

</div>

<?php

}

}else{

?>

<div class="arama-bos">
    Sonuç bulunamadı
</div>

<?php

}

}else{

?>

<div class="arama-bos">
    Kullanıcı aramaya başla 🔍
</div>

<?php } ?>

</div>

</body>
</html>