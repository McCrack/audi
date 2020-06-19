<?php
$handle = "b".time();
$classes = JSON::load('php://input');
?>
<div id="<?=$handle?>" class="mount modal">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<style>
	.confirm.box>div.box-body{
		display:flex;
		align-items:center;
		justify-content:center;
	}
	.confirm.box>div.box-body>output{
		font-size:22px;
	}
	</style>
	<form class="box confirm <?=implode(' ', $classes)?>" style="width:360px;">
		<div class="h-bar logo-bg">
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
			<output name="alert"></output>
		</div>
		<div class="box-footer" align="right">
			<button class="light-btn-bg" type="submit">Ok</button>
			<button class="dark-btn-bg" type="reset" data-translate="textContent">cancel</button>
		</div>
		<script>
		(function(form){
			location.hash = "<?=$handle?>";
			translate.fragment(form);
			form.onreset = function(){ form.drop() }
			form.addEventListener("submit",function(){
				form.drop();
			});
			form.style.top = "calc(50% - "+(form.offsetHeight/2)+"px)";
		})(document.currentScript.parentNode);
		</script>
	</form>
</div>