<?php 
/* iyibu!Portal:PHP javascript.php dosyası
	Yazım Tarihi: 8 Eylül 2013
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
header ('Content-type: text/javascript');
if(!preg_match('/((.*?).(js))/i', $_GET['dosya'], $sonuc)) die('canım sıkıldı');
$javascript = @file_get_contents($_GET['dosya']);
echo $javascript;
?>