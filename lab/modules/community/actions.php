<?php
switch(ARG_2){
	case "change-review":
		$review = file_get_contents('php://input');
		print $mySQL->inquiry("UPDATE gb_community SET review={str} WHERE CommunityID = {int} LIMIT 1", $mySQL->escape_string($review), ARG_3)['affected_rows'];
	break;
	case "save":
		$p = JSON::load('php://input');
		if($p){
			$upd = $mySQL->inquiry("UPDATE gb_community SET options={str} WHERE CommunityID = {int} LIMIT 1", JSON::encode($p), ARG_3)['affected_rows'];
		}else $upd = "Unknow format.";
		print($upd);
	break;
	case "add-to-staff":
		print $mySQL->inquiry("INSERT INTO gb_staff SET CommunityID={int}", ARG_3)['last_id'];
	break;
	default: break;
}
?>