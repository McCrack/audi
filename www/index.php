<?php

if(preg_match("/[A-Z]/", $_GET['params'])){
	header("Location: ".mb_strtolower($_GET['params'], "utf-8"), true, 301);
	exit;
}

/********************************************  CLOCLAB 1.0 *****************************************/

require_once("core/index.php");

$host = explode(".", $_SERVER['HTTP_HOST']);
define("PROTOCOL", getProtocol());
define("SUBDOMAIN", reset($host));
define("HOST", implode(".", array_slice($host, 1)));

$config = new Config();

require_once("core/db.php");

/*************************************/

/*
['REDIRECT_SCRIPT_URL'], ['SCRIPT_URL'], ['REDIRECT_URL'], ['REQUEST_URI']
['REDIRECT_SCRIPT_URI'], ['SCRIPT_URI']
*/

$link = $mySQL->getRow("SELECT target,code FROM gb_redirects WHERE hash LIKE {str} LIMIT 1", md5($_SERVER['SCRIPT_URL']));
if($mySQL->status['affected_rows']>0){
	header("Location: ".$link['target'], true, $link['code']);
	exit;
}

/***** Device detect *****************/

if(preg_match("/(android|phone|ipad|tablet|blackberry|bb10|symbian|series|samsung|webos|mobile|opera m|htc|fennec|windowsphone|wp7|wp8)/i", $_SERVER['HTTP_USER_AGENT'])){
	define("MOBILE", true);
	define("DESKTOP", false);
	define("DEVICE", "mobile");
}else{
	define("MOBILE", false);
	define("DESKTOP", true);
	define("DEVICE", "desktop");
}

/*************************************/

define("THEME", $config->{"theme"});

define("DEFAULT_LANG", $config->language);
define("DEFAULT_LOCAL", $config->locality);

/************* Parse URL *************/

$params = preg_split("/\//", urldecode($_GET['params']), -1, PREG_SPLIT_NO_EMPTY);

/* LANGUAGES DEFINE ******************/

if(in_array($params[0], $config->languageset)){
	define("USER_LANG", $params[0]);
	$params = array_slice($params, 1);
	define("LANG_INDEX", "/".USER_LANG);
}else{
	define("USER_LANG", DEFAULT_LANG);
	define("LANG_INDEX", "");
}

define("USER_LOCAL", $config->{USER_LANG});

$mask = 0;
foreach($config->languageset as $key=>$val){
	if($val!=USER_LANG) $mask |= pow(2, $key);
}
define("LANG_MASK", $mask);

define("ROOT", empty($params[0]) ? $config->{"home page"} : array_shift($params));
foreach($params as $i=>$itm) define("ARG_".($i+1), $itm);

/*************************************/

$map = $mySQL->getTree("name","parent","SELECT PageID,name,parent,header,soundex FROM gb_sitemap WHERE published & 2 AND language LIKE {str} ORDER BY SortID", USER_LANG);

/*************************************/

include_once("core/wordlist.php");
$wordlist = new Wordlist();

$page = new Data;

$time_start = microtime(true);

if(file_exists("modules/".$page->module."/index.php")){
	include_once("modules/".$page->module."/index.php");
	//include_once("modules/lineup/index.php");
}else include_once("modules/".$config->{"default module"}."/index.php");

//print("T: ".(microtime(true) - $time_start));

/*********************/

$mySQL->close();


?>