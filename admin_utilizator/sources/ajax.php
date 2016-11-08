<?php

require(realpath(dirname(dirname(dirname(__FILE__)))).'/preload.php');

switch($_GET['type'])
{
	case 'amount':
		$pachete = new Pachete_Servicii($d);
		if($pachete->ifPachetFree($_GET['level']))
		{
			$text= "<font color='blue'>PERIOADA PROMOVARE: ".$_GET['perioada']." luni</font>";
			$final = '0';
		}
		else 
		{
			$level_details = $pachete->getPachetInfo($_GET['level']);
			$amount = $level_details['pret']*$_GET['perioada'];
			$_SESSION['promovare'][$level] = 'selected'; // set up the selected level session !!
			
			if($level_details['discount']!='0' && !empty($level_details['discount']))
			{
				switch ($level_details['discount_type'])
				{
					case 'month':
						$final = $amount - ($level_details['discount']*$level_details['pret']);
						$text = "<font color='blue'>DISCOUNT: ".$level_details['discount']." luni</font>";
						$text.= "<br>".$amount."RON - ( ".$level_details['discount']."luni * ".$level_details['pret']."RON ) = ".$final." RON";
						
					break;
				
					case 'percent':
						$final = round($amount - (($level_details['discount']/100) * $amount));
						$text = "<font color='blue'>DISCOUNT: ".$level_details['discount']."%</font>";
						$text.= "<br>".$amount."RON - ".$level_details['discount']."% = ".$final." RON";
					break;
				}
			}
			else
			{
				$final = $amount;
				$text = $final." RON";
			}
			$text.= "<br><font color='blue'>PERIOADA PROMOVARE: ".$_GET['perioada']." luni</font>";
			$_SESSION['promovare']['cost_total'] = $final;
		}
		
		$results = array('text' => $text, 'amount' => $final);
		header('Content-Type: application/json');
		echo json_encode($results);exit;
	break;
	
	case 'abonament':
		$level_details = getPromovareLevelDetails($_GET['level']);
		$nr_cabinete_abonament = countCabineteAbonament($_SESSION['userinfo']->id);
		$discount = $nr_cabinete_abonament * $conf->discount_abonament_procent;

		$level = $_GET['level'];
		if(!isset($_SESSION['promovare']['cost_total']))
		{
			$_SESSION['promovare']['cost_total'] = $level_details['pret'];
			$_SESSION['promovare'][$level] = 'selected'; // set up the selected level session !!
			$_SESSION['promovare']['last_selected_abonament'] = $level; // set up the last selected level session !!
		}
		else
		{
			## only if we have a new level
			if(!isset($_SESSION['promovare'][$level]))
			{
				$_SESSION['promovare'][$level] = 'selected'; // set up the selected level session !!
				## if the old selected level is different than the current one... then remove the old selected level from the total cost variable
				if($_SESSION['promovare']['last_selected_abonament']!=$level)
				{
					unset($_SESSION['promovare'][$_SESSION['promovare']['last_selected_abonament']]);
					$old_level = getPromovareLevelDetails($_SESSION['promovare']['last_selected_abonament']);
					$_SESSION['promovare']['cost_total']-=$old_level['pret'];
					## now add the new level price into total cost variable
					$_SESSION['promovare']['cost_total']+=$level_details['pret'];
				}
				$_SESSION['promovare']['last_selected_abonament']= $level;
			}
		}
		//print_r($_SESSION['promovare']);exit;
		$_SESSION['promovare']['cost_total']-=$discount;
		echo $_SESSION['promovare']['cost_total']." RON";exit;
	break;

	case 'recomand':
		$level_details = getPromovareLevelDetails($_GET['level']);
		$level = $_GET['level'];
		if(!isset($_SESSION['promovare']['cost_total']))
		{
			$_SESSION['promovare']['cost_total'] = $level_details['pret'];
			$_SESSION['recomandare'][$level] = 'selected'; // set up the selected level session !!
			$_SESSION['recomandare']['last_selected_recomand'] = $level; // set up the last selected level session !!
		}
		else
		{
			## only if we have a new level
			if(!isset($_SESSION['recomandare'][$level]))
			{
				$_SESSION['recomandare'][$level] = 'selected'; // set up the selected level session !!
				## if the old selected level is different than the current one... then remove the old selected level from the total cost variable
				if($_SESSION['recomandare']['last_selected_recomand']!=$level)
				{
					unset($_SESSION['recomandare'][$_SESSION['recomandare']['last_selected_recomand']]);
					$old_level = getPromovareLevelDetails($_SESSION['recomandare']['last_selected_recomand']);
					$_SESSION['promovare']['cost_total']-=$old_level['pret'];
					## now add the new level price into total cost variable
					$_SESSION['promovare']['cost_total']+=$level_details['pret'];
				}
				$_SESSION['recomandare']['last_selected_recomand']= $level;
			}
		}
		echo $_SESSION['promovare']['cost_total']." RON";exit;
	break;
	
	case 'calculate_total':
		$pk = new Pachete_Servicii($db);
		$pachet = $pk->getPachetInfo($_GET['pk']);
		if($_GET['pk']=='1')
		{
			$total = 0;
			$pachet_serv = explode(";",$_GET['servicii']);
			foreach($pachet_serv as $ky3 => $val3)
			{
				if($val3!='')
				{
					$serv = $pk->getServiciuInfo($val3);
					$total+=$serv['price'];
				}
			}
			
			echo $total;exit;
		}
		else
		{
			echo $pachet['pret'];exit;
		}
	break;
	
	case 'free_user_modal':
		
		$tpl = new Template(APPLICATION_PATH.'/templates/admin_utilizator/');
		$get_firme = GetFirme($_SESSION['userinfo']->id,"-1");
		if(count($get_firme)>0)
		{
			$has_free = false;
			foreach ($get_firme as $key => $value)
			{
				// if has OLD FREE package
				if($value['level']=='1') $has_free = true;
			}
			
			if($has_free)
			{
				if(showFreeUserModal())
				{
					$tpl->set_file('tpl_ajax', 'free_user_modal.tpl');
					$tpl->pparse('AJAX_RESPONSE','tpl_ajax');
				}
				else $tpl->set_var('AJAX_RESPONSE','');
			}
		}
	break;
	
	case 'list-cities':
		$tpl = new Template(APPLICATION_PATH.'/templates/admin_utilizator/');
		$tpl->set_file('tpl_ajax', 'ajax/list-cities.tpl');
		$tpl->set_block('tpl_ajax','list_cities','list_cities2');
		$cod_judet = $_GET['judet'];
		$get_dentist_localitati = GetLocalitati($cod_judet);
		foreach($get_dentist_localitati as $ky => $val)
		{
			$tpl->set_var('CITY_CODE',$val['id'] );
			$tpl->set_var('CITY',$val['name'] );
			$tpl->parse('list_cities2', 'list_cities', true);
		}
		$tpl->pparse('MAIN','tpl_ajax');
	break;
	
	case 'new-add':
		$tpl = new Template(APPLICATION_PATH.'/templates/admin_utilizator/');
		switch($_GET['step'])
		{
			case '1':
				echo '1';
			break;
			
			case '2':
				$tpl->set_file('tpl_ajax', 'ajax/new-add/step2.tpl');
				$tpl->pparse('MAIN','tpl_ajax');
			break;
			
			case '3':
				$tpl->set_file('tpl_ajax', 'ajax/new-add/step3.tpl');
				$tpl->pparse('MAIN','tpl_ajax');
			break;
		}
	break;
}




?>