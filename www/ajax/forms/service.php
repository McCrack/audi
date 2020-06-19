<?php

$p = JSON::load('php://input');

$headers = "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/html; charset=utf8\r\n";
$headers .= "From: service@".$_SERVER['HTTP_HOST']."\r\n";

ob_start();?>
<h1><?=$p['first']?>&nbsp;<?=$p['second']?></h1>
<h3 style="float:left"><small>Тел.:</small> <?=$p['phone']?></h3>
<h3 style="float:right">Email: <?=$p['email']?></h3>
<h2>Модель: <?=$p['model']?> / <small>VIN: <?=$p['vin']?></small> / <small>Державний номер: <?=$p['number']?></small> / <small>Пробіг автомобіля: <?=$p['distance']?></small> </h2>
<?php
$message = ob_get_contents();
ob_end_clean();

$sent = mail($config->{"email"}, "=?utf-8?B?".base64_encode("Новая запись на сервис с сайта ".$_SERVER['HTTP_HOST'])."?=", $message, $headers);
print($sent);

?>