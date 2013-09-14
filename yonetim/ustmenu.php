<?php header('Content-Type: text/html; charset=iso-8859-9');
require(__DIR__ . '/../AYARLAR.php');
require(__DIR__ . '/../_inc/fonksiyonlar.php');
session_start();
if($_SESSION['yonetici']==false){header('Location: giris.php');
die();};
$sayfa = @$_GET['q'];
if($sayfa == "site-genel"&&yetkiVarmi('site')):?>
<div class="navbar">
  <div class="navbar-inner">
    <a class="brand">Site Genel</a>
    <ul class="nav" style="position:static">
	<?php if(yetkiVarmi('s_ist')&&1==2):?><li id="link1" sayfa="istatistikler.php"><a href="javascript:void(0)" onclick="menusec('#link1')">�statistikler</a></li><?php endif;?>
      <?php if(yetkiVarmi('s_ayr')):?><li id="link2" sayfa="site_genel.php?sayfa=ayarlar"><a href="javascript:void(0)" onclick="menusec('#link2')">Site Ayarlar�</a></li><?php endif;?>
      <?php if(yetkiVarmi('s_blg')):?><li  id="link3" sayfa="site_genel.php?sayfa=sistem"><a href="javascript:void(0)" onclick="menusec('#link3')">Sistem Bilgisi</a></li><?php endif;?>
      <?php if(yetkiVarmi('s_bynt')):?><li id="link4" sayfa="site_genel.php?sayfa=blok-yonetimi"><a href="javascript:void(0)" onclick="menusec('#link4')">Blok Y�netimi</a></li><?php endif;?>
	  <?php if(yetkiVarmi('s_mynt')):?><li id="link5" sayfa="menu.php"><a href="javascript:void(0)" onclick="menusec('#link5')">Men� Y�netimi</a></li><?php endif;?>
	  <?php if(yetkiVarmi('s_adzn')):?><li id="link6" sayfa="blok-listele.php?modul=index&blok_tip=<?php echo $site_aduzen?>"><a href="javascript:void(0)" onclick="menusec('#link6')">Anasayfa D�zeni</a></li><?php endif;?>
    </ul>
  </div>
</div>
<?php elseif($sayfa == "uye"&&yetkiVarmi('uye')):?>
<div class="navbar">
  <div class="navbar-inner">
    <a class="brand">�yelik Y�netimi</a>
    <ul class="nav" style="position:static">
	<?php if(yetkiVarmi('u_ist')):?><li id="u_link1" sayfa="uye.php?sayfa=istatistik"><a href="javascript:void(0)" onclick="menusec('#u_link1')">�statistikler</a></li><?php endif;?>
	<?php if(yetkiVarmi('u_uye')):?><li id="u_link2" sayfa="uye.php?sayfa=uyeler"><a href="javascript:void(0)" onclick="menusec('#u_link2')">T�m �yeler</a></li><?php endif;?>
	<?php if(yetkiVarmi('u_yetki')):?><li id="u_link3" sayfa="uye.php?sayfa=yetki"><a href="javascript:void(0)" onclick="menusec('#u_link3')">Yetki ��lemleri</a></li><?php endif;?>
	<?php if(yetkiVarmi('u_pst')):?><li id="u_link4" sayfa="uye.php?sayfa=posta"><a href="javascript:void(0)" onclick="menusec('#u_link4')">E-Posta/Mesaj G�nder</a></li><?php endif;?>
	<?php if(yetkiVarmi('u_yni')):?><li id="u_link5" sayfa="uye.php?sayfa=form"><a href="javascript:void(0)" onclick="menusec('#u_link5')">Yeni �ye Ekle</a></li><?php endif;?>
    </ul>
  </div>
</div>
<?php elseif($sayfa == "modul"&&(yetkiVarmi('tum_modul')||yetkiVarmi('m_'.$_GET['modul']))):?>
<div class="navbar">
  <div class="navbar-inner">
    <a class="brand">Mod�l Ayarlar�</a>
    <ul class="nav" style="position:static">
	<li id="m_link1" sayfa="modul.php?sayfa=form&modul=<?php echo $_GET['modul']?>"><a href="javascript:void(0)" onclick="menusec('#m_link1')">Mod�l D�zenle</a></li>
	<li id="m_link2" sayfa="modul-icerik.php?sayfa=form&modul=<?php echo $_GET['modul']?>"><a href="javascript:void(0)" onclick="menusec('#m_link2')">Yeni ��erik Ekle</a></li>
	<li id="m_link3" sayfa="modul-icerik.php?sayfa=duzenle&modul=<?php echo $_GET['modul']?>"><a href="javascript:void(0)" onclick="menusec('#m_link3')">��erikleri D�zenle</a></li>
	<?php if(yetkiVarmi('s_bynt')):?><li id="m_link4" sayfa="blok-listele.php?modul=<?php echo $_GET['modul']?>&blok_tip=<?php echo $_GET['blok_tip']?>"><a href="javascript:void(0)" onclick="menusec('#m_link4')">Bloklar� D�zenle</a></li><?php endif;?>
    </ul>
  </div>
</div>
<?php endif;?>