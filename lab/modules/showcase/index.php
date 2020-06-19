<?php
	$staff = preg_split("/,\s*/", JSON::load("modules/staff/config.init")['access']['value'], -1, PREG_SPLIT_NO_EMPTY);
	$settings = preg_split("/,\s*/", JSON::load("modules/settings/config.init")['access']['value'], -1, PREG_SPLIT_NO_EMPTY);
	$access = [
		"staff"=>in_array(USER_GROUP, $staff),
		"settings"=>in_array(USER_GROUP, $settings)
	];

	if(defined("ARG_2")){
		if(is_numeric(ARG_2)){
			$model = $mySQL->getRow("
			SELECT * FROM gb_pages
			CROSS JOIN gb_showcase USING(PageID)
			WHERE gb_showcase.PageID = {int} LIMIT 1", ARG_2);

			if($mySQL->status['affected_rows']>0){
				define("PRODUCT", $model['PageID']);
				define("CATEGORY", $model['CategoryID']);
				$model['options'] = JSON::parse($model['options']);
				$category = $mySQL->getRow("
				SELECT filterset,optionset,name
				FROM gb_pages
				CROSS JOIN gb_sitemap USING(PageID)
				CROSS JOIN gb_static USING(PageID)
				WHERE PageID={int} LIMIT 1", CATEGORY);

				if((INT)$model['DiscountID']>0) $discount = $mySQL->getRow("SELECT * FROM gb_discounts WHERE DiscountID={int} LIMIT 1", $model['DiscountID']);
			}else{
				//header("Location: /showcase",true,301);
				//exit;
			}
		}else{
			$category = $mySQL->getRow("SELECT PageID,filterset,optionset,name,header FROM gb_sitemap CROSS JOIN gb_static USING(PageID) WHERE language LIKE {str} AND name LIKE {str} LIMIT 1", ARG_1, ARG_2);
			if($mySQL->status['affected_rows']>0){
				define("PRODUCT", false);
				define("CATEGORY", $category['PageID']);
				$feed = $mySQL->get("SELECT * FROM gb_showcase WHERE CategoryID={int}", CATEGORY);
			}else{
				//header("Location: /showcase",true,301);
				//exit;
			}
		}
	}else{
		define("PRODUCT", false);
		define("CATEGORY", false);
	}
	
?>
<!DOCTYPE html>
<html>
	<head>
		<?include_once("components/head.php")?>
		<link rel="stylesheet" type="text/css" href="/modules/showcase/index.css">
		<script src="/js/ace/src-min/ace.js" charset="utf-8"></script>
		<script src="/modules/code-editor/tpl/code-editor.js"></script>
		<script src="/xhr/wordlist/<?=USER_LANG?>?d[0]=base&d[1]=modules&d[2]=store" defer charset="utf-8"></script>
	</head>
	<body>
		<input id="screenmode" type="checkbox" autocomplete="off" hidden onchange="STANDBY.screenmode=this.checked">
		<div id="wrapper">
			<input id="leftbar-shower" type="checkbox" autocomplete="off" hidden>
			<input id="rightbar-shower" type="checkbox" autocomplete="off" hidden>
			<nav class="h-bar light-txt t">
				<label for="leftbar-shower"></label>
				<a href="/" id="goolybeep">G</a>
				<label for="rightbar-shower"></label>
			</nav>
			<aside class="body-bg">
				<div class="tabs">
					<input id="left-default" name="tabs" type="radio" form="leftbar-tabs" hidden>
					<div id="modules-tree" class="tab body-bg light-txt"><?include_once("components/modules.php")?></div>

					<input id="categories-tab" name="tabs" type="radio" form="leftbar-tabs" hidden checked>
					<div id="categories" class="tab body-bg light-txt">
						<div class="h-bar white-txt">
							<span data-translate="textContent">categories</span>
						</div>
						<section>
							<?function staticTree(&$items, $offset="root"){
								if(is_array($items[$offset])):?>
								<div class="root">
									<?foreach($items[$offset] as $key=>$val):?>
									<a href="/showcase/<?=$val['language']?>/<?=$val['name']?>" class="<?if($val['PageID']==CATEGORY):?>active-txt<?elseif($val['published']==='Published'):?>published-txt<?else:?>white-txt<?endif?>">
										<?=(empty($val['header'])?$val['name']:$val['header'])?>
									</a>
									<?staticTree($items, $key);
									endforeach?>
								</div>
								<?endif;
							}
							$language = $cng->language;
							$tree = $mySQL->getTree("name", "parent", "SELECT * FROM gb_sitemap CROSS JOIN gb_pages USING(PageID) WHERE language LIKE {str} ORDER BY SortID ASC", $language);

							foreach($tree['prodazh-avtomobiliv-audi'] as $key=>$val) if($val['type']=="category"):?>
							<a href="/showcase/<?=$val['language']?>/<?=$val['name']?>" class="<?if($val['PageID']==CATEGORY):?>active-txt<?elseif($val['published']==='Published'):?>published-txt<?else:?>white-txt<?endif?>">
								<?=(empty($val['header'])?$val['name']:$val['header'])?>
							</a>
							<?staticTree($tree, $key); endif?>
						</section>
						<br>
						<script>
						(function(map){
							map.onscroll=function(){STANDBY.mapScrollTop = map.scrollTop;}
						})(document.currentScript.parentNode)
						</script>
					</div>
					<?if(PRODUCT):?>


					<?elseif(CATEGORY):?>
					<input id="filters-tab" name="tabs" type="radio" form="leftbar-tabs" hidden checked>
					<form id="filters" class="tab body-bg light-txt" autocomplete="off">
						<div class="h-bar white-txt" data-translate="textContent">filters</div>
						<?$i=0;
						$fPattern = JSON::parse($category['filterset']);
						foreach($fPattern as $setname=>$set):?>
						<fieldset><legend><?=$setname?></legend>
							<?foreach($set as $id=>$value):?>
							<label><input value="<?=$id?>" <?if(in_array($id, $filterset[$i])):?>checked<?endif?> type="checkbox" hidden><span><?=$value?></span></label>
							<?endforeach?>
						</fieldset>
						<? $i++; endforeach?>
						<script>
						(function(form){
							form.onchange=function(){
								var filters = [];
								form.querySelectorAll("fieldset").forEach(function(set,i){
									var filterset = [0];
									set.querySelectorAll("input:checked").forEach(function(inp){
										filterset.push(inp.value);
									});
									filters.push(filterset.join("x"));
								});
								location.pathname = "/showcase/"+LANGUAGE+"/<?=$category['name']?>/"+filters.join("-");
							}
						})(document.currentScript.parentNode)
						</script>
					</form>
					<?endif?>
				</div>
				<form id="leftbar-tabs" class="v-bar l" autocomplete="off">
					<div class="toolbar">
						<label title="modules" class="tool" for="left-default" data-translate="title">⋮</label>
						<label title="categories" class="tool" for="categories-tab" data-translate="title">&#xe902;</label>
						<?if(PRODUCT):?>

						<?elseif(CATEGORY):?>
						<label title="filters" class="tool" for="filters-tab" data-translate="title">&#xe5d1;</label>
						<?endif?>
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
    					if(STANDBY.leftbar && bar[STANDBY.leftbar]) bar[STANDBY.leftbar].checked = true;
					})(document.currentScript.parentNode);
					</script>
				</form>
			</aside>
			<header class="h-bar light-txt">
				<?if(PRODUCT):?><a class="tool" title="Back" href="/showcase">❬</a><?endif?>
				<?if(defined("ARG_1")):?>
				<div class="toolbar t">
					<label title="create model" class="tool" data-translate="title" onclick="new Box(null, 'showcase/createbox/<?=CATEGORY?>/'+LANGUAGE)">&#xe89c;</label>
				</div>
				<?endif?>
				<?if(PRODUCT):?>
				<div class="toolbar t">
					<label title="clone page" data-translate="title" class="tool" onclick="new Box('<?=$model['named']?>', 'showcase/clonepagebox/<?=$model['PageID']?>/<?=$model['articul']?>')">&#xe925;</label>
				</div>
				<?endif?>
				<div class="toolbar r right">
					<?if($access['settings']):?>
					<label title="settings" data-translate="title" class="tool" onclick="new Box(null, 'settings/module_settingsbox/<?=SECTION?>');">&#xf013;</label>
					<?endif?>
				</div>
				<?if(defined("ARG_2")):?>
				<div class="toolbar t right">
					<label for="screenmode" class="screenmode-btn" title="screen mode" data-translate="title" class=""></label>
				</div>
				<?endif?>
			</header>
			<main>
			<?if(PRODUCT):
				function catlist(&$items, $selected, $offset="showcase"){
					if(is_array($items[$offset])): foreach($items[$offset] as $key=>$val):?>
					<option <?if($val['PageID']==$selected):?>selected<?endif?> value="<?=$val['PageID']?>"><?=(empty($val['header'])?$val['name']:$val['header'])?></option>
					<?catlist($items, $selected, $key);
					endforeach; endif;
				}?>
				
				<!--~~~ MEDIASET ~~~~-->
				<section id="mediaset">
					<div id="slideshow">
						<?$mediaset = JSON::parse($model['mediaset']);
						foreach($mediaset as $itm):?>
						<form autocomplete="off">
							<fieldset>
								<label class="left"><input type="checkbox" hidden <?if($itm['hidden']=="NO"):?>checked<?endif?> name="hidden"><span>&#xf011;</span></label>
								
								<label><input type="radio" hidden <?if($itm['position']=="top"):?>checked<?endif?> name="position" value="top"><span>&#xe86b;</span></label>
								<label><input type="radio" hidden <?if($itm['position']=="bottom"):?>checked<?endif?> name="position" value="bottom"><span>&#xe3c8;</span></label>
								<label><input type="radio" hidden <?if($itm['color']=="light"):?>checked<?endif?> name="color" value="light"><span>&#xf069;</span></label>
								<label><input type="radio" hidden <?if($itm['color']=="dark"):?>checked<?endif?> name="color" value="dark"><span>&#xe94e;</span></label>
								<br>
								<input value="<?=$itm['alt']?>" placeholder="Alternative Text" name="alt">
								<br>
								<textarea placeholder="Description" name="description"><?=$itm['description']?></textarea>
							</fieldset>
							<?if($itm['type']=="video"):?>
							<video src="<?=$itm['url']?>" controls></video>
							<?else:?>
							<img src="<?=$itm['url']?>">
							<?endif?>
							<script>
							document.currentScript.parentNode.onchange=function(){saveMediaset()}
							</script>
						</form>
						<?endforeach?>
						<script>var SLIDER = document.currentScript.parentNode</script>
					</div>

					<div id="slidelist">
						<?foreach($mediaset as $itm):?>
						<div class="card">
							<label class="drop-card">✕</label>
							<div class="preview">
								<?if($itm['type']=="video"):?>
								<video src="<?=$itm['url']?>" preload="metadata"></video>
								<?else:?>
								<img src="<?=$itm['url']?>" alt="&#xe94a;">
								<?endif?>
							</div>
						</div>
						<?endforeach?>
						<script>
						
						var	MEDIASET = document.currentScript.parentNode;
							MEDIASET.refreshSlideshow = function(){
							MEDIASET.querySelectorAll(".card").forEach(function(img,i){
								img.onmouseover=function(){
									SLIDER.shotSlide(i*SLIDER.offsetWidth);
								}
							});
							MEDIASET.querySelectorAll("label").forEach(function(label,i){
								label.onclick=function(){
									SLIDER.removeChild( SLIDER.querySelectorAll("form")[i] );
									MEDIASET.removeChild( label.parentNode);
									MEDIASET.refreshSlideshow();
									setTimeout(saveMediaset,1000);
								}
							});
						}
						MEDIASET.refreshSlideshow();
						</script>
					</div>

					<form title="<?=$mediaset['Category']?> / <?=$mediaset['Name']?>">
						<button name="previous" id="left-btn" data-dir="-1" class="transparent-bg">❰</button>
						<button name="next" id="right-btn" data-dir="1" class="transparent-bg">❱</button>
						<button name="add" id="add-btn">add</button>
						<template id="slide-tpl">
							<fieldset>
								<label class="left"><input type="checkbox" hidden name="showdesc"><span>&#xf011;</span></label>

								<label><input type="radio" hidden checked name="position" value="top"><span>&#xe86b;</span></label>
								<label><input type="radio" hidden name="position" value="bottom"><span>&#xe3c8;</span></label>
								<label><input type="radio" hidden checked name="color" value="light"><span>&#xf069;</span></label>
								<label><input type="radio" hidden name="color" value="dark"><span>&#xe94e;</span></label>
								<br><input placeholder="Alternative Text" name="alt">
								<br><textarea placeholder="Description" name="description"></textarea>
							</fieldset>
						</template>
						<script>
						(function(form){
							var animate;
							form.onsubmit=function(event){
								event.preventDefault();
							}
							form.next.onclick=
							form.previous.onclick=function(event){
								event.preventDefault();
								let dir = parseInt(event.target.dataset.dir),
								offset = SLIDER.offsetWidth*(dir+(SLIDER.scrollLeft/SLIDER.offsetWidth)>>0);

								if((offset<0) || offset>(SLIDER.scrollWidth-SLIDER.offsetWidth)) return false;
								SLIDER.shotSlide(offset);
							}
							SLIDER.shotSlide = function(offset){
								cancelAnimationFrame(animate);
								animate = requestAnimationFrame(function scrollSlide(){
									if(Math.abs(offset - SLIDER.scrollLeft) > 16){
										SLIDER.scrollLeft += (offset - SLIDER.scrollLeft)/8;
										animate = requestAnimationFrame(scrollSlide);
									}else SLIDER.scrollLeft = offset;
								});
							}
							form.add.onclick=function(event){
								event.preventDefault();
								openBox('{}', "mediaset/navigatorbox",function(box){
									box.querySelector(".box-body>iframe").contentWindow.getSelected().forEach(function(img){

										let frm = doc.create("form",{autocomplete:"off"}, form.querySelector("#slide-tpl").cloneNode(true).content);
										frm.onchange=saveMediaset;
										switch(img.type){
											case "image":
												var slide = doc.create("img",{src:img.url,alt:""});
												frm.appendChild(slide.cloneNode(true));
											break;
											case "video":
												frm.appendChild( doc.create("video",{src:img.url,controls:"true"}) );
												var slide = doc.create("video",{src:img.url});
											break;
											default:break;
										}
										SLIDER.appendChild(frm);
										let snippet = doc.create("div", {class:"card"}, "<label class='drop-card'>✕</label>");
										let preview = doc.create("div", {class:"preview"});
											preview.appendChild( slide );
										snippet.appendChild( preview );
										MEDIASET.appendChild(snippet);
									});
									MEDIASET.refreshSlideshow();
									box.drop();

									setTimeout(saveMediaset,2000);
								});
							}
						})(document.currentScript.parentNode)
						</script>
					</form>
				</section>
				<br><hr><br>
				<!--~~~ PROPERTIES ~~~~-->
				<input id="equipment" name="prop" type="radio" hidden checked>
				<input id="additional" name="prop" type="radio" hidden>
				<div>
					<label for="equipment" data-translate="textContent">equipment</label>
					<label for="additional" data-translate="textContent">additional</label>
				</div>
				<section id="equipment-tab">
					<?if(empty($model['equipment'])):?>
					<textarea form="properties" name="equipment" placeholder="equipment" data-translate="placeholder" autocomplete="off"><?=$model['equipment']?></textarea>
					<?else:?>
					<input name="equipment" type="hidden" form="properties">
					<ul class="light-txt" oninput="changeEquipment('equipment',this)" contenteditable="true"><?=$model['equipment']?></ul>
					<?endif?>
				</section>
				<section id="additional-tab">
					<?if(empty($model['additional'])):?>
					<textarea form="properties" name="additional" placeholder="additional" data-translate="placeholder" autocomplete="off"></textarea>
					<?else:?>
					<input name="additional" type="hidden" form="properties">
					<ul class="light-txt" oninput="changeEquipment('additional',this)" contenteditable="true"><?=$model['additional']?></ul>
					<?endif?>
				</section>
				<script>
				function saveMediaset(){
					XHR.push({
						addressee:"/showcase/actions/sv_images/<?=$model['PageID']?>",
						body:(function(mediaset){
							doc.querySelectorAll("#mediaset>#slideshow>form").forEach(function(form,i){
								let obj = form.querySelector("img,video");
								mediaset.push({
									url:obj.src,
									hidden:form.hidden.checked ? "NO" : "YES",
									type:obj.nodeName.toLowerCase(),
									alt:form.alt.value.trim().replace(/"/g,"”").replace("/'/g","’"),
									description:form.description.value.trim().replace(/"/g,"”").replace("/'/g","’"),
									color:form.color.value,
									position:form.position.value,
								});
							});
							return JSON.encode(mediaset);
						})([])
					});
				}
				function changeEquipment(cmd, fld){
					clearTimeout(fld.timeout);
					fld.timeout = setTimeout(function(){
						XHR.push({
							addressee:"/showcase/actions/ch_model/<?=$model['PageID']?>/"+cmd,
							body:utf8_to_b64(fld.innerHTML)
						});
					},2000);
				}
				</script>
				<?elseif(CATEGORY):?>
				<div id="tile">
					<?foreach($feed as $snippet):?>
					<a class="snippet<?if($snippet['status']!="available"):?> sold<?endif?>" href="/showcase/<?=$language?>/<?=$snippet['PageID']?>/<?=$snippet['ItemID']?>">
						<div class="preview"><img src="<?=$snippet['preview']?>" alt="&#xe906;"></div>
						<div class="header"><?=$snippet['named']?></div>
					</a>
					<?endforeach?>
				</div>
				<?endif?>
			</main>
			<?if(defined("ARG_2")):?>
			<section>
				<div class="tabs">
				<?if(PRODUCT):?>

				<input id="right-default" name="tabs" type="radio" form="rightbar-tabs" hidden checked>
				<div id="metadata" class="tab body-bg light-txt">
					<div class="h-bar light-bg">
						ID: <span class="white-txt"><?=$model['PageID']?></span>
						
						<hr class="separator">
						
						<input name="articul" value="<?=$model['articul']?>" size="8" placeholder="Articul" form="properties">

						<!--~~~ Language ~~~-->
						<div class="select">
							<select name="language" class="gold-txt">
								<?$pages = $mySQL->get("SELECT * FROM gb_showcase WHERE articul={int}", $model['articul'])?>
								<?foreach($pages as $pg):?>
								<option <?if($pg['PageID'] == $model['PageID']):?>selected<?endif?> value="<?=$pg['language']?>/<?=$pg['PageID']?>"><?=$pg['language']?></option>
								<?endforeach?>
								<script>
								(function(select){
									select.onchange=function(){
										location.href = "/showcase/"+select.value;
									}
								})(document.currentScript.parentNode)
								</script>
							</select>
						</div>

						<hr class="separator">

						<!--~~~ Available ~~~-->
						<div class="select">
							<select name="status" class="active-txt" form="properties">
								<?foreach(["available","not available"] as $status):?>
								<option <?if($status==$model['status']):?>selected<?endif?> data-translate="textContent" value="<?=$status?>"><?=$status?></option>
								<?endforeach?>
							</select>
						</div>

						<!--~~ Item Select ~~-->
						<div class="toolbar t right">
							<input type="checkbox" name="saved" autocomplete="off" form="properties" hidden><span title="autosave indicator" class="tool">&#xf0c7;</span>
						</div>
					</div>
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
												addressee:"/showcase/actions/ch_model/<?=$model['PageID']?>/preview",
												body:utf8_to_b64(event.target.value),
												onsuccess:function(response){
													if(parseInt(response)){

													}
												}
											});
										}
									}
								}
							});
						})(document.currentScript)
						</script>
						<img src="<?=$model['preview']?>" alt="&#xe94a;">
					</div>
					<form id="properties" autocomplete="off">
						<!--~~~~ Named ~~~~-->
						<fieldset style="grid-row:1/3">
							<legend class="white-txt" data-translate="textContent">model</legend>
							<textarea name="named" placeholder="..." class="text-field"><?=$model['named']?></textarea>
						</fieldset>

						<!--~~~~ Price ~~~~-->
						<fieldset><legend data-translate="textContent" class="active-txt">price</legend>
							<input name="discount" value="<?=$discount['sticker']?>" data-id="<?=$discount['DiscountID']?>" placeholder="0%" class="text-field right" style="width:31%">
							<input name="price" value="<?=$model['price']?>" placeholder="0.00" class="text-field" style="width:59%">
						</fieldset>
						
						<!--~~ Currency ~~~-->
						<fieldset><legend data-translate="textContent" class="green-txt">currency</legend>
							<div class="select">
								<select name="currency" class="green-txt" autocomplete="off">
								<?foreach(["USD","EUR","UAH"] as $currency):?>
									<option <?if($currency==$model['currency']):?>selected<?endif?> value="<?=$currency?>"><?=$currency?></option>
								<?endforeach?>
								</select>
							</div>
						</fieldset>

						<!--~ Horsepower ~-->
						<fieldset><legend class="gold-txt" data-translate="textContent">horsepower</legend>
							<input name="horsepower" placeholder="0" value="<?=$model['horsepower']?>" class="text-field">
						</fieldset>

						<!--~~~ Engine ~~~-->
						<fieldset><legend class="gold-txt" data-translate="textContent">engine</legend>
							<div class="select">
								<input list="engines" name="engine" value="<?=$model['engine']?>" class="text-field">
								<datalist id="engines">
									<?foreach([
										"1.0 TFSI","1.4 TFSI","1.5 TFSI",
										"1.6 TFSI","1.8 TFSI","2.0 TFSI",
										"2.5 TFSI","3.0 TFSI","4.0 TFSI",
										"1.4 TDI", "1.6 TDI", "2.0 TDI",
										"3.0 TDI", "4.0 TDI"
									] as $engine):?>
									<option><?=$engine?></option>
									<?endforeach?>
								</datalist>
							</div>
						</fieldset>
						<div align="right">
							<span data-translate="textContent">power</span>: <input name="power" value="<?=$model['options']['power']?>" class="text-field" size="6"><br>
							<span data-translate="textContent">torque</span>: <input name="torque" value="<?=$model['options']['torque']?>" class="text-field" size="6"><br>
							<span data-translate="textContent">capacity</span>: <input name="capacity" value="<?=$model['options']['capacity']?>" class="text-field" size="6">
						</div>
						<fieldset><legend class="gold-txt" data-translate="textContent">gearbox</legend>
							<div class="select">
								<select name="gearbox" class="active-txt">
									<option><?=$model['options']['gearbox']?></option>
									<?foreach([
										"multitronic",
										"S-tronic",
										"Tiptronic 8-ступ",
										"manual"
									] as $gearbox) if($gearbox!=$model['options']['gearbox']):?>
									<option><?=$gearbox?></option>
									<?endif?>
								</select>
							</div>
							<hr><hr>
							<hr><hr>
						</fieldset>
						<fieldset><legend class="gold-txt" data-translate="textContent">drive</legend>
							<div class="select">
								<select name="drive" class="active-txt">
									<option><?=$model['options']['drive']?></option>
									<?foreach([
										"quattro",
										"front-wheel",
										"rear-wheel"
									] as $drive) if($drive!=$model['options']['drive']):?>
									<option><?=$drive?></option>
									<?endif?>
								</select>
							</div>
							<hr><hr>
							<hr><hr>
						</fieldset>

						<div align="right">
							<span class="green-txt" data-translate="textContent">speed</span> / <span data-translate="textContent" class="red-txt">issue</span>: <input name="speed" value="<?=$model['options']['speed']?>" class="text-field" size="12"><br>
							<span class="green-txt" data-translate="textContent">racing</span> / <span data-translate="textContent" class="red-txt">mileage</span>: <input name="racing" value="<?=$model['options']['racing']?>" class="text-field" size="12">
						</div>

						<fieldset><legend data-translate="textContent">consumption</legend>
							<input name="consumption" value="<?=$model['options']['consumption']?>" class="text-field">
						</fieldset>

						<fieldset><legend class="white-txt" data-translate="textContent">fuel</legend>
							<div class="select">
								<select name="fuel" class="active-txt">
									<option><?=$model['options']['fuel']?></option>
									<?foreach([
										"Бензин",
										"Дизель",
										"e-tron",
										"g-tron"
									] as $fuel) if($fuel!=$model['options']['fuel']):?>
									<option><?=$fuel?></option>
									<?endif?>
								</select>
							</div>
						</fieldset>

						<!--~~~ Body Color ~~~-->
						<fieldset><legend class="white-txt" data-translate="textContent">body color</legend>
							<input name="body" class="text-field" value="<?=$model['body']?>" data-id="<?=$model['LabelID']?>" size="8" placeholder="...">
						</fieldset>

						<!--~ Interior Color ~-->
						<fieldset style="grid-column:2/4"><legend class="white-txt" data-translate="textContent">interior</legend>
							<input name="interior" value="<?=$model['interior']?>" class="text-field" placeholder="...">
						</fieldset>

						
						<fieldset><legend class="white-txt" data-translate="textContent">category</legend>
							<div class="select">
								<select name="CategoryID" class="active-txt">
								<?catlist($tree, $model['CategoryID'],$model['parent'])?>
								</select>
							</div>
						</fieldset>

						<fieldset><legend class="white-txt" data-translate="textContent">lineup</legend>
							<div class="select">
								<select name="LineupID" class="green-txt">
									<?$lineups = $mySQL->get("SELECT PageID,model FROM gb_lineup WHERE language LIKE {str}", $model['language']);
									foreach($lineups as $lineup):?>
									<option <?if($lineup['PageID']==$model['LineupID']):?>selected<?endif?> value="<?=$lineup['PageID']?>"><?=$lineup['model']?></option>
									<?endforeach?>
								</select>
							</div>
						</fieldset>

						<fieldset><legend data-translate="textContent">template</legend>
							<div class="select">
								<select name="subtemplate" class="gold-txt">
									<option selected value="<?=$model['subtemplate']?>"><?=$model['subtemplate']?></option>
									<?foreach(glob("../".BASE_FOLDER."/themes/".$cng->theme."/includes/showcase/*.html") as $file) if($file!=$model['subtemplate']): $file = pathinfo($file)['filename']?>
									<option value="<?=$file?>"><?=$file?></option>
									<?endif?>
								</select>
							</div>
						</fieldset>

						<script>
						(function(form){
							
							form.LineupID.onchange = 
							form.status.onchange=
							form.currency.onchange=
							form.CategoryID.onchange=
							form.subtemplate.onchange=function(event){
								form.saved.checked = true;
								form.changeModel(event)
							}

							form.named.oninput=
							form.articul.oninput=
							form.price.oninput=
							form.horsepower.oninput=
							form.body.oninput=
							form.engine.oninput=
							form.interior.oninput=function(event){
								form.saved.checked = true;
								clearTimeout(event.target.timeout);
								event.target.timeout = setTimeout(function(){
									form.changeModel(event);
								},2500);
							}

							form.fuel.onchange=
							form.drive.onchange=
							form.gearbox.onchange=
							form.speed.oninput=
							form.racing.oninput=
							form.power.oninput=
							form.torque.oninput=
							form.capacity.oninput=
							form.consumption.oninput=function(){
								form.saved.checked = true;
								clearTimeout(event.target.timeout);
								event.target.timeout = setTimeout(function(){
									XHR.push({
										addressee:"/showcase/actions/ch_model/<?=$model['PageID']?>/options",
										body:utf8_to_b64( JSON.encode({
											fuel:form.fuel.value,
											power:form.power.value,
											gearbox:form.gearbox.value,
											drive:form.drive.value,
											consumption:form.consumption.value,
											speed:form.speed.value,
											racing:form.racing.value,
											capacity:form.capacity.value,
											torque:form.torque.value
										}) ),
										onsuccess:function(response){
											if(parseInt(response)) form.saved.checked = false;
										}
									});
								},2000);
							}

							form.equipment.onchange=
							form.additional.onchange=function(){
								var set = doc.create("ul");
								event.target.value.trim().split(/\n/).forEach(function(row){
									set.appendChild( doc.create("li",{},row.trim()) );
								});
								XHR.push({
									addressee:"/showcase/actions/ch_model/<?=$model['PageID']?>/"+event.target.name,
									body:utf8_to_b64(set.innerHTML),
									onsuccess:function(response){
										if(parseInt(response)) form.saved.checked = false;
									}
								});
							}
							form.discount.onfocus=function(){
								new Box(<?=$model['PageID']?>, "showcase/discountsbox/"+form.discount.dataset.id,function(dForm){
									
									form.discount.value = dForm.sticker.value;
									form.discount.dataset.id = dForm.DiscountID.value;
									
									XHR.push({
										addressee:"/showcase/actions/ch_model/<?=$model['PageID']?>/DiscountID",
										body:utf8_to_b64(form.discount.dataset.id),
										onsuccess:function(response){
											if(parseInt(response)){
												if(parseInt(response)) dForm.drop();
											}
										}
									});
								});
							}
							form.changeModel=function(event){
								XHR.push({
									addressee:"/showcase/actions/ch_model/<?=$model['PageID']?>/"+event.target.name,
									body:utf8_to_b64(event.target.value),
									onsuccess:function(response){
										if(parseInt(response)) form.saved.checked = false;
									}
								});
							}
						})(document.currentScript.parentNode)
						</script>
					</form>
				</div>

				<?elseif(CATEGORY):?>
				
				<!--~~~~ FILTERSET ~~~~-->
				<input id="filterset-tab" name="tabs" type="radio" form="rightbar-tabs" hidden checked>
				<div id="filterset" class="tab white-bg">
					<div class="h-bar active-bg">
						<div class="toolbar r right">
							<label title="save" data-translate="title" class="tool" onclick="saveFilters()">&#xf0c7;</label>
							<label title="add filterset" data-translate="title" class="tool" onclick="addFilterset()">&#xe146;</label>
							<label title="show pattern" data-translate="title" class="tool" onclick="showPattern(filtersToJson({}), jsonTofilters)">⌘</label>
						</div>
						<span data-translate="textContent">filters</span>
					</div>
					<table width="100%" cellpadding="5" cellspacing="0" rules="cols" bordercolor="#CCC">
						<colgroup><col width="26"><col><col width="26"></colgroup>
						<?foreach($fPattern as $setname=>$set):?>
						<tbody>
							<tr class="dark-btn-bg">
								<th class="tool" onclick="this.parent(2).swap(false,1)">&#xe86b;</th>
								<td class="setname" contenteditable="true" align="center"><?=$setname?></td>
								<th class="tool" onclick="removeSet(this.parent(2))">&#xf011;</th>
							</tr>
							<?foreach($set as $id=>$value):?>
							<tr>
								<th class="tool" title="add row" data-translate="title" onclick="addFilterValue(this.parentNode)">+</th>
								<td onfocus="onCell(this)" contenteditable="true"><?=$value?></td>
								<th class="tool" title="delete row" data-translate="title" onclick="deleteRow(this.parentNode)">✕</th>
							</tr>
							<?endforeach?>
						</tbody>
						<?endforeach?>
					</table>
					<datalist id="filterlist">
						<?foreach($mySQL->get("SELECT * FROM gb_filters") as $filter):?>
						<option value="<?=$filter['caption']?>"><?=$filter['caption']?></option>
						<?endforeach?>
					</datalist>
					<template id="filterset-tpl">
						<tbody>
							<tr class="dark-btn-bg">
								<th class="tool" onclick="this.parent(2).swap(false,1)">&#xe86b;</th>
								<td class="setname" contenteditable="true" align="center"></td>
								<th class="tool" onclick="removeSet(this.parent(2))">&#xf011;</th>
							</tr>
							<tr>
								<th class="tool" title="add row" data-translate="title" onclick="addFilterValue(this.parentNode)">+</th>
								<td onfocus="onCell(this)" contenteditable="true"></td>
								<th class="tool" title="delete row" data-translate="title" onclick="deleteRow(this.parentNode)">✕</th>
							</tr>
						</tbody>
					</template>
					<template>
						<th class="tool" title="add row" data-translate="title" onclick="addFilterValue(this.parentNode)">+</th>
						<td onfocus="onCell(this)" contenteditable="true"></td>
						<th class="tool" title="delete row" data-translate="title" onclick="deleteRow(this.parentNode)">✕</th>
					</template>
					<script>
					var subrow = document.currentScript.previousElementSibling;
					
					function onCell(cell){
						var inp = doc.create("input",{value:cell.textContent,list:"filterlist",onblur:"this.parentNode.textContent = this.value"});
						cell.textContent = "";
						cell.appendChild(inp);
						inp.focus();
					}
					function saveFilters(){
						XHR.push({
							addressee:"/actions/showcase/sv_filterset/<?=CATEGORY?>",
							body:filtersToJson({})
						});
					}
					var removeSet=(set)=>{set.parentNode.removeChild(set)};
					var addFilterValue=(row)=>{row.insertAdjacentElement("afterEnd", doc.create("tr",{}, subrow.cloneNode(true).content))}
					var addFilterset=()=>{doc.querySelector("#filterset>table").appendChild(doc.querySelector("#filterset-tpl").cloneNode(true).content)}
					
					var filtersToJson = function(filterset){
						doc.querySelectorAll("#filterset>table>tbody").forEach(function(set){
							var caption = set.querySelector("tr:first-child>td").textContent.trim();
							filterset[caption] = [];
							set.querySelectorAll("tr:not(:first-child)>td").forEach(function(cell){
								filterset[caption].push(cell.textContent.trim());
							});
						});
						return JSON.encode(filterset);
					}
					var jsonTofilters = function(json){
						var filters = doc.querySelector("#filterset>table");
							filters.querySelectorAll("tbody").forEach(function(set){
								set.parentNode.removeChild(set);
							});
						var pattern = JSON.parse(json);
						for(var key in pattern){
							var caption = doc.create("tr",{class:"dark-btn-bg"});
							caption.create("th",{class:"tool",title:"Add Row",onclick:"this.parent(2).swap(false,1)"},"&#xe86b;");
							caption.create("td",{class:"setname",contenteditable:"true",align:"center"},key);
							caption.create("th",{class:"tool",title:"Delete Row",onclick:"removeSet(this.parent(2))"},"&#xf011;");

							var set = doc.create("tbody");
								set.appendChild( caption );

							for(var i=0; i<pattern[key].length; i++){
								var row = doc.create("tr")
								row.create("th",{class:"tool",title:"Add Row",onclick:"addFilterValue(this.parentNode)"},"+");
								row.create("td",{contenteditable:"true",onfocus:"onCell(this)"},pattern[key][i]);
								row.create("th",{class:"tool",title:"Delete Row",onclick:"deleteRow(this.parentNode)"},"✕");
								
								set.appendChild(row);
							}
							filters.appendChild(set);
						}
					}
					</script>
				</div>

				<!--~~~~ OPTIONSET ~~~~-->
				<input id="options-tab" name="tabs" type="radio" form="rightbar-tabs" hidden>
				<div id="options" class="tab white-bg">
					<div class="h-bar logo-bg">
						<div class="toolbar r right">
							<label title="save" data-translate="title" class="tool" onclick="SaveOptionsTpl()">&#xf0c7;</label>
							<label title="show pattern" data-translate="title" class="tool" onclick="showPattern(optionsToJson({}), jsonTooptions)">⌘</label>
						</div>
						<span data-translate="textContent">options</span>
					</div>
					<table width="100%" cellpadding="5" cellspacing="0" rules="cols" bordercolor="#CCC">
						<colgroup><col width="26"><col><col><col width="26"></colgroup>
						<tbody>
							<?
							$options = JSON::parse($category['optionset']);
							foreach($options as $key=>$val):?>
							<tr>
								<th class="tool" title="add row" data-translate="title" onclick="addRow(this.parentNode)">+</th>
								<td contenteditable="true"><?=$key?></td>
								<td contenteditable="true"><?=$val?></td>
								<th class="tool" title="delete row" data-translate="title" onclick="deleteRow(this.parentNode)">✕</th>
							</tr>
							<?endforeach;
							if(empty($options)):?>
							<tr>
								<th class="tool" title="add row" data-translate="title" onclick="addRow(this.parentNode)">+</th>
								<td contenteditable="true"></td>
								<td contenteditable="true"></td>
								<th class="tool" title="delete row" data-translate="title" onclick="deleteRow(this.parentNode)">✕</th>
							</tr>
							<?endif?>
						</tbody>
					</table>
					<script>
					var SaveOptionsTpl = function(){
						XHR.push({
							addressee:"/actions/showcase/sv_optionset/<?=CATEGORY?>",
							body:optionsToJson({})
						});
					}
					var optionsToJson = function(properties,key){
						doc.querySelectorAll("#options>table>tbody>tr>td").forEach(function(cell,i){
						if(i%2) properties[key] = cell.textContent.trim();
							else key = cell.textContent.trim();
						});
						return JSON.encode(properties);
					}
					var jsonTooptions = function(json){
						var pattern = JSON.parse(json);
						var optionset = doc.create("tbody");
						for(var key in pattern){
							var row = doc.create("tr")
							row.create("th",{class:"tool",title:"Add Row",onclick:"addRow(this.parentNode)"},"+");
							row.create("td",{contenteditable:"true"},key);
							row.create("td",{contenteditable:"true"},pattern[key]);
							row.create("th",{class:"tool",title:"Delete Row",onclick:"deleteRow(this.parentNode)"},"✕");
							optionset.appendChild(row);
						}
						var tbody = doc.querySelector("#options>table>tbody");
						tbody.parentNode.replaceChild(optionset, tbody);
					}
					</script>
				</div>
				<?endif?>
				</div>
				<form id="rightbar-tabs" class="v-bar r v-bar-bg" data-default="right-default" autocomplete="off">
					<?if(PRODUCT):?>
					<label title="Metadata" class="tool" for="right-default" data-translate="title">&#xe871;</label>
					
					<div class="toolbar">
						<!--<label title="microdata" class="tool" data-translate="title" onclick="new Box('<?=MATERIAL_ID?>','sitemap/microdatabox')">&#xe8ab;</label>-->
						<!--<label title="customizer" class="tool" data-translate="title" onclick="new Box(null,'customizer/box/<?=$model['PageID']?>')">&#xe993;</label>-->
					</div>
					
					<div class="toolbar">
						<label title="Remove Vehicle" class="tool"><input name="remove" type="checkbox" hidden>&#xe94d;</label>
					</div>

					<?elseif(CATEGORY):?>
					<div class="toolbar">
						<label title="filters" class="tool" for="filterset-tab" data-translate="title">&#xe5d1;</label>
						<label title="options" class="tool" for="options-tab" data-translate="title">&#xf05e;</label>
					</div>
					<?endif?>
					<script>
					(function(bar){
						bar.onsubmit=function(event){ event.preventDefault(); }
						/*
						bar.tabs.forEach(function(tab){ tab.onchange=function(event){
							STANDBY.rightbar = event.target.id;
						}});
						if(STANDBY.rightbar) bar[STANDBY.rightbar].checked = true;
						*/
						bar.remove.onchange=function(){
							XHR.push({
							addressee:"/showcase/actions/rm_vehicle/<?=$model['articul']?>",
							onsuccess:function(response){
								if(parseInt(response)){
									let path = location.pathname.split("/")
										path[3] = "<?=$category['name']?>";
									location.pathname = path.join("/");
								}
							}
							});
						}
					})(document.currentScript.parentNode);
					</script>
				</form>
			</section>
			<?endif?>
		</div>
		<script>
		<?if(defined("ARG_2")):?>
		(function(body){
			body.querySelector("#screenmode").checked = (STANDBY.screenmode=="true");
		})(document.currentScript.parentNode);
		<?endif?>
		var LANGUAGE = "<?=$language?>";
		function reloadTree(lang){
			XHR.push({
				addressee:"/showcase/actions/rl_tree/"+lang,
				onsuccess:function(response){
					var path = location.pathname.split(/\//);
						path[1] = "showcase";
						path[2] = lang;
					doc.querySelector("#categories>section").outerHTML = response;
					window.history.pushState("", "tree", path.join("/"));
				}
			});
			return lang;
		}
		</script>
	</body>
</html>