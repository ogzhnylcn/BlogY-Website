<?php
try {
    $host = 'localhost';
    $vtadi = 'uyelik'; // veritabanı adı
    $kullanici = 'root'; //varsayılan olarak kullanıcı ismi
    $sifre = ''; //Varsayılan olarak Mysql root şifresi boş
    $vt = new PDO("mysql:host=$host;dbname=$vtadi;charset=UTF8", "$kullanici", $sifre);
} catch (PDOException $e) {
    print $e->getMessage();
} 
?>






