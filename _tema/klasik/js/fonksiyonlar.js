function ajaxform(div,sayfa,type,form,okey,sonuc) {
$('#'+div+'').html('<div style="text-align:center"><img src="_tema/klasik/img/yukle.gif" alt="bekleyiniz..."> Yükleniyor...</div><br><br>');
$.ajax({
	type: ""+type+"",
	data: $('#'+form+'').serialize(),
	url: ""+sayfa+"",
	success: function(ajaxcevap){
		
 		if (ajaxcevap=="ok")
			{
			$('#'+div+'').html('<div style="text-align:center"><img src="_tema/klasik/img/yukle.gif" alt="bekleyiniz..."> Hazýrlanýyor...</div><br><br>');
			if (okey=="e")
			{
			$.iyibuKutu('hide');
			}
			else if (okey=="y") 
			{
			alert();
			}
			}
		else {$('#'+div+'').html(ajaxcevap+'<br><br><br>');}
		
 }
 });
};
function sayfa_yenile(){setTimeout("location.reload();",2300);};


$(".ackapa").click(function(){
var yazi = $(this).index('.blok .ackapa');
var hareket = $(this).parents('.blok').children('.row-fluid:eq(1)').slideToggle();
if($(this).hasClass('kapali')){
$(this).attr('src','_resimler/plus.gif');
$(this).removeClass('kapali').addClass('acik');
}else{
$(this).attr('src','_resimler/minus.gif');
$(this).addClass('kapali').removeClass('acik');
}
});

$('.yazi-boyut .btn').tooltip();

$('.yazi-boyut .yazi-buyut').click(function(){
var sec = $(this).parents('.blok').children('.row-fluid').children('.blok-orta');
var size = str_replace(sec.css('font-size'), 'px', '');
size = str_replace(size, 'pt', '');
if(size>26) return false;
sec.css('font-size',size+3+'pt');
sec.css('line-height','100%');
});

$('.yazi-boyut .yazi-kucut').click(function(){
var sec = $(this).parents('.blok').children('.row-fluid').children('.blok-orta');
var size = str_replace(sec.css('font-size'), 'px', '');
size = str_replace(size, 'pt', '');
if(size<10) return false;
sec.css('font-size',(size-3)+'px');
sec.css('line-height','100%');
});

$('.yazi-boyut .normal-yazi').click(function(){
var sec = $(this).parents('.blok').children('.row-fluid').children('.blok-orta');
sec.css('font-size','');
sec.css('line-height','');
});

function str_replace(haystack, needle, replacement) {
    var temp = haystack.split(needle);
    return temp.join(replacement);
}
$('.tip').tooltip();
function sayfala(div){
var gecerli = $(div).attr('gecerli');
var toplam = $(div).attr('toplam');
var sayfa = $(div).attr('sayfa');
var options = {
currentPage: gecerli,
totalPages: toplam,
alignment: 'center',
useBootstrapTooltip: true,
tooltipTitles: function (type, page, current) {
                    switch (type) {
                    case "first":
                        return "Ýlk Sayfa";
                    case "prev":
                        return "Önceki";
                    case "next":
                        return "Sonraki";
                    case "last":
                        return "Son Sayfa";
                    case "page":
                        return page+". sayfadasýnýz";
                    }
                },
pageUrl: function(type, page, current){
	return sayfa+page+'/'
}
}
$(div).bootstrapPaginator(options);
}
sayfala('#modulSayfa');
$('.modulSayfa').remove();
$('a[data-slide]').click();