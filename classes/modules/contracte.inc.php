<?php
#proforme related functions
function CountContracte ($list_by,$contracte_type)
{
	global $db;
	$how_to_list1 = explode("_",$list_by);
	$how_to_list = $how_to_list1[0]."_".$how_to_list1[1];	
	$how_to_list_ascdesc = $how_to_list1[2];
	
	switch($contracte_type)
	{
		default:
		$query = "SELECT COUNT(id) as total_contracte FROM contracte where status = '".$contracte_type."' order by ".$how_to_list." ".$how_to_list_ascdesc;		
		break;

		case 'all':
				$query = "SELECT COUNT(id) as total_contracte FROM contracte order by ".$how_to_list." ".$how_to_list_ascdesc;		
		break;
	}
	
	$db->query($query);
	$db->next_record();
	return $db->f("total_contracte");
}
function GetContracte($list_by, $contracte_type, $query_limit)
{
	global $db;
	$how_to_list1 = explode("_",$list_by);
	$how_to_list = $how_to_list1[0]."_".$how_to_list1[1];
	$how_to_list_ascdesc = $how_to_list1[2];
	
	switch($contracte_type)
	{
		default:
		$query = "SELECT * FROM contracte where status = '".$contracte_type."' order by ".$how_to_list." ".$how_to_list_ascdesc." ".$query_limit;		
		break;

		case 'all':
				$query = "SELECT * FROM contracte order by ".$how_to_list." ".$how_to_list_ascdesc." ".$query_limit;		
		break;
	}
	$db->query($query);
	$contracte = array();
	$i = 0;
	while ($db->next_record())
	{
		$contracte[$i]['id'] = $db->f("id");
		$contracte[$i]['user_id'] = $db->f("user_id");
		$contracte[$i]['firma_id'] = $db->f("firma_id");
		$contracte[$i]['factura_proforma_id'] = $db->f("factura_proforma_id");
		$contracte[$i]['factura_fiscala_id'] = $db->f("factura_fiscala_id");
		$contracte[$i]['nume_firma'] = $db->f("nume_firma");
		$contracte[$i]['perioada'] = $db->f("perioada");
		$contracte[$i]['type'] = $db->f("type");
		$contracte[$i]['achitat'] = $db->f("achitat");
		$contracte[$i]['cost'] = $db->f("cost");
		$contracte[$i]['adaugare_contract'] = $db->f("adaugare_contract");
		$contracte[$i]['expirare_contract'] = $db->f("expirare_contract");
		$contracte[$i]['status'] = $db->f("status");
		$i++;
	}
	return $contracte;
}
function GetInfoContract($contract)
{ global $db;
	$query = "SELECT * FROM contracte Where id='".$contract."'";
	$db->query($query);
	$contracte = array();
	$i = 0;
	while ($db->next_record())
	{
		$contracte['id'] = $db->f("id");
		$contracte['user_id'] = $db->f("user_id");
		$contracte['firma_id'] = $db->f("firma_id");
		$contracte['nume_firma'] = $db->f("nume_firma");
		$contracte['perioada'] = $db->f("perioada");
		$contracte['type'] = $db->f("type");
		$contracte['achitat'] = $db->f("achitat");
		$contracte['cost'] = $db->f("cost");
		$contracte['status'] = $db->f("status");
		$contracte['factura_fiscala_id'] = $db->f("factura_fiscala_id");
		$contracte['factura_proforma_id'] = $db->f("factura_proforma_id");
		$contracte['adaugare_contract'] = $db->f("adaugare_contract");
		$contracte['expirare_contract'] = $db->f("expirare_contract");
		$i++;
	}
	return $contracte;
}
function InsertContract($get_info_proforma )
{
	global $db;
	global $conf;
	$expirare_contract = date("Y-m-d", mktime(0, 0, 0, date("m")+$get_info_proforma['perioada'], date("d"), date("Y")));
	$query ="INSERT INTO contracte (`user_id`,`firma_id`, `nume_firma`,`perioada`,`type`, `achitat`,`cost`,`adaugare_contract`,`expirare_contract`, `status`,`factura_proforma_id`) 
							VALUES('".$get_info_proforma['user_id']."',
									'".$get_info_proforma['firma_id']."',
									'".addslashes($get_info_proforma['nume_firma'])."',
									'".$get_info_proforma['perioada']."',
									'".$get_info_proforma['type']."',
									'Y',
									'".$get_info_proforma['cost']."',
									'NOW()',
									'".$expirare_contract."',
									'Y',
									'".$get_info_proforma['id']."')";
	$db->query($query);
	$last_id=$db->last_insert_id();

	//$query="Update cabinete set expire_date='".$expirare_contract."',submision_date=now() where id='".$get_info_proforma['firma_id']."'";
	//$db->query($query);
	return $last_id;
}
function ChangeContractStatus ($new_status, $id)
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
	$query = "UPDATE contracte SET status = '".$status."'
						WHERE id = '".$id."'";
	$db->query($query);
	return '0';
}
function CountContracteCauta ($list_by,$value)
{
	global $db;
	$what = substr($list_by,0,-9);
	if($what=="username")
	{
		$get_username_id = GetUsernameId($value);
		$what="id";
		$value = $get_username_id;
	}
	//echo $what;exit;
	switch($value)
	{
		default:
		$query = "SELECT COUNT(id) as total_contracte FROM contracte where ".$what." = '".$value."'";		
		break;

		case 'all':
				$query = "SELECT COUNT(id) as total_contracte FROM contracte order by adaugare_contract DESC";		
		break;
	}
	
	$db->query($query);
	$db->next_record();
	return $db->f("total_contracte");
}
function GetContracteCauta($what_search, $value, $query_limit)
{
	global $db;
	$what = substr($what_search,0,-9);
	if($what=="username")
	{
		$get_username_id = GetUsernameId($value);
		$what="user_id";
		$value = $get_username_id;
	}
	switch($value)
	{
		default:
		$query = "SELECT * FROM contracte where ".$what." = '".$value."' ".$query_limit;		
		break;

		case 'all':
				$query = "SELECT * FROM contracte order by adaugare_contract DESC ".$query_limit;		
		break;
	}
	$db->query($query);
	$contracte = array();
	$i = 0;
	while ($db->next_record())
	{
		$contracte[$i]['id'] = $db->f("id");
		$contracte[$i]['user_id'] = $db->f("user_id");
		$contracte[$i]['firma_id'] = $db->f("firma_id");
		$contracte[$i]['factura_proforma_id'] = $db->f("factura_proforma_id");
		$contracte[$i]['factura_fiscala_id'] = $db->f("factura_fiscala_id");
		$contracte[$i]['nume_firma'] = $db->f("nume_firma");
		$contracte[$i]['perioada'] = $db->f("perioada");
		$contracte[$i]['type'] = $db->f("type");
		$contracte[$i]['achitat'] = $db->f("achitat");
		$contracte[$i]['cost'] = $db->f("cost");
		$contracte[$i]['adaugare_contract'] = $db->f("adaugare_contract");
		$contracte[$i]['expirare_contract'] = $db->f("expirare_contract");
		$contracte[$i]['status'] = $db->f("status");
		$i++;
	}
	return $contracte;
}


function GetContracteForUser($user_id)
{
	global $db;
	$contracte = array();
	$i=0;
	$query = "SELECT * FROM contracte Where user_id ='".$user_id."'";		
	$db->query($query);
	if($db->affected_rows()>0)
	{
			while ($db->next_record())
			{
				$contracte[$i]['id'] = $db->f("id");
				$contracte[$i]['user_id'] = $db->f("user_id");
				$contracte[$i]['firma_id'] = $db->f("firma_id");
				$contracte[$i]['factura_proforma_id'] = $db->f("factura_proforma_id");
				$contracte[$i]['factura_fiscala_id'] = $db->f("factura_fiscala_id");
				$contracte[$i]['nume_firma'] = $db->f("nume_firma");
				$contracte[$i]['perioada'] = $db->f("perioada");
				$contracte[$i]['type'] = $db->f("type");
				$contracte[$i]['achitat'] = $db->f("achitat");
				$contracte[$i]['cost'] = $db->f("cost");
				$contracte[$i]['adaugare_contract'] = $db->f("adaugare_contract");
				$contracte[$i]['expirare_contract'] = $db->f("expirare_contract");
				$contracte[$i]['status'] = $db->f("status");
				$i++;
			}
	}
return $contracte;
}
?>