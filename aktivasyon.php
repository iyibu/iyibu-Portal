<?php /* 	iyibu!Portal:PHP aktivasyon.php dosyas�
	Yaz�m Tarihi: 14 Eyl�l 2013 00:59
	*/
header('Content-Type: text/html; charset=iso-8859-9');
require('baglanti.php');
require('_inc/fonksiyonlar.php');
function ay�kla($q){
global $baglanti;
return htmlspecialchars(strip_tags($baglanti->real_escape_string($q)));
};
$onay = ay�kla($_GET['kod']);
$kadi = ay�kla($_GET['kadi']);
$yeni_onay = rndStr(10);
$sorgu = $baglanti->query("SELECT id FROM uyeler WHERE kullaniciadi='$kadi' and onay='$onay' LIMIT 1");
if($sorgu->num_rows==1){
$baglanti->query("UPDATE uyeler SET yetki = 1, onay='$yeni_onay' WHERE kullaniciadi='$kadi' LIMIT 1");
die('Say�n, '.$kadi.'. �yeli�iniz ba�ar�yla onayland�. Siteye geri d�nerek giri� i�leminizi ger�ekle�tirebilirsiniz..<br>Geri d�nmek i�in <b><a href="'.$site_adres.'">t�klay�n</a></b>');
}else{
die('Hesap onaylama linkiniz ge�erli de�il l�tfen y�netimle irtibata ge�in');
}
$sorgu->close();
$baglanti->close();
?>