<?php

/*
- Function used in : admin / recomandate.php to check if we have avilable palce for the cabinet
only 3 placece foreach type an a county
*/
function CheckAvailablePlace ($judet,$type)
{
	global $db;
	$mods = array();
	$query = "SELECT id FROM recomandate WHERE judet_id = '".$judet."' AND type_id = '".$type."'";
	$db->query($query);
	if($db->num_rows()>7)
	{
		return false;
	}
	else
	{
		return true;
	}
	
}

/*
- Function used in : admin / recomandate.php to inser into recomandate table the offer but finalizat will be on "N";
afret the bill is payed we set finalizat on Y;
*/
function InsertToRecomandate($user_id,$cabinet_id,$comment,$judet_id,$type_id,$perioada,$factura_id,$loc,$tip_promovare)
{
	global $db;
	$date_add = date("Y-m-d");
	$date_exp = date("Y-m-d", mktime(0, 0, 0, date("m")+$perioada, date("d")+3, date("Y")));
	$query ="Insert into recomandate (user_id,
																		firma_id,
																		date_add,
																		date_exp,
																		comment,
																		judet_id,
																		type_id,
																		perioada,
																		factura_id,
																		loc,
																		tip_promovare)
												values('".$user_id."',
																'".$cabinet_id."',
																'".$date_add."',
																'".$date_exp."',
																'".$comment."',
																'".$judet_id."',
																'".$type_id."',
																'".$perioada."',
																'".$factura_id."',
																'".$loc."',
																'".$tip_promovare."')";
	$db->query($query);
	return true;
}

function GetInfoRecomandate($user_id,$firma_id)
{
	global $db;
	$items = array();$i=0;

	$query = "SELECT * FROM recomandate WHERE user_id = '".$user_id."' and firma_id='".$firma_id."'";
	$db->query($query);

	while ($db->next_record())
	{
		$items[$i]['loc'] = $db->f("loc");
		$items[$i]['tip_promovare'] = $db->f("tip_promovare");
		$items[$i]['factura_id'] = $db->f("factura_id");
		$items[$i]['perioada'] = $db->f("perioada");
		$items[$i]['finalizat'] = $db->f("finalizat");
		$items[$i]['type_id'] = $db->f("type_id");
		$items[$i]['judet_id'] = $db->f("judet_id");
		$items[$i]['id'] = $db->f("id");
		$items[$i]['user_id'] = $db->f("user_id");
		$items[$i]['firma_id'] = $db->f("firma_id");
		$items[$i]['date_add'] = $db->f("date_add");
		$items[$i]['date_exp'] = $db->f("date_exp");
		$items[$i]['comment'] = $db->f("comment");
		$i++;
	}
	return $items;

}

?>