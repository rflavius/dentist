<?php
function getCabinetServiciiFile ($cab_id)
{
	global $db;
	$sql = "SELECT * FROM servicii_file WHERE cabinet_id='$cab_id'";
	$db->query($sql);
	if ($db->num_rows()>0 )
	{
		$db->next_record();
		$info['id'] = $db->f('id');
		$info['name'] = $db->f('name');
		$info['cabinet_id'] = $db->f('cabinet_id');
		$info['date'] = $db->f('date');
		return $info;
	}
	else 
	{
		return "";
	}
}
function getCabinetVideoFile ($cab_id)
{
	global $db;$i=0;
	$sql = "SELECT * FROM video WHERE `cabinet_id`='$cab_id'";
	$db->query($sql);
	if ($db->num_rows()>0 )
	{
		while($db->next_record())
		{
			$info[$i]['id'] = $db->f('id');
			$info[$i]['type'] = $db->f('type');
			$info[$i]['cabinet_id'] = $db->f('cabinet_id');
			$info[$i]['date'] = $db->f('date');
			$info[$i]['youtube_url'] = $db->f('youtube_url');
			$i++;
		}
		return $info;
	}
	else 
	{
		return '';
	}
}

function CheckCabinetStatus($user_id)
{

	global $db;
	$query = "SELECT id,status FROM cabinete
									WHERE user_id = '".$user_id."' AND status='1'";
	$db->query($query);
	if ($db->num_rows() != 0)
	{	return 1;}
	else
		{return 0;	}
}
function GetCabinetIdByAlias($alias)
{
	global $db;
	$query = "SELECT id FROM cabinete
						WHERE alias = '".trim($alias)."'";

	$db->query($query);
	$db->next_record();
	return $db->f('id');

}
function GetAllArticlesForUser($user_id,$status=false)
{
	global $db; $i=0;
	$infos = array();
	$sql_expand = "";
	if($status!='false')
	{
		$sql_expand = " And status='1'";
	}
	if($user_id!="-1")
	{
		$sql = "Select * from articles where user_id='".$user_id."'".$sql_expand." order by data_adaugarii  DESC Limit 10";
		$db->query($sql);
			if($db->num_rows()>0)
			{
				while($db->next_record())
				{
					$infos[$i]['id'] = $db->f('id');
					$infos[$i]['titlu'] = $db->f('titlu');
					$infos[$i]['alias'] = $db->f('alias');
					$infos[$i]['bigcat_id'] = $db->f('bigcat_id');
					$infos[$i]['short_description'] = substr(strip_tags($db->f('continut')), '0', '250');
					$i++;
				}
				return $infos;
			}
			else
			{
				return 0;
			}
	}
	else
	{
		return 0;
	}
	
}

function GetAllAnunturiForUser($user_id,$status=false)
{
	global $db; $i=0;
	$infos = array();
	$sql_expand = "";
	if($status!='false')
	{
		$sql_expand = " And status='1'";
	}
	if($user_id!="-1")
	{
		$sql = "Select * from anunturi where user_id='".$user_id."'".$sql_expand." order by data_adaugarii  DESC ";
		$db->query($sql);
			if($db->num_rows()>0)
			{
				while($db->next_record())
				{
					$infos[$i]['id'] = $db->f('id');
					$infos[$i]['titlu'] = $db->f('titlu');
					$infos[$i]['alias'] = $db->f('alias');
					$infos[$i]['bigcat_id'] = $db->f('bigcat_id');
					$infos[$i]['judet'] = $db->f('judet');
					$infos[$i]['short_description'] = substr(strip_tags($db->f('continut')), 0, 250);
					$i++;
				}
				return $infos;
			}
			else
			{
				return 0;
			}
	}
	else
	{
		return 0;
	}
	
}


function SavePicturesCabinete ($id,$front_back)
{
	global $conf;	global $db;
	$uploaddir = '../images/users_cabinete/'.$id.'/';	
	if(is_dir($uploaddir))
	{
		chmod($uploaddir,0777);
	}
	else
	{
		mkdir($uploaddir, 0777);
		chmod($uploaddir, 0777);
	}

		#lets check if we have some other pictures add
		$query ="SELECT * FROM images
				WHERE folder_id = '".$id."' 
				ORDER BY position DESC limit 1";
		$db->query($query);
		if($db->affected_rows()>0)
		{
			$db->next_record();
			$last_pos = $db->f('position');
		}
		else
		{
			$last_pos = 0;
		}
		
		if(count($_FILES)>0)
		{
			$foldername = '../images/users_cabinete/'.$id.'/';
			for($i = 1; $i <=count($_FILES) ; $i++)
			{
					$extension = explode('/',$_FILES['picture_'.$i]['type']);
					if(isset($extension[1]))
					{
						$filename = $_FILES['picture_'.$i]['name'];
						$filename = GenerateImageNameCabinete($filename);
						$uploadfile = $uploaddir.$filename;
						
						$last_pos = $last_pos + 1;
						$sql = "INSERT INTO images(`image_name`, `folder_id`, `type`,`position`) VALUES ('".$filename."','".$id."','cabinet','".$last_pos."')";
						$db->query($sql);

						#lets insert to resize table images
						$sql2 = "INSERT INTO resize_img_cron(`id`, `image_name`, `item_id`, `size`, `status`, `date`,`folder_name`) VALUES ('','".$filename."','".$id."','".$_FILES['picture_'.$i]['size']."','N','','".addslashes($foldername)."')";
						$db->query($sql2);
		
						if (!move_uploaded_file($_FILES['picture_'.$i]['tmp_name'], $uploadfile))
						{
							$notice_message=$_FILES['picture_'.$i]['name']." : Failed to save file<br>";
						}
						chmod($uploaddir,0777);
					}
					
			}
		}
}

function GenerateSmallImages($cabinet_id)
{
		$get_images = GetCabineteImages($cabinet_id);
		$imagefile = array();
		foreach ($get_images as $key =>$val)
		{
			$imagefile["name"] = $val['image_name'];
			$imagefile["item_id"] = $val['id'];
			$imagefile["folder_id"] = $val['folder_id'];
			$type = explode(".",$imagefile["name"]);
			$imagefile["type"] = $type[count($type)-1];
			$cachedir = $imagefile["folder_id"];
			$a = Generate_Image_Cabinete("",$imagefile,$type="photos",$imagefile["name"],$cachedir);
		}
		return 1;
}
function Generate_Image_Cabinete($size="",$imagefile="",$type="thumbnail",$prod_name="",$cache_dir)
{
		if($size=="" && $type=="photos")
		{
			$size ='100';
			$max = '100';
		}
		else
		{	$max= $size;}
		
		$link = "../images/users_cabinete/".$cache_dir."/".$imagefile['name'];
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
			$file_name = "../images/smallimages/cabinete/".$imagefile['name'];
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
					{imagepng($thumb, $file_name, 9);}
				if (strtolower($file_ext)=="gif")
					{imagegif($thumb, $file_name, $image_quality);}

				imagedestroy($thumb);
				imagedestroy($big);
			}
			unset($_SESSION['image_error']);
		
}
function GetCabInfo($cab_id)
{
	global $db;$info=array();
	$query = "SELECT category_id,nume_firma,judet,alias FROM cabinete
								WHERE id = '".trim($cab_id)."'";

	$db->query($query);
	$db->next_record();
	$info['category_id'] = $db->f('category_id');
	$info['nume_firma'] = $db->f('nume_firma');
	$info['judet'] = $db->f('judet');
	$info['alias'] = $db->f('alias');
	return $info;
}
function GetCabinete ($module, $category,$limit,$recomandat)
{
	global $db;
	global $conf;$cabinet=array();
	if(substr($category,0,6)=='pagina')
	{	$category="";	}

	if ($module != '' && $category == '')
	{
		$query = "SELECT  a.id as id_cab,a.nume_firma,a.descriere,a.judet,a.submision_date,a.level,b.image_name
							FROM cabinete as a, images as b 
							WHERE a.category_id = '".$module."' and a.status='1' and a.id=b.folder_id and b.position='1'
							ORDER by submision_date DESC".$limit;
		$db->query($query);
		$i = 1;
		$cabinet = array();
		while ($db->next_record())
		{
			$cabinet[$i]['id'] = $db->f('id_cab');
			$cabinet[$i]['nume_firma'] = $db->f('nume_firma');
			$cabinet[$i]['descriere'] = strip_tags($db->f('descriere'));
			$cabinet[$i]['judet'] = $db->f('judet');
			$cabinet[$i]['level'] = $db->f('level');
			$cabinet[$i]['image_name'] = $db->f('image_name');
			$cabinet[$i]['submision_date'] = TimeFormatShort($db->f('submision_date'));
			$i++;
		}
		
	}
	else
	{//echo $recomandat."<BR>";
		$query = "SELECT A.id as id_cab,A.nume_firma,A.descriere,A.judet,A.submision_date,A.level, B.*, C.image_name 
							FROM cabinete A, cabinete_cat B, images C
							WHERE B.cat_id = '".$category."' 
							AND A.id = B.cabinet_id AND  A.status = '1' AND A.id=C.folder_id AND C.position='1'
							AND A.level LIKE '%23%'".$recomandat."
							ORDER by A.level DESC ".$limit;
		//echo $query;
		$db->query($query);
		if($db->num_rows()>0)
		{
			$i = 0;
			$cabinet = array();$id_cabinete_abonament="(";
			while ($db->next_record())
			{
				$cabinet[$i]['id'] = $db->f('id_cab');
				$id_cabinete_abonament = $id_cabinete_abonament."'".$db->f('id_cab')."',";
				$cabinet[$i]['nume_firma'] = $db->f('nume_firma');
				$cabinet[$i]['descriere'] = strip_tags($db->f('descriere'));
				$cabinet[$i]['judet'] = $db->f('judet');
				$cabinet[$i]['level'] = $db->f('level');
				$cabinet[$i]['image_name'] = $db->f('image_name');
				$cabinet[$i]['submision_date'] = TimeFormatShort($db->f('submision_date'));
				$i++;
			}
			$id_cabinete_abonament = $id_cabinete_abonament."' ')";
			//print_r($cabinet);exit;
			### if we do not have enough results
			$the_limit = 12;
			if($i<12)
			{
				$query = "SELECT A.id as id_cab,A.nume_firma,A.descriere,A.judet,A.submision_date,A.level, B.*, C.image_name 
									FROM cabinete A, cabinete_cat B, images C
									WHERE B.cat_id = '".$category."' 
									AND A.status = '1' AND A.id=C.folder_id AND C.position='1'  AND A.id NOT IN ".$id_cabinete_abonament."
									AND A.id = B.cabinet_id ".$recomandat."
									ORDER by A.submision_date DESC ".$limit;
				$db->query($query);
				if($db->num_rows()>0)
				{
					$i = count($cabinet);
					while ($db->next_record())
					{
						$cabinet[$i]['id'] = $db->f('id_cab');
						$cabinet[$i]['nume_firma'] = $db->f('nume_firma');
						$cabinet[$i]['descriere'] = strip_tags($db->f('descriere'));
						$cabinet[$i]['judet'] = $db->f('judet');
						$cabinet[$i]['level'] = $db->f('level');
						$cabinet[$i]['image_name'] = $db->f('image_name');
						$cabinet[$i]['submision_date'] = TimeFormatShort($db->f('submision_date'));
						$i++;
					}
				//print_r($cabinet);
				}

			}
		}
		else
		{
			$query = "SELECT A.id as id_cab,A.nume_firma,A.descriere,A.judet,A.submision_date,A.level, B.*, C.image_name 
								FROM cabinete A, cabinete_cat B, images C
								WHERE B.cat_id = '".$category."' 
								AND A.status = '1' AND A.id=C.folder_id AND C.position='1'
								AND A.id = B.cabinet_id ".$recomandat."
								ORDER by A.submision_date DESC ".$limit;
			$db->query($query);
			if($db->num_rows()>0)
			{
				$i = 1;
				while ($db->next_record())
				{
					$cabinet[$i]['id'] = $db->f('id_cab');
					$cabinet[$i]['nume_firma'] = $db->f('nume_firma');
					$cabinet[$i]['descriere'] = strip_tags($db->f('descriere'));
					$cabinet[$i]['judet'] = $db->f('judet');
					$cabinet[$i]['level'] = $db->f('level');
					$cabinet[$i]['image_name'] = $db->f('image_name');
					$cabinet[$i]['submision_date'] = TimeFormatShort($db->f('submision_date'));
					$i++;
				}
			}
		}
	}

	/*if($recomandat!="")
	{
			$judet_details = GetJudetCodeFromCategories($category);
			$judet_code = 	$judet_details['cat_code'];
			$query = "SELECT A.id as id_cab,A.nume_firma,A.descriere,A.judet,A.submision_date, B.firma_id, C.image_name
								FROM cabinete A, recomandate B, images C
								WHERE A.id = B.firma_id and B.date_exp > curdate() and B.judet_id = '".$judet_code."'
								AND A.status = '1' AND A.id=C.folder_id AND C.position='1'
								ORDER by B.position ASC".$limit;
		
	}*/
	return $cabinet;

}

function  GetJudetCodeFromCategories ($category)
{
	global $db;
	global $conf;
	$query = "SELECT * FROM  cabinete_categories where id_cat='".$category."'";
	$db->query($query);
	$db->next_record();
	$cabinet=array();

		$cabinet['cat_name'] = $db->f('cat_name');
		$cabinet['parent_module'] = $db->f('parent_module');
		$cabinet['cat_code'] = $db->f('cat_code');
		

	return $cabinet;
}


function GetLastOferte($limit)
{
	global $db;
	global $conf;
	$query = "SELECT * FROM cabinete
							WHERE status = '1' ORDER by submision_date DESC ".$limit;
	
	$db->query($query);
	$i = 1;
	$cabinet = array();
	while ($db->next_record())
	{
		$cabinet[$i]['id'] = $db->f('id');
		$cabinet[$i]['nume_firma'] = $db->f('nume_firma');
		$cabinet[$i]['descriere'] = $db->f('descriere');
		$cabinet[$i]['submision_date'] = TimeFormatShort($db->f('submision_date'));
		$i++;
	}
	return $cabinet;
}
#this is for magazin terapeutic
function GetCabineteWhithoutMagazinTerapeutic ($module, $category,$limit)
{
	global $db;
	global $conf;
	if(substr($category,0,6)=='pagina')
	{	$category="";	}

	if ($module != '' && $category == '')
	{
		$query = "SELECT * FROM cabinete
							WHERE status = '1' AND category_id = '".$module."' and id<>'144'
							ORDER by submision_date DESC".$limit;
	}
	else
	{
		$query = "SELECT A.*, B.* FROM cabinete A, cabinete_cat B
							WHERE B.cat_id = '".$category."'
							AND A.status = '1'
							AND  A.id<>'144'
							AND A.id = B.cabinet_id
							ORDER by A.submision_date DESC".$limit;
	}

	$db->query($query);
	$i = 1;
	$cabinet = array();
	while ($db->next_record())
	{
		$cabinet[$i]['id'] = $db->f('id');
		$cabinet[$i]['nume_firma'] = $db->f('nume_firma');
		$cabinet[$i]['descriere'] = $db->f('descriere');
		$cabinet[$i]['judet'] = $db->f('judet');
		$cabinet[$i]['submision_date'] = TimeFormatShort($db->f('submision_date'));
		$i++;
	}
	return $cabinet;
}
/*
- Function used in : sources / cabinete.php
-                  : admin / cabinete.php
-                  : admin / delete.php
*/
function GetSelectedCabinet ($id)
{
	global $db;
	$cabinet = array();
	$query = "SELECT * FROM cabinete WHERE id = '".$id."'";
	//echo $query;exit;
	$db->query($query);
	while($db->next_record())
	{
		$cabinet['category_id'] = $db->f('category_id');
		$cabinet['nume_firma'] = $db->f('nume_firma');
		$cabinet['descriere'] = $db->f('descriere');
		$cabinet['adresa_firma'] = $db->f('adresa_firma');
		$cabinet['date'] = $db->f('submision_date');
		$cabinet['idfirma'] = $db->f('id');
		$cabinet['email_firma'] = $db->f('email_firma');
		$cabinet['tarife']=$db->f('tarife');
		$cabinet['orar']=$db->f('orar');
		$cabinet['type']=$db->f('type');
		$cabinet['perioada']=$db->f('perioada');
		$cabinet['adresa_web']=$db->f('adresa_web');
		$cabinet['echipa_medicala']=$db->f('echipa_medicala');
		$cabinet['inreg_fiscala_cnp']=$db->f('inreg_fiscala_cnp');
		$cabinet['reg_comert_bi']=$db->f('reg_comert_bi');
		$cabinet['judet']=$db->f('judet');
		$cabinet['nume_loc_sector']=$db->f('nume_loc_sector');
		$cabinet['fax']=$db->f('fax');
		$cabinet['pers_contact']=$db->f('pers_contact');
		$cabinet['persc_email']=$db->f('persc_email');
		$cabinet['persc_tel']=$db->f('persc_tel');
		$cabinet['persc_adresa']=$db->f('persc_adresa');
		$cabinet['zip_code']=$db->f('zip_code');
		$cabinet['adresa_firma']=$db->f('adresa_firma');
		$cabinet['meta_keywords']=$db->f('meta_keywords');
		$cabinet['meta_description']=$db->f('meta_description');
		$cabinet['nr_visits']=$db->f('nr_visits');
		$cabinet['user_id']=$db->f('user_id');
		$cabinet['status']=$db->f('status');
		$cabinet['level']=$db->f('level');
		if ($db->f('parent_module') != '0')
		{
			$cabinet['module_parent'] = $db->f('parent_module');
		}
		else
		{
			$query = "SELECT cat_id FROM cabinete_cat WHERE cabinet_id = '".$id."'";
			$db->query($query);
			$db->next_record();
			$cabinet['category_parent'] = $db->f('cat_id');
		}
	}
	return $cabinet;
}
/*
- Function used in : admin / cabinete.php
-                  : sources / sitemap.php
-                  : classes / general_functions.inc.php
*/
function GetCabineteCategories ($id, $active, $cabinet_id)
{
	global $db;
	$cats = array();
	switch ($active)
	{
		default :
			$status = " AND active = '".$active."' Order by cat_name ASC";
		break;

		case '-1':
			$status = "Order by cat_name ASC";
		break;
	}
	if ($cabinet_id != "")
	{
		#select the parent_module
		$query = "SELECT parent_module FROM cabinete WHERE id = '".$cabinet_id."'";
		$db->query($query);
		$db->next_record();
		if ($db->f('parent_module') != '0')
		{
			$query = "SELECT * FROM cabinete_categories
								WHERE parent_module = '".$db->f('parent_module')."'".$status;
		}
		else 
		{
			$query = "SELECT cat_id FROM cabinete_cat WHERE cabinet_id = '".$cabinet_id."'";
			$db->query($query);
			$db->next_record();
			$query = "SELECT parent_module FROM cabinete_categories
								WHERE id_cat = '".$db->f('cat_id')."'";
			$db->query($query);
			$db->next_record();
			$query = "SELECT * FROM cabinete_categories
								WHERE parent_module = '".$db->f('parent_module')."'".$status;
		}
	}
	else 
	{
		$query = "SELECT * FROM cabinete_categories
						WHERE parent_module = '".$id."'".$status;
	}
	$db->query($query);
	$i = 0;
	
	while ($db->next_record())
	{
		$cats[$i]['id_cat'] = $db->f('id_cat');
		$cats[$i]['cat_name'] = $db->f('cat_name');
		$cats[$i]['active'] = $db->f('active');
		$cats[$i]['cat_code'] = $db->f('cat_code');
		$cats[$i]['ahref_title'] = $db->f('ahref_title');
		$cats[$i]['parent_module'] = $db->f('parent_module');
		$i++;
	}
	
	return $cats;
}

/*
- Function used in : sources / cabinete.php
*/
function GetPreviousOrNextCabinete ($id)
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
		$query = "SELECT id,nume_firma FROM cabinete
							WHERE parent_module = '".$parent."' and status='1'
							AND submision_date > '".$submision_date."'
							ORDER by submision_date ASC
							LIMIT 1";
		$db->query($query);
		if ($db->num_rows() != 0)
		{
			$db->next_record();
			$this_cabinete["previous"]['id'] = $db->f("id");
			$this_cabinete["previous"]['title'] = $db->f("nume_firma");
		}
		#select next if exists - cabinet is older than current
		$query = "SELECT id,nume_firma FROM cabinete
							WHERE parent_module = '".$parent."'  and status='1'
							AND submision_date < '".$submision_date."'
							ORDER by submision_date DESC
							LIMIT 1";
		$db->query($query);
		if ($db->num_rows() != 0)
		{
			$db->next_record();
			$this_cabinete["next"]['id'] = $db->f("id");
			$this_cabinete["next"]['title'] = $db->f("nume_firma");
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
							AND B.submision_date > '".$submision_date."'  and B.status='1'
							ORDER by B.submision_date ASC
							LIMIT 1";
		$db->query($query);
		if ($db->num_rows() != 0)
		{
			$db->next_record();
			$this_cabinete["previous"]['id'] = $db->f("id");
			$this_cabinete["previous"]['title'] = $db->f("nume_firma");
		}
		#select next if exists - cabinet is older than current
		$query = "SELECT A.*, B.*
							FROM cabinete_cat as A, cabinete as B
							WHERE A.cat_id = '".$category_id."'
							AND A.cabinet_id = B.id
							AND B.submision_date < '".$submision_date."' and B.status='1'
							ORDER by B.submision_date DESC
							LIMIT 1";
		$db->query($query);
		if ($db->num_rows() != 0)
		{
			$db->next_record();
			$this_cabinete["next"]['id'] = $db->f("id");
			$this_cabinete["next"]['title'] = $db->f("nume_firma");
		}
	}
	return $this_cabinete;
}
function GetRelatedCabinete ($id,$judet,$big_cat,$localitate)
{
	//echo $id." ".$judet." ".$big_cat." ".$localitate;
	global $db;$i=0;
	$this_cabinete = array();
	$query = "SELECT id,nume_firma,level
						FROM cabinete
						WHERE status='1' and judet='".$judet."' AND category_id='".$big_cat ."' AND 
						nume_loc_sector='".$localitate."' and id <> ".$id." and level<> 22 and level <> 1 LIMIT 6 ";
	$db->query($query);
	//echo $query;
	//echo $db->affected_rows();
	//exit;
	if($db->affected_rows()>0)
	{
		while($db->next_record())
		{
			$this_cabinete[$i]['id'] = $db->f("id");
			$this_cabinete[$i]['title'] = $db->f("nume_firma");
			$i++;
		}
	}

	if($db->affected_rows()<5)
	{
		$limit_cabs = 6 - count($db->affected_rows()+1);
		$query = "SELECT id,nume_firma,level
						FROM cabinete
						WHERE status='1' and judet='".$judet."' AND category_id='".$big_cat ."' AND 
						nume_loc_sector='".$localitate."' and id <> ".$id." and (level = 1 || level = 22   )order by rand() LIMIT ".$limit_cabs;
						$db->query($query);
		//echo $query;//exit;
		while($db->next_record())
		{
			$this_cabinete[$i]['id'] = $db->f("id");
			$this_cabinete[$i]['title'] = $db->f("nume_firma");
			$i++;
		}
	}
	
	//	print_r($this_cabinete);
	return $this_cabinete;
}
#frontend
function GetLocalitate($id_loc)
{
	global $db;
	$info = array();
	$query="Select * from localitati  where id='".$id_loc."'";
	$db->query($query);
	$db->next_record();
	$info['judet_code']=$db->f('judet_code');
	$info['name']=$db->f('name');
	return $info;
}
#frontend
function GetJudet($what,$value)
{
	global $db;
	$info = array();
	switch($what)
	{
		case 'code':
				$query="Select * from judete where code='".$value."'";
		break;
		case 'name':
				$query="Select * from judete where name='".$value."'";
		break;
		case 'id':
				$query="Select * from judete where id='".$value."'";
		break;
	}
	$db->query($query);
	$db->next_record();
	$info['judet_code']=$db->f('code');
	$info['name']=$db->f('name');
	$info['id']=$db->f('id');
	return $info;
}
#frontend too
 function Get_Dentist_Cats($id_cat=-1)
 {
	global $db;
	global $modules;
	$info = array();$i=0;
	if(!empty($id_cat) && is_numeric($id_cat))
	{
		switch ($id_cat )
		{
			default:
				$section = 'cabinete.'.$id_cat;
				$info[$i]['id'] = $modules->module[$section]['id'];
				$info[$i]['name'] = $modules->module[$section]['name']; 
			break;


			case '-1':
				$q="Select * from dentist_categories";
				$db->query($q);
				while($db->next_record())
				{
					$info[$i]['id'] = $db->f('id');
					$info[$i]['name'] = $db->f('name');
					$i++;
				}
			break;
		}
	}
	return $info;
 }

#frontend
function GetJudete()
 {
	global $db;
	$info = array();$i=0;
	$q="Select * from judete";
	$db->query($q);
	while($db->next_record())
	{
		$info[$i]['id'] = $db->f('id');
		$info[$i]['name'] = $db->f('name');
		$info[$i]['code'] = $db->f('code');
		$i++;
	}
	return $info;
 }

function GetLocalitati($cod_judet)
{
	global $db;
	$info = array();$i=0;
	$q="Select * from localitati where judet_code='".$cod_judet."'";
	$db->query($q);
	while($db->next_record())
	{
		$info[$i]['id'] = $db->f('id');
		$info[$i]['name'] = $db->f('name');
		$i++;
	}
	return $info;
}
#fronend
function GetAllCabinete()
{
	global $db;
	//$query = "SELECT * FROM cabinete Where status='1' and  order by rand() limit 10 ";
	$query = "SELECT Distinct a.*,b.folder_id,b.position,b.image_name,b.type FROM cabinete as a, images as b 
		Where a.status='1' and a.id=b.folder_id and b.type<>'harta' and b.position='1' and b.image_name!='default.jpg'
		Group by id
		order by rand() limit 8 ";

	$db->query($query);
	$i = 0; $cabinete = array();
	#lets make something that dentaltech to be on the first 12 on page
	while ($db->next_record())
	{
		$cabinete[$i]['id'] = $db->f('id');
		$cabinete[$i]['nume_firma'] = $db->f('nume_firma');
		$cabinete[$i]['descriere'] = strip_tags($db->f('descriere'));
		$cabinete[$i]['category_id'] = $db->f('category_id');
		$cabinete[$i]['judet'] = $db->f('judet');
		$cabinete[$i]['image_name'] = $db->f('image_name');
		$i++;
	}
		$rand_pos = rand(0,7);
		$cabinete[$rand_pos]['id'] = 122;
		$cabinete[$rand_pos]['nume_firma'] = "DentalTech";
		$cabinete[$rand_pos]['descriere'] = "Laborator dentar dotat modern la dispozitia cabinetelor din tara si strainatate prin curierat rapid.";
		$cabinete[$rand_pos]['category_id'] = "2";
		$cabinete[$rand_pos]['image_name'] = "molr.jpg";
		$cabinete[$rand_pos]['judet'] = "TM";

	return $cabinete;
}

#frontend
function UpdateCabinetViews($id) 
 { 
      global $db; 
      if(!isset($_COOKIE['cabinet_visits_'.$id])) 
      { 
           ## set the cookie for 5 mins...in time we will make it from config 
           setcookie('cabinet_visits_'.$id,$id,time()+300,"/",".dentistonline.ro",0); 
           $sql = "UPDATE cabinete SET nr_visits=nr_visits+1 WHERE id='".$id."'"; 
           $db->query($sql); 
      } 
 } 

function UpdateCabinetRecent($id) 
 { 
      global $db; 
			if(isset($id)&&($id!=''))
			{
				  $sql = "Insert into recent_visits (id_cabinet,date) values('".$id."',now())"; 
					$db->query($sql); 
				
			}
    

 } 
function GetCabineteMainPhoto($id,$type)
{
	global $db;
	$info = array();
	$sql = "SELECT * FROM images WHERE folder_id ='".$id."' AND status='Y' and type='".$type."' ORDER BY position ASC LIMIT 0,1";
	$db->query($sql);
	$db->next_record();
	$info['id'] = $db->f('id');
	$info['image_name'] = $db->f('image_name');
	$info['position'] = $db->f('position');
	$info['folder_id'] = $db->f('folder_id');
return $info;
}
function GetCabineteImages($cab_id)
{
	global $db;
	$info = array();
	$sql = "SELECT * FROM images WHERE folder_id='".$cab_id."' ORDER BY position ASC";
	$db->query($sql);
	if($db->num_rows()>0)
	{
		$i=0;
		while($db->next_record())
		{
			$info[$i]['id'] = $db->f('id');
			$info[$i]['image_name'] = $db->f('image_name');
			$info[$i]['status'] = $db->f('status');
			$info[$i]['position'] = $db->f('position');
			$info[$i]['type'] = $db->f('type');
			$info[$i]['folder_id'] = $db->f('folder_id');
			$i++;
		}
	}
	return $info;
}
function CheckPictureItemCabinet()
{
	global $conf;
	$allowed_types = array("image/pjpeg","image/jpeg","image/gif","image/png");
	$allowed_extension = array("jpg","jpeg","gif","png");
	for($i = 1; $i <=4 ; $i++)
	{
		$ext = explode(".",$_FILES['picture_'.$i]['name']);
		$extension = strtolower($ext[count($ext)-1]); // the real extension of the image !!!
		
		if(isset($_FILES['picture_'.$i])&&($_FILES['picture_'.$i]['name']!=""))
		{
				if(in_array($_FILES['picture_'.$i]['type'], $allowed_types)  && ($_FILES['picture_'.$i]['name']!="") && in_array($extension, $allowed_extension) )
				{
					/*$image_sizes = GetImageSize($_FILES['picture_'.$i]['tmp_name']);
					$width = $image_sizes['0'];
					if ($width > $conf->max_img_cabinete)
					{
						return "1";
						break;
					}*/

				}
				else 
				{
					return '0';
					break;
				}
		}
	
	}
}
function GetCabinetImage($id)
{
	global $db;
	$sql = "SELECT * FROM images WHERE id='".$id."'";
	$db->query($sql);
	$db->next_record();
	$info['id'] = $db->f('id');
	$info['image_name'] = $db->f('image_name');
	$info['status'] = $db->f('status');
	$info['position'] = $db->f('position');
	$info['folder_id'] = $db->f('folder_id');
return $info;
}

#reorder and rearenge images
function ReorderImages ($id, $order_type)
{
	global $db;
	$query="SELECT position FROM images WHERE `id`='".$id."'";
	$db->query($query);
	$db->next_record();
	$new_order = $db->f('position');
	if ($order_type == 'up')
	{
		$new_order += -15;
	}
	else 
	{
		$new_order += +15;
	}
	UpdateImagesOrder($id, $new_order);
}

function UpdateImagesOrder ($id, $order_value)
{
	global $db;
	$query="UPDATE images SET position = '".$order_value."'
					WHERE id='".$id."'";
	$db->query($query);
}

#it rearranges the order, after you do an reorder
function RearrangeImages ($parent_id)
{
	global $db;
	$query="SELECT id FROM images WHERE folder_id = '".$parent_id."'
																	ORDER BY position ASC";
	$db->query($query);
	$y = 0;
	$ids = array();
	while ($db->next_record())
	{
		$ids[$y] = $db->f('id');
		$y++;
	}
	$i = 20;
	foreach ($ids as $key => $val)
	{
		UpdateImagesOrder($val, $i);
		$i+=10;
	}
}

#-----------------------lets mofufy it to be more practical for us nd now is going very good---------------------
function ReorderImagesNew ($id, $order_type,$nr_imagini_cabinet)
{
	global $db;global $conf;
	$query="SELECT position FROM images WHERE `id`='".$id."'";
	$db->query($query);
	$db->next_record();
	$new_order = $db->f('position');
	$position = $db->f('position');

	$response=array();$response['special']='N';

	if ($order_type == 'up')
	{
		$new_order += -1;
	}
	else 
	{
		$new_order += +1;
	}

	if(($position =='1') and ($order_type=='up'))
	{
		$new_order = $nr_imagini_cabinet;
		$response['special']='Y';
	}
	elseif(($position == $nr_imagini_cabinet) and ($order_type=='down'))
	{
		$new_order = 1;
		$response['special']='Y';
	}

	$response['position'] = $new_order;
	UpdateImagesOrderNew($id, $new_order);
	return $response;

}

function UpdateImagesOrderNew ($id, $order_value)
{
	global $db;
	$query="UPDATE images SET position = '".$order_value."'
					WHERE id='".$id."'";
	$db->query($query);
}

#it rearranges the order, after you do an reorder
function RearrangeImagesNew ($parent_id,$id_image,$new_dates,$order_type)
{
	global $db; $new_order = $new_dates['position'];$ids=array();
	if($new_dates['special']=='Y')
	{
		$query="SELECT id FROM images 
				WHERE folder_id = '".$parent_id."' and id<>'".$id_image."' and type='cabinet'
				ORDER BY position ASC";
		$db->query($query);$y=0;
		while ($db->next_record())
		{
			$ids[$y] = $db->f('id');
			$y++;
		}
		if($order_type=='up')
		{
			foreach ($ids as $key => $val)
			{
				$query="UPDATE images SET position = position-1
						WHERE id='".$val."'";
				$db->query($query);
			}
		}
		else
		{
			foreach ($ids as $key => $val)
			{
				$query="UPDATE images SET position = position+1
						WHERE id='".$val."'";
				$db->query($query);
			}
		
		}
	}
	else
	{	#daca avem un caz simplu de schimbare de pozitie
		$query="SELECT id FROM images 
						WHERE folder_id = '".$parent_id."' and id<>'".$id_image."' and position='".$new_order."' and type='cabinet'
						ORDER BY position ASC";
		$db->query($query);
		$db->next_record();
		$id_image = $db->f('id');
		if($order_type == 'up' )
		{
			$query="UPDATE images SET position=position+1 
					WHERE  id ='".$id_image."'";
			$db->query($query);
		}
		else
		{
			$query="UPDATE images SET position=position-1 
					WHERE  id ='".$id_image."'";
			$db->query($query);
		}
	}
	return 1;
}

function ReorderImagesPositions($folder_id)
{
	global $db; $ids=array();
	if(isset($folder_id) && ($folder_id!=""))
	{
		
		$query="SELECT * FROM images 
					WHERE folder_id = '".$folder_id."' and type='cabinet'
					ORDER BY position ASC";
			$db->query($query);$y=0;
			if($db->affected_rows()>0)
			{
					while ($db->next_record())
				{
					$ids[$y] = $db->f('id');
					$y++;
				}

				$j=1;
				foreach ($ids as $key => $val)
				{
					$query="UPDATE images SET position = '".$j."'
							WHERE id='".$val."'";
					$db->query($query);
					$j = $j+1;
				}
			
			}
	}
	else
	{
		for ($i=1;$i<700;$i++)
		{
		
			$query="SELECT * FROM images 
					WHERE folder_id = '".$i."' and type='cabinet'
					ORDER BY position ASC";
			$db->query($query);$y=0;
			if($db->affected_rows()>0)
			{
					while ($db->next_record())
				{
					$ids[$y] = $db->f('id');
					$y++;
				}

				$j=1;
				foreach ($ids as $key => $val)
				{
					$query="UPDATE images SET position = '".$j."'
							WHERE id='".$val."'";
					$db->query($query);
					$j = $j+1;
				}
			
			}
		}
	}
}
#********************************************************
function GetFirstDistribuitor()
{
	global $db;$cabinet = array();
	$sql = "SELECT * FROM cabinete WHERE id='144'";
	$db->query($sql);
	$db->next_record();
	$cabinet['id'] = $db->f('id');
	$cabinet['nume_firma'] = $db->f('nume_firma');
	$cabinet['descriere'] = $db->f('descriere');
	$cabinet['judet'] = $db->f('judet');
	$cabinet['submision_date'] = TimeFormatShort($db->f('submision_date'));
return $cabinet;
	
}

#tag clouds
function GetUniqueASearchAppearance()
{
	global $db;
	$j=0;
	$fotos = array();
	$tags = "";
	$query = "SELECT search_word AS word, COUNT(id) AS quantity,judet
						FROM tagclouds_search
						GROUP BY search_word
						ORDER BY search_word ASC";
	$db->query($query);
	while($db->next_record())
		{
			$tags[$j]['judet']= $db->f('judet');
			$tags[$j]['word']= $db->f('word');
			$tags[$j]['appearance']= $db->f('quantity');
			$j++;
		}

	return $tags;
		
}
#front end
function InsertMesajeutilizator($id_cabinet,$subject,$email_content,$email_utilizator,$nume_utilizator,$user_id,$type,$telefon)
{
	#insert into cabinete table the title and content
	global $db;
	$query = "INSERT into mesaje_utilizator(id_cabinet,
																 subiect,
																 mesaj,
																 email_utilizator,
																 nume_utilizator,
																 submision_date,
																 type,
																 telefon,
																 user_id)
													VALUES('".$id_cabinet."',
																 '".addslashes($subject)."',
																 '".addslashes($email_content)."',
																 '".addslashes($email_utilizator)."',
																 '".addslashes($nume_utilizator)."',
																 now(),
																 '".$type."',
																	'".addslashes($telefon)."',
																 '".$user_id."')";
	$db->query($query);
	return 1;
}
#front end
function JudetIdFromCategories($judet_code,$parent)
{
	global $db;
	$info=array();
	$query = "SELECT id_cat,cat_name from cabinete_categories WHERE cat_code = '".$judet_code."' and parent_module =".$parent;
	$db->query($query);
	$db->next_record();
	$info['id'] = $db->f('id_cat');
	$info['name'] = $db->f('cat_name');

	return $info;
}
#frontend too
function CountCabineteTotalRecords ($parent, $parent_id, $admin_level=false)
{
	global $db;
	$extra_sql='';
	if($admin_level!==false)
	{
		if($parent=='-1')
		{
			$extra_sql = " WHERE `level`='1' ";
		}
		else
		{
			$extra_sql = " AND `level`='1' ";
		}
	}
	
	switch ($parent)
	{
		case 'category':
			$query = "SELECT A.id , B.*
								FROM cabinete A, cabinete_cat B
								WHERE B.cat_id = '".$parent_id."'
								AND A.id = B.cabinet_id".$extra_sql;
		break;

		case 'module':
			$query = "SELECT id FROM cabinete
			WHERE category_id = '".$parent_id."'".$extra_sql;
		break;

		case '-1':
			$query = "SELECT id FROM cabinete".$extra_sql;
		break;
	}
	$db->query($query);
	return $db->num_rows();
}

function CountCabineteTotalRecordsFront ($parent, $parent_id, $optional_cond = false)
{
	global $db;
	switch ($parent)
	{
		case 'category':
			$query = "SELECT A.id , B.*
								FROM cabinete A, cabinete_cat B
								WHERE B.cat_id = '".$parent_id."'
								AND A.id = B.cabinet_id and A.status='1'";
		break;

		case 'module':
			$query = "SELECT id FROM cabinete
			WHERE category_id = '".$parent_id."' and status='1'";
		break;

		case '-1':
			$query = "SELECT id FROM cabinete Where status='1'";
		break;
	}
	if($optional_cond!==false) $query.= " ".$optional_cond;
	$db->query($query);
	return $db->num_rows();
}
function CountCabineteTotalRecordsRecents()
{
	global $db;$i=1;$id_s=array();
	$q="Select distinct(id_cabinet)
			from recent_visits 
			order by date DESC ";
	$db->query($q);
	while($db->next_record())
	{
		$id_s[$i] = $db->f('id_cabinet');
		$i++;
	}
	return count($id_s);
	
}


function GetCabineteRecente($query_l)
{
	global $db;
	$i=1;
	$id_s=array();

	$q="Select distinct(id_cabinet)
			from recent_visits 
			ORDER BY id DESC ".$query_l;
	$db->query($q);
	while($db->next_record())
	{
		$id_s[$i] = $db->f('id_cabinet');
		$i++;
	}
	return($id_s);
	
}
function GenerateImageNameCabinete($nume_imagine)
{
	global $db;
	$nume_imagine = ereg_replace("[^a-zA-Z0-9_.:/\-]", "", $nume_imagine);
	$query = "SELECT id FROM images
						WHERE image_name = '".addslashes($nume_imagine)."'";
	$db->query($query);
	
	if($db->affected_rows()>0)
	{
		$nume_imagine = mt_rand(3,99).$nume_imagine;
	}

		return $nume_imagine;
}

function GetBanner($cab_id,$details=0)
{
	global $db;
	$i=1;
	$banner_name = "";
	$banner_details = array();

	$q = "SELECT * from banner WHERE cabinet_id='".$cab_id."'";
	$db->query($q);
	
	if($db->num_rows()>0)
	{
		$db->next_record();
		if($details=='Y')
			{
				$banner_details['id'] = $db->f('id');
				$banner_details['afisari_curente'] = $db->f('recomandam_banner');
				$banner_details['total_afisari'] = $db->f('total_afisari');
				$banner_details['name'] = $db->f('name');
				return $banner_details;
			}
			else
			{
				$banner_name = $db->f('name');
			}
	}
}

function generateThumb($image_location,$folder_id_what_to_resize,$what_to_resize,$width_asked,$height_asked,$crop_ratio)
{
if (!isset($image_location))
{
	header('HTTP/1.1 400 Bad Request');
	echo 'Error: no image was specified';
	exit();
}
//echo $image_location;
define('MEMORY_TO_ALLOCATE',	'100M');
define('DEFAULT_QUALITY',		90);
define('CURRENT_DIR',			'/home/dentisto/public_html');
#chech what we have to resize and creat thumbnail article,anunturi or cabinet
if($what_to_resize=='articole')
{
	define('CACHE_DIR_NAME',		'/images/smallimages/articole/'.$folder_id_what_to_resize.'/');
}
elseif($what_to_resize=='anunturi')
{
	define('CACHE_DIR_NAME',		'/images/smallimages/anunturi/');
}
elseif($what_to_resize=='cabinete')
{
	define('CACHE_DIR_NAME',		'/images/smallimages/cabinete/'.$folder_id_what_to_resize.'/');
}

define('CACHE_DIR',	CURRENT_DIR . CACHE_DIR_NAME);
define('DOCUMENT_ROOT',			$_SERVER['DOCUMENT_ROOT']);

//echo CURRENT_DIR;
// Images must be local files, so for convenience we strip the domain if it's there
$image= preg_replace('/^(s?f|ht)tps?:\/\/[^\/]+/i', '', (string) $image_location);

#chech what we have to resize and creat thumbnail article,anunturi or cabinet
if($what_to_resize=='articole')
{
	$file_name = str_replace("//images/users_articole/","",$image); 
}
elseif($what_to_resize=='anunturi')
{
	$file_name = str_replace("//images/users_anunturi/","",$image); 
	
}
elseif($what_to_resize=='cabinete')
{
	$file_name = str_replace("//images/users_cabinete/".$folder_id_what_to_resize."/","",$image); 
}


$img_type = explode(".", $image);
$image_type = $img_type[count($img_type)-1];

// For security, directories cannot contain ':', images cannot contain '..' or '<', and
// images must start with '/'
if ($image{0} != '/' || strpos(dirname($image), ':') || preg_match('/(\.\.|<|>)/', $image))
{
	header('HTTP/1.1 400 Bad Request');
	echo 'Error: malformed image path. Image paths must begin with \'/\'';
	exit();
}

// If the image doesn't exist, or we haven't been told what it is, there's nothing
// that we can do
if (!$image)
{
	header('HTTP/1.1 400 Bad Request');
	echo 'Error: no image was specified';
	exit();
}

// Strip the possible trailing slash off the document root
$docRoot	= preg_replace('/\/$/', '', DOCUMENT_ROOT);

if (!file_exists($docRoot . $image))
{
	header('HTTP/1.1 404 Not Found');
	echo 'Error: image does not exist: ' . $docRoot . $image;
	exit();
}

// Get the size and MIME type of the requested image
$size	= GetImageSize($docRoot . $image);
$mime	= $size['mime'];
//print_r( $size);
// Make sure that the requested file is actually an image
if (substr($mime, 0, 6) != 'image/')
{
	header('HTTP/1.1 400 Bad Request');
	echo 'Error: requested file is not an accepted type: ' . $docRoot . $image;
	exit();
}

$width			= $size[0];
$height			= $size[1];

$maxWidth		= (isset($width_asked)) ? (int) $width_asked : 0;
$maxHeight		= (isset($height_asked)) ? (int) $height_asked : 0;

if (isset($_GET['color']))
	$color		= preg_replace('/[^0-9a-fA-F]/', '', (string) $_GET['color']);
else
	$color		= FALSE;

// If either a max width or max height are not specified, we default to something
// large so the unspecified dimension isn't a constraint on our resized image.
// If neither are specified but the color is, we aren't going to be resizing at
// all, just coloring.
if (!$maxWidth && $maxHeight)
{
	$maxWidth	= 99999999999999;
}
elseif ($maxWidth && !$maxHeight)
{
	$maxHeight	= 99999999999999;
}
elseif ($color && !$maxWidth && !$maxHeight)
{
	$maxWidth	= $width;
	$maxHeight	= $height;
}

// If we don't have a max width or max height, OR the image is smaller than both
// we do not want to resize it, so we simply output the original image and exit

if ((!$maxWidth && !$maxHeight) || (!$color && $maxWidth >= $width && $maxHeight >= $height))
{
	$data	= file_get_contents($docRoot . '/' . $image);
	
	$lastModifiedString	= gmdate('D, d M Y H:i:s', filemtime($docRoot . '/' . $image)) . ' GMT';
	$etag				= md5($data);
	
	doConditionalGet($etag, $lastModifiedString);
	
	header("Content-type: $mime");
	header('Content-Length: ' . strlen($data));
	echo $data;
	exit();
}

// Ratio cropping
$offsetX	= 0;
$offsetY	= 0;

if (isset($crop_ratio))
{
	$cropRatio		= explode(':', (string) $crop_ratio);
	if (count($cropRatio) == 2)
	{
		$ratioComputed		= $width / $height;
		$cropRatioComputed	= (float) $cropRatio[0] / (float) $cropRatio[1];
		
		if ($ratioComputed < $cropRatioComputed)
		{ // Image is too tall so we will crop the top and bottom
			$origHeight	= $height;
			$height		= $width / $cropRatioComputed;
			$offsetY	= ($origHeight - $height) / 2;
		}
		else if ($ratioComputed > $cropRatioComputed)
		{ // Image is too wide so we will crop off the left and right sides
			$origWidth	= $width;
			$width		= $height * $cropRatioComputed;
			$offsetX	= ($origWidth - $width) / 2;
		}
	}
}

// Setting up the ratios needed for resizing. We will compare these below to determine how to
// resize the image (based on height or based on width)
$xRatio		= $maxWidth / $width;
$yRatio		= $maxHeight / $height;

if ($xRatio * $height < $maxHeight)
{ // Resize the image based on width
	$tnHeight	= ceil($xRatio * $height);
	$tnWidth	= $maxWidth;
}
else // Resize the image based on height
{
	$tnWidth	= ceil($yRatio * $width);
 	$tnHeight	= $maxHeight;
}

// Determine the quality of the output image
$quality	= (isset($_GET['quality'])) ? (int) $_GET['quality'] : DEFAULT_QUALITY;

// Before we actually do any crazy resizing of the image, we want to make sure that we
// haven't already done this one at these dimensions. To the cache!
// Note, cache must be world-readable

// We store our cached image filenames as a hash of the dimensions and the original filename
$resizedImageSource		= $tnWidth . 'x' . $tnHeight . 'x' . $quality;
if ($color)
	$resizedImageSource	.= 'x' . $color;
if (isset($crop_ratio))
	$resizedImageSource	.= 'x' . (string) $crop_ratio;
$resizedImageSource		.= '-' . $image;

$resizedImage	= md5($resizedImageSource);
	
$resized= CACHE_DIR.$file_name;

// Check the modified times of the cached file and the original file.
// If the original file is older than the cached file, then we simply serve up the cached file
if (!isset($_GET['nocache']) && file_exists($resized))
{
	$imageModified	= filemtime($docRoot . $image);
	$thumbModified	= filemtime($resized);
	
	if($imageModified < $thumbModified) {
		$data	= file_get_contents($resized);

		$lastModifiedString	= gmdate('D, d M Y H:i:s', $thumbModified) . ' GMT';
		$etag				= md5($data);
		
		doConditionalGet($etag, $lastModifiedString);
		
		header("Content-type: $mime");
		header('Content-Length: ' . strlen($data));
		echo $data;
		exit();
	}
}

// We don't want to run out of memory
ini_set('memory_limit', MEMORY_TO_ALLOCATE);

// Set up a blank canvas for our resized image (destination)
$dst	= imagecreatetruecolor($tnWidth, $tnHeight);

// Set up the appropriate image handling functions based on the original image's mime type
switch ($size['mime'])
{
	case 'image/gif':
		// We will be converting GIFs to PNGs to avoid transparency issues when resizing GIFs
		// This is maybe not the ideal solution, but IE6 can suck it
		$creationFunction	= 'ImageCreateFromGif';
		$outputFunction		= 'ImagePng';
		$mime				= 'image/png'; // We need to convert GIFs to PNGs
		$doSharpen			= FALSE;
		$quality			= round(10 - ($quality / 10)); // We are converting the GIF to a PNG and PNG needs a compression level of 0 (no compression) through 9
	break;
	
	case 'image/x-png':
	case 'image/png':
		$creationFunction	= 'ImageCreateFromPng';
		$outputFunction		= 'ImagePng';
		$doSharpen			= FALSE;
		$quality			= round(10 - ($quality / 10)); // PNG needs a compression level of 0 (no compression) through 9
	break;
	
	default:
		$creationFunction	= 'ImageCreateFromJpeg';
		$outputFunction	 	= 'ImageJpeg';
		$doSharpen			= TRUE;
	break;
}

// Read in the original image
$src	= $creationFunction($docRoot . $image);

if (in_array($size['mime'], array('image/gif', 'image/png')))
{
	if (!$color)
	{
		// If this is a GIF or a PNG, we need to set up transparency
		imagealphablending($dst, false);
		imagesavealpha($dst, true);
	}
	else
	{
		// Fill the background with the specified color for matting purposes
		if ($color[0] == '#')
			$color = substr($color, 1);
		
		$background	= FALSE;
		
		if (strlen($color) == 6)
			$background	= imagecolorallocate($dst, hexdec($color[0].$color[1]), hexdec($color[2].$color[3]), hexdec($color[4].$color[5]));
		else if (strlen($color) == 3)
			$background	= imagecolorallocate($dst, hexdec($color[0].$color[0]), hexdec($color[1].$color[1]), hexdec($color[2].$color[2]));
		if ($background)
			imagefill($dst, 0, 0, $background);
	}
}


// Resample the original image into the resized canvas we set up earlier
ImageCopyResampled($dst, $src, 0, 0, $offsetX, $offsetY, $tnWidth, $tnHeight, $width, $height);



if ($doSharpen)
{
	// Sharpen the image based on two things:
	//	(1) the difference between the original size and the final size
	//	(2) the final size
	$sharpness	= findSharp($width, $tnWidth);
	
	$sharpenMatrix	= array(
		array(-1, -2, -1),
		array(-2, $sharpness + 12, -2),
		array(-1, -2, -1)
	);
	$divisor		= $sharpness;
	$offset			= 0;
	imageconvolution($dst, $sharpenMatrix, $divisor, $offset);
}

// Make sure the cache exists. If it doesn't, then create it
if (!file_exists(CACHE_DIR))
	mkdir(CACHE_DIR, 0755);
echo CACHE_DIR;
// Make sure we can read and write the cache directory

if (!is_readable(CACHE_DIR))
{
	header('HTTP/1.1 500 Internal Server Error');
	echo 'Error: the cache directory is not readable';
	exit();
}
else if (!is_writable(CACHE_DIR))
{
	header('HTTP/1.1 500 Internal Server Error');
	echo 'Error: the cache directory is not writable';
	exit();
}


// Write the resized image to the cache
$outputFunction($dst, $resized, $quality);

// Put the data of the resized image into a variable
ob_start();
$outputFunction($dst, null, $quality);
$data	= ob_get_contents();
ob_end_clean();

// Clean up the memory
ImageDestroy($src);
ImageDestroy($dst);

// See if the browser already has the image
$lastModifiedString	= gmdate('D, d M Y H:i:s', filemtime($resized)) . ' GMT';
$etag				= md5($data);

//doConditionalGet($etag, $lastModifiedString);

// Send the image to the browser with some delicious headers
//header("Content-type: $mime");
//header('Content-Length: ' . strlen($data));
//echo $data;
}

function findSharp($orig, $final) // function from Ryan Rud (http://adryrun.com)
{
	$final	= $final * (750.0 / $orig);
	$a		= 52;
	$b		= -0.27810650887573124;
	$c		= .00047337278106508946;
	
	$result = $a + $b * $final + $c * $final * $final;
	
	return max(round($result), 0);
} // findSharp()

function doConditionalGet($etag, $lastModified)
{
	header("Last-Modified: $lastModified");
	header("ETag: \"{$etag}\"");
		
	$if_none_match = isset($_SERVER['HTTP_IF_NONE_MATCH']) ?
		stripslashes($_SERVER['HTTP_IF_NONE_MATCH']) : 
		false;
	
	$if_modified_since = isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) ?
		stripslashes($_SERVER['HTTP_IF_MODIFIED_SINCE']) :
		false;
	
	if (!$if_modified_since && !$if_none_match)
		return;
	
	if ($if_none_match && $if_none_match != $etag && $if_none_match != '"' . $etag . '"')
		return; // etag is there but doesn't match
	
	if ($if_modified_since && $if_modified_since != $lastModified)
		return; // if-modified-since is there but doesn't match
	
	// Nothing has changed since their last request - serve a 304 and exit
	header('HTTP/1.1 304 Not Modified');
	exit();
} // doConditionalGet()


?>