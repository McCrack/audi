<?php
$handle = "b:".time();
$classes = JSON::load('php://input');
?>
<div id="<?=$handle?>" class="mount modal">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<form class="box prompt logo-bg" style="width:320px;">
		<div class="box-caption">&#xe995;</div>
		<div class="h-bar">
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
		<div class="box-body" align="center">
			<br><br>
			<output>Choose Subdomain</output>:
			<select name="subdomain" class="">
				<?foreach(glob("../*", GLOB_ONLYDIR) as $path): $subdomain=basename($path)?>
				<option <?if($subdomain==BASE_FOLDER):?>selected<?endif?> value="<?=$subdomain?>"><?=$subdomain?></option>
				<?endforeach?>
			</select>
		</div>
		<div class="box-footer" align="center">
			<button class="light-btn-bg" type="submit" data-translate="textContent">apply</button>
			<button class="dark-btn-bg" type="reset" data-translate="textContent">cancel</button>
		</div>
		<script>
		(function(form){
			location.hash = "<?=$handle?>";
			translate.fragment(form);
			form.onreset = function(){ form.drop() }
			form.addEventListener("submit",function(){
				COOKIE.set("subdomain", form.subdomain.value, {
					expires:2592000,
					paht:"/"
				});
				form.drop();
				location.reload();
			});
			form.style.top = "calc(50% - "+(form.offsetHeight/2)+"px)";
		})(document.currentScript.parentNode);
		</script>
	</form>
</div>