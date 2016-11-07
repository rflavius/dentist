<?php


//echo $module." ".$action." ".$param1." ".$param2;
if($conf->url_rewrite_mode == 'Y')
{
		$new_acction = "";
		if(isset($param1) && $param1==="downloadservicii")
		{
			$new_acction = "downloadservicii";
		}
		if((isset($param1))&&(substr($param1,0,6)!="pagina")&&($action!='trimitemail')&&($action!='emailtrimis'))
		{
				if(strpos($param1,".html")!=FALSE)
				{
					$param1 = str_replace(".html","",$param1);
					//echo $param1;exit;
				}
				
				$jud_namee = $param1;
				$param1 = GetModuleLinkByNameJudet($param1,$action);
				$registry->route['param1'] = $param1;
				
		}
		if((isset($param2))&&(substr($param2,0,6)!="pagina")&&($param2!="")&&($action!='trimitemail')&&($action!='emailtrimis'))
		{
				///echo $module." ".$action." ".$param1." ".$param2;
				$action ="detalii";
				if($new_acction=='downloadservicii')
				{
					$action = "downloadservicii";
				}
				$param2 = str_replace(".html","",$param2);
				$param1 = GetCabinetIdByAlias($param2);
				$registry->route['action'] = $action;
				$registry->route['param1'] = $param1;
				$registry->route['param2'] = $param2;
		}
		if(($action=='trimitemail')||($action=='emailtrimis'))
		{
			
			$param1 = str_replace(".html","",$param2);
			$param1 = GetCabinetIdByAlias($param1);
			$registry->route['param1'] = $param1;
		}
}

$array_jud_res =array ("Sfantu Gheorghe" => "Covasna", 
						"Focsani" => "Vrancea",
						"Oradea"=>"Bihor",
						"Timisoara"=>"Timis",
						"Resita"=>"Caras-Severin",
						"Drobeta turnu Severin"=>"Mehedinti",
						"Zalau"=>"Salaj",
						"Baia Mare"=>"Maramures",
						"Miercurea Ciuc"=>"Harghita",
						"Tragoviste"=>"Dambovita",
						"Tragu Jiu"=>"Gorj",
						"Craiova"=>"Dolj",
						"Slatina"=>"Olt",
						"Pitesti"=>"Arges",
						"Alexandria"=>"Teleorman",
						"Ploiesti"=>"Prahova",
						"Slobozia"=>"Ialomita");

//echo $module.' => '.$action.' => '.$param1;

//if($action=='detalii' && $param1 == '2121' && in_array(getUserIP(), array('79.117.18.200', '89.34.170.32'))){ $action='detalii_responsive';}

switch ($action)
{
	default:
		$tpl->set_file('tpl_cabinete', 'modules/cabinete/cabinete.tpl');
		$tpl->set_block('tpl_cabinete','if_business','if_business2' );
		$tpl->set_block('tpl_cabinete','if_recomandat','if_recomandat2' );
		$tpl->set_block('tpl_cabinete','display_image','display_imagee' );
		$tpl->set_block('tpl_cabinete','Recomandam','Recomandamm' );
		$tpl->set_block('tpl_cabinete','rowdoicabs','rowdoicabss' );
		$tpl->set_block('tpl_cabinete', 'pagination_table', 'pagination_tablee');
		
		/**************************for pagination***********************/
		$pachete = new Pachete_Servicii($db);
		#create de pagination page_name
		$page_name = $module.'.'.$action;
		if((isset($param1))&&(substr($param1,0,6)!="pagina")&&($param1!=""))
		{
			$total_records = CountCabineteTotalRecordsFront("category", $param1, " AND A.recomandata = 'N' ");
			$page_name = $page_name.'.'.$param1;
			$cat_name = Get_Dentist_Cats($action);
			$cat_n=$cat_name[0]['name'];
			$cat_name[0]['name'] = strtolower(str_replace(" ","_",$cat_name[0]['name']));
			$rss_link = SITE_BASE."/rss/".$cat_name[0]['name']."/".$jud_namee.".xml";
			$tpl->set_var('RSS_FILE',"<a href='".$rss_link."' target='_blank' class='btn btn-sm btn-warning pull-right' title='Rss '".$cat_n." ".$jud_namee."' ><span class='glyphicon glyphicon-list-alt'></span></a>" );
			
			#here we make all stufs with recomandate
			$query_limit = '';
			$ii=0;
			$getrecomandate = GetCabinete(intval($action), $param1,$query_limit," And A.recomandata='Y' ");
			if($param1=='1')
			{
				/*$anca_rusu = array();
				$anca_rusu['id'] = '2120';
				$anca_rusu['nume_firma'] = 'Crystal Dental Clinc';
				$anca_rusu['descriere'] = strip_tags('Situata in centrul orasului Bucuresti, clinica stomatologica Crystal Dental Clinic a fost infiintata in anul 2000 si dispune de 9 cabinete moderne, dotate cu aparatura ce se ridica la cele mai inalte standarde internationale.,');
				$anca_rusu['judet'] = 'B';
				$anca_rusu['level'] = '5';
				$anca_rusu['image_name'] = 'pedo.jpg';
				$anca_rusu['submision_date'] ='2015-08-05';
				array_push($getrecomandate,$anca_rusu);

				$dental_praxis = array();
				$dental_praxis['id'] = '1304';
				$dental_praxis['nume_firma'] = 'DENTAL PRAXIS';
				$dental_praxis['descriere'] = strip_tags('Deviza  DENTAL PRAXIS este terapia fara durere prin respectarea celor mai inalte standarde de calitate si profesionalism.');
				$dental_praxis['judet'] = 'B';
				$dental_praxis['level'] = '5';
				$dental_praxis['image_name'] = 'dental-praxis.jpg';
				$dental_praxis['submision_date'] ='2012-01-05';
				array_push($getrecomandate,$dental_praxis);*/

				$asclepimed = array();
				$asclepimed['id'] = '169';
				$asclepimed['nume_firma'] = 'ASCLEPIMED Clinica stomatologica de supraspecialitate';
				$asclepimed['descriere'] = strip_tags('Clinica noastra ofera asistenta specializata in domeniul implantologiei, parodontologiei, chirurgiei oro-maxilo facial.');
				$asclepimed['judet'] = 'B';
				$asclepimed['level'] = '5';
				$asclepimed['image_name'] = 'Daniel-Iordachescu-asclepimed-receptie.jpg';
				$asclepimed['submision_date'] ='2008-03-03';
				array_push($getrecomandate,$asclepimed);
			}

			//http://www.dentistonline.ro/images/smallimages/cabinete/1127/default.jpg
			//http://www.dentistonline.ro/images/smallimages/cabinete/default.jpg
			//	print_r($getrecomandate);
			$nr_cabinete_recomandate = count($getrecomandate);
			$nr_randuri = ceil($nr_cabinete_recomandate/3);
			$j = 0;  #i want to count the rows, to parse only then the empty cabinete
			if($nr_cabinete_recomandate>0)
			{
				$tpl->set_file('tpl_cabinete_rec', 'modules/cabinete/recomandat.tpl');
				$tpl->set_block('tpl_cabinete_rec','no_display_cabinete','no_display_cabinetee' );
				$tpl->set_block('tpl_cabinete_rec','display_cabinete','display_cabinetee' );
				//$tpl->set_block('tpl_cabinete_rec','display_cabinete_row','display_cabinete_roww');
				$nr_cabinete_goale = 3 - ($nr_cabinete_recomandate%3);
				shuffle($getrecomandate);
				foreach($getrecomandate as $ky => $val)
				{
					$tpl->set_var('NUME_FIRMA_REC', $val['nume_firma']);
					$tpl->set_var('DESCRIERE_REC', text_best_fit($val['descriere'],130));
					$tpl->set_var('IMAGE_REC',SITE_BASE.'/images/smallimages/cabinete/'.$val['id'].'/'.$val['image_name']);		
					$tpl->set_var('URLCITESTE_REC', ReWrite('cabinete_detalii', 'cabinete.detalii.'.$val['id']));
					$tpl->parse('display_cabinetee', 'display_cabinete', true);	
				}
				$tpl->parse('DISPLAY_RECOMANDAT','tpl_cabinete_rec');
			}
			else
			{
				$tpl->parse('display_imagee', 'display_image', true);
			}
			$tpl->parse('Recomandamm', 'Recomandam', true);
		}
		elseif((isset($param1) && substr($param1,0,6)=="pagina") || (empty($param1) || !isset($param1)))
		{
			$total_records = CountCabineteTotalRecordsFront("module", $action);
			$tpl->set_var('RSS_FILE',"" );
		}
		$tpl->set_var('COUNT_CABINETE', $total_records);
		$pages_number = ceil($total_records/$conf->cabinete_anunturi_per_page);
		$tpl->set_var("PAGES", $pages_number);
		if($conf->url_rewrite_mode == 'Y')
		{
			if(isset($param1)&&(substr($param1,0,6)=="pagina"))
			{		$start = substr($param1,6);	}
			elseif(isset($param2)&&(substr($param2,0,6)=="pagina"))
			{	$start = substr($param2,6);	}
		}

		if(!isset($start))
		{
			$start_q = 0;
			$start = 1;
		}
		else
		{
			$start_q = $conf->cabinete_anunturi_per_page*($start-1);
		}
		#Create and parse pagination
		$html_pages = FrontEndPagination($conf->cabinete_anunturi_per_page, $total_records, $page_name, $start);
		$tpl->set_var("PAGINATION", $html_pages);
		#Create query limit and get the cabinete for displaing
		$query_limit = " LIMIT $start_q, $conf->cabinete_anunturi_per_page";
		#only if we are on the category page-judet to display cabinetele
		if((isset($param1))&&(substr($param1,0,6)!="pagina")&&($param1!=""))
		 {
				$cabinete = GetCabinete(intval($action), $param1, $query_limit, " AND A.recomandata='N' ");
				if($param1=='34')
				{
					#here we add our cabinet that will be promote at bouth cabinete and clinici
					$cericimina = array();
					$cericimina['id'] = '228';
					$cericimina['nume_firma'] = 'CMI Dr.Cerici Mina-Mihail ';
					$cericimina['descriere'] = strip_tags('Echipa de profesionisti, tehnologia de ultima generatie, serviciile stomatologice integrate si timpul scurt de solutionare a problemelor stomatologice.');
					$cericimina['judet'] = 'PH';
					$cericimina['level'] = '2';
					$cericimina['image_name'] = 'dr-cerici-mina.jpg';
					$cericimina['submision_date'] ='2008-03-03';
					array_unshift($cabinete,$cericimina);
				}
		}
		else
		{
			$cabinete = GetCabinete(intval($action), '', $query_limit,"");
		}
		// $cabinete = GetCabinete(intval($action), $param1,$query_limit,"");
		//var_dump($cabinete);
		$i=0;
		foreach($cabinete as $ky => $v)
		{
			$tpl->parse('if_business2', '');
			$recomandat = false;
			$tpl->set_var('NUME_FIRMA', ucwords(strtolower(text_best_fit($v['nume_firma'],30))));
			$tpl->set_var('DESCRIERE', text_best_fit(strtolower(strip_tags($v['descriere'])),100));
			$tpl->set_var('IMAGE', SITE_BASE.'/images/smallimages/cabinete/'.$v['id'].'/'.$v['image_name']);	
			if(($v['image_name'])=='default.jpg')
			{
				$tpl->set_var('IMAGE', SITE_BASE.'/images/users_cabinete/default.jpg');	
			}

			if($pachete->ifPachetFree($v['level'])===false)
			{
				$tpl->parse('if_business2', 'if_business', true);
			}
			
			if($pachete->hasRecomandat($v['level']))
			{
				$recomandat = true;
			}
			if($recomandat)
			{
				$tpl->set_var('RECOMANDAT_CLASS','recomandat');
				$tpl->parse('if_recomandat2','if_recomandat',true);
			}
			else
			{
			  $tpl->set_var('RECOMANDAT_CLASS','');
			  $tpl->parse('if_recomandat2','');
			}
			$tpl->set_var('URLCITESTE', ReWrite('cabinete_detalii', 'cabinete.detalii.'.$v['id']));
			$judet_code = $v['judet'];
			$get_judet_infoss = JudetIdFromCategories($judet_code,$action);
			$judet_name = $get_judet_infoss['name'];
			$just_judet_name = $judet_name;
			$tpl->set_var('JUDET_NAME',	$judet_name  );
						
			$url_categorie = ReWrite("cabinete","cabinete.".$action.".".$get_judet_infoss['id']);
			switch($action)
			{
				case '1':
						
						$cat_name = "Cabinete stomatologice ".$judet_name;
						$categ_hrf = "Stomatologie ".$judet_name;
						$tpl->set_var('REC_TYPE','Cabinetul tau stomatologic' );
						$tpl->set_var('REC_TYPE_2','cabinete' );
						$tpl->set_var('REC_JUDET',$judet_name );
						$tpl->set_var('AHREFCABS',$v['nume_firma'] );
				break;
				
				case '5':
					$cat_name = "Clinici stomatologice ".$judet_name;
					$tpl->set_var('AHREFCABS',$v['nume_firma'] );
					$categ_hrf = "Clinici de stomatologie ".$judet_name;
					$tpl->set_var('REC_TYPE','Clinica ta stomatologica' );
					$tpl->set_var('REC_TYPE_2','clinici' );
					$tpl->set_var('REC_JUDET',$judet_name );
				break;
				
				case '2':
					$cat_name = "Tehnica dentara ".$judet_name ;
					$tpl->set_var('AHREFCABS',"Laborator tehnica dentara ".$v['nume_firma'] );
					$categ_hrf= "Laboratoare tehnica dentara din ".$judet_name;
					$tpl->set_var('REC_TYPE','Laboratorul tau de tehnica dentara' );
					$tpl->set_var('REC_TYPE_2','laboartoarele dentare' );
					$tpl->set_var('REC_JUDET',$judet_name );
				break;
				
				case '4':
					$cat_name = "Distribuitori materiale ".$judet_name;
					$tpl->set_var('AHREFCABS',"Distribuitor materiale ".$v['nume_firma'] );
					$categ_hrf = "Lista distribuitori materiale din ".$judet_name;
					$tpl->set_var('REC_TYPE','Firma ta de distributie materiale stomatologice' );
					$tpl->set_var('REC_TYPE_2','firme' );
					$tpl->set_var('REC_JUDET',$judet_name );
				break;
				
				case '3':
					$cat_name = "Radiologie dentara ".$judet_name ;			
					$tpl->set_var('AHREFCABS',$v['nume_firma'] );
					$categ_hrf = "Lista laboratoarelor de radiologie dentara din ".$judet_name ;
					$tpl->set_var('REC_TYPE','Laboratorul tau de radiologie dentara' );
					$tpl->set_var('REC_TYPE_2','laboartoarele dentare' );
					$tpl->set_var('REC_JUDET',$judet_name );
				break;
				

			}
			//$tpl->set_var('CAT_DETAILS_HERE',$cat_name );
			//print_r($param1);
			//print_r($action);
			//print_r($cat_name);
			if(isset($action) && !is_numeric($param1))
			{
				$tpl->set_var('CAT_DETAILS_HERE',"<a href='".$url_categorie."' title='".$categ_hrf."'>".$cat_name."</a>" );
				//$tpl->set_var('CATEGORY_NAME',$categ_hrf );

			}
			$tpl->parse('rowdoicabss', 'rowdoicabs', true);	
		}
		$tpl->parse('pagination_tablee', 'pagination_table', true);
			
			
		//parse the H2 page title
		if(isset($judet_name) && in_array($judet_name,$array_jud_res))
		{
			$resedinta = array_keys($array_jud_res, $judet_name);
			$res = $resedinta[0];
			$judet_name = $res.' - '.$judet_name;
		}
		elseif(!empty($jud_namee)) $judet_name = ucwords(str_replace("_"," ",$jud_namee));
		
		switch($action)
		{
			case '1':
				if(!is_numeric($param1))
				{	$cat_name = "Cabinete stomatologice";				}
				else
				{	
					$cat_name = "Cabinete stomatologice ".$judet_name;				
					//$tpl->set_var('OTHER_CATEGORY', "Vezi si: <a href='http://www.dentistonline.ro/Clinici-Stomatologice/$just_judet_name.html'>Clinici stomatologice ".$judet_name."</a>");
				
				}
				$tpl->set_var('CATEGORY_NAME', $cat_name);
				$tpl->set_var('RECOMANT_CATEGORY_NAME', "Cabinete stomatologice");
			break;
		
			case '5':
				if(!is_numeric($param1))
				{	$cat_name = "Clinici stomatologice";				}
				else 
				{	$cat_name = "Clinici stomatologice ".$judet_name;	
					//$tpl->set_var('OTHER_CATEGORY', "Vezi si: <a href='http://www.dentistonline.ro/Cabinete-Stomatologice/$just_judet_name.html'>Cabinete stomatologice ".$judet_name."</a>");
				}
				$tpl->set_var('CATEGORY_NAME', $cat_name);
				$tpl->set_var('RECOMANT_CATEGORY_NAME', "Clinici stomatologice");
			break;
		
			case '2':
				if(!is_numeric($param1))
				{	$cat_name = "Tehnica dentara";				}
				else 
				{	$cat_name = "Tehnica dentara ".$judet_name ;				}				
				$tpl->set_var('CATEGORY_NAME',"Laboratoare ".$cat_name );
				$tpl->set_var('RECOMANT_CATEGORY_NAME', "Laboratoare tehnica dentara");
			break;
		
			case '4':
				if(!is_numeric($param1))
				{	$tpl->set_var('CATEGORY_NAME', "Distribuitori/Depozite materiale stomatologice");	}
				else 
				{	$tpl->set_var('CATEGORY_NAME', "Distribuitori/Depozite materiale stomatologice ".$judet_name );	}
				$tpl->set_var('RECOMANT_CATEGORY_NAME', "Distribuitori/Depozite materiale stomatologice");
			break;
		
			case '3':
				if(!is_numeric($param1))
				{	$tpl->set_var('CATEGORY_NAME',"Laboratoare radiologie dentara");	}		
				else 
				{	$tpl->set_var('CATEGORY_NAME',"Laboratoare radiologie dentara ".$judet_name);	}
				$tpl->set_var('RECOMANT_CATEGORY_NAME', "Laboratoare radiologie dentara");
			break;
		}

		$tpl->parse('MAIN', 'tpl_cabinete');
	break;

	case 'detalii_old':
		$get_cabinet = GetSelectedCabinet(intval($param1));
		if((($get_cabinet['status']!='1')||(!isset($get_cabinet['status']))) && $param1!='1890')
		{
			FakeError ();
			$tpl->set_file('tpl_main', 'unpublished.tpl');
			$tpl->set_var('ERRORMSG', 'Aceasta pagina nu este disponibila');
			$tpl->parse('MAIN', 'tpl_main');
		}
		else
		{
			$pachete = new Pachete_Servicii($db);
			$user_pachet = $pachete->getTipPromovare(intval($param1));
			//print_r($user_pachet);			
			//this is for the new promovare using pachete and servicii
			if(is_array($user_pachet) && $param1=='1890')
			{
				$tpl->set_file('tpl_details', 'modules/cabinete/details_new.tpl');
				$tpl->set_block('tpl_details', 'related_cabinete', 'related_cabinete_block');
				$tpl->set_block('tpl_details', 'articole_create', 'articole_createe');
				$tpl->set_block('tpl_details', 'if_articles', 'if_articless');
				$tpl->set_block('tpl_details', 'list_video', 'list_video2');
				$tpl->set_block('tpl_details', 'prezentare_video', 'prezentare_video2');
				$tpl->set_block('tpl_details', 'anunturi_create', 'anunturi_createe');
				$tpl->set_block('tpl_details', 'if_anunturi', 'if_anunturii');
				$tpl->set_block('tpl_details', 'localizare_harta', 'localizare_harta2');
				$tpl->set_block('tpl_details', 'servicii_tarife', 'servicii_tarife2');

				if($user_pachet['pachet']=='1')
				{
					if($user_pachet['servicii']!='')
					{
						$s = explode(";",$user_pachet['servicii']);
						$info='';
						$i=0;
						foreach($s as $ky => $val)
						{
							if($val!='')
							{
								$info[$i] = $pachete->getServiciuInfo($val);
								$i++;
							}
						}
					}
					else 
					{
						$pkInfo = $pachete->getPachetInfo($user_pachet['pachet']);
						$s = explode(";",$pkInfo['servicii']);
						$info='';
						$i=0;
						foreach($s as $ky => $val)
						{
							if($val!='')
							{
								$info[$i] = $pachete->getServiciuInfo($val);
								$i++;
							}
						}
					}
					$servicii = $info;
				}
				else 
				{
					$pkInfo = $pachete->getPachetInfo($user_pachet['pachet']);
					$servicii = $pachete->listPachetServicii($pkInfo['pachet']);
				}

				#lets inser_nr wievs
				UpdateCabinetViews($param1);
				UpdateCabinetRecent($param1);
				$tpl->set_var('SITEBASE', SITE_BASE);
				$tpl->set_var('IMAGESDIR',SITE_BASE.'/images/allstufs' );
				$tpl->set_var('MAXTHUMBNAILSIZE',$conf->normal_img_cabinete);
				$tpl->set_var('CAB_ID',$param1);
				
				if($pachete->checkIfServiciuAvailable($servicii,'localizare'))
				{
					$get_image_map = GetCabineteMainPhoto(intval($param1),"harta");
					$map_exists = 0;
					if(count($get_image_map)>0 &&($get_image_map['image_name']!="" ))
					{
						$map_exists=1;	$tpl->set_var('THUMBNAIL2',SITE_BASE."/sources/thumbnails.php?target=".$get_image_map['image_name'].'&max_size=165&folder='.$param1);
						$tpl->set_var('SRC_FINAL',$param1."/".$get_image_map['image_name'] );
					}
					else
					{
						$tpl->set_var('THUMBNAIL2',SITE_BASE.'/sources/thumbnails.php?target=default.jpg&max_size=165');
						$tpl->set_var('SRC_FINAL','default.jpg' );
					}
					$tpl->parse('localizare_harta2','localizare_harta',true);
				}
				else
				{
					$tpl->parse('localizare_harta2','');
				}
				
				if($pachete->checkIfServiciuAvailable($servicii,'adresa web'))
				{
					$tpl->set_var('WEBSITE_URL',ReWrite('cabinete_detalii', 'cabinete.detalii.'.$param1) );
				}
				
				foreach($get_cabinet  as $ky => $val)
				{
					if($ky=="judet")
					{
						$get_judet = GetJudet("code",$val);
						$tpl->set_var('JUDET',$get_judet['name']  );
					}
					elseif($ky=="nume_loc_sector")
					{
						$nume_loc = GetLocalitate($val);
						$tpl->set_var('NUME_LOC_SECTOR',$nume_loc['name'] );
					}
					else
					{
						if(!isset($val)||($val==" "))
						{
							$tpl->set_var(strtoupper($ky),"-");
						}
						else
						{
							if($ky=='tarife')
							{
								if($pachete->checkIfServiciuAvailable($servicii,$ky))
								{
									$tpl->set_var(strtoupper($ky),nl2br(trim($val)));
								}
								else 
								{
									$tpl->set_var(strtoupper($ky),'');
								}
							}
							else 
							{
								$tpl->set_var(strtoupper($ky),nl2br(trim($val)));
							}
						}
					}
				}
				
				$tpl->set_var('SHORT_PHONE',substr($get_cabinet['fax'],0,5));
				
				//$tpl->set_block('tpl_details', 'images_block', 'images_block2');
				$tpl->set_block('tpl_details', 'imgessmall', 'images_block3');
				$main_photo = GetCabineteMainPhoto($param1,"cabinet");
				if($main_photo['image_name']=="")
				{
					$tpl->set_var('MAIN_PHOTO',SITE_BASE.'/images/users_cabinete/default.jpg');
				}
				else
				{
					$tpl->set_var('MAIN_PHOTO', SITE_BASE."/sources/thumbnails.php?target=".$main_photo['image_name'].'&max_size=270&folder='.$param1);
					$tpl->set_var('IMAGENAME_MAIN', $main_photo['image_name']);
					$pic_list = GetCabineteImages($param1);
					$tpl->set_var('PICNUM',count($pic_list) - $map_exists );
					$tpl->set_var('FOLDER_ID', $param1);
					$tpl->set_var('MAIN_PHOTO_PATH', 'images/users_cabinete/'.$param1."/".$main_photo['image_name']);
				
					$i=1;
					foreach ($pic_list as $key => $val)
					{
						if($val['type']=="cabinet")
						{
							$tpl->set_var('IMAGEINDEX',$i);
							$tpl->set_var('IMAGENAME',$val['image_name']);
							$tpl->set_var('SMALL_IMGES', SITE_BASE."/images/smallimages/cabinete/".$param1."/".$val['image_name']);
							$tpl->set_var('SMALL_IMGES_PATH', SITE_BASE."/images/users_cabinete/".$param1."/".$val['image_name']);
							if($i>1)
							{
								$tpl->parse('images_block3','imgessmall',true);
							}
							$i++;
						}
					}
				}
				
				if($pachete->checkIfServiciuAvailable($servicii,'programare'))
				{
					$tpl->set_var('PARSE_EMAIL', "<a href='".ReWrite('cabinete_trimitemail','cabinete.trimitemail.'.$param1)."' class='cabinet_programare_btn'></a>");
				}
				
				#Previous or next link if the cabinete exists
				global $modules;
				$sect="cabinete.".$get_cabinet['category_id'];
				$tpl->set_var('TYPE_RELATED', $modules->module[$sect]['name']);
				$this_cabinete = GetRelatedCabinete(intval($param1),$get_cabinet['judet'],$get_cabinet['category_id']);
				if (count($this_cabinete))
				{
					foreach( $this_cabinete as $ky => $val)
					{
						$tpl->set_var("CABINET_RELATED_LINK", ReWrite('cabinete_detalii', 'cabinete.detalii.'.$val['id']));
						$tpl->set_var("CABINET_RELATED_TITLE",$val['title']);
						$tpl->parse("related_cabinete_block", "related_cabinete", true);
					}
				}
				
				#let's find out the post articles on dentistonline.ro
				$all_articles = GetAllArticlesForUser($get_cabinet['user_id'],$status=1);
				if((count($all_articles)>0)&&($all_articles!="0"))
				{
					$tpl->parse('if_articless', 'if_articles', true);
					foreach($all_articles as $ky => $val)
					{
						$tpl->set_var('ARTICOL_DETAILS',"<li><a href=\"".Rewrite('articole', 'articole-medicale.articol.'.$val['bigcat_id'].'.'.$val['id'])."\">".$val['titlu']."</a></li>" );
						$tpl->parse('articole_createe', 'articole_create', true);
					}
				}
				##############################VIDEO PART####################lets parse the video if we have it
				
				if($pachete->checkIfServiciuAvailable($servicii,'Prezentare video'))
				{
					$video = getCabinetVideoFile($param1);
					
					if (is_array($video) )
					{
						//echo "ss"; print_r($video);
						if($video[0]['type']!="")
						{
							$tpl->set_var('DATE_ADD',TimeFormatShort($video[0]['date']) );
							$tpl->set_var('DIV_ID',"mp4_player");
							$tpl->set_var('VIDEO_PATH',"../video/".$video[0]['id'].'.'.$video[0]['type']);
							$tpl->parse('list_video2', 'list_video', true);
						}
						if($video[0]['youtube_url']!="")
						{
							$tpl->set_var('VIDEO_PATH',$video[0]['youtube_url']);
							$tpl->set_var('DIV_ID',"youtube_player");
							$tpl->set_var('DATE_ADD',TimeFormatShort($video[0]['date']) );
							$tpl->parse('list_video2', 'list_video', true);
						}
						$tpl->parse('if_videoo', 'if_video', true);
					}
					else
					{
						$tpl->parse('prezentare_video2', '');
						$tpl->parse('list_video2', '');
					}
				}
				else 
				{
					$tpl->parse('prezentare_video2', '');
					$tpl->parse('list_video2', '');
				}
				
				#let's find out the post anunturi on dentistonline.ro
				$all_anunturi = GetAllAnunturiForUser($get_cabinet['user_id']);
				//print_R($all_anunturi);
				if((count($all_anunturi)>0)&&($all_anunturi!="0"))
				{
					foreach($all_anunturi as $ky => $val)
					{
						$tpl->set_var('ANUNTURI_DET',"<li><a href=\"".ReWrite('anunturi_detalii', 'anunturi.detalii.'.$val['id'])."\">".$val['titlu']."</a></li>" );
						$tpl->parse('anunturi_createe', 'anunturi_create', true);
					}
					$tpl->parse('if_anunturii', 'if_anunturi', true);
				}
				##############################Servicii si tarife file##########################
				if($pachete->checkIfServiciuAvailable($servicii,'tarife'))
				{
					$servicii_file = getCabinetServiciiFile($param1);
					if (is_array($servicii_file) )
					{
						//print_r($servicii_file);
						$file_type = explode(".",$servicii_file['name']);
						$file_ext = $file_type[count($file_type)-1];
					
						$tpl->set_var('CLASS_TYPE', "download_".$file_ext);
						$tpl->set_var('URL_SERVICII_FILE', Rewrite("default","cabinete-stomatologice/downloadservicii/".$param2));
						$tpl->set_var('TEXT_DOWNLOAD', "!!Download acum lista completa cu servicii si tarife pentru :".$get_cabinet['nume_firma']);
					
					}
					$tpl->parse('servicii_tarife2','servicii_tarife',true);
				}
				else 
				{
					$tpl->parse('servicii_tarife2','');
				}
			}
			else
			{
				//echo "a";
				$tpl->set_file('tpl_details', 'modules/cabinete/details.tpl');
				#next and previous links
				$tpl->set_block('tpl_details', 'related_cabinete', 'related_cabinete_block');
				$tpl->set_block('tpl_details', 'articole_create', 'articole_createe');
				$tpl->set_block('tpl_details', 'if_articles', 'if_articless');
				$tpl->set_block('tpl_details', 'list_video', 'list_video2');
				$tpl->set_block('tpl_details', 'if_video', 'if_videoo');
				$tpl->set_block('tpl_details', 'anunturi_create', 'anunturi_createe');
				$tpl->set_block('tpl_details', 'if_anunturi', 'if_anunturii');
				
				
				#lets inser_nr wievs
				UpdateCabinetViews($param1);
				UpdateCabinetRecent($param1);
				$tpl->set_var('SITEBASE', SITE_BASE);
				$tpl->set_var('IMAGESDIR',SITE_BASE.'/images/allstufs' );
				$tpl->set_var('MAXTHUMBNAILSIZE',$conf->normal_img_cabinete);
				$get_image_map = GetCabineteMainPhoto(intval($param1),"harta");
				$map_exists = 0;
				if(count($get_image_map)>0 &&($get_image_map['image_name']!="" ))
				{
					$map_exists=1;	$tpl->set_var('THUMBNAIL2',SITE_BASE."/sources/thumbnails.php?target=".$get_image_map['image_name'].'&max_size=165&folder='.$param1);
					$tpl->set_var('SRC_FINAL',$param1."/".$get_image_map['image_name'] );
				}
				else
				{
					$tpl->set_var('THUMBNAIL2',SITE_BASE.'/sources/thumbnails.php?target=default.jpg&max_size=165');
					$tpl->set_var('SRC_FINAL','default.jpg' );
				}
				$tpl->set_var('WEBSITE_URL',ReWrite('cabinete_detalii', 'cabinete.detalii.'.$param1) );
				
				//print_r($get_cabinet);
				$tpl->set_var('CAB_ID',$param1 );
				$tpl->set_var('SHORT_PHONE',substr($get_cabinet['fax'],0,5));
				foreach($get_cabinet  as $ky => $val)
				{
					if($ky=="judet")
					{
						$get_judet = GetJudet("code",$val);
						$tpl->set_var('JUDET',$get_judet['name']  );
					}
					elseif($ky=="nume_loc_sector")
					{
						$nume_loc = GetLocalitate($val);
						$tpl->set_var('NUME_LOC_SECTOR',$nume_loc['name'] );
					}
					elseif($ky=="adresa_web")
					{
						#here we check if he has a different package than basic, then make the direct link to his site
						if (is_array($user_pachet))
						{
							$link_begin = strtolower(substr(trim($val),0,7));
							if($link_begin=="http://")
							{
							 $tpl->set_var(strtoupper($ky),"<a href=\"".trim($val)."\" rel=\"nofollow\" target=\"_blank\">".trim($val)."</a>");
							}
							else
							{
							$tpl->set_var(strtoupper($ky),"<a href=\"http://".trim($val)."\" rel=\"nofollow\" target=\"_blank\">".trim($val)."</a>");
							}
						}
						else
						{
							$tpl->set_var(strtoupper($ky),nl2br(trim($val)));
						}
					}
					else
					{
						if(!isset($val)||($val==" "))
						{
							$tpl->set_var(strtoupper($ky),"-");
						}
						else
						{
							$tpl->set_var(strtoupper($ky),nl2br(trim($val)));
						}
					}
				}
				
				//$tpl->set_block('tpl_details', 'images_block', 'images_block2');
				$tpl->set_block('tpl_details', 'imgessmall', 'images_block3');
				$main_photo = GetCabineteMainPhoto($param1,"cabinet");
				if($main_photo['image_name']=="")
				{
					$tpl->set_var('MAIN_PHOTO',SITE_BASE.'/images/users_cabinete/default.jpg');
				}
				else
				{
					$tpl->set_var('MAIN_PHOTO', SITE_BASE."/sources/thumbnails.php?target=".$main_photo['image_name'].'&max_size=270&folder='.$param1);
					$tpl->set_var('IMAGENAME_MAIN', $main_photo['image_name']);
					$pic_list = GetCabineteImages($param1);
					$tpl->set_var('PICNUM',count($pic_list) - $map_exists );
					$tpl->set_var('FOLDER_ID', $param1);
					$tpl->set_var('MAIN_PHOTO_PATH', 'images/users_cabinete/'.$param1."/".$main_photo['image_name']);
				
					$i=1;
					foreach ($pic_list as $key => $val)
					{
						if($val['type']=="cabinet")
						{
							$tpl->set_var('IMAGEINDEX',$i);
							$tpl->set_var('IMAGENAME',$val['image_name']);
							$tpl->set_var('SMALL_IMGES', SITE_BASE."/images/smallimages/cabinete/".$param1."/".$val['image_name']);
							$tpl->set_var('SMALL_IMGES_PATH', SITE_BASE."/images/users_cabinete/".$param1."/".$val['image_name']);
							if($i>1)
							{
								$tpl->parse('images_block3','imgessmall',true);
							}
							$i++;
						}
					}
				}

				if($get_cabinet['user_id']!="-1")
				{
					$tpl->set_var('PARSE_EMAIL', "<a href=\"{URLTRIMITEEMAIL}\" class='cabinet_programare_btn'></a>");
					$tpl->set_var('URLTRIMITEEMAIL',ReWrite('cabinete_trimitemail','cabinete.trimitemail.'.$param1));
				}
				
				#Previous or next link if the cabinete exists
				global $modules;
				$sect="cabinete.".$get_cabinet['category_id'];
				$tpl->set_var('TYPE_RELATED', $modules->module[$sect]['name']);
				$this_cabinete = GetRelatedCabinete(intval($param1),$get_cabinet['judet'],$get_cabinet['category_id']);
				if (count($this_cabinete))
				{
					foreach( $this_cabinete as $ky => $val)
					{
						$tpl->set_var("CABINET_RELATED_LINK", ReWrite('cabinete_detalii', 'cabinete.detalii.'.$val['id']));
						$tpl->set_var("CABINET_RELATED_TITLE",$val['title']);
						$tpl->parse("related_cabinete_block", "related_cabinete", true);
					}
				}
				
				#let's find out the post articles on dentistonline.ro
				$all_articles = GetAllArticlesForUser($get_cabinet['user_id'],$status=1);
				if((count($all_articles)>0)&&($all_articles!="0"))
				{
					$tpl->parse('if_articless', 'if_articles', true);
					foreach($all_articles as $ky => $val)
					{
						$tpl->set_var('ARTICOL_DETAILS',"<li><a href=\"".Rewrite('articole', 'articole-medicale.articol.'.$val['bigcat_id'].'.'.$val['id'])."\">".$val['titlu']."</a></li>" );
						$tpl->parse('articole_createe', 'articole_create', true);
					}
				}
				##############################VIDEO PART####################lets parse the video if we have it
				$video = getCabinetVideoFile($param1);
				if (is_array($video) )
				{//print_r($video);
					//echo "ss"; print_r($video);
					if($video[0]['type']!="")
					{
						$tpl->set_var('DATE_ADD',TimeFormatShort($video[0]['date']) );
						$tpl->set_var('DIV_ID',"mp4_player");
						$tpl->set_var('VIDEO_PATH',"../video/".$video[0]['id'].'.'.$video[0]['type']);
						$tpl->parse('list_video2', 'list_video', true);
					}
					if($video[0]['youtube_url']!="")
					{
						$tpl->set_var('VIDEO_PATH',$video[0]['youtube_url']);
						$tpl->set_var('DIV_ID',"youtube_player");
						$tpl->set_var('DATE_ADD',TimeFormatShort($video[0]['date']) );
						$tpl->parse('list_video2', 'list_video', true);
					}
					$tpl->parse('if_videoo', 'if_video', true);
				}
				else
				{
					$tpl->parse('if_videoo', '');
					$tpl->parse('list_video2', '');
				}
				
				#let's find out the post anunturi on dentistonline.ro
				$all_anunturi = GetAllAnunturiForUser($get_cabinet['user_id']);
				//print_R($all_anunturi);
				if((count($all_anunturi)>0)&&($all_anunturi!="0"))
				{
			
					foreach($all_anunturi as $ky => $val)
					{
						$tpl->set_var('ANUNTURI_DET',"<li><a href=\"".ReWrite('anunturi_detalii', 'anunturi.detalii.'.$val['id'])."\">".$val['titlu']."</a></li>" );
						$tpl->parse('anunturi_createe', 'anunturi_create', true);
					}
					$tpl->parse('if_anunturii', 'if_anunturi', true);
				}
				##############################Servicii si tarife file##########################
				$servicii_file = getCabinetServiciiFile($param1);
				if (is_array($servicii_file) )
				{
					$file_type = explode(".",$servicii_file['name']);
					$file_ext = $file_type[count($file_type)-1];
					$tpl->set_var('CLASS_TYPE', "download_".$file_ext);
					$tpl->set_var('URL_SERVICII_FILE', Rewrite("default","cabinete-stomatologice/downloadservicii/".$param2));
					$tpl->set_var('TEXT_DOWNLOAD', "!!Download acum lista completa cu servicii si tarife pentru :".$get_cabinet['nume_firma']);
				
					//$tpl->set_var('SERVICII_FILE', "<A HREF='?page=user.downloadservicii.".$param1."'><b>".$servicii_file['name']."</b>&nbsp;&nbsp;&nbsp;&nbsp; <img src='../images/".$file_ext.".jpg'></A><br><i>Fisierul a fost adaugat in: </i>".TimeFormatShort($servicii_file['date']));
				}
				else
				{
					$tpl->set_var('SERVICII_FILE',"Nu aveti nici un fisier adaugat !" );
				}
			}
			$tpl->parse('MAIN', 'tpl_details');
		}
	break;
	
	case 'detalii':
		
		$get_cabinet = GetSelectedCabinet(intval($param1));
		if((($get_cabinet['status']!='1')||(!isset($get_cabinet['status']))) && $param1!='1890')
		{
			FakeError ();
			$tpl->set_file('tpl_main', 'unpublished.tpl');
			$tpl->set_var('ERRORMSG', 'Aceasta pagina nu este disponibila');
			$tpl->parse('MAIN', 'tpl_main');
		}
		else
		{
			
			$pachete = new Pachete_Servicii($db);
			$user_pachet = $pachete->getPromovareView($get_cabinet['level']);
			
			//for testing
			//print_r($user_pachet);
			//$user_pachet = '22';
			//echo $pachet_promovare;
			if(is_array($user_pachet)) $pachet_promovare = $user_pachet['pachet'];
			else $pachet_promovare = $user_pachet;
			$servicii = $pachete->listPachetServicii($pachet_promovare);

			$tpl->set_file('tpl_details', "modules/".$module.'/details_responsive.tpl');
			
			$tpl->set_var('SECURITYID', md5(time()));
			// global blocks setup
			$tpl->set_block('tpl_details', 'related_cabinete', 'related_cabinete_block');
			$tpl->set_block('tpl_details', 'articole_create', 'articole_createe');
			$tpl->set_block('tpl_details', 'anunturi_create', 'anunturi_createe');
			$tpl->set_block('tpl_details', 'list_video', 'list_video2');
			$tpl->set_block('tpl_details', 'if_recomandari', 'if_recomandari2');
			$tpl->set_block('tpl_details', 'imgessmall', 'images_block3');
			$tpl->set_block('tpl_details', 'carousel_big', 'carousel_big2');
				
			//setup the blocks for servicii
			$tpl->set_block('tpl_details', 'programare_online', 'programare_online2');
			$tpl->set_block('tpl_details', 'prezentare_video', 'prezentare_video2');
			$tpl->set_block('tpl_details', 'localizare_harta', 'localizare_harta2');
			$tpl->set_block('tpl_details', 'foto_gallery', 'foto_gallery2');
			$tpl->set_block('tpl_details', 'recomandat_badge', 'recomandat_badge2');
			
			if($pachete->hasRecomandat($pachet_promovare)) $tpl->parse('recomandat_badge2', 'recomandat_badge', true);
			else  $tpl->parse('recomandat_badge2', '');
			
			
			
			//displayResponsiveBreadcrumb(GetTitleAndTagsNavigation($module, $action, $param1));
			
			// parse the share info
			$tpl->set_var('SHARE_URL', ReWrite('cabinete_detalii', 'cabinete.detalii.'.$param1));
			
			#lets inser_nr wievs
			UpdateCabinetViews($param1);
			UpdateCabinetRecent($param1);
			$tpl->set_var('SITEBASE', SITE_BASE);
			$tpl->set_var('IMAGESDIR',SITE_BASE.'/images/allstufs' );
			$tpl->set_var('MAXTHUMBNAILSIZE',$conf->normal_img_cabinete);
			$tpl->set_var('WEBSITE_URL',ReWrite('cabinete_detalii', 'cabinete.detalii.'.$param1) );
			
			//here we parse the GMAP location
			if($pachete->checkIfServiciuAvailable($servicii,'localizare'))
			{
				$tpl->set_var('HARTA_OFF', '');
				$map_address = formatGmapAddress($get_cabinet['adresa_firma'], GetLocalitate($get_cabinet['nume_loc_sector']));
				$map_coords = getCabinetMapCoords($param1);
				if(is_array($map_coords))
				{
					if(!empty($map_coords['address'])) $tpl->set_var('MAP_QUERY', $map_coords['address']);
					else $tpl->set_var('MAP_QUERY', $map_coords['lat'].','.$map_coords['lng']);
				}
				else $tpl->set_var('MAP_QUERY', $map_address);
				$tpl->parse('localizare_harta2', 'localizare_harta', true);
			}
			else 
			{
				$tpl->set_var('HARTA_OFF', 'disabled');
				$tpl->parse('localizare_harta2', '');
			}
			
			$tpl->set_var('CAB_ID',$param1 );
			$tpl->set_var('SHORT_PHONE',substr($get_cabinet['fax'],0,5));
			foreach($get_cabinet  as $ky => $val)
			{
				if($ky=="judet")
				{
					$get_judet = GetJudet("code",$val);
					$tpl->set_var('JUDET',$get_judet['name']  );
				}
				elseif($ky=="nume_loc_sector")
				{
					$nume_loc = GetLocalitate($val);
					$tpl->set_var('NUME_LOC_SECTOR',$nume_loc['name'] );
					$localitate = $val;
				}
				elseif($ky=="adresa_web")
				{
					#here we check if he has a different package than basic, then make the direct link to his site
					$link_pakages = array('2','5','6','23','24');	// $user_pachet its rewrited with default package= 23;				
					if (in_array($user_pachet,$link_pakages))
					{
						$URL = "";
						$val = $val.',';
						$new_link = explode(',',$val);
						foreach($new_link as $keyy=>$val2)
						{
							$link_begin = strtolower(substr(trim($val2),0,7));
							if($link_begin=="http://")
							{
								$urls = "<a href=\"".trim($val2)."\" rel=\"nofollow\" target=\"_blank\">".trim($val2)."</a>";
							}
							else
							{
								$urls = "<a href=\"http://".trim($val2)."\" rel=\"nofollow\" target=\"_blank\">".trim($val2)."</a>";
							}
							$URL = $URL." ".$urls;
						}

						
					}
					else
					{
						$URL = trim($val);
					}
					
					if (($pachete->ifPachetFree($pachet_promovare))|| ($get_cabinet['level']=='1')) $tpl->parse('if_recomandari2', 'if_recomandari', true);
					else $tpl->parse('if_recomandari2', '');

					#this is the originl level of each cabinet
					if($get_cabinet['level']=='1')
					{
					$URL = trim($val);
					//$tpl->parse('if_recomandari2', 'if_recomandari', true);
					
					}

					//print_r($user_pachet);
					
					
					$tpl->set_var('ADRESA_WEB', $URL );
					/*if($pachete->checkIfServiciuAvailable($servicii,'adresa web'))
					{
						$tpl->set_var('ADRESA_WEB', $URL );
					}*/
				}
				elseif(in_array($ky, array('descriere', 'tarife', 'echipa_medicala')))
				{
					$tpl->set_var(strtoupper($ky), nl2br(addReadMore($val, 'read_more_'.$ky)));
				}
				elseif($ky=='nr_visits')
				{
					$tpl->set_var(strtoupper($ky), number_format($val,0,',','.'));
				}
				else
				{
					if(!isset($val)||($val==" "))
					{
						$tpl->set_var(strtoupper($ky),"-");
					}
					else
					{
						$tpl->set_var(strtoupper($ky),nl2br(trim($val)));
					}
				}
			}
			
			//here is the carousel foto gallery
			//print_r(GetCabineteImages($param1));
			if($pachete->checkIfServiciuAvailable($servicii,'galerie'))
			{
				$pic_list = GetCabineteImages($param1);
				if(count($pic_list)>0)
				{
					$i=0;
					foreach ($pic_list as $key => $val)
					{
						$tpl->set_var('CAROUSEL_NR', $i);
						if($i==0)
						{
							$tpl->set_var('CAROUSEL_SMALL_ACTIVE', 'active');
							$tpl->set_var('CAROUSELL_BIG_ACTIVE', 'active');
						}
						else
						{
							$tpl->set_var('CAROUSEL_SMALL_ACTIVE', '');
							$tpl->set_var('CAROUSELL_BIG_ACTIVE', '');
						}
							
						if($val['type']=='cabinet') 
							$tpl->set_var('SMALL_IMGES', SITE_BASE."/images/smallimages/cabinete/".$param1."/".$val['image_name']);
						else 
							$tpl->set_var('SMALL_IMGES', SITE_BASE."/sources/thumbnails.php?target=".$val['image_name'].'&max_size=60&folder='.$param1);
						if($val['image_name']=="default.jpg")
						{
							$tpl->set_var('CAROUSEL_BIG_IMG', SITE_BASE."/images/default_big.png");
						}
						else
							$tpl->set_var('CAROUSEL_BIG_IMG', SITE_BASE."/images/users_cabinete/".$param1."/".$val['image_name']);

						$tpl->parse('images_block3', 'imgessmall', true);
						$tpl->parse('carousel_big2', 'carousel_big', true);
						$i++;
						
					}
				}
				else
				{
					
					// display the single default image
					$tpl->set_var('CAROUSEL_NR', '0');
					$tpl->set_var('CAROUSEL_SMALL_ACTIVE', 'active');
					$tpl->set_var('CAROUSELL_BIG_ACTIVE', 'active');
					$tpl->set_var('SMALL_IMGES', SITE_BASE."/images/smallimages/cabinete/default.jpg");
					$tpl->set_var('CAROUSEL_BIG_IMG', SITE_BASE."/images/default_big.png");
					$tpl->parse('images_block3', 'imgessmall', true);
					$tpl->parse('carousel_big2', 'carousel_big', true);
				}
				$tpl->parse('foto_gallery2', 'foto_gallery', true);
			}
			else
			{
				$tpl->set_var('CAROUSELL_BIG_ACTIVE', 'active');
				$main_img = GetCabineteMainPhoto($param1, 'cabinet');
				
				if((count($main_img)>0)&&($main_img['image_name']!="default.jpg")) 
					$tpl->set_var('CAROUSEL_BIG_IMG', SITE_BASE."/images/users_cabinete/".$param1."/".$main_img['image_name']);
				else 
					$tpl->set_var('CAROUSEL_BIG_IMG', SITE_BASE."/images/default_big.png");
				$tpl->parse('carousel_big2', 'carousel_big', true);
				$tpl->parse('foto_gallery2', '');
			}

			if($get_cabinet['user_id']!="-1")
			{
				//$tpl->set_var('URLTRIMITEEMAIL',ReWrite('cabinete_trimitemail','cabinete.trimitemail.'.$param1));
			}
			//parse the send email block based on servicii
			if($pachete->checkIfServiciuAvailable($servicii,'programare'))
			{
				$tpl->set_var('CABINETETRIMITEEMAIL', ReWrite("cabinete_emailtrimis","cabinete.emailtrimis.".$param1));
				$tpl->set_var('ID_CABINET', $param1);
				$tpl->parse('programare_online2', 'programare_online', true);
			}
			else $tpl->parse('programare_online2', '');
		
			#Previous or next link if the cabinete exists
			global $modules;
			$sect="cabinete.".$get_cabinet['category_id'];
			$tpl->set_var('TYPE_RELATED', $modules->module[$sect]['name']);
			$this_cabinete = GetRelatedCabinete(intval($param1),$get_cabinet['judet'],$get_cabinet['category_id'],$localitate);
			//var_dump($this_cabinete);
			if (count($this_cabinete))
			{
				foreach( $this_cabinete as $ky => $val)
				{
					$tpl->set_var("CABINET_RELATED_LINK", ReWrite('cabinete_detalii', 'cabinete.detalii.'.$val['id']));
					$tpl->set_var("CABINET_RELATED_TITLE",$val['title']);
					$img = GetCabineteMainPhoto($val['id'],"cabinet");
					if(empty($img['image_name']) || $img['image_name']=='default.jpg')
					{
						//$tpl->set_var('CABINET_RELATED_IMG',SITE_BASE.'/images/default_big.png');
						$tpl->set_var('CABINET_RELATED_IMG',SITE_BASE.'/images/users_cabinete/default.jpg');
					}
					else
					{
						$tpl->set_var("CABINET_RELATED_IMG", SITE_BASE."/images/smallimages/cabinete/".$val['id']."/".$img['image_name']);
						//$tpl->set_var("CABINET_RELATED_IMG", SITE_BASE."/images/users_cabinete/".$val['id']."/".$img['image_name']);
					}
					
					$tpl->parse("related_cabinete_block", "related_cabinete", true);
				}
			}
		
			#let's find out the post articles on dentistonline.ro
			$all_articles = GetAllArticlesForUser($get_cabinet['user_id'],$status=1);
			if((count($all_articles)>0)&&($all_articles!="0"))
			{
				foreach($all_articles as $ky => $val)
				{
					$tpl->set_var('ARTICOL_TITLE', $val['titlu']);
					$tpl->set_var('ARTICOL_LINK', Rewrite('articole', 'articole-medicale.articol.'.$val['bigcat_id'].'.'.$val['id']));
					$tpl->set_var('ARTICOL_DESCRIPTION', $val['short_description']);
					$tpl->parse('articole_createe', 'articole_create', true);
				}
			}
			else $tpl->parse('articole_createe', '');
			
			
			// VIDEO PART - lets parse the video if we have it
			if($pachete->checkIfServiciuAvailable($servicii,'Prezentare video'))
			{
				$tpl->set_var('VIDEO_OFF', '');
				$video = getCabinetVideoFile($param1);
				if (is_array($video) )
				{
					if($video[0]['youtube_url']!="")
					{
						$path = $video[0]['youtube_url'];
						if(stristr($path,'embed/')===false)
						{
							$str = explode("?v=", $path);
							$path = 'https://www.youtube.com/embed/'.trim($str[1]);
						}
						$tpl->set_var('VIDEO_PATH',$path);
						$tpl->parse('list_video2', 'list_video', true);
					}
				}
				else
				{
					$tpl->parse('list_video2', '');
				}
				$tpl->parse('prezentare_video2', 'prezentare_video', true);
			}
			else
			{
				$tpl->set_var('VIDEO_OFF', 'disabled');
				$tpl->parse('list_video2', '');
				$tpl->parse('prezentare_video2', '');
			}

			#let's find out the post anunturi on dentistonline.ro
			$all_anunturi = GetAllAnunturiForUser($get_cabinet['user_id']);
			//print_R($all_anunturi);
			if((count($all_anunturi)>0)&&($all_anunturi!="0"))
			{
				foreach($all_anunturi as $ky => $val)
				{
					$tpl->set_var('ANUNT_TITLE', $val['titlu']);
					$tpl->set_var('ANUNT_LINK', ReWrite('anunturi_detalii', 'anunturi.detalii.'.$val['id']));
					$tpl->set_var('ANUNT_DESCRIPTION', $val['short_description']);
					$tpl->parse('anunturi_createe', 'anunturi_create', true);
				}
			}
			else $tpl->parse('anunturi_createe', '');
			
			##############################Servicii si tarife file##########################
			$servicii_file = getCabinetServiciiFile($param1);
			if (is_array($servicii_file) )
			{
				$file_type = explode(".",$servicii_file['name']);
				$file_ext = $file_type[count($file_type)-1];
				$tpl->set_var('CLASS_TYPE', "download_".$file_ext);
				$tpl->set_var('URL_SERVICII_FILE', Rewrite("default","cabinete-stomatologice/downloadservicii/".$param2));
				$tpl->set_var('TEXT_DOWNLOAD', "!!Download acum lista completa cu servicii si tarife pentru :".$get_cabinet['nume_firma']);
				//$tpl->set_var('SERVICII_FILE', "<A HREF='?page=user.downloadservicii.".$param1."'><b>".$servicii_file['name']."</b>&nbsp;&nbsp;&nbsp;&nbsp; <img src='../images/".$file_ext.".jpg'></A><br><i>Fisierul a fost adaugat in: </i>".TimeFormatShort($servicii_file['date']));
			}
			else
			{
				$tpl->set_var('SERVICII_FILE',"Nu aveti nici un fisier adaugat !" );
			}
			
			$tpl->parse('MAIN', 'tpl_details');
		}
	break;

	case 'downloadservicii':
		$servicii_file = getCabinetServiciiFile($param1);
		$filename = './servicii_file/'.$servicii_file['name'];
	//12/3/2011	echo $filename;exit;
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
		readfile($filename);
		exit;
	break;
	
	case 'trimitemail':
		$param1 = str_replace(".html","",$param1);
		header("HTTP/1.1 301 Moved Permanently");
		header("Location: ".ReWrite('cabinete_detalii', 'cabinete.detalii.'.$param1));
		exit;
	break;

	case 'emailtrimis':
		$display_errors= "";
		if($_POST['field_1']=="")
		{
			$display_errors .= "<li>Ati uitat sa completati numele</li> ";
		}
		if($_POST['field_2']=="")
		{
			$display_errors .= "<li>Ati uitat sa completati emailul </li>";
		}
		if($_POST['field_3']=="")
		{
			$display_errors .= "<li>Ati uitat sa completati subiectul </li>";
		}
		if($_POST['field_4']=="")
		{
			$display_errors .= "<li>Ati uitat sa completati mesajul </li>";	
		}
		if($_POST['security_code2']=="")
		{
			$display_errors .= "<li>Ati uitat sa completati codul de siguranta </li>";	
		}
		$check = SecurityImageGeneral($_POST['security_code2'],$_SESSION['security_code']);
		unset($_SESSION['security_code']);
			
		if(!$check)
		{
			$display_errors .= "<li>Codul de siguranta este gresit!</li>"; 
		}	
		
		if($display_errors!="")
		{
			#let_put in sessions all infos from post in case we have errors
			$_SESSION['error']['message'] = $display_errors;
			$_SESSION['error']['type'] = 'error';

			$_SESSION['error']['post'] = array("field_1" => ''.$_POST['field_1'] .'',
												"field_2" =>''.$_POST['field_2'].'',
												"field_3" => ''.$_POST['field_3'].'',
												"field_4" => ''.$_POST['field_4'].'',
												"field_5" =>''.$_POST['field_5'].'');
			header('location: '.GetReferer());
			exit;
		}
		#inseram in baza de date si dupa ce dam acceptul se va trimite email utilizatorului
		$id_cabinet = $_POST['id_cabinet'];
		$get_cab_info = GetSelectedCabinet($id_cabinet);
		$email_content = $_POST['field_4'];
		$subject = $_POST['field_3'];
		$email_utilizator = $_POST['field_2'];
		$nume_utilizator = $_POST['field_1'];
		$telefon = $_POST['field_5'];

		$type = "cabinete";
		InsertMesajeutilizator($_POST['id_cabinet'],$subject,$email_content,$email_utilizator,$nume_utilizator,$get_cab_info['user_id'],$type,$telefon);
		#trimite email clientului ca a primit un mesaj pe dentistonline.ro!!
		/*
		$text = GetFileContent('./templates/emails/mesajutilizator.tpl');
		$text = str_replace("%OFERTA_CABINET%", $get_cab_info['nume_firma'], $text);
		$text = str_replace("%PERSOANA_CONTACT%", $get_cab_info['pers_contact'] , $text);
		
		$Recipiant = $get_cab_info['persc_email'];
		$CustomHeaders = '';
		$Sender = 'DentistOnline.ro<'.$conf->contact_recipient.'>';
		$Subject = "Ati primit un mesaj pe Dentistonline.ro ";
		$message = new Email($Recipiant, $Sender, $Subject, $CustomHeaders);
		$message->SetHtmlContent($text);
		if (ValidHeader($Sender))
		{
			$message->Send();
		}*/
		$_SESSION['error']['message'] = "Emailul a fost trimis cu succes!<br>Pentru programarii va rugam sa contactati si telefonic medicul dentist. Multumim!";
		$_SESSION['error']['type'] = 'info';
		
		$_SESSION['submit_errors'] = "<li></li> <li></li>";
		header('location: '.GetReferer());
		exit;
	break;
}
?>