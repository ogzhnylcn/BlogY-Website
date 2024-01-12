<?php
session_start();
include 'oturum_kapali_uyari.php';
include 'header.php';
include 'loading.php';
include 'veritabani_baglanti.php';
require_once 'kategoriler_liste.php';


$user_id = $_SESSION['user']['id'];

$bloglarim = $vt->query("SELECT * FROM blog WHERE gonderen = '{$user_id}'")->fetchAll(PDO::FETCH_OBJ);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/profil_bloglarim.css?v=7" class="style">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <title>Bloglarım</title>
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
                        <?php
                        foreach ($bloglarim as $index => $blog) {
                            ?>
                            <div class="article">
                                <img src="resim/<?php echo $blog->foto; ?>" class="foto">
                                <h4 class="minibaslik">
                                    &emsp;
                                    <?php echo $blog->baslik; ?>
                                </h4>
                                <div class="yazar-tarih">
                                    <div class="yazar">
                                        <?php echo $blog->gonderen_isim; ?>
                                    </div>
                                    <div class="tarih">
                                    <?php echo date('d.m.Y', strtotime($blog->gondermetarihi)); ?>
                                    </div>
                                    <div class="kategori">
                                        <?php echo $kategoriler[$pesron->Kategori_id]; ?>
                                    </div>
                                </div>
                                <div class="ozet">
                                    &emsp;
                                    <?php echo $blog->ileti; ?>
                                </div>
                                <a href="icerik.php?blogId=<?= $blog->id ?>" class="btn btn-primary">Daha fazla..</a>
                            </div>
                            <?php
                        }
                        ?>
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