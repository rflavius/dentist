<?php

switch($action)
{
	case 'contnou':
		$tpl->set_file('tpl_main', "./modules/".$module.'/cont_nou.tpl');
		$tpl->set_var('PAGINAOFERTA', ReWrite("pagina","pagina.oferta"));
		$tpl->set_var('TERMENICONDITII',ReWrite("pagina","pagina.termeniconditii") );
		$tpl->parse('MAIN', 'tpl_main', true);
	break;
	
	case 'oferta':
		$pk = new Pachete_Servicii($db);
		$reviews = new Dentist_Reviews();
		
		$tpl->set_file('tpl_main', "modules/".$module.'/oferta_new.tpl');
		$tpl->set_block('tpl_main','list_servicii','list_servicii2');
		$tpl->set_block('tpl_main','list_pachete','list_pachete2');
		$tpl->set_block('tpl_main','list_reviews','list_reviews2');
		$tpl->set_block('tpl_main','error','error2');
		
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
		$pachete = $pk->listPacheteFrontend('Y');
		foreach($pachete as $ky => $val)
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
			$serv = $pk->listPachetServicii($val['id']);
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
		
		$tpl->set_var('USER_CREATE_LINK',ReWrite('user', 'user.create'));
		
		#display error
		if (isset($_SESSION['submit_errors']))
		{
			$tpl->set_var("ERROR_MSG", $_SESSION['submit_errors']);
			unset($_SESSION['submit_errors']);
			$tpl->parse("error2", "error", true);
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
		#Set the security code
		$tpl->set_var('SECURITYID', md5(time()));
		
		$tpl->parse('MAIN', 'tpl_main', true);
	break;
	
	case 'termeniconditii':
		$tpl->set_file('tpl_main', "./modules/".$module.'/termeniconditii.tpl');
		
		$tpl->parse('MAIN', 'tpl_main', true);
	break;
	case 'detaliiadaugafirma':
		$tpl->set_file('tpl_main', './modules/'.$module.'/detalii_adaugafirma.tpl');
		$tpl->parse('MAIN', 'tpl_main', true);
	break;
	
	case 'cabinete':
		$tpl->set_file('tpl_cabinete', 'modules/'.$module.'/cabinete.tpl');
		$tpl->set_block('tpl_cabinete', 'pagination_table', 'pagination_tablee');
		$tpl->set_block('tpl_cabinete','rowunucabs','rowunucabss' );
		
		$page_name = $module.'.'.$action;
		
		$total_records = CountCabineteTotalRecordsRecents();
		$conf->cabinete_anunturi_per_page='25';
		$tpl->set_var('COUNT_CABINETE', $total_records);
		$pages_number = ceil($total_records/$conf->cabinete_anunturi_per_page);
		$tpl->set_var("PAGES", $pages_number);
	
		if($conf->url_rewrite_mode == 'Y')
		{
			if(isset($param1)&&(substr($param1,0,6)=="pagina"))
			{		$start = substr($param1,6);	}
			else
			{
				$start=1;
			}
		}
		//echo $start." ".$param1;
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
		$conf->cabinete_anunturi_per_page=$conf->cabinete_anunturi_per_page-2;
		#Create query limit and get the cabinete for displaing
		$query_limit = " LIMIT $start_q, $conf->cabinete_anunturi_per_page";
		
		$cabinete = GetCabineteRecente($query_limit);
		$i=0;
		foreach($cabinete as $ky => $val)
		{
					$i++;
					$v = GetSelectedCabinet($val); 
					$tpl->set_var('NUME_FIRMA', $v['nume_firma']);
					switch($v['category_id'])
					{
						case '1':
							if($i%3==0)
							{
								$end_ref="cabinet stomatologic";
							}
							else
							{
								$end_ref="";
							}
							
						break;
						case '2':
							$end_ref="radiologie dentara";
						break;
						case '3':
							$end_ref="tehnica dentara";
						break;
						case '4':
							$end_ref="distribuitor materiale";
						break;
					
						case '5':
							$end_ref="clinici stomatologice";
						break;
					}
					
					$tpl->set_var('AHREFCABS',$v['nume_firma']." ".$end_ref);
					$tpl->set_var('URLCITESTE', ReWrite('cabinete_detalii', 'cabinete.detalii.'.$val));
					$tpl->parse('rowunucabss', 'rowunucabs', true);	
		}
		$tpl->parse('pagination_tablee', 'pagination_table', true);
		$tpl->parse('MAIN', 'tpl_cabinete');	
	break;
	
	case 'feedback':
		if(empty($_POST))
		{
			$tpl->set_file('tpl_main', 'modules/'.$module.'/feedback.tpl');
			$tpl->set_var('SECURITYID', md5(time()));
			if(!empty($_SESSION['feedback']))
			{
				$tpl->set_var('EMAIL', $_SESSION['feedback']['email']);
				$tpl->set_var('NAME', $_SESSION['feedback']['name']);
			}
			$tpl->parse('MAIN', 'tpl_main');
		}
		else 
		{
			unset($_SESSION['feedback']);
			$errors = "";
			
			//submit the feedback
			$check = SecurityImageGeneral($_POST['security_code'], $_SESSION['security_code']);
			unset($_SESSION['security_code']);
			
			if(!$check)
			{
				$errors = "Codul de siguranta este invalid!"; 
			}
			
			if(empty($_POST['name'])) $errors.= "<br>Va rugam sa complectati numele dvs !";

			if(empty($_POST['email'])) $errors.= "<br>Nu ati complectat adresa dvs de email !";
			elseif(!ValidEmail($_POST['email'])) $errors.= "<br>Adresa dvs de email nu este valida !";

			if(empty($_POST['text'])) $errors.= "<br>Va rugam sa complectati sugestia/parerea dvs !";
			
			if(!empty($errors))
			{
				$_SESSION['error']['type'] = 'error';
				$_SESSION['error']['message'] = $errors;
				$_SESSION['error']['post'] = $_POST;
				header("Location: ".ReWrite('default', 'pagina-feedback'));
				exit;
			}
			else 
			{
				$data = array('name' => $_POST['name'], 'email' => $_POST['email'], 'text' => $_POST['text'], 'refferer' => GetReferer(), 'IP' => GetUserIP(), 'date' => new Zend_Db_Expr('NOW()'));
				addFeedback($data);
				$_SESSION['error']['type'] = 'info';
				$_SESSION['error']['message'] = "Va multumim pentru contributia dvs.";
				header("Location: ".SITE_BASE);
				exit;
			}
		}
		
		
	break;
}
?>