<?php
/* 	iyibu!Portal:PHP baglanti.php dosyasý
	Yazým Tarihi: 23 Temmmuz 2013 
	Deðiþiklik 6 Eylül 2013 00:45 flood korumasý ve gerçek ip adresi eklendi
	Son Deðiþiklik 6 Eylül 2013 14:48 Flood korumasý rafa kaldýrýldý*/
function GetIP(){
	if(getenv("HTTP_CLIENT_IP")) {
 		$ip = getenv("HTTP_CLIENT_IP");
 	} elseif(getenv("HTTP_X_FORWARDED_FOR")) {
 		$ip = getenv("HTTP_X_FORWARDED_FOR");
 		if (strstr($ip, ',')) {
 			$tmp = explode (',', $ip);
 			$ip = trim($tmp[0]);
 		}
 	} else {
 	$ip = getenv("REMOTE_ADDR");
 	}
	return $ip;
}
require('AYARLAR.php');
$baglanti = new mysqli($mysql_host, $mysql_user, $mysql_pass, $mysql_db) or die('iyibu!Portal:PHP.hata<br>Veritabaný baðlantýsý baþarýsýz!');
$baglanti->set_charset("latin5");
session_start();
?>
