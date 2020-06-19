<?

$prototype = $mySQL->getRow("SELECT MaterialID,language,header FROM gb_sitemap WHERE PageID={int} LIMIT 1", ARG_2);

$alts = $mySQL->getGroup("SELECT language FROM gb_sitemap WHERE MaterialID={int}", $prototype['MaterialID'])['language'];

$cng = new config("../".BASE_FOLDER."/".$config->{"config file"});

$handle = "l:".time();
?>
<div id="<?=$handle?>" class="mount modal">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<style>
	.clone-box>div.box-body{
		padding:10px;
		font-size:15px;
		position:relative;
	}
	.clone-box>div.box-footer{
		padding:0 14px 10px 0;
	}
	.clone-box>div.box-body>fieldset{
		padding:0;
		margin-top:8px;
		border-width:0;
	}
	.clone-box>div.box-body>fieldset>textarea{
		color:#444;
		width:100%;
		height:80px;
		padding:8px;
		resize:none;
		border-width:0;
		box-sizing:border-box;
		font-family:calibri,helvetica,arial;
		box-shadow:inset 0 0 6px 0 rgba(0,0,0, .6);
		background-image:linear-gradient(to top, #FFF, #F0F0F0);
	}
	.clone-box>div.box-body>fieldset>textarea[name='header']{
		color:#111;
		font-weight:bold;
	}
	.clone-box>div.box-body>div.select{
		right:8px;
		position:absolute;
	}
	.clone-box>div.box-body>div.select>select{
		vertical-align:middle;
		text-transform:uppercase;
	}
	.clone-box>div.box-caption{
		cursor:default;
		font-size:16px;
		line-height:36px;
	}
	.clone-box>div.h-bar{
		cursor:grab;
	}
	</style>
	<form class="box clone-box body-bg" style="width:540px">
		<button type="reset" class="close-btn white-txt" title="close" data-translate="title">✕</button>
		<div class="box-caption light-btn-bg">&#xe925;</div>
		<div class="h-bar active-bg">
			<script>
			(function(bar){
				bar.onmousedown=function(event){
					event.preventDefault();
					var form = bar.parentNode,
						y = event.clientY - form.offsetTop,
						x = event.clientX - form.offsetLeft;
					document.onmousemove=function(event){
						let top = event.clientY - y;
						let left = event.clientX - x;
						form.style.top = (top > 0) ? top+"px" : "0";
						form.style.left = (left > 0) ? left+"px" : "0";
					}
					document.onmouseup=function(){document.onmousemove = null;}
				}
			})(document.currentScript.parentNode)
			</script>
		</div>
		<div class="box-body light-txt">
			<div class="select">
				language:
				<select class="active-txt" name="language" required>
					<?foreach($cng->languageset as $lang):?>
					<option <?if(in_array($lang, $alts)):?>disabled<?endif?> value="<?=$lang?>"><?=$lang?></option>
					<?endforeach?>
				</select>
			</div>
			<fieldset><legend data-translate="textContent">page name</legend>
				<textarea name="header" placeholder="..."><?=$prototype['header']?></textarea>
			</fieldset>
		</div>
		<div class="box-footer" align="right">
			<button type="submit" class="light-btn-bg" <?if(!defined("ARG_2")):?>disabled<?endif?> data-translate="textContent">create</button>
			<button type="reset" class="dark-btn-bg" data-translate="textContent">cancel</button>
		</div>
		<script>
		(function(form){
			location.hash = "<?=$handle?>";
			form.onreset = function(){ form.drop() }
			form.onsubmit = function(event){
				event.preventDefault();
				XHR.push({
					addressee:"/sitemap/actions/clone-page/<?=ARG_2?>",
					body:JSON.stringify({
						header:form.header.value.trim().replace(/"/g,"″"),
						name:form.header.value.trim().toLowerCase().translite("-", true),
						language:form.language.value
					}),
					onsuccess:function(response){
						form.drop();
						try{
							response = JSON.parse(response);
							location.pathname = "sitemap/"+response['language']+"/"+response['name'];
						}catch(e){ console.log(e.name+": "+e.value) }
					}
				});
			}
			form.style.top = "calc(50% - "+(form.offsetHeight/2)+"px)";
		})(document.currentScript.parentNode);
		</script>
	</form>
</div>