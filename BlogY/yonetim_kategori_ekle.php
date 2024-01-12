<?php
session_start();

include 'header.php';
include 'loading.php';
include 'veritabani_baglanti.php';
require_once 'kategoriler_liste.php';

$kategoriler = $vt->query("SELECT * FROM kategori ORDER BY kategori_id ", PDO::FETCH_ASSOC);



if ($_POST) {
    if ($_POST['type'] == 'kategoriEkle') {
        $kategori = $_POST['kategori'];
        if (isset($kategori) && !empty($kategori)) {
            // Kategoriyi veritabanına eklemeden önce var mı kontrolü yapalım
            $kategoriKontrol = $vt->prepare("SELECT kategori_id FROM kategori WHERE kategori = ?");
            $kategoriKontrol->execute([$kategori]);

            if ($kategoriKontrol->rowCount() > 0) {
                echo "Bu kategori zaten mevcut.";
            } else {
                $kategoriEkle = $vt->prepare("INSERT INTO kategori SET kategori = ?");
                $kaydet = $kategoriEkle->execute([$kategori]);

                if ($kaydet) {
                    echo "Kategori başarıyla eklendi.";

                    echo '<meta http-equiv="refresh" content="0.5;url=yonetim_kategori_ekle.php">';
                } else {
                    echo "Kategori eklenirken bir hata oluştu.";
                }
            }
        } else {
            echo "Kategori boş olamaz.";
        }
    } elseif ($_POST['type'] == 'kategoriSil') {
        // Kategori silme işlemi
    } elseif ($_POST['type'] == 'kategoriDuzenle') {
        // Kategori düzenleme işlemi
    }
}
?>

<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/kategori_ekle.css?v=10" class="style">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <title>BlogY</title>
</head>
<body class="body">
    <div class="sablon">
        <div class="container py-5" id="container">
            <nav id="nav" class="navbar navbar-expand-lg bg-body-tertiary">
                <div class="container-fluid">
                    <a class="navbar-brand" href="yonetim_paneli.php ">KULLANICILAR</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                        <div class="navbar-nav">
                            <a class="navbar-brand py-2" href="yonetim_kategori_ekle.php ">KATEGORİLER</a>
                            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                                data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup"
                                aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                            <a class="nav-link" href="yonetim_blog.php">BLOGLAR</a>
                        </div>
                    </div>
                </div>
            </nav>
            <div class="row mb-3">
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="100">ID</th>
                                    <th>Başlık</th>
                                    <th width="160">Blog Sayısı
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($kategoriler->rowCount()): ?>
                                    <?php foreach ($kategoriler as $kategori): ?>
                                        <tr>
                                            <td>
                                                <?= $kategori['kategori_id'] ?>
                                            </td>
                                            <td>
                                                <?= $kategori['kategori'] ?>
                                            </td>
                                            <td class="text-end">
                                                <?php
                                                $kategoriId = $kategori['kategori_id'];
                                                $blogSayisiSorgusu = $vt->prepare("SELECT COUNT(*) AS blog_sayisi FROM blog WHERE Kategori_id = ?");
                                                $blogSayisiSorgusu->execute([$kategoriId]);
                                                $blogSayisi = $blogSayisiSorgusu->fetch(PDO::FETCH_ASSOC)['blog_sayisi'];
                                                echo $blogSayisi;
                                                ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4">Hiç kategori eklenmedi.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                        <div class="col-12">
                            <button type="button" class="btn btn-primary" id="katekle" data-bs-toggle="modal"
                                data-bs-target="#exampleModal">Yeni
                                Kategori Ekle</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <form action="" method="POST" class="modal-dialog">
                <input type="hidden" name="type" value="kategoriEkle">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Yeni Kategori Oluşturma</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Başlık</label>
                            <input type="text" class="form-control" name="kategori" id="exampleFormControlInput1"
                                required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Vazgeç</button>
                        <button type="submit" class="btn btn-success">Kaydet</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>
</body>

</html>