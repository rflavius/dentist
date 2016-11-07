<?php 
/**
 * here we keep all the work for the servicii object
 * @version    $Id$
 */
$pachete = new Pachete_Servicii($db);

switch ($action)
{
	default:
		$tpl->set_file('tpl_main', 'servicii/list.tpl');
		$tpl->set_block('tpl_main','list_servicii','list_servicii2');
		$servs = $pachete->listServiciiBackend();
		$i=0;
		foreach($servs as $ky=>$val)
		{
			$bc = ($i % 2)+1;
			$tpl->set_var("BGCOLOR", 'row'.$bc);
			
			$tpl->set_var('ID',$val['id']);
			$tpl->set_var('NAME',$val['name']);
			$tpl->set_var('DESCRIPTION',$val['description']);
			$tpl->set_var('PRICE',$val['price']);
			$tpl->set_var('VALUE',$val['value']);
			
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
			$tpl->parse('list_servicii2', 'list_servicii', true);
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
		$pachete->updateServiciuStatus($status,$param2);
		$_SESSION['admin_info'] = "Serviciu status successfully changed !";
		$_SESSION['admin_info_type'] = 'info';
		header ('location: '.$_SERVER['HTTP_REFERER']);
		exit;
	break;
	
	case 'delete':
		$pachete->removeServiciu($param1);
		$_SESSION['admin_info'] = "Serviciul was removed from system !";
		$_SESSION['admin_info_type'] = 'info';
		header ('location: '.$_SERVER['HTTP_REFERER']);
		exit;
	break;
	
	case 'edit':
		$tpl->set_file('tpl_main', 'servicii/edit.tpl');
		$tpl->set_var('BGCOLOR1','row1');
		$tpl->set_var('BGCOLOR2','row2');
		$tpl->set_var('ID',$param1);
		$pk = $pachete->getServiciuInfo($param1);
		$tpl->set_var('NAME',$pk['name']);
		$tpl->set_var('PRET',$pk['price']);
		$tpl->set_var('DESCRIPTION',$pk['description']);
		$tpl->set_var('VALUE',$pk['value']);
	break;
	
	case 'save_edit':
		$pachete->updateServiciu($param1);
		$_SESSION['admin_info'] = "Serviciul a fost modificat cu succes !";
		$_SESSION['admin_info_type'] = 'info';
		header ('location: index.php?page=servicii');
		exit;
	break;
	
	case 'add':
		$tpl->set_file('tpl_main', 'servicii/add.tpl');
		$tpl->set_var('BGCOLOR1','row1');
		$tpl->set_var('BGCOLOR2','row2');
	break;
	
	case 'save':
		$pachete->addServiciu();
		$_SESSION['admin_info'] = "Un nou serviciu a fost adaugat cu succes !";
		$_SESSION['admin_info_type'] = 'info';
		header ('location: index.php?page=servicii');
		exit;
	break;
	
}
$tpl->parse('MAIN', 'tpl_main');