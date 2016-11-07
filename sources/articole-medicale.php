<?php
$all_infos=array();

#this script insert into redirect links old link,and new link
/*$action=5;
$the_children = GetSubmenuItems ("cabinete", $action, @$this_param1);
unset($the_children[0]);
foreach($the_children as $ky => $val)
{
	 $old_link1 = explode("http://www.dentistonline.ro/",$val['link']);
	 $old_link2 = substr( $old_link1[1],0,-5)."/";
	//echo 	  $old_link2;
	 $new_link = $val['link'];
	// echo 	  $new_link;
		$query="INSERT INTO redirect_links (old_link,new_link) values( '".$old_link2."','".$new_link."')";
		$db->query($query);
	 echo "<br />";

}*/
$new_acction="";
if($conf->url_rewrite_mode == 'Y')
{
	if(isset($param1) && $param1==="downloadarticol")
	{
		$new_acction = "downloadarticol";
	}

	if((isset($param1))&&(substr($param1,0,6)!="pagina")&&($param1!="")&&($action!='trimitemail')&&($action!='emailtrimis'))
	{
		$cat_name = str_replace(".html","",$param1);
		$all_infos = GetArticleCategoryInfosByAlias($cat_name);
		$param1 = $all_infos['id_cat'];
		$registry->route['param1'] = $param1;
	}

	if((isset($param2))&&(substr($param2,0,6)!="pagina")&&($param2!="")&&($action!='trimitemail')&&($action!='emailtrimis'))
	{
		$param2 = str_replace(".html","",$param2);
		$param1 = GetArtIdByAlias($param2);
		$action = "detalii";
		if($new_acction=='downloadarticol')
		{
			$action = "downloadarticol";
			$param1 = $param2;
		}
		$registry->route['action'] = $action;
		$registry->route['param1'] = $param1;
		$registry->route['param2'] = $param2;
	}
}
//echo "modulul:".$module."--------- actiunea:".$action."=========== param 1 este: ".$param1.$param2;

//echo "testam";exit;
//var_dump($param1);
//echo "modulul:".$module."--------- actiunea:".$action."=========== param 1 este: ".$param1;exit;
//echo $module." "
switch ($action )
{
	default:
		$tpl->set_file('tpl_art', 'modules/articole/articole.tpl');
		$tpl->set_block('tpl_art','rowdoiart','rowdoiartt' );
		
		#this is to display the bloks for medical articles categories
		$tpl->set_block('tpl_art','rowunucabs','rowunucabss' );
		$tpl->set_block('tpl_art', 'pagination_table', 'pagination_tablee');
		
		#we get all articles categories
		$i=0;
		$get_articles_categ = GetArticlesCategories('Y', '');
		foreach($get_articles_categ as $kky => $vall)
		{
				$tpl->set_var('CAT_NAME',$vall['cat_name'] );
				$rew_cat = ReWrite("articole","articole-medicale.".$vall['id_cat']);
				$nr_articles = CountArticlesTotalRecords ($vall['id_cat'],'1');
				if(isset($param1) && $param1 == $vall['id_cat']) $tpl->set_var('SELL_CAT_CLASS', 'list-group-item-info');
				else  $tpl->set_var('SELL_CAT_CLASS', '');
				
				$tpl->set_var('NR_ART',$nr_articles );
				$tpl->set_var('REWRITECAT_ID',$rew_cat );
				$tpl->set_var('IMAGE_CATEGORY',"{SITE_BASE}/images/admin/articles_categories_image/".$vall['image_name'] );
				$tpl->parse('rowdoiartt', 'rowdoiart', true);	
				$i++;
		}
		/**************************for pagination***********************/
		#create de pagination page_name
		$page_name = $module.'.'.$action;
		$status=1;
		if((isset($param1))&&(substr($param1,0,6)!="pagina")&&($param1!=""))
		{
			$total_records = CountArticlesTotalRecords ($param1, $status);
			$cat_id = $param1;
			$page_name = $module.'.'.$param1;
			$cat_details = GetArticleCategoryInfos($cat_id);
			$cat_name = "categoria <B>".$cat_details['cat_name']."</b>";
			$tpl->set_var('HIDE_SMALL_VIEW', 'hidden-xs hidden-sm');

		}
		elseif((!isset($param1))||(isset($param1) && substr($param1,0,6)=="pagina")||($param1==""))
		{
			$total_records = CountArticlesTotalRecords ("all", $status);
			$cat_id ="all";
			$cat_name = " toate categoriile";
			$tpl->set_var('HIDE_SMALL_VIEW', '');
		}
		$tpl->set_var('CATEGORY_NAME', $cat_name);
		
			$tpl->set_var('COUNT_ARTICLES', $total_records);
			$pages_number = ceil($total_records/$conf->cabinete_anunturi_per_page);
			$tpl->set_var("PAGES", $pages_number);
			
				if($conf->url_rewrite_mode == 'Y')
				{
					if(isset($param1)&&(substr($param1,0,6)=="pagina"))
					{		$start = substr($param1,6);	}
					elseif(isset($param2)&&(substr($param2,0,6)=="pagina"))
					{	$start = substr($param2,6);	}

				}
			if(!isset($start)||($start=="")||($start==FALSE))
			{
				$start_q = 0;
				$start = 1;
			}
			else
			{
				$start_q = $conf->cabinete_anunturi_per_page*($start-1);
			}
			#Create and parse pagination
			$html_pages = ArticlesFrontEndPagination($conf->cabinete_anunturi_per_page, $total_records, $page_name, $start);
			//print_r($html_pages );exit;
			$tpl->set_var("PAGINATION", $html_pages);
			#Create query limit and get the cabinete for displaing
			$query_limit = " LIMIT $start_q, $conf->cabinete_anunturi_per_page";
			$getanunturi = ListAdminArticles ($cat_id, $status, $query_limit);
			
			if (count($getanunturi) != '0')
			{$i=0;
			
				while (list($k, $v) = each($getanunturi))
				{
					$tpl->set_var('TITLU_ANUNT', $v['titlu']);
					$tpl->set_var('DESCRIERE', text_best_fit(strip_tags($v['continut']),120));
					if($cat_id=="all")
					{	
						$cat_name =  GetArticleCategoryInfos($v['bigcat_id']);
						$tpl->set_var("BIGCAT", $cat_name['cat_name']);
						$tpl->set_var("CATEGORY_DISPLAY","<span class=\"small\"><a href=".ReWrite("articole","articole-medicale.".$v['bigcat_id'])."> Articole ". $cat_name['cat_name']."</a></span>" );
					}
					else
					$tpl->set_var("CATEGORY_DISPLAY","");
				
					$tpl->set_var("ART_DATE", TimeFormatEvents($v['data_adaugarii']));
					$tpl->set_var('ART_CAT',ReWrite("articole","articole-medicale.".$v['bigcat_id']));
					$tpl->set_var('IMAGE', SITE_BASE."/images/smallimages/articole/".$v['id']."/".$v['imagine']);
					$tpl->set_var('URLCITESTE', ReWrite('articole', 'articole-medicale.articol.'.$v['bigcat_id'].'.'.$v['id']));
					$tpl->set_var('TITLE_URL_ANUNTURI',$v['titlu'] );
					$tpl->parse('rowunucabss', 'rowunucabs', true);	
				}
				$tpl->parse('pagination_tablee', 'pagination_table', true);
			}
		$tpl->parse('MAIN', 'tpl_art');
	break;
	
	case 'detalii':
		$tpl->set_file('tpl_details', 'modules/articole/detalii.tpl');
		$tpl->set_block('tpl_details', 'articole_related', 'articole_related_block');
		$tpl->set_block('tpl_details', 'if_pdf_file', 'if_pdf_file_block');
		$get_cabinet = GetArticole(-1,intval($param1));
		if (count($get_cabinet)<1)
		{
			FakeError ();
			$tpl->set_file('tpl_main', 'unpublished.tpl');
			$tpl->set_var('ERRORMSG', 'Aceasta pagina nu este disponibila');
			$tpl->parse('MAIN', 'tpl_main');
		}
		UpdateArticleViews($param1); 
		$tpl->set_var('SITEBASE', SITE_BASE);
		$tpl->set_var('SHARE_URL', ReWrite('articole', 'articole-medicale.articol.'.$get_cabinet[0]['category_id'].'.'.$param1));
		if (count($get_cabinet) != '0')
		{
			$tpl->set_var("TITLU",$get_cabinet[0]['titlu']);
			$tpl->set_var("ART_DATE",$get_cabinet[0]['data_adaugarii']);
			$tpl->set_var("CONTINUT",nl2br($get_cabinet[0]['continut']));
			$tpl->set_var('EMAIL', $get_cabinet[0]['email']);
			$tpl->set_var('NR_VIZUALIZARI',$get_cabinet[0]['nr_visits']);
			$tpl->set_var("IMAGINE",SITE_BASE."/sources/thumbnails.php?target=".$get_cabinet[0]['imagine'].'&max_size=340&articles=yes');
			$tpl->set_var('IMAGNAME',$get_cabinet[0]['imagine']);
			
		/*	$cat_name = Get_Dentist_Cats($get_cabinet[0]['category_id']);
			$cat_n =$cat_name[0]['name'];
			$tpl->set_var("BIGCAT",$cat_n);*/
			if(isset($get_cabinet[0]['related'])&&($get_cabinet[0]['related']!=""))
			{
				$articole_related = explode(",",$get_cabinet[0]['related']);
				foreach($articole_related as $ky => $val)
				{
					if($val!="")
					{
						$get_art_det= GetArticole(-1,intval($val));
						$tpl->set_var('ARTICLE_RELATED_LINK',  ReWrite('articole', 'articole-medicale.articol.'.$get_art_det[0]['category_id'].'.'.$get_art_det[0]['id']));
						$tpl->set_var('ARTICLE_REALATED_TITLE', ucfirst(strtolower($get_art_det[0]['titlu'])));
						$tpl->parse('articole_related_block', 'articole_related', true);
					}
				}
			}

			if($get_cabinet[0]['user_id']!="-1")
				{
					$tpl->set_var('PARSE_EMAIL', "<a href=\"{URLTRIMITEEMAIL}\" ><b>Trimite E-mail</b>");
					$tpl->set_var('URLTRIMITEEMAIL',ReWrite('articol_trimitemail','articole-medicale.trimitemail.'.$param1));
				}
		}
		
		#let's take the pdf file if exist
		$art_file = getArticolServiciiFile($param1);
		//var_dump($art_file);
		if (is_array($art_file) )
		{
			//print_r($servicii_file);
			$file_type = explode(".",$art_file['name']);
			$file_ext = $file_type[count($file_type)-1];
			$tpl->set_var('CLASS_TYPE', "download_".$file_ext);
			$tpl->set_var('URL_SERVICII_FILE', Rewrite("default","articole-medicale/downloadarticol/".$param1)); 
			//$a = Rewrite("default","articole-medicale/downloadarticol/".$param1);
			//print_r($a);
			//$tpl->set_var('TEXT_DOWNLOAD', "!!Download acum fisierul  :".$get_cabinet['nume_firma']); 
			$tpl->parse('if_pdf_file_block', 'if_pdf_file', true);
		}
		else 
		{
			$tpl->parse('if_pdf_file', false);
		}
			

		#let't take the contact details , to meake some links to ther mai area - cabinetele
		$tpl->set_block('tpl_details', 'AUTOR_DET', 'AUTOR_DETT');
		if($get_cabinet[0]['user_id']!="-1")
		{
		$get_gabinet_for_anunce = GetFirme($get_cabinet[0]['user_id'],"-1");
		$tpl->set_var('AUTOR_NAME',$get_cabinet[0]['autor'] );
		$tpl->set_var('AUTOR_LINK', ReWrite('cabinete_detalii', 'cabinete.detalii.'.$get_gabinet_for_anunce[0]['id']) );
		$tpl->set_var('ADRESA',ucfirst($get_gabinet_for_anunce[0]['adresa_firma']) );
		$nume_loc = GetLocalitate($get_gabinet_for_anunce[0]['nume_loc_sector']);
		$tpl->set_var('NUME_LOC_SECTOR',$nume_loc['name'] );
		$tpl->set_var('LOCALITATE', $nume_loc['name'] );
		$tpl->set_var('TELEFON',$get_gabinet_for_anunce[0]['fax'] );
		$tpl->set_var('SHORT_PHONE',substr($get_gabinet_for_anunce[0]['fax'],0,5));
		$tpl->set_var('CAB_ID',$get_gabinet_for_anunce[0]['id'] ); 
		$tpl->set_var('WEBSITE',$get_gabinet_for_anunce[0]['adresa_web'] );
		$tpl->parse('AUTOR_DETT', 'AUTOR_DET', true);
		}
		$tpl->parse('MAIN', 'tpl_details');
	break;
	
	case 'trimitemail':
		//print_r($_SESSION);exit;
		$tpl->set_file('tpl_trimemail', 'modules/articole/trimiteemail.tpl');
		$tpl->set_block('tpl_trimemail', 'error', 'error_block');
		$tpl->set_var('SITEBASE',SITE_BASE );
		$param2 = str_replace(".html","",$param2);
		$alias = $param2;
		$param2 = str_replace("-"," ",$param2);
		
		$param1 = GetArtIdByAlias($alias);
		$tpl->set_var('ARTICOL', $param2 );
		$tpl->set_var('ID_ARTICOL',$param1 );
		$tpl->set_var('CABINETETRIMITEEMAIL', ReWrite("articol_trimitemail","articole-medicale.emailtrimis.".$param1));
		#display error
			if (isset($_SESSION['submit_errors']))
			{
				$tpl->set_var("ERROR_MSG", $_SESSION['submit_errors']);
				unset($_SESSION['submit_errors']);
				$tpl->parse("error_block", "error", true);
			}
			#fill fields
			if (isset($_SESSION['submit_array'])&&($_SESSION['submit_array']!=""))
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
																					"field_2" =>''.$_POST["field_2"].'',
																					"field_3" => ''.$_POST['field_3'] .'',
																					"field_4" => ''.$_POST['field_4'] .'',
																					"field_5" =>''.$_POST["field_5"].'');
				header('location: '.GetReferer());
				exit;
		}
		$id_articol = $_POST['id_articol'];
		$get_articol_info =  GetArticole(-1,intval($id_articol));
		$tpl->set_var('PERSOANA_CONTACT', $get_anunt_info[0]['autor'] );
		$autor = $get_articol_info[0]['autor'] ; # autorul anuntului
		$email = $get_articol_info[0]['email']; # aici vom trimite default email pt a anunta ca a primt un mesaj 
		$anunt_title = $get_articol_info[0]['titlu']; #titlul anuntului
		$user_id = $get_articol_info[0]['user_id']; #id user
		#inseram in baza de date 
		$email_content = $_POST['field_4'];
		$subject = $_POST['field_3'];
		$email_utilizator = $_POST['field_2'];
		$nume_utilizator = $_POST['field_1'];
		$telefon = $_POST['field_5'];
		$type = "articles";

		InsertMesajeutilizator($id_articol,$subject,$email_content,$email_utilizator,$nume_utilizator, $user_id,$type,$telefon);
		$_SESSION['submit_errors'] = "<li>Mesajul a fost trimis cu succes!</li>";
		header('location: '.ReWrite("articol_trimitemail","articole-medicale.trimitemail.".$id_articol));exit;
	break;

	case 'downloadarticol':
		$servicii_file = getArticolServiciiFile($param1);
		$filename = './articole_file/'.$servicii_file['name'];
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

}

?>