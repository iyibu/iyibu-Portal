<?php
/* 	iyibu!Portal:PHP _ajax/uyegiris.php dosyasý
	Yazým Tarihi: 28 Temmmuz 2013
	Deðiþiklik: 29 Temmuz 2013 01:51
	Son Deðiþiklik: 05 Eylül 2013 01:51
	hata1: eksik alan |
	hata2: veritabanýna baðlanýlamýyor
	hata3: kullanýcýadý þifre yanlýþ
	hata4: onaysýz kullanýcý
	hata5: engelli kullanýcý
	Ok: iþlem baþarýlý
	*/
header('Content-Type: text/html; charset=iso-8859-9');
require('../baglanti.php');
require('../_inc/fonksiyonlar.php');
function ayýkla($q){
global $baglanti;
return htmlspecialchars(strip_tags($baglanti->real_escape_string($q)));
};
function geçerli_üye($q){return preg_match('/^[A-Za-z][A-Za-z0-9]*(?:_[A-Za-z0-9]+)*$/',$q);};
$kadi = (isset($_POST['kadi']) == true && geçerli_üye($_POST['kadi']) == true  ? ayýkla($_POST['kadi']) : false);
$þifre = (!empty($_POST['sifre']) ? md5($_POST['sifre']) : false);
if($kadi==false||$þifre==false) die('hata1');
$sql = "SELECT ID, kullaniciadi, Parola, Yetki FROM uyeler WHERE kullaniciadi = '$kadi' AND Parola = '$þifre'";
$sorgu = $baglanti->query($sql) or die('hata2');
$sonuc=$sorgu->fetch_assoc() or die('hata3');
if($sonuc['Yetki']==0) die('hata4');
if($sonuc['Yetki']==-1) die('hata5');
$_SESSION['kadi'] = $sonuc['kullaniciadi'];
die('Ok');
?>