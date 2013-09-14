<?php 
/* iyibu!Portal:PHP resim.php dosyasý
	Yazým Tarihi: 26 Temmuz 2013
	Deðiþtirilme: 28 Temmuz 2013 (cache eklendi)
	Son deðiþtirilme: 8 Eylül 2013 (gzip isteðe baðlý)
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
if(!preg_match('/((.*?).(jpg|png))/i', $_GET['dosya'], $sonuc)) die('caným sýkýldý');
$resim = @file_get_contents($_GET['dosya']);
echo $resim;
?>