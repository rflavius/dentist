<?php

$conf->admin_gallery_max="150";

set_time_limit(0);
ini_set('memory_limit', '256M');

//ini_set('display_errors', '1');
$size = ini_get('upload_max_filesize');
$conf->max_video_size=$size;

$pachete = new Pachete_Servicii($db);
$reviews = new Dentist_Reviews();

switch ($action)
{
	########################################## STUFFS ABOUT ADD,EDIT,INSER,MODIFY A CAB,LAB,CLINIQU E##########################################
	#add new cab,laboratory,clinique
	case 'detaliiadaugafirma':
		$tpl->set_file('tpl_main', 'user/detalii_adaugafirma.tpl');
		$tpl->parse('MAIN', 'tpl_main', true);
	break;

	case 'addfirm':
		/*if($_SERVER['REMOTE_ADDR']!='79.113.82.85' && $_SERVER['REMOTE_ADDR']!='89.34.170.32')
		{
			echo 'Momentan site-ul dentistonline.ro realizeaza o actiune de mentenanta. Va rugam reveniti !';exit;
		}*/
		
		$tpl->set_file("tpl_firm", "user/adauga_firma.tpl");
		$tpl->set_block('tpl_firm', 'display_cats', 'display_catss');
		$tpl->set_block('tpl_firm', 'judet', 'judett');
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
				{		$tpl->set_var('SELECTTEDJUDET',"selected");	}
				else
				{		$tpl->set_var('SELECTTEDJUDET',"");		}
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
				{
					$tpl->set_var('SELECTED_LOC',"selected" );
				}
				else
				{
					$tpl->set_var('SELECTED_LOC',"" );
				}
			
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
			$tpl->set_file('tpl_error', '../info/'.$_SESSION['submit_errors']['type'].'.tpl');
			$tpl->set_var('MESSAGE', $_SESSION['submit_errors']['message']);
			$tpl->parse("ERROR_MSG", 'tpl_error');
			unset($_SESSION['submit_errors']);
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
							$tpl->set_file("tpl_formplace","user/".$values[1].".tpl");
							$tpl->parse('LOC_FORM_PLACE','tpl_formplace');
						}
					}
					else
					{	$tpl->set_var(strtoupper($values[0]), $values[1]); }
			}
			unset($_SESSION['submit_firma']);
		}
		$tpl->set_var('INSERT_FIRMA',"?page=user.insertfirma");
		
		$tpl->parse("MAIN", "tpl_firm");
	break;
	
	case 'insertfirma':
		$array_obligatorii = array("category_id"=>"Categoria nu e setata","nume_firma"=>"Numele firmei nu e setat ","adresa_firma"=>"Adresa firmei nu e setata","judet"=>"Judetul nu e setat","nume_loc_sector"=>"Localitate/sector nu e setat","orar"=>"Nu aveti orar","pers_contact"=>"Persoana de contact nu e setata","persc_email"=>"Adresa de email persoana contact nu e setata","descriere"=>"Descrierea nu e setata");
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
		{	$display_errors .="<li>Adresa de e-mail a persoanei de contact este invalida.</li>";	}
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
				{	$display_errors .="<li>Adresa de e-mail a firmei este invalida.</li>";	}

		}
		#lets add two images(imaginea de cabinet - imaginea cu harta (unde e situat cabinetul))
		#this is the image for cabinet
		$result =  CheckPictureItemCabinet();
		if ($result == '0')
		{
			$display_errors .=  '<li>'.'Imaginile pentru cabinet nu au extensiile acceptate!'.'</li>';
		}
		elseif ($result == '1')
		{
			$display_errors .= '<li>'. 'Imaginii cabinet - Va rugam respectati dimensiunile maxime admise!'.'</li>';
		}

		#this is for map...harta cabinet
		if ($_FILES['picture_harta']['type']!= "")
		{#function saved in classes/api/user.inc!!!!!!!!!!!!!!!!
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


		if($display_errors!="")
		{
			#let_put in sessions all infos from post in case we have errors
			$_SESSION['submit_errors']['message'] = $display_errors;
			$_SESSION['submit_errors']['type'] = 'error';
			$_SESSION['submit_firma']=array();
			foreach($_POST as $ky => $val)
			{
				$info = $ky ."=>".$val;	array_push($_SESSION['submit_firma'],$info);
			}
			header('location: '.GetReferer());
			exit;
		}


		$user_id = $_SESSION['userinfo']->id;
		array_pop($_POST);
		#insert infos about cabinet ,we take the id of cabinet
		/*$type = $_POST['type'];
		$id_some_info = InsertPartFromFirma($_POST['nume_firma'],$user_id,$type,$_POST['perioada']);*/
		$type = $_POST['type'];
		$id_some_info = InsertPartFromFirma($_POST['nume_firma'],$user_id,$type,1);

		$i=0;
		foreach($_POST as $ky => $val)
		{
			if(strpos($ky,"caractere")!==FALSE)
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
		
		#daca avem poza pt harta o salvam:D
		if ($_FILES['picture_harta']['type'] != "" )
		{
			$extension = explode('/',$_FILES['picture_harta']['type']);
			$file_extension = $extension[1];
			SavePicturesMap($file_extension, $id_some_info,"frontend" );
			unset($_FILES['picture_harta']);
		}
		SavePicturesCabinete($id_some_info,"frontend" );



		if(count($_FILES)>0)
		{
				GenerateSmallImages($id_some_info);	#let's create small images for cabinet
		}
		

		$_SESSION['submit_errors']['type']='info';
		$_SESSION['submit_errors']['message'] = "Pasul precedent a fost finalizat cu succes.";
		header('location: ?page=user.addfirm2.'.$id_some_info);
		exit;
	break;

	case 'addfirm2':
		$id_some_info = $param1;
		$tpl->set_file("tpl_firm", "user/adauga_firma2.tpl");
		$tpl->set_block('tpl_firm', 'if_images', 'if_images_block');
		$tpl->set_var('USERNAME',$_SESSION['userinfo']->username." - " );
		$tpl->set_var('FIRMA_ID',$id_some_info);
		$user_id  = $_SESSION['userinfo']->id;
		$tpl->set_var('INSERT_FIRMA2', '?page=user.insertfirma2.'.$id_some_info);
		
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

		if (isset($_SESSION['submit_errors']))
		{
			$tpl->set_file('tpl_error', '../info/'.$_SESSION['submit_errors']['type'].'.tpl');
			$tpl->set_var('MESSAGE', $_SESSION['submit_errors']['message']);
			$tpl->parse("ERROR_MSG", 'tpl_error');
			unset($_SESSION['submit_errors']);
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

	case 'insertfirma2':
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

		$array_obligatorii = array("orar"=>"Nu ati completat orarul!","descriere"=>"Descrierea nu e completata,aceasta este importanta, vizitatorii va contacteaza in functie de informatiile furnizate aici");
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
			$_SESSION['submit_errors']['message'] = $display_errors;
			$_SESSION['submit_errors']['type'] = 'error';
			$_SESSION['submit_firma']=array();
			foreach($_POST as $ky => $val)
			{
				$info = $ky ."=>".$val;	array_push($_SESSION['submit_firma'],$info);
			}
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

		$_SESSION['submit_errors']['type'] = 'info';
		$_SESSION['submit_errors']['message'] = "Pasul precedent a fost finalizat cu succes.";
		header('location: ?page=user.addfirm3.'.$id_some_info);
		exit;
	break;

	case 'addfirm3':
		$id_some_info = $param1;
		$tpl->set_file("tpl_firm", "user/adauga_firma3b.tpl");
		$tpl->set_var('USERNAME',$_SESSION['userinfo']->username." - " );
		$tpl->set_var('EMAIL_FACTURA',$_SESSION['userinfo']->email );
		$tpl->set_var('PRET_UN_AN', $conf->pret_perioada_1);
		$_SESSION['cost_final'] = $_SESSION['promovare']['cost_total'];
	
		if (isset($_SESSION['submit_errors']))
		{
			$tpl->set_file('tpl_error', '../info/'.$_SESSION['submit_errors']['type'].'.tpl');
			$tpl->set_var('MESSAGE', $_SESSION['submit_errors']['message']);
			$tpl->parse("ERROR_MSG", 'tpl_error');
			unset($_SESSION['submit_errors']);
		}
		
		// list pachete
		$tpl->set_block('tpl_firm', 'list_pachete', 'list_pachete2');
		$pk = $pachete->listPacheteFrontend('Y');
		if(count($pk)>0)
		{
			$i=1;
			foreach ($pk as $key => $value)
			{
				if($i==1)
				{
					$tpl->set_var('PACHET_SELL', 'checked');
					$tpl->set_var('DEFAULT_LEVEL', $value['id']);
				}
				else $tpl->set_var('PACHET_SELL', '');
				
				$tpl->set_var('PACHET', strtoupper($value['name']));
				$tpl->set_var('PACHET_PRICE', $value['pret']);
				$tpl->set_var('PACHET_ID', $value['id']);
				$tpl->set_var('PACHET_HASHTAG', str_replace(" ","_",strtolower($value['name'])));
				
				if(!empty($value['discount']))
				{
					switch ($value['discount_type'])
					{
						case 'month':
							$tpl->set_var('PACHET_OFERTA', '<p class="text-danger">DISCOUNT: '.$value['discount'].'</p>');
						break;

						case 'percent':
							$tpl->set_var('PACHET_OFERTA', '<p class="text-danger">DISCOUNT: '.$value['discount'].'% </p>');
						break;
					}
				}
				else
				{
				
					$tpl->set_var('PACHET_OFERTA', "");
				}
				
				$tpl->parse('list_pachete2', 'list_pachete', true);
				$i++;
			}
		}
		else $tpl->parse('list_pachete2', '');
		
		$tpl->set_block('tpl_firm','list_perioada','list_perioada2');
		for ($i = 6; $i <= 24; $i++)
		{
			if($i==6) $tpl->set_var('PERIOADA_SELL', 'selected');
			else $tpl->set_var('PERIOADA_SELL', '');
			
			$tpl->set_var('PERIOADA_VALUE', $i.' luni');
			$tpl->set_var('PERIOADA', $i);
			$tpl->parse('list_perioada2','list_perioada',true);
		}
		
		#fill fields
		//print_r($_SESSION['submit_firma']);
		$have_errors = "NO"; $price = 0;
		if (isset($_SESSION['submit_firma']))
		{
			$have_errors="YES";
			foreach ($_SESSION['submit_firma'] as $key => $val)
			{
				$values = explode("=>",$val);
				if(($values[0]=="cost_abonament")||($values[0]=="cost_recomandat"))
				{
					$price = $price + $values[1];
				}
				if(($values[0]=="selected_cost_abonament")||($values[0]=="selected_cost_recomandat"))
				{
					$price2 = $price2 + $values[1];
				}
	
				//old price for abonament
				if($values[0]=='cost_abonament' && $values[1]!='0')
				{
					$tpl->set_var('SELL_COST_ABONAMENT',$values[1] );
				}
				elseif($values[0]=='selected_cost_abonament' && $values[1]!="0")
				{
					$tpl->set_var('SELL_COST_ABONAMENT',$values[1] );
				}
				elseif($values[0]=='cost_recomandat' && $values[1]!='0')
				{
					$tpl->set_var('SELL_COST_RECOMANDAT',$values[1] );
				}
				elseif($values[0]=='selected_cost_recomandat' && $values[1]!='0')
				{
					$tpl->set_var('SELL_COST_RECOMANDAT',$values[1] );
				}
				//display the final price with the currency RON
				elseif($values[0]=='cost_final')
				{
					if($values[1]=='0')
					{
						$tpl->set_var('COST_FINAL',$price2." RON");
					}
					else
					{
						$tpl->set_var('COST_FINAL',$values[1]." RON");
					}
					$tpl->set_var('COST_FINAL',$_SESSION['cost_final']." RON");
				}
				elseif($values[0]=="judet")
				{
					$tpl->set_var(strtoupper($values[0]), "selected"); 
				}
				elseif($values[0]=="perioada")
				{
					$tpl->set_var('SELECTED_'.$values[1],"selected" );
				}
				elseif($values[0]=="recomandata")
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
		else
		{
			unset($_SESSION['promovare']);
			unset($_SESSION['recomandare']);
		}
	
		$user_id  = $_SESSION['userinfo']->id;
		if($have_errors=="NO")
		{
			$tpl->set_var('COST_PROMOVARE',0 );
			$final_cost = 0;
			$tpl->set_var('COST_FINAL',$final_cost ." RON");
			$tpl->set_var('SEL_COST_FINAL',$final_cost);
		}
		//$tpl->set_var('COST_FINAL',"ddd");
		if($price!="0")
		{
			$tpl->set_var('COST_PROMOVARE',$price);
			$tpl->set_var('SEL_COST_FINAL',$price);
		}
		else
		{
			$tpl->set_var('COST_PROMOVARE',$price2);
			$tpl->set_var('SEL_COST_FINAL',$price2);
		}
		$tpl->set_var('ABONAMENT_NR',countCabineteAbonament($user_id) );
		$tpl->set_var('ABONAMENT_DISCOUNT_PROCENTAJ',$conf->discount_abonament_procent );
		$discount_procent = countCabineteAbonament($user_id)*$conf->discount_abonament_procent;
		$tpl->set_var('DISCOUNT_PR',$discount_procent ."%");
		$discount_val = (200*$discount_procent)/100;
		//$tpl->set_var('COST_FINAL',"0 RON");
		$tpl->set_var('INSERT_FIRMA3', '?page=user.insertfirma3.'.$id_some_info);
		$tpl->parse("MAIN", "tpl_firm");
	break;
	
	case 'insertfirma3':
		//print_r($_POST);exit;
		$id_some_info = $param1; $display_errors = "";
		$user_id = $_SESSION['userinfo']->id;
		
		if($pachete->ifPachetFree($_POST['level']))
		{
			### check if he has another cabinet gratuit !!!
			if(hasAnotherGratuitCabinet($user_id,$id_some_info))
			{
				$display_errors.=  '<li>Ne pare rau dar nu puteti avea decat un singur cabinet GRATUIT, daca doriti sa adaugati un nou cabinet va rugam sa alegeti PACHETUL ABONAMENT !</li>';
				$_SESSION['submit_errors']['message'] = $display_errors;
				$_SESSION['submit_errors']['type'] = 'error';
				header('location: '.GetReferer());
				exit;
			}
			### update cabinete
			$sql = "UPDATE cabinete SET `level`='".$_POST['level']."' WHERE id='".$id_some_info."'";
			$db->query($sql);
			
			$_SESSION['admin_info'] = "Firma a fost adaugata cu succes!<br />";
			$_SESSION['admin_info_type'] = 'info';
			header('location: ?page=user.listfirms');exit;
		}
		else 
		{
			#this means we have some one who choose Abonament or Recomandat
			#if he only picked Abonament-Recomandat and clicked Finalizare an warning to him to choose something
			if(($_POST['perioada']==""))
			{
				$display_errors .=  '<li>Va rugam alegeti perioada de promovare.</li>';
			}

			#let_put in sessions all infos from post, we have errors
			if($display_errors!="")
			{
				$_SESSION['submit_errors']['message'] = $display_errors;
				$_SESSION['submit_errors']['type'] = 'error';
				$_SESSION['submit_firma']=array();
				foreach($_POST as $ky => $val)
				{
					$info = $ky ."=>".$val;
					array_push($_SESSION['submit_firma'],$info);
				}
				header('location: '.GetReferer());
				exit;
			}
			#if no errors, let's insert and generate Factura Proforma
			$get_firma_name_email = GetSelectedCabinet(intval($id_some_info));
			$_POST['nume_firma'] = $get_firma_name_email['nume_firma'];
			$_POST['persc_email'] = $_SESSION['userinfo']->email;
			$_POST['nume_loc_sector'] = $get_firma_name_email['nume_loc_sector'];
			$level = $_POST['level'];
			
			if($_POST['type']=='persoana_fizica')
			{
				### update cabinete
				$sql = "UPDATE cabinete SET `level`='".$_POST['level']."', `type`='".$_POST['type']."', `inreg_fiscala_cnp`='".$_POST['cnp']."', `persc_adresa`='".$_POST['persc_adresa']."', `zip_code`='".$_POST['zip_code']."' WHERE id='".$id_some_info."'";
				$db->query($sql);

				### add cumparator
				$sql = "INSERT INTO cumparatori(`nume`, `adresa`, `cui`, `bi`,`cnp`,`rc`) VALUES ('".addslashes($_POST['nume_firma'])."', '".addslashes($_POST['persc_adresa'])."', '','','".$_POST['cnp']."', '')";
				$db->query($sql);
				$cump_id = $db->last_insert_id();
			}
			else
			{
				### update cabinete
				$sql = "UPDATE cabinete SET `level`='".$_POST['level']."', `type`='".$_POST['type']."', `inreg_fiscala_cnp`='".$_POST['cnp']."', `persc_adresa`='".$_POST['adresa_firma']."', `zip_code`='".$_POST['zip_code2']."',`reg_comert_bi`='".$_POST['reg_comert_bi']."' WHERE id='".$id_some_info."'";
				$db->query($sql);
	
				### add cumparator
				$sql = "INSERT INTO cumparatori(`nume`, `adresa`, `cui`, `bi`,`cnp`,`rc`) VALUES ('".addslashes($_POST['nume_firma'])."', '".addslashes($_POST['adresa_firma'])."', '".addslashes($_POST['cui'])."','','', '".addslashes($_POST['reg_comert_bi'])."')";
				$db->query($sql);
				$cump_id = $db->last_insert_id();
			}
			
			#we insert the correct bill by the choosed promovatins plans
			$pret_total = 0;
			$a = $pachete->getPachetInfo($_POST['level']);
			switch ($a['discount_type'])
			{
				case 'month':
					$pret_total = ($a['pret'] * $_POST['perioada']) - ($a['discount'] * $a['pret']);
				break;
			
				case 'percent':
					$pret_total = round(($a['pret'] * $_POST['perioada']) - (($a['discount']/100) * ($a['pret'] * $_POST['perioada'])));
				break;
			}
			
			$_POST['cost_final'] = $pret_total;
			
			#let insert dates about proform bill
			#here we check if he choose one of the Recomandat packages
			$recomandat = 'N'; $emis_fact= 'Y';
			if($pachete->hasRecomandat($level))
			{
				$recomandat = 'Y';
			}
			$plata_id = InsertPlata($user_id,$id_some_info,$_POST['nume_firma'],$level,$_POST['type'],$emis_fact,$_POST['cost_final'],$recomandat,$_POST['persc_email'],$cump_id, $_POST['perioada']);
			### generate the HTML file for factura proforma
			$html = GenerateFacturaProforma($plata_id);
		
			#lets send an e-mail with factura proforma
			$text = GetFileContent("../templates/emails/factura_proforma.tpl");
			#acestea sunt aceleasi indiferent pe cine se emite factura proforma
			$text = str_replace("%NUME_PERS_CONTACT%", ucfirst($_POST['pers_contact']) , $text);
			$text = str_replace("%NUMAR_FACTURA_PROFORMA%", $plata_id, $text);
			$text =str_replace("%EXPIRARE_FACTURA_PROFORMA%", $conf->expirare_proforma,$text);
			$text = str_replace("%DATA%", date("d.m.Y"),$text);
			$text = str_replace("%PRET_TOTAL%", $_POST['cost_final'],$text);
			
			$new_text = TextFacturaInFunctieDeLevel($level, $_POST['perioada']);
			$new_text = str_replace("%NUME_FIRMA%", $nume_firma,$new_text);
			$text = str_replace("%DENUMIRE_SERVICI%",$new_text ,$text);
			$text = str_replace("%COD_FISCAL_CNP%",	$_POST['inreg_fiscala_cnp'] , $text);
			$text = str_replace("%NR_REG_COM_BI%",	$_POST['reg_comert_bi'] , $text);
			$get_name_localitate = GetLocalitate($_POST['nume_loc_sector']);
			#daca se emite factura pe firma
			if($_POST['type']=="firma")
			{
				#aici emitem factura pentru firma
				$text = str_replace("%NUME_PERS_CONTACT_FIRMA%",addslashes($_POST['nume_firma']) , $text);
				$text = str_replace("%ADRESA%",	$_POST['adresa_firma']." <br /> ".$get_name_localitate['name'].", ".$_POST['judet'].",".$_POST['zip_code'] , $text);
			}
			else
			{
				$text = str_replace("%NUME_PERS_CONTACT_FIRMA%",$_POST['pers_contact'] , $text);
				$text = str_replace("%ADRESA%",	$_POST['persc_adresa'], $text);
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
			}
			$query ="UPDATE facturi_proforme SET emis_fact_proforma='".$emis_fact."' WHERE id='".$nr_fact_proforma."'";
			$db->query($query);
			
			$_SESSION['admin_info_type'] = 'info';
			if($emis_fact==="N")
			{
				$_SESSION['admin_info'] = "Exista o problema in emiterea facturi proforme,vom incerca sa o retrimitem in cel mai scurt timp!";
			}
			else
			{
				$_SESSION['admin_info'] = "Pachetul de promovare a fost modificat cu succes!<br /><B style='text-decoration:blink;color:#CC0000;'>Aici aveti factura proforma</B>. Deasemenea  a fost trimisa pe adresa de e-mail : ".$_POST['persc_email'];
			}
			$_SESSION['admin_info_type'] = 'info';
			header('location: ?page=user.facturiproforme');exit;
		}
	break;
	
	case 'updatepachet':
		$id_some_info = $param1;
		$tpl->set_file("tpl_firm", "user/update_pachet2.tpl");
		$tpl->set_block("tpl_firm", "error",'error_block' );
		$tpl->set_var('USERNAME',$_SESSION['userinfo']->username." - " );
		$tpl->set_var('PRET_UN_AN', $conf->pret_perioada_1);
		$tpl->set_var('EMAIL_FACTURA', $_SESSION['userinfo']->email);
		$_SESSION['cost_final'] = $_SESSION['promovare']['cost_total'];

		//print_r($_SESSION['promovare']['cost_total']);
		if (isset($_SESSION['submit_errors']))
		{
			$tpl->set_var("ERROR_MSG", $_SESSION['submit_errors']);
			unset($_SESSION['submit_errors']);
			$tpl->parse("error_block", "error", true);
		}
		#fill fields
		//print_r($_SESSION['submit_firma']);
		$have_errors = "NO"; $price = 0;
		if (isset($_SESSION['submit_firma']))
		{ 
			$have_errors="YES";
			$_SESSION['promovare']['cost_total'] = $_SESSION['cost_final'];
			foreach ($_SESSION['submit_firma'] as $key => $val)
			{
					$values = explode("=>",$val);
					if(($values[0]=="cost_abonament")||($values[0]=="cost_recomandat"))
					{	$price = $price + $values[1]; }
					if(($values[0]=="selected_cost_abonament")||($values[0]=="selected_cost_recomandat"))
					{	$price2 = $price2 + $values[1]; }

					//old price for abonament
					if($values[0]=='cost_abonament' && $values[1]!='0')
					{
						$tpl->set_var('SELL_COST_ABONAMENT',$values[1] );
					}
					elseif($values[0]=='selected_cost_abonament' && $values[1]!="0")
					{
						$tpl->set_var('SELL_COST_ABONAMENT',$values[1] );
					}
					elseif($values[0]=='cost_recomandat' && $values[1]!='0')
					{
						$tpl->set_var('SELL_COST_RECOMANDAT',$values[1] );
					}
					elseif($values[0]=='selected_cost_recomandat' && $values[1]!='0')
					{
						$tpl->set_var('SELL_COST_RECOMANDAT',$values[1] );
					}
					//display the final price with the currency RON
					elseif($values[0]=='cost_final')
					{
						if($values[1]=='0')
						{
							$tpl->set_var('COST_FINAL',$price2." RON");
						}
						else
						{
							$tpl->set_var('COST_FINAL',$values[1]." RON");
						}
						$tpl->set_var('COST_FINAL',$_SESSION['cost_final']." RON");
					}
					elseif($values[0]=="judet")
					{	$tpl->set_var(strtoupper($values[0]), "selected"); }
					elseif($values[0]=="perioada")
					{
						$tpl->set_var('SELECTED_'.$values[1],"selected" );
					}
					elseif($values[0]=="recomandata")
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
					{	$tpl->set_var(strtoupper($values[0]), $values[1]); }
			}
			unset($_SESSION['submit_firma']);
		}
		else
		{
			unset($_SESSION['promovare']);
			unset($_SESSION['recomandare']);
		}

		$user_id  = $_SESSION['userinfo']->id;
		if($have_errors=="NO")
		{
			$tpl->set_var('COST_PROMOVARE',0 );
			$final_cost = 0;
			$tpl->set_var('COST_FINAL',$final_cost ." RON");
			$tpl->set_var('SEL_COST_FINAL',$final_cost);
		}
		//$tpl->set_var('COST_FINAL',"ddd");
		if($price!="0")
		{
			$tpl->set_var('COST_PROMOVARE',$price);
			$tpl->set_var('SEL_COST_FINAL',$price);
		}
		else
		{
			$tpl->set_var('COST_PROMOVARE',$price2);
			$tpl->set_var('SEL_COST_FINAL',$price2);
		}
		$tpl->set_var('ABONAMENT_NR',countCabineteAbonament($user_id) );
		$tpl->set_var('ABONAMENT_DISCOUNT_PROCENTAJ',$conf->discount_abonament_procent );
		$discount_procent = countCabineteAbonament($user_id)*$conf->discount_abonament_procent;
		$tpl->set_var('DISCOUNT_PR',$discount_procent ."%");
		$discount_val = (200*$discount_procent)/100;
		$tpl->set_var('UPDATE_PACHET_ACTION', '?page=user.doupdateabonament.'.$id_some_info);
		$tpl->parse("MAIN", "tpl_firm");
	break;

	case 'doupdateabonament':
		//	print_r($_POST);exit;
		$id_some_info = $param1;
		$user_id = $_SESSION['userinfo']->id;
		$display_errors="";
		#lets check emitere factura

		if(($_POST['perioada']=="")&&($_POST['recomandata']==""))
		{
			$display_errors .=  '<li>'. 'Va rugam alegeti un plan de promovare ABONAMENT sau RECOMANDAT'.'</li>';
		}

		if(isset($_POST['type'])&&($_POST['type']!=""))
		{
			if($_POST['type']=='persoana_fizica')
			{
				if(!isset($_POST['cnp'])||($_POST['cnp']==""))
				{
					$display_errors .=  '<li>'. 'Ati uitat sa completati CNP.'.'</li>';
				}
				if(!isset($_POST['persc_adresa'])||$_POST['persc_adresa']=="")
				{
					$display_errors .=  '<li>'. 'Adresa nu este completata. Factura va fi trimisa postal, introduceti informatii valide'.'</li>';
				}
			}
			else
			{
				if(!isset($_POST['cui'])||$_POST['cui']=="")
				{
					$display_errors .=  '<li>'. 'Codul unic de inregistrare fiscala nu este setat.'.'</li>';
				}
				/*if(!isset($_POST['reg_comert_bi'])||$_POST['reg_comert_bi']=="")
				{
					$display_errors .=  '<li>'. 'Registru comertului nu este setat.'.'</li>';
				}*/
				if(!isset($_POST['adresa_firma'])||$_POST['adresa_firma']=="")
				{
					$display_errors .=  '<li>'. 'Adresa firmei nu este completata.'.'</li>';
				}
			}
		}
		else
		{
			$display_errors.=  '<li>'.'Va rugam sa alegeti tipul de emitere pentru factura proforma.'.'</li>';
		}
		#let_put in sessions all infos from post, we have errors
		if($display_errors!="")
		{
			$_SESSION['submit_errors'] = $display_errors;
			$_SESSION['submit_firma']=array();
			foreach($_POST as $ky => $val)
			{
				$info = $ky ."=>".$val;	array_push($_SESSION['submit_firma'],$info);
			}
			header('location: '.GetReferer());
			exit;
		}

		$get_firma_name_email = GetSelectedCabinet(intval($id_some_info));
		$_POST['nume_firma'] = $get_firma_name_email['nume_firma'];
		$_POST['persc_email'] = $_SESSION['userinfo']->email; 
		$_POST['nume_loc_sector'] = $get_firma_name_email['nume_loc_sector'];
		
		#lets set the new level for our cabinet
		#here we check if he choose or not ABONAMENT
		if(($_POST['perioada']=="")||($_POST['perioada']=="1"))
		{			$_POST['perioada'] ='N'; 		}
		
		#here we check if he choose or not to be RECOMANDAT
		if(($_POST['recomandata']=="")||($_POST['recomandata']=="N"))
		{			$_POST['recomandata'] = 'N';		}

		#this means the client choose ABONAMENT, just this, and chech the other posibilities
		if(($_POST['perioada']=='2')&&($_POST['recomandata']=='N'))
		{
			$level = '2'; #this is the id for Abonament simple
		}
		elseif(($_POST['perioada']=='2')&&($_POST['recomandata']=='6'))
		{
			$level = '2,6'; #this is the id for Abonament & Recomandat on 6 months	
		}
		elseif(($_POST['perioada']=='2')&&($_POST['recomandata']=='5'))
		{
			$level = '2,5'; #this is the id for Abonament & RECOMANDAT 12 months
		}
		elseif(($_POST['perioada']=='N')&&($_POST['recomandata']=='6'))
		{
			$level = '6'; #this is the id for RECOMANDAT on 6 months
		}
		elseif(($_POST['perioada']=='N')&&($_POST['recomandata']=='5'))
		{
			$level = '5'; #this is the id for RECOMANDAT 12 months
		}
		#here we just add the buyer dates and the choosed package
		if($_POST['type']=='persoana_fizica')
		{
			### update cabinete
			$sql = "UPDATE cabinete SET `level`='".$level."', `type`='".$_POST['type']."', `inreg_fiscala_cnp`='".$_POST['cnp']."', `persc_adresa`='".$_POST['persc_adresa']."', `zip_code`='".$_POST['zip_code']."' WHERE id='".$id_some_info."'";
			$db->query($sql);

			### add cumparator
			$sql = "INSERT INTO cumparatori(`nume`, `adresa`, `cui`, `bi`,`cnp`,`rc`) VALUES ('".addslashes($_POST['nume_firma'])."', '".addslashes($_POST['persc_adresa'])."', '','','".$_POST['cnp']."', '')";
			$db->query($sql);
			$cump_id = $db->last_insert_id();
		}
		else
		{
			### update cabinete
			$sql = "UPDATE cabinete SET `level`='".$level."', `type`='".$_POST['type']."', `inreg_fiscala_cnp`='".$_POST['cnp']."', `persc_adresa`='".$_POST['adresa_firma']."', `zip_code`='".$_POST['zip_code2']."',`reg_comert_bi`='".$_POST['reg_comert_bi']."' WHERE id='".$id_some_info."'";
			$db->query($sql);

			### add cumparator
			$sql = "INSERT INTO cumparatori(`nume`, `adresa`, `cui`, `bi`,`cnp`,`rc`) VALUES ('".addslashes($_POST['nume_firma'])."', '".addslashes($_POST['adresa_firma'])."', '".addslashes($_POST['cui'])."','','', '".addslashes($_POST['reg_comert_bi'])."')";
			$db->query($sql);
			$cump_id = $db->last_insert_id();
		}

			#let insert dates about proform bill
			#here we check if he choose one of the Recomandat packages
			$recomandat = 'N'; $emis_fact= 'Y';
			$array_level_recomandat = array("5","6");
			if(in_array($level,	$array_level_recomandat))
			{
				$recomandat = 'Y';
			}
			
			$pret_total = 0;
			if(stristr($level,',')!==false)
			{
					$price = explode(",",$level);
				foreach($price as $ky => $val)
				{
					$a = getPromovareLevelDetails($val);
					$pret_total = $pret_total + $a['pret'];
				}
				$_POST['cost_final'] =	$pret_total;
			}
			else
			{
			
				$pret_total = getPromovareLevelDetails($level);
				$_POST['cost_final'] = $pret_total['pret'];
			}
			//echo $_POST['cost_final'];exit;
			$plata_id = InsertPlata($user_id,$id_some_info,$_POST['nume_firma'],$level,$_POST['type'],$emis_fact,$_POST['cost_final'],$recomandat,$_POST['persc_email'],$cump_id);

			### generate the HTML file for factura proforma
			$html = GenerateFacturaProforma($plata_id);

			#lets send an e-mail with factura proforma
			$text = GetFileContent("../templates/emails/factura_proforma.tpl");
			
			#acestea sunt aceleasi indiferent pe cine se emite factura proforma
			$text = str_replace("%NUME_PERS_CONTACT%",	ucfirst($_POST['pers_contact']) , $text);
			$text = str_replace("%NUMAR_FACTURA_PROFORMA%",$plata_id, $text);
			$text =str_replace("%EXPIRARE_FACTURA_PROFORMA%",$conf->expirare_proforma,$text); 
			$text = str_replace("%DATA%",date("d.m.Y"),$text);
			$text = str_replace("%PRET_TOTAL%",$_POST['cost_final'],$text);
			
			/*if($_POST['perioada']==="1")
			{
				if($_POST['recomandata']=='Y')
				{
					$text = str_replace("%DENUMIRE_SERVICI%","Promovare online timp de 1 an pentru ".$_POST['nume_firma']." din data de ".date("d.m.Y") ." pana in ".date("d.m.Y", mktime(0, 0, 0, date("m"), date("d"), date("Y")+1))." in cadrul portalului stomotologic dentistonline.ro." ,$text);
				}
				else
				{
					$text = str_replace("%DENUMIRE_SERVICI%","Promovare online timp de 1 an pentru ".$_POST['nume_firma']." din data de ".date("d.m.Y") ." pana in ".date("d.m.Y", mktime(0, 0, 0, date("m"), date("d"), date("Y")+1))." in cadrul portalului stomotologic dentistonline.ro." ,$text);
				}
			}
			else
			{
					$text = str_replace("%DENUMIRE_SERVICI%","Promovare online timp de 2 ani, pentru ".$_POST['nume_firma']." din data de ".date("d.m.Y") ." pana in ".date("d.m.Y", mktime(0, 0, 0, date("m"), date("d"), date("Y")+2))." in cadrul portalului stomotologic dentistonline.ro.",$text);
			}*/
			$new_text = TextFacturaInFunctieDeLevel($level);
			$new_text = str_replace("NUME_FIRMA",$nume_firma,$new_text);
			$text = str_replace("%DENUMIRE_SERVICI%",$new_text ,$text);
			$text = str_replace("%COD_FISCAL_CNP%",	$_POST['inreg_fiscala_cnp'] , $text);
			$text = str_replace("%NR_REG_COM_BI%",	$_POST['reg_comert_bi'] , $text);
			$get_name_localitate = GetLocalitate($_POST['nume_loc_sector']);
			#daca se emite factura pe firma
			if($_POST['type']=="firma")
			{
				#aici emitem factura pentru firma
				$text = str_replace("%NUME_PERS_CONTACT_FIRMA%",addslashes($_POST['nume_firma']) , $text);
				$text = str_replace("%ADRESA%",	$_POST['adresa_firma']." <br /> ".$get_name_localitate['name'].", ".$_POST['judet'].",".$_POST['zip_code'] , $text);
			}
			else
			{
				$text = str_replace("%NUME_PERS_CONTACT_FIRMA%",$_POST['pers_contact'] , $text);
				$text = str_replace("%ADRESA%",	$_POST['persc_adresa'], $text);
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
			$_SESSION['admin_info_type'] = 'info';
			if($emis_fact==="N")
			{
				$_SESSION['admin_info'] = "Exista o problema in emiterea facturi proforme,vom incerca sa o retrimitem in cel mai scurt timp!";
			}
			else
			{
				$_SESSION['admin_info'] = "Pachetul de promovare a fost modificat cu succes!<br /><B style='text-decoration:blink;color:#CC0000;'>Aici aveti factura proforma</B>. Deasemenea  a fost trimisa pe adresa de e-mail : ".$_POST['persc_email'];
			}
			$_SESSION['admin_info_type'] = 'info';
			header('location: ?page=user.facturiproforme');exit;
	break;

	case 'listfirms':
		$tpl->set_file("tpl_listfirm", "user/listfirms.tpl");
		$tpl->set_block('tpl_listfirm', 'alert_email_activare', 'alert_email_activaree');
		$tpl->set_block('tpl_listfirm', 'list_firme', 'list_firmee');
		$tpl->set_block('tpl_listfirm','if_firme','if_firmes' );
		
		$tpl->set_file("tpl_nofirm", "user/no_firme_block.tpl");

		$tpl->set_block('tpl_nofirm','list_servicii','list_servicii2');
		$tpl->set_block('tpl_nofirm','list_pachete','list_pachete2');
		$tpl->set_block('tpl_nofirm','list_reviews','list_reviews2');
		$tpl->set_block('tpl_nofirm', 'if_no_firme', 'if_no_firmee');
	
		
		$tpl->set_var('USERADDFIRM',"?page=user.addfirm" );
		$user_id = $_SESSION['userinfo']->id; $level="";
		$get_firme = GetFirme($user_id,"-1");
		
		//print_r($get_firme);
		if(count($get_firme )>0)
		{
			$i=0;
			foreach($get_firme as $ky => $val)
			{
				$x = ($i%2)+1;
				$tpl->set_var("BGCOLOR","row".$x);
				$tpl->set_var('NUME_FIRMA',$val['nume_firma'] );

				if($val['status']=='1')
				{
					$tpl->set_var('STATUSFIRMA',"Activ,  ".$val['nr_visits']." vizitatori" );
					$tpl->set_var('PREVIEW',ReWrite('cabinete_detalii','cabinete.detalii.'.$val['idfirma']) );
					$tpl->parse('alert_email_activaree', '');
				}
				else
				{	
					$tpl->set_var('STATUSFIRMA',"Inactiv" );
					$tpl->set_var('DATA_EXPIRARII',"");
					$tpl->set_var('PREVIEW',ReWrite('preview','preview.cabinet.'.$val['idfirma']));
					$tpl->parse('alert_email_activaree', 'alert_email_activare', true);
				}
				$tpl->set_var('DESCRIERE', substr($val['descriere'],0,200)."...");
				$tpl->set_var('EDITFIRMA', "?page=user.editfirme.". $val['idfirma']);
				##if we have more than one pachet
				//$pachete = showPromovareFunction($val['level'],$val['idfirma']);
				//$tpl->set_var('PACHET_PROMOVARE', $pachete);

				// show tip promovare
				$level = $val['level'];
				$get_tip_promovare = "";
				$user_pachet = $pachete->getTipPromovare($val['idfirma']);
				
				//this is for the new promovare using pachete and servicii
				if(is_array($user_pachet))
				{
					$pkInfo = $pachete->getPachetInfo($user_pachet['pachet']);
					$get_tip_promovare = $pkInfo['name']." - ".$user_pachet['pret']." RON/".$pkInfo['luni'].' luni';
				}
				else
				{
					if(stristr($val['level'],',')!==false)
					{
						$price = explode(",",$val['level']);
						foreach($price as $k => $v)
						{
							$pkInfo = $pachete->getPachetInfo($v);
							$get_tip_promovare = $get_tip_promovare." <br>".$pkInfo['name']." - ".$pkInfo['pret']." RON/".$pkInfo['luni'].' luni';
						}
					}
					else
					{
						$pkInfo = $pachete->getPachetInfo($val['level']);
						$get_tip_promovare = $pkInfo['name']." - ".$pkInfo['pret']." RON/".$pkInfo['luni'].' luni';
					}
				}
				$tpl->set_var('PACHET_PROMOVARE', $get_tip_promovare);
				
				/*if($val['level']=='1')
				{
					$tpl->set_var('PACHET_PROMOVARE', "<b>&nbsp;&nbsp;Pachet GRATUIT</b> <a href=\"?page=user.updatepachet.".$val['idfirma'].".abonament\"><img src=\"../images/allstufs/alege-abonament.jpg\"></a>");
					
				}*/


				/*
				if(($val['level']==2)&&($val['recomandat']=='Y'))
				{
					$tpl->set_var('PACHET_PROMOVARE', "Abonament + Recomandare pe judet");
					$tpl->set_var('UPDATE_PACHET_PROMOVARE', "");
				}
				elseif($val['level']=="2")
				{
					$tpl->set_var('PACHET_PROMOVARE', "Abonament");
					$tpl->set_var('UPDATE_PACHET_PROMOVARE', "");
				}
				else
				{
					$tpl->set_var('PACHET_PROMOVARE', "Pachet Gratuit");
					$tpl->set_var('UPDATE_PACHET_PROMOVARE', "<a href=\"?page=user.updatepachet.".$val['idfirma'].".abonament\">[ Alege Abonament ]</a>
					<br>
					<a href=\"?page=user.updatepachet.".$val['idfirma'].".recomandat\">[ Alege Recomandat ]</a>
					");
				}*/

				$array_type =array('1'=>"cabinetul",'2'=>"laboratorul",'3'=>"laboratorul",'4'=>"firma",'5'=>"clinica");
				$tyep_cabinet = $val['category_id'];
				$tpl->set_var('TYPE_CABINET', $array_type[$tyep_cabinet]);
				$array_type_promovare =array('1'=>"cabinete",'2'=>"laboratoare",'3'=>"laboratore",'4'=>"firme",'5'=>"clinici");
				$tpl->set_var('TYPE_CABINET_PROMOVARE', $array_type_promovare[$tyep_cabinet]);
				$array_type_rec =array('1'=>"recomandat",'2'=>"recomandat",'3'=>"recomandat",'4'=>"recomandat",'5'=>"recomandata");
				$tpl->set_var('RECOMANDAT_WORD', $array_type_rec[$tyep_cabinet]);
			
				$tpl->set_var('ALEGE_RECOMANDAT', "?page=user.updatepachet.".$val['idfirma'].".recomandat");
				$get_judet_infoss = JudetIdFromCategories($val['judet'],$val['category_id']);
				$tpl->set_var('JUDET_NAME',$get_judet_infoss['name']); 
				$url_categorie = ReWrite("cabinete","cabinete.".$val['category_id'].".".$get_judet_infoss['id']);
				$tpl->set_var('LINK_CABINET_RECOMANDAT',"<a href=\"".$url_categorie."\" target=\"_blank\">".$url_categorie."</a>" ); 
				$tpl->set_var('TYPE_CAUTARI',"cabinete stomatologice ".$get_judet_infoss['name'].", clinici stomatologice ".$get_judet_infoss['name'].",laboratoare ".$get_judet_infoss['name']." , distribuitori materiale stomatologice ".$get_judet_infoss['name']." etc." ); 

				$tpl->set_var('CAB_ID',$val['id'] ); 
				$main_image = GetCabineteMainPhoto($val['id'],'cabinet');
				if($main_image['image_name']=="")
				{
					$main_image['image_name']="default.jpg";
				}
				$count_images= GetCabineteImages($val['id']);
				$video = getCabinetVideoFile($val['id']);
				if (is_array($video) )
				{
					$tpl->set_var('NR_VIDEO', 1); 
				}
				else 
				{
				$tpl->set_var('NR_VIDEO', 0); 
				}

				$tpl->set_var('NR_IMAGINI',count($count_images) );
				$tpl->set_var('MODIFICA_IMAGINI',"?page=user.modificaimg.". $val['id'].".".$val['nume_firma']);
				$tpl->set_var('THUMBNAIL', "../sources/thumbnails.php?target=".$main_image['image_name'].'&max_size=120&folder='.$val['id']);
				$tpl->set_var('IDFIRMA', $val['idfirma']);
				$tpl->parse('list_firmee', 'list_firme', true);
				$i++;
			}
				$tpl->parse('if_firmes', 'if_firme', true);
		}

		#lets parse the review stuffs
	
		$reviewslist = $reviews->listRandomReviews();
		if(count($reviewslist)>0)
		{
			foreach ($reviewslist as $key => $value)
			{
				$tpl->set_var('REVIEW', $value['short_description']);
				$tpl->set_var('REVIEW_LINK', ReWrite('default','reviews'));
				$tpl->set_var('HASHTAG', 'review_'.$value['id']);
				$tpl->set_var('NAME', $value['name']);
				$get_cabinet = GetSelectedCabinet($value['cabinet_id']);
				$tpl->set_var('START_DATE', TimeFormatEvents($get_cabinet['date']));
				$tpl->set_var('CABINET_LINK', ReWrite('cabinete_detalii', 'cabinete.detalii.'.$value['cabinet_id']));
				$tpl->set_var('REVIEW_IMAGE', SITE_BASE.$value['image']);
				$tpl->parse('list_reviews2','list_reviews',true);
			}
		}
		else $tpl->parse('list_reviews2','');


		if( (count($get_firme) == '0') || ($level =='1'))
		{
			$user_id = $_SESSION['userinfo']->id;
			$i=1;
			$pk = $pachete->listPacheteFrontend('Y');
			foreach($pk as $ky => $val)
			{
				$tpl->parse('list_servicii2','');
				$tpl->set_var('PACHET',strtoupper($val['name']));
				$tpl->set_var('PACHET_STYLE', str_replace(" ","_",strtolower($val['name'])));
				$tpl->set_var('PACHET_PRICE', $val['pret']);
				
				if(!empty($val['discount']))
				{
					switch ($val['discount_type'])
					{
						case 'month':
							$tpl->set_var('PACHET_OFERTA', '<span class="oferta_speciala pull-left"></span>REDUCERE: ('.$val['discount'].'luni x '.$val['pret'].'RON), din valoarea totala !');
						break;
						
						case 'percent':
							$tpl->set_var('PACHET_OFERTA', '<span class="oferta_speciala pull-left"></span>REDUCERE: '.$val['discount'].'% din valoarea totala !');
						break;
					}
				}
				else 
				{
					
					$tpl->set_var('PACHET_OFERTA', "");
				}
				
				$j=1;
				$serv = $pachete->listPachetServicii($val['id']);
				foreach($serv as $k => $v)
				{
					$tpl->set_var('NR',$j);
					$tpl->set_var('SERVICE',$v['name']);
					$tpl->set_var('DESCRIPTION',$v['description']);
					$tpl->parse('list_servicii2','list_servicii',true);
					$j++;
				}
				$tpl->parse('list_pachete2','list_pachete',true);
				$i++;
			}
			
			$tpl->parse('if_no_firmee','if_no_firme',true);
			$tpl->parse("PROMOVARE_TEXT", "tpl_nofirm");
		}

		#if we have information messages
		if (isset($_SESSION['admin_info'])&&($_SESSION['admin_info']!=""))
		{
		
			$tpl->set_var('INFORMATION',"<p class=\"info\">".$_SESSION['admin_info']."</p>");
			#uset sessions
			unset($_SESSION['admin_info']);
			unset($_SESSION['admin_info_type']);
		}
		$tpl->parse("MAIN", "tpl_listfirm");
	break;
	
	case 'editfirme':
		$tpl->set_file("tpl_editfirme", "user/editfirma.tpl");
		$tpl->set_block('tpl_editfirme', 'judet', 'judett');
		$tpl->set_block("tpl_editfirme", "error", "error_block");
		$tpl->set_var('LOC_DIV_ADAUGAFIRMA',"Alegeti judetul intai!" );
		$tpl->set_var('MAX_PICTURE_WIDTH',$conf->max_img_anunt );
		$id_firma = $param1;
		$user_id=$_SESSION['userinfo']->id;
		$get_firm_info = GetFirme($user_id,$id_firma);
		
		$get_firm_info_real = $get_firm_info[0];
		
		$cab_status="0";
		foreach($get_firm_info_real  as $ky => $val)
		{
			if($ky=="category_id")
			{
					$get_dentist_categ = GetAnunturiCategories('Y', '');
					foreach($get_dentist_categ as $kky => $vall)
					{
						if($val==$vall['id'])
						{
							$tpl->set_var('CAT_NAME',$vall['name'] );
							$tpl->set_var('CAT_ID',$vall['id'] );
						}
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
			/*elseif($ky=="type")
			{
				if($val!="none")
				{
					$tpl->set_var('FACTURA_TYPE',$val );
					$tpl->set_file("tpl_formplace","user/".$val.".tpl");
					$tpl->set_var('EDITABLE',"readonly" );
					$tpl->parse('LOC_FORM_PLACE','tpl_formplace');
				}
				else
				{
					$tpl->set_var('PERIOADA', "1" );
					$tpl->set_var('FACTURA_TYPE',"Firma neplatitoare. Nu exista factura!" );
				}
			}*/
			
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
				$cab_status = $val;
			}
			/*elseif($ky=="expire_date")
			{
				$data_expirarii = $val;
			}*/
			else
			{
				
				$tpl->set_var(strtoupper($ky),$val );
			}
			
		}
		$tpl->set_var('MODIFICA_IMAGINI',"?page=user.modificaimg.". $get_firm_info_real['id'].".".$get_firm_info_real['nume_firma']);
		/*if($cab_status=="1")
			{
				$tpl->set_var('DATA_EXPIRARE',"<li>Firma dvs. va fi activa pana in data de : ".$data_expirarii."</li>" );
			}*/

		### servicii file stuff
		$servicii_file = getCabinetServiciiFile($id_firma);
		if (is_array($servicii_file) )
		{
			$file_type = explode(".",$servicii_file['name']);
			$file_ext = $file_type[count($file_type)-1];
			$tpl->set_var('SERVICII_FILE', "<A HREF='?page=user.downloadservicii.".$id_firma."'><b>".$servicii_file['name']."</b>&nbsp;&nbsp;&nbsp;&nbsp; <img src='../images/".$file_ext.".jpg'></A><br><i>Fisierul a fost adaugat in: </i>".TimeFormatShort($servicii_file['date'])); 
		}
		else 
		{
			$tpl->set_var('SERVICII_FILE',"Nu aveti nici un fisier adaugat !" ); 
		}
		

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
		$tpl->set_var('UPDATE_FIRMA',"?page=user.updatefirma.".$id_firma);
		$tpl->parse("MAIN", "tpl_editfirme");
	break;

	case 'updatefirma':
		$id_firma = $param1;
		$array_obligatorii = array("nume_firma"=>"nume firma","adresa_firma"=>"Adresa firma","inreg_fiscala_cnp"=>"Cod inregistrare fiscala/ CNP","reg_comert_bi"=>"Registru Comertului/BI serie numar","judet"=>"judet","nume_loc_sector"=>"Localitate/sector ","orar"=>"Orar","pers_contact"=>"Persoana de contact","persc_email"=>"Adresa de email","persc_tel"=>"Telefon persoana contact","persc_adresa"=>"Adresa persona contact");
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
				{	$display_errors .="<li>Adresa de e-mail este invalida</li>";	}
		}
		/*	#check nume firma
		$check_nume_firma = CheckNumeFirma($_POST['nume_firma']);
		if(isset($check_nume_firma)&&($check_nume_firma!=""))
		{
			$display_errors .= $check_nume_firma;
		}*/


		if($_FILES['servicii']['type']!="")
		{
			$result = CheckServiciiFile();
			if ($result == '0')
			{
				$display_errors.= '<li>Fisierul pentru Servicii si Tarife nu are extensia acceptata ! Va rugam sa adaugati doar fisier PDF sau Microsoft Office.</li>';
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
		else
		{

			### save servicii si tarife file !!!
			if($_FILES['servicii']['type']!="")
			{
				saveServiciiFileCabinet($id_firma);
			}

			$user_id = $_SESSION['userinfo']->id;array_pop($_POST);
			#lets remove link form content:D
			$_POST['descriere'] = RemoveAHref($_POST['descriere']);
			foreach($_POST as $ky => $val)
			{
				if(strpos($ky,"caractere")!==FALSE)
					{			unset($_POST[$ky]);	}
					else
					{
						$query="Update cabinete set ".$ky."='".mysql_real_escape_string(strip_tags($val,'<p><font><b><br><strong><i><u><font>'))."' WHERE id='".$id_firma."'";
						$db->query($query);
						if($ky=="judet")
						{		UpdateCabinetToCat($id_firma,$_POST['category_id'],$val);		}
						}
				}
				$query="Update cabinete set data_modificarii=now() WHERE id='".$id_firma."'";
				$db->query($query);
				//$update_alias_name = GenerateAlias($_POST['nume_firma']);
				//$query="Update cabinete set alias='".addslashes($update_alias_name)."' WHERE id='".$id_firma."'";
				//$db->query($query);

				$_SESSION['admin_info_type'] = 'info';
				$_SESSION['admin_info'] = "Modificarea a fost realizata cu succes!";
				header('location: '."?page=user.listfirms");exit;
			}
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

	case 'modifyvideo':
		$tpl->set_file("tpl_editfirme", "user/edit_video.tpl");
		$tpl->set_block('tpl_editfirme', 'list_video','list_video2');

		#this is for erros block, if we have information messages
		if (isset($_SESSION['admin_info'])&&($_SESSION['admin_info']!=""))
		{
			$tpl->set_file('tpl_info', '../admin/info/'.$_SESSION['admin_info_type'].'.tpl');
			$tpl->set_var('MESSAGE', $_SESSION['admin_info']);
			$tpl->parse('ERROR', 'tpl_info');
			#uset sessions
			unset($_SESSION['admin_info']);
			unset($_SESSION['admin_info_type']);
		}

		$tpl->set_var('CAB_ID', $param1); $i=0;
		$video = getCabinetVideoFile($param1);
		if (is_array($video) )
		{ //echo "s";
			//print_r($video);
			
			foreach($video as $kyy => $vaal)
			{
				$tpl->set_var('VIDEO_ID',$vaal['id']);
				if($vaal['type']!="")
				{
					$tpl->set_var('DATE_ADD',TimeFormatShort($vaal['date']) );
					$tpl->set_var('DIV_ID',"mp4_player");
					#this is some cod eto paly all video file type need to be improved
					/*$video_file = file_get_contents('../classes/modules/media/'.$video['type'].'.html');
					$tpl->set_var('VIDEO_FILE',$video_file );
					$path_for_video="../video/".$video['id'].'.'.$video['type'];
					$tpl->set_var('media_src',$path_for_video);*/
					$tpl->set_var('VIDEO_PATH',"../video/".$vaal['id'].'.'.$vaal['type']);
					//$tpl->parse('list_video2', 'list_video', true); 
				}

				if($vaal['youtube_url']!="")
				{
					$tpl->set_var('VIDEO_PATH',$vaal['youtube_url']);
					$tpl->set_var('DIV_ID',"youtube_player");
					$tpl->set_var('DATE_ADD',TimeFormatShort($vaal['date']) );
					 
				}
				$tpl->parse('list_video2', 'list_video', true); 
				$tpl->set_var('VIDEO_ID',$vaal['id']);
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
			$display_errors.= '<li>Va rugam adaugati un link Youtube sau selectati un fisier video!</li>';
		}
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
		header('location: ?page=user.modifyvideo.'.$param1);
		exit;
	break;

	case 'deletevideo':
			$video_id = $param1;
			$delete_video = DeleteVideo($video_id);
			$_SESSION['admin_info'] = "Fisierul video a sters din baza de date.";
			$_SESSION['admin_info_type'] = "info";
			header('location: '.GetReferer());
			exit;
	break;

	########################################## STUFFS ABOUT ADD,EDIT,INSER,MODIFY AN ANNOUNCE ##########################################
		
	case 'addanunt':
			$user_id = $_SESSION['userinfo']->id;
			$get_firme = GetFirme($user_id,"-1");
			
			/*if(count($get_firme)>0)
			{	$can_add = "Yes";	}
			else
			{	$can_add = "No";	}*/

			$tpl->set_file('tpl_main', 'user/adaugaanunt.tpl');
			$tpl->set_block('tpl_main', 'display_cats', 'display_catss');
			$tpl->set_block('tpl_main', 'judet', 'judett');
			$tpl->set_block('tpl_main', 'display_anunt', 'display_anunt_block');
			$tpl->set_block('tpl_main', 'error', 'error_block');
			$tpl->set_block('tpl_main', 'NOCABINET', 'NOCABINETT');
			

			$tpl->set_var('LOC_DIV_ADAUGAFIRMA',"Alegeti judetul intai!" );
			$tpl->set_var('TERMENIICONDITII', ReWrite("pagina","pagina.termeniconditii"));
			$tpl->set_var('INSERT_ANUNT',"?page=user.insertanunt");
			$tpl->set_var('META_KEYWORDS', $conf->def_meta_keywords);
			$tpl->set_var('META_DESCRIPTION', $conf->def_meta_description);

			$get_dentist_categ = GetAnunturiCategories('Y', '');
			foreach($get_dentist_categ as $kky => $vall)
				{
					$tpl->set_var('CAT_NAME',$vall['name'] );
					$tpl->set_var('CAT_ID',$vall['id'] );
					$tpl->parse('display_catss', 'display_cats', true);
				}
			
			#display error
			$get_dentist_judete = GetJudete();
			foreach($get_dentist_judete as $ky => $val)
			{
				$tpl->set_var('COD_JUDET',$val['code'] );
				$tpl->set_var('NUMEJUDET',$val['name'] );
				$tpl->parse('judett', 'judet', true);
			}
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
			$tpl->parse('display_anunt_block', 'display_anunt', true);
			$tpl->parse('MAIN', 'tpl_main', true);
	break;

	case 'insertanunt':
		$display_errors ="";
		if($_POST['titlu']=="")
		{	$display_errors .= " <li>Ati uitat sa completati titlul anuntutlui </li>";	}
		if($_POST['autor']=="")
		{		$display_errors .= " <li>Ati uitat sa completati autorul anuntutlui </li>";	}
		if($_POST['judet']=="")
		{		$display_errors .= " <li>Ati uitat sa completati judetul  </li>";	}
		if (array_key_exists('nume_loc_sector', $_POST)===FALSE) 
		{	$display_errors .= "<li>Ati uitat sa completati localitatea.</li>"; }
		if($_POST['email']=="")
		{	$display_errors .= " <li>Ati uitat sa completati e-mail-ul </li>";	}
		else
		{
			$email = ValidEmail($_POST['email']);
			if(!$email)
				{	$display_errors .="<li>Adresa de e-mail este invalida</li>";	}
		}
		if($_POST['continut_anunt']=="")
		{		$display_errors .= " <li>Ati uitat sa completati descrierea anuntului </li>";	}

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
				$display_errors .= '<li>'.'Imagine anunt - Va rugam respectati dimensiunile maxime admise!'.'</li>';
			}*/
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
		$user_id = $_SESSION['userinfo']->id;
		#lets remove link form content:D
		$_POST['continut_anunt'] = RemoveAHref($_POST['continut_anunt']);

		$id_anunt =	InsertAnunt($user_id, $_POST['titlu'], $_POST['continut_anunt'], $_POST['category_id'],$_POST['autor'],$_POST['email'],$_POST['judet'],$_POST['nume_loc_sector'],$_POST['meta_keywords'],$_POST['meta_description']);
		#daca avem setata poza pt cabinet o salvam
			if ($_FILES['imagine']['type'] != "" )
			{
				$extension = explode('/',$_FILES['imagine']['type']);
				$file_extension = $extension[1];//echo "extenis:".$file_extension;
				$image_name =	SavePicturesAnunturi($file_extension, $id_anunt,"frontend" );
				#we genereate small images in admin when we activet the file
				//echo '<img src="http://www.dentistonline.ro/upload_js/resize_image_thumb.inc.php?what_to_resize=anunturi&width=80&height=80&cropratio=1:1&image=//images/users_anunturi/'.$image_name.'">';
				
				//Generate_Small_Images_Anunt($user_id, $id_anunt);
				//require_once('../upload_js/resize_image_thumb.inc.php?what_to_resize=anunturi&width=80&height=80&cropratio=1:1&image=//images/users_anunturi/'.$image_name);exit;
			}
			else
			{
				SavePicturesAnunturi("default", $id_anunt,"frontend" );
			}
			
			$_SESSION['admin_info_type'] = 'info';
			$_SESSION['admin_info'] = "Anuntul a fost adaugat cu succes!";
			header('location: .?page=user.listanunturi');exit;
	break;

	case 'prelungesteanunt':
		$id_anunt = $param1;
		$sql = "Update anunturi set data_expirarii=date_add(`data_expirarii`,INTERVAL 6 MONTH) where id='".$id_anunt."'";
		$db->query($sql);
		$_SESSION['admin_info_type'] = 'info';
		$_SESSION['admin_info'] = "Anuntul dvs. a fost prelungit cu 6 luni!";
		header('location: ?page=user.listanunturi');exit;
	break;
	
	case 'listanunturi':
				$tpl->set_file("tpl_listanunt", "user/listanunturi.tpl");
				$tpl->set_block('tpl_listanunt', 'list_anunturi', 'list_anunturii');
				$tpl->set_block('tpl_listanunt','if_anunturi','if_anunturii' );
				$tpl->set_block('tpl_listanunt', 'if_no_anunt', 'if_no_anuntt');
				$tpl->set_var('USERADDANUNT',"?page=user.addanunt");
				$user_id = $_SESSION['userinfo']->id;
				$get_anunturi = GetAnunturi($user_id,"-1");
				if(count($get_anunturi )>0)
				{
					foreach($get_anunturi as $ky => $val)
					{
						$tpl->set_var('FRONTENDANUNT',"[ <a href=\"?page=user.editanunt.".$val['id']."\">".$val['titlu']."</a> ]" );
						$tpl->set_var('TITLU',$val['titlu'] );
						if($val['status']=='1')
						{		$tpl->set_var('STATUSANUNT',"Activ" );
								$tpl->set_var('PREVIEW',ReWrite('anunturi_detalii','anunturi.detalii.'.$val['id']) );
						}
						else
						{	
							$tpl->set_var('PREVIEW',ReWrite('preview','preview.anunt.'.$val['id']));
							$tpl->set_var('STATUSANUNT',"<p style=\"color:#CC0000\">Inactiv</p>" );	
			
						}

						$tpl->set_var('CONTINUT', text_best_fit($val['continut'],200));
						$tpl->set_var('EDITANUNT',"?page=user.editanunt.". $val['id']);
						$tpl->set_var('PRELUNGESTEANUNT', "?page=user.prelungesteanunt.". $val['id']);
						
						$tpl->set_var('THUMBNAIL', "../sources/thumbnails.php?target=".$val['imagine'].'&max_size=150&anunturi=yes');
						$tpl->set_var('IDANUNT', $val['id']);
						$tpl->set_var('DELETEANUNT',"?page=user.deleteanunt.".$val['id'] );
						$tpl->parse('list_anunturii', 'list_anunturi', true);
					}
						$tpl->parse('if_anunturii', 'if_anunturi', true);
				}
				else
				{	$tpl->parse('if_no_anuntt', 'if_no_anunt', true);	}
			
				#if we have information messages
				if (isset($_SESSION['admin_info'])&&($_SESSION['admin_info']!=""))
				{
					$tpl->set_var('INFORMATION', "<p class=\"info\">" .$_SESSION['admin_info']."</p>");
					#uset sessions
					unset($_SESSION['admin_info']);
					unset($_SESSION['admin_info_type']);
				}
				$tpl->parse("MAIN", "tpl_listanunt");
	break;
	
		
	case 'editanunt':
		$tpl->set_file('tpl_main', 'user/edit_anunt.tpl');
		$tpl->set_block('tpl_main', 'display_cats', 'display_catss');
		$tpl->set_block('tpl_main', 'judet', 'judett');

		$tpl->set_var('UPDATE_ANUNT',"?page=user.updateanunt.".$param1);
		$tpl->set_var('MAX_PICTURE_WIDTH',$conf->max_img_anunt );
		$tpl->set_var('TERMENIICONDITII', ReWrite("pagina","pagina.termeniconditii"));

		$user_id = $_SESSION['userinfo']->id;
		$get_anunturi = GetAnunturi($user_id,$param1);
		$tpl->set_var('SUBMISION_DATE',$get_anunturi[0]['data_adaugarii']);
		$tpl->set_var('EXPIRE_DATE',$get_anunturi[0]['data_expirarii']);
		$tpl->set_var('TITLU', $get_anunturi[0]['titlu']);
		$tpl->set_var('CONTINUT', $get_anunturi[0]['continut']);
		$tpl->set_var('AUTOR', $get_anunturi[0]['autor']);
		$tpl->set_var('EMAIL', $get_anunturi[0]['email']);
		$tpl->set_var('META_KEYWORDS', $get_anunturi[0]['meta_keywords']);
		$tpl->set_var('META_DESCRIPTION', $get_anunturi[0]['meta_description']);

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

		$get_ext = explode('.',$get_anunturi[0]['imagine']);
		if(trim($get_ext[1]==='png'))
		{
			$tpl->set_var('THUMBNAIL', "../sources/thumbnails.php?target=".$get_anunturi[0]['imagine'].'&max_size=300&anunturi=yes&ext=png');
		}
		else
		{
			$tpl->set_var('THUMBNAIL', "../sources/thumbnails.php?target=".$get_anunturi[0]['imagine'].'&max_size=300&anunturi=yes');
		}

		$get_dentist_categ = GetAnunturiCategories('Y', '');
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
		
	case 'updateanunt':
		$display_errors ="";
		if($_POST['titlu']=="")
		{		$display_errors .= " <li>Ati uitat sa completati titlul anuntutlui </li>";	}
			if($_POST['continut']=="")
		{		$display_errors .= " <li>Ati uitat sa completati descrierea anuntului </li>";	}
		if($_POST['autor']=="")
		{		$display_errors .= " <li>Ati uitat sa completati autorul anuntutlui </li>";	}
		if($_POST['judet']=="")
		{		$display_errors .= " <li>Ati uitat sa completati judetul  </li>";	}
	   if (array_key_exists('nume_loc_sector', $_POST)===FALSE) 
		{		$display_errors .= '<li>Ati uitat sa completati localitatea.<li>'; }
		if($_POST['email']=="")
		{		
			$display_errors .= " <li>Ati uitat sa completati e-mail-ul </li>";	
		}
		else
		{
			$email = ValidEmail($_POST['email']);
			if(!$email)
				{	$display_errors .="<li>Adresa de email este invalida</li>";	}
		}
		#this is the image for anunt
		if ($_FILES['imagine']['type']!= "")
		{
			$result =  CheckPictureItemAnunt();
			if ($result == '0')
			{
				$display_errors .=  '<li>'.'Imaginea pentru anunt nu are una din extensiile acceptate!'.'</li>';
			}
			elseif ($result == '1')
			{
				$display_errors .= '<li>'.'Imagine anunt - Va rugam respectati dimensiunile maxime admise!'.'</li>';
			}
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
		#lets remove link form content:D
		$_POST['continut']= RemoveAHref($_POST['continut']);
		UpdateAnunt($param1, $_POST['titlu'], $_POST['continut'], $_POST['category_id'],$_POST['autor'],$_POST['email'],$_POST['judet'],$_POST['nume_loc_sector'],$_POST['meta_keywords'],$_POST['meta_description'],"");
		//$update_alias_name = GenerateAlias($_POST['titlu']);
		//$query="Update anunturi set alias='".addslashes($update_alias_name)."' WHERE id='".$id_anunt."'";
		//$db->query($query);
		#daca avem setata poza pt anunt o salvam
			if ($_FILES['imagine']['type'] != "" )
			{
				$extension = explode('/',$_FILES['imagine']['type']);
				$file_extension = $extension[1];//echo "extenis:".$file_extension;
				SavePicturesAnunturi($file_extension, $id_anunt,"frontend" );
				Generate_Small_Images_Anunt($user_id, $id_anunt);
			}
			$_SESSION['admin_info_type'] = 'info';
			$_SESSION['admin_info'] = "Anuntul a fost modificat cu succes!";
			header('location: ?page=user.listanunturi');exit;
	break;

	case 'deleteanunt':
			$user_id = $_SESSION['userinfo']->id;
			$id_anunt = $param1;
				#prima data sa stergem pozele :D
				$sql = "SELECT * from anunturi where id='".$id_anunt ."'";
				$db->query($sql);
				$db->next_record();
				$img_name = $db->f('imagine');
				if(strpos($img_name,"default")===false)
				{		unlink("./images/users_anunturi/".$img_name);	}
			
			$query ="DELETE from anunturi where id='".$id_anunt."' and user_id='".$user_id."'";
			$db->query($query);
			
			$_SESSION['admin_info_type'] = 'info';
			$_SESSION['admin_info'] = "Anuntul a fost sters!";
			header('location: ?page=user.listanunturi');exit;
	break;
	########################################### ARTICLES STUFFS ################################################
	case 'addarticol':
		$user_id = $_SESSION['userinfo']->id;
		$get_firme = GetFirme($user_id,"-1");
		if(count($get_firme)>0)
		{	$can_add = "Yes";	}
		else
		{	$can_add = "No";
		$can_add = "Yes";
		}
		$tpl->set_file('tpl_main', 'user/adaugaarticol.tpl');
		$tpl->set_block('tpl_main', 'display_cats', 'display_catss');
		$tpl->set_block('tpl_main', 'display_anunt', 'display_anunt_block');
		$tpl->set_block('tpl_main', 'error', 'error_block');
		if($can_add=="Yes")
		{
			$tpl->set_var('INSERT_ARTICOL',"?page=user.insertarticol" );
			$tpl->set_var('META_KEYWORDS', $conf->def_meta_keywords);
			$tpl->set_var('META_DESCRIPTION', $conf->def_meta_description);

			$get_dentist_categ = GetArticlesCategories('Y', '');
			foreach($get_dentist_categ as $kky => $vall)
				{
					$tpl->set_var('CAT_NAME',$vall['cat_name'] );
					$tpl->set_var('CAT_ID',$vall['id_cat'] );
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
						$tpl->set_var(strtoupper($values[0]), $values[1]); 
				}
				unset($_SESSION['submit_anunt']);
			}
			
			$tpl->parse('display_anunt_block', 'display_anunt', true);
		}
		else
		{
			$tpl->set_var('NO_FIRM_ADD', "Daca doriti sa postati un articol trebuie sa aveti cel putin o firma adaugata!");
		}
		$tpl->parse('MAIN', 'tpl_main', true);
	break;

	case 'insertarticol':
		$display_errors ="";
		if($_POST['titlu']=="")
		{	$display_errors .= " <li>Ati uitat sa completati titlul articolului </li>";	}
		if($_POST['autor']=="")
		{		$display_errors .= " <li>Ati uitat sa completati autorul articolului </li>";	}
		if($_POST['email']=="")
		{	$display_errors .= " <li>Ati uitat sa completati e-mail-ul </li>";	}
		else
		{
			$email = ValidEmail($_POST['email']);
			if(!$email)
				{	$display_errors .="<li>Adresa de e-mail este invalida</li>";	}
		}
		if($_POST['continut_anunt']=="")
		{		$display_errors .= " <li>Ati uitat sa completati continutul articolului </li>";	}

		#this is the image for anunt
		if ($_FILES['imagine']['type']!= "")
		{
			$result =  CheckPictureItemAnunt();
			if ($result == '0')
			{
				$display_errors .=  '<li>'.'Imaginea pentru anunt nu are una din extensiile acceptate!'.'</li>';
			}
			elseif ($result == '1')
			{
				$display_errors .= '<li>'.'Imagine anunt - Va rugam respectati dimensiunile maxime admise!'.'</li>';
			}
		}
		#we check if we hav a pdf, word for our erticle
		if($_FILES['articol_file']['type']!="")
		{
			$result = CheckArticolFile();
			if ($result == '0')
			{
				$display_errors.= '<li>Extensia fisierului nu este acceptata ! Va rugam sa adaugati doar fisier PDF sau Microsoft Office.</li>';
			}
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
		
		#lets remove link form content:D
		$_POST['continut_anunt'] = RemoveAHref($_POST['continut_anunt']);
		$user_id = $_SESSION['userinfo']->id;
		$id_anunt =	InsertArticle($user_id, $_POST['titlu'], $_POST['continut_anunt'], $_POST['category_id'],$_POST['autor'],$_POST['email'],$_POST['meta_keywords'],$_POST['meta_description'],"");
		#daca avem setata poza pt cabinet o salvam
			if ($_FILES['imagine']['type'] != "" )
			{
				$extension = explode('/',$_FILES['imagine']['type']);
				$file_extension = $extension[1];
				SavePicturesArticles($file_extension, $id_anunt,"frontend" );
			}
			else
			{
				SavePicturesArticles("default", $id_anunt,"frontend" );
			}
			Generate_Small_Images_Article($id_anunt);
			### save article pdf,doc file !!!
			if($_FILES['articol_file']['type']!="")
			{
				saveArticolPdfFile($id_anunt);
			}

			$_SESSION['admin_info_type'] = 'info';
			$_SESSION['admin_info'] = "Articolul a fost adaugat cu succes!";
			header('location: ?page=user.listarticole');exit;
	break;
	
	case 'listarticole':
		$tpl->set_file("tpl_listarticole", "user/listarticole.tpl");
		$tpl->set_block('tpl_listarticole', 'if_abonament', 'if_abonament2');
		$tpl->set_block('tpl_listarticole', 'list_anunturi', 'list_anunturii');
		$tpl->set_block('tpl_listarticole','if_anunturi','if_anunturii' );
		$tpl->set_block('tpl_listarticole', 'if_no_anunt', 'if_no_anuntt');
		$user_id = $_SESSION['userinfo']->id;

		$if_abonament = getIfUserHasAbonament($user_id); 
		if($if_abonament)
		{
			$tpl->set_var('IF_ABONAMENT', "<p style='font-size:14px;line-height:24px;'>Datorita faptului ca ati achizitionat pachetul de promovare abonament, aveti posibilitatea de a alege care dintre articolele dvs va fii promovat in cadrul portalului stomatologic dentistonline.ro, la sectiunea articole recomandate ! Mentionam ca doar un singur articol poate fi recomandat.</p>");
		}
		else
		{
			$tpl->set_var('IF_ABONAMENT', "");
		}

		$get_anunturi = GetArticole($user_id,"-1");
		if(count($get_anunturi )>0)
		{
			foreach($get_anunturi as $ky => $val)
			{
				$tpl->set_var('FRONTENDANUNT',"[ <a href=\"?page=user.editarticol.".$val['id']."\" target=\"blank\">".$val['titlu']."</a> ]" );
				$tpl->set_var('TITLU',$val['titlu'] );
				if($val['status']=='1')
				{
					$tpl->set_var('STATUSANUNT',"Activ" );
					$tpl->set_var('PREVIEW', ReWrite('articole', 'articole-medicale.articol.'.$val['category_id'].'.'.$val['id']) );
				}
				else
				{
					$tpl->set_var('PREVIEW',ReWrite('preview','preview.articol.'.$val['id']));
					$tpl->set_var('STATUSANUNT',"<p style=\"color:#CC0000\">Inactiv</p>" );	
				}

				$tpl->set_var('CONTINUT', text_best_fit(ucfirst($val['continut']),200));
				$tpl->set_var('EDITANUNT', "?page=user.editarticol.". $val['id']);
				$tpl->set_var('THUMBNAIL', "../sources/thumbnails.php?target=".$val['imagine'].'&max_size='.$conf->admin_gallery_max.'&articles=yes');
				$tpl->set_var('IDANUNT', $val['id']);

				if($if_abonament)
				{
					if($val['recomandat']=='Y')
					{
						$tpl->set_var('IF_RECOMANDAT', "<p style='color:#B30000;'>Articol Recomandat</p>");
						$tpl->parse('if_abonament2', '');
					}
					else
					{
						$tpl->set_var('IF_RECOMANDAT', "");
						$tpl->parse('if_abonament2', 'if_abonament',true);
					}
				}


				$tpl->parse('list_anunturii', 'list_anunturi', true);
			}
				$tpl->parse('if_anunturii', 'if_anunturi', true);
		}
		else
		{
			$tpl->parse('if_no_anuntt', 'if_no_anunt', true);	}
			$tpl->set_var('USERADDARTICOL', "?page=user.addarticol");
			#if we have information messages
			if (isset($_SESSION['admin_info'])&&($_SESSION['admin_info']!=""))
			{
				$tpl->set_var('INFORMATION', "<p class=\"info\">".$_SESSION['admin_info']."</p>");
				#uset sessions
				unset($_SESSION['admin_info']);
				unset($_SESSION['admin_info_type']);
		}
		$tpl->parse("MAIN", "tpl_listarticole");
	break;

	case 'editarticol':
		$tpl->set_file('tpl_main', 'user/edit_articol.tpl');
		$tpl->set_block('tpl_main', 'error', 'error_block');
		$tpl->set_var('UPDATE_ARTICOL',"?page=user.updatearticol.".$param1 );
		$tpl->set_var('MAX_PICTURE_WIDTH',$conf->max_img_anunt );
		
		$user_id = $_SESSION['userinfo']->id;
		$get_anunturi = GetArticole($user_id,$param1);
		$tpl->set_var('SUBMISION_DATE',$get_anunturi[0]['data_adaugarii']);
		$tpl->set_var('TITLU', $get_anunturi[0]['titlu']);
		$tpl->set_var('CONTINUT', $get_anunturi[0]['continut']);
		$tpl->set_var('AUTOR', $get_anunturi[0]['autor']);
		$tpl->set_var('EMAIL', $get_anunturi[0]['email']);
		$tpl->set_var('META_KEYWORDS', $get_anunturi[0]['meta_keywords']);
		$tpl->set_var('META_DESCRIPTION', $get_anunturi[0]['meta_description']);
		$get_ext = explode('.',$get_anunturi[0]['imagine']);
			if(trim($get_ext[1]==='png'))
			{
				$tpl->set_var('THUMBNAIL', "../sources/thumbnails.php?target=".$get_anunturi[0]['imagine'].'&max_size='.$conf->admin_gallery_max.'&articles=yes&ext=png');
			}
			else
			{
				$tpl->set_var('THUMBNAIL', "../sources/thumbnails.php?target=".$get_anunturi[0]['imagine'].'&max_size='.$conf->admin_gallery_max.'&articles=yes');
			}
			$get_dentist_categ = GetArticlesCategories('Y', '');
			foreach($get_dentist_categ as $kky => $vall)
			{
				if($vall['id_cat']==$get_anunturi[0]['category_id'])
				{			
					$tpl->set_var('CAT_NAME',$vall['cat_name'] );
					$tpl->set_var('CAT_ID',$vall['id_cat']);	
			
				}
			}

		### get artcol file stuff
		$art_file = getArticolServiciiFile($param1);
		if (is_array($art_file) )
		{
			$file_type = explode(".",$art_file['name']);
			$file_ext = $file_type[count($file_type)-1];
			$tpl->set_var('ARTICOL_FILE', "<A HREF='?page=user.downloadarticolfile.".$param1."'><b>".$art_file['name']."</b>&nbsp;&nbsp;&nbsp;&nbsp; <img src='../images/".$file_ext.".jpg'></A><br><i>Fisierul a fost adaugat in: </i>".TimeFormatShort($art_file['date'])); 
		}
		else 
		{
			$tpl->set_var('ARTICOL_FILE',"Nu aveti nici un fisier adaugat !" ); 
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
						else
						{		$tpl->set_var(strtoupper($values[0]), $values[1]);}
				}
				unset($_SESSION['update_anunt']);
			}
			$tpl->parse('MAIN', 'tpl_main', true);
	break;

	case 'updatearticol':
		$display_errors ="";
		if($_POST['continut_anunt']=="")
		{		$display_errors .= " <li>Ati uitat sa completati continutul articolului </li>";	}
		
		if($_POST['autor']=="")
		{		$display_errors .= " <li>Ati uitat sa completati autorul articolului </li>";	}

			if($_POST['titlu']=="")
		{		$display_errors .= " <li>Ati uitat sa completati titlu articolului </li>";	}
		
		if($_POST['email']=="")
		{		
			$display_errors .= " <li>Ati uitat sa completati e-mail-ul </li>";	
		}
		else
		{
			$email = ValidEmail($_POST['email']);
			if(!$email)
				{	$display_errors .="<li>Adresa de e-mail este invalida</li>";	}
		}

		#this is the image for anunt
		if ($_FILES['imagine']['type']!= "")
		{
			$result =  CheckPictureItemAnunt();
			if ($result == '0')
			{
				$display_errors .=  '<li>'.'Imaginea pentru articolul nu are una din extensiile acceptate!'.'</li>';
			}
			elseif ($result == '1')
			{
				$display_errors .= '<li>'.'Imagine articol - Va rugam respectati dimensiunile maxime admise!'.'</li>';
			}
		}
		#we check if we hav a pdf, word for our erticle
		if($_FILES['articol_file']['type']!="")
		{
			$result = CheckArticolFile();
			if ($result == '0')
			{
				$display_errors.= '<li>Extensia fisierului nu este acceptata ! Va rugam sa adaugati doar fisier PDF sau Microsoft Office.</li>';
			}
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
		$_POST['continut_anunt']= RemoveAHref($_POST['continut_anunt']);
		UpdateArticle($_POST['category_id'], $_POST['titlu'], $_POST['continut_anunt'], intval($param1),$_POST['meta_keywords'], $_POST['meta_description'],$_POST['autor'],$_POST['email'],"");
		$sql="update articles set data_modificarii=now() where id='".$param1."'";
		$db->query($sql);
		
		### save article pdf,doc file !!!
			if($_FILES['articol_file']['type']!="")
			{
				saveArticolPdfFile($param1);
			}
		#daca avem setata poza pt articol o salvam
		if ($_FILES['imagine']['type'] != "" )
		{
			$extension = explode('/',$_FILES['imagine']['type']);
			$file_extension = $extension[1];//echo "extenis:".$file_extension;
			SavePicturesArticles($file_extension, $id_anunt,"frontend" );
			Generate_Small_Images_Article($id_anunt);
		}
		$_SESSION['admin_info_type'] = 'info';
		$_SESSION['admin_info'] = "Articolul a fost modificat cu succes!";
		header('location: ?page=user.listarticole');exit;
	break;

	case 'ajutor':
		$tpl->set_file('tpl_main', 'user/help.tpl');
		$tpl->set_var('PAGETITLE','Ajutor Manual utilizator, Intrebari si raspunsuri meniu utilizator' );
		$tpl->parse('MAIN','tpl_main',true );

		
	break;

	case 'add_articol_recomandat':
		$user_id = $_SESSION['userinfo']->id;
		$my_last_art_recomandat = getLastUserRecomandatArticle($user_id);
		if($my_last_art_recomandat!="")
		{
			## he can have only one article recomandat
			$sql = "UPDATE articles SET `recomandat`='N' WHERE `user_id`='$user_id'";
			$db->query($sql);

			$sql = "UPDATE articles SET `recomandat`='Y',`recomandam_articole`='".$my_last_art_recomandat['recomandam_articole']."' WHERE id='$param1'";
			$db->query($sql);
		}
		else
		{
			## he can have only one article recomandat
			$sql = "UPDATE articles SET `recomandat`='N' WHERE `user_id`='$user_id'";
			$db->query($sql);

			$sql = "UPDATE articles SET `recomandat`='Y' WHERE id='$param1'";
			$db->query($sql);
		}
		header("Location: ?page=user.listarticole");
		exit;
	break;

	case 'downloadarticolfile':
		$art_file = getArticolServiciiFile($param1);
		$filename = '../articole_file/'.$art_file['name'];
		$file_type = explode(".",$art_file['name']);
		$file_ext = $file_type[count($file_type)-1];

		## download the file !!!
		if ($file_ext=='pdf' )
		{
			// We'll be outputting a PDF
			header('Content-type: application/pdf');
			header('Content-Disposition: attachment; filename="'.$art_file['name'].'"');
		}
		elseif ($file_ext=='doc' )
		{
			// We'll be outputting a MSOffice file
			header('Content-type: application/msword');
			header('Content-Disposition: attachment; filename="'.$art_file['name'].'"');
		}

		// The file source
		readfile($filename);
		exit;
	break;

########################################## Account infos ##########################################
	#user home page
	case 'home':
		$tpl->set_file("tpl_home", "user/home.tpl");
		$tpl->set_var('EXPIRARE_PROFORMA',$conf->expirare_proforma);
		$tpl->set_block('tpl_home', 'no_cabinet', 'no_cabinets');
		$tpl->set_block('tpl_home', 'if_has_cabinet', 'if_has_cabinets');
		$check_firm = ChechIfHasfirmAdd($_SESSION['userinfo']->id);
		if(	$check_firm)
		{
				$tpl->parse('if_has_cabinets', 'if_has_cabinet', true);
		}
		else
		{
			$tpl->parse('no_cabinets', 'no_cabinet', true);
		}
		$tpl->parse("MAIN", "tpl_home");
	break;

	case 'publicitate':
		$tpl->set_file("tpl_pub", "user/publicitate.tpl");
		$user_id = $_SESSION['userinfo']->id;
		$get_firme = GetFirme($user_id,"-1");
		$tpl->set_block('tpl_pub','list_servicii','list_servicii2');
		$tpl->set_block('tpl_pub','list_pachete','list_pachete2');
		$tpl->set_block('tpl_pub','list_reviews','list_reviews2');
		
		$reviews = new Dentist_Reviews();
		$reviewslist = $reviews->listRandomReviews();
		if(count($reviewslist)>0)
		{
			foreach ($reviewslist as $key => $value)
			{
				$tpl->set_var('REVIEW', $value['short_description']);
				$tpl->set_var('REVIEW_LINK', ReWrite('default','reviews'));
				$tpl->set_var('HASHTAG', 'review_'.$value['id']);
				$tpl->set_var('NAME', $value['name']);
				$get_cabinet = GetSelectedCabinet($value['cabinet_id']);
				$tpl->set_var('START_DATE', TimeFormatEvents($get_cabinet['date']));
				$tpl->set_var('CABINET_LINK', ReWrite('cabinete_detalii', 'cabinete.detalii.'.$value['cabinet_id']));
				$tpl->set_var('REVIEW_IMAGE', SITE_BASE.$value['image']);
				$tpl->parse('list_reviews2','list_reviews',true);
			}
		}
		else $tpl->parse('list_reviews2','');
		
		$i=1;
		$pk = $pachete->listPacheteFrontend('Y');
		foreach($pk as $ky => $val)
		{
			$tpl->parse('list_servicii2','');
			$tpl->set_var('PACHET',strtoupper($val['name']));
			$tpl->set_var('PACHET_STYLE', str_replace(" ","_",strtolower($val['name'])));
			$tpl->set_var('PACHET_PRICE', $val['pret']);
			
			if(!empty($val['discount']))
			{
				switch ($val['discount_type'])
				{
					case 'month':
						$tpl->set_var('PACHET_OFERTA', '<span class="oferta_speciala pull-left"></span>REDUCERE: ('.$val['discount'].'luni x '.$val['pret'].'RON), din valoarea totala !');
					break;
					
					case 'percent':
						$tpl->set_var('PACHET_OFERTA', '<span class="oferta_speciala pull-left"></span>REDUCERE: '.$val['discount'].'% din valoarea totala !');
					break;
				}
			}
			else 
			{
				
				$tpl->set_var('PACHET_OFERTA', "");
			}
			
			$j=1;
			$serv = $pachete->listPachetServicii($val['id']);
			foreach($serv as $k => $v)
			{
				$tpl->set_var('NR',$j);
				$tpl->set_var('SERVICE',$v['name']);
				$tpl->set_var('DESCRIPTION',$v['description']);
				$tpl->parse('list_servicii2','list_servicii',true);
				$j++;
			}
			$tpl->parse('list_pachete2','list_pachete',true);
			$i++;
		}
		
		$tpl->parse("MAIN", "tpl_pub");
	break;
	
	case 'publicitate_new':
		$tpl->set_file("tpl_pub", "user/publicitate_new.tpl");
		$user_id = $_SESSION['userinfo']->id;
		$get_firme = GetFirme($user_id,"-1");
		$tpl->set_block('tpl_pub','list_servicii','list_servicii2');
		$tpl->set_block('tpl_pub','list_pachete','list_pachete2');
	
		$i=1;
		$pk = $pachete->listPacheteFrontend('Y');
		foreach($pk as $ky => $val)
		{
			$tpl->parse('list_servicii2','');
			$tpl->set_var('PACHET',strtoupper($val['name']));
			$tpl->set_var('PACHET_STYLE', str_replace(" ","_",strtolower($val['name'])));
			$tpl->set_var('PACHET_PRICE', $val['pret']);
			
			if(!empty($val['discount']))
			{
				switch ($val['discount_type'])
				{
					case 'month':
						$tpl->set_var('PACHET_OFERTA', '<span class="oferta_speciala pull-left"></span>DISCOUNT: ('.$val['discount'].'luni x '.$val['pret'].'RON), din valoarea totala !');
					break;
					
					case 'percent':
						$tpl->set_var('PACHET_OFERTA', '<span class="oferta_speciala pull-left"></span>DISCOUNT: '.$val['discount'].'% din valoarea totala !');
					break;
				}
			}
			else 
			{
				
				$tpl->set_var('PACHET_OFERTA', "");
			}
			
			$j=1;
			$serv = $pachete->listPachetServicii($val['id']);
			foreach($serv as $k => $v)
			{
				$tpl->set_var('NR',$j);
				$tpl->set_var('SERVICE',$v['name']);
				$tpl->set_var('DESCRIPTION',$v['description']);
				$tpl->parse('list_servicii2','list_servicii',true);
				$j++;
			}
			$tpl->parse('list_pachete2','list_pachete',true);
			$i++;
		}
		$tpl->parse("MAIN", "tpl_pub");
	break;
	

	#log out
	case 'logout':
		$user->Logout();
		header('location: '.Rewrite("default", "acasa"));
		exit;
	break;

	#account info form
	case 'account':
		$tpl->set_file("tpl_account", "user/account.tpl");
		$tpl->set_block("tpl_account", "error", "error_block");
		
		if (isset($_SESSION['account_errors']))
		{
			$tpl->set_var("ERROR_MSG", $_SESSION['account_errors']);
			unset($_SESSION['account_errors']);
			$tpl->parse("error_block", "error", true);
		}
		#display db values*/
		$tpl->set_var("FIRSTNAME", $_SESSION['userinfo']->firstname);
		$tpl->set_var("LASTNAME", $_SESSION['userinfo']->lastname);
		$tpl->set_var("EMAIL", $_SESSION['userinfo']->email);
		#if an error existed display values from post sesssion
		if (isset($_SESSION['account_array']))
		{
			foreach ($_SESSION['account_array'] as $key => $val)
			{
				$tpl->set_var(strtoupper($key), $val);
			}
			unset($_SESSION['account_array']);
		}
		#user action links
		$tpl->set_var("USER_SAVE_CHANGES_LINK", "?page=user.savechanges");
		$tpl->set_var("USER_PASSWORD_LINK", "?page=user.password");
		$tpl->parse("MAIN", "tpl_account");
	break;
		#change password form
	case 'password':
		$tpl->set_file("tpl_password", "user/password.tpl");
		$tpl->set_block("tpl_password", "error", "error_block");
		#show hint or error msg
		$tpl->set_var("ERROR_MSG", "!!! Dupa schimbarea parolei trebuie sa va logati din nou!");
		if (isset($_SESSION['password_errors']))
		{
			$tpl->set_var("ERROR_MSG", $_SESSION['password_errors']);
			unset($_SESSION['password_errors']);
		}
		$tpl->parse("error_block", "error", true);
		#set var
		$tpl->set_var('USER_SAVE-PASSWORD_LINK', '?page=user.save_password');
		$tpl->parse("MAIN", "tpl_password");
	break;

	#change password
	case 'save_password':
		$user->password = $_POST['old_password'];
		$user->pass_1 = $_POST['new_pass_1'];
		$user->pass_2 = $_POST['new_pass_2'];
		#validate the form
		$errors = array();
		$errors = $user->ValidateChangePassword();
		if (count($errors) != 0)
		{
			$display_errors = '';
			foreach ($errors as $val)
			{
				$display_errors .= '<li>'.$err_string[$val].'</li>';
			}
			$_SESSION['password_errors'] = $display_errors;
			header ('location: '.GetReferer());
			exit;
		}
		$user->username = $_SESSION['userinfo']->username;
		$user->id = $_SESSION['userinfo']->id;
		$user->ChangePassword($user->pass_1);
		#empty user array
		$_SESSION['userinfo'] = array();
		#create message
		$_SESSION['login_error'] = "Parola schimbata!Logati-va din nou";
		header ('location: '.ReWrite("default", "home"));
		exit;
	break;

	#account info update
	case 'savechanges':
		$user->firstname = $_POST['firstname'];
		$user->lastname = $_POST['lastname'];
		$user->email = $_POST['email'];
		$user->username = $_SESSION['userinfo']->username;
		$user->id = $_SESSION['userinfo']->id;
		$user->last_login = $_SESSION['userinfo']->last_login;

		#validate the form
		$errors = array();
		$errors = $user->ValidateChangeAccountInfo();
		if (count($errors) != 0)
		{
			$display_errors = '';
			foreach ($errors as $val)
			{
				$display_errors .= '<li>'.$err_string[$val].'</li>';
			}
			$_SESSION['account_errors'] = $display_errors;
			$_SESSION['account_array'] = array("firstname" => ''.$user->firstname.'',
																				 "lastname" => ''.$user->lastname.'',
																				 "email" => ''.$user->email.'');
			header ('location: '.GetReferer());
			exit;
		}
		$user->UpdateUser($_SESSION['userinfo']->id);

		#relogin automatically so user will see new info from his account
		//$user->Login($_SESSION['userinfo']->username, $user->GetPassword());
		#overwrite session information
		$_SESSION['userinfo'] = $user;
		#create message
		$_SESSION['account_errors'] = "<li> Modificarile au fost realizate cu succes </li>";
		header ('location: '.GetReferer());
		exit;
	break;
	########################################## Facturii stuffs ##########################################
	case 'facturiproforme':
		$tpl->set_file("tpl_factura", "user/facturaproforme.tpl");
		$tpl->set_block('tpl_factura', 'afiseaza_proforme', 'afiseaza_proforme_block');
		$tpl->set_block('tpl_factura', 'if_facturi', 'if_facturi_block');
		$tpl->set_block('tpl_factura', 'no_facturi', 'no_facturi_block');
		$user_id = $_SESSION['userinfo']->id;
		#split in 2steps - daca avem factura proforma nexpirata si inca nu exista factura fiscala dam date pentru factura proforma
		$get_info_factura_proforma = GetFacturiProformeForUser($user_id);
		if(count($get_info_factura_proforma)>0)
		{
			foreach($get_info_factura_proforma as $ky => $val)
			{
				$tpl->set_var('SERIE_PROFORMA',$val['id'] );
				$tpl->set_var('DATA_EMITERII',$val['adaugare_factura']);
				$tpl->set_var('DATA_EXPIRARII',$val['expirare_factura'] );
				$tpl->set_var('COST',$val['cost'] );
				$tpl->set_var('NUME_FIRMA',$val['nume_firma'] );
				
				$get_adr_email = GetAdrEmail($val['firma_id']);
				$tpl->set_var('ADRESA_EMAIL',$get_adr_email );
				
				$get_factura_fiscala = GetFiscalaForProforma($val['id']);
				if(count($get_factura_fiscala)>0)
				{
					$tpl->set_var('DET_FISCALA',"<a href=\"?page=user.vizualizarefiscala.".$get_factura_fiscala['serie_factura']."\">[ Factura: ".$get_factura_fiscala['serie_factura']."] </a>");
				}
				else
				{
					$tpl->set_var('DET_FISCALA',"Factura fiscala se va emite dupa confirmarea platii." );
				}
			
				$tpl->parse('afiseaza_proforme_block', 'afiseaza_proforme', true);
			}
			$tpl->parse('if_facturi_block', 'if_facturi', true);
		}
		else
		{
			
			$tpl->set_var('NO_FACTURA',"Momentan nu exista factura pentru dvs.!" );
			$tpl->parse('no_facturi_block', 'no_facturi', true);
		}
		#if we have information messages
		if (isset($_SESSION['admin_info'])&&($_SESSION['admin_info']!=""))
		{
		
			$tpl->set_var('INFORMATION',"<p class=\"info\">".$_SESSION['admin_info']."</p>");
			#uset sessions
			unset($_SESSION['admin_info']);
			unset($_SESSION['admin_info_type']);
		}
		$tpl->parse("MAIN", "tpl_factura");
	break;

	case 'vizualizareproforma':
		$tpl->set_file("tpl_factura", "user/viewfacturi.tpl");
		$user_id = $_SESSION['userinfo']->id;
		$id_proforma = $param1;
		$tpl->set_var('SERIE_FACTURA', "Proforma seria: ".$id_proforma);
		$text = GetFileContent("../facturi/facturi_proforme/proforma_".$id_proforma.".html");
		$tpl->set_var('LINK_TO_PRINT',"?page=user.printproforma.".$id_proforma );
		$tpl->set_var('FACTURA_CONTENT',$text );
		$tpl->parse("MAIN", "tpl_factura");
	break;

	case 'printproforma':
		$id_proforma = $param1;
		$text = GetFileContent("../facturi/facturi_proforme/proforma_".$id_proforma.".html");
		echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"><html><head>
		<script>
			function printWindow()
			{
			bV = parseInt(navigator.appVersion)
			if (bV >= 4) window.print();
			window.close();
			}
		</script>
		</head>
		<body onload="printWindow()">';echo  '<b>'. $text.'</b><br />';
		echo '</body></html>';
		#use exit so the all output wont be shown
		//header('location: index.php?page=user.facturiproforme');
		exit;
	break;

	case 'facturifiscale':
		$tpl->set_file("tpl_factura", "user/facturifiscale.tpl");
		$tpl->set_block('tpl_factura', 'afiseaza_proforme', 'afiseaza_proforme_block');
		$tpl->set_block('tpl_factura', 'if_facturi', 'if_facturi_block');
		$tpl->set_block('tpl_factura', 'no_facturi', 'no_facturi_block');
		$user_id = $_SESSION['userinfo']->id;
		$get_info_factura_proforma = GetFacturiForUser($user_id);
		if(count($get_info_factura_proforma)>0)
		{
			foreach($get_info_factura_proforma as $ky => $val)
			{
				$tpl->set_var('SERIE_PROFORMA',$val['serie_factura'] );
				$tpl->set_var('DATA_EMITERII',$val['data_eliberarii']);
				$tpl->set_var('SERVICIU_DIN',$val['serviciu_din']);
				$tpl->set_var('SERVICIU_EXPIRARE',$val['serviciu_expirare'] );
				
				$get_factura_fiscala = GetInfoProforma($val['id_proforma']);
				$tpl->set_var('COST',$get_factura_fiscala['cost']." RON" );

				$tpl->set_var('DET_FISCALA',"<a href=\"?page=user.vizualizareproforma.".$val['id_proforma']."\">[ Proforma : ".$val['id_proforma']."] </a>");
				$tpl->parse('afiseaza_proforme_block', 'afiseaza_proforme', true);
			}
			$tpl->parse('if_facturi_block', 'if_facturi', true);
		}
		else
		{
			
			$tpl->set_var('NO_FACTURA',"Momentan nu exista factura pentru dvs.!" );
			$tpl->parse('no_facturi_block', 'no_facturi', true);
		}
		$tpl->parse("MAIN", "tpl_factura");
	break;

	case 'vizualizarefiscala':
		$tpl->set_file("tpl_factura", "user/viewfacturi.tpl");
		$user_id = $_SESSION['userinfo']->id;
		$id_proforma = $param1;
		$tpl->set_var('SERIE_FACTURA',"Seria :".$id_proforma);
		$tpl->set_var('LINK_TO_PRINT',"?page=user.printfiscala.".$id_proforma );
		$text = GetFileContent("../facturi/facturi_fiscale/fiscala_".$id_proforma.".html");
		//echo $text;exit;
		$tpl->set_var('FACTURA_CONTENT',$text );
		$tpl->parse("MAIN", "tpl_factura");
	break;

	case 'printfiscala':
		$id_proforma = $param1;
		$text = GetFileContent("../facturi/facturi_fiscale/fiscala_".$id_proforma.".html");
		echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"><html><head>
		<script>
			function printWindow()
			{
			bV = parseInt(navigator.appVersion)
			if (bV >= 4) window.print();
			window.close();
			}
		</script>
		</head>
		<body onload="printWindow()">';echo  '<b>'. $text.'</b><br />';
		echo '</body></html>';
		#use exit so the all output wont be shown
		//header('location: index.php?page=user.facturifiscale');
		exit;
	break;

	case 'contract':
		$tpl->set_file("tpl_contract", "user/contract.tpl");
		$user_id = $_SESSION['userinfo']->id;
		$get_contracte = GetContracteForUser($user_id);	
		if(count($get_contracte)>0)
		{
			
		}
		else
		{
			$tpl->set_var('NO_CONTRACT',"Contractul se va emite doar dupa efectuarea plati conform facturii proforme." );
		}
		$tpl->parse("MAIN", "tpl_contract");
	break;
	##########################################Images stuffs  ##########################################
	case 'modificaimg':
		$tpl->set_file('tpl_main', 'user/list_images.tpl');
		$tpl->set_block('tpl_main', 'upload_block', 'upload_block2');
		$tpl->set_block('tpl_main', 'if_upload', 'if_upload2');
		$tpl->set_block('tpl_main', 'if_no_upload', 'if_no_upload2');

		$tpl->set_var('USER_ADD_IMAGES', '?page=user.addimage.'.$param1.".cabinet");
		$tpl->set_var('USER_ADD_IMAGE_HARTA','?page=user.addimage.'.$param1.".harta");


		$tpl->set_block('tpl_main', 'list_images', 'list_images2');
		$tpl->set_block('tpl_main', 'if_images', 'if_images_block');

		#imagine harta stuffs
		$tpl->set_block('tpl_main', 'if_images_harta', 'if_images_harta_block');
		$tpl->set_block('tpl_main', 'if_no_images_harta', 'if_no_images_harta2');
		#imagine banner stuffs
		$tpl->set_block('tpl_main', 'if_images_banner', 'if_images_banner_block');
		$tpl->set_block('tpl_main', 'if_no_images_banner', 'if_no_images_banner2');
		$tpl->parse('if_no_upload2', '');
		$tpl->parse('if_upload2', '');
		$user_id = $_SESSION['userinfo']->id;
		$get_firm_info = GetFirme($user_id,$param1);
		$get_firm_info_real = $get_firm_info[0]; 
		$tpl->set_var('NUME_FIRMA', ucfirst($get_firm_info_real['nume_firma']));
		
		$images = GetCabineteImages($param1);
		$harta="N";$plusharta=0;
		if(count($images)>0)
		{
			$i=0;
			foreach($images as $ky => $val)
			{
				if($val['type']=="cabinet")
				{
					$tpl->set_var('ORDER',$val['position'] );
					$tpl->set_var('IMG',"../images/users_cabinete/".$user_id."/".$val['image_name'] );
					$tpl->set_var('THUMBNAIL',"../sources/thumbnails.php?target=".$val['image_name'].'&max_size='.$conf->admin_gallery_max.'&folder='.$param1);
					$tpl->set_var('RE_ORDER_UP','?page=user.rearenge.up.'.$param1.'.'.$val['id'] );
					$tpl->set_var('RE_ORDER_DOWN','?page=user.rearenge.down.'.$param1.'.'.$val['id'] );
					$tpl->set_var('DELETE_IMAGE','?page=user.imagesdelete.'.$val['id']);
					$tpl->parse('list_images2', 'list_images', true);
				}
				else
				{
					$harta="Y";
					$plusharta=1;
					$tpl->set_var('THUMBNAIL_HARTA',"../sources/thumbnails.php?target=".$val['image_name'].'&max_size=150&folder='.$param1);
					$tpl->set_var('DELETE_IMAGE',"?page=user.imagesdelete.".$val['id']);
					$tpl->parse('if_images_harta_block', 'if_images_harta', true);
				}
				
			}
			$tpl->parse('if_images_block', 'if_images', true);
		}
		if($harta!="Y")
		{
			$tpl->parse('if_no_images_harta2', 'if_no_images_harta', true);
			
		}
		
		
		$tpl->set_var('USER_ADD_IMAGE_BANNER',"?page=user.savebanner.".$param1 );
		$get_banner = GetBanner($param1,'Y');
		if($get_banner!="")
		{
			$tpl->set_var('THUMBNAIL_BANNER',"../images/banner/".$get_banner['name']);
			$tpl->set_var('DELETE_BANNER',"?page=user.deletebanner.".$param1 );
			$tpl->parse('if_images_banner_block', 'if_images_banner', true);
		}
		else
		{
			$tpl->parse('if_no_images_banner2', 'if_no_images_banner', true);
		}
		#hai sa postam si baberul daca il avem
		$tpl->set_var('SIZE_MAX_IMG',$conf->max_img_cabinete );
		$left_images = 15 - count($images)+$plusharta;
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
			$tpl->set_var('NO_UPLOAD',"Nu mai puteti sa adaugati alte imagini. Aveti adaugate deja <b>15</b> imagini !" );
			$tpl->parse('if_no_upload2', 'if_no_upload', true);
			$tpl->parse('if_upload', '');
		}
		if (isset($_SESSION['admin_info'])&&($_SESSION['admin_info']!=""))
		{
			$tpl->set_var('ERROR',"<p class=\"info\">".$_SESSION['admin_info']."</p>");
			#uset sessions
			unset($_SESSION['admin_info']);
			unset($_SESSION['admin_info_type']);
		}
		$tpl->parse('MAIN', 'tpl_main');
	break;
	
	case 'savebanner':
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

	case 'deletebanner':
		$get_banner = GetBanner($param1);
		chmod("../images/banner/".$get_banner,0777);
		unlink("../images/banner/".$get_banner );
		$sql = "DELETE FROM banner WHERE cabinet_id='".$param1."'";
		$db->query($sql);
		header('location: '.GetReferer());
		exit;
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
		elseif($param2=='harta')
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
		
		if($display_errors!="")
		{
			$_SESSION['admin_info_type']="info";
			$_SESSION['admin_info'] = $display_errors;
			$_SESSION['message'] = $display_errors;
			header ('location: '.GetReferer());
			exit;
		}
		if($param2=="cabinet")
		{
			SavePicturesCabinete($param1,"frontend" );
			GenerateSmallImages($param1);
		}
		else{
			if ($_FILES['picture_harta']['type'] != "" )
			{
				$extension = explode('/',$_FILES['picture_harta']['type']);
				$file_extension = $extension[1];
				SavePicturesMap($file_extension, $param1,"frontend");
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
	
	case 'rearenge':
		#this function just reareange images pozitions in data base they were with position laike 40,50...etc
		//ReorderImagesPositions();exit;
		$_SESSION['admin_info_type'] = 'info';
		$_SESSION['admin_info'] = "Pozitia imaginii in galerie a fost modificata cu succes !";
		$count_images = GetCabineteImages($param2);
		$nr_imagini_cabinet = count($count_images) ;
		foreach ($count_images as $key => $val)
		{
			if($val['type']=='harta')
			{
				$nr_imagini_cabinet = $nr_imagini_cabinet-1;
			}
		}
		$new_dates = ReorderImagesNew($param3, $param1,$nr_imagini_cabinet);
		RearrangeImagesNew($param2,$param3,$new_dates,$param1);
		GenerateSmallImages($param2);
		header ('location: '.$_SERVER['HTTP_REFERER']);
		exit;
	break;

	case 'galerie':
		$tpl->set_file("tpl_listfirm", "user/galerie.tpl");
		$tpl->set_block('tpl_listfirm', 'list_firme', 'list_firmee');
		$tpl->set_block('tpl_listfirm','if_firme','if_firmes' );
		$tpl->set_block('tpl_listfirm', 'if_no_firme', 'if_no_firmee');
		$tpl->set_var('USERADDFIRM',"?page=user.addfirm" );
		$user_id = $_SESSION['userinfo']->id;
		$get_firme = GetFirme($user_id,"-1");
		if(count($get_firme )>0)
		{
			$i=0;
			foreach($get_firme as $ky => $val)
			{
				$x = ($i%2)+1;
				$tpl->set_var("BGCOLOR","row".$x);
				$tpl->set_var('NUME_FIRMA',$val['nume_firma'] );
				if($val['status']=='1')
				{		$tpl->set_var('STATUSFIRMA',"Activ" );
						$tpl->set_var('PREVIEW',ReWrite('cabinete_detalii','cabinete.detalii.'.$val['idfirma']));
				}
				else
				{	
				$tpl->set_var('STATUSFIRMA',"Inactiv" );
				$tpl->set_var('PREVIEW',ReWrite('preview','preview.cabinet.'.$val['idfirma']));
				}
				
				
				$main_image = GetCabineteMainPhoto($val['id'],'cabinet');
				if($main_image['image_name']=="")
				{	
					$main_image['image_name']="default.jpg";
				}
				$count_images = GetCabineteImages($val['id']);
				$tpl->set_var('NR_IMAGINI',count($count_images) );
				$tpl->set_var('MODIFICA_IMAGINI', "?page=user.modificaimg.". $val['id'].".".$val['nume_firma']);
				$tpl->set_var('THUMBNAIL', "../sources/thumbnails.php?target=".$main_image['image_name'].'&max_size='.$conf->admin_gallery_max.'&folder='.$val['id']);
				$tpl->set_var('IDFIRMA', $val['idfirma']);
				$tpl->parse('list_firmee', 'list_firme', true);
				$i++;
			}
				$tpl->parse('if_firmes', 'if_firme', true);
		}
		else
		{	$tpl->parse('if_no_firmee', 'if_no_firme', true);	}
		#if we have information messages
		if (isset($_SESSION['admin_info'])&&($_SESSION['admin_info']!=""))
		{
			$tpl->set_var('INFORMATION',"<div class=\"error\">".$_SESSION['admin_info']."</div>");
			#uset sessions
			unset($_SESSION['admin_info']);
			unset($_SESSION['admin_info_type']);
		}
		$tpl->parse("MAIN", "tpl_listfirm");
	break;

	#-------------------------------------------Mesaje STUFFS--------------------------------------------
	case 'mesaje':
		$tpl->set_file("tpl_mesaje", "user/mesaje.tpl");
		$tpl->set_block('tpl_mesaje', 'list_mesaje', 'list_mesajee');
		$tpl->set_block('tpl_mesaje','if_mesaje','if_mesajes' );
		$tpl->set_block('tpl_mesaje', 'if_no_mesaje', 'if_no_mesajee');
		$tpl->set_var('USERMESAJEDETALII',"?page=user.mesajedetalii");
		$user_id = $_SESSION['userinfo']->id;
		//echo $user_id;
		//******************************************************************************************
		$get_mesaje = GetMesaje($user_id,"all");
		//var_dump($get_mesaje);
		if(count($get_mesaje )>0)
		{
					$i=0;
					foreach($get_mesaje as $ky => $val)
					{
						#only if messaje is approved we show it
						if($val['status']==="Y")
						{
								$x = ($i%2)+1;
								$tpl->set_var("BGCOLOR","row".$x);
								$tpl->set_var('NUME_UTILIZATOR',ucwords($val['nume_utilizator']) );
								$tpl->set_var('EMAIL',$val['email_utilizator'] );
								$tpl->set_var('SUBIECT_MESAJ',ucfirst($val['subiect']));
								$tpl->set_var('MESAJ',ucfirst(substr($val['mesaj'],0,100)));
								$tpl->set_var('DETALIIMESAJ',"?page=user.detaliimesaj.".$val['id']);
								$tpl->set_var('DATA',TimeFormatShort($val['submision_date'] ) );
								$i++;
								$tpl->parse('list_mesajee', 'list_mesaje', true);
							}
							/*else
							{
								$tpl->parse('list_mesajee', '', false);
							}*/
				}
				$tpl->parse('if_mesajes', 'if_mesaje', true);
		}
		else
		{	$tpl->parse('if_no_mesajee', 'if_no_mesaje', true);	}	

		#if we have information messages
		if (isset($_SESSION['admin_info'])&&($_SESSION['admin_info']!=""))
		{
			$tpl->set_file('tpl_info', './admin/info/'.$_SESSION['admin_info_type'].'.tpl');
			$tpl->set_var('MESSAGE', $_SESSION['admin_info']);
			$tpl->parse('INFORMATION', 'tpl_info');
			#uset sessions
			unset($_SESSION['admin_info']);
			unset($_SESSION['admin_info_type']);
		}
		$tpl->parse("MAIN", "tpl_mesaje");
	break;
	
	case 'detaliimesaj':
		$id_msj = $param1;
		$tpl->set_file("tpl_mesaje", "user/detaliimesaj.tpl");
		$user_id = $_SESSION['userinfo']->id;
		$get_mesaje = GetMesaje($user_id,$id_msj);
		$i=1;
		foreach($get_mesaje as $ky => $val)
		{
			$x = ($i%2)+1;
			$tpl->set_var("BGCOLOR","row".$x);
			$tpl->set_var('NUME_UTILIZATOR',ucwords($val['nume_utilizator']) );
			$tpl->set_var('EMAIL',$val['email_utilizator'] );
			$tpl->set_var('SUBIECT_MESAJ',$val['subiect'] );
			$tpl->set_var('MESAJ',$val['mesaj']);
			$tpl->set_var('TELEFON',$val['telefon']);
			$tpl->set_var('DETALIIMESAJ', '?page=user.detaliimesaj.'.$val['id']);
			$tpl->set_var('DATA',TimeFormatShort($val['submision_date'] ));
			$i++;
		}
		$tpl->parse("MAIN", "tpl_mesaje");
	break;

	#-------------------------------------------Agenda pacieneti--------------------------------------------
	case 'agendapacienti':
		$tpl->set_file("tpl_pub", "user/agendapacienti.tpl");
		$tpl->parse("MAIN", "tpl_pub");
	break;
	#--------------------------------------------Statistici---------------------------------------------
	case 'statistici':
		$tpl->set_file("tpl_statistici", "user/statistici.tpl");
		$tpl->set_file("tpl_nofirm", "user/no_firme_block.tpl");

		$tpl->set_block('tpl_statistici', 'list_firme', 'list_firmee');
		$tpl->set_block('tpl_statistici','if_firme','if_firmes' );
		$tpl->set_block('tpl_statistici', 'if_no_firme', 'if_no_firmee');
		$user_id = $_SESSION['userinfo']->id;
		$tpl->set_var('UTILIZATOR',$_SESSION['userinfo']->username);
		$get_firme = GetFirme($user_id,"-1");
		if(getUserIP()=='79.117.19.240') $get_firme = GetFirme('32',"-1");
		
		if(count($get_firme )>0)
		{
			$i=0;
			foreach($get_firme as $ky => $val)
			{
				$tpl->set_var('NUME_FIRMA',$val['nume_firma'] );
				$tpl->set_var('NR_VIZITATORI',$val['nr_visits']);
				$tpl->set_var('ID_CABINET',$val['id']);
				
				$art_recomandat = getLastUserRecomandatArticle($user_id);
				if($art_recomandat!="")
				{
					$tpl->set_var('ART_RECOMANDAT', "<p style='color:black;'><i>Titlul articolului recomandat:</i> <a href='?page=user.listarticole'><b>".$art_recomandat['titlu']."</b></a></p>");
				}
				else
				{
					$tpl->set_var('ART_RECOMANDAT', "");
				}
				$tpl->set_var('NR_ACCESARI_TELEFON',$val['phone_views']);
				$pachete = showPromovareFunction($val['level'],$val['idfirma']);
				$tpl->set_var('UPDATE_PACHET_PROMOVARE', $pachete);

				$count_images = GetCabineteImages($val['id']);
				$tpl->set_var('NR_IMAGINI',count($count_images) );
				$tpl->set_var('MODIFICA_IMAGINI',"http://www.dentistonline.ro/admin_utilizator/?page=user.modificaimg.".$val['id'].".".$val['nume_firma']);
				
				$get_mesaje = GetMesaje($user_id,"all");
				$tpl->set_var('NR_MESAJE',count($get_mesaje));
				#doar cele care au abonament beneficiaza de aceste servicii
				$tpl->set_var('NR_AFISARI_HOME_PAGE',$val['home_page']);


				///	$art_details = GetArticole($user_id,$id_articol) $art_details[0]['recomandam_articole'] 
				$tpl->set_var('NR_AFISARI_ARTICOL',	0 );
				$a = getPromovareLevelDetails('2');
				$tpl->set_var('AFISARI_BANNER',	$a['recomandam_banner'] );
				$tpl->set_var('AFISARI_PRIMA_PAGINA',	$a['home_page'] );
				$tpl->set_var('AFISARI_ARTICOL',	$a['recomandam_articole']);


				$banner_det = getBannerDetails($val['id']);
				if(is_array($banner_det))
				{
					$tpl->set_var('NR_AFISARI_BANNER', $banner_det['recomandam_banner'] );
					$tpl->set_var('NR_AFISARI_BONUS',  $banner_det['total_afisari'] - $a['recomandam_banner']);
					$tpl->set_var('NR_AFISARI_TOTAL', $banner_det['total_afisari'] );
					$exist_banner = 1;
				}else
				{
					$tpl->set_var('NR_AFISARI_BANNER', '0');$exist_banner = 0;
				}

			

				$tpl->set_var('NR_BANNER',$exist_banner );
			
				$video = getCabinetVideoFile($val['id']);
				if (is_array($video) )
				{	$tpl->set_var('NR_VIDEO', 1); 		}
				else 
				{	$tpl->set_var('NR_VIDEO', 0); 		}
			
				
				$servicii_file = getCabinetServiciiFile($val['id']);
				if (is_array($servicii_file) )
				{
					$tpl->set_var('NR_SERVICII_TARIFE',	"1");
				}
				else 
				{
					$tpl->set_var('NR_SERVICII_TARIFE',	"0");
				}
				$tpl->parse('list_firmee', 'list_firme', true);
			}

				$tpl->parse('if_firmes', 'if_firme', true);
		}
		else
		{	$tpl->parse("PROMOVARE_TEXT", "Investeste in imaginea ta si promoveazate la standarde europene.");
			$tpl->parse('if_no_firmee', 'if_no_firme', true);	
			
		}
		
		// here we have the charts widget
		displayCabinetVisitorsStats($get_firme[0]['id']);
		displayCabinetEmailsStats($get_firme[0]['id']);
		displayCabinetPhoneStats($get_firme[0]['id']);
		
		//$tpl->parse("PROMOVARE_TEXT", "tpl_nofirm");
		$tpl->parse("MAIN", "tpl_statistici");
	break;

}
?>