<?php
session_start();

include 'header.php';
include 'loading.php';
include 'veritabani_baglanti.php';
require_once 'kategoriler_liste.php';

$kullanici_id = $_GET['id'];
$kullaniciDetay = $vt->query("SELECT * FROM kullanicilar WHERE id = '{$kullanici_id}'")->fetch(PDO::FETCH_OBJ);

if (isset($_POST['SİL'])) {


    $blogSil = "DELETE FROM blog WHERE gonderen = :kullanici_id";

    $sorgu = $vt->prepare($blogSil);
    $sorgu->bindValue(':kullanici_id', $kullanici_id, PDO::PARAM_INT);
    $sorgu->execute();



    $kullaniciSil = "DELETE FROM kullanicilar WHERE id = :kullanici_id";

    $sorgu = $vt->prepare($kullaniciSil);
    $sorgu->bindValue(':kullanici_id', $kullanici_id, PDO::PARAM_INT);
    $sorgu->execute();

    header('Location: yonetim_paneli.php');
    exit();

}





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
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/yonetim_kullanici.css" class="style">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <title>BlogY</title>
</head>

<body class="body">
    <div class="sablon">
        <div class="card-container">
            <img src="resim/<?php echo $kullaniciDetay->resim; ?>" class="foto">
            <h3 class="isimbaslik">
                <?php echo "<div>{$kullaniciDetay->Ad_Soyad}</div>"; ?>
            </h3>
            <h6 class="isimbaslik">
                <?php echo $kullaniciDetay->id; ?>
            </h6>
            <div class="buttons">
                <button class="primary">
                    Mesaj gönder
                </button>
            </div>
            <div class="merkez">
                <div class="solmerkez">
                    <div class="kullaniciad" id="icerik">
                        KULLANICI ADI:
                        <?php echo "<div>{$kullaniciDetay->Kullanici_Adi}</div>"; ?>
                    </div>
                    <div class="email" id="icerik">
                        E-MAİL :
                        <?php echo "<div>{$kullaniciDetay->email}</div>"; ?>
                    </div>
                    <div class="tel" id="icerik">
                        TELEFON :
                        <?php echo "<div>{$kullaniciDetay->Telefon}</div>"; ?>
                    </div>
                </div>
                <div class="sagmerkez">
                    <h3 class="h3">DURUM</h3>
                    <div class="toggle-radio">
                        <input type="radio" name="rdo" id="yes" checked>
                        <input type="radio" name="rdo" id="no">
                        <div class="switch">
                            <label for="yes">Yes</label>
                            <label for="no">No</label>
                        </div>
                    </div>
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                        data-bs-target="#staticBackdrop">Hesabı Sil</button>
                    <!-- Modal -->
                    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false"
                        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Blog Sil</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Blog yazınızı silmek istediğinizden emin misiniz?
                                </div>
                                <!-- SİLME FORMU -->
                                <form action="yonetim_kullanici.php?id=<?php echo $kullanici_id; ?>" method="POST">
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Kapat</button>
                                        <button type="submit" class="btn btn-danger" name="SİL">Sil</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="bloglar">
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
                        <?php echo date('d.m.Y', strtotime($blog->gondermetarihi)); ?>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>
</body>

</html>