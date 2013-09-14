<?php header('Content-Type: text/html; charset=iso-8859-9');
require(__DIR__ . '/../_inc/fonksiyonlar.php');
$sayfa = @$_GET['sayfa'];
if($sayfa == ""):
require(__DIR__ . '/../AYARLAR.php');
$adres2 = '../_tema/'.$site_tema.'/AYARLAR.xml';
$blok_ayar = simplexml_load_file($adres2);
?>
<!DOCTYPE html>
<html>
<head>
<title>iyibu!Portal v1.0 Kurulum * Beta</title>
<meta charset="iso-8859-9">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-9">
<meta http-equiv="Content-Language" content="tr">
<meta http-equiv="X-UA-Compatible" content="ie10" />
<meta name="keywords" content="#anahtar_kelime#">
<meta name="description" content="#meta_aciklama#">
<link href="../iyibu.css" rel="stylesheet" type="text/css">
<link href="../yonetim/css/select2.css" rel="stylesheet" type="text/css">
<link media="all" rel="stylesheet" type="text/css" href="../yonetim/css/iyibu.css">
<link rel="shortcut icon" href="../_tema/klasik/img/favicon.ico" />
<script src="../iyibu.js"></script>
<script src="../yonetim/js/fonksiyonlar.js"></script>
<script src="../yonetim/js/select2.js"></script>
</head>
<body>
<div class="blok kur">
<div class="row-fluid"><div class="span12 blok-ust">
<h4 style="margin-top:4px">iyibu!Portal v1.0 Kurulum * Beta</h4>
</div></div><div class="row-fluid"><div class="span12 blok-orta">
  <?php if (!is_writable('../AYARLAR.php')) {
    echo "<div class=\"alert alert-danger\">
  <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
  <h4>Bir sorun var gibi!</h4>
  AYARLAR.php dosyas� yaz�labilir de�il! De�i�iklikleri kaydedemeyeceksiniz!
</div>";}?>
<form id="site-ayarlari" method="POST" action="javascript:ayarlari_kaydet()" class="form-horizontal">
  <div class="control-group">
    <label class="control-label" for="m_host">Mysql Sunucu Adresi</label>
    <div class="controls">
      <input type="text" name="m_host" id="m_host" placeholder="�rn. localhost" value="<?php echo $mysql_host?>">
	  <i class="icon-info-sign tip" rel="popover" data-content="Bu ayar Mysql'deki host de�i�kenini belirler. ($mysql_host) <br>Genelde localhost'tur. Ancak kimi hosting sa�lay�c�lar�nda Mysql farkl� bir adreste bulunabilir. K�saca Mysql'in bulundu�u sunucu adresidir diyebiliriz.<hr><br>�rn. 'localhost'<br>�rn. 'mysql.iyibu.org:8080" data-original-title="Mysql Host Ayar� :: �nemli De�i�ken" data-trigger="hover" data-html="true"></i>
    </div>
  </div>
  
  <div class="control-group">
    <label class="control-label" for="m_kadi">Mysql Kullan�c� Ad�</label>
    <div class="controls">
      <input type="text" name="m_kadi" id="m_kadi" placeholder="�rn. root" value="<?php echo $mysql_user?>">
	  <i class="icon-info-sign tip" rel="popover" data-content="Mysql kullan�c� ad�. ($mysql_user) <br>Genelde  root'tur. Ancak kendi verdi�iniz bir isim de olabilir. <hr><br>�rn. 'root'<br>�rn. 'turan'" data-original-title="Mysql Kullan�c� Ad� :: �nemli De�i�ken" data-trigger="hover" data-html="true"></i>
    </div>
  </div>
  
    <div class="control-group">
    <label class="control-label" for="m_sif">Mysql �ifresi</label>
    <div class="controls">
      <input type="password" name="m_sif" id="m_sif" placeholder="E�er yoksa bo� b�rak�n" value="<?php echo $mysql_pass?>">
	  <i class="icon-info-sign tip" rel="popover" data-content="Mysql �ifreniz. ($mysql_pass) <br>Localhostlarda bo� bir de�er olabilir . Ancak genelde bunu hosting panelinizden belirlersiniz" data-original-title="Mysql �ifresi :: �nemli De�i�ken" data-trigger="hover" data-html="true"></i>
    </div>
  </div>
  
  <div class="control-group">
    <label class="control-label" for="m_db">Mysql Veritaban�</label>
    <div class="controls">
      <input type="text" name="m_db" id="m_db" placeholder="Veritaban� Ad�n� Girin" value="<?php echo $mysql_db?>">
	  <i class="icon-info-sign tip" rel="popover" data-content="Mysql veritaban� ad�. ($mysql_db) <br>Yeni olu�turdu�unuz veya var olan veritaban� ad�." data-original-title="Mysql Veritaban� :: �nemli De�i�ken" data-trigger="hover" data-html="true"></i>
	  <button id="dogrula" type="button" class="btn btn-success" onclick="vt_test()">Veritaban�n� Bilgilerini Do�rula!</button>
		<div id="vt_test"></div>
    </div>
  </div>
  <br>
  <hr>
    <div class="control-group">
    <label class="control-label" for="s_tema">Site Temas�</label>
    <div class="controls">
        <select id="s_tema" name="s_tema" class="span4">
    <?php
	if ($handle = opendir('../_tema/')) {
    while (false !== ($entry = readdir($handle))) {
        if (strpos($entry,'.htaccess') !== 0 &&  strpos($entry,'.') == 0 && $entry != "." && $entry != "..") {
			$selected = '';
			if($site_tema==$entry) $selected = 'selected';
            echo "<option value=\"$entry\" $selected>$entry</option>";
        }
    }
    closedir($handle);
	}
	?>
	</select>
	  <i class="icon-info-sign tip" rel="popover" data-content="Sitenizin tema kayna��. ($site_tema) <br>Web sitenizin kullan�c�lara g�stermek istedi�iniz tema klas�r�n�n ad�. '_tema' kls�r� baz al�narak klas�r ismi girilmelidir" data-original-title="Site Tema" data-trigger="hover" data-html="true" style="margin-left:5px"></i>
    </div>
  </div>
  
      <div class="control-group">
    <label class="control-label" for="aduzen">Anasayfa D�zeni</label>
    <div class="controls">
        <select class="span4" name="aduzen" id="aduzen">
		<?php
		foreach($blok_ayar->gorunum_tipleri->children() as $key => $val) {
        echo '<option value="'.trKarakter($key).'"';
		$ge�erli_tip = $modul['blok_tip'];
		if($site_aduzen == trKarakter($key)) echo 'selected';
		echo '>'.trKarakter($val->aciklama).'</option>';;
		}
		?>
	  </select>
	  
	  <i class="icon-info-sign tip" rel="popover" data-content="Anasayfa D�zeni teman�z taraf�ndan belirlenmi� blok d�zenlerinden birisi olmal�d�r. Bu de�i�kene g�re �st men�deki Anasayfa D�zenine t�klayarak anasayfan�zdaki bloklar� d�zenleyebilirsiniz.." data-original-title="Anasayfa D�zeni" data-trigger="hover" data-html="true" style="margin-left:5px"></i>
    </div>
  </div>
  
  <div class="control-group">
    <label class="control-label" for="s_adres">Site Adresi</label>
    <div class="controls">
      <input type="text" class="span6" name="s_adres" id="s_adres" placeholder="Sitenizin Adresi" value="<?php echo $site_adres?>">
	  <i class="icon-info-sign tip" rel="popover" data-content="Sitenizin tam adresi. ($site_adres) <br>Web sitenizin adresidir.<hr>�rn. http://www.iyibu.org/<br>�rn. http://localhost/iyibu/" data-original-title="Site Adresi" data-trigger="hover" data-html="true"></i>
    </div>
  </div>
  
  <div class="control-group">
    <label class="control-label" for="s_mail">Site E-Posta Adresi</label>
    <div class="controls">
      <input type="text" class="span6" name="s_mail" id="s_mail" placeholder="Sitenizin Adresi" value="<?php echo $site_mail?>">
	  <i class="icon-info-sign tip" rel="popover" data-content="Sitenizin mail adresi. Junk klas�r�ne gitmemesi i�in alan ad�n�z �zerinden bir adres girin" data-original-title="Site E-Posta Adresi" data-trigger="hover" data-html="true"></i>
    </div>
  </div>
  
  <div class="control-group">
    <label class="control-label" for="s_baslik">Site Ba�l�k</label>
    <div class="controls">
      <input type="text" class="span6" name="s_baslik" id="s_baslik" placeholder="Sitenizin Ba�l���" value="<?php echo $site_baslik?>">
	  <i class="icon-info-sign tip" rel="popover" data-content="Sitenizin ba�l���. ($site_baslik) <br>Tema kaynaklar� bu de�i�keni <title> olarak kullanacakt�r. SEO i�in pek uzun olmamas�na dikkat etmelisiniz" data-original-title="Site Ba�l���" data-trigger="hover" data-html="true"></i>
    </div>
  </div>
  
    <div class="control-group">
    <label class="control-label" for="s_k_baslik">Site K�sa Ba�l�k</label>
    <div class="controls">
      <input type="text" class="span6" name="s_k_baslik" id="s_k_baslik" placeholder="Sitenizin Ba�l���" value="<?php echo $site_k_baslik?>">
	  <i class="icon-info-sign tip" rel="popover" data-content="Sitenizin k�sa ba�l���. Mail g�nderirken kullan�lacakt�r her ihtimale kar�� t�rk�e karakter kullanmay�n �rnek: iyibu!Portal" data-original-title="Site K�sa Ba�l���" data-trigger="hover" data-html="true"></i>
    </div>
  </div>
  
  <br>
  
  <div class="control-group">
    <label class="control-label" for="meta_k">Anahtar Kelimeler</label>
    <div class="controls">
      <input class="span8" type="text" name="meta_k" id="meta_k" placeholder="Sitenizi en iyi anlatan kelimeler" value="<?php echo $meta_keywords?>">
	  <i class="icon-info-sign tip" rel="popover" data-content="Anahtar kelimeler. ($meta_keywords) <br>Arama motorlar�n�n sitenizi daha iyi tan�mlayabilmek i�in teman�z bu de�i�keni bir <meta> olarak kullan�r" data-original-title="Anahtar Kelimeler" data-trigger="hover" data-html="true"></i>
    </div>
  </div>
  
  <div class="control-group">
    <label class="control-label" for="meta_d">Site A��klamas�</label>
    <div class="controls">
      <textarea class="span8" rows="5" type="text" name="meta_d" id="meta_d" placeholder="Sitenizi en iyi bi�imde tan�t�n"><?php echo $meta_desc?></textarea>
	  <i class="icon-info-sign tip" rel="popover" data-content="Site a��klamas�. ($meta_keywords) <br>Arama motorlar�n�n sitenizi daha iyi tan�mlayabilmek i�in teman�z bu de�i�keni bir <meta> olarak kullan�r" data-original-title="Site A��klamas�" data-trigger="hover" data-html="true"></i>
    </div>
  </div>
  
  <br>
  
  <div class="control-group">
    <label class="control-label" for="o_sure">Oturum S�resi</label>
    <div class="controls">
      <input class="span2" type="text" name="o_sure" id="o_sure" placeholder="Sitenizi en iyi anlatan kelimeler" value="<?php echo $oturum_tazele?>">
	  <i class="icon-info-sign tip" rel="popover" data-content="Oturum tazeleme s�resi (Saniye cinsinden) <br>Bu de�i�ken ile sitenizdeki aktif ziyaret�i ve �yeler veritaban�na belirtilen s�rede kaydedilir, g�ncellenir veya silinir. Saniye cinsinden yaz�n" data-original-title="Site A��klamas�" data-trigger="hover" data-html="true"></i>
    </div>
  </div>
  
  <div class="control-group">
    <label class="control-label" for="gzip">Gzip S�k��t�rma?</label>
    <div class="controls">
      <input class="span2 iyibuSwitch" type="checkbox" name="gzip" id="gzip" <?php if($site_gzip) echo 'checked';?>>
	  <i class="icon-info-sign tip" rel="popover" data-content="Sitede t�m php,html,js,css,png ve jpg dosyalar�nda Gzip aktif olsun mu? (�nerilir)" data-original-title="Gzip S�k��t�rma?" data-trigger="hover" data-html="true"></i>
    </div>
  </div>
  
  <div class="control-group">
    <label class="control-label" for="html">Html S�k��t�rma?</label>
    <div class="controls">
      <input class="span2 iyibuSwitch" type="checkbox" name="html" id="html" <?php if($site_html_s) echo 'checked';?>>
	  <i class="icon-info-sign tip" rel="popover" data-content="Sitede yans�t�lan HTML ��kt�s� s�k��t�r�ls�n m�? ��kt� tek sat�rda g�sterilecek gereksiz bo�luklar temizlenecek. (�nerilir)" data-original-title="Html S�k��t�rma?" data-trigger="hover" data-html="true"></i>
    </div>
  </div>
  
  <div class="control-group">
    <div class="controls">
      <button id="kaydet" type="submit" class="btn btn-success" disabled>T�m bilgileri kaydet/g�ncelle!</button>
	  <i class="icon-info-sign tip" rel="popover" data-content="T�m de�i�ikliklerin etkili olabilmesi i�in veritaban� do�rulamas� yapmal�s�n�z!" data-original-title="De�i�iklikleri Kaydet/G�ncelle!" data-trigger="hover" data-html="true"></i>
	  <span id="sonuc" class="help-inline"></span>
    </div>
  </div>
</form>
</div></div></div>
<style>
.kur {
height: 1030px;
width: 700px;
position: absolute;
left: 50%;
margin-top:-35px;
margin-left: -350px;
}
</style>
	<script>
	$('select').select2();
function ayarlari_kaydet(){
var gzip = $('#gzip').is(':checked');
var html = $('#html').is(':checked');
var onaylar = '&gzip='+gzip+'&html='+html;
$.ajax({
    url: "index.php?sayfa=bismillah",
    type: "POST",
    data: $('#site-ayarlari').serialize()+onaylar
	}).done(function( html ) {
	if(html == 'Ok'){
	$("html, body").animate({scrollTop:0},"slow");
	$('.kur').css('height','500px');
	$('#site-ayarlari').hide('slow',function(){
	$('#site-ayarlari').html('<h1>Kurulum ba�ar�yla tamamland�!</h1>Buradan sonra yapman�z gereken tek �ey websitenizin y�netim paneline gidip iste�inize uygun ayarlar� kurmak yeni mod�ller yaratmakt�r.<br><br><b><a href="../index.html">Anasayfaya Git</a> | <a href="../yonetim/">Y�netim Paneline Git</a></b><br><br>daha fazla bilgi i�in <b><a href="http://www.iyibu.org/Kullanim-Kilavuzu.html">kullan�m k�lavuzunu mutlaka okuyun</a></b><br><br>iyibu!Portal &copy; 2013<br>Turan Erg�n Tekeli').slideDown('slow');
	})
	}else{
	$('#sonuc').html(html);
	$('#kaydet').html('<i class="icon-repeat icon-white"></i> Ba�ar�s�z. Tekrar dene!').removeClass('btn-success').addClass('btn-danger');
	}
	});
	};
function vt_test(){
$("#m_host,#m_kadi,#m_sif,#m_db").parents(".control-group").removeClass('success error');
$('#vt_test').html('<img src="../yonetim/img/yukle.gif" alt="..."> Ba�lant� Test Ediliyor...');
var m_host = $('#m_host').val();
var m_kadi = $('#m_kadi').val();
var m_sif = $('#m_sif').val();
var m_db = $('#m_db').val();
$.ajax({
    url: "index.php?sayfa=vt",
    type: "POST",
    data: "m_host="+m_host+"&m_kadi="+m_kadi+"&m_sif="+m_sif+"&m_db="+m_db
}).done(function( html ) {
if(html == 'Ok'){
$('#vt_test').empty();
$("#m_host,#m_kadi,#m_sif,#m_db").parents(".control-group").addClass('success');
$("#m_host,#m_kadi,#m_sif,#m_db").attr('readonly','readonly');
$('#dogrula').html('<i class="icon-ok-sign icon-white"></i> Veritaban� ba�lant�s� ba�ar�l�!').attr('disabled','disabled');
$('#kaydet').removeAttr("disabled");
}
else if(html.indexOf("@") != -1){
$('#vt_test').empty();
$("#m_kadi,#m_sif").parents(".control-group").addClass('error');}
else if(html.indexOf(m_db) != -1){
$('#vt_test').empty();
$('#m_db').parents(".control-group").addClass('error');}
else {
$("#m_host").parents(".control-group").addClass('error');
$('#vt_test').html('<br>'+html);}
});}
$(function ()
{ $(".tip").tooltip('destroy');
$(".tip").popover();
});
iyibuSwitch();
</script>
</body>
</html>
<?php 
elseif($sayfa=='vt'):
@$mysqli_connection = new MySQLi($_POST['m_host'], $_POST['m_kadi'], $_POST['m_sif'], $_POST['m_db']);
if ($mysqli_connection->connect_error) {
   echo "Veritaban�na ba�lant�s� ba�ar�s�z!: " . $mysqli_connection->connect_error;
}
else {
   echo "Ok";
}
elseif($sayfa=='bismillah'):
$myFile = '../AYARLAR.php';
$fh = fopen($myFile, 'w') or die("can't open file");
$bug�n = TRg�nAy(date("d F Y, l")); 
$m_host = trKarakter($_POST['m_host']);
$m_kadi = trKarakter($_POST['m_kadi']);
$m_sif = trKarakter($_POST['m_sif']);
$m_db = trKarakter($_POST['m_db']);
$s_tema = trKarakter($_POST['s_tema']);
$s_baslik = trKarakter($_POST['s_baslik']);
$s_k_baslik = trKarakter($_POST['s_k_baslik']);
$s_adres = trKarakter($_POST['s_adres']);
$s_mail = trKarakter($_POST['s_mail']);
$aduzen = trKarakter($_POST['aduzen']);
$meta_k = trKarakter($_POST['meta_k']);
$meta_d = trKarakter($_POST['meta_d']);
$o_sure = trKarakter($_POST['o_sure']);
$gzip = $_POST['gzip'];
$html_s = $_POST['html'];
$�rnek = "<?php 
/* 	iyibu!Portal:PHP AYARLAR.php dosyas�
	Yaz�m Tarihi: 23 Temmmuz 2013
	Son De�i�tirilme 29 Temmuz 2013
	Y�netim-Paneli D�zenlenme $bug�n */

\$mysql_host		=	'$m_host';  
\$mysql_user		=	'$m_kadi';
\$mysql_pass		=	'$m_sif';
\$mysql_db		=	'$m_db';  

\$site_tema		=	'$s_tema';
\$site_aduzen		=	'$aduzen';
\$site_adres		=	'$s_adres';
\$site_mail		=	'$s_mail';
\$site_baslik	=	'$s_baslik';
\$site_k_baslik	=	'$s_k_baslik';

\$meta_keywords	=	'$meta_k';
\$meta_desc		=	'$meta_d';

\$oturum_tazele	=	$o_sure;
\$site_gzip			=	$gzip;
\$site_html_s		=	$html_s;
?>";
fwrite($fh, $�rnek);
fclose($fh);
require(__DIR__ . '/../baglanti.php');
$sql = file_get_contents('iyibu.sql');
$baglanti->multi_query($sql) or die(trigger_error(@$baglanti->error));
die('Ok');
endif;
?>