<?php

$p = JSON::load('php://input');

$headers = "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/html; charset=utf8\r\n";
$headers .= "From: site@p".$_SERVER['HTTP_HOST']."\r\n";

$message = "
<h4>от: ".$p['email']."</h4>
<p>".$p['message']."</p>
";

$ch = curl_init();
curl_setopt_array($ch, array(
	CURLOPT_URL				=> "https://api.telegram.org/bot113034897:AAE9DUuGkp-whCBhr_lKCZJhMKkWdFy7mnI/sendMessage?disable_web_page_preview=true&chat_id=-135220987",
	CURLOPT_POST			=> TRUE,
	CURLOPT_RETURNTRANSFER	=> TRUE,
	CURLOPT_FOLLOWLOCATION	=> FALSE,
	CURLOPT_HEADER			=> FALSE,
	CURLOPT_TIMEOUT			=> 10,
	CURLOPT_HTTPHEADER		=> array("Accept-Language: ru,en-us"),
	CURLOPT_POSTFIELDS		=> "text=Сообщение от: ".$p['email']."\n ".$p['message']
));
curl_exec($ch);
curl_close($ch);

$sent = mail($config->email, "=?utf-8?B?".base64_encode("Сообщение с сайта ".$_SERVER['HTTP_HOST'])."?=", $message, $headers);

?>
<div class="part">Обратная связь:</div>
<?if((INT)$sent):?>
	<p>Сообщение отправлено.</p>
<?else:?>
	<p>Ошибка! Попробуйте еще раз.</p>
<?endif?>
