<?php header('Content-Type: text/html; charset=iso-8859-9');
require(__DIR__ . '/../baglanti.php');
require(__DIR__ . '/../_inc/fonksiyonlar.php');
if($_SESSION['yonetici']==false){header('Location: giris.php');
die();};
$sayfa = @$_GET['sayfa'];
$modul_seo = @$_GET['modul'];
$modul_seo = $baglanti->real_escape_string($modul_seo);
if($sayfa == "form"&&(yetkiVarmi('tum_modul')||yetkiVarmi('yeni_modul')||yetkiVarmi('m_'.$modul_seo))):
if(!empty($modul_seo)){
$modul = $baglanti->query('select id, baslik, aciklama, kelime, icon, ana_tip, oku_tip, kat_tip, blok_tip, gizlilik, seo from modul where seo = \''.$modul_seo.'\' limit 1');
if(empty($modul->num_rows)) die('Hata: Ýstenilen modul bulunamadý: '.$modul_seo);
$modul = $modul->fetch_assoc();
$disabled = 'disabled';
}else{
$yeni_modül = true;
}
?>
<div class="blok">
  <div class="blok-ust"><?php echo (@$yeni_modül) ? 'Yeni Modül Oluþtur' : 'Modül Düzenle =>'?> <b><?php echo @$modul['baslik']?></b>
  <button class="btn btn-success btn-mini pull-right" onclick="$('#sayfa').html('<div style=&quot;text-align:center&quot;><img src=&quot;img/yukle.gif&quot; alt=&quot;bekleyiniz...&quot;> Hazýrlanýyor...</div>').load('<?php echo basename($_SERVER['REQUEST_URI']);?>');"><i class="icon-refresh icon-white"></i></button>
  <?php if(!@$yeni_modül):?><button class="btn btn-danger btn-mini pull-right" onclick="modulSil()" style="margin-right:5px"><i class="icon-trash icon-white"></i> Bu modülü kaldýr</button><?php endif?>
    <?php if(!@$yeni_modül):?>
  <a href="<?php echo $site_adres.'/'.$_GET['modul'].'.html'?>" target="_blank"><div class="btn btn-info btn-mini pull-right" style="margin-right:5px;"><i class="icon-zoom-in icon-white"></i> Görüntüle</div></a>
  <?php endif?>
  <?php if(!@$yeni_modül):?>
  <button class="btn btn-primary btn-mini pull-right kategori-ekle kapali" style="margin-right:5px"><i class="icon-plus-sign icon-white"></i> Kategori Ekle/Düzenle</button>
  <?php endif?>
  <div id="islem" class="pull-right" style="margin-right:5px"></div></div>
  <div class="blok-icerik">
	<form id="modul-ayarlari" method="POST" action="javascript:modul_kaydet()" class="form-horizontal">
<?php if(!empty($modul_seo)):?>	
	<div class="control-group">
    <label class="control-label" for="seo">Modül Seo</label>
    <div class="controls">
      <input type="text" name="seo" id="seo" placeholder="Modül Seo" value="<?php echo @$modul['seo']?>" <?php echo @$disabled?>>
	  <i class="icon-info-sign tip" rel="popover" data-content="Modülün SEO adresi. Konu hakkýnda daha fazla bilgi edinmek için Arama Motorlarý Optimizasyonu'nu (SEO) araþtýrýn <hr> Bu deðiþken linklerde þöyle görünecektir:<br><?php echo '/<b>'.$modul['seo'].'</b>.html'?><br><?php echo '/<b>'.$modul['seo'].'</b>/Örnek-Seo-Kategori/'?><br><?php echo '/<b>'.$modul['seo'].'</b>/Örnek-Seo-Icerigi.html'?>" data-original-title="Modul Seo" data-trigger="hover" data-html="true"></i>
    </div>
    </div>
<?php else:?>
<input type="hidden" name="seo" id="seo" value="<?php echo @$modul['seo']?>">
<?php endif;?>
	
	<div class="control-group">
    <label class="control-label" for="baslik">Modül Baþlýk</label>
    <div class="controls">
      <input type="text" name="baslik" id="baslik" placeholder="Modül Baþlýk" value="<?php echo @$modul['baslik']?>">
	  <i class="icon-info-sign title" data-original-title="Modülün Baþlýðý. title Kýsmýnda ve üstmenüde de bu deðiþken gözükür"></i>
    </div>
    </div>
	
	<div class="control-group">
    <label class="control-label" for="aciklama">Modül Açýklamasý</label>
    <div class="controls">
      <textarea class="span6" name="aciklama" id="aciklama" rows="4" placeholder="Modül Açýklamasý"><?php echo @$modul['aciklama']?></textarea>
	  <i class="icon-info-sign title" data-original-title="Modülün açýklamasý. Baþta meta-description olmak üzere pek çok yerde temanýz bu deðiþkeni kullanýr"></i>
    </div>
    </div>
	
	<div class="control-group">
    <label class="control-label" for="kelime">Modül Kelime</label>
    <div class="controls">
      <input class="span10" type="text" name="kelime" id="kelime" placeholder="Modül Kelime" value="<?php echo @$modul['kelime']?>">
	  <i class="icon-info-sign title" data-original-title="Modülün Anahtar Kelimeleri (Keywords): <br> Baþta meta-keywords olmak üzere pek çok yerde temanýz bu deðiþkeni kullanýr" data-trigger="hover" data-html="true"></i>
    </div>
    </div>
	
	<div class="control-group">
    <label class="control-label" for="icon">Modül Simgesi</label>
    <div class="controls">
      <input class="span8" type="text" name="icon" id="icon" placeholder="Modül Simgesi" value="<?php echo @$modul['icon']?>">
	  <i class="icon-info-sign title" data-original-title="Baþta üst menü olmak üzere navigasyon vb. yerlerde temanýz kullanýr" data-trigger="hover" data-html="true"></i>
    </div>
    </div>
	
	<div class="control-group">
    <label class="control-label" for="ana_tip">Anasayfa Görünümü</label>
    <div class="controls">
      <select class="span5" name="ana_tip" id="ana_tip">
	  <?php 
	  $adres2 = '../_tema/'.$site_tema.'/AYARLAR.xml';
	  $m_tip = simplexml_load_file($adres2);
	  foreach ($m_tip->modul_tipleri->ana->tip as $tip){
	  echo '<option value="'.trKarakter($tip->degisken).'"';
	  $geçerli_tip = $modul['ana_tip'];
	  if($geçerli_tip == trKarakter($tip->degisken)) echo 'selected';
	  echo '>'.trKarakter($tip->aciklama).'</option>';}
	  ?>
	  </select>
	  <i class="icon-info-sign tip" rel="popover" data-content="Modülün anasayfa görünümü örneðin modül Haberler ise <br><b><?php echo rtrim($site_adres,'/')?>/Haberler.html</b><br> adresindeki görünüm þekli. Temanýza göre farklýlýk gösterebilir" data-original-title="Anasayfa Görünümü" data-trigger="hover" data-html="true"></i>
    </div>
    </div>
	
	<div class="control-group">
    <label class="control-label" for="oku_tip">Ýçerik Görünümü</label>
    <div class="controls">
      <select class="span5" name="oku_tip" id="oku_tip">
	  <?php 
	  foreach ($m_tip->modul_tipleri->oku->tip as $tip){
	  echo '<option value="'.trKarakter($tip->degisken).'"';
	  $geçerli_tip = $modul['oku_tip'];
	  if($geçerli_tip == trKarakter($tip->degisken)) echo 'selected';
	  echo '>'.trKarakter($tip->aciklama).'</option>';}
	  ?>
	  </select>
	  <i class="icon-info-sign tip" rel="popover" data-content="Modülün içerik görünümü örneðin modül Haberler ise ve içerik Deneme-Icerigi þeklinde seoya sahipse <br><b><?php echo rtrim($site_adres,'/')?>/Haberler/Deneme-Icerigi.html</b><br> adresindeki görünüm þekli. Temanýza göre farklýlýk gösterebilir" data-original-title="Ýçerik Görünümü" data-trigger="hover" data-html="true"></i>
    </div>
    </div>
	
	<div class="control-group">
    <label class="control-label" for="kat_tip">Kategori Görünümü</label>
    <div class="controls">
      <select class="span5" name="kat_tip" id="kat_tip">
	  <?php 
	  foreach ($m_tip->modul_tipleri->kategori->tip as $tip){
	  echo '<option value="'.trKarakter($tip->degisken).'"';
	  $geçerli_tip = $modul['kat_tip'];
	  if($geçerli_tip == trKarakter($tip->degisken)) echo 'selected';
	  echo '>'.trKarakter($tip->aciklama).'</option>';}
	  ?>
	  </select>
	  <i class="icon-info-sign tip" rel="popover" data-content="Modülün içerik görünümü örneðin modül Haberler ise ve içerik Deneme-Kategorisi þeklinde seoya sahipse <br><b><?php echo rtrim($site_adres,'/')?>/Haberler/Deneme-Kategorisi/</b><br> adresindeki görünüm þekli. Temanýza göre farklýlýk gösterebilir" data-original-title="Kategori Görünümü" data-trigger="hover" data-html="true"></i>
    </div>
    </div>
	
	<div class="control-group">
    <label class="control-label" for="blok_tip">Blok Görünümü</label>
    <div class="controls">
      <select class="span5" name="blok_tip" id="blok_tip">
	  	<?php 
		foreach($m_tip->gorunum_tipleri->children() as $key => $val) {
        echo '<option value="'.trKarakter($key).'"';
		$geçerli_tip = $modul['blok_tip'];
		if($geçerli_tip == trKarakter($key)) echo 'selected';
		echo '>'.trKarakter($val->aciklama).'</option>';;
		}
		?>
	  </select>
	  <i class="icon-info-sign tip" rel="popover" data-content="Modülün bloklarý nasýl görünecek? Temanýzýn blok yapýlandýrmasý varsa ve bunlar deðiþiklik gösteriyorsa buradan ayarlayabilirsiniz. Örneðin temanýz 3 Blok görünümü gibi bir deðer atanabilir. Temanýza göre farklýlýk gösterir" data-original-title="Modul Baþlýk" data-trigger="hover" data-html="true"></i>
    </div>
    </div>
	
	
	<div class="control-group">
    <label class="control-label" for="gizlilik">Gizlilik</label>
    <div class="controls">
    <input name="gizlilik" id="gizlilik" type="checkbox" class="iyibuSwitch" data-acik="Üyelere Özel" data-kapali="Herkes Görebilir" <?php if($modul['gizlilik']) echo 'checked';?>>
    </div>
    </div>

	<div class="control-group">
    <div class="controls">
	<input id="yeni" name="yeni" type="hidden" value="<?php echo (@$yeni_modül) ? 1 : 0?>">
      <button id="kaydet" type="submit" class="btn btn-success"><?php echo (@$yeni_modül) ? 'Yeni Modül OLUÞTUR!' : 'Tüm Bilgileri Kaydet/Güncelle!'?></button>
	  <span id="sonuc" class="help-inline"></span>
    </div>
  </div>
	    
	</form>
  </div>
  </div>
  <style>.popover{min-width:400px;}
  .kategoriler, .kategoriler li{list-style: none inside none; margin: 0;}</style>
   <script type="text/javascript">
	$('.kategori-ekle').popover({
	title: 'Kategori Düzenle: <?php echo @$modul['baslik']?><button class="btn btn-success btn-mini pull-right" onclick="kategoriForm(\'<?php echo @$modul['seo']?>\',\'\')" style="margin-top:-2px"><i class="icon-plus-sign icon-white"></i> Yeni Kategori Ekle</button>',
	content: '<div id="kategoriler"></div>',
	placement: 'bottom',
	html: true,
	width: '400px'
	});
	
	$('.kategori-ekle').click(function(){
	if($(this).hasClass('kapali')==true){
	kategoriJSON();
	$(this).removeClass('kapali');
	}else{
	$(this).addClass('kapali');
	}
	$("#kategoriler").parents('.popover').css('min-width','540px').css('margin-left','-120px').css('z-index','9');
	});
	
	function kategoriJSON(){
	$("#kategoriler").html('<div style="text-align:center"><img src="img/yukle.gif" alt="bekleyiniz..."> Hazýrlanýyor...</div>');
	$.getJSON("modul-islem.php?sayfa=json-kategori&modul=<?php echo @$modul['seo']?>",
      function(data){
	  var kategoriler = [];
	  kategoriler.push('<thead><th class="span1">#</th><th>Ýsim</th><th style="width: 83px">Ýþlem</th></thead><tbody>');
        $.each(data.kategoriler, function( i, alt_anahtar ){
          kategoriler.push("<tr id=\"k_"+alt_anahtar.id +"\"><td>"+alt_anahtar.no +"</td><td>"+alt_anahtar.isim +"</td><td>");
		  kategoriler.push('<button onclick="kategoriForm(\'<?php echo @$modul['seo']?>\',\''+alt_anahtar.id +'\')" type="button" class="btn btn-info btn-mini pull-left kategori-duzen" data-id="'+alt_anahtar.id +'" style="margin-right:5px">Düzenle</button>');
		  if(alt_anahtar.no!=1){
		  kategoriler.push('<button type="button" class="btn btn-danger btn-mini kategori-sil" data-id="'+alt_anahtar.id+'">Sil</button>');
		  }
		  kategoriler.push('</td></tr>');
        });
		kategoriler.push('</tbody>');
		$("#kategoriler").html('');
		  $('<table/>', {
		  'class': 'kategoriler table table-striped',
		  html: kategoriler.join('')}).appendTo('#kategoriler');
		  $("#kategoriler").append('<div id="k-islem"></div>');
	$('.kategori-sil').click(function(){
	var id = $(this).attr('data-id');
	$('#k-islem').load('modul-islem.php?sayfa=kategori-sil&id='+id, function(){
	$('#k_'+id).remove()})
	});
    });
	}
	function kategoriForm(m,id){
	bootbox.dialog("<div id=\"kategori-form-div\"></div>", [{
	"label": "Ýptal"
	},
	{
	"label": "Kaydet",
	"class" : "btn-success",
	"callback": function() {
	kategoriKaydet();
	kategoriJSON();
	}
	}]);
	$("#kategori-form-div").html('<div style="text-align:center"><img src="img/yukle.gif" alt="bekleyiniz..."> Hazýrlanýyor...</div>');
	$('#kategori-form-div').load('modul-icerik.php?sayfa=kategori-form&modul='+m+'&id='+id)
	$('.modal-backdrop').click(function(){
	bootbox.hideAll();
	});
	}
	
	function kategoriKaydet(){
	$.post("modul-islem.php?sayfa=kategori-ekle", $("#kategori-form").serialize()).done(function(data){console.log('Alýnan cevap: " '+data+' "');});
	}
	
	function modulSil(){
	bootbox.confirm("<h3>Silmek istediðinize emin misiniz?</h3><hr>Bu modüle ait bütün içerikler, ayarlar, kategori ve diðer dokümanlar yok edilecektir..<br>Bu iþlem geri <b>alýnamaz</b>","Ýptal","Modülü herþeyiyle kaldýr", function(result) {
		if(result == true){
		$('#islem').load('modul-islem.php?sayfa=modul-kaldir&modul=<?php echo @$_GET['modul']?>', function(){
		setTimeout("location.reload(true);",2000);});};
	}); 
	$('.bootbox').css({'margin-top': function () {return 100}});
	
	$('.modal-backdrop').click(function(){
	bootbox.hideAll();
	});
	}
	
iyibuSwitch();
function modul_kaydet(){
var gizlilik = $('#gizlilik').is(':checked');
if(gizlilik==true){
gizlilik = 1;
}else{
gizlilik = 0;}
var onaylar = '&gizlilik='+gizlilik+'&seo=<?php echo $modul_seo?>';
$.ajax({
    url: "modul-islem.php?sayfa=kaydet",
    type: "POST",
    data: $('#modul-ayarlari').serialize()+onaylar
	}).done(function( html ) {
	if(html == 'Ok'){
	$('#kaydet').removeClass('btn-danger').addClass('btn-success').html('<i class="icon-ok-sign icon-white"></i> Tüm deðiþiklikler kaydedildi! Sayfa yenileniyor...').attr('disabled','disabled');
	setTimeout(location.reload(),1500);
	$('#sonuc').empty();
	}else{
	$('#sonuc').html(html);
	$('#kaydet').html('<i class="icon-repeat icon-white"></i> Baþarýsýz. Tekrar dene!').removeClass('btn-success').addClass('btn-danger');
	}
	});
	};
$("select").select2();
$(".title").tooltip();
$(".tip").popover();
</script>
<?php endif;?>