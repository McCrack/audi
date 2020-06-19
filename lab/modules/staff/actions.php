<?php
switch(ARG_2){
	case "save":
		$p = JSON::load('php://input');
		if(ARG_3){
			$set = [
				"Login"=>$p['login'],
				"Passwd"=>$p['passwd'],
				"Group"=>$p['group'],
				"Departament"=>$p['departament'],
				"Name"=>$p['name'],
				"Email"=>$p['email'],
				"Phone"=>$p['phone']
			];
			if(!empty($p['settings'])) $set['settings'] = JSON::encode($p['settings']);
			$mySQL->inquiry("UPDATE gb_staff LEFT JOIN gb_community USING(CommunityID) SET {prp} WHERE UserID = {int}", $mySQL->parse("{set}", $set), ARG_3);
		}else{
			$CommunityID = $mySQL->inquiry("INSERT INTO gb_community SET {prp}", $mySQL->parse("{set}",[
				"Email"=>$p['email'],
				"Name"=>$p['name'],
				"Phone"=>(INT)$p['phone']
			]))['last_id'];

			print $mySQL->inquiry("INSERT INTO gb_staff SET {prp}", $mySQL->parse("{set}",[
				"CommunityID"=>$CommunityID,
				"Login"=>$p['login'],
				"Passwd"=>$p['passwd'],
				"Group"=>$p['group'],
				"Departament"=>$p['departament'],
				"settings"=>JSON::encode([
					"General"=>[
						"language"=>$config->language
					]
				])
			]))['last_id'];
		}			
	break;
	case "delete":
		if(ARG_3) print $mySQL->inquiry("DELETE FROM gb_staff WHERE UserID={int} LIMIT 1", ARG_3);
	break;
	case "load-user":
		$user = $mySQL->getRow("SELECT * FROM gb_staff LEFT JOIN gb_community USING(CommunityID) WHERE UserID={int} LIMIT 1", ARG_3);
		print JSON::encode($user);
	break;
	default:break;
}

?>