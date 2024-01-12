<?php
include 'veritabani_baglanti.php';
$kategoriler_sorgu = $vt->prepare('SELECT kategori_id, kategori FROM kategori');
$kategoriler_sorgu->execute();
$kategoriler = $kategoriler_sorgu->fetchAll(PDO::FETCH_ASSOC);
?>

<nav  class="navbar  navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <img src="resim/logo.png" class="logo" href="#" />
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll"
            aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarScroll">
            <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="anasayfa_deneme.php">Ana Sayfa</a>
                </li>
                <?php if (isset($_SESSION['user'])) { ?>
                    <li class="nav-item ">
                        <a class="nav-link pt-2 " href="blog_yaz.php">Blog yaz</a>
                    </li>
                <?php } ?>
                <li class="nav-item">
                    <a class="nav-link" href="iletişim.php">İletişim</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Kategori
                    </a>
                    <ul class="dropdown-menu">
                        <?php foreach ($kategoriler as $kategori): ?>
                            <li><a class="dropdown-item" href="kategori.php?kategori_id=<?= $kategori['kategori_id'] ?>"><?= $kategori['kategori'] ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </li>
                <li class="nav-item">
                    <?php if (isset($_SESSION['user']) && $_SESSION['user']['Kullanici_Adi'] == 'Yönetici') { ?>
                        <div class="yonetici" style="display: flex; flex-direction: row;">
                            <a class="nav-link pt-2 " href="yonetim_paneli.php">Yönetim Paneli </a>
                            <a class="nav-link pt-2 " style="color:red;" href="profil.php">Yönetici</a>
                        </div>
                    <?php } elseif (isset($_SESSION['user']) && $_SESSION['user']['Kullanici_Adi'] != 'Yönetici') { ?>
                        <a class="nav-link pt-2 " href="profil.php">Hesabım
                            <?php echo "(" . $_SESSION['user']['Kullanici_Adi'] . ")" ?>
                        </a>
                    <?php } else { ?>
                        <a href="uye_giris.php" class="nav-link">Giriş Yap</a>
                    <?php } ?>
                </li>
            </ul>
            <img src="resim/BlogY Logo - Original - 5000x5000.png" class="logo2" />
        </div>
    </div>
</nav>



