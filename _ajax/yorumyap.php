<?php
/* 	iyibu!Portal:PHP _ajax/yorumyap.php dosyası
	Yazım Tarihi: 5 Eylül 2013
	hata1: kullanıcı giriş yapmamış
	hata2: boş alanlar var
	hata3: bağlantı hatası
	Ok: yorum kaydedildi
	*/
header('Content-Type: text/html; charset=iso-8859-9');
require('../baglanti.php');
require('../_inc/fonksiyonlar.php');
function ayıkla($q){
global $baglanti;
$q = trim(trKarakter(strip_tags($baglanti->real_escape_string($q),'<p><a><br><b><i><u><span><div><strong><em>')));
$q = str_replace(array('\n','\r\n','\r'),'',$q);
return $q;
};
$yorum = ayıkla($_POST['yorum']);
$modul = ayıkla($_POST['modul']);
$icerik = ayıkla($_POST['icerik']);
$alt = (int)$_POST['alt'];
$ekleyen = @$_SESSION['kadi'];
if(empty($_SESSION['kadi'])) die('hata1');
if(empty($yorum) || empty($modul) || empty($icerik)) die('hata2');
$baglanti->query("INSERT INTO yorumlar (yorum,ekleyen,modul,icerik,alt) VALUES ('$yorum','$ekleyen','$modul','$icerik','$alt')") or die('hata3');
die('Ok');
?>