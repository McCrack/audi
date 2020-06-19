<?php
switch(ARG_2){
	case "add-model":
		$p = JSON::load('php://input');
		$timestamp = time();
		$cng = new config("../".BASE_FOLDER."/config.init");

		$ClassID = $mySQL->getRow("SELECT ClassID FROM gb_classes WHERE class LIKE {str} AND body LIKE {str} LIMIT 1", $p['class'], $p['body'])['ClassID'];
		if(empty($ClassID)) $ClassID = $mySQL->inquiry("INSERT INTO gb_classes SET class={str}, body={str}", $p['class'], $p['body'])['last_id'];

		foreach($cng->languageset as $lang){
	
			$PageID = $mySQL->inquiry("INSERT INTO gb_pages (created,modified,type) VALUES ({int},{int},'vehicle')", $timestamp, $timestamp)['last_id'];

			$mySQL->inquiry("INSERT INTO gb_lineup SET {prp}",$mySQL->parse("{set}",[
					"PageID"=>$PageID,
					"ClassID"=>$ClassID,
					"ModelID"=>$p['ModelID'],
					"model"=>$p['model'],
					"language"=>$lang
			]));
			
			$mySQL->inquiry("INSERT INTO gb_static SET PageID={int}, module='vehicle',template='default'", $PageID);
		}

		print JSON::encode([
			"ID"=>$PageID,
			"ClassID"=>$ClassID,
			"family"=>$p['class']
		]);
	break;
	case "remove-vehicle":
		print $mySQL->inquiry("DELETE FROM gb_pages WHERE PageID IN (SELECT PageID FROM gb_lineup WHERE ModelID LIKE {str})", ARG_3)['affected_rows'];
	break;
	
	case "change-modelid":
		print $mySQL->inquiry("UPDATE gb_lineup SET ModelID={str} WHERE ModelID = {str}", file_get_contents('php://input'), ARG_3)['affected_rows'];
	break;
	case "change-model":
		print $mySQL->inquiry("UPDATE gb_lineup SET model={str} WHERE ModelID = {str}", file_get_contents('php://input'), ARG_3)['affected_rows'];
	break;
	/*
	case "change-family":
		print $mySQL->inquiry("UPDATE gb_lineup SET family={str} WHERE ModelID = {str}", file_get_contents('php://input'), ARG_3)['affected_rows'];
	break;
	*/
	case "change-published":
		print $mySQL->inquiry("UPDATE gb_lineup SET published={str} WHERE ModelID = {str}", file_get_contents('php://input'), ARG_3)['affected_rows'];
	break;
	case "change-cover":
		print $mySQL->inquiry("UPDATE gb_lineup SET cover={str} WHERE ModelID = {str}", file_get_contents('php://input'), ARG_3)['affected_rows'];
	break;
	case "change-profile":
		print $mySQL->inquiry("UPDATE gb_lineup SET profile={str} WHERE ModelID = {str}", file_get_contents('php://input'), ARG_3)['affected_rows'];
	break;
	case "change-front":
		print $mySQL->inquiry("UPDATE gb_classes SET front={str} WHERE ClassID = {int}", file_get_contents('php://input'), ARG_3)['affected_rows'];
	break;
	case "change-side":
		print $mySQL->inquiry("UPDATE gb_classes SET side={str} WHERE ClassID = {int}", file_get_contents('php://input'), ARG_3)['affected_rows'];
	break;
	case "change-back":
		print $mySQL->inquiry("UPDATE gb_classes SET back={str} WHERE ClassID = {int}", file_get_contents('php://input'), ARG_3)['affected_rows'];
	break;
	case "mediaset":
		print $mySQL->inquiry("UPDATE gb_lineup SET SetID={int} WHERE PageID = {int}", ARG_4, ARG_3)['affected_rows'];
	break;
	case "change-template":
		print $mySQL->inquiry("UPDATE gb_static SET template={str} WHERE PageID IN (SELECT PageID FROM gb_lineup WHERE ModelID LIKE {str})", file_get_contents('php://input'), ARG_3)['affected_rows'];
	break;
	case "change-pagetitle":
		print $mySQL->inquiry("UPDATE gb_lineup CROSS JOIN gb_static USING(PageID) SET title={str} WHERE ModelID LIKE {str} AND language LIKE {str}", file_get_contents('php://input'), ARG_3,ARG_4)['affected_rows'];
	break;
	case "change-context":
		print $mySQL->inquiry("UPDATE gb_lineup CROSS JOIN gb_static USING(PageID) SET context={str} WHERE ModelID LIKE {str} AND language LIKE {str}", file_get_contents('php://input'), ARG_3,ARG_4)['affected_rows'];
	break;
	case "change-description":
		print $mySQL->inquiry("UPDATE gb_lineup CROSS JOIN gb_static USING(PageID) SET description={str} WHERE ModelID LIKE {str} AND language LIKE {str}", file_get_contents('php://input'), ARG_3,ARG_4)['affected_rows'];
	break;
	case "save-options":
		print $mySQL->inquiry("UPDATE gb_static SET optionset={str} WHERE PageID = {int}", file_get_contents('php://input'), ARG_3)['affected_rows'];
	break;
	case "save-content":
		$mySQL->inquiry("UPDATE gb_pages SET modified=>{int} WHERE PageID={int} LIMIT 1", time(), ARG_3);

		$data = gzencode(file_get_contents('php://input'));
		print $mySQL->inquiry("UPDATE gb_static SET content={str} WHERE PageID={int} LIMIT 1", $data,ARG_3)['affected_rows'];
	break;
	case "assort":
		$mySQL->inquiry("UPDATE gb_lineup SET SortID={int} WHERE ModelID={str}", ARG_4,ARG_3);
	break;
	default:break;
}

?>