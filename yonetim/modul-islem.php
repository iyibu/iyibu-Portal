<?php header('Content-Type: text/html; charset=iso-8859-9');
require(__DIR__ . '/../_inc/fonksiyonlar.php');
require(__DIR__ . '/../baglanti.php');
if($_SESSION['yonetici']==false){header('Location: giris.php');
die();};
$sayfa = @$_GET['sayfa'];
function kategoriTazele(){
global $baglanti;
$kategoriler = $baglanti->query("SELECT isim,seo,modul FROM modulkategori");
while($m = $kategoriler->fetch_assoc()){
	$içerikler = $baglanti->query("SELECT id FROM modulicerik WHERE kategori ='".$m['seo']."' and modul = '".$m['modul']."'");
	$top_içerik = $içerikler->num_rows;
	$baglanti->query("UPDATE modulkategori SET kayitlar = $top_içerik WHERE seo = '".$m['seo']."' and modul = '".$m['modul']."' LIMIT 1");
	$içerikler->close();
}
$kategoriler->close();
}
if($sayfa == "kaydet"&&(yetkiVarmi('tum_modul')||yetkiVarmi('yeni_modul')||yetkiVarmi('m_'.$modul_seo))):
$baslik = trKarakter($baglanti->real_escape_string($_POST['baslik']));
$aciklama = trKarakter($baglanti->real_escape_string($_POST['aciklama']));
$kelime = trKarakter($baglanti->real_escape_string($_POST['kelime']));
$seo = trKarakter($baglanti->real_escape_string($_POST['seo']));
if(empty($seo)) $seo = seo_temizle(trKarakter($_POST['baslik']));
$icon = trKarakter($baglanti->real_escape_string($_POST['icon']));
$ana_tip = trKarakter($baglanti->real_escape_string($_POST['ana_tip']));
$oku_tip = trKarakter($baglanti->real_escape_string($_POST['oku_tip']));
$kat_tip = trKarakter($baglanti->real_escape_string($_POST['kat_tip']));
$blok_tip = trKarakter($baglanti->real_escape_string($_POST['blok_tip']));
$gizlilik = trKarakter($baglanti->real_escape_string($_POST['gizlilik']));
if(trKarakter($_POST['yeni'])){ 
$sql = "INSERT INTO modul VALUES ('','$baslik','$aciklama','$kelime','$icon','$ana_tip','$oku_tip','$kat_tip','$blok_tip','$gizlilik','$seo')";
$baglanti->query($sql) or die($baglanti->error);
$baglanti->query("INSERT INTO modulkategori VALUES ('','Kategorisiz','_resimler/bos.png','kategorisiz, uncategorized','Kategorisiz içerikler','$seo','Kategorisiz',0)");
echo 'Ok';
}else{
$sql = "UPDATE modul SET baslik='".$baslik."', aciklama='".$aciklama."', kelime='".$kelime."', icon='".$icon."', ana_tip='".$ana_tip."', oku_tip='".$oku_tip."', kat_tip='".$kat_tip."', blok_tip='".$blok_tip."', gizlilik='".$gizlilik."' WHERE seo='".$seo."' LIMIT 1";
$baglanti->query($sql) or die($baglanti->error);
echo 'Ok';
}
elseif($sayfa == "icerik-ekle"&&(yetkiVarmi('tum_modul')||yetkiVarmi('m_'.$modul_seo))):
$baþlýk = trKarakter($baglanti->real_escape_string(@$_POST['baslik']));
$içerik = trKarakter($baglanti->real_escape_string(@$_POST['icerik']));
$resim = trKarakter($baglanti->real_escape_string(@$_POST['resim']));
$etiket = trKarakter($baglanti->real_escape_string(@$_POST['etiket']));
$seo = $baglanti->real_escape_string(@$_POST['seo']);
$kod = 0;
if($_POST['kod']=='true') $kod = 1;
if(empty($seo)) $seo = seo_temizle(trKarakter(@$_POST['baslik']));

$modul = trKarakter($baglanti->real_escape_string(@$_POST['modul']));
$ekleyen = trKarakter($baglanti->real_escape_string(@$_POST['ekleyen']));
$kategori = trKarakter($baglanti->real_escape_string(@$_POST['kategori']));
$onay = trKarakter($baglanti->real_escape_string(@$_POST['onay']));
$yeni = trKarakter($baglanti->real_escape_string(@$_POST['yeni']));
if(!$yeni) $etiket = 'iyibu';
if(empty($baþlýk)||empty($içerik)||empty($etiket)) die('<span class="label label-important"><i class="icon-remove icon-white"></i> Boþ býraktýðýnýz alanlar var!</span><br><br>');
if($yeni){ // Yeni içerik
$sorgula = $baglanti->query("SELECT id FROM modulicerik where seo = '$seo' and modul = '$modul'");
if(!empty($sorgula->num_rows)) die('<span class="label label-important"><i class="icon-remove icon-white"></i> Böyle bir içerik zaten bulunmakta. Lütfen farklý bir baþlýk belirleyin.</span><br><br>');
$baglanti->query("INSERT INTO modulicerik VALUES ('','$baþlýk','$içerik','$resim','$etiket','$seo','$modul','".$_SESSION['yonetici']."',NOW(),'$kategori',0,'','$kod','$onay','')");
kategoriTazele();
die('Ok');
if($baglanti->error) die($baglanti->error);
}else{
$baglanti->query("UPDATE modulicerik SET baslik = '$baþlýk', icerik = '$içerik', resim='$resim', onay = $onay, kategori= '$kategori', kod = '$kod' WHERE seo = '$seo' LIMIT 1");
kategoriTazele();
if($baglanti->error) die($baglanti->error);
die('Ok');
}
elseif($sayfa == "seo"&&(yetkiVarmi('tum_modul')||yetkiVarmi('m_'.$modul_seo))):
$baslik = seo_temizle(trKarakter($_GET['cevir']));
$modul = $_GET['modul'];
$sorgula = $baglanti->query("SELECT id FROM modulicerik where seo = '$baslik' and modul = '$modul'");
if($sorgula->num_rows) die('<span class="label label-important" style="font-size:8pt">Böyle bir içerik zaten bulunmakta. Lütfen farklý bir baþlýk belirleyin.</span>');
$site_adres = rtrim($site_adres,'/');
if(empty($baslik)) die();
die('Seo Url: '.$site_adres.'/'.$modul.'/<b>'.$baslik.'</b>.html');
elseif($sayfa == "icerik-sil"&&(yetkiVarmi('tum_modul')||yetkiVarmi('m_'.$modul_seo))):
$baglanti->query('DELETE FROM modulicerik where id='.$_GET['id']);
kategoriTazele();
die('Ýçerik baþarýyla silindi!');
elseif($sayfa == "icerik-onayla"&&(yetkiVarmi('tum_modul')||yetkiVarmi('m_'.$modul_seo))):
$baglanti->query('UPDATE modulicerik SET onay = 1 where id='.$_GET['id']);
die('Ýçerik onaylandý');
elseif($sayfa == "icerik-onay-kaldir"&&(yetkiVarmi('tum_modul')||yetkiVarmi('m_'.$modul_seo))):
$baglanti->query('UPDATE modulicerik SET onay = 0 where id='.$_GET['id']);
die('Ýçeriðin onayý kaldýrýldý');
elseif($sayfa == "modul-kaldir"&&(yetkiVarmi('tum_modul')||yetkiVarmi('m_'.$modul_seo))):
$baglanti->query("DELETE FROM modulblok where modul='".$_GET['modul']."'");
$baglanti->query("DELETE FROM modulkategori where modul='".$_GET['modul']."'");
$baglanti->query("DELETE FROM modulicerik where modul='".$_GET['modul']."'");
$baglanti->query("DELETE FROM modul where seo='".$_GET['modul']."'");
die('Modül ve modüle ait tüm içerik ve yorumlar hepsi silindi. SAYFA YENÝLENECEK');
elseif($sayfa == "json-kategori"&&(yetkiVarmi('tum_modul')||yetkiVarmi('m_'.$modul_seo))):
$sorgu = $baglanti->query("SELECT id,isim,resim FROM modulkategori where modul='".$_GET['modul']."' ORDER BY id ASC");
$JSON["kategoriler"]=array();
$i=1;
while ($k = $sorgu->fetch_assoc()){
$gecici['id']=array();
$gecici['no']=array();
$gecici['isim']=array();
$gecici['resim']=array();
array_push($gecici['id'],$k['id']);
array_push($gecici['no'],$i++);
array_push($gecici['isim'],mb_convert_encoding($k['isim'], "UTF-8", "ISO-8859-9"));
array_push($gecici['resim'],$k['resim']);
array_push($JSON['kategoriler'],$gecici);
}
echo json_encode($JSON);
elseif($sayfa == "kategori-ekle"&&(yetkiVarmi('tum_modul')||yetkiVarmi('m_'.$modul_seo))):
$isim = trKarakter($baglanti->real_escape_string(@$_POST['k_isim']));
$resim = trKarakter($baglanti->real_escape_string(@$_POST['k_resim']));
$kelime = trKarakter($baglanti->real_escape_string(@$_POST['k_key']));
$aciklama = trKarakter($baglanti->real_escape_string(@$_POST['k_desc']));
$seo = seo_temizle($isim);
$modul = @$_POST['k_modul'];
$id = @$_POST['k_id'];
if(empty($id)){
$baglanti->query("INSERT INTO modulkategori VALUES ('','$isim','$resim','$kelime','$aciklama','$modul','$seo','')") or trigger_error(@$baglanti->error);
}else{
$baglanti->query("UPDATE modulkategori SET isim ='$isim',resim ='$resim',kelime ='$kelime',aciklama ='$aciklama' WHERE id=$id LIMIT 1") or trigger_error(@$baglanti->error);
}
elseif($sayfa == "kategori-sil"&&(yetkiVarmi('tum_modul')||yetkiVarmi('m_'.$modul_seo))):
$id = @$_GET['id'];
$baglanti->query("DELETE FROM modulkategori WHERE id=$id LIMIT 1");
elseif($sayfa == "json-yorumlar"&&(yetkiVarmi('tum_modul')||yetkiVarmi('m_'.$modul_seo))):
$sorgu = $baglanti->query("SELECT id,yorum,ekleyen,tarih,onay FROM yorumlar WHERE modul='".$_GET['modul']."' and icerik='".$_GET['icerik']."' ORDER BY onay ASC");
$JSON["yorumlar"]=array();
$i=2;
while ($k = $sorgu->fetch_assoc()){
$gecici['id']=array();
$gecici['yorum']=array();
$gecici['ekleyen']=array();
$gecici['tarih']=array();
$gecici['onay']=array();
array_push($gecici['id'],$k['id']);
array_push($gecici['yorum'],mb_convert_encoding($k['yorum'], "UTF-8", "ISO-8859-9"));
array_push($gecici['ekleyen'],$k['ekleyen']);
array_push($gecici['tarih'],$k['tarih']);
array_push($gecici['onay'],$k['onay']);
array_push($JSON['yorumlar'],$gecici);
}
echo json_encode($JSON);
elseif($sayfa == "yorum-onayla"&&(yetkiVarmi('tum_modul')||yetkiVarmi('m_'.$modul_seo))):
$baglanti->query('UPDATE yorumlar SET onay = 1 where id='.$_GET['id']);
elseif($sayfa == "yorum-onay-kaldir"&&(yetkiVarmi('tum_modul')||yetkiVarmi('m_'.$modul_seo))):
$baglanti->query('UPDATE yorumlar SET onay = 0 where id='.$_GET['id']);
elseif($sayfa == "yorum-sil"&&(yetkiVarmi('tum_modul')||yetkiVarmi('m_'.$modul_seo))):
$baglanti->query('DELETE FROM yorumlar where id='.$_GET['id']);
endif;?>