<?php

$page->canonical .= LANG_INDEX."/".$page->name;

/*********************************************************/

$logo = getimagesize($page->logo);

/* BREAD CRUMBS ******************************************/

$backTree = $mySQL->getTree("parent","name","SELECT parent,name,header FROM gb_sitemap WHERE language LIKE {str}", USER_LANG);


$breadcrumbs = [];
$key = $page->name;
while($key && $key!="root"){
	$subkey = $key;
	$key = key($backTree[$key]);
	
	$breadcrumbs[] = [
		"@type"=>"ListItem",
		"name"=>$backTree[$subkey][$key]['header'],
		"item"=>$page->root.LANG_INDEX."/".$subkey
	];
}
$cnt = count($breadcrumbs);
for($i=$cnt; $i--;){
	$breadcrumbs[$i]['position'] = $cnt-$i+1;
	$page->schemes['breadcrumbs']['itemListElement'][] = $breadcrumbs[$i];
}

if(defined("ARG_1")){
	$subpage = $mySQL->getRow("
	SELECT * FROM gb_lineup
	CROSS JOIN gb_classes USING(ClassID)
	CROSS JOIN gb_pages USING(PageID)
	CROSS JOIN gb_static USING(PageID)
	WHERE ModelID LIKE {str} AND language LIKE {str} LIMIT 1", ARG_1, USER_LANG);

	if($mySQL->status['affected_rows']>0){
		
		$page->data = array_merge($page->data, $subpage);

		$page->title = implode(" - ",[
			$subpage['title'],
			$page->SiteName
		]);

		$page->canonical .= "/".$subpage['ModelID'];

		$page->schemes['breadcrumbs']['itemListElement'][] = [
			"@type"=>"ListItem",
			"position"=>3,
			"name"=>$subpage['model'],
			"item"=>$page->canonical
		];

		$alternates = $mySQL->getGroup("SELECT language,ModelID FROM gb_lineup WHERE ModelID LIKE {str} AND published & 2", $subpage['ModelID']);
		foreach($alternates['language'] as $i=>$lang) if($lang==DEFAULT_LANG){
			$page->x_default = 
			$page->languageset[$lang] = $page->root."/".$page->name."/".$alternates['ModelID'][$i];
		}else $page->languageset[$lang] = $page->root."/".$lang."/".$page->name."/".$alternates['ModelID'][$i];

		define("TEMPLATE", "vehicle");

		$mediaset = $mySQL->getRow("SELECT Mediaset FROM gb_media WHERE SetID={int} LIMIT 1", $page->SetID)['Mediaset'];
		$mediaset = JSON::parse($mediaset);

	}else{
		$page->data = $mySQL->getMaterial("404", ["*"]);
		header('HTTP/1.0 404 Not Found');
		define("TEMPLATE", $page->template);
	}
}else{

	/*********************************************************/

	$alternates = $mySQL->getGroup("SELECT language,name FROM gb_sitemap WHERE MaterialID = {int}", $page->MaterialID);
	foreach($alternates['language'] as $i=>$lang) if($lang==DEFAULT_LANG){
		$page->x_default = 
		$page->languageset[$lang] = $page->root."/".$alternates['name'][$i];
	}else $page->languageset[$lang] = $page->root."/".$lang."/".$alternates['name'][$i];

	define("TEMPLATE", $page->template);
}


/* Template **********************************************/

include_once("themes/".THEME."/lineup.html");

?>