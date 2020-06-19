<?php

require_once("core/index.php");

$config = new config();

if(isset($_COOKIE['subdomain'])){
	define("BASE_FOLDER", $_COOKIE['subdomain']);
}else define("BASE_FOLDER", $config->{"base folder"});

define("BASE_DOMAIN", $config->{BASE_FOLDER});

$cng = new config("../".BASE_FOLDER."/".$config->{"config file"});

define("DB_HOST", $cng->{"db host"});
define("DB_NAME", $cng->{"db name"});
define("DB_USER", $cng->{"db user"});
define("DB_PASS", $cng->{"db password"});

require_once("core/db.php");

$host = explode(".", $_SERVER['HTTP_HOST']);
define("PROTOCOL", getProtocol());
define("SUBDOMAIN", reset($host));
define("HOST", implode(".", array_slice($host, 1)));

$mySQL->login();

define("DEFAULT_LANG", $config->{"language"});
define("USER_LANG", empty($mySQL->settings['General']['language'])?DEFAULT_LANG:$mySQL->settings['General']['language']);

$params = preg_split("/\//", urldecode($_GET['params']), -1, PREG_SPLIT_NO_EMPTY);

define("SECTION", empty($params[0]) ? $config->{"default module"} : array_shift($params));

$path = "modules/".SECTION;

foreach($params as $itm){
	if(is_dir($path."/".$itm)){
		$path .= "/".array_shift($params);
	}else break;
}
foreach($params as $i=>$itm) define("ARG_".($i+1), $itm);

if(file_exists($path."/config.init")){
	$conf = JSON::load($path."/config.init");
	$groups = preg_split("/,\s*/", $conf['access']['value'], -1, PREG_SPLIT_NO_EMPTY);
	if(($conf['free access']['value']=="YES") || in_array(USER_GROUP, $groups)){
		
		if(file_exists($path."/".ARG_1.".php")){
			include_once($path."/".ARG_1.".php");
		}elseif(file_exists($path."/index.php")){
			include_once($path."/index.php");
		}else include_once("modules/".SECTION."/index.php");

	}else die(include_once("login.php"));
}

$mySQL->close();

?>