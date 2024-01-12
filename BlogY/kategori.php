<?php
session_start();

include 'header.php';
include 'loading.php';
include 'veritabani_baglanti.php';

if (isset($_GET['kategori_id'])) {
    $kategori_id = intval($_GET['kategori_id']);
}

$sorgu = $vt->prepare('SELECT * FROM blog WHERE Kategori_id = :kategori_id');
$sorgu->bindParam(':kategori_id', $kategori_id, PDO::PARAM_INT);
$sorgu->execute();
$bloglarim = $sorgu->fetchAll(PDO::FETCH_OBJ);


$kategoriler_sorgu = $vt->prepare('SELECT kategori_id, kategori FROM kategori');
$kategoriler_sorgu->execute();
$kategoriler = $kategoriler_sorgu->fetchAll(PDO::FETCH_ASSOC);


if (isset($_GET['kategori_id'])) {
    $kategori_id = intval($_GET['kategori_id']);

    $sorgu_kategori = $vt->prepare('SELECT kategori FROM blog WHERE kategori_id = :kategori_id');
    $sorgu_kategori->bindParam(':kategori_id', $kategori_id, PDO::PARAM_INT);
    $sorgu_kategori->execute();
    $kategori = $sorgu_kategori->fetchColumn();
    $kategori = mb_strtoupper($kategori, "UTF-8");



}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/kategori.css?v=4" class="style">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <title>Araştırma</title>
</head>

<body class="body">

    <div class="sablon">
        <div class="cizgi">
            <?php
            if (isset($kategori_id)) {
                $sorgu_kategori = $vt->prepare('SELECT kategori FROM kategori WHERE kategori_id = :kategori_id');
                $sorgu_kategori->bindParam(':kategori_id', $kategori_id, PDO::PARAM_INT);
                $sorgu_kategori->execute();
                $kategori_ad = $sorgu_kategori->fetchColumn();
                if ($kategori_ad) {
                    
                    echo '<h3>' . $kategori_ad . '</h3>';
                } else {
                }
            }
            ?>
        </div>
        <div class="merkez">
            <?php
            foreach ($bloglarim as $index => $person) {
                ?>
                <div class="article">
                    <img src="resim/<?php echo $person->foto; ?>" class="foto">
                    <h4 class="minibaslik">
                        &emsp;
                        <?php echo $person->baslik; ?>
                    </h4>
                    <div class="yazar-tarih">
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
                        <?php echo date('d.m.Y', strtotime($person->gondermetarihi)); ?>
                        </div>
                    </div>
                    <div class="ozet">
                        &emsp;
                        <?php echo $person->ileti; ?>
                    </div>
                    <a href="icerik.php?blogId=<?= $person->id ?>" class="btn btn-primary">Daha fazla..</a>
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