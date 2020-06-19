<?php

require_once("core/index.php");
$config = new config();

define("PROTOCOL", getProtocol());

$mySQL = new dBase($config->host, $config->{"user name"}, $config->password, $config->{"db name"});
$mySQL->set_charset("utf8");

$xml = new DOMDocument("1.0", "UTF-8");

$urlset = $loc = $xml->createElement("urlset");

$rows = $mySQL->query("SELECT `collection`,`PageID` FROM `gb_collections` WHERE `status` & 1 ORDER BY `PageID` DESC");
foreach($rows as $row){
	$loc = $xml->createElement("loc");
	$loc->nodeValue = PROTOCOL."://".$_SERVER['HTTP_HOST']."/keramicheskaya-plitka-".translite($row['collection'])."-".$row['PageID'];
	$url = $xml->createElement("url");
	$url->appendChild($loc);
	$urlset->appendChild($url);
}

$rows = $mySQL->query("SELECT `name`,`language` FROM `gb_sitemap` WHERE published & 2 ORDER BY `PageID` DESC");

foreach($rows as $row){
	$loc = $xml->createElement("loc");
	$loc->nodeValue = PROTOCOL."://".$_SERVER['HTTP_HOST']."/".$row['name'];
	$url = $xml->createElement("url");
	$url->appendChild($loc);
	$urlset->appendChild($url);
}

$xml->appendChild($urlset);

$xml->save("sitemap.xml");

?>