<?php session_start();
$_SESSION['yonetici'] = false;
require(__DIR__ . '/../AYARLAR.php');
header('Location: '.$site_adres)
?>