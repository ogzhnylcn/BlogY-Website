<?php
session_start();

include 'header.php';
include 'loading.php';
include 'veritabani_baglanti.php';
require_once 'kategoriler_liste.php';

setlocale(LC_TIME, 'tr_TR.utf8'); // Türkçe ay adları için locale ayarı yapılıyor

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$perPage = 4;
$totalArticles = $vt->query('SELECT COUNT(*) FROM blog')->fetchColumn();
$totalPages = ceil($totalArticles / $perPage);

if ($page < 1 || $page > $totalPages) {
    header('Location: anasayfa_deneme.php?page=1');
    exit;
}

$limit = $perPage;
$offset = ($page - 1) * $perPage;

$sorgu = $vt->prepare('SELECT * FROM blog ORDER BY gondermetarihi DESC LIMIT :limit OFFSET :offset');
$sorgu->bindValue(':limit', $limit, PDO::PARAM_INT);
$sorgu->bindValue(':offset', $offset, PDO::PARAM_INT);
$sorgu->execute();
$bloglarim = $sorgu->fetchAll(PDO::FETCH_OBJ);
?>

<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/anasayfa_deneme1.css?v=10" class="style">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <title>BlogY</title>
</head>

<body class="body">
    <div class="sablon">
        <img src="resim/daktilo.png" alt="" class="anafoto">
        <div class="solmerkez">
            <div class="icsablon">
                <div class="merkez1">
                    <div class="articles-container">
                        <?php foreach ($bloglarim as $index => $person): ?>
                            <div class="article">
                                <div class="baslik">
                                    <?php echo $person->baslik; ?>
                                </div>
                                <hr>
                                <div class="yayinci">
                                    <?php
                                    $yazarID = $person->gonderen;
                                    $yazarSorgu = $vt->query("SELECT resim FROM kullanicilar WHERE id = '{$yazarID}'");
                                    $yazarBilgi = $yazarSorgu->fetch(PDO::FETCH_ASSOC);
                                    ?>
                                    <img src="resim/<?php echo $yazarBilgi['resim']; ?>" class="kull_foto">
                                    <div class="yazar">
                                        <a href="kullanici_profil.php?id=<?php echo $yazarID; ?>">
                                            <?php echo $person->gonderen_isim; ?>
                                        </a>
                                    </div>
                                    <div class="tarih">
                                        <img src="resim/clock_2838794.png" class="icon me-1">
                                        <?php echo strftime('%d %B %Y', strtotime($person->gondermetarihi)); ?>
                                    </div>
                                    <div class="kategori">
                                        <img src="resim/book_828370.png" class="icon me-1">
                                        <?php
                                        $kategoriSorgu = $vt->query("SELECT kategori FROM kategori WHERE kategori_id = {$person->Kategori_id}");
                                        $kategoriAdi = $kategoriSorgu->fetchColumn();
                                        echo $kategoriAdi;
                                        ?>
                                    </div>
                                </div>
                                <div class="bosluk"></div>
                                <hr class="hr">
                                <div class="veri">
                                    <img src="resim/<?php echo $person->foto; ?>" class="fotograf">
                                    <div class="yazi-buton">
                                        <div class="yazi">
                                            &emsp;&emsp;
                                            <?php echo $person->ileti; ?>
                                        </div>
                                        <a href="icerik.php?blogId=<?= $person->id ?>" class="btn btn-primary">Daha
                                            fazla..</a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <nav class="nav" aria-label="Sayfalama Bölümü">
                <ul class="pagination">
                    <?php if ($page > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="anasayfa_deneme.php?page=<?php echo $page - 1; ?>">Önceki</a>
                        </li>
                    <?php endif; ?>
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>">
                            <a class="page-link" href="anasayfa_deneme.php?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                        </li>
                    <?php endfor; ?>
                    <?php if ($page < $totalPages): ?>
                        <li class="page-item">
                            <a class="page-link" href="anasayfa_deneme.php?page=<?php echo $page + 1; ?>">Sonraki</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
        <div class="sagmerkez">
            <div class="kayit">
                <div class="fototav">
                    <img src="resim/kayit_tavsiye.png" alt="" class="tavfoto">
                </div>
                <h3 class="baslik">Aramıza katıl</h3>
                <div class="yazi">Güncel yazılarımızı takip etmek ve dilediğince yazı yazmak için kayıt olabilirsiniz.
                </div>
                <div class="mail">
                    <input type="mail" placeholder="E-posta">
                </div>
                <button class="buton" name="gonder">Gönder</button>
            </div>
            <div class="iletisim">
                <div class="ustkisim">
                    <div class="baslik">
                        <img src="resim/share.png" class="share me-2">
                        Sosyal Medyada Biz
                    </div>
                    <div class="siyah"></div>
                </div>
                <div class="iconlar">
                    <a href="https://www.instagram.com/ogzhnylcnn_/"><img class="insta me-2" src="resim/instagram.png"
                            alt=""></a>
                    <a href="https://twitter.com/OYalcinn_"><img class="twit me-2" src="resim/twitter.png" alt=""></a>
                    <a href="https://www.linkedin.com/in/o%C4%9Fuzhan-yal%C3%A7in-146833221/"><img class="link me-2"
                            src="resim/linkedin.png" alt=""></a>
                    <a href="https://www.youtube.com/channel/UCjA8ezN9AjgkVCL06aZZGBg"><img class="you me-2"
                            src="resim/youtube.png" alt=""></a>
                </div>
            </div>
            <div class="reklamci">
                <div class="rekbaslik">Reklamınız burada gözüksün! </div>
                <div class="rekyazi"> Kategori ve Arşiv sayfalarına özel bu alanda uygun fiyata reklam vermek isterseniz
                    hemen iletişime geçebilirsiniz.</div>
                <div class="buton">
                    <a href="iletişim.php"> <button class="btn btn-primary" type="button">Reklam Ver</button></a>
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
