<?php header('Content-Type: text/html; charset=iso-8859-9');
require(__DIR__ . '/../_inc/fonksiyonlar.php');
require(__DIR__ . '/../baglanti.php');
if($_SESSION['yonetici']==false){header('Location: giris.php');
die();};
$sayfa = @$_GET['sayfa'];
if($sayfa == "form"&&(yetkiVarmi('tum_modul')||yetkiVarmi('m_'.$modul_seo))):
$yenimi = 1;
$seo = @$_GET['seo'];
if(!empty($seo)){
$sorgula = $baglanti->query("SELECT baslik, resim, etiket, icerik, seo, kod,kategori FROM modulicerik where seo = '$seo' LIMIT 1");
$yenimi = 0;
if(empty($sorgula->num_rows)) die('B�yle bir i�erik bulunamad� :(');
$i�erik = $sorgula->fetch_assoc();
}
?>
<div class="blok">
  <div class="blok-ust">Yeni ��erik Ekle: <?php echo @$_GET['modul'];?>
<button class="btn btn-success btn-mini pull-right" onclick="$('#sayfa').html('<div style=&quot;text-align:center&quot;><img src=&quot;img/yukle.gif&quot; alt=&quot;bekleyiniz...&quot;> Haz�rlan�yor...</div>').load('<?php echo basename($_SERVER['REQUEST_URI']);?>');"><i class="icon-refresh icon-white"></i></button></div>  <div class="blok-icerik">
  <form id="icerik-form" action="javascript:icerik_kaydet(1)" class="form-horizontal">
  <div class="control-group">
    <label class="control-label" for="baslik">Ba�l�k</label>
    <div class="controls">
      <input type="text" class="span9" name="baslik" id="baslik" placeholder="Ba�l�k" value="<?php echo @$i�erik['baslik']?>">
	  <i class="icon-info-sign tip" title="��eri�in ba�l���" data-placement="right"></i>
	  <br><span id="seo" style="font-size:8pt"></span>
	  <?php if(!$yenimi) echo '<span style="font-size:8pt">'.$site_adres.'/'.$_GET['modul'].'/<b>'.$i�erik['seo'].'</b>.html (*De�i�meyecek)</span>'?>
    </div>
  </div>
  
  <div class="control-group">
    <label class="control-label" for="resim">Resim (Video, M�zik..)</label>
    <div class="controls">
      <input type="text" class="span9" name="resim" id="resim" placeholder="Resim, video veya m�zik url'si" value="<?php echo @$i�erik['resim']?>">
	  <i class="icon-info-sign tip" title="��eri�in medyas� teman�za g�re; resim video m�zik olabilir..." data-placement="right"></i>
    </div>
  </div>
  
  <div class="control-group">
    <label class="control-label" for="kategori">Kategori</label>
    <div class="controls">
      <?php echo '<select class="select2 span9" id="kategori" name="kategori">';
		$kategoriler = $baglanti->query("SELECT isim,seo FROM modulkategori WHERE modul ='".$_GET['modul']."'");
		while($m = $kategoriler->fetch_assoc()){
		$selected = '';
		if($m['seo']==@$i�erik['kategori']) $selected = ' selected';
		echo '<option value="'.$m['seo'].'"'.$selected.'>'.$m['isim'].'</option>';
		}
		$kategoriler->close();
		echo '</select>';?>
	  <i class="icon-info-sign tip" title="��eri�inizde iyibu!Portal kodlar� kullanabilirsiniz..." data-placement="right" style="margin-left:5px"></i>
    </div>
  </div>
  <hr>
  <div class="control-group">
    <label class="control-label" for="etiket">Etiketler</label>
    <div class="controls">
      <input type="text" class="span9" name="etiket" id="etiket" placeholder="Her etiket ard�ndan enter'a bas�n�z.." <?php echo 'value="'.@$i�erik['etiket'].'"'; if(empty($yenimi)) echo 'disabled';?>> 
	  <i class="icon-info-sign tip" title="��eri�in etiketi. Arama motorlar� i�in i�eri�inizle en alakal� kelimeleri giriniz. En fazla 5-8 aras� �nerilir.." data-placement="right" style="margin-left:5px"></i>
	  <br><br><span style="font-size:8pt" class="clearfix">* Etiketleri i�eri�i ilk kaydettikten sonra de�i�tiremezsiniz..</span>
    </div>
  </div>
  <hr>
  <div class="control-group">
    <label class="control-label" for="icerik">��erik</label>
    <div class="controls">
      <textarea id="icerik" name="icerik" style="height:300px"><?php echo htmlspecialchars(@$i�erik['icerik'])?></textarea>
	  <i class="icon-info-sign tip" title="��eri�inizde iste�e ba�l� olarak iyibu!Portal kodlar� kullanabilirsiniz..." data-placement="right"></i>
    </div>
  </div>
  
    <div class="control-group">
    <label class="control-label" for="kod">iyibuKodlar�?</label>
    <div class="controls">
	  <input type="checkbox" class="iyibuSwitch" id="kod" name="kod" <?php if(@$i�erik['kod']) echo 'checked';?>>
	  <i class="icon-info-sign tip" title="A��k se�ene�ini i�aretleyerek i�eri�inizde iyibu!Portal kodlar� kullanabilirsiniz" data-placement="right"></i>
    </div>
  </div>
  
  <div class="control-group">
    <div class="controls">
	  <input id="yeni" name="yeni" type="hidden" value="<?php echo $yenimi?>">
	  <input id="onay" name="onay" type="hidden" value="1">
	  <input id="modul" name="modul" type="hidden" value="<?php echo $_GET['modul']?>">
	  <input id="seo" name="seo" type="hidden" value="<?php echo @$_GET['seo']?>">
      <input type="submit" value="Kaydet ve Yay�nla" class="btn btn-success"> <input type="button" onclick="icerik_kaydet(2)" value="Taslak Olarak Kaydet" class="btn btn-warning"> <input type="reset" value="S�f�rla" class="btn">
    </div>
  </div>
  
  </form>
	  <div id="sonuc" class="clearfix" style="margin-left:180px"></div>
  </div>
  </div>
  <script>$('.tip').tooltip();
  editor('textarea');
  iyibuSwitch();
  $("#etiket").select2({tags:[]});
  $('select.select2').select2();
  function icerik_kaydet(onay){
  $('#onay').val(onay)
  $.ajax({
    url: "modul-islem.php?sayfa=icerik-ekle",
    type: "POST",
    data: $('#icerik-form').serialize()+'&kod='+$('#kod').is(':checked')
	}).done(function(data){
		if(data=='Ok'){
			$('#icerik-form').slideUp();
			$("html, body").animate({scrollTop:0},"fast");
			$('#sonuc').css('margin-left',3);
			$('#sonuc').html('<div class="alert alert-success"><i class="icon-ok-sign icon-white"></i> <strong>Tamamd�r!</strong> ��erik ba�ar�yla kaydedildi, isterseniz �st men�den i�eri�i tekrar d�zenleyebilir veya silebilirsiniz...</div>');
		}else{
		$('#sonuc').html(data);
		}
	});
  }
  
  $('#baslik').keyup(function(){
  var baslik = encodeURIComponent($(this).val());
  $('#seo').load('modul-islem.php?sayfa=seo&modul=<?php echo $_GET['modul']?>&cevir='+baslik);
  })
  
  $('#baslik').change(function(){
  var baslik = encodeURIComponent($(this).val());
  $('#seo').load('modul-islem.php?sayfa=seo&modul=<?php echo $_GET['modul']?>&cevir='+baslik);
  });
  
  var yenimi = $('#yeni').val()
  if(yenimi == 0){ $('#seo').remove()};
  </script>
<?php elseif($sayfa == "duzenle"&&(yetkiVarmi('tum_modul')||yetkiVarmi('m_'.$modul_seo))):?>
<div class="blok">
  <div class="blok-ust">��erikleri D�zenle
<button class="btn btn-success btn-mini pull-right" onclick="$('#sayfa').html('<div style=&quot;text-align:center&quot;><img src=&quot;img/yukle.gif&quot; alt=&quot;bekleyiniz...&quot;> Haz�rlan�yor...</div>').load('<?php echo basename($_SERVER['REQUEST_URI']);?>');"><i class="icon-refresh icon-white"></i></button>
<div id="islem" class="pull-right" style="margin-right:5px"></div></div>  <div class="blok-icerik">
  <div id="icerik-listele"></div>
  <script>
  $('#icerik-listele').load('modul-icerik.php?sayfa=listele&modul=<?php echo $_GET['modul']?>&baslangic=0&artis=6&page=1')
  </script>
  </div>
  </div>
<?php elseif($sayfa == "listele"&&(yetkiVarmi('tum_modul')||yetkiVarmi('m_'.$modul_seo))):
$modul = $_GET['modul'];
$ba�lang�� = $_GET['baslangic'];
$art�� = $_GET['artis'];
$page = $_GET['page'];
$i�erikler = $baglanti->query("SELECT * FROM modulicerik WHERE modul = '$modul' ORDER BY id DESC LIMIT $ba�lang�� , $art��");
$t�m_i�erik = $baglanti->query("SELECT id FROM modulicerik WHERE modul = '$modul'") or die();
$toplam_i�erik = $t�m_i�erik->num_rows;

if(empty($i�erikler->num_rows)){ echo '    <div class="alert alert-info">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <h4>Bilginlendirme</h4>
    Bu mod�le hen�z hi� i�erik eklenmemi�, buralar bombo�..
    </div>';}else{
echo '<table class="table table-striped"><thead><tr>
<th class="span1">#</th><th class="span8">Ba�l�k</th><th class="span1">Ekleyen</th>
<th class="span1">Hit</th><th class="span1">��lem</th></tr></thead><tbody>';
$i = $toplam_i�erik-($page*6-6);
while($i�erik = $i�erikler->fetch_assoc()){
$detay = $i�erik['icerik'];
$detay = strip_tags($detay);
$detay = substr($detay, 0, 600);
$detay = rtrim($detay);
if(strlen($i�erik['icerik'])>600) $detay .= '(...)';
echo '<tr id="icerik_'.$i�erik['id'].'" class="icerik" data-seo="'.$i�erik['seo'].'" title="D�zenlemek i�in �ift t�klay�n"><td>'.$i.'</td><td class="detay"><b>'.$i�erik['baslik'].'</b> <div class="pull-right" style="font-size:8pt">('.$i�erik['tarih'].') <b>#'.$i�erik['id'].'</b></div><br>'.$detay.'</td><td>'.$i�erik['ekleyen'].'</td><td>'.$i�erik['sayac'].'</td><td class="islem">
<a href="'.$site_adres.'/'.$_GET['modul'].'/'.$i�erik['seo'].'.html" target="_blank"><span class="badge badge-info" title="G�r�nt�le"><i class="icon-zoom-in icon-white" ></i></span></a>
<span class="badge badge-important sil" title="Sil!" data-id="'.$i�erik['id'].'"><i class="icon-trash icon-white" ></i></span>';
if($i�erik['onay']==1){
echo '<span class="badge badge-success onayli" title="Onay� Kald�r" data-id="'.$i�erik['id'].'"><i class="icon-ok icon-white" ></i></span>';
}elseif($i�erik['onay']==0){
echo '<span class="badge onaysiz" title="Onayla" data-id="'.$i�erik['id'].'"><i class="icon-ban-circle icon-white" ></i></span>';
}else{
echo '<span class="badge badge-warning taslak" title="Onayla ve Yay�nla" data-id="'.$i�erik['id'].'"><i class="icon-file icon-white" ></i></span>';
}
echo '<span class="badge badge-inverse yorumlar kapali" title="Yorumlar� G�r�nt�le" data-id="'.$i�erik['id'].'" data-seo="'.$i�erik['seo'].'"><i class="icon-comment icon-white" ></i></span>';
echo '</td></tr>';
$i--;
};
echo '</tbody></table>';
echo '<div class="pagination pagination-centered"><ul><li><a href="#">�</a></li>';
$sorgu = $baglanti->query("SELECT id FROM modulicerik where modul = '$modul'");
$sayfalar = ceil(($sorgu->num_rows)/$art��);
$sorgu->close();
for ($i = 1; $i <= $sayfalar; $i++) {
	$class = ($i == $page ? 'class="disabled"' : '');
    echo "<li $class><a href=\"javascript:void(0)\" class=\"sayfala\">$i</a></li>";
}
echo'<li><a href="#">�</a></li></ul></div>';
}?>
<script>
$('.sayfala').click(function(){
var sayfa = $(this).text();
var baslangic = sayfa*6-6;
var artis = 6;
$('#icerik-listele').slideUp();
$('#icerik-listele').load('modul-icerik.php?sayfa=listele&modul=<?php echo $_GET['modul']?>&baslangic='+baslangic+'&artis='+artis+'&page='+sayfa, function() {$('#icerik-listele').slideDown()})
});
$('span').tooltip({placement: 'left'});
$("tr").hover(
function () {$(this).children().addClass("aktific");},
function () {$(this).children().removeClass("aktific");});
$('tr').dblclick(function(){
var seo = $(this).attr('data-seo');
$('#sayfa').load('modul-icerik.php?sayfa=form&modul=<?php echo $_GET['modul']?>&seo='+seo);
});
$('tr').tooltip();
$('#tum_yorumlar').tooltip({placement: 'left'});
onaysizla(); onayla1(); onayla2();

$('.sil').click(function(){
var id = $(this).attr('data-id');
bootbox.confirm("<h3>��eri�i silmek istedi�inize emin misiniz?</h3><hr>Ayn� zamanda bu i�eri�e ait t�m yorumlar ve di�er bilgiler de kald�r�lacakt�r..<br>Bu i�lem geri <b>al�namaz</b>. Silmek yerine onay� kald�rarak i�eri�i 'g�r�nmez' yapabilirsiniz.","�ptal","Evet, i�eri�i sil", function(result) {
if(result == true){
$('#islem').load('modul-islem.php?sayfa=icerik-sil&id='+id);
$('#icerik_'+id).remove();
};
}); 
$('.bootbox').css({'margin-top': function () {return 100}});
$('.modal-backdrop').click(function(){
bootbox.hideAll();
});
});

$('.yorumlar').popover({
	content: '<div id="yorumlar"></div><div id="y-islem"></div>',
	placement: 'left',
	html: true,
	width: '400px'
	});

$('.yorumlar').click(function(){
var seo = $(this).attr('data-seo');
	if($(this).hasClass('kapali')==true){
	yorumlarJSON(seo);
	$('tr').tooltip('hide');
	$(this).removeClass('kapali');
	}else{
	$(this).addClass('kapali');
	}
	$('#yorumlar').parents('.popover').css('min-width','700px').css('margin-left','-546px').css('z-index','100');
	$('#yorumlar').resize(function(){
		var yukseklik = ($('#yorumlar').height())/2;
		var top = $('#yorumlar').parents('.popover').prev('.yorumlar').offset();
		$('#yorumlar').parents('.popover').css('top',(top.top)-yukseklik-19);
		}).resize();
	});
function yorumlarJSON(seo){
$('#yorumlar').html('<div style="text-align:center"><img src="img/yukle.gif" alt="bekleyiniz..."> Haz�rlan�yor...</div>');
	$.getJSON("modul-islem.php?sayfa=json-yorumlar&modul=<?php echo @$_GET['modul']?>&icerik="+seo,
      function(data){
	  var yorumlar = [];
	  var klas = '';
	  var toplam = data.yorumlar.length;
	  if(toplam == 0){yorumlar.push('Bu i�eri�e ait hi� yorum yok');
	  }else{
	  yorumlar.push('<thead><th>Yorum</th><th style="width: 83px">Ekleyen</th><th style="width: 100px">��lem</th></thead><tbody>');
	  };
        $.each(data.yorumlar, function( i, y ){
		if(y.onay==0){klas = 'style="background-color:#B94A48!important;color:#FFF"';
		}else{klas = 'style=""'};
          yorumlar.push('<tr id="yorum_'+y.id+'" '+klas+'>');
		  yorumlar.push('<td '+klas+'>'+escapeHtml(y.yorum)+'</td>');
		  yorumlar.push('<td '+klas+'>'+y.ekleyen+'</td>');
		  yorumlar.push('<td '+klas+'>');
		  yorumlar.push('<a class="btn btn-info btn-mini" onclick="bootbox.alert(\''+escapeHtml(y.yorum)+'\')" title="�nizle" data-id="'+y.id+'"><i class="icon-zoom-in icon-white"></i></a> ');
		  if(y.onay==0){
		  yorumlar.push('<a class="btn btn-success btn-mini y-onay" title="Onayla" data-id="'+y.id+'" data-seo="'+seo+'"><i class="icon-ok icon-white"></i></a> ');
		  }else{
		  yorumlar.push('<a class="btn btn-danger btn-mini y-o-k" title="Onay� Kald�r" data-id="'+y.id+'" data-seo="'+seo+'"><i class="icon-remove icon-white"></i></a> ');
		  };
		  yorumlar.push('<a class="btn btn-danger btn-mini y-sil" title="Sil" data-id="'+y.id+'" data-seo="'+seo+'"><i class="icon-trash icon-white"></i></a>');
		  yorumlar.push('</td></tr>');
        });
		yorumlar.push('</tbody>');
		$('#yorumlar').html('');
		$('<table/>', {
		'class': 'yorumtbl table table-striped',
		html: yorumlar.join('')}).appendTo('#yorumlar');
		$('#yorumlar').append('<div id="k-islem"></div>');
		$('#yorumlar').resize(function(){
		var yukseklik = ($('#yorumlar').height())/2;
		var top = $('#yorumlar').parents('.popover').prev('.yorumlar').offset();
		$('#yorumlar').parents('.popover').css('top',(top.top)-yukseklik-19);
		}).resize();
		$('#yorumlar').parents('.popover').hover(function(){$('tr').tooltip('hide');});
		$('#yorumlar a').tooltip();
		
$('.y-onay').click(function(){
var id = $(this).attr('data-id');
var seo = $(this).attr('data-seo');
$('#y-islem').load('modul-islem.php?sayfa=yorum-onayla&id='+id,function(){
yorumlarJSON(seo);});
});

$('.y-o-k').click(function(){
var id = $(this).attr('data-id');
var seo = $(this).attr('data-seo');
$('#y-islem').load('modul-islem.php?sayfa=yorum-onay-kaldir&id='+id,function(){
yorumlarJSON(seo);});
});

$('.y-sil').click(function(){
var id = $(this).attr('data-id');
var seo = $(this).attr('data-seo');
$('#y-islem').load('modul-islem.php?sayfa=yorum-sil&id='+id,function(){
yorumlarJSON(seo);});
});


    });
}



</script>
<style>.detay {cursor: pointer}
.aktific {background-color: #EFEFEF!important}
#yorumlar {max-height:350px;overflow:auto}</style>
<?php elseif($sayfa == "kategori-form"&&(yetkiVarmi('tum_modul')||yetkiVarmi('m_'.$modul_seo))):
if(!empty($_GET['id'])){
$sorgu = $baglanti->query("SELECT isim,resim,kelime,aciklama FROM modulkategori where id=".$_GET['id']." LIMIT 1");
$kategori = $sorgu->fetch_assoc();
}?>
<form id="kategori-form" method="POST" action="javascript:modul_kaydet()" class="form-horizontal" style="width:500px">
	<div class="control-group">
    <label class="control-label" for="k_isim" style="margin-left:0px; width:120px;">Kategori</label>
    <div class="controls" style="margin-left:130px; width:auto;">
      <input type="text" name="k_isim" id="k_isim" placeholder="Kategori �smi" value="<?php echo @$kategori['isim']?>" style="width:100%">
    </div>
	</div>
	<div class="control-group">
    <label class="control-label" for="k_resim" style="margin-left:0px; width:120px;">K���k Resim</label>
    <div class="controls" style="margin-left:130px; width:auto;">
      <input type="text" name="k_resim" id="k_resim" placeholder="Kategori Resmi (mini-icon)" value="<?php echo @$kategori['resim']?>" style="width:100%">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="k_key" style="margin-left:0px; width:120px;">Anahtar Kelimeler</label>
    <div class="controls" style="margin-left:130px; width:auto;">
      <input type="text" name="k_key" id="k_key" placeholder="Kategori Anahtar Kelimeleri (meta_keywords)" value="<?php echo @$kategori['kelime']?>" style="width:100%">
    </div>
  </div>
  
 <div class="control-group">
    <label class="control-label" for="k_desc" style="margin-left:0px; width:120px;">A��klama</label>
    <div class="controls" style="margin-left:130px; width:auto;">
      <textarea name="k_desc" id="k_desc" placeholder="Kategori A��klamas� (meta_description)" style="width:100%"><?php echo @$kategori['aciklama']?></textarea>
	  <input type="hidden" name="k_modul" id="k_modul" value="<?php echo @$_GET['modul']?>">
	  <input type="hidden" name="k_id" id="k_id" value="<?php echo @$_GET['id']?>">
    </div>
  </div>
</form>
<?php endif?>