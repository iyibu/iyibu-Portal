<?php
header('Content-Type: text/html; charset=iso-8859-9');
require('baglanti.php');
require('_inc/fonksiyonlar.php');
require('_inc/iyibuTema.php');
$iyibu 		= new iyibu_Tema;
$moduller 	= new iyibu;
$iyibu->dizin = '_tema/'.$site_tema.'/';

#modul bilgileri alýnýyor#
$modul_seo = @$_GET['modul'];
$modul_seo = $baglanti->real_escape_string($modul_seo);
if(empty($modul_seo)) die('Hata: Geçersiz kimlik');
$modul_seçim = 'modul-ana.tpl';
$modul = $baglanti->query('SELECT id, baslik, aciklama, kelime, icon, ana_tip, oku_tip, kat_tip, blok_tip, gizlilik, seo FROM modul WHERE seo = \''.$modul_seo.'\' LIMIT 1');
if(empty($modul->num_rows)){ die('Hata: Ýstenilen modul bulunamadý: '.$modul_seo);}
$modul_sayfa = 1;
if(is_numeric(@$_GET['kategori'])) $modul_sayfa = @$_GET['kategori'];
$modul_girdiler = $modul->fetch_assoc();
$t_i_s = $baglanti->query("SELECT count(id) FROM modulicerik WHERE modul='$modul_seo' LIMIT 1");
$toplam_içerik = $t_i_s->fetch_row();
$toplam_içerik = $toplam_içerik[0];
$toplam_sayfa = ceil(($toplam_içerik)/5);
if($toplam_sayfa<1) $toplam_sayfa=1;
if($modul_sayfa>$toplam_sayfa) die('Hata: Böyle bir sayfa yok');
$modul_girdiler['sayfa'] = $modul_sayfa;
$modul_girdiler['toplam_sayfa'] = $toplam_sayfa;
$modul_girdiler['toplam_içerik'] = $toplam_içerik;
$iyibu->dizi('modul',$modul_girdiler);
$sayfa_baslik = $modul_girdiler['baslik'];
$modul->close();
$modul_yer = 'ana';
#modul bilgileri alýndý#

#kategori bilgileri alýnýyor#
if(empty($içerik_seo)){
$kategori_seo = @$_GET['kategori'];
$kategori_seo = $baglanti->real_escape_string($kategori_seo);
if(!empty($kategori_seo)&&!is_numeric($kategori_seo)){
$kategori = $baglanti->query('SELECT id, isim,resim,kelime,aciklama,modul,seo,kayitlar FROM modulkategori WHERE seo = \''.$kategori_seo.'\' and modul = \''.$modul_seo.'\' LIMIT 1');
if(empty($kategori->num_rows)) die('Hata: Böyle bir kategori bulunamadý');
$modul_seçim = 'modul-kat.tpl';
$kategori_girdiler = $kategori->fetch_assoc();
$iyibu->dizi('kategori',$kategori_girdiler);
$sayfa_baslik .= ' :: '.$kategori_girdiler['isim'];
$kategori->close();
$modul_yer = 'kat';
}
}
#kategori bilgileri alýndý#

#içerik bilgileri alýnýyor#
$içerik_seo = @$_GET['oku'];
$içerik_seo = $baglanti->real_escape_string($içerik_seo);
if(!empty($içerik_seo)){
$içerik = $baglanti->query('SELECT id, baslik, icerik, resim, etiket, seo, modul, ekleyen, tarih, kategori, onay,sayac,kod FROM modulicerik WHERE seo = \''.$içerik_seo.'\' and modul = \''.$modul_seo.'\' and onay = 1 LIMIT 1');
if(empty($içerik->num_rows)) die('Hata: Böyle bir içerik bulunamadý');
$modul_seçim = 'modul-oku.tpl';
$içerik_girdiler = $içerik->fetch_assoc();
$içerik_girdiler['sayac']++;
if($içerik_girdiler['kod']==0) $içerik_girdiler['icerik'] = $iyibu->noscript($içerik_girdiler['icerik']);
$iyibu->dizi('içerik',$içerik_girdiler);
$sayfa_baslik = $içerik_girdiler['baslik'];
$modul_yer = 'oku';
$kategori = $baglanti->query('SELECT id, isim,resim,kelime,aciklama,modul,seo,kayitlar FROM modulkategori WHERE seo = \''.$içerik_girdiler['kategori'].'\' and modul = \''.$modul_seo.'\' LIMIT 1');
if(!empty($kategori->num_rows)){
$kategori_girdiler = $kategori->fetch_assoc();
$iyibu->dizi('kategori',$kategori_girdiler);
}
$kategori->close();
$baglanti->query("UPDATE modulicerik SET sayac = sayac+1 WHERE seo = '".$içerik_girdiler['seo']."' LIMIT 1") or die();
$yorumlar = $baglanti->query("SELECT id, yorum, ekleyen,tarih FROM yorumlar WHERE modul='$modul_seo' and icerik= '$içerik_seo' and onay = 1") or die('hata');
$tüm_yorumlar = array();
while($yorum = $yorumlar->fetch_assoc()){
$kadi = $yorum['ekleyen'];
$sorgu = $baglanti->query("SELECT email FROM uyeler WHERE kullaniciadi ='$kadi' LIMIT 1");
$md5Email = $sorgu->fetch_assoc();
$md5Email = $md5Email['email'];
$md5Email = md5($md5Email);
$sorgu->close();
$y_a = $yorum;
$y_a['k_tarih'] = nezaman($yorum['tarih']);
$y_a['md5Email'] = $md5Email;
$y_a['yorum'] = $iyibu->noscript($y_a['yorum']);
$tüm_yorumlar[] = $y_a;
};
$tüm_yorumlar['toplam'] = array_count($tüm_yorumlar);
$iyibu->dizi('yorumlar',$tüm_yorumlar);
$içerik->close();
}
#içerik bilgileri alýndý#

$iyibu->kaynak($modul_seçim);
$iyibu->girdi('tema_adi',$site_tema);

$iyibu->girdi('uye_giris',0);
if(!empty($_SESSION['kadi'])){
$iyibu->girdi('uye_giris',1);
$iyibu->girdi('kullanici',$_SESSION['kadi']);
};

$iyibu->dizi('site',array('kelime'=>$meta_keywords,'aciklama'=>$meta_desc,'adres'=>rtrim($site_adres, '/'),'baslik'=>$site_baslik,'tema'=>$site_tema));

$iyibu->girdi('sayfa_baslik',$sayfa_baslik);

$moduller->menu();
$moduller->bloklar($modul_seo,$modul_yer);
$moduller->temaAyarlari();
$iyibu->yayýnla();
$moduller->tazele($oturum_tazele);
?>