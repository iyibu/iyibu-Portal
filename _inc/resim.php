<?php 
/* iyibu!Portal:PHP resim.php dosyas�
	Yaz�m Tarihi: 26 Temmuz 2013
	De�i�tirilme: 28 Temmuz 2013 (cache eklendi)
	Son de�i�tirilme: 8 Eyl�l 2013 (gzip iste�e ba�l�)
*/
require(__DIR__ . '/../AYARLAR.php');
$expire=60*60*24*7;// seconds, minutes, hours, days
header('Pragma: public');
header('Cache-Control: maxage='.$expire);
header('Expires: ' . gmdate('D, d M Y H:i:s', time()+$expire) . ' GMT');
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');

if($site_gzip==true){
if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) {
	ob_start("ob_gzhandler"); 
	}
	else {
	ob_start(); 
	}
}
header ('Content-type: image');
if(!preg_match('/((.*?).(jpg|png))/i', $_GET['dosya'], $sonuc)) die('can�m s�k�ld�');
$resim = @file_get_contents($_GET['dosya']);
echo $resim;
?>