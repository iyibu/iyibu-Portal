<?php header('Content-Type: text/html; charset=iso-8859-9');
require(__DIR__ . '/../baglanti.php');
require(__DIR__ . '/../_inc/fonksiyonlar.php');
if($_SESSION['yonetici']==false&&yetkiVarmi('s_bynt')){header('Location: giris.php');
die();};
$alt_bölüm = @$_GET['alt'];
$blok_tip = @$_GET['blok_tip'];
if(empty($alt_bölüm)) $alt_bölüm = 'ana';
if(empty($blok_tip)) $blok_tip = $site_aduzen;
$adres = '../_tema/'.$site_tema.'/AYARLAR.xml';
$blok_tipi_al = simplexml_load_file($adres);
$yazdýr = trKarakter($blok_tipi_al->gorunum_tipleri->$blok_tip->gorunum);
function blokla($q){
$q = str_replace('clearfix;','<div class="clearfix" style="margin-top:10px">',$q);
$q = preg_replace("/sütun span(.*?);/", "<div class=\"span\$1 gorsel-blok well\">", $q);
$q = preg_replace_callback("/Listele\((.*?)\);/",
function($eþ){
return listele($eþ[1]);}, $q);
$q = str_replace('/div;','</div>',$q);
return $q;
}
function listele($q){
global $baglanti, $alt_bölüm;
$q = $baglanti->real_escape_string(trim($q));
$listele = '<ul id="listele-'.$q.'" class="listele unstyled" style="padding-top:5px">';
$manam = $_GET['modul'];
$sorgu = $baglanti->query("select bisim, id from modulblok where modul = '$manam' and yer = '$q' and alt = '$alt_bölüm' order by sira asc");
while($blok = $sorgu->fetch_assoc()){
	$listele .= '<li id="'.$q.'_'.$blok['id'].'" class="gorsel-alt">'.$blok['bisim'].' <i class="icon-trash pull-right" data-sil="'.$q.'_'.$blok['id'].'" data-id="'.$blok['id'].'"></i></li>';}
$listele .= '</ul><a class="btn btn-success ekle" data-blok="'.$q.'" style="margin-left:14%; margin-bottom:15px;"><i class="icon-plus icon-white"></i> Yeni Blok Ekle</a>';
  return $listele;
}
$sayfam = 'blok-listele.php?modul='.$_GET['modul'].'&blok_tip='.$blok_tip;
?>
<div class="blok">
  <div class="blok-ust" style="height:26px;">Bloklarý Düzenle
  <select id="alt-bolum" class="pull-right span3 select2">
  <option value="<?php echo $sayfam.'&alt=ana"'; if($alt_bölüm=='ana') echo 'selected';?>>Modül Anasayfasý</option>
  <option value="<?php echo $sayfam.'&alt=oku"'; if($alt_bölüm=='oku') echo 'selected';?>>Modül Ýçerik Sayfasý</option>
  <option value="<?php echo $sayfam.'&alt=kat"'; if($alt_bölüm=='kat') echo 'selected';?>>Modül Kategori Sayfasý</option></select></div>
  <div class="blok-icerik">
<?php echo blokla($yazdýr);?>
<div id="sonuc"></div>
<div id="ekle" style="display:none"></div>
</div>
</div>
  </div>
  <style>.placeholder{border: 2px dashed #CCCCCC; margin-bottom:10px; background: #FAFAFA; display: block;margin-left:auto;
margin-right:auto;}</style>
<script type="text/javascript">
$(".listele").sortable({
	placeholder: 'placeholder',
	start: function(e, ui){
        ui.placeholder.height(ui.item.height()+20);
		ui.placeholder.width(ui.item.width()+25);
		$('.menu li,.menu i').tooltip('hide');
    },
	items: "li:not(.ekle)",
	update : function () {
	var order = $(this).sortable('serialize');
		$.post('blok-veri.php?sayfa=blok-sirala', order, function(data) {
		$('#sonuc').html(data);
		});
	}
});

function popKapat(id){
$(".ekle[data-blok='"+id+"']").popover("hide");
}

function popKapat2(id){
$(id).popover("hide");
}

function silgitsin(silinecek,id){
$(silinecek).remove();
$('#sonuc').load('blok-veri.php?sayfa=blok-sil&id='+id);
}

$('#alt-bolum').change(function(){
var sayfa = $(this).val();
$('#sayfa').html('<div style="text-align:center"><img src="img/yukle.gif" alt="bekleyiniz..."> Hazýrlanýyor...</div>');
$('#sayfa').load(sayfa);
});
function blok_ekle(id){
var sonuncu = $('#listele-'+id+' li').size()+1;
$.post("blok-veri.php?sayfa=blok-kaydet", $('#blok-ekle-'+id).serialize()+"&alt=<?php echo $alt_bölüm?>&tema=<?php echo $site_tema?>&yer="+id+"&modul=<?php echo $_GET['modul']?>&sira="+sonuncu).done(function(data){
$('#sonuc').html(data);
popKapat(id);
});
}
$(".ekle").click(function(){
$('#ekle').load('blok-veri.php?sayfa=blok-ekle', function(data){
$('.ekle2').html(data);
});
var blok_tip = $(this).attr('data-blok');
var icerik = '<form id="blok-ekle-'+blok_tip+'"><div class="ekle2" style="min-height:50px;"></div><hr><a class="btn btn-info ekle" onclick="blok_ekle(\''+blok_tip+'\')"><i class="icon-plus icon-white"></i> Ekle</a> <a class="btn btn-danger ekle" onclick="popKapat(\''+blok_tip+'\')"><i class=\"icon-remove icon-white\"></i> Ýptal</a></form>';
$(this).popover({ 
title: 'Yeni Blok Ekle: '+blok_tip, content: icerik, html:true, placement: 'bottom' });
}).click();

$(".gorsel-alt i").click(function(){
var id = $(this).attr('data-id');
var silinecek = $(this).attr('data-sil');
var icerik = '<hr><a class="btn btn-danger" onclick="silgitsin(\'#'+silinecek+'\',\''+id+'\')"><i class="icon-ok icon-white"></i> Sil gitsin</a> <a class="btn ekle" onclick="popKapat2(\'#'+silinecek+' i\')"><i class="icon-remove"></i> Kalsýn</a>';
$(this).popover({ 
title: 'Bu bloðu kaldýr', content: 'Emin misiniz?'+icerik, html:true, placement: 'top' });
}).click();
</script>
<style>.popover{width:500px;}</style>