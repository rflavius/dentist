<?php
#- Function used in : admin / articles.php
	function AnunturiCategoryExists ($cat_name)
	{
		global $db;
		$query = "SELECT id_cat FROM anunturi_categories
							WHERE cat_name = '".addslashes($cat_name)."'";
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

	#- Function used in : admin / articles.php

function SaveAnunturiCategory ($name,$meta_key,$meta_desc, $id)
{
	global $db;
	$alias = GenerateAlias($name);
	$query = "UPDATE anunturi_categories SET cat_name = '".addslashes($name)."',meta_keywords='".addslashes($meta_key)."',meta_description='".addslashes($meta_desc)."',alias='".addslashes($alias)."'
							WHERE id_cat = '".$id."'";
	$db->query($query);
	return 0;
}


	#- Function used in : admin / articles.php
function InsertAnunturiCategory ($cat_name,$meta_key,$meta_desc)
{
	global $db;
	$alias = GenerateAlias($cat_name);
	$query = "INSERT into anunturi_categories(cat_name, meta_keywords,meta_description,alias)
						VALUES ('".addslashes($cat_name)."','".addslashes($meta_key)."','".addslashes($meta_desc)."','".addslashes($alias)."')";
	$db->query($query);
	return '0';
}
function Update_Image_Name_Anunturi($id_anunt,$image_name,$old_img_name)
{
	global $db;
	
	#we have to rename the file name
	$old_picture = '../images/users_anunturi/'.$old_img_name;
	$new_pict = '../images/users_anunturi/'.$image_name;
	$response = rename($old_picture,$new_pict);
	
	if ($response)
	{
		#we update the db
		$sql =  "Update anunturi Set imagine='".$image_name."' where id='".$id_anunt."'";
		$db->query($sql);
	}
	return 1;
}



function GetAnunturiByCat($cat,$status,$dispmode,$limit)
{
	global $db;
	$get_info = array();$i = 0;
	$stat ="";
	
	$displaymode = explode("-",$dispmode);
	$disp_type = $displaymode[0]; //data,status,vizite
	$disp_what = $displaymode[1];//data_adaugari,nr_visits
	$disp_how = $displaymode[2];//ASC,DESC
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
	switch ($cat)
	{
		default:
			if($status!="all")
			{	$stat ="and status='".$status."'"; }

			$query = "SELECT * FROM anunturi WHERE bigcat_id = '".$cat."' ".$stat."  ".$query_form." ".$limit;
		break;
		case 'all':
			if($status!="all")
			{	$stat ="WHERE status='".$status."'";	}
			$query = "SELECT * FROM anunturi ".$stat."  ".$query_form." ".$limit;
		break;
	}

	$db->query($query);
	while ($db->next_record())
	{
		$get_info[$i]['id'] = $db->f('id');
		$get_info[$i]['titlu'] = $db->f('titlu');
		$get_info[$i]['imagine'] = $db->f('imagine');
		$get_info[$i]['data_adaugarii'] = $db->f('data_adaugarii');
		$get_info[$i]['data_expirarii'] = $db->f('data_expirarii');
		$get_info[$i]['data_modificarii'] = $db->f('data_modificarii');
		$get_info[$i]['user_id'] = $db->f('user_id');
		$get_info[$i]['email'] = $db->f('email');
		$get_info[$i]['bigcat_id'] = $db->f('bigcat_id');
		$get_info[$i]['autor'] = $db->f('autor');
		$get_info[$i]['meta_keywords'] = $db->f('meta_keywords');
		$get_info[$i]['meta_description'] = $db->f('meta_description');
		$get_info[$i]['judet'] = $db->f('judet');
		$get_info[$i]['comments'] = $db->f('comments');
		$get_info[$i]['localitate'] = $db->f('localitate');
		$get_info[$i]['continut'] = $db->f('continut');
		$get_info[$i]['status'] = $db->f('status');
		$get_info[$i]['nr_visits'] = $db->f('nr_visits');
		$i++;
	}

	return $get_info;

}
function GetRecomandateAnunturiByCat($cat,$status,$dispmode,$limit)
{
	global $db;
	$get_info = array();$i = 0;
	$stat ="";
	
	$displaymode = explode("-",$dispmode);
	$disp_type = $displaymode[0]; //data,status,vizite
	$disp_what = $displaymode[1];//data_adaugari,nr_visits
	$disp_how = $displaymode[2];//ASC,DESC
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
	switch ($cat)
	{
		default:
			if($status!="all")
			{	$stat ="and t1.show_first_page='".$status."'"; }

			//$query = "SELECT * FROM anunturi WHERE bigcat_id = '".$cat."' ".$stat."  ".$query_form." ".$limit;
			
			$query = "SELECT t1.*,t2.user_id,t2.level,t2.status FROM anunturi as t1,cabinete as t2 WHERE t1.bigcat_id='".$cat." and t1.user_id=t2.user_id and t2.level>'1' and t2.level <> '22' ".$stat." and t1.imagine!='default.jpg'".$query_form." ".$limit;
		break;

		case 'all':
			if($status!="all")
			{	$stat ="and t1.show_first_page='".$status."'";	}

			//$query = "SELECT * FROM anunturi ".$stat."  ".$query_form." ".$limit;
			
			$query = "SELECT t1.*,t2.user_id,t2.level,t2.status FROM anunturi as t1,cabinete as t2 WHERE t1.user_id=t2.user_id and t2.level>'1' and t2.level <> '22' and t1.imagine!='default.jpg' ".$stat."  ".$query_form." ".$limit;
		break;
	}

	$db->query($query);
	while ($db->next_record())
	{
		$get_info[$i]['id'] = $db->f('id');
		$get_info[$i]['titlu'] = $db->f('titlu');
		$get_info[$i]['imagine'] = $db->f('imagine');
		$get_info[$i]['data_adaugarii'] = $db->f('data_adaugarii');
		$get_info[$i]['data_expirarii'] = $db->f('data_expirarii');
		$get_info[$i]['data_modificarii'] = $db->f('data_modificarii');
		$get_info[$i]['show_first_page'] = $db->f('show_first_page');
		$get_info[$i]['user_id'] = $db->f('user_id');
		$get_info[$i]['email'] = $db->f('email');
		$get_info[$i]['bigcat_id'] = $db->f('bigcat_id');
		$get_info[$i]['autor'] = $db->f('autor');
		$get_info[$i]['meta_keywords'] = $db->f('meta_keywords');
		$get_info[$i]['meta_description'] = $db->f('meta_description');
		$get_info[$i]['judet'] = $db->f('judet');
		$get_info[$i]['comments'] = $db->f('comments');
		$get_info[$i]['localitate'] = $db->f('localitate');
		$get_info[$i]['continut'] = $db->f('continut');
		$get_info[$i]['status'] = $db->f('status');
		$get_info[$i]['nr_visits'] = $db->f('nr_visits');
		$i++;
	}

	return $get_info;

}

function GetAnuntTitle ($id)
{
	global $db;
	$query = "SELECT titlu FROM anunturi
						WHERE id = '".intval($id)."'";
	$db->query($query);
	$db->next_record();
	$title = ShortVersionOfString($db->f('titlu'), '50');
	return $title;
}

?>