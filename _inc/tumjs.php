<?php
/* iyibu!Portal:PHP tumjs.php dosyasý 
Yazým Tarihi: 25 Temmmuz 2013 
Son Deðiþtirilme: 28 Temmuz 2013 (cache eklendi)
ana dizindeki _js klasöründe ki ve _tema/{tema_adi}/js klasöründeki
.js dosyalarýný toplar sýkýþtýrýr ve iyibu.js olarak çýkartýr
bu fonksiyon hazýr olarak bulunup geliþtirilmiþtir */
require(__DIR__ . '/../AYARLAR.php');
require 'jsmin.php';
$expire=60*60*24*7;// seconds, minutes, hours, days
header('Pragma: public');
header('Cache-Control: maxage='.$expire);
header('Expires: ' . gmdate('D, d M Y H:i:s', time()+$expire) . ' GMT');
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');

$dizin = "../_js";
$uzanti = "js";
$files = array();
function ext($text)  { 
    $text = strtolower(pathinfo($text, PATHINFO_EXTENSION));
    return $text;  }
if ($handle = opendir("$dizin") or die ("Dizin acilamadi!")) {
while (false !== ($file = readdir($handle))) {
    $filetype = ext($file);
    if(is_file($dizin."/".$file) && $filetype == "$uzanti") {
	$files[] = $dizin.'/'.$file;
    } 
}
closedir($handle);
}
$dizin = "../_tema/klasik/js";
if ($handle = opendir("$dizin") or die ("Dizin acilamadi!")) {
while (false !== ($file = readdir($handle))) {
    $filetype = ext($file);
    if(is_file($dizin."/".$file) && $filetype == "$uzanti") {
	$files[] = $dizin.'/'.$file;
    } 
}
closedir($handle);
}
    
$modified = 0;

foreach($files as $file) {        
    $age = filemtime($file);
    if($age > $modified) {
        $modified = $age;
    }
}

$offset = 60 * 60 * 24 * 7; // Cache for 1 weeks
header ('Expires: ' . gmdate ("D, d M Y H:i:s", time() + $offset) . ' GMT');
header ('Content-type: text/javascript');
    function compress($buffer) {
        $buffer = JSMin::minify($buffer);
        return $buffer;
    }
	$içerik = null;
    foreach($files as $file) {
	if(strpos(basename($file),'.min.')===false) {
	$içerik .= compress(@file_get_contents($file));
	}else{
	$içerik .= @file_get_contents($file);
	}
	}
	if($site_gzip==true){
	if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) {
	ob_start("ob_gzhandler"); 
	}
	else {
	ob_start(); 
	}
	}
	echo $içerik;
?>