<?php
/* 	iyibu!Portal:PHP baglanti.php dosyas�
	Yaz�m Tarihi: 23 Temmmuz 2013 
	De�i�iklik 6 Eyl�l 2013 00:45 flood korumas� ve ger�ek ip adresi eklendi
	Son De�i�iklik 6 Eyl�l 2013 14:48 Flood korumas� rafa kald�r�ld�*/
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
$baglanti = new mysqli($mysql_host, $mysql_user, $mysql_pass, $mysql_db) or die('iyibu!Portal:PHP.hata<br>Veritaban� ba�lant�s� ba�ar�s�z!');
$baglanti->set_charset("latin5");
session_start();
?>
