<?php
/*
 * here is the thumbnails.php
 * here we make the resize on images
 */


// phpinfo(); 
//ini_set('display_errors',1);
//ini_set('display_startup_errors',1);
//error_reporting(E_ALL);

//print_r($link);exit;

$target = 'default.jpg';
$folder = "../images/users_cabinete/";
if (isset($_GET['target']) && $_GET['target'] != "" && $_GET['target'] != "default.jpg")
{	
	$target = $_GET['target'];
	$folder = "../images/users_cabinete/".$_GET['folder']."/";
}

$ext = explode(".",$target);
$extension =$ext[1];

/*change for a new preview - download item preview pic*/
if (isset($_GET['anunturi']))
{		$folder = "../images/users_anunturi/";	}
if (isset($_GET['articles']))
{		$folder = "../images/users_articole/";	}

if (isset($_GET['news']))
{		$folder = "../images/news/";	}

if (isset($_GET['banner']))
{		$folder = "../images/banner/";	}

/*check if the file exists*/
$link = $folder.$target;

if (!file_exists($folder.$target))
{
	$link = $folder."default.jpg";//default image
}

//echo $link;exit;

$max = (isset($_GET['max_size']) && $_GET['max_size'] != "")? $_GET['max_size']:120;
//$max_size = variable from get

	//print_r($link);exit;

/* send first the header, to work in stupid browsers */
if($extension=="png")
{	header('Content-Type: image/png');	}
elseif($extension=="gif")
{	header('Content-Type: image/gif');	}
else
{	header('Content-Type: image/jpeg');	}


/*get current image size*/
$currentimagesize = getimagesize($link);

$image_width = $currentimagesize[0];
$image_height = $currentimagesize[1];

/*get the size factor - a number between 0.1 and 1 with wich the image will be multiplied*/

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
else
{
	$sizefactor = 1;
}
/*get new sizes*/
$newwidth = (int) ($image_width * $sizefactor);
$newheight = (int) ($image_height * $sizefactor);
/*create thumbnail*/
$thumb = imagecreatetruecolor($newwidth, $newheight);
/*create the image*/
if($extension=="png")
{	$big = imagecreatefrompng ($link);}
elseif($extension=="gif")
{	$big = imagecreatefromgif ($link);}
else
{	$big = imagecreatefromjpeg ($link);	}

/*copy a rectangular portion of one image to another image*/
imagecopyresampled($thumb, $big, 0, 0, 0, 0, $newwidth, $newheight, $image_width, $image_height);
/*creates the JPEG file in filename from the image $target*/
if($extension=="png")
{	imagepng($thumb, NULL, '9');	}
elseif($extension=="gif")
{
	imagegif($thumb);
}
else
{		imagejpeg($thumb, NULL, '100');	}

/*free any memory associated with image $target*/
imagedestroy($thumb);
