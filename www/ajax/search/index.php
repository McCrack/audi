<?php

$query = file_get_contents('php://input');
$query = preg_replace("/\s+/", "|", $query);

require_once("core/db.php");

$result = [];

$res = $mySQL->getGroup("SELECT PageID FROM gb_sitemap WHERE `header` REGEXP {str}", $query)['PageID'];
if(is_array($res)) $result = $res;
$res = $mySQL->getGroup("SELECT PageID FROM gb_collections WHERE `collection` REGEXP {str}", $query)['PageID'];
if(is_array($res)) $result = array_merge($result, $res);
$res = $mySQL->getGroup("SELECT PageID FROM gb_textures WHERE `name` REGEXP {str} GROUP BY PageID", $query)['PageID'];
if(is_array($res)) $result = array_merge($result, $res);
print implode("-", array_unique($result) );
?>