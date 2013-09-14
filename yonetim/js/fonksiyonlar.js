$(document).ready(function() {
var solmenu = $(window).height()-41;
$('#sol-menu').css('left','0').css('position','fixed').css('height',solmenu);

$('body').click(function() {
$('#sol-menu-sub .sol-menu').slideUp();}
);

$('#sol-menu ul li').click(function() {
var sira = $(this).index();
$('#sol-menu-sub .sol-menu').not('#sol-menu-sub .sol-menu:eq('+sira+')').slideUp();
$('#sol-menu-sub .sol-menu:eq('+sira+')').slideToggle();
return false;
});

$('#sol-menu-sub ul li').click(function() {
var sira = $(this).index();
var ustsira = $(this).parents("ul").index();
var menu = $(this).attr('ustmenu');
var aktif = $(this).attr('aktif');
var sayfa = $(this).attr('sayfa');
var durum = $(this).attr('durum');
$('.sol-menu li').not('#sol-menu-sub .sol-menu li:eq('+sira+')').attr('durum','no');
$('.sol-menu li').not('#sol-menu-sub .sol-menu li:eq('+sira+')').not('#sol-menu .sol-menu li:eq('+ustsira+')').removeClass("active");
if(durum!=='ok'){
if(typeof menu!='undefined'){
$('#menu').html('<div style="text-align:center"><img src="img/yukle.gif" alt="bekleyiniz..."> Hazýrlanýyor...</div>');
$('#menu').load(menu, function(){
$(aktif).addClass('active');});
}
if(typeof sayfa!='undefined'){
$(this).addClass("active");
$('#sol-menu .sol-menu li:eq('+ustsira+')').addClass("active");
$('#sayfa').html('<div style="text-align:center"><img src="img/yukle.gif" alt="bekleyiniz..."> Hazýrlanýyor...</div>');
$('#sayfa').load(sayfa, function(data){
setTimeout("$('#sol-menu-sub .sol-menu').slideUp()",700);
});
$(this).attr('durum','ok');
$("html, body").animate({scrollTop:0},"slow");
}
}
return false;
});

$(window).resize(function () {
var solmenu = $(window).height()-41;
$('#sol-menu').css('position','fixed').css('height',solmenu);
});
});

function sec(id){
$('#sol-menu li').removeClass("active");
$(id).addClass("active");
}

function menusec(id){
$('ul.nav li').removeClass("active");
$(id).addClass("active");
if(id.indexOf('m_link')== -1){
$('#sol-menu-sub ul li').removeClass("active");
$( "li[aktif='"+id+"']" ).addClass("active");
}
var menu = $(id).attr('ustmenu');
var sayfa = $(id).attr('sayfa');
var durum = $(id).attr('durum');
if(durum!=='ok'){
if(typeof menu!='undefined'){
$('#menu').html('<div style="text-align:center"><img src="img/yukle.gif" alt="bekleyiniz..."> Hazýrlanýyor...</div>');
$('#menu').load(menu);
}
if(typeof sayfa!='undefined'){
$('#sayfa').html('<div style="text-align:center"><img src="img/yukle.gif" alt="bekleyiniz..."> Hazýrlanýyor...</div>');
$('#sayfa').load(sayfa);
$(this).attr('durum','ok');
}
}
}

function editor(select){
var baseurl = $('#sayfa').attr('adres');
tinymce.init({
    selector: select,
    theme: "modern",
	content_css : "iyibu.css,_css/editor.css",
	document_base_url: baseurl,
    plugins: [
        "advlist autolink lists link image charmap print preview hr anchor pagebreak",
        "searchreplace wordcount visualblocks visualchars code fullscreen",
        "insertdatetime media nonbreaking save table contextmenu directionality",
        "emoticons template paste textcolor kod iyibukod"
    ],
    toolbar1: "bold italic underline | alignleft aligncenter alignright alignjustify | styleselect | insertfile undo redo | newdocument print preview | inserttime | link image media kod iyibukod hr | bullist numlist outdent indent  | forecolor backcolor emoticons | code fullscreen",
    image_advtab: true,
    language : 'tr_TR',
	extended_valid_elements : "script[src|type|language]",
	force_br_newlines : true,
    force_p_newlines : false,
    forced_root_block : '',
	entities: '160,nbsp,38,amp,34,quot,162,cent,8364,euro,163,pound,165,yen,169,copy,174,reg,8482,trade,8240,permil,60,lt,62,gt,8804,le,8805,ge,176,deg,8722,minus,35',
	apply_source_formatting: true,
	protect: [	/<iyibukod>/g, /<\/iyibukod>/],
	setup: function(editor) {
        editor.on('ObjectSelected', function(e) {
            console.log('ObjectSelected event', e);
        });
    }
});
}

function onaysizla(){
$('.onayli').hover(
function () {$(this).removeClass("badge-success");
			$(this).children('i').removeClass("icon-ok");
			$(this).children('i').addClass("icon-ban-circle");},
function () {if($(this).hasClass('onaysiz') == true){return false};
			$(this).addClass("badge-success");
			$(this).children('i').addClass("icon-ok");
			$(this).children('i').removeClass("icon-ban-circle");});
$('.onayli').click(function(){
if($(this).hasClass('onaysiz') == true){return false};
var id = $(this).attr('data-id');
$('#islem').load('modul-islem.php?sayfa=icerik-onay-kaldir&id='+id);
$(this).removeClass('onayli').addClass('onaysiz');
onayla1();
});
$('.onaysiz').attr('data-original-title','Onayla').tooltip('fixTitle');
$('.onayli').attr('data-original-title','Onayý Kaldýr').tooltip('fixTitle');
}

function onayla1(){		
$('.onaysiz').hover(
function () {$(this).addClass("badge-success");
			$(this).children('i').addClass("icon-ok");
			$(this).children('i').removeClass("icon-ban-circle");},
function () {if($(this).hasClass('onayli') == true){return false};
			$(this).removeClass("badge-success");
			$(this).children('i').removeClass("icon-ok");
			$(this).children('i').addClass("icon-ban-circle");});
$('.onaysiz').click(function(){
if($(this).hasClass('onayli') == true){return false};
var id = $(this).attr('data-id');
$('#islem').load('modul-islem.php?sayfa=icerik-onayla&id='+id);
$(this).addClass('onayli').removeClass('onaysiz');
onaysizla();
});

$('.taslak').click(function(){
if($(this).hasClass('onayli') == true){return false};
var id = $(this).attr('data-id');
$('#islem').load('modul-islem.php?sayfa=icerik-onayla&id='+id);
$(this).addClass('onayli').removeClass('taslak').removeClass('badge-warning');
onaysizla();
});

$('.onaysiz').attr('data-original-title','Onayla').tooltip();
$('.onayli').attr('data-original-title','Onayý Kaldýr').tooltip('fixTitle');
}

function onayla2(){
$('.taslak').hover(
function () {$(this).addClass("badge-success");
			$(this).children('i').addClass("icon-ok");
			$(this).children('i').removeClass("icon-file");},
function () {if($(this).hasClass('onayli') == true){return false};
			$(this).removeClass("badge-success");
			$(this).children('i').removeClass("icon-ok");
			$(this).children('i').addClass("icon-file");});
}

 var entityMap = {
    "&": "&amp;",
    "<": "&lt;",
    ">": "&gt;",
    '"': '&quot;',
    "'": '&#39;',
    "/": '&#x2F;',
	'\n' : '<br>'
  };

  function escapeHtml(string) {
    return String(string).replace(/[&<>"'\/]/g, function (s) {
      return entityMap[s];
    });
  }
  function iyibuSwitch(){
  	var ekle = '<div class="btn-group iyibuSwitch-ekle">'
				+'<button id="acik" type="button" class="btn acik">Açýk</button>'
				+'<button id="kapali" type="button" class="btn kapali">Kapalý</button>'
				+'</div>';
	$("input.iyibuSwitch").after(ekle);
	$("input.iyibuSwitch").hide();
	
	$("input.iyibuSwitch").change(function() {
	var acik = $(this).attr('data-acik');
	var kapali = $(this).attr('data-kapali');
	$(this).next('.iyibuSwitch-ekle:first').children('.acik').text(acik);
	$(this).next('.iyibuSwitch-ekle:first').children('.kapali').text(kapali);
	if($(this).is(':checked')==true){
	$(this).next('.iyibuSwitch-ekle:first').children('.acik').addClass('btn-primary');
	$(this).next('.iyibuSwitch-ekle:first').children('.kapali').removeClass('btn-primary');
	}else{
	$(this).next('.iyibuSwitch-ekle:first').children('.kapali').addClass('btn-primary');
	$(this).next('.iyibuSwitch-ekle:first').children('.acik').removeClass('btn-primary');
	}
	}).change();
	
	$(".iyibuSwitch-ekle .acik").click(function(){
	$(this).parent('.iyibuSwitch-ekle').prev().prop('checked', true).change();
	});
	
	$(".iyibuSwitch-ekle .kapali").click(function(){
	$(this).parent('.iyibuSwitch-ekle').prev().prop('checked', false).change();
	});
  }