<?php header('Content-Type: text/html; charset=iso-8859-9');
require(__DIR__ . '/../baglanti.php');
require(__DIR__ . '/../_inc/fonksiyonlar.php');
if($_SESSION['yonetici']==false&&yetkiVarmi('s_bynt')){header('Location: giris.php');
die();};
$sayfa = @$_GET['sayfa'];
if($sayfa == "blok-sirala"):
$yer = array_keys($_POST);
$yer = $yer[0];
echo 'Sýralandý: ';
foreach($_POST[$yer] as $sira => $id){
$sira++;
echo ($id).'=>'.$sira.', ';
$baglanti->query("UPDATE modulblok SET sira=$sira where id = $id");}
elseif($sayfa == "blok-ekle"):
?>
<select id="tum_bloklar" name="bisim" class="select2" style="min-width:250px;" placeholder="turan">
    <?php
	$divler = '';
if ($handle = opendir('../_tema/'.$site_tema.'/bloklar/')) {
    while (false !== ($entry = readdir($handle))) {
        if (strpos($entry,'.xml')) {
            $adres = '../_tema/'.$site_tema.'/bloklar/'.$entry;
			$blok_al = simplexml_load_file($adres);
			echo '<option value="'.$entry.'">'.trKarakter($blok_al->baslik).'</option>';
			$divler .= '<div id="'.$entry.'" class="divler" style="display:none">';
			foreach(explode('|',$blok_al->ek_deger) as $ek_deger){
			$ek_deger_ayýr = explode('->',$ek_deger);
			$tip = rtrim($ek_deger_ayýr[2]);
			$açýklama = $ek_deger_ayýr[1];
			$deðer = ltrim($ek_deger_ayýr[0]);
			if($tip=='input'){
			$divler .= '<br><input name="d_'.$deðer.'" type="text" placeholder="'.trKarakter($açýklama).'" style="min-width:235px;" disabled>';
			}if($tip=='modul'){
			$divler .= '<br><select class="select2" name="d_'.$deðer.'" placeholder="'.trKarakter($açýklama).'" style="min-width:250px;margin-bottom:20px" disabled>';
			$moduller = $baglanti->query('SELECT baslik,seo FROM modul');
			while($m = $moduller->fetch_assoc()){
			$divler .= '<option value="'.$m['seo'].'">'.$m['baslik'].'</option>';
			}
			$moduller->close();
			$divler .= '</select>';
			}
			}
			$divler.='<br>* '.trKarakter($blok_al->aciklama).'</div>';
        }
    }
    closedir($handle);
}
echo '</select><hr style="margin:5px;">'.$divler;
?>
<script>$('select.select2').select2();
$('#tum_bloklar').change(function(){
var id = $(this).val();
id = id.replace(".","\\.");
$('.divler').hide();
$('.divler input,.divler select').attr('disabled','disabled');
$('#'+id).show();
$('#'+id+' input,#'+id+' select').removeAttr('disabled');
$('select.select2').select2();
}).change();
</script>
<?php elseif($sayfa == "blok-kaydet"):
$bisim = trKarakter($_POST['bisim']);
$sira = trKarakter($_POST['sira']);
$alt = trKarakter($_POST['alt']);
$tema = trKarakter($_POST['tema']);
$yer = trKarakter($_POST['yer']);
$modul = trKarakter($_POST['modul']);
foreach($_POST as $key =>$ek){
if(strpos($key,'d_')!==false) $fdeger[] = trKarakter($ek);
}
$fdeger = @implode('|',$fdeger);
$baglanti->query("INSERT INTO modulblok (bisim,sira,modul,tema,alt,yer,fdeger) VALUES ('$bisim',$sira,'$modul','$tema','$alt','$yer','$fdeger')") or die('Bir hata oluþtu!');?>
<script>$('#listele-<?php echo $yer?>').append('<li id="<?php echo $yer?>_<?php echo $baglanti->insert_id?>" class="gorsel-alt"><?php echo $bisim?><i class="icon-trash pull-right" data-sil="<?php echo $yer?>_<?php echo $baglanti->insert_id?>" data-id="<?php echo $baglanti->insert_id?>"></i></li>');
$(".gorsel-alt i").click(function(){
var id = $(this).attr('data-id');
var silinecek = $(this).attr('data-sil');
var icerik = '<hr><a class="btn btn-danger" onclick="silgitsin(\'#'+silinecek+'\',\''+id+'\')"><i class="icon-ok icon-white"></i> Sil gitsin</a> <a class="btn ekle" onclick="popKapat2(\'#'+silinecek+' i\')"><i class="icon-remove"></i> Kalsýn</a>';
$(this).popover({ 
title: 'Bu bloðu kaldýr', content: 'Emin misiniz?'+icerik, html:true, placement: 'top' });
})</script>
<?php elseif($sayfa == "blok-sil"):
$baglanti->query("DELETE from modulblok where id = ".$_GET['id']) or die('Bir hata oluþtu!');
endif?>