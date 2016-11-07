<?php
function InsertPlata($user_id,$id_firma,$nume_firma,$level,$type,$emis_fact,$cost,$recomandata,$email_contact,$cump_id,$perioada = false)
{
	global $db;
	global $conf;

	#it's about 5 working days
	$day = date("D");
	if(($day=="Sun")||($day=="Dum"))
	{
		$data_expirarii = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d")+$conf->expirare_proforma, date("Y")));	}
	elseif(($day=="Sat")||($day=="Sam"))
	{
			$data_expirarii = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d")+$conf->expirare_proforma+1, date("Y")));
	}
	else
	{
		$data_expirarii = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d")+$conf->expirare_proforma+2, date("Y")));
	}

	$text = TextFacturaInFunctieDeLevel($level, $perioada);
	$text = str_replace("NUME_FIRMA",$nume_firma,$text);

	$query ="INSERT INTO facturi_proforme (
											`user_id`,
											`firma_id`, 
											`nume_firma`, 
											`perioada`, 
											`type`, 
											`emis_fact_proforma`, 
											`achitat`, 
											`cost`, 
											`adaugare_proforma`, 
											`expirare_proforma`, 
											`status`,
											`content`,
											`email`,
											`cumparator_id`,
											`recomandata`,
											`tip_promovare`)
								 VALUES('".$user_id."',
								 		'".$id_firma."',
								 		'".addslashes($nume_firma)."',
								 		'".(int)$perioada."',
								 		'".$type."',
								 		'".$emis_fact."',
								 		'N',
								 		'".$cost."',
								 		now(),
								 		'".$data_expirarii."',
										'Y',
										'$text',
										'".$email_contact."',
										'$cump_id',
										'$recomandata',
										'$level')";
	$db->query($query);
	return $db->last_insert_id();
}

function GetlevelDetails($level_id)
{
	global $db;
	$level_det = array();

	$query = "SELECT * FROM level Where id ='".$level_id."'";
	$db->query($query);
	$db->next_record();
	$level_det['name'] = $db->f('name');
	$level_det['perioada'] = $db->f('perioada');
	return $level_det;
}

function TextFacturaInFunctieDeLevel($level_id, $perioada = false)
{
	global $db;
	$text="";
	$pachete = new Pachete_Servicii($db);
	
	if(stristr($level_id,",")!==false)
	{
		$count_levels = explode(",",$level_id);
		#means we have more packeges choose eg;abonament and recomandat
		if(isset($count_levels['1'])&&($count_levels['1'])!="")
		{
			$level_details1 = GetlevelDetails($count_levels['0']);
			$level_details2 = GetlevelDetails($count_levels['1']);
			$text = "Promovare online  pachet ".$level_details1['name']." pe o perioada de ".$level_details1['perioada']." luni, pachet ".$level_details2['name']." pe o perioada de ".$level_details2['perioada']." luni pentru NUME_FIRMA , in cadrul portalului stomatologic www.dentistonline.ro";
		}
	}
	else
	{
		$level_details =  $pachete->getPachetInfo($level_id);
		if($perioada !==false) $text = "Promovare online, pachet ".$level_details['name']."  pentru NUME_FIRMA pe o perioada de ".$perioada." luni, in cadrul portalului stomatologic www.dentistonline.ro";
		else $text = "Promovare online, pachet ".$level_details['name']."  pentru NUME_FIRMA pe o perioada de ".$level_details['luni']." luni, in cadrul portalului stomatologic www.dentistonline.ro";
	}
	return $text;
}
#proforme related functions
function CountProforme ($list_by,$proforme_type,$admin_id=false)
{
	global $db;
	$how_to_list1 = explode("_",$list_by);
	$how_to_list = $how_to_list1[0]."_".$how_to_list1[1];	
	$how_to_list_ascdesc = $how_to_list1[2];
	
	$get_info=explode(":",$proforme_type);
	$proforme_type = $get_info['0'];
	$status = $get_info['1'];
	
		if(($status!="all")&&($proforme_type!="all"))
	{
		$stat_cond = "and status = '".$status."'";
	}
	elseif(($status!="all")&&($proforme_type=="all"))
	{
		$stat_cond ="WHERE status='".$status."'";
	}
	else
	{
		$stat_cond = "";
	}
	$specyal_cond="";
	if($admin_id!==false)
	{
		$specyal_cond = "AND `admin_id`='$admin_id' ";
	}


	switch($proforme_type)
	{
		default:
		$query = "SELECT COUNT(id) as total_proforme FROM facturi_proforme WHERE achitat = '".$proforme_type."' ".$specyal_cond." ".$stat_cond." order by ".$how_to_list." ".$how_to_list_ascdesc;		
		break;

		case 'all':
				if($stat_cond!="")
				{
					$query = "SELECT COUNT(id) as total_proforme FROM facturi_proforme ".$stat_cond." ".$specyal_cond." order by ".$how_to_list." ".$how_to_list_ascdesc;		
				}
				else
				{
						if($admin_id!==false)
						{
							$specyal_cond = "WHERE `admin_id`='$admin_id' ";
						}
					$query = "SELECT COUNT(id) as total_proforme FROM facturi_proforme ".$specyal_cond." order by ".$how_to_list." ".$how_to_list_ascdesc;		
				}
		break;
	}
	
	$db->query($query);
	$db->next_record();
	return $db->f("total_proforme");
}

function CountFiscale ($list_by,$fiscale_type)
{
	global $db;
	$how_to_list1 = explode("_",$list_by);
	$how_to_list = $how_to_list1[0]."_".$how_to_list1[1];	
	$how_to_list_ascdesc = $how_to_list1[2];
	
	$get_info = explode(":",$fiscale_type);
	$fiscale_type = $get_info['0'];
	$status = $get_info['1'];
	
	if(($status!="all")&&($fiscale_type!="all"))
	{
		$stat_cond = "and status = '".$status."'";
	}
	elseif(($status!="all")&&($fiscale_type=="all"))
	{
		$stat_cond ="WHERE status='".$status."'";
	}
	else
	{
		$stat_cond = " ";
	}

	switch($fiscale_type)
	{
		default:
		$query = "SELECT COUNT(serie_factura) as total_fiscale FROM facturi_fiscale where trimisa = '".$fiscale_type."' ".$stat_cond." order by ".$how_to_list." ".$how_to_list_ascdesc;		
		break;

		case 'all':
				$query = "SELECT COUNT(serie_factura) as total_fiscale FROM facturi_fiscale ".$stat_cond." order by ".$how_to_list." ".$how_to_list_ascdesc;		
		break;
	}
	//echo $query;
	$db->query($query);
	$db->next_record();
	return $db->f("total_fiscale");
}

function GetProforme ($list_by, $proforme_type, $query_limit,$admin_id=false)
{
	global $db;
	$how_to_list1 = explode("_",$list_by);
	$how_to_list = $how_to_list1[0]."_".$how_to_list1[1];
	$how_to_list_ascdesc = $how_to_list1[2];

	$get_info=explode(":",$proforme_type);
	$proforme_type = $get_info['0'];
	$status = $get_info['1'];
	
	if(($status!="all")&&($proforme_type!="all"))
	{
		$stat_cond = "and status = '".$status."'";
	}
	elseif(($status!="all")&&($proforme_type=="all"))
	{
		$stat_cond ="WHERE status='".$status."'";
	}
	else
	{
		$stat_cond = "";
	}
	
	if($admin_id!==false)
	{
		switch($proforme_type)
		{
			default:
				$query = "SELECT * FROM facturi_proforme where achitat = '".$proforme_type."' ".$stat_cond." AND `admin_id`='$admin_id' ORDER BY ".$how_to_list." ".$how_to_list_ascdesc." ".$query_limit;		
			break;

			case 'all':
				if($stat_cond!="")
				{
					$query = "SELECT * FROM facturi_proforme ".$stat_cond." AND `admin_id`='$admin_id' ORDER BY ".$how_to_list." ".$how_to_list_ascdesc." ".$query_limit;		
				}
				else
				{
					$query = "SELECT * FROM facturi_proforme WHERE `admin_id`='$admin_id' ORDER BY ".$how_to_list." ".$how_to_list_ascdesc." ".$query_limit;		
				}
			break;
		}
	}
	else
	{
		switch($proforme_type)
		{
			default:
				$query = "SELECT * FROM facturi_proforme where achitat = '".$proforme_type."' ".$stat_cond." ORDER BY ".$how_to_list." ".$how_to_list_ascdesc." ".$query_limit;		
			break;

			case 'all':
				if($stat_cond!="")
				{
					$query = "SELECT * FROM facturi_proforme ".$stat_cond." ORDER BY ".$how_to_list." ".$how_to_list_ascdesc." ".$query_limit;		
				}
				else
				{
					$query = "SELECT * FROM facturi_proforme ORDER BY ".$how_to_list." ".$how_to_list_ascdesc." ".$query_limit;		
				}
			break;
		}
	}


	$db->query($query);
	$proforme = array();
	$i = 0;
	while ($db->next_record())
	{
		$proforme[$i]['id'] = $db->f("id");
		$proforme[$i]['user_id'] = $db->f("user_id");
		$proforme[$i]['firma_id'] = $db->f("firma_id");
		$proforme[$i]['tip_promovare'] = $db->f("tip_promovare");
		$proforme[$i]['nume_firma'] = $db->f("nume_firma");
		$proforme[$i]['perioada'] = $db->f("perioada");
		$proforme[$i]['type'] = $db->f("type");
		$proforme[$i]['achitat'] = $db->f("achitat");
		$proforme[$i]['emis_fact_proforma'] = $db->f("emis_fact_proforma");
		$proforme[$i]['cost'] = $db->f("cost");
		$proforme[$i]['adaugare_proforma'] = $db->f("adaugare_proforma");
		$proforme[$i]['expirare_proforma'] = $db->f("expirare_proforma");
		$proforme[$i]['status'] = $db->f("status");
		$i++;
	}
	return $proforme;
}
function GetFiscale ($list_by, $fiscale_type, $query_limit)
{
	global $db;
	$how_to_list1 = explode("_",$list_by);
	$how_to_list = $how_to_list1[0]."_".$how_to_list1[1];
	$how_to_list_ascdesc = $how_to_list1[2];

	$get_info=explode(":",$fiscale_type);
	$fiscale_type = $get_info['0'];
	$status = $get_info['1'];
	
	if(($status!="all")&&($fiscale_type!="all"))
	{
		$stat_cond = "and status = '".$status."'";
	}
	elseif(($status!="all")&&($fiscale_type=="all"))
	{
		$stat_cond ="WHERE status='".$status."'";
	}
	else
	{
		$stat_cond = " ";
	}
	
	switch($fiscale_type)
	{
		default:
		$query = "SELECT * FROM facturi_fiscale where trimisa = '".$fiscale_type."' ".$stat_cond." order by ".$how_to_list." ".$how_to_list_ascdesc." ".$query_limit;		
		break;

		case 'all':
				$query = "SELECT * FROM facturi_fiscale ".$stat_cond." order by ".$how_to_list." ".$how_to_list_ascdesc." ".$query_limit;		
		break;
	}
	$db->query($query);
	$fiscale = array();
	$i = 0;
	while ($db->next_record())
	{
		$fiscale[$i]['serie_factura'] = $db->f("serie_factura");
		$fiscale[$i]['id_proforma'] = $db->f("id_proforma");
		$fiscale[$i]['id_contract'] = $db->f("id_contract");
		$fiscale[$i]['status'] = $db->f("status");
		$fiscale[$i]['user_id'] = $db->f("user_id");
		$fiscale[$i]['trimisa'] = $db->f("trimisa");
		$fiscale[$i]['firma_id'] = $db->f("firma_id");
		$fiscale[$i]['data_eliberarii'] = TimeFormatFacturi ($db->f("data_eliberarii"));
		$fiscale[$i]['serviciu_expirare'] = TimeFormatFacturi($db->f("serviciu_expirare"));
		$i++;
	}
	return $fiscale;
}
function GetInfoProforma($id_proforma)
{ global $db;
	$query = "SELECT * FROM facturi_proforme Where id='".$id_proforma."'";
	$db->query($query);
	$proforme = array();
	$i = 0;
	while ($db->next_record())
	{
		$proforme['id'] = $db->f("id");
		$proforme['user_id'] = $db->f("user_id");
		$proforme['firma_id'] = $db->f("firma_id");
		$proforme['nume_firma'] = $db->f("nume_firma");
		$proforme['perioada'] = $db->f("perioada");
		$proforme['type'] = $db->f("type");
		$proforme['achitat'] = $db->f("achitat");
		$proforme['cost'] = $db->f("cost");
		$proforme['status'] = $db->f("status");
		$proforme['adaugare_proforma'] = $db->f("adaugare_proforma");
		$proforme['expirare_proforma'] = $db->f("expirare_proforma");
		$proforme['emis_fact_proforma'] = $db->f("emis_fact_proforma");
		$proforme['email'] = $db->f("email");
		$proforme['content'] = $db->f("content");
		$proforme['recomandata'] = $db->f("recomandata");
		$proforme['cumparator_id'] = $db->f("cumparator_id");
		$proforme['tip_promovare'] = $db->f("tip_promovare");
		$proforme['servicii_promovare'] = $db->f("servicii_promovare");
		
		$i++;
	}
	return $proforme;
}
function CheckProformaContracte($id_proforma)
{
	global $db;
	$query = "SELECT * FROM contracte WHERE factura_proforma_id='".$id_proforma."'";
	$db->query($query);
	if($db->affected_rows()>0)
	{
		return 'Y';
	}
	else
	{
		return 'N';
	}
}
function CountFacturiCauta ($list_by,$value,$wich_table)
{
	global $db;
	$what = substr($list_by,0,-8);
	if($what=="username")
	{
		$get_username_id = GetUsernameId($value);
		$what="id";
		$value = $get_username_id;
	}
	switch($wich_table)
	{
		case 'facturi_proforme':
			
			if($what=="adaugare")
			{		$what ="adaugare_proforma";		}
			elseif($what=="expirare")
			{		$what ="expirare_proforma";		}
		
			$query = "SELECT COUNT(id) as total_facturi FROM facturi_proforme where ".$what." = '".$value."'";		
		break;

		case 'facturi_fiscale':
			if($what=="adaugare")
			{		$what ="adaugare_fiscala";		}
			elseif($what=="expirare")
			{		$what ="expirare_fiscala";			}

			$query = "SELECT COUNT(id) as total_facturi FROM facturi_fiscale where ".$what." = '".$value."'";		
		break;
	}
	
	$db->query($query);
	$db->next_record();
	return $db->f("total_facturi");
}

function GetFacturiCauta($what_search, $value,$which_table, $query_limit)
{
	global $db;
	$what = substr($what_search,0,-8);
	if($what=="username")
	{
		$get_username_id = GetUsernameId($value);
		$what="user_id";
		$value = $get_username_id;
	}
	switch($which_table)
	{
		case 'facturi_proforme':
		if($what=="adaugare")
		{		$what ="adaugare_proforma";		}
		elseif($what=="expirare")
		{
			$what ="expirare_proforma";	
		}
		
		$query = "SELECT id,user_id,firma_id,nume_firma,perioada,type,emis_fact_proforma,achitat,	cost, 	adaugare_proforma as adaugare_factura, expirare_proforma as expirare_factura,status FROM facturi_proforme where ".$what." = '".$value."' Order by adaugare_proforma DESC ".$query_limit;			
		break;

		case 'facturi_fiscale':
			if($what=="adaugare")
			{		$what ="adaugare_fiscala";		}
			elseif($what=="expirare")
			{		$what ="expirare_fiscala";			}

			$query = "SELECT *  FROM facturi_fiscale where ".$what." = '".$value."' Order by adaugare_proforma DESC ".$query_limit;			
		break;
	}

	$db->query($query);
	$facturi = array();
	$i = 0;
	while ($db->next_record())
	{
		$facturi[$i]['id'] = $db->f("id");
		$facturi[$i]['user_id'] = $db->f("user_id");
		$facturi[$i]['firma_id'] = $db->f("firma_id");
		$facturi[$i]['nume_firma'] = $db->f("nume_firma");
		$facturi[$i]['perioada'] = $db->f("perioada");
		$facturi[$i]['type'] = $db->f("type");
		$facturi[$i]['achitat'] = $db->f("achitat");
		$facturi[$i]['cost'] = $db->f("cost");
		$facturi[$i]['adaugare_factura'] = $db->f("adaugare_factura");
		$facturi[$i]['expirare_factura'] = $db->f("expirare_factura");
		$facturi[$i]['status'] = $db->f("status");
		$i++;
	}
	return $facturi;
}

function UpdateStatusFacturiProforme()
{
	global $db;
	$today = date("Y-m-d");
	$query ="Update facturi_proforme set status ='N' where expirare_proforma='".$today."' and achitat='N'";
	$db->query($query);
}

function InsertProformaToFiscala($get_info_proforma, $contract_id)
{
	global $db;
	global $conf;
	$query ="INSERT INTO facturi_fiscale (`id_proforma`, `id_contract`,`user_id`,`data_eliberarii`,`firma_id`,`serviciu_din`,`serviciu_expirare`,`tip_promovare`,`cost`) 
							VALUES('".$get_info_proforma['id']."', 
									'".$contract_id."',
									'".$get_info_proforma['user_id']."',
									NOW(),
									'".$get_info_proforma['firma_id']."',
									'".date("Y-m-d",mktime(0, 0, 0, date("m"), date("d")+1, date("Y")))."',
									'".date("Y-m-d", mktime(0, 0, 0, date("m")+$get_info_proforma['perioada'], date("d")+3, date("Y")))."',
									'".$get_info_proforma['tip_promovare']."',
									'".$get_info_proforma['cost']."')";
	$db->query($query);
	$serie_fiscala = $db->last_insert_id();
	
	#and insert fiscala to contracte
	$query="UPDATE contracte SET factura_fiscala_id='".$serie_fiscala."' WHERE id='".$contract_id."'";
	$db->query($query);
	
	return $serie_fiscala;
}

function GetproformaForCabinet($id)
{
	global $db;
	$query = "SELECT * FROM facturi_proforme Where firma_id='".$id."'";
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
function GetLastProformaForCabinet($id)
{
	global $db;
	$query = "SELECT * FROM facturi_proforme Where firma_id='".$id."' ORDER BY id DESC";
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
function GetFacturiForUser($user_id)
{
	global $db;
	$facturi = array();
	$i=0;
	$query = "SELECT * FROM facturi_fiscale Where user_id ='".$user_id."' ORDER by data_eliberarii DESC";		
	$db->query($query);
	if($db->affected_rows()>0)
	{
		while ($db->next_record())
		{
		$facturi[$i]['serie_factura'] = $db->f("serie_factura");
		$facturi[$i]['id_proforma'] = $db->f("id_proforma");
		$facturi[$i]['user_id'] = $db->f("user_id");
		$facturi[$i]['data_eliberarii'] = $db->f("data_eliberarii");
			
		$facturi[$i]['serviciu_din'] = $db->f("serviciu_din");
		$facturi[$i]['serviciu_expirare'] = $db->f("serviciu_expirare");

		$facturi[$i]['status'] = $db->f("status");
		$facturi[$i]['firma_id'] = $db->f("firma_id");
		$i++;
		}
	}
	return $facturi;
}
function GetFacturaFiscala($fiscala_id)
{
	global $db;
	$facturi = array();
	$query = "SELECT * FROM facturi_fiscale Where serie_factura ='".$fiscala_id."'";		
	$db->query($query);
	$db->next_record();
		
		$facturi['serie_factura'] = $db->f("serie_factura");
		$facturi['id_proforma'] = $db->f("id_proforma");
		$facturi['id_contract'] = $db->f("id_contract");
		$facturi['user_id'] = $db->f("user_id");
		$facturi['data_eliberarii'] = $db->f("data_eliberarii");
		$facturi['serviciu_din'] = $db->f("serviciu_din");
		$facturi['serviciu_expirare'] = $db->f("serviciu_expirare");
		$facturi['status'] = $db->f("status");
		$facturi['firma_id'] = $db->f("firma_id");
	return $facturi;
}
function GetFacturiProformeForUser($user_id)
{
	global $db;
	$query = "SELECT * FROM facturi_proforme Where user_id ='".$user_id."' Order by adaugare_proforma DESC";		
	$db->query($query);
	$facturi = array();
	$i = 0;
	while ($db->next_record())
	{
		$facturi[$i]['id'] = $db->f("id");
		$facturi[$i]['user_id'] = $db->f("user_id");
		$facturi[$i]['firma_id'] = $db->f("firma_id");
		$facturi[$i]['nume_firma'] = $db->f("nume_firma");
		$facturi[$i]['perioada'] = $db->f("perioada");
		$facturi[$i]['type'] = $db->f("type");
		$facturi[$i]['achitat'] = $db->f("achitat");
		$facturi[$i]['cost'] = $db->f("cost");
		$facturi[$i]['adaugare_factura'] =TimeFormatFacturi( $db->f("adaugare_proforma"));
		$facturi[$i]['expirare_factura'] = TimeFormatFacturi( $db->f("expirare_proforma"));
		$facturi[$i]['status'] = $db->f("status");
		$i++;
	}
	return $facturi;
}
function GetAdrEmail($firm_id)
{
	global $db;
	$query = "SELECT persc_email FROM cabinete Where id ='".$firm_id."'";		
	$db->query($query);
	$db->next_record();
	return $db->f('persc_email');
}
function GetFiscalaForProforma($id_proforma)
{
	global $db;
	$facturi = array();
	$query = "SELECT * FROM facturi_fiscale Where id_proforma ='".$id_proforma."'";		
	$db->query($query);
	if($db->affected_rows()>0)
	{
		while ($db->next_record())
		{
		$facturi['serie_factura'] = $db->f("serie_factura");
		$facturi['id_proforma'] = $db->f("id_proforma");
		$facturi['id_contract'] = $db->f("id_contract");
		$facturi['user_id'] = $db->f("user_id");
		$facturi['data_eliberarii'] = TimeFormatFacturi($db->f("data_eliberarii"));
		$facturi['serviciu_din'] = TimeFormatFacturi($db->f("serviciu_din"));
		$facturi['serviciu_expirare'] = TimeFormatFacturi($db->f("serviciu_expirare"));
		$facturi['status'] = $db->f("status");
		$facturi['firma_id'] = $db->f("firma_id");
		}
	}
	return $facturi;
}
function GetInfoCumparator($id_cump)
{
	global $db;
	$facturi = array();
	$query = "SELECT * FROM cumparatori Where id ='".$id_cump."'";		
	$db->query($query);
	$db->next_record();
		$facturi['nume'] = $db->f("nume");
		$facturi['adresa'] = $db->f("adresa");
		$facturi['cui'] = $db->f("cui");
		$facturi['cnp'] = $db->f("cnp");
		$facturi['bi'] = $db->f("bi");
		$facturi['rc'] = $db->f("rc");
	
	return $facturi;

}

function ChangeSendBillStatus($status,$id_fiscala)
{
	global $db;
	//echo $status;
	if($status=='Y')
	{
		$query = "Update facturi_fiscale Set trimisa='N' Where serie_factura ='".$id_fiscala."'";		
	}
	else
	{
		$query = "Update facturi_fiscale Set trimisa='Y' Where serie_factura ='".$id_fiscala."'";		
	}
	//echo $query;
	$db->query($query);
	return 1;
}
?>