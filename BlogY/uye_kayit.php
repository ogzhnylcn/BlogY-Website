<?php

require_once 'baglan.php';
include 'loading.php';

if (isset($_POST['kaydet'])) {
    $name = $_POST["Ad"];
    $nickname = $_POST["KullaniciAdi"];
    $email = $_POST["email"];
    $password = $_POST["parola"];
    $date = $_POST["dogumt"];
    $phone = $_POST["tel"];
    $image = "user_1077114.png";

    $kontrolEmail = $db->prepare("SELECT * FROM kullanicilar WHERE email=?");
    $kontrolNickname = $db->prepare("SELECT * FROM kullanicilar WHERE Kullanici_Adi=?");
    $kontrolEmail->execute(array($email));
    $kontrolNickname->execute(array($nickname));

    if ($kontrolEmail->rowCount()) {
        echo '<div class="alert alert-danger" role="alert"> E-Posta adresi zaten kayıtlı! </div> ';
    } elseif ($kontrolNickname->rowCount()) {
        echo '<div class="alert alert-danger" role="alert"> Kullanıcı Adı zaten kayıtlı! </div> ';
    } else {
        if ($name != "" and $nickname != "" and $email != "" and $password != "" and $date != "" and $phone != "") {
            $sorgu = $db->prepare('INSERT INTO kullanicilar SET
                Ad_Soyad =?,
                Kullanici_Adi=?,
                email=?,
                Parola=?,
                Dogum_tarihi=?,
                Telefon=?,
                resim=?
                ');
            $ekle = $sorgu->execute([
                $name,
                $nickname,
                $email,
                md5($password),
                $date,
                $phone,
                $image
            ]);

            if ($ekle) {
                echo '<div class="alert alert-success" role="alert">Kayıt İşlemi Başarılı</div> ';
            } else {
                $hata = $sorgu->errorInfo();
                echo '<div class="alert alert-danger" role="alert">mysql hatası: ' . $hata[2] . '</div> ';
            }
        } else {
            echo '<div class="alert alert-danger" role="alert">Kayıt İşlemi Başarısız. Tüm alanları doldurun.</div> ';
        }
    }
}

?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/uye_kayit.css?v=2" class="style">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <title>Üye Kayıt</title>


</head>

<body class="body">
    <div class="Sablon">
        <p class="baslik">KAYDOL </p>
        <form action="uye_kayit.php" method="POST">
            <div class="article">
                <input type="text" class="input" name="Ad" placeholder="İsim Soyisim">
            </div>
            <div class="article">
                <input class="input" name="KullaniciAdi" placeholder="Kullanıcı Adı">
            </div>
            <div class="article">
                <input class="input" type="email" name="email" placeholder="E-mail">
            </div>
            <div class="article">
                <input type="password" class="input" name="parola" placeholder="Parola">
            </div>
            <div class="article">
                <input class="input" type="date" name="dogumt" placeholder="Doğum Tarihi">
            </div>
            <div class="article">
                <input class="input" name="tel" placeholder="Telefon">
            </div>
            <form action="uye_kayit.php" method="POST">
                <button class="button" id="btn1" name="kaydet" type="submit">Kayıt ol</button>
            </form>
            <form action="uye_giris.php">
                <button class="button" type="submit">Giriş Yap</button>
            </form>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>
</body>

</html>