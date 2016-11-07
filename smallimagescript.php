<?php

require('preload.php');
ini_set("memory_limit", "256M");
set_time_limit(0);
ini_set('display_errors', '1');

$image_link = "./images/smallimages/articole/491/_MG_7921web.jpg";
//chown("./images/smallimages/articole/491/","root");
//chown($image_link,"root");
//chmod($image_link,0777);
$handle = fopen($image_link, "w");
fclose($handle);
chown($image_link,465); //Insert an Invalid UserId to set to Nobody Owner; for instance 465
$do = unlink($image_link);
//unlink($image_link);
exit;

##########################################RESIZE IMAGES ARTICLES##############################################
function GetAllArticlesImages()
{
	global $db;$i=0;
	$q="Select imagine from articles where id<200  and imagine!='default.jpg' ";
	$db->query($q);
	while($db->next_record())
	{
		$info[$i]['image_name'] = $db->f('imagine');
		$i++;
	}
	return $info;
}
$get_images = GetAllArticlesImages(); 
$imagefile = array();
echo count($get_images );
foreach ($get_images as $key =>$val)
{
	$imagefile["name"] = $val['image_name'];
	$type = explode(".",$imagefile["name"]);
	$imagefile["type"] = $type[count($type)-1];
	$cachedir = "";
	$a = Generate_Image("",$imagefile,$type="photos",$imagefile["name"],$cachedir);
}


function Generate_Image($size="",$imagefile="",$type="thumbnail",$prod_name="",$cache_dir)
{
		if($size=="" && $type=="photos")
		{
			$size ='100';
			$max = '100';
		}
		else
		{	$max= $size;}
		
		$link = "./images/users_articole/".$imagefile['name'];
		$file_ext = $imagefile['type'];
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
			
			#Set up picture
			$thumb = imagecreatetruecolor($newwidth, $newheight);
			$white = imagecolorallocate($thumb, 255, 255, 255);
			$grey = imagecolorallocate($thumb, 150, 150, 150);
			$red = imagecolorallocate($thumb, 255, 0, 0);
			imagefill($thumb, 0, 0, $white);
	
			
			$file_name = "./images/smallimages/articole/".$imagefile['name'];
			echo "  Image path:".	$file_name."<br>";
	
			$jpg_array = array('jpeg','jpg','JPG','JPEG','x-jpg','pjpeg','pipeg','vnd.swiftview-jpeg','x-xbitmap');
			if (in_array($file_ext,$jpg_array)) 
			{$big = imagecreatefromjpeg($link);}
			if (strtolower($file_ext)=="png"){$big = imagecreatefrompng($link);}
			if (strtolower($file_ext)=="gif"){$big = imagecreatefromgif($link);}
			
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
					{echo imagejpeg($thumb, $file_name, $image_quality);}
				if (strtolower($file_ext)=="png")
					{imagepng($thumb, $file_name, $image_quality);}
				if (strtolower($file_ext)=="gif")
					{imagegif($thumb, $file_name, $image_quality);}

				imagedestroy($thumb);
				imagedestroy($big);
			}
			unset($_SESSION['image_error']);
		
	}

#######################################RESIZE IMAGES FROM ANUNTURI##########################################
/*function GetAllAnunturiImages()
{
	global $db;$i=0;
	$q="Select imagine from anunturi where id>299 and id<400  and imagine!='default.jpg' ";
	$db->query($q);
	while($db->next_record())
	{
		$info[$i]['image_name'] = $db->f('imagine');
		$i++;
	}
	return $info;
}
$get_images = GetAllAnunturiImages(); 
$imagefile = array();
echo count($get_images );
foreach ($get_images as $key =>$val)
{
	$imagefile["name"] = $val['image_name'];
	$type = explode(".",$imagefile["name"]);
	$imagefile["type"] = $type[count($type)-1];
	$cachedir = "";
	$a = Generate_Image("",$imagefile,$type="photos",$imagefile["name"],$cachedir);
}


function Generate_Image($size="",$imagefile="",$type="thumbnail",$prod_name="",$cache_dir)
{
		if($size=="" && $type=="photos")
		{
			$size ='100';
			$max = '100';
		}
		else
		{	$max= $size;}
		
		$link = "./images/users_anunturi/".$imagefile['name'];
		$file_ext = $imagefile['type'];
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
			
			#Set up picture
			$thumb = imagecreatetruecolor($newwidth, $newheight);
			$white = imagecolorallocate($thumb, 255, 255, 255);
			$grey = imagecolorallocate($thumb, 150, 150, 150);
			$red = imagecolorallocate($thumb, 255, 0, 0);
			imagefill($thumb, 0, 0, $white);
	
			
			$file_name = "./images/smallimages/anunturi/".$imagefile['name'];
			echo "  Image path:".	$file_name."<br>";
	
			$jpg_array = array('jpeg','jpg','JPG','JPEG','x-jpg','pjpeg','pipeg','vnd.swiftview-jpeg','x-xbitmap');
			if (in_array($file_ext,$jpg_array)) 
			{$big = imagecreatefromjpeg($link);}
			if (strtolower($file_ext)=="png"){$big = imagecreatefrompng($link);}
			if (strtolower($file_ext)=="gif"){$big = imagecreatefromgif($link);}
			
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
					{echo imagejpeg($thumb, $file_name, $image_quality);}
				if (strtolower($file_ext)=="png")
					{imagepng($thumb, $file_name, $image_quality);}
				if (strtolower($file_ext)=="gif")
					{imagegif($thumb, $file_name, $image_quality);}

				imagedestroy($thumb);
				imagedestroy($big);
			}
			unset($_SESSION['image_error']);
		
	}
*/
 #########################################################we resize the images form cabinete###########################################
/*#let take the images from db
function GetAllCabineteImages()
{
	global $db;$i=0;
	$q="Select * from images where id>1499 and id<1908";
	$db->query($q);
	while($db->next_record())
	{
		$info[$i]['id'] = $db->f('id');
		$info[$i]['image_name'] = $db->f('image_name');
		$info[$i]['folder_id'] = $db->f('folder_id');
		
		$i++;
	}
	return $info;
}
$get_images = GetAllCabineteImages(); 
$imagefile = array();
echo count($get_images );
foreach ($get_images as $key =>$val)
{
	$imagefile["name"] = $val['image_name'];
	$imagefile["item_id"] = $val['id'];
	$imagefile["folder_id"] = $val['folder_id'];
	$type = explode(".",$imagefile["name"]);
	$imagefile["type"] = $type[count($type)-1];
	$cachedir = $imagefile["folder_id"];
	$a = Generate_Image("",$imagefile,$type="photos",$imagefile["name"],$cachedir);
}



function Generate_Image($size="",$imagefile="",$type="thumbnail",$prod_name="",$cache_dir)
{
		if($size=="" && $type=="photos")
		{
			$size ='100';
			$max = '100';
		}
		else
		{	$max= $size;}
		
		$link = "./images/users_cabinete/".$cache_dir."/".$imagefile['name'];
		$file_ext = $imagefile['type'];
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
			
			#Set up picture
			$thumb = imagecreatetruecolor($newwidth, $newheight);
			$white = imagecolorallocate($thumb, 255, 255, 255);
			$grey = imagecolorallocate($thumb, 150, 150, 150);
			$red = imagecolorallocate($thumb, 255, 0, 0);
			imagefill($thumb, 0, 0, $white);
	
			
			$file_name = "./images/smallimages/cabinete/".$imagefile['name'];
			echo "  Image path:".	$file_name."<br>";
	
			$jpg_array = array('jpeg','jpg','JPG','JPEG','x-jpg','pjpeg','pipeg','vnd.swiftview-jpeg','x-xbitmap');
			if (in_array($file_ext,$jpg_array)) 
			{$big = imagecreatefromjpeg($link);}
			if (strtolower($file_ext)=="png"){$big = imagecreatefrompng($link);}
			if (strtolower($file_ext)=="gif"){$big = imagecreatefromgif($link);}
			
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
					{echo imagejpeg($thumb, $file_name, $image_quality);}
				if (strtolower($file_ext)=="png")
					{imagepng($thumb, $file_name, $image_quality);}
				if (strtolower($file_ext)=="gif")
					{imagegif($thumb, $file_name, $image_quality);}

				imagedestroy($thumb);
				imagedestroy($big);
			}
			unset($_SESSION['image_error']);
		
	}*/
?>