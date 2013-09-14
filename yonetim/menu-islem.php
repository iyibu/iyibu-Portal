<?php header('Content-Type: text/html; charset=iso-8859-9');
require(__DIR__ . '/../baglanti.php');
require(__DIR__ . '/../_inc/fonksiyonlar.php');
if($_SESSION['yonetici']==false&&yetkiVarmi('s_mynt')){header('Location: giris.php');
die();};
$sayfa = @$_GET['sayfa'];
if($sayfa == "sirala"):
echo 'Sýralandý: ';
foreach($_POST['menu'] as $sira => $id){
$sira++;
echo ($id).'=>'.$sira.', ';
$baglanti->query("UPDATE menu SET sira=$sira where id = $id LIMIT 1");}
elseif($sayfa == "sil"):
$id = @$_GET['id'];
$isim = trKarakter(@$_GET['isim']);
$baglanti->query("DELETE FROM menu where id = $id LIMIT 1");
if($isim) $baglanti->query("DELETE FROM menu where yer = '$isim'");
die('Silindi!');
elseif($sayfa == "ekle"):
$isim = trKarakter(@$_GET['isim']);
$resim = trKarakter(@$_GET['resim']);
$link = trKarakter(@$_GET['adres']);
$sira = @$_GET['sira'];
$yer = @$_GET['yer'];
if(empty($isim)||empty($resim)||empty($link)) die('Boþ alanlarý doldurun');
$baglanti->query("INSERT INTO menu VALUES ('','$isim','$resim','$link','$yer',$sira)");
echo($baglanti->insert_id);
elseif($sayfa == "grup-ekle"):
$isim = trKarakter(@$_GET['isim']);
$baglanti->query("INSERT INTO menu VALUES ('','$isim','','','iyibu-menu-list',0)");
echo($baglanti->insert_id);
endif;?>