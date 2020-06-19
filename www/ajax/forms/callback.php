<?php
$text = "text=".file_get_contents('php://input');

$ch = curl_init();
curl_setopt_array($ch, array(
	CURLOPT_URL				=> "https://api.telegram.org/bot113034897:AAE9DUuGkp-whCBhr_lKCZJhMKkWdFy7mnI/sendMessage?disable_web_page_preview=true&chat_id=-135220987",
	CURLOPT_POST			=> TRUE,
	CURLOPT_RETURNTRANSFER	=> TRUE,
	CURLOPT_FOLLOWLOCATION	=> FALSE,
	CURLOPT_HEADER			=> FALSE,
	CURLOPT_TIMEOUT			=> 10,
	CURLOPT_HTTPHEADER		=> array("Accept-Language: ru,en-us"),
	CURLOPT_POSTFIELDS		=> $text,
));
curl_exec($ch);
curl_close($ch);
?>