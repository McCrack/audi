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

/*********************************************************/

$alternates = $mySQL->getGroup("SELECT language,name FROM gb_sitemap WHERE MaterialID = {int} AND published & 2", $page->MaterialID);
foreach($alternates['language'] as $i=>$lang) if($lang==DEFAULT_LANG){
	$page->x_default = 
	$page->languageset[$lang] = $page->root."/".$alternates['name'][$i];
}else $page->languageset[$lang] = $page->root."/".$lang."/".$alternates['name'][$i];

/*********************************************************/

$customizer = JSON::parse($page->customizer);

/* Template **********************************************/

define("TEMPLATE", $page->template);

include_once("themes/".THEME."/index.html");

?>