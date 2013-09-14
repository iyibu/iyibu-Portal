<?php header('Content-Type: text/html; charset=iso-8859-9');
require(__DIR__ . '/../baglanti.php');
require(__DIR__ . '/../_inc/fonksiyonlar.php');
if($_SESSION['yonetici']==false){header('Location: giris.php');
die();}?>
<!DOCTYPE html>
<html>
<head>
	<title>iyibu!Portal Kontrol Paneli</title>
	<link media="all" rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link media="all" rel="stylesheet" type="text/css" href="css/datepicker.css">
	<link media="all" rel="stylesheet" type="text/css" href="css/select2.css">
	<link media="all" rel="stylesheet" type="text/css" href="css/iyibu.css">
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/select2.js"></script>
	<script type="text/javascript" src="js/select2_locale_tr.js"></script>
	<script type="text/javascript" src="js/fonksiyonlar.js"></script>
	  <script type="text/javascript" src="js/jquery-ui-1.10.3.custom.min.js"></script>
	  <script type="text/javascript" src="js/bootbox.min.js"></script>
	  <script type="text/javascript" src="../_editor/tinymce.min.js"></script>
	  <script type="text/javascript" src="../_editor/jquery.tinymce.min.js"></script>
	  <script type="text/javascript" src="js/jquery.ba-resize.min.js"></script>
	  <script type="text/javascript" src="js/bootstrap-paginator.min.js"></script>
	  <script type="text/javascript" src="js/bootstrap-datepicker.js"></script>
	  <script type="text/javascript" src="js/bootstrap-datepicker.tr.js"></script>

	<link rel="shortcut icon" href="img/favicon.ico" />
</head>
<body>
<div class="ust-bar"><div id="ust-bar"><a href="index.php" style="text-decoration:none"><div class="logo">iyibu!Portal:PHP</div></a>
<div class="btn-group pull-right" style="margin-right:10px;">
			<button class="btn btn-inverse" onclick="location.href='cikis.php';"><i class="icon-off icon-white"></i> Çýkýþ Yap</button>
			<button class="btn dropdown-toggle btn-inverse" data-toggle="dropdown">
			<span class="caret"></span>
			</button>
  <ul class="dropdown-menu">
    <li><a target="_blank" href="<?php echo $site_adres?>"><i class="icon-globe"></i> Siteyi Gör</a></li>
  </ul>
</div>
</div></div>
<div class="row-fluid">
  <div id="sol-menu">
  <ul class="sol-menu">
  <?php if(yetkiVarmi('site')):?><li><i class="icon-home icon-white"></i><br>Site Genel</li><?php endif;?>
  <?php if(yetkiVarmi('modul')):?><li><i class="icon-file icon-white"></i><br>Modül</li><?php endif;?>
  <?php if(yetkiVarmi('tema')):?><li><i class="icon-heart icon-white"></i><br>Tema</li><?php endif;?>
  <?php if(yetkiVarmi('uye')):?><li><i class="icon-user icon-white"></i><br>Üyeler</li><?php endif;?>
  <?php if(yetkiVarmi('vt')):?><li><i class="icon-hdd icon-white"></i><br>Veritabaný</li><?php endif;?>
  <div id="iyibu"><a target="_blank" href="http://www.iyibu.org">iyibu.org<img src="img/link_arrow.png"></a><br>© 2011-<?php echo date('Y')?><br></div>
  </ul></div>
  <div id="sol-menu-sub">
  <?php if(yetkiVarmi('site')):?>
  <ul class="sol-menu">
  <?php if(yetkiVarmi('s_ist')&&1==2):?><li ustmenu="ustmenu.php?q=site-genel" sayfa="istatistikler.php" aktif="#link1"><i class="icon-tasks icon-white"></i> Ýstatistikler</li><?php endif;?>
  <?php if(yetkiVarmi('s_ayr')):?><li ustmenu="ustmenu.php?q=site-genel" sayfa="site_genel.php?sayfa=ayarlar" aktif="#link2"><i class="icon-cog icon-white"></i> Site Ayarlarý</li><?php endif;?>
  <?php if(yetkiVarmi('s_blg')):?><li ustmenu="ustmenu.php?q=site-genel" sayfa="site_genel.php?sayfa=sistem" aktif="#link3"><i class="icon-info-sign icon-white"></i> Sistem Bilgisi</li><?php endif;?>
  <?php if(yetkiVarmi('s_bynt')):?><li ustmenu="ustmenu.php?q=site-genel" sayfa="site_genel.php?sayfa=blok-yonetimi" aktif="#link4"><i class="icon-th icon-white"></i> Blok Yönetimi</li><?php endif;?>
  <?php if(yetkiVarmi('s_mynt')):?><li ustmenu="ustmenu.php?q=site-genel" sayfa="menu.php" aktif="#link5"><i class="icon-th-list icon-white"></i> Menü Yönetimi</li><?php endif;?>
  <?php if(yetkiVarmi('s_adzn')):?><li ustmenu="ustmenu.php?q=site-genel" sayfa="blok-listele.php?modul=index&blok_tip=" aktif="#link6"><i class="icon-home icon-white"></i> Anasayfa Düzeni</li><?php endif;?>
  <?php endif;?></ul>
  
  
  <?php if(yetkiVarmi('modul')):?><ul class="sol-menu">
  <?php $sorgu = $baglanti->query('select baslik, seo, blok_tip from modul');
  while($modul = $sorgu->fetch_assoc()){
	$modul_seo = $modul['seo'];
	if(yetkiVarmi('tum_modul')||yetkiVarmi('m_'.$modul_seo)){
	echo '<li ustmenu="ustmenu.php?q=modul&modul='.$modul_seo.'&blok_tip='.$modul['blok_tip'].'" sayfa="modul.php?sayfa=form&modul='.$modul_seo.'" aktif="#m_link1"><i class="icon-file icon-white"></i> '.$modul['baslik'].'</li>';
	};
	}?>
  <?php if(yetkiVarmi('yeni_modul')):?><li ustmenu="ustmenu.php" sayfa="modul.php?sayfa=form"><i class="icon-plus-sign icon-white"></i> Yeni Modül Ekle</li><?php endif;?>
  </ul><?php endif;?>
  
  
  <?php if(yetkiVarmi('tema')):?><ul class="sol-menu">
   <?php if(yetkiVarmi('t_ayr')):?><li ustmenu="ustmenu.php" sayfa="tema.php?sayfa=form"><i class="icon-wrench icon-white"></i> Tema Ayarlarý</li><?php endif;?>
   </ul><?php endif;?>
   
   
  <?php if(yetkiVarmi('uye')):?><ul class="sol-menu">
  <?php if(yetkiVarmi('u_ist')):?><li ustmenu="ustmenu.php?q=uye" sayfa="uye.php?sayfa=istatistik" aktif="#u_link1"><i class="icon-tasks icon-white"></i> Ýstatistikler</li><?php endif;?>
  <?php if(yetkiVarmi('u_uye')):?><li ustmenu="ustmenu.php?q=uye" sayfa="uye.php?sayfa=uyeler" aktif="#u_link2"><i class="icon-user icon-white"></i> Tüm Üyeler</li><?php endif;?>
  <?php if(yetkiVarmi('u_yetki')):?><li ustmenu="ustmenu.php?q=uye" sayfa="uye.php?sayfa=yetki" aktif="#u_link3"><i class="icon-lock icon-white"></i> Yetki Ýþlemleri</li><?php endif;?>
  <?php if(yetkiVarmi('u_pst')):?><li ustmenu="ustmenu.php?q=uye" sayfa="uye.php?sayfa=posta" aktif="#u_link4"><i class="icon-envelope icon-white"></i> E-Posta/Mesaj Gönder</li><?php endif;?>
  <?php if(yetkiVarmi('u_yni')):?><li ustmenu="ustmenu.php?q=uye" sayfa="uye.php?sayfa=form" aktif="#u_link5"><i class="icon-plus-sign icon-white"></i> Yeni Üye Ekle</li><?php endif;?>
  </ul><?php endif;?>
  
  
  <?php if(yetkiVarmi('vt')):?><ul class="sol-menu">
  <?php if(yetkiVarmi('vt_sql')):?><li ustmenu="ustmenu.php" sayfa="tema.php"><i class="icon-hdd icon-white"></i> Toplu SQL Sorgusu</li><?php endif;?>
   <?php if(yetkiVarmi('vt_ydk')):?><li ustmenu="ustmenu.php" sayfa="tema.php"><i class="icon-download-alt icon-white"></i> Yedekle</li><?php endif;?>
   </ul><?php endif;?>
   
   
 </div>
 
	<div id="menu">
	</div>
 <div id="sayfa" adres="<?php echo $site_adres?>"><div id="hosgeldin"><h1>Hoþgeldiniz!</h1><br>Burasý sizin yönetim alanýnýz. Web sitenizi yönetmeye sol taraftaki menüden baþlayabilirsiniz. <br>Unutmayýn! Bu panel üzerinden sitenize her türlü iþlem yapýlabilir. Bu nedenle yetkisiz birinin eline geçmesi geri dönüþü olmayan sonuçlar doðurabilir..<br><br><i>iyibu!Portal:PHP Ücretsiz Hazýr Site <a href="http://www.iyibu.org">iyibu.org<img src="img/link_arrow.png"></a></i></div></div>
</div>
</body>
</html>