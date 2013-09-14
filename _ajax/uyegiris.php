<?php
/* 	iyibu!Portal:PHP _ajax/uyegiris.php dosyas�
	Yaz�m Tarihi: 28 Temmmuz 2013
	De�i�iklik: 29 Temmuz 2013 01:51
	Son De�i�iklik: 05 Eyl�l 2013 01:51
	hata1: eksik alan |
	hata2: veritaban�na ba�lan�lam�yor
	hata3: kullan�c�ad� �ifre yanl��
	hata4: onays�z kullan�c�
	hata5: engelli kullan�c�
	Ok: i�lem ba�ar�l�
	*/
header('Content-Type: text/html; charset=iso-8859-9');
require('../baglanti.php');
require('../_inc/fonksiyonlar.php');
function ay�kla($q){
global $baglanti;
return htmlspecialchars(strip_tags($baglanti->real_escape_string($q)));
};
function ge�erli_�ye($q){return preg_match('/^[A-Za-z][A-Za-z0-9]*(?:_[A-Za-z0-9]+)*$/',$q);};
$kadi = (isset($_POST['kadi']) == true && ge�erli_�ye($_POST['kadi']) == true  ? ay�kla($_POST['kadi']) : false);
$�ifre = (!empty($_POST['sifre']) ? md5($_POST['sifre']) : false);
if($kadi==false||$�ifre==false) die('hata1');
$sql = "SELECT ID, kullaniciadi, Parola, Yetki FROM uyeler WHERE kullaniciadi = '$kadi' AND Parola = '$�ifre'";
$sorgu = $baglanti->query($sql) or die('hata2');
$sonuc=$sorgu->fetch_assoc() or die('hata3');
if($sonuc['Yetki']==0) die('hata4');
if($sonuc['Yetki']==-1) die('hata5');
$_SESSION['kadi'] = $sonuc['kullaniciadi'];
die('Ok');
?>