<?php
$staff = preg_split("/,\s*/", JSON::load("modules/staff/config.init")['access']['value'], -1, PREG_SPLIT_NO_EMPTY);
$settings = preg_split("/,\s*/", JSON::load("modules/settings/config.init")['access']['value'], -1, PREG_SPLIT_NO_EMPTY);
$access = [
	"staff"=>in_array(USER_GROUP, $staff),
	"settings"=>in_array(USER_GROUP, $settings)
];

if(defined("ARG_3")){
	$car = $mySQL->getRow("
	SELECT * FROM gb_lineup
	CROSS JOIN gb_pages USING(PageID)
	CROSS JOIN gb_classes USING(ClassID)
	CROSS JOIN gb_static USING(PageID)
	WHERE PageID LIKE {int}
	LIMIT 1", ARG_3);
	define("PAGE_ID", $car['PageID']);
	define("FAMILY", $car['ClassID']);
	define("MODEL_ID", $car['ModelID']);
}else{
	define("PAGE_ID", 0);
	define("FAMILY", 0);
}
$cng = new config("../".BASE_FOLDER."/".$config->{"config file"});

?>
<!DOCTYPE html>
<html>
	<head>
		<?include_once("components/head.php")?>
		<link rel="stylesheet" type="text/css" href="/modules/lineup/index.css">
		<script src="/modules/sitemap/tpl/sitemap.js"></script>
		<script src="/xhr/wordlist?d[0]=base&d[1]=modules&d[2]=sitemap" defer charset="utf-8"></script>
		<script src="/js/ace/src-min/ace.js" type="text/javascript" charset="utf-8"></script>
	</head>
	<body>
		<input id="mediaset-shower" type="checkbox" hidden>
		<input id="screenmode" type="checkbox" autocomplete="off" hidden onchange="STANDBY.screenmode=this.checked">
		<div id="wrapper">
			<input id="leftbar-shower" type="checkbox" autocomplete="off" hidden>
			<input id="rightbar-shower" type="checkbox" autocomplete="off" hidden>
			<nav class="h-bar logo-bg t">
				<label for="leftbar-shower"></label>
				<a href="/" id="goolybeep">G</a>
				<label for="rightbar-shower"></label>
			</nav>
			<aside class="body-bg">
				<div class="tabs">
					<input id="left-default" name="tabs" type="radio" form="leftbar-tabs" hidden>
					<div id="modules-tree" class="tab body-bg light-txt"><?include_once("components/modules.php")?></div>

					<input id="lineup-tab" name="tabs" type="radio" form="leftbar-tabs" hidden checked>
					<div id="lineup" class="tab body-bg light-txt">
						<div class="h-bar white-txt" data-translate="textContent">lineup</div>
						
						<div class="root">
							<div class="root">
							<?php
							$class = "";
							$lineup = $mySQL->get("SELECT * FROM gb_classes ORDER BY class");
							foreach($lineup as $vehicle):
								if($vehicle['class']!=$class):$class=$vehicle['class']?>
							</div>
							<input id="<?=$class?>" type="radio" name="tree" value="<?=$class?>" <?if($class==ARG_1):?>checked<?endif?> hidden autocomplete="off">
							<label for="<?=$class?>"><?=$class?></label>
							<div class="root">
								<?endif?>
								<a class="body<?if($vehicle['ClassID']==ARG_2):?> active-txt<?endif?>" href="/lineup/<?=$class?>/<?=$vehicle['ClassID']?>"><?=$vehicle['body']?></a>
							<?endforeach?>
							</div>
							<script>
							(function(root){
								root.onchange=function(event){
									doc.querySelector("#wrapper>main>input[value='"+event.target.value+"']").checked=true;
									history.pushState({}, event.target.value, "/lineup/"+event.target.value);
								}
							})(document.currentScript.parentNode)
							</script>
						</div>
						<script>
						(function(map){
							map.onscroll=function(){STANDBY.mapScrollTop = map.scrollTop;}
						})(document.currentScript.parentNode)
						</script>
					</div>
				</div>
				<form id="leftbar-tabs" class="v-bar l" autocomplete="off">
					<div class="toolbar">
						<label title="modules" class="tool" for="left-default" data-translate="title">⋮</label>
						<label title="lineup" class="tool" for="lineup-tab" data-translate="title">&#xe902;</label>
					</div>
					<div class="toolbar">
						<label title="navigator" class="tool" data-translate="title" onclick="new Box(null, 'navigator/box')">&#xf07c;</label>
						<label title="mediaset" class="tool" data-translate="title" onclick="new Box(null, 'mediaset/box')">&#xe94b;</label>
					</div>
					<div class="toolbar">
						<label title="keywords" class="tool" data-translate="title" onclick="new Box(null, 'keywords/box')">&#xe9d3;</label>
						<?if($access['settings']):?>
						<label title="settings" class="tool" data-translate="title" onclick="new Box(null, 'settings/box')">&#xf013;</label>
						<?endif?>
						<?if($access['staff']):?>
						<label title="staff" class="tool" data-translate="title" onclick="new Box(null, 'staff/box')">&#xe972;</label>
						<?endif?>
					</div>
					<script>
					(function(bar){
						bar.onsubmit=function(event){ event.preventDefault(); }
						bar.tabs.forEach(function(tab){ tab.onchange=function(event){
							if(event.target.id!="left-default") STANDBY.leftbar = event.target.id;
						}});
    					if(STANDBY.leftbar) bar[STANDBY.leftbar].checked = true;
					})(document.currentScript.parentNode);
					</script>
				</form>
			</aside>
			<header class="h-bar t black-bg">
				<?if(PAGE_ID):?><a class="tool" title="Back" href="/lineup/<?=ARG_1?>">❬</a><?endif?>
				<div class="toolbar t">
					<label title="add model" data-translate="title" class="tool" onclick="new Box('<?=FAMILY?>','lineup/addmodelbox')">&#xe89c;</label>
					<label title="Sorted Box" class="tool" onclick="new Box(null,'lineup/sortedbox')">&#xf05e;</label>
				</div>
				<div class="toolbar r right">
					<?if($access['settings']):?>
					<label title="settings" data-translate="title" class="tool" onclick="new Box(null, 'settings/module_settingsbox/<?=SECTION?>');">&#xf013;</label>
					<?endif?>
				</div>
				<?if(PAGE_ID):?>
				<div class="toolbar t">
					<button title="save" form="metadata" data-translate="title" class="tool transparent-bg light-txt" type="submit">&#xf0c7;</button>
					<button title="remove" form="metadata" data-translate="title" class="tool transparent-bg light-txt" type="reset">&#xe94d;</button>
				</div>

				<div class="toolbar t right">
					<label for="screenmode" class="screenmode-btn" title="screen mode" data-translate="title" class=""></label>
				</div>
				<hr class="separator right">
				<div class="toolbar t right">
					<label id="mediaset-shower-btn" for="mediaset-shower" title="show mediaset" class="tool" data-translate="title">&#xe94b;</label>
					<label for="reset" title="reset mediaset" class="tool" data-translate="title">&#xf021;</label>
				</div>
				<?endif?>
			</header>
			<main class="light-txt">
				<?if(PAGE_ID):?>
				<form id="mediaset" class="tab">
					<input id="reset" type="reset" hidden>
					<input name="setid" value="<?=$vehicle['SetID']?>" type="hidden">
					<iframe width="100%" height="500" frameborder="no"></iframe>
					<script>
					(function(form){
						var frame = form.querySelector("iframe");
						var imgset = frame.contentWindow;	
						window.addEventListener("load",function(){
							frame.onload=function(){
								form.setid.value = imgset.SETID || "NULL"
								frame.height = imgset.document.body.scrollHeight+20;
							}

							reauth();
							imgset.location.href = (<?if(empty($car['SetID'])):?>false<?else:?>true<?endif?>) 
								? "/mediaset/set/<?=$car['SetID']?>"
								: "/mediaset/set";
						});
						form.onreset=function(event){
							event.preventDefault();
							imgset.location.href = "/mediaset/set";
						}
					})(document.currentScript.parentNode);
					</script>
				</form>
				<iframe src="/editor/embed" width="100%" height="100%" frameborder="no"></iframe>
				<script>var EDITOR = document.currentScript.previousElementSibling.contentWindow;</script>
				<?else:?>
				<div>
				<?foreach($lineup as $vehicle):
					if($vehicle['class']!=$class):$class=$vehicle['class']?>
				</div>
				<input type="radio" name="lineup" value="<?=$class?>" <?if($class==ARG_1):?>checked<?endif?> hidden autocomplete="off">
				<div class="tile active-bg" data-method="family" title="<?=$class?>">
					<?endif?>
					<div>
						<a data-id="<?=$vehicle['ClassID']?>" class="snippet" href="/lineup/<?=$class?>/<?=$vehicle['ClassID']?>">
							<div class="preview"><img src="<?=$vehicle['front']?>" alt="&#xe94a;"></div>
							<div class="header"><?=$vehicle['body']?></div>
						</a>
					</div>
				<?endforeach?>
				</div>
				<?if(defined("ARG_2")):
				$lineup = $mySQL->get("SELECT * FROM gb_lineup LEFT JOIN gb_classes USING(ClassID) WHERE ClassID={int} GROUP BY ModelID ORDER BY SortID", ARG_2)?>
				<div class="tile white-bg" data-method="lineup" title="<?=ARG_1?> <?=$lineup[0]['body']?>">
					<?foreach($lineup as $vehicle):?>
					<div>
						<a class="snippet" href="/lineup/<?=(ARG_1.'/'.$vehicle['ClassID'].'/'.$vehicle['PageID'])?>" data-id="<?=$vehicle['PageID']?>">
							<div class="preview"><img src="<?=$vehicle['profile']?>" alt="&#xe94a;"></div>
							<div class="header"><?=$vehicle['model']?></div>
							<div class="options">
								<span><?=$vehicle['language']?></span>
								<span <?if($vehicle['published']=="Published"):?>class="green-txt"<?endif?>><?=$vehicle['published']?></span>
							</div>
						</a>
					</div>
					<?endforeach?>
				</div>
				<?endif?>
				<?endif?>
			</main>
			<?if(PAGE_ID):?>
			<section>
				<div class="tabs">
					<input id="right-default" name="tabs" type="radio" form="rightbar-tabs" hidden checked>
					<form id="metadata" class="tab body-bg light-txt" autocomplete="off">
						<input id="side-tab" type="radio" name="family-img" hidden checked>
						<input id="face-tab" type="radio" name="family-img" hidden>
						<input id="back-tab" type="radio" name="family-img" hidden>
						<div class="toolbar right">
							<label for="side-tab">SIDE</label>
							<label for="face-tab">FACE</label>
							<label for="back-tab">BACK</label>
						</div>
						<div class="h-bar"><?=($car['class']." ".$car['body'])?></div>
						<div id="side">
							<iframe frameborder="no"></iframe>
							<script>
							(function(script){
								var frame =  script.previousElementSibling;
								var	navigator = frame.contentWindow, options = [];
								navigator.standby = (window.localStorage['navigator'] || "undefined").jsonToObj() || {};

								if(navigator.standby.subdomain) options.push("subdomain="+navigator.standby.subdomain);
								if(navigator.standby[navigator.standby.subdomain]) options.push("path="+navigator.standby[navigator.standby.subdomain]);

								window.addEventListener("load",function(){
									reauth();
									navigator.location.href="/navigator/folder/image/radio?"+options.join("&");
									frame.onload=function(){
										navigator.onchange=function(event){
											if(event.target.name=="files-on-folder"){
												script.nextElementSibling.src=event.target.value;

												XHR.push({
													addressee:"/lineup/actions/change-side/<?=$car['ClassID']?>",
													body:event.target.value
												});
											}
										}
									}
								});
							})(document.currentScript)
							</script>
							<img src="<?=$car['side']?>" alt="&#xe94a;">
						</div>
						<div id="face">
							<iframe frameborder="no"></iframe>
							<script>
							(function(script){
								var frame =  script.previousElementSibling;
								var	navigator = frame.contentWindow, options = [];
								navigator.standby = (window.localStorage['navigator'] || "undefined").jsonToObj() || {};

								if(navigator.standby.subdomain) options.push("subdomain="+navigator.standby.subdomain);
								if(navigator.standby[navigator.standby.subdomain]) options.push("path="+navigator.standby[navigator.standby.subdomain]);

								window.addEventListener("load",function(){
									reauth();
									navigator.location.href="/navigator/folder/image/radio?"+options.join("&");
									frame.onload=function(){
										navigator.onchange=function(event){
											if(event.target.name=="files-on-folder"){
												script.nextElementSibling.src=event.target.value;

												XHR.push({
													addressee:"/lineup/actions/change-front/<?=$car['ClassID']?>",
													body:event.target.value
												});
											}
										}
									}
								});
							})(document.currentScript)
							</script>
							<img src="<?=$car['front']?>" alt="&#xe94a;">
						</div>
						<div id="back">
							<iframe frameborder="no"></iframe>
							<script>
							(function(script){
								var frame =  script.previousElementSibling;
								var	navigator = frame.contentWindow, options = [];
								navigator.standby = (window.localStorage['navigator'] || "undefined").jsonToObj() || {};

								if(navigator.standby.subdomain) options.push("subdomain="+navigator.standby.subdomain);
								if(navigator.standby[navigator.standby.subdomain]) options.push("path="+navigator.standby[navigator.standby.subdomain]);

								window.addEventListener("load",function(){
									reauth();
									navigator.location.href="/navigator/folder/image/radio?"+options.join("&");
									frame.onload=function(){
										navigator.onchange=function(event){
											if(event.target.name=="files-on-folder"){
												script.nextElementSibling.src=event.target.value;

												XHR.push({
													addressee:"/lineup/actions/change-back/<?=$car['ClassID']?>",
													body:event.target.value
												});
											}
										}
									}
								});
							})(document.currentScript)
							</script>
							<img src="<?=$car['back']?>" alt="&#xe94a;">
						</div>

						<div class="h-bar light-btn-bg">
							<div class="toolbar">
								<small>ID: <output name="PageID"><?=PAGE_ID?></output></small>
								<div class="select">
									<select name="language" class="active-txt">
										<?$pgs = $mySQL->get("SELECT language,ClassID,PageID FROM gb_lineup WHERE ModelID={str}", $car['ModelID']);
										foreach($pgs as $pg):?>
										<option <?if($pg['language']==$car['language']):?>selected<?endif?> value="<?=$pg['ClassID']?>/<?=$pg['PageID']?>"><?=$pg['language']?></option>
										<?endforeach?>
										<script>
										(function(select){
											select.onchange=function(){
												location.pathname = "lineup/<?=ARG_1?>/"+select.value;
											}
										})(document.currentScript.parentNode)
										</script>
									</select>
								</div>
							</div>
							<!-- Template -->
							<div class="select" title="template" data-translate="title">
								<select name="template" class="active-txt"> 
									<?foreach(glob("../".BASE_FOLDER."/themes/".$cng->theme."/includes/lineup/*.html") as $file):$file = pathinfo($file)['filename']?>
									<option <?if($file==$car['template']):?>selected<?endif?> value="<?=$file?>"'><?=$file?></option>
									<?endforeach?>
								</select>
							</div>
							<label class="right"><small>Published</small> <input name="published" <?if($car['published']=="Published"):?>checked<?endif?> type="checkbox"></label>
						</div>
						

						<!-- COVERS -->
						<input id="cover-tab" type="radio" name="cover-tab" hidden checked>
						<input id="profile-tab" type="radio" name="cover-tab" hidden>
						<div class="toolbar right">
							<br>
							<label for="cover-tab">COVER</label>
							<label for="profile-tab">PROFILE</label>
						</div>

						<fieldset class="left"><legend class="active-txt" data-translate="textContent">model</legend>
							<input name="model" value="<?=$car['model']?>" placeholder="..." size="15">
						</fieldset>
						<!-- URL Name -->
						<fieldset><legend class="active-txt">ModelID</legend>
							<input name="ModelID" value="<?=$car['ModelID']?>" data-id="<?=$car['ModelID']?>" placeholder="..." required>
						</fieldset>
							
							
						<div id="cover">
							<iframe frameborder="no"></iframe>
							<script>
							(function(script){
								var frame =  script.previousElementSibling;
								var	navigator = frame.contentWindow, options = [];
								navigator.standby = (window.localStorage['navigator'] || "undefined").jsonToObj() || {};

								if(navigator.standby.subdomain) options.push("subdomain="+navigator.standby.subdomain);
								if(navigator.standby[navigator.standby.subdomain]) options.push("path="+navigator.standby[navigator.standby.subdomain]);

								window.addEventListener("load",function(){
									reauth();
									navigator.location.href="/navigator/folder/image/radio?"+options.join("&");
									frame.onload=function(){
										navigator.onchange=function(event){
											if(event.target.name=="files-on-folder"){
												script.nextElementSibling.src=event.target.value;

												XHR.push({
													addressee:"/lineup/actions/change-cover/"+MODELID,
													body:event.target.value
												});
											}
										}
									}
								});
							})(document.currentScript)
							</script>
							<img src="<?=$car['cover']?>" alt="&#xe94a;">
						</div>
						<div id="profile">
							<iframe frameborder="no"></iframe>
							<script>
							(function(script){
								var frame =  script.previousElementSibling;
								var	navigator = frame.contentWindow, options = [];
								navigator.standby = (window.localStorage['navigator'] || "undefined").jsonToObj() || {};

								if(navigator.standby.subdomain) options.push("subdomain="+navigator.standby.subdomain);
								if(navigator.standby[navigator.standby.subdomain]) options.push("path="+navigator.standby[navigator.standby.subdomain]);

								window.addEventListener("load",function(){
									reauth();
									navigator.location.href="/navigator/folder/image/radio?"+options.join("&");
									frame.onload=function(){
										navigator.onchange=function(event){
											if(event.target.name=="files-on-folder"){
												script.nextElementSibling.src=event.target.value;

												XHR.push({
													addressee:"/lineup/actions/change-profile/"+MODELID,
													body:event.target.value
												});
											}
										}
									}
								});
							})(document.currentScript)
							</script>
							<img src="<?=$car['profile']?>" alt="&#xe94a;">
						</div>

						<div class="h-bar active-bg"><small data-translate="textContent">Options</small>
							<div class="toolbar r right">
								<label title="save" class="tool" onclick="saveOptions()" data-translate="title">&#xf0c7;</label>
								<label title="Pattern" class="tool" onclick="showPattern(optionsToJSON(doc.querySelector('#options')), jsontooptions);">⌘</label>
							</div>
							<script>
							function jsontooptions(json){
								var sobj = JSON.parse(json),
									tbody = doc.querySelector("#options>tbody");
									tbody.innerHTML = "";
								for(var key in sobj){
									var row = doc.create("tr");
									row.appendChild(doc.create("th",{title:"Add Row",class:"tool",onclick:"addRow(this)"},"+"));
									
									row.appendChild(doc.create("td",{contenteditable:"true"},key));
									row.appendChild(doc.create("td",{contenteditable:"true"},sobj[key]));
									
									row.appendChild(doc.create("th",{title:"Delete Row",class:"tool",onclick:"deleteRow(this)"},"✕"));
									tbody.appendChild(row);
								}
							}
							function optionsToJSON(owner){
								var key, options={};
								owner.querySelectorAll("tbody>tr>td").forEach(function(cell,i){
									if(i%2) options[key] = cell.textContent.trim();
									else key = cell.textContent.trim();
								});
								return JSON.encode(options);
							}
							function saveOptions(){
								XHR.push({
									addressee:"/lineup/actions/save-options/<?=PAGE_ID?>",
									body:JSON.encode((function(properties,key){
										document.querySelectorAll("#options>tbody>tr>td").forEach(function(cell,i){
											if(i%2) properties[key] = cell.textContent.trim();
											else key = cell.textContent.trim();
										});
										return properties;
									})({}))
								});
							}
							</script>
						</div>
						<table id="options" rules="cols" width="100%" cellpadding="5" cellspacing="0" bordercolor="#CCC">
							<colgroup><col width="36"><col><col><col width="36"></colgroup>
							<tbody class="dark-txt">
							<?
							$optionset = JSON::parse($car['optionset']);
							if(!empty($optionset)):foreach($optionset as $key=>$val):?>
								<tr>
									<th class="tool" title="add row" data-translate="title" onclick="addRow(this.parentNode)">+</th>
									<td contenteditable="true"><?=$key?></td>
									<td contenteditable="true"><?=$val?></td>
									<th class="tool" title="delete row" data-translate="title" onclick="deleteRow(this.parentNode)">✕</th>
								</tr>
							<?endforeach?>
							<?else:?>
								<tr>
									<th class="tool" title="add row" data-translate="title" onclick="addRow(this.parentNode)">+</th>
									<td contenteditable="true"></td>
									<td contenteditable="true"></td>
									<th class="tool" title="delete row" data-translate="title" onclick="deleteRow(this.parentNode)">✕</th>
								</tr>
							<?endif?>
							</tbody>
						</table>
						<br>
						<fieldset><legend>Title:</legend>
							<input name="pagetitle" value="<?=$car['title']?>" placeholder="...">
						</fieldset>
						<fieldset><legend>Context:</legend>
							<input name="context" value="<?=$car['context']?>" placeholder="...">
						</fieldset>
						<fieldset><legend>Description:</legend>
							<textarea name="description" placeholder="..."><?=$car['description']?></textarea>
						</fieldset>
						<script>
						(function(form){
							form.onsubmit=function(event){
								event.preventDefault();
								var box = new Box(true, "sitemap/logbox");
								box.onopen = function(){
									var mediasetform = document.querySelector("#mediaset");
										mediasetform.querySelector("iframe").contentWindow.save();
									XHR.push({
										addressee:"/lineup/actions/mediaset/<?=PAGE_ID?>/"+mediasetform.setid.value,
										onsuccess:function(response){
											if(parseInt(response)){
												box.body.appendChild(doc.create("h3", {}, "Mediaset - <span class='green-txt'>Saved</span>"));
											}else box.body.appendChild(doc.create("h3", {}, "Mediaset - <span class='red-txt'>Failed save or not changes</span>"));
											box.align();
										}
									});
									XHR.push({
										"Content-Type":"text/html",
										"addressee":"/lineup/actions/save-content/<?=PAGE_ID?>",
										"body":EDITOR.getContent(),
										"onsuccess":function(response){
											if(parseInt(response)){
												box.body.appendChild(doc.create("h3", {}, "Content - <span class='green-txt'>Saved</span>"));
											}else box.body.appendChild(doc.create("h3", {}, "Content - <span class='red-txt'>Failed save or not changes</span>"));
											box.align();
										}
									});
								}
							}
							form.onreset=function(event){
								event.preventDefault();
								confirmBox("remove vehicle", function(){
									XHR.push({
										addressee:"/lineup/actions/remove-vehicle/<?=MODEL_ID?>", 
										onsuccess:function(response){
											setTimeout(function(){
												isNaN(response) ? alertBox(response) : (location.href = "/lineup/"+LANGUAGE); 
											}, 300);
										}
									});
								});		
							}
							form.ModelID.onchange=function(){
								form.ModelID.value = form.ModelID.value.trim()
								XHR.push({
									addressee:"/lineup/actions/change-modelid/"+form.ModelID.dataset.id,
									body:form.ModelID.value,
									onsuccess:function(response){
										if(parseInt(response)){
											MODELID = form.ModelID.dataset.id = form.ModelID.value;
										}else alertBox("UNKNOW ERROR:", ["logo-bg","big-txt"]);
									}
								});
							}
							form.model.onchange=
							form.template.onchange=
							form.context.onchange=
							form.pagetitle.onchange=
							form.description.onchange=function(event){
								XHR.push({
									addressee:"/lineup/actions/change-"+event.target.name+"/"+form.ModelID.value+"/<?=$car['language']?>",
									body:event.target.value.trim()
								});
							}
							form.published.onchange=function(){
								XHR.push({
									addressee:"/lineup/actions/change-published/"+form.ModelID.value,
									body:form.published.checked ? "Published" : "Not published"
								});
							}
						})(document.currentScript.parentNode);
						</script>
					</form>

					<input id="codefullscreen" name="codefullscreen" type="checkbox" hidden autocomplete="off" form="rightbar-tabs">
					<input id="code-editor-tab" name="tabs" type="radio" form="rightbar-tabs" hidden>
					<div id="code" class="tab">
						<div class="h-bar dark-btn-bg">
							<span class="tool">&#xeae4;</span> HTML
							<div class="toolbar r right">
								<label for="codefullscreen" title="screen mode" data-translate="title" class="screenmode-btn"></label>
							</div>
						</div>
						<xmp><?=gzdecode($car['content'])?></xmp>
						<script>
						var	CODE = ace.edit(document.currentScript.previousElementSibling);
							CODE.setTheme("ace/theme/twilight");
							CODE.getSession().setMode("ace/mode/html");
							CODE.setShowInvisibles(false);
							CODE.setShowPrintMargin(false);
							CODE.resize();
							CODE.session.on('change', function(event){
								if(CODE.curOp && CODE.curOp.command.name){
									html_change = true;
									setTimeout(function(){
										if(html_change) EDITOR.setContent(CODE.session.getValue());
										html_change = false;
									},1000);
								}
							});
						EDITOR.onload = function(){
							EDITOR.CODE = CODE;
							EDITOR.setContent( CODE.session.getValue() );
							EDITOR.save = function(){
								XHR.push({
									"Content-Type":"text/html",
									"addressee":"/sitemap/actions/save-content/<?=PAGE_ID?>",
									"body":EDITOR.getContent()
								});
							}
						}
						window.addEventListener("keydown",function(event){
							if((event.ctrlKey || event.metaKey) && event.keyCode==83){
								event.preventDefault();
								EDITOR.save();
							}
						});
						</script>
					</div>
				</div>
				<form id="rightbar-tabs" class="v-bar r v-bar-bg" data-default="right-default" autocomplete="off">
					<label title="Metadata" class="tool" for="right-default" data-translate="title">&#xe871;</label>
					<label title="code editor" class="tool" for="code-editor-tab" data-translate="title">&#xeae4;</label>
					<script>
					(function(bar){
						bar.onsubmit=function(event){ event.preventDefault(); }
						bar.tabs.forEach(function(tab){ tab.onchange=function(event){
							STANDBY.rightbar = event.target.id;
						}});
						if(STANDBY.rightbar) bar[STANDBY.rightbar].checked = true;
						bar.codefullscreen.onchange=function(){
							CODE.resize();
						}
					})(document.currentScript.parentNode);
					</script>
				</form>
			</section>
			<?endif?>
		</div>
		<script>
		<?if(PAGE_ID):?>
		(function(body){
			body.querySelector("#screenmode").checked = (STANDBY.screenmode=="true");
		})(document.currentScript.parentNode);
		<?endif?>
		var LANGUAGE = "<?=$language?>";
		var MODELID = "<?=MODEL_ID?>";
		function reloadTree(lang){
			var path = location.pathname.split(/\//);
			path[2] = lang;
			XHR.push({
				addressee:"/sitemap/actions/reload-tree/"+lang+"/sitemap",
				onsuccess:function(response){
					doc.querySelector("#sitemap>.root").outerHTML = response;
					window.history.pushState("", "tree", path.join("/"));
				}
			});
		}
		</script>
	</body>
</html>