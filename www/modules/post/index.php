<?php

$logo = getimagesize($page->logo);

$page->canonical .= LANG_INDEX."/".$page->name;

$category = $mySQL->getRow("SELECT name,header,parent FROM gb_sitemap WHERE name LIKE {str} AND language LIKE {str} LIMIT 1", $page->category, USER_LANG);

$categories = $mySQL->parse("parent LIKE {str}", $category['parent']);

/* BREAD CRUMBS ******************************************/

// Blog Item
$page->schemes['breadcrumbs']['itemListElement'][] = [
	"@type"=>"ListItem",
	"position"=>2,
	"name"=>$wordlist->news,
	"item"=>$page->root."".LANG_INDEX."/".$category['parent']
];
// Blog Category Item
$page->schemes['breadcrumbs']['itemListElement'][] = [
	"@type"=>"ListItem",
	"position"=>3,
	"name"=>$category['header'],
	"item"=>$page->root."".LANG_INDEX."/".$category['name']
];
// Current Post Item
$page->schemes['breadcrumbs']['itemListElement'][] = [
	"@type"=>"ListItem",
	"position"=>4,
	"name"=>$page->header,
	"item"=>$page->canonical
];

//$categories = $mySQL->parse("parent LIKE (SELECT parent FROM gb_sitemap WHERE name LIKE {str})", $page->category);

$alternates = $mySQL->getGroup("SELECT PageID,header,language FROM gb_blogfeed WHERE ID={int} AND published & 2", $page->ID);
foreach($alternates['language'] as $i=>$lang){
	if($lang==DEFAULT_LANG){
		$page->x_default = 
		$page->languageset[$lang] = $page->root."/".translite($alternates['header'][$i])."-".$alternates['PageID'][$i];
	}else $page->languageset[$lang] = $page->root."/".$lang."/".translite($alternates['header'][$i])."-".$alternates['PageID'][$i];
}

//$keywords = $mySQL->getGroup("SELECT KeyWORD FROM gb_keywords ORDER BY rating DESC LIMIT 32")['KeyWORD'];

//$tags = $mySQL->getGroup("SELECT KeyWORD FROM blog_vs_keywords CROSS JOIN gb_keywords USING(KeyID) WHERE PageID={int} ORDER BY rating DESC", PAGE_ID)['KeyWORD'];

$feed = $mySQL->get("SELECT * FROM gb_blogfeed CROSS JOIN gb_pages USING(PageID) WHERE published & 2 AND category LIKE {str} AND language LIKE {str} ORDER BY created DESC LIMIT 3", $page->category,USER_LANG);

include_once("themes/".THEME."/blog.html");

?>