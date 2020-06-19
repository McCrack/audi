<?php

$page->canonical .= LANG_INDEX."/".$page->name;

/*********************************************************/

$logo = getimagesize($page->logo);

/* bread crumbs ******************************************/

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

if($page->type=="material"){
	$all_news = $page->parent;
	$cat = $page->header;
	$category = $page->name;
	$categories = $mySQL->parse("parent LIKE {str}", $page->parent);
}else{
	$all_news = $page->name;
	$cat = $wordlist->{'all news'};
	$category = '%';
	$categories = $mySQL->parse("parent LIKE {str}", $page->name);
}

$alternates = $mySQL->getGroup("SELECT language,name FROM gb_sitemap WHERE MaterialID = {int} AND published & 2", $page->MaterialID);

$limit = 20;

if(defined("ARG_1")){

	$key = $mySQL->getRow("SELECT KeyID FROM gb_keywords WHERE KeyWORD LIKE {str} LIMIT 1", ARG_1)['KeyID'];
	if($mySQL->status['affected_rows']>0){
		$word = $wordlist->{ARG_1};
		$page->canonical .= "/".ARG_1;
		$page->title = implode(" - ",[
			$word,
			$page->title
		]);

		$page->schemes['breadcrumbs']['itemListElement'][] = [
			"@type"=>"ListItem",
			"position"=>$cnt+2,
			"name"=>$word,
			"item"=>$page->canonical
		];

		foreach($alternates['language'] as $i=>$lang) if($lang==DEFAULT_LANG){
			$page->x_default = 
			$page->languageset[$lang] = $page->root."/".$alternates['name'][$i]."/".ARG_1;
		}else $page->languageset[$lang] = $page->root."/".$lang."/".$alternates['name'][$i].ARG_1;

		/*********************************************************/

		$feed = $mySQL->get("
		SELECT * FROM blog_vs_keywords
		CROSS JOIN gb_blogfeed USING(PageID)
		CROSS JOIN gb_pages USING(PageID) 
		WHERE
			KeyID = {int} AND
			category LIKE {str} AND
			language LIKE {str} AND
			published & 2 AND
			created<{int}
		ORDER BY created DESC
		LIMIT {int}", $key,$category,USER_LANG,time(),$limit);

	}else{
		header("Location: /".$page->name, true, 301);
		exit;
	}

}else{

	foreach($alternates['language'] as $i=>$lang) if($lang==DEFAULT_LANG){
		$page->x_default = 
		$page->languageset[$lang] = $page->root."/".$alternates['name'][$i];
	}else $page->languageset[$lang] = $page->root."/".$lang."/".$alternates['name'][$i];

	/*********************************************************/

	$feed = $mySQL->get("
	SELECT * FROM gb_blogfeed
	CROSS JOIN gb_pages USING(PageID) 
	WHERE
		category LIKE {str} AND
		language LIKE {str} AND
		published & 2 AND
		created<{int}
	ORDER BY created DESC
	LIMIT {int}", $category,USER_LANG,time(),$limit);
}

/* Template **********************************************/

include_once("themes/".THEME."/blog.html");

?>