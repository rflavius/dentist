<?php
switch ($action)
{
	case 'list':
		$tpl->set_file('tpl_list', 'contracte/list.tpl');
		#page main title
		$tpl->set_var('MAIN_TITLE', 'Listare contracte');
		#set blocks
		$tpl->set_block('tpl_list', 'list_messages', 'list_messages_block');
		$tpl->set_block('tpl_list', 'if_messages', 'if_messages_block');
		if($param1=="")
		{
			$param1 = "adaugare_contract_desc";
			$param2 = "all";
		}
		$tpl->set_var(strtoupper($param1),"selected" );
		$tpl->set_var("SELECTED".strtoupper($param2),"selected" );

		#count all messages
		$total_records = CountContracte($param1,$param2);
		$tpl->set_var('COUNT_CONTRACTE', $total_records);
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
		$contracte = GetContracte($param1,$param2, $query_limit);
		if (count($contracte) != '0')
		{
			$i = 0;
			while (list($k, $v) = each($contracte))
			{
				#set colors*/
				$bc = ($i % 2)+1;
				$tpl->set_var("BGCOLOR", 'row'.$bc);
				if(substr($v['adaugare_contract'],0,10)==date("Y-m-d"))
				{	$tpl->set_var("BGCOLOR", "today_add");	}
				
				if(substr($v['expirare_contract'],0,10)==date("Y-m-d"))
				{	$tpl->set_var("CLASSEXP", "style=\"color:red;\"");	}
				else
				{
					$tpl->set_var("CLASSEXP", "");
				}

				$tpl->set_var('ID',$v['id'] );
				
				if($v['user_id']==='-1')
				{	$get_username="admin";}
				else
				{	$get_username = GetUserName($v['user_id']);}
				$tpl->set_var('USERNAME',$get_username );
				$tpl->set_var('USER_ID',$v['user_id'] );
				
				$tpl->set_var('FIRMA_ID',$v['firma_id'] );
				$tpl->set_var('TYPE',ucfirst($v['type']) );
				$tpl->set_var('EXPIRARE_CONTRACT',$v['expirare_contract'] );
				$tpl->set_var('ADAUGARE_CONTRACT',$v['adaugare_contract'] );
				$tpl->set_var('COST',$v['cost'] );
				$tpl->set_var('ACHITAT',$v['achitat'] );
				$tpl->set_var('ID_PROFORMA',$v['factura_proforma_id'] );
				
				$tpl->set_var('ID_FISCALA',$v['factura_fiscala_id'] );
				$tpl->set_var('NUME_FIRMA',$v['nume_firma'] );
				
				//$tpl->set_var('',$v[''] );
					if ($v['status'] == 'Y')
				{
					$tpl->set_var('IMAGE', 'active.png');
					$tpl->set_var('IMAGE_TITLE', 'inactive');
				}
				else 
				{
					$tpl->set_var('IMAGE', 'inactive.png');
					$tpl->set_var('IMAGE_TITLE', 'active');
				}

				$tpl->parse('list_messages_block', 'list_messages', true);
				$i++;
			}
			$tpl->parse('if_messages_block', 'if_messages', true);
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
		$tpl->parse('MAIN', 'tpl_list');
	break;
	
	case 'set':
		ChangeContractStatus($param1, $param2);
		$_SESSION['admin_info'] = 'Contract status successfully changed !';
		$_SESSION['admin_info_type'] = 'info';
		header ('location: '.$_SERVER['HTTP_REFERER']);
		exit;
	break;
	
	case 'cauta':
		$tpl->set_file('tpl_list', 'contracte/cauta.tpl');
		#page main title
		$tpl->set_var('MAIN_TITLE', 'Cautare contracte');
		#set blocks
		$tpl->set_block('tpl_list', 'list_messages', 'list_messages_block');
		$tpl->set_block('tpl_list', 'if_messages', 'if_messages_block');
		if($param1=="")
		{
			$param1 = "id_contract";
			$param2 = "all";
		}
		$tpl->set_var(strtoupper($param1),"selected" );
		$tpl->set_var('CE_CAUTAM',strtoupper(substr($param1,0,-9)) );
		$tpl->set_var("VALOARE_CAUTARE",$param2);

		#count all messages
		$total_records = CountContracteCauta($param1,$param2);
		$tpl->set_var('COUNT_CONTRACTE', $total_records);
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
		$contracte = GetContracteCauta($param1,$param2, $query_limit);
		if (count($contracte) != '0')
		{
			$i = 0;
			while (list($k, $v) = each($contracte))
			{
				#set colors*/
				$bc = ($i % 2)+1;
				$tpl->set_var("BGCOLOR", 'row'.$bc);
				if(substr($v['adaugare_contract'],0,10)==date("Y-m-d"))
				{	$tpl->set_var("BGCOLOR", "today_add");	}
				
				if(substr($v['expirare_contract'],0,10)==date("Y-m-d"))
				{	$tpl->set_var("CLASSEXP", "style=\"color:red;\"");	}
				else
				{
					$tpl->set_var("CLASSEXP", "");
				}

				$tpl->set_var('ID',$v['id'] );
				
				if($v['user_id']==='-1')
				{	$get_username="admin";}
				else
				{	$get_username = GetUserName($v['user_id']);}
				$tpl->set_var('USERNAME',$get_username );
				$tpl->set_var('USER_ID',$v['user_id'] );
				
				$tpl->set_var('FIRMA_ID',$v['firma_id'] );
				$tpl->set_var('TYPE',ucfirst($v['type']) );
				$tpl->set_var('EXPIRARE_CONTRACT',$v['expirare_contract'] );
				$tpl->set_var('ADAUGARE_CONTRACT',$v['adaugare_contract'] );
				$tpl->set_var('COST',$v['cost'] );
				$tpl->set_var('ACHITAT',$v['achitat'] );
				$tpl->set_var('ID_PROFORMA',$v['factura_proforma_id'] );
				$tpl->set_var('ID_FISCALA',$v['factura_fiscala_id'] );
				$tpl->set_var('NUME_FIRMA',$v['nume_firma'] );
				
				//$tpl->set_var('',$v[''] );
					if ($v['status'] == 'Y')
				{
					$tpl->set_var('IMAGE', 'active.png');
					$tpl->set_var('IMAGE_TITLE', 'inactive');
				}
				else 
				{
					$tpl->set_var('IMAGE', 'inactive.png');
					$tpl->set_var('IMAGE_TITLE', 'active');
				}

				$tpl->parse('list_messages_block', 'list_messages', true);
				$i++;
			}
			$tpl->parse('if_messages_block', 'if_messages', true);
		}
		else
		{
			$tpl->set_var('NOTFOUND',"Nu am gasit nici un contract cu aceste caracteristici!" );
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
		$tpl->parse('MAIN', 'tpl_list');
	break;

	case 'schimba':
		$contract_id = $param1;
		if($param2==="Y")
		{
			$query ="Update contracte set achitat='N',status='N' where id='".$param1."'";
		}
		else
		{
			$query ="Update contracte set achitat='Y',status='Y' where id='".$param1."'";
		}
		$db->query($query);
		header('location: '.GetReferer());exit;
		
	break;
	case 'detaliicontract':
		$tpl->set_file('tpl_det', 'contracte/detaliicontracte.tpl');
		#page main title
		$tpl->set_var('MAIN_TITLE', 'Detalii contract'. $param1);
		#set blocks
		$tpl->set_var('BGCOLOR1',"row1" );
		$tpl->set_var('BGCOLOR2',"row2" );
		$contract_details = GetInfoContract($param1);
		foreach($contract_details as $ky => $val)
		{
			$tpl->set_var(strtoupper($ky),$val );
		}
		$tpl->parse('MAIN', 'tpl_det');
	break;

	
}
?>