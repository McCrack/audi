<?php

switch(ARG_2){
	case "ad_model":
		$p = JSON::load('php://input');
		$time = time();

		$PageID = $mySQL->inquiry("INSERT INTO gb_pages SET {set}",[
			"type"=>"showcase",
			"created"=>$time,
			"modified"=>$time
		])['last_id'];
		
		$mySQL->inquiry("INSERT INTO gb_showcase SET {set}",[
			"PageID"=>$PageID,
			"CategoryID"=>$p['category'],
			"articul"=>$p['articul'],
			"named"=>$p['name']
		]);
		print $PageID;
	break;
	case "rl_tree":
		$tree = $mySQL->getTree("name","parent","SELECT parent,name,header,language,published,type FROM gb_sitemap CROSS JOIN gb_pages USING(PageID) WHERE language LIKE {str} ORDER BY SortID ASC", ARG_3);
		print_r($tree['prodazh-avtomobiliv-audi']);
		foreach($tree['prodazh-avtomobiliv-audi'] as $key=>$val) if($val['type']=="category"):?>
			<a href="/showcase/<?=$val['language']?>/<?=$val['name']?>" class="<?if($val['published']==='Published'):?>published-txt<?else:?>white-txt<?endif?>">
				<?=(empty($val['header'])?$val['name']:$val['header'])?>
			</a>
			<?staticTree($tree, $key);
		endif;
		//print staticTree($tree);
	break;
	case "rl_list":
		$rows = $mySQL->getTree("name", "parent", "SELECT PageID,name,parent,header FROM gb_sitemap WHERE language LIKE {str}", ARG_3);
		print catlist($rows);
	break;
	case "sv_filterset":
		$p = JSON::load('php://input');
		$filterset = [];
		foreach($p as $setname=>$set){
			$filterset[$setname] = [];
			foreach($set as $key=>$value){
				$id = $mySQL->getRow("SELECT FilterID FROM gb_filters WHERE value LIKE {str}", $key)['FilterID'];
				if(empty($id)){
					$id = $mySQL->inquiry("INSERT INTO gb_filters SET {set}", [
						"value"=>$key,
						"caption"=>$value
					])['last_id'];
				}
				$filterset[$setname][$id] = $value;
			}
		}
		$mySQL->inquiry("UPDATE gb_static SET filterset={str} WHERE PageID={int} LIMIT 1", JSON::encode($filterset), ARG_1);
	break;
	case "ch_model":
		$value = base64_decode($HTTP_RAW_POST_DATA);
		if(ARG_4=="articul") $value = (INT)$value;
		print $mySQL->inquiry("UPDATE gb_showcase SET {fld}={str} WHERE PageID={int}", ARG_4, $value,ARG_3)['affected_rows'];
		$mySQL->inquiry("UPDATE gb_pages SET modified={int} WHERE PageID={int} LIMIT 1", time(), ARG_3);
	break;
	case "cl_page":
		$p = JSON::load('php://input');
		
		$prototype = $mySQL->getRow("
		SELECT * FROM gb_pages
		CROSS JOIN gb_showcase USING(PageID)
		WHERE PageID={int} LIMIT 1",
		ARG_3);

		$MID = $mySQL->getRow("SELECT MaterialID FROM gb_sitemap WHERE PageID={int} LIMIT 1", $prototype['CategoryID'])['MaterialID'];
		$CategoryID = $mySQL->getRow("SELECT PageID FROM gb_sitemap WHERE MaterialID={int} AND language LIKE {str} LIMIT 1", $MID,$p['language'])['PageID'];

		if(empty($CategoryID)) exit;

		$PageID = $mySQL->inquiry("INSERT INTO gb_pages (created,modified,type) VALUES ({int},{int},{str})", $prototype['created'], time(), $prototype['type'])['last_id'];
		$mySQL->inquiry("INSERT INTO gb_showcase SET {set}", [
			"PageID"=>$PageID,
			"CategoryID"=>$CategoryID,
			"articul"=>$prototype['articul'],
			"status"=>$prototype['status'],
			"preview"=>$prototype['preview'],
			"price"=>$prototype['price'],
			"currency"=>$prototype['currency'],
			"subtemplate"=>$prototype['subtemplate'],
			"options"=>$prototype['options'],
			"mediaset"=>$prototype['mediaset'],
			"engine"=>$prototype['engine'],
			"horsepower"=>$prototype['horsepower'],
			"language"=>$p['language'],
			"named"=>base64_decode($p['named'])
		]);
		print $PageID;
	break;
	case "rm_vehicle":
		$IDs = $mySQL->getGroup("SELECT PageID FROM gb_showcase WHERE articul={int}", ARG_3)['PageID'];
		print $mySQL->inquiry("DELETE FROM gb_pages WHERE PageID IN ({arr})", $IDs)['affected_rows'];
	break;
	/*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*/
	case "sv_optionset":
		$mySQL->inquiry("UPDATE gb_static SET optionset={str} WHERE PageID={int} LIMIT 1", file_get_contents('php://input'), ARG_1);
	break;
	case "st_filter":
		print $mySQL->inquiry("INSERT INTO item_vs_filters SET PageID = {int}, FilterID = {int}", ARG_1, ARG_2)['affected_rows'];
	break;
	case "dp_filter":
		print $mySQL->inquiry("DELETE FROM item_vs_filters WHERE PageID = {int} AND FilterID = {int}", ARG_1, ARG_2)['affected_rows'];
	break;
	case "sv_images":
		$data = file_get_contents('php://input');
		print $mySQL->inquiry("UPDATE gb_showcase SET mediaset={str} WHERE PageID = {int}", $data,ARG_3)['affected_rows'];
	break;
	/*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*~*/
	case "ad_discount":
		$time = time();
		print $mySQL->inquiry("INSERT INTO gb_discounts SET begining={int},ended={int}", $time,$time)['last_id'];
		$mySQL->inquiry("UPDATE gb_pages SET modified={int} WHERE PageID={int} LIMIT 1", time(), ARG_3);
	break;
	case "gt_discount":
		$discount = $mySQL->getRow("SELECT * FROM gb_discounts WHERE DiscountID={int} LIMIT 1", ARG_3)?>
		<div align="left">
			<input type="checkbox" name="saved" hidden>
			<output value="<?=$discount['DiscountID']?>">Discount ID: </output>
			<input name="DiscountID" value="<?=$discount['DiscountID']?>" type="hidden">
		</div>
		<div class="left" style="white-space:nowrap;">
			<input name="sticker" value="<?=$discount['sticker']?>" class="text-field" placeholder="sticker" data-translate="placeholder" size="10">
			<input name="discount" value="<?=$discount['discount']?>" class="text-field" placeholder="value" data-translate="placeholder" size="8">
		</div>
		<span class="tool">&#xe900;</span>
		<input required name="begining" type="date" value="<?=date("Y-m-d", $discount['begining'])?>" class="text-field" size="9">
		<input required name="ended" type="date" value="<?=date("Y-m-d", $discount['ended'])?>" class="text-field" size="9"> 

		<input name="caption" value="<?=$discount['caption']?>" class="text-field" placeholder="named" data-translate="placeholder">
		<textarea name="essence" class="text-field" placeholder="description" data-translate="placeholder"><?=$discount['essence']?></textarea>
	<?break;
	case "ch_discount":
		print $mySQL->inquiry("UPDATE gb_discounts SET {fld}={str} WHERE DiscountID={int}", ARG_4, base64_decode($HTTP_RAW_POST_DATA),ARG_3)['affected_rows'];
	break;
	case "rs_discount":
		print $mySQL->inquiry("UPDATE gb_showcase SET DiscountID=NULL WHERE PageID={int}", ARG_3)['affected_rows'];
	break;
	case "dl_discount":
		print $mySQL->inquiry("DELETE FROM gb_discounts WHERE DiscountID={int}" ,ARG_3)['affected_rows'];
	break;
	default:break;
}

/***************************************************************************/

function staticTree(&$items, $offset){
	if(is_array($items[$offset])):?>
	<div class="root">
	<?foreach($items[$offset] as $key=>$val):?>
		<a href="/showcase/<?=($val['language'].'/'.$val['name'])?>" class="<?if($val['published']==='Published'):?>published-txt<?else:?>white-txt<?endif?>"><?=(empty($val['header'])?$val['name']:$val['header'])?></a>
		<?staticTree($items, $key);
	endforeach?>
	</div>
	<?endif;
}

function catlist(&$items, $offset="novi-avtomobili-audi"){
	if(is_array($items[$offset])):?>
		<?foreach($items[$offset] as $key=>$val):?>
		<option <?if($val['PageID']==ARG_3):?>selected<?endif?> value="<?=$val['PageID']?>"><?=(empty($val['header'])?$val['name']:$val['header'])?></option>
		<?catlist($items, $key);
		endforeach?>
	<?endif;
}

?>