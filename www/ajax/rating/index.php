<?php

require_once("core/db.php");

$vote = (ARG_2) ? 0 : 1;
$mySQL->inquiry("UPDATE `gb_pages` SET votes={fld}+{int},rating=({fld}-{int})+{int} WHERE PageID={int} LIMIT 1", "votes",$vote,"rating",(INT)ARG_2,(INT)ARG_1,(INT)SUBMODULE);

//$res = $mySQL->getRow("SELECT rating,votes FROM gb_pages WHERE PageID={int} LIMIT 1", (INT)SUBMODULE);
//print( ($res['rating']/$res['votes'])>>0 );

?>