<?php

require_once("core/db.php");

$mySQL->inquiry("UPDATE gb_pages SET rating = rating+1 WHERE PageID={int} LIMIT 1", ARG_1);
print $mySQL->getRow("SELECT rating FROM gb_pages WHERE PageID={int} LIMIT 1", ARG_1)['rating'];


?>