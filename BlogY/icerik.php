<?php
session_start();
ob_start();
include 'header.php';
require_once 'baglan.php';
include 'loading.php';
include 'veritabani_baglanti.php';
require_once 'kategoriler_liste.php';

$blog_id = $_GET['blogId'];
$blogDetay = $vt->query("SELECT * FROM blog WHERE id = '{$blog_id}'")->fetch(PDO::FETCH_OBJ);

$user_id = $_SESSION['user']['id'];

if (isset($_POST['Sil'])) {
    $blogId = $_GET['blogId']; // Silinecek blog ID'sini al
    $userid = $_SESSION['user']['id'];

    // Giriş yapan kullanıcının blogunu sadece silinecek blogun sahibi silebilir
    $deleteBlogQuery = "DELETE FROM blog WHERE id = :blogId AND gonderen = :userid";
    $stmt = $vt->prepare($deleteBlogQuery);
    $stmt->bindValue(':blogId', $blogId, PDO::PARAM_INT);
    $stmt->bindValue(':userid', $userid, PDO::PARAM_INT);
    $stmt->execute();


    if ($_SESSION['user']['Kullanici_Adi'] == 'Yönetici') {
        header('Location: yonetim_blog.php');


    } else {
        header('Location: profil_bloglarim.php');
    }
    exit();
}

ob_end_flush();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/icerik.css?v=8" class="style">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <title>Teknoloji</title>
</head>

<body class="body">
    <div class="sablon">
        <div class="fotoyazi">
            <img src="resim/<?php echo $blogDetay->foto; ?>" class="foto">
            <div class="yazi">
                <?= $blogDetay->baslik ?>
            </div>
        </div>
        <div class="yayinci">
            <?php
            $yazarID = $blogDetay->gonderen; // $person->gonderen; ifadesi değiştirildi
            $yazarSorgu = $vt->query("SELECT resim FROM kullanicilar WHERE id = '{$yazarID}'");
            $yazarBilgi = $yazarSorgu->fetch(PDO::FETCH_ASSOC);
            ?>
            <img src="resim/<?php echo $yazarBilgi['resim']; ?>" class="kull_foto"></img>
            <div class="yazar">
                <a href="kullanici_profil.php?id=<?php echo $yazarID; ?>"> <?php echo $blogDetay->gonderen_isim; ?></a>
            </div>
            <hr>
            <div class="tarih me-2 ">
                <?php echo "<div>{$blogDetay->gondermetarihi}</div>"; ?>
            </div>
            <hr>
            <div class="kategori">
                <?php
                $kategoriId = $blogDetay->Kategori_id;
                $kategoriSorgu = $vt->query("SELECT kategori FROM kategori WHERE kategori_id = '{$kategoriId}'");
                $kategoriAdi = $kategoriSorgu->fetchColumn();
                echo "{$kategoriAdi}";
                ?>
            </div>
            <?php
            if (isset($_SESSION['user']) && $blogDetay->gonderen == $_SESSION['user']['id']) {
                echo '<a href="icerik-duzenle.php?blogId=' . $blog_id . '" type="button" class="btn btn-outline-secondary">DÜZENLE</a>'; ?>
                <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                    data-bs-target="#staticBackdrop"> SİL</button>
                <!-- Modal -->
                <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                    aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="staticBackdropLabel">Blog Sil</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Blog yazınızı silmek istediğinizden emin misiniz?
                            </div>
                            <!-- SİLME FORMU -->
                            <form action="icerik.php?blogId=<?php echo $blog_id; ?>" method="POST">
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Vazgeç</button>
                                    <button type="submit" class="btn btn-danger" name="Sil">Sil</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <?php } elseif ($_SESSION['user']['Kullanici_Adi'] == 'Yönetici') {
                echo '<a href="icerik-duzenle.php?blogId=' . $blog_id . '" type="button"
                    class="btn btn-outline-secondary">DÜZENLE</a>'; ?>
                <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                    data-bs-target="#staticBackdrop"> SİL</button>
                <!-- Modal -->
                <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                    aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="staticBackdropLabel">Blog Sil</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Blog yazınızı silmek istediğinizden emin misiniz?
                            </div>
                            <!-- SİLME FORMU -->
                            <form action="icerik.php?blogId=<?php echo $blog_id; ?>" method="POST">
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Vazgeç</button>
                                    <button type="submit" id="ikiOncekiButton" class="btn btn-danger"
                                        name="Sil">Sil</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            <?php } ?>
        </div>
        <div class="ileti">
            <?php echo "<div>{$blogDetay->ileti}</div>"; ?>
        </div>
    </div>



    <script>
        // İki önceki sayfaya gitmek için düğmeye tıklama olayını dinleyin
        var ikiOncekiButton = document.getElementById("ikiOncekiButton");
        ikiOncekiButton.addEventListener("click", function () {
            // 2 önceki sayfaya git
            history.go(-2);
        });
    </script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>
</body>

</html>