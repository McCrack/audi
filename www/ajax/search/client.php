<?php

require_once("core/db.php");

$citizen = $mySQL->getRow("SELECT Name,Phone,Email FROM gb_community WHERE Phone LIKE {str} LIMIT 1", ARG_1);

if(empty($citizen)){
	print '{"status":"0"}';
}else print JSON::encode([
	"status"=>1,
	"citizen"=>$citizen
]);

?>