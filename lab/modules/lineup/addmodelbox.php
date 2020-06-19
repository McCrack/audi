<?
$cng = new config("../".BASE_FOLDER."/config.init");

$bodies = $mySQL->getGroup("SELECT body FROM gb_classes GROUP BY body")['body'];
$classes = $mySQL->getGroup("SELECT class FROM gb_classes GROUP BY class")['class'];


$handle = "b:".time()
?>
<div id="<?=$handle?>" class="mount modal">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<style>
	.addmodel-box>div.box-caption{
		font-size:16px;
	}
	.addmodel-box>div.box-body{
		padding:0 15px;
	}
	.addmodel-box>div.box-body>fieldset{
		height:50px;
		padding:0 2px;
		border-width:0;
		margin:10px 2px;
	}
	.addmodel-box>div.box-body>fieldset>div{
		width:100%;
	}
	.addmodel-box>div.box-body>fieldset input{
		width:100%;
		padding:6px;
		height:30px;
		border-width:0;
		box-sizing:border-box;

		box-shadow:inset 0 0 5px -1px black;
		background-image:linear-gradient(to top, #FFF, #EEE);
	}
	</style>
	<form class="box addmodel-box dark-btn-bg" style="width:360px">
		<button type="reset" class="close-btn white-txt" title="close" data-translate="title">✕</button>
		<div class="box-caption black-bg">
			📄
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
		<div class="h-bar logo-bg" data-translate="textContent">add model</div>
		<div class="box-body">
			<fieldset class="left"><legend data-translate="textContent">family</legend>
				<div class="input-with-select">
					<input name="family" list="family-lst" size="14" required placeholder="...">
					<datalist id="family-lst">
						<?foreach($classes as $class):?>
						<option value="<?=$class?>"><?=$class?></option>	
						<?endforeach?>
						<script>
						(function(datalist){
							datalist.querySelectorAll("option").forEach(function(option){
								option.onmousedown=function(){
									datalist.previousElementSibling.value = option.value;
								}
							});
						})(document.currentScript.parentNode);
						</script>
					</datalist>
				</div>
			</fieldset>
			<fieldset><legend data-translate="textContent">body</legend>
				<div class="input-with-select">
					<input name="body" list="body-lst" required placeholder="...">
					<datalist id="body-lst">
						<?foreach($bodies as $body):?>
						<option value="<?=$body?>"><?=$body?></option>	
						<?endforeach?>
						<script>
						(function(datalist){
							datalist.querySelectorAll("option").forEach(function(option){
								option.onmousedown=function(){
									datalist.previousElementSibling.value = option.value;
								}
							});
						})(document.currentScript.parentNode);
						</script>
					</datalist>
				</div>
			</fieldset>
			<fieldset><legend data-translate="textContent">model name</legend>
				<input name="model" required placeholder="...">
			</fieldset>
		</div>
		<div class="box-footer" align="right">
			<button type="submit" name="create" class="light-btn-bg" data-translate="textContent" disabled>create</button>
			<button type="reset" class="dark-btn-bg" data-translate="textContent">cancel</button>
		</div>
		<script>
		(function(form){
			form.onreset=function(){ form.drop(); }
			form.onsubmit=function(event){
				event.preventDefault();
				let ModelID = "audi-"+form.model.value.trim().toLowerCase().translite("-", true);
				XHR.push({
					addressee:"/lineup/actions/add-model",
					body:JSON.encode({
						class:form.family.value.trim(),
						body:form.body.value.trim(),
						model:form.model.value.trim(),
						ModelID:ModelID
					}),
					onsuccess:function(response){
						setTimeout(function(){
							try{
								response = JSON.parse(response);
								location.href = "/lineup/"+response.family+"/"+response.ClassID+"/"+response.ID
							}catch(e){ console.log(e.name+": "+e.message) }
						}, 100);
						form.drop();
					}
				});
			}
			form.oninput=function(){
				form.create.disabled = false;
			}
			location.hash = "<?=$handle?>";
			translate.fragment(form);
			form.style.top = "calc(50% - "+(form.offsetHeight/2)+"px)";
		})(document.currentScript.parentNode);
		</script>
	</form>
</div>