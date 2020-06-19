<?
require_once("core/db.php");

if(MODULE){
	define("LANGUAGE", MODULE);
}else define("LANGUAGE", DEFAULT_LANG);

$limit = 20;

$feed = $mySQL->get("
SELECT * FROM gb_blogfeed
CROSS JOIN gb_pages USING(PageID) 
WHERE
	language LIKE {str}
	AND published & 2
	AND created<{int}
ORDER BY created DESC
LIMIT {int},{int}", LANGUAGE,time(), ARG_1,$limit);

?>

<div class="container container--wide">
	<?foreach($feed as $post): $lastpost=$post['created'];?>
	<div class="feed__preview">
		<img src="<?=$post['preview']?>" alt="<?=$post['header']?>">

		<!-- inner hood -->
		<div class="feed__inner">
			<p class="feed__preview--header"><?=$post['header']?></p>
			<p class="feed__preview--subheader"><?=$post['subheader']?></p>
		</div>
		<a href="<?=(translite($post['header']).'-'.$post['PageID'])?>" data-id="<?=$post['PageID']?>">

			<!-- outer -->
			<div class="feed__outer">

				<!-- header -->
				<div class="feed__outer--header">
					<p class="feed__preview--header"><?=$post['header']?></p>
					<p class="feed__preview--subheader"><?=$post['subheader']?></p>
				</div>

				<!-- footer -->
				<div class="feed__outer--footer">
					<span><?=date("d.m.Y", $post['created'])?></span>
					<button href="<?=(LANG_INDEX.'/'.translite($post['header']).'-'.$post['PageID'])?>" class="btn secondary white s">Подробнее</button>
				</div>
			</div>
		</a>
	</div>
	<?endforeach?>
</div>