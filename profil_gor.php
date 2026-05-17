<?php

session_start();
include("database.php");
global $baglanti;

if(!isset($_SESSION["kullanici_id"])){
    header("Location:giris.php");
    exit();
}

if(!isset($_GET["id"])){
    header("Location:kullanici_ara.php");
    exit();
}

$profil_id = $_GET["id"];

$kullanici_sorgu = mysqli_query($baglanti, "SELECT * FROM kullanicilar WHERE id='$profil_id'");
$kullanici = mysqli_fetch_assoc($kullanici_sorgu);

if(!$kullanici){
    header("Location:kullanici_ara.php");
    exit();
}

$puan_sorgu = mysqli_query($baglanti, "
SELECT AVG(puan) AS ortalama, COUNT(*) AS toplam
FROM puanlar
WHERE alan_id='$profil_id'
");

$puan_bilgi = mysqli_fetch_assoc($puan_sorgu);

$ortalama_puan = $puan_bilgi["ortalama"];
$toplam_puan = $puan_bilgi["toplam"];
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Profil Gör - HALLEDERİZ</title>
    <link rel="stylesheet" href="assets/style.css">

    <style>
        .profil-gor-kutu{
            width:75%;
            margin:50px auto;
            background:rgba(0,0,0,0.50);
            border:1px solid rgba(44,255,143,0.30);
            border-radius:25px;
            padding:35px;
            box-shadow:0 0 25px rgba(44,255,143,0.12);
        }

        .profil-gor-ust{
            display:flex;
            align-items:center;
            gap:25px;
            margin-bottom:30px;
        }

        .profil-gor-foto{
            width:140px;
            height:140px;
            border-radius:50%;
            object-fit:cover;
            border:3px solid #2cff8f;
            box-shadow:0 0 20px rgba(44,255,143,0.35);
        }

        .profil-gor-bos{
            width:140px;
            height:140px;
            border-radius:50%;
            border:3px solid #2cff8f;
            display:flex;
            align-items:center;
            justify-content:center;
            color:#2cff8f;
            font-weight:bold;
        }

        .profil-bilgi-grid{
            display:grid;
            grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
            gap:18px;
            margin-top:25px;
        }

        .profil-bilgi-kart{
            background:rgba(255,255,255,0.04);
            border:1px solid rgba(44,255,143,0.18);
            border-radius:18px;
            padding:20px;
        }

        .profil-bilgi-kart h3{
            color:#2cff8f;
            margin-bottom:8px;
        }

        .profil-bilgi-kart p{
            color:#ddd;
        }

        .puan-kutu{
            display:inline-block;
            margin-top:12px;
            padding:10px 18px;
            border-radius:30px;
            background:rgba(44,255,143,0.1);
            border:1px solid #2cff8f;
            color:#2cff8f;
            font-weight:bold;
        }

        .profil-aksiyonlar{
            margin-top:30px;
            display:flex;
            gap:15px;
            flex-wrap:wrap;
        }

        .geri-btn{
            display:inline-block;
            padding:13px 22px;
            border-radius:12px;
            background:rgba(255,255,255,0.08);
            color:white;
            text-decoration:none;
            border:1px solid rgba(44,255,143,0.25);
            font-weight:bold;
        }
    </style>
</head>
<body>

<header>
    <div class="logo">HALLEDERİZ</div>

    <nav>
        <a href="panel.php">Panel</a>
        <a href="kullanici_ara.php">Kullanıcı Ara</a>
        <a href="profil.php">Profilim</a>
        <a href="mesajlarim.php">Mesajlarım</a>
    </nav>
</header>

<div class="profil-gor-kutu">

    <div class="profil-gor-ust">

        <?php if($kullanici["profil_foto"] != ""){ ?>
            <img src="<?php echo $kullanici["profil_foto"]; ?>" class="profil-gor-foto">
        <?php } else { ?>
            <div class="profil-gor-bos">Fotoğraf</div>
        <?php } ?>

        <div>
            <h1 class="baslik">
                <?php echo $kullanici["adsoyad"]; ?>
            </h1>

            <p>
                Rol:
                <b><?php echo $kullanici["rol"]; ?></b>
            </p>

            <div class="puan-kutu">
                ⭐ Ortalama Puan:
                <?php
                if($ortalama_puan == ""){
                    echo "Henüz yok";
                }else{
                    echo round($ortalama_puan,1) . " / 5";
                }
                ?>
                <?php if($toplam_puan > 0){ ?>
                    (<?php echo $toplam_puan; ?> değerlendirme)
                <?php } ?>
            </div>
        </div>

    </div>

    <div class="profil-bilgi-grid">

        <div class="profil-bilgi-kart">
            <h3>Uzmanlık</h3>
            <p>
                <?php
                if($kullanici["uzmanlik"] == ""){
                    echo "Belirtilmemiş";
                }else{
                    echo $kullanici["uzmanlik"];
                }
                ?>
            </p>
        </div>

        <div class="profil-bilgi-kart">
            <h3>Şehir</h3>
            <p>
                <?php
                if($kullanici["sehir"] == ""){
                    echo "Belirtilmemiş";
                }else{
                    echo $kullanici["sehir"];
                }
                ?>
            </p>
        </div>

        <div class="profil-bilgi-kart">
            <h3>Telefon</h3>
            <p>
                <?php
                if($kullanici["telefon"] == ""){
                    echo "Belirtilmemiş";
                }else{
                    echo $kullanici["telefon"];
                }
                ?>
            </p>
        </div>

    </div>

    <div class="profil-bilgi-kart" style="margin-top:20px;">
        <h3>Hakkında</h3>
        <p>
            <?php
            if($kullanici["hakkimda"] == ""){
                echo "Bu kullanıcı henüz hakkında bilgisi eklememiş.";
            }else{
                echo $kullanici["hakkimda"];
            }
            ?>
        </p>
    </div>

    <div class="profil-aksiyonlar">
        <a href="kullanici_ara.php" class="geri-btn">Geri Dön</a>
<a href="mesaj_gonder.php?alici_id=<?php echo $profil_id; ?>" class="btn">
    Mesaj Gönder
</a>    </div>

</div>

</body>
</html>