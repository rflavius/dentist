<?php

function getArticolServiciiFile($art_id)
{
	global $db;
	$sql = "SELECT * FROM articole_file WHERE articol_id='$art_id'";
	$db->query($sql);
	if ($db->num_rows()>0 )
	{
		$db->next_record();
		$info['id'] = $db->f('id');
		$info['name'] = $db->f('name');
		$info['articol_id'] = $db->f('articol_id');
		$info['date'] = $db->f('date');
		return $info;
	}
	else 
	{
		return "";
	}
}
#used in front end
function GetArtIdByAlias($alias)
{
	global $db;
	$query = "SELECT id FROM articles
						WHERE trim(lower(alias)) = '".trim(strtolower($alias))."'";

	$db->query($query);
	$db->next_record();
	return $db->f('id');

}
function GetArtIdByAlias2($alias)
{
	global $db;
	$query = "SELECT id FROM articles
						WHERE trim(lower(titlu)) = '".trim(strtolower($alias))."'";

	$db->query($query);
	$db->next_record();
	return $db->f('id');

}
#frontend
function UpdateArticleViews($id) 
 { 
      global $db; 
      if(!isset($_COOKIE['article_visits_'.$id])) 
      { 
           ## set the cookie for 5min...in time we will make it from config 
           setcookie('article_visits_'.$id,$id,time()+300,"/",".dentistonline.ro",0); 
           $sql = "UPDATE articles SET nr_visits=nr_visits+1 WHERE id='".$id."'"; 
           $db->query($sql); 
      } 
 } 

function getLastUserRecomandatArticle($u_id)
{
	global $db;
	$sql = "SELECT * FROM articles WHERE user_id='$u_id' AND `recomandat`='Y'";
	$db->query($sql);
	if($db->num_rows()>0)
	{
		while($db->next_record())
		{
			$info['id'] = $db->f('id');
			$info['category_id'] = $db->f('bigcat_id');
			$info['titlu'] = $db->f('titlu');
			$info['status'] = $db->f('status');
			$info['continut'] = $db->f('continut');
			$info['email'] = $db->f('email');
			$info['autor'] = $db->f('autor');
			$info['user_id'] = $db->f('user_id');
			$info['imagine'] = $db->f('imagine');
			$info['related'] = $db->f('related');
			$info['alias'] = $db->f('alias');
			$info['meta_keywords'] = $db->f('meta_keywords');
			$info['meta_description'] = $db->f('meta_description');
			$info['data_adaugarii'] = TimeFormatShort($db->f('data_adaugarii'));
			$info['data_modificarii'] = $db->f('data_modificarii');
			$info['nr_visits'] =$db->f('nr_visits');
			$info['recomandam_articole'] =$db->f('recomandam_articole');
			$info['recomandat'] =$db->f('recomandat');
		}
		return $info;
	}
	else
	{
		return '';
	}
}

function GetArticole($user_id,$id_anunt=-1)
{
		global $db;$info=array();$i=0;
		switch($id_anunt)
		{
			default:
			if ($user_id='-1' )
			{
				$query = "SELECT * FROM articles WHERE id='".$id_anunt."' order by data_adaugarii DESC";
			}
			else 
			{
				$query = "SELECT * FROM articles WHERE user_id= '".$user_id."' and id='".$id_anunt."' order by data_adaugarii DESC";
			}
			
			
				
			break;
			
			case '-1':
				$query = "SELECT * FROM articles WHERE user_id= '".$user_id."' order by data_adaugarii DESC";
			break;
		}
	
		$db->query($query);
		while($db->next_record())
		{
			$info[$i]['id'] = $db->f('id');
			$info[$i]['category_id'] = $db->f('bigcat_id');
			$info[$i]['titlu'] = $db->f('titlu');
			$info[$i]['status'] = $db->f('status');
			$info[$i]['continut'] = $db->f('continut');
			$info[$i]['email'] = $db->f('email');
			$info[$i]['autor'] = $db->f('autor');
			$info[$i]['user_id'] = $db->f('user_id');
			$info[$i]['imagine'] = $db->f('imagine');
			$info[$i]['related'] = $db->f('related');
			$info[$i]['alias'] = $db->f('alias');
			$info[$i]['meta_keywords'] = $db->f('meta_keywords');
			$info[$i]['meta_description'] = $db->f('meta_description');
			$info[$i]['data_adaugarii'] = TimeFormatShort($db->f('data_adaugarii'));
			$info[$i]['data_modificarii'] = $db->f('data_modificarii');
			$info[$i]['nr_visits'] =$db->f('nr_visits');
			$info[$i]['recomandam_articole'] =$db->f('recomandam_articole');
			$info[$i]['recomandat'] =$db->f('recomandat');
			$i++;
		}
		return $info;
		
}


function UpdateArticle($category, $title, $continut,$id,$meta_keywords, $meta_description,$autor,$email,$tags)
{
	global $db;
	if(!isset($id))
	{
		$id=-1;
	}
	/*$query = "UPDATE articles SET titlu = '".addslashes($title)."',
																continut = '".CleanImagePath(addslashes($continut))."',
																meta_keywords = '".addslashes($meta_keywords)."',
																meta_description = '".addslashes($meta_description)."',
																bigcat_id = '".addslashes($category)."',
																autor = '".addslashes($autor)."',
																email = '".addslashes($email)."'
						WHERE id = '".$id."'";*/
					  	$query = "UPDATE articles SET 
								titlu = '".mysql_real_escape_string(strip_tags($title,'<p><font><b><br><strong><i><u><font>'))."',
								continut = '".mysql_real_escape_string(strip_tags($continut,'<p><font><b><br><strong><i><u><font>'))."',
								meta_keywords = '".mysql_real_escape_string(strip_tags($meta_keywords,'<p><font><b><br><strong><i><u><font>'))."',
								meta_description = '".mysql_real_escape_string(strip_tags($meta_description,'<p><font><b><br><strong><i><u><font>'))."',
								bigcat_id = '".mysql_real_escape_string(strip_tags($category,'<p><font><b><br><strong><i><u><font>'))."',
								autor = '".mysql_real_escape_string(strip_tags($autor,'<p><font><b><br><strong><i><u><font>'))."',
								tags = '".mysql_real_escape_string(strip_tags($tags,'<p><font><b><br><strong><i><u><font>'))."',
								data_modificarii=now(),
								email = '".mysql_real_escape_string(strip_tags($email,'<p><font><b><br><strong><i><u><font>'))."'
						WHERE id = '".$id."'";
	$db->query($query);
	return '0';
}
//i want to be abel to add images into an article
function UpdateAdminArticle($category, $title, $continut,$id,$meta_keywords, $meta_description,$autor,$email,$tags)
{
	global $db;
	if(!isset($id))
	{
		$id=-1;
	}
	/*$query = "UPDATE articles SET titlu = '".addslashes($title)."',
																continut = '".CleanImagePath(addslashes($continut))."',
																meta_keywords = '".addslashes($meta_keywords)."',
																meta_description = '".addslashes($meta_description)."',
																bigcat_id = '".addslashes($category)."',
																autor = '".addslashes($autor)."',
																email = '".addslashes($email)."'
						WHERE id = '".$id."'";*/
					  	$query = "UPDATE articles SET 
								titlu = '".mysql_real_escape_string(strip_tags($title,'<p><font><b><br><strong><i><u><font>'))."',
								continut = '".mysql_real_escape_string(strip_tags($continut,'<p><font><b><br><strong><i><u><img><font>'))."',
								meta_keywords = '".mysql_real_escape_string(strip_tags($meta_keywords,'<p><font><b><br><strong><i><u><font>'))."',
								meta_description = '".mysql_real_escape_string(strip_tags($meta_description,'<p><font><b><br><strong><i><u><font>'))."',
								bigcat_id = '".mysql_real_escape_string(strip_tags($category,'<p><font><b><br><strong><i><u><font>'))."',
								autor = '".mysql_real_escape_string(strip_tags($autor,'<p><font><b><br><strong><i><u><font>'))."',
								tags = '".mysql_real_escape_string(strip_tags($tags,'<p><font><b><br><strong><i><u><font>'))."',
								data_modificarii=now(),
								email = '".mysql_real_escape_string(strip_tags($email,'<p><font><b><br><strong><i><u><font>'))."'
						WHERE id = '".$id."'";
	$db->query($query);
	return '0';
}
# Function used in : admin / articles.php
function ListAdminArticles ($cat_id, $status, $limit)
{
	global $db;
	if($status!="all")
	{	 $status_q="and status = ".$status;  }
	else
	{		$status_q="";	}

	switch ($cat_id)
	{
		case 'all':
			$status_q="";
			if($status!='all')
			{
				 $status_q="where status = ".$status; 
			}
			$query = "SELECT * FROM articles ".$status_q." ORDER by data_adaugarii DESC".$limit;
		break;
		
		default:
			$query = "SELECT * FROM articles
											WHERE bigcat_id = '".$cat_id."' ".$status_q." ORDER by data_adaugarii DESC".$limit;
		break;
	
	}
	$db->query($query);
	$i = 0; $get_info = array();
	$db->query($query);
	while ($db->next_record())
	{
		$get_info[$i]['id'] = $db->f('id');
		$get_info[$i]['titlu'] = $db->f('titlu');
		$get_info[$i]['imagine'] = $db->f('imagine');
		$get_info[$i]['bigcat_id'] = $db->f('bigcat_id');
		$get_info[$i]['data_adaugarii'] = $db->f('data_adaugarii');
		$get_info[$i]['data_modificarii'] = $db->f('data_modificarii');
		$get_info[$i]['user_id'] = $db->f('user_id');
		$get_info[$i]['email'] = $db->f('email');
		$get_info[$i]['autor'] = $db->f('autor');
		$get_info[$i]['meta_keywords'] = $db->f('meta_keywords');
		$get_info[$i]['meta_description'] = $db->f('meta_description');
		$get_info[$i]['continut'] = strip_tags($db->f('continut'));
		$get_info[$i]['status'] = $db->f('status');
		$get_info[$i]['tags'] = $db->f('tags');
		$get_info[$i]['related'] = $db->f('related');
		$get_info[$i]['nr_visits'] = $db->f('nr_visits');
		$i++;
	}

	return $get_info;
}
/*
- Function used in : admin / articles.php
-                  : sources / sitemap.php
-                  : classes / general_functions.inc.php
*/
#if I have an article I can see his category
function GetArticlesCategories ($active, $article_id)
{
	global $db;
	$cats = array();
	switch ($active)
	{
		default :
			$status = " WHERE active = '".$active."'";
		break;

		case '-1':
			$status = "";
		break;
	}
	if ($article_id != "")
	{
		/*select the parent_module*/
		$query = "SELECT bigcat_id FROM articles WHERE id = '".$article_id."'";
	}
	else 
	{
		$query = "SELECT * FROM articles_categories	 ".$status."order by cat_name asc";
	}
	$db->query($query);
	$i = 0;
	while ($db->next_record())
	{
		$cats[$i]['id_cat'] = $db->f('id_cat');
		$cats[$i]['cat_name'] = $db->f('cat_name');
		$cats[$i]['active'] = $db->f('active');
		$cats[$i]['alias'] = $db->f('alias');
		$cats[$i]['image_name'] = $db->f('image_name');
		$i++;
	}
	return $cats;
}

function GetArticleCategoryInfos ($id)
{
	global $db;
	if(isset($id)&&($id!=""))
	{
		$query = "SELECT * FROM articles_categories
								WHERE id_cat = '".$id."'";
		$db->query($query);
		$db->next_record();
		$infos = array();
			$infos['id_cat']=$db->f('id_cat');
			$infos['cat_name']=$db->f('cat_name');
			$infos['alias']=$db->f('alias');
			$infos['image_name']=$db->f('image_name');
			$infos['meta_keywords']=$db->f('meta_keywords');
			$infos['meta_description']=$db->f('meta_description');
		return $infos;
			
	}

}
function GetArticleCategoryInfosByAlias ($alias)
{
	global $db;
	$query = "SELECT * FROM articles_categories
							WHERE alias = '".addslashes($alias)."'";
	$db->query($query);
	$db->next_record();
	$infos=array();

	$infos['id_cat']=$db->f('id_cat');
	$infos['cat_name']=$db->f('cat_name');
	$infos['alias']=$db->f('alias');
	$infos['meta_keywords']=$db->f('meta_keywords');
	$infos['meta_description']=$db->f('meta_description');

	return $infos;
}
function CountArticlesTotalRecords ($cat_id, $status)
{
	global $db;
	if($status!="all")
	{
		$status_q="and status = ".$status;
	}
	else
	{
		$status_q="";
	}

	switch ($cat_id)
	{
		case 'all':
			$status_q="";
			if($status!='all')
			{
				 $status_q="where status = ".$status; 
			}
			$query = "SELECT id FROM articles ".$status_q;
		break;
		
		default:
			$query = "SELECT id FROM articles
											WHERE bigcat_id = '".$cat_id."' ".$status_q;
		break;
	
	}
	$db->query($query);
	return $db->num_rows();
}


function GetSelectedArticle ($id)
{
	global $db;
	$query = "SELECT * FROM articles WHERE id = '".$id."'";
	$db->query($query);
	$db->next_record();
	$article = array();

	$article['id'] = $db->f('id');
	$article['category_id'] = $db->f('bigcat_id');
	$article['titlu'] = $db->f('titlu');
	$article['status'] = $db->f('status');
	$article['continut'] = $db->f('continut');
	$article['email'] = $db->f('email');
	$article['autor'] = $db->f('autor');
	$article['user_id'] = $db->f('user_id');
	$article['imagine'] = $db->f('imagine');
	$article['tags'] = $db->f('tags');
	$article['meta_keywords'] = $db->f('meta_keywords');	
	$article['related'] = $db->f('related');
	$article['meta_description'] = $db->f('meta_description');
	$article['nr_visits'] = $db->f('nr_visits');
	$article['data_adaugarii'] = TimeFormatShort($db->f('data_adaugarii'));
	$article['data_modificarii'] = $db->f('data_modificarii');
	return $article;
}
function InsertArticle($user_id, $titlu, $continut,$category_id,$autor,$email,$meta_keywords=1,$meta_description=1,$tags)
{
	global $db;
	global $conf;
	$alias = GenerateAlias($titlu);
	$query ="Insert into articles (user_id,titlu,continut,bigcat_id,data_adaugarii,autor,email,meta_keywords,meta_description,alias,tags) values('".$user_id."','".mysql_real_escape_string(strip_tags($titlu,'<p><font><b><br><strong><i><u><font>'))."','".mysql_real_escape_string(strip_tags($continut,'<p><font><b><br><strong><i><u><font>'))."','".$category_id."',now(),'".mysql_real_escape_string(strip_tags($autor,'<p><font><b><br><strong><i><u><font>'))."','".mysql_real_escape_string(strip_tags($email,'<p><font><b><br><strong><i><u><font>'))."','".mysql_real_escape_string(strip_tags($meta_keywords,'<p><font><b><br><strong><i><u><font>'))."','".mysql_real_escape_string(strip_tags($meta_description,'<p><font><b><br><strong><i><u><font>'))."','".$alias."','".$tags."')";
	$db->query($query);
	return $db->last_insert_id();
}

/*just added to content <img> tag, to be able to add images*/
function InsertAdminArticle($user_id, $titlu, $continut,$category_id,$autor,$email,$meta_keywords=1,$meta_description=1,$tags)
{
	global $db;
	global $conf;
	$alias = GenerateAlias($titlu);
	$query ="Insert into articles (user_id,titlu,continut,bigcat_id,data_adaugarii,autor,email,meta_keywords,meta_description,alias,tags) values('".$user_id."','".mysql_real_escape_string(strip_tags($titlu,'<p><font><b><br><strong><i><u><font>'))."','".mysql_real_escape_string(strip_tags($continut,'<p><font><b><br><strong><i><img><u><font>'))."','".$category_id."',now(),'".mysql_real_escape_string(strip_tags($autor,'<p><font><b><br><strong><i><u><font>'))."','".mysql_real_escape_string(strip_tags($email,'<p><font><b><br><strong><i><u><font>'))."','".mysql_real_escape_string(strip_tags($meta_keywords,'<p><font><b><br><strong><i><u><font>'))."','".mysql_real_escape_string(strip_tags($meta_description,'<p><font><b><br><strong><i><u><font>'))."','".$alias."','".$tags."')";
	$db->query($query);
	return $db->last_insert_id();
}
function SavePicturesArticles ($file_extension, $id,$front_back)
{
	global $conf;
	global $db;
	
	if($front_back=="frontend")
	{		$uploaddir = '../images/users_articole/'; }
	else
	{		$uploaddir = '../images/users_articole/';	}

	
	if ($file_extension!="default" )
	{
			#daca anuntul are imagine sa o stergem
			$sql = "SELECT * from articles where id='".$id."'";
			$db->query($sql);
			if($db->affected_rows()>0)
			{
				$db->next_record();
				$img_name = $db->f('imagine');
				if((strpos($img_name,"default")===false)&&($img_name!=""))
				{		unlink($uploaddir.$img_name);	}
			
			}

			/*create photo name*/
			//$today = date("Ymd");                           
			//$filename = 'articol_'.$today.'_'.$id.'.'.$file_extension;
			//$uploadfile = $uploaddir.$filename;
			

			$filename = $_FILES['imagine']['name'];
			$filename = GenerateImageNameArticles($filename);
			$uploadfile = $uploaddir.$filename;


			/*do query*/
			$query = "UPDATE articles SET imagine = '".$filename."' WHERE id = '".$id."'";
			$db->query($query);
			

			$foldername = './images/users_articole/';
			#lets insert to reseze table images
			$sql2 = "INSERT INTO resize_img_cron(`id`, `image_name`, `item_id`, `size`, `status`, `date`,`folder_name`) VALUES ('','".$filename."','".$id."','".$_FILES['imagine']['size']."','N','','".addslashes($foldername)."')";
			$db->query($sql2);

			/*upload picture*/
			if (!move_uploaded_file($_FILES['imagine']['tmp_name'], $uploadfile))
			{
				print "Possible file upload attack!  Here's some debugging info:\n";
				print_r($_FILES);
			}
			/*change chmode*/
			chmod($uploadfile, 0777);
	}
	else 
	{
			$filename = 'default.jpg';
			$query = "UPDATE articles SET imagine = '".$filename."' WHERE id = '".$id."'";
			$db->query($query);
	
	}
	
}

 /*
- Function used in : sources / cabinete.php
*/
function GetPreviousOrNextArticle ($id,$big_cat_id)
{
	global $db;
	$this_cabinete = array();
	$query = "SELECT data_adaugarii
			FROM articles
			WHERE id = '".$id."'";
	$db->query($query);
	$db->next_record();
	$submision_date = $db->f("data_adaugarii");
		#select previous if exists - cabinet is newer than current
		$query = "SELECT id,titlu FROM articles
							WHERE bigcat_id = '".$big_cat_id."'
							AND data_adaugarii > '".$submision_date."'
							ORDER by data_adaugarii ASC
							LIMIT 1";
		$db->query($query);
		if ($db->num_rows() != 0)
		{
			$db->next_record();
			$this_cabinete['previous']['id'] = $db->f("id");
			$this_cabinete['previous']['title'] = substr($db->f("titlu"),0,30);
		}
		#select next if exists - cabinet is older than current
		$query = "SELECT id,titlu FROM articles
							WHERE bigcat_id = '".$big_cat_id."'
							AND data_adaugarii < '".$submision_date."'
							ORDER by data_adaugarii DESC
							LIMIT 1";
		$db->query($query);
		if ($db->num_rows() != 0)
		{
			$db->next_record();
			$this_cabinete['next']['id'] = $db->f("id");
			$this_cabinete['next']['title'] = substr($db->f("titlu"),0,30);
		}
	return $this_cabinete;
}

function GenerateImageNameArticles($nume_imagine)
{
	global $db;
	$nume_imagine = ereg_replace("[^a-zA-Z0-9_.:/\-]", "", $nume_imagine);
	$query = "SELECT id FROM articles
						WHERE imagine = '".addslashes($nume_imagine)."'";
	$db->query($query);
	
	if($db->affected_rows()>0)
	{
		$nume_imagine = mt_rand(3,20).$nume_imagine;
	}

		return $nume_imagine;
}

function Generate_Small_Images_Article($id_art)
{
		$imagefile = array();
		$get_images = GetSelectedArticle($id_art);
		$imagefile["name"] = $get_images['imagine'];
		$type = explode(".",$imagefile["name"]);
		$imagefile["type"] = $type[count($type)-1];
		$cachedir = $id_art;
		$a = Generate_Image_Articles("",$imagefile,$type="photos",$imagefile["name"],$cachedir);
		return 1;
}
function Generate_Image_Articles($size="",$imagefile="",$type="thumbnail",$prod_name="",$cache_dir)
{
		if($size=="" && $type=="photos")
		{
			$size ='100';
			$max = '100';
		}
		else
		{	$max= $size;}
		
		$link = "../images/users_articole/".$imagefile['name'];
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
			$file_name = "../images/smallimages/articole/".$cache_dir."/".$imagefile['name'];
			$jpg_array = array('jpeg','jpg','JPG','JPEG','x-jpg','pjpeg','pipeg','vnd.swiftview-jpeg','x-xbitmap');
			if (in_array($file_ext,$jpg_array)) 
			{$big = imagecreatefromjpeg($link);}
			if (strtolower($file_ext)=="png"){$big = imagecreatefrompng($link);}
			if (strtolower($file_ext)=="gif"){$big = imagecreatefromgif($link);}
			if (!$big)
			{		$_SESSION['image_error'][]="Error when creating the new image from <b>".$imagefile['name']."</b>";		}
			if (!isset($_SESSION['image_error']))
			{
				$img_resample = imagecopyresampled($thumb, $big, 0, 0, 0, 0, $newwidth, $newheight, $image_width, $image_height);
				if (!$img_resample)
				{
					$_SESSION['image_error'][]="Error when resizing the image <b>".$val['image_name']."</b>";
				}
				$image_quality = 90;
				$jpg_array = array('jpeg','jpg','JPG','JPEG','x-jpg','pjpeg','pipeg','vnd.swiftview-jpeg','x-xbitmap');

				if (in_array($file_ext,$jpg_array))
					{ imagejpeg($thumb, $file_name, $image_quality);}
				if (strtolower($file_ext)=="png")
					{imagepng($thumb, $file_name, $image_quality);}
				if (strtolower($file_ext)=="gif")
					{imagegif($thumb, $file_name, $image_quality);}

				imagedestroy($thumb);
				imagedestroy($big);
			}
			unset($_SESSION['image_error']);
		
}

?>