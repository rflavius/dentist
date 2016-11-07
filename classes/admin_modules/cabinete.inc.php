<?php


/*
- Function used in : admin / cabinete.php
*/
function CategoryExists ($cat_name, $module_id)
{
	global $db;
	$query = "SELECT id_cat FROM cabinete_categories
						WHERE cat_name = '".addslashes($cat_name)."'
						AND parent_module = '".$module_id."'";
	$db->query($query);
	if ($db->num_rows() != '0')
	{
		return true;
	}
	else 
	{
		return false;
	}
}
/*
- Function used in : admin / cabinete.php
*/
function InsertCategory ($cat_name, $parent_module)
{
	global $db;
	$query ="Select code from judete where LOWER(name) = '".strtolower($cat_name)."'";
	$db->query($query);
	if($db->affected_rows()>0)
	{
		$db->next_record();
		$cat_code=$db->f('code');

	}
	else
	{
		$cat_code = " ";
	}
	$query = "INSERT into cabinete_categories(cat_name, parent_module,cat_code)
						VALUES ('".addslashes($cat_name)."', '".intval($parent_module)."','".$cat_code."')";
	$db->query($query);
	return '0';
}
/*
- Function used in : admin / cabinete.php
*/
function ChangeCategoryStatus ($new_status, $id)
{
	global $db;
	switch ($new_status)
	{
		case 'active':
			$status = 'Y';
		break;

		case 'inactive':
			$status = 'N';
		break;
	}
	$query = "UPDATE cabinete_categories SET active = '".$status."'
						WHERE id_cat = '".$id."'";
	$db->query($query);
	return '0';
}
/*
- Function used in : admin / cabinete.php
*/
function SaveCategory ($name,$meta_keywords,$meta_description, $id)
{
	global $db;
	$query = "UPDATE cabinete_categories SET cat_name = '".addslashes($name)."', meta_description='".$meta_description."',meta_keywords='".$meta_keywords."'
							WHERE id_cat = '".$id."'";
	$db->query($query);
	return 0;
}
/*
- Function used in : admin / cabinete.php
*/
function GetCategoryName ($id)
{
	global $db;
	$query = "SELECT cat_name FROM cabinete_categories
							WHERE id_cat = '".$id."'";
	$db->query($query);
	$db->next_record();
	return $db->f('cat_name');
}
/*
- Function used in : admin / cabinete.php
*/
function GetCabineteModules ()
{
	global $db;
	$mods = array();
	$query = "SELECT id, name FROM modules WHERE active = '1' AND support = 'cabinete'";
	$db->query($query);
	$i = 0;
	while ($db->next_record())
	{
		$mods[$i]['id'] = $db->f('id');
		$mods[$i]['name'] = $db->f('name');
		$i++;
	}
	return $mods;
}
/*
- Function used in : admin / cabinete.php
*/
function InsertCabinet ($cabinet_category, $title, $short_description, $content, $meta_keywords, $meta_description, $print)
{
	#insert into cabinete table the title and content
	global $db;
	$query = "INSERT into cabinete(title,
																 short_description,
																 content,
																 meta_keywords,
																 meta_description,
																 print,
																 submision_date)
													VALUES('".addslashes($title)."',
																 '".addslashes($short_description)."',
																 '".CleanImagePath(addslashes($content))."',
																 '".addslashes($meta_keywords)."',
																 '".addslashes($meta_description)."',
																 '".$print."',
																 now())";
	$db->query($query);
	$last_id = $db->last_insert_id();
	#see where the cabinet goes
	$parent = explode("_", $cabinet_category);
	$parent_mod = $parent['0'];
	$parent_id = $parent['1'];
	switch ($parent_mod)
	{
		#the cabinet has been inserted for a certain module
		case 'module':
			$query = "UPDATE cabinete SET parent_module = '".$parent_id."'
								WHERE id = '".$last_id."'";
			$db->query($query);
		break;
		#the cabinet has been inserted for a certain category under a module
		case 'category':
			$query = "INSERT into cabinete_cat(cabinet_id,
																				 cat_id)
																	VALUES('".$last_id."',
																				 '".$parent_id."')";
			$db->query($query);
		break;
	}
	return '0';
}

/*
- Function used in : admin / cabinete.php
*/
function ListAdminCabinete ($parent, $parent_id, $limit,$dispmode,$admin_level=false)
{
	global $db;
	global $conf;
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
	
	$displaymode = explode("-",$dispmode);
	$disp_type = $displaymode[0];
			
	$disp_what = $displaymode[1];
	$disp_how = $displaymode[2];
	switch($disp_type)
	{
		case 'data':
			$query_form = "ORDER by ".$disp_what." ".$disp_how;
		break;
		
		case 'vizite':
			$query_form = "ORDER by ".$disp_what." ".$disp_how;
		break;
		
		case 'accesaritel':
			$query_form = "ORDER by ".$disp_what." ".$disp_how;
		break;
		
		case 'status':
				$query_form="";
		break;


	}

	switch ($parent)
	{
		case '-1':
			$query = "SELECT * FROM cabinete ".$extra_sql.' '.$query_form." ".$limit;
		break;

		case 'category':
			$query = "SELECT A.*, B.* FROM cabinete A, cabinete_cat B
								WHERE B.cat_id = '".$parent_id."'
								AND A.id = B.cabinet_id ".$extra_sql.$query_form." ".$limit;
		break;

		case 'module':
			$query = "SELECT * FROM cabinete
								WHERE category_id = '".$parent_id."' ".$extra_sql.$query_form." ".$limit;;
		break;
	}
	$db->query($query);
	$i = 0; $cabinete = array();
	while ($db->next_record())
	{
		$cabinete[$i]['id'] = $db->f('id');
		$cabinete[$i]['nume_firma'] = $db->f('nume_firma');
		$cabinete[$i]['user_id'] = $db->f('user_id');
		$cabinete[$i]['nume_loc_sector'] = $db->f('nume_loc_sector');
		$cabinete[$i]['submision_date'] = AdminTimeFormat($db->f('submision_date'),'Y');
		$cabinete[$i]['data_modificarii'] = AdminTimeFormat($db->f('data_modificarii'),'Y');
		$cabinete[$i]['status'] = $db->f('status');
		$cabinete[$i]['comment'] = $db->f('comment');
		$cabinete[$i]['judet'] = $db->f('judet');
		$cabinete[$i]['level'] = $db->f('level');
		$cabinete[$i]['recomandata'] = $db->f('recomandata');
		$cabinete[$i]['category_id'] = $db->f('category_id');
		$cabinete[$i]['adresa_firma'] = $db->f('adresa_firma');
		$cabinete[$i]['pers_contact'] = $db->f('pers_contact');
		$cabinete[$i]['emailplata'] = $db->f('emailplata');
		$cabinete[$i]['contactat'] = $db->f('contactat');
		$cabinete[$i]['admin_id'] = $db->f('admin_id');
		$cabinete[$i]['phone_views'] = $db->f('phone_views');
		$cabinete[$i]['nr_visits'] = $db->f('nr_visits');
		$cabinete[$i]['telefon'] = $db->f('fax');
		
		$cabinete[$i]['email'] = $db->f('email_firma');
		if($db->f('persc_email')!="" &&  $db->f('email_firma')!=$db->f('persc_email'))
		{
			$cabinete[$i]['email'] = $db->f('email_firma')."<br>".$db->f('persc_email');
		}
		$i++;
	}
	return $cabinete;
}

function ListAdminCabinete2 ($parent, $parent_id, $limit,$dispmode)
{
	global $db;
	global $conf;

	$displaymode = explode("-",$dispmode);
	$disp_type = $displaymode[0];
			
	$disp_what = $displaymode[1];
	$disp_how = $displaymode[2];
	switch($disp_type)
	{
		case 'data':
			$query_form = "ORDER by ".$disp_what." ".$disp_how;
		break;
		
		case 'vizite':
			$query_form = "ORDER by ".$disp_what." ".$disp_how;
		break;
		
		case 'status':
				$query_form="";
		break;


	}

	switch ($parent)
	{
		case '-1':
			$query = "SELECT * FROM cabinete WHERE `user_id`<>'-1' ".$query_form." ".$limit;
		break;

		case 'category':
			$query = "SELECT A.*, B.* FROM cabinete A, cabinete_cat B
								WHERE B.cat_id = '".$parent_id."'
								AND A.id = B.cabinet_id ".$query_form." ".$limit;
		break;

		case 'module':
			$query = "SELECT * FROM cabinete
								WHERE category_id = '".$parent_id."' ".$query_form." ".$limit;;
		break;
	}
	$db->query($query);
	$i = 0; $cabinete = array();
	while ($db->next_record())
	{
		$cabinete[$i]['id'] = $db->f('id');
		$cabinete[$i]['nume_firma'] = $db->f('nume_firma');
		$cabinete[$i]['user_id'] = $db->f('user_id');
		$cabinete[$i]['nume_loc_sector'] = $db->f('nume_loc_sector');
		$cabinete[$i]['submision_date'] = AdminTimeFormat($db->f('submision_date'),'Y');
		$cabinete[$i]['data_modificarii'] = AdminTimeFormat($db->f('data_modificarii'),'Y');
		$cabinete[$i]['status'] = $db->f('status');
		$cabinete[$i]['comment'] = $db->f('comment');
		$cabinete[$i]['judet'] = $db->f('judet');
		$cabinete[$i]['level'] = $db->f('level');
		$cabinete[$i]['recomandata'] = $db->f('recomandata');
		$cabinete[$i]['category_id'] = $db->f('category_id');
		$cabinete[$i]['adresa_firma'] = $db->f('adresa_firma');
		$cabinete[$i]['pers_contact'] = $db->f('pers_contact');
		$cabinete[$i]['emailplata'] = $db->f('emailplata');
		$cabinete[$i]['contactat'] = $db->f('contactat');

		$cabinete[$i]['nr_visits'] = $db->f('nr_visits');
		$cabinete[$i]['telefon'] = $db->f('fax');
		
		$cabinete[$i]['email'] = $db->f('email_firma');
		if($db->f('persc_email')!="" &&  $db->f('email_firma')!=$db->f('persc_email'))
		{
			$cabinete[$i]['email'] = $db->f('email_firma')."<br>".$db->f('persc_email');
		}
		$i++;
	}
	return $cabinete;
}

/*
- Function used in : admin / cabinete.php
*/
function GetCabinetParents ($cabinet_id)
{
	global $db;
	$query = "SELECT parent_module FROM cabinete WHERE id = '".$cabinet_id."'";
	$db->query($query);
	$db->next_record();
	if ($db->f('parent_module') != '0')//cabinet is child of module
	{
		return GetNameOfParent('module', $db->f('parent_module'));
	}
	else//cabinet is child of category
	{
		$query = "SELECT cat_id FROM cabinete_cat WHERE cabinet_id = '".$cabinet_id."'";
		$db->query($query);
		$db->next_record();
		return GetNameOfParent('category', $db->f('cat_id'));
	}
}
/*
- Function used in : admin / cabinete.php
*/
function ChangeCabinetStatus ($new_status, $id)
{
	global $db;
	switch ($new_status)
	{
		case 'active':
		$status = '1';
		#let's check if he has at least one image and the position to an image must be 1, other wise we insert the defalult.jpg
		$query = "Select id,position from images where folder_id='".$id."'";
		$db->query($query);
		if($db->affected_rows()<1)
		{
				$query = "INSERT into images(position,image_name,folder_id,status,type)
									VALUES('1','default.jpg','".$id."','Y','cabinet')";
				$db->query($query);
		}
		else
		{	
			#if we have images, but no image has position 1 set it the first inserted to data base
			$db->next_record();
			if($db->f('position')=='0')
			{
				$query = "UPDATE images SET position = '1'
						WHERE id = '".$db->f('id')."'";
				//echo $query;
				$db->query($query);
			}
		}
		break;

		case 'inactive':
			$status = '0';
		break;
	}
	$query = "UPDATE cabinete SET status = '".$status."'
						WHERE id = '".$id."'";
	$db->query($query);
	return '0';
}

function ChangeCabinetStatus2 ($new_status, $id)
{
	global $db;
	switch ($new_status)
	{
		case 'active':
			$status = 'Y';
		break;

		case 'inactive':
			$status = 'N';
		break;
	}
	$query = "UPDATE cabinete SET `emailplata` = '".$status."'
						WHERE id = '".$id."'";
	$db->query($query);
	return '0';
}


/*
- Function used in : admin / cabinete.php
*/
function UpdateCabinet ($cabinet_category, $title, $content, $id, $short_description, $meta_keywords, $meta_description, $print)#, $dwd_pdf, $email_to_friend)
{
	#insert into cabinete table the title and content
	global $db;
	$query = "UPDATE cabinete SET title = '".addslashes($title)."',
																short_description = '".addslashes($short_description)."',
																content = '".CleanImagePath(addslashes($content))."',
																meta_keywords = '".addslashes($meta_keywords)."',
																meta_description = '".addslashes($meta_description)."',
																print = '".$print."',
																parent_module = '0'
						WHERE id = '".$id."'";
	$db->query($query);
	#see where the cabinet goes
	$parent = explode("_", $cabinet_category);
	$parent_mod = $parent['0'];
	$parent_id = $parent['1'];
	switch ($parent_mod)
	{
		#the cabinet has been inserted for a certain module
		case 'module':
			$query = "UPDATE cabinete SET parent_module = '".$parent_id."'
								WHERE id = '".$id."'";
			$db->query($query);
			$query = "DELETE FROM cabinete_cat WHERE cabinet_id = '".$id."'";
			$db->query($query);
		break;
		#the cabinet has been inserted for a certain category under a module
		case 'category':
			$query = "DELETE FROM cabinete_cat WHERE cabinet_id = '".$id."'";
			$db->query($query);
			$query = "INSERT into cabinete_cat(cabinet_id,
																				 cat_id)
																	VALUES('".$id."',
																				 '".$parent_id."')";
			$db->query($query);
		break;
	}
	return '0';
}

function GetIdCatForCabinet($id_cab)
{
	global $db;
	$query="Select * from cabinete_cat where cabinet_id='".$id_cab."'";
	$db->query($query);
	$db->next_record();
	return $db->f('cat_id');
}




function GetContractForCabinet($id)
{
	global $db;
	$query = "SELECT * FROM contracte Where firma_id='".$id."'";
	$db->query($query);
	if($db->affected_rows()>0)
	{
		$db->next_record();
		return $db->f('id');
	}
	else
	{
		return "none";
	}
}


 function CountCabineteCauta ($list_by,$value)
{
	global $db;
	$what = $list_by;
	$query = "SELECT COUNT(id) as total_cabinete FROM cabinete where ".$what." = '".addslashes($value)."'";		
	$db->query($query);
	$db->next_record();
	return $db->f("total_cabinete");
}
function GetCabineteCauta($what_search, $value, $query_limit)
{
	global $db;
	$what = $what_search;
	$query = "SELECT * FROM cabinete where ".$what." LIKE '%".addslashes($value)."%' Order by submision_date DESC ".$query_limit;			

	$db->query($query);
	$cabinete = array();
	$i = 0;
	while ($db->next_record())
	{
		$cabinete[$i]['id'] = $db->f('id');
		$cabinete[$i]['nume_firma'] = $db->f('nume_firma');
		$cabinete[$i]['user_id'] = $db->f('user_id');
		$cabinete[$i]['nume_loc_sector'] = $db->f('nume_loc_sector');
		$cabinete[$i]['submision_date'] = AdminTimeFormat($db->f('submision_date'),'Y');
		$cabinete[$i]['data_modificarii'] = AdminTimeFormat($db->f('data_modificarii'),'Y');
		$cabinete[$i]['status'] = $db->f('status');
		$cabinete[$i]['comment'] = $db->f('comment');
		$cabinete[$i]['judet'] = $db->f('judet');
		$cabinete[$i]['level'] = $db->f('level');
		$cabinete[$i]['recomandata'] = $db->f('recomandata');
		$cabinete[$i]['category_id'] = $db->f('category_id');
		$cabinete[$i]['emailplata'] = $db->f('emailplata');

		$cabinete[$i]['nr_visits'] = $db->f('nr_visits');
		$cabinete[$i]['telefon'] = $db->f('fax');
		
		$cabinete[$i]['email'] = $db->f('email_firma');
		$cabinete[$i]['admin_id'] = $db->f('admin_id');
		if($db->f('persc_email')!="" &&  $db->f('email_firma')!=$db->f('persc_email'))
		{
			$cabinete[$i]['email'] = $db->f('email_firma')."<br>".$db->f('persc_email');
		}
		$i++;
	}
	return $cabinete;
}
#frontend too

function CountCabineteRecomandateTotalRecords ($parent, $parent_id)
{
	global $db;
	switch ($parent)
	{
		case 'category':
			$query = "SELECT A.id , B.*
								FROM cabinete A, cabinete_cat B
								WHERE a.recomandata='Y' and B.cat_id = '".$parent_id."'
								AND A.id = B.cabinet_id ";
		break;

		case 'module':
			$query = "SELECT id FROM cabinete
			WHERE recomandata='Y' and category_id = '".$parent_id."'";
		break;

		case '-1':
			$query = "SELECT id FROM cabinete WHERE recomandata='Y'";
		break;
	}
	$db->query($query);
	return $db->num_rows();
}
function ListAdminCabineteRecomandate ($parent, $parent_id, $limit,$dispmode)
{
	global $db;
	global $conf;

	$displaymode = explode("-",$dispmode);
	$disp_type = $displaymode[0];
			
	$disp_what = $displaymode[1];
	$disp_how = $displaymode[2];
	switch($disp_type)
	{
		case 'data':
			$query_form = "ORDER by ".$disp_what." ".$disp_how;
		break;
		
		case 'vizite':
			$query_form = "ORDER by ".$disp_what." ".$disp_how;
		break;
		
		case 'status':
				$query_form="";
		break;


	}

	switch ($parent)
	{
		case '-1':
			$query = "SELECT A.*,B.date_exp FROM cabinete A,recomandate B Where A.recomandata='Y' and A.id = B.firma_id  ".$query_form." ".$limit;
		break;

		case 'category':
			$query = "SELECT A.*, B.*, C.* FROM cabinete A, cabinete_cat B, recomandate C
								WHERE A.recomandata='Y'  and B.cat_id = '".$parent_id."'
								AND A.id = B.cabinet_id ".$query_form." ".$limit;
		break;

		case 'module':
			$query = "SELECT A.*,B.* FROM cabinete A,recomandate B
								WHERE A.recomandata='Y'  and A.category_id = '".$parent_id."' ".$query_form." ".$limit;;
		break;
	}
	$db->query($query);
	$i = 0; $cabinete = array();
	while ($db->next_record())
	{
		$cabinete[$i]['id'] = $db->f('id');
		$cabinete[$i]['nume_firma'] = $db->f('nume_firma');
		$cabinete[$i]['user_id'] = $db->f('user_id');
		$cabinete[$i]['nume_loc_sector'] = $db->f('nume_loc_sector');
		$cabinete[$i]['submision_date'] = AdminTimeFormat($db->f('submision_date'),'Y');
		$cabinete[$i]['data_modificarii'] = AdminTimeFormat($db->f('data_modificarii'),'Y');
		$cabinete[$i]['status'] = $db->f('status');
		$cabinete[$i]['comment'] = $db->f('comment');
		$cabinete[$i]['judet'] = $db->f('judet');
		$cabinete[$i]['judet'] = $db->f('judet');
		$cabinete[$i]['recomandata'] = $db->f('recomandata');
		$cabinete[$i]['category_id'] = $db->f('category_id');
		$cabinete[$i]['nr_visits'] = $db->f('nr_visits');
		$i++;
	}//	print_r($cabinete);
	return $cabinete;

}

function GetCabinetForPromotion($module,$category)
{
	global $db;
	global $conf;
	$query =	"SELECT *
				FROM cabinete 
				Where category_id = '".$module."' and judet='".$category."' and recomandata='N' and done='N'
				ORDER by submision_date DESC limit 1";
		
	$db->query($query);
	$cabinet = array();
	$db->next_record();
	
	$cabinet['id'] = $db->f('id');
	$cabinet['nume_firma'] = $db->f('nume_firma');
	$cabinet['pers_contact'] = strip_tags($db->f('pers_contact'));
	$cabinet['judet'] = $db->f('judet');
	$cabinet['persc_email'] = $db->f('persc_email');
	$cabinet['email_firma'] = $db->f('email_firma');
	$cabinet['submision_date'] = TimeFormatShort($db->f('submision_date'));

	return $cabinet;
}

function Update_Image_Name_Cabinete($id_cabinet,$id_imagine,$image_name,$old_img_name)
{
	global $db;
	
	#let's rename the small images too
	$old_picture = '../images/smallimages/cabinete/'.$old_img_name;
	$new_pict = '../images/smallimages/cabinete/'.$image_name;
	$response = rename($old_picture,$new_pict);

	#let's rename the small images too
	$old_picture = '../images/smallimages/cabinete/'.$id_cabinet.'/'.$old_img_name;
	$new_pict = '../images/smallimages/cabinete/'.$id_cabinet.'/'.$image_name;
	$response = rename($old_picture,$new_pict);

	#we have to rename the file name
	$old_picture = '../images/users_cabinete/'.$id_cabinet.'/'.$old_img_name;
	$new_pict = '../images/users_cabinete/'.$id_cabinet.'/'.$image_name;
	$response = rename($old_picture,$new_pict);


	if ($response)
	{
		#we update the db
		$sql =  "Update images Set image_name='".$image_name."' where id='".$id_imagine."'";
		$db->query($sql);
	}
	return 1;
}


function  MakeFirstImmage($id_cabinet)
{
	
}

function getCabinetDetails($id)
{
	global $db;
	$expected = array('id', 'user_id', 'category_id', 'nume_firma', 'adresa_firma', 'judet', 'nume_loc_sector', 'fax', 'echipa_medicala', 'email_firma', 'adresa_web', 'orar', 'descriere', 'tarife', 'pers_contact', 'persc_email', 'persc_tel', 'persc_adresa', 'zip_code', 'submision_date', 'status', 'meta_keywords', 'meta_description', 'parent_module', 'expire_date', 'alias', 'nr_visits', 'ahref_title', 'data_modificarii', 'comment', 'recomandata', 'done', 'inreg_fiscala_cnp', 'reg_comert_bi', 'type', 'perioada', 'emailplata','level');

	$sql = "SELECT * FROM cabinete WHERE `id`='$id'";
	$db->query($sql);
	while($db->next_record())
	{
		foreach($expected as $ky)
		{
			$info[$ky] = $db->f($ky);
		}
		$info['telefon'] = $db->f('fax');
		
		$info['email'] = $db->f('email_firma');
		if($db->f('persc_email')!="" &&  $db->f('email_firma')!=$db->f('persc_email'))
		{
			$info['email'] = $db->f('email_firma')."<br>".$db->f('persc_email');
		}
	}
	return $info;
}

function getCabinetCategory($cat)
{
	global $db;
	$sql = "SELECT name FROM dentist_categories WHERE id='$cat'";
	$db->query($sql);
	$db->next_record();
	return $db->f('name');
}

function countCabinetMessages($cab)
{
	global $db;
	$sql = "SELECT id FROM mesaje_utilizator WHERE id_cabinet='$cab'";
	$db->query($sql);
	return $db->num_rows();
}

function countMarketingContacts($admin_id,$type,$parent,$parent_id)
{
	global $db;
	if($type!="")
	{
		$sql = "SELECT id FROM cabinete_marketing WHERE `admin_id`='$admin_id' AND `revin`!='0000-00-00' ORDER BY `revin` ASC";
	}
	else
	{
		$sql = "SELECT id FROM cabinete_marketing WHERE `admin_id`='$admin_id'";
	}
	
	switch ($parent)
	{
		case 'category':
			$sql = "SELECT a.id FROM cabinete_cat b, cabinete_marketing a
							WHERE a.cabinet_id = b.cabinet_id AND a.admin_id = '$admin_id' AND b.cat_id = '".$parent_id."'";
		break;
	
		case 'module':
			$sql = "SELECT a.id FROM cabinete_marketing as a,cabinete as b
							WHERE a.cabinet_id = b.id AND a.admin_id = '$admin_id' AND b.category_id = '".$parent_id."'";
		break;
	
		case '-1':
			$sql = "SELECT id FROM cabinete_marketing WHERE admin_id='$admin_id'";
		break;
	}
	
	
	$db->query($sql);
	return $db->num_rows();
}

function listMarketingContacts($admin_id,$type,$limit,$parent,$parent_id)
{
	global $db;
	if($type!="")
	{
		$sql = "SELECT * FROM cabinete_marketing WHERE `admin_id`='$admin_id'  AND `revin`!='0000-00-00' ORDER BY `revin` ASC ".$limit;
	}
	else
	{
		$sql = "SELECT * FROM cabinete_marketing WHERE `admin_id`='$admin_id' ORDER BY date DESC ".$limit;
	}
	
	switch ($parent)
	{
		case '-1':
			$sql = "SELECT * FROM cabinete_marketing WHERE admin_id='$admin_id' ".$limit;
		break;
	
		case 'category':
			$sql = "SELECT a.* FROM cabinete_marketing a, cabinete_cat b
								WHERE b.cat_id = '".$parent_id."'
								AND a.cabinet_id = b.cabinet_id AND a.admin_id = '".$admin_id."'".$limit;
		break;
	
		case 'module':
			$sql = "SELECT a.* FROM cabinete_marketing as a, cabinete as b
								WHERE b.category_id = '".$parent_id."' AND a.cabinet_id = b.id AND a.admin_id='".$admin_id."'".$limit;;
		break;
	}
	$db->query($sql);
	if($db->num_rows()>0)
	{
		$i=0;
		while($db->next_record())
		{
			$info[$i]['id'] = $db->f('id');
			$info[$i]['cabinet_id'] = $db->f('cabinet_id');
			$info[$i]['date'] = $db->f('date');
			$info[$i]['comments'] = $db->f('comments');
			$info[$i]['revin'] = $db->f('revin');
			$info[$i]['email_oferta'] = $db->f('email_oferta');
			$i++;
		}
		return $info;
	}
	else
	{
		return '';
	}
}

function getMarketingContactDetails($id)
{
	global $db;
	$sql = "SELECT * FROM cabinete_marketing WHERE `id`='$id' ";
	$db->query($sql);
	if($db->num_rows()>0)
	{
		$i=0;
		while($db->next_record())
		{
			$info['id'] = $db->f('id');
			$info['cabinet_id'] = $db->f('cabinet_id');
			$info['date'] = $db->f('date');
			$info['comments'] = $db->f('comments');
		}
	}
		return $info;
}

function getBilant($admin_id,$start,$end)
{
	global $db;
	if($end!="")
	{
		$s = "AND `adaugare_proforma`<='$end' ";
	}
	else
	{
		$s="";
	}
	$sql = "SELECT * FROM facturi_proforme WHERE `admin_id`='$admin_id' AND `adaugare_proforma`>='$start' ".$s." ORDER BY `adaugare_proforma` ASC";
	$db->query($sql);
	if($db->num_rows()>0)
	{
		$i=0;
		while($db->next_record())
		{
			$info[$i]['id'] = $db->f('id');
			$info[$i]['user_id'] = $db->f('user_id');
			$info[$i]['firma_id'] = $db->f('firma_id');
			$info[$i]['cost'] = $db->f('cost');
			$info[$i]['adaugare_proforma'] = $db->f('adaugare_proforma');
			$info[$i]['tip_promovare'] = $db->f('tip_promovare');
			$i++;
		}
		return $info;
	}
	else
	{
		return '';
	}
}

function sendPromovareEmail($id)
{
	global $db, $conf;
	$text = GetFileContent('../templates/emails/special_email.tpl');
	$cabInfo = getCabinetDetails($id);
	$text = str_replace("%START_DATE%", TimeFormatShort($cabInfo['submision_date']), $text);
	$text = str_replace("%CABINET%", $cabInfo['nume_firma'], $text);
	
	$pachete = new Pachete_Servicii($db);
	$pk = array('1','2','6');
	foreach($pk as $ky=>$val)
	{
		$servicii = $pachete->listPachetServicii($val);
		$serv = '';
		foreach($servicii as $ky2=>$val2)
		{
			$serv.=$val2['name'].'\n'.$val2['description'].'\n\n';
		}
		
		if($ky==1)
		{
			$text = str_replace("%BASIC_SERVICII%", $serv, $text);
		}
		elseif($ky==2)
		{
			$text = str_replace("%BUSINESS_SERVICII%", $serv, $text);
		}
		elseif($ky==6)
		{
			$text = str_replace("%PREMIUM_SERVICII%", $serv, $text);
		}
	}
	
	$Sender = $conf->contact_recipient;
	$Recipiant = $_POST['email'];
	$CustomHeaders = '';
	#send text email
	$Subject = 'Oferta promovare';
	$message = new Email($Recipiant, $Sender, $Subject, $CustomHeaders);
	$message->SetTextContent($text);
	if (ValidHeader($Sender))
	{
		$message->Send();
	}
	$sql = "UPDATE cabinete_marketing SET email_oferta='Y' WHERE cabinet_id='$id'";
	$db->query($sql);
}




?>