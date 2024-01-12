<?php
session_start();


include 'oturum_kapali_uyari.php';
include 'header.php';
include 'veritabani_baglanti.php';
include 'loading.php';
include 'sql_sorgu.php';




$userID = $_SESSION['user']['id'];

$sorgu = $vt->prepare('SELECT resim FROM kullanicilar WHERE id = :id');
$sorgu->bindValue(':id', $userID, PDO::PARAM_INT);
$sorgu->execute();
$kullanici = $sorgu->fetch(PDO::FETCH_ASSOC);

$resimAdi = $kullanici['resim'];


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/profil.css?v=6" class="style">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <title>Profil</title>
</head>

<body class="body">
    <div class="container text-center">
        <div class="row">
            <div class="col">
                <div class="icerik">
                    <div class="sol-merkez">
                        <ul class="menu">
                            <li><a href="profil.php">Profil</a></li>
                            <li><a href="profil_bloglarim.php">Bloglarım</a></li>
                            <li><a href="profil_sifre.php">Şifre Yenile</a></li>
                            <li><a href="cikis.php">Çıkış</a></li>
                        </ul>
                    </div>
                    <div class="sag-merkez">
                        <div class="bilgiler-sol">
                            <h4 class="h4">Doğum Tarihi</h4>
                            <label class="dogumt">
                                <?php echo "" . $_SESSION['user']['Dogum_tarihi'] . "" ?>
                            </label>
                            <h4 class="h4">E-posta</h4>
                            <label class="e-posta">
                                <?php echo "" . $_SESSION['user']['email'] . "" ?>
                            </label>
                        </div>
                        <div class="ortakisim">
                            <img src="resim/<?php echo $resimAdi; ?>" class="foto">
                            <h4 class="h4">İsim Soyisim</h4>
                            <label class="isim">
                                <?php echo "" . $_SESSION['user']['Ad_Soyad'] . "" ?>
                            </label>
                            <form action="profil-ayar.php">
                                <button type="submit" class="btn btn-outline-secondary">DÜZENLE</button>
                            </form>
                        </div>
                        <div class="bilgiler-sag">
                            <div class="bosluk"></div>
                            <h4 class="h4">Telefon</h4>
                            <label class="telefon">
                                <?php echo "" . $_SESSION['user']['Telefon'] . "" ?>
                            </label>
                            <h4 class="h4">Kullanıcı Adı</h4>
                            <label class="kadi">
                                <?php echo "" . $_SESSION['user']['Kullanici_Adi'] . "" ?>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>
</body>

</html>