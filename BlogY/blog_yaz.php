<?php

session_start();


include 'oturum_kapali_uyari.php';
include 'header.php';
require_once 'baglan.php';
include 'loading.php';
include 'veritabani_baglanti.php';

$kategoriler_sorgu = $vt->prepare('SELECT kategori_id, kategori FROM kategori');
$kategoriler_sorgu->execute();
$kategoriler = $kategoriler_sorgu->fetchAll(PDO::FETCH_ASSOC);

if (isset($_POST["gonder"])) {
    $baslik = $_POST["baslik"];
    $kategori = $_POST["kategori"];
    $ileti = $_POST["ileti"];
    $foto = $_POST["foto"];
    $gonderen = "" . $_SESSION['user']['id'] . "";
    $gonderen_isim = "" . $_SESSION['user']['Ad_Soyad'] . "";

    if ($baslik != "" and $kategori != "" and $ileti != "") {
        $sorgu = $db->prepare('INSERT INTO blog SET
        baslik = ?,
        Kategori_id = ?,
        ileti = ?,
        gonderen = ?,
        gonderen_isim = ?,
        foto = ?');
        
        $ekle = $sorgu->execute([
            $baslik,
            $kategori,
            $ileti,
            $gonderen,
            $gonderen_isim,
            $foto
        ]);

        if ($ekle) {
            echo '<div class="alert alert-success" role="alert">Kayıt İşlemi Başarılı.</div> ';
            echo '<div class="alert alert-info" role="alert">Blogunuz incelemeden sonra yayınlanacaktır.</div>
            ';

        } else {
            echo '<div class="alert alert-danger" role="alert">Kayıt İşlemi Başarısız.</div> ';

            $hata = $sorgu->errorInfo();
            echo 'mysql hatası :' . $hata[2];
        }
    } else {
        echo '<div class="alert alert-danger" role="alert">Lütfen boş geçmeyin</div> ';


    }
}



?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/blog_yaz.css?v=3" class="style">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <title>Blog Yaz</title>


</head>


<body class="body">


    <div class="icerik">
        <div class="başlık-değer">
            <div class="yazi">Blog Yaz</div>
            <form action="blog_yaz.php" method="POST">
                <div>
                    <input class="Başlık" name="baslik" placeholder="Başlık ">
                </div>
                <div>
                    <select name="kategori" id="kategori" class="kategori">
                        <option value="">Kategori seçin</option>
                        <?php foreach ($kategoriler as $kategori): ?>
                            <option value="<?= $kategori['kategori_id'] ?>"><?= $kategori['kategori'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <div class="mb-3">
                        <input class="form-control" type="file" name="foto" id="formFile">
                    </div>
                </div>
        </div>
        <div class="metin-buton">
            <div><textarea class="metin" name="ileti" placeholder="....."></textarea></div>
            <div class="buttons">
                <button class="buton" name="gonder"> GÖNDER </button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>

</body>

</html>