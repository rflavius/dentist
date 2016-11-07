<?php
function DeleteVideo($video_id)
{
		global $db;
		$sql = "DELETE FROM video WHERE id='".$video_id."'";
		$db->query($sql);
		return 1;
}
function GetMenuUtilizator ($parent_id)
{
	global $db;
	$menu = array();
	$query = "SELECT * FROM user_menu
						WHERE status='Y'
						AND parent_id='".$parent_id."' ORDER by position ASC";
	$db->query($query);
	$i = 0;
	while ($db->next_record())
	{
		$menu[$i]['id'] = $db->f('id');
		$menu[$i]['name'] = $db->f('name');
		$menu[$i]['parent_id'] = $db->f('parent_id');
		$menu[$i]['active'] = $db->f('status');
		$menu[$i]['url'] = $db->f('url');
		$i++;
	}
	return $menu;
}

function GetMenuUtilizatorComplex ($parent_id)
{
	global $db;
	$menu = array();
	$query = "SELECT * FROM user_menu
						WHERE status='Y'
						AND parent_id='".$parent_id."' ORDER by position ASC";
	$db->query($query);
/*	if($db->affected_rows()<1)
	{
		$query = "SELECT * FROM user_menu
						WHERE status='Y'
						AND parent_id='".$parent_id."' ORDER by position ASC";
		$db->query($query);
	
	}*/
	$i = 0;
	while ($db->next_record())
	{
		$menu[$i]['id'] = $db->f('id');
		$menu[$i]['name'] = $db->f('name');
		$menu[$i]['parent_id'] = $db->f('parent_id');
		$menu[$i]['active'] = $db->f('status');
		$menu[$i]['url'] = $db->f('url');
		$i++;
	}
	return $menu;
}

#get the main menu name 
function GetMenuUtilizatorNameFromID($menu_id)
{
	global $db;
	$query = "SELECT * FROM admin_menu
						WHERE active='Y'
						AND id='".$menu_id."'";
	$db->query($query);
	$db->next_record();
	return $db->f('name');
}


#return the ids for each modul like in admin menu items
function GetCurrentMenuIDUtilizator($module,$action)
{
	switch ($action)
	{
		default:
			$id_module = 1;
		break;
		case 'account':
			$id_module = 20;
		break;

		case 'password':
			$id_module = 20;
		break;
		
		case 'addfirm':
			$id_module = 21;
		break;

		case 'galerie':
			$id_module = 21;
		break;
		case 'editfirme':
			$id_module = 21;
		break;
		case 'listfirms':
			$id_module = 21;
		break;
		case 'modificaimg':
			$id_module = 21;
		break;
		

		case 'listarticole':
			$id_module = 30;
		break;
		case 'addarticol':
			$id_module = 30;
		break;
		case 'editarticol':
			$id_module = 30;
		break;
		
		
		case 'listanunturi':
			$id_module = 27;
		break;
		
		case 'addanunt':
			$id_module = 27;
		break;

		case 'editanunt':
			$id_module = 27;
		break;

		case 'mesaje':
			$id_module = 26;
		break;
		
		case 'publicitate':
		$id_module = 39;
		break;

		case 'logout':
			$id_module = 38;
		break;

		case 'agendapacienti':
			$id_module = 37;
		break;

		case 'contact':
		$id_module = 36;
		break;

		case 'facturiproforme':
			$id_module = 34;
		break;
		case 'facturifiscale':
			$id_module = 34;
		break;
		case 'vizualizareproforma':
			$id_module = 34;
		break;
		case 'vizualizarefiscala':
			$id_module = 34;
		break;



		case 'ajutor':
			$id_module = 33;
		break;
	}

	return $id_module;
}

function CheckVideoItem()
{
	global $_PATH;
	global $conf;
	$allowed_types = array("video/mpg","video/mpeg","video/avi","video/x-ms-wmv","video/swf","audio/wav","audio/mp3","video/au", "video/mid","video/mov","audio/aiff","audio/x-mpeg","audio/x-wav", "audio/mpeg","application/x-shockwave-flash","video/x-msvideo","application/octet-stream");

	if(in_array($_FILES['video']['type'], $allowed_types))
	{
		/*check is the width is valid*/
		$size=ini_get('upload_max_filesize');
		$video_sizes = $_FILES['video']['size'];
		$size_from_db = $conf->max_video_size;
		
		$size = substr($size_from_db,0,strlen($size_from_db)-1);
		$sizee = $size*1000024;
		$width = $video_sizes;
		if($width > $sizee)
		{
			return '1';
		}
	}
	else 
	{
		/*not a valid file type*/
		return '0';
	}
}

function saveVideoCabinet ($cab_id,$youtube=false)
{
	global $db;
	global $conf;
	$extension = "";
	#only if we add another video file , just then we delete, othrwise we just add the youtube link
	if($_FILES['video']['type']!="")
	{
		$video = getCabinetVideoFile($cab_id);
		## if we allready have a video file then REMOVE IT !!!
		if (is_array($video) )
		{
			$sql = "DELETE FROM video WHERE cabinet_id='$cab_id'";
			$db->query($sql);
			$filename = $video['id'].'.'.$video['type'];
			chmod("../video/".$filename,0777);
			unlink("../video/".$filename);
		}
	
		$ext = explode(".",$_FILES['video']['name']);
		$extension = $ext[count($ext)-1];
	}

	$query = "INSERT into video(`id`,`cabinet_id`,`type`,`date`,`youtube_url`) VALUES('','$cab_id','$extension',NOW(),'$youtube')";
	$db->query($query);
	$last_id =$db->last_insert_id();
	
	#here we save the video file
	if($_FILES['video']['name']!="")
	{
		SaveVideoPhoto($last_id,$extension);
	}
	return $last_id;
}

function SaveVideoPhoto ($id,$file_extension)
{	
	global $conf;
	global $db;
	
	$filename = $id.'.'.$file_extension; /*create video name*/
	$uploaddir = '../video/';
	$uploadfile = $uploaddir.$filename;
	/*upload picture*/
	if (($file_extension!="" )&&($file_extension!="NULL"))
	{
		if (!move_uploaded_file($_FILES['video']['tmp_name'], $uploadfile))
		{
			print "Possible file upload attack!  Here's some debugging info:\n";
			print_r($_FILES);
		}
	}
	
	/*change chmode*/
	if ($file_extension!="" )
	{
		chmod($uploadfile, 0777);
	}
}

function CheckPicture($image)
{
	global $conf;
	$allowed_types = array("image/pjpeg","image/jpeg","image/gif","image/png");
	$allowed_extension = array("jpg","jpeg","gif","png");

	$ext = explode(".",$image['name']);
	$extension = strtolower($ext[count($ext)-1]); // the real extension of the image !!!
	
	if($image['name']!="")
	{
		if(in_array($image['type'], $allowed_types)  && ($image['name']!="") && in_array($extension, $allowed_extension) )
		{
		}
		else 
		{
			return '0';
			break;
		}

		$image_sizes = GetImageSize($image['tmp_name']);
		$width = $image_sizes['0'];
		if ($width > $conf->max_img_banner)
		{
			return "1";
			break;
		}
	}
}

function saveBannerCabinet($cab_id)
{
	global $conf;
	global $db;

	#if we have old banner we delete it
	$get_banner = GetBanner($cab_id);
	if(isset($get_banner)&&($get_banner!=""))
	{
		chmod("../images/banner/".$get_banner,0777);
		unlink("../images/banner/".$get_banner );
		$sql = "DELETE FROM banner WHERE cabinet_id='".$cab_id."'";
		$db->query($sql);
	}

	$ext = explode(".",$_FILES['banner']['name']);
	$extension = $ext[count($ext)-1];
	$img_name = str_replace(".".$extension,"",$_FILES['banner']['name']);
	$filename = $img_name.'.'.$extension; /*create banner name*/


	$a = getPromovareLevelDetails('2');
	$afisari = $a['recomandam_banner'];
	$sql = "INSERT INTO banner(`id`,`name`,`cabinet_id`,`date`,`total_afisari`) VALUES('','$filename','$cab_id',NOW(),'$afisari')";
	$db->query($sql);

	$uploaddir = '../images/banner/';
	$uploadfile = $uploaddir.$filename;
	/*upload picture*/
	if (($extension!="" )&&($extension!="NULL"))
	{
		if (!move_uploaded_file($_FILES['banner']['tmp_name'], $uploadfile))
		{
			print "Possible file upload attack!  Here's some debugging info:\n";
			print_r($_FILES);
		}
	}
	
	/*change chmode*/
	if ($extension!="" )
	{
		chmod($uploadfile, 0777);
	}
}

function CheckServiciiFile()
{
	global $conf;
	$allowed_extension = array("pdf","doc");

	$ext = explode(".",$_FILES['servicii']['name']);
	$extension = strtolower($ext[count($ext)-1]); // the real extension of the image !!!
	
	if($_FILES['servicii']['name']!="")
	{
		if(($_FILES['servicii']['name']!="") && in_array($extension, $allowed_extension) )
		{
		}
		else 
		{
			return '0';
			break;
		}
	}
}


function CheckArticolFile()
{
	global $conf;
	$allowed_extension = array("pdf","doc");

	$ext = explode(".",$_FILES['articol_file']['name']);
	$extension = strtolower($ext[count($ext)-1]); // the real extension of the image !!!
	
	if($_FILES['articol_file']['name']!="")
	{
		if(($_FILES['articol_file']['name']!="") && in_array($extension, $allowed_extension) )
		{
		}
		else 
		{
			return '0';
			break;
		}
	}
}

function saveServiciiFileCabinet($cab_id)
{
	global $conf;
	global $db;

	## remove if we have old files !!!
	$servicii_file = getCabinetServiciiFile($cab_id);
	if (is_array($servicii_file) )
	{
		$sql = "DELETE FROM servicii_file WHERE cabinet_id='$cab_id'";
		$db->query($sql);

		## remove the file
		chmod("../servicii_file/".$servicii_file['name'],0777);
		unlink("../servicii_file/".$servicii_file['name']);
	}
	

	$ext = explode(".",$_FILES['servicii']['name']);
	$extension = $ext[count($ext)-1];
	$f_name = str_replace(".".$extension,"",$_FILES['servicii']['name']);

	$filename = $f_name.'.'.$extension; /*create file name*/

	$sql = "INSERT INTO servicii_file(`id`,`name`,`cabinet_id`,`date`) VALUES('','$filename','$cab_id',NOW())";
	$db->query($sql);

	$uploaddir = '../servicii_file/';
	$uploadfile = $uploaddir.$filename;
	/*upload picture*/
	if (($extension!="" )&&($extension!="NULL"))
	{
		if (!move_uploaded_file($_FILES['servicii']['tmp_name'], $uploadfile))
		{
			print "Possible file upload attack!  Here's some debugging info:\n";
			print_r($_FILES);
		}
	}
	
	/*change chmode*/
	if ($extension!="" )
	{
		chmod($uploadfile, 0777);
	}
}

function saveArticolPdfFile($art_id)
{
	global $conf;
	global $db;

	## remove if we have old files !!!
	$servicii_file = getArticolServiciiFile($art_id);
	if (is_array($servicii_file) )
	{
		$sql = "DELETE FROM articole_file WHERE articol_id='$art_id'";
		$db->query($sql);

		## remove the file
		chmod("../articole_file/".$servicii_file['name'],0777);
		unlink("../articole_file/".$servicii_file['name']);
	}
	

	$ext = explode(".",$_FILES['articol_file']['name']);
	$extension = $ext[count($ext)-1];
	$f_name = str_replace(".".$extension,"",$_FILES['articol_file']['name']);

	$filename = $f_name.'.'.$extension; /*create file name*/

	$sql = "INSERT INTO articole_file(`id`,`name`,`articol_id`,`date`) VALUES('','$filename','$art_id',NOW())";
	$db->query($sql);

	$uploaddir = '../articole_file/';
	$uploadfile = $uploaddir.$filename;
	/*upload picture*/
	if (($extension!="" )&&($extension!="NULL"))
	{
		if (!move_uploaded_file($_FILES['articol_file']['tmp_name'], $uploadfile))
		{
			print "Possible file upload attack!  Here's some debugging info:\n";
			print_r($_FILES);
		}
	}
	
	/*change chmode*/
	if ($extension!="" )
	{
		chmod($uploadfile, 0777);
	}
}

function hasAnotherGratuitCabinet($user_id,$this_cabinet)
{
	global $db;
	$sql = "SELECT level FROM cabinete WHERE `user_id`='$user_id' AND `id`<>'$this_cabinet'";
	$db->query($sql);
	if($db->num_rows()>0)
	{
		while($db->next_record())
		{
			## if we found a gratuit cabinet
			if($db->f('level')=='1')
			{
				return true;
				break;
			}
		}
	}
	else
	{
		### this is the first GRATUIT cabinet
		return false;
	}
}

function countCabineteAbonament($user_id)
{
	global $db;
	$sql = "SELECT id FROM cabinete WHERE `user_id`='$user_id' AND `level`='2'";
	$db->query($sql);
	return $db->num_rows();
}

/**
 * here we get the stats for cabinet from the cabinete_statistics table
 * @access public
 * @param int $id
 * @param string $field
 * @param int $month
 * @param int $year
 * @return int
 */
function getCabinetStat($id, $field, $month, $year)
{
	$db = Zend_Registry::get('database');
	$select = $db->select()
					->from('cabinete_statistics', $field)
					->where('cab_id = ?', $id)
					->where('MONTH(cron_date) = ?', $month)
					->where('YEAR(cron_date) = ?', $year);
	//echo $select."<br>";
	
	$first = (int)$db->fetchOne($select);
	
	$prev_month = $month-1;
	$prev_year = $year;
	if($prev_month==0)
	{
		$prev_month = 12;
		$prev_year = $year-1;
	}
	
	$select2 = $db->select()
					->from('cabinete_statistics', $field)
					->where('cab_id = ?', $id)
					->where('MONTH(cron_date) = ?', $prev_month)
					->where('YEAR(cron_date) = ?', $prev_year);
	$last = (int)$db->fetchOne($select2);
	return ($first-$last);
}

/**
 * here we display the chart info for cabinet visitors
 * @access public
 * @param int $id
 * @return void
 */
function displayCabinetVisitorsStats($id)
{
	// column chart
	global $tpl;
	$tpl->set_file('tpl_widget', 'user/widget/widget_visitors.tpl');
	$current_month = date('n');
	$current_year = date('Y');
	$date = array();
	
	for ($i = -2; $i <= 0; $i++)
	{
		$month = date('n', strtotime("$i month"));
		if($month>$current_month)
		{
			// this means we are at new year starting months
			$date[] = array('year' => $current_year-1, 'month' => $month);
		}
		else $date[] = array('year' => $current_year, 'month' => $month);
	}
	
	$title='';
	$months = '';
	$visitors = '';
	
	foreach ($date as $key => $value)
	{
		if($key==0)
		{
			$title = date('M', strtotime($value['month'].' month'));
			$months = "'".date('M', strtotime($value['month'].' month'))."'";
			$visitors = getCabinetStat($id, 'visitors', $value['month'], $value['year']);
		}
		else
		{
			$title.= ' - '.date('M', strtotime($value['month'].' month'));
			$months.= ", '".date('M', strtotime($value['month'].' month'))."'";
			$visitors.= ",".getCabinetStat($id, 'visitors', $value['month'], $value['year']);
		}
	}
	
	$tpl->set_var('MONTHS_TITLE', $title);
	$tpl->set_var('MONTHS_LIST', $months);
	$tpl->set_var('MONTH_VISITORS', $visitors);
	
	//parse colors
	$tpl->parse('WIDGET_VISITORS_BLOCK','tpl_widget');
}

/**
 * here we display the chart info for cabinet programari
 * @access public
 * @param int $id
 * @return void
 */
function displayCabinetEmailsStats($id)
{
	// column chart
	global $tpl;
	$tpl->set_file('tpl_widget2', 'user/widget/widget_emails.tpl');
	$current_month = date('n');
	$current_year = date('Y');
	$date = array();
	
	for ($i = -2; $i <= 0; $i++)
	{
		$month = date('n', strtotime("$i month"));
		if($month>$current_month)
		{
		// this means we are at new year starting months
			$date[] = array('year' => $current_year-1, 'month' => $month);
		}
		else $date[] = array('year' => $current_year, 'month' => $month);
	}
	
	$title='';
	$months = '';
	$visitors = '';
	
	foreach ($date as $key => $value)
	{
		if($key==0)
		{
			$title = date('M', strtotime($value['month'].' month'));
			$months = "'".date('M', strtotime($value['month'].' month'))."'";
			$visitors = getCabinetStat($id, 'emails', $value['month'], $value['year']);
		}
		else
		{
			$title.= ' - '.date('M', strtotime($value['month'].' month'));
			$months.= ", '".date('M', strtotime($value['month'].' month'))."'";
			$visitors.= ",".getCabinetStat($id, 'emails', $value['month'], $value['year']);
		}
	}
	
	$tpl->set_var('MONTHS_TITLE', $title);
	$tpl->set_var('MONTHS_LIST', $months);
	$tpl->set_var('MONTH_VISITORS', $visitors);
	
	//parse colors
	$tpl->parse('WIDGET_EMAIL_BLOCK','tpl_widget2');
}

/**
 * here we display the chart info for cabinet programari
 * @access public
 * @param int $id
 * @return void
 */
function displayCabinetPhoneStats($id)
{
	// column chart
	global $tpl;
	$tpl->set_file('tpl_widget3', 'user/widget/widget_phone.tpl');
	$current_month = date('n');
	$current_year = date('Y');
	$date = array();

	for ($i = -2; $i <= 0; $i++)
	{
		$month = date('n', strtotime("$i month"));
		if($month>$current_month)
		{
			// this means we are at new year starting months
			$date[] = array('year' => $current_year-1, 'month' => $month);
		}
		else $date[] = array('year' => $current_year, 'month' => $month);
	}

	$title='';
	$months = '';
	$visitors = '';

	foreach ($date as $key => $value)
	{
		if($key==0)
		{
			$title = date('M', strtotime($value['month'].' month'));
			$months = "'".date('M', strtotime($value['month'].' month'))."'";
			$visitors = getCabinetStat($id, 'phone_views', $value['month'], $value['year']);
		}
		else
		{
			$title.= ' - '.date('M', strtotime($value['month'].' month'));
			$months.= ", '".date('M', strtotime($value['month'].' month'))."'";
			$visitors.= ",".getCabinetStat($id, 'phone_views', $value['month'], $value['year']);
		}
	}

	$tpl->set_var('MONTHS_TITLE', $title);
	$tpl->set_var('MONTHS_LIST', $months);
	$tpl->set_var('MONTH_VISITORS', $visitors);

	//parse colors
	$tpl->parse('WIDGET_PHONE_BLOCK','tpl_widget3');
}

/*
#Get modules
function GetModules ($id)
{
	global $db;
	switch ($id)
	{
		default :
			$query = "SELECT * FROM modules WHERE id = '".$id."'";
		break;

		case '-1':
			$query = "SELECT * FROM modules";
		break;
	}
	$db->query($query);
	$modules = array();
	$i = 0;
	while ($db->next_record())
	{
		$modules[$i]['id'] = $db->f('id');
		$modules[$i]['name'] = $db->f('name');
		$modules[$i]['link'] = $db->f('link');
		$modules[$i]['type'] = $db->f('type');
		$modules[$i]['meta_keywords'] = $db->f('meta_keywords');
		$modules[$i]['meta_description'] = $db->f('meta_description');
		$modules[$i]['content'] = $db->f('content');
		$modules[$i]['active'] = $db->f('active');
		$modules[$i]['support'] = $db->f('support');
		$i++;
	}
	return $modules;
}

#Check if link module exists
function UrlExists ($link)
{
	global $db;
	$query = "SELECT id FROM modules WHERE link = '".$link."'";
	$db->query($query);
	if ($db->num_rows() != '0' )
	{
		return '1';
	}
	$query = "SELECT id FROM pages WHERE link = '".$link."'";
	$db->query($query);
	if ($db->num_rows() != '0' )
	{
		return '1';
	}
	else 
	{
		return '0';
	}
}

function ShowUploadedPhotos ()
{
	$show_pictures = array();
	global $db;
	$query = " SELECT *
							FROM uploaded_photos ORDER by photo_id DESC";
	$db->query($query);
	$i = 0;
	while ($db->next_record())
	{
		$show_pictures[$i]['photo_id'] = $db->f("photo_id");
		$show_pictures[$i]['photo_name'] = $db->f("photo_name");
		$show_pictures[$i]['width'] = $db->f("width");
		$show_pictures[$i]['height'] = $db->f("height");
		$show_pictures[$i]['size'] = $db->f("size");
		$i++;
	}
	return $show_pictures;
}

function SaveUploadedPhoto ($file_extension, $form_num)
{
	global $conf;
	global $db;
	$allowed_types = array("image/pjpeg","image/jpeg","image/png","image/x-png","image/gif");
	if(in_array($_FILES['userfile_'.$form_num]['type'], $allowed_types))
	{
		#select bigest id
		$query = "SELECT photo_id FROM uploaded_photos ORDER BY photo_id DESC LIMIT 1";
		$db->query($query);
		if ($db->num_rows() == '0')
		{
			#table empty
			$new_id = '1';
		}
		else 
		{
			$db->next_record();
			$new_id = $db->f('photo_id') + 1;
		}
		#create photo name
		$filename = 'photo_'.$new_id.'.'.$file_extension;
		$uploaddir = '../images/uploaded_photos/';
		$uploadfile = $uploaddir.$filename;
		#get image information : width , height, size 
		$sizes = GetImageSize($_FILES['userfile_'.$form_num]['tmp_name']);
		$width = $sizes[0];
		$height = $sizes[1];
		$size = $_FILES['userfile_'.$form_num]['size'];
		if (move_uploaded_file($_FILES['userfile_'.$form_num]['tmp_name'], $uploadfile))
		{
			#change chmode
			chmod($uploadfile, 0777);
			#do query if image is uploaded
			$query = "INSERT into uploaded_photos(photo_name, width, height, size)
														VALUES ('".$filename."',
																		'".$width."',
																		'".$height."',
																		'".$size."')";
			$db->query($query);
			$uploadthumb = $uploaddir.$filename;
			#return txt msg 
			$result = 'Image number '.$form_num.' successfully uploaded !';
		}
		else
		{
			print "Possible file upload attack! Here's some debugging info:\n";
			echo '<pre>';
			print_r($_FILES);
			echo '</pre>';
		}
	}
	else 
	{
		#return txt msg 
		$result = 'Image number '.$form_num.' is not a valid image type !';
	}
	return $result;
}

function GetPages ($order_column)
{
	global $db;
	$pages = array();
	if (trim($order_column) != "")
	{
		$query = "SELECT * FROM pages ORDER by ".$order_column." ASC";
	}
	else 
	{
		$query = "SELECT * FROM pages ";
	}
	$db->query($query);
	$i = 0;
	while ($db->next_record())
	{
		$pages[$i]['id'] = $db->f('id');
		$pages[$i]['name'] = $db->f('name');
		$pages[$i]['link'] = $db->f('link');
		$pages[$i]['meta_keywords'] = $db->f('meta_keywords');
		$pages[$i]['meta_description'] = $db->f('meta_description');
		$pages[$i]['active'] = $db->f('active');
		$i++;
	}
	return $pages;
}

function GetSelectedPage ($id)
{
	global $db;
	$page = array();
	$query = "SELECT * FROM pages WHERE id = '".$id."'";
	$db->query($query);
	$db->next_record();
	$page['id'] = $db->f('id');
	$page['name'] = $db->f('name');
	$page['link'] = $db->f('link');
	$page['content'] = $db->f('content');
	$page['meta_keywords'] = $db->f('meta_keywords');
	$page['meta_description'] = $db->f('meta_description');
	$page['active'] = $db->f('active');
	return $page;
}

function SaveConfig ($the_variable, $value)
{
	global $db;
	$query = "UPDATE config SET `value` = '".addslashes($value)."'
						WHERE `variable`='".$the_variable."'";
	$db->query($query);
	return 0;
}

function DeleteSelectedItem ($table, $column, $delete)
{
	global $db;
	$query = "DELETE FROM ".$table." WHERE ".$column." = '".$delete."'";
	$db->query($query);
	return 0;
}

function InsertAdminMessage ($message)
{
	global $admin;
	global $db;
	$query = "INSERT into admin_messages(exp, msg, date)
										VALUES('".$admin->userID."', '".$message."', now())";
	$db->query($query);
	return 0;
}

function GetAdminMessages ()
{
	global $db;
	$query = "SELECT * FROM admin_messages ORDER by date DESC";
	$db->query($query);
	$i = 0;
	$msg = array();
	while ($db->next_record())
	{
		$msg[$i]['id'] = $db->f('id');
		$msg[$i]['exp'] = $db->f('exp');
		$msg[$i]['msg'] = $db->f('msg');
		$msg[$i]['date'] = $db->f('date');
		$i++;
	}
	return $msg;
}

function GetTheExpeditor ($id)
{
	global $db;
	$query = "SELECT user FROM admin_accounts WHERE id = '".$id."'";
	$db->query($query);
	$db->next_record();
	return $db->f('user');
}

function AdminPagination ($per_page, $totals, $page_name, $p) 
{
	$html_pages = ''; 
	$start = ($p-1)*$per_page; 
	$pages = ceil($totals/$per_page); 

	if ($pages > 1 )
	{
		if (($p-1) > 0 )
		{
			$html_pages.="<a href=?page=".$page_name."&start=1 class=pags>&laquo; First </a>&nbsp;";
		}
		for($i = max(($p-8), 1); $i <= min(($p+8),$pages) ; $i++)
		{
			if ($p == $i)
			{
				$html_pages.= "[ <strong>".$i." </strong>]&nbsp;";
			}
			else
			{
			$html_pages.="<a href=?page=".$page_name."&start=".$i." class=pags>".$i."</a>&nbsp;&nbsp;";
			}
		}
		if ($p < $pages)
		{
		$html_pages.=" <a href=?page=".$page_name."&start=".$pages." class=pags>Last &raquo;</a>";
		}
	}
	return $html_pages;
}

function AdminPaginationCabineteAnuntArticole ($per_page, $totals, $page_name, $p,$dismode) 
{
	$html_pages = ''; 
	$start = ($p-1)*$per_page; 
	$pages = ceil($totals/$per_page); 

	#to set displpay mode
	if(isset($dismode)&&($dismode!=""))
	{
			$dispmode = "&displaymode=".$dismode;
	}
	else
	{	$dispmode = "";	}
	

	if ($pages > 1 )
	{
		if (($p-1) > 0 )
		{
			
			$html_pages.="<a href=?page=".$page_name."&start=1".$dispmode." class=pags>&laquo; First </a>&nbsp;";
		}
		for($i = max(($p-8), 1); $i <= min(($p+8),$pages) ; $i++)
		{
			if ($p == $i)
			{
				
				$html_pages.= "[ <strong>".$i." </strong>]&nbsp;";
			}
			else
			{
			$html_pages.="<a href=?page=".$page_name."&start=".$i."".$dispmode." class=pags>".$i."</a>&nbsp;&nbsp;";
			}
		}
		if ($p < $pages)
		{
		$html_pages.=" <a href=?page=".$page_name."&start=".$pages."".$dispmode." class=pags>Last &raquo;</a>";
		}
	}
	
	return $html_pages;
}

function FrontEndPagination ($per_page, $totals, $page_name, $p) 
{	global $conf;
	$html_pages = ''; 
	if($conf->url_rewrite_mode == 'N')
	{
			$start = ($p-1)*$per_page; 
			$pages = ceil($totals/$per_page); 

			if ($pages > 1 )
			{
				if (($p-1) > 0 )
				{
					$html_pages.="<a href=?p=".$page_name."&start=1 >&laquo; Prima </a>";
				}
				for($i = max(($p-8), 1); $i <= min(($p+8),$pages) ; $i++)
				{
					if ($p == $i)
					{
						$html_pages.= "<strong>".$i." </strong>";
					}
					else
					{
					$html_pages.="<a href=?p=".$page_name."&start=".$i." >".$i."</a>";
					}
				}
				if ($p < $pages)
				{
				$html_pages.=" <a href=?p=".$page_name."&start=".$pages." >Ultima &raquo;</a>";
				}
			}	
	}
	else
	{
		#means we have urlrewrite on
		$modulle =	explode(".",$page_name);
		$modul =	$modulle[0];
			

			$start = ($p-1)*$per_page; 
			$pages = ceil($totals/$per_page); 

			if ($pages > 1 )
			{
				if (($p-1) > 0 )
				{
					$html_pages.="<a href=".ReWrite($modul,$page_name.'.pagina1')." >&laquo; Prima </a>";
				}
				for($i = max(($p-8), 1); $i <= min(($p+8),$pages) ; $i++)
				{
					if ($p == $i)
					{
						$html_pages.= "<strong>".$i." </strong>";
					}
					else
					{
					$html_pages.="<a href=".ReWrite($modul,$page_name.'.pagina'.$i).">".$i."</a>";
					}
				}
				if ($p < $pages)
				{
				$html_pages.=" <a href=".ReWrite($modul,$page_name.'.pagina'.$pages)." >Ultima &raquo;</a>";
				}
			}	
	
	}
	
	return $html_pages;
}

function ArticlesFrontEndPagination ($per_page, $totals, $page_name, $p) 
{	global $conf;
	$html_pages = ''; 
	if($conf->url_rewrite_mode == 'N')
	{
			$start = ($p-1)*$per_page; 
			$pages = ceil($totals/$per_page); 

			if ($pages > 1 )
			{
				if (($p-1) > 0 )
				{
					$html_pages.="<a href=?p=".$page_name."&start=1 >&laquo; Prima </a>";
				}
				for($i = max(($p-8), 1); $i <= min(($p+8),$pages) ; $i++)
				{
					if ($p == $i)
					{
						$html_pages.= "<strong>".$i." </strong>";
					}
					else
					{
					$html_pages.="<a href=?p=".$page_name."&start=".$i." >".$i."</a>";
					}
				}
				if ($p < $pages)
				{
				$html_pages.=" <a href=?p=".$page_name."&start=".$pages." >Ultima &raquo;</a>";
				}
			}	
	}
	else
	{
		#means we have urlrewrite on
		$modulle =	explode(".",$page_name);
		$modul =	$modulle[0];
			
			$start = ($p-1)*$per_page; 
			$pages = ceil($totals/$per_page); 

			if ($pages > 1 )
			{
				if (($p-1) > 0 )
				{
					$html_pages.="<a href=".ReWrite('articole',$page_name.'.pagina1')." >&laquo; Prima </a>";
				}
				for($i = max(($p-8), 1); $i <= min(($p+8),$pages) ; $i++)
				{
					if ($p == $i)
					{
						$html_pages.= "<strong>".$i." </strong>";
					}
					else
					{
					$html_pages.="<a href=".ReWrite('articole',$page_name.'.pagina'.$i).">".$i."</a>";
					}
				}
				if ($p < $pages)
				{
				$html_pages.=" <a href=".ReWrite('articole',$page_name.'.pagina'.$pages)." >Ultima &raquo;</a>";
				}
			}	
	
	}
	
	return $html_pages;
}

function AnunturiFrontEndPagination ($per_page, $totals, $page_name, $p) 
{	global $conf;
	$html_pages = ''; 
	if($conf->url_rewrite_mode == 'N')
	{
			$start = ($p-1)*$per_page; 
			$pages = ceil($totals/$per_page); 

			if ($pages > 1 )
			{
				if (($p-1) > 0 )
				{
					$html_pages.="<a href=?p=".$page_name."&start=1 >&laquo; Prima </a>";
				}
				for($i = max(($p-8), 1); $i <= min(($p+8),$pages) ; $i++)
				{
					if ($p == $i)
					{
						$html_pages.= "<strong>".$i." </strong>";
					}
					else
					{
					$html_pages.="<a href=?p=".$page_name."&start=".$i." >".$i."</a>";
					}
				}
				if ($p < $pages)
				{
				$html_pages.=" <a href=?p=".$page_name."&start=".$pages." >Ultima &raquo;</a>";
				}
			}	
	}
	else
	{
		#means we have urlrewrite on
			$start = ($p-1)*$per_page; 
			$pages = ceil($totals/$per_page); 
			
			if ($pages > 1 )
			{
				if (($p-1) > 0 )
				{
					$html_pages.="<a href=".ReWrite('anunturi',$page_name.'.pagina1')." >&laquo; Prima </a>";
				}
				for($i = max(($p-8), 1); $i <= min(($p+8),$pages) ; $i++)
				{
					if ($p == $i)
					{
						$html_pages.= "<strong>".$i." </strong>";
					}
					else
					{
					$html_pages.="<a href=".ReWrite('anunturi',$page_name.'.pagina'.$i).">".$i."</a>";
					}
				}
				if ($p < $pages)
				{
				$html_pages.=" <a href=".ReWrite('anunturi',$page_name.'.pagina'.$pages)." >Ultima &raquo;</a>";
				}
			}	
	
	}
	
	return $html_pages;
}

function GetNameOfParent ($parent, $parent_id)
{
	global $db;
	#select module anyway
	switch ($parent)
	{
		case 'module':
			return '<li>'.GetModuleName($parent_id).'</li>';
		break;

		case 'category':
			$query = "SELECT cat_name, parent_module FROM cabinete_categories
								WHERE id_cat = '".$parent_id."'";
			$db->query($query);
			$db->next_record();
			$cat_name = $db->f('cat_name');
			$res = '<li>'.GetModuleName($db->f('parent_module')).'</li><div id="left_pad"><li>'.$cat_name.'</li></div>';
			return $res;
		break;
	}
}

function GetModuleName ($parent_id)
{
	global $db;
	$query = "SELECT name FROM modules WHERE id = '".$parent_id."'";
	$db->query($query);
	$db->next_record();
	return $db->f('name');
}
function GetModuleNameAnunturi ($parent_id)
{
	global $db;
	$query = "SELECT name FROM modules WHERE link = '".$parent_id."'";
	$db->query($query);
	$db->next_record();
	return $db->f('name');
}
function GetModuleLinkByName($module_name)
{
	global $db;
	$info = array();
	$query = "SELECT link,id FROM modules WHERE lower(name) = '".strtolower($module_name)."'";
	$db->query($query);
	if($db->affected_rows()>0)
	{
		$db->next_record();
	$info['link'] = $db->f('link');
	$info['id'] = $db->f('id');
	}
	else
	{
		$info['link'] = "";
	}

	return $info;
}
function GetModuleLinkByNameJudet($judet,$parent_module)
{
	global $db;
	$query = "SELECT id_cat FROM cabinete_categories WHERE lower(cat_name) = '".strtolower($judet)."' and parent_module='".$parent_module."'";
	$db->query($query);
	$db->next_record();
	return $db->f('id_cat');
}
function DeleteCabinet ($cabinet_id)
{
	global $db;
	$query = "DELETE FROM cabinete_cat WHERE cabinet_id = '".$cabinet_id."'";
	$db->query($query);

	#let_take foto name for this cabinet
	$cab_info = GetSelectedCabinet($cabinet_id);
	
	$query = "DELETE FROM cabinete WHERE id = '".$cabinet_id."'";
	$db->query($query);

	#let delete pictures too
	$picture_cab = $cab_info['picture_item1'];
	$picture_map = $cab_info['picture_item2'];
	

	if(strpos($picture_cab,"default")===false)
	{	
		unlink("../images/users_cabinete/".$picture_cab);	}
	
	if(strpos($picture_map,"default")===false)
		{	 unlink("../images/users_cabinete/".$picture_map);	}

	#let delete all contracte,facturi proforme si fiscale de la cabinetul respectiv
	$query="Delete from facturi_proforme where firma_id='".$cabinet_id."'";
	$db->query($query);
	$query="Delete from facturi_fiscale where firma_id='".$cabinet_id."'";
	$db->query($query);
	$query="Delete from contracte where firma_id='".$cabinet_id."'";
	$db->query($query);

}

function DeleteAnunt ($anunt_id)
{
	global $db;
	
	#let_take foto name for this cabinet
	$anunt_info = GetAnunturi('-1',intval($anunt_id));
	
	$query = "DELETE FROM anunturi WHERE id = '".$anunt_id."'";
	$db->query($query);

	#let delete pictures too
	$picture_anunt = $anunt_info[0]['imagine'];
	if(strpos($picture_anunt,"default")===false)
	{	
		unlink("../images/users_anunturi/".$picture_anunt);	}

}

function DeleteArticle ($art_id)
{
	global $db;
	
	#let_take foto name for this cabinet
	$anunt_info = GetSelectedArticle(intval($art_id));
	$query = "DELETE FROM articles WHERE id = '".$art_id."'";
	$db->query($query);

	#let delete pictures too
	$picture_anunt = $anunt_info['imagine'];
	if(strpos($picture_anunt,"default")===false)
	{	
		unlink("../images/users_articole/".$picture_anunt);	}

}
function SaveModuleChanges ($name, $status, $keywords, $description, $content, $id)
{
	global $db;
	$query = "UPDATE modules SET name = '".$name."',
															 meta_keywords = '".$keywords."',
															 meta_description = '".$description."',
															 content = '".$content."',
															 active = '".$status."'
						WHERE id = '".$id."'";
	$db->query($query);
	#change the name in the menus - but first find the link
	$query = "SELECT link FROM modules WHERE id = '".$id."'";
	$db->query($query);
	$db->next_record();
	$query = "UPDATE menus_items SET name = '".$name."' WHERE link = '".$db->f('link')."'";
	$db->query($query);
	return '0';
}

function DeleteModule ($id)
{
	global $db;
	#select the link so we can delete the menu items if they exist
	$query = "SELECT link, support FROM modules WHERE id = '".$id."'";
	$db->query($query);
	$db->next_record();
	$link = $db->f('link');
	$support = $db->f('support');//what items will be deleted next
	#delete the menu item  from the db
	$query = "DELETE FROM menus_items WHERE link = '".$link."'";
	$db->query($query);
	#optimaze table
	$query = "OPTIMIZE TABLE `menus_items`";
	$db->query($query);
	#delete the module from the db
	$query = "DELETE FROM modules WHERE id = '".intval($id)."'";
	$db->query($query);
	#optimaze table
	$query = "OPTIMIZE TABLE `modules`";
	$db->query($query);
	switch ($support)
	{
		case 'links':
			#Select links ids
			$query = "SELECT id FROM links WHERE parent_module = '".$id."'";
			$db->query($query);
			if ($db->num_rows() != 0)
			{
				while ($db->next_record())
				{
					$in_condition[$db->f("id")] = $db->f("id");
				}
				$in_condition = implode(",", $in_condition);
				#delete from db
				$query = "DELETE FROM links WHERE id IN (".$in_condition.")";
				$db->query($query);
				#optimeze links table
				$query = "OPTIMIZE TABLE `links`";
				$db->query($query);
				#make auto increment from 1
				$query = "ALTER TABLE `links`
									PACK_KEYS = 0 CHECKSUM = 0 DELAY_KEY_WRITE = 0 AUTO_INCREMENT = 1";
				$db->query($query);
			}
		break;

		case 'cabinete':
			#delete cabinete
			$query = "DELETE FROM cabinete WHERE parent_module = '".$id."'";
			$db->query($query);
			#select and delete cats
			$query = "SELECT id_cat FROM cabinete_categories WHERE parent_module = '".$id."'";
			$db->query($query);
			$tmpArr = array();
			while ($db->next_record())
			{
				$tmpArr[$db->f("id_cat")] = $db->f("id_cat");
			}
			#delete selected cats
			$query = "DELETE FROM cabinete_categories WHERE parent_module = '".$id."'";
			$db->query($query);
			#select and delete cats cabinete
			$tmpArray = array();
			foreach ($tmpArr as $key => $val)
			{
				$query = "SELECT cabinet_id FROM cabinete_cat WHERE cat_id = '".$val["id_cat"]."'";
				$db->query($query);
				while ($db->next_record())
				{
					$tmpArray[$db->f("cabinet_id")] = $db->f("cabinet_id");
				}
			}
			if (count($tmpArray) != 0)
			{
				$in_condition = implode(",", $tmpArray);
				#delete cabinete
				$query = "DELETE FROM cabinete WHERE id IN (".$in_condition.")";
				$db->query($query);
			}
		break;

		case 'gallery':
			$query = "SELECT id FROM gallery WHERE parent_module = '".$id."'";
			$db->query($query);
			#create array with ids
			$tmpArr = array();
			while ($db->next_record())
			{
				$tmpArr[$db->f("id")] = $db->f("id");
			}
			#delete items
			foreach ($tmpArr as $key => $val)
			{
				DeleteGalleryItem($val['id']);
			}
		break;

		case 'downloads':
			$query = "SELECT id FROM downloads WHERE parent_module = '".$id."'";
			$db->query($query);
			#create array with ids
			$tmpArr = array();
			while ($db->next_record())
			{
				$tmpArr[$db->f("id")] = $db->f("id");
			}
			#delete items
			foreach ($tmpArr as $key => $val)
			{
				DeleteDownloadItem($val['id']);
			}
		break;
	}
}

function ChangeStatus ($table, $field, $new_status, $id)
{
	global $db;
	switch ($new_status)
	{
		case 'active':
			$status = '1';
		break;

		case 'inactive':
			$status = '0';
		break;
	}
	$query = "UPDATE ".$table." SET ".$field." = '".$status."'
						WHERE id = '".$id."'";
	$db->query($query);
	#change the status for the items in the menus
	$query = "SELECT link FROM ".$table." WHERE id = '".$id."'";
	$db->query($query);
	$db->next_record();
	$query = "UPDATE menus_items SET active = '".$status."' WHERE link = '".$db->f('link')."'";
	$db->query($query);
	return '0';
}

function InsertPage ($name, $content, $link, $meta_keywords, $meta_description, $status)
{
	global $db;
	$query = "INSERT into pages (name,
															 content,
															 link,
															 meta_keywords,
															 meta_description,
															 active)
												VALUES ('".addslashes($name)."',
																'".$content."',
																'".addslashes($link)."',
																'".addslashes($meta_keywords)."',
																'".addslashes($meta_description)."',
																'".$status."')";
	$db->query($query);
	return $db->last_insert_id();
}

function DeleteMenu ($id)
{
	global $db;
	$query = "DELETE FROM menus WHERE id = '".$id."'";
	$db->query($query);
	#delete items from table
	$query = "DELETE FROM menus_items WHERE parent_menu = '".$id."'";
	$db->query($query);
	return '0';
}

function GetItems ($parent_id)
{
	global $db;
	$query = "SELECT * FROM menus_items
						WHERE parent_menu = '".$parent_id."'
						AND active != '0'
						ORDER by position ASC";
	$db->query($query);
	$items = array();
	$i = 0;
	while ($db->next_record())
	{
		$items[$i]['id'] = $db->f('id');
		$items[$i]['name'] = $db->f('name');
		$items[$i]['link'] = $db->f('link');
		$items[$i]['position'] = $db->f('position');
		$items[$i]['type'] = $db->f('type');
		$i++;
	}
	return $items;
}

#reorder and rearenge menus
function ReorderMenus ($id, $order_type)
{
	global $db;
	$query="SELECT position FROM menus_items WHERE `id`='".$id."'";
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
	UpdateMenusOrder($id, $new_order);
}

function UpdateMenusOrder ($id, $order_value)
{
	global $db;
	$query="UPDATE menus_items SET position = '".$order_value."'
					WHERE id='".$id."'";
	$db->query($query);
}

#it rearranges the order, after you do an reorder
function RearrangeMenus ($parent_id)
{
	global $db;
	$query="SELECT id FROM menus_items WHERE parent_menu = '".$parent_id."'
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
		UpdateMenusOrder($val, $i);
		$i+=10;
	}
}

#get the menu's name to displait to the admin when editing a menu
function  GetMenuName ($id)
{
	global $db;
	$query = "SELECT name FROM menus WHERE id = '".$id."'";
	$db->query($query);
	$db->next_record();
	return $db->f('name');
}

#get all the items from the modules table except the ones in the array
function GetModulesForMenu ($the_array)
{
	global $db;
	$query = "SELECT id, name, link FROM modules WHERE active = '1'";
	$get_modules = array();
	$db->query($query);
	$i = 0;
	while ($db->next_record())
	{
		if (!in_array($db->f('link'), $the_array))
		{
			$get_modules[$i]['id'] = $db->f('id');
			$get_modules[$i]['name'] = $db->f('name');
			$get_modules[$i]['link'] = $db->f('link');
			$i++;
		}
	}
	return $get_modules;
}

#exclude a item from a menu, and its children(items in submenu)
function DeleteMenuItem ($id)
{
	global $db;
	$query = "DELETE FROM menus_items WHERE id ='".$id."'";
	$db->query($query);
	#optimize table
	$query = "OPTIMIZE TABLE `menus_items`";
	$db->query($query);
	$query = "ALTER TABLE `menus_items` PACK_KEYS =0 CHECKSUM =0 DELAY_KEY_WRITE =0 AUTO_INCREMENT =1";
	$db->query($query);
	return '0';
}

function AddModuleToMenu ($menu_id, $module_id)
{
	global $db;
	$query = "SELECT name, link FROM modules WHERE id = '".$module_id."'";
	$db->query($query);
	$db->next_record();
	$name = $db->f('name');
	$link = $db->f('link');
	$query = "INSERT INTO menus_items (parent_menu,
																		 name,
																		 link,
																		 position,
																		 type)
														VALUES ('".intval($menu_id)."',
																		'".$name."',
																		'".$link."',
																		'".GetPositionIntoMenu($menu_id)."',
																		'module')";
	$db->query($query);
	return '0';
}

function GetPositionIntoMenu ($menu_id)
{
	global $db;
	$query = "SELECT position FROM menus_items
						WHERE parent_menu = '".$menu_id."'
						ORDER by position DESC LIMIT 1";
	$db->query($query);
	$db->next_record();
	return $db->f('position') + 10;
}

function GetPagesForMenu ($the_array)
{
	global $db;
	$query = "SELECT id, name, link FROM pages WHERE active = '1' AND sitemap = 'Y'";
	$get_pages = array();
	$db->query($query);
	$i = 0;
	while ($db->next_record())
	{
		if (!in_array($db->f('link'), $the_array))
		{
			$get_pages[$i]['id'] = $db->f('id');
			$get_pages[$i]['name'] = $db->f('name');
			$get_pages[$i]['link'] = $db->f('link');
			$i++;
		}
	}
	return $get_pages;
}

function AddPageToMenu ($menu_id, $page_id)
{
	global $db;
	$query = "SELECT name, link FROM pages WHERE id = '".$page_id."'";
	$db->query($query);
	$db->next_record();
	$name = $db->f('name');
	$link = $db->f('link');
	$query = "INSERT INTO menus_items (parent_menu,
																		 name,
																		 link,
																		 position,
																		 type)
														VALUES ('".intval($menu_id)."',
																		'".$name."',
																		'".$link."',
																		'".GetPositionIntoMenu($menu_id)."',
																		'page')";
	$db->query($query);
	return '0';
}

function GetItemsForParent ($item)
{
	global $db;
	$item = explode("_", $item);
	switch ($item['0'])
	{
		case 'page':
			$query = "SELECT link FROM pages WHERE id = '".$item['1']."'";
		break;

		case 'module':
			$query = "SELECT link FROM modules WHERE id = '".$item['1']."'";
		break;
	}
	$db->query($query);
	$db->next_record();
	$link = $db->f('link');
	$query = "SELECT * FROM menus_items WHERE parent_link = '".$link."' ORDER by position ASC";
	$db->query($query);
	$existent_items = array();
	$i = 0;
	while ($db->next_record())
	{
		$existent_items[$i]['id'] = $db->f('id');
		$existent_items[$i]['name'] = $db->f('name');
		$existent_items[$i]['link'] = $db->f('link');
		$existent_items[$i]['position'] = $db->f('position');
		$existent_items[$i]['type'] = $db->f('type');
		$i++;
	}
	return $existent_items;
}

function GetParentNameAndLink ($item)
{
	global $db;
	$item = explode("_", $item);
	switch ($item['0'])
	{
		case 'page':
			$query = "SELECT name, link FROM pages WHERE id = '".$item['1']."'";
		break;

		case 'module':
			$query = "SELECT name, link FROM modules WHERE id = '".$item['1']."'";
		break;
	}
	$db->query($query);
	$db->next_record();
	$parent['name'] = $db->f('name');
	$parent['link'] = $db->f('link');
	return $parent;
}

function AddModuleChild ($page_type, $id)
{
	global $db;
	$page_type = explode("_", $page_type);
	switch ($page_type['0'])
	{
		case 'page':
			$query = "SELECT link FROM pages WHERE id = '".$page_type['1']."'";
		break;

		case 'module':
			$query = "SELECT link FROM modules WHERE id = '".$page_type['1']."'";
		break;
	}
	$db->query($query);
	$db->next_record();
	$parent_link = $db->f('link');
	$query = "SELECT name, link FROM modules WHERE id = '".$id."'";
	$db->query($query);
	$db->next_record();
	$child_name = $db->f('name');
	$child_link = $db->f('link');
	#insert values
	$query = "INSERT INTO menus_items (parent_menu,
																		 name,
																		 link,
																		 parent_link,
																		 position,
																		 type)
															VALUES('2',
																		 '".$child_name."',
																		 '".$child_link."',
																		 '".$parent_link."',
																		 '".GetChildPosition($parent_link)."',
																		 'module')";
	$db->query($query);
	return '0';
}

function AddPageChild ($page_type, $id)
{
	global $db;
	$page_type = explode("_", $page_type);
	switch ($page_type['0'])
	{
		case 'page':
			$query = "SELECT link FROM pages WHERE id = '".$page_type['1']."'";
		break;

		case 'module':
			$query = "SELECT link FROM modules WHERE id = '".$page_type['1']."'";
		break;
	}
	$db->query($query);
	$db->next_record();
	$parent_link = $db->f('link');
	$query = "SELECT name, link FROM pages WHERE id = '".$id."'";
	$db->query($query);
	$db->next_record();
	$child_name = $db->f('name');
	$child_link = $db->f('link');
	#insert values
	$query = "INSERT INTO menus_items (parent_menu,
																		 name,
																		 link,
																		 parent_link,
																		 position,
																		 type)
															VALUES('2',
																		 '".$child_name."',
																		 '".$child_link."',
																		 '".$parent_link."',
																		 '".GetChildPosition($parent_link)."',
																		 'page')";
	$db->query($query);
	return '0';
}

function GetChildPosition ($parent_link)
{
	global $db;
	$query = "SELECT position FROM menus_items
						WHERE parent_link = '".$parent_link."'
						ORDER by position DESC LIMIT 1";
	$db->query($query);
	$db->next_record();
	return $db->f('position') + 10;
}

function DeleteSubmenuItem ($id)
{
	global $db;
	$query = "DELETE FROM menus_items WHERE id ='".$id."'";
	$db->query($query);
	#optimize table
	$query = "OPTIMIZE TABLE `menus_items`";
	$db->query($query);
	$query = "ALTER TABLE `menus_items` PACK_KEYS =0 CHECKSUM =0 DELAY_KEY_WRITE =0 AUTO_INCREMENT =1";
	$db->query($query);
	return '0';
}

#reorder and rearenge menus
function ReorderSubMenuItems ($id, $order_type)
{
	global $db;
	$query="SELECT position FROM menus_items WHERE `id`='".$id."'";
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
	UpdateSubMenuItemsOrder($id, $new_order);
}


function UpdateSubMenuItemsOrder ($id, $order_value)
{
	global $db;
	$query="UPDATE menus_items SET position = '".$order_value."'
					WHERE id='".$id."'";
	$db->query($query);
}

#it rearranges the order, after you do an reorder
function RearrangeSubMenuItems ($parent_link)
{
	global $db;
	$query="SELECT id FROM menus_items WHERE parent_link = '".$parent_link."'
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
		UpdateSubMenuItemsOrder($val, $i);
		$i+=10;
	}
}

function DeletePage ($id)
{
	global $db;
	#get the link of the page so we can delete the item from menus
	$query = "SELECT link FROM pages WHERE id = '".intval($id)."'";
	$db->query($query);
	$db->next_record();
	$query = "DELETE FROM menus_items WHERE link = '".$db->f('link')."'";
	$db->query($query);
	#optimeze table
	$query = "OPTIMIZE TABLE `menus_items`";
	$db->query($query);
	#delete from pages
	$query = "DELETE FROM pages WHERE id = '".intval($id)."'";
	$db->query($query);
	#optimeze pages table
	$query = "OPTIMIZE TABLE `pages`";
	$db->query($query);
}

function UpdatePage ($name, $meta_keywords, $meta_description, $status, $content, $id)
{
	global $db;
	$content = CleanImagePath($content);
	$query = "UPDATE pages SET name = '".$name."',
												 content = '".$content."',
												 meta_keywords = '".$meta_keywords."',
												 meta_description = '".$meta_description."',
												 active = '".$status."'
						WHERE id = '".$id."'";
	$db->query($query);
	#change the name of the menu items
	$query = "SELECT link FROM pages WHERE id = '".$id."'";
	$db->query($query);
	$db->next_record();
	$query = "UPDATE menus_items SET name = '".$name."' WHERE link = '".$db->f('link')."'";
	$db->query($query);
}

#../images/ becomes ./images/ so we can see the images in site's main pages situated in subfolder(site)
function CleanImagePath ($content)
{
	$cnt = str_replace("../images/", "./images/", $content);
	return $cnt;
}

#./images/ becomes ../images/ so the admin can see the images when editing an item using tinymce
function RestoreImagePath ($content)
{
	$cnt = str_replace("./images/", "../images/", $content);
	return $cnt;
}

# return date formatted fancy  N mean short format, Y long format
function AdminTimeFormat($date, $format='N')
{
	# display the time with or without hh mm ss
	global $conf;
	$diff = $conf->server_time * 3600;
	$times = strtotime($date) + $diff;
	if ($format == 'Y' )
	{
		$times = strftime($conf->time_format_short,$times);
	}
	else 
	{
		$times = strftime($conf->time_format_long,$times);
	}
	return $times;
}

function ListRobots ($page, $per_page, $bot_type)
{
	global $conf;
	$visit = array();
	$q_limit ='';
	$q_type = '';

	foreach(explode( "\n", $conf->search_engine_bots) as $bot )
	{
		list($ua, $n) = explode( "=", $bot );
		if ($ua and $n)
		{
			$bot_map[ strtolower($ua) ] = $n;
		}
	}
	global $db;
	if ($bot_type !='all')
	{
		$q_type = " WHERE bot = '$bot_type' ";
	}
	$start = $per_page*($page-1);

	$q_limit = " ORDER BY visit_date DESC LIMIT $start, $per_page ";
	$query = " SELECT * FROM log_spiders ".$q_type.$q_limit;
	$db->query($query);
	$i =0;
	while ($db->next_record())
	{
		$page = explode("=", $db->f("page"));
		if (isset($page[1]))
		{
			$visited_page = $page[1];
		}
		else 
		{
			$visited_page = 'index.php';
		}
		$visit[$i]['page'] = $visited_page;
		$visit[$i]['bot'] = $bot_map[strtolower($db->f("bot"))];
		$visit[$i]['visit_date'] = $db->f("visit_date");
		$visit[$i]['ip_address'] = $db->f("ip_address");
		$visit[$i]['user_agent'] = $db->f("user_agent");
		$i++;
	}
	return $visit;
}

#remove the PHPSESSID from url's
function CleanSessionUrl ($path)
{
	$cleaned = '';
	$original = explode("PHPSESSID", $path);
	$cleaned = $original['0'];
	return $cleaned;
}

#return a short version of user agent
function ShortUA ($ua)
{
	$short = explode("(", $ua);
	return $short[0];
}

function GetCurrentMenuItem ($module, $action)
{
	$selected_page = '2';//index page
	switch ($module)
	{
		case 'modules':
			switch ($action)
			{
				case 'list':
					$selected_page = '4';
				break;
			}
		break;

		case 'pages':
			switch ($action)
			{
				default :
					$selected_page = '8';//for edit and other actions
				break;
				case 'list':
					$selected_page = '8';
				break;
				case 'add':
					$selected_page = '9';
				break;
			}
		break;

		case 'menus'://posibly some more options is creating menu will be enabled
			$selected_page = '22';
		break;

		case 'cabinete':
			switch ($action)
			{
				default :
					if (intval($action))
					{
						$selected_page = '4';//when a module is selected to be edited
					}
					else 
					{
						$selected_page = '19';//for edit and other actions
					}
				break;
				case 'list':
					$selected_page = '19';
				break;
				case 'add':
					$selected_page = '20';
				break;
			}
		break;

		case 'news':
			switch ($action)
			{
				default :
					if ($action == "")
					{
						$selected_page = '4';//when a module is selected to be edited
					}
					else 
					{
						$selected_page = '13';//for edit and other actions
					}
				break;
				case 'list':
					$selected_page = '13';
				break;
				case 'add':
					$selected_page = '14';
				break;
			}
		break;

		case 'links':
			switch ($action)
			{
				default :
					if (intval($action))
					{
						$selected_page = '4';//when a module is selected to be edited
					}
					else 
					{
						$selected_page = '16';//for edit and other actions
					}
				break;
				case 'list':
					$selected_page = '16';
				break;
				case 'add':
					$selected_page = '17';
				break;
			}
		break;

		case 'contact':
			switch ($action)
			{
				default :
					if ($action == "")
					{
						$selected_page = '4';//when a module is selected to be edited
					}
					else 
					{
						$selected_page = '37';
					}
				break;

				case 'form':
					$selected_page = '38';
				break;

				case 'edit':
					$selected_page = '38';
				break;

				case 'add':
					$selected_page = '39';
				break;
			}
		break;

		case 'sitemap':
			$selected_page = '4';//when a module is selected to be edited
		break;

		case 'photos':
			switch ($action)
			{
				default :
					$selected_page = '11';
				break;

				case 'add':
					$selected_page = '27';
				break;
			}
		break;

		case 'settings':
			$selected_page = '29';
		break;

		case 'logins':
			$selected_page = '32';
		break;

		case 'admins':
			$selected_page = '33';
		break;

		case 'logo':
			$selected_page = '43';
		break;

		case 'users':
			switch ($action)
			{
				default :
					$selected_page = '45';
				break;

				case 'logins':
					$selected_page = '46';
				break;
			}
		break;
	}
	return $selected_page;
}


#home page statistics
function CountModules ()
{
	global $db;
	$query = "SELECT COUNT(id) AS total_modules FROM modules";
	$db->query($query);
	$db->next_record();
	return $db->f('total_modules');
}

function CountPages ()
{
	global $db;
	$query = "SELECT COUNT(id) AS total_pages FROM pages";
	$db->query($query);
	$db->next_record();
	return $db->f('total_pages');
}

function CountNews ()
{
	global $db;
	$query = "SELECT COUNT(id) AS total_news FROM news";
	$db->query($query);
	$db->next_record();
	return $db->f('total_news');
}

function CountLinks ()
{
	global $db;
	$query = "SELECT COUNT(id) AS total_links FROM links";
	$db->query($query);
	$db->next_record();
	return $db->f('total_links');
}

function GetConfVariables ()
{
	global $db;
	$query = "SELECT * FROM config WHERE editable = 'Y' ORDER by title ASC";
	$db->query($query);
	$conf_variables = array();
	$i = 0;
	while ($db->next_record())
	{
		$conf_variables[$i]['variable'] = $db->f('variable');
		$conf_variables[$i]['title'] = $db->f('title');
		$conf_variables[$i]['comment'] = $db->f('comment');
		$conf_variables[$i]['value'] = $db->f('value');
		$conf_variables[$i]['type'] = $db->f('type');
		$conf_variables[$i]['posible_values'] = $db->f('posible_values');
		$i++;
	}
	return $conf_variables;
}

function ListRobotsType ()
{
	global $conf;
	$robots = array();

	foreach( explode( "\n", $conf->search_engine_bots) as $bot )
	{
		list($ua, $n) = explode( "=", $bot );
		if ( $ua and $n )
		{
				//$robots[ strtolower($ua) ] = $n;
				$robots[$ua] = $n;
		}
	}

	return $robots;
}

function StatsCountRobots ($bot_type)
{
	$q_type = '';
	if ($bot_type !='all' )
	{
		$bot_type = trim($bot_type);
		$q_type = " WHERE bot= '$bot_type' ";
	}
	
	global $db;
	$query = " SELECT COUNT(id) As a FROM log_spiders".$q_type;
	
	$db->query($query);
	$db->next_record();
	$count = $db->f("a");
	return $count;
}
function DeleteBots($boot)
{
		global $db;
		$query = "DELETE FROM log_spiders WHERE bot = '".trim($boot)."'";
		$db->query($query);
}

function LastHitBot ($bot_type)
{
	global $cfg, $db;
	$last_hit ='';
	$query = " SELECT visit_date As a FROM log_spiders
						 WHERE bot = '$bot_type' 
						ORDER BY visit_date DESC LIMIT 0,1";
	$db->query($query);
	while ($db->next_record())
	{
		$last_hit	= $db->f("a");
	}
	return $last_hit;
}

function BotsPagination ($per_page, $totals, $link_page, $p)
{
	$html_pages = '';
	$start = ($p-1)*$per_page;
	$pages = ceil($totals/$per_page);
	#at least 2 pages
	if ($pages > 1 )
	{
		if (($p-1) > 0 )
		{
			$html_pages.="<a href=index.php?page=".$link_page."&p=1 class=\"pager\">&laquo; First </a>&nbsp;    ";
		}
		for($i = max(($p-10), 1); $i <= min(($p+10),$pages) ; $i++)
		{
			if ($p == $i)
			{
				$html_pages.= "[ <strong>".$i." </strong>]&nbsp;";
			}
			else 
			{
				$html_pages.="<a href=index.php?page=".$link_page."&p=".$i." class=\"pager\">".$i."</a>&nbsp;&nbsp;";
			}
		}
		if ($p < $pages)
		{
			$html_pages.=	" <a href=index.php?page=".$link_page."&p=".$pages." class=\"pager\">Last &raquo;</a>";
		}
	}
	return $html_pages;
}

#Count admin logins
function CountAdminLogins($admin_id)
{
	global $db;
	switch ($admin_id)
	{
		default :
			$query = "SELECT COUNT(id) As a FROM admin_login WHERE user_id = '".intval($admin_id)."'";
		break;

		case '-1':
			$query = "SELECT COUNT(id) As a FROM admin_login";
		break;
	}
	$db->query($query);
	$db->next_record();
	$reviews = $db->f("a");
	return $reviews;
}

#IP 2 country function, return an array with : short name, like 'ro' or 'us' and long name, like 'Romania'
function Ip2Country($ip)
{
	global $GEOIP_COUNTRY_NAMES;
	global $GEOIP_COUNTRY_CODES;
	$country = array();
	$country[0] = 'unknown';
	$country[1] = 'Unknown';
	$gi = geoip_open("../classes/admin/geoIp/GeoIP.dat",GEOIP_STANDARD);
	$country_code = geoip_country_code_by_addr($gi, $ip);
	geoip_close($gi);
	if($country_code)
	{
		$country_index = array_search($country_code, $GEOIP_COUNTRY_CODES);
		$country[0] = strtolower($country_code);
		$country[1] = $GEOIP_COUNTRY_NAMES[$country_index];
	}
	return $country;
}

#return the borwser icon
function GetBrowserIcon($agent)
{
	global $browsers_array;
	global $browsers_icons;
	for($i = 0; $i < count($browsers_array); $i++)
	{
		if (substr_count($agent,$browsers_array[$i]) > 0 )
		{
			$icon = $browsers_icons[$i]; 
		}
	}
	if (!isset($icon) )
	{
		$icon="netscape";
	}
	return $icon;
}

function GetAdmins ()
{
	global $db;
	$admins = array();
	$query = "SELECT * FROM admin_accounts";
	$db->query($query);
	$i = 0;
	while ($db->next_record())
	{
		$admins[$i]["id"] = $db->f("id");
		$admins[$i]["user"] = $db->f("user");
		$admins[$i]["email"] = $db->f("email");
		$admins[$i]["last_login"] = $db->f("last_login");
		$i++;
	}
	return $admins;
}

function CheckAdminUsername ($user)
{
	if (trim($user) == "")
	{
		return "Please provide a username !";
	}
	global $db;
	$query = "SELECT id FROM admin_accounts WHERE user = '".$user."'";
	$db->query($query);
	if ($db->num_rows() != "0")
	{
		return "Username already exists !";
	}
}

function InsertAdminAccount ($user, $pass, $email)
{
	global $db;
	$query = "INSERT into admin_accounts (user,
																				email,
																				pasw)
																VALUES ('".$user."',
																				'".$email."',
																				'".md5($pass)."')";
	$db->query($query);
}

function GetSelectedAdmin ($id)
{
	global $db;
	$query = "SELECT * FROM admin_accounts WHERE id = '".$id."'";
	$db->query($query);
	$admin = array();
	while ($db->next_record())
	{
		$admin['id'] = $db->f("id");
		$admin['user'] = $db->f("user");
		$admin['email'] = $db->f("email");
	}
	return $admin;
}

function SaveAdminChanges ($what, $content, $id)
{
	global $db;
	if($what=="pasw")
	{
		$query = "UPDATE admin_accounts SET pasw = '".md5($content)."' WHERE id = '".$id."'";
	}
	else
	{
		$query = "UPDATE admin_accounts SET ".$what." = '".$content."' WHERE id = '".$id."'";
	}
	
	$db->query($query);
}

function OldPassword ($id)
{
	global $db;
	$query = "SELECT pasw FROM admin_accounts WHERE id = '".$id."'";
	$db->query($query);
	$db->next_record();
	return $db->f("pasw");
}

function NewsletterAdresses ()
{
	global $db;
	$query = "SELECT email FROM newsletter WHERE newsletter = 'Y'";
	$db->query($query);
	$bcc = "";
	while ($db->next_record())
	{
		if (trim($bcc) != "")
		{
			$bcc = $bcc.", ";
		}
		$bcc = $bcc.$db->f("email");
	}
	return $bcc;
}

function GetModuleID ($module)
{
	global $db;
	$query = "SELECT id FROM modules WHERE link = '".$module."'";
	$db->query($query);
	$db->next_record();
	return $db->f("id");
}

#Check if pagetink is valid
function PageLinkIsInvalid ($link)
{
	if (trim($link) == "")
	{
		return false;//no characters
	}
	#check if alpha numeric
	if (eregi("[^a-zA-Z0-9-]", $link))
	{
		return false;
	}
	else 
	{
		return true;
	}
}

function LatestNews ()
{
	global $conf;
	$rss = new class_rss();
	$rss->rss_parse_feed_from_url($conf->xml_news_link);
	$latest_news = array();
	$i = 0;
	foreach ($rss->rss_channels as $channel_id => $channel_data)
	{
		foreach($rss->rss_items[$channel_id] as $item_id => $item_data)
		{
			foreach ($item_data as $key => $val)
			{
				$latest_news[$i][$key] = $val;
			}
			$i++;
		}
	}
	return $latest_news;
}

function AddMenuStaticLink ($name, $link, $target, $parent_menu, $parent_link)
{
	global $db;
	$query = "INSERT INTO menus_items (parent_menu,
																		 name,
																		 link,
																		 parent_link,
																		 position,
																		 type,
																		 target)
														VALUES ('".intval($parent_menu)."',
																		'".addslashes($name)."',
																		'".addslashes($link)."',
																		'".addslashes($parent_link)."',
																		'".GetPositionIntoMenu($parent_menu)."',
																		'external',
																		'".addslashes($target)."')";
	$db->query($query);
}

function SaveLogo ($file_extension)
{
	global $conf;
	global $db;
	$allowed_types = array("image/pjpeg", "image/jpeg", "image/png", "image/x-png", "image/gif");
	if(in_array($_FILES['logo']['type'], $allowed_types))
	{
		$filename = "logo.".$file_extension;
		$uploaddir = '../images/';
		$uploadfile = $uploaddir.$filename;
		#move the image
		if (move_uploaded_file($_FILES['logo']['tmp_name'], $uploadfile))
		{
			#change chmode so we cand delete next time
			chmod($uploadfile, 0777);
			#update logo value in config table
			SaveConfig("logo", $filename);
			#return txt msg 
			$result = 'Logo successfully changed !';
			$_SESSION['photos_style'] = "hint";
		}
		else
		{
			print "Possible file upload attack! Here's some debugging info:\n";
			echo '<pre>';
			print_r($_FILES);
			echo '</pre>';
		}
	}
	else 
	{
		#return txt msg 
		$result = 'The logo provided is not a valid image type !';
		$_SESSION['photos_style'] = "error";
	}
	return $result;
}

function GetAvailableCloneModules ($id)
{
	global $db;
	switch ($id)
	{
		default :
			$query = "SELECT * FROM available_modules WHERE id = '".$id."'";
		break;

		case '-1':
			$query = "SELECT * FROM available_modules WHERE status = '1'";
		break;
	}
	$db->query($query);
	$clones = array();
	$i = 0;
	while ($db->next_record())
	{
		$clones[$i]['id'] = $db->f('id');
		$clones[$i]['module_title'] = $db->f('module_title');
		$clones[$i]['module_link'] = $db->f('module_link');
		$i++;
	}
	return $clones;
}
*/

?>