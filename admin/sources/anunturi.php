<?php
$pachete = new Pachete_Servicii($db);
switch ($action)
{
	case 'categories':
		switch ($param1)
		{
			case 'list_categories':
			$tpl->set_file('tpl_edit', 'anunturi/list_categories.tpl');
			$tpl->set_var('MAIN_TITLE', 'List and add anunturi categories');
			#set colors
			$tpl->set_var('BGCOLOR1', 'row1');$tpl->set_var('BGCOLOR2', 'row2');
			

			$tpl->set_block('tpl_edit', 'if_add_errors', 'if_add_errors_block');
			if (isset($_SESSION['add_category']))
			{
				$tpl->set_var('ADD_ERROR', $_SESSION['add_category']);
				$tpl->parse('if_add_errors_block', 'if_add_errors', true);
				unset($_SESSION['add_category']);
			}

			#the block for the article categories for this module and the error block
			$tpl->set_block('tpl_edit', 'list_categories', 'list_categories_block');
			$tpl->set_block('tpl_edit', 'if_categories', 'if_categories_block');
			$get_module_categories = GetAnunturiCategories('-1', '');
			if (count($get_module_categories) != '0')
			{
				$i = 0;
				while (list($k, $v) = each($get_module_categories))
				{
					#set colors
					$bc = ($i % 2)+1;
					$tpl->set_var("BGCOLOR", 'row'.$bc);
					$tpl->set_var('CAT_ID', $v['id']);
					$tpl->set_var('CAT_NAME', $v['name']);
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
			$tpl->set_var('MESSAGE', 'Add, edit and delete article module categories.');
			$tpl->parse('CATEGORY_INFORMATION', 'tpl_catinfo');
			$tpl->parse('MAIN', 'tpl_edit');
		break;
		
		case 'add':
			if ((trim($_POST['cat_name']) == "")||(!isset($_POST['cat_name'])))
			{
				$_SESSION['add_category'] = "Please provide a name for the category !";
				header ('location: ?page=anunturi.categories.list_categories');
				exit;
			}
			if (AnunturiCategoryExists($_POST['cat_name']))
			{
				$_SESSION['add_category'] = "Category already exists for this module !";
				header ('location: ?page=anunturi.categories.list_categories');
				exit;
			}
			
			#no errors - add the category and return with success message
			InsertAnunturiCategory($_POST['cat_name'],$_POST['meta_keywords'],$_POST['meta_description']);
			$_SESSION['add_category'] = "Category added successfully !";
			header ('location: ?page=anunturi.categories.list_categories');
			exit;
		break;

		case 'delete':
			$query = "DELETE FROM anunturi_categories WHERE id_cat = '".intval($param2)."'";
			$db->query($query);
			$_SESSION['add_category'] = "Category successfully deleted !";
			header ('location: '.$_SERVER['HTTP_REFERER']);
			exit;
		break;

		case 'set':
			switch ($param2)
			{
				case 'active':
					$status = 'Y';
				break;

				case 'inactive':
					$status = 'N';
				break;
			}
				$query = "UPDATE anunturi_categories SET active = '".$status."'
									WHERE id_cat = '".$param3."'";
				$db->query($query);
			$_SESSION['add_category'] = "Category status successfully changed !";
			header ('location: '.$_SERVER['HTTP_REFERER']);
			exit;
		break;

		case 'edit':
			$tpl->set_file('tpl_categories', 'anunturi/edit_cat.tpl');
			$tpl->set_var('MAIN_TITLE', 'Edit Category');
			$tpl->set_block('tpl_categories', 'if_errors', 'if_errorss');
			#for the form
			$tpl->set_var('ID', $param2);
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
				$tpl->parse('if_errorss', 'if_errors', true);
			}
			
			$get_cat_info = GetAnunturiCategoryInfos($param2) ;
			
			$tpl->set_var('CAT_NAME', $get_cat_info['name']);
			$tpl->set_var('META_KEYWORDS', $get_cat_info['meta_keywords']);
			$tpl->set_var('META_DESCRIPTION', $get_cat_info['meta_description']);

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
			SaveAnunturiCategory($_POST['cat_name'],$_POST['meta_keywords'],$_POST['meta_description'], $param2);
			$_SESSION['admin_info'] = "Category changes successfully saved !";
			$_SESSION['admin_info_type'] = 'info';
			header ('location: ?page=anunturi.categories.list_categories');
			exit;
		break;
		}
	break;
	case 'add':
			$tpl->set_file('tpl_main', 'anunturi/adaugaanunt.tpl');
			$tpl->set_block('tpl_main', 'display_cats', 'display_catss');
			$tpl->set_block('tpl_main', 'judet', 'judett');
			$tpl->set_var('MAIN_TITLE',"Adauga anunt" );
			$tpl->set_var('LOC_DIV_ADAUGAFIRMA',"Alegeti judetul intai!" );

			$tpl->set_var('MAX_PICTURE_WIDTH',$conf->max_img_anunt );
			$tpl->set_var('INSERT_ANUNT',"?page=anunturi.insert" );
			$tpl->set_var('META_KEYWORDS', $conf->def_meta_keywords);
			$tpl->set_var('META_DESCRIPTION', $conf->def_meta_description);
			$tpl->set_var('BGCOLOR1',"row1" );		$tpl->set_var('BGCOLOR2',"row2" );

			#get judetet
			$get_dentist_judete = GetJudete();
			foreach($get_dentist_judete as $ky => $val)
			{
				$tpl->set_var('COD_JUDET',$val['code'] );
				$tpl->set_var('NUMEJUDET',$val['name'] );
				$tpl->parse('judett', 'judet', true);
			}

			#get dentist cats
			$get_dentist_categ = GetAnunturiCategories('-1', '');
			foreach($get_dentist_categ as $kky => $vall)
			{
				$tpl->set_var('CAT_NAME',$vall['name'] );
				$tpl->set_var('CAT_ID',$vall['id'] );
				$tpl->parse('display_catss', 'display_cats', true);
			}
			
			#display error
			if (isset($_SESSION['submit_errors']))
			{
				$tpl->set_var("ERROR_MSG", $_SESSION['submit_errors']);
				unset($_SESSION['submit_errors']);
				$tpl->parse("error_block", "error", true);
			}
			#fill fields
			if (isset($_SESSION['submit_anunt']))
			{
				foreach ($_SESSION['submit_anunt'] as $key => $val)
				{
						$values = explode("=>",$val);
						if($values[0]=="judet")
						{	$tpl->set_var(strtoupper($values[0]), "selected"); }
						else
						{	$tpl->set_var(strtoupper($values[0]), $values[1]); }
				}
				unset($_SESSION['submit_anunt']);
			}
			$tpl->parse('MAIN', 'tpl_main', true);
	break;

	case 'insert':
		$display_errors ="";
		if($_POST['titlu']=="")
		{	$display_errors = " <li> Ati uitat sa complectati titlul anuntutlui </li>";	}
		
		if($_POST['continut']=="")
		{	$display_errors .= " <li>Ati uitat sa complectati descrierea anuntului </li>";}

		if($_POST['autor']=="")
		{		$display_errors = " <li> Ati uitat sa complectati autorul anuntutlui </li>";	}
		
		if($_POST['judet']=="")
		{		$display_errors = " <li> Ati uitat sa complectati judetul  </li>";	}
		
		if (array_key_exists('nume_loc_sector', $_POST)===FALSE) 
		{	$display_errors .= "<li>Ati uitat sa complectati localitatea.</li>"; }

		if(isset($_POST['email']) && ($_POST['email']!=""))
		{				$email = ValidEmail($_POST['email']);
			if(!$email)
				{	$display_errors .="<li>Adresa de email este invalida</li>";	}
		}

		if ($_FILES['imagine']['type']!= "")
		{
			$result =  CheckPictureItemAnunt();
			if ($result == '0')
			{	$display_errors .=  '<li>'.'Imaginea pentru anunt nu are una din extensiile acceptate!'.'</li>';}
			elseif ($result == '1')
			{	$display_errors .= '<li>'. 'Imagine anunt - Va rugam respectati dimensiunile maxime admise!'.'</li>';	}
		}
		if($display_errors!="")
		{		
				#let_put in sessions all infos from post in case we have errors
				$_SESSION['submit_errors'] = $display_errors;
				$_SESSION['submit_anunt']=array();
				foreach($_POST as $ky => $val)
				{
					$info = $ky ."=>".$val;	array_push($_SESSION['submit_anunt'],$info);
				}
				header('location: '.GetReferer());
				exit;
		}
		$user_id = "-1";
		#lets remove link form content:D
		$_POST['continut'] = RemoveAHref($_POST['continut']);
		
		$id_anunt =InsertAnunt($user_id, $_POST['titlu'], $_POST['continut'], $_POST['category_id'],$_POST['autor'],$_POST['email'],$_POST['judet'],$_POST['nume_loc_sector'],$_POST['meta_keywords'],$_POST['meta_description']);
		#daca avem setata poza pt cabinet o salvam
			if ($_FILES['imagine']['type'] != "" )
			{
				$extension = explode('/',$_FILES['imagine']['type']);
				$file_extension = $extension[1];
				SavePicturesAnunturi($file_extension, $id_anunt,"backend" );
				Generate_Small_Images_Anunt($user_id, $id_anunt);
			}
			else
			{
				SavePicturesAnunturi("default", $id_anunt,"backend" );
			}
			
			$_SESSION['admin_info_type'] = 'info';
			$_SESSION['admin_info'] = "Anuntul a fost adugat cu succes!";
		header('location: ?page=anunturi.list');exit;
	break;
	
	
	
	case 'list':
		$tpl->set_file('tpl_list', 'anunturi/list.tpl');
		$tpl->set_var('MAIN_TITLE', 'Listeaza anunturi');
		$tpl->set_block('tpl_list', 'list_anunturi', 'list_anunturi_block');
		$tpl->set_block('tpl_list', 'if_anunturi', 'if_anunturi_block');
		$tpl->set_block('tpl_list', 'no_anunturi', 'no_anunturi_block');
		$tpl->set_block('tpl_list', 'bigcat', 'bigcat_block');

		if($param1=="")
		{			$param1="all";	}

		if($param2=="")
		{			$param2="all";	}
		$tpl->set_var("SELECTED".strtoupper($param2),"selected" );

		$total_records = CountAnunturi($param1,$param2);
		$get_dentist_cats = GetAnunturiCategories('-1', '');
		foreach($get_dentist_cats as $ky => $val)
		{
			$tpl->set_var('CAT_ID',$val['id'] );
			$tpl->set_var('CAT_NAME', $val['name']);
			if($val['id']==$param1)
			{		$tpl->set_var('SELECTED_CAT',"selected" );	}
			else
			{		$tpl->set_var('SELECTED_CAT'," " );	}
			$tpl->parse('bigcat_block', 'bigcat', true);
		}

		#cabinete count
		$tpl->set_var('COUNT_ANUNTURI', $total_records);
		$pages_number = ceil($total_records/$conf->admin_cabinete_per_page);
		$tpl->set_var("PAGES", $pages_number);
		#create de pagination page_name
		$page_name = $module.'.'.$action;
		if ($param1 != '')
		{
			$page_name = $page_name.'.'.$param1;
		}
		if ($param2 != '')
		{
			$page_name = $page_name.'.'.$param2;
		}

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

		if(!isset($start))
		{	$start_q = 0;	$start = 1;	}
		else
		{		$start_q = $conf->admin_cabinete_per_page*($start-1);	}

		if(isset($_GET['displaymode'])&&($_GET['displaymode']!=""))
		{
				$dispmode = $_GET['displaymode'];
		}
		 else
		{
			$dispmode = "data-data_adaugarii-DESC";
		}

		#Create and parse pagination
		$html_pages = AdminPaginationCabineteAnuntArticole($conf->admin_cabinete_per_page, $total_records, $page_name, $start,$dispmode);
		$tpl->set_var("PAGINATION", $html_pages);
		$tpl->set_var("PAGE_NAME",$page_name );
		
		#Create query limit and get the cabinete for displaing
		$query_limit = " LIMIT $start_q, $conf->admin_cabinete_per_page";
		$get_anunturi = GetAnunturiByCat($param1,$param2,$dispmode,$query_limit);
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
				
				$tpl->set_var('LINK_TO_ANUNT',  ReWrite('anunturi_detalii', 'anunturi.detalii.'.$v['id']));
				$tpl->set_var('ID', $v['id']);
				$tpl->set_var('CONTENT',text_best_fit($v['continut'],150));
				$tpl->set_var('TITLU', $v['titlu']);
				$tpl->set_var('COMMENTS', $v['comments']);
				$tpl->set_var('NR_VISITS',$v['nr_visits'] );
				$tpl->set_var('THUMBNAILS', "../sources/thumbnails.php?target=".$v['imagine'].'&max_size='.$conf->admin_gallery_max.'&anunturi=yes');
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

					/*here we display if pays or not*/
					$user_pachet = $pachete->getTipPromovareByUser($v['user_id']);
					$get_tip_promovare = "";
					if(is_array($user_pachet))
					{
						
						$pkInfo = $pachete->getPachetInfo($user_pachet['pachet']);
						$get_tip_promovare = $pkInfo['name']." - ".$user_pachet['pret']." RON";
					}
					$tpl->set_var('LEVEL',$get_tip_promovare);
					
				}

				$tpl->set_var('DATE_EXP',AdminTimeFormat( $v['data_expirarii'],'Y'));
				$tpl->set_var('DATE_ADDED',AdminTimeFormat($v['data_adaugarii'],'Y'));
				$tpl->set_var('DATE_MOD', AdminTimeFormat($v['data_modificarii'],'Y'));
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
			$tpl->parse('if_anunturi_block', 'if_anunturi', true);
		}
		else 
		{
			$tpl->parse('no_anunturi_block', 'no_anunturi', true);
		}
		$tpl->parse('MAIN', 'tpl_list');

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
	
	case 'recomandate':
		$tpl->set_file('tpl_list', 'anunturi/list_recomandate.tpl');
		$tpl->set_var('MAIN_TITLE', 'Listeaza anunturi');
		$tpl->set_block('tpl_list', 'list_anunturi', 'list_anunturi_block');
		$tpl->set_block('tpl_list', 'if_anunturi', 'if_anunturi_block');
		$tpl->set_block('tpl_list', 'no_anunturi', 'no_anunturi_block');
		$tpl->set_block('tpl_list', 'bigcat', 'bigcat_block');

		if($param1=="")
		{			$param1="all";	}

		if($param2=="")
		{			$param2="all";	}

		$tpl->set_var("SELECTED".strtoupper($param2),"selected" );

		$total_records = CountAnunturi($param1,$param2);
		$get_dentist_cats = GetAnunturiCategories('-1', '');
		foreach($get_dentist_cats as $ky => $val)
		{
			$tpl->set_var('CAT_ID',$val['id'] );
			$tpl->set_var('CAT_NAME', $val['name']);
			if($val['id']==$param1)
			{		$tpl->set_var('SELECTED_CAT',"selected" );	}
			else
			{		$tpl->set_var('SELECTED_CAT'," " );	}
			$tpl->parse('bigcat_block', 'bigcat', true);
		}

		#cabinete count
		$tpl->set_var('COUNT_ANUNTURI', $total_records);
		$pages_number = ceil($total_records/$conf->admin_cabinete_per_page);
		$tpl->set_var("PAGES", $pages_number);
		#create de pagination page_name
		$page_name = $module.'.'.$action;
		if ($param1 != '')
		{
			$page_name = $page_name.'.'.$param1;
		}
		if ($param2 != '')
		{
			$page_name = $page_name.'.'.$param2;
		}
		//echo "param 2 este:". $param2;

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

		if(!isset($start))
		{	$start_q = 0;	$start = 1;	}
		else
		{		$start_q = $conf->admin_cabinete_per_page*($start-1);	}

		if(isset($_GET['displaymode'])&&($_GET['displaymode']!=""))
		{
				$dispmode = $_GET['displaymode'];
		}
		 else
		{
			$dispmode = "data-data_adaugarii-DESC";
		}

		#Create and parse pagination
		$html_pages = AdminPaginationCabineteAnuntArticole($conf->admin_cabinete_per_page, $total_records, $page_name, $start,$dispmode);
		$tpl->set_var("PAGINATION", $html_pages);
		$tpl->set_var("PAGE_NAME",$page_name );
		
		#Create query limit and get the cabinete for displaing
		$query_limit = " LIMIT $start_q, $conf->admin_cabinete_per_page";
		
		//$get_anunturi = GetAnunturiByCat($param1,$param2,$dispmode,$query_limit);
		$get_anunturi = GetRecomandateAnunturiByCat($param1,$param2,$dispmode,$query_limit);
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
				
				$tpl->set_var('LINK_TO_ANUNT',  ReWrite('anunturi_detalii', 'anunturi.detalii.'.$v['id']));
				$tpl->set_var('ID', $v['id']);
				$tpl->set_var('CONTENT',text_best_fit($v['continut'],150));
				$tpl->set_var('TITLU', $v['titlu']);
				$tpl->set_var('COMMENTS', $v['comments']);
				$tpl->set_var('NR_VISITS',$v['nr_visits'] );
				$tpl->set_var('THUMBNAILS', "../sources/thumbnails.php?target=".$v['imagine'].'&max_size='.$conf->admin_gallery_max.'&anunturi=yes');
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

					/*here we display if pays or not*/
					$user_pachet = $pachete->getTipPromovareByUser($v['user_id']);
					$get_tip_promovare = "";
					if(is_array($user_pachet))
					{
						
						$pkInfo = $pachete->getPachetInfo($user_pachet['pachet']);
						$get_tip_promovare = $pkInfo['name']." - ".$user_pachet['pret']." RON";
					}
					$tpl->set_var('LEVEL',$get_tip_promovare);
					
				}

				$tpl->set_var('DATE_EXP',AdminTimeFormat( $v['data_expirarii'],'Y'));
				$tpl->set_var('DATE_ADDED',AdminTimeFormat($v['data_adaugarii'],'Y'));
				$tpl->set_var('DATE_MOD', AdminTimeFormat($v['data_modificarii'],'Y'));
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

				
				if ($v['show_first_page'] == '1')
				{
					$tpl->set_var('IMAGE_REC', 'active.png');
					$tpl->set_var('IMAGE_REC_TITLE', 'inactive');
				}
				else 
				{
					$tpl->set_var('IMAGE_REC', 'inactive.png');
					$tpl->set_var('IMAGE_REC_TITLE', 'active');
				}


			
				$tpl->parse('list_anunturi_block', 'list_anunturi', true);
				$i++;
			}
			$tpl->parse('if_anunturi_block', 'if_anunturi', true);
		}
		else 
		{
			$tpl->parse('no_anunturi_block', 'no_anunturi', true);
		}
		$tpl->parse('MAIN', 'tpl_list');

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
	case 'edit':
			$tpl->set_file('tpl_main', 'anunturi/edit_anunt.tpl');
			$tpl->set_block('tpl_main', 'display_cats', 'display_catss');
			$tpl->set_block('tpl_main', 'judet', 'judett');

			$tpl->set_var('UPDATE_ANUNT',"?page=anunturi.update.".$param1 );
			$tpl->set_var('MAX_PICTURE_WIDTH',$conf->max_img_anunt );
			$tpl->set_var('BGCOLOR1',"row1" );$tpl->set_var('BGCOLOR2',"row2" );
			$tpl->set_var('ID_ANUNT',$param1);
			$tpl->set_var('ID_USER',$param2 );

			$user_id = $param2; $id_anunt = $param1;
			$get_anunturi = GetAnunturi($user_id,$id_anunt);
			
			$tpl->set_var('MAIN_TITLE',"Editeaza anuntul ". $get_anunturi[0]['titlu'] );
			$tpl->set_var('SUBMISION_DATE',$get_anunturi[0]['data_adaugarii']);
			$tpl->set_var('EXPIRE_DATE',substr($get_anunturi[0]['data_expirarii'],0,10));
			$tpl->set_var('TITLU', $get_anunturi[0]['titlu']);
			$tpl->set_var('CONTINUT', $get_anunturi[0]['continut']);
			$tpl->set_var('ALIAS', $get_anunturi[0]['alias']);
			$tpl->set_var('AUTOR', $get_anunturi[0]['autor']);
			$tpl->set_var('EMAIL', $get_anunturi[0]['email']);
			$tpl->set_var('NR_VISITS', $get_anunturi[0]['nr_visits']);

			$tpl->set_var('COMMENTS_TEXT', $get_anunturi[0]['comments']);
			$tpl->set_var('META_KEYWORDS', $get_anunturi[0]['meta_keywords']);
			$tpl->set_var('META_DESCRIPTION', $get_anunturi[0]['meta_description']);
			$tpl->set_var('NUME_IMAGINE',$get_anunturi[0]['imagine']);

			$tpl->set_var('THUMBNAIL', "../sources/thumbnails.php?target=".$get_anunturi[0]['imagine'].'&max_size='.$conf->admin_gallery_max.'&anunturi=yes');
			$filename = '../images/smallimages/anunturi/'.$get_anunturi[0]['imagine'];
			if (!file_exists($filename)) 
			{
				echo '<img src="http://www.dentistonline.ro/upload_js/resize_image_thumb.inc.php?what_to_resize=anunturi&width=80&height=80&cropratio=1:1&image=//images/users_anunturi/'.$get_anunturi[0]['imagine'].'">';
			}

		
				if($get_anunturi[0]['status']=='0')
				{
					$tpl->set_var('EMAILACTIVARE', " Emailul de activare a cabinetului nu a fost trimis!!");
				}
				else
				{
				$tpl->set_var('EMAILACTIVARE', " ");
				}
			#parse judete and loclitati
			$cod_judet = $get_anunturi[0]['judet'];
			$get_dentist_judete = GetJudete();
			foreach($get_dentist_judete as $kky => $vval)
			{
				if($cod_judet==$vval['code'])
				{	$tpl->set_var('JUDET',"selected" );	}
				else
				{	$tpl->set_var('JUDET',"" );	}

				$tpl->set_var('COD_JUDET',$vval['code'] );
				$tpl->set_var('NUMEJUDET',$vval['name'] );
				$tpl->parse('judett', 'judet', true);
			}
			$tpl->set_file("tpl_search_ajax","../modules/search/localitati_ajax_faratoate.tpl");
			$tpl->set_block('tpl_search_ajax', 'loocalitati', 'loocalitatii');

			$get_dentist_localitati = GetLocalitati($cod_judet);
			foreach($get_dentist_localitati as $kyy => $vaal)
			{
				if($get_anunturi[0]['localitate'] == $vaal['id'])
				{	$tpl->set_var('SELECTED_LOC',"selected" );	}
				else
				{	$tpl->set_var('SELECTED_LOC',"" );	}

				$tpl->set_var('ID_LOCALITATE',$vaal['id'] );
				$tpl->set_var('NUMELOCALITATE',$vaal['name'] );
				$tpl->parse('loocalitatii', 'loocalitati', true);
			}
			$tpl->parse('LOC_DIV_ADAUGAFIRMA','tpl_search_ajax');


			
			$get_dentist_categ = GetAnunturiCategories('-1', '');
			foreach($get_dentist_categ as $kky => $vall)
			{
				if($vall['id']==$get_anunturi[0]['category_id'])
				{		$tpl->set_var('SELECTTEDCAT',"selected" );	}
				else
				{	$tpl->set_var('SELECTTEDCAT'," " );	}

				$tpl->set_var('CAT_ID',$vall['id'] );
				$tpl->set_var('CAT_NAME',$vall['name'] );
				$tpl->parse('display_catss', 'display_cats', true);
			}


			#this is for erros block
		if (isset($_SESSION['submit_errors']))
		{
			$tpl->set_var("ERROR_MSG", $_SESSION['submit_errors']);
			unset($_SESSION['submit_errors']);
			$tpl->parse("error_block", "error", true);
		}
		#fill fields
		if (isset($_SESSION['update_anunt']))
		{
			foreach ($_SESSION['update_anunt'] as $key => $val)
			{
					$values = explode("=>",$val);
					if($values[0]=="category_id")
					{	$tpl->set_var(strtoupper($values[0]), "selected");	}
					elseif($values[0]=="judet")
					{		$tpl->set_var(strtoupper($values[0]), "selected");	}
					else
					{		$tpl->set_var(strtoupper($values[0]), $values[1]);}
			}
			unset($_SESSION['update_anunt']);
		}
			$tpl->parse('MAIN', 'tpl_main', true);
		break;

	case 'update':
		$display_errors ="";
		if($_POST['titlu']=="")
		{
			$display_errors = " <li> Ati uitat sa complectati titlul anuntutlui </li>";
		}
		if($_POST['continut']=="")
		{
			$display_errors .= " <li>Ati uitat sa complectati descrierea anuntului </li>";
		}
		if($_POST['autor']=="")
		{		$display_errors = " <li> Ati uitat sa complectati autorul anuntutlui </li>";	}

		if (array_key_exists('nume_loc_sector', $_POST)===FALSE) 
		{		$display_errors .= '<li>Ati uitat sa complectati localitatea.<li>'; }

		if ((isset($_POST['email']))&&($_POST['email']!=""))
		{
			$email = ValidEmail($_POST['email']);
			if(!$email)
				{	$display_errors .="<li>Adresa de email este invalida</li>";	}
		}
		if($_POST['judet']=="")
		{		$display_errors = " <li> Ati uitat sa complectati judetul  </li>";	}
		#this is the image for anunt
		if ($_FILES['imagine']['type']!= "")
		{
			$result =  CheckPictureItemAnunt();
			if ($result == '0')
			{
				$display_errors .=  '<li>'.'Imaginea pentru anunt nu are una din extensiile acceptate!'.'</li>';
			}
			/*elseif ($result == '1')
			{
				$display_errors .= '<li>'. 'Imagine anunt - Va rugam respectati dimensiunile maxime admise!'.'</li>';
			}*/
		}
		if($display_errors!="")
		{		
				#let_put in sessions all infos from post in case we have errors
				$_SESSION['submit_errors'] = $display_errors;
				$_SESSION['update_anunt']=array();
				foreach($_POST as $ky => $val)
				{
					$info = $ky ."=>".$val;	array_push($_SESSION['update_anunt'],$info);
				}
				header('location: '.GetReferer());
				exit;
		}
		$id_anunt = $param1;	
		UpdateAnunt($param1, $_POST['titlu'], $_POST['continut'], $_POST['category_id'],$_POST['autor'],$_POST['email'],$_POST['judet'],$_POST['nume_loc_sector'],$_POST['meta_keywords'],$_POST['meta_description'],$_POST['comments']);

		$update_alias_name = $_POST['alias'];
		$query="Update anunturi set alias='".addslashes($update_alias_name)."' WHERE id='".$id_anunt."'";
		$db->query($query);
		
		#daca avem setata poza pt anunt o salvam
		if ($_FILES['imagine']['type'] != "" )
		{
			$extension = explode('/',$_FILES['imagine']['type']);
			$file_extension = $extension[1];//echo "extenis:".$file_extension;
			SavePicturesAnunturi($file_extension, $id_anunt,"backend" );

		}

		#modificam numele imagini doar daca e diferit de ce e in baza de date
		if ($_POST['nume_img_vechi']!= $_POST['nume_imagine'])
		{
			$_POST['nume_imagine']= GenerateImageNameAnunturi($_POST['nume_imagine']);
			Update_Image_Name_Anunturi($id_anunt,addslashes($_POST['nume_imagine']),addslashes($_POST['nume_img_vechi']));	
		}
		Generate_Small_Images_Anunt($param2, $id_anunt);
		$_SESSION['admin_info_type'] = 'info';
		$_SESSION['admin_info'] = "Anuntul a fost modificat cu succes!";
		header('location: '.GetReferer());exit;
	break;

	case 'set':
		$_SESSION['admin_info'] = 'Status successfully saved !';
		$_SESSION['admin_info_type'] = 'info';
		switch ($param1)
		{
			case 'active':
				$query = "UPDATE anunturi SET status = '1' WHERE id = '".intval($param2)."'";
				$db->query($query);
			break;

			case 'inactive':
				$query = "UPDATE anunturi SET status = '0' WHERE id = '".intval($param2)."'";
				$db->query($query);
			break;
		}
		header ('location: ?page=anunturi.list');
		exit;
	break;

	case 'set_recomandat':
		$_SESSION['admin_info'] = 'Status successfully saved !';
		$_SESSION['admin_info_type'] = 'info';
		switch ($param1)
		{
			case 'active':
				$query = "UPDATE anunturi SET show_first_page = '1' WHERE id = '".intval($param2)."'";
				$db->query($query);
			break;

			case 'inactive':
				$query = "UPDATE anunturi SET show_first_page = '0' WHERE id = '".intval($param2)."'";
				$db->query($query);
			break;
		}
		header('location: '.GetReferer());
		exit;
	break;


	case 'sendemail':
		$id_anunt = $param1;$user_id = $param2;$CustomHeaders = '';
		$linkfirma = ReWrite("anunturi_detalii","anunturi.detalii.".$id_anunt);
		$Sender = $conf->contact_recipient;
		if(!isset($_POST['emaill'] )||($_POST['emaill'] ==""))
		{			$Recipiant = GetAutorEmail($user_id);		}
		else
		{			$Recipiant = $_POST['emaill'] ;		}
		
		
		$text = GetFileContent("../templates/emails/".$_POST['emailform'].".tpl");
		switch($_POST['emailform'])
		{
			
			case 'anunt_activat':
				$text = str_replace("%NUMEPERSOANA%",	$_POST['autorr'] , $text);
				$text = str_replace("%NUMEFIRMA%",ucfirst($_POST['titluu']),$text);
				$text = str_replace("%DATAEXPIRARII%",date("d/m/Y", mktime(0, 0, 0, date("m")+6, date("d"), date("Y"))),$text);
				$text = str_replace("%LINKFIRMA%",$linkfirma,$text);
				$Subject = "Anuntul ".ucfirst($_POST['titluu'])." este activ pe DentistOnline.ro";	
				$_SESSION['submit_errors'] = "<li>Emailul de activare a anuntului a fost trimis cu succes!</li>";
				$query = "Update anunturi set status='1' Where id='".$param1."'";
				$db->query($query);
			break;
		
			case 'anunt_dezactivat':
					$text = str_replace("%NUMEPERSOANA%",$_POST['autorr'], $text);
					$text = str_replace("%NUMEFIRMA%",ucfirst($_POST['titluu']),$text);
					$Subject ="Anuntul ".ucfirst($_POST['titluu'])." este inactiv pe DentistOnline.ro";
					$_SESSION['submit_errors'] = "<li>Emailul de dezactivare a anuntului a fost trimis cu succes!</li>";
					$query="Update anunturi set status='0' Where id='".$param1."'";
					$db->query($query);
			break;
		}

		$message = new Email($Recipiant, $Sender, $Subject, $CustomHeaders);
		$message->SetHtmlContent($text);
		if (ValidHeader($Sender))
		{
			$message->Send();
		}
		
		header('location: ?page=anunturi.edit.'.$param1.".".$param2);
		exit;
		
	break;
}
?>