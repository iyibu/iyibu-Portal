#girdi anahtar_kelime = '#modul[kelime]#'#
#girdi meta_aciklama = '#modul[aciklama]#'#
{include ust.tpl}
<div id="iskelet">

{if '#modul[blok_tip]#' == 'cift_blok'}
<div id="orta">
{elseif '#modul[blok_tip]#' == 'sag_blok'}
<div id="orta-sag">
{elseif '#modul[blok_tip]#' == 'sol_blok'}
<div id="orta-sol">
{else}
<div id="orta-tek">
{/if}

{include orta-blok1.tpl}</div>
</div>
{if '#modul[blok_tip]#' == 'cift_blok'}
<div id="sol">{include sol-blok.tpl}</div>
<div id="sag">{include sag-blok.tpl}</div>
{elseif '#modul[blok_tip]#' == 'sag_blok'}
<div id="sag">{include sag-blok.tpl}</div>
{elseif '#modul[blok_tip]#' == 'sol_blok'}
<div id="sol">{include sol-blok.tpl}</div>
{/if}
{include alt.tpl}