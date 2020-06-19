<?php

$cart = JSON::load('php://input');

require_once("core/db.php");

$IDs = [];
//foreach($p as $item){ $IDs[] = $item['ModelID']; }
//$models = $mySQL->get("SELECT * FROM gb_models CROSS JOIN gb_items USING(ItemID) LEFT JOIN gb_discounts USING(DiscountID) WHERE gb_models.PageID IN (".implode(",",$IDs).")");

$models = $mySQL->getTree("ItemID","cart", "
SELECT 
	PageID,
	({str}) AS cart,
	(gb_items.ItemID) AS ItemID,
	name,
	label,
	preview,
	selling,
	units,
	(gb_discounts.discount) AS discount
FROM gb_items
CROSS JOIN gb_models USING(`PageID`) 
LEFT JOIN gb_discounts USING(`DiscountID`) 
WHERE gb_items.ItemID IN (".implode(",",$cart['IDs']).")", "cart")['cart'];

foreach($models as $item):
	$last_price = $label = "";
	if($item['DiscountID']){
		$label = "<label class='discount'>".$item['sticker']."</label>";
		if($item['discount']){
			$discount = ($item['selling'] * $item['discount']) / 100;
			$price = money_format("%i", ($item['selling'] - $discount));
			$lost_price = "<s class='lost-price'>".money_format("%i", $item['selling'])."грн.</s>";
		}
	}else $price = money_format("%i", $item['selling']);?>
	<div class="preview additem">
		<label class="close-btn">&#xe5cd;</label>
		<a href="/<?=translite($item['name'])?>-<?=$item['PageID']?>">
			<?=$label?>
			<img src="<?=$item['preview']?>">
			<div class="item-name"><?=$item['name']?></div>
			<?=$lost_price?>
			<div class="item-price"><?=$price?> грн.</div>
		</a>
	</div>
<?endforeach?>