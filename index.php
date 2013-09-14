<?php
header('Content-Type: text/html; charset=iso-8859-9');
require('baglanti.php');
require('_inc/fonksiyonlar.php');
require('_inc/iyibuTema.php');
$iyibu 		= new iyibu_Tema;
$moduller 	= new iyibu;
$iyibu->dizin = '_tema/'.$site_tema.'/';
$iyibu->kaynak('index.tpl');

$iyibu->girdi('uye_giris',0);
if(!empty($_SESSION['kadi'])) $iyibu->girdi('uye_giris',1);
if(!empty($_SESSION['kadi'])) $iyibu->girdi('kullanici',$_SESSION['kadi']);

$iyibu->dizi('site',array('kelime'=>$meta_keywords,'aciklama'=>$meta_desc,'adres'=>rtrim($site_adres, '/'),'baslik'=>$site_baslik,'tema'=>$site_tema));

$iyibu->girdi('sayfa_baslik','Anasayfa');
$iyibu->dizi('modul',array('blok_tip'=>$site_aduzen));

$moduller->menu();
$moduller->bloklar('index','ana');
$moduller->temaAyarlari();

$iyibu->yayýnla();
$moduller->tazele($oturum_tazele);
?>