<?php

$wordlist = [
	"card"=>"Картой",
	"cash"=>"Наличными",
	"on delivery"=>"Наложенный платеж",
];

$headers = "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/html; charset=utf8\r\n";
$headers .= "From: order@".$_SERVER['HTTP_HOST']."\r\n";

$p = JSON::load('php://input');

$mySQL = new dBase($config->host, $config->{"user name"}, $config->password, $config->{"db name"});
$mySQL->set_charset("utf8");

$IDs = [];
$cart = $p['cart'];
foreach($cart as $id=>$count) $IDs[] = $id;
$models = $mySQL->group_rows("
SELECT
	name,
	label,
	sticker,
	selling,
	preview,
	currency,
	discount,
	DiscountID,
	gb_items.ItemID AS ItemID,
	gb_items.PageID AS PageID
FROM gb_items
CROSS JOIN gb_models USING(PageID)
LEFT JOIN gb_discounts USING(DiscountID) 
WHERE gb_items.ItemID IN (".implode(",",$IDs).")");

$total = 0;

ob_start();?>

<h2>Имя: <?=$p['name']?></h2>
<h3>Тел.: <?=$p['phone']?></h3>
<h3>Email: <?=$p['email']?></h3>
<br>
<?if($p['type']=="delivery"):?>
<p>Доставка в город: <b><?=$p['city']?></b> / Отделение НП: <b><?=$p['office']?></b></p>
<?else: $p['payment']="cash"?>
<h2>Самовывоз</h2>
<?endif?>
<p>Оплата: <b><?=$wordlist[$p['payment']]?></b></p>
<table width="100%" cellspacing="0" rules="rows" bordercolor="#CCC">
	<thead>
		<tr align="center">
 			<th></th>
 			<th>Наименование</th>
			<th>Количество</th>
 			<th>Цена</th>
 			<th>Сумма</th>
		</tr>
	</thead>
	<tbody>
	<?foreach($models['ItemID'] as $i=>$id):
		$offer = "";
		$discount = 0;
 		$models['selling'][$i] *= $config->{$models['currency'][$i]};
		if($models['DiscountID'][$i] && $models['discount'][$i]){
			$discount = floor($models['selling'][$i] * $models['discount'][$i] / 100);
			$offer = $models['sticker'][$i];
		}
		$price = $models['selling'][$i] - $discount;
		$total += $sum = $price * $cart[$models['ItemID'][$i]];
		?>
		<tr>
			<td><img width="80px" src="<?=$models['preview'][$i]?>"></td>
			<td align="left">
				<tt>код товара: <?=($models['PageID'][$i]."-".$models['ItemID'][$i])?></tt><br>
				<h3><?=($models['name'][$i].' - '.$models['label'][$i])?></h3>
			</td>
			<td align="center"><?=$cart[$models['ItemID'][$i]]?></td>
			<td><?=money_format("%i", $price)?> грн.</td>
			<td><?=money_format("%i", $sum)?> грн.</td>
		</tr>
	<?endforeach?>
	</tbody>
	<tfoot>
		<tr>
			<th colspan="5" align="right">В заказе <?=count($models['ItemID'])?> товар (-ов) на сумму <?=money_format("%i", $total)?> грн.</th>
		</tr>
	</tfoot>
</table>
<?php
$message = ob_get_contents();
ob_end_clean();

/* --- CREATE ORDER --- */

$time = time();

$citizen = $mySQL->single_row("SELECT CommunityID,reputation FROM gb_community WHERE Phone LIKE '".$p['phone']."' LIMIT 1");
if(empty($citizen)){
	$CitizenID = $mySQL->single_row("SELECT MAX(CitizenID) AS CitizenID FROM gb_community LIMIT 1")['CitizenID'];
	$citizen = [
		"reputation"=>0,
		"CommunityID"=>$mySQL->insert("gb_community", [
			"CitizenID"=>($CitizenID+1),
			"Name"=>$p['name'],
			"Phone"=>$p['phone'],
			"Email"=>$p['email']
		])
	];
}else $mySQL->query("UPDATE gb_community SET Name='".$p['name']."',reputation=reputation+1 WHERE CommunityID=".$citizen['CommunityID']." LIMIT 1");

$log = "<span class='red'>".$p['name']."</span> <small class='gold'>[".date("d M, H:i:s")."]</small>
<div>Created order<br>Buyer reputation: <span class='gold'>".$citizen['reputation']."</span><br>Pice: <span class='green'>".$total." uah</span></div>";

$orderID = $mySQL->insert("gb_orders", [
	"CommunityID"=>$citizen['CommunityID'],
	"created"=>$time,
	"modified"=>$time,
	"type"=>$p['type'],
	"payment"=>$p['payment'],
	"price"=>money_format("%i", $total),
	"delivery"=>JSON::encode([
		"tracking"=>"",
		"city"=>$p['city'],
		"office"=>$p['office']
	]),
	"body"=>JSON::encode($cart),
	"log"=>$mySQL->escape_string($log)
]);
$sent = mail($config->email, "=?utf-8?B?".base64_encode("Новый Заказ №".$orderID)."?=", $message, $headers);
print (INT)$sent;

?>