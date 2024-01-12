<?php
error_reporting(0);
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: uye_giris.php');
    echo 'oturum açmanız gerekiyor';

    exit; 
} else{

}

?>











































