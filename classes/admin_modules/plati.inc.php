<?php
function GenereteFacturaContent($vals)
{
		global $db;
		$content="";
		
		$content = " Promovare online timp de ".$vals['perioada']." luni pentru ".$vals['nume_firma']." pe portalul stomatologic  www.dentistonline.ro .";

		if($_POST['recomandat']=='Y')
		{
			$content = "Promovare online timp de ".$vals['perioada']." luni pentru ".$vals['nume_firma']." pe www.dentistonline.ro, in cadrul cabinetelor recomandate.";
		}
		 //acesta la generare factura fiscala!!!
		//$content = " Promovare online timp de ".$vals['perioada']." luni pentru ".$vals['nume_firma']." din data de ".date("d.m.Y") ." pana in ".date("d.m.Y", mktime(0, 0, 0, date("m")+$vals['perioada'], date("d")+10, date("Y")))." pe www.dentistonline.ro .";
	return $content;
}

function UpdateProforma($vals,$id_proforma)
{
	global $db;
	$query = "UPDATE facturi_proforme SET email = '".addslashes($vals['email'])."',
										  perioada='".addslashes($vals['perioada'])."',
										  type='".addslashes(strtoupper($vals['type']))."',
										  emis_fact_proforma='".addslashes(strtoupper($vals['emis_fact_proforma']))."',
										  adaugare_proforma='".addslashes($vals['adaugare_proforma'])."',
										  expirare_proforma='".addslashes($vals['expirare_proforma'])."',
										  status='".addslashes(strtoupper($vals['status']))."',
										  recomandata='".addslashes(strtoupper($vals['recomandata']))."'
					WHERE id	 = '".$id_proforma."'";
	$db->query($query);
	return 1;
}
function InsertCommentBill($comment,$id_bill)
{
	global $db;
		$query = "UPDATE facturi_fiscale SET comment_bill = '".addslashes($comment)."'
				  WHERE serie_factura = '".$id_bill."'";
		$db->query($query);
		return 1;
}

function InsertClientDetails($get_info_proforma,$fiscala_id )
{
	global $db;
	global $conf;
	#let's take infos about cabinet, judet and type
	$get_firm_info = GetFirme($get_info_proforma['user_id'],$get_info_proforma['firma_id']);
	$judet = $get_firm_info[0]['judet'];
	$category = $get_firm_info[0]['category_id'];

	//print_r($get_firm_info);
	#means we have more packages choose ...eg:2,5
	$facturi = new Facturi($db);
	$user_pachet = $facturi->getTipPromovare($get_info_proforma['firma_id']);
	
	//this is for the new promovare using pachete and servicii
	if(is_array($user_pachet))
	{
		$query = "INSERT INTO clienti (`id_proforma`, `id_fiscala`,`serviciu_id`,`firma_id`,`date_add`,`date_exp`,`user_id`,`judet_id`,`type_id`) 
								VALUES('".$get_info_proforma['id']."', 
										'".$fiscala_id."',
										'".$user_pachet['pachet']."',
										'".$get_info_proforma['firma_id']."',
										'".date("Y-m-d",mktime(0, 0, 0, date("m"), date("d")+1, date("Y")))."',
										'".date("Y-m-d", mktime(0, 0, 0, date("m")+$get_info_proforma['perioada'], date("d")+3, date("Y")))."',
										'".$get_info_proforma['user_id']."',
										'".$judet."',
										'".$category."')";
		$db->query($query);
	}
	else
	{
		if(stristr($get_info_proforma['tip_promovare'],',')!==false)
		{
			$levels = explode(",",$get_info_proforma['tip_promovare']);
			foreach($levels as $ky => $val)
			{
				$a = $facturi->getPachetInfo($val);
				#we might have a bill generated from admin
				$query = "INSERT INTO clienti (`id_proforma`, `id_fiscala`,`serviciu_id`,`firma_id`,`date_add`,`date_exp`,`user_id`,`judet_id`,`type_id`) 
										VALUES('".$get_info_proforma['id']."',
												'".$fiscala_id."',
												'".$val."',
												'".$get_info_proforma['firma_id']."',
												'".date("Y-m-d",mktime(0, 0, 0, date("m"), date("d")+1, date("Y")))."',
												'".date("Y-m-d", mktime(0, 0, 0, date("m")+$a['luni'], date("d")+3, date("Y")))."',
												'".$get_info_proforma['user_id']."',
												'".$judet."',
												'".$category."')";
				$db->query($query);
			}
		}
		else
		{
			$a = $facturi->getPachetInfo($get_info_proforma['tip_promovare']);
			#means we have just one package choosed
			$query = "INSERT INTO clienti (`id_proforma`, `id_fiscala`,`serviciu_id`,`firma_id`,`date_add`,`date_exp`,`user_id`,`judet_id`,`type_id`) 
									VALUES('".$get_info_proforma['id']."',
											'".$fiscala_id."',
											'".$get_info_proforma['tip_promovare']."',
											'".$get_info_proforma['firma_id']."',
											'".date("Y-m-d",mktime(0, 0, 0, date("m"), date("d")+1, date("Y")))."',
											'".date("Y-m-d", mktime(0, 0, 0, date("m")+$a['luni'], date("d")+3, date("Y")))."',
											'".$get_info_proforma['user_id']."',
											'".$judet."',
											'".$category."')";
			$db->query($query);
		}
	}
	return 1;
}

function GenerateFacturaProforma($id_proforma)
{
	global $db;
	global $conf;

	$get_proforma_details = GetInfoProforma($id_proforma);
	$get_cumparator = GetInfoCumparator($get_proforma_details['cumparator_id']);
	$get_firma_name = GetCabInfo($get_proforma_details['firma_id']);

	$text = GetFileContent("../templates/emails/factura_proforma.tpl");
	$text = str_replace("%NUME_PERS_CONTACT%",	ucfirst($get_cumparator['nume']) , $text);
	$text = str_replace("%NUMAR_FACTURA_PROFORMA%",$id_proforma, $text);
	$text =str_replace("%EXPIRARE_FACTURA_PROFORMA%",$conf->expirare_proforma,$text); 
	$text = str_replace("%DATA%",date("d.m.Y"),$text);
	$text = str_replace("%PRET_TOTAL%",$get_proforma_details['cost'],$text);
	$text = str_replace("%DENUMIRE_SERVICI%",$get_proforma_details['content'] ,$text);
	
	
	if(isset($get_cumparator['cui'])&&($get_cumparator['cui']!=""))
	{			$text = str_replace("%COD_FISCAL_CNP%",	$get_cumparator['cui'] , $text);		}
	else
	{				$text = str_replace("%COD_FISCAL_CNP%",	$get_cumparator['cnp'] , $text);			}
	
	
	if(isset($_POST['rc'])&&($_POST['rc']!=""))
	{				$text = str_replace("%NR_REG_COM_BI%",	$get_cumparator['rc'] , $text);			}
	else
	{				$text = str_replace("%NR_REG_COM_BI%",	$get_cumparator['bi'] , $text);			}
	
	$text = str_replace("%NUME_PERS_CONTACT_FIRMA%",addslashes($get_cumparator['nume']) , $text);
	$text = str_replace("%ADRESA%",	$get_cumparator['adresa'] , $text);
	#scriem continutul intr-un fisier
	/////////////////////////
	$filename = '../facturi/facturi_proforme/proforma_'.$id_proforma.".html";
	$somecontent = $text;
	if (!$handle = fopen($filename, 'w')) 
	{
		 echo "Cannot open file ($filename)";
		 exit;
		}
	if (fwrite($handle, $somecontent) === FALSE) {
			echo "Cannot write to file ($filename)";
			exit;
		}
	fclose($handle);
	return 1;


}
function AddFacturaProforma($vals,$content,$admin_id=false)
{
	global $db;
	global $conf;
	$sql = "INSERT INTO cumparatori(`nume`, `adresa`, `CUI`, `BI`,`CNP`,`RC`) VALUES ('".addslashes($vals['name'])."', '".addslashes($vals['adresa'])."', '".addslashes($vals['cui'])."','".$vals['bi']."','".$vals['cnp']."', '".$vals['rc']."')";
	$db->query($sql);
	$cump_id = $db->last_insert_id();

	#e vorba de 5 zile lucratoare!!
	$day = date("D");
		if(($day=="Sun")||($day=="Dum"))
	{
		$data_expirarii = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d")+$conf->expirare_proforma, date("Y")));	
	}
	elseif(($day=="Sat")||($day=="Sam"))
	{
			$data_expirarii = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d")+$conf->expirare_proforma+1, date("Y")));
	}
	else
	{
		$data_expirarii = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d")+$conf->expirare_proforma+2, date("Y")));
	}

	if($admin_id!==false)
	{
		$sql2 = "INSERT INTO facturi_proforme(`user_id`,
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
											`recomandata`,
											`cumparator_id`,
											`email`,
											`tip_promovare`,
											`admin_id`
											) 
								VALUES ('".$vals['user_id']."',
												'".$vals['firma_id']."',
												'".addslashes($vals['nume_firma'])."',
												'".$vals['perioada']."',
												'".$vals['type']."',
												'N',
												'N',
												'".$vals['price']."',
												'".date('Y-m-d')."',
												'".$data_expirarii."',
												'Y',
												'".addslashes($content)."',
												'',
												'".$cump_id."',
												'".$vals['email']."',
												'".$vals['type_promovare']."',
												'".$admin_id."'
												)";
	}
	else
	{
		$sql2 = "INSERT INTO facturi_proforme(`user_id`,
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
											`recomandata`,
											`cumparator_id`,
											`email`,
											`tip_promovare`
											) 
								VALUES ('".$vals['user_id']."',
												'".$vals['firma_id']."',
												'".addslashes($vals['nume_firma'])."',
												'".$vals['perioada']."',
												'".$vals['type']."',
												'N',
												'N',
												'".$vals['price']."',
												'".date('Y-m-d')."',
												'".$data_expirarii."',
												'Y',
												'".addslashes($content)."',
												'".$vals['recomandat']."',
												'".$cump_id."',
												'".$vals['email']."',
												'".$vals['type_promovare']."')";
	}
	$db->query($sql2);
	return $db->last_insert_id();
}

function GenerateFiscalaHtml($id_fiscala)
{
	global $db;
	global $conf;

	$text = GetFileContent("../templates/emails/factura_fiscala.tpl");
	$get_facturi = GetFacturaFiscala($id_fiscala);	
	$get_proforma_details = GetInfoProforma($get_facturi['id_proforma']);
	$get_cumparator = GetInfoCumparator($get_proforma_details['cumparator_id']);
	$get_firma_name = GetCabInfo($get_proforma_details['firma_id']);


	#what we now from facturi fiscale
	$text = str_replace("%SERIE_FACTURA%",	$get_facturi['serie_factura'] , $text);
	$text = str_replace("%DATA%",TimeFormatFacturi($get_facturi['data_eliberarii']),$text);
	$text = str_replace("%PROFORMA_ID%",$get_facturi['id_proforma'],$text);
	$text = str_replace("%PRET_TOTAL%",$get_proforma_details['cost'],$text);
	$text = str_replace("%NUME_PERS_CONTACT_FIRMA%",$get_cumparator['nume'] ,$text);
	$text = str_replace("%COD_FISCAL_CNP%",$get_cumparator['cui']." ".$get_cumparator['cnp']  ,$text);
	$text = str_replace("%NR_REG_COM_BI%", $get_cumparator['rc']." ".$get_cumparator['bi'] ,$text);
	$text = str_replace("%ADRESA%",$get_cumparator['adresa'] ,$text);
	
	#if we have more packages choosed
	if(stristr($get_proforma_details['tip_promovare'],',')!==false)
	{
		$new_content_head = "Promovare online";
		$new_content_body = "";
		$new_content_foot = " in cadrul portalului stomatologic www.dentistonline.ro";

		$levels = explode(",",$get_proforma_details['tip_promovare']);
		foreach($levels as $ky => $val)
		{
				$a = getPromovareLevelDetails($val);
				#we might have a bill generated from admin
				$new_content_body = $new_content_body.", pachet ".$a['name']." timp de ".$a['perioada']." luni, din data de ".TimeFormatFacturi(date("Y-m-d",mktime(0, 0, 0, date("m"), date("d")+1, date("Y"))))." pana in data de ".TimeFormatFacturi(date("Y-m-d", mktime(0, 0, 0, date("m")+$a['perioada'], date("d")+3, date("Y"))));
				
		}
		$get_proforma_details['content'] = $new_content_head.$new_content_body.$new_content_foot;
		$text = str_replace("%DENUMIRE_SERVICI%",$get_proforma_details['content'] ,$text);
	}
	else
	{
		#means we have just one package choosed
		$text = str_replace("%DENUMIRE_SERVICI%",$get_proforma_details['content'].". Promovare se va realiza din data de ".TimeFormatFacturi($get_facturi['serviciu_din']) ." pana in ".TimeFormatFacturi($get_facturi['serviciu_expirare'])."." ,$text);
	}	

	#scriem continutul intr-un fisier
	$filename = '../facturi/facturi_fiscale/fiscala_'.$id_fiscala.".html";
	$somecontent = $text;
	if (!$handle = fopen($filename, 'w')) 
	{
		echo "Cannot open file ($filename)";
		exit;
	}
	
	if (fwrite($handle, $somecontent) === FALSE)
	{
		echo "Cannot write to file ($filename)";
		exit;
	}
	fclose($handle);
	return 1;
}
function GetCumparatorId($user_id,$firma_id)
{
	global $db;
	$query = "SELECT * FROM facturi_proforme where user_id = '".$user_id."' and firma_id='".$firma_id."' and status!='prelungita'";
	$db->query($query);
	$db->next_record();
	return $db->f('cumparator_id');
}
function GetCumapratorInformations($get_cumparator_id )
{
	global $db;$info=array();
	$query = "SELECT * FROM cumparatori where id = '".$get_cumparator_id ."'";
	$db->query($query);
	$db->next_record();
	$info['nume'] = $db->f('nume');
	$info['adresa'] = $db->f('adresa');
	$info['cui'] = $db->f('cui');
	$info['bi'] = $db->f('bi');
	$info['cnp'] = $db->f('cnp');
	$info['rc'] = $db->f('rc');

	return $info;
}

function GetFiscaleAdmin ($list_by, $fiscale_type, $query_limit,$year)
{
	global $db;
	$how_to_list1 = explode("_",$list_by);
	$how_to_list = $how_to_list1[0]."_".$how_to_list1[1];
	$how_to_list_ascdesc = $how_to_list1[2];

	$get_info=explode(":",$fiscale_type);
	$fiscale_type = $get_info['0'];
	$status = $get_info['1'];
	
	if($year!="all")
	{
		$year_condition = " and substr(serviciu_expirare,0,4)='".$year."'";
	}
	else
	{
		$year_condition="";
	}
	
	if(($status!="all")&&($fiscale_type!="all"))
	{
		$stat_cond = "and status = '".$status."'".$year_condition;
	}
	elseif(($status!="all")&&($fiscale_type=="all"))
	{
		$stat_cond ="WHERE status='".$status."'".$year_condition;
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
	//echo $query;exit;
	$fiscale = array();
	$i = 0;
	while ($db->next_record())
	{
		$fiscale[$i]['serie_factura'] = $db->f("serie_factura");
		$fiscale[$i]['id_proforma'] = $db->f("id_proforma");
		$fiscale[$i]['user_id'] = $db->f("user_id");
		$fiscale[$i]['trimisa'] = $db->f("trimisa");
		$fiscale[$i]['firma_id'] = $db->f("firma_id");
		$fiscale[$i]['tip_promovare'] = $db->f("tip_promovare");
		$fiscale[$i]['serviciu_din'] = $db->f("serviciu_din");
		$fiscale[$i]['data_eliberarii'] = TimeFormatFacturi ($db->f("data_eliberarii"));
		$fiscale[$i]['serviciu_expirare'] = TimeFormatFacturi($db->f("serviciu_expirare"));
		$i++;
	}
	return $fiscale;
}


function GetFiscaleAdminCurente ($list_by, $fiscale_type, $query_limit,$year)
{
	global $db;
	$how_to_list1 = explode("_",$list_by);
	$how_to_list = $how_to_list1[0]."_".$how_to_list1[1];
	$how_to_list_ascdesc = $how_to_list1[2];

	$get_info=explode(":",$fiscale_type);
	$fiscale_type = $get_info['0'];
	$status = $get_info['1'];
	
	if($year!="all")
	{
		$year_condition = " and substr(serviciu_expirare,0,4)='".$year."'";
	}
	else
	{
		$year_condition="";
	}
	
	if(($status!="all")&&($fiscale_type!="all"))
	{
		$stat_cond = "and status = '".$status."'".$year_condition;
	}
	elseif(($status!="all")&&($fiscale_type=="all"))
	{
		$stat_cond ="WHERE status='".$status."'".$year_condition;
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
				$query = "SELECT * FROM facturi_fiscale 
		Where  `serviciu_expirare` + INTERVAL '55'	DAY > CURDATE( ) ".$stat_cond." order by ".$how_to_list." ".$how_to_list_ascdesc." ".$query_limit;		
		break;
	}
	$db->query($query);
	//echo $query;exit;
	$fiscale = array();
	$i = 0;
	while ($db->next_record())
	{
		$fiscale[$i]['serie_factura'] = $db->f("serie_factura");
		$fiscale[$i]['id_proforma'] = $db->f("id_proforma");
		$fiscale[$i]['user_id'] = $db->f("user_id");
		$fiscale[$i]['trimisa'] = $db->f("trimisa");
		$fiscale[$i]['cost'] = $db->f("cost");
		$fiscale[$i]['firma_id'] = $db->f("firma_id");
		$fiscale[$i]['tip_promovare'] = $db->f("tip_promovare");
		$fiscale[$i]['serviciu_din'] = $db->f("serviciu_din");
		$fiscale[$i]['comment_bill'] = $db->f("comment_bill");
		$fiscale[$i]['data_eliberarii'] = TimeFormatFacturi ($db->f("data_eliberarii"));
		$fiscale[$i]['serviciu_expirare'] = TimeFormatFacturi($db->f("serviciu_expirare"));
		$i++;
	}
	return $fiscale;
}

function CountFiscaleAdmin ($list_by,$fiscale_type)
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


#if $users is all means we list all fcaturi fiscale grouped by user, otherwise we list just the fcaturi fiscale for one user
function GetFiscaleAdminOnUsers ($users, $fiscale_type, $query_limit)
{
	global $db;
	if($users=="all")
	{
				switch($fiscale_type)
			{
				default:
				$query =" SELECT P . * 
											FROM facturi_fiscale P
											JOIN ( SELECT MAX( serviciu_expirare ) AS expireservice
														FROM facturi_fiscale
														GROUP BY user_id
														)P2 ON P2.expireservice = P.serviciu_expirare
											WHERE P.trimisa='".$fiscale_type."'
											Group by P.user_id
											ORDER BY P.serviciu_expirare ASC".$query_limit;	
				break;

				case 'all':
					$query =" SELECT P . * 
											FROM facturi_fiscale P
											JOIN ( SELECT MAX( serviciu_expirare ) AS expireservice
														FROM facturi_fiscale
														GROUP BY user_id
														)P2 ON P2.expireservice = P.serviciu_expirare
											Group by P.user_id
											ORDER BY P.serviciu_expirare ASC".$query_limit;
				break;
			}
	}
	else
	{
			$query =" SELECT * 
							FROM facturi_fiscale 
							WHERE user_id='".$users."'";
	}
	//echo $query;
	$db->query($query);
	$fiscale = array();
	$i = 0;
	while ($db->next_record())
	{
		$fiscale[$i]['serie_factura'] = $db->f("serie_factura");
		$fiscale[$i]['id_proforma'] = $db->f("id_proforma");
		$fiscale[$i]['user_id'] = $db->f("user_id");
		$fiscale[$i]['trimisa'] = $db->f("trimisa");
		$fiscale[$i]['tip_promovare'] = $db->f("tip_promovare");
		$fiscale[$i]['firma_id'] = $db->f("firma_id");
		$fiscale[$i]['serviciu_din'] = $db->f("serviciu_din");
		$fiscale[$i]['status'] = $db->f("status");
		$fiscale[$i]['cost'] = $db->f("cost");
		$fiscale[$i]['data_eliberarii'] = TimeFormatFacturi ($db->f("data_eliberarii"));
		$fiscale[$i]['serviciu_expirare'] = TimeFormatFacturi($db->f("serviciu_expirare"));
		
		$i++;
	}
	return $fiscale;
}


function CountFiscaleAdminCurente ($fiscale_type)
{
	global $db;
	$query = "SELECT * FROM facturi_fiscale 
		Where  `serviciu_expirare` + INTERVAL '25'	DAY > CURDATE( )";		

	$db->query($query);
	return $db->affected_rows();
}

function CountFiscaleForUser($user_id)
{
	global $db;
	$query =" SELECT COUNT(serie_factura) as total_fiscale
						FROM facturi_fiscale
						WHERE user_id='".$user_id."'";

	$db->query($query);
	$db->next_record();
	return $db->f('total_fiscale');
}

function getTipPromovareName($id_promovare)
{
	global $db; $promovare=array();

	$query =" SELECT * FROM level
						WHERE id='".$id_promovare."'";

	$db->query($query);
	$db->next_record();

	$promovare['nume']= $db->f('name');
	$promovare['pret']= $db->f('pret');
	$promovare['perioada']= $db->f('perioada');
	return  $promovare;
}

function getPromovareTypes()
{
	global $db; $promovare=array();

	$query =" SELECT * FROM level ";

	$db->query($query);
	$i = 0;
	while ($db->next_record())
	{
		$promovare[$i]['id']= $db->f('id');
		$promovare[$i]['nume']= $db->f('name');
		$promovare[$i]['pret']= $db->f('pret');
		$promovare[$i]['perioada']= $db->f('perioada');
		$i++;
	}
	return $promovare;
}

#####################clienti stuffs########################
function CountActiveClienti($active_clients,$cat,$judet)
{
	global $db;
	if(($cat)!="all" && ($judet!="all"))
	{
		$sql_part = "judet_id = '".$judet."' and type_id = '".$cat."'";
	}
	elseif($cat=="all")
	{
		$sql_part = "judet_id = '".$judet."'";
	}
	else
	{
		$sql_part = "type_id = '".$cat."'";
	}
	switch($active_clients)
	{
		default:
				$query =" SELECT *
							FROM `clienti`
							WHERE `date_exp` + INTERVAL '25'	DAY > CURDATE( )
							AND ".$sql_part." 
							Group by user_id
							ORDER BY `date_exp` ASC";		
		break;

		case 'all':
				$query =" SELECT *
							FROM `clienti`
							WHERE `date_exp` + INTERVAL '25'	DAY > CURDATE( )
							Group by user_id
							ORDER BY `date_exp` ASC";	
		break;
	}
	
	$db->query($query);
	return $db->affected_rows();
}
#if $users is all means we list all fcaturi fiscale grouped by user, otherwise we list just the fcaturi fiscale for one user
function GetAdminClients($active_clients,$cat,$judet, $query_limit)
{
	global $db;
	$clienti = array();
	if(($cat)!="all" && ($judet!="all"))
	{
		$sql_part = "judet_id = '".$judet."' and type_id = '".$cat."'";
	}
	elseif($cat=="all")
	{
		$sql_part = "judet_id = '".$judet."'";
	}
	else
	{
		$sql_part = "type_id = '".$cat."'";
	}
	switch($active_clients)
	{
		default:
				$query =" SELECT *
							FROM `clienti`
							WHERE `date_exp` + INTERVAL '10' DAY > CURDATE( )
							AND ".$sql_part." 
							ORDER BY `date_exp` ASC ".$query_limit;		
		break;

		case 'all':
				$query =" SELECT *
							FROM `clienti`
							WHERE `date_exp` + INTERVAL '10'	DAY > CURDATE( )
							ORDER BY `date_exp` ASC ".$query_limit;	
		break;
	}
	
	$db->query($query);
	$clienti = array();
	$i = 0;
	while ($db->next_record())
	{
		$clienti[$i]['serie_factura'] = $db->f("id_fiscala");
		$clienti[$i]['id_proforma'] = $db->f("id_proforma");
		$clienti[$i]['serviciu_id'] = $db->f("serviciu_id");
		$clienti[$i]['user_id'] = $db->f("user_id");
		$clienti[$i]['judet_id'] = $db->f("judet_id");
		$clienti[$i]['type_id'] = $db->f("type_id");
		$clienti[$i]['firma_id'] = $db->f("firma_id");
		$clienti[$i]['serviciu_din'] = $db->f("date_add");
		$clienti[$i]['data_eliberarii'] = TimeFormatFacturi ($db->f("date_add"));
		$clienti[$i]['serviciu_expirare'] = TimeFormatFacturi($db->f("date_exp"));
		$i++;
	}
	return $clienti;
}
function CheckIfNewFiscalaExists($firma)
{
	global $db;
	$query ="SELECT * FROM `clienti`
			WHERE `date_exp` + INTERVAL '2'	DAY > CURDATE( )
			AND firma_id = '".$firma."'";		
	echo $query;
	$db->query($query);
	$db->next_record();
	
	if($db->affected_rows()>0)
	{
		return "Y";
	}
	else
	{
		return "N";
	}

}
########################################FACTURI LUNARE STUFFS#############################################
function CountFiscaleOnMonthsYear ($month,$year)
{
	global $db;
	$stat_cond = " ";
	if($month!="all")
	{		$stat_cond = "and MONTH(data_eliberarii) = '".$month."'";	}

	$query = "SELECT COUNT(serie_factura) as total_fiscale FROM facturi_fiscale where YEAR(data_eliberarii) = '".$year."' ".$stat_cond;		
	$db->query($query);
	$db->next_record();
	
	return $db->f("total_fiscale");
}


function AllMoneyMonthYear ($month,$year)
{
	global $db;
	$stat_cond = " ";
	if($month!="all")
	{		$stat_cond = "and MONTH(data_eliberarii) = '".$month."'";	}

	$query = "SELECT SUM(cost) as total_money FROM facturi_fiscale where YEAR(data_eliberarii) = '".$year."' ".$stat_cond;		
	$db->query($query);
	$db->next_record();
	
	return $db->f("total_money");
}
function GetFiscaleOnMonthsYear($luna_curenta,$year_curent,$query_limit)
{
	global $db;
	$stat_cond = " ";
	if($luna_curenta!="all")
	{
		$stat_cond = "and MONTH(data_eliberarii) = '".$luna_curenta."'";
	}

	$query = "SELECT * FROM facturi_fiscale where YEAR(data_eliberarii) = '".$year_curent."' ".$stat_cond." order by data_eliberarii ASC ".$query_limit;		
	$db->query($query);
	$fiscale = array();
	$i = 0;
	while ($db->next_record())
	{
		$fiscale[$i]['serie_factura'] = $db->f("serie_factura");
		$fiscale[$i]['id_proforma'] = $db->f("id_proforma");
		$fiscale[$i]['user_id'] = $db->f("user_id");
		$fiscale[$i]['tip_promovare'] = $db->f("tip_promovare");
		$fiscale[$i]['trimisa'] = $db->f("trimisa");
		$fiscale[$i]['firma_id'] = $db->f("firma_id");
		$fiscale[$i]['serviciu_din'] = $db->f("serviciu_din");
		$fiscale[$i]['status'] = $db->f("status");
		$fiscale[$i]['data_eliberarii'] = TimeFormatFacturi ($db->f("data_eliberarii"));
		$fiscale[$i]['serviciu_expirare'] = TimeFormatFacturi($db->f("serviciu_expirare"));
		$i++;
	}
	return $fiscale;
}

?>