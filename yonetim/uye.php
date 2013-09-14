<?php header('Content-Type: text/html; charset=iso-8859-9');
require(__DIR__ . '/../baglanti.php');
require(__DIR__ . '/../_inc/fonksiyonlar.php');
if($_SESSION['yonetici']==false&&yetkiVarmi('uye')){header('Location: giris.php');
die();};
$sayfa = $_GET['sayfa'];
if($sayfa=='istatistik'&&yetkiVarmi('u_ist')):?>
<div class="blok">
  <div class="blok-ust">�statistikler
  <button id="yenile" class="btn btn-success btn-mini pull-right" onclick="$('#sayfa').html('<div style=&quot;text-align:center&quot;><img src=&quot;img/yukle.gif&quot; alt=&quot;bekleyiniz...&quot;> Haz�rlan�yor...</div>').load('<?php echo basename($_SERVER['REQUEST_URI']);?>');"><i class="icon-refresh icon-white"></i></button></div>
  <div class="blok-icerik">
	Burada �statistik
  </div>
</div>
<?php elseif($sayfa=='uyeler'&&yetkiVarmi('u_uye')):?>
<div class="blok">
  <div class="blok-ust">T�m �yeler
  <button class="btn btn-success btn-mini pull-right" onclick="$('#sayfa').html('<div style=&quot;text-align:center&quot;><img src=&quot;img/yukle.gif&quot; alt=&quot;bekleyiniz...&quot;> Haz�rlan�yor...</div>').load('<?php echo basename($_SERVER['REQUEST_URI']);?>');"><i class="icon-refresh icon-white"></i></button>
    <div id="islemler" class="pull-right" style="margin-right:5px"></div></div>
  <div class="blok-icerik">
	  <div id="uye-listele"></div>
  <script>
  $('#uye-listele').load('uye.php?sayfa=listele&baslangic=0&artis=10&page=1');
  </script>
  </div>
</div>
<?php elseif($sayfa=='listele'&&yetkiVarmi('u_uye')):
$ba�lang�� = $_GET['baslangic'];
$art�� = $_GET['artis'];
$page = $_GET['page'];
$uyeler = $baglanti->query("SELECT kullaniciadi,Adi,Soyadi,Email,Yetki FROM uyeler ORDER BY id ASC LIMIT $ba�lang�� , $art��") or trigger_error(@$baglanti->error);
$t_�ye1 = $baglanti->query("SELECT id FROM uyeler") or die();
$t_�ye = (int)$t_�ye1->num_rows;
$sayfalar = ceil(($t_�ye1->num_rows)/$art��);
$i = $page*$art��-$art��+1;
echo '<table class="table table-striped"><thead><tr>
<th class="span1">#</th><th style="min-width:80px" class="span1">Avatar</th><th style="min-width:140px" class="span1">Kullan�c� Ad�</th><th style="min-width:100px" class="span1">Ad�</th>
<th style="min-width:100px" class="span1">Soyad�</th><th class="span5">E-Posta</th><th style="min-width:100px">��lemler</th></tr></thead><tbody>';
while($uye = $uyeler->fetch_assoc()){
echo '<tr';
if($uye['Yetki']==-1) echo ' style="color: red" title="Engelli kullan�c�"';
if($uye['Yetki']==0) echo ' style="color: blue" title="Onaylanmam�� kullan�c�"';
echo '><td>'.$i.'</td>';
echo '<td><img src="https://1.gravatar.com/avatar/'.md5($uye['Email']).'?s=64" style="width:64px;height:64px;"></td>';
echo '<td><b>'.$uye['kullaniciadi'].'</b></td>';
echo '<td>'.$uye['Adi'].'</td>';
echo '<td>'.$uye['Soyadi'].'</td>';
echo '<td>'.$uye['Email'].'</td>';
echo '<td><a class="btn btn-mini" onclick="$(\'#sayfa\').load(\'uye.php?sayfa=form&kadi='.$uye['kullaniciadi'].'\');" title="D�zenle"><i class="icon-edit"></i></a>';
echo ' <a class="btn btn-danger btn-mini engelle" onclick="" title="Engelle (Yetki -1)" kadi="'.$uye['kullaniciadi'].'"><i class="icon-ban-circle icon-white"></i></a>';
echo ' <a class="btn btn-success btn-mini onayla" onclick="" title="Onayla (Yetki 1)" kadi="'.$uye['kullaniciadi'].'"><i class="icon-ok icon-white"></i></a>';
echo '</td></tr>';

$i++;
};
echo '</tbody></table><div class="sayfalar" gecerli="'.$page.'" toplam="'.$sayfalar.'" artis="'.$art��.'">sadsad</div>';?>
<script>
$('.engelle').click(function(){
var kadi = $(this).attr('kadi');
$('#islemler').load('uye-islem.php?sayfa=uye-engelle&kadi='+kadi);
});
$('.onayla').click(function(){
var kadi = $(this).attr('kadi');
$('#islemler').load('uye-islem.php?sayfa=uye-onayla&kadi='+kadi);
});
$('tr').tooltip();
$('td a').tooltip();
function sayfala(div){
var gecerli = $(div).attr("gecerli");
var toplam = $(div).attr("toplam");
var artis = $(div).attr("artis");
var options = {
currentPage: gecerli,
totalPages: toplam,
alignment: 'center',
numberOfPages: 19,
useBootstrapTooltip: true,
tooltipTitles: function (type, page, current) {
                    switch (type) {
                    case "first":
                        return "�lk Sayfa";
                    case "prev":
                        return "�nceki";
                    case "next":
                        return "Sonraki";
                    case "last":
                        return "Son Sayfa";
                    case "page":
                        return page+". sayfadas�n�z";
                    }
                },
pageUrl: function(type, page, current){
		return "javascript:void(0)";
},
onPageClicked: function(event, originalEvent, type, page){
	$('#uye-listele').slideUp();
	var baslangic = page*artis-artis;
	$('#uye-listele').load('uye.php?sayfa=listele&baslangic='+baslangic+'&artis='+artis+'&page='+page);
	$('#uye-listele').slideDown();
}
}
$(div).bootstrapPaginator(options);
}
sayfala('.sayfalar');
$("tr").hover(
function () {$(this).children().addClass("aktific");},
function () {$(this).children().removeClass("aktific");});
</script>
<style>.pagination{position:fixed;bottom:0;margin:0}
.aktific {background-color: #EFEFEF!important}</style>
<?php elseif($sayfa=='form'&&yetkiVarmi('u_yni')):
$kadi = @$_GET['kadi'];
if(!empty($kadi)){
$sorgu = $baglanti->query("SELECT kullaniciadi,Parola,Email,Adi,Soyadi,dogum,Meslek,Sehir,Web,Imza,Yetki FROM uyeler WHERE kullaniciadi ='$kadi' LIMIT 1");
$uye = $sorgu->fetch_assoc();
}?>
<div class="blok">
  <div class="blok-ust">�ye D�zenle/Ekle
  <button class="btn btn-success btn-mini pull-right" onclick="$('#sayfa').html('<div style=&quot;text-align:center&quot;><img src=&quot;img/yukle.gif&quot; alt=&quot;bekleyiniz...&quot;> Haz�rlan�yor...</div>').load('<?php echo basename($_SERVER['REQUEST_URI']);?>');"><i class="icon-refresh icon-white"></i></button></div>
  <div class="blok-icerik">
	<form id="uye-form" action="javascript:uyeKaydet()" class="form-horizontal">
	<div class="control-group">
		<label class="control-label" for="Yetki">Yetki</label>
		<div class="controls">
			<select id="Yetki" name="Yetki" class="span4">
				<?php $sorgu = $baglanti->query("SELECT id,isim FROM yetki");
				while($y = $sorgu->fetch_assoc()){
					$selected = '';
					if($uye['Yetki'] == $y['id']) $selected = ' selected';
					echo '<option value="'.$y['id'].'"'.$selected.'>'.$y['isim'].'</option>';
				};?>
				<option value="0"<?php if(!$uye['Yetki']) echo ' selected'?>>Onays�z</option>
				<option value="-1"<?php if($uye['Yetki']==-1) echo ' selected'?>>Engelli</option>
			</select>
		</div>
	</div>
	
	<div class="control-group">
		<label class="control-label" for="kadi">Kullan�c� Ad�</label>
		<div class="controls">
			<input type="text" id="kadi" name="kullaniciadi" value="<?php echo @$uye['kullaniciadi']?>" placeholder="A-Za-z0-9_(T�rk�e Karakter Yok)">
		</div>
	</div>
	
	<div class="control-group">
		<label class="control-label" for="Parola">�ifre</label>
		<div class="controls">
			<input type="text" id="Parola" name="Parola" placeholder="De�i�memesi i�in bo� b�rak�n"><?php if(!empty($uye['Parola'])) echo ' * MD5 Hash: '.$uye['Parola']?>
		</div>
	</div>

	<div class="control-group">
		<label class="control-label" for="Email">E-Posta</label>
		<div class="controls">
			<input type="text" id="Email" name="Email" value="<?php echo @$uye['Email']?>" placeholder="E-Posta Adresi">
		</div>
	</div>
	
	<div class="control-group">
		<label class="control-label" for="Adi">Ad�</label>
		<div class="controls">
			<input type="text" id="Adi" name="Adi" value="<?php echo @$uye['Adi']?>" placeholder="Ger�ek Ad�">
		</div>
	</div>
	
	<div class="control-group">
		<label class="control-label" for="Soyadi">Soyad�</label>
		<div class="controls">
			<input type="text" id="Soyadi" name="Soyadi" value="<?php echo @$uye['Soyadi']?>" placeholder="Ger�ek Soyad�">
		</div>
	</div>

	<div class="control-group">
		<label class="control-label" for="dogum">Do�um Tarihi</label>
		<div class="controls">
			<div class="input-append date">
			<input type="text" id="dogum" name="dogum" style="width:85px" value="<?php echo @$uye['dogum']?>" placeholder="03.05.1996"><span class="add-on"><i class="icon-th"></i></span>
			</div>
		</div>
	</div>
	
	<div class="control-group">
		<label class="control-label" for="Meslek">Meslek</label>
		<div class="controls">
			<input type="text" id="Meslek" name="Meslek" value="<?php echo @$uye['Meslek']?>" placeholder="Meslek">
		</div>
	</div>

	<div class="control-group">
		<label class="control-label" for="Sehir">�ehir</label>
		<div class="controls">
			<input type="text" id="Sehir" name="Sehir" value="<?php echo @$uye['Sehir']?>" placeholder="Bulundu�u �ehir">
		</div>
	</div>

	<div class="control-group">
		<label class="control-label" for="Web">Web Adresi</label>
		<div class="controls">
			<input type="text" id="Web" name="Web" value="<?php echo @$uye['Web']?>" placeholder="Web Site">
		</div>
	</div>
	
	<div class="control-group">
		<label class="control-label" for="Imza">�mza</label>
		<div class="controls">
			<textarea class="span6" id="Imza" name="Imza" placeholder="�mza"><?php echo @$uye['Imza']?></textarea>
		</div>
	</div>

	<div class="control-group">
		<div class="controls">
		<input id="kadi2" name="kadi2" type="hidden" value="<?php echo @$uye['kullaniciadi']?>">
		<button id="kaydet" class="btn btn-success" type="submit"><i class="icon-ok icon-white"></i> De�i�iklikleri Kaydet</button>
		<div id="uye-kayit"></div>
		</div>
	</div>
	  </form>
  </div>
</div>
<script>$('select').select2();
$('.input-append.date').datepicker({
    format: "dd.mm.yyyy",
    startView: 2,
    todayBtn: true,
    language: "tr",
    forceParse: false,
    autoclose: true,
    });
function uyeKaydet(){
$.ajax({
    url: "uye-islem.php?sayfa=uye-kaydet",
    type: "POST",
    data: $('#uye-form').serialize()
	}).done(function( html ) {
	if(html == 'Ok'){
	$('#kaydet').removeClass('btn-danger').addClass('btn-success').html('<i class="icon-ok-sign icon-white"></i> T�m de�i�iklikler kaydedildi!').attr('disabled','disabled');
	$('#uye-kayit').empty();
	}else{
	$('#uye-kayit').html(html);
	$('#kaydet').html('<i class="icon-repeat icon-white"></i> Ba�ar�s�z. Tekrar dene!').removeClass('btn-success').addClass('btn-danger');
	}
	});
};
	</script>
<?php elseif($sayfa=='yetki-form'&&yetkiVarmi('u_yetki')):
$title = 'Yeni Yetki Ekle';
if(!empty($_GET['id'])){
$sorgu = $baglanti->query("SELECT isim,yetkiler FROM yetki WHERE id={$_GET['id']} LIMIT 1");
$yetkiler = @$sorgu->fetch_assoc();
$title = $yetkiler['isim'].' yetkilerini �zenle';
$isim = $yetkiler['isim'];
$yetkiler = $yetkiler['yetkiler'];
$yetkiler = explode(',',$yetkiler);
$id = $_GET['id'];
}?>
	<h3><?php echo $title?></h3><hr>
	  <form id="yetki-form" action="javascript:yetkiKaydet()" style="display:inline-block!important; position:default;">
	  <?php if(empty($id)) echo '<input class="span5" type="text" name="isim" placeholder="Yetkiye bir isim verin"><br>';
	  if(!empty($id)) echo '<input type="hidden" name="isim" value="'.$isim.'">'?>
	  <div class="well" style="padding-top:0px">
	  <h4>Site Genel</h4>
	  <span class="badge<?php if(@strposa('site',$yetkiler)) echo ' sec'?>" style="margin-top:5px"><input type="checkbox" value="site" name="yetki[]"><i class="icon-eye-open icon-white"></i></span>
	  <span class="label<?php if(@strposa('s_ist',$yetkiler)) echo ' sec'?>"><input type="checkbox" value="s_ist" name="yetki[]"><i class="icon-tasks icon-white"></i> �statistikler</span>
	  <span class="label<?php if(@strposa('s_ayr',$yetkiler)) echo ' sec'?>"><input type="checkbox" value="s_ayr" name="yetki[]"><i class="icon-cog icon-white"></i> Site Ayarlar�</span>
	  <span class="label<?php if(@strposa('s_blg',$yetkiler)) echo ' sec'?>"><input type="checkbox" value="s_blg" name="yetki[]"><i class="icon-info-sign icon-white"></i> Sistem Bilgisi</span>
	  <span class="label<?php if(@strposa('s_bynt',$yetkiler)) echo ' sec'?>"><input type="checkbox" value="s_bynt" name="yetki[]"><i class="icon-th icon-white"></i> Blok Y�netimi</span>
	  <span class="label<?php if(@strposa('s_mynt',$yetkiler)) echo ' sec'?>"><input type="checkbox" value="s_mynt" name="yetki[]"><i class="icon-th-list icon-white"></i> Men� Y�netimi</span>
	  <span class="label<?php if(@strposa('s_adzn',$yetkiler)) echo ' sec'?>"><input type="checkbox" value="s_adzn" name="yetki[]"><i class="icon-home icon-white"></i> Anasayfa D�zeni</span>
	  </div>
	  
	  <div class="well" style="padding-top:0px">
	  <h4>Mod�ller</h4>
	  <span class="badge<?php if(@strposa('modul',$yetkiler)) echo ' sec'?>" style="margin-top:5px"><input type="checkbox" value="modul" name="yetki[]"><i class="icon-eye-open icon-white"></i></span>
	  <?php $sorgu = $baglanti->query("SELECT seo, baslik FROM modul");
	  while($m=$sorgu->fetch_assoc()){
	  if(@@strposa('m_'.$m['seo'],$yetkiler)) $sec = ' sec';
	  echo '<span class="label'.@$sec.'"><input type="checkbox" value="m_'.$m['seo'].'" name="yetki[]"> <i class="icon-file icon-white"></i> '.$m['baslik'].'</span>';
	  };
	  $sorgu->close();?>
	  <span class="label<?php if(@strposa('tum_modul',$yetkiler)) echo ' sec'?>"><input type="checkbox" value="tum_modul" name="yetki[]"> <i class="icon-star icon-white"></i> T�m Mod�llere �zin</span>
	  <span class="label<?php if(@strposa('yeni_modul',$yetkiler)) echo ' sec'?>"><input type="checkbox" value="yeni_modul" name="yetki[]"> <i class="icon-wrench icon-white"></i> Yeni Mod�l Olu�tur</span>
	  </div>
	  
	  <div class="well" style="padding-top:0px">
	  <h4>Tema</h4>
	  <span class="badge<?php if(@strposa('tema',$yetkiler)) echo ' sec'?>" style="margin-top:5px"><input type="checkbox" value="tema" name="yetki[]"><i class="icon-eye-open icon-white"></i></span>
	  <span class="label<?php if(@strposa('t_ayr',$yetkiler)) echo ' sec'?>"><input type="checkbox" value="t_ayr" name="yetki[]"> <i class="icon-wrench icon-white"></i> Tema Ayarlar�</span>
	  </div>
	  
	  <div class="well" style="padding-top:0px">
	  <h4>�ye Y�netimi</h4>
	  <span class="badge<?php if(@strposa('uye',$yetkiler)) echo ' sec'?>" style="margin-top:5px"><input type="checkbox" value="uye" name="yetki[]"><i class="icon-eye-open icon-white"></i></span>
	  <span class="label<?php if(@strposa('u_ist',$yetkiler)) echo ' sec'?>"><input type="checkbox" value="u_ist" name="yetki[]"><i class="icon-tasks icon-white"></i> �statistikler</span>
	  <span class="label<?php if(@strposa('u_uye',$yetkiler)) echo ' sec'?>"><input type="checkbox" value="u_uye" name="yetki[]"><i class="icon-user icon-white"></i> T�m �yeler</span>
	  <span class="label<?php if(@strposa('u_yetki',$yetkiler)) echo ' sec'?>"><input type="checkbox" value="u_yetki" name="yetki[]"><i class="icon-lock icon-white"></i> Yetki ��lemleri</span>
	  <span class="label<?php if(@strposa('u_pst',$yetkiler)) echo ' sec'?>"><input type="checkbox" value="u_pst" name="yetki[]"><i class="icon-envelope icon-white"></i> E-Posta/Mesaj G�nder</span>
	  <span class="label<?php if(@strposa('u_yni',$yetkiler)) echo ' sec'?>"><input type="checkbox" value="u_yni" name="yetki[]"><i class="icon-plus-sign icon-white"></i> �ye Ekle/D�zenle</span>
	  </div>
	  
	  <div class="well" style="padding-top:0px">
	  <h4>Veritaban� Y�netimi</h4>
	  <span class="badge <?php if(@strposa('vt',$yetkiler)) echo ' sec'?>" style="margin-top:5px"><input type="checkbox" value="vt" name="yetki[]"><i class="icon-eye-open icon-white"></i></span>
	  <span class="label<?php if(@strposa('vt_sql',$yetkiler)) echo ' sec'?>"><input type="checkbox" value="vt_sql" name="yetki[]"><i class="icon-hdd icon-white"></i> Toplu SQL Sorgusu</span>
	  <span class="label<?php if(@strposa('vt_ydk',$yetkiler)) echo ' sec'?>"><input type="checkbox" value="vt_ydk" name="yetki[]"><i class="icon-download-alt icon-white"></i> Yedekle</span>
	  </div>
	  <input type="hidden" name="id" value="<?php echo @$id?>">
	  <div id="yetki-kayit" class="pull-left"></div>
	  <button id="kaydet" type="submit" class="btn btn-success pull-right">De�i�iklikleri Kaydet</button>
	  </form>

<script>
function yetkiKaydet(){
$.ajax({
    url: "uye-islem.php?sayfa=yetki-kaydet",
    type: "GET",
    data: $('#yetki-form').serialize()
	}).done(function( html ) {
	if(html == 'Ok'){
	$('#kaydet').removeClass('btn-danger').addClass('btn-success').html('<i class="icon-ok-sign icon-white"></i> T�m de�i�iklikler kaydedildi!').attr('disabled','disabled');
	$('#yetki-kayit').empty();
	}else{
	$('#yetki-kayit').html(html);
	$('#kaydet').html('<i class="icon-repeat icon-white"></i> Ba�ar�s�z. Tekrar dene!').removeClass('btn-success').addClass('btn-danger');
	}
	});
};

function isaretle(span){
$('.'+span).children('input').hide();
$('.'+span).not('.yeni-label').click(function(){
var secili = $(this).hasClass('sec');
if(secili==true){
$(this).removeClass(span+'-success').removeClass('sec');
$(this).children('input').prop('checked', false);
if(span=='badge') $(this).parent('div').children('.label').children('input').prop('checked', false).parent('.label').removeClass('sec').removeClass('label-success');
}else{
$(this).addClass(span+'-success').addClass('sec');
$(this).children('input').prop('checked', true);
if(span=='label') $(this).parent('div').children('.badge').children('input').prop('checked', true).parent('.badge').addClass('sec').addClass('badge-success');
}
}).css('cursor','pointer').css('user-select','none');
if(span=='label') $('.'+span).not('.yeni-label').css('padding','10px').css('margin-bottom','10px');
if(span=='badge') $('.'+span).tooltip();
$('.'+span+' input').change(function(){
var secili = $(this).parents('.'+span).hasClass('sec');
if(secili==true){
$(this).parents('.'+span).addClass(span+'-success').addClass('sec');
$(this).prop('checked', true);
}else{
$(this).parents('.'+span).removeClass(span+'-success').removeClass('sec');
$(this).prop('checked', false);
}
}).change();
}
isaretle('badge');
isaretle('label');
</script>
<?php elseif($sayfa=='yetki'&&yetkiVarmi('u_yetki')):?>
<div class="blok">
  <div class="blok-ust">Yetki
  <button class="btn btn-success btn-mini pull-right" onclick="$('#sayfa').html('<div style=&quot;text-align:center&quot;><img src=&quot;img/yukle.gif&quot; alt=&quot;bekleyiniz...&quot;> Haz�rlan�yor...</div>').load('<?php echo basename($_SERVER['REQUEST_URI']);?>');"><i class="icon-refresh icon-white"></i></button></div>
  <div class="blok-icerik" style="height:800px">
  <div class="tabbable span12 tabs-left">
		<ul class="nav nav-tabs" style="height:800px">
		<?php $yetkiler = $baglanti->query("SELECT id,isim FROM yetki") or die();
		while($yetki = $yetkiler->fetch_assoc()){
		echo '<li><a data-toggle="tab" data-id="'.$yetki['id'].'">'.$yetki['isim'].'</a></li>';
		};?>
		<li><a data-toggle="tab" data-id=""><span class="label yeni-label"><i class="icon-plus-sign"></i> Yeni Yetki</a></span></li>
	</ul>
	<div class="tab-content">
		<div id="yetki-div">
	<div class="alert alert-info">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <h4>Bilgilendirme</h4> Yan men�den yetkileri d�zenlemeye ba�layabilirsiniz. D�zenlemeye ba�lad�ktan sonra herhangi bir kutucu�un �zerine t�klayarak yetkilendirme i�lemi yapabilirsiniz. Kutucuk ye�il oldu�unda yetki verilmi� demektir. Yetkileri her g�ncelledi�inizde �yeler tablosundaki yetki s�tunu da g�ncellenmektedir. Yetki problemleri g�rd���n�z taktirde hi� bir de�i�iklik yapmadan kayd� yenilemeniz sorununuza ��z�m olabilir.<br>
	<b>Ayr�ca!</b> yetki verirken �ok dikkatli olun. Kendi yetkilerinizi s�n�rland�rd���n�zda veritaban�ndan el ile ayarlar� d�zeltmeniz gerekebilir.
    </div></div>
	</div><!-- /.tab-content -->
</div>
    </div>
</div>
<script>
$('.nav-tabs li a').click(function(){
var id = $(this).attr('data-id');
$('#yetki-div').html('<div style="text-align:center"><img src="img/yukle.gif" alt="bekleyiniz..."> Haz�rlan�yor...</div>')
$('#yetki-div').load('uye.php?sayfa=yetki-form&id='+id);
});

$('.nav-tabs').css('cursor','default').css('user-select','none');</script>
<?php endif;?>