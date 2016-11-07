<?php
#used in front end
function GetAnuntIdByAlias($alias)
{
	
	global $db;
	$query = "SELECT id FROM anunturi
						WHERE alias = '".trim($alias)."'";

	$db->query($query);
	$db->next_record();
	return $db->f('id');

}
#used in front end
function GetAliasModuleAnunturi($link)
{
	global $db;
	$query = "SELECT alias FROM modules
						WHERE link = '".trim($link)."'";

	$db->query($query);
	$db->next_record();
	return $db->f('alias');

}

function GetAnunturiCategoryInfos ($id)
{
	global $db;
	if(isset($id)&&($id!=""))
	{
		$query = "SELECT * FROM anunturi_categories
								WHERE id_cat = '".$id."'";
		$db->query($query);
		$db->next_record();
		
		$infos = array();
			$infos['id']=$db->f('id_cat');
			$infos['name']=$db->f('cat_name');
			$infos['alias']=$db->f('alias');
			$infos['meta_keywords']=$db->f('meta_keywords');
			$infos['meta_description']=$db->f('meta_description');
		return $infos;
			
	}

}
function UpdateAnunturiViews($id) 
 { 
      global $db; 
      if(!isset($_COOKIE['anunturi_visits_'.$id])) 
      { 
           ## set the cookie for 5min...in time we will make it from config 
           setcookie('anunturi_visits_'.$id,$id,time()+300,"/",".dentistonline.ro",0); 
           $sql = "UPDATE anunturi SET nr_visits=nr_visits+1 WHERE id='".$id."'"; 
           $db->query($sql); 
      } 
 } 

 /*
- Function used in : sources / cabinete.php
*/
function GetPreviousOrNextAnunturi ($id)
{
	global $db;
	$this_cabinete = array();
	$query = "SELECT submision_date, parent_module
						FROM cabinete
						WHERE id = '".$id."'
						AND parent_module <> '0'";
	$db->query($query);
	#if cabinet is child of module
	if ($db->num_rows() != 0)
	{
		$db->next_record();
		$parent = $db->f("parent_module");
		$submision_date = $db->f("submision_date");
		#select previous if exists - cabinet is newer than current
		$query = "SELECT id FROM cabinete
							WHERE parent_module = '".$parent."'
							AND submision_date > '".$submision_date."'
							ORDER by submision_date ASC
							LIMIT 1";
		$db->query($query);
		if ($db->num_rows() != 0)
		{
			$db->next_record();
			$this_cabinete["previous"] = $db->f("id");
		}
		#select next if exists - cabinet is older than current
		$query = "SELECT id FROM cabinete
							WHERE parent_module = '".$parent."'
							AND submision_date < '".$submision_date."'
							ORDER by submision_date DESC
							LIMIT 1";
		$db->query($query);
		if ($db->num_rows() != 0)
		{
			$db->next_record();
			$this_cabinete["next"] = $db->f("id");
		}
	}
	#the cabinet is a category's child
	else 
	{
		#get parents category id
		$query = "SELECT cat_id FROM cabinete_cat
							WHERE cabinet_id = '".$id."'";
		$db->query($query);
		$db->next_record();
		$category_id = $db->f('cat_id');
		#get cabinete submision date
		$query = "SELECT submision_date FROM cabinete WHERE id = '".$id."'";
		$db->query($query);
		$db->next_record();
		$submision_date = $db->f('submision_date');
		#Select previous if exists
		$query = "SELECT A.*, B.*
							FROM cabinete_cat as A, cabinete as B
							WHERE A.cat_id = '".$category_id."'
							AND A.cabinet_id = B.id
							AND B.submision_date > '".$submision_date."'
							ORDER by B.submision_date ASC
							LIMIT 1";
		$db->query($query);
		if ($db->num_rows() != 0)
		{
			$db->next_record();
			$this_cabinete["previous"] = $db->f("id");
		}
		#select next if exists - cabinet is older than current
		$query = "SELECT A.*, B.*
							FROM cabinete_cat as A, cabinete as B
							WHERE A.cat_id = '".$category_id."'
							AND A.cabinet_id = B.id
							AND B.submision_date < '".$submision_date."'
							ORDER by B.submision_date DESC
							LIMIT 1";
		$db->query($query);
		if ($db->num_rows() != 0)
		{
			$db->next_record();
			$this_cabinete["next"] = $db->f("id");
		}
	}
	return $this_cabinete;
}
#used in front end
function CountAnunturi($cat,$status)
{
	global $db;
	$stat ="";
	switch ($cat)
	{
		#for the admin edit
		default:
			if($status!="all")
			{
				$stat ="and status='".$status."'";
			}
			$query = "SELECT count(id) as nr_anunturi FROM anunturi WHERE bigcat_id = '".$cat."'".$stat;
		break;
	
		#all for admin
		case 'all':
			if($status!="all")
			{
				$stat ="WHERE status='".$status."'";
			}

			$query = "SELECT count(id) as nr_anunturi FROM anunturi ".$stat." ORDER by data_adaugarii DESC";
		break;
	}
	$db->query($query);
	$db->next_record();
	return $db->f('nr_anunturi');
}

function GetAnunturiCategories ($active, $article_id)
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
		$query = "SELECT bigcat_id FROM anunturi WHERE id = '".$article_id."'";
	}
	else 
	{
		$query = "SELECT * FROM anunturi_categories	 ".$status."order by cat_name asc";
	}
	$db->query($query);
	$i = 0;
	while ($db->next_record())
	{
		$cats[$i]['id'] = $db->f('id_cat');
		$cats[$i]['name'] = $db->f('cat_name');
		$cats[$i]['active'] = $db->f('active');
		$cats[$i]['alias'] = $db->f('alias');
		
		$i++;
	}
	return $cats;
}
function RemoveAHref($continut)
{
	#lets remove link form content:D
	$content = $continut;
	$regex_pattern = "/<a(.*)>(.*)<\/a>/";
	preg_match_all($regex_pattern,$content,$matches);
	if (count($matches)>0) 
	{
		$content = str_replace("</a>"," ", $content);
		foreach ($matches[1] as $key=>$value) 
		{
			$content = str_replace($value," ", $content);
		}
		$content = str_replace("<a  >"," ", $content);
	}
	return $content;
}

#used in front end
function CountAnunturiTotalRecords ($parent, $parent_id,$modul_id)
{
	global $db;
	switch ($parent)
	{
		case 'category':
			$query = "SELECT id 
								FROM anunturi
								WHERE judet = '".$parent_id."' and bigcat_id='".$modul_id."' and status='1'";
		break;

		case 'module':
			$query = "SELECT id FROM anunturi
											WHERE bigcat_id = '".$parent_id."' and status='1'";
		break;

		case '-1':
			$query = "SELECT id FROM anunturi";
		break;
	}
	
	$db->query($query);
	return $db->num_rows();
}

#used in front end
function GetAnunturiGeneral($cat_id,$limit)
{
		global $db;$info=array();$i=0;
		switch($cat_id)
		{
			default:
				$query =  "SELECT * from anunturi where status='1' and bigcat_id='".$cat_id."' order by data_adaugarii DESC".$limit;
			break;
			
			case 'all':
				$query = "SELECT * FROM anunturi WHERE status='1' order by data_adaugarii DESC ".$limit;
			break;
		}

		$db->query($query);
		while($db->next_record())
		{
			$info[$i]['id'] = $db->f('id');
			$info[$i]['category_id'] = $db->f('bigcat_id');
			$info[$i]['titlu'] = $db->f('titlu');
			$info[$i]['status'] = $db->f('status');
			$info[$i]['continut'] = strip_tags($db->f('continut'));
			$info[$i]['email'] = $db->f('email');
			$info[$i]['autor'] = $db->f('autor');
			$info[$i]['imagine'] = $db->f('imagine');
			$info[$i]['meta_keywords'] = $db->f('meta_keywords');
			$info[$i]['meta_description'] = $db->f('meta_description');
			$info[$i]['judet'] = $db->f('judet');
			$info[$i]['localitate'] = $db->f('localitate');
			$info[$i]['data_adaugarii'] = TimeFormatShort($db->f('data_adaugarii'));
			$info[$i]['data_expirarii'] = TimeFormatShort($db->f('data_expirarii'));
			$info[$i]['nr_visits'] =$db->f('nr_visits');
			$i++;
		}
		return $info;
		
}

#used in front end
function GetAnunturiMainPage($cat_id,$limit)
{
		global $db;$info=array();$i=0;
		switch($cat_id)
		{
			default:
				$query =  "SELECT * from anunturi where status='1' and bigcat_id='".$cat_id."'  order by data_adaugarii DESC".$limit;
			break;
			
			case 'all':
				$query = "SELECT * FROM anunturi WHERE status='1' and imagine!='default.jpg' order by data_adaugarii DESC ".$limit;
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
			$info[$i]['imagine'] = $db->f('imagine');
			$info[$i]['meta_keywords'] = $db->f('meta_keywords');
			$info[$i]['meta_description'] = $db->f('meta_description');
			$info[$i]['judet'] = $db->f('judet');
			$info[$i]['localitate'] = $db->f('localitate');
			$info[$i]['data_adaugarii'] = TimeFormatShort($db->f('data_adaugarii'));
			$info[$i]['data_expirarii'] = TimeFormatShort($db->f('data_expirarii'));
			$i++;
		}
		return $info;
		
}

#used in front end to parse the anunturi from witch they pay
function GetAnunturiMainPagePaid($cat_id,$limit)
{
		global $db;$info=array();$i=0;
		switch($cat_id)
		{
			default:
				$query =  "SELECT * from anunturi where status='1' and bigcat_id='".$cat_id."'  order by data_adaugarii DESC".$limit;
			break;
			
			case 'all':
				$query = "SELECT t1.*,t2.user_id,t2.level,t2.status FROM anunturi as t1,cabinete as t2 WHERE t1.user_id=t2.user_id and t2.level>'1' and t2.level <> '22' and t1.show_first_page='1' and t1.status='1' and t1.imagine!='default.jpg' and YEAR(t1.data_adaugarii)>'2013' order by rand() ".$limit;
			break;
		}

		$db->query($query);
		while($db->next_record())
		{
			$info[$i]['id'] = $db->f('id');
			$info[$i]['user_id'] = $db->f('user_id');
			$info[$i]['data_modificarii'] = $db->f('data_modificarii');
			$info[$i]['category_id'] = $db->f('bigcat_id');
			$info[$i]['nr_visits'] = $db->f('nr_visits');
			$info[$i]['comments'] = $db->f('comments');
			$info[$i]['titlu'] = $db->f('titlu');
			$info[$i]['status'] = $db->f('status');
			$info[$i]['continut'] = $db->f('continut');
			$info[$i]['email'] = $db->f('email');
			$info[$i]['autor'] = $db->f('autor');
			$info[$i]['imagine'] = $db->f('imagine');
			$info[$i]['show_first_page'] = $db->f('show_first_page');
			$info[$i]['meta_keywords'] = $db->f('meta_keywords');
			$info[$i]['meta_description'] = $db->f('meta_description');
			$info[$i]['judet'] = $db->f('judet');
			$info[$i]['localitate'] = $db->f('localitate');
			$info[$i]['data_adaugarii'] = TimeFormatShort($db->f('data_adaugarii'));
			$info[$i]['data_expirarii'] = TimeFormatShort($db->f('data_expirarii'));
			$i++;
		}
		return $info;
		
}
#used in front end
function GetAnunturiFrontend($bigcat,$judet,$limit)
{
	global $db;
	$info=array();$i=0;
	global $db;
	if(substr($judet,0,6)=='pagina')
	{	$judet="";	}

	if ($bigcat != '' && $judet == '')
	{
			$query = "SELECT * FROM anunturi
											WHERE bigcat_id = '".$bigcat."' and status='1' ORDER by data_adaugarii DESC".$limit;
	}
	else
	{
		$query = "SELECT * 
								FROM anunturi
								WHERE judet = '".$judet."' and bigcat_id='".$bigcat."' and status='1' ORDER by data_adaugarii DESC".$limit;
		
	}
		$db->query($query);
		while($db->next_record())
		{
			$info[$i]['id'] = $db->f('id');
			$info[$i]['category_id'] = $db->f('bigcat_id');
			$info[$i]['titlu'] = $db->f('titlu');
			$info[$i]['status'] = $db->f('status');
			$info[$i]['continut'] = strip_tags($db->f('continut'));
			$info[$i]['email'] = $db->f('email');
			$info[$i]['autor'] = $db->f('autor');
			$info[$i]['imagine'] = $db->f('imagine');
			$info[$i]['meta_keywords'] = $db->f('meta_keywords');
			$info[$i]['meta_description'] = $db->f('meta_description');
			$info[$i]['judet'] = $db->f('judet');
			$info[$i]['localitate'] = $db->f('localitate');
			$info[$i]['data_adaugarii'] = TimeFormatShort($db->f('data_adaugarii'));
			$info[$i]['data_expirarii'] = TimeFormatShort($db->f('data_expirarii'));
			$i++;
		}
		return $info;
		
}
function  GetJudetById($id)
{
	global $db;
	$query = "SELECT code FROM judete WHERE id = '".$id."' ";
	$db->query($query);
	$db->next_record();
	return $db->f('code');
}
function GetJudetCodeByName($judet)
{
	global $db;
	$query = "SELECT code FROM judete WHERE lower(name) = '".strtolower($judet)."' ";
	$db->query($query);
	$db->next_record();
	return $db->f('code');
}
function GetJudetName($judet_code)
{
	global $db;
	$query = "SELECT name FROM judete WHERE lower(code) = '".strtolower(trim($judet_code))."'";
	$db->query($query);
	$db->next_record();
	return $db->f('name');
}
function GetJudetIdByName($judet_name)
{
	global $db;
	$query = "SELECT id FROM judete WHERE lower(name) = '".strtolower($judet_name)."' ";
	$db->query($query);
	$db->next_record();
	return $db->f('id');
}


function GetAnuntIdByName($titluanunt)
{
	global $db;
	$query = "SELECT id FROM anunturi WHERE lower(titlu) = '".trim(strtolower($titluanunt))."' ";
	$db->query($query);
	$db->next_record();
	return $db->f('id');
}
#used in front end
function GetAnunturi($user_id,$id_anunt=-1)
{
		global $db;$info=array();$i=0;
		switch($id_anunt)
		{
			default:
			if ($user_id='-1' )
			{
				$query = "SELECT * FROM anunturi WHERE id='".$id_anunt."' order by data_adaugarii DESC";
			}
			else 
			{
				$query = "SELECT * FROM anunturi WHERE user_id= '".$user_id."' and id='".$id_anunt."' order by data_adaugarii DESC";
			}
			
			
				
			break;
			
			case '-1':
				$query = "SELECT * FROM anunturi WHERE user_id= '".$user_id."' order by data_adaugarii DESC";
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
			$info[$i]['alias'] = $db->f('alias');
			$info[$i]['imagine'] = $db->f('imagine');
			$info[$i]['comments'] = $db->f('comments');
			$info[$i]['judet'] = $db->f('judet');
			$info[$i]['meta_keywords'] = $db->f('meta_keywords');
			$info[$i]['meta_description'] = $db->f('meta_description');
			$info[$i]['localitate'] = $db->f('localitate');
			$info[$i]['data_adaugarii'] = TimeFormatShort($db->f('data_adaugarii'));
			$info[$i]['data_expirarii'] = TimeFormatShort($db->f('data_expirarii'));
			$info[$i]['data_modificarii'] = $db->f('data_modificarii');
			$info[$i]['nr_visits'] =$db->f('nr_visits');
			$i++;
		}
		return $info;
		
}
function GetAnuntInfo($cab_id)
{
	global $db;$info=array();
	$query = "SELECT titlu,bigcat_id,judet,alias FROM anunturi
								WHERE id = '".trim($cab_id)."'";

	$db->query($query);
	$db->next_record();
	$info['bigcat_id'] = $db->f('bigcat_id');
	$info['titlu'] = $db->f('titlu');
	$info['judet'] = $db->f('judet');
	$info['alias'] = $db->f('alias');
	return $info;
}

function GetAnuntCategoryName($judet_code)
{

global $db;
$query = "SELECT name FROM judete
								WHERE code = '".$judet_code."'";
$db->query($query);
$db->next_record();
return $db->f('name');

}

function CheckPictureItemAnunt ()
{
	global $conf;
	$allowed_types = array("image/pjpeg","image/jpeg","image/png","image/gif");
	$allowed_extension = array("jpg","jpeg","gif","png");
	
	$ext = explode(".",$_FILES['imagine']['name']);
	$extension = strtolower($ext[count($ext)-1]); // the real extension of the image !!!
	
	if(in_array($_FILES['imagine']['type'], $allowed_types) && ($_FILES['imagine']['name']!="") && in_array($extension, $allowed_extension))
	{
		/*check is the width is valid*/
		/*
		$image_sizes = GetImageSize($_FILES['imagine']['tmp_name']);
		$width = $image_sizes['0'];
		
		//if ($width > $conf->max_gallery_width)
		if ($width > $conf->max_img_anunt)
		{
			return '1';
		}
		*/
		return 'ok';

	}
	else 
	{
		/*not a valid file type*/
		return '0';
	}
}


########################################Anunturi functions###########################################
function InsertAnunt($user_id, $titlu, $continut, $category_id,$autor,$email,$judet,$localitate,$meta_keywords=1,$meta_description=1)
{
	global $db;
	global $conf;
	$alias = GenerateAlias($titlu);
	$exp_date = date("y-m-d", mktime(0, 0, 0, date("m")+6, date("d"), date("Y")));

	$query ="Insert into anunturi (user_id,titlu,continut,bigcat_id,data_adaugarii,data_expirarii,autor,email,judet,localitate,meta_keywords,meta_description,alias) values('".$user_id."','".mysql_real_escape_string(strip_tags($titlu,'<p><font><b><br><strong><i><u><font>'))."','".mysql_real_escape_string(strip_tags($continut,'<p><font><b><br><strong><i><u><font>'))."','".$category_id."',now(),'".$exp_date."','".mysql_real_escape_string(strip_tags($autor,'<p><font><b><br><strong><i><u><font>'))."','".mysql_real_escape_string(strip_tags($email,'<p><font><b><br><strong><i><u><font>'))."','".mysql_real_escape_string(strip_tags($judet,'<p><font><b><br><strong><i><u><font>'))."','".mysql_real_escape_string(strip_tags($localitate,'<p><font><b><br><strong><i><u><font>'))."','".mysql_real_escape_string(strip_tags($meta_keywords,'<p><font><b><br><strong><i><u><font>'))."','".mysql_real_escape_string(strip_tags($meta_description,'<p><font><b><br><strong><i><u><font>'))."','".$alias."')";
	$db->query($query);
	return $db->last_insert_id();
}
function UpdateAnunt($anunt_id, $titlu, $continut, $category_id,$autor,$email,$judet,$localitate,$meta_key=1,$meta_desc=1,$comment)
{
	global $db;
	global $conf;
	$query ="Update  anunturi set  titlu='".mysql_real_escape_string(strip_tags($titlu,'<p><font><b><br><strong><i><u><font>'))."',continut='".mysql_real_escape_string(strip_tags($continut,'<p><font><b><br><strong><i><u><font>'))."',bigcat_id='".$category_id."',data_modificarii=now(),autor='".mysql_real_escape_string(strip_tags($autor,'<p><font><b><br><strong><i><u><font>'))."',email='".mysql_real_escape_string(strip_tags($email,'<p><font><b><br><strong><i><u><font>'))."',judet='".mysql_real_escape_string(strip_tags($judet,'<p><font><b><br><strong><i><u><font>'))."',localitate='".mysql_real_escape_string(strip_tags($localitate,'<p><font><b><br><strong><i><u><font>'))."',meta_keywords='".mysql_real_escape_string(strip_tags($meta_key,'<p><font><b><br><strong><i><u><font>'))."',meta_description='".mysql_real_escape_string(strip_tags($meta_desc,'<p><font><b><br><strong><i><u><font>'))."',comments='".mysql_real_escape_string(strip_tags($comment,'<p><font><b><br><strong><i><u><font>'))."' WHERE id = '".$anunt_id."'";
	$db->query($query);
}
function SavePicturesAnunturi ($file_extension, $id,$front_back)
{
	global $conf;
	global $db;
	$uploaddir = '../images/users_anunturi/';	
	if ($file_extension!="default" )
	{
			#daca anuntul are imagine sa o stergem
			$sql = "SELECT * from anunturi where id='".$id."'";
			$db->query($sql);
			if($db->affected_rows()>0)
			{
				$db->next_record();
				$img_name = $db->f('imagine');
				if((strpos($img_name,"default")===false)&&($img_name!=""))
				{		unlink($uploaddir.$img_name);	}
			
			}
			/*check if photo name already exist*/
			$filename = $_FILES['imagine']['name'];
			$filename = GenerateImageNameAnunturi($filename);
			$uploadfile = $uploaddir.$filename;
			/*do query*/
			$query = "UPDATE anunturi SET done='N',imagine = '".$filename."' WHERE id = '".$id."'";
			$db->query($query);
			$foldername = '../images/users_anunturi/';
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
			$query = "UPDATE anunturi SET imagine = '".$filename."' WHERE id = '".$id."'";
			$db->query($query);
	}

	return $filename;
	
}
function Generate_Small_Images_Anunt($user_id,$id_anunt)
{
		$imagefile = array();
		$get_images = GetAnunturi($user_id,$id_anunt);
		$imagefile["name"] = $get_images[0]['imagine'];
		$type = explode(".",$imagefile["name"]);
		$imagefile["type"] = $type[count($type)-1];
		$cachedir ="";
		$a = Generate_Image_Anunturi("",$imagefile,$type="photos",$imagefile["name"],$cachedir);
		return 1;
}
function Generate_Image_Anunturi($size="",$imagefile="",$type="thumbnail",$prod_name="",$cache_dir)
{
		if($size=="" && $type=="photos")
		{
			$size ='100';
			$max = '100';
		}
		else
		{	$max= $size;}
		
		$link = "../images/users_anunturi/".$imagefile['name'];
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
			$file_name = "../images/smallimages/anunturi/".$imagefile['name'];
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
function GenerateImageNameAnunturi($nume_imagine)
{
	global $db;
	$nume_imagine = ereg_replace("[^a-zA-Z0-9_.:/\-]", "", $nume_imagine);
	$query = "SELECT id FROM anunturi
						WHERE imagine = '".addslashes($nume_imagine)."'";
	$db->query($query);
	
	if($db->affected_rows()>0)
	{
		$nume_imagine = mt_rand(3,20).$nume_imagine;
	}

		return $nume_imagine;
}

?>