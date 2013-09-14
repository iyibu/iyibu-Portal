<?php header('Content-Type: text/html; charset=iso-8859-9');
require(__DIR__ . '/../baglanti.php');
require(__DIR__ . '/../_inc/fonksiyonlar.php');
if($_SESSION['yonetici']==false&&yetkiVarmi('tema')){header('Location: giris.php');
die();};
$sayfa = @$_GET['sayfa'];
if($sayfa=='form'&&yetkiVarmi('t_ayr')):
$sorgu = $baglanti->query("SELECT isim,deger FROM ayarlar WHERE isim = 'tema_{$site_tema}' LIMIT 1");
$ayar = @$sorgu->fetch_assoc();
$ayar = @$ayar['deger'];
$ayar = @explode('|',$ayar);
?>
<div class="blok">
  <div class="blok-ust">Tema Ayarlarý :: <?php echo $site_tema?>  
  <button class="btn btn-success btn-mini pull-right" onclick="$('#sayfa').html('<div style=&quot;text-align:center&quot;><img src=&quot;img/yukle.gif&quot; alt=&quot;bekleyiniz...&quot;> Hazýrlanýyor...</div>').load('<?php echo basename($_SERVER['REQUEST_URI']);?>');"><i class="icon-refresh icon-white"></i></button></div>
  <div class="blok-icerik">
	    <div class="alert alert-info">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <h4>Bilgilendirme</h4>Burada yapacaðýnýz ayarlar temanýz <b>(<?php echo $site_tema?>)</b> tarafýndan belirlenmiþ olup, bu ayarlar sistem altyapýsýna deðil doðrudan tema deðiþkenlerine etki edecektir.
    </div>
    <form id="ayarlar-form" action="javascript:kaydet()" class="form-horizontal">
  <?php
  $adres = '../_tema/'.$site_tema.'/AYARLAR.xml';
  $blok = simplexml_load_file($adres);
  $ek_deger = explode('|',trim(trKarakter($blok->ek_deger)));
  $i=0;
  foreach($ek_deger as $b){
  $b = explode('->',$b);
  $name = $b[0];
  $aciklama = $b[1];
  $tip = $b[2];
  $form = $b[3];
  if($form=='input'){
	echo '<div class="control-group">
    <label class="control-label" for="'.$name.'">'.$aciklama.'</label>
    <div class="controls">
      <input type="text" class="span9" name="'.$name.'" id="'.$name.'" placeholder="'.$aciklama.'" value="'.@$ayar[$i].'">
	  <i class="icon-info-sign tip" title="'.$tip.'" data-placement="right"></i>
    </div>
  </div>';
  }else if($form=='textarea'){
  	echo '<div class="control-group">
    <label class="control-label" for="'.$name.'">'.$aciklama.'</label>
    <div class="controls">
      <textarea class="span9" name="'.$name.'" id="'.$name.'" placeholder="'.$aciklama.'">'.@$ayar[$i].'</textarea>
	  <i class="icon-info-sign tip" title="'.$tip.'" data-placement="right"></i>
    </div>
  </div>';
  }
  $i++;
  }
  ?>
  <div class="control-group">
    <div class="controls">
        <button id="kaydet" type="submit" class="btn btn-success"><i class="icon-ok icon-white tip"></i> Deðiþiklikleri Kaydet</button><br><br>
		<div id="sonuc"></div>
    </div>
  </div>
	</form>
	<script>$('i').tooltip();</script>
</div>
  </div>
<script>
function kaydet(){
$.ajax({
    url: "tema.php?sayfa=kaydet",
    type: "POST",
    data: $('#ayarlar-form').serialize()
	}).done(function( html ) {
	if(html == 'Ok'){
	$('#kaydet').removeClass('btn-danger').addClass('btn-success').html('<i class="icon-ok-sign icon-white"></i> Tüm deðiþiklikler kaydedildi!').attr('disabled','disabled');
	$('#sonuc').empty();
	}else{
	$('#sonuc').html(html);
	$('#kaydet').html('<i class="icon-repeat icon-white"></i> Baþarýsýz. Tekrar dene!').removeClass('btn-success').addClass('btn-danger');
	}
	});
	}
</script>
<?php elseif($sayfa == 'kaydet'&&yetkiVarmi('t_ayr')):
$baglanti->query("DELETE FROM ayarlar WHERE isim ='tema_{$site_tema}' LIMIT 1") or trigger_error(@$baglanti->error);
$baglanti->query("INSERT INTO ayarlar VALUES ('','tema_{$site_tema}','".$baglanti->real_escape_string(implode('|',$_POST))."')") or trigger_error(@$baglanti->error);
die('Ok');
endif?>