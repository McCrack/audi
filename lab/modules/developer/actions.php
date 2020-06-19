<?php

$iconset = [
	"application"=>"&#xeae3;",
	"text"=>"&#xe926",
	"mp3"=>"&#xe928",
	"mp4"=>"&#xe929", 
	"video"=>"&#xe92a",
	"zip"=>"&#xe92b",
	"html"=>"&#xeae4", 
	"css"=>"&#xeae6",
	"php"=>"&#xf069",
	"json"=>"&#xe8ab",
	"init"=>"&#xe995",
	"image"=>"&#xe927",
	"js"=>"&#xf013"
];
function navigate($path, $chain){
	foreach(glob($path."/*", GLOB_ONLYDIR) as $i=>$root):
		$dir = basename($root);
		$subchain = $chain."-".$dir?>
	<input id="<?=$subchain?>" name="<?=$subchain?>" value="<?=$root?>" type="checkbox" hidden>
	<label for="<?=$subchain?>" data-path="<?=$root?>"><?=$dir?></label>
	<div class="root"><?navigate($root, $subchain)?></div>
	<?endforeach;
	global $iconset;
	foreach(array_filter(glob($path."/*"), "is_file") as $file):
		$info = pathinfo($file);
		$type = explode("/",mime_content_type($file));
		
		$symbol = $iconset['application'];		
		if(isset($iconset[$info['extension']])){
			$symbol = $iconset[$info['extension']];
		}elseif(isset($iconset[$type[1]])){
			$symbol = $iconset[$type[1]];
		}elseif(isset($iconset[$type[0]])){
			$symbol = $iconset[$type[0]];
		}?>
		<a class="file" data-path="<?=$file?>" data-type="<?=$type[0]?>" data-name="<?=basename($file)?>"><?=$symbol?></a>
	<?endforeach;
}

switch(ARG_2){
	case "load-folder":
		$path = file_get_contents('php://input');
		$chain = explode("/", $path);
		array_splice($chain, 0, 1);
		navigate($path, implode("-",$chain));
	break;
	case "create-file":
		$fullpath = file_get_contents('php://input');
		file_put_contents($fullpath, "\n");
		
		$chain = array_slice(explode("/", $fullpath), 1, -1);
		navigate("../".implode("/",$chain), implode("-",$chain));
	break;
	case "create-folder":
		$fullpath = file_get_contents('php://input');
		@mkpath($fullpath);
		
		$chain = array_slice(explode("/", $fullpath), 1, -1);
		navigate("../".implode("/",$chain), implode("-",$chain));
	break;
	case "remove":
		$path = file_get_contents('php://input');
		if(is_dir($path)){
			deletedir($path);			// Remove folder
		}elseif(is_file($path)) unlink($path);
		$chain = array_slice(explode("/", $path), 1, -1);
		navigate("../".implode("/",$chain), implode("-",$chain));
	break;
	case "save-file":
		$data = file_get_contents('php://input');
		file_put_contents($_GET['path'], $data);
		print($saved);
	break;
	case "download":
		$fsize = filesize($_GET['path']); 
		$mime = explode( "/", mime_content_type($_GET['path']) );
		header('Pragma: public');
		header("Content-Length: ".$fsize); 
		header("Content-Type: application/".end($mime));
		header("Content-Disposition: attachment; filename=".end(explode("/", $_GET['path'])));
		header('Cache-Control: public, must-revalidate, post-check=0, pre-check=0');
		
		readfile($_GET['path']);
	break;
	case "upload":
		$data = $HTTP_RAW_POST_DATA;
		if(empty($_GET['seek'])){				
			$size = file_put_contents($_GET['path']."/".$_GET['file'], $data);
		}else{
			$file = fopen($_GET['path']."/".$_GET['file'], "a");
			$size = fwrite($file, $data);
			fclose($file);
		}
		$size = ($size/1022)>>0;
		printf("<samp>%s%'.".(60 - strlen($_GET['file']))."d KB</samp>", $_GET['file'], $size);
	break;
	case "rename":
		$p = JSON::load('php://input');
		rename($p['old'], $p['new']);

		$chain = array_slice(explode("/", $p['old']), 1, -1);
		navigate("../".implode("/",$chain), implode("-",$chain));
	break;
	case "copy":
		$p = JSON::load('php://input');
		foreach($p['src'] as $src){
			$name = end( explode("/", $src) );
			if(is_file($src)){
				copy($src, $p['dest']."/".$name);
			}elseif(is_dir($src)) copyFolder($src, $p['dest']."/".$name);
		}
		$chain = array_slice(explode("/", $p['dest']), 1);
		navigate("../".implode("/",$chain), implode("-",$chain));
	break;
	case "move":
		$p = JSON::load('php://input');
		foreach($p['src'] as $src){
			rename($src, $p['dest']."/".end( explode("/", $src) ));
		}
		$chain = array_slice(explode("/", $p['dest']), 1);
		navigate("../".implode("/",$chain), implode("-",$chain));
	break;
	case "create-zip":
		$fullpath = file_get_contents('php://input');
		$locale = end(explode("/",$fullpath));
		$zip = new ZipArchive;
		$zip->open($fullpath.".zip", ZipArchive::CREATE);
		folderToZip($fullpath, $zip, $locale);
		$zip->close();
		
		$chain = array_slice(explode("/", $fullpath), 1, -1);
		navigate("../".implode("/",$chain), implode("-",$chain));
	break;
	case "unzip":
		$fullpath = file_get_contents('php://input');
		$items = array_slice(explode("/", $fullpath), 0, -1);
		$type = mime_content_type($fullpath);
		if($type==="application/zip"){
			$zip = new ZipArchive;
			if($zip->open($fullpath)){
				$zip->extractTo( implode("/", $items) );
				$zip->close();
			}
		}
		
		$chain = array_slice(explode("/", $fullpath), 1, -1);
		navigate("../".implode("/",$chain), implode("-",$chain));
	break;
	default:break;
}

?>