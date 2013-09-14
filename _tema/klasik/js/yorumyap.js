function yorumYaz(modul,icerik,alt){ 
	$.iyibuKutu('show', {
	duration    : 0,
	closeKey        : true,
    closeOverlay    : true,
    icerik : '<h3>Ýçerikle Ýlgili Yorumda Bulun</h3>'
				+ '<form id="yorum-yap" name="yorum-yap" action="javascript:yorumYap()" method="post">'
                + '<textarea name="yorum" style="height:150px; width:435px;"></textarea>'
				+ '<input name="modul" type="hidden" value="'+modul+'">'
				+ '<input name="icerik" type="hidden" value="'+icerik+'">'
				+ '<input name="alt" type="hidden" value"'+alt+'">'
				+ '<br><p class="pull-left"><div id="yorum-islem" class="pull-left"><span class="label">Unutmayýn! Yorumunuz onaylandýktan sonra yayýnlancak</span></div>'
                + '<button type="submit" class="btn btn-info pull-right">Gönder</button></p></form>',
    position    : 'center',
    genislik: '550px',
    yukseklik: '400px',
	simge: 'bos'
});
editor();}

function yorumYap(){
$('#yorum-islem').html('<div class="pull-left" style="text-align:center"><img src="_tema/klasik/img/yukle.gif" alt="bekleyiniz..."> Hazýrlanýyor...</div>');
$.ajax({
	type: 'POST',
	data: $('#yorum-yap').serialize(),
	url: '_ajax/yorumyap.php',
	success: function(ajaxcevap){	
		if(ajaxcevap == 'hata1'){
			$('#yorum-islem').html('<span class="label label-warning pull-left">Yorum Ekleyebilmek Ýçin Giriþ Yapmalýsýnýz</span>');
		}else if(ajaxcevap == 'hata2'){
			$('#yorum-islem').html('<span class="label label-warning pull-left">Boþ býraktýðýnýz alanlar var</span>');
		}else if(ajaxcevap == 'hata3'){
			$('#yorum-islem').html('<span class="label label-important pull-left">Baðlantý hatasý</span>');
		}else if(ajaxcevap == 'Ok'){
			var kadi = $('#giris input:first').val();
			$('#yorum-islem').html('<span class="label label-success pull-left">Yorumunuz baþarýyla kaydedildi!</span>');
			setTimeout("location.reload(true);",2000);
		}
 }
 });
}