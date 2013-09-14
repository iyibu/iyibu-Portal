<?php /* 	iyibu!Portal:PHP _ajax/uyekayit.php dosyas�
	Yaz�m Tarihi: 14 Eyl�l 2013 00:00
	hata0: eksik alanlar var
	hata1: parolalar e�le�miyor
	hata2: ge�ersiz kullan�c� ad�
	hata3: ge�ersiz eposta
	hata4: kullan�c� zaten kay�tl�
	hata5: ba�lant� hatas�
	hata6: onay maili g�nderilemedi
	Ok: i�lem ba�ar�l�
	*/
header('Content-Type: text/html; charset=iso-8859-9');
require('../baglanti.php');
require('../_inc/fonksiyonlar.php');
function ay�kla($q){
global $baglanti;
return htmlspecialchars(strip_tags($baglanti->real_escape_string($q)));
};
function ge�erli_�ye($q){return preg_match('/^[A-Za-z][A-Za-z0-9]*(?:_[A-Za-z0-9]+)*$/',$q);};
$kadi = $_POST['kadi'];
$Parola = $_POST['parola'];
$Parola2 = $_POST['parola2'];
$Parola1 = md5($Parola);
$Email = $_POST['posta'];
$Adi = trKarakter($baglanti->real_escape_string(ay�kla($_POST['ad'])));
$Soyadi = trKarakter($baglanti->real_escape_string(ay�kla($_POST['soyad'])));
$dogum = trKarakter($baglanti->real_escape_string(ay�kla($_POST['dogum'])));
$Meslek = trKarakter($baglanti->real_escape_string(ay�kla($_POST['is'])));
$Sehir = trKarakter($baglanti->real_escape_string(ay�kla($_POST['memleket'])));
$Web = trKarakter($baglanti->real_escape_string(ay�kla($_POST['Web'])));
$Imza = trKarakter($baglanti->real_escape_string(ay�kla($_POST['imza'])));
$onay_kodu = rndStr(10);
if((empty($kadi))||empty($Parola)||empty($Email)||empty($Adi)||empty($Soyadi)||empty($dogum)) die('hata0');
if($Parola!==$Parola2) die('hata1');
if(!ge�erli_�ye($kadi)) die('hata2');
if (!preg_match(
'/^[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\.[a-zA-Z]{2,4}$/',
$Email)) die('hata3');
$sorgu = $baglanti->query("SELECT id FROM uyeler WHERE kullaniciadi = '$kadi' or Email = '$Email' LIMIT 1");
if($sorgu->num_rows) die('hata4');
$sorgu->close();
$baglanti->query("INSERT INTO uyeler (kullaniciadi,Parola,Email,Adi,Soyadi,dogum,Meslek,Sehir,Web,Imza,Yetki,onay) VALUES ('$kadi','$Parola1','$Email','$Adi','$Soyadi','$dogum','$Meslek','$Sehir','$Web','$Imza',0,'$onay_kodu')") or die('hata5');
$to = $Email;
$subject = $site_k_baslik.' �yelik Aktivasyonu';
$body = "Merhaba $Adi $Soyadi ($kadi)<br><br>".$site_adres.' Adresi i�in ger�ekle�tirmi� oldu�unuz �yeli�i aktifle�tirmek i�in l�tfen a�a��daki linke t�klay�n. E�er bu �yeli�i siz ger�ekle�tirmediyseniz l�tfen bu mesaj� yok say�n';
$body .= '<br><br><a href="'.rtrim($site_adres,'/')."/aktivasyon.php?kod=$onay_kodu&kadi=$kadi".'">'.rtrim($site_adres,'/')."/aktivasyon.php?kod=$onay_kodu&kadi=$kadi".'</a>';
$headers = "From: $site_k_baslik <$site_mail>\r\n" ;
$headers .='Reply-To: '. $to . "\r\n" ;
$headers .='X-Mailer: PHP/' . phpversion();
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/html; charset=iso-8859-9\r\n";   
if(@mail($to, $subject, $body,$headers)) {die('Ok');} else {die('hata6');}
?>