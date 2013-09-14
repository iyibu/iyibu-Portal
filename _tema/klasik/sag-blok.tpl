{if #sag-blok[toplam]# == 0}
Pek blok yok gibi (sag-blok)
{/if}
{for $i=1 to #sag-blok[toplam]#}
{if "#sag-blok[tip][#i#]#" == "salt"}
#sag-blok[icerik][#i#]#
{else}
<div class="blok">
<div class="row-fluid"><div class="span12 blok-ust">
#sag-blok[baslik][#i#]# <img src="_resimler/minus.gif" class="pull-right ackapa kapali">
</div></div><div class="row-fluid"><div class="span12 blok-orta">
#sag-blok[icerik][#i#]#
</div></div></div>
{/if}
{/for}