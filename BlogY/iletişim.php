<?php

session_start();

require_once 'baglan.php';
include 'header.php';
include 'loading.php';

if (isset($_POST["gonder"])) {
    $name = $_POST["name"];
    $mail = $_POST["mail"];
    $konu = $_POST["konu"];
    $ileti = $_POST["ileti"];
    
    if ($name != "" and $mail != "" and $konu != "" and $ileti != "") {
        $sorgu = $db->prepare('INSERT INTO iletisim SET
    Ad_Soyad =?,
    mail =?,
    konu =?,
    ileti =?');
        $ekle = $sorgu->execute([
            $name,
            $mail,
            $konu,
            $ileti
        ]);
        if ($ekle) {
        } else {
            $hata = $sorgu->errorInfo();
            echo 'mysql hatası :' . $hata[2];
        }
    } else {
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/iletisim2.css?v=" class="style">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <title>İletişim</title>

</head>

<body class="body">
    <div class="merkez">
        <div class="article1">
            <div class="Baslik">Destek Ekibimiz ile iletişime geçerek bize her türlü konuda yazabilirsiniz..</div>
            <div class="icerik1">
                Telefon : +(90) 536 065 7508
            </div>
            <div class="icerik1">
                E-posta : oguzhanyalcin1919@gmail.com
            </div>
            <div class="icerik2">
                <p class="Baslik">SOSYAL MEDYA</p>
                <a target="_blank" href="https://www.instagram.com/ogzhnylcnn_/">
                    <img class="icon1"
                        src="https://www.freepnglogos.com/uploads/logo-ig-png/logo-ig-instagram-icon-download-icons-12.png">
                </a>
                <a target="_blank" href="https://www.linkedin.com/in/o%C4%9Fuzhan-yal%C3%A7in-146833221/">
                    <img class="icon1" src="https://www.freepnglogos.com/uploads/linkedin-logo-black-png-12.png">
                </a>
                <a target="_blank" href="https://twitter.com/OYalcinn_">
                    <img class="icon1"
                        src="https://www.freepnglogos.com/uploads/twitter-logo-png/twitter-logo-white-circle-png-images-23.png">
                </a>
            </div>
        </div>
        <div class="article2">
            <form action="iletişim.php" method="POST">
                <div class="boşluk2"></div>
                <div class="yazı5">Ad Soyad</div>
                <input type="text" class="txt1" name="name">
                <div class="yazı6">E-Posta </div>
                <input type="email" class="txt2" name="mail">
                <div class="yazı7">Konu</div>
                <input type="text" class="txt3" name="konu">
                <div class="yazı8">İleti </div>
                <textarea class="txt4" rows="3" cols="40" name="ileti"></textarea>
                <button class="buton" name="gonder">Gönder</button>
                <?php
                if (isset($_POST["gonder"])) {
                    $name = $_POST["name"];
                    $mail = $_POST["mail"];
                    $konu = $_POST["konu"];
                    $ileti = $_POST["ileti"];
                    if ($name != "" and $mail != "" and $konu != "" and $ileti != "") {
                        echo '<div class="alert alert-success" role="alert">iletiniz gönderildi</div> ';
                    } else {
                        echo '<div class="alert alert-danger" role="alert">Lütfen boş geçmeyin</div> ';
                    }
                }
                ?>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>
</body>

</html>