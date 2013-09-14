<?php header('Content-Type: text/html; charset=iso-8859-9');
require(__DIR__ . '/../baglanti.php');
require(__DIR__ . '/../_inc/fonksiyonlar.php');
if($_POST){
if(!empty($_POST[$_SESSION['y_f_k']])&&!empty($_POST[$_SESSION['y_f_s']])){
$kadi = $baglanti->real_escape_string($_POST[$_SESSION['y_f_k']]);
$þifre = md5($baglanti->real_escape_string($_POST[$_SESSION['y_f_s']]));
$sorgu = $baglanti->query("SELECT kullaniciadi,Yetki FROM uyeler WHERE kullaniciadi='$kadi' and parola = '$þifre' and Yetki >= 1 LIMIT 1");
if(!empty($sorgu->num_rows)){
$sonuc = $sorgu->fetch_assoc();
$yetki = $baglanti->query("SELECT yetkiler FROM yetki WHERE id ={$sonuc['Yetki']} LIMIT 1");
$yetkiler = $yetki->fetch_assoc();
$yetkiler = $yetkiler['yetkiler'];
$yetkiler = @explode(',',$yetkiler);
$_SESSION['yetki'] = $yetkiler;
$_SESSION['yonetici'] = $sonuc['kullaniciadi'];
header('Location: index.php');}
$hata = true;
}
}
$_SESSION['y_f_k'] = rndStr();
$_SESSION['y_f_s'] = rndStr();
$y_f_k = @$_SESSION['y_f_k'];
$y_f_s = @$_SESSION['y_f_s'];
?>
<!DOCTYPE html>
<html>
<head>
	<title>iyibu!Portal Kontrol Paneli</title>
	<link media="all" rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link media="all" rel="stylesheet" type="text/css" href="http://ivaynberg.github.io/select2/select2-3.4.1/select2.css">
	<link media="all" rel="stylesheet" type="text/css" href="css/iyibu.css">
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="http://ivaynberg.github.io/select2/select2-3.4.1/select2.js"></script>
	<script type="text/javascript" src="js/select2_locale_tr.js"></script>
	<script type="text/javascript" src="js/fonksiyonlar.js"></script>
	  <script type="text/javascript" src="js/jquery-ui-1.10.3.custom.min.js"></script>
	  <script type="text/javascript" src="js/bootbox.min.js"></script>
	  <script type="text/javascript" src="../_editor/tinymce.min.js"></script>
	  <script type="text/javascript" src="../_editor/jquery.tinymce.min.js"></script>
	  <script type="text/javascript" src="js/jquery.ba-resize.min.js"></script>

	<link rel="shortcut icon" href="img/favicon.ico" />
</head>
<body>
<div class="ust-bar"><div id="ust-bar"><a href="index.php" style="text-decoration:none"><div class="logo">iyibu!Portal:PHP</div></a>
<div class="btn-group pull-right" style="margin-right:10px;">
			<button class="btn btn-inverse"><i class="icon-question-sign icon-white"></i> Þifremi Unuttum?</button>
			<button class="btn dropdown-toggle btn-inverse" data-toggle="dropdown">
			<span class="caret"></span>
			</button>
  <ul class="dropdown-menu">
    <li><a target="_blank" href="<?php echo $site_adres?>"><i class="icon-globe"></i> Siteyi Gör</a></li>
  </ul>
</div>
</div></div>
<div id="sayfa">
    <div id="hosgeldin">
        <div class="span4 well">
            <legend>iyibu!Portal:PHP Yönetim Paneli</legend>
			<?php if(@$hata):?>
			<div class="alert alert-danger">
                <a class="close" data-dismiss="alert" href="#">×</a>Geçersiz Kullanýcý Adý/Þifre
            </div>
			<?php else:?>
            <div class="alert alert-info">
                <a class="close" data-dismiss="alert" href="#">×</a>Lütfen kullanýcý giriþi yapýn
            </div>
			<?php endif;?>
            <form method="POST" action="">
            <input type="text" id="username" class="span4" name="<?php echo $y_f_k;?>" placeholder="Kullanýcý Adý" onload="$(this).focus()" autofocus>
            <input type="password" id="password" class="span4" name="<?php echo $y_f_s;?>" placeholder="Þifre">
            <button type="submit" name="submit" class="btn btn-primary btn-block">Giriþ Yap</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>