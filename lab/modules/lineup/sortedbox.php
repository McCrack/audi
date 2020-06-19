<?php
	
	$rows = $mySQL->get("SELECT ModelID,SortID,model,class,body FROM gb_lineup CROSS JOIN gb_classes USING(ClassID) GROUP BY ModelID ORDER BY SortID");
	$handle = "w:".time();

?>
<div id="<?=$handle?>" class="mount" style="width:600px">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<form class="box white-bg">
		<button type="reset" class="close-btn white-txt" title="close" data-translate="title">✕</button>
		<div class="box-caption black-bg">&#xf077;<?include_once("components/movebox.php")?></div>
		<div class="h-bar logo-bg">
			<span>Sorted</span>
			<hr class="separator">
			<div class="toolbar t">
				<label title="Refresh" class="tool" onclick="">&#xf021;</label>
			</div>
		</div>
		<div class="box-body">
			<div class="h-bar">
				<input name="SortID">
				<input name="ModelID" list="ModelList">
				<datalist>
				<?foreach($rows as $i=>$row):?>
					<option value="<?=$row['ModelID']?>"><?=$row['model']?></option>
				<?endforeach?>
				</datalist>
			</div>

			<table width="100%" rules="cols" cellpadding="4" cellspacing="0" bordercolor="#CCC">
				<thead>
					<tr class="h-bar-bg">
						<th></th>
						<th>Sorted ID</th>
						<th>Model</th>
						<th>Lineup</th>
					</tr>
				</thead>
				<tbody align="center">
					<?foreach($rows as $i=>$row):?>
					<tr>
						<td><?=$i?></td>
						<td data-id="<?=$row['ModelID']?>" contenteditable="true"><?=$row['SortID']?></td>
						<td><?=$row['model']?></td>
						<td><?=($row['class']." ".$row['body'])?></td>
					</tr>
					<?endforeach?>
					<script>
					(function(body){
						body.oninput=function(event){
							var cell = event.target;
							clearTimeout(cell.timeout);
							cell.timeout = setTimeout(function(){
								XHR.push({
									addressee:"/lineup/actions/assort/"+cell.dataset.id+"/"+cell.textContent.trim()
								});
							},1000);
						}
					})(document.currentScript.parentNode)
					</script>
				</tbody>
			</table>
		</div>
		<script>document.currentScript.parentNode.onreset=function(){this.drop()}</script>
	</form>
	<script>
	(function(mount){
		location.hash = "<?=$handle?>";
		translate.fragment(mount);
		if(mount.offsetHeight>(screen.height - 40)){
			mount.style.top = "20px";
		}else mount.style.top = "calc(50% - "+(mount.offsetHeight/2)+"px)";
	})(document.currentScript.parentNode);
	</script>
</div>