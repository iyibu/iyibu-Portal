<?php 
header('Content-Type: text/html; charset=iso-8859-9');
$sayfa = @$_GET['sayfa'];
require(__DIR__ . '/../_inc/fonksiyonlar.php');
require(__DIR__ . '/../baglanti.php');
if($_SESSION['yonetici']==false){header('Location: giris.php');
die();};
if($sayfa == "ayarlar"&&yetkiVarmi('s_ayr')):
$adres2 = '../_tema/'.$site_tema.'/AYARLAR.xml';
$blok_ayar = simplexml_load_file($adres2);
?>
<div class="blok">
  <div class="blok-ust">Site Ayarlar�
  
  <button class="btn btn-success btn-mini pull-right" onclick="$('#sayfa').html('<div style=&quot;text-align:center&quot;><img src=&quot;img/yukle.gif&quot; alt=&quot;bekleyiniz...&quot;> Haz�rlan�yor...</div>').load('<?php echo basename($_SERVER['REQUEST_URI']);?>');"><i class="icon-refresh icon-white"></i></button></div>
  <div class="blok-icerik">
  
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
<style>.popover{max-width:350px;}</style>
	<script>
	$('select').select2();
function ayarlari_kaydet(){
var gzip = $('#gzip').is(':checked');
var html = $('#html').is(':checked');
var onaylar = '&gzip='+gzip+'&html='+html;
$.ajax({
    url: "site_genel.php?sayfa=ayarlar-kaydet",
    type: "POST",
    data: $('#site-ayarlari').serialize()+onaylar
	}).done(function( html ) {
	if(html == 'Ok'){
	$('#kaydet').removeClass('btn-danger').addClass('btn-success').html('<i class="icon-ok-sign icon-white"></i> T�m de�i�iklikler kaydedildi!').attr('disabled','disabled');
	$('#menu').load('ustmenu.php?q=site-genel');
	$('#sonuc').empty();
	}else{
	$('#sonuc').html(html);
	$('#kaydet').html('<i class="icon-repeat icon-white"></i> Ba�ar�s�z. Tekrar dene!').removeClass('btn-success').addClass('btn-danger');
	}
	});
	};
function vt_test(){
$("#m_host,#m_kadi,#m_sif,#m_db").parents(".control-group").removeClass('success error');
$('#vt_test').html('<img src="img/yukle.gif" alt="bekleyiniz..."> Ba�lant� Test Ediliyor...');
var m_host = $('#m_host').val();
var m_kadi = $('#m_kadi').val();
var m_sif = $('#m_sif').val();
var m_db = $('#m_db').val();
$.ajax({
    url: "site_genel.php?sayfa=ayarlarvt",
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
{ $(".tip").popover();
vt_test();
});
iyibuSwitch();
</script>
</div>
  </div>
<?php 
elseif($sayfa == "ayarlar-kaydet"&&yetkiVarmi('s_ayr')):
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
echo 'Ok';
elseif($sayfa == "ayarlarvt"&&yetkiVarmi('s_ayr')):
@$mysqli_connection = new MySQLi($_POST['m_host'], $_POST['m_kadi'], $_POST['m_sif'], $_POST['m_db']);
if ($mysqli_connection->connect_error) {
   echo "Veritaban�na ba�lant�s� ba�ar�s�z!: " . $mysqli_connection->connect_error;
}
else {
   echo "Ok";
}
elseif($sayfa == "sistem"&&yetkiVarmi('s_blg')):
?>
<div class="blok">
  <div class="blok-ust">Sistem Bilgisi
  
  <button class="btn btn-success btn-mini pull-right" onclick="$('#sayfa').html('<div style=&quot;text-align:center&quot;><img src=&quot;img/yukle.gif&quot; alt=&quot;bekleyiniz...&quot;> Haz�rlan�yor...</div>').load('<?php echo basename($_SERVER['REQUEST_URI']);?>');"><i class="icon-refresh icon-white"></i></button></div>
  <div class="blok-icerik">
    <div class="tabbable span12 tabs-left">
		<ul class="nav nav-tabs" style="height:800px">
		<li class="active"><a data-toggle="tab" data-id="iyibuinfo">iyibu!Portal Bilgisi</a></li>
		<li><a data-toggle="tab" data-id="phpinfo">PHP Bilgisi</a></li>
	</ul>
	<div class="tab-content">
	<div id="phpinfo" class="tab-pane"><?php phpinfo(INFO_GENERAL)?><?php phpinfo(INFO_CONFIGURATION)?></div>
	<div id="iyibuinfo" class="tab-pane active">
	<table class="table table-striped">
	<tr>
	<td><h1>iyibu!Portal:PHP v1.0</h1></td>
	<td class="span1"><img src="img/logo.png"></td>
	</tr>
	</table>
	<table class="table table-striped">
	<tr>
	<td class="span3">S�r�m Bilgisi</td>
	<td>*Beta v1.0 (�lk S�r�m)</td>
	</tr>
	<tr>
	<td class="span3">PHP Versiyonu</td>
	<td><?php echo (version_compare(PHP_VERSION, '5.3.0', '>')) ? '<span class="label label-success">Kar��l�yor</span>' : '<span class="label label-important">Kar��lam�yor</span>';?> (<?php echo PHP_VERSION?>)</td>
	</tr>
	<tr>
	<td class="span3">MYSQL(i)</td>
	<td>Ba�lant�: <?php echo $baglanti->host_info?> | S�r�m <?php echo $baglanti->client_version?></td>
	</tr>
	<tr>
	<td class="span3">Kurulu Temalar</td>
	<td><?php
	if ($handle = opendir('../_tema/')) {
    while (false !== ($entry = readdir($handle))) {
	if (strpos($entry,'.htaccess') !== 0 &&  strpos($entry,'.') == 0 && $entry != "." && $entry != "..") {
            $temalar[] = $entry;
        }
    }
	echo implode(',',$temalar);
    closedir($handle);
	}?></td>
	</tr>
	<tr>
	<td class="span3">Varsay�lan Tema</td>
	<td><?php echo $site_tema?></td>
	</tr>
	<tr>
	<td class="span3">Kullan�labilir Bloklar</td>
	<td><?php
	if ($handle = opendir('../_tema/'.$site_tema.'/bloklar/')) {
    while (false !== ($entry = readdir($handle))) {
	if (strpos($entry,'.') !== 0 && $entry != "." && $entry != "..") {
			$izin = (is_writable('../_tema/'.$site_tema.'/bloklar/'.$entry)) ? '<span class="label label-success"><i class="icon-ok icon-white"></i></span>' : '<span class="label label-important"><i class="icon-remove icon-white"></i></span>';
            $bloklar[] = $izin.' '.$entry;
        }
    }
	echo implode(',<br>',$bloklar);
    closedir($handle);
	}?></td>
	</tr>
	<tr>
	<td class="span3">AYARLAR.php</td>
	<td><?php echo (is_writable('../AYARLAR.php')) ? '<span class="label label-success">Yaz�labilir</span>' : '<span class="label label-important">Yaz�lamaz</span>';?></td>
	</tr>
	<tr>
	<td class="span3">Bloklar</td>
	<td><?php echo (is_writable('../_tema/'.$site_tema.'/bloklar/')) ? '<span class="label label-success">Yaz�labilir</span>' : '<span class="label label-important">Yaz�lamaz</span>';?> (Blok olu�turup silebilmek i�in)</td>
	</tr>
	</table>
	<div class="pull-right">Turan Erg�n Tekeli &copy; 2013 </div><br><div class="pull-right"><i style="font-size:10px">�nsanlar�n en hay�rl�s� insanlara en faydal� oland�r Hz. Muhammed (s.a.v)</i></div></div>
  <script>$('#phpinfo style').remove();
  	var yukseklik = $('.tab-content').css('height');
	$('#sayfa .blok-icerik,.nav-tabs').css('min-height','500px').css('height',yukseklik);
	$('#phpinfo table').addClass('table table-striped');
	$('#phpinfo .h td a,#phpinfo .v td a').addClass('pull-right');
	$('.nav-tabs').css('cursor','default').css('user-select','none');
	$('.nav-tabs li a').click(function(){
	var id = $(this).attr('data-id');
	$('.tab-content div').removeClass('active');
	$('#'+id).addClass('active');
	var yukseklik = $('.tab-content').css('height');
	$('#sayfa .blok-icerik,.nav-tabs').css('min-height','500px').css('height',yukseklik);
	});</script></div>
  </div>
	</div><!-- /.tab-content -->
</div>


<?php elseif($sayfa == "blok-yonetimi"&&yetkiVarmi('s_bynt')):?>
<div class="blok">
  <div class="blok-ust">Blok Y�netimi
  
  <button class="btn btn-success btn-mini pull-right" onclick="$('#sayfa').html('<div style=&quot;text-align:center&quot;><img src=&quot;img/yukle.gif&quot; alt=&quot;bekleyiniz...&quot;> Haz�rlan�yor...</div>').load('<?php echo basename($_SERVER['REQUEST_URI']);?>');"><i class="icon-refresh icon-white"></i></button></div>
  <div class="blok-icerik" style="height:850px">
  <div class="span3" style="width:240px">
  <select id="blok-tema-sec" class="span12" placeholder="L�tfen bir tema se�in">
  <option></option>
    <?php
if ($handle = opendir('../_tema/')) {
    while (false !== ($entry = readdir($handle))) {
        if (strpos($entry,'.htaccess') !== 0 &&  strpos($entry,'.') == 0 && $entry != "." && $entry != "..") {
            echo "<option value=\"$entry\">$entry</option>";
        }
    }
    closedir($handle);
}
?>
</select>
   <div id="blok-listele">Buradan ba�lay�n</div>
</div>
   <div id="blok-duzenle" class="span8"><h1 style="margin-top:170px">Blok Y�netimi</h1> Yan taraftaki a��l�r kutudan teman�z� se�erek bloklar�n�z� d�zenlemeye ba�layabilirsiniz. "Blok" tabiri nedir ne de�ildir detayl� bilgi i�in l�tfen <a href="http://www.iyibu.org">iyibu.org<img src="img/link_arrow.png" style="margin-top:-5px; margin-left:-5px;"></a> adresini ziyaret edin..</div>
&nbsp;
</div>
  </div>
  <style>.popover{min-width:300px;}</style>
<script>$('select').select2();
function blok_duzenle(adres,tema){
$('#blok-duzenle').html('<img src="img/yukle.gif" alt="bekleyiniz..."> Haz�rlan�yor...');
$('#blok-duzenle').load('site_genel.php?sayfa=blok-duzenle&adres='+adres+'&tema='+tema);
}
function blok_sil(adres,tema){
$('#blok-duzenle').html('<img src="img/yukle.gif" alt="bekleyiniz..."> Haz�rlan�yor...');
$('#blok-duzenle').load('site_genel.php?sayfa=blok-sil&adres='+adres+'&tema='+tema);
}
function blok_liste_yenile(){
var tema = $('#blok-tema-sec').val();
$('#blok-listele').html('<img src="img/yukle.gif" alt="bekleyiniz..."> Haz�rlan�yor...');
$('#blok-listele').load('site_genel.php?sayfa=blok-listele&tema='+tema);
}
$('#blok-tema-sec').change(function() {
var tema = $('#blok-tema-sec').val();
$('#blok-listele').html('<img src="img/yukle.gif" alt="bekleyiniz..."> Haz�rlan�yor...');
$('#blok-listele').load('site_genel.php?sayfa=blok-listele&tema='+tema);
});
function blok_kaydet(){
$.ajax({
    url: "site_genel.php?sayfa=blok-kaydet",
    type: "POST",
    data: $('#blok_guncelle').serialize()
	}).done(function( html ) {
	if(html == 'Ok'){
	$('#kaydet').removeClass('btn-danger').addClass('btn-success').html('<i class="icon-ok-sign icon-white"></i> T�m de�i�iklikler kaydedildi!').attr('disabled','disabled');
	$('#sonuc').empty();
	setTimeout(function(){$('#kaydet').html('G�ncelle/Kaydet!').removeAttr('disabled');},2000)
	var tema = $('#tema').val();
	$('#blok-listele').html('<img src="img/yukle.gif" alt="bekleyiniz..."> Haz�rlan�yor...');
	$('#blok-listele').load('site_genel.php?sayfa=blok-listele&tema='+tema);
	}else{
	$('#sonuc').html(html);
	$('#kaydet').html('<i class="icon-repeat icon-white"></i> Ba�ar�s�z. Tekrar dene!').removeClass('btn-success').addClass('btn-danger');
	}
	});
	};
</script>
<?php elseif($sayfa == "blok-listele"&&yetkiVarmi('s_bynt')):?>
<ul class="well unstyled" style="margin-top:35px; position:relative">
<a href="javascript:void(0)" onclick="blok_liste_yenile()"><i class="icon-repeat title" style="position:absolute;top:0;left:0;" title="Yenile!" data-placement="right"></i></a>
<?php
$blok_tema = $_GET['tema'];
if ($handle = opendir('../_tema/'.$blok_tema.'/bloklar')) {
    while (false !== ($entry = readdir($handle))) {
        if (strpos($entry,'.xml')) {
			$adres = '../_tema/'.$site_tema.'/bloklar/'.$entry;
			$blok = simplexml_load_file($adres);
			$aciklama = trkarakter($blok->aciklama);
			$baslik = trkarakter($blok->baslik);
			$tip = trkarakter($blok->tip);
			if(empty($aciklama)) $aciklama = 'A��klama Bulunmuyor';
            echo "<li id=\"$entry\"><a href=\"javascript:void(0)\" onclick=\"blok_duzenle('$adres','$blok_tema')\">$entry </a>";
			if($blok->ozel == 'ozel') echo "<a href=\"javascript:void(0)\" onclick=\"blok_sil('$adres','$blok_tema')\">".'<i class="icon-trash pull-right title" title="Kald�r" data-placement="right"></i></a>';
			echo "<i class=\"icon-info-sign tip pull-right\" rel=\"popover\" data-content=\"$aciklama<hr>Blok tipi: $tip\" data-original-title=\"$baslik\" data-trigger=\"hover\" data-html=\"true\"></i></li>";
        }
    }
    closedir($handle);
}
?>
<hr>
  <li><i class="icon-plus-sign"></i> <a href="javascript:void(0)" onclick="blok_duzenle('yeni','<?php echo $blok_tema?>')">Yeni Blok Olu�tur</a></li>
</ul>
<script>$(".tip").popover();
$('.title').tooltip();</script>
<?php elseif($sayfa == "blok-duzenle"&&yetkiVarmi('s_bynt')):
$adres = @$_GET['adres'];
if(!empty($adres)):
if (!($adres == 'yeni')) {
$blok = simplexml_load_file($adres);
if (!is_writable($adres)) {
echo "<div class=\"alert alert-danger\">
  <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
  <h4>Bir sorun var gibi!</h4>
  Dosya yaz�labilir de�il! De�i�iklikleri kaydedemeyeceksiniz!
</div>";}
}
$blok_tema = $_GET['tema'];
$adres2 = '../_tema/'.$blok_tema.'/AYARLAR.xml';
$blok_ayar = simplexml_load_file($adres2);?>
<br>
<div>
<form id="blok_guncelle" method="POST" action="javascript:blok_kaydet()" class="form-horizontal">
<?php if (($adres == 'yeni')):?>
<div class="control-group">
    <label class="control-label" for="b_bisim">Benzersiz �sim</label>
    <div class="controls">
      <div class="input-append">
  <input id="b_bisim" name="b_bisim" class="span9" id="appendedInput" type="text">
  <span class="add-on">.xml</span>
</div>
	  <i class="icon-info-sign title" title="Olu�turulan blo�un benzersiz ismi. Ge�ersiz karakter olmamal�!" data-placement="right"></i>
    </div>
  </div>
  <?php endif;?>
  <div class="control-group">
    <label class="control-label" for="b_baslik">Blok Ba�l�k</label>
    <div class="controls">
      <input type="text" name="b_baslik" id="b_baslik"  value="<?php echo @trKarakter($blok->baslik)?>">
	  <i class="icon-info-sign title" title="Blo�un Ba�l���" data-placement="right"></i>
    </div>
  </div>
  
    <div class="control-group">
    <label class="control-label" for="b_aciklama">A��klama</label>
    <div class="controls">
      <textarea type="text" rows="3" name="b_aciklama" id="b_aciklama"><?php echo @trKarakter($blok->aciklama)?></textarea>
	  <i class="icon-info-sign title" title="Blo�un A��klamas�" data-placement="right"></i>
    </div>
  </div>
  
  <div class="control-group">
    <label class="control-label" for="b_tip">Blok Tipi</label>
    <div class="controls">
      <select class="span5" name="b_tip" id="b_tip">
	  <?php foreach ($blok_ayar->blok_tipleri->tip as $blok_tip){
	  $ge�erli_tip = @trKarakter($blok->tip);
	  echo '<option value="'.trKarakter($blok_tip->degisken).'"';
	  if($ge�erli_tip == trKarakter($blok_tip->degisken)) echo 'selected';
	  echo '>'.trKarakter($blok_tip->aciklama).'</option>';}?>
	  </select>
	  <i class="icon-info-sign title" title="Blok tipi teman�z taraf�ndan belirlenen tiplerdir" data-placement="right" style="margin-left:5px"></i>
    </div>
  </div>
  <hr>
  <div class="control-group">
    <div class="controls" style="margin-left:40px">
      <textarea class="span10 iyibuEditor" type="text" rows="10" name="b_kod" id="b_kod"><?php echo @trKarakter(htmlspecialchars($blok->kod,ENT_QUOTES|ENT_IGNORE))?></textarea>
	  <i class="icon-info-sign title" title="HTML ve iyibu!Kodlar�n� kullanabilirsiniz" data-placement="right"></i>
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="ek_deger">Ek De�er</label>
    <div class="controls">
      <input class="span10" type="text" name="ek_deger" id="ek_deger"  value="<?php echo @trKarakter($blok->ek_deger)?>">
	  <i class="icon-info-sign title" title="Geni�letilebilir bloklar i�in ekde�er" data-placement="right"></i>
    </div>
  </div>
  
  <div class="control-group">
    <div class="controls">
	<input type="hidden" name="b_adres" id="adres" value="<?php echo $adres?>">
	<input type="hidden" name="b_tema" id="tema" value="<?php echo $blok_tema?>">
	<input type="hidden" name="b_ozel" id="ozel" value="<?php echo @$blok->ozel?>">
      <button id="kaydet" type="submit" class="btn btn-success">G�ncelle/Kaydet!</button>
	  <span id="sonuc" class="help-inline"></span>
    </div>
  </div>
  </form></div>
    <style>.popover{width:200px;} .form-horizontal .control-label{width:100px;} .form-horizontal .controls{margin-left:120px}</style>
<script>$('select').select2();
$(".title").tooltip();
function duzenle(adres){
$('#blok-duzenle').load('site_genel.php?sayfa=blok-duzenle');
}
editor('.iyibuEditor')</script>
<?php else:
echo "<p class=\"text-error\">Bir sorun olu�tu olsa gerek.</p>";
endif;?>
<?php elseif($sayfa == "blok-kaydet"&&yetkiVarmi('s_bynt')):
$myFile = trKarakter($_POST['b_adres']);
$b_bisim = @$_POST['b_bisim'];
$e�le�me = preg_match('/^[a-z][a-z0-9]*(?:_[a-z0-9]+)*$/',$b_bisim);
if($myFile == 'yeni' && empty($e�le�me)) die('Ge�ersiz benzersiz isim!');
if($myFile == 'yeni') {
$myFile = '../_tema/'.$_POST['b_tema'].'/bloklar/'.$_POST['b_bisim'].'.xml';
if(file_exists($myFile)) die('B�yle bir blok zaten var!');
}
$fh = fopen($myFile, 'w') or die("can't open file");
$bug�n = TRg�nAy(date("d F Y, l")); 
$b_baslik = trKarakter($_POST['b_baslik']);
$b_aciklama = trKarakter($_POST['b_aciklama']);
$b_tip = trKarakter($_POST['b_tip']);
function bKod($q){
$q = preg_replace_callback(
    '@\#(.*?)\#@',
    function ($m){
	$sonhal = str_replace('=&gt;','=>',$m[1]);
	return "#".$sonhal."#";
	},
    $q);
	return $q;
}
$b_kod = trKarakter(bKod($_POST['b_kod']));
$b_kod = str_replace('<![CDATA[','',$b_kod);
$b_kod = str_replace(']]>','',$b_kod);
$b_ozel = trKarakter($_POST['b_ozel']);
$ek_deger = trKarakter($_POST['ek_deger']);
if(empty($b_ozel)) $b_ozel = 'ozel';
if(empty($b_baslik) || empty($b_tip) || empty($b_kod) || empty($myFile)) die('Eksik alanlar var gibi');
$�rnek = "<?xml version=\"1.0\" encoding=\"ISO-8859-9\"?>
<blok>
<baslik>$b_baslik</baslik>
<aciklama>$b_aciklama</aciklama>
<tip>$b_tip</tip>
<ozel>$b_ozel</ozel>
<kod><![CDATA[$b_kod]]></kod>
<ek_deger>
$ek_deger
</ek_deger>
</blok>
";
fwrite($fh, $�rnek);
fclose($fh);
echo 'Ok';?>
<?php elseif($sayfa == "blok-sil"&&yetkiVarmi('s_bynt')):
$myFile = trKarakter($_GET['adres']);
$tema	= $_GET['tema'];
if(!file_exists($myFile)) die("<div class=\"alert alert-danger\">
  <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
  <h4>�stenilen blok bulunamad�!</h4>$myFile
</div>");
if(!is_writable($myFile)) die("<div class=\"alert alert-danger\">
  <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
  <h4>Bu blok yaz�labilir de�il!</h4>$myFile
</div>");
unlink($myFile);
echo "<div class=\"alert alert-success\">
  <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
  <h4>Blok ba�ar�yla silindi!</h4>$myFile
</div><script>$('#blok-listele').load('site_genel.php?sayfa=blok-listele&tema=$tema');</script>";
endif;?>