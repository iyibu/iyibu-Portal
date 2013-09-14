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
  AYARLAR.php dosyası yazılabilir değil! Değişiklikleri kaydedemeyeceksiniz!
</div>";}?>
<form id="site-ayarlari" method="POST" action="javascript:ayarlari_kaydet()" class="form-horizontal">
  <div class="control-group">
    <label class="control-label" for="m_host">Mysql Sunucu Adresi</label>
    <div class="controls">
      <input type="text" name="m_host" id="m_host" placeholder="örn. localhost" value="<?php echo $mysql_host?>">
	  <i class="icon-info-sign tip" rel="popover" data-content="Bu ayar Mysql'deki host değişkenini belirler. ($mysql_host) <br>Genelde localhost'tur. Ancak kimi hosting sağlayıcılarında Mysql farklı bir adreste bulunabilir. Kısaca Mysql'in bulunduğu sunucu adresidir diyebiliriz.<hr><br>Örn. 'localhost'<br>Örn. 'mysql.iyibu.org:8080" data-original-title="Mysql Host Ayarı :: Önemli Değişken" data-trigger="hover" data-html="true"></i>
    </div>
  </div>
  
  <div class="control-group">
    <label class="control-label" for="m_kadi">Mysql Kullanıcı Adı</label>
    <div class="controls">
      <input type="text" name="m_kadi" id="m_kadi" placeholder="örn. root" value="<?php echo $mysql_user?>">
	  <i class="icon-info-sign tip" rel="popover" data-content="Mysql kullanıcı adı. ($mysql_user) <br>Genelde  root'tur. Ancak kendi verdiğiniz bir isim de olabilir. <hr><br>Örn. 'root'<br>Örn. 'turan'" data-original-title="Mysql Kullanıcı Adı :: Önemli Değişken" data-trigger="hover" data-html="true"></i>
    </div>
  </div>
  
    <div class="control-group">
    <label class="control-label" for="m_sif">Mysql Şifresi</label>
    <div class="controls">
      <input type="password" name="m_sif" id="m_sif" placeholder="Eğer yoksa boş bırakın" value="<?php echo $mysql_pass?>">
	  <i class="icon-info-sign tip" rel="popover" data-content="Mysql şifreniz. ($mysql_pass) <br>Localhostlarda boş bir değer olabilir . Ancak genelde bunu hosting panelinizden belirlersiniz" data-original-title="Mysql Şifresi :: Önemli Değişken" data-trigger="hover" data-html="true"></i>
    </div>
  </div>
  
  <div class="control-group">
    <label class="control-label" for="m_db">Mysql Veritabanı</label>
    <div class="controls">
      <input type="text" name="m_db" id="m_db" placeholder="Veritabanı Adını Girin" value="<?php echo $mysql_db?>">
	  <i class="icon-info-sign tip" rel="popover" data-content="Mysql veritabanı adı. ($mysql_db) <br>Yeni oluşturduğunuz veya var olan veritabanı adı." data-original-title="Mysql Veritabanı :: Önemli Değişken" data-trigger="hover" data-html="true"></i>
	  <button id="dogrula" type="button" class="btn btn-success" onclick="vt_test()">Veritabanını Bilgilerini Doğrula!</button>
		<div id="vt_test"></div>
    </div>
  </div>
  <br>
  <hr>
    <div class="control-group">
    <label class="control-label" for="s_tema">Site Teması</label>
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
	  <i class="icon-info-sign tip" rel="popover" data-content="Sitenizin tema kaynağı. ($site_tema) <br>Web sitenizin kullanıcılara göstermek istediğiniz tema klasörünün adı. '_tema' klsörü baz alınarak klasör ismi girilmelidir" data-original-title="Site Tema" data-trigger="hover" data-html="true" style="margin-left:5px"></i>
    </div>
  </div>
  
      <div class="control-group">
    <label class="control-label" for="aduzen">Anasayfa Düzeni</label>
    <div class="controls">
        <select class="span4" name="aduzen" id="aduzen">
		<?php
		foreach($blok_ayar->gorunum_tipleri->children() as $key => $val) {
        echo '<option value="'.trKarakter($key).'"';
		$geçerli_tip = $modul['blok_tip'];
		if($site_aduzen == trKarakter($key)) echo 'selected';
		echo '>'.trKarakter($val->aciklama).'</option>';;
		}
		?>
	  </select>
	  
	  <i class="icon-info-sign tip" rel="popover" data-content="Anasayfa Düzeni temanız tarafından belirlenmiş blok düzenlerinden birisi olmalıdır. Bu değişkene göre üst menüdeki Anasayfa Düzenine tıklayarak anasayfanızdaki blokları düzenleyebilirsiniz.." data-original-title="Anasayfa Düzeni" data-trigger="hover" data-html="true" style="margin-left:5px"></i>
    </div>
  </div>
  
  <div class="control-group">
    <label class="control-label" for="s_adres">Site Adresi</label>
    <div class="controls">
      <input type="text" class="span6" name="s_adres" id="s_adres" placeholder="Sitenizin Adresi" value="<?php echo $site_adres?>">
	  <i class="icon-info-sign tip" rel="popover" data-content="Sitenizin tam adresi. ($site_adres) <br>Web sitenizin adresidir.<hr>örn. http://www.iyibu.org/<br>örn. http://localhost/iyibu/" data-original-title="Site Adresi" data-trigger="hover" data-html="true"></i>
    </div>
  </div>
  
  <div class="control-group">
    <label class="control-label" for="s_mail">Site E-Posta Adresi</label>
    <div class="controls">
      <input type="text" class="span6" name="s_mail" id="s_mail" placeholder="Sitenizin Adresi" value="<?php echo $site_mail?>">
	  <i class="icon-info-sign tip" rel="popover" data-content="Sitenizin mail adresi. Junk klasörüne gitmemesi için alan adınız üzerinden bir adres girin" data-original-title="Site E-Posta Adresi" data-trigger="hover" data-html="true"></i>
    </div>
  </div>
  
  <div class="control-group">
    <label class="control-label" for="s_baslik">Site Başlık</label>
    <div class="controls">
      <input type="text" class="span6" name="s_baslik" id="s_baslik" placeholder="Sitenizin Başlığı" value="<?php echo $site_baslik?>">
	  <i class="icon-info-sign tip" rel="popover" data-content="Sitenizin başlığı. ($site_baslik) <br>Tema kaynakları bu değişkeni <title> olarak kullanacaktır. SEO için pek uzun olmamasına dikkat etmelisiniz" data-original-title="Site Başlığı" data-trigger="hover" data-html="true"></i>
    </div>
  </div>
  
    <div class="control-group">
    <label class="control-label" for="s_k_baslik">Site Kısa Başlık</label>
    <div class="controls">
      <input type="text" class="span6" name="s_k_baslik" id="s_k_baslik" placeholder="Sitenizin Başlığı" value="<?php echo $site_k_baslik?>">
	  <i class="icon-info-sign tip" rel="popover" data-content="Sitenizin kısa başlığı. Mail gönderirken kullanılacaktır her ihtimale karşı türkçe karakter kullanmayın örnek: iyibu!Portal" data-original-title="Site Kısa Başlığı" data-trigger="hover" data-html="true"></i>
    </div>
  </div>
  
  <br>
  
  <div class="control-group">
    <label class="control-label" for="meta_k">Anahtar Kelimeler</label>
    <div class="controls">
      <input class="span8" type="text" name="meta_k" id="meta_k" placeholder="Sitenizi en iyi anlatan kelimeler" value="<?php echo $meta_keywords?>">
	  <i class="icon-info-sign tip" rel="popover" data-content="Anahtar kelimeler. ($meta_keywords) <br>Arama motorlarının sitenizi daha iyi tanımlayabilmek için temanız bu değişkeni bir <meta> olarak kullanır" data-original-title="Anahtar Kelimeler" data-trigger="hover" data-html="true"></i>
    </div>
  </div>
  
  <div class="control-group">
    <label class="control-label" for="meta_d">Site Açıklaması</label>
    <div class="controls">
      <textarea class="span8" rows="5" type="text" name="meta_d" id="meta_d" placeholder="Sitenizi en iyi biçimde tanıtın"><?php echo $meta_desc?></textarea>
	  <i class="icon-info-sign tip" rel="popover" data-content="Site açıklaması. ($meta_keywords) <br>Arama motorlarının sitenizi daha iyi tanımlayabilmek için temanız bu değişkeni bir <meta> olarak kullanır" data-original-title="Site Açıklaması" data-trigger="hover" data-html="true"></i>
    </div>
  </div>
  
  <br>
  
  <div class="control-group">
    <label class="control-label" for="o_sure">Oturum Süresi</label>
    <div class="controls">
      <input class="span2" type="text" name="o_sure" id="o_sure" placeholder="Sitenizi en iyi anlatan kelimeler" value="<?php echo $oturum_tazele?>">
	  <i class="icon-info-sign tip" rel="popover" data-content="Oturum tazeleme süresi (Saniye cinsinden) <br>Bu değişken ile sitenizdeki aktif ziyaretçi ve üyeler veritabanına belirtilen sürede kaydedilir, güncellenir veya silinir. Saniye cinsinden yazın" data-original-title="Site Açıklaması" data-trigger="hover" data-html="true"></i>
    </div>
  </div>
  
  <div class="control-group">
    <label class="control-label" for="gzip">Gzip Sıkıştırma?</label>
    <div class="controls">
      <input class="span2 iyibuSwitch" type="checkbox" name="gzip" id="gzip" <?php if($site_gzip) echo 'checked';?>>
	  <i class="icon-info-sign tip" rel="popover" data-content="Sitede tüm php,html,js,css,png ve jpg dosyalarında Gzip aktif olsun mu? (Önerilir)" data-original-title="Gzip Sıkıştırma?" data-trigger="hover" data-html="true"></i>
    </div>
  </div>
  
  <div class="control-group">
    <label class="control-label" for="html">Html Sıkıştırma?</label>
    <div class="controls">
      <input class="span2 iyibuSwitch" type="checkbox" name="html" id="html" <?php if($site_html_s) echo 'checked';?>>
	  <i class="icon-info-sign tip" rel="popover" data-content="Sitede yansıtılan HTML çıktısı sıkıştırılsın mı? Çıktı tek satırda gösterilecek gereksiz boşluklar temizlenecek. (Önerilir)" data-original-title="Html Sıkıştırma?" data-trigger="hover" data-html="true"></i>
    </div>
  </div>
  
  <div class="control-group">
    <div class="controls">
      <button id="kaydet" type="submit" class="btn btn-success" disabled>Tüm bilgileri kaydet/güncelle!</button>
	  <i class="icon-info-sign tip" rel="popover" data-content="Tüm değişikliklerin etkili olabilmesi için veritabanı doğrulaması yapmalısınız!" data-original-title="Değişiklikleri Kaydet/Güncelle!" data-trigger="hover" data-html="true"></i>
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
	$('#site-ayarlari').html('<h1>Kurulum başarıyla tamamlandı!</h1>Buradan sonra yapmanız gereken tek şey websitenizin yönetim paneline gidip isteğinize uygun ayarları kurmak yeni modüller yaratmaktır.<br><br><b><a href="../index.html">Anasayfaya Git</a> | <a href="../yonetim/">Yönetim Paneline Git</a></b><br><br>daha fazla bilgi için <b><a href="http://www.iyibu.org/Kullanim-Kilavuzu.html">kullanım kılavuzunu mutlaka okuyun</a></b><br><br>iyibu!Portal &copy; 2013<br>Turan Ergün Tekeli').slideDown('slow');
	})
	}else{
	$('#sonuc').html(html);
	$('#kaydet').html('<i class="icon-repeat icon-white"></i> Başarısız. Tekrar dene!').removeClass('btn-success').addClass('btn-danger');
	}
	});
	};
function vt_test(){
$("#m_host,#m_kadi,#m_sif,#m_db").parents(".control-group").removeClass('success error');
$('#vt_test').html('<img src="../yonetim/img/yukle.gif" alt="..."> Bağlantı Test Ediliyor...');
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
$('#dogrula').html('<i class="icon-ok-sign icon-white"></i> Veritabanı bağlantısı başarılı!').attr('disabled','disabled');
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
   echo "Veritabanına bağlantısı başarısız!: " . $mysqli_connection->connect_error;
}
else {
   echo "Ok";
}
elseif($sayfa=='bismillah'):
$myFile = '../AYARLAR.php';
$fh = fopen($myFile, 'w') or die("can't open file");
$bugün = TRgünAy(date("d F Y, l")); 
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
$örnek = "<?php 
/* 	iyibu!Portal:PHP AYARLAR.php dosyası
	Yazım Tarihi: 23 Temmmuz 2013
	Son Değiştirilme 29 Temmuz 2013
	Yönetim-Paneli Düzenlenme $bugün */

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
fwrite($fh, $örnek);
fclose($fh);
require(__DIR__ . '/../baglanti.php');
$sql = file_get_contents('iyibu.sql');
$baglanti->multi_query($sql) or die(trigger_error(@$baglanti->error));
die('Ok');
endif;
?>