<?php header('Content-Type: text/html; charset=iso-8859-9');
require(__DIR__ . '/../baglanti.php');
require(__DIR__ . '/../_inc/fonksiyonlar.php');
if($_SESSION['yonetici']==false&&yetkiVarmi('uye')){header('Location: giris.php');
die();};
$sayfa = $_GET['sayfa'];
if($sayfa=='yetki-kaydet'&&yetkiVarmi('u_yetki')):
$yetkiler = @implode(',',$_GET['yetki']);
$isim = trKarakter($baglanti->real_escape_string($_GET['isim']));
$id = $_GET['id'];
if(empty($id)){
$baglanti->query("INSERT INTO yetki VALUES ('','$isim','$yetkiler',NOW())") or trigger_error(@$baglanti->error);
}else{
$baglanti->query("UPDATE yetki SET yetkiler = '$yetkiler' WHERE id = $id LIMIT 1") or trigger_error(@$baglanti->error);
}
die('Ok');
elseif($sayfa=='uye-kaydet'&&yetkiVarmi('u_uye')):
function geçerli_üye($q){return preg_match('/^[A-Za-z][A-Za-z0-9]*(?:_[A-Za-z0-9]+)*$/',$q);};
$kadi = $_POST['kullaniciadi'];
$kadi2 = $_POST['kadi2'];
$Parola = $_POST['Parola'];
$Parola1 = md5($Parola);
$Email = $_POST['Email'];
$Adi = trKarakter($baglanti->real_escape_string($_POST['Adi']));
$Soyadi = trKarakter($baglanti->real_escape_string($_POST['Soyadi']));
$dogum = trKarakter($baglanti->real_escape_string($_POST['dogum']));
$Meslek = trKarakter($baglanti->real_escape_string($_POST['Meslek']));
$Sehir = trKarakter($baglanti->real_escape_string($_POST['Sehir']));
$Web = trKarakter($baglanti->real_escape_string($_POST['Web']));
$Imza = trKarakter($baglanti->real_escape_string($_POST['Imza']));
if(!geçerli_üye($kadi)) die('Geçersiz Kullanýcý Adý');
if (!preg_match(
'/^[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\.[a-zA-Z]{2,4}$/',
$Email)) die('Geçersiz E-Posta Adresi');
$Yetki = $_POST['Yetki'];
if(empty($_POST['kadi2'])){
$sorgu = $baglanti->query("SELECT id FROM uyeler WHERE kullaniciadi = '$kadi' or Email = '$Email' LIMIT 1");
if($sorgu->num_rows) die('Böyle bir kullanýcý zaten var');
$sorgu->close();
$baglanti->query("INSERT INTO uyeler (kullaniciadi,Parola,Email,Adi,Soyadi,dogum,Meslek,Sehir,Web,Imza,Yetki) VALUES ('$kadi','$Parola1','$Email','$Adi','$Soyadi','$dogum','$Meslek','$Sehir','$Web','$Imza','$Yetki')") or die(trigger_error(@$baglanti->error));
}else{
if(empty($Parola)){
$baglanti->query("UPDATE uyeler SET kullaniciadi='$kadi',Email='$Email',Adi='$Adi',Soyadi='$Soyadi',dogum='$dogum',Meslek='$Meslek',Sehir='$Sehir',Web='$Web',Imza='$Imza',Yetki='$Yetki'  WHERE kullaniciadi = '$kadi2' LIMIT 1") or die(trigger_error(@$baglanti->error));
}else{
$baglanti->query("UPDATE uyeler SET kullaniciadi='$kadi',Parola='$Parola1',Email='$Email',Adi='$Adi',Soyadi='$Soyadi',dogum='$dogum',Meslek='$Meslek',Sehir='$Sehir',Web='$Web',Imza='$Imza',Yetki='$Yetki'  WHERE kullaniciadi = '$kadi2' LIMIT 1") or die(trigger_error(@$baglanti->error));
}
}
die('Ok');
elseif($sayfa=='uye-onayla'&&yetkiVarmi('u_uye')):
$kadi = $_GET['kadi'];
$baglanti->query("UPDATE uyeler SET Yetki = 1 WHERE kullaniciadi='$kadi' LIMIT 1") or die(trigger_error(@$baglanti->error));
die("Üye baþarýyla onaylandý");
elseif($sayfa=='uye-engelle'&&yetkiVarmi('u_uye')):
$kadi = $_GET['kadi'];
$baglanti->query("UPDATE uyeler SET Yetki = -1 WHERE kullaniciadi='$kadi' LIMIT 1") or die(trigger_error(@$baglanti->error));
die("Üye baþarýyla engellendi");
endif;
?>