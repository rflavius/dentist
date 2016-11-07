<?php
function CountDictionaryTotalRecordsUsers ($cat_id, $status)
{
	global $db;
	if($status!="all")
	{
		$status_q="and status = '".$status."'";
	}
	else
	{
		$status_q="";
	}

	switch ($cat_id)
	{
		case 'all':
			if($status_q!="")
			{
					$status_q="and status = '".$status."' ";
			}
		$query = "SELECT id FROM dictionary  where user_id!='-1' ".$status_q."  ";
		break;
		
		default:
			$query = "SELECT id FROM dictionary
											WHERE bigcat_id = '".$cat_id."' ".$status_q." and user_id!='-1'";
		break;
	
	}
	$db->query($query);
	return $db->num_rows();
}

function ChangeDictionaryCategoryStatus ($new_status, $id)
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
	$query = "UPDATE dictionary_categories SET active = '".$status."'
						WHERE id_cat = '".$id."'";
	$db->query($query);
	return '0';
}
function GetDictionaryCategoryInfos ($id)
{
	global $db;
	$query = "SELECT * FROM dictionary_categories
							WHERE id_cat = '".$id."'";
	$db->query($query);
	$db->next_record();
	$infos=array();
	$infos['cat_name']=$db->f('cat_name');
	$infos['meta_keywords']=$db->f('meta_keywords');
	$infos['meta_description']=$db->f('meta_description');

	return $infos;
}

function SaveDictionaryCategory ($name,$meta_key,$meta_desc, $id)
{
	global $db;
	$alias = GenerateAlias($name);
	$query = "UPDATE dictionary_categories SET cat_name = '".addslashes($name)."',meta_keywords='".addslashes($meta_key)."',meta_description='".addslashes($meta_desc)."',alias='".addslashes($alias)."'
							WHERE id_cat = '".$id."'";
	$db->query($query);
	return 0;
}


function ListAdminDictionaryTerms ($cat_id, $status, $limit)
{
	//echo "ss";exit;
	global $db;
	if($status!="all")
	{	 $status_q="and status = '".$status."'";}
	else
	{		$status_q="";	}

	switch ($cat_id)
	{
		case 'all':
			if($status_q!="")
			{
					$status_q="where status = '".$status."'";
			}
			$query = "SELECT * FROM dictionary ".$status_q." ORDER by titlu ASC ".$limit;
		break;
		
		default:
			$query = "SELECT * FROM dictionary
											WHERE bigcat_id = '".$cat_id."' ".$status_q." ORDER by titlu ASC ".$limit;
		break;
	
	}
	
	$db->query($query);
	$i = 0; $get_info = array();
	$db->query($query);
	while ($db->next_record())
	{
		$get_info[$i]['id'] = $db->f('id');
		
		$get_info[$i]['titlu'] = $db->f('titlu');
		$get_info[$i]['data_adaugarii'] = $db->f('data_adaugarii');
		$get_info[$i]['data_modificarii'] = $db->f('data_modificarii');
		$get_info[$i]['email'] = $db->f('email');
		$get_info[$i]['autor'] = $db->f('autor');
		$get_info[$i]['user_id'] = $db->f('user_id');
		$get_info[$i]['meta_keywords'] = $db->f('meta_keywords');
		$get_info[$i]['meta_description'] = $db->f('meta_description');
		$get_info[$i]['continut'] = $db->f('continut');
		$get_info[$i]['status'] = $db->f('status');
		$get_info[$i]['alias'] = $db->f('alias');
		$i++;
	}

	return $get_info;
}
function ListAdminDictionaryTermsUsers ($cat_id, $status, $limit)
{
	//echo "ss";exit;
	global $db;
	if($status!="all")
	{	 $status_q="and status = '".$status."'";}
	else
	{		$status_q="";	}

	switch ($cat_id)
	{
		case 'all':
				$query = "SELECT * FROM dictionary where user_id!='-1' ".$status_q." ORDER by titlu ASC ".$limit;
		break;
		
		default:
			$query = "SELECT * FROM dictionary
											WHERE bigcat_id = '".$cat_id."' ".$status_q." and user_id!='-1' ORDER by titlu ASC ".$limit;
		break;
	
	}
	
	$db->query($query);
	$i = 0; $get_info = array();
	$db->query($query);
	while ($db->next_record())
	{
		$get_info[$i]['id'] = $db->f('id');
		
		$get_info[$i]['titlu'] = $db->f('titlu');
		$get_info[$i]['data_adaugarii'] = $db->f('data_adaugarii');
		$get_info[$i]['data_modificarii'] = $db->f('data_modificarii');
		$get_info[$i]['email'] = $db->f('email');
		$get_info[$i]['autor'] = $db->f('autor');
		$get_info[$i]['user_id'] = $db->f('user_id');
		$get_info[$i]['meta_keywords'] = $db->f('meta_keywords');
		$get_info[$i]['meta_description'] = $db->f('meta_description');
		$get_info[$i]['continut'] = $db->f('continut');
		$get_info[$i]['status'] = $db->f('status');
		$get_info[$i]['alias'] = $db->f('alias');
		$i++;
	}

	return $get_info;
}

function ChangeDictionaryTermStatus ($new_status, $id)
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
	$query = "UPDATE dictionary SET status = '".$status."'
						WHERE id = '".$id."'";
	$db->query($query);
	return '0';
}


#========================================UTILIZATOR PARTS=============================================
/*function  GetUserTerms($user_id,$msj_id)
{
	global $db;$get_info=array();$i=0;
	switch($msj_id)
	{
		default:
				$query = "SELECT * FROM dictionary WHERE user_id='".$user_id."' and id='".$msj_id."' order by submision_date DESC";
		break;
		
		case 'all':
			$query = "SELECT * FROM dictionary WHERE user_id='".$user_id."' order by submision_date DESC";
		break;
	}
	
		$db->query($query);
		while($db->next_record())
		{
			$get_info[$i]['id'] = $db->f('id');
			$get_info[$i]['titlu'] = $db->f('titlu');
			$get_info[$i]['data_adaugarii'] = $db->f('data_adaugarii');
			$get_info[$i]['email'] = $db->f('email');
			$get_info[$i]['autor'] = $db->f('autor');
			$get_info[$i]['user_id'] = $db->f('user_id');
			$get_info[$i]['continut'] = $db->f('continut');
			$get_info[$i]['status'] = $db->f('status');
			$i++;
		}
		return $info;
}
function CheckTermStatus($alias)
{
	global $db;
	$get_info = array();$i=0;
	$query = "SELECT * FROM dictionary WHERE alias='".$alias."'";
	$db->query($query);
	if($db->affected_rows()>1)
	{
		while($db->next_record())
		{
			$get_info[$i]['id'] = $db->f('id');
			$i++;
		}
	}
	else
	{
		$get_info = array();
	}
	return $get_info;
}*/
?>