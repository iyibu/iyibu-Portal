function uye_giris(){ 
	$.iyibuKutu('show', {
	duration    : 0,
	closeKey        : true,
    closeOverlay    : true,
    icerik : '<h3>�yelik Giri�i</h3>'
				+ '<form id="giris" name="giris" action="javascript:uyeGiris()" method="post">'
                +     '<input name="kadi" placeholder="Kullan�c� Ad�" type="text" style="width: 95%">'
                +     '<input name="sifre" placeholder="�ifre" type="password" style="width: 95%">'
                + '<input border="0" src="_tema/klasik/img/power.png" align="right"  type="image">'
                + '<br><div id="uye-islem" style="width: 200px;word-break:break-all;"><br></div>'
                + '<p><a href="#">�ifremi Unuttum</a> | <a href="javascript:yeniuye()">Yeni �yelik</a></p></form>',
    position    : 'center',
    genislik: '350px',
    yukseklik: '225px',
    simge: 'user',
});}

function uyeGiris(){
$('#uye-islem').html('<div style="text-align:center"><img src="_tema/klasik/img/yukle.gif" alt="bekleyiniz..."> Haz�rlan�yor...</div>');
$('#giris p:first').remove();
$.ajax({
	type: 'POST',
	data: $('#giris').serialize(),
	url: '_ajax/uyegiris.php',
	success: function(ajaxcevap){	
		if(ajaxcevap == 'hata1'){
			$('#uye-islem').html('<span class="label label-warning">Bir yanl��l�k var gibi</span>');
		}else if(ajaxcevap == 'hata2'){
			$('#uye-islem').html('<span class="label label-important">Ba�lant� problemi</span>');
		}else if(ajaxcevap == 'hata3'){
			$('#uye-islem').html('<span class="label label-important">Kullan�c� Ad�/�ifre hatal� gibi</span>');
		}else if(ajaxcevap == 'hata4'){
			$('#uye-islem').html('<span class="label label-important">�yeli�iniz onaylanmam��</span><br><span class="label label-info">L�tfen posta adresinizi kontrol edin</span>');
		}else if(ajaxcevap == 'hata5'){
			$('#uye-islem').html('<span class="label label-important">Eri�im izniniz ENGELLENM��</span><br><span class="label label-info">L�tfen Y�neticiyle irtibata ge�in</span>');
		}else if(ajaxcevap == 'Ok'){
			var kadi = $('#giris input:first').val();
			$('#uye-islem').html('<span class="label label-success">Ho�geldin '+kadi+', y�nlendiriliyorsun</span>');
			setTimeout("location.reload(true);",2000);
		}else{
		$('#uye-islem').html('<span class="label label-important">Tan�mlanamayan bir hata</span><br><span class="label label-info">L�tfen Y�neticiyle irtibata ge�in</span>');
		}
 }
 });
}

	function yeniuye(){ 
	$.iyibuKutu('show', {
	duration    : 0,
	closeKey        : true,
    closeOverlay    : true,
    icerik : '<h3>�yelik Kayd�</h3>'
				+ '<form id="yeniuye" name="yeniuye"  action="javascript:uyeKayit();" method="post">'
				+ '<input name="kadi" placeholder="Kullan�c� Ad�" type="text" style="width: 92%">'
				+ '<p><input name="parola" placeholder="�ifre" type="password" style="width: 44%;margin-right:5px">'
				+ '<input name="parola2" placeholder="�ifre Tekrar" type="password" style="width: 44%"></p>'
				+ '<p>Kullan�c� Bilgileri</p><input name="posta" placeholder="E-Posta Adresi" type="text" style="width: 92%">'
				+ '<input name="ad" placeholder="Ad" type="text" style="width: 44%;margin-right:5px">'
				+ '<input name="soyad" placeholder="Soyad" type="text" style="width: 44%">'
				+ '<input name="Web" placeholder="Web Site" type="text" style="width: 92%">'
				+ '<table width="100%"><tr><td style="width:46%;padding:0px;">Do�um Tarihi:</td><td>Memleket:</td></tr></table>'
				+ '<div class="input-append date">'
				+ '<input type="text" id="dogum" name="dogum" style="width:160px" placeholder="03.05.1996"><span class="add-on"><i class="icon-th"></i></span></div>'
				+ '<input name="memleket" placeholder="Memleket" type="text" style="width: 200px;margin-right:22px;" class="pull-right">'
				+ '<input name="is" placeholder="Meslek" type="text" style="width: 92%">'
				+ '<textarea rows="9" name="imza" placeholder="�mza" style="width: 92%; height: 100px"></textarea>'
				+ '<input border="0" src="_resimler/bos.png" align="right"  type="image">'
				+ '<button class="btn btn-danger pull-right" style="margin-left:5px;margin-right:22px" onclick="$.iyibuKutu(\'hide\')">�ptal</button> <button class="btn pull-right" type="submit">�yelik i�lemimi ger�ekle�tir</button></form>'
				+ '<br><div id="uye-islem" class="clearfix"></div>',
    position    : 'center',
    genislik: '550px',
    yukseklik: '645px',
    simge: 'user',
	afterShow: function(){
	$('.input-append.date').datepicker({
    format: "dd.mm.yyyy",
    startView: 2,
    todayBtn: false,
    language: "tr",
    forceParse: false,
    autoclose: true,
	endDate: '31.12.1999'
    });
	},
}).fadeIn("slow");	
}

function uyeKayit(){
$('#uye-islem').html('<div style="text-align:center"><img src="_tema/klasik/img/yukle.gif" alt="bekleyiniz..."> Haz�rlan�yor...</div>');
$.ajax({
	type: 'POST',
	data: $('#yeniuye').serialize(),
	url: '_ajax/uyekayit.php',
	success: function(ajaxcevap){	
		if(ajaxcevap == 'hata0'){
			$('#uye-islem').html('<span class="label label-warning">Eksik alanlar var</span>');
		}else if(ajaxcevap == 'hata1'){
			$('#uye-islem').html('<span class="label label-important">Parolalar e�le�miyor</span>');
		}else if(ajaxcevap == 'hata2'){
			$('#uye-islem').html('<span class="label label-important">Ge�ersiz kullan�c� ad�</span>');
		}else if(ajaxcevap == 'hata3'){
			$('#uye-islem').html('<span class="label label-important">Ge�ersiz E-Posta</span>');
		}else if(ajaxcevap == 'hata4'){
			$('#uye-islem').html('<span class="label label-important">B�yle bir kullan�c� zaten var</span>');
		}else if(ajaxcevap == 'hata5'){
			$('#uye-islem').html('<span class="label label-important">Ba�lant� problemi</span>');
		}else if(ajaxcevap == 'hata6'){
		$('#uye-islem').html('<span class="label label-important">Sunucu e-posta g�nderirken bir hatayla kar��la�t�</span><br><span class="label label-info">L�tfen Y�neticiyle irtibata ge�in, aksi takdirde �yeli�iniz onaylanmayacak</span>');
		}else if(ajaxcevap == 'Ok'){
			var kadi = $('#yeniuye input:first').val();
			$('#uye-islem').html('<span class="label label-success">E-Posta adresine girip onaylamak kald� '+kadi+', y�nlendiriliyorsun</span>');
			setTimeout("location.reload(true);",2000);
		}else{
		$('#uye-islem').html('<span class="label label-important">Tan�mlanamayan bir hata</span><br><span class="label label-info">L�tfen Y�neticiyle irtibata ge�in</span>');
		}
 }
 });
}