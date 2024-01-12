<?php
session_start();

include 'oturum_kapali_uyari.php';
include 'header.php';
include 'veritabani_baglanti.php';
include 'loading.php';

$userID = $_SESSION['user']['id'];

$sorgu = $vt->prepare('SELECT resim FROM kullanicilar WHERE id = :id');
$sorgu->bindValue(':id', $userID, PDO::PARAM_INT);
$sorgu->execute();
$kullanici = $sorgu->fetch(PDO::FETCH_ASSOC);

$resimAdi = $kullanici['resim'];

$user_id = $_SESSION['user']['id'];

$bloglarim = $vt->query("SELECT * FROM blog WHERE gonderen = '{$user_id}'")->fetchAll(PDO::FETCH_OBJ);

$kullanici_id = $_GET['id'];

$blogDetay = $vt->query("SELECT * FROM kullanicilar WHERE id = '{$kullanici_id}'")->fetch(PDO::FETCH_OBJ);

$bloglarKullanici = $vt->query("SELECT * FROM blog WHERE gonderen = '{$kullanici_id}'")->fetchAll(PDO::FETCH_OBJ);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/kullanici_profil.css?v=6" class="style">
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
                    <div class="solkisim">
                        <?php
                        // Kullanıcı bilgilerini çek
                        $sorgu = $vt->prepare('SELECT * FROM kullanicilar WHERE id = :id');
                        $sorgu->bindValue(':id', $kullanici_id, PDO::PARAM_INT);
                        $sorgu->execute();
                        $kullaniciBilgileri = $sorgu->fetch(PDO::FETCH_ASSOC);
                        ?>
                        <img src="resim/<?php echo $kullaniciBilgileri['resim']; ?>" class="profil_foto">
                        <h4 class="h4">İsim Soyisim</h4>
                        <label class="isim">
                            <?php echo $kullaniciBilgileri['Ad_Soyad']; ?>
                        </label>
                        <h4 class="h4">Kullanıcı Adı</h4>
                        <label class="kadi">
                            <?php echo $kullaniciBilgileri['Kullanici_Adi']; ?>
                        </label>
                        <h4 class="h4">Telefon</h4>
                        <label class="kadi">
                            <?php echo $kullaniciBilgileri['Telefon']; ?>
                        </label>
                    </div>
                    <div class="sagkisim">
                        <?php
                        foreach ($bloglarKullanici as $index => $blog) {
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
                                        <?php echo $blog->gondermetarihi; ?>
                                    </div>
                                    <div class="kategori">
                                        <?php echo $kategoriler[$blog->Kategori_id]; ?>
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