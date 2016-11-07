<?php
//echo "actt:".$action. " //// param 1:".$param1."/////param2: ".$param2."module: ".$module;
$ip = GetUserIP();
if($ip=='79.113.87.77')
{
	ini_set('display_errors', '1');
}
if($conf->url_rewrite_mode == 'Y')
{
	if(isset($param1)&&($param1=='toate'))
	{
		$action='';
		$param1="";
		$param2="";
		$module="anunturi";
	}
	elseif($action!="trimitemail" && $action!="emailtrimis")
	{
		if((isset($param1))&&(strpos($param1,'-')!= false))
		{
			$action = "produse";
			$get_userid = explode("-",$param1);
			$user_id = substr($get_userid[1],0,strpos($get_userid[1],'.'));
		}
		elseif((isset($param1))&&(substr($param1,0,6)!="pagina"))
		{
			$param1 = GetJudetCodeByName(str_replace(FILE_EXTENSION,"",$param1));
		}
		if((isset($param2))&&(substr($param2,0,6)!="pagina")&&($param2!=""))
		{
			$param2 = str_replace(".html","",$param2);
			$param1 = GetAnuntIdByAlias($param2);
			$action ="detalii";
		}
	}
}

$registry->route['action'] = $action;
$registry->route['param1'] = $param1;
$registry->route['param2'] = $param2;

//print_r($registry->route);

switch ($action )
{
	case 'detalii':
		$tpl->set_file('tpl_details', 'modules/anunturi/details.tpl');
		#next and previous links
		$tpl->set_block('tpl_details', 'previous', 'previous_block');
		$tpl->set_block('tpl_details', 'next', 'next_block');
		$tpl->set_block('tpl_details', 'NOT_AUTOR', 'NOT_AUTORR');
		$tpl->set_block('tpl_details', 'if_email', 'if_emaill');
		$get_cabinet = GetAnunturi('-1',intval($param1));
		//print_r($get_cabinet );
		
		$tpl->set_var('SHARE_URL', ReWrite('anunturi_detalii', 'anunturi.detalii.'.$param1));
		
		UpdateAnunturiViews(intval($param1));
		$tpl->set_var('SITEBASE', SITE_BASE);
		if (count($get_cabinet) != '0')
		{
			$tpl->set_var("TITLU",$get_cabinet[0]['titlu']);
			$tpl->set_var("ART_DATE",$get_cabinet[0]['data_adaugarii']);
			$tpl->set_var("CONTINUT",nl2br($get_cabinet[0]['continut']));
			$tpl->set_var('AUTOR', $get_cabinet[0]['autor']);
			$tpl->set_var('EMAIL', $get_cabinet[0]['email']);
			$tpl->set_var('NR_VIZUALIZARI',$get_cabinet[0]['nr_visits']);

			if(isset($get_cabinet[0]['email'])&&($get_cabinet[0]['email']!=""))
			{
				$tpl->parse('if_emaill', 'if_email', true);

			}
			$tpl->set_var("IMAGINE",SITE_BASE."/sources/thumbnails.php?target=".$get_cabinet[0]['imagine'].'&max_size=340&anunturi=yes');
			$tpl->set_var('IMAGNAME',$get_cabinet[0]['imagine']);
			
			$cat_name = GetAnunturiCategoryInfos($get_cabinet[0]['category_id']);
			//print_r($cat_name);
			$cat_n = $cat_name['name'];
			$tpl->set_var("BIGCAT",$cat_n);
			$tpl->set_var('ANUNTURIBYCAT',ReWrite("anunturi",'anunturi.'.$get_cabinet[0]['category_id']));
			
			$get_judet = GetJudet("code",$get_cabinet[0]['judet']);
			$tpl->set_var('JUDET',$get_judet['name']  );
			
			$nume_loc = GetLocalitate($get_cabinet[0]['localitate']);
			$tpl->set_var('LOCALITATE',$nume_loc['name']);
			$tpl->set_var('CONTACT_PERS', $get_cabinet[0]['autor']);
			
			$tpl->set_var('DATA_ADAUGARII',$get_cabinet[0]['data_adaugarii']);
			$tpl->set_var('DATA_EXPIRARII',$get_cabinet[0]['data_expirarii']);
			$tpl->set_var('ANUNTURITRIMEMAIL',ReWrite("anunturi","anunturi.trimitemail.".$get_cabinet[0]['id']) );
		}

		#let't take the contact details , to meake some links to ther mai area - cabinetele
		$tpl->set_block('tpl_details', 'AUTOR_DET', 'AUTOR_DETT');
		$check_cabinet_activate = CheckCabinetStatus($get_cabinet[0]['user_id']);
		if(($get_cabinet[0]['user_id']!="-1")&&($check_cabinet_activate=='1'))
		{
		$get_gabinet_for_anunce = GetFirme($get_cabinet[0]['user_id'],"-1");
		$tpl->set_var('AUTOR_NAME',$get_cabinet[0]['autor'] );
		$tpl->set_var('AUTOR_LINK', ReWrite('cabinete_detalii', 'cabinete.detalii.'.$get_gabinet_for_anunce[0]['id']) );
		$tpl->set_var('ANUNTURI_LINK', ReWrite('anunturi', "anunturi.produse.".preg_replace('/[^A-Za-z0-9_]/', '', strtolower($get_cabinet[0]['autor']))."-".$get_cabinet[0]['user_id']));
		$tpl->set_var('ADRESA',$get_gabinet_for_anunce[0]['adresa_firma'] );
		//echo $get_gabinet_for_anunce[0]['adresa_firma'];
		$nume_loc = GetLocalitate($get_gabinet_for_anunce[0]['nume_loc_sector']);
		$tpl->set_var('NUME_LOC_SECTOR',$nume_loc['name'] );
		$tpl->set_var('LOCALITATE', $nume_loc['name'] );
		$tpl->set_var('TELEFON',$get_gabinet_for_anunce[0]['fax'] );
		$tpl->set_var('SHORT_PHONE',substr($get_gabinet_for_anunce[0]['fax'],0,5));
		$tpl->set_var('CAB_ID',$get_gabinet_for_anunce[0]['id'] ); 
		$tpl->set_var('WEBSITE',$get_gabinet_for_anunce[0]['adresa_web'] );
		$tpl->parse('AUTOR_DETT', 'AUTOR_DET', true);
		}
		else
		{
			$tpl->parse('NOT_AUTORR', 'NOT_AUTOR', true);
		}

		#Previous or next link if the cabinete exists
		/*$this_cabinete = GetPreviousOrNextCabinete(intval($param1));
		if (count($this_cabinete))
		{
			#check if there exists and previous cabinet and parse the link
			if (isset($this_cabinete['previous']))
			{
				$tpl->set_var("PREVIOUS_LINK", ReWrite('cabinete_detalii', 'cabinete.detalii.'.$this_cabinete['previous']));
				$tpl->parse("previous_block", "previous", true);
			}
			#check if there exists and previous cabinet and parse the link
			if (isset($this_cabinete['next']))
			{
				$tpl->set_var("NEXT_LINK", ReWrite('cabinete_detalii', 'cabinete.detalii.'.$this_cabinete['next']));
				$tpl->parse("next_block", "next", true);
			}
		}*/
		$tpl->parse('MAIN', 'tpl_details');
	break;
	
	case 'produse':
		$tpl->set_file('tpl_anunturi', 'modules/anunturi/produse.tpl');
		$tpl->set_block('tpl_listanunt', 'list_anunturi', 'list_anunturii');
		$tpl->set_block('tpl_listanunt','if_anunturi','if_anunturii' );
		$tpl->set_block('tpl_listanunt', 'if_no_anunt', 'if_no_anuntt');
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

				$tpl->set_var('CONTINUT', text_best_fit(strtolower($val['continut']),150));
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

	default:
		$tpl->set_file('tpl_anunturi', 'modules/anunturi/anunturi.tpl');
		$tpl->set_block('tpl_anunturi','rowdoicabs','rowdoicabss' );
		//$tpl->set_block('tpl_anunturi','rowunucabs','rowunucabss' );
		$tpl->set_block('tpl_anunturi', 'pagination_table', 'pagination_tablee');
		$tpl->set_block('tpl_anunturi', 'display_cats_anunturi', 'display_cats_anunturii');
		$tpl->set_var("URLREWRITE",$conf->url_rewrite_mode);
		$judet_setat = 'N';
		$get_dentist_categ = GetAnunturiCategories('Y', '');
		foreach($get_dentist_categ as $kky => $vall)
		{
			$tpl->set_var('CAT_NAME',$vall['name'] );
			$rew_cat = ReWrite("anunturi","anunturi.".$vall['id']);
			if(!empty($action) && $action == $vall['id']) $tpl->set_var('SELL_CAT_CLASS', 'list-group-item-info');
			else  $tpl->set_var('SELL_CAT_CLASS', '');
			
			$tpl->set_var('REWRITECAT_ID',$rew_cat );
			$tpl->parse('display_cats_anunturii', 'display_cats_anunturi', true);
		}

		if(!isset($action)||($action===""))
		{
			$tpl->set_var('HIDE_SMALL_VIEW', '');
			$page_name = $module.'.'.$action;
			if(!isset($action)||($action===""))
			{
				$page_name = "anunturi";
			}
			$total_records = CountAnunturiTotalRecords("-1", "","");
			$tpl->set_var('COUNT_ANUNTURI', $total_records);
			$pages_number = ceil($total_records/$conf->cabinete_anunturi_per_page);
			$tpl->set_var("PAGES", $pages_number);
			
				if($conf->url_rewrite_mode == 'Y')
				{
					if(isset($param1)&&(substr($param1,0,6)=="pagina"))
					{		$start = substr($param1,6);	}
					elseif(isset($param2)&&(substr($param2,0,6)=="pagina"))
					{		$start = substr($param2,6);	}
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
			$html_pages = AnunturiFrontEndPagination($conf->cabinete_anunturi_per_page, $total_records, $page_name, $start);
			$tpl->set_var("PAGINATION", $html_pages);
			
			#Create query limit and get the cabinete for displaing
			$limit = " LIMIT $start_q, $conf->cabinete_anunturi_per_page";
			$tpl->set_var('SELECTEDCAT_TOATE',"selected" );
				$i=0;
				$all_anunturi = GetAnunturiGeneral("all",$limit);
				while (list($k, $v) = each($all_anunturi))
				{
					$tpl->set_var('TITLU_ANUNT', ucfirst(strtolower($v['titlu'])));
					$tpl->set_var('DESCRIERE', text_best_fit(ucfirst(strtolower(strip_tags($v['continut']))),130));
				
					$cat_name = GetAnunturiCategoryInfos($v['category_id']);
					$cat_n = $cat_name['name'];
					$tpl->set_var('ANUNTURIBYCAT',ReWrite("anunturi",'anunturi.'.$v['category_id']));
					$tpl->set_var("ART_DATE", $v['data_adaugarii']);
					$tpl->set_var('IMAGE', SITE_BASE."/images/smallimages/anunturi/".$v['imagine']);
					$tpl->set_var('URLCITESTE', ReWrite('anunturi_detalii', 'anunturi.detalii.'.$v['id']));
					$get_judet_name = GetJudetName($v['judet']);
					$tpl->set_var("BIGCAT","Anunturi ".$cat_n." ".$get_judet_name);
					$tpl->set_var('JUDET',$get_judet_name);
					$tpl->set_var('TITLE_URL_ANUNTURI',$v['titlu'] );
					$tpl->set_var('ART_CAT',ReWrite('anunturi','anunturi.'.$v['category_id'].'.'.$v['judet']));
					$tpl->parse('rowdoicabss', 'rowdoicabs', true);	
				}
				$tpl->parse('pagination_tablee', 'pagination_table', true);
	
		}
		else
		{
			$tpl->set_var('HIDE_SMALL_VIEW', 'hidden-xs hidden-sm');
			/**************************for pagination***********************/
			#create de pagination page_name
			$main_cat = GetAnunturiCategoryInfos($action);
			
			$tpl->set_var('SELL_CAT', $main_cat['name']);
			$page_name = $module.'.'.$action;
			if((isset($param1))&&(substr($param1,0,6)!="pagina")&&($param1!=""))
			{
				$total_records = CountAnunturiTotalRecords("category", $param1,$action);
				$page_name = $page_name.'.'.$param1;
				$tpl->set_var('SELL_CAT', $main_cat['name'].', '.GetJudetName($param1));
			}
			elseif((isset($param1) && substr($param1,0,6)=="pagina")||($param1=="")||(!isset($param1)))
			{
				$total_records = CountAnunturiTotalRecords("module", $action,"");
				$judet_setat='Y';
			}

			$tpl->set_var('COUNT_ANUNTURI', $total_records);
			$pages_number = ceil($total_records/$conf->cabinete_anunturi_per_page);
			$tpl->set_var("PAGES", $pages_number);
			
				if($conf->url_rewrite_mode == 'Y')
				{
					if(isset($param1)&&(substr($param1,0,6)=="pagina"))
					{		$start = substr($param1,6);	}
					elseif(isset($param2)&&(substr($param2,0,6)=="pagina"))
					{		$start = substr($param2,6);	}
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
			$getanunturi = GetAnunturiFrontend(intval($action), $param1,$query_limit);
			if (count($getanunturi) != '0')
			{
				$i=0;
				while (list($k, $v) = each($getanunturi))
				{
					$tpl->set_var('TITLU_ANUNT', $v['titlu']);
					$tpl->set_var('DESCRIERE', text_best_fit(strtolower($v['continut']),150));
					$cat_name =  GetAnunturiCategoryInfos($v['category_id']);
					$cat_n = $cat_name['name'];
					$tpl->set_var("ART_DATE", $v['data_adaugarii']);

					$tpl->set_var('ANUNTURIBYCAT',ReWrite("anunturi",'anunturi.'.$v['category_id']));
					$tpl->set_var('IMAGE', SITE_BASE."/images/smallimages/anunturi/".$v['imagine']);
					$tpl->set_var('URLCITESTE', ReWrite('anunturi_detalii', 'anunturi.detalii.'.$v['id']));
					$get_judet_name = GetJudetName($v['judet']);
					$tpl->set_var("BIGCAT","Anunturi ".$cat_n." ".$get_judet_name);
					$tpl->set_var('TITLE_URL_ANUNTURI',$v['titlu'] );
					$tpl->set_var('JUDET',$get_judet_name);
					if($judet_setat=='Y')
					{
					$tpl->set_var('ART_CAT',ReWrite('anunturi','anunturi.'.$v['category_id'].'.'.$v['judet']));
					}

					//$tpl->set_var('ANUNTURIBIGCAT',ReWrite("anunturi","anunturi.".$v['category_id'].".".$v['judet']));
					
					
					$tpl->parse('rowdoicabss', 'rowdoicabs', true);	
					/*$i++;
					if(($i%2==0)||($i==count($getanunturi)))
					{
						$tpl->parse('rowunucabss', 'rowunucabs', true);	
						$tpl->parse('rowdoicabss', '');
					}*/
				}
					$tpl->parse('pagination_tablee', 'pagination_table', true);
			}
		}
		$tpl->parse('MAIN', 'tpl_anunturi');
	break;
	
	case 'trimitemail':
		$tpl->set_file('tpl_trimemail', 'modules/anunturi/trimiteemail.tpl');
		$tpl->set_block('tpl_trimemail', 'error', 'error_block');
		$tpl->set_var('SITEBASE',SITE_BASE );
		$param1 = str_replace(".html","",$param1);
		$id_anunt = $param1;
		$get_anunt_info = GetAnunturi('-1',intval($param1));
		$tpl->set_var('PERSOANA_CONTACT', $get_anunt_info[0]['autor'] );
		$tpl->set_var('ID_ANUNT',$param1 );
		$tpl->set_var('ANUNTURITRIMITEEMAIL', ReWrite("anunturi","anunturi.emailtrimis.".$param1));
		#display error
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
				$_SESSION['submit_errors'] = $display_errors;
				$_SESSION['submit_array'] = array("field_1" => ''.$_POST['field_1'] .'',
																					"field_2" =>''.$_POST["field_2"].'',
																					"field_3" => ''.$_POST['field_3'] .'',
																					"field_4" => ''.$_POST['field_4'] .'',
																					"field_5" =>''.$_POST["field_5"].'');
				
				header('location: '.GetReferer());
				exit;
		}
		$id_anunt = $_POST['id_anunt'];
		$get_anunt_info = GetAnunturi('-1',intval($id_anunt));
		$tpl->set_var('PERSOANA_CONTACT', $get_anunt_info[0]['autor'] );
		$autor = $get_anunt_info[0]['autor'] ; # autorul anuntului
		$email = $get_anunt_info[0]['email']; # aici vom trimite default email pt a anunta ca a primt un mesaj 
		$anunt_title = $get_anunt_info[0]['titlu']; #titlul anuntului
		$user_id = $get_anunt_info[0]['user_id']; #id user

		
		#inseram in baza de date 
		$email_content = $_POST['field_4'];
		$subject = $_POST['field_3'];
		$email_utilizator = $_POST['field_2'];
		$nume_utilizator = $_POST['field_1'];
		$type = 'anunturi';
		$telefon = $_POST['field_5'];
		InsertMesajeutilizator($id_anunt,$subject,$email_content,$email_utilizator,$nume_utilizator, $user_id,$type,$telefon);
		
		
		#trimite email clientului ca a primit un mesaj pe dentistonline.ro doar din admin Panel!!
		/*
			$text = GetFileContent('./templates/emails/mesajutilizator.tpl');
			$text = str_replace("%OFERTA_CABINET%", $anunt_title, $text);
			$text = str_replace("%PERSOANA_CONTACT%", $autor , $text);
			
			$Recipiant = $email;
			$CustomHeaders = '';
			$Sender = 'DentistOnline.ro<'.$conf->contact_recipient.'>';
			$Subject = "Ati primit un mesaj pe Dentistonline.ro ";
			
			$message = new Email($Recipiant, $Sender, $Subject, $CustomHeaders);
			$message->SetHtmlContent($text);
			if (ValidHeader($Sender))
			{
				$message->Send();
			}*/
			$_SESSION['submit_errors'] = "<li>Mesajul a fost trimis cu succes!</li>";
			header('location: '.ReWrite("anunturi","anunturi.trimitemail.".$id_anunt));exit;
	break;

}

?>