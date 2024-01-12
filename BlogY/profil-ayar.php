<?php
session_start();

include 'oturum_kapali_uyari.php';
include 'header.php';
include 'loading.php';
include 'veritabani_baglanti.php';

$id = $_SESSION['user']['id'];
$sorgu = $vt->prepare("SELECT * FROM kullanicilar WHERE id = :id ");
$sorgu->execute(array(":id" => $id));
$row = $sorgu->fetch(PDO::FETCH_ASSOC);

$userID = $_SESSION['user']['id'];

$sorgu = $vt->prepare('SELECT resim FROM kullanicilar WHERE id = :id');
$sorgu->bindValue(':id', $userID, PDO::PARAM_INT);
$sorgu->execute();
$kullanici = $sorgu->fetch(PDO::FETCH_ASSOC);

if (!empty($_POST["resim"])) {
    $resimAdi = $_POST["resim"];
} else {
    $resimAdi = $_POST["eski_resim"];
}

$guncelle = false;

if ($_POST) {
    $name = $_POST["Ad"];
    $nickname = $_POST["KullaniciAdi"];
    $email = $_POST["email"];
    $date = $_POST["dogumt"];
    $phone = $_POST["tel"];

    $guncelleHazirlik = $vt->prepare("UPDATE kullanicilar SET 
    Ad_Soyad = ?,
    Dogum_tarihi = ?,
    email = ?,
    Telefon = ?,
    Kullanici_Adi = ?,
    resim = ?
    WHERE id = '{$id}'");
    
    $guncelleYap = $guncelleHazirlik->execute([
        $name,
        $date,
        $email,
        $phone,
        $nickname,
        $resimAdi
    ]);

    if ($guncelleYap) {
        $_SESSION['user']['Ad_Soyad'] = $name;
        $_SESSION['user']['Dogum_tarihi'] = $date;
        $_SESSION['user']['email'] = $email;
        $_SESSION['user']['Telefon'] = $phone;
        $_SESSION['user']['Kullanici_Adi'] = $nickname;
        $_SESSION['user']['resim'] = $resimAdi;

        echo '<meta http-equiv="refresh" content="0.5;url=profil.php">';
    } else {
        echo 'güncelleme işlemi hatalı';
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/profil-ayar.css?v=3" class="style">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <title>Profil Düzenle</title>
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
                        <div class="bilgiler">
                            <div class="bilgiler-sol">
                                <form action="" method="POST">
                                    <div class="isim">
                                        <h4>İsim Soyisim</h4>
                                        <input type="text" class="input" name="Ad"
                                            value="<?php echo $row["Ad_Soyad"]; ?>">
                                    </div>
                                    <div class="dogumt">
                                        <h4>Doğum Tarihi</h4>
                                        <input type="date" class="input" name="dogumt"
                                            value="<?php echo $row["Dogum_tarihi"]; ?>">
                                    </div>
                                    <div class="e-posta">
                                        <h4>E-posta</h4>
                                        <input type="email" class="input" name="email"
                                            value="<?php echo $row["email"]; ?>">
                                    </div>
                                    <div class="telefon">
                                        <h4>Telefon</h4>
                                        <input type="number" class="input" name="tel"
                                            value="<?php echo $row["Telefon"]; ?>">
                                    </div>
                                    <div class="kadi">
                                        <h4>Kullanıcı Adı</h4>
                                        <input class="input" name="KullaniciAdi"
                                            value="<?php echo $row["Kullanici_Adi"]; ?>">
                                    </div>
                            </div>
                            <div class="bilgiler-sag">
                                <img src="resim/<?php echo $row["resim"]; ?>" class="foto">
                                <form action="" method="POST" enctype="multipart/form-data">
                                    <div class="mb-3">
                                        <input class="form-control" type="file" id="formFile" name="resim">
                                    </div>
                                    <div class="yazi">
                                        <p>Değiştirmek istediğiniz bilgileri yazıp onaylayınız.</p>
                                        <input type="hidden" name="eski_resim" value="<?php echo $row["resim"]; ?>">

                                    </div>
                                    <button type="SUBMİT" class="btn btn-outline-success">ONAYLA</button>
                                </form>
                                <?php
                                if ($guncelle) {
                                    echo '<div class="alert alert-success" role="alert">Bilgileriniz Güncellendi</div> ';
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
        </script>
</body>

</html>