<?php

//echo $module." ".$action." ".$param1." ".$param2;exit;

if($conf->url_rewrite_mode == 'Y')
{
		if((isset($param1))&&(substr($param1,0,6)!="pagina")&&($action!='trimitemail')&&($action!='emailtrimis'))
		{
				if(strpos($param1,".html")!=FALSE)
				{
					$param1 = str_replace(".html","",$param1);
					//echo $param1;exit;
				}
				
				$jud_namee = $param1;
				$param1 = GetModuleLinkByNameJudet($param1,$action);
		}
		if((isset($param2))&&(substr($param2,0,6)!="pagina")&&($param2!="")&&($action!='trimitemail')&&($action!='emailtrimis'))
		{
				$param2 = str_replace(".html","",$param2);
				$param1 = GetCabinetIdByAlias($param2);
				$action ="detalii";
		}
		if(($action=='trimitemail')||($action=='emailtrimis'))
		{
			
			$param1 = str_replace(".html","",$param2);
			$param1 = GetCabinetIdByAlias($param1);
		}
}

switch ($action)
{
	default:
		$tpl->set_file('tpl_cabinete', 'modules/cabinete/cabinete.tpl');
		$tpl->set_block('tpl_cabinete','display_image','display_imagee' );
		$tpl->set_block('tpl_cabinete','Recomandam','Recomandamm' );
		$tpl->set_block('tpl_cabinete','rowdoicabs','rowdoicabss' );
		$tpl->set_block('tpl_cabinete','rowunucabs','rowunucabss' );
		$tpl->set_block('tpl_cabinete', 'pagination_table', 'pagination_tablee');
		$conf->cabinete_anunturi_per_page = $conf->cabinete_anunturi_per_page-2;
		/**************************for pagination***********************/
		#create de pagination page_name
		$page_name = $module.'.'.$action;
		if((isset($param1))&&(substr($param1,0,6)!="pagina")&&($param1!=""))
		{
			$total_records = CountCabineteTotalRecordsFront("category", $param1);
			$page_name = $page_name.'.'.$param1;
			$cat_name = Get_Dentist_Cats($action);
			$cat_n=$cat_name[0]['name'];
			$cat_name[0]['name'] = strtolower(str_replace(" ","_",$cat_name[0]['name']));
			$rss_link = SITE_BASE."/rss/".$cat_name[0]['name']."/".$jud_namee.".xml";
			$tpl->set_var('RSS_FILE',"<td width=\"14\" ><a href=\"$rss_link\"><img width=\"14\" height=\"14\" border=\"0\" align=\"right\" src=\"{SITE_BASE}/images/allstufs/rss.gif\" title=\"Rss ".$cat_n." $jud_namee\" alt=\"Rss $cat_name[0]['name'] $jud_namee\"></a></td>" );
			
			#here we make all stufs with recomandate
			$query_limit = ' Limit 8';
			$ii=0;
			$getrecomandate = GetCabinete(intval($action), $param1,$query_limit," And A.recomandata='Y' ");
			//print_r($getrecomandate);
			$nr_cabinete_recomandate = count($getrecomandate);
			$nr_randuri = ceil($nr_cabinete_recomandate/3);
			$j = 0;  #i want to count the rows, to parse only then the empty cabinete
			if($nr_cabinete_recomandate>0)
			{
					$tpl->set_file('tpl_cabinete_rec', 'modules/cabinete/recomandat.tpl');
					$tpl->set_block('tpl_cabinete_rec','no_display_cabinete','no_display_cabinetee' );
					$tpl->set_block('tpl_cabinete_rec','display_cabinete','display_cabinetee' );
					$tpl->set_block('tpl_cabinete_rec','display_cabinete_row','display_cabinete_roww');
					
					$nr_cabinete_goale = 3 - ($nr_cabinete_recomandate%3);
					shuffle($getrecomandate);
					foreach($getrecomandate as $ky => $val)
					{
						//echo "sss"." ";
						$tpl->set_var('NUME_FIRMA_REC', $val['nume_firma']);
						$tpl->set_var('DESCRIERE_REC', text_best_fit($val['descriere'],130));
						$tpl->set_var('IMAGE_REC',SITE_BASE.'/images/smallimages/cabinete/'.$val['image_name']);		
						$tpl->set_var('URLCITESTE_REC', ReWrite('cabinete_detalii', 'cabinete.detalii.'.$val['id']));
						$tpl->parse('display_cabinetee', 'display_cabinete', true);	
						$ii++;
						if(($ii%3==0)||($ii==$nr_cabinete_recomandate))
						{
							$j++;
							if(($j==$nr_randuri )&&($nr_cabinete_goale>0)&&($nr_cabinete_goale<3))
							{
								
								for($i = 1; $i <= $nr_cabinete_goale ; $i++)
								{
									$tpl->parse('no_display_cabinetee', 'no_display_cabinete', true);
								}
							}
							else
							{
								$tpl->parse('no_display_cabinetee', '');
							}
							$tpl->parse('display_cabinete_roww', 'display_cabinete_row', true);	
							$tpl->parse('display_cabinetee', '');
						}

					}
					$tpl->parse('DISPLAY_RECOMANDAT','tpl_cabinete_rec');
			}
			else
			{
				$tpl->parse('display_imagee', 'display_image', true);
			}
			$tpl->parse('Recomandamm', 'Recomandam', true);
		}
		elseif((isset($param1) && substr($param1,0,6)=="pagina")||($param1=="")||(!isset($param1)))
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
			$start_q = 0;			$start = 1;
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
			$cabinete = GetCabinete(intval($action), $param1,$query_limit,"");
	 }
	 else
	 {
			$cabinete = GetCabinete(intval($action), $param1,$query_limit,"");
	 }
		$i=0;
		foreach($cabinete as $ky => $v)
		{
					$tpl->set_var('NUME_FIRMA', $v['nume_firma']);
					$tpl->set_var('DESCRIERE', text_best_fit($v['descriere'],200));
					//echo $v['image_name']." ";
					$tpl->set_var('IMAGE', SITE_BASE.'/images/smallimages/cabinete/'.$v['image_name']);		
					$tpl->set_var('URLCITESTE', ReWrite('cabinete_detalii', 'cabinete.detalii.'.$v['id']));
					$judet_code = $v['judet'];
					$get_judet_infoss = JudetIdFromCategories($judet_code,$action);
					$judet_name = $get_judet_infoss['name'];
					$tpl->set_var('JUDET_NAME',	$judet_name  );
					$url_categorie = ReWrite("cabinete","cabinete.".$action.".".$get_judet_infoss['id']);
					switch($action)
					{
						case '1':
								$cat_name = "Cabinete stomatologice ".$judet_name;
								$categ_hrf = "Stomatologie".$judet_name;
								$tpl->set_var('REC_TYPE','Cabinetul tau stomatologic' );
								$tpl->set_var('REC_TYPE_2','cabinete' );
								$tpl->set_var('REC_JUDET',$judet_name );
								$tpl->set_var('CATEGORY_NAME', "Cabinete");
								$tpl->set_var('AHREFCABS',$v['nume_firma'] );
						break;
						
						case '5':
							$cat_name = "Clinici stomatologice ".$judet_name;
							$tpl->set_var('AHREFCABS',$v['nume_firma'] );
							$categ_hrf = "Clinici de stomatologie ".$judet_name;
							$tpl->set_var('REC_TYPE','Clinica ta stomatologica' );
							$tpl->set_var('REC_TYPE_2','clinici' );
							$tpl->set_var('REC_JUDET',$judet_name );
							$tpl->set_var('CATEGORY_NAME', "Clinici");
						break;
						
						case '2':
							$cat_name = "Tehnica dentara ".$judet_name ;
							$tpl->set_var('AHREFCABS',"Laborator tehnica dentara ".$v['nume_firma'] );
							$categ_hrf= "Laboratoare tehnica dentara din ".$judet_name;
							$tpl->set_var('REC_TYPE','Laboratorul tau de tehnica dentara' );
							$tpl->set_var('REC_TYPE_2','laboartoarele dentare' );
							$tpl->set_var('REC_JUDET',$judet_name );
							$tpl->set_var('CATEGORY_NAME',"Laboratoare" );
						break;
						
						case '4':
							$cat_name = "Distribuitori materiale ".$judet_name;
							$tpl->set_var('AHREFCABS',"Distribuitor materiale ".$v['nume_firma'] );
							$categ_hrf = "Lista distribuitori materiale din ".$judet_name;
							$tpl->set_var('REC_TYPE','Firma ta de distributie materiale stomatologice' );
							$tpl->set_var('REC_TYPE_2','firme' );
							$tpl->set_var('REC_JUDET',$judet_name );
							$tpl->set_var('CATEGORY_NAME', "Distribuitori" );
						break;
						
						case '3':
							$cat_name = "Radiologie dentara ".$judet_name ;			
							$tpl->set_var('AHREFCABS',$v['nume_firma'] );
							$categ_hrf = "Lista laboratoarelor de radiologie dentara din ".$judet_name ;
							$tpl->set_var('REC_TYPE','Laboratorul tau de radiologie dentara' );
							$tpl->set_var('REC_TYPE_2','laboartoarele dentare' );
							$tpl->set_var('REC_JUDET',$judet_name );
							$tpl->set_var('CATEGORY_NAME',"Laboratoare");
						break;
					}


				if(!is_numeric($param1))
				{
						$tpl->set_var('CAT_DETAILS_HERE',"<p class=\"cabinet_category_href\" ><a href=\"".	$url_categorie."\" title=\"".$categ_hrf."\">".$cat_name."</a></p>" );
						
				}
				$tpl->parse('rowdoicabss', 'rowdoicabs', true);	
					$i++;
					if(($i%2==0)||($i==count($cabinete)))
					{
						$tpl->parse('rowunucabss', 'rowunucabs', true);	
						$tpl->parse('rowdoicabss', '');
					}
	
			}
				$tpl->parse('pagination_tablee', 'pagination_table', true);

		$tpl->parse('MAIN', 'tpl_cabinete');
	break;

	case 'detalii':
		$get_cabinet = GetSelectedCabinet(intval($param1));
		if(($get_cabinet['status']!='1')||(!isset($get_cabinet['status'])))
		{
			FakeError ();
			$tpl->set_file('tpl_main', 'unpublished.tpl');
			$tpl->set_var('ERRORMSG', 'Aceasta pagina nu este disponibila');
			$tpl->parse('MAIN', 'tpl_main');
		}
		else
		{

		$tpl->set_file('tpl_details', 'modules/cabinete/details.tpl');
		#next and previous links
		$tpl->set_block('tpl_details', 'related_cabinete', 'related_cabinete_block');
		$tpl->set_block('tpl_details', 'articole_create', 'articole_createe');
		$tpl->set_block('tpl_details', 'if_articles', 'if_articless');
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
			$map_exists=1;	$tpl->set_var('THUMBNAIL2',SITE_BASE."/sources/thumbnails.php?target=".$get_image_map['image_name'].'&max_size='.$conf->normal_img_cabinete.'&folder='.$param1);
			$tpl->set_var('SRC_FINAL',$param1."/".$get_image_map['image_name'] );
		}
		else
		{
			$tpl->set_var('THUMBNAIL2',SITE_BASE.'/sources/thumbnails.php?target=default.jpg&max_size='.$conf->normal_img_cabinete);
			$tpl->set_var('SRC_FINAL','default.jpg' );
		}
		$tpl->set_var('WEBSITE_URL',ReWrite('cabinete_detalii', 'cabinete.detalii.'.$param1) );
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
						$tpl->set_var(strtoupper($ky),nl2br($val));
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
					$tpl->set_var('MAIN_PHOTO', SITE_BASE."/sources/thumbnails.php?target=".$main_photo['image_name'].'&max_size='.$conf->normal_img_cabinete.'&folder='.$param1);
					$tpl->set_var('IMAGENAME_MAIN', SITE_BASE."/images/users_cabinete/".$param1."/".$main_photo['image_name']);
					$pic_list = GetCabineteImages($param1);

					$tpl->set_var('PICNUM',count($pic_list) - $map_exists );
					$tpl->set_var('FOLDER_ID', $param1);
					$i=1;
					foreach ($pic_list as $key => $val)
					{
						if($val['type']=="cabinet")
						{
							$tpl->set_var('IMAGEINDEX',$i);
							$tpl->set_var('IMAGENAME',SITE_BASE."/images/users_cabinete/".$param1."/".$val['image_name']);
							$tpl->set_var('SMALL_IMGES', SITE_BASE."/sources/thumbnails.php?target=".$val['image_name'].'&max_size=70&folder='.$param1);
							
							if($i>1)
							{
									$tpl->parse('images_block3','imgessmall',true);
							}
							//$tpl->parse('images_block2','images_block',true);
						
							$i++;
							
						}
					}
				}
		
		
		if($get_cabinet['user_id']!="-1")
		{
			$tpl->set_var('PARSE_EMAIL', "<a href=\"{URLTRIMITEEMAIL}\" ><b>Programare Online sau Trimite E-mail</b>");
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
			$all_articles = GetAllArticlesForUser($get_cabinet['user_id']);
			if((count($all_articles)>0)&&($all_articles!="0"))
			{
					$tpl->parse('if_articless', 'if_articles', true);
					foreach($all_articles as $ky => $val)
					{
						$tpl->set_var('ARTICOL_DETAILS',"<a href=\"".Rewrite('articole', 'articole-medicale.articol.'.$val['bigcat_id'].'.'.$val['id'])."\">".$val['titlu']."</a>" );
					
						$tpl->parse('articole_createe', 'articole_create', true);

					}
			}

			#let's find out the post anunturi on dentistonline.ro
			$all_anunturi = GetAllAnunturiForUser($get_cabinet['user_id']);
			//print_R($all_anunturi);
			if((count($all_anunturi)>0)&&($all_anunturi!="0"))
			{
					
					foreach($all_anunturi as $ky => $val)
					{
						$tpl->set_var('ANUNTURI_DET',"<a href=\"".ReWrite('anunturi_detalii', 'anunturi.detalii.'.$val['id'])."\">".$val['titlu']."</a>" );
						$tpl->parse('anunturi_createe', 'anunturi_create', true);
					}
					$tpl->parse('if_anunturii', 'if_anunturi', true);
			}
			
		
			$tpl->parse('MAIN', 'tpl_details');
			}
	break;
	
	case 'trimitemail':
		$tpl->set_file('tpl_trimemail', 'modules/cabinete/trimitemail.tpl');
		$tpl->set_block('tpl_trimemail', 'error', 'error_block');
		$tpl->set_var('SITEBASE',SITE_BASE );
		$param2 = str_replace(".html","",$param2);
		$param2 = str_replace("-"," ",$param2);
		$param1 = str_replace(".html","",$param1);
		$tpl->set_var('PERSOANA_CONTACT', $param2 );
		$tpl->set_var('ID_CABINET',$param1 );
		$tpl->set_var('CABINETETRIMITEEMAIL', ReWrite("cabinete_emailtrimis","cabinete.emailtrimis.".$param1));
		#display error
			if (isset($_SESSION['submit_errors']))
			{
				$tpl->set_var("ERROR_MSG", $_SESSION['submit_errors']);
				unset($_SESSION['submit_errors']);
				$tpl->parse("error_block", "error", true);
			}
			#fill fields
			if (isset($_SESSION['submit_array']))
			{
				foreach ($_SESSION['submit_array'] as $key => $val)
				{
					$tpl->set_var(strtoupper($key), $val);
				}
				unset($_SESSION['submit_array']);
			}
		$tpl->set_var('SECURITYID', md5(time()));
		$tpl->parse('MAIN', 'tpl_trimemail');
	break;

	case 'emailtrimis':
		$display_errors= "";
		if($_POST['field_1']=="")
		{
			$display_errors .= "<li>Ati uitat sa complectati numele</li> ";
		}
		if($_POST['field_2']=="")
		{
			$display_errors .= "<li>Ati uitat sa complectati emailul </li>";
		}
		if($_POST['field_3']=="")
		{
			$display_errors .= "<li>Ati uitat sa complectati subiectul </li>";
		}
		if($_POST['field_4']=="")
		{
			$display_errors .= "<li>Ati uitat sa complectati mesajul </li>";	
		}
		if($_POST['security_code2']=="")
		{
			$display_errors .= "<li>Ati uitat sa complectati codul de siguranta </li>";	
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
				$_SESSION['submit_errors'] = $display_errors;
				$_SESSION['submit_array'] = array("field_1" => ''.$_POST['field_1'] .'',
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
		$_SESSION['submit_errors'] = "<li>Emailul a fost trimis cu succes!</li> <li>Pentru programarii va rugam sa contactati si telefonic medicul dentist. Multumim!</li>";
		header('location: '.ReWrite("cabinete_trimitemail","cabinete.trimitemail.".$id_cabinet));exit;
	
	break;
}
?>