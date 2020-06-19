<?php

$page->canonical .= LANG_INDEX."/".$page->name;

/*********************************************************/

$logo = getimagesize($page->logo);

$alternates = $mySQL->getGroup("SELECT language,name FROM gb_sitemap WHERE MaterialID = {int} AND published & 2", $page->MaterialID);
foreach($alternates['language'] as $i=>$lang) if($lang==DEFAULT_LANG){
	$page->x_default = 
	$page->languageset[$lang] = $page->root."/".$alternates['name'][$i];
}else $page->languageset[$lang] = $page->root."/".$lang."/".$alternates['name'][$i];

if(defined("ARG_1")){
	$id = explode("-", ARG_1);
	$id = end($id);

	if(is_numeric($id)){
		$showcase = $mySQL->getRow("SELECT * FROM gb_showcase WHERE articul={int} AND language LIKE {str} LIMIT 1", $id, USER_LANG);
		$mediaset = JSON::parse($showcase['mediaset']);
		$optionset = JSON::parse($showcase['options']);
		
		define("SUBTEMPLATE", $showcase['subtemplate']);

		$alternates = $mySQL->getGroup("SELECT language,named FROM gb_showcase WHERE articul = {int} AND status & 1", $showcase['articul']);
		
		foreach($alternates['language'] as $i=>$lang){
			$page->languageset[$lang] .= "/".translite($alternates['named'][$i])."-".$showcase['articul'];
		}

		$page->canonical .= "/".ARG_1;
	}
}else define("SUBTEMPLATE", $page->template);


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

/*********************************************************/

//$customizer = JSON::parse($page->customizer);

$page->description .= " ➤ ".$page->data['title']." ".($showcase['named']." ".$showcase['articul'])." ✓ ".$page->context;

$page->title = $page->data['title']." ".($showcase['named']." ".$showcase['articul'])." ".$page->context;

/* Template **********************************************/

define("TEMPLATE", "showcase");

include_once("themes/".THEME."/index.html");

?>