#girdi anahtar_kelime = '#i�erik[etiket]#'#
#girdi meta_aciklama = '\'#modul[baslik]#\' b�l�m�nde \'#kategori[isim]#\' kategorisinde \'#i�erik[baslik]#\' ba�l�kl� yaz�y� okumak i�in t�klay�n!'#
{include ust.tpl}
<ul id="neredeyim" class="ustmenu">
  <li><div itemscope itemtype="http://data-vocabulary.org/Breadcrumb" class="pull-left">
	<a href="#site[adres]#/#modul[seo]#.html" itemprop="url">
	<img src="#modul[icon]#" style="margin-top:-3px" onerror="$(this).remove()">
    <span itemprop="title">#modul[baslik]#</span>
	</a> <span class="divider icon-arrow-right"></span>
	</div>
  </li>
  <li><div itemscope itemtype="http://data-vocabulary.org/Breadcrumb" class="pull-left">
	<a href="#site[adres]#/#modul[seo]#/#kategori[seo]#/" itemprop="url">
	<img src="#kategori[resim]#" style="margin-top:-3px" onerror="$(this).remove()">
    <span itemprop="title">#kategori[isim]#</span>
	</a> <span class="divider icon-arrow-right"></span>
	</div> 
  </li>
  <li class="active"><div itemscope itemtype="http://data-vocabulary.org/Breadcrumb" class="pull-left">
    <a href="#site[adres]#/#modul[seo]#/#i�erik[seo]#.html" itemprop="url">
    <span itemprop="title">#i�erik[baslik]#</span></a></div></li>
</ul>

 

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