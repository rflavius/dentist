<?php

require('preload.php');
ini_set("memory_limit", "256M");
set_time_limit(0);
ini_set('display_errors', '1');

//echo ini_get("memory_limit");exit;


#only if we have what to resize we do it
$sql = "SELECT * FROM resize_img_cron WHERE status='N' LIMIT 0,1";
$db->query($sql);
if($db->num_rows()>0)
{
	
	$db->next_record();
	$id_record = $db->f('id');
	$imagefile["name"] = $db->f('image_name');
	$imagefile["item_id"] = $db->f('item_id');
	$imagefile["tmp_name"] = '';
	$type = explode(".",$imagefile["name"]);
	$imagefile["type"] = $type[count($type)-1];
	$imagefile["error"] = '';
	if((stristr($db->f('folder_name'),".."))!=='FALSE')
	{
		$imagefile["folder_name"] = str_replace("..",".",$db->f('folder_name'));
	}
	else
	{
		$imagefile["folder_name"] =$db->f('folder_name');
	}
	
	$cachedir = $imagefile["folder_name"];
	//$file_picture = $imagefile["folder_name"].'/'.$imagefile["name"];
	print_r($imagefile);
	if(isset($imagefile))
	{
		$type = explode(".", $imagefile['name']);
		$type = $type[1];
		$file_name = $imagefile['name'];
		if(isset($_SESSION['image_error']))
		{
			unset($_SESSION['image_error']);
			
		}
		#here we make all the reize stuffs
		//print_R($imagefile);exit;
		if($type!='png')
		{
			echo "d";
			$a = Generate_Image("",$imagefile,$type="photos",$file_name,$cachedir);
		}
		
		
		//http://www.dentistonline.ro/upload_js/resizeImage2.inc.php?width=80&height=80&cropratio=1:1&image=//images/users_cabinete/1282/34es-dent-clinica-brasov.jpg&firma_id=1282
		//echo '<img src="{SITE_BASE}/upload_js/resizeImage2.inc.php?width=80&height=80&cropratio=1:1&image=/'.$cachedir.'/'.$imagefile["name"].'&firma_id='.$imagefile["item_id"].'">';
		$sql_update = "Update resize_img_cron set status='Y' where id='".$id_record."'";
		$db->query($sql_update);

	}



}
exit;


function Generate_Image($size="",$imagefile="",$type="thumbnail",$prod_name="",$cachedir)
{
	if($size=="" && $type=="photos")
	{
		$size ='500';
		$max = '500';
		$cache_dir = $cachedir;
	}
	else
	{	$max= $size;}
		
		$link = $cache_dir.$imagefile['name'];
		$file_ext = $imagefile['type'];
		($prod_name=="") ? $file_name = $cache_dir.$imagefile['name'] : $file_name = $cache_dir.$prod_name;


		$currentimagesize = getimagesize($link);
		$image_width = $currentimagesize[0];
		$image_height= $currentimagesize[1];
		if ($size!="")
		{
			if (($image_height > $max) || ($image_width > $max))
			{
				if ($image_height > $image_width)
				{
					$sizefactor = (double) ($max / $image_height);
				}
				else
				{
					$sizefactor = (double) ($max / $image_width) ;
				}
			}
			else  $sizefactor = 1;
			$newwidth = (int) ($image_width * $sizefactor);
			$newheight = (int) ($image_height * $sizefactor);
		}
		else
		{
			$newwidth = $image_width;
			$newheight = $image_height;
		}
			echo "inainte: <img src=\"".$link."\">";
			#Set up picture
			$thumb = imagecreatetruecolor($newwidth, $newheight);
			$white = imagecolorallocate($thumb, 255, 255, 255);
			$grey = imagecolorallocate($thumb, 150, 150, 150);
			$red = imagecolorallocate($thumb, 255, 0, 0);
			imagefill($thumb, 0, 0, $white);
	
			print_r($file_ext);
			echo "<br> Image path:".$link;
	
			$jpg_array = array('jpeg','jpg','JPG','JPEG','x-jpg','pjpeg','pipeg','vnd.swiftview-jpeg','x-xbitmap');
			if (in_array($file_ext,$jpg_array)) 
				{$big = imagecreatefromjpeg($link);}
			if (strtolower($file_ext)=="png"){$big = imagecreatefrompng($link);}
			if (strtolower($file_ext)=="gif"){$big = imagecreatefromgif($link);}
			
			echo "<br><img src=\"".$link."\">";
			//var_dump($big);
			if (!$big)
			{		$_SESSION['image_error'][]="Error when creating the new image from <b>".$imagefile['name']."</b>";		}
			
			if (!isset($_SESSION['image_error']))
			{
				
				$img_resample = imagecopyresampled($thumb, $big, 0, 0, 0, 0, $newwidth, $newheight, $image_width, $image_height);
				if (!$img_resample)
				{
					$_SESSION['image_error'][]="Error when resizing the image <b>".$val['image_name']."</b>";
				}
				$image_quality = 80;
				$jpg_array = array('jpeg','jpg','JPG','JPEG','x-jpg','pjpeg','pipeg','vnd.swiftview-jpeg','x-xbitmap');
				if (in_array($file_ext,$jpg_array))
					{imagejpeg($thumb, $file_name, $image_quality);}
				if (strtolower($file_ext)=="png"){imagepng($thumb, $file_name, $image_quality);}
				if (strtolower($file_ext)=="gif"){imagegif($thumb, $file_name, $image_quality);}
				imagedestroy($thumb);
				imagedestroy($big);
			}
		
}


?>