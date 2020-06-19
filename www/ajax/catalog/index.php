<div class="grid">
	
<?php

require_once("core/db.php");

$p = JSON::load('php://input');

$map = $mySQL->getTree("name", "parent", "SELECT PageID,name,parent FROM gb_sitemap WHERE Published & 2");
function branch(&$map,&$branch,$point){
	foreach($map[$point] as $item){
		$branch[] = $item['PageID'];
		branch($map,$branch,$item['name']);
	}
}
$IDs = [$p['PageID']];
branch($map,$IDs,$p['category']);

$where = [ "`CategoryID` IN (".implode(",", $IDs).")" ];

$filters = explode("_", $p['filter']);
if(1==count($filters)) $filter = $mySQL->getRow("SELECT id FROM gb_filters WHERE translit LIKE {str} LIMIT 1", PAGE);

if(empty($filter)){
	foreach($filters as $filter){
		$sections = explode("z", $filter);
		foreach($sections as $field=>$val){
			$val = intval($val, 35);
			if($val>0) $where[] = "(`".$field."` & ".$val.")";
		}
	}	
}else $where[] = "(`".(($filter['id']/33)>>0)."` & ".pow(2, ($filter['id']-1)%32).")";

$sorted = [
	"rating"=>"rating DESC",
	"created"=>"created DESC",
	"selling"=>"discount DESC,selling"
][$p['sorted']];

$limit = 12;
$catalog = $mySQL->get("
SELECT SQL_CALC_FOUND_ROWS * FROM gb_models
CROSS JOIN gb_tagination USING(tid)
CROSS JOIN gb_pages USING(PageID)
CROSS JOIN gb_items USING(ItemID)
LEFT JOIN gb_discounts USING(DiscountID) 
WHERE ".implode(" AND ", $where)."
ORDER BY ".$sorted."
LIMIT {int}", $limit);

foreach($catalog as $item):
	$discount = 0;
	$brands[] = $item['brand'];
	$item['selling'] *= $config->{$item['currency']}?>
	<a class="preview" href="/<?=(translite($item['name'].'-'.$item['label']).'-'.$item['PageID'].'/'.$item['ItemID'])?>">
		<img src="<?=$item['preview']?>">
		<div class="name">
			<div class="brand gold"><?=$item['brand']?></div>
			<?=$item['name']?>
		</div>
		<div class="price gold">
			<?if($item['DiscountID'] && $item['discount']): $discount = ($item['selling'] * $item['discount']) / 100?>
			<label class="discount"><?=$item['sticker']?></label>
			<s><?=$item['selling']?></s>
			<?endif?>
			<span><?=($item['selling']-$discount)?></span><small>грн.</small>
		</div>
	</a>
<?endforeach?>
</div>
<br><br><br>
<div id="brands">
	<div class="caption" data-translate="textContent">brands</div>
	<?php
	$brands = array_unique($brands);
	foreach($brands as $brand):?>
	<a class="link" href="/<?=($p['category'].'/'.translite($brand))?>"><?=$brand?></a>
	<?endforeach?>
</div>
<div id="pagination">
<?php
$count = reset($mySQL->getRow("SELECT FOUND_ROWS()"));
$total=ceil($count/$limit);
$path = $p['category']."/".$p['sorted']."/".$p['filter'];
if($total>1):?>
	<a class="selected">1</a>
	<a href="/<?=$path?>/2">2</a>
	<?if($total>3):?>
		 ... <a href="/<?=($path.'/'.$total)?>"><?=$total?></a>
	<?elseif($total>2):?>
		 <a href="/<?=$path?>/3">3</a>
	<?endif;
endif?>
</div>
<br><br><br>