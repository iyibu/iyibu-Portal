<!DOCTYPE html>
<html>
<head>
<title>#sayfa_baslik# - #site[baslik]#</title>
<base href="#site[adres]#/">
<meta charset="iso-8859-9">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-9">
<meta http-equiv="Content-Language" content="tr">
<meta http-equiv="X-UA-Compatible" content="ie10" />
<meta name="keywords" content="#anahtar_kelime#">
<meta name="description" content="#meta_aciklama#">
<link href="iyibu.css" rel="stylesheet" type="text/css">
<link rel="shortcut icon" href="_tema/klasik/img/favicon.ico" />
</head>
<body onload="prettyPrint()">
<div class="container" style="width:96%; min-width:800px; max-width:1280px;">
<div class="row-fluid">
  <div class="ust span12">
  <div class="logo"><a href="#site[adres]#"><img src="_resimler/bos.png" class="c1" alt="#site[baslik]#"></a></div>
<div class="ustpanel">
{if #uye_giris# == 1}
<div align="left" class="uyegiris">Hoşgeldin <b>#kullanici#</b>,<div class="pull-right"><a href="cikis.php">Çıkış Yap</a></div></div>
<br>
{else}
<a onclick="yeniuye()" href="javascript:void(0)"><img class="c2" src="_tema/klasik/img/uyeol.png" alt="Üye Ol!"></a>
<a onclick="uye_giris()" href="javascript:void(0)"><img class="c3" src="_tema/klasik/img/10.png" alt="Giriş Yap"></a>
{/if}
</div>
  </div>
</div>
<div class="row-fluid">
  <div class="ustmenu span12">
  <ul id="menu">
  {for $i=0 to #menu[toplam]#-1}
  <li><img style="width:16px;height:16px;" src="#menu[resim][#i#]#" onerror="$(this).remove()" alt="#menu[isim][#i#]#"><a href="#menu[link][#i#]#">#menu[isim][#i#]#</a></li>
  {/for}
  </ul>
  </div>
</div>