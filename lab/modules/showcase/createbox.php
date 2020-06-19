<?$handle = "b:".time()?>
<div id="<?=$handle?>" class="mount modal">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<style>
	.create-box{
		width:380px;
		max-width:98%;
	}
	.create-box>div.box-caption{
		font-size:18px;
		line-height:26px;
	}
	.create-box>div.box-body{
		font-size:0;
	}
	.create-box>div.box-body>fieldset{
		font-size:15px;
		border-width:0;
		padding:2px 0 0 0;
		margin:8px 15px 0 15px;
	}
	.create-box>div.box-body>fieldset>textarea{
		height:60px;
		border-width:0;
		resize:vertical;
		width:100%;
		padding:6px;
		box-sizing:border-box;
		font:bold 15px calibri, helvetica, arial;
	}
	.create-box>div.box-body>fieldset>input{
		height:26px;
	}
	.create-box>div.box-body>fieldset>div.select{
		width:100%;
		padding:6px;
		border:1px solid #AAA;
		box-sizing:border-box;
	}
	.create-box>div.box-body>fieldset>div.select>select{
		width:100%;
	}
	.create-box>div.box-body>fieldset>div.select>select[name='language']{
		text-transform:uppercase;
	}
	</style>
	<form class="box create-box light-btn-bg">
		<button type="reset" class="close-btn dark-txt" title="close" data-translate="title">✕</button>
		<div class="box-caption dark-btn-bg white-txt">
			<span data-translate="textContent">create model</span>
			<script>
			(function(bar){
				bar.onmousedown=function(event){
					event.preventDefault();
					var mount = bar.parentNode,
						y = event.clientY - mount.offsetTop,
						x = event.clientX - mount.offsetLeft;
					document.onmousemove=function(event){
						let top = event.clientY - y;
						let left = event.clientX - x;
						mount.style.top = (top > 0) ? top+"px" : "0";
						mount.style.left = (left > 0) ? left+"px" : "0";
					}
					document.onmouseup=function(){document.onmousemove = null;}
				}
			})(document.currentScript.parentNode)
			</script>
		</div>
		<div class="h-bar"></div>
		<div class="box-body">
			<fieldset class="left"><legend data-translate="textContent">Articul</legend>
				<input name="articul" required size="10" placeholder="0">
			</fieldset>
			
			<fieldset class="right"><legend data-translate="textContent">language</legend>
				<div class="select">
					<select name="language">
						<option value="<?=$cng->language?>"><?=$cng->language?></option>
						<script>
						(function(select){
							select.onchange=function(){
								XHR.push({
									addressee:"/actions/showcase/rl_list/"+select.value,
									onsuccess:function(response){
										select.form.category.innerHTML = response;
									}
								});
							}
						})(document.currentScript.parentNode)
						</script>
					</select>
				</div>
			</fieldset>
			<br clear="both">
			<fieldset><legend data-translate="textContent">category</legend>
				<div class="select">
					<select name="category">
						<?function catlist(&$items, $offset){
							if(is_array($items[$offset])):?>
							<?foreach($items[$offset] as $key=>$val):?>
								<option <?if($val['PageID']==ARG_2):?>selected<?endif?> value="<?=$val['PageID']?>"><?=(empty($val['header'])?$val['name']:$val['header'])?></option>
								<?catlist($items, $key);
							endforeach?>
							<?endif;
						}
						$categories = $mySQL->getTree("name", "parent", "SELECT PageID,name,parent,header FROM gb_sitemap WHERE language LIKE {str} ORDER BY SortID ASC", ARG_3);
						catlist($categories,"prodazh-avtomobiliv-audi")?>
						<option value="367">Автомобілі з пробігом</option>
					</select>
				</div>
			</fieldset>
			<fieldset><legend data-translate="textContent">named</legend>
				<textarea name="named" placeholder="..."></textarea>
			</fieldset>
		</div>
		<div class="box-footer" align="center">
			<button type="submit" name="create" class="light-btn-bg" data-translate="textContent">create</button>
			<button type="reset" class="dark-btn-bg" data-translate="textContent">cancel</button>
		</div>
		<script>
		(function(form){
			form.onreset=function(){ form.drop(); }
			form.onsubmit=function(event){
				event.preventDefault();
				let articul = parseInt(form.articul.value);
				if(articul) XHR.push({
					addressee:"/showcase/actions/ad_model",
					body:JSON.encode({
						name:form.named.value.trim().replace(/"/g,"″"),
						articul:articul,
						category:form.category.value,
					}),
					onsuccess:function(response){
						setTimeout(function(){
							location.pathname = "showcase/"+form.language.value+"/"+response;
						}, 150);
						form.drop();
					}
				});
			}
			location.hash = "<?=$handle?>";
			translate.fragment(form);
			form.style.top = "calc(50% - "+(form.offsetHeight/2)+"px)";
		})(document.currentScript.parentNode);
		</script>
	</form>
</div>