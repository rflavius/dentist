<?php 
/*
 * here we wil have all things regarding new account
 */

$conf->admin_gallery_max="150";


set_time_limit(0);
ini_set('memory_limit', '256M');

//ini_set('display_errors', '1');
$size = ini_get('upload_max_filesize');
$conf->max_video_size=$size;
$pk = new Pachete_Servicii($db);

switch($action)
{
	default:
		$tpl->set_file('tpl_main','firma/step1.tpl');
		$tpl->set_var('SITE_BASEE', SITE_BASE);
		$tpl->set_block('tpl_main', 'display_cats', 'display_catss');
		$tpl->set_block('tpl_main', 'judet', 'judett');
		$tpl->set_block('tpl_main', 'ADD_FIRM_BLOCK', 'ADD_FIRM_BLOCKK');
		$tpl->set_block('tpl_main', 'fara_cabinet', 'fara_cabinet_block');
		$tpl->set_var('LOC_DIV_ADAUGAFIRMA',"Alegeti judetul intai!" );
		$tpl->set_var('MAX_PICTURE_WIDTH',$conf->max_img_cabinete);
		$tpl->set_var('DETALIIADAUGAFIRMA','?page=user.detaliiadaugafirma');
		$tpl->set_var('USERNAME',$_SESSION['userinfo']->username." - " );
		$user_id  = $_SESSION['userinfo']->id;
		$get_firme = GetFirme($user_id,"-1");
		$get_dentist_categ = Get_Dentist_Cats('-1');
		//print_r($_SESSION['submit_firma']);
		foreach($get_dentist_categ as $ky => $val)
		{
			if(isset($_SESSION['submit_firma'][0])&&($_SESSION['submit_firma'][0]!=""))
			{
				$values = explode("=>",$_SESSION['submit_firma'][0]);
				if($values[1]==$val['id'] )
				{
					$tpl->set_var('SELECTTEDCAT',"selected");
				}
				else
				{
					$tpl->set_var('SELECTTEDCAT',"");
				}
			}
			$tpl->set_var('CAT_NAME',$val['name'] );
			$tpl->set_var('CAT_ID',$val['id'] );
			$tpl->parse('display_catss', 'display_cats', true);
		}
		
		$tpl->parse('fara_cabinet_block', 'fara_cabinet', true);
		$get_dentist_judete = GetJudete();
		
		foreach($get_dentist_judete as $ky => $val)
		{
			if(isset($_SESSION['submit_firma'][3])&&($_SESSION['submit_firma'][3]!=""))
			{
				$values = explode("=>",$_SESSION['submit_firma'][3]);
				$judt_code = $values[1];
				if(strtolower($values[1])==strtolower($val['code']) )
				{
					$tpl->set_var('SELECTTEDJUDET',"selected");
				}
				else
				{
					$tpl->set_var('SELECTTEDJUDET',"");
				}
			}
			$tpl->set_var('COD_JUDET',$val['code'] );
			$tpl->set_var('NUMEJUDET',$val['name'] );
			$tpl->parse('judett', 'judet', true);
		}
		
		if(isset($_SESSION['submit_firma'][4])&&($_SESSION['submit_firma'][4])!="")
		{
			$tpl->set_file("tpl_loc_ajax","../modules/search/localitati_ajax_faratoate.tpl");
			$tpl->set_block('tpl_loc_ajax', 'loocalitati', 'loocalitatii');
			$cod_judet = $judt_code;
			$get_dentist_localitati = GetLocalitati($cod_judet);
			$values = explode("=>",$_SESSION['submit_firma'][4]);
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
		
		#if we have information messages
		if (isset($_SESSION['admin_info'])&&($_SESSION['admin_info']!=""))
		{
			$tpl->set_file('tpl_info', '../admin/info/'.$_SESSION['admin_info_type'].'.tpl');
			$tpl->set_var('MESSAGE', $_SESSION['admin_info']);
			$tpl->parse('ERROR_MSG', 'tpl_info');
			#uset sessions
			unset($_SESSION['admin_info']);
			unset($_SESSION['admin_info_type']);
		}
		
		#fill fields
		if (isset($_SESSION['submit_firma']))
		{
			foreach ($_SESSION['submit_firma'] as $key => $val)
			{
				$values = explode("=>",$val);
				if($values[0]=="judet")
				{
					$tpl->set_var(strtoupper($values[0]), "selected");
				}
				elseif($values[0]=="perioada")
				{
					$tpl->set_var('SELECTED_'.$values[1],"selected" );
				}
				elseif($values[0]=="type")
				{
					if(($values[1]!="none")&&($values[1]!=""))
					{
						$tpl->set_var('SELECTED_'.strtoupper($values[1]),"selected" );
						$tpl->set_file("tpl_formplace","user/".$values[1].".tpl");
						$tpl->parse('LOC_FORM_PLACE','tpl_formplace');
					}
				}
				else
				{
					$tpl->set_var(strtoupper($values[0]), $values[1]);
				}
			}
			unset($_SESSION['submit_firma']);
		}
		$tpl->set_var('INSERT_FIRMA',"?page=firma.addstep1");
		$tpl->parse('ADD_FIRM_BLOCKK', 'ADD_FIRM_BLOCK', true);
		
		$tpl->parse('MAIN','tpl_main');
	break;
	
	case 'addstep1':
		$array_obligatorii = array(
									"category_id"=>"Categoria nu e setata",
									"nume_firma"=>"Numele firmei nu e setat ",
									"adresa_firma"=>"Adresa firmei nu e setata",
									"judet"=>"Judetul nu e setat",
									"nume_loc_sector"=>"Localitate/sector nu e setat",
									"orar"=>"Nu aveti orar",
									"pers_contact"=>"Persoana de contact nu e setata",
									"persc_email"=>"Adresa de email persoana contact nu e setata",
									"descriere"=>"Descrierea nu e setata");
		$display_errors = '';
		foreach($_POST as $ky => $val)
		{
			if((array_key_exists($ky,$array_obligatorii))&&($val==""))
			{
				$display_errors .= '<li>'. $array_obligatorii[$ky].'.</li>';
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
			{
				$display_errors .="<li>Adresa de e-mail a persoanei de contact este invalida.</li>";
			}
		}
		
		if(isset($_POST['adresa_web'])&&($_POST['adresa_web']!=""))
		{
			$url = ValidateURL($_POST['adresa_web']);
			if(!$url)
			{
				$display_errors .="<li>Adresa web este incorecta.</li>";
			}
		}
		if(isset($_POST['email_firma'])&&($_POST['email_firma']!=""))
		{
			$url = ValidEmail($_POST['email_firma']);
			if(!$url)
			{
				$display_errors .="<li>Adresa de e-mail a firmei este invalida.</li>";
			}
		}

		if($display_errors!="")
		{
			#let_put in sessions all infos from post in case we have errors
			$_SESSION['submit_errors'] = $display_errors;
			$_SESSION['submit_firma']=array();
			foreach($_POST as $ky => $val)
			{
				$info = $ky ."=>".$val;
				array_push($_SESSION['admin_info'],$info);
			}
			$_SESSION['admin_info_type'] = 'error';
			header('location: '.GetReferer());
			exit;
		}
		
		
		$user_id = $_SESSION['userinfo']->id;
		array_pop($_POST);
		#insert infos about cabinet ,we take the id of cabinet
		$type = $_POST['type'];
		$id_some_info = InsertPartFromFirma($_POST['nume_firma'],$user_id,$type,1);
		
		$pk->addCabinetCoords($id_some_info);
		
		$i=0;
		foreach($_POST as $ky => $val)
		{
			if(strpos($ky,"caractere")!==FALSE || strpos($ky,"lat")!==FALSE || strpos($ky,"lng")!==FALSE || strpos($ky,"address")!==FALSE)
			{
				unset($_POST[$ky]);
			}
			else
			{
				if($i==0)
				{
					$vars = "`".$ky."`='".mysql_real_escape_string(strip_tags($val,'<p><font><b><br><strong><i><u><font>'))."'";
				}
				else
				{
					$vars.= ", `".$ky."`='".mysql_real_escape_string(strip_tags($val,'<p><font><b><br><strong><i><u><font>'))."'";
				}
				$i++;
			}
		}
		
		$query="UPDATE cabinete SET ".$vars." WHERE id='".$id_some_info."'";
		$db->query($query);
		
		#let's insert cabinet to his category
		$inser_cab_to_cat = InsertCabinetToCat($id_some_info,$_POST['category_id'],$_POST['judet']);

		$_SESSION['admin_info'] = "Pasul precedent a fost finalizat cu succes.";
		$_SESSION['admin_info_type'] = 'info';
		
		header('location: ?page=firma.step2.'.$id_some_info);
		exit;
	break;
	
	case 'step2':
		$id_some_info = $param1;
		$tpl->set_file("tpl_firm", "firma/step2.tpl");
		$tpl->set_block('tpl_firm', 'if_images', 'if_images_block');
		$tpl->set_var('USERNAME',$_SESSION['userinfo']->username." - " );
		$tpl->set_var('FIRMA_ID',$id_some_info);
		$user_id  = $_SESSION['userinfo']->id;
		$tpl->set_var('INSERT_FIRMA2', '?page=firma.addstep2.'.$id_some_info);
		
		$images = GetCabineteImages($param1);
		if(count($images)>0)
		{
			$i=0;
			foreach($images as $ky => $val)
			{
				if($val['type']=="cabinet")
				{
					$tpl->set_var('IMG',"../images/users_cabinete/".$user_id."/".$val['image_name'] );
					$tpl->set_var('THUMBNAIL',"../images/smallimages/cabinete/".$val['image_name'] );
					$tpl->parse('if_images_block', 'if_images', true);
				}
			}
		}
		
		#if we have information messages
		if (isset($_SESSION['admin_info'])&&($_SESSION['admin_info']!=""))
		{
			$tpl->set_file('tpl_info', '../admin/info/'.$_SESSION['admin_info_type'].'.tpl');
			$tpl->set_var('MESSAGE', $_SESSION['admin_info']);
			$tpl->parse('ERROR_MSG', 'tpl_info');
			#uset sessions
			unset($_SESSION['admin_info']);
			unset($_SESSION['admin_info_type']);
		}
		
		#fill fields
		if (isset($_SESSION['submit_firma']))
		{
			foreach ($_SESSION['submit_firma'] as $key => $val)
			{
				$values = explode("=>",$val);
				$tpl->set_var(strtoupper($values[0]), $values[1]);
			}
			unset($_SESSION['submit_firma']);
		}
		$tpl->parse("MAIN", "tpl_firm");
	break;
	
	case 'addstep2':
		$id_some_info = $param1;
		$user_id = $_SESSION['userinfo']->id;
		## check video file
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
		## check banner file
		if($_FILES['banner']['type']!="")
		{
			$result = CheckPicture();
			if ($result == '0')
			{
				$display_errors.= '<li>Extensia imaginii pentru banner nu este acceptata !</li>';
			}
			elseif ($result == '1')
			{
				$display_errors.= '<li>Dimensiunea imaginii pentru banner este prea mare !</li>';
			}
		}
		
		if($_FILES['servicii']['type']!="")
		{
			$result = CheckServiciiFile();
			if ($result == '0')
			{
				$display_errors.= '<li>Extensia fisierului nu este acceptata ! Va rugam sa adaugati doar fisier PDF sau Microsoft Office.</li>';
			}
		}
		
		$array_obligatorii = array("orar"=>"Nu ati completat orarul!",
									"descriere"=>"Descrierea nu e completata,aceasta este importanta, vizitatorii va contacteaza in functie de informatiile furnizate aici");
		$display_errors = '';
		//print_r($_POST);exit;
		foreach($_POST as $ky => $val)
		{
			//var_dump(array_key_exists($ky,$array_obligatorii));echo " - ".$val."<br>";
			if((array_key_exists($ky,$array_obligatorii))&&($val==""))
			{
				$display_errors.= '<li>'. $array_obligatorii[$ky].'.</li>';
			}
		}
		//echo $display_errors;exit;
		
		if($display_errors!="")
		{
			#let_put in sessions all infos from post in case we have errors
			$_SESSION['submit_errors'] = $display_errors;
			$_SESSION['submit_firma']=array();
			foreach($_POST as $ky => $val)
			{
				$info = $ky ."=>".$val;
				array_push($_SESSION['admin_info'],$info);
			}
			$_SESSION['admin_info_type'] = 'error';
			header('location: '.GetReferer());
			exit;
		}
		
		### save the banner image
		if($_FILES['banner']['type']!="")
		{
			saveBannerCabinet($id_some_info);
		}
		### save the video file !!!
		if($_FILES['video']['type']!="")
		{
			saveVideoCabinet($id_some_info);
		}
		### save servicii si tarife file !!!
		if($_FILES['servicii']['type']!="")
		{
			saveServiciiFileCabinet($id_some_info);
		}
		### update cabinet step2
		#lets remove link form content:D
		$_POST['descriere'] = RemoveAHref($_POST['descriere']);
		$i=0;
		foreach($_POST as $ky => $val)
		{
			if((strpos($ky,"caractere")!==FALSE)||(strpos($ky,"firma_id")!==FALSE))
			{
				unset($_POST[$ky]);
			}
			elseif($ky!='Submit')
			{
				if($i==0)
				{
					$vars = "`".$ky."`='".mysql_real_escape_string(strip_tags($val,'<p><font><b><br><strong><i><u><font>'))."'";
				}
				else
				{
					$vars.= ", `".$ky."`='".mysql_real_escape_string(strip_tags($val,'<p><font><b><br><strong><i><u><font>'))."'";
				}
				$i++;
			}
		}
		
		$query="UPDATE cabinete SET ".$vars." WHERE id='".$id_some_info."'";
		$db->query($query);
		
		$_SESSION['admin_info'] = "Pasul precedent a fost finalizat cu succes.";
		$_SESSION['admin_info_type'] = 'info';
		
		header('location: ?page=firma.step3.'.$id_some_info);
		exit;
	break;
	
	case 'step3':
		$id_some_info = $param1;
		$tpl->set_file("tpl_firm", "firma/step3.tpl");
		$tpl->set_block('tpl_firm','list_pachete_col','list_pachete_col2');
		$tpl->set_block('tpl_firm','list_servicii','list_servicii2');
		$tpl->set_block('tpl_firm','list_pachete','list_pachete2');
		$tpl->set_block('tpl_firm','list_total_pachete','list_total_pachete2');
		// set the default package to be the BASIC or FREE
		$tpl->set_var('DEF_PACHET','1');
		//unset($_SESSION['submit_firma']);
		//print_r($_SESSION['submit_firma']);exit;
		$tpl->set_var('USERNAME',$_SESSION['userinfo']->username." - " );
		$tpl->set_var('EMAIL_FACTURA',$_SESSION['userinfo']->email );
		$tpl->set_var('PRET_UN_AN', $conf->pret_perioada_1);
		$_SESSION['cost_final'] = $_SESSION['promovare']['cost_total'];
		//print_r($_SESSION['admin_info']);
		//print_r($_SESSION['submit_firma']);exit;

		$pk = new Pachete_Servicii($db);
		$i=1;
		$pachete = $pk->listPacheteFrontend();
		foreach($pachete as $ky => $val)
		{
			$tpl->set_var('COL_NR',$i+1);
			$tpl->set_var('PACHET',strtoupper($val['name']));
			$tpl->set_var('PK',strtoupper($val['name']));
			$tpl->set_var('PK_ID',$val['id']);
			if(isset($_SESSION['submit_firma']) && is_array($_SESSION['submit_firma']))
			{
				if($val['id'] == $_SESSION['submit_firma']['pachet'])
				{
					$tpl->set_var('PK_SELL','selected');
				}
				else 
				{
					$tpl->set_var('PK_SELL','');
				}
			}
			
			$tpl->set_var(strtoupper(str_replace(' ','_',$val['name'])).'_PRICE',$val['pret']);
			$tpl->parse('list_pachete2','list_pachete',true);
			$tpl->parse('list_total_pachete2','list_total_pachete',true);
			$i++;
		}
		
		$i=1;
		$serv = $pk->listServiciiFrontend();
		foreach($serv as $ky => $val)
		{
			$tpl->set_var('SERVICE',$val['name']);
			$tpl->set_var('NR',$i);
			$tpl->set_var('DESCRIPTION',$val['description']);
			$tpl->parse('list_pachete_col2','');
			$j=1;
			$found=false;
			foreach($pachete as $ky2 => $val2)
			{
				$pachet_serv = explode(";",$val2['servicii']);
				$tpl->set_var('SERV_VAL','');
				$serv_checked = '';
				foreach($pachet_serv as $ky3 => $val3)
				{
						
					if($val3!='')
					{
						if($val3==$val['id'])
						{
							if($val['value']!='')
							{
								$tpl->set_var('SERV_VAL',number_format((($val2['id']-1)*$val['value']),0,',',' ').' afisari');
							}
							else
							{
								$tpl->set_var('SERV_VAL','<img src="'.SITE_BASE.'/images/check.png">');
							}
							$found = true;
						}
					}
				}
				
				if(isset($_SESSION['submit_firma']) && is_array($_SESSION['submit_firma']))
				{
					if(is_array($_SESSION['submit_firma']['services']))
					{
						foreach ($_SESSION['submit_firma']['services'] as $ky4 => $val4)
						{
							if($val['id']==$val4)
							{
								$serv_checked = 'checked';
							}
						}
					}
				}
				
				if($val2['name']=='Basic' && !$found)
				{
					$tpl->set_var('SERV_VAL',"<span style='width:20px;padding-right:20px;'><input type='checkbox' name='services[]' value='".$val['id']."' onClick=addPachetService('".$val['id']."') ".$serv_checked."></span>".$val['price'].' RON');
				}
		
				$tpl->set_var('COL_NR',$j+1);
				$tpl->parse('list_pachete_col2','list_pachete_col',true);
				$j++;
			}
			$tpl->parse('list_servicii2','list_servicii',true);
			$i++;
		}
		
		
		#if we have information messages
		if (isset($_SESSION['admin_info'])&&($_SESSION['admin_info']!=""))
		{
			$tpl->set_file('tpl_info', '../admin/info/'.$_SESSION['admin_info_type'].'.tpl');
			$tpl->set_var('MESSAGE', $_SESSION['admin_info']);
			$tpl->parse('ERROR_MSG', 'tpl_info');
			#uset sessions
			unset($_SESSION['admin_info']);
			unset($_SESSION['admin_info_type']);
				
			// autocompleat some fields if it was an error
			$tpl->set_var('TOTAL', $_SESSION['submit_firma']['total']);
			$tpl->set_var('SERVICII', $_SESSION['submit_firma']['servicii']);
			$tpl->set_var('DEF_PACHET', $_SESSION['submit_firma']['pachet']);
				
			$tpl->set_var('CNP', $_SESSION['submit_firma']['cnp']);
			$tpl->set_var('PERSC_ADRESA', $_SESSION['submit_firma']['persc_adresa']);
			$tpl->set_var('CUI', $_SESSION['submit_firma']['cui']);
			$tpl->set_var('REG_COMERT_BI', $_SESSION['submit_firma']['reg_comert_bi']);
			$tpl->set_var('ADRESA_FIRMA', $_SESSION['submit_firma']['adresa_firma']);
			if($_SESSION['submit_firma']['type']=='firma')
			{
				$tpl->set_var(strtoupper($_SESSION['submit_firma']['type']).'_SELL', 'selected');
				$tpl->set_var('PERSOANA_FIZICA_SELL', '');
				$tpl->set_var('PERSOANA_FIZICA_BLOCK_STYLE', 'style="display:none;"');
			}
			else
			{
				$tpl->set_var(strtoupper($_SESSION['submit_firma']['type']).'_SELL', 'selected');
				$tpl->set_var('FIRMA_SELL', '');
				$tpl->set_var('FIRMA_BLOCK_STYLE', 'style="display:none;"');
			}
			unset($_SESSION['submit_firma']);
		}
		else
		{
			$tpl->set_var('PERSOANA_FIZICA_BLOCK_STYLE', 'style="display:none;"');
			$tpl->set_var('FIRMA_BLOCK_STYLE', 'style="display:none;"');
			$tpl->set_var('TOTAL', 0);
		}
		
		
		$tpl->set_var('INSERT_FIRMA3', '?page=firma.addstep3.'.$id_some_info);
		$tpl->parse("MAIN", "tpl_firm");
	break;
	
	case 'addstep3':
		//print_r($_POST);exit;
		$id_some_info = $param1; $display_errors = "";
		$user_id = $_SESSION['userinfo']->id;
		if(!isset($_POST['nume_firma']) || $_POST['nume_firma']=='')
		{
			$_POST['nume_firma'] = getCabinetNumeFirma($id_some_info);
		}
		
		#the user choosed Gratuit so we juset say - your firm has been added to our site, but you can have only one for free
		$pk = new Pachete_Servicii($db);
		if($pk->hasFreePackage($user_id,$id_some_info))
		{
			$display_errors.=  '<li>Ne pare rau dar nu puteti avea decat un singur cabinet GRATUIT, daca doriti sa adaugati un nou cabinet va rugam sa alegeti un alt plan tarifar !</li>';
			$_SESSION['admin_info'] = $display_errors;
			$_SESSION['admin_info_type'] = 'error';
			$_SESSION['submit_firma']=$_POST;
			header('location: '.GetReferer()."#error");
			exit;
		}
		else
		{
			// check the data for bill
			if($_POST['total']!='' && $_POST['total']!="0")
			{
				if(isset($_POST['type'])&&($_POST['type']!=""))
				{
					if($_POST['type']=='persoana_fizica')
					{
						if(!isset($_POST['cnp'])||($_POST['cnp']==""))
						{
							$display_errors .=  '<li>'. 'Ati uitat sa complectati CNP.'.'</li>';
						}
						if(!isset($_POST['persc_adresa'])||$_POST['persc_adresa']=="")
						{
							$display_errors .=  '<li>'. 'Adresa nu este complectata. Factura va fi trimisa postal, introduceti informatii valide'.'</li>';
						}
					}
					else
					{
						if(!isset($_POST['cui'])||$_POST['cui']=="")
						{
							$display_errors .=  '<li>'. 'Codul unic de inregistrare fiscala nu este setat.'.'</li>';
						}
						if(!isset($_POST['adresa_firma'])||$_POST['adresa_firma']=="")
						{
							$display_errors .=  '<li>'. 'Adresa firmei nu este complectata.'.'</li>';
						}
					}
				}
				else
				{
					$display_errors.=  '<li>'.'Va rugam sa alegeti tipul de emitere pentru factura proforma.'.'</li>';
				}
			}
			#let_put in sessions all infos from post, we have errors
			if($display_errors!="")
			{
				$_SESSION['submit_errors'] = $display_errors;
				$_SESSION['submit_firma']=$_POST;
				foreach($_POST as $ky => $val)
				{
					$info = $ky ."=>".$val;
					array_push($_SESSION['admin_info'],$info);
				}
				
				$_SESSION['admin_info_type'] = 'error';
				header('location: '.GetReferer()."#error");
				exit;
			}
			
			$pret_total = $_POST['total'];

			if($pret_total!='' && $pret_total!='0')
			{
				#here we just add the buyer dates and the choosed package
				if($_POST['type']=='persoana_fizica')
				{
					### update cabinete
					$sql = "UPDATE cabinete SET `level`='0', `type`='".$_POST['type']."', `inreg_fiscala_cnp`='".$_POST['cnp']."', `persc_adresa`='".$_POST['persc_adresa']."' WHERE id='".$id_some_info."'";
					$db->query($sql);
				
					### add cumparator
					$sql = "INSERT INTO cumparatori(`nume`, `adresa`, `cui`, `bi`,`cnp`,`rc`) VALUES ('".addslashes($_POST['nume_firma'])."', '".addslashes($_POST['persc_adresa'])."', '','','".$_POST['cnp']."', '')";
					$db->query($sql);
					$cump_id = $db->last_insert_id();
				}
				else
				{
					### update cabinete
					$sql = "UPDATE cabinete SET `level`='0', `type`='".$_POST['type']."', `inreg_fiscala_cnp`='".$_POST['cnp']."', `persc_adresa`='".$_POST['adresa_firma']."', `reg_comert_bi`='".$_POST['reg_comert_bi']."' WHERE id='".$id_some_info."'";
					$db->query($sql);
				
					### add cumparator
					$sql = "INSERT INTO cumparatori(`nume`, `adresa`, `cui`, `bi`,`cnp`,`rc`) VALUES ('".addslashes($_POST['nume_firma'])."', '".addslashes($_POST['adresa_firma'])."', '".addslashes($_POST['cui'])."','','', '".addslashes($_POST['reg_comert_bi'])."')";
					$db->query($sql);
					$cump_id = $db->last_insert_id();
				}
				
				#let insert dates about proform bill
				#here we check if he choose one of the Recomandat packages
				$level = $_POST['pachet'];
				$servicii = $_POST['servicii'];
				$recomandat = 'N'; $emis_fact= 'Y';
				$serviciu_recomandat = $pk->getRecomandatServiceId();
				if(stristr($serviciu_recomandat,$servicii)!==false)
				{
					$recomandat = 'Y';
				}
				$facturi = new Facturi($db);
				$plata_id = $facturi->addProforma($user_id,$id_some_info,$_POST,$recomandat,$cump_id);
				### generate the HTML file for factura proforma
				$facturi->saveProformaFile($plata_id);
					
				#lets send an e-mail with factura proforma
				$text = GetFileContent("../templates/emails/factura_proforma.tpl");
		
				#acestea sunt aceleasi indiferent pe cine se emite factura proforma
				$text = str_replace("%NUME_PERS_CONTACT%", ucfirst($_POST['pers_contact']) , $text);
				$text = str_replace("%NUMAR_FACTURA_PROFORMA%",$plata_id, $text);
				$text =str_replace("%EXPIRARE_FACTURA_PROFORMA%",$conf->expirare_proforma,$text);
				$text = str_replace("%DATA%",date("d.m.Y"),$text);
				$text = str_replace("%PRET_TOTAL%",$_POST['total'],$text);
				$servicii_text = $facturi->generateFacturaText($level,$servicii,$id_some_info);
				$text = str_replace("%DENUMIRE_SERVICI%",$servicii_text ,$text);
				$text = str_replace("%COD_FISCAL_CNP%", $_POST['inreg_fiscala_cnp'] , $text);
				$text = str_replace("%NR_REG_COM_BI%", $_POST['reg_comert_bi'] , $text);
				$get_name_localitate = GetLocalitate($_POST['nume_loc_sector']);
				#daca se emite factura pe firma
				if($_POST['type']=="firma")
				{
					#aici emitem factura pentru firma
					$text = str_replace("%NUME_PERS_CONTACT_FIRMA%",addslashes($_POST['nume_firma']) , $text);
					$text = str_replace("%ADRESA%",$_POST['adresa_firma']." <br /> ".$get_name_localitate['name'].", ".$_POST['judet'].",".$_POST['zip_code'] , $text);
				}
				else
				{
					$text = str_replace("%NUME_PERS_CONTACT_FIRMA%",$_POST['pers_contact'] , $text);
					$text = str_replace("%ADRESA%",$_POST['persc_adresa'], $text);
				}
				
				$CustomHeaders = '';
				$Subject = "Factura proforma";
				$nr_fact_proforma = $plata_id;
				$Sender = 'DentistOnline.ro<'.$conf->contact_recipient.'>';
				$Recipiant = trim($_POST['persc_email']);
				
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
					$query ="UPDATE facturi_proforme SET emis_fact_proforma='N' WHERE id='".$nr_fact_proforma."'";
					$db->query($query);
				}
				
				if($emis_fact==="N")
				{
					$_SESSION['admin_info'] = "Exista o problema in emiterea facturi proforme,vom incerca sa o retrimitem in cel mai scurt timp!";
				}
				else
				{
					$_SESSION['admin_info'] = "Unitatea dvs a fost adaugata cu succes. Va rugam sa realizati plata pentru factura proforma, in cel mai scurt timp. Aveti acces la factura proforma in panoul de administrare, deasemenea factura a fost trimisa pe adresa de mail: ".$_POST['persc_email'];
				}
				$_SESSION['admin_info_type'] = 'info';
				header('location: ?page=user.facturiproforme');
				exit;
			}
			else
			{
				$pk->addPachetAndServicii($user_id,$id_some_info);
				$sql = "UPDATE cabinete SET `level`='".$_POST['pachet']."' WHERE id='".$id_some_info."' ";
				$db->query($sql);
				
				$_SESSION['admin_info'] = "Unitatea dvs a fost adaugata cu succes. Va rugam sa asteptati activarea firmei de catre administrator.";
				$_SESSION['admin_info_type'] = 'info';
				header('location: ?page=user.listfirms');
				exit;
			}
		}
	break;
}