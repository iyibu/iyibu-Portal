{if #orta-blok1[toplam]# == 0}
Pek blok yok gibi (orta-blok1)
{/if}
{for $i=1 to #orta-blok1[toplam]#}
{if "#orta-blok1[tip][#i#]#" == "salt"}
#orta-blok1[icerik][#i#]#
<br>
{else}
<div class="blok">
<div class="row-fluid"><div class="span12 blok-ust">
#orta-blok1[baslik][#i#]# <img src="_resimler/minus.gif" class="pull-right ackapa kapali">
</div></div><div class="row-fluid"><div class="span12 blok-orta">
#orta-blok1[icerik][#i#]#
</div></div></div>
{/if}
{/for}