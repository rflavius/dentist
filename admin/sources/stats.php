<?php

$pachete = new Pachete_Servicii($db);

switch($admin->level)
{
	case '1':
		switch($action)
		{
			default:
				$tpl->set_file('tpl_main', $module.'/admin_stats.tpl');
				$tpl->set_block('tpl_main', 'list_bilant', 'list_bilant2');
				$tpl->set_block('tpl_main', 'list_agents', 'list_agents2');

				$agents = GetAdmins();
				foreach ($agents as $ky => $val)
				{
					$tpl->set_var("AGENT",$val['user']);
					$tpl->set_var("AGENT_ID",$val['id']);
					$tpl->parse("list_agents2","list_agents",true);
				}
				
				if(isset($_POST['start']))
				{
					$stats = getBilant($_POST['admin_id'],$_POST['start'],$_POST['end']);
					$tpl->set_var('START', $_POST['start']);
					$tpl->set_var('END', $_POST['end']);
		
					$tpl->set_var("NR_CONTRACTS",count($stats));
					
					if(is_array($stats))
					{
						$i=0;
						$total = 0;
						foreach($stats as $ky => $val)
						{
							$bc = ($i % 2)+1;
							$tpl->set_var("BGCOLOR",'row'.$bc);
							$tpl->set_var('CAB_ID', $val['firma_id']);
							$tpl->set_var('COST', $val['cost']);
							$tpl->set_var('DATE', TimeFormatEvents($val['adaugare_proforma']));
							$v = getCabinetDetails($val['firma_id']);
		
							$tpl->set_var('CABINET', $v['nume_firma']);
							$tpl->set_var('TELEFON',$v['telefon'] );
							$tpl->set_var('EMAIL',$v['email'] );
							$tpl->set_var('USERID',$v['user_id'] );
		
							$get_contract_id = GetContractForCabinet($v['id']);
							$get_proforma_id = GetLastProformaForCabinet($v['id']);
							$fiscalaInfo = GetFiscalaForProforma($get_proforma_id);
							$tpl->set_var('PROFORMA_ID', $get_proforma_id);
							if(count($fiscalaInfo)>0)
							{
								$tpl->set_var('FISCALA_ID',$fiscalaInfo['serie_factura'] );
							}
							else
							{
								$tpl->set_var('FISCALA_ID','' );
							}
							$tpl->set_var('PARENT_MODULE', GetCabinetParents($v['id']));
							$tpl->set_var('LINK_TO_CABINET', ReWrite('cabinete_detalii', 'cabinete.detalii.'.$v['id']));
								
							// show tip promovare
							$promovare = "";
							$user_pachet = $pachete->getTipPromovare($val['firma_id']);
								
							//this is for the new promovare using pachete and servicii
							if(is_array($user_pachet))
							{
								$pkInfo = $pachete->getPachetInfo($user_pachet['pachet']);
								$promovare = $pkInfo['name'];
								$tpl->set_var('LOCPROMOVARE', $promovare);
							}
							else
							{
								if(stristr($val['tip_promovare'],',')!=FALSE)
								{
									$promovare="";
									$a = explode(',',$val['tip_promovare']);
									foreach($a as $ky2 => $val2)
									{
										$pkInfo = $pachete->getPachetInfo($val2);
										$promovare = $promovare.$pkInfo['name']."<br>";
									}
									$tpl->set_var('LOCPROMOVARE',$promovare );
								}
								else
								{
									$pkInfo = $pachete->getPachetInfo($val['tip_promovare']);
									$tpl->set_var('LOCPROMOVARE',$pkInfo['name'] );
								}
							}
								
							if (count($fiscalaInfo)> 0)
							{
								$total+=$val['cost'];
								$tpl->set_var('IMAGE', 'active.png');
								$tpl->set_var('IMAGE_TITLE', 'Plata efectuata cu succes!');
							}
							else
							{
								$tpl->set_var('IMAGE', 'inactive.png');
								$tpl->set_var('IMAGE_TITLE', 'Plata facturii proforme: #'.$get_proforma_id.' nu s-a efectuat inca!');
							}
		
							$tpl->parse('list_bilant2', 'list_bilant', true);
							$i++;
						}
						//print_r($conf);
						$marketing_amount = ($conf->marketing_procent * $total)/100;
						$tpl->set_var('MARKETING_COST',$marketing_amount );
						$tpl->set_var('INCOME',$total);
					}
					else
					{
						$tpl->parse('list_bilant2', '');
					}
				}
				else
				{
					$tpl->parse('list_bilant2', '');
					$tpl->set_var("NR_CONTRACTS",'0');
				}
		
				$tpl->parse('MAIN', 'tpl_main');
				break;
		}
		
	break;

	case '2':
		switch($action)
		{
			default:
				$tpl->set_file('tpl_main', $module.'/stats.tpl');
				$tpl->set_block('tpl_main', 'list_bilant', 'list_bilant2');
				if(isset($_POST['start']))
				{
					$stats = getBilant($admin->userID,$_POST['start'],$_POST['end']);
					$tpl->set_var('START', $_POST['start']);
					$tpl->set_var('END', $_POST['end']);
					$tpl->set_var("NR_CONTRACTS",count($stats));

					if(is_array($stats))
					{
						$i=0;
						$total = 0;
						foreach($stats as $ky => $val)
						{
							$bc = ($i % 2)+1;
							$tpl->set_var("BGCOLOR",'row'.$bc);
							$tpl->set_var('CAB_ID', $val['firma_id']);
							$tpl->set_var('COST', $val['cost']);
							$tpl->set_var('DATE', TimeFormatEvents($val['adaugare_proforma']));
							$v = getCabinetDetails($val['firma_id']);

							$tpl->set_var('CABINET', $v['nume_firma']);
							$tpl->set_var('TELEFON',$v['telefon'] );
							$tpl->set_var('EMAIL',$v['email'] );
							$tpl->set_var('USERID',$v['user_id'] );

							$get_contract_id = GetContractForCabinet($v['id']);
							$get_proforma_id = GetLastProformaForCabinet($v['id']);
							$fiscalaInfo = GetFiscalaForProforma($get_proforma_id);
							$tpl->set_var('PROFORMA_ID', $get_proforma_id);
							if(count($fiscalaInfo)>0)
							{
								$tpl->set_var('FISCALA_ID',$fiscalaInfo['serie_factura'] );
							}
							else
							{
								$tpl->set_var('FISCALA_ID','' );
							}
							
							$tpl->set_var('PARENT_MODULE', GetCabinetParents($v['id']));
							$tpl->set_var('LINK_TO_CABINET', ReWrite('cabinete_detalii', 'cabinete.detalii.'.$v['id']));
							
							// show tip promovare
							$promovare = "";
							$user_pachet = $pachete->getTipPromovare($val['idfirma']);
							
							//this is for the new promovare using pachete and servicii
							if(is_array($user_pachet))
							{
								$pkInfo = $pachete->getPachetInfo($user_pachet['pachet']);
								$promovare = $pkInfo['name'];
								$tpl->set_var('LOCPROMOVARE', $promovare);
							}
							else
							{
								if(stristr($val['tip_promovare'],',')!=FALSE)
								{
									$promovare="";
									$a = explode(',',$val['tip_promovare']);
									foreach($a as $ky2 => $val2)
									{
										$pkInfo = $pachete->getPachetInfo($val2);
										$promovare = $promovare.$pkInfo['name']."<br>";
									}
									$tpl->set_var('LOCPROMOVARE',$promovare );
								}
								else
								{
									$pkInfo = $pachete->getPachetInfo($val['tip_promovare']);
									$tpl->set_var('LOCPROMOVARE',$pkInfo['name'] );
								}
							}
							
							if (count($fiscalaInfo)> 0)
							{
								$total+=$val['cost'];
								$tpl->set_var('IMAGE', 'active.png');
								$tpl->set_var('IMAGE_TITLE', 'Plata efectuata cu succes!');
							}
							else
							{
								$tpl->set_var('IMAGE', 'inactive.png');
								$tpl->set_var('IMAGE_TITLE', 'Plata facturii proforme: #'.$get_proforma_id.' nu s-a efectuat inca!');
							}
							
							$tpl->parse('list_bilant2', 'list_bilant', true);
							$i++;
						}
						//print_r($conf);
						$marketing_amount = ($conf->marketing_procent * $total)/100;
						$tpl->set_var('MARKETING_COST',$marketing_amount );
						$tpl->set_var('INCOME',$total);
					}
					else
					{
						$tpl->parse('list_bilant2', '');
					}
				}
				else
				{
					$tpl->parse('list_bilant2', '');
					$tpl->set_var("NR_CONTRACTS",'0');
				}

				$tpl->parse('MAIN', 'tpl_main');
			break;
		}
		
	break;
}




?>