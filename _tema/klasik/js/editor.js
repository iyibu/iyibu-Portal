function editor(){
var baseurl = $('base').attr('href');
tinymce.init({
        selector: "textarea",
		content_css : "iyibu.css,_css/editor.css",
		document_base_url: baseurl,
		language : 'tr_TR',
        plugins: [
                "advlist autolink autosave link image lists charmap print preview hr anchor pagebreak spellchecker",
                "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                "table contextmenu directionality emoticons template textcolor paste fullpage textcolor"
        ],

        toolbar1: "bold italic underline strikethrough removeformat | alignleft aligncenter alignright alignjustify | link image media",
        menubar: false,
		force_br_newlines : true,
		force_p_newlines : false,
		forced_root_block : '',
		entities: '160,nbsp,38,amp,34,quot,162,cent,8364,euro,163,pound,165,yen,169,copy,174,reg,8482,trade,8240,permil,60,lt,62,gt,8804,le,8805,ge,176,deg,8722,minus,35',
		remove_linebreaks : true,
		cleanup: true,
		apply_source_formatting: true,
		protect: [ /\n/g],
});}