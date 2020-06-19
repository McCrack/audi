<?php

switch(ARG_2){
	case "save":
		if(defined("ARG_4")){
			$settings = JSON::load('php://input');
			$saved = JSON::save("../".ARG_3."/modules/".ARG_4."/config.init", array_shift($settings));
		}else $saved = file_put_contents("../".ARG_3."/config.init", $HTTP_RAW_POST_DATA);
		print($saved);
	break;
	case "module-save":
		print file_put_contents("modules/".ARG_3."/config.init", file_get_contents('php://input'));
	break;
	case "showsubdomain":
		if(defined("ARG_4")):?>
		<tr class="v-bar-bg" height="36"><td class="section" align="center" colspan="5"><?=ARG_4?></td></tr>
		<?foreach(JSON::load("../".ARG_3."/modules/".ARG_4."/config.init") as $key=>$val):?>
		<tr data-type="<?=$val['type']?>">
			<th class="tool" title="add row" data-translate="title" onclick="addRow(this.parentNode)">+</th>
			<td align="center" data-translate="textContent" data-key="<?=$key?> <?=(empty($key) ? "contenteditable='true'" : "")?>"><?=$key?></td>
			<td contenteditable="true"><?=$val['value']?></td>
			<td contenteditable="true">
			<?switch($key):
				case "status": print implode(", ", ["enabled","disabled"]); break;
				case "access": eval("show_".$mySQL->getRow("SHOW COLUMNS FROM gb_staff LIKE 'Group'")['Type'].";"); break;
				default: print implode(", ", $val['valid']); break;
			endswitch?>
			</td>
			<th class="tool" title="delete row" data-translate="title" onclick="deleteRow(this.parentNode)">✕</th>
		</tr>
		<?endforeach;

		elseif(defined("ARG_3")):
			$subdomains=$modules=$themes = [];
			foreach(scandir("..") as $folder){
				if(($folder!="." && $folder!="..") && is_dir("../".$folder)) $subdomains[] = $folder;
			}
			foreach(scandir("../".ARG_3."/modules") as $module){
				if(is_dir("../".ARG_3."/modules/".$module) && $module!="." && $module!="..") $modules[] = $module;
			}
			foreach(scandir("../".ARG_3."/themes") as $dir){
				if(is_dir("../".ARG_3."/themes/".$dir) && $dir!="." && $dir!="..") $themes[] = $dir;
			}
			foreach(JSON::load("../".ARG_3."/config.init") as $name=>$section):?>
			<tr class="v-bar-bg" height="36"><td class="section" align="center" colspan="5"><?=$name?></td></tr>
			<?foreach($section as $key=>$val):?>
			<tr data-type="<?=$val['type']?>">
				<th class="tool" title="add row" data-translate="title" onclick="addRow(this.parentNode)">+</th>
				<td align="center" data-translate="textContent" data-key="<?=$key?> <?=(empty($key) ? "contenteditable='true'" : "")?>"><?=$key?></td>
				<td contenteditable="true"><?=$val['value']?></td>
				<td contenteditable="true">
				<?switch($key):
					case "subdomain":
					case "mobile subdomain":
					case "desktop subdomain":
					case "base folder": print implode(", ",$subdomains); break;
					case "default module": print implode(", ", $modules); break;
					case "theme":
					case "mobile theme": print implode(", ", $themes); break;
					default: print implode(", ", $val['valid']); break;
				endswitch?>
				</td>
				<th class="tool" title="delete row" data-translate="title" onclick="deleteRow(this.parentNode)">✕</th>
			</tr>
			<?endforeach; endforeach;
		endif;
	break;
	default:break;
}
?>
<?function show_enum(){ print implode(", ", func_get_args()); }?>