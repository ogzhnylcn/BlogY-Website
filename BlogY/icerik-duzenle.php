<?php
session_start();
ob_start();
require_once 'header.php';
require_once 'baglan.php';
require_once 'loading.php';
include 'veritabani_baglanti.php';

if (isset($_GET['blogId'])) {
    $blog_id = $_GET['blogId'];

    $blogDetay = $vt->query("SELECT * FROM blog WHERE id = '{$blog_id}'")->fetch(PDO::FETCH_OBJ);
} else {
    header("Location: uygun_sayfa.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $baslik = $_POST['baslik'];
    $ileti = $_POST['ileti'];



    $kategori = $_POST['kategori'];

    $query = "UPDATE blog SET baslik = :baslik, ileti = :ileti, kategori_id = :kategori WHERE id = :blog_id";
    $stmt = $vt->prepare($query);
    $stmt->bindParam(':baslik', $baslik);
    $stmt->bindParam(':ileti', $ileti);
    $stmt->bindParam(':kategori', $kategori);
    $stmt->bindParam(':blog_id', $blog_id);

    if ($stmt->execute()) {
        header("Location: icerik.php?blogId={$blog_id}");
        exit;
    } else {
        echo "Güncelleme işlemi sırasında bir hata oluştu!";
    }
}

$kategoriler_sorgu = $vt->prepare('SELECT kategori_id, kategori FROM kategori');
$kategoriler_sorgu->execute();
$kategoriler = $kategoriler_sorgu->fetchAll(PDO::FETCH_ASSOC);
ob_end_flush();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/icerik-duzenle.css?v=7" class="style">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <title>Düzenle</title>
</head>
<body class="body">
    <div class="sablon">
        <form action="icerik-duzenle.php?blogId=<?= $blog_id ?>" method="post">
            <div class="fotoyazi">
                <img src="resim/<?php echo $blogDetay->foto; ?>" class="foto">
                <div class="yazi">
                    <input class="baslik " name="baslik" value="<?php echo $blogDetay->baslik ?>">
                </div>
            </div>
            <div class="yayinci">
                <div class="yazar">
                    <?php echo "<div>{$blogDetay->gonderen_isim}</div>"; ?>
                </div>
                <div class="tarih">
                    <?php echo "<div>{$blogDetay->gondermetarihi}</div>"; ?>
                </div>
                <div class="kategori">
                    <select name="kategori" id="kategori" class="input">
                        <?php foreach ($kategoriler as $kategori): ?>
                            <option value="<?= $kategori['kategori_id'] ?>"
                                <?php if ($kategori['kategori_id'] == $blogDetay->Kategori_id) echo 'selected' ?>>
                                <?= $kategori['kategori'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit" style="height: 30px;" class="btn btn-outline-secondary">GÜNCELLE</button>
                </div>
            </div>
            <div class="ileti">
                <textarea type="textarea" class="ileti" name="ileti"><?php echo $blogDetay->ileti ?></textarea>
            </div>
        </form>
    </div>
</body>

</html>