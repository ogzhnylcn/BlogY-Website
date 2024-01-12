<?php
session_start();

include 'header.php';
include 'loading.php';
include 'veritabani_baglanti.php';
require_once 'kategoriler_liste.php';

$sorgu = $vt->prepare('SELECT * FROM kullanicilar');
$sorgu->execute();
$kullanicilar = $sorgu->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/yonetim_paneli.css" class="style">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <title>BlogY</title>
</head>

<body class="body">
    <div class="sablon">
        <div class="blog ">
            <nav id="nav" class="navbar navbar-expand-lg bg-body-tertiary">
                <div class="container-fluid">
                    <a class="navbar-brand" href="yonetim_paneli.php ">KULLANICILAR</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                        <div class="navbar-nav">
                            <a class="navbar-brand py-2" href="yonetim_kategori_ekle.php ">KATEGORİLER</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                            <a class="nav-link" href="yonetim_blog.php">BLOGLAR</a>
                        </div>
                    </div>
                </div>
            </nav>
            <hr class="hr">
            <div class="basliklar ">
                <h4 style="width: 50px;">id</h4>
                <h4 style="width: 100px;">fotoğraf</h4>
                <h4 style="width: 150px;">İsim Soyisim</h4>
                <h4 style="width: 150px;">Kullanıcı Adı</h4>
                <h4 style="width: 150px;">E-posta</h4>
                <h4 style="width: 150px;">Telefon</h4>
            </div>
            <hr>
            <?php foreach ($kullanicilar as $index => $kullanici): ?>
                <div class="icerikler">
                    <div class="veriler">
                        <div class="id" id="icerik">
                            <?php echo $kullanici['id']; ?>
                        </div>
                        <img src="resim/<?php echo $kullanici['resim']; ?>" class="foto">
                        <a href="yonetim_kullanici.php?id=<?php echo $kullanici['id']; ?>">
                            <div class="adsoyad" id="icerik">
                                <?php echo $kullanici['Ad_Soyad']; ?>
                            </div>
                        </a>
                        <div class="kullaniciad" id="icerik">
                            <?php echo $kullanici['Kullanici_Adi']; ?>
                        </div>
                        <div class="email" id="icerik">
                            <?php echo $kullanici['email']; ?>
                        </div>
                        <div class="tel" id="icerik">
                            <?php echo $kullanici['Telefon']; ?>
                        </div>
                    </div>
                </div>
                <hr>
            <?php endforeach; ?>
        </div>
    </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>
</body>

</html>