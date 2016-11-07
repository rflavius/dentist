<?php

$pachet = new Pachete_Servicii($db);
$facturiObj = new Facturi($db);

switch ($action)
{
	#update level la cabinete
	/*case 'script':
		$bills_infos = array();	$i=0;
		$sql = "Select * from facturi_proforme ";
		$db->query($sql);
		while($db->next_record())
		{
			$bills_infos[$i]['id'] = $db->f('id');
			$bills_infos[$i]['cost'] = $db->f('cost');
			$i++;
		}
		
		foreach($bills_infos as $ky => $val)
		{
			$sql = "Update facturi_fiscale set cost='".$val['cost']."' where id_proforma='".$val['id']."'";
			$db->query($sql);
		}
	break;

#here we take all fiscale bills and insert them to clienti
	case 'script2':
		$query_limit = " LIMIT 60";
		
		$fiscale = GetFiscaleAdmin($param1,"all:all", $query_limit,"all");
		foreach($fiscale as $ky => $val)
		{
			/*if ($val['serie_factura']<='43301')
			{
					
					$get_firm_info = GetFirme($val['user_id'],$val['firma_id']);
					$judet = $get_firm_info[0]['judet'];
					$category = $get_firm_info[0]['category_id'];
					#we might have a bill generated from admin
					$time = strtotime($val['serviciu_expirare']);
					$val['serviciu_expirare'] = strftime("%Y-%m-%d", $time);
					$query = "Insert into clienti (`id_proforma`, `id_fiscala`,`serviciu_id`,`firma_id`,`date_add`,`date_exp`,`user_id`,`judet_id`,`type_id`) 
									values('".$val['id_proforma']."','".$val['serie_factura']."','".$val['tip_promovare']."','".$val['firma_id']."','".$val['serviciu_din']."','".$val['serviciu_expirare']."','".$val['user_id']."','".$judet."','".$category."')";
					$db->query($query);
			}

			if ($val['serie_factura']>'43301')
			{
					$get_firm_info = GetFirme($val['user_id'],$val['firma_id']);
					$judet = $get_firm_info[0]['judet'];
					$category = $get_firm_info[0]['category_id'];
					$sql = "Update clienti set judet_id = '".$judet."', type_id = '".$category."' where id_fiscala='".$val['serie_factura']."'";
					$db->query($sql);
					
			}
		}
		exit;
	break;
*/


	case 'facturiproforme':

		switch($admin->level)
		{
			case '1':
				$tpl->set_file('tpl_list', 'plati/listproforme.tpl');
				#page main title
				$tpl->set_var('MAIN_TITLE', 'Listare si generare facturi proforme');
				#set blocks
				$tpl->set_block('tpl_list', 'list_messages', 'list_messages_block');
				$tpl->set_block('tpl_list', 'if_messages', 'if_messages_block');
				if($param1=="")
				{
					$param1 = "adaugare_proforma_desc";
					$param2 = "all";
					$param3 = "all";
				}
				$tpl->set_var(strtoupper($param1),"selected" );
				$tpl->set_var("SELECTED".strtoupper($param2),"selected" );
					$tpl->set_var("SELECTEDSTATUS".strtoupper($param3),"selected" );

				#count all messages
				$total_records = CountProforme($param1,$param2.":".$param3);
				$tpl->set_var('COUNT_PROFORME', $total_records);
				$pages_number = ceil($total_records/$conf->users_per_page);
				$tpl->set_var('PAGES', $pages_number);

				#create de pagination page_name
				$page_name = $module.'.'.$action;
				if(isset($_GET['start'])&&($_GET['start']!=""))
				{	$start = $_GET['start'];	}
				if(!isset($start))
				{
					$start_q = 0;
					$start = 1;
				}
				else
				{
					$start_q = $conf->users_per_page*($start-1);
				}
				#Create and parse pagination
				$html_pages = AdminPagination($conf->users_per_page, $total_records, $page_name, $start);
				$tpl->set_var("PAGINATION", $html_pages);
				$query_limit = " LIMIT $start_q, $conf->users_per_page";
				#get messages*/
				$proforme = GetProforme($param1,$param2.":".$param3, $query_limit);
				//var_dump($proforme);
				if (count($proforme) != '0')
				{
					$i = 0;
					while (list($k, $v) = each($proforme))
					{
						#set colors*/
						$bc = ($i % 2)+1;
						$tpl->set_var("BGCOLOR", 'row'.$bc);
						if(substr($v['adaugare_proforma'],0,10)==date("Y-m-d"))
						{	$tpl->set_var("BGCOLOR", "today_add");	}
						if(strtotime($v['expirare_proforma'])<=strtotime(date("Y-m-d")))
						{	$tpl->set_var("CLASSEXP", "style=\"color:red;\"");	}
						else
						{
							$tpl->set_var("CLASSEXP", "");
						}
						if($v['emis_fact_proforma']=='N')
						{
							$tpl->set_var("NOTSENT", "style=\"color:red;\"");	
						}
						$tpl->set_var('EMISA', $v['emis_fact_proforma']);

						$tpl->set_var('ID',$v['id'] );
						if($v['user_id']==='-1')
						{	$get_username="admin";}
						else
						{	$get_username = GetUserName($v['user_id']);}
						$tpl->set_var('USERNAME',$get_username );
						$tpl->set_var('USER_ID',$v['user_id'] );
						
						//$get_info_tip_promovare = GetInfoRecomandate($v['user_id'],$v['firma_id']);
						//print_r($get_info_recomandate);
						$get_tip_promovare = "";
						
						if(stristr($v['tip_promovare'],',')!==false)
						{
							$price = explode(",",$v['tip_promovare']);
							foreach($price as $ky => $val)
							{
								$pkInfo = $pachet->getPachetInfo($val);
								$get_tip_promovare = $get_tip_promovare." <br>".$pkInfo['name'];
							}
						}
						else
						{
							$pkInfo = $pachet->getPachetInfo($v['tip_promovare']);
							$get_tip_promovare = $get_tip_promovare." <br>".$pkInfo['name'];
						}
						//$get_tip_promovare = getTipPromovareName($v['tip_promovare']);
						
						$tpl->set_var('LOCPROMOVARE',$get_tip_promovare);
						
						$tpl->set_var('FIRMA_ID',$v['firma_id'] );
						$tpl->set_var('TYPE',"PF" );
						if($v['type']=='firma')
						{  $tpl->set_var('TYPE',"Firma");			}
						$tpl->set_var('AN_FACTURA',substr($v['adaugare_proforma'],0,4) );
						$tpl->set_var('EXPIRARE_PROFORMA',$v['expirare_proforma'] );
						$tpl->set_var('ADAUGARE_PROFORMA',$v['adaugare_proforma'] );
						$tpl->set_var('COST',$v['cost'] );
						#get cabinet details
						
						if($v['achitat']=='N')
						{	$tpl->set_var("CLASSNOTPAYED", "style=\"color:red;\"");	}
						else
						{
							$tpl->set_var("CLASSNOTPAYED", "");
						}
						$tpl->set_var('ACHITAT',$v['achitat'] );
						$tpl->set_var('NUME_FIRMA',substr($v['nume_firma'],0,20) );
						$tpl->set_var('EMIS_FACT_PROFORMA',$v['emis_fact_proforma'] );
						$get_fiscala = GetFiscalaForProforma($v['id']);
						if (count ($get_fiscala)>=1)
						{
							 $tpl->set_var('FACTURA_FISALA_ID',$get_fiscala['serie_factura'] );
						}
						else
						{
							$tpl->set_var('FACTURA_FISALA_ID',"--" );
						}
						
						
						if ($v['status'] == 'Y')
						{
							$tpl->set_var('IMAGE', 'active.png');
							$tpl->set_var('IMAGE_TITLE', 'inactive');
						}
						else 
						{
							$tpl->set_var('IMAGE', 'inactive.png');
							$tpl->set_var('IMAGE_TITLE', 'active');
						}
						$tpl->parse('list_messages_block', 'list_messages', true);
						$i++;
					}
					$tpl->parse('if_messages_block', 'if_messages', true);
				}
				else
				{
					$tpl->set_var('NOTFOUND',"Nu am gasit nici o ".$param1." cu aceste caracteristici!" );

				}
				#if we have information messages
				if (isset($_SESSION['admin_info']))
				{
					$tpl->set_file('tpl_info', 'info/'.$_SESSION['admin_info_type'].'.tpl');
					$tpl->set_var('MESSAGE', $_SESSION['admin_info']);
					$tpl->parse('INFORMATION', 'tpl_info');
					#uset sessions
					unset($_SESSION['admin_info']);
					unset($_SESSION['admin_info_type']);
				}
				$tpl->parse('MAIN', 'tpl_list');
			break;

			case '2':
				$tpl->set_file('tpl_list', 'plati/listproforme2.tpl');
				#page main title
				$tpl->set_var('MAIN_TITLE', 'Listare si generare facturi proforme');
				#set blocks
				$tpl->set_block('tpl_list', 'list_messages', 'list_messages_block');
				$tpl->set_block('tpl_list', 'if_messages', 'if_messages_block');
				if($param1=="")
				{
					$param1 = "adaugare_proforma_desc";
					$param2 = "all";
					$param3 = "all";
				}
				$tpl->set_var(strtoupper($param1),"selected" );
				$tpl->set_var("SELECTED".strtoupper($param2),"selected" );
					$tpl->set_var("SELECTEDSTATUS".strtoupper($param3),"selected" );

				#count all messages
				$total_records = CountProforme($param1,$param2.":".$param3,$admin->userID);
				$tpl->set_var('COUNT_PROFORME', $total_records);
				$pages_number = ceil($total_records/$conf->users_per_page);
				$tpl->set_var('PAGES', $pages_number);

				#create de pagination page_name
				$page_name = $module.'.'.$action;
				if(isset($_GET['start'])&&($_GET['start']!=""))
				{	$start = $_GET['start'];	}
				if(!isset($start))
				{
					$start_q = 0;
					$start = 1;
				}
				else
				{
					$start_q = $conf->users_per_page*($start-1);
				}
				#Create and parse pagination
				$html_pages = AdminPagination($conf->users_per_page, $total_records, $page_name, $start);
				$tpl->set_var("PAGINATION", $html_pages);
				$query_limit = " LIMIT $start_q, $conf->users_per_page";
				#get messages*/
				$proforme = GetProforme($param1,$param2.":".$param3, $query_limit,$admin->userID);
				//var_dump($proforme);
				if (count($proforme) != '0')
				{
					$i = 0;
					while (list($k, $v) = each($proforme))
					{
						#set colors*/
						$bc = ($i % 2)+1;
						$tpl->set_var("BGCOLOR", 'row'.$bc);
						if(substr($v['adaugare_proforma'],0,10)==date("Y-m-d"))
						{	$tpl->set_var("BGCOLOR", "today_add");	}
						if(strtotime($v['expirare_proforma'])<=strtotime(date("Y-m-d")))
						{	$tpl->set_var("CLASSEXP", "style=\"color:red;\"");	}
						else
						{
							$tpl->set_var("CLASSEXP", "");
						}
						if($v['emis_fact_proforma']=='N')
						{
							$tpl->set_var("NOTSENT", "style=\"color:red;\"");	
						}
						$tpl->set_var('EMISA', $v['emis_fact_proforma']);

						$tpl->set_var('ID',$v['id'] );
						if($v['user_id']==='-1')
						{	$get_username="admin";}
						else
						{	$get_username = GetUserName($v['user_id']);}
						$tpl->set_var('USERNAME',$get_username );
						$tpl->set_var('USER_ID',$v['user_id'] );
						
						$get_tip_promovare = "";
						
						$user_pachet = $pachet->getTipPromovare($v['firma_id']);
						
						//this is for the new promovare using pachete and servicii
						if(is_array($user_pachet))
						{
							$pkInfo = $pachet->getPachetInfo($user_pachet['pachet']);
							$get_tip_promovare = $pkInfo['name'];
						}
						else
						{
							if(stristr($v['tip_promovare'],',')!==false)
							{
								$price = explode(",",$v['tip_promovare']);
								foreach($price as $ky => $val)
								{
									$pkInfo = $pachet->getPachetInfo($val);
									$get_tip_promovare = $get_tip_promovare." <br>".$pkInfo['name'];
								}
							}
							else
							{
								$pkInfo = $pachet->getPachetInfo($v['tip_promovare']);
								$get_tip_promovare = $get_tip_promovare." <br>".$pkInfo['name'];
							}
							//$get_tip_promovare = getTipPromovareName($v['tip_promovare']);
							
						}
						$tpl->set_var('LOCPROMOVARE',$get_tip_promovare);
						
						
						$tpl->set_var('FIRMA_ID',$v['firma_id'] );
						$tpl->set_var('TYPE',"PF" );
						if($v['type']=='firma')
						{  $tpl->set_var('TYPE',"Firma");			}
						$tpl->set_var('AN_FACTURA',substr($v['adaugare_proforma'],0,4) );
						$tpl->set_var('EXPIRARE_PROFORMA',$v['expirare_proforma'] );
						$tpl->set_var('ADAUGARE_PROFORMA',$v['adaugare_proforma'] );
						$tpl->set_var('COST',$v['cost'] );
						
						if($v['achitat']=='N')
						{	$tpl->set_var("CLASSNOTPAYED", "style=\"color:red;\"");	}
						else
						{
							$tpl->set_var("CLASSNOTPAYED", "");
						}
						$tpl->set_var('ACHITAT',$v['achitat'] );
						$tpl->set_var('NUME_FIRMA',substr($v['nume_firma'],0,20) );
						$tpl->set_var('EMIS_FACT_PROFORMA',$v['emis_fact_proforma'] );
						$get_fiscala = GetFiscalaForProforma($v['id']);
						if (count ($get_fiscala)>=1)
						{
							 $tpl->set_var('FACTURA_FISALA_ID',$get_fiscala['serie_factura'] );
						}
						else
						{
							$tpl->set_var('FACTURA_FISALA_ID',"--" );
						}
						
						
						if ($v['status'] == 'Y')
						{
							$tpl->set_var('IMAGE', 'active.png');
							$tpl->set_var('IMAGE_TITLE', 'inactive');
						}
						else 
						{
							$tpl->set_var('IMAGE', 'inactive.png');
							$tpl->set_var('IMAGE_TITLE', 'active');
						}
						$tpl->parse('list_messages_block', 'list_messages', true);
						$i++;
					}
					$tpl->parse('if_messages_block', 'if_messages', true);
				}
				else
				{
					$tpl->set_var('NOTFOUND',"Nu am gasit nici o ".$param1." cu aceste caracteristici!" );

				}
				#if we have information messages
				if (isset($_SESSION['admin_info']))
				{
					$tpl->set_file('tpl_info', 'info/'.$_SESSION['admin_info_type'].'.tpl');
					$tpl->set_var('MESSAGE', $_SESSION['admin_info']);
					$tpl->parse('INFORMATION', 'tpl_info');
					#uset sessions
					unset($_SESSION['admin_info']);
					unset($_SESSION['admin_info_type']);
				}
				$tpl->parse('MAIN', 'tpl_list');
			break;
		}
	break;

	case 'schimba':
		$proforma_id = $param1;
		$exp_date = $param3;
		//$get_firm_info = GetFirme($get_info_proforma['user_id'],$get_info_proforma['firma_id']);
		//$get_firm_info = GetFirme('1705','1315');
		///print_r($get_firm_info);
		//exit;
		if($param2==="Y")
		{
			#doar daca factura proforma a expirat atunci statusul este inactiv
			if(strtotime($exp_date)<=strtotime(date("Y-m-d")))
			{
				$query ="Update facturi_proforme set achitat='N',status='N' where id='".$param1."'";
			}
			else
			{
				$query ="Update facturi_proforme set achitat='N',status='Y' where id='".$param1."'";
			}
			$db->query($query);
			#if something had happend we change status and in contract to
			$query ="Update contracte set achitat='N',status='N' where factura_proforma_id='".$param1."'";
			$db->query($query);
			
			#daca dezactivez sterg din facturi fiscale 
			$query ="Delete from facturi_fiscale Where id_proforma ='".$param1."'";
			$db->query($query);

		}
		else
		{

			#here we have a client,let's save all things - insert into clients,generate fiscala,generate the html bill
			$query ="Update facturi_proforme set achitat='Y',status='Y' where id='".$param1."'";
			$db->query($query);
			
			
			#lets move infos to contracte,palata a fost facut ,tocmai avem un contract
			$get_info_proforma = GetInfoProforma($param1);
			
			$facturiObj->updatePachetAchitat($get_info_proforma['firma_id']);
			#if we didn't save perioada for the client we set it now, consider the level of promotion
			$user_pachet='';
			if($get_info_proforma['perioada']=="")
			{
				$perioada = "";
				
				$user_pachet = $pachet->getTipPromovare($get_info_proforma['firma_id']);
				
				//this is for the new promovare using pachete and servicii
				if(is_array($user_pachet))
				{
					$pkInfo = $pachet->getPachetInfo($user_pachet['pachet']);
					$perioada = $pkInfo['luni'];
				}
				else
				{
					$v['tip_promovare'] = $get_info_proforma['tip_promovare'];
					if(stristr($v['tip_promovare'],',')!==false)
					{
						$price = explode(",",$v['tip_promovare']);
						foreach($price as $ky => $val)
						{
							$a = getPromovareLevelDetails($val);
							$perioada .= $a['perioada'].",";
						}
					}
					else
					{
						$a = getPromovareLevelDetails($v['tip_promovare']);
						$perioada = $a['perioada'];
					}
				}
				$get_info_proforma['perioada'] = $perioada; 
				
				$query ="UPDATE facturi_proforme SET perioada='$perioada' WHERE id='".$param1."'";
				$db->query($query);
			}
		
			$check_proforma = CheckProformaContracte($param1);
			## update the achitat field for cabinete DB table !
			$query ="UPDATE cabinete SET achitat='Y' WHERE id='".$get_info_proforma['firma_id']."'";
			$db->query($query);

			if($check_proforma=="N")
			{
				#here we have update la data promovarii de cand pana cand!!!
				$id_contract = InsertContract($get_info_proforma);
				
			}
			else
			{
				$query ="UPDATE contracte SET `achitat`='Y', `status`='Y' WHERE `factura_proforma_id`='".$param1."'";
				$db->query($query);
			}
			
			#sa introducem si la facturi fiscale informatiile necesare
			$insert_fact_to_fiscala = InsertProformaToFiscala($get_info_proforma,$id_contract);

			#insert into clienti db - informations about proforma, and id of fiscala
			$insert_ito_clienti_db = InsertClientDetails($get_info_proforma,$insert_fact_to_fiscala);

			#daca factura e recomandata sa updatam cabinetul ca si recomandat, dar si in tabela de recomandate
			if(is_array($user_pachet))
			{
				if($pachet->hasRecomandat($user_pachet['pachet']))
				{
					$query ="UPDATE cabinete SET recomandata='Y',`level`='".$get_info_proforma['tip_promovare']."' WHERE id='".$get_info_proforma['firma_id']."'";
					$db->query($query);
				
					$query ="UPDATE recomandate SET `finalizat`='Y', `date_add`='".date("y-m-d")."', `date_exp`='".date("Y-m-d", mktime(0, 0, 0, date("m")+$get_info_proforma['perioada'], date("d")+3, date("Y")))."' WHERE firma_id='".$get_info_proforma['firma_id']."'";
					$db->query($query);
				}
				$pachet->updateUserPacheteFromProforma($param1);
			}
			else
			{
				if($get_info_proforma['recomandata']=='Y')
				{
					$query ="UPDATE cabinete SET recomandata='Y',`level`='".$get_info_proforma['tip_promovare']."' WHERE id='".$get_info_proforma['firma_id']."'";
					$db->query($query);
				
					$query ="UPDATE recomandate SET finalizat='Y', date_add='".date("y-m-d")."', date_exp='".date("Y-m-d", mktime(0, 0, 0, date("m")+$get_info_proforma['perioada'], date("d")+3, date("Y")))."' WHERE firma_id='".$get_info_proforma['firma_id']."'";
					$db->query($query);
				}
				$pachet->insertUserPacheteFromProforma($param1);
			}
			
			#trebuie sa generam factura fisacala - fisierele ;
			$generate_factura_fiscala = GenerateFiscalaHtml($insert_fact_to_fiscala);

		}
		$db->query($query);
		header('location: '.GetReferer());exit;
	break;
	
	case 'cauta':
		$tpl->set_file('tpl_list', 'plati/cauta.tpl');
		#page main title
		$tpl->set_var('MAIN_TITLE', 'Cautare facturi proforme si fiscale');
		#set blocks
		$tpl->set_block('tpl_list', 'list_messages', 'list_messages_block');
		$tpl->set_block('tpl_list', 'if_messages', 'if_messages_block');
		if($param1!="" )
		{
				$tpl->set_var(strtoupper($param1),"selected" );
				$tpl->set_var('CE_CAUTAM',strtoupper(substr($param1,0,-8)) );
				$tpl->set_var('FEL_FACTURA', $param3);
				$tpl->set_var("VALOARE_CAUTARE",$param2);

				#count all messages
				$total_records = CountFacturiCauta($param1,$param2,$param3);
				$tpl->set_var('COUNT_FACTURI', $total_records);
				$pages_number = ceil($total_records/$conf->users_per_page);
				$tpl->set_var('PAGES', $pages_number);
				#create de pagination page_name
				$page_name = $module.'.'.$action.'.'.$param1.'.'.$param2.'.'.$param3;
				if(isset($_GET['start'])&&($_GET['start']!=""))
				{	$start = $_GET['start'];	}
				if(!isset($start))
				{
					$start_q = 0;
					$start = 1;
				}
				else
				{
					$start_q = $conf->users_per_page*($start-1);
				}
				#Create and parse pagination
				$html_pages = AdminPagination($conf->users_per_page, $total_records, $page_name, $start);
				$tpl->set_var("PAGINATION", $html_pages);
				$query_limit = " LIMIT $start_q, $conf->users_per_page";
				#get messages*/
				$facturi = GetFacturiCauta($param1,$param2,$param3, $query_limit);
				if (count($facturi) !='0')
				{
					$i = 0;
					while (list($k, $v) = each($facturi))
					{
						#set colors*/
						$bc = ($i % 2)+1;
						$tpl->set_var("BGCOLOR", 'row'.$bc);
						if(substr($v['adaugare_factura'],0,10)==date("Y-m-d"))
						{	$tpl->set_var("BGCOLOR", "today_add");	}
						
						if(substr($v['expirare_factura'],0,10)==date("Y-m-d"))
						{	$tpl->set_var("CLASSEXP", "style=\"color:red;\"");	}
						else
						{
							$tpl->set_var("CLASSEXP", "");
						}

						$tpl->set_var('ID',$v['id'] );
						
						if($v['user_id']==='-1')
						{	$get_username="admin";}
						else
						{	$get_username = GetUserName($v['user_id']);}
						$tpl->set_var('USERNAME',$get_username );
						$tpl->set_var('USER_ID',$v['user_id'] );
						
						$tpl->set_var('FIRMA_ID',$v['firma_id'] );
						$tpl->set_var('TYPE',ucfirst($v['type']) );
						$tpl->set_var('EXPIRARE_FACTURA',$v['expirare_factura'] );
						$tpl->set_var('ADAUGARE_FACTURA',$v['adaugare_factura'] );
						$tpl->set_var('COST',$v['cost'] );
						$tpl->set_var('ACHITAT',$v['achitat'] );
						$tpl->set_var('NUME_FIRMA',$v['nume_firma'] );
						
							if ($v['status'] == 'Y')
							{
								$tpl->set_var('IMAGE', 'active.png');
								$tpl->set_var('IMAGE_TITLE', 'inactive');
							}
							else 
							{
								$tpl->set_var('IMAGE', 'inactive.png');
								$tpl->set_var('IMAGE_TITLE', 'active');
							}

						$tpl->parse('list_messages_block', 'list_messages', true);
						$i++;
					}
					$tpl->parse('if_messages_block', 'if_messages', true);
				}
				else
				{
					$tpl->set_var('NOTFOUND',"Nu am gasit nici o ".$param1." cu aceste caracteristici!" );
				}
		}
		#if we have information messages
		if (isset($_SESSION['admin_info']))
		{
			$tpl->set_file('tpl_info', 'info/'.$_SESSION['admin_info_type'].'.tpl');
			$tpl->set_var('MESSAGE', $_SESSION['admin_info']);
			$tpl->parse('INFORMATION', 'tpl_info');
			#uset sessions
			unset($_SESSION['admin_info']);
			unset($_SESSION['admin_info_type']);
		}
		$tpl->parse('MAIN', 'tpl_list');
		
	break;

	case 'genereazaproforma':

		switch($admin->level)
		{
			case '1':
				$tpl->set_file('tpl_det', 'plati/genereaza_proforme.tpl');
				#page main title
				$tpl->set_var('MAIN_TITLE', 'Genereaza factura proforma');
				$tpl->set_var('LINK_NAME', "plati.dogenerateproforma");
				$tpl->set_block('tpl_det', 'display_types', 'display_types_block');
				if(isset($param1)&&($param1!=""))
				{
					$tpl->set_var('FIRMA_ID', $param1);
					$tpl->set_var('USER_ID',$param2);
					$get_firm_info = GetFirme($param2,$param1);
					$tpl->set_var('NUME_FIRMA',$get_firm_info[0]['nume_firma'] );
				}
				else
				{
					$get_firm_info[0]['nume_firma'] = "NUME FIRMA";
				}

				$get_all_type_promovare = getPromovareTypes();
				foreach($get_all_type_promovare as $ky => $val)
				{
					if(isset($_SESSION['submit_firma'][0])&&($_SESSION['submit_firma'][0]!=""))
					{
						$values = explode("=>",$_SESSION['submit_firma'][0]);
						if($values[1]==$val['id'] )
						{		$tpl->set_var('SELECTTEDTYPE',"selected");	}
						else
						{		$tpl->set_var('SELECTTEDTYPE',"");		}
					}
					$tpl->set_var('TYPE_NAME',$val['nume'] );
					$tpl->set_var('TYPE_ID',$val['id'] );
					$tpl->set_var('TYPE_COST',$val['pret'] );
					$tpl->set_var('TYPE_PERIOADA',$val['perioada'] );
					$tpl->parse('display_types_block', 'display_types', true);
				}

				$tpl->set_var("SERVICIU","Promovare online timp de ..... luni pentru ". $get_firm_info[0]['nume_firma'] ." pe www.dentistonline.ro in cadrul cabinetelor recomandate.");
				
				// sistem nou de promovare
				
				$tpl->set_block('tpl_det', 'list_pachete', 'list_pachete2');
				$tpl->set_block('tpl_det', 'list_servicii', 'list_servicii2');
				$tpl->set_file('tpl_cump','users/facturare.tpl');
				
				
				$tpl->set_var('CAB_ID', $param1);
				$tpl->set_var('USER_ID', getUseridForCabinet($param1));
				
				//list pachete
				$all_pk = $pachet->listPacheteBackend();
				foreach($all_pk  as $ky => $val)
				{
					$tpl->set_var('PACHET', $val['name']);
					$tpl->set_var('PACHET_ID', $val['id']);
					$tpl->set_var('COST', $val['pret']);
				
					$tpl->parse('list_pachete2', 'list_pachete', true);
				}
				
				//aici listam doar serviciile care sunt contra cost, excludem cele care sunt gratuite pentru a nu lista serviciile gratuite la pachetul basic
				$servs = $pachet->listServiciiPreferentiale();
				foreach($servs as $ky=>$val)
				{
					$tpl->set_var('SERV', $val['name']);
					$tpl->set_var('SERV_ID', $val['id']);
					$tpl->set_var('SERV_PRET', $val['price']);
					$tpl->set_var('SERV_CHECK', '');
				
					if($val['value']!='')
					{
						$tpl->set_var('VALUE', "(".$val['value']." afisari)");
					}
					else
					{
						$tpl->set_var('VALUE', "");
					}
				
					$tpl->parse('list_servicii2', 'list_servicii', true);
				}
				$tpl->parse('FACTURARE_BLOCK','tpl_cump');
				
				
				if (isset($_SESSION['admin_info'])) 
				{
					$tpl->set_file('tpl_info', 'info/'.$_SESSION['admin_info_type'].'.tpl');
					$tpl->set_var('MESSAGE', $_SESSION['admin_info']);
					$tpl->parse('INFORMATION', 'tpl_info');
					
					if(isset($_SESSION['admin_info_values']))
					{
						foreach ($_SESSION['admin_info_values'] as $key=>$value) 
						{
							$tpl->set_var(strtoupper($key),$value);
						}
						unset($_SESSION['admin_info_values']);
					}
					#uset sessions
					unset($_SESSION['admin_info']);
					unset($_SESSION['admin_info_type']);
				}
				$tpl->set_var('DIV_TYPE','none' );
				$tpl->parse('MAIN', 'tpl_det');
			break;

			case '2':
				$tpl->set_file('tpl_det', 'plati/genereaza_proforme2.tpl');
				#page main title
				$tpl->set_var('MAIN_TITLE', 'Genereaza factura proforma');
				$tpl->set_var('LINK_NAME', "plati.dogenerateproforma");
				$tpl->set_block('tpl_det', 'display_types', 'display_types_block');
				if(isset($param1)&&($param1!=""))
				{
					$tpl->set_var('FIRMA_ID', $param1);
					$tpl->set_var('USER_ID',$param2);
					$get_firm_info = GetFirme($param2,$param1);
					$tpl->set_var('NUME_FIRMA',$get_firm_info[0]['nume_firma'] );
					$tpl->set_var('EMAIL',$get_firm_info[0]['persc_email'].', '.$get_firm_info[0]['email_firma'] );
				}
				else
				{
					$get_firm_info[0]['nume_firma'] = "NUME FIRMA";
				}

				$get_all_type_promovare = getPromovareTypes();
				foreach($get_all_type_promovare as $ky => $val)
				{
					if(isset($_SESSION['submit_firma'][0])&&($_SESSION['submit_firma'][0]!=""))
					{
						$values = explode("=>",$_SESSION['submit_firma'][0]);
						if($values[1]==$val['id'] )
						{		$tpl->set_var('SELECTTEDTYPE',"selected");	}
						else
						{		$tpl->set_var('SELECTTEDTYPE',"");		}
					}
					$tpl->set_var('TYPE_NAME',$val['nume'] );
					$tpl->set_var('TYPE_ID',$val['id'] );
					$tpl->set_var('TYPE_COST',$val['pret'] );
					$tpl->set_var('TYPE_PERIOADA',$val['perioada'] );
					$tpl->parse('display_types_block', 'display_types', true);
				}

				$tpl->set_var("SERVICIU","Promovare online timp de ..... luni pentru ". $get_firm_info[0]['nume_firma'] ." pe www.dentistonline.ro in cadrul cabinetelor recomandate.");
				
				// sistem nou de promovare
				
				$tpl->set_block('tpl_det', 'list_pachete', 'list_pachete2');
				$tpl->set_block('tpl_det', 'list_servicii', 'list_servicii2');
				$tpl->set_file('tpl_cump','users/facturare.tpl');
				
				
				$tpl->set_var('CAB_ID', $param1);
				//$tpl->set_var('USER_ID', getUseridForCabinet($param1));
				
				//list pachete
				$all_pk = $pachet->listPacheteBackend();
				foreach($all_pk  as $ky => $val)
				{
					$tpl->set_var('PACHET', $val['name']);
					$tpl->set_var('PACHET_ID', $val['id']);
					$tpl->set_var('COST', $val['pret']);
				
					$tpl->parse('list_pachete2', 'list_pachete', true);
				}
				
				//aici listam doar serviciile care sunt contra cost, excludem cele care sunt gratuite pentru a nu lista serviciile gratuite la pachetul basic
				$servs = $pachet->listServiciiPreferentiale();
				foreach($servs as $ky=>$val)
				{
					$tpl->set_var('SERV', $val['name']);
					$tpl->set_var('SERV_ID', $val['id']);
					$tpl->set_var('SERV_PRET', $val['price']);
					$tpl->set_var('SERV_CHECK', '');
				
					if($val['value']!='')
					{
						$tpl->set_var('VALUE', "(".$val['value']." afisari)");
					}
					else
					{
						$tpl->set_var('VALUE', "");
					}
				
					$tpl->parse('list_servicii2', 'list_servicii', true);
				}
				$tpl->parse('FACTURARE_BLOCK','tpl_cump');
				
				
				
				// display erros , warning, success
				if (isset($_SESSION['admin_info'])) 
				{
					$tpl->set_file('tpl_info', 'info/'.$_SESSION['admin_info_type'].'.tpl');
					$tpl->set_var('MESSAGE', $_SESSION['admin_info']);
					$tpl->parse('INFORMATION', 'tpl_info');
					
					if(isset($_SESSION['admin_info_values']))
					{
						foreach ($_SESSION['admin_info_values'] as $key=>$value) 
						{
							$tpl->set_var(strtoupper($key),$value);
						}
						unset($_SESSION['admin_info_values']);
					}
					#uset sessions
					unset($_SESSION['admin_info']);
					unset($_SESSION['admin_info_type']);
				}
				$tpl->set_var('DIV_TYPE','none' );
				$tpl->parse('MAIN', 'tpl_det');
			break;
		}

	break;

	case 'dogenerateproforma':
		
		//print_r($_POST);exit;
		
		switch($_POST['promovare_tip'])
		{
			case 'vechi':
				$expected = array('price','name','adresa_vechi','user_id','firma_id','email_vechi','nume_firma');
				$error="";
				foreach ($expected as $key)
				{
					if ($_POST[$key]=="")
					{
						$error .= "<li>Va rugam sa complectati campul: <b>".$key."</b></li>";
					}
				}
				// this is a simple fix because we had the same field twice and it got suprascris LOL
				$_POST['adresa'] = $_POST['adresa_vechi'];
				$_POST['email'] = $_POST['email_vechi'];
				
				/*if(isset($_POST['email'])&&($_POST['email']!=""))
				{
					$email = ValidEmail($_POST['email']);
					if(!$email)
					{
						$error .="<li>Adresa de email a persoanei de contact este invalida.</li>";
						$_SESSION['admin_info_values']['email'] = $_POST['email'];
					}
				}*/
				
				if ($error!="")
				{
					foreach ($_POST as $key=>$value)
					{
						$_SESSION['admin_info_values'][$key] = $value;
					}
					$_SESSION['admin_info'] = '<ul>'.$error.'</ul>';
					$_SESSION['admin_info_type'] = 'error';
					header('location: index.php?page=plati.genereazaproforma');
					exit;
				}
				else
				{
					#functia genera continutul din factura
					//$content = GenereteFacturaContent($_POST);
					$content = $_POST['serviciu'];
					//print_r($_POST);exit;
					$id_proforma = AddFacturaProforma($_POST,$content,$admin->userID);
					#daca e factura pentru cabinet recomandat atunci o inseram in recomandate
					/*if($_POST['recomandat']=='Y')
					{
					InsertToRecomandate($_POST['user_id'],$_POST['firma_id'],"",$judet_id,$cab_type,$_POST['perioada'],$id_proforma,$_POST['loc'],$_POST['tip_promovare']);
					}*/
					$_SESSION['email_to_send'] = $_POST['email'];
					#aici trebuie sa generam si fisierul html,pdf pentru factura proforma!!!
					
					
					#generare factura html
					$generate_proforma = GenerateFacturaProforma($id_proforma);
					$_SESSION['admin_info'] = 'Factura proforma a fost generata cu succes ! Atentie nu a fost trimisa utilizatorului';
					$_SESSION['admin_info_type'] = 'info';
					header('location: index.php?page=plati.facturiproforme');
					exit;
				}
			break;
			
			case 'nou':
				$expected = array('user_id','firma_id','email','nume_firma');
				$error="";
				foreach ($expected as $key)
				{
					if ($_POST[$key]=="")
					{
						$error .= "<li>Va rugam sa complectati campul: <b>".$key."</b></li>";
					}
				}
				
				/*if(isset($_POST['email'])&&($_POST['email']!=""))
				{
					$email = ValidEmail($_POST['email']);
					if(!$email)
					{
						$error .="<li>Adresa de email a persoanei de contact este invalida.</li>";
						$_SESSION['admin_info_values']['email'] = $_POST['email'];
					}
				}*/
				
				if ($error!="")
				{
					foreach ($_POST as $key=>$value)
					{
						$_SESSION['admin_info_values'][$key] = $value;
					}
					$_SESSION['admin_info'] = '<ul>'.$error.'</ul>';
					$_SESSION['admin_info_type'] = 'error';
					header('location: index.php?page=plati.genereazaproforma');
					exit;
				}
				else
				{
					if($_POST['total_price']!='0')
					{
						$cump_id = $facturiObj->addCumparator();
						$_POST['pachet'] = $_POST['firma_pachet'];
						$_POST['servicii'] = $_POST['firma_servicii'];
						$_POST['nume_firma'] = $_POST['nume'];
						$_POST['pers_contact'] = $_POST['nume'];
						$_POST['total'] = $_POST['total_price'];
						$_POST['persc_email'] = $_POST['email'];
						$_POST['adresa_firma'] = $_POST['adresa'];
						if($_POST['cui']!='')
						{
							$_POST['type'] = 'firma';
						}
						else
						{
							$_POST['type'] = 'persoana_fizica';
						}
						$plata_id = $facturiObj->addAdminProforma($_POST['user_id'],$_POST['firma_id'],$_POST,'',$cump_id);
						$facturiObj->assignProformaAgent($plata_id,$admin->userID);
						### generate the HTML file for factura proforma
						$facturiObj->saveProformaFile($plata_id);
					}
					else
					{
						$facturiObj->updatePachetAchitat($_POST['firma_id']);
					}
					$facturiObj->assignCabinetAgent($_POST['firma_id'],$admin->userID);
					$_SESSION['admin_info'] = 'Factura proforma a fost generata cu succes ! Atentie nu a fost trimisa utilizatorului';
					$_SESSION['admin_info_type'] = 'info';
					header('location: index.php?page=plati.facturiproforme');
					exit;
				}
			break;
		}
	break;

	case 'viewproforma':
		$id_proforma = $param1;
		$tpl->set_var('ID', $id_proforma );
		$tpl->set_file('tpl_facturi', 'plati/viewfacturi.tpl');
		$text = GetFileContent("../facturi/facturi_proforme/proforma_".$id_proforma.".html");
		$tpl->set_var('FACTURA_CONTENT',$text );
		$tpl->set_var('TRIMITE_FACTURA','trimiteproforma');
		$tpl->parse('MAIN', 'tpl_facturi', true);
	break;

	case 'trimiteproforma':
		$id_proforma = $param1;
		$text = GetFileContent("../facturi/facturi_proforme/proforma_".$id_proforma.".html");
		$proforma_details = GetInfoProforma($id_proforma);
		#trimitem factura proforma
		$CustomHeaders = '';
		$Subject = "Factura proforma";	
		$Sender = 'Admin DentistOnline.ro<'.$conf->contact_recipient.'>';
		$Recipiant = trim($proforma_details['email']);
		//echo $Recipiant;exit;
		$message = new Email($Recipiant, $Sender, $Subject, $CustomHeaders);
		$message->SetHtmlContent($text);
		if (ValidHeader($Sender))
		{
			$message->Send();
			$query = "Update facturi_proforme set emis_fact_proforma='Y' where id='".$id_proforma."'"; 
			$db->query($query);
		}
		else
		{
			$emis_fact="N";
			$query ="Update plati set emis_fact_proforma='N' where id='".$nr_fact_proforma."'";
			$db->query($query);

		}

		$_SESSION['admin_info'] = 'Factura proforma a fost trimisa cu succes !';
		$_SESSION['admin_info_type'] = 'info';
		header('location: index.php?page=plati.facturiproforme');
		exit;
		
	break;

	case 'detaliiproforma':
		$tpl->set_file('tpl_det', 'plati/detaliiproforma.tpl');
		#page main title
		$tpl->set_var('MAIN_TITLE', 'Detalii factura proforma '. $param1);
		$tpl->set_var('BGCOLOR1',"row1" );
		$tpl->set_var('BGCOLOR2',"row2" );
		#set blocks
		$proforma_details = GetInfoProforma($param1);
		$get_user_info = GetUser($proforma_details['user_id']);
		$tpl->set_var('USERNAME',$get_user_info );
		foreach($proforma_details as $ky => $val)
		{
			$tpl->set_var(strtoupper($ky),$val );
		}
		$tpl->parse('MAIN', 'tpl_det');
	break;
	
	#we have to update the data base proforma
	case 'updateproforma':
		$id_proforma = $param1;
		$update_databse = UpdateProforma($_POST,$id_proforma);
		$_SESSION['admin_info'] = 'Factura proforma a fost modificata cu succes !';
		$_SESSION['admin_info_type'] = 'info';
		header('location: index.php?page=plati.facturiproforme');

		
	break;
	#********************************* Prelungeste promovare********************************************
	case 'prelungestepromovare':
		$tpl->set_file('tpl_det', 'plati/genereaza_proforme.tpl');
		#page main title
		$tpl->set_var('MAIN_TITLE', '<b>Prelungeste promovarea - generam o noua factura proforma</b>');
		$tpl->set_var('LINK_NAME', "plati.doprelungeste");
		if(isset($param1)&&($param1!=""))
		{
			$tpl->set_var('FIRMA_ID', $param1);
			$tpl->set_var('USER_ID',$param2);
			$get_firm_info = GetFirme($param2,$param1);
			$tpl->set_var('NUME_FIRMA',$get_firm_info[0]['nume_firma'] );
		}
		else
		{
			$get_firm_info[0]['nume_firma'] = "NUME FIRMA";
		}
		$tpl->set_var("SERVICIU","Promovare online timp de ..... luni pentru ". $get_firm_info[0]['nume_firma'] ." pe www.dentistonline.ro in cadrul cabinetelor recomandate.");
		
		$get_cumparator_id = GetCumparatorId($param2,$param1);
		$get_cumparator_details = GetCumapratorInformations($get_cumparator_id );

		$tpl->set_var('NUME_FIRMA',$get_cumparator_details['nume'] );
		$tpl->set_var('ADRESA',$get_cumparator_details['adresa'] );
		$tpl->set_var('CUI',$get_cumparator_details['cui'] );
		$tpl->set_var('CNP',$get_cumparator_details['cnp'] );
		$tpl->set_var('BI',$get_cumparator_details['bi'] );
		$tpl->set_var('RC',$get_cumparator_details['rc'] );
		

		if (isset($_SESSION['admin_info'])) 
		{
			$tpl->set_file('tpl_info', 'info/'.$_SESSION['admin_info_type'].'.tpl');
			$tpl->set_var('MESSAGE', $_SESSION['admin_info']);
			$tpl->parse('INFORMATION', 'tpl_info');
			
			if(isset($_SESSION['admin_info_values']))
			{
				foreach ($_SESSION['admin_info_values'] as $key=>$value) 
				{
					$tpl->set_var(strtoupper($key),$value);
				}
				unset($_SESSION['admin_info_values']);
			}
			#uset sessions
			unset($_SESSION['admin_info']);
			unset($_SESSION['admin_info_type']);
		}
		$tpl->set_var('DIV_TYPE','none' );
		$tpl->parse('MAIN', 'tpl_det');
	
	break;

	case 'doprelungeste':
		$expected = array('price','name','adresa','user_id','firma_id','email','nume_firma');
		$error="";
		foreach ($expected as $key) 
		{
			if ($_POST[$key]=="") 
			{
				$error .= "<li>Va rugam sa complectati campul: <b>".$key."</b></li>";
			}
		}
		if(isset($_POST['email'])&&($_POST['email']!=""))
		{
			$email = ValidEmail($_POST['email']);
			if(!$email)
			{	
				$error .="<li>Adresa de email a persoanei de contact este invalida.</li>";
				$_SESSION['admin_info_values']['email'] = $_POST['email'];
			}
		}
		#daca e recomandat verificam daca mai sunt locuri pentru judetul si tipul cerut, eg. cabinete stomatologice cj
		if ($error!="") 
		{
			foreach ($_POST as $key=>$value) 
			{
				$_SESSION['admin_info_values'][$key] = $value;
			}
			$_SESSION['admin_info'] = '<ul>'.$error.'</ul>';
			$_SESSION['admin_info_type'] = 'error';
			header('location: index.php?page=plati.genereazaproforma');
			exit;
		}
		else 
		{
			#functia genera continutul din factura
			//$content = GenereteFacturaContent($_POST);
			$content = $_POST['serviciu'];
			$id_proforma = AddFacturaProforma($_POST,$content);
			#daca e factura pentru cabinet recomandat atunci o inseram in recomandate
			if($_POST['recomandat']=='Y')
			{
				InsertToRecomandate($_POST['user_id'],$_POST['firma_id'],"",$judet_id,$cab_type,$_POST['perioada'],$id_proforma,$_POST['loc'],$_POST['tip_promovare']);
			}
			$_SESSION['email_to_send'] = $_POST['email'];
			#aici trebuie sa generam si fisierul html,pdf pentru factura proforma!!!
			
			#let's clear the last infomatios about old promoteing form recomnadte db

			
			#generare factura html
			$generate_proforma = GenerateFacturaProforma($id_proforma);
			$_SESSION['admin_info'] = 'Factura proforma a fost generata cu succes ! Atentie nu a fost trimisa utilizatorului';
			$_SESSION['admin_info_type'] = 'info';
			header('location: index.php?page=plati.facturiproforme');
			exit;
		}
	break;

	/****************************************Facturi Fiscale grouped by users and all together ***************************/
	# facturi group by users
	case 'facturifiscale':
		$tpl->set_file('tpl_list', 'plati/listfiscale.tpl');
		#page main title
		$tpl->set_var('MAIN_TITLE', 'Listare facturi fiscale');
		#set blocks
		$tpl->set_block('tpl_list', 'list_messages', 'list_messages_block');
		$tpl->set_block('tpl_list', 'if_messages', 'if_messages_block');
		if($param1=="")
		{
			$param1 = "serviciu_expirare_ASC";
			$param2 = "all";
			$param3 = "all";
			$param4 = "all";
		}
		$tpl->set_var(strtoupper($param1),"selected" );
		$tpl->set_var("SELECTED".strtoupper($param2),"selected" );
		$tpl->set_var("SELECTEDSTATUS".strtoupper($param3),"selected" );

		$total_records = CountFiscaleAdminCurente($param1);
		$tpl->set_var('COUNT_FISCALE', $total_records);

		$total_records_fiscale = CountFiscale('data_eliberarii_desc','all:all');
		$tpl->set_var('COUNT_FISCALE_TOTAL', $total_records_fiscale);

		
		$pages_number = ceil($total_records/$conf->users_per_page);
		$tpl->set_var('PAGES', $pages_number);
		#create de pagination page_name
		$page_name = $module.'.'.$action.'.'.$param1.'.'.$param2.'.'.$param3;
		if(isset($_GET['start'])&&($_GET['start']!=""))
		{	$start = $_GET['start'];	}
		if(!isset($start))
		{
			$start_q = 0;
			$start = 1;
		}
		else
		{
			$start_q = $conf->users_per_page*($start-1);
		}
		#Create and parse pagination
		$html_pages = AdminPagination($conf->users_per_page, $total_records, $page_name, $start);
		$tpl->set_var("PAGINATION", $html_pages);
		$query_limit = " LIMIT $start_q, $conf->users_per_page";
		$all_cost = 0;
		#get messages*/
		$fiscale = GetFiscaleAdminCurente($param1,$param2.":".$param3, $query_limit,$param4);
		if (count($fiscale) != '0')
		{
			$i = 0;
			while (list($k, $v) = each($fiscale))
			{
				#set colors*/
				$bc = ($i % 2)+1;
				$tpl->set_var("BGCOLOR", 'row'.$bc);
				if(substr($v['data_eliberarii'],0,10)==date("Y-m-d"))
				{	$tpl->set_var("BGCOLOR", "today_add");	}
				$tpl->set_var('DATA_ELIBERARII',$v['data_eliberarii'] );
				
				if(strtotime($v['serviciu_expirare'])< (strtotime(date("Y-m-d"))+460000))
				{	$tpl->set_var("CLASSEXPIRE", "style=\"color:red;font-weight:bold;\"");	}
				else
				{
					$tpl->set_var("CLASSEXPIRE", "");
				}
				$tpl->set_var('DATE_PROMOVARE',TimeFormatEvents($v['serviciu_din']));
				$tpl->set_var('DATA_EXPIRE',TimeFormatEvents($v['serviciu_expirare']));
				$tpl->set_var("COST", $v['cost']);
				$tpl->set_var("COMMENT", $v['comment_bill']);
				
				$tpl->set_var('ID_FACTURA',$v['serie_factura'] );
				if($v['user_id']==='-1')
				{	$get_username="admin";}
				else
				{	
				$get_username = GetUserName($v['user_id']);}
				$tpl->set_var('USERNAME',$get_username );
				$tpl->set_var('USER_ID',$v['user_id'] );
				$tpl->set_var('ID_PROFORMA',$v['id_proforma'] );
				$tpl->set_var('TRIMISA',$v['trimisa'] );
				if($v['trimisa']=='N')
				{	
					$tpl->set_var("CLASSNOTPAYED", "style=\"color:red;\"");	
					$tpl->set_var('IMAGEPRINT',"noprint.jpg" );
					}
				else
				{
					$tpl->set_var('IMAGEPRINT', "print.jpg");
					$tpl->set_var("CLASSNOTPAYED", "");
				}

				#lets set some firma details
				$array_cabinet_type=array('1'=>'Cabinet','2'=>'Laborator teh','3'=>'Radiologie','4'=>'Distribuitor','5'=>'Clinica');
				$cabinet_det = GetCabInfo($v['firma_id']);
				$tpl->set_var("JUDET", $cabinet_det['judet']);
				$typecabinet = $cabinet_det['category_id'];
				$tpl->set_var("TYPE_CAB", $array_cabinet_type[$typecabinet]);
				$tpl->set_var("NUME_FIRMA", substr($cabinet_det['nume_firma'],0,20));
				$tpl->set_var("ID_CABINET", $v['firma_id']);

				$info_proforma = GetInfoProforma($v['id_proforma']);
				
				$tpl->set_var("PERIOADA_PROMOV", $info_proforma['perioada']);
				$all_cost = $all_cost+$info_proforma['cost'];


				#lets count all facturi fiscale for user
				$nr_fiscale = CountFiscaleForUser($v['user_id']);
				$tpl->set_var("NR_FACT_FISCALE", $nr_fiscale );
				

				
				$tpl->parse('list_messages_block', 'list_messages', true);
				$i++;
			}
			$tpl->parse('if_messages_block', 'if_messages', true);
		}
		else
		{
			$tpl->set_var('NOTFOUND',"Nu am gasit nici o ".$param1." cu aceste caracteristici!" );
		}
		$tpl->set_var('CASTIG_DENTIST',	$all_cost );
		#if we have information messages
		if (isset($_SESSION['admin_info']))
		{
			$tpl->set_file('tpl_info', 'info/'.$_SESSION['admin_info_type'].'.tpl');
			$tpl->set_var('MESSAGE', $_SESSION['admin_info']);
			$tpl->parse('INFORMATION', 'tpl_info');
			#uset sessions
			unset($_SESSION['admin_info']);
			unset($_SESSION['admin_info_type']);
		}
		$tpl->parse('MAIN', 'tpl_list');
	break;

	case 'listfiscaleuser':
		$tpl->set_file('tpl_list', 'plati/listfiscaleuser.tpl');
		#page main title
		$tpl->set_var('MAIN_TITLE', 'Listare facturi fiscale pentru: '.$param2);
		
		#set blocks
		$tpl->set_block('tpl_list', 'list_messages', 'list_messages_block');
		$tpl->set_block('tpl_list', 'if_messages', 'if_messages_block');
				
		#count all facturi for user
		//$total_records = CountFiscaleAdminOnUsers("all");
		//$tpl->set_var('COUNT_FISCALE_TOTAL', $total_records);

		
		$tpl->set_var('COUNT_FISCALE_FOR_USER', $param3);

		#get Facturi Fiscale  by user
		$fiscale = GetFiscaleAdminOnUsers($param1,"","");
		if (count($fiscale) != '0')
		{
			$i = 0;
			while (list($k, $v) = each($fiscale))
			{
				#set colors
				$bc = ($i % 2)+1;
				$tpl->set_var("BGCOLOR", 'row'.$bc);
				if(substr($v['data_eliberarii'],0,10)==date("Y-m-d"))
				{	$tpl->set_var("BGCOLOR", "today_add");	}
				$tpl->set_var('DATA_ELIBERARII',$v['data_eliberarii'] );
				if(strtotime($v['serviciu_expirare'])< (strtotime(date("Y-m-d"))+360000))
				{	$tpl->set_var("CLASSEXPIRE", "style=\"color:red;font-weight:bold;\"");	}
				else
				{	$tpl->set_var("CLASSEXPIRE", "");				}

				$tpl->set_var('DATE_PROMOVARE',TimeFormatEvents($v['serviciu_din']));
				$tpl->set_var('DATA_EXPIRE',TimeFormatEvents($v['serviciu_expirare']));
				$tpl->set_var('ID_FACTURA',$v['serie_factura'] );
				if($v['user_id']==='-1')
				{	$get_username="admin";}
				else
				{	
					
					$tpl->set_var('USERNAME',$param2 );
					$tpl->set_var('USER_ID',$v['user_id'] );
					$tpl->set_var('ID_PROFORMA',$v['id_proforma'] );
					$tpl->set_var('TRIMISA',$v['trimisa'] );
					if($v['trimisa']=='N')
					{	$tpl->set_var('IMAGEPRINT',"noprint.jpg" );	}
					else
					{	$tpl->set_var('IMAGEPRINT', "print.jpg");	}
					
					#lets set some cabinet details
					$array_cabinet_type=array('1'=>'Cabinet','2'=>'Laborator teh','3'=>'Radiologie','4'=>'Distribuitor','5'=>'Clinica');
					$cabinet_det = GetCabInfo($v['firma_id']);
					$tpl->set_var("JUDET", $cabinet_det['judet']);
					$typecabinet = $cabinet_det['category_id'];
					$tpl->set_var("TYPE_CAB", $array_cabinet_type[$typecabinet]);
					$tpl->set_var("NUME_FIRMA", $cabinet_det['nume_firma'],0,22);
					$tpl->set_var("ID_CABINET", $v['firma_id']);

					//$info_proforma = GetInfoProforma($v['id_proforma']);
					$tpl->set_var("COST", $v['cost']);
					$perioada_promo = getPromovareLevelDetails($v['tip_promovare']);
					//var_dump($perioada);
					$tpl->set_var("PERIOADA_PROMOV", $perioada_promo['perioada']);
				}
					$tpl->parse('list_messages_block', 'list_messages', true);
					$i++;
				}
				$tpl->parse('if_messages_block', 'if_messages', true);
		}
		else
		{
			$tpl->set_var('NOTFOUND',"Nu am gasit nici o ".$param1." cu aceste caracteristici!" );
		}
		#if we have information messages
		if (isset($_SESSION['admin_info']))
		{
			$tpl->set_file('tpl_info', 'info/'.$_SESSION['admin_info_type'].'.tpl');
			$tpl->set_var('MESSAGE', $_SESSION['admin_info']);
			$tpl->parse('INFORMATION', 'tpl_info');
			#uset sessions
			unset($_SESSION['admin_info']);
			unset($_SESSION['admin_info_type']);
		}
		$tpl->parse('MAIN', 'tpl_list');
	break;

	case 'toatefacturifiscale':
		$tpl->set_file('tpl_list', 'plati/toatefacturifiscale.tpl');
		#page main title
		$tpl->set_var('MAIN_TITLE', 'Listare facturi fiscale');
		#set blocks
		$tpl->set_block('tpl_list', 'list_messages', 'list_messages_block');
		$tpl->set_block('tpl_list', 'if_messages', 'if_messages_block');
		if($param1=="")
		{
			$param1 = "serviciu_expirare_ASC";
			$param2 = "all";
			$param3 = "all";
			$param4 = "all";
		}
		$tpl->set_var(strtoupper($param1),"selected" );
		$tpl->set_var("SELECTED".strtoupper($param2),"selected" );
		$tpl->set_var("SELECTEDSTATUS".strtoupper($param3),"selected" );

		#count all messages
		$total_records = CountFiscaleAdmin($param1,$param2.":".$param3);
		$total_records_on_users = CountFiscaleAdminCurente("");
		$tpl->set_var('COUNT_FISCALE', $total_records);
		$tpl->set_var('COUNT_FISCALE_ONUSERS', $total_records_on_users );
		$pages_number = ceil($total_records/$conf->users_per_page);
		$tpl->set_var('PAGES', $pages_number);
		#create de pagination page_name
		$page_name = $module.'.'.$action.'.'.$param1.'.'.$param2.'.'.$param3;
		if(isset($_GET['start'])&&($_GET['start']!=""))
		{	$start = $_GET['start'];	}
		if(!isset($start))
		{
			$start_q = 0;
			$start = 1;
		}
		else
		{
			$start_q = $conf->users_per_page*($start-1);
		}
		#Create and parse pagination
		$html_pages = AdminPagination($conf->users_per_page, $total_records, $page_name, $start);
		$tpl->set_var("PAGINATION", $html_pages);
		$query_limit = " LIMIT $start_q, $conf->users_per_page";
		$all_cost = 0;
		#get messages*/
		$fiscale = GetFiscaleAdmin($param1,$param2.":".$param3, $query_limit,$param4);
		if (count($fiscale) != '0')
		{
			$i = 0;
			while (list($k, $v) = each($fiscale))
			{
				#set colors*/
				$bc = ($i % 2)+1;
				$tpl->set_var("BGCOLOR", 'row'.$bc);
				if(substr($v['data_eliberarii'],0,10)==date("Y-m-d"))
				{	$tpl->set_var("BGCOLOR", "today_add");	}
				$tpl->set_var('DATA_ELIBERARII',$v['data_eliberarii'] );
				
				if(strtotime($v['serviciu_expirare'])< (strtotime(date("Y-m-d"))+360000))
				{	$tpl->set_var("CLASSEXPIRE", "style=\"color:red;font-weight:bold;\"");	}
				else
				{
					$tpl->set_var("CLASSEXPIRE", "");
				}
				$tpl->set_var('DATE_PROMOVARE',TimeFormatEvents($v['serviciu_din']));
				$tpl->set_var('DATA_EXPIRE',TimeFormatEvents($v['serviciu_expirare']));
				$tpl->set_var('ID_FACTURA',$v['serie_factura'] );
				if($v['user_id']==='-1')
				{	$get_username="admin";}
				else
				{	
				$get_username = GetUserName($v['user_id']);}
				$tpl->set_var('USERNAME',$get_username );
				$tpl->set_var('USER_ID',$v['user_id'] );
				$tpl->set_var('ID_PROFORMA',$v['id_proforma'] );
				$tpl->set_var('TRIMISA',$v['trimisa'] );
				if($v['trimisa']=='N')
				{	
					$tpl->set_var("CLASSNOTPAYED", "style=\"color:red;\"");	
					$tpl->set_var('IMAGEPRINT',"noprint.jpg" );
					}
				else
				{
					$tpl->set_var('IMAGEPRINT', "print.jpg");
					$tpl->set_var("CLASSNOTPAYED", "");
				}

				#lets set some firma details
				$array_cabinet_type=array('1'=>'Cabinet','2'=>'Laborator teh','3'=>'Radiologie','4'=>'Distribuitor','5'=>'Clinica');
				$cabinet_det = GetCabInfo($v['firma_id']);
				$tpl->set_var("JUDET", $cabinet_det['judet']);
				$typecabinet = $cabinet_det['category_id'];
				$tpl->set_var("TYPE_CAB", $array_cabinet_type[$typecabinet]);
				$tpl->set_var("NUME_FIRMA", $cabinet_det['nume_firma']);
				$tpl->set_var("ID_CABINET", $v['firma_id']);

				$info_proforma = GetInfoProforma($v['id_proforma']);
				$tpl->set_var("COST", $info_proforma['cost']);
				$tpl->set_var("PERIOADA_PROMOV", $info_proforma['perioada']);
				
				$all_cost = $all_cost+$info_proforma['cost'];

				
				$tpl->parse('list_messages_block', 'list_messages', true);
				$i++;
			}
			$tpl->parse('if_messages_block', 'if_messages', true);
		}
		else
		{
			$tpl->set_var('NOTFOUND',"Nu am gasit nici o ".$param1." cu aceste caracteristici!" );
		}
		$tpl->set_var('CASTIG_DENTIST',	$all_cost );
		#if we have information messages
		if (isset($_SESSION['admin_info']))
		{
			$tpl->set_file('tpl_info', 'info/'.$_SESSION['admin_info_type'].'.tpl');
			$tpl->set_var('MESSAGE', $_SESSION['admin_info']);
			$tpl->parse('INFORMATION', 'tpl_info');
			#uset sessions
			unset($_SESSION['admin_info']);
			unset($_SESSION['admin_info_type']);
		}
		$tpl->parse('MAIN', 'tpl_list');
	break;
	
	case 'viewfiscala':
		$id_fis = $param1;
		$tpl->set_var('ID', $id_fis );
		$tpl->set_file('tpl_facturi', 'plati/viewfacturi.tpl');
		$text = GetFileContent("../facturi/facturi_fiscale/fiscala_".$id_fis.".html");
		$tpl->set_var('FACTURA_CONTENT',$text );
		$tpl->set_var('TRIMITE_FACTURA','trimitefiscala');
		$tpl->parse('MAIN', 'tpl_facturi', true);
	break;

	case 'print':
		$id_fisacla = $param1;
		$text = GetFileContent("../facturi/facturi_fiscale/fiscala_".$id_fisacla.".html");
		echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"><html><head>
		<script>
			function printWindow(){
			bV = parseInt(navigator.appVersion)
			if (bV >= 4) window.print();
			window.close();
			}
		</script>
		</head>
		<body onload="printWindow()">';echo '<b>'. $text.'</b><br />';
		echo '</body></html>';
		#use exit so the all output wont be shown
		exit;
		
	break;

	case 'trimitefiscala':
		$id_fiscala = $param1;
		$text = GetFileContent("../facturi/facturi_fiscale/fiscala_".$id_fiscala.".html");
		$fiscala_details = GetFacturaFiscala($id_fiscala);
		$id_proforma = $fiscala_details['id_proforma'];
		$proforma_details = GetInfoProforma($id_proforma);
		
		#trimitem factura fiscala
		$CustomHeaders = '';
		$Subject = "Factura emisa";	
		$Sender = 'Admin DentistOnline.ro<'.$conf->contact_recipient.'>';
		$Recipiant = trim($proforma_details['email']);
		//$Recipiant = "lumy_r@yahoo.com";
		$message = new Email($Recipiant, $Sender, $Subject, $CustomHeaders);
		$message->SetHtmlContent($text);
		if (ValidHeader($Sender))
		{
			$message->Send();
			$query = "Update facturi_fiscale set status = 'Y' where serie_factura='".$id_fiscala."'"; 
			$db->query($query);
		}
		else
		{
			$emis_fact="N";
			$query ="Update facturi_fiscale set status = 'N' where serie_factura='".$id_fiscala."'";
			$db->query($query);
		}
		$_SESSION['admin_info'] = 'Factura fisacala a fost trimisa cu succes !';
		$_SESSION['admin_info_type'] = 'info';
		header('location: index.php?page=plati.facturifiscale');
		exit;
		
	break;
	#we change if we sent/not sent a bill by post in envelope
	case 'schimbafacturatrimisa':
		$status =$param1;
		$id_fisacla = $param2;
		ChangeSendBillStatus($status,$id_fisacla);
		header('location: '.GetReferer());
		exit;
	break;
	case 'facturilunare':
		$tpl->set_file('tpl_list', 'plati/facturilunare.tpl');
		$tpl->set_var('MAIN_TITLE', 'Listare facturi pe luni');
		#set blocks
		$tpl->set_block('tpl_list', 'list_years', 'list_years2');
		$tpl->set_block('tpl_list', 'list_messages', 'list_messages_block');
		$tpl->set_block('tpl_list', 'if_messages', 'if_messages_block');
		$tpl->set_block('tpl_list', 'fiscale_luni', 'fiscale_luni_block');
		
		#we check if we have a month selected
		if(isset($param1)&&($param1!=""))
		{	$luna_curenta = $param1;
		}else
		{	$luna_curenta = "all";
			$tpl->set_var('SELECTED_ALL', "selected");	
		}
		
		#we check if we have a year selected
		if(isset($param2)&&($param2!=""))
		{
			$year_curent = $param2;
		}
		else
		{
			// the current year
			$year_curent = date('Y');
		}
		
		//parse the years
		for ($i = 2009; $i <= date('Y'); $i++)
		{
			$tpl->set_var('YEAR', $i);
			if($i==$year_curent)
			{
				$tpl->set_var('SELECTED_YEAR', 'selected');
			}
			else
			{
				$tpl->set_var('SELECTED_YEAR', '');
			}
			$tpl->parse('list_years2', 'list_years', true);
		}
		

		$luni = array(1=> 'Ianuarie', 'Februarie', 'Martie', 'Aprilie', 'May', 'Iunie', 'Iulie',
		'August', 'Sepembrie', 'Octombrie', 'Noembrie', 'Decembrie');
		foreach ($luni as $key=>$val)
		{
			$tpl->set_var('LUNA_ID', $key);
			$tpl->set_var('LUNA_NAME', $val);
			if($key==$luna_curenta)
			{	$tpl->set_var('SELECTED_LUNA', "selected");			}
			else
			{	$tpl->set_var('SELECTED_LUNA', "");			}
			$tpl->parse('fiscale_luni_block', 'fiscale_luni', true);
		}

		#count all facturi an selected month/year
		$total_records = CountFiscaleOnMonthsYear($luna_curenta,$year_curent);
		$tpl->set_var('COUNT_FISCALE_TOTAL', $total_records);

		$total_money = AllMoneyMonthYear($luna_curenta,$year_curent);
		$tpl->set_var('TOTAL_MONEY', $total_money);
		
		#create pagination 
		$pages_number = ceil($total_records/$conf->users_per_page);
		$tpl->set_var('PAGES', $pages_number);
		$page_name = $module.'.'.$action.'.'.$param1.'.'.$param2;
		if(isset($_GET['start'])&&($_GET['start']!=""))
		{	$start = $_GET['start'];	}
		if(!isset($start))
		{
			$start_q = 0;
			$start = 1;
		}
		else
		{	$start_q = $conf->users_per_page*($start-1);		}
		$html_pages = AdminPagination($conf->users_per_page, $total_records, $page_name, $start);
		$tpl->set_var("PAGINATION", $html_pages);
		$query_limit = " LIMIT $start_q, $conf->users_per_page";

		$fiscale = GetFiscaleOnMonthsYear($luna_curenta,$year_curent,$query_limit);
		if (count($fiscale) != '0')
		{
			$i = 0;
			while (list($k, $v) = each($fiscale))
			{
				#set colors
				$bc = ($i % 2)+1;
				$tpl->set_var("BGCOLOR", 'row'.$bc);
				if(substr($v['data_eliberarii'],0,10)==date("Y-m-d"))
				{	$tpl->set_var("BGCOLOR", "today_add");	}
				$tpl->set_var('DATA_ELIBERARII',$v['data_eliberarii'] );
				if(strtotime($v['serviciu_expirare'])< (strtotime(date("Y-m-d"))+360000))
				{	$tpl->set_var("CLASSEXPIRE", "style=\"color:red;font-weight:bold;\"");	}
				else
				{	$tpl->set_var("CLASSEXPIRE", "");				}
				
				$tpl->set_var('TRIMISA_EMAIL',$v['status']);
				$tpl->set_var('DATE_PROMOVARE',TimeFormatEvents($v['serviciu_din']));
				$tpl->set_var('DATA_EXPIRE',TimeFormatEvents($v['serviciu_expirare']));
				$tpl->set_var('ID_FACTURA',$v['serie_factura'] );
				if($v['user_id']==='-1')
				{	$get_username="admin";}
				else
				{	
					$get_username = GetUserName($v['user_id']);}
					$tpl->set_var('USERNAME',$get_username );
					$tpl->set_var('USER_ID',$v['user_id'] );
					$tpl->set_var('ID_PROFORMA',$v['id_proforma'] );
					$tpl->set_var('TRIMISA',$v['trimisa'] );
					if($v['trimisa']=='N')
					{	$tpl->set_var('IMAGEPRINT',"noprint.jpg" );	}
					else
					{	$tpl->set_var('IMAGEPRINT', "print.jpg");	}
					
					#lets set some cabinet details
					$array_cabinet_type=array('1'=>'Cabinet','2'=>'Laborator teh','3'=>'Radiologie','4'=>'Distribuitor','5'=>'Clinica');
					$cabinet_det = GetCabInfo($v['firma_id']);
					$tpl->set_var("JUDET", $cabinet_det['judet']);
					$typecabinet = $cabinet_det['category_id'];
					$tpl->set_var("TYPE_CAB", $array_cabinet_type[$typecabinet]);
					$tpl->set_var("NUME_FIRMA", substr($cabinet_det['nume_firma'],0,22));
					$tpl->set_var("ID_CABINET", $v['firma_id']);

					$info_proforma = GetInfoProforma($v['id_proforma']);
					$tpl->set_var("COST", $info_proforma['cost']);
					#promovare packeges details
					$get_tip_promovare = "";
					
					$user_pachet = $pachet->getTipPromovare($v['firma_id']);
					
					//this is for the new promovare using pachete and servicii
					if(is_array($user_pachet))
					{
						$pkInfo = $pachet->getPachetInfo($user_pachet['pachet']);
						$get_tip_promovare = "<a href='index.php?page=users.viewpromovare.".$v['firma_id']."'>".$pkInfo['name']." ".$pkInfo['luni']."luni, ".$user_pachet['pret']." RON</a>";
					}
					else
					{
						if(stristr($v['tip_promovare'],',')!==false)
						{
							$price = explode(",",$v['tip_promovare']);
							foreach($price as $ky => $val)
							{
								$a = getPromovareLevelDetails($val);
								$get_tip_promovare = $get_tip_promovare." <B>".$a['name']."</b> ".$a['perioada']." luni, ".$a['pret']." RON </br>";
							}
						}
						else
						{
							$a = getPromovareLevelDetails($v['tip_promovare']);
							$get_tip_promovare = $get_tip_promovare." <B>".$a['name']."</B> ".$a['perioada']." luni, ".$a['pret']." RON </br>";
						}
					}

					$tpl->set_var('LOCPROMOVARE',$get_tip_promovare);

						
					#lets count all facturi fiscale for user
					$nr_fiscale = CountFiscaleForUser($v['user_id']);
					$tpl->set_var("NR_FACT_FISCALE", $nr_fiscale );

					$tpl->parse('list_messages_block', 'list_messages', true);
					$i++;
			}
			$tpl->parse('if_messages_block', 'if_messages', true);
		}
		else
		{
			$tpl->set_var('NOTFOUND',"Nu am gasit nici o ".$param1." cu aceste caracteristici!" );
		}
		#if we have information messages
		if (isset($_SESSION['admin_info']))
		{
			$tpl->set_file('tpl_info', 'info/'.$_SESSION['admin_info_type'].'.tpl');
			$tpl->set_var('MESSAGE', $_SESSION['admin_info']);
			$tpl->parse('INFORMATION', 'tpl_info');
			#uset sessions
			unset($_SESSION['admin_info']);
			unset($_SESSION['admin_info_type']);
		}
		$tpl->parse('MAIN', 'tpl_list');
	break;

	case 'addcomment':
		$id_fis = $param1;
		$tpl->set_var('ID', $id_fis );
		$tpl->set_file('tpl_facturi', 'plati/addcomment.tpl');
		//$text = GetFileContent("../facturi/facturi_fiscale/fiscala_".$id_fis.".html");
		//$tpl->set_var('FACTURA_CONTENT',$text );
		//$tpl->set_var('TRIMITE_FACTURA','trimitefiscala');
		$tpl->parse('MAIN', 'tpl_facturi', true);
	break;
	case 'insertcomment':
		$id_fis = $param1;
		if($_POST['comment_bill']!="")
		{
			$comment = $_POST['comment_bill'];
			InsertCommentBill($comment,$id_fis);
		}
		header("Location: ?page=plati.facturifiscale");
		exit;
	break;

#######################################################CLIENTI STUFF##############################
	case 'clienti':
		$tpl->set_file('tpl_list', 'plati/clienti.tpl');
		#page main title
		$tpl->set_var('MAIN_TITLE', 'Listare clienti curenti');
		
		#set blocks
		$tpl->set_block('tpl_list', 'list_messages', 'list_messages_block');
		$tpl->set_block('tpl_list', 'if_messages', 'if_messages_block');
		#-------------------------cabinete categories stuffs---------------------------------
		#check if the selected parent is a category or a module
		$path = explode("_", $param1);
			switch ($path['0'])
			{
				default :
					$all_cabinete = 0;
					$total_records = CountActiveClienti('all', 'all', 'all');
					$cat = "all";$judet ="all";
				break;

				case 'category':
					$cat_code = $path['1'];
					$total_records = CountActiveClienti("1",$path['2'], $path['1']);
					$cat = $path['2'];$judet = $path['1'];
				break;

				case 'module':
					$the_module_id = $path['1'];
					$total_records = CountActiveClienti("1",$path['1'], "all");
					$cat = $path['1'];$judet ="all";
				break;
			}
			#get the modules and categories
			$tpl->set_block('tpl_list', 'categories', 'categories_block');
			$tpl->set_block('tpl_list', 'modules', 'modules_block');
			$get_modules = GetCabineteModules();
			if (count($get_modules) != '0')
			{
				while (list($k, $v) = each($get_modules))
				{
					$tpl->set_var('SELECTED_MODULE', '');
					if (isset($the_module_id) && $the_module_id == $v['id']) 
						$tpl->set_var('SELECTED_MODULE', 'selected');
					$tpl->set_var('MODULE_ID', $v['id']);
					$tpl->set_var('MODULE_NAME', $v['name']);
					$get_cats = GetCabineteCategories($v['id'], 'Y', '');
					if (count($get_cats) != '0')
					{
						while (list($key, $val) = each($get_cats))
						{
							$tpl->set_var('SELECTED_CAT', '');
							if (isset($cat_code) && $cat_code == $val['cat_code']) 
								$tpl->set_var('SELECTED_CAT', 'selected');
							$tpl->set_var('CATEGORY_CODE', $val['cat_code']);
							$tpl->set_var('CATEGORY_NAME', $val['cat_name']);
							$tpl->parse('categories_block', 'categories', true);
						}
					}
					$tpl->parse('modules_block', 'modules', true);
					$tpl->parse('categories_block', '');
				}
			}
		
		#count all active clients
		$tpl->set_var('COUNT_CLIENTI', $total_records);

		#create pagination 
		$pages_number = ceil($total_records/$conf->users_per_page);
		$tpl->set_var('PAGES', $pages_number);
		$page_name = $module.'.'.$action.'.'.$param1.'.'.$param2.'.'.$param3;
		if(isset($_GET['start'])&&($_GET['start']!=""))
		{	$start = $_GET['start'];	}
		if(!isset($start))
		{
			$start_q = 0;
			$start = 1;
		}
		else
		{	$start_q = $conf->users_per_page*($start-1);		}
		$html_pages = AdminPagination($conf->users_per_page, $total_records, $page_name, $start);
		$tpl->set_var("PAGINATION", $html_pages);
		$query_limit = " LIMIT $start_q, $conf->users_per_page";
		
		#get all clienti
		$clienti = GetAdminClients("all",$cat,$judet,$query_limit);
		if (count($clienti) != '0')
		{
			$i = 0;
			while (list($k, $v) = each($clienti))
			{#set colors
				$bc = ($i % 2)+1;
				$tpl->set_var("BGCOLOR", 'row'.$bc);
				#here we mark with red the next clients wich service will expire
				if(substr($v['data_eliberarii'],0,10)==date("Y-m-d"))
				{	$tpl->set_var("BGCOLOR", "today_add");	}
				$tpl->set_var('DATA_ELIBERARII',$v['data_eliberarii'] );
				if(strtotime($v['serviciu_expirare'])< (strtotime(date("Y-m-d"))+360000))
				{	$tpl->set_var("CLASSEXPIRE", "style=\"color:red;font-weight:bold;\"");	}
				else
				{	$tpl->set_var("CLASSEXPIRE", "");				}
				
				$tpl->set_var('DATE_PROMOVARE',TimeFormatEvents($v['serviciu_din']));
				$tpl->set_var('DATA_EXPIRE',TimeFormatEvents($v['serviciu_expirare']));
				$tpl->set_var('ID_FACTURA',$v['serie_factura'] );
				if(isset($v['user_id'])&&($v['user_id']!=""))
				{
					$get_username = GetUserName($v['user_id']);
					$tpl->set_var('USERNAME',$get_username );
					$tpl->set_var('USER_ID',$v['user_id'] );
				}
				
				$tpl->set_var('ID_PROFORMA',$v['id_proforma'] );
				#lets set some cabinet details
				$array_cabinet_type=array('1'=>'Cabinet','2'=>'Laborator teh','3'=>'Radiologie','4'=>'Distribuitor','5'=>'Clinica');
				$cabinet_det = GetCabInfo($v['firma_id']);
				//print_r($cabinet_det );
				$tpl->set_var("JUDET", $cabinet_det['judet']);
				$typecabinet = $cabinet_det['category_id'];
				$tpl->set_var("TYPE_ID", $cabinet_det['category_id']);
				$tpl->set_var("TYPE_CAB", $array_cabinet_type[$typecabinet]);
				$tpl->set_var("NUME_FIRMA", substr($cabinet_det['nume_firma'],0,22));
				$tpl->set_var("ID_CABINET", $v['firma_id']);
				$main_photo = GetCabineteMainPhoto($v['firma_id'],"cabinet");
				$tpl->set_var('IMAGINE', SITE_BASE.'/sources/thumbnails.php?target='.$main_photo['image_name'].'&max_size='.$conf->admin_gallery_max.'&folder='.$v['firma_id']);
				if(($v['serviciu_id']!='5' )&&($v['serviciu_id']!='6'))
				{
					$tpl->set_var('RECOMANDED', "NO" );
					$tpl->set_var('CHANGE_RECOMANDED', 'change_yes' );
					$tpl->set_var('PRELUNGESTE_PROMOVARE', "" );

				}else
				{
					$tpl->set_var('RECOMANDED', " YES " );
					$tpl->set_var('PRELUNGESTE_PROMOVARE', "<a href=\"?page=plati.prelungestepromovare.".$v['firma_id'].".".$v['user_id'].".".$cabinet_det['judet'].".".$cabinet_det['category_id']."\">Prelungeste promovare</a>" );
					$tpl->set_var('CHANGE_RECOMANDED','change_no'  );

				}
		
					$get_level_det = getPromovareLevelDetails($v['serviciu_id']);
					//print_R($get_level_det);
					$tpl->set_var('LOCPROMOVARE',$get_level_det['name'] );
					$tpl->set_var("COST", $get_level_det['pret']);
					$tpl->set_var("PERIOADA_PROMOV", $get_level_det['perioada']);
					#media stuffs - images, video
					$video = getCabinetVideoFile($v['firma_id']);
						if (is_array($video) )
						{
							$tpl->set_var('NR_VIDEO', 1); 
						}
						else 
						{
						$tpl->set_var('NR_VIDEO', 0); 
						}
						$tpl->set_var('MODIFICA_VIDEO', "index.php?page=cabinete.modificavideo.".$v['firma_id'].".".$v['user_id']);
							
						$get_banner = GetBanner($v['firma_id']);
						if($get_banner!="")
						{	$tpl->set_var('NR_BANNER', 1); 				}
						else
						{	$tpl->set_var('NR_BANNER', 0); 			}
						
						
						$count_images = GetCabineteImages($v['firma_id']);
						$tpl->set_var('NR_IMAGINI',count($count_images) );
						$tpl->set_var('MODIFICA_IMAGINI',"index.php?page=cabinete.modificaimg.".$v['firma_id'].".".$v['user_id'].".".$cabinet_det['nume_firma'] );
					#lets count all facturi fiscale for user
					$nr_fiscale = CountFiscaleForUser($v['user_id']);
					$tpl->set_var("NR_FACT_FISCALE", $nr_fiscale );
					
					/*if(CheckIfNewFiscalaExists($v['firma_id'])=='N')
					{
						$tpl->parse('list_messages_block', 'list_messages', true);
					}
					else
					{
						$tpl->parse('list_messages_block', '', false);
					}*/
					$tpl->parse('list_messages_block', 'list_messages', true);
					$i++;
			}
			$tpl->parse('if_messages_block', 'if_messages', true);
		}
		else
		{
			$tpl->set_var('NOTFOUND',"In acesta categorie/judet nu avem nici un client!!" );
		}
		#if we have information messages
		if (isset($_SESSION['admin_info']))
		{
			$tpl->set_file('tpl_info', 'info/'.$_SESSION['admin_info_type'].'.tpl');
			$tpl->set_var('MESSAGE', $_SESSION['admin_info']);
			$tpl->parse('INFORMATION', 'tpl_info');
			unset($_SESSION['admin_info']);
			unset($_SESSION['admin_info_type']);
		}
		$tpl->parse('MAIN', 'tpl_list');
	break;
}
?>