<?php

$pachete = new Pachete_Servicii($db);

switch($admin->level)
{
	case '1':
		switch ($action)
		{
			case 'list':
				$tpl->set_file('tpl_list', 'users/list.tpl');
				#page main title
				$tpl->set_var('MAIN_TITLE', 'List all users');
				#set blocks
				$tpl->set_block('tpl_list', 'list_messages', 'list_messages_block');
				$tpl->set_block('tpl_list', 'if_messages', 'if_messages_block');
				
				if($param1=="")
				{
					$param1 = "creation_date_desc";
					$param2 = "all";
				}
				$tpl->set_var(strtoupper($param1),"selected" );
				$tpl->set_var("SELECTED".strtoupper($param2),"selected" );

				#count all messages
				$total_records = CountUsers($param1,$param2);
				$tpl->set_var('COUNT_USERS', $total_records);
				$pages_number = ceil($total_records/$conf->users_per_page);
				$tpl->set_var('PAGES', $pages_number);
				#create de pagination page_name
				$page_name = $module.'.'.$action.'.'.$param1.'.'.$param2;
				if(isset($_GET['start'])&&($_GET['start']!=""))
				{
						$start = $_GET['start'];
				}
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
				$users = GetUsers($param1,$param2, $query_limit);
				if (count($users) != '0')
				{
					$i = 0;
					while (list($k, $v) = each($users))
					{
						#set colors*/
						$bc = ($i % 2)+1;
						$tpl->set_var("BGCOLOR", 'row'.$bc);
						if(substr($v['creation_date'],0,10)==date("Y-m-d"))
						{
							$tpl->set_var("BGCOLOR", "today_add");
						}
						#set variables*/
						$tpl->set_var("USERNAME", $v['username']);
						$tpl->set_var("LASTNAME", $v['last_name']);
						$tpl->set_var("FIRSTNAME", $v['first_name']);
						$get_has_cab = GetFirme($v['id'],"-1");
						$tpl->set_var('ARECABINET',"No" );
						if(count($get_has_cab)>0)
						{
							$tpl->set_var('ARECABINET',"Yes" );
						}
					//	echo $v['email']."<br />";
						$tpl->set_var("EMAIL", $v['email']);
						$tpl->set_var("SUBMIT_DATE",AdminTimeFormat($v['creation_date'],'Y'));
						$tpl->set_var("LAST_LOGIN", AdminTimeFormat($v['last_login'], 'Y'));
						$tpl->set_var("ID", $v['id']);
						
				
						if ($v['status'] == '1')
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

			case 'set':
				ChangeUserStatus($param1, $param2);
				$_SESSION['admin_info'] = 'User status successfully changed !';
				$_SESSION['admin_info_type'] = 'info';
				header ('location: '.$_SERVER['HTTP_REFERER']);
				exit;
			break;

			case 'logins':
				$tpl->set_file("tpl_logins", "users/logins.tpl");
				$tpl->set_var("MAIN_TITLE", "List Users Logins");
				$logins_per_page = '25';
				$p = isset($_GET['start']) ? $_GET['start']: 1;
				#for one user only
				if (isset($_GET['user_id']))
				{
					$user_id = $_GET['user_id'];
					$page_name = "users.logins&user_id=".$user_id;
				}
				else
				{
					$user_id = '-1';
					$page_name = "users.logins";
				}
				$start = ($p-1)*$logins_per_page;
				#pagination query
				$query_limit = " LIMIT $start, $logins_per_page ";
				#count user logins and display pagination
				$total_logins = CountUserLogins ($user_id);
				$tpl->set_var("TOTAL_LOGINS", $total_logins);
				$pages = ceil($total_logins/$logins_per_page);
				$tpl->set_var("PAGES", $pages);
				$tpl->set_var("PAGINATION", AdminPagination($logins_per_page, $total_logins, $page_name, $p));
				switch ($user_id)
				{
					default :
						$query = "SELECT A.username, B.ip, B.user_agent, B.date,B.user_id
											FROM users A , logins B
											WHERE A.id = B.user_id AND B.user_id = '".intval($user_id)."'
											ORDER BY B.date DESC ".$query_limit;
					break;

					case '-1':
						$query = "SELECT A.username, B.ip, B.user_agent, B.date,B.user_id
											FROM users A , logins B
											WHERE A.id = B.user_id ORDER BY B.date DESC ".$query_limit;
					break;
				}
				$db->query($query);
				$i = 0;
				$tpl->set_block("tpl_logins", "list", "list_block");
				while ($db->next_record())
				{
					$bc = ($i % 2)+1;
					$tpl->set_var("BGCOLOR", 'row'.$bc);

					$tpl->set_var("USERNAME",$db->f("username"));
					$tpl->set_var("USER_ID",$db->f("user_id"));
					$tpl->set_var("DATE", AdminTimeFormat($db->f("date"),'N'));
					$tpl->set_var("IP", $db->f("ip"));
					$tpl->set_var("USER_AGENT", $db->f("user_agent"));
					$ip2country = Ip2Country($db->f("ip"));
					$tpl->set_var("COUNTRY_IMAGE", strtolower($ip2country[0]));
					$tpl->set_var("COUNTRY_NAME", $ip2country[1]);
					$tpl->set_var("ICON", GetBrowserIcon(strtolower($db->f("user_agent"))));
					$tpl->parse("list_block", "list", true);
					$i++;
				}
				$tpl->parse("MAIN", "tpl_logins");
			break;
			
			case 'details':
				$tpl->set_file("tpl_details", "users/userdetails.tpl");
				$tpl->set_block('tpl_details', 'list_firme', 'list_firmee');
				$tpl->set_block('tpl_details', 'if_no_firme', 'if_no_firmee');
				$tpl->set_var("MAIN_TITLE", " User ". $param2. " Details");
				$tpl->set_var('USERNAME',ucfirst($param2) );
				$user_id = $param1;
				#user details
				$get_user_details=GetUserDetails($param1);
				$tpl->set_var("LASTNAME", $get_user_details['last_name']);
				$tpl->set_var("FIRSTNAME", $get_user_details['first_name']);
				
				$get_has_cab = GetFirme($user_id,"-1");
				$tpl->set_var('ARECABINET',"No" );
				if(count($get_has_cab)>0)
				{$tpl->set_var('ARECABINET',"Yes" );}
				$tpl->set_var("USERNAME", $get_user_details['username']);
				$tpl->set_var("MAINEMAIL", $get_user_details['email']);
				$tpl->set_var("SUBMIT_DATE",AdminTimeFormat($get_user_details['creation_date'],'Y'));
				$tpl->set_var("LAST_LOGIN", AdminTimeFormat($get_user_details['last_login'], 'Y'));
				$tpl->set_var("ID_USER", $user_id);
				
				$nr_fiscale = CountFiscaleForUser($user_id);
				$tpl->set_var("NR_FACT_FISCALE", $nr_fiscale );
				
				
				if ($get_user_details['status'] == '1')
				{
					$tpl->set_var('IMAGEUSER', 'active.png');
					$tpl->set_var('IMAGE_TITLE', 'inactive');
				}
				else 
				{
					$tpl->set_var('IMAGEUSER', 'inactive.png');
					$tpl->set_var('IMAGEUSER_TITLE', 'active');
				}
				$tpl->set_var("BGCOLOR", "row1");
				if(substr($get_user_details['creation_date'],0,10)==date("Y-m-d"))
				{
					$tpl->set_var("BGCOLOR", "today_add");
				}
				#cabinete details
				$get_firme = GetFirme($user_id,"-1");
				
				//var_dump($get_firme);
				if(count($get_firme )>0)
				{
					foreach($get_firme as $ky => $val)
					{
						$tpl->set_var('PARENT_MODULE', GetCabinetParents($val['id']));
						$tpl->set_var('TYPE_ID', $val['category_id']);
						$tpl->set_var('JUDET_ID', $val['judet']);
						$tpl->set_var('NUME_FIRMA',ucfirst($val['nume_firma']) );
						$tpl->set_var('DESCRIERE', substr($val['descriere'],0,200)."...");
						$tpl->set_var('NR_PHONE_VIEWS', $val['phone_views']);
						
						$tpl->set_var('NR_VISITS_CABINET', $val['nr_visits']);
						$tpl->set_var('EDITFIRMA', '?page=cabinete.edit.'.$val['idfirma'].'.'.$user_id);
						
						$main_photo = GetCabineteMainPhoto($val['id'],"cabinet");
						$tpl->set_var('THUMBNAIL', SITE_BASE.'/sources/thumbnails.php?target='.$main_photo['image_name'].'&max_size='.$conf->admin_gallery_max.'&folder='.$val['id']);
					
						$tpl->set_var('IDFIRMA', $val['idfirma']);
						$get_contract_id = GetContractForCabinet($val['idfirma']);
						$get_proforma_id = GetLastProformaForCabinet($val['idfirma']);
						$tpl->set_var('PROFORMA_ID', $get_proforma_id);
						$tpl->set_var('CONTRACT_ID',$get_contract_id );
						
						// show tip promovare
						$get_tip_promovare = "";
						$user_pachet = $pachete->getTipPromovare($val['idfirma']);
						
						//this is for the new promovare using pachete and servicii
						if(is_array($user_pachet))
						{
							$pkInfo = $pachete->getPachetInfo($user_pachet['pachet']);
							$get_tip_promovare = "<a href='index.php?page=users.viewpromovare.".$val['idfirma']."'>".$pkInfo['name']." - ".$user_pachet['pret']." RON</a>";
						}
						else
						{
							if(stristr($val['level'],',')!==false)
							{
								$price = explode(",",$val['level']);
								foreach($price as $k => $v)
								{
									$pkInfo = $pachete->getPachetInfo($v);
									$get_tip_promovare = $get_tip_promovare." <br>".$pkInfo['name']." - ".$pkInfo['pret']." RON";
								}
							}
							else
							{
								$pkInfo = $pachete->getPachetInfo($val['level']);
								$get_tip_promovare = $pkInfo['name']." - ".$pkInfo['pret']." RON";
							}
							$get_tip_promovare.= "<p>[ <a href='index.php?page=users.addpromovare.".$val['idfirma']."'>schimba promovare</a> ]</p>";
						}
						$tpl->set_var('PROMOVARE', $get_tip_promovare);
						
						
						if($val['recomandat']=='N')
						{
							$tpl->set_var('RECOMANDED', "NO" );
							$tpl->set_var('CHANGE_RECOMANDED', 'change_yes' );
							$tpl->set_var('PRELUNGESTE_PROMOVARE', "" );

						}else
						{
							$tpl->set_var('RECOMANDED', "YES" );
							$tpl->set_var('PRELUNGESTE_PROMOVARE', "<a href=\"?page=plati.prelungestepromovare.".$val['idfirma'].".".$user_id.".".$val['judet'].".".$val['category_id']."\">Prelungeste promovare</a>" );
							$tpl->set_var('CHANGE_RECOMANDED','change_no'  );

						}


						if ($val['status'] == '1')
						{
							$tpl->set_var('IMAGE', 'active.png');
							$tpl->set_var('IMAGE_TITLE', 'inactive');
						}
						else 
						{
							$tpl->set_var('IMAGE', 'inactive.png');
							$tpl->set_var('IMAGE_TITLE', 'active');
						}
						$tpl->parse('list_firmee', 'list_firme', true);
					}
				}
				else
				{	$tpl->parse('if_no_firmee', 'if_no_firme', true);	}
				#now display anunturile pt userul respectiv
				$tpl->set_block('tpl_details', 'list_anunturi', 'list_anunturi_block');
				$tpl->set_block('tpl_details', 'no_anunturi', 'no_anunturi_block');
				$get_anunturi = GetAnunturi($param1,"-1");
			//	print_r($get_anunturi );
				if (count($get_anunturi) != '0')
				{
					$i = 0;
					while (list($k, $v) = each($get_anunturi))
					{
						#set colors
						$bc = ($i % 2)+1;
						$tpl->set_var("BGCOLOR",'row'.$bc);
							

						if($v['data_adaugarii']== date("Y-m-d")||(substr($v['data_modificarii'],0,10)== date("Y-m-d")))
						{	$tpl->set_var("BGCOLOR", "today_add"); }
					
						$tpl->set_var('VIZITE', $v['nr_visits']);
						$tpl->set_var('ID', $v['id']);
						$tpl->set_var('CONTENT',text_best_fit($v['continut'],150));
						$tpl->set_var('TITLU', $v['titlu']);
						$tpl->set_var('THUMBNAILS', "../sources/thumbnails.php?target=".$v['imagine'].'&max_size='.$conf->admin_gallery_max.'&anunturi=yes');
					
						$tpl->set_var('DATE_EXP', substr($v['data_expirarii'],0,10));
						$tpl->set_var('DATE_ADDED', $v['data_adaugarii']);
						$tpl->set_var('DATE_MOD', substr($v['data_modificarii'],0,10));
						if(substr($v['data_expirarii'],0,10)== date("Y-m-d"))
						{	$tpl->set_var("BGCOLOR", "alert_anunt"); }
						
						if ($v['status'] == '1')
						{
							$tpl->set_var('IMAGE', 'active.png');
							$tpl->set_var('IMAGE_TITLE', 'inactive');
						}
						else 
						{
							$tpl->set_var('IMAGE', 'inactive.png');
							$tpl->set_var('IMAGE_TITLE', 'active');
						}
					
						$tpl->parse('list_anunturi_block', 'list_anunturi', true);
						$i++;
					}
				}
				else 
				{
					$tpl->parse('no_anunturi_block', 'no_anunturi', true);
				}
			
				
				#list all articles of the user
				$tpl->set_block('tpl_details', 'list_articole', 'list_articole_block');
				$tpl->set_block('tpl_details', 'no_articole', 'no_articole_block');
				$get_anunturi = GetArticole($param1,"-1");
				//print_r($get_anunturi);
				if (count($get_anunturi) != '0')
				{
					$i = 0;
					while (list($k, $v) = each($get_anunturi))
					{
						#set colors
						$bc = ($i % 2)+1;
						$tpl->set_var("BGCOLOR",'row'.$bc);
							

						if($v['data_adaugarii']== date("Y-m-d")||(substr($v['data_modificarii'],0,10)== date("Y-m-d")))
						{	$tpl->set_var("BGCOLOR", "today_add"); }
					
						
						$tpl->set_var('ID', $v['id']);
						$tpl->set_var('CONTENT',text_best_fit($v['continut'],150));
						$tpl->set_var('TITLU', $v['titlu']);
						$tpl->set_var('VISITS', $v['nr_visits']);
						$tpl->set_var('THUMBNAILS', "../sources/thumbnails.php?target=".$v['imagine'].'&max_size='.$conf->admin_gallery_max.'&articles=yes');
					
						
						$tpl->set_var('DATE_ADDED', $v['data_adaugarii']);
						$tpl->set_var('DATE_MOD', substr($v['data_modificarii'],0,10));
						if(isset($v['data_expirarii']) && substr($v['data_expirarii'],0,10)== date("Y-m-d"))
						{	$tpl->set_var("BGCOLOR", "alert_anunt"); }
						
						if ($v['status'] == '1')
						{
							$tpl->set_var('IMAGE', 'active.png');
							$tpl->set_var('IMAGE_TITLE', 'inactive');
						}
						else 
						{
							$tpl->set_var('IMAGE', 'inactive.png');
							$tpl->set_var('IMAGE_TITLE', 'active');
						}
					
						$tpl->parse('list_articole_block', 'list_articole', true);
						$i++;
					}
				}
				else 
				{
					$tpl->parse('no_articole_block', 'no_articole', true);
				}

				#mesaje / utilizator
				$query_limit="LIMIT 0, 50";
				$get_users_mesages = GetUsersMesages($user_id,$query_limit);
				$i = 0;
				$tpl->set_block("tpl_details", "list", "list_block");
					foreach($get_users_mesages as $ky => $val)
					{
						$bc = ($i % 2)+1;
						$tpl->set_var("BGCOLOR", 'row'.$bc);

						$query = "SELECT A.username, B.ip, B.user_agent, B.date as date_login,B.user_id
										FROM users A , logins B
										WHERE A.id = B.user_id AND B.user_id = '".intval($val['user_id'])."'
											ORDER BY B.date DESC ";
						$db->query($query);
						$db->next_record();
						$last_login = $db->f('date_login');
						$tpl->set_var("USER_ID",$val['user_id']);
						$tpl->set_var('ID_MESAJ', $val['id']);
						$tpl->set_var('NUME_EXPEDITOR',$val['nume_utilizator'] );
						$tpl->set_var('EMAIL',$val['email_utilizator'] );
						$tpl->set_var('TELEFON',$val['telefon'] );
						$tpl->set_var('SUBIECT_MESAJ',$val['subiect'] );
						$tpl->set_var('MESAJ', $val['mesaj']);
						$tpl->set_var("DATA", AdminTimeFormat($val['submision_date'],'Y'));
						
						$date_login = strtotime($last_login);
						$date_add_message =  strtotime($val['submision_date']);
					
						if($val['citit']=='Y')
						{ 
							$tpl->set_var("COLOR_MESAGE","#330000");
							$tpl->set_var("MESAJ_STATUS","Citit");
						}
						else
						{
							if($date_login > $date_add_message)
							{
								$tpl->set_var("COLOR_MESAGE","#330000");
								$tpl->set_var("MESAJ_STATUS","Citit");

							}
							else
							{
								$tpl->set_var("COLOR_MESAGE","#FF0000");
								$tpl->set_var("MESAJ_STATUS","Necitit");

							}
						}
						if ($val['status'] == 'Y')
							{
								$tpl->set_var('IMAGE', 'active.png');
								$tpl->set_var('IMAGE_TITLE', 'inactive');
							}
							else 
							{
								$tpl->set_var('IMAGE', 'inactive.png');
								$tpl->set_var('IMAGE_TITLE', 'active');
							}
						
						$tpl->parse("list_block", "list", true);
						$i++;
				}
				
				$tpl->parse('MAIN', 'tpl_details', true);
			break;
			
			case 'listmesaje':
				$tpl->set_file("tpl_listmesaje", "users/usersmesages.tpl");
				$tpl->set_var("MAIN_TITLE", "List Users Mesages");
				$mesages_per_page = '25';
				$p = isset($_GET['start']) ? $_GET['start']: 1;
				#for one user only
				if (isset($_GET['user_id']))
				{
					$user_id = $_GET['user_id'];
					$page_name = "users.listmesaje&user_id=".$user_id;
				}
				else
				{
					$user_id = '-1';
					$page_name = "users.listmesaje";
				}

				$logins_per_page=25;
				$mesages_per_page=25;
				$start = ($p-1)*$logins_per_page;
				#pagination query
				$query_limit = " LIMIT $start, $mesages_per_page ";
				#count user logins and display pagination
				$total_mesages = CountUserMesages ($user_id);
				$tpl->set_var("TOTAL_MESAGES", $total_mesages);
				$pages = ceil($total_mesages/$logins_per_page);
				$tpl->set_var("PAGES", $pages);
				$tpl->set_var("PAGINATION", AdminPagination($logins_per_page, $total_mesages, $page_name, $p));
				//print_r($user_id);
				$get_users_mesages = GetUsersMesages($user_id,$query_limit);	$i = 0;
				//print_r($get_users_mesages);
				$tpl->set_block("tpl_listmesaje", "list", "list_block");

					foreach($get_users_mesages as $ky => $val)
					{
						$bc = ($i % 2)+1;
						$tpl->set_var("BGCOLOR", 'row'.$bc);

						###############get the cabinet details for each user : phone numbers etc
						$get_cabinete_for_user = GetFirme($val['user_id'],"-1");
						$phone = "";
						if(count($get_cabinete_for_user )>0)
						{
							foreach($get_cabinete_for_user as $kky => $vaal)
							{
									$phone .=  $vaal['fax'];
								
							}
							$tpl->set_var('PHONE_NUMBER', $phone);
						}
						else
						{
						$tpl->set_var('PHONE_NUMBER', "");
						}
							

						
						
						$user_info = GetUserDetails($val['user_id']);
						$tpl->set_var("USERNAME",$user_info['username']);
						if($val['user_id']=='-1')
						{
								$tpl->set_var("USERNAME","admin");
						}
						
						$query = "SELECT A.username, B.ip, B.user_agent, B.date as date_login,B.user_id
										FROM users A , logins B
										WHERE A.id = B.user_id AND B.user_id = '".intval($val['user_id'])."'
											ORDER BY B.date DESC ";
						$db->query($query);
						$db->next_record();
						$last_login = $db->f('date_login');
						$tpl->set_var("USER_ID",$val['user_id']);
						$tpl->set_var('ID_MESAJ', $val['id']);
						$tpl->set_var('NUME_EXPEDITOR',$val['nume_utilizator'] );
						$tpl->set_var('EMAIL',$val['email_utilizator'] );
						$tpl->set_var('TELEFON',$val['telefon']  );
						$tpl->set_var('SUBIECT_MESAJ',$val['subiect'] );
						$tpl->set_var('MESAJ', $val['mesaj']);
						$tpl->set_var("DATA", AdminTimeFormat($val['submision_date'],'Y'));
						
						$date_login = strtotime($last_login);
						$date_add_message =  strtotime($val['submision_date']);
						$code_row = $val['user_id']."-".$val['id'];
						$nr_letters = strlen($code_row);
						$query ="SELECT `read_messages` FROM `users_messages_links` WHERE SUBSTR(`acces_link`,'46','".$nr_letters."')='".$code_row."' AND `read_messages`='Y'";
							$db->query($query);
							$db->next_record();
							$read_m = $db->f('read_messages');
						if($val['citit']=='Y')
						{
								$tpl->set_var("COLOR_MESAGE","#330000");
								$tpl->set_var("MESAJ_STATUS","Citit");
						}
						else
						{
							if(($date_login > $date_add_message) || ($read_m=='Y'))
							{
								$tpl->set_var("COLOR_MESAGE","#330000");
								$tpl->set_var("MESAJ_STATUS","Citit");

							}
							else
							{
								$tpl->set_var("COLOR_MESAGE","#FF0000");
								$tpl->set_var("MESAJ_STATUS","Necitit");
							}
						}

						if ($val['status'] == 'Y')
							{
								$tpl->set_var('IMAGE', 'active.png');
								$tpl->set_var('IMAGE_TITLE', 'inactive');
							}
							else 
							{
								$tpl->set_var('IMAGE', 'inactive.png');
								$tpl->set_var('IMAGE_TITLE', 'active');
							}
							
							
							
					// here we show promovare level
					if(isset($get_cabinete_for_user[0]['id'])&&($get_cabinete_for_user[0]['id']!=""))
					{
					$user_pachet = $pachete->getTipPromovare($get_cabinete_for_user[0]['id']);
						
					//this is for the new promovare using pachete and servicii
					if(is_array($user_pachet))
					{
						$pkInfo = $pachete->getPachetInfo($user_pachet['pachet']);
						$get_tip_promovare = $pkInfo['name']." - ".$user_pachet['pret']." RON";
					}
					else
					{
						if(stristr($get_cabinete_for_user[0]['level'],',')!==false)
						{
							$price = explode(",",$get_cabinete_for_user[0]['level']);
							foreach($price as $k => $v)
							{
								$pkInfo = $pachete->getPachetInfo($v);
								$get_tip_promovare = $get_tip_promovare." <br>".$pkInfo['name']." - ".$pkInfo['pret']." RON";
							}
						}
						else
						{
							$pkInfo = $pachete->getPachetInfo($get_cabinete_for_user[0]['level']);
							$get_tip_promovare = $pkInfo['name']." - ".$pkInfo['pret']." RON";
						}
					}
					}
					$tpl->set_var('LEVEL',$get_tip_promovare);
					
					$tpl->parse("list_block", "list", true);
					$i++;
				}
				
				$tpl->parse("MAIN", "tpl_listmesaje");
			break;

			case 'deletemesaj':
				$id_mesaj=$param1;
				DeleteMesaj($id_mesaj);
				header ('location: '.$_SERVER['HTTP_REFERER']);
				exit;
				
			break;
			
			case 'setmesaj':
				#when we activate the message - means we send am email to dentist that he has a new message on dentistonline.ro
				#to make this more easy...not necesary to log in we create a page where the owner can see his messages
				#we make this secure and generate the link
				$acces_link = GenerateAccesLink($param3,$param2);
				ChangeMesajStatus($param1, $param2,$acces_link );
				$_SESSION['admin_info'] = 'Status successfully changed !';
				$_SESSION['admin_info_type'] = 'info';
				header ('location: '.$_SERVER['HTTP_REFERER']);
				exit;
			break;
			
			case 'viewpromovare':
				$tpl->set_file('tpl_main', $module.'/promovare.tpl');
				$tpl->set_var("MAIN_TITLE", "Vezi tipul promovarii pentru:");
				$tpl->set_block('tpl_main', 'list_pachete', 'list_pachete2');
				$tpl->set_block('tpl_main', 'list_servicii', 'list_servicii2');
				
				$tpl->set_var('CAB_ID', $param1);
				
				if(!isset($param2) || $param2=='')
				{
					$user_pachet = $pachete->getTipPromovare($param1);
					$tpl->set_var('SELL_PK', $user_pachet['pachet']);
				}
				else
				{
					$user_pachet = $pachete->getPachetInfo($param2);
					$tpl->set_var('SELL_PK', $param2);
				}
				//list pachete
				$all_pk = $pachete->listPacheteBackend();
				foreach($all_pk  as $ky => $val)
				{
					$tpl->set_var('PACHET', $val['name']);
					$tpl->set_var('PACHET_ID', $val['id']);
					$tpl->set_var('COST', $val['pret']);
					if(!isset($param2) || $param2=='')
					{
						if($val['id']==$user_pachet['pachet'])
						{
							$tpl->set_var('PACHET_SELL', 'selected');
						}
						else
						{
							$tpl->set_var('PACHET_SELL', '');
						}
					}
					else
					{
						if($val['id']==$param2)
						{
							$tpl->set_var('PACHET_SELL', 'selected');
						}
						else
						{
							$tpl->set_var('PACHET_SELL', '');
						}
					}
					$tpl->parse('list_pachete2', 'list_pachete', true);
				}
				//print_r($user_pachet);exit;
				//list servicii
				$selected_servs = explode(";",$user_pachet['servicii']);
				
				//aici listam doar serviciile care sunt contra cost, excludem cele care sunt gratuite pentru a nu lista serviciile gratuite la pachetul basic
				$servs = $pachete->listServiciiPreferentiale();
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
						
					if(is_array($selected_servs))
					{
						foreach($selected_servs  as $v)
						{
							//echo $v." => ".$val['id']."<br>";
							if($v!='' && $val['id']==$v)
							{
								$tpl->set_var('SERV_CHECK', 'checked');
							}
						}
					}
					$tpl->parse('list_servicii2', 'list_servicii', true);
				}
				
				$tpl->set_var('TOTAL', $user_pachet['pret']);
				$tpl->set_var('SELL_SERVS', $user_pachet['servicii']);
				
				$tpl->set_file('tpl_factura',$module.'/facturare.tpl');
				$userid = getUseridForCabinet($param1);
				$facturi = new Facturi($db);
				$cumpinfo = $facturi->getCumparatorLastInfo($userid);
				$userinfo = GetUserDetails($userid);
				$tpl->set_var('NUME',$cumpinfo['nume']);
				$tpl->set_var('ADRESA',$cumpinfo['adresa']);
				$tpl->set_var('CUI',$cumpinfo['cui']);
				$tpl->set_var('BI',$cumpinfo['bi']);
				$tpl->set_var('CNP',$cumpinfo['cnp']);
				$tpl->set_var('RC',$cumpinfo['rc']);
				$tpl->set_var('EMAIL',$userinfo['email']);
				$tpl->parse('FACTURARE_BLOCK','tpl_factura');
				
				$tpl->parse("MAIN", "tpl_main");
			break;
			
			case 'change_promovare':
				$pachete->updatePachetAndServicii($_POST);
				$facturi = new Facturi($db);
				if($_POST['firma_total']!='0')
				{
					
					$cump_id = $facturi->addCumparator();
					$_POST['pachet'] = $_POST['firma_pachet'];
					$_POST['servicii'] = $_POST['firma_servicii'];
					$_POST['nume_firma'] = $_POST['nume'];
					$_POST['pers_contact'] = $_POST['nume'];
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
					$plata_id = $facturi->addProforma($_POST['user_id'],$_POST['cabinet_id'],$_POST,$recomandat,$cump_id);
					$facturi->assignProformaAgent($plata_id,$admin->userID);
					### generate the HTML file for factura proforma
					$facturi->saveProformaFile($plata_id);
						
					$facturi->sendProformaByEmail($plata_id,$_POST['pachet'],$_POST['servicii'],$_POST['cabinet_id']);
				}
				else
				{
					$facturi->updatePachetAchitat($_POST['cabinet_id']);
					$_SESSION['admin_info'] = "Tipul de promovare si serviciile oferite au fost modificate cu succes !";
				}
				$facturi->assignCabinetAgent($_POST['cabinet_id'],$admin->userID);
				$_SESSION['admin_info_type'] = 'info';
				header ('location: index.php?page=users.details.'.$_POST['user_id']);
				exit;
			break;
			
			case 'addpromovare':
				$tpl->set_file('tpl_main',$module.'/addpromovare.tpl');
				$tpl->set_var("MAIN_TITLE", "Adauga promovare");
				$tpl->set_block('tpl_main', 'list_pachete', 'list_pachete2');
				$tpl->set_block('tpl_main', 'list_servicii', 'list_servicii2');
				$tpl->set_file('tpl_cump',$module.'/facturare.tpl');
				
				
				$tpl->set_var('CAB_ID', $param1);
				$tpl->set_var('USER_ID', getUseridForCabinet($param1));
				$tpl->set_var('TOTAL','0');
				
				//list pachete
				$all_pk = $pachete->listPacheteBackend();
				foreach($all_pk  as $ky => $val)
				{
					$tpl->set_var('PACHET', $val['name']);
					$tpl->set_var('PACHET_ID', $val['id']);
					$tpl->set_var('COST', $val['pret']);

					$tpl->parse('list_pachete2', 'list_pachete', true);
				}
				
				//aici listam doar serviciile care sunt contra cost, excludem cele care sunt gratuite pentru a nu lista serviciile gratuite la pachetul basic
				$servs = $pachete->listServiciiPreferentiale();
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
				$tpl->parse("MAIN", "tpl_main");
			break;
			
			case 'dopromovare':
				
				$facturi = new Facturi($db);
				if($_POST['total']!='0' && $_POST['total']!='')
				{
					$cump_id = $facturi->addCumparator();
					$_POST['pachet'] = $_POST['firma_pachet'];
					$_POST['servicii'] = $_POST['firma_servicii'];
					$_POST['nume_firma'] = $_POST['nume'];
					$_POST['pers_contact'] = $_POST['nume'];
					$_POST['total'] = $_POST['total'];
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
					$plata_id = $facturi->addProforma($_POST['user_id'],$_POST['cabinet_id'],$_POST,'',$cump_id);
					$facturi->assignProformaAgent($plata_id,$admin->userID);
					### generate the HTML file for factura proforma
					$facturi->saveProformaFile($plata_id);
					
					$facturi->sendProformaByEmail($plata_id,$_POST['pachet'],$_POST['servicii'],$_POST['cabinet_id']);
				}
				else
				{
					$user_pachet = $pachete->getTipPromovare($_POST['cabinet_id']);
					if(is_array($user_pachet))
					{
						$pachete->updatePachetAndServicii($_POST);
					}
					else
					{
						$pachete->addFreeClientPachetAndServicii($_POST);
					}
					
					$sql = "UPDATE cabinete SET `level`='".$_POST['pachet']."', `recomandata`='N' WHERE id='".$_POST['cabinet_id']."'";
					$db->query($sql);
					
					$_SESSION['admin_info'] = "Tipul de promovare si serviciile oferite au fost modificate cu succes !";
					$facturi->updatePachetAchitat($_POST['cabinet_id']);
				}
				$facturi->assignCabinetAgent($_POST['cabinet_id'],$admin->userID);
				$_SESSION['admin_info_type'] = 'info';
				header ('location: index.php?page=users.details.'.$_POST['user_id']);
				exit;
			break;
	}
	break;

	case '2':
		switch($action)
		{
			case 'listmesaje':
				$tpl->set_file("tpl_listmesaje", "users/usersmesagessales.tpl");
				$tpl->set_var("MAIN_TITLE", "List Users Mesages");
				$mesages_per_page = '25';
				$p = isset($_GET['start']) ? $_GET['start']: 1;
				#for one user only
				if (isset($_GET['user_id']))
				{
					$user_id = $_GET['user_id'];
					$page_name = "users.listmesaje&user_id=".$user_id;
				}
				else
				{
					$user_id = '-1';
					$page_name = "users.listmesaje";
				}

				$logins_per_page=25;
				$mesages_per_page=25;
				$start = ($p-1)*$logins_per_page;
				#pagination query
				$query_limit = " LIMIT $start, $mesages_per_page ";
				#count user logins and display pagination
				$total_mesages = CountUserMesages ($user_id);
				$tpl->set_var("TOTAL_MESAGES", $total_mesages);
				$pages = ceil($total_mesages/$logins_per_page);
				$tpl->set_var("PAGES", $pages);
				$tpl->set_var("PAGINATION", AdminPagination($logins_per_page, $total_mesages, $page_name, $p));
				$get_users_mesages = GetUsersMesages($user_id,$query_limit);	$i = 0;
			//	print_r($get_users_mesages);
				$tpl->set_block("tpl_listmesaje", "list", "list_block");
					foreach($get_users_mesages as $ky => $val)
					{
						$bc = ($i % 2)+1;
						$tpl->set_var("BGCOLOR", 'row'.$bc);

						$user_info = GetUserDetails($val['user_id']);
						$tpl->set_var("USERNAME",$user_info['username']);
						if($val['user_id']=='-1')
						{
								$tpl->set_var("USERNAME","admin");
						}
						
						$query = "SELECT A.username, B.ip, B.user_agent, B.date as date_login,B.user_id
										FROM users A , logins B
										WHERE A.id = B.user_id AND B.user_id = '".intval($val['user_id'])."'
											ORDER BY B.date DESC ";
						$db->query($query);
						$db->next_record();
						$last_login = $db->f('date_login');
						

						$tpl->set_var("USER_ID",$val['user_id']);
						$tpl->set_var('ID_MESAJ', $val['id']);
						$tpl->set_var('NUME_EXPEDITOR',$val['nume_utilizator'] );
						$tpl->set_var('EMAIL',$val['email_utilizator'] );
						$tpl->set_var('TELEFON',$val['telefon']  );
						$tpl->set_var('SUBIECT_MESAJ',$val['subiect'] );
						$tpl->set_var('MESAJ', $val['mesaj']);
						$tpl->set_var("DATA", AdminTimeFormat($val['submision_date'],'Y'));
						
						$date_login = strtotime($last_login);
						$date_add_message =  strtotime($val['submision_date']);
						$code_row = $val['user_id']."-".$val['id'];
						$nr_letters = strlen($code_row);
						$query ="SELECT `read_messages` FROM `users_messages_links` WHERE SUBSTR(`acces_link`,'46','".$nr_letters."')='".$code_row."' AND `read_messages`='Y'";
							$db->query($query);
							$db->next_record();
							$read_m = $db->f('read_messages');
						if(($date_login > $date_add_message) || ($read_m=='Y'))
						{
							$tpl->set_var("COLOR_MESAGE","#330000");
							$tpl->set_var("MESAJ_STATUS","Citit");

						}
						else
						{
							$tpl->set_var("COLOR_MESAGE","#FF0000");
							$tpl->set_var("MESAJ_STATUS","Necitit");
						}

						if ($val['status'] == 'Y')
							{
								$tpl->set_var('IMAGE', 'active.png');
								$tpl->set_var('IMAGE_TITLE', 'inactive');
							}
							else 
							{
								$tpl->set_var('IMAGE', 'inactive.png');
								$tpl->set_var('IMAGE_TITLE', 'active');
							}
						
						$tpl->parse("list_block", "list", true);
						$i++;
				}
				
				$tpl->parse("MAIN", "tpl_listmesaje");
			break;
			
			case 'addpromovare':
				$tpl->set_file('tpl_main',$module.'/addpromovare.tpl');
				$tpl->set_var("MAIN_TITLE", "Adauga promovare");
				$tpl->set_block('tpl_main', 'list_pachete', 'list_pachete2');
				$tpl->set_block('tpl_main', 'list_servicii', 'list_servicii2');
				$tpl->set_file('tpl_cump',$module.'/facturare.tpl');
			
			
				$tpl->set_var('CAB_ID', $param1);
				$tpl->set_var('USER_ID', getUseridForCabinet($param1));
				$tpl->set_var('TOTAL','0');
				
				//list pachete
				$all_pk = $pachete->listPacheteBackend();
				foreach($all_pk  as $ky => $val)
				{
					$tpl->set_var('PACHET', $val['name']);
					$tpl->set_var('PACHET_ID', $val['id']);
					$tpl->set_var('COST', $val['pret']);
			
					$tpl->parse('list_pachete2', 'list_pachete', true);
				}
			
				//aici listam doar serviciile care sunt contra cost, excludem cele care sunt gratuite pentru a nu lista serviciile gratuite la pachetul basic
				$servs = $pachete->listServiciiPreferentiale();
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
				$tpl->parse("MAIN", "tpl_main");
			break;
					
			case 'dopromovare':
				$facturi = new Facturi($db);
				if($_POST['total']!='0' && $_POST['total']!='')
				{
					$cump_id = $facturi->addCumparator();
					$_POST['pachet'] = $_POST['firma_pachet'];
					$_POST['servicii'] = $_POST['firma_servicii'];
					$_POST['nume_firma'] = $_POST['nume'];
					$_POST['pers_contact'] = $_POST['nume'];
					$_POST['total'] = $_POST['total'];
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
					$plata_id = $facturi->addProforma($_POST['user_id'],$_POST['cabinet_id'],$_POST,'',$cump_id);
					$facturi->assignProformaAgent($plata_id,$admin->userID);
					### generate the HTML file for factura proforma
					$facturi->saveProformaFile($plata_id);
						
					$facturi->sendProformaByEmail($plata_id,$_POST['pachet'],$_POST['servicii'],$_POST['cabinet_id']);
				}
				else
				{
					
					$user_pachet = $pachete->getTipPromovare($_POST['cabinet_id']);
					if(is_array($user_pachet))
					{
						$pachete->updatePachetAndServicii($_POST);
					}
					else
					{
						$pachete->addFreeClientPachetAndServicii($_POST);
					}
					
					$sql = "UPDATE cabinete SET `level`='".$_POST['pachet']."', `recomandata`='N' WHERE id='".$_POST['cabinet_id']."'";
					$db->query($sql);
					
					$_SESSION['admin_info'] = "Tipul de promovare si serviciile oferite au fost modificate cu succes !";
					$facturi->updatePachetAchitat($_POST['cabinet_id']);
				}
				$facturi->assignCabinetAgent($_POST['cabinet_id'],$admin->userID);
				$_SESSION['admin_info_type'] = 'info';
				header ('location: index.php?page=users.details.'.$_POST['user_id']);
				exit;
			break;

			case 'details':
				$tpl->set_file("tpl_details", "users/userdetails2.tpl");
				$tpl->set_block('tpl_details', 'list_firme', 'list_firmee');
				$tpl->set_block('tpl_details', 'if_no_firme', 'if_no_firmee');
				$tpl->set_var("MAIN_TITLE", " User ". $param2. " Details");
				$tpl->set_var('USERNAME',ucfirst($param2) );
				$user_id = $param1;
				#user details
				$get_user_details=GetUserDetails($param1);
				$tpl->set_var("LASTNAME", $get_user_details['last_name']);
				$tpl->set_var("FIRSTNAME", $get_user_details['first_name']);
				$get_has_cab = GetFirme($user_id,"-1");
				$tpl->set_var('ARECABINET',"No" );
				if(count($get_has_cab)>0)
				{$tpl->set_var('ARECABINET',"Yes" );}
				$tpl->set_var("USERNAME", $get_user_details['username']);
				$tpl->set_var("MAINEMAIL", $get_user_details['email']);
				$tpl->set_var("SUBMIT_DATE",AdminTimeFormat($get_user_details['creation_date'],'Y'));
				$tpl->set_var("LAST_LOGIN", AdminTimeFormat($get_user_details['last_login'], 'Y'));
				$tpl->set_var("ID_USER", $user_id);
			
				$nr_fiscale = CountFiscaleForUser($user_id);
				$tpl->set_var("NR_FACT_FISCALE", $nr_fiscale );
			
			
				if ($get_user_details['status'] == '1')
				{
					$tpl->set_var('IMAGEUSER', 'active.png');
					$tpl->set_var('IMAGE_TITLE', 'inactive');
				}
				else
				{
					$tpl->set_var('IMAGEUSER', 'inactive.png');
					$tpl->set_var('IMAGEUSER_TITLE', 'active');
				}
				$tpl->set_var("BGCOLOR", "row1");
				if(substr($get_user_details['creation_date'],0,10)==date("Y-m-d"))
				{
					$tpl->set_var("BGCOLOR", "today_add");
				}
				#cabinete details
				$get_firme = GetFirme($user_id,"-1");
			
				//var_dump($get_firme);
				if(count($get_firme )>0)
				{
					foreach($get_firme as $ky => $val)
					{
						$tpl->set_var('PARENT_MODULE', GetCabinetParents($val['id']));
						$tpl->set_var('TYPE_ID', $val['category_id']);
						$tpl->set_var('JUDET_ID', $val['judet']);
						$tpl->set_var('NUME_FIRMA',ucfirst($val['nume_firma']) );
						$tpl->set_var('DESCRIERE', substr($val['descriere'],0,200)."...");
						$tpl->set_var('EDITFIRMA', '?page=cabinete.edit.'.$val['idfirma'].'.'.$user_id);

						$tpl->set_var('CAB_TEL',$val['fax'] );
						$tpl->set_var('CAB_EMAIL',$val['email_firma'] );
						$tpl->set_var('CAB_VISITS',$val['nr_visits'] );
						
						$main_photo = GetCabineteMainPhoto($val['id'],"cabinet");
						$tpl->set_var('THUMBNAIL', SITE_BASE.'/sources/thumbnails.php?target='.$main_photo['image_name'].'&max_size='.$conf->admin_gallery_max.'&folder='.$val['id']);
						
						$tpl->set_var('IDFIRMA', $val['idfirma']);
						$get_contract_id = GetContractForCabinet($val['idfirma']);
						$get_proforma_id = GetLastProformaForCabinet($val['idfirma']);
						$tpl->set_var('PROFORMA_ID', $get_proforma_id);
						$tpl->set_var('CONTRACT_ID',$get_contract_id );
			
						// show tip promovare
						$get_tip_promovare = "";
						$user_pachet = $pachete->getTipPromovare($val['idfirma']);
			
						//this is for the new promovare using pachete and servicii
						if(is_array($user_pachet))
						{
							$pkInfo = $pachete->getPachetInfo($user_pachet['pachet']);
							$get_tip_promovare = "<a href='index.php?page=users.viewpromovare.".$val['idfirma']."'>".$pkInfo['name']." - ".$user_pachet['pret']." RON</a>";
						}
						else
						{
							if(stristr($val['level'],',')!==false)
							{
								$price = explode(",",$val['level']);
								foreach($price as $k => $v)
								{
									$pkInfo = $pachete->getPachetInfo($v);
									$get_tip_promovare = $get_tip_promovare." <br>".$pkInfo['name']." - ".$pkInfo['pret']." RON";
								}
							}
							else
							{
								$pkInfo = $pachete->getPachetInfo($val['level']);
								$get_tip_promovare = $pkInfo['name']." - ".$pkInfo['pret']." RON";
							}
							$get_tip_promovare.= "<p>[ <a href='index.php?page=users.addpromovare.".$val['idfirma']."'>schimba promovare</a> ]</p>";
						}
						$tpl->set_var('PROMOVARE', $get_tip_promovare);
			
			
						if($val['recomandat']=='N')
						{
							$tpl->set_var('RECOMANDED', "NO" );
							$tpl->set_var('CHANGE_RECOMANDED', 'change_yes' );
							$tpl->set_var('PRELUNGESTE_PROMOVARE', "" );
						}
						else
						{
							$tpl->set_var('RECOMANDED', "YES" );
							$tpl->set_var('PRELUNGESTE_PROMOVARE', "<a href=\"?page=plati.prelungestepromovare.".$val['idfirma'].".".$user_id.".".$val['judet'].".".$val['category_id']."\">Prelungeste promovare</a>" );
							$tpl->set_var('CHANGE_RECOMANDED','change_no'  );
						}
			
						if ($val['status'] == '1')
						{
							$tpl->set_var('IMAGE', 'active.png');
							$tpl->set_var('IMAGE_TITLE', 'inactive');
						}
						else
						{
							$tpl->set_var('IMAGE', 'inactive.png');
							$tpl->set_var('IMAGE_TITLE', 'active');
						}
						$tpl->parse('list_firmee', 'list_firme', true);
					}
				}
				else
				{
					$tpl->parse('if_no_firmee', 'if_no_firme', true);	}
					#now display anunturile pt userul respectiv
					$tpl->set_block('tpl_details', 'list_anunturi', 'list_anunturi_block');
					$tpl->set_block('tpl_details', 'no_anunturi', 'no_anunturi_block');
					$get_anunturi = GetAnunturi($param1,"-1");
					//	print_r($get_anunturi );
					if (count($get_anunturi) != '0')
					{
						$i = 0;
						while (list($k, $v) = each($get_anunturi))
						{
							#set colors
							$bc = ($i % 2)+1;
							$tpl->set_var("BGCOLOR",'row'.$bc);
			
							if($v['data_adaugarii']== date("Y-m-d")||(substr($v['data_modificarii'],0,10)== date("Y-m-d")))
							{
								$tpl->set_var("BGCOLOR", "today_add"); 
							}
							$tpl->set_var('VIZITE', $v['nr_visits']);
							$tpl->set_var('ID', $v['id']);
							$tpl->set_var('CONTENT',text_best_fit($v['continut'],150));
							$tpl->set_var('TITLU', $v['titlu']);
							$tpl->set_var('THUMBNAILS', "../sources/thumbnails.php?target=".$v['imagine'].'&max_size='.$conf->admin_gallery_max.'&anunturi=yes');

							$tpl->set_var('DATE_EXP', substr($v['data_expirarii'],0,10));
							$tpl->set_var('DATE_ADDED', $v['data_adaugarii']);
							$tpl->set_var('DATE_MOD', substr($v['data_modificarii'],0,10));
							if(substr($v['data_expirarii'],0,10)== date("Y-m-d"))
							{
								$tpl->set_var("BGCOLOR", "alert_anunt");
							}
			
							if ($v['status'] == '1')
							{
								$tpl->set_var('IMAGE', 'active.png');
								$tpl->set_var('IMAGE_TITLE', 'inactive');
							}
							else
							{
								$tpl->set_var('IMAGE', 'inactive.png');
								$tpl->set_var('IMAGE_TITLE', 'active');
							}
			
							$tpl->parse('list_anunturi_block', 'list_anunturi', true);
							$i++;
						}
					}
					else
					{
						$tpl->parse('no_anunturi_block', 'no_anunturi', true);
					}
				
					#list all articles of the user
					$tpl->set_block('tpl_details', 'list_articole', 'list_articole_block');
					$tpl->set_block('tpl_details', 'no_articole', 'no_articole_block');
					$get_anunturi = GetArticole($param1,"-1");
					if (count($get_anunturi) != '0')
					{
						$i = 0;
						while (list($k, $v) = each($get_anunturi))
						{
							#set colors
							$bc = ($i % 2)+1;
							$tpl->set_var("BGCOLOR",'row'.$bc);
							if($v['data_adaugarii']== date("Y-m-d")||(substr($v['data_modificarii'],0,10)== date("Y-m-d")))
							{
								$tpl->set_var("BGCOLOR", "today_add"); 
							}
			
							$tpl->set_var('ID', $v['id']);
							$tpl->set_var('CONTENT',text_best_fit($v['continut'],150));
							$tpl->set_var('TITLU', $v['titlu']);
							//$tpl->set_var('VISITS', $v['nr_visits']);
							$tpl->set_var('ART_VISITS', $v['nr_visits']);
							$tpl->set_var('THUMBNAILS', "../sources/thumbnails.php?target=".$v['imagine'].'&max_size='.$conf->admin_gallery_max.'&articles=yes');
			
							$tpl->set_var('DATE_ADDED', $v['data_adaugarii']);
							$tpl->set_var('DATE_MOD', substr($v['data_modificarii'],0,10));
							if(isset($v['data_expirarii']) && substr($v['data_expirarii'],0,10)== date("Y-m-d"))
							{
								$tpl->set_var("BGCOLOR", "alert_anunt"); 
							}
			
							if ($v['status'] == '1')
							{
								$tpl->set_var('IMAGE', 'active.png');
								$tpl->set_var('IMAGE_TITLE', 'inactive');
							}
							else
							{
								$tpl->set_var('IMAGE', 'inactive.png');
								$tpl->set_var('IMAGE_TITLE', 'active');
							}
							
							$tpl->parse('list_articole_block', 'list_articole', true);
							$i++;
						}
					}
					else
					{
						$tpl->parse('no_articole_block', 'no_articole', true);
					}
			
					#mesaje / utilizator
					$query_limit="LIMIT 0, 50";
					$get_users_mesages = GetUsersMesages($user_id,$query_limit);
					$i = 0;
					$tpl->set_block("tpl_details", "list", "list_block");
					foreach($get_users_mesages as $ky => $val)
					{
						$bc = ($i % 2)+1;
						$tpl->set_var("BGCOLOR", 'row'.$bc);
			
						$query = "SELECT A.username, B.ip, B.user_agent, B.date as date_login,B.user_id
										FROM users A , logins B
										WHERE A.id = B.user_id AND B.user_id = '".intval($val['user_id'])."'
											ORDER BY B.date DESC ";
						$db->query($query);
						$db->next_record();
						$last_login = $db->f('date_login');
						$tpl->set_var("USER_ID",$val['user_id']);
						$tpl->set_var('ID_MESAJ', $val['id']);
						$tpl->set_var('NUME_EXPEDITOR',$val['nume_utilizator'] );
						$tpl->set_var('EMAIL',$val['email_utilizator'] );
						$tpl->set_var('TELEFON',$val['telefon'] );
						$tpl->set_var('SUBIECT_MESAJ',$val['subiect'] );
						$tpl->set_var('MESAJ', $val['mesaj']);
						$tpl->set_var("DATA", AdminTimeFormat($val['submision_date'],'Y'));
		
						$date_login = strtotime($last_login);
						$date_add_message =  strtotime($val['submision_date']);
						if($val['citit']=='Y')
						{
							$tpl->set_var("COLOR_MESAGE","#330000");
							$tpl->set_var("MESAJ_STATUS","Citit");
						}
						else
						{
							if($date_login > $date_add_message)
							{
								$tpl->set_var("COLOR_MESAGE","#330000");
								$tpl->set_var("MESAJ_STATUS","Citit");
							}
							else
							{
								$tpl->set_var("COLOR_MESAGE","#FF0000");
								$tpl->set_var("MESAJ_STATUS","Necitit");
							}
						}
						if ($val['status'] == 'Y')
						{
							$tpl->set_var('IMAGE', 'active.png');
							$tpl->set_var('IMAGE_TITLE', 'inactive');
						}
						else
						{
							$tpl->set_var('IMAGE', 'inactive.png');
							$tpl->set_var('IMAGE_TITLE', 'active');
						}
			
						$tpl->parse("list_block", "list", true);
						$i++;
					}
				$tpl->parse('MAIN', 'tpl_details', true);
			break;
		}
	break;
}

?>