function yorumYaz(modul,icerik,alt){ 
	$.iyibuKutu('show', {
	duration    : 0,
	closeKey        : true,
    closeOverlay    : true,
    icerik : '<h3>��erikle �lgili Yorumda Bulun</h3>'
				+ '<form id="yorum-yap" name="yorum-yap" action="javascript:yorumYap()" method="post">'
                + '<textarea name="yorum" style="height:150px; width:435px;"></textarea>'
				+ '<input name="modul" type="hidden" value="'+modul+'">'
				+ '<input name="icerik" type="hidden" value="'+icerik+'">'
				+ '<input name="alt" type="hidden" value"'+alt+'">'
				+ '<br><p class="pull-left"><div id="yorum-islem" class="pull-left"><span class="label">Unutmay�n! Yorumunuz onayland�ktan sonra yay�nlancak</span></div>'
                + '<button type="submit" class="btn btn-info pull-right">G�nder</button></p></form>',
    position    : 'center',
    genislik: '550px',
    yukseklik: '400px',
	simge: 'bos'
});
editor();}

function yorumYap(){
$('#yorum-islem').html('<div class="pull-left" style="text-align:center"><img src="_tema/klasik/img/yukle.gif" alt="bekleyiniz..."> Haz�rlan�yor...</div>');
$.ajax({
	type: 'POST',
	data: $('#yorum-yap').serialize(),
	url: '_ajax/yorumyap.php',
	success: function(ajaxcevap){	
		if(ajaxcevap == 'hata1'){
			$('#yorum-islem').html('<span class="label label-warning pull-left">Yorum Ekleyebilmek ��in Giri� Yapmal�s�n�z</span>');
		}else if(ajaxcevap == 'hata2'){
			$('#yorum-islem').html('<span class="label label-warning pull-left">Bo� b�rakt���n�z alanlar var</span>');
		}else if(ajaxcevap == 'hata3'){
			$('#yorum-islem').html('<span class="label label-important pull-left">Ba�lant� hatas�</span>');
		}else if(ajaxcevap == 'Ok'){
			var kadi = $('#giris input:first').val();
			$('#yorum-islem').html('<span class="label label-success pull-left">Yorumunuz ba�ar�yla kaydedildi!</span>');
			setTimeout("location.reload(true);",2000);
		}
 }
 });
}