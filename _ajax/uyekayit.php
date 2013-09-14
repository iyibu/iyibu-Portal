<?php /* 	iyibu!Portal:PHP _ajax/uyekayit.php dosyasý
	Yazým Tarihi: 14 Eylül 2013 00:00
	hata0: eksik alanlar var
	hata1: parolalar eþleþmiyor
	hata2: geçersiz kullanýcý adý
	hata3: geçersiz eposta
	hata4: kullanýcý zaten kayýtlý
	hata5: baðlantý hatasý
	hata6: onay maili gönderilemedi
	Ok: iþlem baþarýlý
	*/
header('Content-Type: text/html; charset=iso-8859-9');
require('../baglanti.php');
require('../_inc/fonksiyonlar.php');
function ayýkla($q){
global $baglanti;
return htmlspecialchars(strip_tags($baglanti->real_escape_string($q)));
};
function geçerli_üye($q){return preg_match('/^[A-Za-z][A-Za-z0-9]*(?:_[A-Za-z0-9]+)*$/',$q);};
$kadi = $_POST['kadi'];
$Parola = $_POST['parola'];
$Parola2 = $_POST['parola2'];
$Parola1 = md5($Parola);
$Email = $_POST['posta'];
$Adi = trKarakter($baglanti->real_escape_string(ayýkla($_POST['ad'])));
$Soyadi = trKarakter($baglanti->real_escape_string(ayýkla($_POST['soyad'])));
$dogum = trKarakter($baglanti->real_escape_string(ayýkla($_POST['dogum'])));
$Meslek = trKarakter($baglanti->real_escape_string(ayýkla($_POST['is'])));
$Sehir = trKarakter($baglanti->real_escape_string(ayýkla($_POST['memleket'])));
$Web = trKarakter($baglanti->real_escape_string(ayýkla($_POST['Web'])));
$Imza = trKarakter($baglanti->real_escape_string(ayýkla($_POST['imza'])));
$onay_kodu = rndStr(10);
if((empty($kadi))||empty($Parola)||empty($Email)||empty($Adi)||empty($Soyadi)||empty($dogum)) die('hata0');
if($Parola!==$Parola2) die('hata1');
if(!geçerli_üye($kadi)) die('hata2');
if (!preg_match(
'/^[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\.[a-zA-Z]{2,4}$/',
$Email)) die('hata3');
$sorgu = $baglanti->query("SELECT id FROM uyeler WHERE kullaniciadi = '$kadi' or Email = '$Email' LIMIT 1");
if($sorgu->num_rows) die('hata4');
$sorgu->close();
$baglanti->query("INSERT INTO uyeler (kullaniciadi,Parola,Email,Adi,Soyadi,dogum,Meslek,Sehir,Web,Imza,Yetki,onay) VALUES ('$kadi','$Parola1','$Email','$Adi','$Soyadi','$dogum','$Meslek','$Sehir','$Web','$Imza',0,'$onay_kodu')") or die('hata5');
$to = $Email;
$subject = $site_k_baslik.' Üyelik Aktivasyonu';
$body = "Merhaba $Adi $Soyadi ($kadi)<br><br>".$site_adres.' Adresi için gerçekleþtirmiþ olduðunuz üyeliði aktifleþtirmek için lütfen aþaðýdaki linke týklayýn. Eðer bu üyeliði siz gerçekleþtirmediyseniz lütfen bu mesajý yok sayýn';
$body .= '<br><br><a href="'.rtrim($site_adres,'/')."/aktivasyon.php?kod=$onay_kodu&kadi=$kadi".'">'.rtrim($site_adres,'/')."/aktivasyon.php?kod=$onay_kodu&kadi=$kadi".'</a>';
$headers = "From: $site_k_baslik <$site_mail>\r\n" ;
$headers .='Reply-To: '. $to . "\r\n" ;
$headers .='X-Mailer: PHP/' . phpversion();
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/html; charset=iso-8859-9\r\n";   
if(@mail($to, $subject, $body,$headers)) {die('Ok');} else {die('hata6');}
?>