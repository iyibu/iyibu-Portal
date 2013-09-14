<?php
/* iyibu!Portal:PHP tumjs.php dosyas� 
Yaz�m Tarihi: 25 Temmmuz 2013 
Son De�i�tirilme: 28 Temmuz 2013 (cache eklendi)
ana dizindeki _css klas�r�nde ki ve _tema/{tema_adi}/css klas�r�ndeki
.css dosyalar�n� toplar s�k��t�r�r ve iyibu.css olarak ��kart�r
bu fonksiyon haz�r olarak bulunup geli�tirilmi�tir */
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
	$i�erik = null;
	sort($files);
    foreach($files as $file) {
	if(strpos(basename($file),'.min.')===false) {
	$i�erik .= compress(@file_get_contents($file))."\n";
	}else{
	$i�erik .= @file_get_contents($file);
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
	echo $i�erik;
	
?>