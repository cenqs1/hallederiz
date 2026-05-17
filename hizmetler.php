<?php
session_start();
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hizmetler | Hallederiz</title>

    <link rel="stylesheet" href="assets/style.css">

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:Arial, Helvetica, sans-serif;
        }

        body{
            min-height:100vh;
            background:
                radial-gradient(circle at left top, rgba(0,255,128,0.28), transparent 28%),
                linear-gradient(110deg, #03140d, #050807 55%, #07361f);
            color:white;
        }

        .navbar{
            width:86%;
            margin:25px auto;
            padding:28px 38px;
            background:rgba(0,0,0,0.72);
            border:1px solid rgba(0,255,128,0.35);
            border-radius:25px;
            display:flex;
            justify-content:space-between;
            align-items:center;
            box-shadow:0 0 28px rgba(0,255,128,0.18);
        }

        .logo{
            font-size:18px;
            font-weight:800;
            letter-spacing:1px;
            text-transform:uppercase;
        }

        .navbar a{
            color:#e8fff2;
            text-decoration:none;
            margin-left:45px;
            font-weight:700;
            transition:0.3s;
        }

        .navbar a:hover{
            color:#22ff8a;
        }

        .hero{
            width:86%;
            margin:95px auto 50px;
        }

        .hero h1{
            font-size:64px;
            line-height:1.1;
            max-width:800px;
            text-shadow:0 0 22px rgba(34,255,138,0.25);
        }

        .hero span{
            color:#57ff9d;
        }

        .hero p{
            margin-top:25px;
            font-size:23px;
            color:#c8d8cc;
            max-width:850px;
        }

        .hizmetler{
            width:86%;
            margin:45px auto 70px;
            display:grid;
            grid-template-columns:repeat(auto-fit, minmax(280px, 1fr));
            gap:25px;
        }

        .kart{
            background:rgba(0,0,0,0.45);
            border:1px solid rgba(34,255,138,0.25);
            border-radius:26px;
            padding:32px;
            min-height:280px;
            transition:0.3s;
            box-shadow:0 0 25px rgba(0,0,0,0.25);
        }

        .kart:hover{
            transform:translateY(-8px);
            border-color:#22ff8a;
            box-shadow:0 0 30px rgba(34,255,138,0.22);
        }

        .ikon{
            width:58px;
            height:58px;
            border-radius:18px;
            background:rgba(34,255,138,0.12);
            border:1px solid rgba(34,255,138,0.35);
            display:flex;
            align-items:center;
            justify-content:center;
            font-size:30px;
            margin-bottom:22px;
        }

        .kart h3{
            font-size:24px;
            margin-bottom:15px;
            color:white;
        }

        .kart p{
            color:#c8d8cc;
            line-height:1.7;
            font-size:16px;
        }

        .btn{
            display:inline-block;
            margin-top:25px;
            padding:13px 26px;
            border-radius:999px;
            background:#2cff8f;
            color:#001b0d;
            text-decoration:none;
            font-weight:800;
            box-shadow:0 0 20px rgba(44,255,143,0.35);
            transition:0.3s;
        }

        .btn:hover{
            transform:scale(1.05);
            background:#6bffb1;
        }

        .alt-bilgi{
            width:86%;
            margin:20px auto 70px;
            padding:28px;
            border-radius:25px;
            background:rgba(0,0,0,0.45);
            border:1px solid rgba(34,255,138,0.25);
            display:flex;
            justify-content:space-between;
            align-items:center;
            gap:20px;
        }

        .alt-bilgi h2{
            font-size:28px;
        }

        .alt-bilgi p{
            color:#c8d8cc;
            margin-top:8px;
        }

        footer{
            text-align:center;
            padding:25px;
            color:#b8c8bd;
            background:rgba(0,0,0,0.55);
        }

        @media(max-width:768px){
            .navbar{
                width:92%;
                flex-direction:column;
                gap:20px;
            }

            .navbar a{
                margin:0 10px;
                font-size:14px;
            }

            .hero{
                width:92%;
                margin-top:60px;
            }

            .hero h1{
                font-size:42px;
            }

            .hero p{
                font-size:18px;
            }

            .hizmetler,
            .alt-bilgi{
                width:92%;
            }

            .alt-bilgi{
                flex-direction:column;
                align-items:flex-start;
            }
        }
    </style>
</head>
<body>

    <div class="navbar">
        <div class="logo">HALLEDERİZ</div>

        <div>
            <a href="index.php">Anasayfa</a>
            <a href="hizmetler.php">Hizmetler</a>
            <a href="giris.php">Giriş Yap</a>
            <a href="kayit.php">Kayıt Ol</a>
        </div>
    </div>

    <section class="hero">
        <h1>İhtiyacın Olan Hizmeti <span>HALLEDERİZ</span></h1>
        <p>Yazılımcı, tasarımcı, tamirci, temizlikçi, nakliyeci ve daha fazlasına dakikalar içinde ulaş.</p>
    </section>

    <section class="hizmetler">

        <div class="kart">
            <div class="ikon">🔧</div>
            <h3>Tamir ve Bakım</h3>
            <p>Ev, ofis veya iş yerindeki küçük tamir, bakım ve onarım işleri için güvenilir hizmet al.</p>
            <a href="giris.php" class="btn">Teklif Al</a>
        </div>

        <div class="kart">
            <div class="ikon">🧹</div>
            <h3>Temizlik Hizmeti</h3>
            <p>Ev temizliği, ofis temizliği ve detaylı temizlik ihtiyaçların için hızlıca teklif oluştur.</p>
            <a href="giris.php" class="btn">Teklif Al</a>
        </div>

        <div class="kart">
            <div class="ikon">💻</div>
            <h3>Teknoloji Desteği</h3>
            <p>Bilgisayar kurulumu, format, yazılım desteği ve teknik sorunların için uzman desteği al.</p>
            <a href="giris.php" class="btn">Teklif Al</a>
        </div>

        <div class="kart">
            <div class="ikon">🚚</div>
            <h3>Nakliye</h3>
            <p>Şehir içi taşıma, küçük nakliye ve eşya taşıma işleri için uygun teklifleri değerlendir.</p>
            <a href="giris.php" class="btn">Teklif Al</a>
        </div>

        <div class="kart">
            <div class="ikon">🎨</div>
            <h3>Boya ve Dekorasyon</h3>
            <p>Ev veya iş yerin için boya, badana ve dekorasyon hizmetlerine kolayca ulaş.</p>
            <a href="giris.php" class="btn">Teklif Al</a>
        </div>

        <div class="kart">
            <div class="ikon">🌐</div>
            <h3>Web Sitesi Hizmeti</h3>
            <p>Kişisel, kurumsal veya işletmene özel modern web sitesi yaptırmak için teklif al.</p>
            <a href="giris.php" class="btn">Teklif Al</a>
        </div>

    </section>

    <section class="alt-bilgi">
        <div>
            <h2>Talebini oluştur, teklifleri karşılaştır.</h2>
            <p>Hizmeti seç, giriş yap ve ihtiyacını birkaç adımda sisteme ekle.</p>
        </div>

        <a href="giris.php" class="btn">Hemen Başla</a>
    </section>

    <footer>
        <p>© 2026 Hallederiz | Tüm hakları saklıdır.</p>
    </footer>

</body>
</html>