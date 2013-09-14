<?php /* 	iyibu!Portal:PHP aktivasyon.php dosyasý
	Yazým Tarihi: 14 Eylül 2013 00:59
	*/
header('Content-Type: text/html; charset=iso-8859-9');
require('baglanti.php');
require('_inc/fonksiyonlar.php');
function ayýkla($q){
global $baglanti;
return htmlspecialchars(strip_tags($baglanti->real_escape_string($q)));
};
$onay = ayýkla($_GET['kod']);
$kadi = ayýkla($_GET['kadi']);
$yeni_onay = rndStr(10);
$sorgu = $baglanti->query("SELECT id FROM uyeler WHERE kullaniciadi='$kadi' and onay='$onay' LIMIT 1");
if($sorgu->num_rows==1){
$baglanti->query("UPDATE uyeler SET yetki = 1, onay='$yeni_onay' WHERE kullaniciadi='$kadi' LIMIT 1");
die('Sayýn, '.$kadi.'. Üyeliðiniz baþarýyla onaylandý. Siteye geri dönerek giriþ iþleminizi gerçekleþtirebilirsiniz..<br>Geri dönmek için <b><a href="'.$site_adres.'">týklayýn</a></b>');
}else{
die('Hesap onaylama linkiniz geçerli deðil lütfen yönetimle irtibata geçin');
}
$sorgu->close();
$baglanti->close();
?>