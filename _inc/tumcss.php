<?php
/* iyibu!Portal:PHP tumjs.php dosyasý 
Yazým Tarihi: 25 Temmmuz 2013 
Son Deðiþtirilme: 28 Temmuz 2013 (cache eklendi)
ana dizindeki _css klasöründe ki ve _tema/{tema_adi}/css klasöründeki
.css dosyalarýný toplar sýkýþtýrýr ve iyibu.css olarak çýkartýr
bu fonksiyon hazýr olarak bulunup geliþtirilmiþtir */
require(__DIR__ . '/../AYARLAR.php');
$expire=60*60*24*7;// seconds, minutes, hours, days
header('Pragma: public');
header('Cache-Control: maxage='.$expire);
header('Expires: ' . gmdate('D, d M Y H:i:s', time()+$expire) . ' GMT');
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');

$files = array();
$uzanti = "css";
$dizin = "../_tema/klasik/css";
if ($handle = opendir("$dizin") or die ("Dizin acilamadi!")) {
while (false !== ($file = readdir($handle))) {
    $filetype = ext($file);
    if(is_file($dizin."/".$file) && $filetype == "$uzanti") {
	$files[] = $dizin.'/'.$file;
    } 
}
closedir($handle);
}

$dizin = "../_css";
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

    header ('Content-type: text/css');
    function compress($buffer) {
        $buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);
        $buffer = str_replace(array("\r\n","\r","\n","\t",'  ','    ','     '), '', $buffer);
		$buffer = str_replace('../img', '_tema/klasik/img', $buffer);
		$buffer = str_replace('../', '', $buffer);
        $buffer = preg_replace(array('(( )+{)','({( )+)'), '{', $buffer);
        $buffer = preg_replace(array('(( )+})','(}( )+)','(;( )*})'), '}', $buffer);
        $buffer = preg_replace(array('(;( )+)','(( )+;)'), ';', $buffer);
        return $buffer;
    }
	$içerik = null;
	sort($files);
    foreach($files as $file) {
	if(strpos(basename($file),'.min.')===false) {
	$içerik .= compress(@file_get_contents($file))."\n";
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