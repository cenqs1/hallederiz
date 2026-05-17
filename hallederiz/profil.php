<?php
session_start();
include("database.php");
global $baglanti;

if(!isset($_SESSION["kullanici_id"])){
    header("Location:giris.php");
    exit();
}

$kullanici_id = $_SESSION["kullanici_id"];

$kullanici_sorgu = mysqli_query($baglanti, "SELECT * FROM kullanicilar WHERE id='$kullanici_id'");
$kullanici = mysqli_fetch_assoc($kullanici_sorgu);

if(isset($_POST["guncelle"])){

    $telefon = $_POST["telefon"];
    $sehir = $_POST["sehir"];
    $uzmanlik = $_POST["uzmanlik"];
    $hakkimda = $_POST["hakkimda"];

    $profil_foto = $kullanici["profil_foto"];

    if(isset($_FILES["profil_foto"]) && $_FILES["profil_foto"]["name"] != ""){

        $klasor = "assets/uploads/";

        if(!is_dir($klasor)){
            mkdir($klasor, 0777, true);
        }

        $dosya_adi = time() . "_" . $_FILES["profil_foto"]["name"];
        $dosya_yolu = $klasor . $dosya_adi;

        move_uploaded_file($_FILES["profil_foto"]["tmp_name"], $dosya_yolu);

        $profil_foto = $dosya_yolu;
    }

    $sql = "UPDATE kullanicilar SET
            telefon='$telefon',
            sehir='$sehir',
            uzmanlik='$uzmanlik',
            hakkimda='$hakkimda',
            profil_foto='$profil_foto'
            WHERE id='$kullanici_id'";

    mysqli_query($baglanti, $sql);

    header("Location:profil.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Profilim - HALLEDERİZ</title>
    <link rel="stylesheet" href="assets/style.css">

    <style>
        .profil-kutu{
            width:70%;
            margin:50px auto;
            background:rgba(0,0,0,0.45);
            border:1px solid rgba(44,255,143,0.25);
            border-radius:25px;
            padding:35px;
        }

        .profil-ust{
            display:flex;
            align-items:center;
            gap:25px;
            margin-bottom:30px;
        }

        .profil-foto{
            width:130px;
            height:130px;
            border-radius:50%;
            object-fit:cover;
            border:3px solid #2cff8f;
            box-shadow:0 0 20px rgba(44,255,143,0.35);
        }

        .profil-bos{
            width:130px;
            height:130px;
            border-radius:50%;
            border:3px solid #2cff8f;
            display:flex;
            align-items:center;
            justify-content:center;
            color:#2cff8f;
            font-weight:bold;
        }

        label{
            display:block;
            margin-top:15px;
            margin-bottom:6px;
            color:#ddd;
            font-weight:bold;
        }

        textarea{
            min-height:120px;
            resize:none;
        }
    </style>
</head>
<body>

<header>
    <div class="logo">HALLEDERİZ</div>

    <nav>
        <a href="panel.php">Panel</a>
        <a href="profil.php">Profilim</a>
        <a href="mesajlarim.php">Mesajlarım</a>
        <a href="cikis.php">Çıkış Yap</a>
    </nav>
</header>

<div class="profil-kutu">

    <div class="profil-ust">

        <?php if($kullanici["profil_foto"] != ""){ ?>
            <img src="<?php echo $kullanici["profil_foto"]; ?>" class="profil-foto">
        <?php } else { ?>
            <div class="profil-bos">Fotoğraf</div>
        <?php } ?>

       <div>

    <h1 class="baslik">
        <?php echo $kullanici["adsoyad"]; ?>
    </h1>

    <p>
        Rol:
        <b><?php echo $kullanici["rol"]; ?></b>
    </p>

<?php

$puan_sorgu = mysqli_query($baglanti,
"SELECT AVG(puan) as ortalama
FROM puanlar
WHERE alan_id='$kullanici_id'");

$puan = mysqli_fetch_assoc($puan_sorgu);

?>

    <div class="puan-kutu">
        ⭐ Ortalama Puan:
        <?php echo round($puan["ortalama"],1); ?>
    </div>

</div>

    </div>

    <form method="POST" enctype="multipart/form-data">

        <label>Profil Fotoğrafı</label>
        <input type="file" name="profil_foto" class="input">

        <label>Telefon</label>
        <input type="text" name="telefon" class="input" value="<?php echo $kullanici["telefon"]; ?>">

       <label>Şehir</label>

<input 
    type="text" 
    name="sehir" 
    class="input" 
    list="sehirler"
    placeholder="Şehir seç veya yaz..."
    value="<?php echo $kullanici["sehir"]; ?>"
>

<datalist id="sehirler">
    <option value="Adana">
    <option value="Adıyaman">
    <option value="Afyonkarahisar">
    <option value="Ağrı">
    <option value="Amasya">
    <option value="Ankara">
    <option value="Antalya">
    <option value="Artvin">
    <option value="Aydın">
    <option value="Balıkesir">
    <option value="Bilecik">
    <option value="Bingöl">
    <option value="Bitlis">
    <option value="Bolu">
    <option value="Burdur">
    <option value="Bursa">
    <option value="Çanakkale">
    <option value="Çankırı">
    <option value="Çorum">
    <option value="Denizli">
    <option value="Diyarbakır">
    <option value="Edirne">
    <option value="Elazığ">
    <option value="Erzincan">
    <option value="Erzurum">
    <option value="Eskişehir">
    <option value="Gaziantep">
    <option value="Giresun">
    <option value="Gümüşhane">
    <option value="Hakkari">
    <option value="Hatay">
    <option value="Isparta">
    <option value="Mersin">
    <option value="İstanbul">
    <option value="İzmir">
    <option value="Kars">
    <option value="Kastamonu">
    <option value="Kayseri">
    <option value="Kırklareli">
    <option value="Kırşehir">
    <option value="Kocaeli">
    <option value="Konya">
    <option value="Kütahya">
    <option value="Malatya">
    <option value="Manisa">
    <option value="Kahramanmaraş">
    <option value="Mardin">
    <option value="Muğla">
    <option value="Muş">
    <option value="Nevşehir">
    <option value="Niğde">
    <option value="Ordu">
    <option value="Rize">
    <option value="Sakarya">
    <option value="Samsun">
    <option value="Siirt">
    <option value="Sinop">
    <option value="Sivas">
    <option value="Tekirdağ">
    <option value="Tokat">
    <option value="Trabzon">
    <option value="Tunceli">
    <option value="Şanlıurfa">
    <option value="Uşak">
    <option value="Van">
    <option value="Yozgat">
    <option value="Zonguldak">
    <option value="Aksaray">
    <option value="Bayburt">
    <option value="Karaman">
    <option value="Kırıkkale">
    <option value="Batman">
    <option value="Şırnak">
    <option value="Bartın">
    <option value="Ardahan">
    <option value="Iğdır">
    <option value="Yalova">
    <option value="Karabük">
    <option value="Kilis">
    <option value="Osmaniye">
    <option value="Düzce">
</datalist>

        <label>Uzmanlık / Hizmet Alanı</label>
        <input type="text" name="uzmanlik" class="input" value="<?php echo $kullanici["uzmanlik"]; ?>">

        <label>Hakkımda</label>
        <textarea name="hakkimda" class="input"><?php echo $kullanici["hakkimda"]; ?></textarea>

        <br><br>

        <button type="submit" name="guncelle" class="btn">
            Profili Güncelle
        </button>

    </form>
    <div class="baglanti-alani">

<h2>Bağlantılar</h2>

<?php

$baglanti_sorgu = mysqli_query($baglanti,

"SELECT kullanicilar.*
FROM baglantilar

JOIN kullanicilar
ON kullanicilar.id = baglantilar.kullanici2

WHERE baglantilar.kullanici1='$kullanici_id'");

while($b = mysqli_fetch_assoc($baglanti_sorgu)){

?>

<div class="baglanti-kart">

    <div class="baglanti-sol">

        <?php if($b["profil_foto"] != ""){ ?>

            <img
            src="<?php echo $b["profil_foto"]; ?>"
            class="mini-foto">

        <?php } ?>

        <div>

            <h3>
                <?php echo $b["adsoyad"]; ?>
            </h3>

            <p>
                <?php echo $b["uzmanlik"]; ?>
            </p>

        </div>

    </div>

</div>

<?php } ?>

</div>

</div>

</body>
</html>