<?php
if (version_compare(PHP_VERSION, '5.3.1', '<'))
{
	die('iyibu!Portal� �al��t�rabilmek i�in PHP 5.3.1 veya �st versiyonuna sahip olmal�s�n�z...');
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
   
   function girdi($de�er, $i�erik) {
      $this->girdiler[$de�er] = $i�erik;
	  $this->girdiler1[] = '#'.$de�er.'#';
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
   
   function dizi($de�er, $i�erik) {
   $this->dil�evir_noscript();
   if(is_array($i�erik)){
	$this->girdi($de�er,$this->diziden_girdiye($i�erik));
	$this->diziler[$de�er] = $i�erik;
	$this->diziler1[] = $de�er;
			foreach ($this->diziler as $de�er => $i�erik) {
			if (is_array($i�erik)) {
				foreach ($i�erik as $de�er2 => $i�erik2) {
				if (is_array($i�erik2)) {
				foreach ($i�erik2 as $de�er3 => $i�erik3) {
					$this->diziler2[] = "#$de�er"."[$de�er2]"."[$de�er3]#";
				}
				}else {
				$this->diziler2[] = "#$de�er"."[$de�er2]#";
				}
				}
			}else {
				$this->diziler2[] = $de�er;
			}
		}
		}else{die("Bu bir dizi de�il <br>'$de�er' ; <br>'$i�erik'");}
		$this->dil�evir_noscript();
	}

   function de�i�tir(){
   $this->dil�evir_noscript();
   foreach ($this->girdiler as $de�er => $i�erik) {
            	$tagToReplace = "#$de�er#";
            	$this->iyibu = str_replace($tagToReplace, $i�erik, $this->iyibu);
    };
	if($this->strposa($this->iyibu, $this->girdiler1));
	
	foreach ($this->diziler as $de�er1 => $i�erik1) {
				foreach ($this->diziler[$de�er1] as $de�er2 => $i�erik2) {
				if(is_array($this->diziler[$de�er1][$de�er2]))
				{
				foreach ($this->diziler[$de�er1][$de�er2] as $de�er3 => $i�erik3) {
				$tagToReplace = "#$de�er1"."[$de�er2]"."[$de�er3]#";
				$this->diziler1[$de�er1][$de�er2][$de�er3] = "#$de�er1"."[$de�er2]"."[$de�er3]#";
            	$this->iyibu = str_replace($tagToReplace, $i�erik3, $this->iyibu);
				};
				}
				else
				{
            	$tagToReplace = "#$de�er1"."[$de�er2]#";
            	$this->iyibu = str_replace($tagToReplace, $i�erik2, $this->iyibu);
				$this->diziler1[$de�er1][$de�er2] = "#$de�er1"."[$de�er2]#";
				};
				};
    };
	if($this->strposa($this->iyibu, $this->diziler2)) $this->de�i�tir();
	}
	
	function dil�evir_if(){
	$this->de�i�tir();
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
	$this->de�i�tir();
	}
	
	function dil�evir_for(){
	$this->de�i�tir();
	preg_match_all('@{for \$(.*?)=(.*?) to (.*?)}@', $this->iyibu, $e�);
	foreach ($e�[1] as $e�le�me){
	$this->iyibu = str_replace("#$e�le�me#", "<?php echo $$e�le�me?>", $this->iyibu);
	}
	$this->iyibu = preg_replace_callback(
    '@{for \$(.*?)=(.*?) to (.*?)}@',
    function ($e�) {
        return "<?php for ($".phpSil("$e�[1]")."=$e�[2]; $$e�[1]<=".phpSil("$e�[3]")."; $$e�[1]++):?>";},
    $this->iyibu);
	$this->iyibu = str_replace('{/for}', "<?php endfor;?>", $this->iyibu);
	$this->de�i�tir();
	}
	
	function dil�evir_foreach(){
	$this->de�i�tir();
	preg_match_all('@{foreach (.*?) as \$(.*?)}@', $this->iyibu, $e�);
	foreach ($e�[2] as $e�le�me){
	$this->iyibu = str_replace("#$e�le�me#", "<?php echo $$e�le�me?>", $this->iyibu);
	}
	$this->iyibu = preg_replace_callback(
    '@{foreach (.*?) as (.*?)}@',
    function ($e�) {
        return "<?php foreach (".phpSil("$e�[1]")." as ".phpSil("$e�[2]")."):?>";},
    $this->iyibu);
	$this->iyibu = str_replace('{/foreach}', "<?php endforeach;?>", $this->iyibu);
	$this->de�i�tir();
	}
	
	function dil�evir_de�i�ken(){
	$this->de�i�tir();
	$this->iyibu = preg_replace_callback(
    '@\#(girdi|dizi) (.*?).=.(.*?)\#@',
    array($this,'dene'),
    $this->iyibu);
	$this->de�i�tir();
	}
	
	function dene($m)
	{
		eval("\$de�i�ken_i�i = ".phpSil($m[3]).";");
        $this->$m[1]("$m[2]",@$de�i�ken_i�i);
	}
	
	function dil�evir_include(){
	$this->de�i�tir();
	preg_match_all("@{include (.*?)}@", $this->iyibu, $e�);
	$includes = array();
	foreach ($e�[1] as $key=>$e�le�me){
	$includes[] = $e�le�me;
	if ($e�le�me == $this->dosya_yolu) {
	echo "Hata: i� i�e include edilemez: $this->dizin$e�le�me";
	die();
	}
	}
	foreach ($e�[0] as $key=>$e�le�me){
	$inc_i�erik = @file_get_contents($this->dizin.$includes[$key]);
	if($inc_i�erik === FALSE) {
	echo "<br><b>��erik okunamad� $this->dizin$includes[$key]</b>";
	die();}
	$this->iyibu = str_replace($e�le�me, $inc_i�erik, $this->iyibu);
	}
	if(preg_match_all("@{include (.*?)}@", $this->iyibu, $e�)) $this->dil�evir_include();
	$this->de�i�tir();
	$this->dil�evir();
	}
	
	function dil�evir_fonksiyonlar(){
	$this->de�i�tir();
	$this->iyibu = preg_replace_callback(
    '@\[(array_count|son_i�erikler|hit_i�erikler|diziden_girdiye|k�saDetay|nezaman)\((.*?)\)\]@',
	array($this,'fonksiyon_al'),
    $this->iyibu);
	$this->de�i�tir();
	}
	
	function fonksiyon_al($m){
	return "<?php echo $m[1]($m[2])?>";
	}
	
	function dil�evir_noscript(){
	$this->iyibu = preg_replace_callback('@<iyibukod>(.*?)<\/iyibukod>@',array($this,'noscript'),$this->iyibu);
	}
	
	function noscript($m) {
	if(is_array($m)){
	$i�erik = $m[1];
	}else{
	$i�erik = $m;
	};
	$kilit = rndStr(4);
	$this->kodlar[$kilit] = $i�erik;
	return '<<<'.$kilit.'>>>';
	}
	
	function dil�evir_doscript(){
	foreach($this->kodlar as $k=>$kod){
	$this->iyibu = str_replace('<<<'.$k.'>>>', $kod, $this->iyibu);
	}
	}
	
	function dil�evir(){
	$pattern = "(<\?(php)?(.*?)\?>)";
	$replacement = htmlentities("<?$1$2?>");
	$this->iyibu = preg_replace($pattern, $replacement, $this->iyibu);
	$pattern = "({yaz \'(.*?)\'})";
	$replacement = "<?echo \"$1\"?>";
	$this->iyibu = preg_replace($pattern, $replacement, $this->iyibu);
	}
	
	function html_s�k��t�r($buffer) {
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

   function yay�nla() {
   global $site_gzip,$site_html_s;
    $this->dil�evir_include();
	$this->dil�evir();
	$this->dil�evir_fonksiyonlar();
	$this->dil�evir_for();
	$this->dil�evir_foreach();
	$this->dil�evir_de�i�ken();
	ob_start();
	eval("?>".$this->iyibu);
	$this->iyibu = ob_get_contents();
	ob_end_clean();
	$this->dil�evir_fonksiyonlar();
	$this->dil�evir_de�i�ken();
	$this->dil�evir_if();
	$this->dil�evir_for();
	$this->dil�evir_foreach();
	ob_start();
	eval("?>".$this->iyibu);
	$this->iyibu = ob_get_contents();
	ob_end_clean();
	$this->dil�evir_de�i�ken();
	$this->dil�evir_doscript();
	if($site_html_s==true) $this->iyibu = $this->html_s�k��t�r($this->iyibu);
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