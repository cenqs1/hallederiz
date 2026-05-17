<?php
session_start();
include("database.php");
global $baglanti;

if(!isset($_SESSION["kullanici_id"])){
    header("Location:giris.php");
    exit();
}

$benim_id = $_SESSION["kullanici_id"];

if(!isset($_GET["id"])){
    header("Location:panel.php");
    exit();
}

$alici_id = $_GET["id"];

if(isset($_POST["gonder"])){

    $mesaj = $_POST["mesaj"];

    $sql = "INSERT INTO mesajlar (gonderen_id, alici_id, mesaj)
            VALUES ('$benim_id', '$alici_id', '$mesaj')";

    mysqli_query($baglanti, $sql);

    header("Location:sohbet.php?id=$alici_id");
    exit();
}

$mesajlar = mysqli_query($baglanti, "
    SELECT * FROM mesajlar
    WHERE 
    (gonderen_id='$benim_id' AND alici_id='$alici_id')
    OR
    (gonderen_id='$alici_id' AND alici_id='$benim_id')
    ORDER BY tarih ASC
");
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Sohbet - HALLEDERİZ</title>
    <link rel="stylesheet" href="assets/style.css">

    <style>
        .sohbet-kutu{
            width:70%;
            margin:50px auto;
            background:rgba(0,0,0,0.45);
            border:1px solid rgba(44,255,143,0.25);
            border-radius:25px;
            padding:25px;
        }

        .mesajlar{
            height:400px;
            overflow-y:auto;
            padding:15px;
            border-radius:20px;
            background:rgba(255,255,255,0.04);
            margin-bottom:20px;
        }

        .mesaj{
            max-width:70%;
            padding:12px 16px;
            border-radius:15px;
            margin-bottom:12px;
            color:white;
        }

        .ben{
            background:#2cff8f;
            color:#001b0d;
            margin-left:auto;
        }

        .diger{
            background:rgba(255,255,255,0.12);
            margin-right:auto;
        }

        textarea{
            width:100%;
            height:100px;
            border-radius:15px;
            padding:15px;
            border:none;
            outline:none;
            resize:none;
            margin-bottom:15px;
        }
    </style>
</head>
<body>

<header>
    <div class="logo">HALLEDERİZ</div>

    <nav>
        <a href="panel.php">Panel</a>
        <a href="index.php">Çıkış Yap</a>
    </nav>
</header>

<div class="sohbet-kutu">

    <h1 class="baslik">Sohbet</h1>

    <div class="mesajlar">

        <?php while($m = mysqli_fetch_assoc($mesajlar)){ ?>

            <?php if($m["gonderen_id"] == $benim_id){ ?>

                <div class="mesaj ben">
                    <?php echo $m["mesaj"]; ?>
                    <br>
                    <small><?php echo $m["tarih"]; ?></small>
                </div>

            <?php } else { ?>

                <div class="mesaj diger">
                    <?php echo $m["mesaj"]; ?>
                    <br>
                    <small><?php echo $m["tarih"]; ?></small>
                </div>

            <?php } ?>

        <?php } ?>

    </div>

    <form method="POST">
        <textarea name="mesaj" placeholder="Mesajını yaz..." required></textarea>
        <button type="submit" name="gonder" class="btn">Gönder</button>
    </form>

</div>

</body>
</html>