/**
 * Select2 Turkish translation.
 * 
 * Author: Salim KAYABA�I <salim.kayabasi@gmail.com>
 */
(function ($) {
    "use strict";

    $.extend($.fn.select2.defaults, {
        formatNoMatches: function () { return "Sonu� bulunamad�"; },
        formatInputTooShort: function (input, min) { var n = min - input.length; return "En az " + n + " karakter daha girmelisiniz"; },
        formatInputTooLong: function (input, max) { var n = input.length - max; return n + " karakter azaltmal�s�n�z"; },
        formatSelectionTooBig: function (limit) { return "Sadece " + limit + " se�im yapabilirsiniz"; },
        formatLoadMore: function (pageNumber) { return "Daha fazla..."; },
        formatSearching: function () { return "Aran�yor..."; }
    });
})(jQuery);
