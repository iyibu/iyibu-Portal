<?php 
/* iyibu!Portal:PHP fonksiyonlar.php dosyas� 
Yaz�m Tarihi: 24 Temmmuz 2013 */

/* 	Fonksiyon: blok_sirala || Yaz�m Tarihi: 24 Temmuz 2013
	$yer: sol-blok, orta-blok1, orta-blok2, sag-blok. 
		Not: orta varsay�lan� orta-blok1
	$mana: modul(ana) ID'si
	$alt: Anasayfa(ana), okuma sayfas�(oku), kategori(kat) 
	$tema: temalar aras� kar���kl��� �nlemek ad�na tema belirtilmeli */
function dil�evir($q){
	$pattern = "(<\?(php)?(.*?)\?>)";
	$replacement = htmlentities("<?$1$2?>");
	return preg_replace($pattern, $replacement, $q);
}
function blok_sirala($yer, $mana, $alt, $hedef, $tema){
global $baglanti,$site_tema;
#modulblok tablosundan blok listesi al�n�yor#
$sql = "select id,bisim, fdeger, sira from modulblok where modul = '$mana' and yer = '$yer' and alt = '$alt' and tema = '$site_tema' order by sira asc";
$sorgu= $baglanti->query($sql);
$t�m_{$hedef} = array();
while ($sonuc=$sorgu->fetch_array()){
#al�nan listeye g�re bloklar �ekiliyor#
$bisim = $sonuc['bisim'];
if(!file_exists('_tema/'.$site_tema.'/bloklar/'.$sonuc['bisim'])){ 
$baglanti->query("DELETE from modulblok where bisim='$bisim'");
die("iyibu!Portal.HATA! Blok bulunamad� ve t�m ba�lant�l� sat�rlar silindi! L�tfen Sayfay� yenileyiniz...<br><b>$bisim</b>");}
$blok = simplexml_load_file('_tema/'.$site_tema.'/bloklar/'.$sonuc['bisim']);
if($hedef=='icerik'){
$blok_i�erik = trKarakter($blok->kod);
$f_i =0;
$ek_deger = @explode('|',$blok->ek_deger);
foreach(explode('|',$sonuc['fdeger']) as $fdeger){
$ek_deger_2 = @explode('->',$ek_deger[$f_i]);
$ek_deger_2 = @ltrim($ek_deger_2[0]);
$blok_i�erik = @str_replace('==blok['.$ek_deger_2.']==',$fdeger,$blok_i�erik);
$f_i++;
}
$blok_i�erik = str_replace('/ID\\',$sonuc['id'],$blok_i�erik);
$t�m_{$hedef}[$sonuc['sira']] = dil�evir($blok_i�erik);
}elseif($hedef=='baslik'){
$t�m_{$hedef}[$sonuc['sira']] = trKarakter($blok->baslik);
}elseif($hedef=='tip'){
$t�m_{$hedef}[$sonuc['sira']] = trKarakter($blok->tip);
}
}
return $t�m_{$hedef};
$sorgu->close;
}
/* 	Fonksiyon: array count || Yaz�m Tarihi 25 temmuz 2013
	count fonksiyonunun ayn�s� sadece count(array()) 0 d�nd�r�r */
function array_count($i�erik){
if(empty($i�erik)){
return 0;
}else{
return count($i�erik);
}
}
class iyibu {
/* 	Fonksiyon: bloklar || Yaz�m Tarihi 25 temmuz 2013
	sa�-sol-orta bloklar� listeletir. kolayl�k i�in*/
function bloklar($mana,$alt){
global $iyibu, $site_tema;
$tip = blok_sirala('sol-blok',$mana,$alt,'tip',$site_tema);
$iyibu->dizi('sol-blok',array('toplam'=>array_count($tip),'baslik'=>blok_sirala('sol-blok',$mana,$alt,'baslik',$site_tema),'icerik'=>blok_sirala('sol-blok',$mana,$alt,'icerik',$site_tema),'tip'=>$tip));
$tip = blok_sirala('sag-blok',$mana,$alt,'tip',$site_tema);
$iyibu->dizi('sag-blok',array('toplam'=>array_count($tip),'baslik'=>blok_sirala('sag-blok',$mana,$alt,'baslik',$site_tema),'icerik'=>blok_sirala('sag-blok',$mana,$alt,'icerik',$site_tema),'tip'=>$tip));
$tip = blok_sirala('orta-blok1',$mana,$alt,'tip',$site_tema);
$iyibu->dizi('orta-blok1',array('toplam'=>array_count($tip),'baslik'=>blok_sirala('orta-blok1',$mana,$alt,'baslik',$site_tema),'icerik'=>blok_sirala('orta-blok1',$mana,$alt,'icerik',$site_tema),'tip'=>$tip));
$tip = blok_sirala('orta-blok2',$mana,$alt,'tip',$site_tema);
$iyibu->dizi('orta-blok2',array('toplam'=>array_count($tip),'baslik'=>blok_sirala('orta-blok2',$mana,$alt,'baslik',$site_tema),'icerik'=>blok_sirala('orta-blok2',$mana,$alt,'icerik',$site_tema),'tip'=>$tip));
}
/* 	Fonksiyon: bloklar || Yaz�m Tarihi 25 temmuz 2013
	sa�-sol-orta bloklar� listeletir. kolayl�k i�in*/
function menu(){
global $iyibu,$baglanti;
$sorgu= $baglanti->query("select isim,resim,link from menu where yer = 'ust-menu' order by sira asc");
while ($sonuc=$sorgu->fetch_assoc()){
$menu_isim[] = $sonuc['isim'];
$menu_resim[] = $sonuc['resim'];
$menu_link[] = $sonuc['link'];}
$iyibu->dizi('menu',array('isim'=>@$menu_isim,'resim'=>@$menu_resim,'link'=>@$menu_link,'toplam'=>$sorgu->num_rows));
$sorgu->close();
}
/* 	Fonksiyon: tazele || Yaz�m Tarihi 25 temmuz 2013
	�ye/ziyaret�i kayd� olu�turma fonksiyonu; kullan�m� $iyibu->tazele()*/
function tazele($q){
global $baglanti;
$kadi = @$_SESSION['kadi'];
if(empty($kadi)) $kadi = 'Ziyaret�i';
$ip = GetIP(); 
$yer = $_SERVER['REQUEST_URI'];
$sid = session_id();
$sorgu = $baglanti->query("select time,isim,session,yer from aktif_uye where ip = '".$ip."' or session = '".$sid."'");
$�imdi = time();
$time = $�imdi-(int)$q;
if(!$sorgu->num_rows){
$baglanti->query("INSERT INTO aktif_uye (isim,session,yer,time,ip) VALUES ('$kadi','$sid','$yer','$�imdi','$ip') ");
}else{
$sonuc = $sorgu->fetch_assoc();
$eski_time = $sonuc['time'];
$eski_kadi = $sonuc['isim'];
$eski_sid = $sonuc['session'];
$eski_yer = $sonuc['yer'];
if(($�imdi-$eski_time)>$q){
$baglanti->query("UPDATE aktif_uye SET isim = '$kadi', time = '$�imdi', yer = '$yer' where ip = '$ip'");
}elseif(($eski_kadi!==$kadi)||($eski_sid!==$sid)){
$baglanti->query("UPDATE aktif_uye SET isim = '$kadi', time = '$�imdi', yer = '$yer' where ip = '$ip'");
}
elseif(($eski_yer!==$yer)&&(($�imdi-$eski_time)>10)){
$baglanti->query("UPDATE aktif_uye SET isim = '$kadi', time = '$�imdi', yer = '$yer' where ip = '$ip'");
}
}
$baglanti->query("SELECT DISTINCT isim FROM aktif_uye");
$baglanti->query("DELETE FROM aktif_uye WHERE  time < $time");
}
function temaAyarlari(){
global $iyibu,$baglanti,$site_tema;
$sorgu = $baglanti->query("SELECT deger FROM ayarlar WHERE isim ='tema_{$site_tema}' LIMIT 1");
$ayarlar = $sorgu->fetch_assoc();
$ayarlar = $ayarlar['deger'];
$ayarlar = explode('|',$ayarlar);
$adres = '_tema/'.$site_tema.'/AYARLAR.xml';
$ayar = simplexml_load_file($adres);
$ayar = $ayar->ek_deger;
$ayar = explode('|',trim(trKarakter($ayar)));
$i=0;
foreach($ayar as $a){
$b = explode('->',$a);
$b = $b[0];
$temayarlar[$b] = @$ayarlar[$i];
$i++;
}
$iyibu->dizi('tema',$temayarlar);
}
}
/* 	Fonksiyon: phpSil || Eklenme Tarihi 27 temmuz 2013
	Tema dosyas� i�in */
	function phpSil($i�erik){
	$pattern = "/(<\?(php)?.echo.(.*?)(:|;|)\?(>|&gt;))/";
	$replacement = "$3";
	return preg_replace($pattern, $replacement, $i�erik);
	}
/* 	Fonksiyon: json t�rk�e karakter deste�i || Eklenme Tarihi 29 temmuz 2013 */
function unicode_decode($str){ 
 return is_array($str) ? array_map('unicode_decode', $str) : preg_replace("/\\\u([0-9A-F]{4})/ie", "iconv('utf-16', 'utf-8', hex2str(\"$1\"))", $str);} 
function hex2str($hex) { 
    $r = ''; 
    for ($i = 0; $i < strlen($hex) - 1; $i += 2) 
    $r .= chr(hexdec($hex[$i] . $hex[$i + 1])); 
    return $r; 
}
/* T�rk�e Tarih G�nAy fonksiyonu || Eklenme Tarihi 31 temmuz 2013*/
function TRg�nAy($q){
$aylar = array( 
    'January'    =>    'Ocak', 
    'February'    =>    '�ubat', 
    'March'        =>    'Mart', 
    'April'        =>    'Nisan', 
    'May'        =>    'May�s', 
    'June'        =>    'Haziran', 
    'July'        =>    'Temmuz', 
    'August'    =>    'A�ustos', 
    'September'    =>    'Eyl�l', 
    'October'    =>    'Ekim', 
    'November'    =>    'Kas�m', 
    'December'    =>    'Aral�k', 
    'Monday'    =>    'Pazartesi', 
    'Tuesday'    =>    'Sal�', 
    'Wednesday'    =>    '�ar�amba', 
    'Thursday'    =>    'Per�embe', 
    'Friday'    =>    'Cuma', 
    'Saturday'    =>    'Cumartesi', 
    'Sunday'    =>    'Pazar', 
);
return  strtr($q, $aylar); }
/* T�rk�e karakter fonksiyonu ajax || Eklenme Tarihi 1 A�ustos 2013*/
function trKarakter($dizi) {
 return is_array($dizi) ? array_map('trKarakter', $dizi) : iconv("UTF-8","ISO-8859-9//TRANSLIT",$dizi);
 }
/* Seo fonksiyonu ||Eklenme tarihi 4 A�ustos 2013 */
function seo_temizle($q) {
$turkce=array("�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","�","$","�");
$duzgun=array("s","S","i","u","U","o","O","c","C","s","S","i","g","G","I","o","O","C","c","u","U","Dolar","Euro");
$q=str_replace($turkce,$duzgun,$q);
$q = preg_replace("@[^a-z0-9\-_����������]+@i","-",$q);
$q = preg_replace("@-+@i","-",$q);
$q = rtrim($q,'-');
$q = ltrim($q,'-');
if(is_numeric(substr($q, -1))) $q .= '-oku';
return $q;
}
/* curPageUrl http://webcheatsheet.com/PHP/get_current_page_url.php || Eklenme tarihi 25 A�ustos 2013 */
function curPageURL() {
 $pageURL = 'http';
 if (@$_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return $pageURL;
}
/* son_i�erikler (tema i�in son kay�tlar� listeleme) || Eklenme tarihi 04 Eyl�l 2013 */
function son_i�erikler($mod�l=false,$kategori=false,$kay�t='sayfa',$max=600){
global $baglanti,$modul_sayfa,$modul_seo,$iyibu;
if(empty($mod�l)) $mod�l = $modul_seo;
if($kay�t=='sayfa') $kay�t = ($modul_sayfa*5-5).','.$modul_sayfa*5;
if($kategori){
$sql = "SELECT baslik,icerik,resim,etiket,seo,ekleyen,tarih,kategori,sayac FROM modulicerik WHERE modul = '$mod�l' and kategori = '$kategori' ORDER BY tarih,id DESC LIMIT $kay�t";
}else{
$sql = "SELECT baslik,icerik,resim,etiket,seo,ekleyen,tarih,kategori,sayac FROM modulicerik WHERE modul = '$mod�l' ORDER BY tarih,id DESC LIMIT $kay�t";
}
$sorgu = $baglanti->query($sql) or die(trigger_error(@$baglanti->error));
while($i�erikler = $sorgu->fetch_assoc()){
$i_k = $i�erikler['kategori'];
$k = $baglanti->query("SELECT isim,kayitlar FROM modulkategori WHERE seo = '$i_k' and modul = '$mod�l' LIMIT 1");
$i�erikler['icerik'] = $iyibu->noscript(k�saDetay($i�erikler['icerik'],$max));
$i�erikler['k_tarih'] = nezaman($i�erikler['tarih']);
$i_k = $k->fetch_assoc();
$i�erikler['kategori_isim'] = $i_k['isim'];
$i�erikler['kategori_kayitlar'] = $i_k['kayitlar'];
$k->close();
$sonuc[] = $i�erikler;
}
$sonuc['toplam_kayit'] = $sorgu->num_rows;
$sorgu->close();
return $sonuc;
}

/* hit_i�erikler (tema i�in en �ok okunan kay�tlar� listeleme) || Eklenme tarihi 04 Eyl�l 2013 */
function hit_i�erikler($mod�l=false,$kategori=false,$kay�t='sayfa',$max=600){
global $baglanti,$modul_sayfa,$modul_seo,$iyibu;
if(empty($mod�l)) $mod�l = $modul_seo;
if($kay�t=='sayfa') $kay�t = ($modul_sayfa*5-5).','.$modul_sayfa*5;
if($kategori){
$sql = "SELECT baslik,icerik,resim,etiket,seo,ekleyen,tarih,sayac FROM modulicerik WHERE modul = '$mod�l' and kategori = '$kategori' ORDER BY sayac ASC LIMIT $kay�t";
}else{
$sql = "SELECT baslik,icerik,resim,etiket,seo,ekleyen,tarih,sayac FROM modulicerik WHERE modul = '$mod�l' ORDER BY sayac ASC LIMIT $kay�t";
}
$sorgu = $baglanti->query($sql) or die(trigger_error(@$baglanti->error));
while($i�erikler = $sorgu->fetch_assoc()){
$i�erikler['icerik'] = $iyibu->noscript(k�saDetay($i�erikler['icerik'],$max));
$sonuc[] = $i�erikler;
}
$sonuc['toplam_kayit'] = $sorgu->num_rows;
$sorgu->close();
return $sonuc;
}

/* online_uyeler (tema i�in online �yeleri listeleme) || Eklenme tarihi 13 Eyl�l 2013 */
function online_uyeler($max=false,$burada='index.html'){
$q = array();
if(!$max){
$sorgu = $baglanti->query("SELECT isim,tarih,yer FROM aktif_uye ORDER BY tarih DESC");
}else{
$sorgu = $baglanti->query("SELECT isim,tarih,yer FROM aktif_uye ORDER BY tarih DESC LIMIT $max");
}
while($uye = $sorgu-fetch_assoc()){
$arr = $uye;
$arr['k_tarih'] = nezaman($uye['tarih']);
$rutbe = $baglanti->query("SELECT Yetki FROM uyeler WHERE kullaniciadi ='{$uye['isim']}' LIMIT 1");
$yetki = $rutbe->fetch_assoc();
$yetki = $yetki['Yetki'];
$rutbe->close();
$arr['yetki'] = $yetki;
$q[] = $arr;
}
return $q;
}
/* diziyi (array) girdiye d�n��t�r�r (string) || Eklenme tarihi 04 Eyl�l 2013 */
function diziden_girdiye($dizi) {
   $dizim = 'array(';
   if(!empty($dizi)){
   foreach ($dizi as $key => $girdi) {
			if (is_array($girdi)){
			$dizim = $dizim.$this->diziden_girdiye($girdi).',';
			}else{
				if (is_numeric($girdi)){
				if(!is_numeric($key)) $key = "'".$key."'";
				$dizim = $dizim.$key."=>".$girdi.',';
				}else{
				if(!is_numeric($key)) $key = "'".$key."'";
				$dizim = $dizim.$key."=>"."'".$girdi."',";
				}
			}
			
   }
   $dizim = substr($dizim, 0, -1);
   }
   return $dizim.')';
   };
/* detay k�salt */
function k�saDetay($q,$max=600){
$ilk=$q;
$q = strip_tags($q);
$q = substr($q, 0, $max);
$q = rtrim($q);
if(strlen($ilk)>$max) $q .= '...';
return $q;
};
/*x g�n �nce kaynak:http://forum.ceviz.net/php/103709-php-zaman-damgasini-x-dakika-once-x-gun-once-yapmak.html || eklenme tarihi 4 eyl�l 2013 */
function nezaman($t)
{
	
	$t = strtotime($t); 	
    $simdi = time();
    $tarih = $simdi - $t;

    if($tarih < (60)) {
        $gecen = intval($tarih);
        $tur = "sn";
    } else
        if($tarih < (60 * 60)) {
            $gecen = intval($tarih / 60);
            $tur = "dk";
        } else
            if($tarih < (24 * 60 * 60)) {
                $gecen = intval($tarih / (60 * 60));
                $tur = "saat";
            } else
                if($tarih < (30 * 24 * 60 * 60)) {
                    $gecen = intval($tarih / (24 * 60 * 60));
                    $tur = "g�n";
                } else
                    if($tarih < (365 * 24 * 60 * 60)) {
                        $gecen = intval($tarih / (30 * 24 * 60 * 60));
                        $tur = "ay";
                    } else {
                        $gecen = intval($tarih / (365 * 24 * 60 * 60));
                        $tur = "y�l";
                    }

                    return $gecen ." ". $tur;
}
/*generateRandomString http://stackoverflow.com/questions/4356289/php-random-string-generator || eklenme tarihi 7 eyl�l 2013 */
function rndStr($length = 6) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}
/* strposa array i�inde string arama (daha �nce iyibuTemada kullan�l�yordu) || eklenme tarihi 12 Eyl�l 2013 */
   function strposa($haystack, $needle) {
     if (is_array($needle)) {
         foreach ($needle as $need) {
               if (strpos($haystack, $need) !== false) {
                       return true;
               }
         }
     }else {
          if (strpos($haystack, $need) !== false) {
                       return true;
          }
     }

     return false;
}
/* yetkiVarmi fonksiyonu y�netim paneli i�in h�zl� kontrol || eklenme tarihi 13 Eyl�l 2013 */
function yetkiVarmi($q){
if(empty($_SESSION['yetki'])){
return false;
}else{
return strposa($q,$_SESSION['yetki']);
}
}
?>