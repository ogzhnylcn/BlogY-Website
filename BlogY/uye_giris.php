<?php
session_start();
error_reporting(0);

include 'loading.php';

$db = new PDO("mysql:host=localhost;dbname=uyelik", 'root', '');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if ($_POST) {
    $Gelenmail = $_POST['nickname'];
    $Gelensifre = $_POST['password'];

    if (!empty($Gelenmail) && !empty($Gelensifre)) {
        $stmt = $db->prepare("SELECT * FROM kullanicilar WHERE Kullanici_Adi = :nickname AND Parola = :password");
        $stmt->bindParam(':nickname', $Gelenmail);
        $stmt->bindParam(':password', md5($Gelensifre));
        $stmt->execute();

        $user = $stmt->fetch();

        if ($user) {
            $_SESSION['user'] = $user;
            header("location:anasayfa_deneme.php");
        } else {
            echo '<div class="alert alert-danger" role="alert">Bilgiler Hatalı</div>';
        }
    } else {
        echo '<div class="alert alert-danger" role="alert">Lütfen boş geçmeyin</div>';
    }
}
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/uye_giris.css" class="style">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <title>Giriş Yap</title>

</head>

<body class="body">
    <div class="Sablon">
        <form method="post">
            <p class="baslik">GİRİŞ YAP </p>
            <div class="article2">
                <input class="username" type="text" placeholder="Kullanıcı Adı" name="nickname">
                <input class="password" type="password" placeholder="Şifre" name="password">
            </div>
            <form action="uye_giris.php" method="POST">
                <button class="button1" type="text"> Giriş Yap</button>
            </form>
            <hr class="hr" />
            <form action="uye_kayit.php">
                <button class="button2" type="text">Yeni Hesap Aç</button>
            </form>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>
</body>

</html>