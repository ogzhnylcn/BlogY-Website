<?php
try {
    $vt->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // SQL sorgusu
    $sql = "SELECT 
                b.id AS blog_id, 
                b.baslik AS blog_baslik, 
                b.gondermetarihi AS blog_tarih, 
                k.kategori AS kategori_baslik, 
                kl.Ad_Soyad AS kullanici_adsoyad,
                kl.Kullanici_Adi AS kullanici_nickname
            FROM 
                blog AS b 
            INNER JOIN 
                kategori AS k ON b.Kategori_id = k.kategori_id 
            INNER JOIN 
                kullanicilar AS kl ON kl.id = b.gonderen AND b.gonderen_isim = kl.Ad_Soyad
            ORDER BY 
                b.gondermetarihi DESC";

    // Sorguyu hazırlayın ve çalıştırın
    $stmt = $vt->prepare($sql);
    $stmt->execute();

    // Sonuçları alın ve işleyin
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($results as $row) {
        // Verileri kullanarak istediğiniz şekilde işlemler yapabilirsiniz
        $blog_id = $row["blog_id"];
        $blog_baslik = $row["blog_baslik"];
        $blog_tarih = $row["blog_tarih"];
        $kategori_baslik = $row["kategori_baslik"];
        $kullanici_adsoyad = $row["kullanici_adsoyad"];
        $kullanici_nickname = $row["kullanici_nickname"];

        // İşlemler...
    }
} catch (PDOException $e) {
    echo "Hata: " . $e->getMessage();
}



    // PDO bağlantısını kapatma
    ?>