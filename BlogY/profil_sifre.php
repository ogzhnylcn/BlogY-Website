<?php
include 'oturum_kapali_uyari.php';
include 'header.php';
include 'veritabani_baglanti.php';
include 'loading.php';

if (isset($_POST['kaydet'])) {
    $yeni_sifre = $_POST['yeni_sifre'];
    $yeni_sifre_tekrar = $_POST['yeni_sifre_tekrar'];
    $mevcut_sifre = $_POST['sifre'];

    $userid = $_SESSION['user']['id'];


}
?>





<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/profil-sifre.css" class="style">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <title>Şifre Yenile</title>
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
                        <div class="bilgiler-sol">
                            <form method="POST" action="">
                                <div class="sifre">
                                    <h4>Mevcut Şifreniz</h4>
                                    <input type="password" class="input" name="sifre">
                                </div>
                                <div class="sifre">
                                    <h4>Yeni Şifre</h4>
                                    <input type="password" class="input" name="yeni_sifre">
                                </div>
                                <div class="sifre">
                                    <h4>Yeni Şifre Tekrar</h4>
                                    <input type="password" class="input" name="yeni_sifre_tekrar">
                                    <button type="submit" class="buton" name="kaydet">Kaydet</button>
                                </div>
                            </form>
                            <?php // Mevcut şifreyi doğrulama
                            $getPasswordQuery = "SELECT Parola FROM kullanicilar WHERE id = :userid";
                            $stmt = $vt->prepare($getPasswordQuery);
                            $stmt->bindValue(':userid', $userid);
                            $stmt->execute();
                            $hashed_mevcut_sifre = $stmt->fetchColumn();
                            if (isset($_POST['kaydet'])) {
                                if ($hashed_mevcut_sifre != "" and $yeni_sifre != "" and $yeni_sifre_tekrar != "") {
                                    if ($hashed_mevcut_sifre !== md5($mevcut_sifre)) {
                                        echo '<div class="alert alert-danger">Mevcut şifre yanlış!</div>';
                                        exit();
                                    }
                                    // kontrol et
                                    if ($yeni_sifre != $yeni_sifre_tekrar) {
                                        echo '<div class="alert alert-danger">Yeni şifreler uyuşmuyor!</div>';
                                        exit();
                                    }
                                    $hashed_yeni_sifre = md5($yeni_sifre);
                                    $updateQuery = "UPDATE kullanicilar SET Parola = :Parola WHERE id = :userid";
                                    $stmt = $vt->prepare($updateQuery);
                                    $stmt->bindValue(':Parola', $hashed_yeni_sifre);
                                    $stmt->bindValue(':userid', $userid);
                                    if ($stmt->execute()) {
                                        echo '<div class="alert alert-success">Şifreniz başarıyla güncellendi!</div>';
                                    } else {
                                        $error = $stmt->errorInfo();
                                        echo 'mysql hatası: ' . $error[2];
                                    }
                                } else {
                                    echo '<div class="alert alert-danger">Lütfen boş alanları doldurunuz!</div>';
                                }
                            }
                            ?>
                        </div>
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