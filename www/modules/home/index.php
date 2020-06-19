<?php

$page->canonical .= LANG_INDEX."/"; 

/*********************************************************/

$logo = getimagesize($page->logo);

/*********************************************************/

$alternates = $mySQL->getGroup("SELECT language,name FROM gb_sitemap WHERE MaterialID = {int}", $page->MaterialID);
foreach($alternates['language'] as $i=>$lang) if($lang==DEFAULT_LANG){
	$page->x_default = 
	$page->languageset[$lang] = $page->root;
}else $page->languageset[$lang] = $page->root."/".$lang;

/* Template **********************************************/

define("TEMPLATE", $page->template);

include_once("themes/".THEME."/index.html");

?>