<?php header('Content-Type: text/html; charset=iso-8859-9');
require(__DIR__ . '/../baglanti.php');
require(__DIR__ . '/../_inc/fonksiyonlar.php');
if($_SESSION['yonetici']==false&&yetkiVarmi('s_mynt')){header('Location: giris.php');
die();};?>
<div class="blok">
  <div class="blok-ust">Men� Y�netimi 
  
  <button class="btn btn-success btn-mini pull-right" onclick="$('#sayfa').html('<div style=&quot;text-align:center&quot;><img src=&quot;img/yukle.gif&quot; alt=&quot;bekleyiniz...&quot;> Haz�rlan�yor...</div>').load('<?php echo basename($_SERVER['REQUEST_URI']);?>');"><i class="icon-refresh icon-white"></i></button></div>
  <div class="blok-icerik">
  <div id="menuler">
  <script>function tabla(q){
  $('.tabbable a[href="#'+q+'"]').tab('show');
  }
  function yenimenu(){
	var deger = $('#deger').val();
	if(deger.length < 1){ 
	$('#deger').focus();
	return false;}
	  $('#sonuc').load('menu-islem.php?sayfa=grup-ekle&isim='+deger,function(id){
	var m_yeni = '<div class="btn-group m_'+id+'">'
			+'<button class="btn" onclick="tabla(\''+id+'\')"><i '
			+'class="icon-th-list"></i> '+deger+'</button>'
			+'<button class="btn grup-sil" data-id="'+id+'" data-isim="'+deger+'"><i class="icon-trash"></i></button>  </div>';
	$('#menu-list').append(m_yeni);
	var t_yeni = '<li class="m_'+id+'"><a href="#'+id+'" data-toggle="tab">'+deger+'</a></li>'
	$('.nav-tabs').append(t_yeni);
	var p_yeni = '<div id="'+id+'" class="tab-pane m_'+id+'">Yeni olu�turdu�unuz men�y� d�zenleyebilmek i�in l�tfen bu b�l�m� tekrar y�kleyin...</div>'
	$('.tab-content').append(p_yeni);
	grupSil();
	$('.nav-tabs li:last a').click();
	});
  }
  
  function yenilink(grup){
  var isim = $('#'+grup+'_isim').val();
  var resim = $('#'+grup+'_resim').val();
  var adres = $('#'+grup+'_adres').val();
  var sira = $('.g_'+grup+' ul li').size()+1;
  $('#sonuc').load('menu-islem.php?sayfa=ekle&isim='+encodeURI(isim)+'&resim='+resim+'&adres='+adres+'&sira='+sira+'&yer='+grup,
  function(data){
  var ekle = '<li id="menu_'+data+'" title="'+adres+'">'+isim+' <i class="icon-remove" data-id="'+data+'" data-grup="'+grup+'" title="Kald�r"></i></li>';
  $('#yok_'+grup).hide();
  $('.g_'+grup+' ul').append(ekle);
  $('.menu li i').click(function(){
  var id = $(this).attr('data-id');
  var grup = $(this).attr('data-grup');
  $(this).tooltip('hide');
  $('#sonuc').load('menu-islem.php?sayfa=sil&id='+id);
  $('#menu_'+id).tooltip('hide').remove();
  var sira2 = $('.g_'+grup+' ul li').size();
  if(sira2<1) $('#yok_'+grup).show();
  });
  $('.menu li,.menu i').tooltip();
  });
  grupSil();
  }
  
  $('.menu li i').click(function(){
  var id = $(this).attr('data-id');
  var grup = $(this).attr('data-grup');
  var sira = $('.g_'+grup+' ul li').size();
  $(this).tooltip('hide');
  $('#sonuc').load('menu-islem.php?sayfa=sil&id='+id);
  $('#menu_'+id).tooltip('hide').remove();
  if(sira<1) $('#yok_'+grup).show();
  });
  </script>
  <style>

  ul.menu li{border: 1px solid #CCCCCC; display:inline-block; padding:15px; margin: 5px; cursor:move; background: #FFF}
  ul.menu li.placeholder{border: 2px dashed #CCCCCC; width: 10px; margin-bottom:-23px; background: #FAFAFA}
  ul.menu i{cursor:pointer}
  </style>
  <div id="menu-list">
  <?php $sorgu = $baglanti->query("SELECT id,isim FROM menu WHERE yer = 'iyibu-menu-list'") or trigger_error(@$baglanti->error);
  while($men� = $sorgu->fetch_assoc()){
  echo '<div class="btn-group m_'.$men�['id'].'">
  <button class="btn" onclick="tabla(\''.$men�['id'].'\')"><i class="icon-th-list" ></i> '.$men�['isim'].'</button>
	<button class="btn grup-sil" data-id="'.$men�['id'].'" data-isim="'.$men�['isim'].'"><i class="icon-trash"></i></button>  </div>';
  }
  $sorgu->close();
  ?>
  </div>
  <br>
  <input id="deger" type="text" style="margin-bottom:0px"> <button class="btn btn-primary" onclick="yenimenu()">Yeni Men� Grubu Ekle</button>
  </div>
  <hr>
  <div class="tabbable">
  <ul class="nav nav-tabs">
  <?php $sorgu = $baglanti->query("SELECT id,isim FROM menu WHERE yer = 'iyibu-menu-list'") or trigger_error(@$baglanti->error);
  while($men� = $sorgu->fetch_assoc()){
  echo '<li class="m_'.$men�['id'].'"><a href="#'.$men�['id'].'" data-toggle="tab">'.$men�['isim'].'</a></li>';
  }
  $sorgu->close();
  ?>
  <div id="sonuc" class="pull-right"></div>
  </ul>
  <div class="tab-content">
  <?php $sorgu = $baglanti->query("SELECT id,isim FROM menu WHERE yer = 'iyibu-menu-list'") or trigger_error(@$baglanti->error);
  while($men� = $sorgu->fetch_assoc()){
  echo '<div id="'.$men�['id'].'" class="tab-pane m_'.$men�['id'].' g_'.$men�['isim'].'"><ul class="menu">';
  $sorgu2 = $baglanti->query("SELECT id,isim,link FROM menu WHERE yer = '".$men�['isim']."' ORDER BY sira ASC") or trigger_error(@$baglanti->error);
  while($men�ler = $sorgu2->fetch_assoc()){
  echo '<li id="menu_'.$men�ler['id'].'" title="'.$men�ler['link'].'">'.$men�ler['isim'].' <i class="icon-remove" data-id="'.$men�ler['id'].'" data-grup="'.$men�['isim'].'" title="Kald�r"></i></li>';
  }
  if(!$sorgu2->num_rows) echo '<div id="yok_'.$men�['isim'].'">Hi� men� yok</div>';
  echo '</ul><hr><div style="margin-left:32px"><input id="'.$men�['isim'].'_isim" class="span4" type="text" style="margin-bottom:0px" placeholder="�sim"> 
  <input id="'.$men�['isim'].'_resim" type="text" style="margin-bottom:0px" placeholder="Men� Resmi" class="span6"><br><br>
<input id="'.$men�['isim'].'_adres" type="text" style="margin-bottom:0px" placeholder="Adres" class="span8">  <button class="btn btn-primary" onclick="yenilink(\''.$men�['isim'].'\')">
  Yeni Men� Ekle</button>';
  echo '</div></div>';
  }
  $sorgu->close();
  ?>
  </div><!-- /.tab-content -->
</div><!-- /.tabbable -->
  <script>
  $('.menu li,.menu i').tooltip();
  $(function () {
    $('.tabbable a:first').tab('show');
  })
  $(".menu").sortable({
	placeholder: 'placeholder',
	items: "li:not(.ekle)",
	start: function(e, ui){
        ui.placeholder.height(ui.item.height());
		ui.placeholder.width(ui.item.width());
		$('.menu li,.menu i').tooltip('hide');
    },
	update : function () {
	var order = $(this).sortable('serialize');
		$.post('menu-islem.php?sayfa=sirala', order, function(data) {
		$('#sonuc').html(data);
		});
	}
});
function grupSil(){
	$('.grup-sil').click(function(){
		var id = $(this).attr('data-id');
		var isim = $(this).attr('data-isim');
		$('.m_'+id).remove();
		$('.nav-tabs li:first a').click();
		$('#sonuc').load('menu-islem.php?sayfa=sil&id='+id+'&isim='+isim);
	});
}
grupSil();
</script>
  </div>
  </div>
  