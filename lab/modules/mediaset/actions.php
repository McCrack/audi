<?php

switch(ARG_2){
	case "create-mediaset":
		$p = JSON::load("php://input");
		print $mySQL->inquiry("INSERT INTO gb_media (language, Name, Category, Mediaset) VALUES ({str}, {str}, {str}, {str})", $p['language'],$p['Name'],$p['Category'],JSON::encode($p['Mediaset']))['last_id'];
	break;
	case "save-mediaset":
		print $mySQL->inquiry("UPDATE gb_media SET Mediaset={str} WHERE SetID={int} LIMIT 1",file_get_contents('php://input'),ARG_3)['affected_rows'];
	break;
	case "remove-mediaset":
		print $mySQL->inquiry("DELETE FROM gb_media WHERE SetID={int} LIMIT 1",ARG_3)['affected_rows'];
	break;
	default:break;
}
?>