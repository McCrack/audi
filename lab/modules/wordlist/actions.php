<?php
switch(ARG_2){
	case "create":
		$p = JSON::load('php://input');
		mkpath("../".$p['domain']."/localization");
		if(file_exists("../".$p['domain']."/localization/".$p['name'].".json")){
			print("Wordlist already exists.");
		}else{
			$created = file_put_contents("../".$p['domain']."/localization/".$p['name'].".json", '{"'.DEFAULT_LANG.'":{"":""}}');
			print($created);
		}
	break;
	case "save":
		$data = file_get_contents('php://input');
		$saved = file_put_contents("../".ARG_3."/localization/".ARG_4.".json", $data);
		print($saved);
	break;
	
	case "remove":
		$removed = unlink("../".ARG_3."/localization/".ARG_4.".json");
		print($removed);
	break;
	
	case "showkey":
		$p = JSON::load('php://input');
		$wordlist = JSON::load($p['path'])?>
		<?foreach($wordlist as $lang=>$words):?>
			<tr><th><?=$lang?></th><td contenteditable="true"><?=$words[$p['key']]?></td></tr>
		<?endforeach?>
	<?break;
	case "savekey":
		$p = JSON::load('php://input');
		$wordlist = JSON::load($p['path']);
		foreach($wordlist as $key=>&$lang){
			$lang = array_merge($lang, $p['wordlist'][$key]);
		}
		JSON::save($p['path'], $wordlist);
	break;
	
	default:break;
}

?>