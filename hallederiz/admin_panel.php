<?php
session_start();
include("database.php");
global $baglanti;

if(!isset($_SESSION["kullanici_id"])){
    header("Location:giris.php");
    exit();
}

if($_SESSION["rol"] != "admin"){
    header("Location:panel.php");
    exit();
}

$toplam_kullanici = mysqli_fetch_assoc(mysqli_query($baglanti, "SELECT COUNT(*) AS toplam FROM kullanicilar"))["toplam"];
$toplam_talep = mysqli_fetch_assoc(mysqli_query($baglanti, "SELECT COUNT(*) AS toplam FROM talepler"))["toplam"];
$toplam_teklif = mysqli_fetch_assoc(mysqli_query($baglanti, "SELECT COUNT(*) AS toplam FROM teklifler"))["toplam"];
$toplam_mesaj = mysqli_fetch_assoc(mysqli_query($baglanti, "SELECT COUNT(*) AS toplam FROM mesajlar"))["toplam"];

$kullanici_sorgu = mysqli_query($baglanti, "SELECT * FROM kullanicilar ORDER BY id DESC");
$talep_sorgu = mysqli_query($baglanti, "SELECT * FROM talepler ORDER BY id DESC");
$teklif_sorgu = mysqli_query($baglanti, "SELECT * FROM teklifler ORDER BY id DESC");

$mesaj_sorgu = mysqli_query($baglanti, "
SELECT 
mesajlar.*,
gonderen.adsoyad AS gonderen_ad,
alici.adsoyad AS alici_ad
FROM mesajlar
INNER JOIN kullanicilar AS gonderen
ON mesajlar.gonderen_id = gonderen.id
INNER JOIN kullanicilar AS alici
ON mesajlar.alici_id = alici.id
ORDER BY mesajlar.id DESC
");
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Admin Paneli - HALLEDERİZ</title>
    <link rel="stylesheet" href="assets/style.css">

    <style>
        .admin-kutu{
            width:90%;
            margin:50px auto;
        }

        .admin-baslik{
            font-size:42px;
            color:#2cff8f;
            margin-bottom:10px;
            text-shadow:0 0 15px rgba(44,255,143,0.45);
        }

        .uyari{
            color:#ccc;
            margin-bottom:25px;
        }

        .dashboard-alani{
            display:grid;
            grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
            gap:20px;
            margin-bottom:35px;
        }

        .dashboard-kart{
            background:rgba(0,0,0,0.55);
            border:1px solid rgba(44,255,143,0.35);
            border-radius:22px;
            padding:25px;
            box-shadow:0 0 22px rgba(44,255,143,0.12);
            transition:0.3s;
        }

        .dashboard-kart:hover{
            transform:translateY(-5px);
            box-shadow:0 0 30px rgba(44,255,143,0.28);
        }

        .dashboard-kart h2{
            font-size:40px;
            color:#2cff8f;
            margin-bottom:8px;
        }

        .dashboard-kart p{
            color:white;
            font-size:17px;
        }

        .admin-kart{
            background:rgba(0,0,0,0.45);
            border:1px solid rgba(44,255,143,0.25);
            border-radius:20px;
            padding:25px;
            margin-bottom:35px;
            overflow-x:auto;
            box-shadow:0 0 18px rgba(44,255,143,0.08);
        }

        .admin-kart h2{
            margin-bottom:20px;
            color:white;
        }

        table{
            width:100%;
            border-collapse:collapse;
            color:white;
        }

        th, td{
            padding:12px;
            border-bottom:1px solid rgba(255,255,255,0.15);
            text-align:left;
        }

        th{
            color:#2cff8f;
        }

        .mini-foto{
            width:45px;
            height:45px;
            border-radius:50%;
            object-fit:cover;
            border:2px solid #2cff8f;
        }

        .foto-yok{
            width:45px;
            height:45px;
            border-radius:50%;
            border:2px solid #2cff8f;
            display:flex;
            align-items:center;
            justify-content:center;
            color:#2cff8f;
            font-size:11px;
        }

        .rol-badge{
            padding:7px 12px;
            border-radius:20px;
            font-weight:bold;
            font-size:13px;
            display:inline-block;
        }

        .rol-admin{
            background:rgba(255,77,77,0.18);
            color:#ff4d4d;
            border:1px solid #ff4d4d;
        }

        .rol-isveren{
            background:rgba(44,255,143,0.15);
            color:#2cff8f;
            border:1px solid #2cff8f;
        }

        .rol-musteri{
            background:rgba(80,170,255,0.15);
            color:#50aaff;
            border:1px solid #50aaff;
        }

        .sil-btn{
            background:#ff4d4d;
            color:white;
            padding:7px 12px;
            border-radius:8px;
            text-decoration:none;
            font-weight:bold;
        }

        .sil-btn:hover{
            background:#ff2222;
        }

        .admin-yazi-kisa{
            max-width:330px;
            white-space:nowrap;
            overflow:hidden;
            text-overflow:ellipsis;
        }
        .admin-mesaj-alani{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(320px,1fr));
    gap:18px;
}

.admin-mesaj-kart{
    background:rgba(255,255,255,0.04);
    border:1px solid rgba(44,255,143,0.22);
    border-radius:18px;
    padding:18px;
    box-shadow:0 0 18px rgba(44,255,143,0.08);
    transition:0.3s;
}

.admin-mesaj-kart:hover{
    transform:translateY(-4px);
    border-color:#2cff8f;
    box-shadow:0 0 25px rgba(44,255,143,0.18);
}

.admin-mesaj-ust{
    display:flex;
    align-items:center;
    gap:10px;
    margin-bottom:12px;
    flex-wrap:wrap;
}

.mesaj-kisi{
    background:rgba(44,255,143,0.12);
    border:1px solid rgba(44,255,143,0.35);
    color:#2cff8f;
    padding:7px 12px;
    border-radius:20px;
    font-weight:bold;
}

.mesaj-ok{
    color:white;
    font-weight:bold;
}

.admin-mesaj-icerik{
    color:white;
    background:rgba(0,0,0,0.35);
    border-radius:14px;
    padding:14px;
    line-height:1.5;
    margin-bottom:12px;
}

.admin-mesaj-alt{
    color:#aaa;
    font-size:13px;
}
html{
    scroll-behavior:smooth;
}

.dashboard-kart{
    text-decoration:none;
    color:inherit;
    cursor:pointer;
}
    </style>
</head>
<body>

<header>
    <div class="logo">HALLEDERİZ</div>

    <nav>
        <a href="admin_panel.php">Admin Paneli</a>
        <a href="index.php">Çıkış Yap</a>
    </nav>
</header>

<div class="admin-kutu">

    <h1 class="admin-baslik">Admin Paneli</h1>
    <p class="uyari">Buradan kullanıcıları, talepleri, teklifleri ve sohbet mesajlarını yönetebilirsin.</p>

    <div class="dashboard-alani">
        <a href="#kullanicilar" class="dashboard-kart">
    <h2><?php echo $toplam_kullanici; ?></h2>
    <p>Toplam Kullanıcı</p>
</a>

<a href="#talepler" class="dashboard-kart">
    <h2><?php echo $toplam_talep; ?></h2>
    <p>Toplam Talep</p>
</a>

<a href="#teklifler" class="dashboard-kart">
    <h2><?php echo $toplam_teklif; ?></h2>
    <p>Toplam Teklif</p>
</a>

<a href="#mesajlar" class="dashboard-kart">
    <h2><?php echo $toplam_mesaj; ?></h2>
    <p>Toplam Mesaj</p>
</a>


    </div>

    <div class="admin-kart" id="kullanicilar">
    <h2>Kullanıcılar</h2>
        <table>
            <tr>
                <th>Foto</th>
                <th>ID</th>
                <th>Ad Soyad</th>
                <th>Email</th>
                <th>Rol</th>
                <th>İşlem</th>
            </tr>

            <?php while($kullanici = mysqli_fetch_assoc($kullanici_sorgu)){ ?>
                <tr>
                    <td>
                        <?php if($kullanici["profil_foto"] != ""){ ?>
                            <img src="<?php echo $kullanici["profil_foto"]; ?>" class="mini-foto">
                        <?php } else { ?>
                            <div class="foto-yok">Foto</div>
                        <?php } ?>
                    </td>

                    <td><?php echo $kullanici["id"]; ?></td>
                    <td><?php echo $kullanici["adsoyad"]; ?></td>
                    <td><?php echo $kullanici["email"]; ?></td>

                    <td>
                        <?php if($kullanici["rol"] == "admin"){ ?>
                            <span class="rol-badge rol-admin">Admin</span>
                        <?php } elseif($kullanici["rol"] == "isveren"){ ?>
                            <span class="rol-badge rol-isveren">İşveren</span>
                        <?php } else { ?>
                            <span class="rol-badge rol-musteri">Müşteri</span>
                        <?php } ?>
                    </td>

                    <td>
                        <?php if($kullanici["id"] != $_SESSION["kullanici_id"]){ ?>
                            <a class="sil-btn" href="admin_kullanici_sil.php?id=<?php echo $kullanici["id"]; ?>">
                                Sil
                            </a>
                        <?php } else { ?>
                            Admin
                        <?php } ?>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>

    <div class="admin-kart" id="talepler">
        <h2>Talepler</h2>

        <table>
            <tr>
                <th>ID</th>
                <th>Kullanıcı ID</th>
                <th>Başlık</th>
                <th>Açıklama</th>
                <th>Kategori</th>
                <th>Bütçe</th>
                <th>İşlem</th>
            </tr>

            <?php while($talep = mysqli_fetch_assoc($talep_sorgu)){ ?>
                <tr>
                    <td><?php echo $talep["id"]; ?></td>
                    <td><?php echo $talep["kullanici_id"]; ?></td>
                    <td><?php echo $talep["baslik"]; ?></td>
                    <td class="admin-yazi-kisa"><?php echo $talep["aciklama"]; ?></td>
                    <td><?php echo $talep["kategori"]; ?></td>
                    <td><?php echo $talep["butce"]; ?> TL</td>
                    <td>
                        <a class="sil-btn" href="admin_talep_sil.php?id=<?php echo $talep["id"]; ?>">
                            Sil
                        </a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>

    <div class="admin-kart">
        <h2>Teklifler</h2>

        <table>
            <tr>
                <th>ID</th>
                <th>Talep ID</th>
                <th>Kullanıcı ID</th>
                <th>Teklif</th>
                <th>Fiyat</th>
                <th>İşlem</th>
            </tr>

            <?php while($teklif = mysqli_fetch_assoc($teklif_sorgu)){ ?>
                <tr>
                    <td><?php echo $teklif["id"]; ?></td>
                    <td><?php echo $teklif["talep_id"]; ?></td>
                    <td><?php echo $teklif["kullanici_id"]; ?></td>
                    <td class="admin-yazi-kisa"><?php echo $teklif["teklif"]; ?></td>
                    <td><?php echo $teklif["fiyat"]; ?> TL</td>
                    <td>
                        <a class="sil-btn" href="admin_teklif_sil.php?id=<?php echo $teklif["id"]; ?>">
                            Sil
                        </a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>

  <div class="admin-kart" id="mesajlar">
    <h2>Sohbet Mesajları</h2>

    <div class="admin-mesaj-alani">

        <?php while($mesaj = mysqli_fetch_assoc($mesaj_sorgu)){ ?>

            <div class="admin-mesaj-kart">

                <div class="admin-mesaj-ust">
                    <span class="mesaj-kisi">
                        <?php echo $mesaj["gonderen_ad"]; ?>
                    </span>

                    <span class="mesaj-ok">→</span>

                    <span class="mesaj-kisi">
                        <?php echo $mesaj["alici_ad"]; ?>
                    </span>
                </div>

                <div class="admin-mesaj-icerik">
                    <?php echo $mesaj["mesaj"]; ?>
                </div>

                <div class="admin-mesaj-alt">
                    Mesaj ID: <?php echo $mesaj["id"]; ?> |
                    <?php echo $mesaj["tarih"]; ?>
                </div>

            </div>

        <?php } ?>

    </div>
</div>

</div>

</body>
</html>