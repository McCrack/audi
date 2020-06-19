<?php

switch(ARG_2){
	case "save-form":
		file_put_contents("modules/customizer/form.html", file_get_contents('php://input'));
	break;
	case "save-options":
		$mySQL->inquiry("UPDATE gb_pages SET customizer={str} WHERE PageID = {int}", JSON::encode($_POST), ARG_3);
	break;
	default:break;
}
?>