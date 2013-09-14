<?php
header('Content-Type: text/html; charset=iso-8859-9');
require('baglanti.php');
require('_inc/fonksiyonlar.php');
require('_inc/iyibuTema.php');
$iyibu 		= new iyibu_Tema;
$moduller 	= new iyibu;
$iyibu->dizin = '_tema/'.$site_tema.'/';

#modul bilgileri al�n�yor#
$modul_seo = @$_GET['modul'];
$modul_seo = $baglanti->real_escape_string($modul_seo);
if(empty($modul_seo)) die('Hata: Ge�ersiz kimlik');
$modul_se�im = 'modul-ana.tpl';
$modul = $baglanti->query('SELECT id, baslik, aciklama, kelime, icon, ana_tip, oku_tip, kat_tip, blok_tip, gizlilik, seo FROM modul WHERE seo = \''.$modul_seo.'\' LIMIT 1');
if(empty($modul->num_rows)){ die('Hata: �stenilen modul bulunamad�: '.$modul_seo);}
$modul_sayfa = 1;
if(is_numeric(@$_GET['kategori'])) $modul_sayfa = @$_GET['kategori'];
$modul_girdiler = $modul->fetch_assoc();
$t_i_s = $baglanti->query("SELECT count(id) FROM modulicerik WHERE modul='$modul_seo' LIMIT 1");
$toplam_i�erik = $t_i_s->fetch_row();
$toplam_i�erik = $toplam_i�erik[0];
$toplam_sayfa = ceil(($toplam_i�erik)/5);
if($toplam_sayfa<1) $toplam_sayfa=1;
if($modul_sayfa>$toplam_sayfa) die('Hata: B�yle bir sayfa yok');
$modul_girdiler['sayfa'] = $modul_sayfa;
$modul_girdiler['toplam_sayfa'] = $toplam_sayfa;
$modul_girdiler['toplam_i�erik'] = $toplam_i�erik;
$iyibu->dizi('modul',$modul_girdiler);
$sayfa_baslik = $modul_girdiler['baslik'];
$modul->close();
$modul_yer = 'ana';
#modul bilgileri al�nd�#

#kategori bilgileri al�n�yor#
if(empty($i�erik_seo)){
$kategori_seo = @$_GET['kategori'];
$kategori_seo = $baglanti->real_escape_string($kategori_seo);
if(!empty($kategori_seo)&&!is_numeric($kategori_seo)){
$kategori = $baglanti->query('SELECT id, isim,resim,kelime,aciklama,modul,seo,kayitlar FROM modulkategori WHERE seo = \''.$kategori_seo.'\' and modul = \''.$modul_seo.'\' LIMIT 1');
if(empty($kategori->num_rows)) die('Hata: B�yle bir kategori bulunamad�');
$modul_se�im = 'modul-kat.tpl';
$kategori_girdiler = $kategori->fetch_assoc();
$iyibu->dizi('kategori',$kategori_girdiler);
$sayfa_baslik .= ' :: '.$kategori_girdiler['isim'];
$kategori->close();
$modul_yer = 'kat';
}
}
#kategori bilgileri al�nd�#

#i�erik bilgileri al�n�yor#
$i�erik_seo = @$_GET['oku'];
$i�erik_seo = $baglanti->real_escape_string($i�erik_seo);
if(!empty($i�erik_seo)){
$i�erik = $baglanti->query('SELECT id, baslik, icerik, resim, etiket, seo, modul, ekleyen, tarih, kategori, onay,sayac,kod FROM modulicerik WHERE seo = \''.$i�erik_seo.'\' and modul = \''.$modul_seo.'\' and onay = 1 LIMIT 1');
if(empty($i�erik->num_rows)) die('Hata: B�yle bir i�erik bulunamad�');
$modul_se�im = 'modul-oku.tpl';
$i�erik_girdiler = $i�erik->fetch_assoc();
$i�erik_girdiler['sayac']++;
if($i�erik_girdiler['kod']==0) $i�erik_girdiler['icerik'] = $iyibu->noscript($i�erik_girdiler['icerik']);
$iyibu->dizi('i�erik',$i�erik_girdiler);
$sayfa_baslik = $i�erik_girdiler['baslik'];
$modul_yer = 'oku';
$kategori = $baglanti->query('SELECT id, isim,resim,kelime,aciklama,modul,seo,kayitlar FROM modulkategori WHERE seo = \''.$i�erik_girdiler['kategori'].'\' and modul = \''.$modul_seo.'\' LIMIT 1');
if(!empty($kategori->num_rows)){
$kategori_girdiler = $kategori->fetch_assoc();
$iyibu->dizi('kategori',$kategori_girdiler);
}
$kategori->close();
$baglanti->query("UPDATE modulicerik SET sayac = sayac+1 WHERE seo = '".$i�erik_girdiler['seo']."' LIMIT 1") or die();
$yorumlar = $baglanti->query("SELECT id, yorum, ekleyen,tarih FROM yorumlar WHERE modul='$modul_seo' and icerik= '$i�erik_seo' and onay = 1") or die('hata');
$t�m_yorumlar = array();
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
$t�m_yorumlar[] = $y_a;
};
$t�m_yorumlar['toplam'] = array_count($t�m_yorumlar);
$iyibu->dizi('yorumlar',$t�m_yorumlar);
$i�erik->close();
}
#i�erik bilgileri al�nd�#

$iyibu->kaynak($modul_se�im);
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
$iyibu->yay�nla();
$moduller->tazele($oturum_tazele);
?>