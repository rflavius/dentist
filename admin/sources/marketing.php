<?php

$pachete = new Pachete_Servicii($db);
$marketing = new Marketing($db);

switch($admin->level)
{
	case '1':
		
	break;

	case '2':
		switch($action)
		{
			default:
				$tpl->set_file('tpl_main', $module.'/list.tpl');
				$tpl->set_block('tpl_main', 'if_no_email_sent', 'if_no_email_sent2');
				$tpl->set_block('tpl_main', 'list_contacts', 'list_contacts2');
				
				
				
				if(isset($_GET['type']))
				{
					$tpl->set_var('SEL_'.strtoupper($_GET['type']), 'selected');
					$type = $_GET['type'];
				}
				else
				{
					$type="";
				}

				
				#check if the selected parent is a category or a module
				$path = explode("_", $action);
				switch ($path['0'])
				{
					default :
						$all_cabinete = 0;
						$total_records = countMarketingContacts($admin->userID,$type,'-1','');
					break;
				
					case 'category':
						$cat_id = $path['1'];
						$total_records = countMarketingContacts($admin->userID,$type,$path['0'],$path['1']);
					break;
				
					case 'module':
						$the_module_id = $path['1'];
						$total_records = countMarketingContacts($admin->userID,$type,$path['0'],$path['1']);
					break;
				}
				#get the modules and categories
				$tpl->set_block('tpl_main', 'categories', 'categories_block');
				$tpl->set_block('tpl_main', 'modules', 'modules_block');
				$get_modules = GetCabineteModules();
				if (count($get_modules) != '0')
				{
					while (list($k, $v) = each($get_modules))
					{
						$tpl->set_var('SELECTED_MODULE', '');
						if (isset($the_module_id) && $the_module_id == $v['id']) $tpl->set_var('SELECTED_MODULE', 'selected');
						$tpl->set_var('MODULE_ID', $v['id']);
						$tpl->set_var('MODULE_NAME', $v['name']);
						$get_cats = GetCabineteCategories($v['id'], 'Y', '');
						if (count($get_cats) != '0')
						{
							while (list($key, $val) = each($get_cats))
							{
								$tpl->set_var('SELECTED_CAT', '');
								if (isset($cat_id) && $cat_id == $val['id_cat']) $tpl->set_var('SELECTED_CAT', 'selected');
								$tpl->set_var('CATEGORY_ID', $val['id_cat']);
								$tpl->set_var('CATEGORY_NAME', $val['cat_name']);
								$tpl->parse('categories_block', 'categories', true);
							}
						}
						$tpl->parse('modules_block', 'modules', true);
						$tpl->parse('categories_block', '');
					}
				}
				$tpl->set_var('COUNT_CABINETE', $total_records);
				$pages_number = ceil($total_records/$conf->users_per_page);
				$tpl->set_var('PAGES', $pages_number);
				#create de pagination page_name
				$page_name = $module;
				if ($action != '')
				{
					$page_name = $page_name.'.'.$action;
				}
				
				
				
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
				
				if (isset($all_cabinete))
				{
					$contacts = listMarketingContacts($admin->userID,$type, $query_limit,'-1','');
				}
				else
				{
					$contacts = listMarketingContacts($admin->userID,$type, $query_limit,$path['0'], $path['1']);
				}
				
				
				if(is_array($contacts))
				{
					$i=0;
					foreach($contacts as $ky => $val)
					{
						#set colors
						$tpl->parse('if_no_email_sent2','');
						$bc = ($i % 2)+1;
						$tpl->set_var("BGCOLOR",'row'.$bc);
						$tpl->set_var('NR', $i+1);
						$tpl->set_var('ID', $val['id']);
						$tpl->set_var('CAB_ID', $val['cabinet_id']);
						$v = getCabinetDetails($val['cabinet_id']);

						$tpl->set_var('CABINET', $v['nume_firma']);
						$tpl->set_var('JUDET_ID',$v['judet'] );
						$tpl->set_var('TYPE_ID',$v['category_id'] );
						$tpl->set_var('USER_ID',$v['user_id'] );
						$tpl->set_var('TELEFON',$v['telefon'] );
						$tpl->set_var('EMAIL',$v['email'] );
						$tpl->set_var('VISITS',$v['nr_visits'] );
						if ($val['email_oferta'] == 'Y')
						{
							$tpl->set_var('IMAGE2', 'active.png');
							$tpl->set_var('IMAGE_TITLE2', 'inactive');
							$tpl->parse('if_no_email_sent2','');
						}
						else
						{
							$tpl->set_var('IMAGE2', 'inactive.png');
							$tpl->set_var('IMAGE_TITLE2', 'active');
							$tpl->parse('if_no_email_sent2','if_no_email_sent',true);
						}
						
						$get_contract_id = GetContractForCabinet($v['id']);
						$get_proforma_id = GetproformaForCabinet($v['id']);
						$tpl->set_var('PROFORMA_ID', $get_proforma_id);
						$tpl->set_var('CONTRACT_ID',$get_contract_id );

						$tpl->set_var('COMMENTS', $val['comments']);
						$tpl->set_var('PARENT_MODULE', GetCabinetParents($v['id']));
						$tpl->set_var('LINK_TO_CABINET', ReWrite('cabinete_detalii', 'cabinete.detalii.'.$v['id']));
						
						$user_pachet = $pachete->getTipPromovare($v['id']);
						//this is for the new promovare using pachete and servicii
						if(is_array($user_pachet))
						{
							$pkInfo = $pachete->getPachetInfo($user_pachet['pachet']);
							$promovare = "<a href='index.php?page=users.viewpromovare.".$v['id']."'>".$pkInfo['name']." - ".$user_pachet['pret']." RON</a>";
						}
						else
						{
							if(stristr($v['level'],',')!=FALSE)
							{
								$promovare="";
								$a = explode(',',$v['level']);
								foreach($a as $ky => $val)
								{
									$pkInfo = $pachete->getPachetInfo($val);
									$promovare = $promovare.$pkInfo['name'].' - '.$pkInfo['pret'].' RON';
								}
									
							}
							else
							{
								$pkInfo = $pachete->getPachetInfo($v['level']);
								$promovare = $pkInfo['name'].' - '.$pkInfo['pret'].' RON';
							}
							$promovare.= "<p><a href='index.php?page=users.addpromovare.".$v['id']."'>schimba promovare</a></p>";
						}
						$tpl->set_var('LOCPROMOVARE',$promovare );
						
						if($val['revin']!="0000-00-00")
						{
							$tpl->set_var('REV_DATE', "<font color='red'>".TimeFormatEvents($val['revin'])."</font><br><br>[ <a href='?page=marketing.removerevin.".$val['id']."'>Sterge revin telefon</a> ] ");
						}
						else
						{
							$tpl->set_var('REV_DATE', "");
						}

						$tpl->set_var('DATE', TimeFormatEvents($val['date']));
						$tpl->parse('list_contacts2', 'list_contacts', true);
						$i++;
					}
				}
				else
				{
					$tpl->parse('list_contacts2', '');
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
				
				$tpl->parse('MAIN', 'tpl_main');
			break;

			case 'addcontact':
				if(!$marketing->contactAlreadyExists($param1))
				{
					$sql = "INSERT INTO cabinete_marketing(`id`, `cabinet_id`, `comments`, `date`, `admin_id`) VALUES('','$param1','',NOW(),'$admin->userID')";
					$db->query($sql);
	
					$sql = "UPDATE cabinete SET `contactat`='Y', `admin_id`='$admin->userID' WHERE `id`='$param1'";
					$db->query($sql);
					
					$_SESSION['admin_info'] = "Cabinetul a fost adaugat cu succes in lista de contacte !";
					$_SESSION['admin_info_type'] = 'error';
						
					header("Location: index.php?page=marketing");
					exit;
				}
				else
				{
					$_SESSION['admin_info'] = "Ne pare rau dar acest cabinet este adaugat deja in lista de contacte !";
					$_SESSION['admin_info_type'] = 'error';
					header("Location: ".GetReferer());
					exit;
				}
			break;

			case 'addcomment':
				$tpl->set_file('tpl_main', $module.'/addcomment.tpl');
				$tpl->set_var('ID',$param1 );
				$v = getCabinetDetails($param2);
				$tpl->set_var('CABINET',$v['nume_firma'] );
				$contact_details = getMarketingContactDetails($param1);
				$tpl->set_var('DATE', AdminTimeFormat($contact_details['date']));
				$tpl->set_var('COMMENTS', $contact_details['comments']);

				$tpl->parse('MAIN', 'tpl_main');
			break;

			case 'savecomment':
				if($_POST['comment']!="" && strlen(trim($_POST['comment']))>'4')
				{
					$sql = "UPDATE cabinete_marketing SET `comments`= CONCAT(`comments`,'<li>".addslashes($_POST['comment'])."</li>') WHERE id='$param1'";
					$db->query($sql);
				}

				header("Location: index.php?page=marketing");
				exit;
			break;

			case 'addrevin':
				$tpl->set_file('tpl_main', $module.'/addrevin.tpl');
				$tpl->set_var('ID',$param1 );
				$v = getCabinetDetails($param2);
				$tpl->set_var('CABINET',$v['nume_firma'] );
				$contact_details = getMarketingContactDetails($param1);
				$tpl->set_var('DATE', AdminTimeFormat($contact_details['date']));
				$tpl->set_var('COMMENTS', $contact_details['comments']);

				$tpl->parse('MAIN', 'tpl_main');
			break;

			case 'saverevin':
				$sql = "UPDATE cabinete_marketing SET `revin`= '".$_POST['revin']."' WHERE id='$param1'";
				$db->query($sql);

				header("Location: index.php?page=marketing");
				exit;
			break;

			case 'removerevin':
				$sql = "UPDATE cabinete_marketing SET `revin`= '0000-00-00' WHERE id='$param1'";
				$db->query($sql);

				header("Location: index.php?page=marketing");
				exit;
			break;
			
			case 'sendmail':
				$tpl->set_file('tpl_main', $module.'/sendmail.tpl');
				
				$tpl->set_var('CAB_ID',$param1);
				$cabInfo = getCabinetDetails($param1);
				
				$tpl->set_var('EMAIL', $cabInfo['email_firma']);
				$tpl->parse('MAIN', 'tpl_main');
			break;
			
			case 'dosendmail':
				sendPromovareEmail($param1);
				//GenerateSmallImages($param2);
				$_SESSION['admin_info'] = 'E-mail de promovare trimis cu succes !';
				$_SESSION['admin_info_type'] = 'info';
				header ('location: index.php?page=marketing');
				exit;
			break;
		}
	break;
}




?>