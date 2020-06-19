<?php

//require_once("core/wordlist.php");
//$wordlist = new Wordlist("main", ARG_1);

require_once("core/db.php");

if(in_array(ARG_1, $config->languageset)){
	define("USER_LANG", $params[0]);
	define("LANG_INDEX", "/".USER_LANG);
}else{
	define("USER_LANG", DEFAULT_LANG);
	define("LANG_INDEX", "");
}

$mask = 0;
foreach($config->languageset as $key=>$val){
	if($val!=ARG_1) $mask |= pow(2, $key);
}
define("LANG_MASK", $mask);

$handle = "b".time();

?>

<!-- test drive modal window -->
<div id="<?=$handle?>" class="modal modal--content">
	<form class="box container">
      <a href="javascript:hide()" class="modal__close"></a>
      <?=gzdecode($mySQL->getMaterial('test-drayv', ['content'])['content'])?>
			<script>
				(function(form) {
					form.onreset = function() {
						form.drop();
					}

					<?=file_get_contents('php://input')?>";
				})(document.currentScript.parentNode);
			</script>
	</form>
</div>