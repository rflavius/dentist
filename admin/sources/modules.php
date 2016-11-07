<?php
/*------------------------------------------------------------------------------------------------
	|		dotBoost Self Managed Content | SMC Users Framework | support@dotboost.com
	+---------------------------------------------------------------------------
	|		SMC Users Framework IS NOT FREE SOFTWARE!
	+---------------------------------------------------------------------------
	|		Name : admin/modules.php
	|		Date started: Aug 3 2006
	|		Description : list, edit modules
	|		Version : 0.9
	+---------------------------------------------------------------------------------------------*/
switch ($action)
{
	case 'list':
		$tpl->set_file('tpl_list', 'modules/list.tpl');
		$tpl->set_block('tpl_list', 'list_modules', 'list_modules_block');
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
		#page main title
		$tpl->set_var('MAIN_TITLE', 'List all modules');
		$get_modules = GetModules('-1');
		$i = 0;
		while (list($k, $v) = each($get_modules))
		{
			#set colors
			$bc = ($i % 2)+1;
			$tpl->set_var("BGCOLOR", 'row'.$bc);
			$tpl->set_var('ID', $v['id']);
			$tpl->set_var('TITLE', $v['name']);
			$link_1 = str_replace(".", "_", $v['link']);
			$tpl->set_var('LINK', $link_1);
			$type = explode("_", $link_1);
			$tpl->set_var('TYPE', strtoupper($type[0]));
			if ($v['active'] == '1')
			{
				$tpl->set_var('IMAGE', 'active.png');
				$tpl->set_var('IMAGE_TITLE', 'inactive');
			}
			else 
			{
				$tpl->set_var('IMAGE', 'inactive.png');
				$tpl->set_var('IMAGE_TITLE', 'active');
			}
			#if the module is dynamic or static, give different links
			if ($v['type'] == 'static')
			{
				$tpl->set_var('EDIT_LINK', 'modules.edit.'.$v['id']);
			}
			else 
			{
				$tpl->set_var('EDIT_LINK', $v['link']);
			}
			#parse block
			$tpl->parse('list_modules_block', 'list_modules', true);
			$i++;
		}
		$tpl->parse('MAIN', 'tpl_list');
	break;

	case 'set':
		ChangeStatus('modules', 'active', $param1, $param2);
		$_SESSION['admin_info'] = 'Status successfully changed !';
		$_SESSION['admin_info_type'] = 'info';
		header ('location: ?page=modules.list');
		exit;
	break;

	case 'save_changes':
		#title and link
		$errors = array();
		if (trim($_POST['name']) == '')
		{
			$errors['0'] = 'Please provide a name for the module';
		}
		#Save changes
		if (count($errors) != '0')
		{
			$display_errors = "";
			foreach ($errors as $key => $val)
			{
				$display_errors .= $val."<br />";
			}
			$_SESSION['admin_info'] = $display_errors;
			$_SESSION['admin_info_type'] = 'error';
			#get the link, page_picture if there are saved
			$get_module = GetModules(intval($param1));
			$info = $get_module['0'];
			$link = $info['link'];
			#put info that doesn't come from the post into array
			$tempArray = array("id" => intval($param1), "link" => $link);
			$_POST = array_merge($_POST, $tempArray);
			$_SESSION['edit_modules_content'] = $_POST;
			header ('location: '.$_SERVER['HTTP_REFERER']);
			exit;
		}
		else 
		{
			SaveModuleChanges(addslashes($_POST['name']), $_POST['active'], addslashes($_POST['meta_keywords']), addslashes($_POST['meta_description']), addslashes($_POST['content']), intval($param1));
		}
		$_SESSION['admin_info'] = 'Update succesfully made !';
		$_SESSION['admin_info_type'] = 'info';
		header ('location: '.$_SERVER['HTTP_REFERER']);
		exit;
	break;

	case 'clone':
		$tpl->set_file('tpl_clone', 'modules/clone.tpl');
/*page main title*/
			$tpl->set_var('MAIN_TITLE', 'Clone a module');
/*blocks*/
			$tpl->set_block('tpl_clone', 'available_clones', 'available_clones_block');
			$tpl->set_block('tpl_clone', 'if_not_imported', 'if_not_imported_block');
			$tpl->set_block('tpl_clone', 'errors', 'errors_block');
			$tpl->set_block('tpl_clone', 'if_errors', 'if_errors_block');
			$tpl->set_block('tpl_clone', 'if_imported', 'if_imported_block');
/*set 2 variables*/
			$tpl->set_var('SYMBOL_MAX_WIDTH', $conf->symbol_max_width);
			$tpl->set_var('SYMBOL_MAX_HEIGHT', $conf->symbol_max_height);
/*set colors*/
			$tpl->set_var('BGCOLOR1', 'row1');
			$tpl->set_var('BGCOLOR2', 'row2');
			if (!isset($_POST['clone_module']) && !isset($_SESSION['import_module']))//first step = select the module to import
			{
				$get_available_modules = GetAvailableCloneModules('-1');
				if (count($get_available_modules) != '0')
				{
					while (list($k, $v) = each($get_available_modules))
					{
						$tpl->set_var('CLONE_ID', $v['id']);
						$tpl->set_var('CLONE_NAME', $v['module_title']);
						$tpl->parse('available_clones_block', 'available_clones', true);
					}
				}
				$tpl->parse('if_not_imported_block', 'if_not_imported', true);
			}
			else //second step = save the imported module
			{
				$tpl->set_var('PICTURE_MAX_WIDTH', $conf->symbol_max_width);
				$tpl->set_var('PICTURE_MAX_HEIGHT', $conf->symbol_max_height);
				$tpl->set_var('KEYWORDS', $conf->def_meta_keywords);
				$tpl->set_var('DESCRIPTION', $conf->def_meta_description);
				if (isset($_POST['clone_module']))
				{
					$get_module = GetAvailableCloneModules($_POST['clone_module']);
				}
				else 
				{
					$get_module = GetAvailableCloneModules($_SESSION['clone_id']);
					unset($_SESSION['clone_id']);
				}
				$get_module = $get_module['0'];
				$tpl->set_var('MODULE_NAME', $get_module['module_title']);
/*page main title*/
				$tpl->set_var('MAIN_TITLE', 'Clone '.$get_module['module_title'].' module');
				$tpl->set_var('CLONE_ID', $get_module['id']);
				if (isset($_SESSION['import_module']))
				{
					foreach ($_SESSION['import_module'] as $key => $val)
					{
						$tpl->set_var('ERROR', $val);
						$tpl->parse('errors_block', 'errors', true);
					}
					unset($_SESSION['import_module']);
					$tpl->parse('if_errors_block', 'if_errors', true);
				}
				$tpl->parse('if_imported_block', 'if_imported', true);
			}
		$tpl->parse('MAIN', 'tpl_clone');
	break;

	case 'save_clone':
/*verify title*/
		$error = array();
		if (trim($_POST['name']) == '')
		{
			$error['0'] = 'Please provide a name for the module';
		}
		if ($_FILES['graphic_symbol']['type'] != "")
		{
			$result = CheckGraphicSymbol();
			if ($result == '0')
			{
				$error['1'] = 'The graphic symbol you have provided is not a valid image';
			}
			elseif ($result == '1')
			{
				$error['1'] = 'Please respect the maximum photo width and height';
			}
		}
		if ($_FILES['page_picture']['type'] != "")
		{
			$result = CheckPagePicture();
			if ($result == '0')
			{
				$error['2'] = 'The picture you have provided is not a valid image';
			}
			elseif ($result == '1')
			{
				$error['2'] = 'Please respect the maximum pictute width and height';
			}
		}
		if (count($error) != '0')
		{
			$_SESSION['import_module'] = $error;
			$_SESSION['clone_id'] = intval($param1);
			header ('location: ?page=modules.clone');
			exit;
		}
		CloneModule($_POST, intval($param1));
		header ('location: ?page=modules.list');
		exit;
	break;
}

?>