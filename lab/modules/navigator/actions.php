<?php

switch(ARG_2){
	case "create-folder":
		$p = JSON::load("php://input");
		$path = explode("/", $p['path']);
		array_splice($path, 1, 0, "data");
		array_unshift($path, "..");
		$path[] = $p['name'];
		$created = @mkpath( implode("/", $path) );
		print (INT)$created;
	break;
	case "delete":
		$p = JSON::load("php://input");
		foreach($p as $item){
			if(is_dir($item['path'])){
				deletedir($item['path']);
			}elseif(is_file($item['path'])) unlink($item['path']);
		}
	break;
	case "prowler":
		$path = explode("/", $_GET['path']);
		array_splice($path, 1, 0, "data");
		$path = "../".implode("/", $path);

		$p = JSON::load('php://input');		// Get images list
		
		foreach($p as $itm){
			$file = file_get_contents($itm['url']);
			file_put_contents($path."/".$itm['filename'], $file);
		}
	break;
	case "upload":
		$data = $HTTP_RAW_POST_DATA;
		$path = explode("/", $_GET['path']);
		array_splice($path, 1, 0, "data");
		$path = "../".implode("/", $path);
		if(empty($_GET['seek'])){				
			$size = file_put_contents($path."/".$_GET['file'], $data);
		}else{
			$file = fopen($path."/".$_GET['file'], "a");
			$size = fwrite($file, $data);
			fclose($file);
		}
		$size = ($size/1022)>>0;
		printf("<samp>%s%'.".(60 - strlen($_GET['file']))."d KB</samp>", $_GET['file'], $size);
	break;
	case "create-zip":
		$path = explode("/", $HTTP_RAW_POST_DATA);
		array_splice($path, 1, 0, "data");
		array_unshift($path, "..");
		$fullpath = implode("/", $path);
		
		$locale = end( $path );
		$zip = new ZipArchive;
		$zip->open($fullpath.".zip", ZipArchive::CREATE);
		folderToZip($fullpath, $zip, $locale);
		$zip->close();
	break;
	case "unzip":
		$path = explode("/", $HTTP_RAW_POST_DATA);
		array_splice($path, 1, 0, "data");
		array_unshift($path, "..");
		$fullpath = implode("/", $path);

		$type = mime_content_type($fullpath);
		if($type==="application/zip"){
			$zip = new ZipArchive;
			if($zip->open($fullpath)){
				$zip->extractTo( implode("/", array_slice($path, 0, -1)) );
				$zip->close();
			}
		}
		print $fullpath; 
	break;
	case "rename":
		$p = JSON::load('php://input');
		$old = explode("/", $p['old']);
		array_splice($old, 1, 0, "data");
		$new = explode("/", $p['new']);
		array_splice($new, 1, 0, "data");
		rename("../".implode("/",$old), "../".implode("/",$new));
	break;
	case "copy":
		$p = JSON::load('php://input');
		foreach($p as $src){
			$file = basename($src);

			if(is_file($src)){
				copy($src, "../".$_GET['path']."/".$file );
			}elseif(is_dir($src)) copyFolder($src, "../".$_GET['path']."/".$file );
		}
	break;
	case "move":
		$p = JSON::load('php://input');
		foreach($p as $src){
			$file = basename($src);
			rename($src, "../".$_GET['path']."/".$file);
		}
	break;
	case "download":
		$path = explode("/", $_GET['path']);
		array_splice($path, 1, 0, "data");
		$path = "../".implode("/", $path);

		$fsize = filesize($path); 

		header('Pragma: public');
		header("Content-Length: ".$fsize); 
		header("Content-Type: ".mime_content_type($path));
		header("Content-Disposition: attachment; filename=".end(explode("/", $path)));
		header('Cache-Control: public, must-revalidate, post-check=0, pre-check=0');

		readfile($path);
	break;
	default:break;
}
?>