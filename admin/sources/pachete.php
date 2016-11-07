<?php 
/*
 * here we will manage the pachete module
 */

$pachete = new Pachete_Servicii($db);

switch ($action)
{
	default:
		$tpl->set_file('tpl_main', 'pachete/list.tpl');
		$tpl->set_var('MAIN_TITLE', 'View Pachete Promovare');
		$tpl->set_block('tpl_main', 'list_servicii', 'list_servicii2');
		$tpl->set_block('tpl_main', 'list_pachete', 'list_pachete2');
		$all_pk = $pachete->listPacheteBackend();
		$i=0;
		foreach($all_pk as $ky => $val)
		{
			$bc = ($i % 2)+1;
			$tpl->set_var("BGCOLOR", 'row'.$bc);
			
			$tpl->set_var('ID', $val['id']);
			$tpl->set_var('NAME', $val['name']);
			$tpl->set_var('PRET', $val['pret']);
			$tpl->set_var('LUNI', $val['luni']);
			$tpl->parse('list_servicii2', '');
			$serv = $pachete->listPachetServicii($val['id']);
			if(is_array($serv))
			{
				foreach($serv  as $ky2 => $val2)
				{
					$tpl->set_var('SERV', $val2['name']);
					$tpl->parse('list_servicii2', 'list_servicii', true);
				}
			}
			
			if ($val['active'] == 'Y')
			{
				$tpl->set_var('IMAGE', 'active.png');
				$tpl->set_var('IMAGE_TITLE', 'inactive');
			}
			else
			{
				$tpl->set_var('IMAGE', 'inactive.png');
				$tpl->set_var('IMAGE_TITLE', 'active');
			}
			$tpl->parse('list_pachete2', 'list_pachete', true);
			$i++;
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
	break;
	
	case 'set':
		switch ($param1)
		{
			case 'active':
				$status = 'Y';
			break;
		
			case 'inactive':
				$status = 'N';
			break;
		}
		$pachete->updatePachetStatus($status,$param2);
		$_SESSION['admin_info'] = "Pachet status successfully changed !";
		$_SESSION['admin_info_type'] = 'info';
		header ('location: '.$_SERVER['HTTP_REFERER']);
		exit;
	break;
	
	case 'delete':
		$pachete->removePachet($param1);
		$_SESSION['admin_info'] = "Pachet was removed from system !";
		$_SESSION['admin_info_type'] = 'info';
		header ('location: '.$_SERVER['HTTP_REFERER']);
		exit;
	break;
	
	case 'edit':
		$tpl->set_file('tpl_main', 'pachete/edit.tpl');
		$tpl->set_block('tpl_main','list_servs','list_servs2');
		$tpl->set_var('BGCOLOR1','row1');
		$tpl->set_var('BGCOLOR2','row2');
		$tpl->set_var('ID',$param1);
		$pk = $pachete->getPachetInfo($param1);
		$tpl->set_var('NAME',$pk['name']);
		$tpl->set_var('PRET',$pk['pret']);
		$serv = $pachete->listServiciiFrontend();
		foreach($serv as $ky2 => $val2)
		{
			$tpl->set_var('SERV', $val2['name']);
			$tpl->set_var('SERV_ID', $val2['id']);
			if(in_array($val2['id'],$pachete->getPachetServiciiToArray($param1)))
			{
				$tpl->set_var('CHECK','checked');
			}
			else
			{
				$tpl->set_var('CHECK','');
			}
			$tpl->parse('list_servs2', 'list_servs', true);
		}
	break;
	
	case 'save_edit':
		$pachete->updatePachet($param1);
		$_SESSION['admin_info'] = "Pachet-ul a fost modificat cu succes !";
		$_SESSION['admin_info_type'] = 'info';
		header ('location: index.php?page=pachete');
		exit;
	break;
	
	case 'add':
		$tpl->set_file('tpl_main', 'pachete/add.tpl');
		$tpl->set_block('tpl_main','list_servs','list_servs2');
		$tpl->set_var('BGCOLOR1','row1');
		$tpl->set_var('BGCOLOR2','row2');
		$serv = $pachete->listServiciiFrontend();
		foreach($serv as $ky2 => $val2)
		{
			$tpl->set_var('SERV', $val2['name']);
			$tpl->set_var('SERV_ID', $val2['id']);
			$tpl->parse('list_servs2', 'list_servs', true);
		}
	break;
	
	case 'save':
		$pachete->addPachet();
		$_SESSION['admin_info'] = "Un nou pachet a fost adaugat cu succes !";
		$_SESSION['admin_info_type'] = 'info';
		header ('location: index.php?page=pachete');
		exit;
	break;
}

$tpl->parse('MAIN', 'tpl_main');