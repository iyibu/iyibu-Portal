<?php
if (version_compare(PHP_VERSION, '5.3.1', '<'))
{
	die('iyibu!Portalý çalýþtýrabilmek için PHP 5.3.1 veya üst versiyonuna sahip olmalýsýnýz...');
}
class iyibu_TEMA { 
   public $iyibu;
   protected $girdiler = array();
   protected $girdiler1 = array();
   protected $diziler = array();
   protected $diziler1 = array();
   protected $diziler2 = array();
   protected $kodlar = array();
   public $dizin = null;
   public $dosya_yolu = null;
    
   function strposa($haystack, $needle) {
     if (is_array($needle)) {
         foreach ($needle as $need) {
               if (strpos($haystack, $need) !== false) {
                       return true;
               }
         }
     }else {
          if (strpos($haystack, $need) !== false) {
                       return true;
          }
     }

     return false;
}
   function kaynak($filepath) { 
      $this->iyibu .= file_get_contents($this->dizin.$filepath); 
	  $this->dosya_yolu = $filepath; 
   } 
   
   function girdi($deðer, $içerik) {
      $this->girdiler[$deðer] = $içerik;
	  $this->girdiler1[] = '#'.$deðer.'#';
   }
   
   function diziden_girdiye($dizi) {
   $dizim = 'array(';
   if(!empty($dizi)){
   foreach ($dizi as $key => $girdi) {
			if (is_array($girdi)){
			$dizim = $dizim.$this->diziden_girdiye($girdi).',';
			}else{
				if (is_numeric($girdi)){
				if(!is_numeric($key)) $key = "'".$key."'";
				$dizim = $dizim.$key."=>".$girdi.',';
				}else{
				if(!is_numeric($key)) $key = "'".$key."'";
				$dizim = $dizim.$key."=>"."'".$girdi."',";
				}
			}
			
   }
   $dizim = substr($dizim, 0, -1);
   }
   return $dizim.')';
   }
   
   function dizi($deðer, $içerik) {
   $this->dilÇevir_noscript();
   if(is_array($içerik)){
	$this->girdi($deðer,$this->diziden_girdiye($içerik));
	$this->diziler[$deðer] = $içerik;
	$this->diziler1[] = $deðer;
			foreach ($this->diziler as $deðer => $içerik) {
			if (is_array($içerik)) {
				foreach ($içerik as $deðer2 => $içerik2) {
				if (is_array($içerik2)) {
				foreach ($içerik2 as $deðer3 => $içerik3) {
					$this->diziler2[] = "#$deðer"."[$deðer2]"."[$deðer3]#";
				}
				}else {
				$this->diziler2[] = "#$deðer"."[$deðer2]#";
				}
				}
			}else {
				$this->diziler2[] = $deðer;
			}
		}
		}else{die("Bu bir dizi deðil <br>'$deðer' ; <br>'$içerik'");}
		$this->dilÇevir_noscript();
	}

   function deðiþtir(){
   $this->dilÇevir_noscript();
   foreach ($this->girdiler as $deðer => $içerik) {
            	$tagToReplace = "#$deðer#";
            	$this->iyibu = str_replace($tagToReplace, $içerik, $this->iyibu);
    };
	if($this->strposa($this->iyibu, $this->girdiler1));
	
	foreach ($this->diziler as $deðer1 => $içerik1) {
				foreach ($this->diziler[$deðer1] as $deðer2 => $içerik2) {
				if(is_array($this->diziler[$deðer1][$deðer2]))
				{
				foreach ($this->diziler[$deðer1][$deðer2] as $deðer3 => $içerik3) {
				$tagToReplace = "#$deðer1"."[$deðer2]"."[$deðer3]#";
				$this->diziler1[$deðer1][$deðer2][$deðer3] = "#$deðer1"."[$deðer2]"."[$deðer3]#";
            	$this->iyibu = str_replace($tagToReplace, $içerik3, $this->iyibu);
				};
				}
				else
				{
            	$tagToReplace = "#$deðer1"."[$deðer2]#";
            	$this->iyibu = str_replace($tagToReplace, $içerik2, $this->iyibu);
				$this->diziler1[$deðer1][$deðer2] = "#$deðer1"."[$deðer2]#";
				};
				};
    };
	if($this->strposa($this->iyibu, $this->diziler2)) $this->deðiþtir();
	}
	
	function dilÇevir_if(){
	$this->deðiþtir();
	$this->iyibu = preg_replace_callback(
    '/(?s){if (.*?) (==|!=|===|>|<|<=|>=|&&) (.*?)}/',
    function ($m) {
        return "<?php if(".phpSil($m[1])." $m[2] ".phpSil($m[3])."):?>";},
    $this->iyibu);
	$this->iyibu = preg_replace_callback(
    '/(?s){elseif (.*?) (==|!=|===|>|<|<=|>=|&&) (.*?)}/',
    function ($m) {
        return "<?php elseif(".phpSil($m[1])." $m[2] ".phpSil($m[3])."):?>";},
    $this->iyibu);
    $this->iyibu = str_replace('{else}', "<?php else:?>", $this->iyibu);
	$this->iyibu = str_replace('{/if}', "<?php endif;?>", $this->iyibu);
	$this->deðiþtir();
	}
	
	function dilÇevir_for(){
	$this->deðiþtir();
	preg_match_all('@{for \$(.*?)=(.*?) to (.*?)}@', $this->iyibu, $eþ);
	foreach ($eþ[1] as $eþleþme){
	$this->iyibu = str_replace("#$eþleþme#", "<?php echo $$eþleþme?>", $this->iyibu);
	}
	$this->iyibu = preg_replace_callback(
    '@{for \$(.*?)=(.*?) to (.*?)}@',
    function ($eþ) {
        return "<?php for ($".phpSil("$eþ[1]")."=$eþ[2]; $$eþ[1]<=".phpSil("$eþ[3]")."; $$eþ[1]++):?>";},
    $this->iyibu);
	$this->iyibu = str_replace('{/for}', "<?php endfor;?>", $this->iyibu);
	$this->deðiþtir();
	}
	
	function dilÇevir_foreach(){
	$this->deðiþtir();
	preg_match_all('@{foreach (.*?) as \$(.*?)}@', $this->iyibu, $eþ);
	foreach ($eþ[2] as $eþleþme){
	$this->iyibu = str_replace("#$eþleþme#", "<?php echo $$eþleþme?>", $this->iyibu);
	}
	$this->iyibu = preg_replace_callback(
    '@{foreach (.*?) as (.*?)}@',
    function ($eþ) {
        return "<?php foreach (".phpSil("$eþ[1]")." as ".phpSil("$eþ[2]")."):?>";},
    $this->iyibu);
	$this->iyibu = str_replace('{/foreach}', "<?php endforeach;?>", $this->iyibu);
	$this->deðiþtir();
	}
	
	function dilÇevir_deðiþken(){
	$this->deðiþtir();
	$this->iyibu = preg_replace_callback(
    '@\#(girdi|dizi) (.*?).=.(.*?)\#@',
    array($this,'dene'),
    $this->iyibu);
	$this->deðiþtir();
	}
	
	function dene($m)
	{
		eval("\$deðiþken_içi = ".phpSil($m[3]).";");
        $this->$m[1]("$m[2]",@$deðiþken_içi);
	}
	
	function dilÇevir_include(){
	$this->deðiþtir();
	preg_match_all("@{include (.*?)}@", $this->iyibu, $eþ);
	$includes = array();
	foreach ($eþ[1] as $key=>$eþleþme){
	$includes[] = $eþleþme;
	if ($eþleþme == $this->dosya_yolu) {
	echo "Hata: iç içe include edilemez: $this->dizin$eþleþme";
	die();
	}
	}
	foreach ($eþ[0] as $key=>$eþleþme){
	$inc_içerik = @file_get_contents($this->dizin.$includes[$key]);
	if($inc_içerik === FALSE) {
	echo "<br><b>Ýçerik okunamadý $this->dizin$includes[$key]</b>";
	die();}
	$this->iyibu = str_replace($eþleþme, $inc_içerik, $this->iyibu);
	}
	if(preg_match_all("@{include (.*?)}@", $this->iyibu, $eþ)) $this->dilÇevir_include();
	$this->deðiþtir();
	$this->dilÇevir();
	}
	
	function dilÇevir_fonksiyonlar(){
	$this->deðiþtir();
	$this->iyibu = preg_replace_callback(
    '@\[(array_count|son_içerikler|hit_içerikler|diziden_girdiye|kýsaDetay|nezaman)\((.*?)\)\]@',
	array($this,'fonksiyon_al'),
    $this->iyibu);
	$this->deðiþtir();
	}
	
	function fonksiyon_al($m){
	return "<?php echo $m[1]($m[2])?>";
	}
	
	function dilÇevir_noscript(){
	$this->iyibu = preg_replace_callback('@<iyibukod>(.*?)<\/iyibukod>@',array($this,'noscript'),$this->iyibu);
	}
	
	function noscript($m) {
	if(is_array($m)){
	$içerik = $m[1];
	}else{
	$içerik = $m;
	};
	$kilit = rndStr(4);
	$this->kodlar[$kilit] = $içerik;
	return '<<<'.$kilit.'>>>';
	}
	
	function dilÇevir_doscript(){
	foreach($this->kodlar as $k=>$kod){
	$this->iyibu = str_replace('<<<'.$k.'>>>', $kod, $this->iyibu);
	}
	}
	
	function dilÇevir(){
	$pattern = "(<\?(php)?(.*?)\?>)";
	$replacement = htmlentities("<?$1$2?>");
	$this->iyibu = preg_replace($pattern, $replacement, $this->iyibu);
	$pattern = "({yaz \'(.*?)\'})";
	$replacement = "<?echo \"$1\"?>";
	$this->iyibu = preg_replace($pattern, $replacement, $this->iyibu);
	}
	
	function html_sýkýþtýr($buffer) {
    $search = array(
        '/\>[^\S ]+/s',  // strip whitespaces after tags, except space
        '/[^\S ]+\</s',  // strip whitespaces before tags, except space
        '/(\s)+/s'       // shorten multiple whitespace sequences
    );
    $replace = array(
        '>',
        '<',
        '\\1'
    );
    $buffer = preg_replace($search, $replace, $buffer);
    return preg_replace(array('/<!--(.*)-->/Uis',"/[[:blank:]]+/"),array('',' '),str_replace(array("\n","\r","\t"),'',$buffer));
}

   function yayýnla() {
   global $site_gzip,$site_html_s;
    $this->dilÇevir_include();
	$this->dilÇevir();
	$this->dilÇevir_fonksiyonlar();
	$this->dilÇevir_for();
	$this->dilÇevir_foreach();
	$this->dilÇevir_deðiþken();
	ob_start();
	eval("?>".$this->iyibu);
	$this->iyibu = ob_get_contents();
	ob_end_clean();
	$this->dilÇevir_fonksiyonlar();
	$this->dilÇevir_deðiþken();
	$this->dilÇevir_if();
	$this->dilÇevir_for();
	$this->dilÇevir_foreach();
	ob_start();
	eval("?>".$this->iyibu);
	$this->iyibu = ob_get_contents();
	ob_end_clean();
	$this->dilÇevir_deðiþken();
	$this->dilÇevir_doscript();
	if($site_html_s==true) $this->iyibu = $this->html_sýkýþtýr($this->iyibu);
	if($site_gzip==true){
	if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) {
	ob_start("ob_gzhandler"); 
	}
	else {
	ob_start(); 
	}
	}
	eval("?>".$this->iyibu);
   } 
}
?>