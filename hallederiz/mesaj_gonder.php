<?php

session_start();
include("database.php");
global $baglanti;

if(!isset($_SESSION["kullanici_id"])){
    header("Location:giris.php");
    exit();
}

if(!isset($_GET["alici_id"])){
    header("Location:kullanici_ara.php");
    exit();
}

$gonderen_id = $_SESSION["kullanici_id"];
$alici_id = $_GET["alici_id"];

if($gonderen_id == $alici_id){
    header("Location:profil.php");
    exit();
}

$alici_sorgu = mysqli_query($baglanti, "SELECT * FROM kullanicilar WHERE id='$alici_id'");
$alici = mysqli_fetch_assoc($alici_sorgu);

if(!$alici){
    header("Location:kullanici_ara.php");
    exit();
}

$mesaj_bilgi = "";

if(isset($_POST["gonder"])){

    $mesaj = $_POST["mesaj"];

    if($mesaj != ""){

        $sql = "INSERT INTO mesajlar(gonderen_id, alici_id, mesaj)
                VALUES('$gonderen_id', '$alici_id', '$mesaj')";

        $ekle = mysqli_query($baglanti, $sql);

        if($ekle){

            $kontrol = mysqli_query($baglanti, "
                SELECT * FROM baglantilar
                WHERE 
                (kullanici1='$gonderen_id' AND kullanici2='$alici_id')
                OR
                (kullanici1='$alici_id' AND kullanici2='$gonderen_id')
            ");

            if(mysqli_num_rows($kontrol) == 0){

                mysqli_query($baglanti, "
                    INSERT INTO baglantilar(kullanici1,kullanici2)
                    VALUES('$gonderen_id','$alici_id')
                ");

            }

            $mesaj_bilgi = "Mesaj gönderildi";

        }else{
            $mesaj_bilgi = "Mesaj gönderilemedi";
        }

    }else{
        $mesaj_bilgi = "Mesaj boş olamaz";
    }

}

$mesajlar = mysqli_query($baglanti, "
    SELECT mesajlar.*, kullanicilar.adsoyad
    FROM mesajlar
    JOIN kullanicilar ON kullanicilar.id = mesajlar.gonderen_id
    WHERE 
    (gonderen_id='$gonderen_id' AND alici_id='$alici_id')
    OR
    (gonderen_id='$alici_id' AND alici_id='$gonderen_id')
    ORDER BY mesajlar.id ASC
");

?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Mesaj Gönder - HALLEDERİZ</title>
    <link rel="stylesheet" href="assets/style.css">

    <style>
        .mesaj-kutu{
            width:70%;
            margin:50px auto;
            background:rgba(0,0,0,0.50);
            border:1px solid rgba(44,255,143,0.30);
            border-radius:25px;
            padding:35px;
        }

        .mesaj-baslik{
            margin-bottom:25px;
        }

        .mesaj-alani{
            max-height:360px;
            overflow-y:auto;
            padding:15px;
            border-radius:18px;
            background:rgba(255,255,255,0.03);
            border:1px solid rgba(44,255,143,0.15);
            margin-bottom:25px;
        }

        .mesaj-satir{
            display:flex;
            margin-bottom:15px;
        }

        .benim-mesaj{
            justify-content:flex-end;
        }

        .karsi-mesaj{
            justify-content:flex-start;
        }

        .mesaj-balonu{
            max-width:65%;
            padding:14px 18px;
            border-radius:18px;
            color:white;
        }

        .benim-mesaj .mesaj-balonu{
            background:#2cff8f;
            color:black;
            border-bottom-right-radius:4px;
        }

        .karsi-mesaj .mesaj-balonu{
            background:rgba(255,255,255,0.08);
            border:1px solid rgba(44,255,143,0.20);
            border-bottom-left-radius:4px;
        }

        .mesaj-form textarea{
            width:100%;
            height:120px;
            resize:none;
        }

        .bildirim{
            margin-bottom:20px;
            padding:12px 18px;
            border-radius:12px;
            background:rgba(44,255,143,0.12);
            border:1px solid rgba(44,255,143,0.35);
            color:#2cff8f;
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

<div class="mesaj-kutu">

    <div class="mesaj-baslik">
        <h1 class="baslik">
            <?php echo $alici["adsoyad"]; ?> ile Mesajlaş
        </h1>
    </div>

    <?php if($mesaj_bilgi != ""){ ?>
        <div class="bildirim">
            <?php echo $mesaj_bilgi; ?>
        </div>
    <?php } ?>

    <div class="mesaj-alani">

        <?php while($m = mysqli_fetch_assoc($mesajlar)){ ?>

            <?php if($m["gonderen_id"] == $gonderen_id){ ?>

                <div class="mesaj-satir benim-mesaj">
                    <div class="mesaj-balonu">
                        <?php echo $m["mesaj"]; ?>
                    </div>
                </div>

            <?php } else { ?>

                <div class="mesaj-satir karsi-mesaj">
                    <div class="mesaj-balonu">
                        <?php echo $m["mesaj"]; ?>
                    </div>
                </div>

            <?php } ?>

        <?php } ?>

    </div>

    <form method="POST" class="mesaj-form">

        <textarea
        name="mesaj"
        class="input"
        placeholder="Mesajını yaz..."></textarea>

        <br><br>

        <button type="submit" name="gonder" class="btn">
            Mesaj Gönder
        </button>

    </form>

</div>

</body>
</html>