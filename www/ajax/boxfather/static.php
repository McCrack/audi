<?php

require_once("core/db.php");

$name = file_get_contents("php://input");

$page = $mySQL->getRow("SELECT * FROM gb_sitemap CROSS JOIN gb_static USING(PageID) WHERE name LIKE {str} LIMIT 1", $name);

$handle = "b".time();

?>
<div class="container">
    <div id="<?=$handle?>" class="box" onreset="boxList.drop()" onclick="event.cancelBubble=true" style="width:980px;">
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
      <div class="box-title">
        <button class="close-btn" onclick="boxList.drop()" type="reset">✕</button>
        <p class="title title--big"><?=$page['header']?></p>  
      </div>
      <div class="box-body">
        <br><br>
        <?=gzdecode($page['content'])?>
        <br><br>
      </div>
      <script>
      (function(box){
        if(box.offsetHeight>screen.height){
          box.style.top="10px";
        }else box.style.top = "calc(50% - "+(box.offsetHeight / 2)+"px)";
      })(document.currentScript.parentNode)
      </script>
</div>