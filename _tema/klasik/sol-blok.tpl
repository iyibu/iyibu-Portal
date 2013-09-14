{if #sol-blok[toplam]# == 0}
Pek blok yok gibi (sol-blok)
{/if}
{for $i=1 to #sol-blok[toplam]#}
{if "#sol-blok[tip][#i#]#" == "salt"}
#sol-blok[icerik][#i#]#
{else}
<div class="blok">
<div class="row-fluid"><div class="span12 blok-ust">
#sol-blok[baslik][#i#]# <img src="_resimler/minus.gif" class="pull-right ackapa kapali">
</div></div><div class="row-fluid"><div class="span12 blok-orta">
#sol-blok[icerik][#i#]#
</div></div></div>
{/if}
{/for}