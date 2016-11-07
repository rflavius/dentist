<?php

$pachete = new Pachete_Servicii($db);

switch($admin->level)
{
	case '1':
		switch ($action)
		{
			default :
				$tpl->set_file('tpl_edit', 'cabinete/edit.tpl');
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
				#set colors
				$tpl->set_var('BGCOLOR1', 'row1');
				$tpl->set_var('BGCOLOR2', 'row2');
				#get info
				$get_module = GetModules(intval($action));
				$the_module = $get_module['0'];
				if (isset($_SESSION['edit_modules_content']))
				{
					$the_module = $_SESSION['edit_modules_content'];
					unset($_SESSION['edit_modules_content']);
				}
				$tpl->set_var('ID', $the_module['id']);
				#the param for the edit categories
				$tpl->set_var('PARENT_ID', $the_module['id']);
				$tpl->set_var('NAME', $the_module['name']);
				$tpl->set_var('KEYWORDS', $the_module['meta_keywords']);
				$tpl->set_var('DESCRIPTION', $the_module['meta_description']);
				$tpl->set_var('CONTENT', $the_module['content']);
				#page main title
				$tpl->set_var('MAIN_TITLE', 'Edit '.$the_module['name'].' module');
				$link = str_replace(".", "_", $the_module['link']);
				$tpl->set_var('LINK', $link.FILE_EXTENSION);
				#status
				if ($the_module['active'] == '1')
				{
					$tpl->set_var('STATUS_ACTIVE', 'selected');
				}
				else 
				{
					$tpl->set_var('STATUS_INACTIVE', 'selected');
				}
				#the block for the cabinet categories for this module and the error block
				$tpl->set_block('tpl_edit', 'list_categories', 'list_categories_block');
				$tpl->set_block('tpl_edit', 'if_categories', 'if_categories_block');
				$get_module_categories = GetCabineteCategories($action, '-1', '');
				if (count($get_module_categories) != '0')
				{
					$i = 0;
					while (list($k, $v) = each($get_module_categories))
					{
						#set colors
						$bc = ($i % 2)+1;
						$tpl->set_var("BGCOLOR", 'row'.$bc);
						$tpl->set_var('CAT_ID', $v['id_cat']);
						$tpl->set_var('CAT_NAME', $v['cat_name']);
						if ($v['active'] == 'Y')
						{
							$tpl->set_var('IMAGE', 'active.png');
							$tpl->set_var('IMAGE_TITLE', 'inactive');
						}
						else 
						{
							$tpl->set_var('IMAGE', 'inactive.png');
							$tpl->set_var('IMAGE_TITLE', 'active');
						}
						$tpl->parse('list_categories_block', 'list_categories', true);
						$i++;
					}
					$tpl->parse('if_categories_block', 'if_categories', true);
				}
				#the category information message
				$tpl->set_file('tpl_catinfo', 'info/info.tpl');
				$tpl->set_var('MESSAGE', 'Add, edit and delete cabinet module categories.');
				$tpl->parse('CATEGORY_INFORMATION', 'tpl_catinfo');
				$tpl->parse('MAIN', 'tpl_edit');
			break;

			case 'categories':
				switch ($param1)
				{
					case 'add':
						if (trim($_POST['cat_name']) == "")
						{
							$_SESSION['admin_info'] = "Please provide a name for the category !";
							$_SESSION['admin_info_type'] = 'error';
							header ('location: ?page=cabinete.'.$param2);
							exit;
						}
						if (CategoryExists($_POST['cat_name'], $param2))
						{
							$_SESSION['admin_info'] = "Category already exists for this module !";
							$_SESSION['admin_info_type'] = 'error';
							header ('location: ?page=cabinete.'.$param2);
							exit;
						}
						#no errors - add the category and return with success message
						InsertCategory($_POST['cat_name'], $param2);
						$_SESSION['admin_info'] = "Category added successfully !";
						$_SESSION['admin_info_type'] = 'info';
						header ('location: ?page=cabinete.'.$param2);
						exit;
					break;

					case 'delete':
						$query = "DELETE FROM cabinete_categories WHERE id_cat = '".intval($param2)."'";
						$db->query($query);
						$_SESSION['admin_info'] = "Category successfully deleted !";
						$_SESSION['admin_info_type'] = 'info';
						header ('location: '.$_SERVER['HTTP_REFERER']);
						exit;
					break;

					case 'set':
						ChangeCategoryStatus($param2, $param3);
						$_SESSION['admin_info'] = "Category status successfully changed !";
						$_SESSION['admin_info_type'] = 'info';
						header ('location: '.$_SERVER['HTTP_REFERER']);
						exit;
					break;

					case 'edit':
						$tpl->set_file('tpl_categories', 'cabinete/edit_cat.tpl');
						$tpl->set_var('MAIN_TITLE', 'Edit Category');
						#for the form
						$tpl->set_var('ID', $param2);
						$tpl->set_var('PARENT_ID', $param3);
						#set colors
						$tpl->set_var('BGCOLOR1', 'row1');
						$tpl->set_var('BGCOLOR2', 'row2');
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
						$tpl->set_var('CAT_NAME', GetCategoryName($param2));
						$get_info_cat = GetInfoCat($param2);
					
						$tpl->set_var('META_DESCRIPTION', $get_info_cat['meta_description']);
						$tpl->set_var('META_KEYWORDS',$get_info_cat['meta_keywords'] );
						$tpl->parse('MAIN', 'tpl_categories');
					break;

					case 'save':
						if (trim($_POST['cat_name']) == "")
						{
							$_SESSION['admin_info'] = "Please provide a name for the category !";
							$_SESSION['admin_info_type'] = 'error';
							header ('location: '.$_SERVER['HTTP_REFERER']);
							exit;
						}
						#no errors - add the category and return with success message
						SaveCategory($_POST['cat_name'],$_POST['meta_keywords'],$_POST['meta_description'], $param2);
						$_SESSION['admin_info'] = "Modificarile au fost realizate cu succes !";
						$_SESSION['admin_info_type'] = 'info';
						header ('location: ?page=cabinete.'.$param3);
						exit;
					break;
				}
			break;

			case 'save':
				#title and link
				$errors = array();
				if (trim($_POST['name']) == '')
				{
					$errors['0'] = 'Please provide a name for the module';
				}
				if (count($errors) != '0')
				{
					$display_errors = "";
					foreach ($errors as $key => $val)
					{
						$display_errors .= $val."<br />";
					}
					$_SESSION['admin_info'] = $display_errors;
					$_SESSION['admin_info_type'] = 'error';
					#get the link, page_picture if there are saved
					$get_module = GetModules(intval($param1));
					$info = $get_module['0'];
					$link = $info['link'];
					#put info that doesn't come from the post into array
					$tempArray = array("id" => intval($param1), "link" => $link);
					$_POST = array_merge($_POST, $tempArray);
					$_SESSION['edit_modules_content'] = $_POST;
					header ('location: '.$_SERVER['HTTP_REFERER']);
					exit;
				}
				else 
				{
					SaveModuleChanges(addslashes($_POST['name']), $_POST['active'], addslashes($_POST['meta_keywords']), addslashes($_POST['meta_description']), addslashes($_POST['content']), intval($param1));
				}
				$_SESSION['admin_info'] = 'Update succesfully made !';
				$_SESSION['admin_info_type'] = 'info';
				header ('location: '.$_SERVER['HTTP_REFERER']);
				exit;
			break;

			case 'add':
				$tpl->set_file('tpl_add', 'cabinete/add_cabinet.tpl');
				$tpl->set_var('BGCOLOR1', 'row1');$tpl->set_var('BGCOLOR2', 'row2');
				$tpl->set_var('META_KEYWORDS', $conf->def_meta_keywords);
				$tpl->set_var('META_DESCRIPTION', $conf->def_meta_description);
				#page main title
				$tpl->set_var('MAIN_TITLE', 'Add new cabinet');
				#set blocks
				$tpl->set_block('tpl_add', 'display_cats', 'display_catss');
				$tpl->set_block('tpl_add', 'judet', 'judett');
				$tpl->set_block("tpl_add", "error", "error_block");
				$tpl->set_var('LOC_DIV_ADAUGAFIRMA',"Alegeti judetul intai!" );
				$tpl->set_var('MAX_PICTURE_WIDTH',$conf->max_img_anunt);
				
				$get_dentist_categ = Get_Dentist_Cats('-1');
				foreach($get_dentist_categ as $ky => $val)
				{
					if(isset($_SESSION['submit_firma'][0])&&($_SESSION['submit_firma'][0]!=""))
					{
						$values = explode("=>",$_SESSION['submit_firma'][0]);
						if($values[1]==$val['id'] )
						{		$tpl->set_var('SELECTTEDCAT',"selected");	}
						else
						{		$tpl->set_var('SELECTTEDCAT',"");		}
					}
					$tpl->set_var('CAT_NAME',$val['name'] );
					$tpl->set_var('CAT_ID',$val['id'] );
					$tpl->parse('display_catss', 'display_cats', true);
				}
				
				$get_dentist_judete = GetJudete();
				foreach($get_dentist_judete as $ky => $val)
				{
					if(isset($_SESSION['submit_firma'][4])&&($_SESSION['submit_firma'][4]!=""))
					{
						$values = explode("=>",$_SESSION['submit_firma'][4]);
						$judt_code = $values[1];
						if(strtolower($values[1])==strtolower($val['code']) )
						{		$tpl->set_var('SELECTTEDJUDET',"selected");	}
						else
						{		$tpl->set_var('SELECTTEDJUDET',"");		}
					}
					
					$tpl->set_var('COD_JUDET',$val['code'] );
					$tpl->set_var('NUMEJUDET',$val['name'] );
					$tpl->parse('judett', 'judet', true);
				}

				if(isset($_SESSION['submit_firma'][5])&&($_SESSION['submit_firma'][5])!="")
				{
						$tpl->set_file("tpl_loc_ajax","../modules/search/localitati_ajax_faratoate.tpl");
						$tpl->set_block('tpl_loc_ajax', 'loocalitati', 'loocalitatii');
						$cod_judet = $judt_code;
						$get_dentist_localitati = GetLocalitati($cod_judet);
						$values = explode("=>",$_SESSION['submit_firma'][5]);
						foreach($get_dentist_localitati as $ky => $val)
						{
							if($val['id']==$values[1])
							{			$tpl->set_var('SELECTED_LOC',"selected" );		}
							else
							{			$tpl->set_var('SELECTED_LOC',"" );	}
						
							$tpl->set_var('ID_LOCALITATE',$val['id'] );
							$tpl->set_var('NUMELOCALITATE',$val['name'] );
							$tpl->parse('loocalitatii', 'loocalitati', true);
						}
					$tpl->parse('LOC_DIV_ADAUGAFIRMA','tpl_loc_ajax');
				}
				else
				{
					$tpl->set_var('LOC_DIV_ADAUGAFIRMA','Alegeti localitatea');
				}
				
				if (isset($_SESSION['submit_errors']))
					{
						$tpl->set_var("ERROR_MSG", $_SESSION['submit_errors']);
						unset($_SESSION['submit_errors']);
						$tpl->parse("error_block", "error", true);
					}
					#fill fields
					if (isset($_SESSION['submit_firma']))
					{
						foreach ($_SESSION['submit_firma'] as $key => $val)
						{
								$values = explode("=>",$val);
								if($values[0]=="judet")
								{	$tpl->set_var(strtoupper($values[0]), "selected"); }
								elseif($values[0]=="perioada")
								{
									$tpl->set_var('SELECTED_'.$values[1],"selected" );
								}
								elseif($values[0]=="type")
								{
										if(($values[1]!="none")&&($values[1]!=""))
										{
											$tpl->set_var('SELECTED_'.strtoupper($values[1]),"selected" );
											$tpl->set_file("tpl_formplace","../modules/user/".$values[1].".tpl");
											$tpl->parse('LOC_FORM_PLACE','tpl_formplace');
										}
								}
								else
								{	$tpl->set_var(strtoupper($values[0]), $values[1]); }
						}
						unset($_SESSION['submit_firma']);
					}
				$tpl->parse("MAIN", "tpl_add");
			break;

			case 'insert':
					#if errors exist create arrays and return to previous pages
					$array_obligatorii = array("category_id"=>"Categoria nu e setata","nume_firma"=>"Numele firmei nu e setat ","adresa_firma"=>"Adresa firmei nu e setata","judet"=>"Judetul nu e setat","nume_loc_sector"=>"Localitate/sector nu e setat","orar"=>"Nu aveti orar","pers_contact"=>"Persoana de contact nu e setata","persc_email"=>"Adresa de email persoana contact nu e setata","descriere"=>"Descrierea nu e setata","perioada"=>"Perioada contractului nu e setata" ,"type"=>"Nu ati ales modul de plata(firma,persoana fizica,none)");
						
						$display_errors = '';
						foreach($_POST as $ky => $val)
						{
							if((array_key_exists($ky,$array_obligatorii))&&($val==""))
							{
									$display_errors .= '<li>'. $array_obligatorii[$ky].".</li>";
							}
						}
						

					if (array_key_exists('nume_loc_sector', $_POST)===FALSE) 
						{
						 $display_errors .= "<li>".$array_obligatorii['nume_loc_sector'].".</li>";
						}
						#check nume firma
						$check_nume_firma = CheckNumeFirma($_POST['nume_firma']);
						if(isset($check_nume_firma)&&($check_nume_firma!=""))
						{
							$display_errors .= $check_nume_firma;
						}
						
						if(isset($_POST['persc_email'])&&($_POST['persc_email']!=""))
						{
						$email = ValidEmail($_POST['persc_email']);
						if(!$email)
						{	$display_errors .="<li>Adresa de email a persoanei de contact este invalida.</li>";	}
						}
						
						if(isset($_POST['adresa_web'])&&($_POST['adresa_web']!=""))
						{
							$url = ValidateURL($_POST['adresa_web']);
							if(!$url)
							{	$display_errors .="<li>Adresa web este incorecta.</li>";	}

						}

						if(isset($_POST['email_firma'])&&($_POST['email_firma']!=""))
						{
							$url = ValidEmail($_POST['email_firma']);
							if(!$url)
								{	$display_errors .="<li>Adresa de email a firmei este invalida.</li>";	}

						}
						
						#lets add two images(imaginea de cabinet - imaginea cu harta (unde e situat cabinetul))
						#this is the image for cabinet
							if ($_FILES['picture_item1']['type']!= "")
							{
								$result =  CheckPictureItemCabinet();
								if ($result == '0')
								{
									$display_errors .=  '<li>'.'Imaginea pentru cabinet nu are una din extensiile acceptate!'.'</li>';
								}
								elseif ($result == '1')
								{
									$display_errors .= '<li>'. 'Imagine cabinet - Va rugam respectati dimensiunile maxime admise!'.'</li>';
								}
							}
							
							#this is for map...harta cabinet
							if ($_FILES['picture_item2']['type']!= "")
							{
								$result = CheckPictureItemHarta();
								if ($result == '0')
								{
									$display_errors .=  '<li>'. 'Imaginea pentru harta nu are una din extensiile acceptate!'.'</li>';
								}
								elseif ($result == '1')
								{
								$display_errors .=  '<li>'.'Imagine harta-Va rugam respectati dimensiunile maxime admise!'.'</li>';
								}
							}
								#lets check emitere factura
						if(isset($_POST['type'])&&($_POST['type']!=""))
						{
							if($_POST['type']=='persoana_fizica')
							{
								if(!isset($_POST['inreg_fiscala_cnp'])||($_POST['inreg_fiscala_cnp']==""))
								{
									$display_errors .=  '<li>'. 'Ati uitat sa complectati CNP.'.'</li>';
								}
								if(!isset($_POST['reg_comert_bi'])||$_POST['reg_comert_bi']=="")
								{
									$display_errors .=  '<li>'. 'Nu ati complectat seria si numarul de buletin.'.'</li>';
								}
								if(!isset($_POST['persc_tel'])||$_POST['persc_tel']=="")
								{
									$display_errors .=  '<li>'. 'Numarul de telefon al persoanei de contact nu e setat.'.'</li>';
								}
								if(!isset($_POST['persc_adresa'])||$_POST['persc_adresa']=="")
								{
									$display_errors .=  '<li>'. 'Adresa persoanei de contact nu este setata.'.'</li>';
								}
								if(!isset($_POST['zip_code'])||$_POST['zip_code']=="")
								{
									$display_errors .=  '<li>'. 'Codul postal nu e setat.'.'</li>';
								}
							}
							elseif($_POST['type']=='firma')
							{
									if(!isset($_POST['inreg_fiscala_cnp'])||$_POST['inreg_fiscala_cnp']=="")
									{
										$display_errors .=  '<li>'. 'Inregisrarea fiscala nu este setata.'.'</li>';
									}
									if(!isset($_POST['reg_comert_bi'])||$_POST['reg_comert_bi']=="")
									{
										$display_errors .=  '<li>'. 'Registru comertului nu este setat.'.'</li>';
									}
										if(!isset($_POST['zip_code'])||$_POST['zip_code']=="")
									{
										$display_errors .=  '<li>'. 'Codul postal pentru adresa firma nu e setat.'.'</li>';
									}
							}

						}
						if($display_errors!="")
						{		
								#let_put in sessions all infos from post in case we have errors
								$_SESSION['submit_errors'] = $display_errors;
								$_SESSION['submit_firma']=array();
								foreach($_POST as $ky => $val)
								{
									$info = $ky ."=>".$val;	array_push($_SESSION['submit_firma'],$info);
								}
								header('location: '.GetReferer());
								exit;
						}
							$user_id = "-1";
							
							#insert infos about cabinet ,we take the id of cabinet
							$type = $_POST['type'];
							$perioada = $_POST['perioada'];
							$id_some_info = InsertPartFromFirma($_POST['nume_firma'],$user_id,$type,$perioada);
							foreach($_POST as $ky => $val)
							{
									if(strpos($ky,"caractere")!==FALSE)
									{
										unset($_POST[$ky]);
									}
									else
									{
										$query="Update cabinete set ".$ky."='".addslashes($val)."' WHERE id='".$id_some_info."'";
										$db->query($query);
									}
									
							}
							#let's insert cabinet to his category
							$inser_cab_to_cat = InsertCabinetToCat($id_some_info,$_POST['category_id'],$_POST['judet']);
							#daca avem setata poza pt cabinet o salvam
							if ($_FILES['picture_item1']['type'] != "" )
							{
								$extension = explode('/',$_FILES['picture_item1']['type']);
								$file_extension = $extension[1];//echo "extenis:".$file_extension;
								SavePicturesCabinete($file_extension, $id_some_info,"backend" );
							}
							elseif ($_FILES['picture_item1']['type'] == "" )
							{
								$file_extension="default";
								SavePicturesCabinete($file_extension, $id_some_info,"backend" );
							}
							
							#daca avem poza pt harta o salvam:D
							if ($_FILES['picture_item2']['type'] != "" )
							{
								$extension = explode('/',$_FILES['picture_item2']['type']);
								$file_extension = $extension[1];//echo "extenis:".$file_extension;
								SavePicturesMap($file_extension, $id_some_info,"backend" );
							}
							elseif ($_FILES['picture_item2']['type'] == "" )
							{
								$file_extension="default";
								SavePicturesMap($file_extension, $id_some_info,"backend" );
							}
							GenerateSmallImages($id_some_info);

							#daca adaugam o firma la care emitem factura,sa inseram in db palti si sa trimitem email
							if($type!="none")
							{
									#	inseram date factura proforma
									$pret_perioada = "pret_perioada_".$_POST['perioada'];
									$emis_fact = 'Y';
									$plata_id = InsertPlata($user_id,$id_some_info,$_POST['nume_firma'],$_POST['perioada'],$_POST['type'],$emis_fact,$conf->$pret_perioada );
									
									
									#lets send an email with factura proforma
									$nr_fact_proforma = $plata_id;
									$Sender = $conf->contact_recipient;
									$Recipiant = $_POST['persc_email'];
									$CustomHeaders = '';
									$text = GetFileContent("../templates/emails/factura_proforma.tpl");
									
									#acestea sunt aceleasi indiferent pe cine se emite factura proforma
									$text = str_replace("%NUME_PERS_CONTACT%",	ucfirst($_POST['pers_contact']) , $text);
									$text = str_replace("%NUMAR_FACTURA_PROFORMA%",$nr_fact_proforma, $text);
									$text =str_replace("%EXPIRARE_FACTURA_PROFORMA%",$conf->expirare_proforma,$text); 
									$text = str_replace("%DATA%",date("d-M-Y"),$text);
									$text = str_replace("%PRET_TOTAL%",$conf->$pret_perioada,$text);
									if($_POST['perioada']==="1")
									{
										$text = str_replace("%DENUMIRE_SERVICI%","Promovare online pentru ".$_POST['nume_firma'].", din ".date("d-M-Y")." pana in ".date("d-M-Y", mktime(0, 0, 0, date("m"), date("d")+5, date("Y")+1)),$text);
									}
									else
									{
											$text = str_replace("%DENUMIRE_SERVICI%","Promovare online pentru ".$_POST['nume_firma'].", din ".date("d-M-Y")." pana in ".date("d-M-Y", mktime(0, 0, 0, date("m"), date("d")+5, date("Y")+2)),$text);
									}
									$text = str_replace("%COD_FISCAL_CNP%",	$_POST['inreg_fiscala_cnp'] , $text);
									$text = str_replace("%NR_REG_COM_BI%",	$_POST['reg_comert_bi'] , $text);
									
									$pret = $conf->$pret_perioada;
									$pret_fara_tva =$pret - $pret * 0.19;
									$valoare_tva = $pret * 0.19;
									$text = str_replace("%VALOARE_TVA%",	$valoare_tva , $text);
									$text = str_replace("%PRET_TOTAL_FARA%",	$pret_fara_tva , $text);
									$get_name_localitate = GetLocalitate($_POST['nume_loc_sector']);

									
									#daca se emite factura pe firma
									if($_POST['type']=="firma")
									{
										#aici emitem factura pentru firma
										$text = str_replace("%NUME_PERS_CONTACT_FIRMA%",	$_POST['nume_firma'] , $text);
										$text = str_replace("%ADRESA%",	$_POST['adresa_firma']." <br /> ".$get_name_localitate['name'].", ".$_POST['judet'].",".$_POST['zip_code'] , $text);
									
									}
									else
									{
										$text = str_replace("%NUME_PERS_CONTACT_FIRMA%",$_POST['pers_contact'] , $text);
										$text = str_replace("%ADRESA%",	$_POST['persc_adresa'], $text);
											$text = str_replace("%COD_FISCAL_CNP%",	$_POST['inreg_fiscala_cnp'] , $text);

									}

									$Subject = "Factura proforma :". $nr_fact_proforma;	
									$message = new Email($Recipiant, $Sender, $Subject, $CustomHeaders);
									$message->SetHtmlContent($text);
									if (ValidHeader($Sender))
									{
										$message->Send();
										$emis_fact = "Y";
									}
									else
									{
										$emis_fact="N";
										$query ="Update plati set emis_fact_proforma='N' where id='".$nr_fact_proforma."'";
										$db->query($query);
									}
							}
							
							$_SESSION['admin_info_type'] = 'info';
							$_SESSION['admin_info'] = "Cabinetul,Laboratorul,Clinica  a fost adaugata cu succes!";
					
						header ('location: ?page=cabinete.list');
						exit;
			break;

			case 'list':
				$tpl->set_file('tpl_list', 'cabinete/list.tpl');
				$tpl->set_var('MAIN_TITLE', 'List cabinete , laboratoare, clinici din Romania');
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
				#check if the selected parent is a category or a module
				$path = explode("_", $param1);
				switch ($path['0'])
				{
					default :
						$all_cabinete = 0;
						$total_records = CountCabineteTotalRecords('-1', '');
					break;

					case 'category':
						$cat_id = $path['1'];
						$total_records = CountCabineteTotalRecords($path['0'], $path['1']);
					break;

					case 'module':
						$the_module_id = $path['1'];
						$total_records = CountCabineteTotalRecords($path['0'], $path['1']);
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
				#cabinete count
				$tpl->set_var('COUNT_CABINETE', $total_records);
				$pages_number = ceil($total_records/$conf->admin_cabinete_per_page);
				$tpl->set_var("PAGES", $pages_number);
				#create de pagination page_name
				$page_name = $module.'.'.$action;
				if(isset($_GET['start'])&&($_GET['start']!=""))
				{
						$start = $_GET['start'];
						$start_q = $conf->admin_cabinete_per_page*($start-1);
				}
				 else
				{
					$start_q = 0;
					$start = 1;
				}
				#to set the display mode, make some rules of display about data modificarii, or others

				if(isset($_GET['displaymode'])&&($_GET['displaymode']!=""))
				{
						$dispmode = $_GET['displaymode'];
				}
				 else
				{
					$dispmode = "data-submision_date-DESC";
				}

				if ($param1 != '')
				{
					$page_name = $page_name.'.'.$param1;
				}
				
				/*if(!isset($start))
				{
					$start_q = 0;
					$start = 1;
				}
				else
				{
					$start_q = $conf->admin_cabinete_per_page*($start-1);
				}*/
				#Create and parse pagination
				$html_pages = AdminPaginationCabineteAnuntArticole($conf->admin_cabinete_per_page, $total_records, $page_name, $start,$dispmode);
				$tpl->set_var("PAGINATION", $html_pages);
				$tpl->set_var("PAGE_NAME",$page_name );
				#Set blocks
				$tpl->set_block('tpl_list', 'list_cabinete', 'list_cabinete_block');
				$tpl->set_block('tpl_list', 'if_cabinete', 'if_cabinete_block');
				$tpl->set_block('tpl_list', 'if_no_cabinete', 'if_no_cabinete_block');
				#Create query limit and get the cabinete for displaing
				$query_limit = " LIMIT $start_q, $conf->admin_cabinete_per_page";
				if (isset($all_cabinete))
				{
					$cabinete = ListAdminCabinete('-1', '', $query_limit,$dispmode);
				}
				else 
				{
					$cabinete = ListAdminCabinete($path['0'], $path['1'], $query_limit,$dispmode);
				}
				if (count($cabinete) != '0')
				{
					$i = 0;
					while (list($k, $v) = each($cabinete))
					{
						#set colors
						$bc = ($i % 2)+1;
						$tpl->set_var("BGCOLOR",'row'.$bc);
						
						if($v['submision_date']==date("d M Y"))
						{	$tpl->set_var("BGCOLOR", "today_add"); }
						$tpl->set_var('NR_VISITS',$v['nr_visits'] );
						$tpl->set_var('ID', $v['id']);
						$tpl->set_var('NUME_CABINET', $v['nume_firma']);
						$tpl->set_var('ACCES_TELEPHONES',$v['phone_views'] );
						$tpl->set_var('JUDET_ID',$v['judet'] );
						$tpl->set_var('TYPE_ID',$v['category_id'] );
						$tpl->set_var('AGENT',getAgentName($v['admin_id']));
						$main_photo = GetCabineteMainPhoto($v['id'],"cabinet");
						$tpl->set_var('IMAGINE', SITE_BASE.'/sources/thumbnails.php?target='.$main_photo['image_name'].'&max_size='.$conf->admin_gallery_max.'&folder='.$v['id']);
					
						$video = getCabinetVideoFile($v['id']);
						if (is_array($video) )
						{
							$tpl->set_var('NR_VIDEO', 1); 
						}
						else 
						{
						$tpl->set_var('NR_VIDEO', 0); 
						}
						$tpl->set_var('MODIFICA_VIDEO', "index.php?page=cabinete.modificavideo.".$v['id'].".".$v['user_id']);
							
						$get_banner = GetBanner($v['id']);
						if($get_banner!="")
						{
							$tpl->set_var('NR_BANNER', 1);
						}
						else
						{
							$tpl->set_var('NR_BANNER', 0);
						}
						
						
						$count_images = GetCabineteImages($v['id']);
						$tpl->set_var('NR_IMAGINI',count($count_images) );
						$tpl->set_var('MODIFICA_IMAGINI',"index.php?page=cabinete.modificaimg.".$v['id'].".".$v['user_id'].".".$v['nume_firma'] );
						//echo $v['level']."<br>";
						
						$user_pachet = $pachete->getTipPromovare($v['id']);
						//this is for the new promovare using pachete and servicii
						if(is_array($user_pachet))
						{
							$pkInfo = $pachete->getPachetInfo($user_pachet['pachet']);
							$promovare = "<a href='index.php?page=users.viewpromovare.".$v['id']."'>".$pkInfo['name']." - ".$user_pachet['pret']." RON</a>";
						}
						else
						{
							//echo $v['level']."<br>";
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
							$promovare.= "<p>[ <a href='index.php?page=users.addpromovare.".$v['id']."'>schimba promovare</a> ]</p>";
						}
						$tpl->set_var('LOCPROMOVARE',$promovare );
						//print_r($get_level_det);
					//	$get_tip_promovare = getTipPromovareName($v['tip_promovare']);
					//	$tpl->set_var('LOCPROMOVARE',$get_tip_promovare['nume'] );
						if($v['user_id']=="-1")
						{
							$tpl->set_var('USER',"admin" );
							$tpl->set_var('USER_ID',"-1");
						}
						else
						{
							$get_user_info = GetUser($v['user_id']);
							$tpl->set_var('USER',$get_user_info );
							$tpl->set_var('USER_ID',$v['user_id'] );
						}

						$tpl->set_var('SUBMISION_DATE',$v['submision_date']);
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
						if ($v['emailplata'] == 'Y')
						{
							$tpl->set_var('IMAGE2', 'active.png');
							$tpl->set_var('IMAGE_TITLE2', 'inactive');
						}
						else 
						{
							$tpl->set_var('IMAGE2', 'inactive.png');
							$tpl->set_var('IMAGE_TITLE2', 'active');
						}
						$tpl->set_var('COMMENT', $v['comment']);
						$tpl->set_var('MODIFY_DATE', $v['data_modificarii']);
						$tpl->set_var('PARENT_MODULE', GetCabinetParents($v['id']));
						$tpl->set_var('LINK_TO_CABINET', ReWrite('cabinete_detalii', 'cabinete.detalii.'.$v['id']));


						if($v['recomandata']=='N')
						{
							$tpl->set_var('RECOMANDED', "NO" );
							$tpl->set_var('CHANGE_RECOMANDED', 'change_yes' );
							$tpl->set_var('PRELUNGESTE_PROMOVARE', "" );

						}else
						{
							$tpl->set_var('RECOMANDED', " YES " );
							$tpl->set_var('PRELUNGESTE_PROMOVARE', "<a href=\"?page=plati.prelungestepromovare.".$v['id'].".".$v['user_id'].".".$v['judet'].".".$v['category_id']."\">Prelungeste promovare</a>" );
							$tpl->set_var('CHANGE_RECOMANDED','change_no'  );

						}

						$tpl->parse('list_cabinete_block', 'list_cabinete', true);
						$i++;
					}
					$tpl->parse('if_cabinete_block', 'if_cabinete', true);
				}
				else 
				{
					$tpl->parse('if_no_cabinete_block', 'if_no_cabinete', true);
				}
				$tpl->parse('MAIN', 'tpl_list');

			break;	

			case 'recomandate':
				$tpl->set_file('tpl_list', 'cabinete/recomandate.tpl');
				$tpl->set_var('MAIN_TITLE', 'Lista cabinete recomandate de pe dentistonline.ro');
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
				#check if the selected parent is a category or a module
				$path = explode("_", $param1);
				switch ($path['0'])
				{
					default :
						$all_cabinete = 0;
						$total_records = CountCabineteRecomandateTotalRecords('-1', '');
					break;

					case 'category':
						$cat_id = $path['1'];
						$total_records = CountCabineteRecomandateTotalRecords($path['0'], $path['1']);
					break;

					case 'module':
						$the_module_id = $path['1'];
						$total_records = CountCabineteRecomandateTotalRecords($path['0'], $path['1']);
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
				#cabinete count
				$tpl->set_var('COUNT_CABINETE', $total_records);
				$pages_number = ceil($total_records/$conf->admin_cabinete_per_page);
				$tpl->set_var("PAGES", $pages_number);
				#create de pagination page_name
				$page_name = $module.'.'.$action;
				if(isset($_GET['start'])&&($_GET['start']!=""))
				{
						$start = $_GET['start'];
						$start_q = $conf->admin_cabinete_per_page*($start-1);
				}
				 else
				{
					$start_q = 0;
					$start = 1;
				}
				#to set the display mode, make some rules of display about data modificarii, or others

				if(isset($_GET['displaymode'])&&($_GET['displaymode']!=""))
				{
						$dispmode = $_GET['displaymode'];
				}
				 else
				{
					$dispmode = "data-date_exp-ASC";
				}

				if ($param1 != '')
				{
					$page_name = $page_name.'.'.$param1;
				}
				
				/*if(!isset($start))
				{
					$start_q = 0;
					$start = 1;
				}
				else
				{
					$start_q = $conf->admin_cabinete_per_page*($start-1);
				}*/
				#Create and parse pagination
				$html_pages = AdminPaginationCabineteAnuntArticole($conf->admin_cabinete_per_page, $total_records, $page_name, $start,$dispmode);
				$tpl->set_var("PAGINATION", $html_pages);
				$tpl->set_var("PAGE_NAME",$page_name );
				#Set blocks
				$tpl->set_block('tpl_list', 'list_cabinete', 'list_cabinete_block');
				$tpl->set_block('tpl_list', 'if_cabinete', 'if_cabinete_block');
				$tpl->set_block('tpl_list', 'if_no_cabinete', 'if_no_cabinete_block');
				#Create query limit and get the cabinete for displaing
				$query_limit = " LIMIT $start_q, $conf->admin_cabinete_per_page";
				if (isset($all_cabinete))
				{
					$cabinete = ListAdminCabineteRecomandate('-1', '', $query_limit,$dispmode);
				}
				else 
				{
					$cabinete = ListAdminCabineteRecomandate($path['0'], $path['1'], $query_limit,$dispmode);
				}
				if (count($cabinete) != '0')
				{
					$i = 0;
					while (list($k, $v) = each($cabinete))
					{
						#set colors
						$bc = ($i % 2)+1;
						$tpl->set_var("BGCOLOR",'row'.$bc);
						
						if($v['submision_date']==date("d M Y"))
						{	$tpl->set_var("BGCOLOR", "today_add"); }
						$tpl->set_var('NR_VISITS',$v['nr_visits'] );
						$tpl->set_var('ID', $v['id']);
						$tpl->set_var('NUME_CABINET', $v['nume_firma']);
						$tpl->set_var('JUDET_ID',$v['judet'] );
						$tpl->set_var('TYPE_ID',$v['category_id'] );
							

						$main_photo = GetCabineteMainPhoto($v['id'],"cabinet");
						$tpl->set_var('IMAGINE', SITE_BASE.'/sources/thumbnails.php?target='.$main_photo['image_name'].'&max_size='.$conf->admin_gallery_max.'&folder='.$v['id']);
						$count_images = GetCabineteImages($v['id']);
						$tpl->set_var('NR_IMAGINI',count($count_images) );
						$tpl->set_var('MODIFICA_IMAGINI',"index.php?page=cabinete.modificaimg.".$v['id'].".".$v['user_id'].".".$v['nume_firma'] );

						if($v['user_id']=="-1")
						{
							$tpl->set_var('USER',"admin" );
							$tpl->set_var('USER_ID',"-1");
						}
						else
						{
							$get_user_info = GetUser($v['user_id']);
							$tpl->set_var('USER',$get_user_info );
							$tpl->set_var('USER_ID',$v['user_id'] );
						}
						#lets take some details about recomandate cabinete
						$infos = GetInfoRecomandate($v['user_id'],$v['id']);
						if(isset($infos[0]['perioada'])&&($infos[0]['perioada']!=""))
						{
							$tpl->set_var('PERIOADA_LUNI',$infos[0]['perioada'] );
							$tpl->set_var('ADAUGAT_RECOMANDAT',TimeFormatEvents($infos[0]['date_add']) );
							$tpl->set_var('EXPIRA_RECOMANDAT',TimeFormatEvents($infos[0]['date_exp']) );
							
								if(isset($infos[0]['factura_id'])&&($infos[0]['factura_id']!="")&&($infos[0]['factura_id']!="0"))
								{
									$tpl->set_var('FACTURA_PROFORMA', $infos[0]['factura_id']);
									$get_fiscala = GetFiscalaForProforma($infos[0]['factura_id']);
									$tpl->set_var('FACTURA_FISCALA', $get_fiscala['serie_factura']);
								}
								else
								{
									$tpl->set_var('FACTURA_PROFORMA', "none");
									$tpl->set_var('FACTURA_FISCALA', "none");
								}

							if(strtotime($infos[0]['date_exp'])< (strtotime(date("Y-m-d"))+360000))
							{	$tpl->set_var("CLASSEXPIRE", "style=\"color:red;font-weight:bold;\"");	}
							else
							{
								$tpl->set_var("CLASSEXPIRE", "");
							}


						}
						else
						{
							$tpl->set_var('PERIOADA_LUNI',"!!!" );
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
						$tpl->set_var('COMMENT', $v['comment']);
						$tpl->set_var('PARENT_MODULE', GetCabinetParents($v['id']));
						$tpl->set_var('LINK_TO_CABINET', ReWrite('cabinete_detalii', 'cabinete.detalii.'.$v['id']));


						if($v['recomandata']=='N')
						{
							$tpl->set_var('RECOMANDED', "NO" );
							$tpl->set_var('CHANGE_RECOMANDED', 'change_yes' );
							$tpl->set_var('PRELUNGESTE_PROMOVARE', "" );

						}else
						{
							$tpl->set_var('RECOMANDED', " YES " );
							$tpl->set_var('PRELUNGESTE_PROMOVARE', "<a href=\"?page=plati.prelungestepromovare.".$v['id'].".".$v['user_id'].".".$v['judet'].".".$v['category_id']."\">Prelungeste promovare</a>" );
							$tpl->set_var('CHANGE_RECOMANDED','change_no'  );

						}

						$tpl->parse('list_cabinete_block', 'list_cabinete', true);
						$i++;
					}
					$tpl->parse('if_cabinete_block', 'if_cabinete', true);
				}
				else 
				{
					$tpl->parse('if_no_cabinete_block', 'if_no_cabinete', true);
				}
				$tpl->parse('MAIN', 'tpl_list');
			break;

			case 'set':
				ChangeCabinetStatus($param1, $param2);
				GenerateSmallImages($param2);
				$_SESSION['admin_info'] = 'Status successfully changed !';
				$_SESSION['admin_info_type'] = 'info';
				header ('location: '.$_SERVER['HTTP_REFERER']);
				exit;
			break;

			case 'setemail':
				ChangeCabinetStatus2($param1, $param2);
				//GenerateSmallImages($param2);
				$_SESSION['admin_info'] = 'E-mail status successfully changed !';
				$_SESSION['admin_info_type'] = 'info';
				header ('location: '.$_SERVER['HTTP_REFERER']);
				exit;
			break;

			case 'edit':
				$tpl->set_file('tpl_edit', 'cabinete/edit_cabinet.tpl');
				#get the parent module or category
				$tpl->set_block('tpl_edit', 'cats', 'cats_block');
				$tpl->set_block('tpl_edit', 'modules', 'modules_block');
				$tpl->set_block('tpl_edit', 'display_cats', 'display_catss');
				$tpl->set_block('tpl_edit', 'judet', 'judett');
				$tpl->set_var('BGCOLOR1', 'row1');
				$tpl->set_var('BGCOLOR2', 'row2');
				$tpl->set_var('ID_USER',$param2 );
				$get_cabinet['category_parent'] = GetIdCatForCabinet($param1);
				$get_modules = GetCabineteModules();
				if (count($get_modules) != '0')
				{
					while (list($k, $v) = each($get_modules))
					{
						$tpl->set_var('SELECTED_MODULE', '');
						if (isset($get_cabinet['module_parent']) && $get_cabinet['module_parent'] == $v['id'])
						{
							$tpl->set_var('SELECTED_MODULE', 'selected');
						}
						$tpl->set_var('MODULE_ID', $v['id']);
						$tpl->set_var('MODULE_NAME', $v['name']);
						$get_cats = GetCabineteCategories($v['id'], 'Y', '');
						if (count($get_cats) != '0')
						{
							while (list($key, $val) = each($get_cats))
							{
								$tpl->set_var('SELECTED_CATEGORY', '');
								if (isset($get_cabinet['category_parent']) && $get_cabinet['category_parent'] == $val['id_cat'])
								{
									$tpl->set_var('SELECTED_CATEGORY', 'selected');
								}
								$tpl->set_var('CATEGORY_ID', $val['id_cat']);
								$tpl->set_var('CATEGORY_NAME', $val['cat_name']);
								$tpl->parse('cats_block', 'cats', true);
							}
						}
						$tpl->parse('modules_block', 'modules', true);
						$tpl->parse('cats_block', '');
					}
				}
				$id_firma = $param1;$user_id = $param2;
				$tpl->set_var('ID_CABINET',$param1 );
				$get_firm_info = GetFirme($user_id,$id_firma);
				//print_r($get_firm_info);
				$get_firm_info_real = $get_firm_info[0];
				$tpl->set_var('MAIN_TITLE', 'Edit "'.$get_firm_info[0]['nume_firma'].'" cabinet');
				$get_contract_id = GetContractForCabinet($id_firma);
				$get_proforma_id = GetproformaForCabinet($id_firma);
				$tpl->set_var('PROFORMA_ID', $get_proforma_id);
				$tpl->set_var('VIZITE_CABINET', $get_firm_info[0]['nr_visits']);
				
				$tpl->set_var('CONTRACT_ID',$get_contract_id );
				foreach($get_firm_info_real as $ky => $val)
				{
					if($ky=="category_id")
					{
							$get_dentist_categ = Get_Dentist_Cats('-1');
							foreach($get_dentist_categ as $kky => $vall)
							{
								if($val==$vall['id'])
								{		$tpl->set_var('CATEGORY_ID',"selected" );	$cat_id=$val;}
								else
								{		$tpl->set_var('CATEGORY_ID',"" );	}

								$tpl->set_var('CAT_NAME',$vall['name'] );
								$tpl->set_var('CAT_ID',$vall['id'] );
								$tpl->parse('display_catss', 'display_cats', true);
							}
					}
					elseif($ky=="judet")
					{		
							$cod_judet = $val;
							$get_dentist_judete = GetJudete();
							foreach($get_dentist_judete as $kky => $vval)
							{
								if($val==$vval['code'])
								{	$tpl->set_var('JUDET',"selected" ); $judet_name = $vval['name'];	}
								else
								{	$tpl->set_var('JUDET',"" );	}

								$tpl->set_var('COD_JUDET',$vval['code'] );
								
								$tpl->set_var('NUMEJUDET',$vval['name'] );
								$tpl->parse('judett', 'judet', true);
							}
					
					}
					elseif($ky=="type")
					{
						if(($val!="none")&&($val!==""))
						{
							//var_dump($val);exit;
							$tpl->set_var('FACTURA_TYPE',$val );
							$tpl->set_file("tpl_formplace","../modules/user/".$val.".tpl");
							$tpl->set_var('EDITABLE',"readonly" );
							$tpl->parse('LOC_FORM_PLACE','tpl_formplace');
						}
						else
						{
							$tpl->set_var('PERIOADA', "1" );
							$tpl->set_var('FACTURA_TYPE',"Firma neplatitoare. Nu exista factura!" );
						}
					}
					elseif($ky=="nume_loc_sector")
					{
						$tpl->set_file("tpl_search_ajax","../modules/search/localitati_ajax_faratoate.tpl");
							$tpl->set_block('tpl_search_ajax', 'loocalitati', 'loocalitatii');

							$get_dentist_localitati = GetLocalitati($cod_judet);
							foreach($get_dentist_localitati as $kyy => $vaal)
							{
								if($val == $vaal['id'])
								{	$tpl->set_var('SELECTED_LOC',"selected" );	}
								else
								{	$tpl->set_var('SELECTED_LOC',"" );	}

								$tpl->set_var('ID_LOCALITATE',$vaal['id'] );
								$tpl->set_var('NUMELOCALITATE',$vaal['name'] );
								$tpl->parse('loocalitatii', 'loocalitati', true);
							}
							$tpl->parse('LOC_DIV_ADAUGAFIRMA','tpl_search_ajax');
					}
					elseif($ky=="status")
					{
						if($val=='0')
						{
							$tpl->set_var('EMAILACTIVARE', " Emailul de activare a cabinetului nu a fost trimis!!");
						}
						else
						{
						$tpl->set_var('EMAILACTIVARE', " ");
						}
					}
					
					else
					{ 
						$tpl->set_var(strtoupper($ky),$val );
						if($ky=="pers_contact")
						{
							$pers_contact = $val;
						}
						
					}
				}
				### servicii file stuff
				$servicii_file = getCabinetServiciiFile($id_firma);
				if (is_array($servicii_file) )
				{
					$file_type = explode(".",$servicii_file['name']);
					$file_ext = $file_type[count($file_type)-1];
					$tpl->set_var('SERVICII_FILE', "<A HREF='?page=cabinete.downloadservicii.".$id_firma."'><b>".$servicii_file['name']."</b>&nbsp;&nbsp;&nbsp;&nbsp; <img src='../images/".$file_ext.".jpg'></A><br><i>Fisierul a fost adaugat in: </i>".TimeFormatShort($servicii_file['date'])); 
				}
				else 
				{
					$tpl->set_var('SERVICII_FILE',"Nu aveti nici un fisier adaugat !" ); 
				}
				
				##############################################Activation email type############################
				#make some stuffs for activation email type
				if(isset($param3)&&($param3!="")&&($param3!="none"))
				{
					$linkfirma = ReWrite("cabinete_detalii","cabinete.detalii.".$param1);
					$text = GetFileContent("../templates/emails/cabinete/cabinete_status.tpl");
					if($param3=="cab_activat_txt")
					{
						$text = GetFileContent("../templates/emails/cabinete/cabinete_status_txt.tpl");
					}
					if($param3=="cab_inactiv")
					{
						$text = str_replace("%SALUT%",	"Buna ziua" , $text);
					}
					else
					{
						$text = str_replace("%SALUT%",	"Buna ziua" , $text);
						$text = str_replace("%NUMEPERSOANA%",	$pers_contact , $text);
						
						switch($cat_id)
						{
							case '1':
								$firmatype ="cabinetele";
								$text = str_replace("%PARSE_FEM%",	"", $text);
								$cautari = "cabinete stomatologice ".$judet_name.", clinici stomatologice ".$judet_name.", etc.";
							break;

							case '2':
								$firmatype = "laboratoarele";
								$text = str_replace("%PARSE_FEM%",	"", $text);
								$cautari = "laboratoare tehnica dentara ".$judet_name.", tehnica dentara ".$judet_name.", etc.";
							break;

							case '3':
								$firmatype = "laboratorele";
								$text = str_replace("%PARSE_FEM%",	"", $text);
								$cautari = "laboratoare radiologie dentara ".$judet_name.", radiologie dentara ".$judet_name.", etc.";
							break;

							case '4':
								$firmatype = "depozitele de materiale stomatologice ";
								$text = str_replace("%PARSE_FEM%",	"", $text);
								$cautari = "distribuitori materiale stomatologice ".$judet_name.", depozite stomatologice ".$judet_name.", etc.";
							break;

							case '5':
								$firmatype ="clinicile stomatologice";
								#we set the acord to feminiine for clinique
								$text = str_replace("%PARSE_FEM%",	"a", $text);
								$cautari = "clinici stomatologice ".$judet_name.", cabinete stomatologice ".$judet_name.", etc.";
							break;

						}
						$text = str_replace("%FIRMA_TYPE%",$firmatype, $text);
						$text = str_replace("%TYPE_CAUTARI%",$cautari, $text);
						
						$tpl->set_var('JUDET_NAME',$judet_name); 
						$text = str_replace("%JUDET_NAME%",	$judet_name , $text);
						$text = str_replace("%NUME_FIRMA%",	$get_firm_info[0]['nume_firma'], $text);
						
						switch($param3)
						{
							#means all it's ok, we have images and full description
							case 'cab_activat':
								$text = str_replace("%MESSAGE_TYPE%",	"", $text);	
							break;

							case 'cab_activat_txt':
								$text = str_replace("%MESSAGE_TYPE%",	"", $text);	
							break;

							#means that we have just a few description and we can't creat logo image
							case 'fara_img_fara_scris':
								$text = str_replace("%MESSAGE_TYPE%",	"	Pentru a avea un numar mai mare de vizitatori ce vor accesa %FIRMA_TYPE2%  va sugeram sa oferiti informatii mai cuprinzatoare in ceea ce priveste descrierea, tarifele si servicile oferite . Deasemenea  o imagine face cat 1000 de cuvinte. <br />", $text);	
							break;
							#means that we create the logo image for him
							case 'imagine_logo':
							$text = str_replace("%MESSAGE_TYPE%",	"	Dorim o promovare eficienta,la nivel inalt de aceea am creat special pentru dvs. o imagine logo gratuit.<br />
							Prin prezenta acestui logo aveti posibilitatea de a aparea aleator pe prima pagina a website-ului. Vizitatorii vor accesa mai usor si mai cu drag prezentarea dvs, de accea asteptam si alte imagini prin care sa perfectionam oferta dvs.", $text);	
							break;
						}
						$text = str_replace("%FIRMA_LINK%",	$linkfirma , $text);
						$text = str_replace("%FIRMA_TYPE2%",	strtolower($firmatype), $text);
							
						
					}

					$tpl->set_var('EMAIL_CONTENT2', $text);
					$tpl->set_var('selected_'.$param3,"selected" );
				}
				else
				{
					$tpl->set_var('EMAIL_CONTENT1', "No email type");
					$tpl->set_var('EMAIL_CONTENT2', "");
					$tpl->set_var('VISABILITI_OPTION', "none");
				}
				#######################################
				#this is for erros block
				if (isset($_SESSION['submit_errors']))
				{
					$tpl->set_var("ERROR_MSG", $_SESSION['submit_errors']);
					unset($_SESSION['submit_errors']);
					$tpl->parse("error_block", "error", true);
				}
				#fill fields
				if (isset($_SESSION['submit_firma']))
				{
					foreach ($_SESSION['submit_firma'] as $key => $val)
					{
							$values = explode("=>",$val);
							if($values[0]=="category_id")
							{	$tpl->set_var(strtoupper($values[0]), "selected");	}
							elseif($values[0]=="judet")
							{		$tpl->set_var(strtoupper($values[0]), "selected");	}
							else
							{		$tpl->set_var(strtoupper($values[0]), $values[1]);}
					}
					unset($_SESSION['submit_firma']);
				}
			$tpl->set_var('UPDATE_FIRMA',ReWrite("user","user.updatefirma.".$id_firma));
			$tpl->parse("MAIN", "tpl_edit");
			break;

			case 'downloadservicii':
				$servicii_file = getCabinetServiciiFile($param1);
				$filename = '../servicii_file/'.$servicii_file['name'];
				$file_type = explode(".",$servicii_file['name']);
				$file_ext = $file_type[count($file_type)-1];

				## download the file !!!
				if ($file_ext=='pdf' )
				{
					// We'll be outputting a PDF
					header('Content-type: application/pdf');
					header('Content-Disposition: attachment; filename="'.$servicii_file['name'].'"');
				}
				elseif ($file_ext=='doc' )
				{
					// We'll be outputting a MSOffice file
					header('Content-type: application/msword');
					header('Content-Disposition: attachment; filename="'.$servicii_file['name'].'"');
				}

				// The file source
				readfile($filename);
				exit;
			break;

			case 'save_edit':
				$id_firma = $param1;
				/* cu plata $array_obligatorii = array("category_id"=>"Categoria","nume_firma"=>"nume firma","adresa_firma"=>"Adresa firma","inreg_fiscala_cnp"=>"Cod inregistrare fiscala/ CNP","reg_comert_bi"=>"Registru Comertului/BI serie numar","judet"=>"judet","nume_loc_sector"=>"Localitate/sector ","orar"=>"Orar","pers_contact"=>"Persoana de contact","persc_email"=>"Adresa de email","persc_tel"=>"Telefon persoana contact","persc_adresa"=>"Adresa persona contact","meta_keywords"=>"Meta keywords","meta_description"=>"Meta Description");*/
				
				$array_obligatorii = array("category_id"=>"Categoria","nume_firma"=>"Nume firma","adresa_firma"=>"Adresa firma","judet"=>"judet","nume_loc_sector"=>"Localitate/sector ","orar"=>"Orar","pers_contact"=>"Persoana de contact","persc_email"=>"Adresa de email","descriere"=>"Descrierea ");
				$display_errors = '';
				foreach($_POST as $ky => $val)
				{
					if((array_key_exists($ky,$array_obligatorii))&&($val==""))
					{	$display_errors .= '<li>'. $array_obligatorii[$ky]." nu este setat".'</li>';}

				}
				
				if (array_key_exists('nume_loc_sector', $_POST)===FALSE) 
				{		$display_errors .= '<li>'.$array_obligatorii['nume_loc_sector']." nu este setat".'<li>'; }
				
					if(isset($_POST['email_firma'])&&($_POST['email_firma']!=""))
				{
					$email = ValidEmail($_POST['email_firma']);
					if(!$email)
						{	$display_errors .="<li>Adresa de email este invalida</li>";	}

				}

				if($display_errors!="")
				{		
						#let_put in sessions all infos from post in case we have errors
						$_SESSION['submit_errors'] = $display_errors;
						$_SESSION['submit_firma']=array();
						foreach($_POST as $ky => $val)
						{
							$info = $ky ."=>".$val;	array_push($_SESSION['submit_firma'],$info);
						}
						header('location: '.GetReferer());
						exit;
				}
				else
				{
					#this means that we can't change sub category for cabinet
					array_shift($_POST);
					#if sub category  has been changed
				
					foreach($_POST as $ky => $val)
					{	if(strpos($ky,"caractere")!==FALSE)
							{
								unset($_POST[$ky]);
							}
							else
							{ 
								$query="Update cabinete set ".$ky."='".mysql_real_escape_string(strip_tags($val,'<p><font><b><br><strong><i><u><font>'))."' WHERE id='".$id_firma."'";
								$db->query($query);
								if($ky=="judet")
								{		UpdateCabinetToCat($id_firma,$_POST['category_id'],$val);		}
							}
					}
					$update_alias_name =$_POST['alias'];
					$query="Update cabinete set alias='".addslashes($update_alias_name)."' WHERE id='".$id_firma."'";
					$db->query($query);
					GenerateSmallImages($id_firma);

					### save servicii si tarife file !!!
					if($_FILES['servicii']['type']!="")
					{
						saveServiciiFileCabinet($id_firma);
					}
					$_SESSION['admin_info_type'] = 'info';
					$_SESSION['admin_info'] = "Modificarea a fost realizata cu succes!";
					header('location: '.'?page=cabinete.list');exit;
				}
			
					/*#check the parent
					$parent = explode("_", $_POST['cabinet_category']);
					$parent_mod = $parent['0'];
					$parent_id = $parent['1'];
					switch ($parent_mod)
					{
						#the cabinet has been inserted for a certain module
						case 'module':
							$tempArray = array("id" => intval($param1), "module_parent" => $parent_id);
						break;
						#the cabinet has been inserted for a certain category under a module
						case 'category':
							$tempArray = array("id" => intval($param1), "category_parent" => $parent_id);
						break;
					}
					$_POST = array_merge($_POST, $tempArray);
					$_SESSION['edit_cabinet_content'] = $_POST;
					header ('location: '.$_SERVER['HTTP_REFERER']);
					exit;
				}*/
			break;
			
			case 'sendemail':
					//print_r($_POST);exit;
					//echo $param1." ".$param2." ".$param3." ".$param4;exit;
					$Sender = $conf->contact_recipient;
					$text = $_POST['email_content'];
					$CustomHeaders = '';
					$recipant = array();
					
					if(trim($_POST['pers_email']) != trim($_POST['email_firma']))
					{
						$recipant[0]= trim($_POST['pers_email']);
						$recipant[1]= trim($_POST['email_firma']);
					}
					else
					{
						$recipant[0]= trim($_POST['pers_email']);
					}
					
				
				for($i = 0; $i < count($recipant) ; $i++)
				{
						if(($_POST['emailform']!="cab_inactiv")&&($_POST['emailform']!="none"))
						{
							$Subject = "Oferta dvs. a fost activata pe DentistOnline.ro";	
							$_SESSION['submit_errors'] = "<li>Emailul de activare a fost trimis cu succes!</li>";
							#lets activate the cabinet
							$query="Update cabinete set status='1' Where id='".$param1."'";
							$db->query($query);
						}
						else
						{
							$Subject = ucfirst($_POST['nume_fir'])." este inactiv pe DentistOnline.ro";
							$_SESSION['submit_errors'] = "<li>Emailul de dezactivare a fost trimis cu succes!</li>";
							
							#deactivate the cab
							$query="Update cabinete set status='0' Where id='".$param1."'";
							$db->query($query);
						}
						$message = new Email($recipant[$i], $Sender, $Subject, $CustomHeaders);
						if($_POST['emailform']=='cab_activat_txt')
						{
							
							$message->SetTextContent($text);
						}
						else
						{
							$message->SetHtmlContent($text);
						}

						
						if (ValidHeader($Sender))
						{
							$message->Send();
						}
				}
					header('location: ?page=cabinete.edit.'.$param1.".".$param2);
					exit;
			
			break;

			case 'emailtrimis':
				$Sender = $conf->contact_recipient;
				$Recipiant = $_POST['email_recipiant'] ;
				$CustomHeaders = '';
				$Subject = $_POST['subject'];
				$text = $_POST['mesaj'];
				$message = new Email($Recipiant, $Sender, $Subject, $CustomHeaders);
				$message->SetHtmlContent($text);
				if (ValidHeader($Sender))
				{
					$message->Send();
				}
				$_SESSION['email_trimis'] = "Yes";
				header('location: ?page=cabinete.sendemail.general');exit;
			break;

			case 'cauta':
				$tpl->set_file('tpl_cauta', 'cabinete/cauta.tpl');
				#page main title
				$tpl->set_var('MAIN_TITLE', 'Cautare cabinete');
				#set blocks
				$tpl->set_block('tpl_cauta', 'list_cabinete', 'list_cabinete2');
				$tpl->set_block('tpl_cauta', 'if_cabinete', 'if_cabinete2');

				$tpl->set_block('tpl_cauta', 'if_no_cabinete', 'if_no_cabinete2');



				if($param1!="" )
				{
					$tpl->set_var(strtoupper($param1),"selected" );
					$tpl->set_var('CE_CAUTAM',strtoupper($param1) );
					$tpl->set_var("VALOARE_CAUTARE",$param2);

					#count all messages
					$total_records = CountCabineteCauta($param1,$param2);
					$tpl->set_var('COUNT_CABINETE', $total_records);
					$pages_number = ceil($total_records/$conf->users_per_page);
					$tpl->set_var('PAGES', $pages_number);
					#create de pagination page_name
					$page_name = $module.'.'.$action.'.'.$param1.'.'.$param2;
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
					$cabinete = GetCabineteCauta($param1,$param2, $query_limit);
				if (count($cabinete) != '0')
				{
					$i = 0;
					while (list($k, $v) = each($cabinete))
					{
						#set colors
						$bc = ($i % 2)+1;
						$tpl->set_var("BGCOLOR",'row'.$bc);
						
						if($v['submision_date']==date("d M Y"))
						{	$tpl->set_var("BGCOLOR", "today_add"); }
						$tpl->set_var('NR_VISITS',$v['nr_visits'] );
						$tpl->set_var('ID', $v['id']);
						$tpl->set_var('NUME_CABINET', $v['nume_firma']);
						$tpl->set_var('TELEFON', $v['telefon']);
						$tpl->set_var('EMAIL', $v['email']);
						$tpl->set_var('AGENT',getAgentName($v['admin_id']));
						$tpl->set_var('JUDET_ID',$v['judet'] );
						$tpl->set_var('TYPE_ID',$v['category_id'] );
						$main_photo = GetCabineteMainPhoto($v['id'],"cabinet");
						$tpl->set_var('IMAGINE', SITE_BASE.'/sources/thumbnails.php?target='.$main_photo['image_name'].'&max_size='.$conf->admin_gallery_max.'&folder='.$v['id']);
						$video = getCabinetVideoFile($v['id']);
						if (is_array($video) )
						{
							$tpl->set_var('NR_VIDEO', 1); 
						}
						else 
						{
						$tpl->set_var('NR_VIDEO', 0); 
						}
						$tpl->set_var('MODIFICA_VIDEO', "index.php?page=cabinete.modificavideo.".$v['id'].".".$v['user_id']);
							
						$get_banner = GetBanner($v['id']);
						if($get_banner!="")
						{						$tpl->set_var('NR_BANNER', 1); 				}
						else
						{					$tpl->set_var('NR_BANNER', 0); 			}
						
						
						$count_images = GetCabineteImages($v['id']);
						$tpl->set_var('NR_IMAGINI',count($count_images) );
						$tpl->set_var('MODIFICA_IMAGINI',"index.php?page=cabinete.modificaimg.".$v['id'].".".$v['user_id'].".".$v['nume_firma'] );
						//echo $v['level']."<br>";
						if(stristr($v['level'],',')!=FALSE)
						{
							$promovare="";
							$a = explode(',',$v['level']);
							foreach($a as $ky => $val)
							{
								$get_level_det = getPromovareLevelDetails($val);
								$promovare = $promovare.$get_level_det['name']."<br>";
							}
							$tpl->set_var('LOCPROMOVARE',$promovare );
						}
						else
						{
							$get_level_det = getPromovareLevelDetails($v['level']);
							$tpl->set_var('LOCPROMOVARE',$get_level_det['name'] );
						}
						//print_r($get_level_det);
						//	$get_tip_promovare = getTipPromovareName($v['tip_promovare']);
						//	$tpl->set_var('LOCPROMOVARE',$get_tip_promovare['nume'] );
						if($v['user_id']=="-1")
						{
							$tpl->set_var('USER',"admin" );
							$tpl->set_var('USER_ID',"-1");
						}
						else
						{
							$get_user_info = GetUser($v['user_id']);
							$tpl->set_var('USER',$get_user_info );
							$tpl->set_var('USER_ID',$v['user_id'] );
						}

						$tpl->set_var('SUBMISION_DATE',$v['submision_date']);
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
						if ($v['emailplata'] == 'Y')
						{
							$tpl->set_var('IMAGE2', 'active.png');
							$tpl->set_var('IMAGE_TITLE2', 'inactive');
						}
						else 
						{
							$tpl->set_var('IMAGE2', 'inactive.png');
							$tpl->set_var('IMAGE_TITLE2', 'active');
						}
						$tpl->set_var('COMMENT', $v['comment']);
						$tpl->set_var('MODIFY_DATE', $v['data_modificarii']);
						$tpl->set_var('PARENT_MODULE', GetCabinetParents($v['id']));
						$tpl->set_var('LINK_TO_CABINET', ReWrite('cabinete_detalii', 'cabinete.detalii.'.$v['id']));


						if($v['recomandata']=='N')
						{
							$tpl->set_var('RECOMANDED', "NO" );
							$tpl->set_var('CHANGE_RECOMANDED', 'change_yes' );
							$tpl->set_var('PRELUNGESTE_PROMOVARE', "" );

						}
						else
						{
							$tpl->set_var('RECOMANDED', " YES " );
							$tpl->set_var('PRELUNGESTE_PROMOVARE', "<a href=\"?page=plati.prelungestepromovare.".$v['id'].".".$v['user_id'].".".$v['judet'].".".$v['category_id']."\">Prelungeste promovare</a>" );
							$tpl->set_var('CHANGE_RECOMANDED','change_no'  );
						}

						$tpl->parse('list_cabinete2', 'list_cabinete', true);
						$i++;
					}
					$tpl->parse('if_cabinete2', 'if_cabinete', true);
				}
				else 
				{
					$tpl->parse('if_no_cabinete2', 'if_no_cabinete', true);
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
				$tpl->parse('MAIN', 'tpl_cauta');
			break;

			#galerie imagini de aici
			case 'modificaimg':
				$tpl->set_file('tpl_main', 'cabinete/modifica_images.tpl');
				$tpl->set_block('tpl_main', 'upload_block', 'upload_block2');
				$tpl->set_block('tpl_main', 'if_upload', 'if_upload2');
				$tpl->set_block('tpl_main', 'if_no_upload', 'if_no_upload2');
				$tpl->set_var('USER_ADD_IMAGES', "index.php?page=cabinete.addimage.".$param1.".cabinet");
				$tpl->set_var('USER_ADD_IMAGE_HARTA', "index.php?page=cabinete.addimage.".$param1.".harta");
				$tpl->set_var('USER_ADD_IMAGE_BANNER', "index.php?page=cabinete.addimage.".$param1.".banner");


				$tpl->set_var('USER_ID', $param2);
				$tpl->set_var('CABINET_ID',$param1);
				
				$tpl->set_block('tpl_main', 'list_images', 'list_images2');
				$tpl->set_block('tpl_main', 'if_images', 'if_images_block');
				
				#imagine harta stuffs
				$tpl->set_block('tpl_main', 'if_images_harta', 'if_images_harta_block');
				$tpl->set_block('tpl_main', 'if_no_images_harta', 'if_no_images_harta2');
				$tpl->set_block('tpl_main', 'upload_harta', 'upload_harta_block');
				
				#banner stufs
				$tpl->set_block('tpl_main', 'if_images_banner', 'if_images_banner_block');
				$tpl->set_block('tpl_main', 'if_no_images_banner', 'if_no_images_banner2');

				$tpl->parse('if_no_upload2', '');
				$tpl->parse('if_upload2', '');
				$get_cabinet_name = Getfirme($param2,$param1);
			//	print_r($get_cabinet_name );
				$tpl->set_var('NUME_FIRMA', $get_cabinet_name[0]['nume_firma'].", ". $get_cabinet_name[0]['judet']);
				$images = GetCabineteImages($param1);
				$harta="N";$plusharta=0;
				if(count($images)>0)
				{
					$i=0;$kk=1;
					foreach($images as $ky => $val)
					{
						if($val['type']=="cabinet")
						{
							$ss=round($kk%2)+1;
							$tpl->set_var('BGCOLOR',"row".$ss );
							$tpl->set_var('ORDER',$val['position'] );
							$tpl->set_var('THUMBNAIL',"../sources/thumbnails.php?target=".$val['image_name'].'&max_size='.$conf->admin_gallery_max.'&folder='.$param1);
							$tpl->set_var('RE_ORDER_UP','index.php?page=cabinete.rearenge.'.$param1.'.'.$val['id'].'.up');
							$tpl->set_var('RE_ORDER_DOWN','index.php?page=cabinete.rearenge.'.$param1.'.'.$val['id'].'.down') ;
							$tpl->set_var('IMAGE_NAME',$val['image_name']) ;
							$tpl->set_var('IMAGE_ID',$val['id']) ;	
							$tpl->set_var('DELETE_IMAGE','index.php?page=cabinete.imagesdelete.'.$val['id']);
							$tpl->parse('list_images2', 'list_images', true);
							$kk++;
						}
						else
						{
					
							$harta="Y";	$plusharta=1;					$tpl->set_var('THUMBNAIL_HARTA',"../sources/thumbnails.php?target=".$val['image_name'].'&max_size='.$conf->admin_gallery_max.'&folder='.$param1);
							$tpl->set_var('DELETE_IMAGE','index.php?page=cabinete.imagesdelete.'.$val['id']);
							$tpl->parse('if_images_harta_block', 'if_images_harta', true);
						}
						
					}
					$tpl->parse('if_images_block', 'if_images', true);
				}
				if($harta!="Y")
				{
					$tpl->parse('if_no_images_harta2', 'if_no_images_harta', true);
					$tpl->parse('upload_harta_block', 'upload_harta', true);
				}
				$tpl->set_var('SIZE_MAX_IMG',$conf->max_img_cabinete );
				$left_images = 40 - count($images)+$plusharta;
				$tpl->set_var('NR_MAX_IMG',$left_images );
				if($left_images!='0')
				{
					for($i = 1; $i <=$left_images ; $i++)
					{
						$tpl->set_var('IMG_NR',$i );
						$tpl->parse('upload_block2', 'upload_block', true);
					}
					$tpl->parse('if_upload2', 'if_upload', true);
				}
				else
				{
					$tpl->set_var('NO_UPLOAD',"Nu mai puteti sa adaugati alte imagini. Aveti adaugate deja <b>4</b> imagini !" );
					$tpl->parse('if_no_upload2', 'if_no_upload', true);
					$tpl->parse('if_upload', '');
				}

				$get_banner = GetBanner($param1,'Y');
				if($get_banner!="")
				{
					$tpl->set_var('THUMBNAIL_BANNER',"../images/banner/".$get_banner['name']);
					$tpl->set_var('AFISARI_CURENTE',$get_banner['afisari_curente']);
					$tpl->set_var('TOTAL_AFISARI',$get_banner['total_afisari']);
					$tpl->set_var('ID_BANNER',$get_banner['id']);
						
					$tpl->set_var('DELETE_BANNER',"?page=cabinete.deletebanner.".$param1 );
					$tpl->parse('if_images_banner_block', 'if_images_banner', true);
				}
				else
				{
					
					$tpl->set_var('USER_ADD_IMAGE_BANNER',"?page=cabinete.addbanner.".$param1 );
					$tpl->parse('if_no_images_banner2', 'if_no_images_banner', true);
				}

				if (isset($_SESSION['admin_info'])&&($_SESSION['admin_info']!=""))
				{
					$tpl->set_file('tpl_info', 'info/'.$_SESSION['admin_info_type'].'.tpl');
					$tpl->set_var('MESSAGE', $_SESSION['admin_info']);
					$tpl->parse('ERROR', 'tpl_info');
					#uset sessions
					unset($_SESSION['admin_info']);
					unset($_SESSION['admin_info_type']);
				}
				$tpl->parse('MAIN', 'tpl_main');
			
			break;
			
			case 'addimage':
				$display_errors = "";
				if($param2=="cabinet")
				{
							$result = CheckPictureItemCabinet();
							if ($result == '0')
							{
								$display_errors .=  '<li>'.'Imaginea nu are una din extensiile acceptate!'.'</li>';
							}
							elseif ($result == '1')
							{
								$display_errors .= '<li>'. 'Pentru imagini va rugam respectati dimensiunile maxime admise!'.'</li>';
							}
				}
				elseif($param2=="harta")
				{
							$result = CheckPictureItemHarta();
							if ($result == '0')
							{
								$display_errors .=  '<li>'. 'Imaginea pentru harta nu are una din extensiile acceptate!'.'</li>';
							}
							elseif ($result == '1')
							{
							$display_errors .=  '<li>'.'Imagine harta - Va rugam respectati dimensiunile maxime admise!'.'</li>';
							}
				}
				else
				{
							$result = CheckPicture();
							if ($result == '0')
							{
								$display_errors .=  '<li>'. 'Imaginea pentru banner nu are una din extensiile acceptate!'.'</li>';
							}
							elseif ($result == '1')
							{
							$display_errors .=  '<li>'.'Imagine banner - Va rugam respectati dimensiunile maxime admise!'.'</li>';
							}
				
				}

				if($display_errors!="")
				{
					$_SESSION['message'] = $display_errors;
					header ('location: '.GetReferer());
					exit;
				}
				if($param2=="cabinet")
				{
					SavePicturesCabinete($param1,"backend" );

				}
				else
				{
					if ($_FILES['picture_harta']['type'] != "" )
					{
						$extension = explode('/',$_FILES['picture_harta']['type']);
						$file_extension = $extension[1];
						SavePicturesMap($file_extension, $param1,"backend" );
						unset($_FILES['picture_harta']);
					}
				}
				GenerateSmallImages($param1);
				$_SESSION['admin_info_type'] = 'info';
				$_SESSION['admin_info'] = "Imagine adaugata cu succes !";
				header ('location: '.$_SERVER['HTTP_REFERER']);
				exit;
			break;

			case 'imagesdelete':
				if(isset($param1))
				{
					$image = GetCabinetImage($param1);
					$path_dir = "../images/users_cabinete/".$image['folder_id']."/".$image['image_name'];
					chmod($path_dir,0777);
					@unlink($path_dir);

					$sql = "DELETE FROM images WHERE id='".$param1."'";
					$db->query($sql);
					ReorderImagesPositions($image['folder_id']);
					$_SESSION['admin_info_type'] = 'info';
					$_SESSION['admin_info'] = "Imaginea a fost stearsa cu succes !";
					header ('location: '.$_SERVER['HTTP_REFERER']);
					exit;
				}
			break;

			case 'rename_image':
				
				#modificam numele imagini doar daca e diferit de ce e in baza de date
				if ($_POST['old_image_name']!= $_POST['new_image_name'])
				{
					$id_cabinet = $param2;
					$id_imagine = $param1;
					Update_Image_Name_Cabinete($id_cabinet,$id_imagine,addslashes($_POST['new_image_name']),addslashes($_POST['old_image_name']));	
				}
				$_SESSION['admin_info_type'] = 'info';
				$_SESSION['admin_info'] = "Numele imaginii a fost modificat cu succes!";
				header ('location: '.$_SERVER['HTTP_REFERER']);
				exit;
			break;
			
			case 'adauga_bonus':
			{
				$id_banner = $param1;
				$sql = "Update banner set total_afisari=total_afisari+".$_POST['bonus']." Where id='".$id_banner."'";
				$db->query($sql);
				$_SESSION['admin_info_type'] = 'info';
				$_SESSION['admin_info'] = "Bonusul a fost adaugat cu succes !";
				header ('location: '.$_SERVER['HTTP_REFERER']);
				exit;

			}
			case 'deletebanner':
				if(isset($param1))
				{
					$image = GetBanner($param1);
					$path_dir = "../images/banner/".$image['image_name'];
				//	echo $path_dir;
					chmod($path_dir,0777);
					@unlink($path_dir);

					$sql = "DELETE FROM banner WHERE cabinet_id='".$param1."'";
					$db->query($sql);
					$_SESSION['admin_info_type'] = 'info';
					$_SESSION['admin_info'] = "Imaginea a fost stearsa cu succes !";
					header ('location: '.$_SERVER['HTTP_REFERER']);
					exit;
				}
			break;

			case 'addbanner':
				## check banner file
				//print_r($_FILES['banner']);exit;
				$display_errors = "";
				if($_FILES['banner']['type']!="")
				{
					$result = CheckPicture($_FILES['banner']);
					if ($result == '0')
					{
						$display_errors.= '<li>Extensia imaginii pentru banner nu este acceptata !</li>';
					}
					elseif ($result == '1')
					{
						$display_errors.= '<li>Dimensiunea imaginii pentru banner este prea mare !</li>';
					}
				}
				else
				{
					$display_errors.= '<li>Nu ati selectat nici o imagine !</li>';
				}

				if($display_errors!="")
				{
					#let_put in sessions all infos from post in case we have errors
					$_SESSION['admin_info'] = $display_errors;
					$_SESSION['admin_info_type'] = 'info';
					$_SESSION['submit_firma']=array();
					foreach($_POST as $ky => $val)
					{
						$info = $ky ."=>".$val;	array_push($_SESSION['submit_firma'],$info);
					}
					header('location: '.GetReferer());
					exit;
				}

				### save the banner image
				saveBannerCabinet($param1);
				$_SESSION['submit_errors']='Y';
				$_SESSION['admin_info_type'] = 'info';
				$_SESSION['admin_info'] = "Bannerul a fost adaugat cu succes.";
				header('location: '.GetReferer());
				exit;
			break;
			case 'rearenge':
				$_SESSION['admin_info_type'] = 'info';
				$_SESSION['admin_info'] = "Pozitia imaginii in galerie a fost modificata cu succes !";
				$count_images = GetCabineteImages($param1);
				$nr_imagini_cabinet = count($count_images) ;
				foreach ($count_images as $key => $val)
				{
					if($val['type']=='harta')
					{
						$nr_imagini_cabinet = $nr_imagini_cabinet-1;
					}
				}
				//$new_dates = ReorderImagesNew($param3, $param1,$nr_imagini_cabinet);
				//RearrangeImagesNew($param2,$param3,$new_dates,$param1);

				$new_dates = ReorderImagesNew($param2, $param3,$nr_imagini_cabinet);
				RearrangeImagesNew($param1,$param2,$new_dates,$param3);
				header ('location: '.$_SERVER['HTTP_REFERER']);
			break;

			#we just change the status - recomanded, or not, we dont't make any changes in cabinete table
			#we must make some changes in recomandate table, to add the cabinet there
			case 'schimba':
				$status_curent_cabinet = $param1;
				$id_cabinet = $param2;
				
				$user_id = $param3;
				$judet_id = $param4;
				$type_id = $param5; 

				$perioada="14";
				$factura_id="";
				$loc="mijloc";
				$tip_promovare="site";
				$comment="";

				if($status_curent_cabinet=="NO")
				{
					$query= "Update cabinete set recomandata='Y' where id='".$id_cabinet."'";
					$newstatus = "Cabinet recomandat";
					$db->query($query);
					#we must insert information into recomandate database
					InsertToRecomandate($user_id,$id_cabinet,$comment,$judet_id,$type_id,$perioada,$factura_id,$loc,$tip_promovare);
				}
				else
				{
					$query= "Update cabinete set recomandata='N' where id='".$id_cabinet."'";
					$newstatus = "Cabinet nu mai este recomandat";
					$db->query($query);
					#we must delete information from recomandate database
					$query= "Delete from recomandate where user_id='".$user_id."' and firma_id='".$id_cabinet ."'";
					$db->query($query);
					

				}
				
				

				
				$_SESSION['admin_info_type'] = 'info';
				$_SESSION['admin_info'] = "Statusul cabinetului a fost schimbat in : <b> ".$newstatus ."</b>!";
				header ('location: '.$_SERVER['HTTP_REFERER']);exit;

			break;

			case 'generatemail':
				$tpl->set_file('tpl_main', $module.'/email_plata.tpl');
				$tpl->set_var('MAIN_TITLE', 'Genereaza e-mail plata');
				$cab_details = getCabinetDetails($param1);
				//print_r($cab_details );
				$tpl->set_var('START_DATE',TimeFormatEvents($cab_details['submision_date']) );
				$cat = getCabinetCategory($cab_details['category_id']);
				//$tpl->set_var('VISITS',number_format($cab_details['nr_visits'],0,',','.') );
				switch($cat)
				{
					case 'Cabinete stomatologice':
						$tpl->set_var('CABINET','Cabinetul Stomatologic '.$cab_details['nume_firma']);
					break;

					case 'Tehnica dentara':
						$tpl->set_var('CABINET','Laboratorul de Tehnica Dentara '.$cab_details['nume_firma']);
					break;

					case 'Radiologie Dentara':
						$tpl->set_var('CABINET','Laboratorul de Radiologie Dentara '.$cab_details['nume_firma']);
					break;

					case 'Distribuitori materiale':
						$tpl->set_var('CABINET','Depozitul de Materiale Stomatologice '.$cab_details['nume_firma']);
					break;

					case 'Clinici Stomatologice':
						$tpl->set_var('CABINET','Clinica Stomatologica '.$cab_details['nume_firma']);
					break;
				}

				$tpl->set_var('CATEGORY', $cat);
				//$tpl->set_var('LINK_CAB',ReWrite('cabinete_detalii', 'cabinete.detalii.'.$param1) );

				//$tpl->set_var('NR_MSGS',countCabinetMessages($param1) );

				$tpl->set_var('SITE',$cab_details['adresa_web']);
				$tpl->set_var('ADRESE_EMAIL',$cab_details['email_firma'].",".$cab_details['persc_email']);

				$tpl->parse('MAIN', 'tpl_main');
			break;

			case 'sendemailplata':
				$tpl->set_file('tpl_main', $module.'/send_email_plata.tpl');
				$cab_details = getCabinetDetails($param1);
				//print_r($cab_details );
				$tpl->set_var('START_DATE',TimeFormatEvents($cab_details['submision_date']) );
				//$cat = getCabinetCategory($cab_details['category_id']);
				//$tpl->set_var('ADRESE_EMAIL',$cab_details['email_firma'].",".$cab_details['persc_email']);
				$cat = getCabinetCategory($cab_details['category_id']);
				
				//$tpl->set_var('VISITS',number_format($cab_details['nr_visits'],0,',','.') );


				switch($cat)
				{
					case 'Cabinete stomatologice':
						$tpl->set_var('CABINET','Cabinetul Stomatologic '.$cab_details['nume_firma']);
					break;

					case 'Tehnica dentara':
						$tpl->set_var('CABINET','Laboratorul de Tehnica Dentara '.$cab_details['nume_firma']);
					break;

					case 'Radiologie Dentara':
						$tpl->set_var('CABINET','Laboratorul de Radiologie Dentara '.$cab_details['nume_firma']);
					break;

					case 'Distribuitori materiale':
						$tpl->set_var('CABINET','Depozitul de Materiale Stomatologice '.$cab_details['nume_firma']);
					break;

					case 'Clinici Stomatologice':
						$tpl->set_var('CABINET','Clinica Stomatologica '.$cab_details['nume_firma']);
					break;
				}

				//$tpl->set_var('CATEGORY', $cat);

				$tpl->parse('MAIN', 'tpl_main');
				$msg = $tpl->get_var('MAIN');
				//echo $msg;exit;

				$Sender = "DentistOnline<".$conf->contact_recipient.">";
				if($cab_details['persc_email']!=$cab_details['email_firma'] && $cab_details['persc_email']!="")
				{
					$Recipiant = $cab_details['email_firma'].",".$cab_details['persc_email'];
				}
				else
				{
					if($cab_details['email_firma']!="")
					{
						$Recipiant = $cab_details['email_firma'];
					}
					elseif($cab_details['email_firma']=="")
					{
						$Recipiant = $cab_details['persc_email'];
					}
					
				}
				## for testing;
				//$Recipiant = 'flavius_r2002@yahoo.com,rflavius@gmail.com';
				$CustomHeaders = '';
				$Subject = "Buna ziua";

				$message = new Email($Recipiant, $Sender, $Subject, $CustomHeaders);
				$message->SetHtmlContent($msg);
				if (ValidHeader($Sender))
				{
					$message->Send();
					//echo 'sent';exit;
					## redirect to the page where we activate the send mail status !!
					header("Location: index.php?page=cabinete.setemail.active.".$param1);
					exit;
				}
			break;
			case 'print':
				
				$tpl = new Template(ADMIN_TEMPLATES_DIR);
				$tpl->set_file("tpl_index", 'cabinete/list2_print_anda.tpl');
				$tpl->set_var('MAIN_TITLE', 'List cabinete , laboratoare, clinici din Romania');
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
				#check if the selected parent is a category or a module
				$path = explode("_", $param1);
				switch ($path['0'])
				{
					default :
						$all_cabinete = 0;
						$total_records = CountCabineteTotalRecords('-1', '');
					break;

					case 'category':
						$cat_id = $path['1'];
						$total_records = CountCabineteTotalRecords($path['0'], $path['1']);
					break;

					case 'module':
						$the_module_id = $path['1'];
						$total_records = CountCabineteTotalRecords($path['0'], $path['1']);
					break;
				}
				#get the modules and categories
				$tpl->set_block('tpl_index', 'categories', 'categories_block');
				$tpl->set_block('tpl_index', 'modules', 'modules_block');
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
				#cabinete count
				$conf->admin_cabinete_per_page = 34;
				$tpl->set_var('COUNT_CABINETE', $total_records);
				$pages_number = ceil($total_records/$conf->admin_cabinete_per_page);
				$tpl->set_var("PAGES", $pages_number);
				#create de pagination page_name
				$page_name = $module.'.'.$action;
				if(isset($_GET['start'])&&($_GET['start']!=""))
				{
						$start = $_GET['start'];
						$start_q = $conf->admin_cabinete_per_page*($start-1);
				}
				 else
				{
					$start_q = 0;
					$start = 1;
				}
				#to set the display mode, make some rules of display about data modificarii, or others

				if(isset($_GET['displaymode'])&&($_GET['displaymode']!=""))
				{
						$dispmode = $_GET['displaymode'];
				}
				 else
				{
					$dispmode = "data-submision_date-DESC";
				}

				if ($param1 != '')
				{
					$page_name = $page_name.'.'.$param1;
				}
				
				/*if(!isset($start))
				{
					$start_q = 0;
					$start = 1;
				}
				else
				{
					$start_q = $conf->admin_cabinete_per_page*($start-1);
				}*/
				#Create and parse pagination
				$html_pages = AdminPaginationCabineteAnuntArticole($conf->admin_cabinete_per_page, $total_records, $page_name, $start,$dispmode);
				$tpl->set_var("PAGINATION", $html_pages);
				$tpl->set_var("PAGE_NAME",$page_name );
				#Set blocks
				$tpl->set_block('tpl_index', 'list_cabinete', 'list_cabinete_block');
				$tpl->set_block('tpl_index', 'if_cabinete', 'if_cabinete_block');
				$tpl->set_block('tpl_index', 'if_no_cabinete', 'if_no_cabinete_block');
				#Create query limit and get the cabinete for displaing
				$query_limit = " LIMIT $start_q, $conf->admin_cabinete_per_page";
				if (isset($all_cabinete))
				{
					$cabinete = ListAdminCabinete2('-1', '', $query_limit,$dispmode);
				}
				else 
				{
					$cabinete = ListAdminCabinete2($path['0'], $path['1'], $query_limit,$dispmode);
				}
			//	print_r($cabinete);
				if (count($cabinete) != '0')
				{
					$i = 0;
					while (list($k, $v) = each($cabinete))
					{
						#set colors
						if($v['status'] == '1')
						{
									$bc = ($i % 2)+1;
									$tpl->set_var("BGCOLOR",'row'.$bc);
									
									if($v['contactat']=='Y')
									{
										$tpl->set_var("BGCOLOR",'row3');
									}
								if($v['submision_date']==date("d M Y"))
								{	$tpl->set_var("BGCOLOR", "today_add"); }
								$tpl->set_var('NR_VISITS',$v['nr_visits'] );
								$tpl->set_var('ID', $v['id']);
								$tpl->set_var('NUME_CABINET', $v['nume_firma']);
								$tpl->set_var('TELEFON', $v['telefon']);
								$tpl->set_var('EMAIL', $v['email']);
								$tpl->set_var('ADDRESS', $v['adresa_firma']);
								$tpl->set_var('PERSOANA_CONTACT', $v['pers_contact']);
								$tpl->set_var('JUDET_ID',$v['judet'] );
								$tpl->set_var('TYPE_ID',$v['category_id'] );
								$main_photo = GetCabineteMainPhoto($v['id'],"cabinet");
								$tpl->set_var('IMAGINE', SITE_BASE.'/sources/thumbnails.php?target='.$main_photo['image_name'].'&max_size='.$conf->admin_gallery_max.'&folder='.$v['id']);
								$video = getCabinetVideoFile($v['id']);
								if (is_array($video) )
								{
									$tpl->set_var('NR_VIDEO', 1); 
								}
								else 
								{
								$tpl->set_var('NR_VIDEO', 0); 
								}
								$tpl->set_var('MODIFICA_VIDEO', "index.php?page=cabinete.modificavideo.".$v['id'].".".$v['user_id']);
									
								$get_banner = GetBanner($v['id']);
								if($get_banner!="")
								{						$tpl->set_var('NR_BANNER', 1); 				}
								else
								{					$tpl->set_var('NR_BANNER', 0); 			}
								
								
								$count_images = GetCabineteImages($v['id']);
								$tpl->set_var('NR_IMAGINI',count($count_images) );
								$tpl->set_var('MODIFICA_IMAGINI',"index.php?page=cabinete.modificaimg.".$v['id'].".".$v['user_id'].".".$v['nume_firma'] );
								//echo $v['level']."<br>";
								if(stristr($v['level'],',')!=FALSE)
								{
									$promovare="";
									$a = explode(',',$v['level']);
									foreach($a as $ky => $val)
									{
										$get_level_det = getPromovareLevelDetails($val);
										$promovare = $promovare.$get_level_det['name']."<br>";
									}
									$tpl->set_var('LOCPROMOVARE',$promovare );
								}
								else
								{
									$get_level_det = getPromovareLevelDetails($v['level']);
									$tpl->set_var('LOCPROMOVARE',$get_level_det['name'] );
								}
								//print_r($get_level_det);
								//	$get_tip_promovare = getTipPromovareName($v['tip_promovare']);
								//	$tpl->set_var('LOCPROMOVARE',$get_tip_promovare['nume'] );
								if($v['user_id']=="-1")
								{
									$tpl->set_var('USER',"admin" );
									$tpl->set_var('USER_ID',"-1");
								}
								else
								{
									$get_user_info = GetUser($v['user_id']);
									$tpl->set_var('USER',$get_user_info );
									$tpl->set_var('USER_ID',$v['user_id'] );
								}

								$tpl->set_var('SUBMISION_DATE',$v['submision_date']);
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
								if ($v['emailplata'] == 'Y')
								{
									$tpl->set_var('IMAGE2', 'active.png');
									$tpl->set_var('IMAGE_TITLE2', 'inactive');
								}
								else 
								{
									$tpl->set_var('IMAGE2', 'inactive.png');
									$tpl->set_var('IMAGE_TITLE2', 'active');
								}
								$tpl->set_var('COMMENT', $v['comment']);
								$tpl->set_var('MODIFY_DATE', $v['data_modificarii']);
								$tpl->set_var('PARENT_MODULE', GetCabinetParents($v['id']));
								$tpl->set_var('LINK_TO_CABINET', ReWrite('cabinete_detalii', 'cabinete.detalii.'.$v['id']));


								if($v['recomandata']=='N')
								{
									$tpl->set_var('RECOMANDED', "NO" );
									$tpl->set_var('CHANGE_RECOMANDED', 'change_yes' );
									$tpl->set_var('PRELUNGESTE_PROMOVARE', "" );

								}
								else
								{
									$tpl->set_var('RECOMANDED', " YES " );
									$tpl->set_var('PRELUNGESTE_PROMOVARE', "<a href=\"?page=plati.prelungestepromovare.".$v['id'].".".$v['user_id'].".".$v['judet'].".".$v['category_id']."\">Prelungeste promovare</a>" );
									$tpl->set_var('CHANGE_RECOMANDED','change_no'  );
								}

								$tpl->parse('list_cabinete_block', 'list_cabinete', true);
								$i++;
						}
				
					}
					$tpl->parse('if_cabinete_block', 'if_cabinete', true);
				}
				else 
				{
					$tpl->parse('if_no_cabinete_block', 'if_no_cabinete', true);
				}
				$tpl->parse("OUTPUT", "tpl_index");
			break;	
			
			case 'modificavideo':
				$tpl->set_file("tpl_editfirme", "cabinete/edit_video.tpl");
				$tpl->set_block('tpl_editfirme', 'list_video','list_video2');

				#this is for erros block
				#if we have information messages
				if (isset($_SESSION['admin_info'])&&($_SESSION['admin_info']!=""))
				{
					$tpl->set_file('tpl_info', '../admin/info/'.$_SESSION['admin_info_type'].'.tpl');
					$tpl->set_var('MESSAGE', $_SESSION['admin_info']);
					$tpl->parse('ERROR', 'tpl_info');
					#uset sessions
					unset($_SESSION['admin_info']);
					unset($_SESSION['admin_info_type']);
				}

				$tpl->set_var('CAB_ID', $param1); 
				$video = getCabinetVideoFile($param1);
				if (is_array($video) )
				{
					$tpl->set_var('DATE_ADD',TimeFormatShort($video['date']) );
					$tpl->set_var('DIV_ID',"mp4_player");
					$tpl->set_var('VIDEO_PATH',"../video/".$video['id'].'.'.$video['type']);
					$tpl->parse('list_video2', 'list_video', true); 
					if($video['youtube_url']!="")
					{
						$tpl->set_var('VIDEO_PATH',$video['youtube_url']);
						$tpl->set_var('DIV_ID',"youtube_player");
						$tpl->set_var('DATE_ADD',TimeFormatShort($video['date']) );
						$tpl->parse('list_video2', 'list_video', true); 
					}
				}
				else 
				{
					$tpl->parse('list_video2', ''); 
				}
				$tpl->parse("MAIN", "tpl_editfirme");
			break;
			
			case 'domodifyvideo':
				//print_r($_FILES['video']);exit;
			$display_errors="";
				if($_FILES['video']['type']!="")
				{
					$result = CheckVideoItem();
					if ($result == '0')
					{
						$display_errors.= '<li>Va rugam sa adaugati un fisier valid pentru video !</li>';
					}
					elseif ($result == '1')
					{
						$display_errors.= '<li>Dimensiunea fisierului este prea mare pentru video !</li>';
					}
				}

				//echo $display_errors;exit;
				$youtube = "";
				if(isset($_POST['youtube_url'])&&($_POST['youtube_url']!=""))
				{
					$youtube = addslashes($_POST['youtube_url']);
				}
				#if no file uploaded and no youtube link dispaly error mesage
				if(($youtube=="")&&($_FILES['video']['type']==""))
				{
					$display_errors.= '<li>Va rugam adugati un link Youtube sau selectati un fisier video!</li>';
				}
				//print_r($display_errors);exit;
				if($display_errors!="")
				{
					#let_put in sessions all infos from post in case we have errors
					$_SESSION['admin_info'] = $display_errors;
					$_SESSION['admin_info_type'] = 'error';
					header('location: '.GetReferer());
					exit;
				}

				### save the video file !!!
				saveVideoCabinet($param1,$youtube);

				$_SESSION['admin_info'] = "Fisierul video a fost adaugat cu succes.";
				$_SESSION['admin_info_type'] = "info";
				header('location: '.GetReferer());
			exit;
	break;



		}
	break;

	case '2':
		switch ($action)
		{
			default :
				$tpl->set_file('tpl_edit', 'cabinete/edit.tpl');
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
				#set colors
				$tpl->set_var('BGCOLOR1', 'row1');
				$tpl->set_var('BGCOLOR2', 'row2');
				#get info
				$get_module = GetModules(intval($action));
				$the_module = $get_module['0'];
				if (isset($_SESSION['edit_modules_content']))
				{
					$the_module = $_SESSION['edit_modules_content'];
					unset($_SESSION['edit_modules_content']);
				}
				$tpl->set_var('ID', $the_module['id']);
				#the param for the edit categories
				$tpl->set_var('PARENT_ID', $the_module['id']);
				$tpl->set_var('NAME', $the_module['name']);
				$tpl->set_var('KEYWORDS', $the_module['meta_keywords']);
				$tpl->set_var('DESCRIPTION', $the_module['meta_description']);
				$tpl->set_var('CONTENT', $the_module['content']);
				#page main title
				$tpl->set_var('MAIN_TITLE', 'Edit '.$the_module['name'].' module');
				$link = str_replace(".", "_", $the_module['link']);
				$tpl->set_var('LINK', $link.FILE_EXTENSION);
				#status
				if ($the_module['active'] == '1')
				{
					$tpl->set_var('STATUS_ACTIVE', 'selected');
				}
				else 
				{
					$tpl->set_var('STATUS_INACTIVE', 'selected');
				}
				#the block for the cabinet categories for this module and the error block
				$tpl->set_block('tpl_edit', 'list_categories', 'list_categories_block');
				$tpl->set_block('tpl_edit', 'if_categories', 'if_categories_block');
				$get_module_categories = GetCabineteCategories($action, '-1', '');
				if (count($get_module_categories) != '0')
				{
					$i = 0;
					while (list($k, $v) = each($get_module_categories))
					{
						#set colors
						$bc = ($i % 2)+1;
						$tpl->set_var("BGCOLOR", 'row'.$bc);
						$tpl->set_var('CAT_ID', $v['id_cat']);
						$tpl->set_var('CAT_NAME', $v['cat_name']);
						if ($v['active'] == 'Y')
						{
							$tpl->set_var('IMAGE', 'active.png');
							$tpl->set_var('IMAGE_TITLE', 'inactive');
						}
						else 
						{
							$tpl->set_var('IMAGE', 'inactive.png');
							$tpl->set_var('IMAGE_TITLE', 'active');
						}
						$tpl->parse('list_categories_block', 'list_categories', true);
						$i++;
					}
					$tpl->parse('if_categories_block', 'if_categories', true);
				}
				#the category information message
				$tpl->set_file('tpl_catinfo', 'info/info.tpl');
				$tpl->set_var('MESSAGE', 'Add, edit and delete cabinet module categories.');
				$tpl->parse('CATEGORY_INFORMATION', 'tpl_catinfo');
				$tpl->parse('MAIN', 'tpl_edit');
			break;

			case 'categories':
				switch ($param1)
				{
					case 'add':
						if (trim($_POST['cat_name']) == "")
						{
							$_SESSION['admin_info'] = "Please provide a name for the category !";
							$_SESSION['admin_info_type'] = 'error';
							header ('location: ?page=cabinete.'.$param2);
							exit;
						}
						if (CategoryExists($_POST['cat_name'], $param2))
						{
							$_SESSION['admin_info'] = "Category already exists for this module !";
							$_SESSION['admin_info_type'] = 'error';
							header ('location: ?page=cabinete.'.$param2);
							exit;
						}
						#no errors - add the category and return with success message
						InsertCategory($_POST['cat_name'], $param2);
						$_SESSION['admin_info'] = "Category added successfully !";
						$_SESSION['admin_info_type'] = 'info';
						header ('location: ?page=cabinete.'.$param2);
						exit;
					break;

					case 'delete':
						$query = "DELETE FROM cabinete_categories WHERE id_cat = '".intval($param2)."'";
						$db->query($query);
						$_SESSION['admin_info'] = "Category successfully deleted !";
						$_SESSION['admin_info_type'] = 'info';
						header ('location: '.$_SERVER['HTTP_REFERER']);
						exit;
					break;

					case 'set':
						ChangeCategoryStatus($param2, $param3);
						$_SESSION['admin_info'] = "Category status successfully changed !";
						$_SESSION['admin_info_type'] = 'info';
						header ('location: '.$_SERVER['HTTP_REFERER']);
						exit;
					break;

					case 'edit':
						$tpl->set_file('tpl_categories', 'cabinete/edit_cat.tpl');
						$tpl->set_var('MAIN_TITLE', 'Edit Category');
						#for the form
						$tpl->set_var('ID', $param2);
						$tpl->set_var('PARENT_ID', $param3);
						#set colors
						$tpl->set_var('BGCOLOR1', 'row1');
						$tpl->set_var('BGCOLOR2', 'row2');
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
						$tpl->set_var('CAT_NAME', GetCategoryName($param2));
						$get_info_cat = GetInfoCat($param2);
					
						$tpl->set_var('META_DESCRIPTION', $get_info_cat['meta_description']);
						$tpl->set_var('META_KEYWORDS',$get_info_cat['meta_keywords'] );
						$tpl->parse('MAIN', 'tpl_categories');
					break;

					case 'save':
						if (trim($_POST['cat_name']) == "")
						{
							$_SESSION['admin_info'] = "Please provide a name for the category !";
							$_SESSION['admin_info_type'] = 'error';
							header ('location: '.$_SERVER['HTTP_REFERER']);
							exit;
						}
						#no errors - add the category and return with success message
						SaveCategory($_POST['cat_name'],$_POST['meta_keywords'],$_POST['meta_description'], $param2);
						$_SESSION['admin_info'] = "Modificarile au fost realizate cu succes !";
						$_SESSION['admin_info_type'] = 'info';
						header ('location: ?page=cabinete.'.$param3);
						exit;
					break;
				}
			break;

			case 'save':
				#title and link
				$errors = array();
				if (trim($_POST['name']) == '')
				{
					$errors['0'] = 'Please provide a name for the module';
				}
				if (count($errors) != '0')
				{
					$display_errors = "";
					foreach ($errors as $key => $val)
					{
						$display_errors .= $val."<br />";
					}
					$_SESSION['admin_info'] = $display_errors;
					$_SESSION['admin_info_type'] = 'error';
					#get the link, page_picture if there are saved
					$get_module = GetModules(intval($param1));
					$info = $get_module['0'];
					$link = $info['link'];
					#put info that doesn't come from the post into array
					$tempArray = array("id" => intval($param1), "link" => $link);
					$_POST = array_merge($_POST, $tempArray);
					$_SESSION['edit_modules_content'] = $_POST;
					header ('location: '.$_SERVER['HTTP_REFERER']);
					exit;
				}
				else 
				{
					SaveModuleChanges(addslashes($_POST['name']), $_POST['active'], addslashes($_POST['meta_keywords']), addslashes($_POST['meta_description']), addslashes($_POST['content']), intval($param1));
				}
				$_SESSION['admin_info'] = 'Update succesfully made !';
				$_SESSION['admin_info_type'] = 'info';
				header ('location: '.$_SERVER['HTTP_REFERER']);
				exit;
			break;

			case 'add':
				$tpl->set_file('tpl_add', 'cabinete/add_cabinet.tpl');
				$tpl->set_var('BGCOLOR1', 'row1');$tpl->set_var('BGCOLOR2', 'row2');
				$tpl->set_var('META_KEYWORDS', $conf->def_meta_keywords);
				$tpl->set_var('META_DESCRIPTION', $conf->def_meta_description);
				#page main title
				$tpl->set_var('MAIN_TITLE', 'Add new cabinet');
				#set blocks
				$tpl->set_block('tpl_add', 'display_cats', 'display_catss');
				$tpl->set_block('tpl_add', 'judet', 'judett');
				$tpl->set_block("tpl_add", "error", "error_block");
				$tpl->set_var('LOC_DIV_ADAUGAFIRMA',"Alegeti judetul intai!" );
				$tpl->set_var('MAX_PICTURE_WIDTH',$conf->max_img_anunt);
				
				$get_dentist_categ = Get_Dentist_Cats('-1');
				foreach($get_dentist_categ as $ky => $val)
				{
					if(isset($_SESSION['submit_firma'][0])&&($_SESSION['submit_firma'][0]!=""))
					{
						$values = explode("=>",$_SESSION['submit_firma'][0]);
						if($values[1]==$val['id'] )
						{		$tpl->set_var('SELECTTEDCAT',"selected");	}
						else
						{		$tpl->set_var('SELECTTEDCAT',"");		}
					}
					$tpl->set_var('CAT_NAME',$val['name'] );
					$tpl->set_var('CAT_ID',$val['id'] );
					$tpl->parse('display_catss', 'display_cats', true);
				}
				
				$get_dentist_judete = GetJudete();
				foreach($get_dentist_judete as $ky => $val)
				{
					if(isset($_SESSION['submit_firma'][4])&&($_SESSION['submit_firma'][4]!=""))
					{
						$values = explode("=>",$_SESSION['submit_firma'][4]);
						$judt_code = $values[1];
						if(strtolower($values[1])==strtolower($val['code']) )
						{		$tpl->set_var('SELECTTEDJUDET',"selected");	}
						else
						{		$tpl->set_var('SELECTTEDJUDET',"");		}
					}
					
					$tpl->set_var('COD_JUDET',$val['code'] );
					$tpl->set_var('NUMEJUDET',$val['name'] );
					$tpl->parse('judett', 'judet', true);
				}

				if(isset($_SESSION['submit_firma'][5])&&($_SESSION['submit_firma'][5])!="")
				{
						$tpl->set_file("tpl_loc_ajax","../modules/search/localitati_ajax_faratoate.tpl");
						$tpl->set_block('tpl_loc_ajax', 'loocalitati', 'loocalitatii');
						$cod_judet = $judt_code;
						$get_dentist_localitati = GetLocalitati($cod_judet);
						$values = explode("=>",$_SESSION['submit_firma'][5]);
						foreach($get_dentist_localitati as $ky => $val)
						{
							if($val['id']==$values[1])
							{			$tpl->set_var('SELECTED_LOC',"selected" );		}
							else
							{			$tpl->set_var('SELECTED_LOC',"" );	}
						
							$tpl->set_var('ID_LOCALITATE',$val['id'] );
							$tpl->set_var('NUMELOCALITATE',$val['name'] );
							$tpl->parse('loocalitatii', 'loocalitati', true);
						}
					$tpl->parse('LOC_DIV_ADAUGAFIRMA','tpl_loc_ajax');
				}
				else
				{
					$tpl->set_var('LOC_DIV_ADAUGAFIRMA','Alegeti localitatea');
				}
				
				if (isset($_SESSION['submit_errors']))
					{
						$tpl->set_var("ERROR_MSG", $_SESSION['submit_errors']);
						unset($_SESSION['submit_errors']);
						$tpl->parse("error_block", "error", true);
					}
					#fill fields
					if (isset($_SESSION['submit_firma']))
					{
						foreach ($_SESSION['submit_firma'] as $key => $val)
						{
								$values = explode("=>",$val);
								if($values[0]=="judet")
								{	$tpl->set_var(strtoupper($values[0]), "selected"); }
								elseif($values[0]=="perioada")
								{
									$tpl->set_var('SELECTED_'.$values[1],"selected" );
								}
								elseif($values[0]=="type")
								{
										if(($values[1]!="none")&&($values[1]!=""))
										{
											$tpl->set_var('SELECTED_'.strtoupper($values[1]),"selected" );
											$tpl->set_file("tpl_formplace","../modules/user/".$values[1].".tpl");
											$tpl->parse('LOC_FORM_PLACE','tpl_formplace');
										}
								}
								else
								{	$tpl->set_var(strtoupper($values[0]), $values[1]); }
						}
						unset($_SESSION['submit_firma']);
					}
				$tpl->parse("MAIN", "tpl_add");
			break;

			case 'insert':
					#if errors exist create arrays and return to previous pages
					$array_obligatorii = array("category_id"=>"Categoria nu e setata","nume_firma"=>"Numele firmei nu e setat ","adresa_firma"=>"Adresa firmei nu e setata","judet"=>"Judetul nu e setat","nume_loc_sector"=>"Localitate/sector nu e setat","orar"=>"Nu aveti orar","pers_contact"=>"Persoana de contact nu e setata","persc_email"=>"Adresa de email persoana contact nu e setata","descriere"=>"Descrierea nu e setata","perioada"=>"Perioada contractului nu e setata" ,"type"=>"Nu ati ales modul de plata(firma,persoana fizica,none)");
						
						$display_errors = '';
						foreach($_POST as $ky => $val)
						{
							if((array_key_exists($ky,$array_obligatorii))&&($val==""))
							{
									$display_errors .= '<li>'. $array_obligatorii[$ky].".</li>";
							}
						}
						

					if (array_key_exists('nume_loc_sector', $_POST)===FALSE) 
						{
						 $display_errors .= "<li>".$array_obligatorii['nume_loc_sector'].".</li>";
						}
						#check nume firma
						$check_nume_firma = CheckNumeFirma($_POST['nume_firma']);
						if(isset($check_nume_firma)&&($check_nume_firma!=""))
						{
							$display_errors .= $check_nume_firma;
						}
						
						if(isset($_POST['persc_email'])&&($_POST['persc_email']!=""))
						{
						$email = ValidEmail($_POST['persc_email']);
						if(!$email)
						{	$display_errors .="<li>Adresa de email a persoanei de contact este invalida.</li>";	}
						}
						
						if(isset($_POST['adresa_web'])&&($_POST['adresa_web']!=""))
						{
							$url = ValidateURL($_POST['adresa_web']);
							if(!$url)
							{	$display_errors .="<li>Adresa web este incorecta.</li>";	}

						}

						if(isset($_POST['email_firma'])&&($_POST['email_firma']!=""))
						{
							$url = ValidEmail($_POST['email_firma']);
							if(!$url)
								{	$display_errors .="<li>Adresa de email a firmei este invalida.</li>";	}

						}
						
						#lets add two images(imaginea de cabinet - imaginea cu harta (unde e situat cabinetul))
						#this is the image for cabinet
							if ($_FILES['picture_item1']['type']!= "")
							{
								$result =  CheckPictureItemCabinet();
								if ($result == '0')
								{
									$display_errors .=  '<li>'.'Imaginea pentru cabinet nu are una din extensiile acceptate!'.'</li>';
								}
								elseif ($result == '1')
								{
									$display_errors .= '<li>'. 'Imagine cabinet - Va rugam respectati dimensiunile maxime admise!'.'</li>';
								}
							}
							
							#this is for map...harta cabinet
							if ($_FILES['picture_item2']['type']!= "")
							{
								$result = CheckPictureItemHarta();
								if ($result == '0')
								{
									$display_errors .=  '<li>'. 'Imaginea pentru harta nu are una din extensiile acceptate!'.'</li>';
								}
								elseif ($result == '1')
								{
								$display_errors .=  '<li>'.'Imagine harta-Va rugam respectati dimensiunile maxime admise!'.'</li>';
								}
							}
								#lets check emitere factura
						if(isset($_POST['type'])&&($_POST['type']!=""))
						{
							if($_POST['type']=='persoana_fizica')
							{
								if(!isset($_POST['inreg_fiscala_cnp'])||($_POST['inreg_fiscala_cnp']==""))
								{
									$display_errors .=  '<li>'. 'Ati uitat sa complectati CNP.'.'</li>';
								}
								if(!isset($_POST['reg_comert_bi'])||$_POST['reg_comert_bi']=="")
								{
									$display_errors .=  '<li>'. 'Nu ati complectat seria si numarul de buletin.'.'</li>';
								}
								if(!isset($_POST['persc_tel'])||$_POST['persc_tel']=="")
								{
									$display_errors .=  '<li>'. 'Numarul de telefon al persoanei de contact nu e setat.'.'</li>';
								}
								if(!isset($_POST['persc_adresa'])||$_POST['persc_adresa']=="")
								{
									$display_errors .=  '<li>'. 'Adresa persoanei de contact nu este setata.'.'</li>';
								}
								if(!isset($_POST['zip_code'])||$_POST['zip_code']=="")
								{
									$display_errors .=  '<li>'. 'Codul postal nu e setat.'.'</li>';
								}
							}
							elseif($_POST['type']=='firma')
							{
									if(!isset($_POST['inreg_fiscala_cnp'])||$_POST['inreg_fiscala_cnp']=="")
									{
										$display_errors .=  '<li>'. 'Inregisrarea fiscala nu este setata.'.'</li>';
									}
									if(!isset($_POST['reg_comert_bi'])||$_POST['reg_comert_bi']=="")
									{
										$display_errors .=  '<li>'. 'Registru comertului nu este setat.'.'</li>';
									}
										if(!isset($_POST['zip_code'])||$_POST['zip_code']=="")
									{
										$display_errors .=  '<li>'. 'Codul postal pentru adresa firma nu e setat.'.'</li>';
									}
							}

						}
						if($display_errors!="")
						{		
								#let_put in sessions all infos from post in case we have errors
								$_SESSION['submit_errors'] = $display_errors;
								$_SESSION['submit_firma']=array();
								foreach($_POST as $ky => $val)
								{
									$info = $ky ."=>".$val;	array_push($_SESSION['submit_firma'],$info);
								}
								header('location: '.GetReferer());
								exit;
						}
							$user_id = "-1";
							
							#insert infos about cabinet ,we take the id of cabinet
							$type = $_POST['type'];
							$perioada = $_POST['perioada'];
							$id_some_info = InsertPartFromFirma($_POST['nume_firma'],$user_id,$type,$perioada);
							foreach($_POST as $ky => $val)
							{
									if(strpos($ky,"caractere")!==FALSE)
									{
										unset($_POST[$ky]);
									}
									else
									{
										$query="Update cabinete set ".$ky."='".addslashes($val)."' WHERE id='".$id_some_info."'";
										$db->query($query);
									}
									
							}
							#let's insert cabinet to his category
							$inser_cab_to_cat = InsertCabinetToCat($id_some_info,$_POST['category_id'],$_POST['judet']);
							#daca avem setata poza pt cabinet o salvam
							if ($_FILES['picture_item1']['type'] != "" )
							{
								$extension = explode('/',$_FILES['picture_item1']['type']);
								$file_extension = $extension[1];//echo "extenis:".$file_extension;
								SavePicturesCabinete($file_extension, $id_some_info,"backend" );
							}
							elseif ($_FILES['picture_item1']['type'] == "" )
							{
								$file_extension="default";
								SavePicturesCabinete($file_extension, $id_some_info,"backend" );
							}
							
							#daca avem poza pt harta o salvam:D
							if ($_FILES['picture_item2']['type'] != "" )
							{
								$extension = explode('/',$_FILES['picture_item2']['type']);
								$file_extension = $extension[1];//echo "extenis:".$file_extension;
								SavePicturesMap($file_extension, $id_some_info,"backend" );
							}
							elseif ($_FILES['picture_item2']['type'] == "" )
							{
								$file_extension="default";
								SavePicturesMap($file_extension, $id_some_info,"backend" );
							}
							GenerateSmallImages($id_some_info);

							#daca adaugam o firma la care emitem factura,sa inseram in db palti si sa trimitem email
							if($type!="none")
							{
									#	inseram date factura proforma
									$pret_perioada = "pret_perioada_".$_POST['perioada'];
									$emis_fact = 'Y';
									$plata_id = InsertPlata($user_id,$id_some_info,$_POST['nume_firma'],$_POST['perioada'],$_POST['type'],$emis_fact,$conf->$pret_perioada );
									
									
									#lets send an email with factura proforma
									$nr_fact_proforma = $plata_id;
									$Sender = $conf->contact_recipient;
									$Recipiant = $_POST['persc_email'];
									$CustomHeaders = '';
									$text = GetFileContent("../templates/emails/factura_proforma.tpl");
									
									#acestea sunt aceleasi indiferent pe cine se emite factura proforma
									$text = str_replace("%NUME_PERS_CONTACT%",	ucfirst($_POST['pers_contact']) , $text);
									$text = str_replace("%NUMAR_FACTURA_PROFORMA%",$nr_fact_proforma, $text);
									$text =str_replace("%EXPIRARE_FACTURA_PROFORMA%",$conf->expirare_proforma,$text); 
									$text = str_replace("%DATA%",date("d-M-Y"),$text);
									$text = str_replace("%PRET_TOTAL%",$conf->$pret_perioada,$text);
									if($_POST['perioada']==="1")
									{
										$text = str_replace("%DENUMIRE_SERVICI%","Promovare online pentru ".$_POST['nume_firma'].", din ".date("d-M-Y")." pana in ".date("d-M-Y", mktime(0, 0, 0, date("m"), date("d")+5, date("Y")+1)),$text);
									}
									else
									{
											$text = str_replace("%DENUMIRE_SERVICI%","Promovare online pentru ".$_POST['nume_firma'].", din ".date("d-M-Y")." pana in ".date("d-M-Y", mktime(0, 0, 0, date("m"), date("d")+5, date("Y")+2)),$text);
									}
									$text = str_replace("%COD_FISCAL_CNP%",	$_POST['inreg_fiscala_cnp'] , $text);
									$text = str_replace("%NR_REG_COM_BI%",	$_POST['reg_comert_bi'] , $text);
									
									$pret = $conf->$pret_perioada;
									$pret_fara_tva =$pret - $pret * 0.19;
									$valoare_tva = $pret * 0.19;
									$text = str_replace("%VALOARE_TVA%",	$valoare_tva , $text);
									$text = str_replace("%PRET_TOTAL_FARA%",	$pret_fara_tva , $text);
									$get_name_localitate = GetLocalitate($_POST['nume_loc_sector']);

									
									#daca se emite factura pe firma
									if($_POST['type']=="firma")
									{
										#aici emitem factura pentru firma
										$text = str_replace("%NUME_PERS_CONTACT_FIRMA%",	$_POST['nume_firma'] , $text);
										$text = str_replace("%ADRESA%",	$_POST['adresa_firma']." <br /> ".$get_name_localitate['name'].", ".$_POST['judet'].",".$_POST['zip_code'] , $text);
									
									}
									else
									{
										$text = str_replace("%NUME_PERS_CONTACT_FIRMA%",$_POST['pers_contact'] , $text);
										$text = str_replace("%ADRESA%",	$_POST['persc_adresa'], $text);
											$text = str_replace("%COD_FISCAL_CNP%",	$_POST['inreg_fiscala_cnp'] , $text);

									}

									$Subject = "Factura proforma :". $nr_fact_proforma;	
									$message = new Email($Recipiant, $Sender, $Subject, $CustomHeaders);
									$message->SetHtmlContent($text);
									if (ValidHeader($Sender))
									{
										$message->Send();
										$emis_fact = "Y";
									}
									else
									{
										$emis_fact="N";
										$query ="Update plati set emis_fact_proforma='N' where id='".$nr_fact_proforma."'";
										$db->query($query);
									}
							}
							
							$_SESSION['admin_info_type'] = 'info';
							$_SESSION['admin_info'] = "Cabinetul,Laboratorul,Clinica  a fost adaugata cu succes!";
					
						header ('location: ?page=cabinete.list');
						exit;
			break;

			case 'list':
				$tpl->set_file('tpl_list', 'cabinete/list2.tpl');
				//$tpl->set_file('tpl_list', 'cabinete/list2_print_anda.tpl');
				$tpl->set_var('MAIN_TITLE', 'List cabinete , laboratoare, clinici din Romania');
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
				#check if the selected parent is a category or a module
				$path = explode("_", $param1);
				switch ($path['0'])
				{
					default :
						$all_cabinete = 0;
						$total_records = CountCabineteTotalRecords('-1', '',$admin->level);
					break;

					case 'category':
						$cat_id = $path['1'];
						$total_records = CountCabineteTotalRecords($path['0'], $path['1'],$admin->level);
					break;

					case 'module':
						$the_module_id = $path['1'];
						$total_records = CountCabineteTotalRecords($path['0'], $path['1'],$admin->level);
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
				#cabinete count
				$tpl->set_var('COUNT_CABINETE', $total_records);
				$pages_number = ceil($total_records/$conf->admin_cabinete_per_page);
				$tpl->set_var("PAGES", $pages_number);
				#create de pagination page_name
				$page_name = $module.'.'.$action;
				if(isset($_GET['start'])&&($_GET['start']!=""))
				{
						$start = $_GET['start'];
						$start_q = $conf->admin_cabinete_per_page*($start-1);
				}
				 else
				{
					$start_q = 0;
					$start = 1;
				}
				#to set the display mode, make some rules of display about data modificarii, or others

				if(isset($_GET['displaymode'])&&($_GET['displaymode']!=""))
				{
						$dispmode = $_GET['displaymode'];
				}
				 else
				{
					$dispmode = "data-submision_date-DESC";
				}

				if ($param1 != '')
				{
					$page_name = $page_name.'.'.$param1;
				}
				
				/*if(!isset($start))
				{
					$start_q = 0;
					$start = 1;
				}
				else
				{
					$start_q = $conf->admin_cabinete_per_page*($start-1);
				}*/
				#Create and parse pagination
				$html_pages = AdminPaginationCabineteAnuntArticole($conf->admin_cabinete_per_page, $total_records, $page_name, $start,$dispmode);
				$tpl->set_var("PAGINATION", $html_pages);
				$tpl->set_var("PAGE_NAME",$page_name );
				#Set blocks
				$tpl->set_block('tpl_list', 'list_cabinete', 'list_cabinete_block');
				$tpl->set_block('tpl_list', 'if_cabinete', 'if_cabinete_block');
				$tpl->set_block('tpl_list', 'if_no_cabinete', 'if_no_cabinete_block');
				#Create query limit and get the cabinete for displaing
				$query_limit = " LIMIT $start_q, $conf->admin_cabinete_per_page";
				if (isset($all_cabinete))
				{
					$cabinete = ListAdminCabinete('-1', '', $query_limit,$dispmode,$admin->level);
				}
				else 
				{
					$cabinete = ListAdminCabinete($path['0'], $path['1'], $query_limit,$dispmode,$admin->level);
				}
				if (count($cabinete) != '0')
				{
					$i = 0;
					while (list($k, $v) = each($cabinete))
					{
						#set colors

						$bc = ($i % 2)+1;
						$tpl->set_var("BGCOLOR",'row'.$bc);
						
						if($v['contactat']=='Y')
						{
							$tpl->set_var("BGCOLOR",'row3');
						}


						if($v['submision_date']==date("d M Y"))
						{	$tpl->set_var("BGCOLOR", "today_add"); }
						$tpl->set_var('NR_VISITS',$v['nr_visits'] );
						$tpl->set_var('ID', $v['id']);
						$tpl->set_var('NUME_CABINET', $v['nume_firma']);
						$tpl->set_var('TELEFON', $v['telefon']);
						$tpl->set_var('EMAIL', $v['email']);
						$tpl->set_var('ADDRESS', $v['adresa_firma']);
						$tpl->set_var('PERSOANA_CONTACT', $v['pers_contact']);
						$tpl->set_var('JUDET_ID',$v['judet'] );
						$tpl->set_var('AGENT',getAgentName($v['admin_id']));
						$tpl->set_var('TYPE_ID',$v['category_id'] );
						$main_photo = GetCabineteMainPhoto($v['id'],"cabinet");
						$tpl->set_var('IMAGINE', SITE_BASE.'/sources/thumbnails.php?target='.$main_photo['image_name'].'&max_size='.$conf->admin_gallery_max.'&folder='.$v['id']);
						$video = getCabinetVideoFile($v['id']);
						if (is_array($video) )
						{
							$tpl->set_var('NR_VIDEO', 1); 
						}
						else 
						{
						$tpl->set_var('NR_VIDEO', 0); 
						}
						$tpl->set_var('MODIFICA_VIDEO', "index.php?page=cabinete.modificavideo.".$v['id'].".".$v['user_id']);
							
						$get_banner = GetBanner($v['id']);
						if($get_banner!="")
						{						$tpl->set_var('NR_BANNER', 1); 				}
						else
						{					$tpl->set_var('NR_BANNER', 0); 			}
						
						
						$count_images = GetCabineteImages($v['id']);
						$tpl->set_var('NR_IMAGINI',count($count_images) );
						$tpl->set_var('MODIFICA_IMAGINI',"index.php?page=cabinete.modificaimg.".$v['id'].".".$v['user_id'].".".$v['nume_firma'] );
						//echo $v['level']."<br>";
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
									$get_level_det = getPromovareLevelDetails($val);
									$promovare = $promovare.$pkInfo['name'].' - '.$pkInfo['pret'].' RON';
								}
						
							}
							else
							{
								$pkInfo = $pachete->getPachetInfo($v['level']);
								$promovare = $pkInfo['name'].' - '.$pkInfo['pret'].' RON';
							}
							$promovare.= "<p>[ <a href='index.php?page=users.addpromovare.".$v['id']."'>schimba promovare</a> ]</p>";
						}
						$tpl->set_var('LOCPROMOVARE',$promovare );
						
						
						
						//print_r($get_level_det);
						//	$get_tip_promovare = getTipPromovareName($v['tip_promovare']);
						//	$tpl->set_var('LOCPROMOVARE',$get_tip_promovare['nume'] );
						if($v['user_id']=="-1")
						{
							$tpl->set_var('USER',"admin" );
							$tpl->set_var('USER_ID',"-1");
						}
						else
						{
							$get_user_info = GetUser($v['user_id']);
							$tpl->set_var('USER',$get_user_info );
							$tpl->set_var('USER_ID',$v['user_id'] );
						}

						$tpl->set_var('SUBMISION_DATE',$v['submision_date']);
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
						if ($v['emailplata'] == 'Y')
						{
							$tpl->set_var('IMAGE2', 'active.png');
							$tpl->set_var('IMAGE_TITLE2', 'inactive');
						}
						else 
						{
							$tpl->set_var('IMAGE2', 'inactive.png');
							$tpl->set_var('IMAGE_TITLE2', 'active');
						}
						$tpl->set_var('COMMENT', $v['comment']);
						$tpl->set_var('MODIFY_DATE', $v['data_modificarii']);
						$tpl->set_var('PARENT_MODULE', GetCabinetParents($v['id']));
						$tpl->set_var('LINK_TO_CABINET', ReWrite('cabinete_detalii', 'cabinete.detalii.'.$v['id']));


						if($v['recomandata']=='N')
						{
							$tpl->set_var('RECOMANDED', "NO" );
							$tpl->set_var('CHANGE_RECOMANDED', 'change_yes' );
							$tpl->set_var('PRELUNGESTE_PROMOVARE', "" );

						}
						else
						{
							$tpl->set_var('RECOMANDED', " YES " );
							$tpl->set_var('PRELUNGESTE_PROMOVARE', "<a href=\"?page=plati.prelungestepromovare.".$v['id'].".".$v['user_id'].".".$v['judet'].".".$v['category_id']."\">Prelungeste promovare</a>" );
							$tpl->set_var('CHANGE_RECOMANDED','change_no'  );
						}

						$tpl->parse('list_cabinete_block', 'list_cabinete', true);
						$i++;
					}
					$tpl->parse('if_cabinete_block', 'if_cabinete', true);
				}
				else 
				{
					$tpl->parse('if_no_cabinete_block', 'if_no_cabinete', true);
				}
				$tpl->parse('MAIN', 'tpl_list');
			break;

			case 'recomandate':
				$tpl->set_file('tpl_list', 'cabinete/recomandate.tpl');
				$tpl->set_var('MAIN_TITLE', 'Lista cabinete recomandate de pe dentistonline.ro');
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
				#check if the selected parent is a category or a module
				$path = explode("_", $param1);
				switch ($path['0'])
				{
					default :
						$all_cabinete = 0;
						$total_records = CountCabineteRecomandateTotalRecords('-1', '');
					break;

					case 'category':
						$cat_id = $path['1'];
						$total_records = CountCabineteRecomandateTotalRecords($path['0'], $path['1']);
					break;

					case 'module':
						$the_module_id = $path['1'];
						$total_records = CountCabineteRecomandateTotalRecords($path['0'], $path['1']);
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
				#cabinete count
				$tpl->set_var('COUNT_CABINETE', $total_records);
				$pages_number = ceil($total_records/$conf->admin_cabinete_per_page);
				$tpl->set_var("PAGES", $pages_number);
				#create de pagination page_name
				$page_name = $module.'.'.$action;
				if(isset($_GET['start'])&&($_GET['start']!=""))
				{
						$start = $_GET['start'];
						$start_q = $conf->admin_cabinete_per_page*($start-1);
				}
				 else
				{
					$start_q = 0;
					$start = 1;
				}
				#to set the display mode, make some rules of display about data modificarii, or others

				if(isset($_GET['displaymode'])&&($_GET['displaymode']!=""))
				{
						$dispmode = $_GET['displaymode'];
				}
				 else
				{
					$dispmode = "data-date_exp-ASC";
				}

				if ($param1 != '')
				{
					$page_name = $page_name.'.'.$param1;
				}
				
				/*if(!isset($start))
				{
					$start_q = 0;
					$start = 1;
				}
				else
				{
					$start_q = $conf->admin_cabinete_per_page*($start-1);
				}*/
				#Create and parse pagination
				$html_pages = AdminPaginationCabineteAnuntArticole($conf->admin_cabinete_per_page, $total_records, $page_name, $start,$dispmode);
				$tpl->set_var("PAGINATION", $html_pages);
				$tpl->set_var("PAGE_NAME",$page_name );
				#Set blocks
				$tpl->set_block('tpl_list', 'list_cabinete', 'list_cabinete_block');
				$tpl->set_block('tpl_list', 'if_cabinete', 'if_cabinete_block');
				$tpl->set_block('tpl_list', 'if_no_cabinete', 'if_no_cabinete_block');
				#Create query limit and get the cabinete for displaing
				$query_limit = " LIMIT $start_q, $conf->admin_cabinete_per_page";
				if (isset($all_cabinete))
				{
					$cabinete = ListAdminCabineteRecomandate('-1', '', $query_limit,$dispmode);
				}
				else 
				{
					$cabinete = ListAdminCabineteRecomandate($path['0'], $path['1'], $query_limit,$dispmode);
				}
				if (count($cabinete) != '0')
				{
					$i = 0;
					while (list($k, $v) = each($cabinete))
					{
						#set colors
						$bc = ($i % 2)+1;
						$tpl->set_var("BGCOLOR",'row'.$bc);
						
						if($v['submision_date']==date("d M Y"))
						{	$tpl->set_var("BGCOLOR", "today_add"); }
						$tpl->set_var('NR_VISITS',$v['nr_visits'] );
						$tpl->set_var('ID', $v['id']);
						$tpl->set_var('NUME_CABINET', $v['nume_firma']);
						$tpl->set_var('JUDET_ID',$v['judet'] );
						$tpl->set_var('TYPE_ID',$v['category_id'] );
							

						$main_photo = GetCabineteMainPhoto($v['id'],"cabinet");
						$tpl->set_var('IMAGINE', SITE_BASE.'/sources/thumbnails.php?target='.$main_photo['image_name'].'&max_size='.$conf->admin_gallery_max.'&folder='.$v['id']);
						$count_images = GetCabineteImages($v['id']);
						$tpl->set_var('NR_IMAGINI',count($count_images) );
						$tpl->set_var('MODIFICA_IMAGINI',"index.php?page=cabinete.modificaimg.".$v['id'].".".$v['user_id'].".".$v['nume_firma'] );

						if($v['user_id']=="-1")
						{
							$tpl->set_var('USER',"admin" );
							$tpl->set_var('USER_ID',"-1");
						}
						else
						{
							$get_user_info = GetUser($v['user_id']);
							$tpl->set_var('USER',$get_user_info );
							$tpl->set_var('USER_ID',$v['user_id'] );
						}
						#lets take some details about recomandate cabinete
						$infos = GetInfoRecomandate($v['user_id'],$v['id']);
						if(isset($infos[0]['perioada'])&&($infos[0]['perioada']!=""))
						{
							$tpl->set_var('PERIOADA_LUNI',$infos[0]['perioada'] );
							$tpl->set_var('ADAUGAT_RECOMANDAT',TimeFormatEvents($infos[0]['date_add']) );
							$tpl->set_var('EXPIRA_RECOMANDAT',TimeFormatEvents($infos[0]['date_exp']) );
							
								if(isset($infos[0]['factura_id'])&&($infos[0]['factura_id']!="")&&($infos[0]['factura_id']!="0"))
								{
									$tpl->set_var('FACTURA_PROFORMA', $infos[0]['factura_id']);
									$get_fiscala = GetFiscalaForProforma($infos[0]['factura_id']);
									$tpl->set_var('FACTURA_FISCALA', $get_fiscala['serie_factura']);
								}
								else
								{
									$tpl->set_var('FACTURA_PROFORMA', "none");
									$tpl->set_var('FACTURA_FISCALA', "none");
								}

							if(strtotime($infos[0]['date_exp'])< (strtotime(date("Y-m-d"))+360000))
							{	$tpl->set_var("CLASSEXPIRE", "style=\"color:red;font-weight:bold;\"");	}
							else
							{
								$tpl->set_var("CLASSEXPIRE", "");
							}


						}
						else
						{
							$tpl->set_var('PERIOADA_LUNI',"!!!" );
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
						$tpl->set_var('COMMENT', $v['comment']);
						$tpl->set_var('PARENT_MODULE', GetCabinetParents($v['id']));
						$tpl->set_var('LINK_TO_CABINET', ReWrite('cabinete_detalii', 'cabinete.detalii.'.$v['id']));


						if($v['recomandata']=='N')
						{
							$tpl->set_var('RECOMANDED', "NO" );
							$tpl->set_var('CHANGE_RECOMANDED', 'change_yes' );
							$tpl->set_var('PRELUNGESTE_PROMOVARE', "" );

						}else
						{
							$tpl->set_var('RECOMANDED', " YES " );
							$tpl->set_var('PRELUNGESTE_PROMOVARE', "<a href=\"?page=plati.prelungestepromovare.".$v['id'].".".$v['user_id'].".".$v['judet'].".".$v['category_id']."\">Prelungeste promovare</a>" );
							$tpl->set_var('CHANGE_RECOMANDED','change_no'  );

						}

						$tpl->parse('list_cabinete_block', 'list_cabinete', true);
						$i++;
					}
					$tpl->parse('if_cabinete_block', 'if_cabinete', true);
				}
				else 
				{
					$tpl->parse('if_no_cabinete_block', 'if_no_cabinete', true);
				}
				$tpl->parse('MAIN', 'tpl_list');
			break;

			case 'set':
				ChangeCabinetStatus($param1, $param2);
				GenerateSmallImages($param2);
				$_SESSION['admin_info'] = 'Status successfully changed !';
				$_SESSION['admin_info_type'] = 'info';
				header ('location: '.$_SERVER['HTTP_REFERER']);
				exit;
			break;

			case 'setemail':
				ChangeCabinetStatus2($param1, $param2);

				$sql = "INSERT INTO cabinete_marketing(`id`, `cabinet_id`, `comments`, `date`, `admin_id`) VALUES('','$param2','Trimis e-mail marketing!',NOW(),'$admin->userID')";
				$db->query($sql);

				$sql = "UPDATE cabinete SET `contactat`='Y' WHERE `id`='$param2'";
				$db->query($sql);

				//GenerateSmallImages($param2);
				$_SESSION['admin_info'] = 'E-mail status successfully changed !';
				$_SESSION['admin_info_type'] = 'info';
				header ('location: '.$_SERVER['HTTP_REFERER']);
				exit;
			break;

			case 'edit':
				$tpl->set_file('tpl_edit', 'cabinete/edit_cabinet.tpl');
				#get the parent module or category
				$tpl->set_block('tpl_edit', 'cats', 'cats_block');
				$tpl->set_block('tpl_edit', 'modules', 'modules_block');
				$tpl->set_block('tpl_edit', 'display_cats', 'display_catss');
				$tpl->set_block('tpl_edit', 'judet', 'judett');
				$tpl->set_var('BGCOLOR1', 'row1');
				$tpl->set_var('BGCOLOR2', 'row2');
				$tpl->set_var('ID_USER',$param2 );
				$get_cabinet['category_parent'] = GetIdCatForCabinet($param1);
				$get_modules = GetCabineteModules();
				if (count($get_modules) != '0')
				{
					while (list($k, $v) = each($get_modules))
					{
						$tpl->set_var('SELECTED_MODULE', '');
						if (isset($get_cabinet['module_parent']) && $get_cabinet['module_parent'] == $v['id'])
						{
							$tpl->set_var('SELECTED_MODULE', 'selected');
						}
						$tpl->set_var('MODULE_ID', $v['id']);
						$tpl->set_var('MODULE_NAME', $v['name']);
						$get_cats = GetCabineteCategories($v['id'], 'Y', '');
						if (count($get_cats) != '0')
						{
							while (list($key, $val) = each($get_cats))
							{
								$tpl->set_var('SELECTED_CATEGORY', '');
								if (isset($get_cabinet['category_parent']) && $get_cabinet['category_parent'] == $val['id_cat'])
								{
									$tpl->set_var('SELECTED_CATEGORY', 'selected');
								}
								$tpl->set_var('CATEGORY_ID', $val['id_cat']);
								$tpl->set_var('CATEGORY_NAME', $val['cat_name']);
								$tpl->parse('cats_block', 'cats', true);
							}
						}
						$tpl->parse('modules_block', 'modules', true);
						$tpl->parse('cats_block', '');
					}
				}
				$id_firma = $param1;$user_id = $param2;
				$tpl->set_var('ID_CABINET',$param1 );
				$get_firm_info = GetFirme($user_id,$id_firma);
				$get_firm_info_real = $get_firm_info[0];
				$tpl->set_var('MAIN_TITLE', 'Edit "'.$get_firm_info[0]['nume_firma'].'" cabinet');
				$get_contract_id = GetContractForCabinet($id_firma);
				$get_proforma_id = GetproformaForCabinet($id_firma);
				$tpl->set_var('PROFORMA_ID', $get_proforma_id);
				$tpl->set_var('CONTRACT_ID',$get_contract_id );
				foreach($get_firm_info_real as $ky => $val)
				{
					if($ky=="category_id")
					{
							$get_dentist_categ = Get_Dentist_Cats('-1');
							foreach($get_dentist_categ as $kky => $vall)
							{
								if($val==$vall['id'])
								{		$tpl->set_var('CATEGORY_ID',"selected" );	$cat_id=$val;}
								else
								{		$tpl->set_var('CATEGORY_ID',"" );	}

								$tpl->set_var('CAT_NAME',$vall['name'] );
								$tpl->set_var('CAT_ID',$vall['id'] );
								$tpl->parse('display_catss', 'display_cats', true);
							}
					}
					elseif($ky=="judet")
					{		
							$cod_judet = $val;
							$get_dentist_judete = GetJudete();
							foreach($get_dentist_judete as $kky => $vval)
							{
								if($val==$vval['code'])
								{	$tpl->set_var('JUDET',"selected" );	}
								else
								{	$tpl->set_var('JUDET',"" );	}

								$tpl->set_var('COD_JUDET',$vval['code'] );
								$tpl->set_var('NUMEJUDET',$vval['name'] );
								$tpl->parse('judett', 'judet', true);
							}
					
					}
					elseif($ky=="type")
					{
						if(($val!="none")&&($val!==""))
						{
							//var_dump($val);exit;
							$tpl->set_var('FACTURA_TYPE',$val );
							$tpl->set_file("tpl_formplace","../modules/user/".$val.".tpl");
							$tpl->set_var('EDITABLE',"readonly" );
							$tpl->parse('LOC_FORM_PLACE','tpl_formplace');
						}
						else
						{
							$tpl->set_var('PERIOADA', "1" );
							$tpl->set_var('FACTURA_TYPE',"Firma neplatitoare. Nu exista factura!" );
						}
					}
					elseif($ky=="nume_loc_sector")
					{
						$tpl->set_file("tpl_search_ajax","../modules/search/localitati_ajax_faratoate.tpl");
							$tpl->set_block('tpl_search_ajax', 'loocalitati', 'loocalitatii');

							$get_dentist_localitati = GetLocalitati($cod_judet);
							foreach($get_dentist_localitati as $kyy => $vaal)
							{
								if($val == $vaal['id'])
								{	$tpl->set_var('SELECTED_LOC',"selected" );	}
								else
								{	$tpl->set_var('SELECTED_LOC',"" );	}

								$tpl->set_var('ID_LOCALITATE',$vaal['id'] );
								$tpl->set_var('NUMELOCALITATE',$vaal['name'] );
								$tpl->parse('loocalitatii', 'loocalitati', true);
							}
							$tpl->parse('LOC_DIV_ADAUGAFIRMA','tpl_search_ajax');
					}
					elseif($ky=="status")
					{
						if($val=='0')
						{
							$tpl->set_var('EMAILACTIVARE', " Emailul de activare a cabinetului nu a fost trimis!!");
						}
						else
						{
						$tpl->set_var('EMAILACTIVARE', " ");
						}
					}
					
					else
					{ 
						$tpl->set_var(strtoupper($ky),$val );
						if($ky=="pers_contact")
						{
							$pers_contact = $val;
						}
						
					}
				}
				
				##############################################Activation email type############################
				#make some stuffs for activation email type
				if(isset($param3)&&($param3!="")&&($param3!="none"))
				{
					$linkfirma = ReWrite("cabinete_detalii","cabinete.detalii.".$param1);
					$text = GetFileContent("../templates/emails/cabinete/cabinete_status.tpl");
				
					if($param3=="cab_inactiv")
					{
						$text = str_replace("%SALUT%",	"Buna ziua" , $text);
					}
					else
					{
						$text = str_replace("%SALUT%",	"Felicitari" , $text);
						$text = str_replace("%NUMEPERSOANA%",	$pers_contact , $text);
						
						switch($cat_id)
						{
							case '1':
							$firmatype ="Cabinetul stomatologic";
							$text = str_replace("%PARSE_FEM%",	"", $text);
							break;
							case '2':
								$firmatype = "Laboratorul de tehnica dentara";
							$text = str_replace("%PARSE_FEM%",	"", $text);
							break;
							case '3':
								$firmatype = "Laboratorul de radiologie dentara";
							$text = str_replace("%PARSE_FEM%",	"", $text);
							break;
							case '4':
								$firmatype = "Depozitul de materiale";
								$text = str_replace("%PARSE_FEM%",	"", $text);
							break;
							case '5':
								$firmatype ="Clinica stomatologica";
								#we set the acord to feminiine for clinique
								$text = str_replace("%PARSE_FEM%",	"a", $text);
							break;
							
						}
						$text = str_replace("%FIRMA_TYPE%",	$firmatype , $text);
						$text = str_replace("%NUME_FIRMA%",	$get_firm_info[0]['nume_firma'], $text);
						
						switch($param3)
						{
							#means all it's ok, we have images and full description
							case 'cab_activat':
							$text = str_replace("%MESSAGE_TYPE%",	"", $text);	
							
							break;
							#means that we have just a few description and we can't creat logo image
							case 'fara_img_fara_scris':
								$text = str_replace("%MESSAGE_TYPE%",	"	Pentru a avea un numar mai mare de vizitatori ce vor accesa %FIRMA_TYPE2%  va sugeram sa oferiti informatii mai cuprinzatoare in ceea ce priveste descrierea, tarifele si servicile oferite . Deasemenea  o imagine face cat 1000 de cuvinte. <br />", $text);	
							break;
							#means that we create the logo image for him
							case 'imagine_logo':
								$text = str_replace("%MESSAGE_TYPE%",	"	Dorim o promovare eficienta,la nivel inalt de aceea am creat special pentru dvs. o imagine logo gratuit.<br />
							Prin prezenta acestui logo aveti posibilitatea de a aparea aleator pe prima pagina a website-ului. Vizitatorii vor accesa mai usor si mai cu drag prezentarea dvs, de accea asteptam si alte imagini prin care sa perfectionam oferta dvs.", $text);	
							break;
						}
						$text = str_replace("%FIRMA_LINK%",	$linkfirma , $text);
						$text = str_replace("%FIRMA_TYPE2%",	strtolower($firmatype), $text);
							
						
					}

					$tpl->set_var('EMAIL_CONTENT2', $text);
					//$tpl->set_var('EMAIL_CONTENT1', $text);
				
					
					$tpl->set_var('selected_'.$param3,"selected" );
				}
				else
				{
				
					$tpl->set_var('EMAIL_CONTENT1', "No email type");
					$tpl->set_var('EMAIL_CONTENT2', "");
					$tpl->set_var('VISABILITI_OPTION', "none");
				}
				#######################################
				#this is for erros block
				if (isset($_SESSION['submit_errors']))
				{
					$tpl->set_var("ERROR_MSG", $_SESSION['submit_errors']);
					unset($_SESSION['submit_errors']);
					$tpl->parse("error_block", "error", true);
				}
				#fill fields
				if (isset($_SESSION['submit_firma']))
				{
					foreach ($_SESSION['submit_firma'] as $key => $val)
					{
							$values = explode("=>",$val);
							if($values[0]=="category_id")
							{	$tpl->set_var(strtoupper($values[0]), "selected");	}
							elseif($values[0]=="judet")
							{		$tpl->set_var(strtoupper($values[0]), "selected");	}
							else
							{		$tpl->set_var(strtoupper($values[0]), $values[1]);}
					}
					unset($_SESSION['submit_firma']);
				}
			$tpl->set_var('UPDATE_FIRMA',ReWrite("user","user.updatefirma.".$id_firma));
			$tpl->parse("MAIN", "tpl_edit");
			break;

			case 'save_edit':
				$id_firma = $param1;
				/* cu plata $array_obligatorii = array("category_id"=>"Categoria","nume_firma"=>"nume firma","adresa_firma"=>"Adresa firma","inreg_fiscala_cnp"=>"Cod inregistrare fiscala/ CNP","reg_comert_bi"=>"Registru Comertului/BI serie numar","judet"=>"judet","nume_loc_sector"=>"Localitate/sector ","orar"=>"Orar","pers_contact"=>"Persoana de contact","persc_email"=>"Adresa de email","persc_tel"=>"Telefon persoana contact","persc_adresa"=>"Adresa persona contact","meta_keywords"=>"Meta keywords","meta_description"=>"Meta Description");*/
				
				$array_obligatorii = array("category_id"=>"Categoria","nume_firma"=>"Nume firma","adresa_firma"=>"Adresa firma","judet"=>"judet","nume_loc_sector"=>"Localitate/sector ","orar"=>"Orar","pers_contact"=>"Persoana de contact","persc_email"=>"Adresa de email","descriere"=>"Descrierea ");
				$display_errors = '';
				foreach($_POST as $ky => $val)
				{
					if((array_key_exists($ky,$array_obligatorii))&&($val==""))
					{	$display_errors .= '<li>'. $array_obligatorii[$ky]." nu este setat".'</li>';}

				}
				
				if (array_key_exists('nume_loc_sector', $_POST)===FALSE) 
				{		$display_errors .= '<li>'.$array_obligatorii['nume_loc_sector']." nu este setat".'<li>'; }
				
					if(isset($_POST['email_firma'])&&($_POST['email_firma']!=""))
				{
					$email = ValidEmail($_POST['email_firma']);
					if(!$email)
						{	$display_errors .="<li>Adresa de email este invalida</li>";	}

				}

				if($display_errors!="")
				{		
						#let_put in sessions all infos from post in case we have errors
						$_SESSION['submit_errors'] = $display_errors;
						$_SESSION['submit_firma']=array();
						foreach($_POST as $ky => $val)
						{
							$info = $ky ."=>".$val;	array_push($_SESSION['submit_firma'],$info);
						}
						header('location: '.GetReferer());
						exit;
				}
				else
				{
					#this means that we can't change sub category for cabinet
					array_shift($_POST);
					#if sub category  has been changed
				
					foreach($_POST as $ky => $val)
					{	if(strpos($ky,"caractere")!==FALSE)
							{
								unset($_POST[$ky]);
							}
							else
							{ 
								$query="Update cabinete set ".$ky."='".mysql_real_escape_string(strip_tags($val,'<p><font><b><br><strong><i><u><font>'))."' WHERE id='".$id_firma."'";
								$db->query($query);
								if($ky=="judet")
								{		UpdateCabinetToCat($id_firma,$_POST['category_id'],$val);		}
							}
					}
					$update_alias_name =$_POST['alias'];
					$query="Update cabinete set alias='".addslashes($update_alias_name)."' WHERE id='".$id_firma."'";
					$db->query($query);
					GenerateSmallImages($id_firma);
					$_SESSION['admin_info_type'] = 'info';
					$_SESSION['admin_info'] = "Modificarea a fost realizata cu succes!";
					header('location: '.'?page=cabinete.list');exit;
				}
					/*#check the parent
					$parent = explode("_", $_POST['cabinet_category']);
					$parent_mod = $parent['0'];
					$parent_id = $parent['1'];
					switch ($parent_mod)
					{
						#the cabinet has been inserted for a certain module
						case 'module':
							$tempArray = array("id" => intval($param1), "module_parent" => $parent_id);
						break;
						#the cabinet has been inserted for a certain category under a module
						case 'category':
							$tempArray = array("id" => intval($param1), "category_parent" => $parent_id);
						break;
					}
					$_POST = array_merge($_POST, $tempArray);
					$_SESSION['edit_cabinet_content'] = $_POST;
					header ('location: '.$_SERVER['HTTP_REFERER']);
					exit;
				}*/
			break;
			
			case 'sendemail':
				
				//print_r($_POST);
				//echo $param1." ".$param2." ".$param3." ".$param4;exit;
					$Sender = $conf->contact_recipient;
					$text = $_POST['email_content'];
					$CustomHeaders = '';
					$recipant=array();
					
					if(trim($_POST['pers_email']) != trim($_POST['email_firma']))
					{
						$recipant[0]= trim($_POST['pers_email']);
						$recipant[1]= trim($_POST['email_firma']);
					}
					else
					{
						$recipant[0]= trim($_POST['pers_email']);
					}
					
				
				for($i = 0; $i < count($recipant) ; $i++)
				{
						if(($_POST['emailform']!="cab_inactiv")&&($_POST['emailform']!="none"))
						{
							$Subject = "Oferta dvs. a fost activata pe DentistOnline.ro";	
							$_SESSION['submit_errors'] = "<li>Emailul de activare a fost trimis cu succes!</li>";
							#lets activate the cabinet
							$query="Update cabinete set status='1' Where id='".$param1."'";
							$db->query($query);
						}
						else
						{
							$Subject = ucfirst($_POST['nume_fir'])." este inactiv pe DentistOnline.ro";
							$_SESSION['submit_errors'] = "<li>Emailul de dezactivare a fost trimis cu succes!</li>";
							
							#deactivate the cab
							$query="Update cabinete set status='0' Where id='".$param1."'";
							$db->query($query);
						}
						$message = new Email($recipant[$i], $Sender, $Subject, $CustomHeaders);
						$message->SetHtmlContent($text);
						if (ValidHeader($Sender))
						{
							$message->Send();
						}
				}
					header('location: ?page=cabinete.edit.'.$param1.".".$param2);
					exit;
			
			break;

			case 'emailtrimis':
				$Sender = $conf->contact_recipient;
				$Recipiant = $_POST['email_recipiant'] ;
				$CustomHeaders = '';
				$Subject = $_POST['subject'];
				$text = $_POST['mesaj'];
				$message = new Email($Recipiant, $Sender, $Subject, $CustomHeaders);
				$message->SetHtmlContent($text);
				if (ValidHeader($Sender))
				{
					$message->Send();
				}
				$_SESSION['email_trimis'] = "Yes";
				header('location: ?page=cabinete.sendemail.general');exit;
			break;

			case 'cauta':
				$tpl->set_file('tpl_cauta', 'cabinete/cauta2.tpl');
				#page main title
				$tpl->set_var('MAIN_TITLE', 'Cautare cabinete');
				#set blocks
				$tpl->set_block('tpl_cauta', 'list_cabinete', 'list_cabinete2');
				$tpl->set_block('tpl_cauta', 'if_cabinete', 'if_cabinete2');

				$tpl->set_block('tpl_cauta', 'if_no_cabinete', 'if_no_cabinete2');



				if($param1!="" )
				{
					$tpl->set_var(strtoupper($param1),"selected" );
					$tpl->set_var('CE_CAUTAM',strtoupper($param1) );
					$tpl->set_var("VALOARE_CAUTARE",$param2);

					#count all messages
					$total_records = CountCabineteCauta($param1,$param2);
					$tpl->set_var('COUNT_CABINETE', $total_records);
					$pages_number = ceil($total_records/$conf->users_per_page);
					$tpl->set_var('PAGES', $pages_number);
					#create de pagination page_name
					$page_name = $module.'.'.$action.'.'.$param1.'.'.$param2;
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
					$cabinete = GetCabineteCauta($param1,$param2, $query_limit);
					if (count($cabinete) != '0')
					{
						$i = 0;
						while (list($k, $v) = each($cabinete))
						{
							#set colors
							$bc = ($i % 2)+1;
							$tpl->set_var("BGCOLOR",'row'.$bc);
							
							if($v['submision_date']==date("d M Y"))
							{	$tpl->set_var("BGCOLOR", "today_add"); }
							$tpl->set_var('NR_VISITS',$v['nr_visits'] );
							$tpl->set_var('ID', $v['id']);
							$tpl->set_var('NUME_CABINET', $v['nume_firma']);
							$tpl->set_var('TELEFON', $v['telefon']);
							$tpl->set_var('EMAIL', $v['email']);
							$tpl->set_var('JUDET_ID',$v['judet'] );
							$tpl->set_var('AGENT',getAgentName($v['admin_id']));
							$tpl->set_var('TYPE_ID',$v['category_id'] );
							$main_photo = GetCabineteMainPhoto($v['id'],"cabinet");
							$tpl->set_var('IMAGINE', SITE_BASE.'/sources/thumbnails.php?target='.$main_photo['image_name'].'&max_size='.$conf->admin_gallery_max.'&folder='.$v['id']);
							$video = getCabinetVideoFile($v['id']);
							if (is_array($video) )
							{
								$tpl->set_var('NR_VIDEO', 1); 
							}
							else 
							{
							$tpl->set_var('NR_VIDEO', 0); 
							}
							$tpl->set_var('MODIFICA_VIDEO', "index.php?page=cabinete.modificavideo.".$v['id'].".".$v['user_id']);
								
							$get_banner = GetBanner($v['id']);
							if($get_banner!="")
							{						$tpl->set_var('NR_BANNER', 1); 				}
							else
							{					$tpl->set_var('NR_BANNER', 0); 			}
							
							
							$count_images = GetCabineteImages($v['id']);
							$tpl->set_var('NR_IMAGINI',count($count_images) );
							$tpl->set_var('MODIFICA_IMAGINI',"index.php?page=cabinete.modificaimg.".$v['id'].".".$v['user_id'].".".$v['nume_firma'] );
							//echo $v['level']."<br>";
							
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
								$promovare.= "<p>[ <a href='index.php?page=users.addpromovare.".$v['id']."'>schimba promovare</a> ]</p>";
							}
							$tpl->set_var('LOCPROMOVARE',$promovare );

							//print_r($get_level_det);
							//	$get_tip_promovare = getTipPromovareName($v['tip_promovare']);
							//	$tpl->set_var('LOCPROMOVARE',$get_tip_promovare['nume'] );
							if($v['user_id']=="-1")
							{
								$tpl->set_var('USER',"admin" );
								$tpl->set_var('USER_ID',"-1");
							}
							else
							{
								$get_user_info = GetUser($v['user_id']);
								$tpl->set_var('USER',$get_user_info );
								$tpl->set_var('USER_ID',$v['user_id'] );
							}
	
							$tpl->set_var('SUBMISION_DATE',$v['submision_date']);
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
							if ($v['emailplata'] == 'Y')
							{
								$tpl->set_var('IMAGE2', 'active.png');
								$tpl->set_var('IMAGE_TITLE2', 'inactive');
							}
							else 
							{
								$tpl->set_var('IMAGE2', 'inactive.png');
								$tpl->set_var('IMAGE_TITLE2', 'active');
							}
							$tpl->set_var('COMMENT', $v['comment']);
							$tpl->set_var('MODIFY_DATE', $v['data_modificarii']);
							$tpl->set_var('PARENT_MODULE', GetCabinetParents($v['id']));
							$tpl->set_var('LINK_TO_CABINET', ReWrite('cabinete_detalii', 'cabinete.detalii.'.$v['id']));
	
	
							if($v['recomandata']=='N')
							{
								$tpl->set_var('RECOMANDED', "NO" );
								$tpl->set_var('CHANGE_RECOMANDED', 'change_yes' );
								$tpl->set_var('PRELUNGESTE_PROMOVARE', "" );
	
							}
							else
							{
								$tpl->set_var('RECOMANDED', " YES " );
								$tpl->set_var('PRELUNGESTE_PROMOVARE', "<a href=\"?page=plati.prelungestepromovare.".$v['id'].".".$v['user_id'].".".$v['judet'].".".$v['category_id']."\">Prelungeste promovare</a>" );
								$tpl->set_var('CHANGE_RECOMANDED','change_no'  );
							}
	
							$tpl->parse('list_cabinete2', 'list_cabinete', true);
							$i++;
						}
					$tpl->parse('if_cabinete2', 'if_cabinete', true);
				}
				else 
				{
					$tpl->parse('if_no_cabinete2', 'if_no_cabinete', true);
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
				$tpl->parse('MAIN', 'tpl_cauta');
			break;

			#galerie imagini de aici
			case 'modificaimg':
				$tpl->set_file('tpl_main', 'cabinete/modifica_images.tpl');
				$tpl->set_block('tpl_main', 'upload_block', 'upload_block2');
				$tpl->set_block('tpl_main', 'if_upload', 'if_upload2');
				$tpl->set_block('tpl_main', 'if_no_upload', 'if_no_upload2');
				$tpl->set_var('USER_ADD_IMAGES', "index.php?page=cabinete.addimage.".$param1.".cabinet");
				$tpl->set_var('USER_ADD_IMAGE_HARTA', "index.php?page=cabinete.addimage.".$param1.".harta");
				$tpl->set_var('USER_ADD_IMAGE_BANNER', "index.php?page=cabinete.addimage.".$param1.".banner");


				$tpl->set_var('USER_ID', $param2);
				$tpl->set_var('CABINET_ID',$param1);
				
				$tpl->set_block('tpl_main', 'list_images', 'list_images2');
				$tpl->set_block('tpl_main', 'if_images', 'if_images_block');
				
				#imagine harta stuffs
				$tpl->set_block('tpl_main', 'if_images_harta', 'if_images_harta_block');
				$tpl->set_block('tpl_main', 'if_no_images_harta', 'if_no_images_harta2');
				$tpl->set_block('tpl_main', 'upload_harta', 'upload_harta_block');
				
				#banner stufs
				$tpl->set_block('tpl_main', 'if_images_banner', 'if_images_banner_block');
				$tpl->set_block('tpl_main', 'if_no_images_banner', 'if_no_images_banner2');

				$tpl->parse('if_no_upload2', '');
				$tpl->parse('if_upload2', '');
				$tpl->set_var('NUME_FIRMA', ucfirst($param3));
				
				

				$images = GetCabineteImages($param1);
				$harta="N";$plusharta=0;
				if(count($images)>0)
				{
					$i=0;$kk=1;
					foreach($images as $ky => $val)
					{
						if($val['type']=="cabinet")
						{
							$ss=round($kk%2)+1;
							$tpl->set_var('BGCOLOR',"row".$ss );
							$tpl->set_var('ORDER',$val['position'] );
							$tpl->set_var('THUMBNAIL',"../sources/thumbnails.php?target=".$val['image_name'].'&max_size='.$conf->admin_gallery_max.'&folder='.$param1);
							$tpl->set_var('RE_ORDER_UP','index.php?page=cabinete.rearenge.'.$param1.'.'.$val['id'].'.up');
							$tpl->set_var('RE_ORDER_DOWN','index.php?page=cabinete.rearenge.'.$param1.'.'.$val['id'].'.down') ;
							$tpl->set_var('DELETE_IMAGE','index.php?page=cabinete.imagesdelete.'.$val['id']);
							$tpl->parse('list_images2', 'list_images', true);
							$kk++;
						}
						else
						{
					
							$harta="Y";	$plusharta=1;					$tpl->set_var('THUMBNAIL_HARTA',"../sources/thumbnails.php?target=".$val['image_name'].'&max_size='.$conf->admin_gallery_max.'&folder='.$param1);
							$tpl->set_var('DELETE_IMAGE','index.php?page=cabinete.imagesdelete.'.$val['id']);
							$tpl->parse('if_images_harta_block', 'if_images_harta', true);
						}
						
					}
					$tpl->parse('if_images_block', 'if_images', true);
				}
				if($harta!="Y")
				{
					$tpl->parse('if_no_images_harta2', 'if_no_images_harta', true);
					$tpl->parse('upload_harta_block', 'upload_harta', true);
				}
				$tpl->set_var('SIZE_MAX_IMG',$conf->max_img_cabinete );
				$left_images = 4 - count($images)+$plusharta;
				$tpl->set_var('NR_MAX_IMG',$left_images );
				if($left_images!='0')
				{
					for($i = 1; $i <=$left_images ; $i++)
					{
						$tpl->set_var('IMG_NR',$i );
						$tpl->parse('upload_block2', 'upload_block', true);
					}
					$tpl->parse('if_upload2', 'if_upload', true);
				}
				else
				{
					$tpl->set_var('NO_UPLOAD',"Nu mai puteti sa adaugati alte imagini. Aveti adaugate deja <b>4</b> imagini !" );
					$tpl->parse('if_no_upload2', 'if_no_upload', true);
					$tpl->parse('if_upload', '');
				}

				$get_banner = GetBanner($param1);
				if($get_banner!="")
				{
					$tpl->set_var('THUMBNAIL_BANNER',"../images/banner/".$get_banner);
					$tpl->set_var('DELETE_BANNER',"?page=cabinete.deletebanner.".$param1 );
					$tpl->parse('if_images_banner_block', 'if_images_banner', true);
				}
				else
				{
					
					$tpl->set_var('USER_ADD_IMAGE_BANNER',"?page=cabinete.addbanner.".$param1 );
					$tpl->parse('if_no_images_banner2', 'if_no_images_banner', true);
				}

				if (isset($_SESSION['admin_info'])&&($_SESSION['admin_info']!=""))
				{
					$tpl->set_file('tpl_info', 'info/'.$_SESSION['admin_info_type'].'.tpl');
					$tpl->set_var('MESSAGE', $_SESSION['admin_info']);
					$tpl->parse('ERROR', 'tpl_info');
					#uset sessions
					unset($_SESSION['admin_info']);
					unset($_SESSION['admin_info_type']);
				}
				$tpl->parse('MAIN', 'tpl_main');
			
			break;
			
			case 'addimage':
				$display_errors = "";
				if($param2=="cabinet")
				{
							$result = CheckPictureItemCabinet();
							if ($result == '0')
							{
								$display_errors .=  '<li>'.'Imaginea nu are una din extensiile acceptate!'.'</li>';
							}
							elseif ($result == '1')
							{
								$display_errors .= '<li>'. 'Pentru imagini va rugam respectati dimensiunile maxime admise!'.'</li>';
							}
				}
				elseif($param2=="harta")
				{
							$result = CheckPictureItemHarta();
							if ($result == '0')
							{
								$display_errors .=  '<li>'. 'Imaginea pentru harta nu are una din extensiile acceptate!'.'</li>';
							}
							elseif ($result == '1')
							{
							$display_errors .=  '<li>'.'Imagine harta - Va rugam respectati dimensiunile maxime admise!'.'</li>';
							}
				}
				else
				{
							$result = CheckPicture();
							if ($result == '0')
							{
								$display_errors .=  '<li>'. 'Imaginea pentru banner nu are una din extensiile acceptate!'.'</li>';
							}
							elseif ($result == '1')
							{
							$display_errors .=  '<li>'.'Imagine banner - Va rugam respectati dimensiunile maxime admise!'.'</li>';
							}
				
				}

				if($display_errors!="")
				{
					$_SESSION['message'] = $display_errors;
					header ('location: '.GetReferer());
					exit;
				}
				if($param2=="cabinet")
				{
					SavePicturesCabinete($param1,"backend" );

				}
				else
				{
					if ($_FILES['picture_5']['type'] != "" )
					{
						$extension = explode('/',$_FILES['picture_5']['type']);
						$file_extension = $extension[1];
						SavePicturesMap($file_extension, $param1,"backend" );
						unset($_FILES['picture_5']);
					}
				}
				GenerateSmallImages($param1);
				$_SESSION['admin_info_type'] = 'info';
				$_SESSION['admin_info'] = "Imagine adaugata cu succes !";
				header ('location: '.$_SERVER['HTTP_REFERER']);
				exit;
			break;

			case 'imagesdelete':
				if(isset($param1))
				{
					$image = GetCabinetImage($param1);
					$path_dir = "../images/users_cabinete/".$image['folder_id']."/".$image['image_name'];
					chmod($path_dir,0777);
					@unlink($path_dir);

					$sql = "DELETE FROM images WHERE id='".$param1."'";
					$db->query($sql);
					ReorderImagesPositions($image['folder_id']);
					$_SESSION['admin_info_type'] = 'info';
					$_SESSION['admin_info'] = "Imaginea a fost stearsa cu succes !";
					header ('location: '.$_SERVER['HTTP_REFERER']);
					exit;
				}
			break;
			case 'deletebanner':
				if(isset($param1))
				{
					$image = GetBanner($param1);
					$path_dir = "../images/banner/".$image['image_name'];
				//	echo $path_dir;
					chmod($path_dir,0777);
					@unlink($path_dir);

					$sql = "DELETE FROM banner WHERE cabinet_id='".$param1."'";
					$db->query($sql);
					$_SESSION['admin_info_type'] = 'info';
					$_SESSION['admin_info'] = "Imaginea a fost stearsa cu succes !";
					header ('location: '.$_SERVER['HTTP_REFERER']);
					exit;
				}
			break;

			case 'addbanner':
				## check banner file
				//print_r($_FILES['banner']);exit;
				$display_errors = "";
				if($_FILES['banner']['type']!="")
				{
					$result = CheckPicture($_FILES['banner']);
					if ($result == '0')
					{
						$display_errors.= '<li>Extensia imaginii pentru banner nu este acceptata !</li>';
					}
					elseif ($result == '1')
					{
						$display_errors.= '<li>Dimensiunea imaginii pentru banner este prea mare !</li>';
					}
				}
				else
				{
					$display_errors.= '<li>Nu ati selectat nici o imagine !</li>';
				}

				if($display_errors!="")
				{
					#let_put in sessions all infos from post in case we have errors
					$_SESSION['admin_info'] = $display_errors;
					$_SESSION['admin_info_type'] = 'info';
					$_SESSION['submit_firma']=array();
					foreach($_POST as $ky => $val)
					{
						$info = $ky ."=>".$val;	array_push($_SESSION['submit_firma'],$info);
					}
					header('location: '.GetReferer());
					exit;
				}

				### save the banner image
				saveBannerCabinet($param1);
				$_SESSION['submit_errors']='Y';
				$_SESSION['admin_info_type'] = 'info';
				$_SESSION['admin_info'] = "Bannerul a fost adaugat cu succes.";
				header('location: '.GetReferer());
				exit;
			break;
			case 'rearenge':
				$_SESSION['admin_info_type'] = 'info';
				$_SESSION['admin_info'] = "Pozitia imaginii in galerie a fost modificata cu succes !";
				$count_images = GetCabineteImages($param1);
				$nr_imagini_cabinet = count($count_images) ;
				foreach ($count_images as $key => $val)
				{
					if($val['type']=='harta')
					{
						$nr_imagini_cabinet = $nr_imagini_cabinet-1;
					}
				}
				//$new_dates = ReorderImagesNew($param3, $param1,$nr_imagini_cabinet);
				//RearrangeImagesNew($param2,$param3,$new_dates,$param1);

				$new_dates = ReorderImagesNew($param2, $param3,$nr_imagini_cabinet);
				RearrangeImagesNew($param1,$param2,$new_dates,$param3);
				header ('location: '.$_SERVER['HTTP_REFERER']);
			break;

			#we just change the status - recomanded, or not, we dont't make any changes in cabinete table
			#we must make some changes in recomandate table, to add the cabinet there
			case 'schimba':
				$status_curent_cabinet = $param1;
				$id_cabinet = $param2;
				
				$user_id = $param3;
				$judet_id = $param4;
				$type_id = $param5; 

				$perioada="14";
				$factura_id="";
				$loc="mijloc";
				$tip_promovare="site";
				$comment="";

				if($status_curent_cabinet=="NO")
				{
					$query= "Update cabinete set recomandata='Y' where id='".$id_cabinet."'";
					$newstatus = "Cabinet recomandat";
					$db->query($query);
					#we must insert information into recomandate database
					InsertToRecomandate($user_id,$id_cabinet,$comment,$judet_id,$type_id,$perioada,$factura_id,$loc,$tip_promovare);
				}
				else
				{
					$query= "Update cabinete set recomandata='N' where id='".$id_cabinet."'";
					$newstatus = "Cabinet nu mai este recomandat";
					$db->query($query);
					#we must delete information from recomandate database
					$query= "Delete from recomandate where user_id='".$user_id."' and firma_id='".$id_cabinet ."'";
					$db->query($query);
					

				}
				
				

				
				$_SESSION['admin_info_type'] = 'info';
				$_SESSION['admin_info'] = "Statusul cabinetului a fost schimbat in : <b> ".$newstatus ."</b>!";
				header ('location: '.$_SERVER['HTTP_REFERER']);exit;
			break;
			
		

			case 'generatemail':
				$tpl->set_file('tpl_main', $module.'/email_plata.tpl');
				$tpl->set_var('MAIN_TITLE', 'Genereaza e-mail plata');
				$cab_details = getCabinetDetails($param1);
				//print_r($cab_details );
				$tpl->set_var('START_DATE',TimeFormatEvents($cab_details['submision_date']) );
				$cat = getCabinetCategory($cab_details['category_id']);
				
				//$tpl->set_var('VISITS',number_format($cab_details['nr_visits'],0,',','.') );


				switch($cat)
				{
					case 'Cabinete stomatologice':
						$tpl->set_var('CABINET','Cabinetul Stomatologic '.$cab_details['nume_firma']);
					break;

					case 'Tehnica dentara':
						$tpl->set_var('CABINET','Laboratorul de Tehnica Dentara '.$cab_details['nume_firma']);
					break;

					case 'Radiologie Dentara':
						$tpl->set_var('CABINET','Laboratorul de Radiologie Dentara '.$cab_details['nume_firma']);
					break;

					case 'Distribuitori materiale':
						$tpl->set_var('CABINET','Depozitul de Materiale Stomatologice '.$cab_details['nume_firma']);
					break;

					case 'Clinici Stomatologice':
						$tpl->set_var('CABINET','Clinica Stomatologica '.$cab_details['nume_firma']);
					break;
				}

				$tpl->set_var('CATEGORY', $cat);
				//$tpl->set_var('LINK_CAB',ReWrite('cabinete_detalii', 'cabinete.detalii.'.$param1) );

				//$tpl->set_var('NR_MSGS',countCabinetMessages($param1) );

				$tpl->set_var('SITE',$cab_details['adresa_web']);
				$tpl->set_var('ADRESE_EMAIL',$cab_details['email_firma'].",".$cab_details['persc_email']);

				$tpl->parse('MAIN', 'tpl_main');
			break;

			case 'sendemailplata':
				$tpl->set_file('tpl_main', $module.'/send_email_plata.tpl');
				$cab_details = getCabinetDetails($param1);
				//print_r($cab_details );
				$tpl->set_var('START_DATE',TimeFormatEvents($cab_details['submision_date']) );
				//$cat = getCabinetCategory($cab_details['category_id']);
				//$tpl->set_var('ADRESE_EMAIL',$cab_details['email_firma'].",".$cab_details['persc_email']);
				$cat = getCabinetCategory($cab_details['category_id']);
				
				//$tpl->set_var('VISITS',number_format($cab_details['nr_visits'],0,',','.') );


				switch($cat)
				{
					case 'Cabinete stomatologice':
						$tpl->set_var('CABINET','Cabinetul Stomatologic '.$cab_details['nume_firma']);
					break;

					case 'Tehnica dentara':
						$tpl->set_var('CABINET','Laboratorul de Tehnica Dentara '.$cab_details['nume_firma']);
					break;

					case 'Radiologie Dentara':
						$tpl->set_var('CABINET','Laboratorul de Radiologie Dentara '.$cab_details['nume_firma']);
					break;

					case 'Distribuitori materiale':
						$tpl->set_var('CABINET','Depozitul de Materiale Stomatologice '.$cab_details['nume_firma']);
					break;

					case 'Clinici Stomatologice':
						$tpl->set_var('CABINET','Clinica Stomatologica '.$cab_details['nume_firma']);
					break;
				}

				//$tpl->set_var('CATEGORY', $cat);

				$tpl->parse('MAIN', 'tpl_main');
				$msg = $tpl->get_var('MAIN');
				//echo $msg;exit;

				$Sender = "DentistOnline<".$conf->contact_recipient.">";
				if($cab_details['persc_email']!=$cab_details['email_firma'] && $cab_details['persc_email']!="")
				{
					$Recipiant = $cab_details['email_firma'].",".$cab_details['persc_email'];
				}
				else
				{
					if($cab_details['email_firma']!="")
					{
						$Recipiant = $cab_details['email_firma'];
					}
					elseif($cab_details['email_firma']=="")
					{
						$Recipiant = $cab_details['persc_email'];
					}
					
				}
				## for testing;
				//$Recipiant = 'flavius_r2002@yahoo.com,rflavius@gmail.com';
				$CustomHeaders = '';
				$Subject = "Buna ziua";

				$message = new Email($Recipiant, $Sender, $Subject, $CustomHeaders);
				$message->SetHtmlContent($msg);
				if (ValidHeader($Sender))
				{
					$message->Send();
					//echo 'sent';exit;
					## redirect to the page where we activate the send mail status !!
					header("Location: index.php?page=cabinete.setemail.active.".$param1);
					exit;
				}
			break;
		}
	break;
}



?>