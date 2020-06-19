<?$handle = "l:".time();?>
<div id="<?=$handle?>" class="mount modal">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<style>
	.log-box>div.box-body{
		padding:10px;
		min-height:220px;
		font-size:12px;
		line-height:20px;
		white-space:nowrap;
	}
	.log-box>div.box-body>input{
		width:100%;
		padding:8px;
		margin:5px 0;
		cursor:pointer;
		box-sizing:border-box;
		border:1px solid #BBB;
		border-width:1px 0;
	}
	.log-box>div.box-body>input:focus{
		background-color:#B2D7FF;
	}
	.box-caption{
		font-size:16px;
		line-height:36px;
	}
	</style>
	<form class="box log-box white-bg" style="width:680px">
		<button type="reset" class="close-btn dark-txt" title="close" data-translate="title">✕</button>
		<div class="box-caption black-bg">&#xe926;</div>
		<div class="h-bar light-btn-bg"></div>
		<div class="box-body">
			
		</div>
		<script>
		(function(form){
			location.hash = "<?=$handle?>";
			form.onreset = function(){ form.drop() }
			form.style.top = "calc(50% - "+(form.offsetHeight/2)+"px)";
		})(document.currentScript.parentNode);
		</script>
	</form>
</div>