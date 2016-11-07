<?php
/*------------------------------------------------------------------------------------------------
	|		dotBoost Self Managed Content | SMC Users Framework | support@dotboost.com
	+---------------------------------------------------------------------------
	|		SMC Users Framework IS NOT FREE SOFTWARE!
	+---------------------------------------------------------------------------
	|		Name : admin/menus.php
	|		Date started: Aug 3 2006
	|		Description : list, edit menus
	|		Version : 0.9
	+---------------------------------------------------------------------------------------------*/
switch ($action)
{
	default :
		$tpl->set_file('tpl_select_menu', 'menus/list.tpl');
		#page main title
		$tpl->set_var('MAIN_TITLE', 'Manage menus');
		#set block
		$tpl->set_block('tpl_select_menu', 'items', 'items_block');
		$tpl->set_block('tpl_select_menu', 'if_menus', 'if_menus_block');
		$tpl->set_block('tpl_select_menu', 'if_no_menus', 'if_no_menus_block');
		#get and display menus
		$get_menus = GetCurrentMenus('-1');
		if (count($get_menus) != '0')
		{
			$i = 0;
			while (list($k, $v) = each($get_menus))
			{
				#set colors
				$bc = ($i % 2)+1;
				$tpl->set_var("BGCOLOR",'row'.$bc);
				$tpl->set_var('ID', $v['id']);
				$tpl->set_var('MENU_NAME', $v['name']);
				#if top submenu go somewhere else
				if ($v['id'] != '2')
				{
					$tpl->set_var('EDIT_PATH', 'manage.'.$v['id']);
				}
				else 
				{
					$tpl->set_var('EDIT_PATH', 'submenu');
				}
				$tpl->parse('items_block', 'items', true);
				$tpl->parse('if_not_submenu_block', '');
				$i++;
			}
			$tpl->parse('if_menus_block', 'if_menus', true);
		}
		else 
		{
			$tpl->parse('if_no_menus_block', 'if_no_menus', true);
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
		$tpl->parse('MAIN', 'tpl_select_menu');
	break;

	case 'manage':
		$tpl->set_file('tpl_manage', 'menus/manage.tpl');
		$tpl->set_var('PARENT_ID', intval($param1));
		$menu_name = GetMenuName(intval($param1));
		$tpl->set_var('THE_MENU_NAME', $menu_name);
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
		$tpl->set_var('MAIN_TITLE', 'Manage '.$menu_name);
		$tpl->set_block('tpl_manage', 'items', 'items_block');
		$tpl->set_block('tpl_manage', 'if_items', 'if_items_block');
		$tpl->set_block('tpl_manage', 'if_no_items', 'if_no_items_block');
		$get_items = GetItems(intval($param1));
		#retain the links so the user cannot add the same page twice in a menu
		$get_the_links = array();
		if (count($get_items) != '0')
		{
			$i = 0;
			while (list($k, $v) = each($get_items))
			{
				#set colors
				$bc = ($i % 2)+1;
				$tpl->set_var("BGCOLOR",'row'.$bc);
				$tpl->set_var("ID", $v['id']);
				$tpl->set_var("NAME", $v['name']);
				$get_the_links[$i] = $v['link'];
				$link = $v['link'];
				if ($v['type'] != "external")
				{
					$link = str_replace(".", "_", $v['link']);
					$link .= FILE_EXTENSION;
				}
				$tpl->set_var('LINK', $link);
				$tpl->parse('items_block', 'items', true);
				$i++;
			}
			$tpl->parse('if_items_block', 'if_items', true);
		}
		else 
		{
			$tpl->parse('if_no_items_block', 'if_no_items', true);
		}
		#start the displaing of the modules, using a function that provides only the items not used yet
		$tpl->set_block('tpl_manage', 'modules', 'modules_block');
		$tpl->set_block('tpl_manage', 'if_modules', 'if_modules_block');
		$tpl->set_block('tpl_manage', 'no_modules', 'no_modules_block');
		$get_available_menus = GetModulesForMenu($get_the_links);
		if (count($get_available_menus) != '0')
		{
			$i = 0;
			while (list($k, $v) = each($get_available_menus))
			{
				#set colors
				$bc = ($i % 2)+1;
				$tpl->set_var("BGCOLOR",'row'.$bc);
				$tpl->set_var('MODULE_ID', $v['id']);
				$tpl->set_var('MODULE_NAME', $v['name']);
				$link = str_replace(".", "_", $v['link']);
				$tpl->set_var('MODULE_LINK', $link);
				$i++;
				$tpl->parse('modules_block', 'modules', true);
			}
			$tpl->parse('if_modules_block', 'if_modules', true);
		}
		else 
		{
			$tpl->parse('no_modules_block', 'no_modules', true);
		}
		#start the displaing of the pages, using a function that provides only the items not used yet
		$tpl->set_block('tpl_manage', 'pages', 'pages_block');
		$tpl->set_block('tpl_manage', 'if_pages', 'if_pages_block');
		$tpl->set_block('tpl_manage', 'no_pages', 'no_pages_block');
		$get_available_pages = GetPagesForMenu($get_the_links);
		if (count($get_available_pages) != '0')
		{
			$i = 0;
			while (list($k, $v) = each($get_available_pages))
			{
				#set colors
				$bc = ($i % 2)+1;
				$tpl->set_var("BGCOLOR",'row'.$bc);
				$tpl->set_var('PAGE_ID', $v['id']);
				$tpl->set_var('PAGE_NAME', $v['name']);
				$link = str_replace(".", "_", $v['link']);
				$tpl->set_var('PAGE_LINK', $link);
				$i++;
				$tpl->parse('pages_block', 'pages', true);
			}
			$tpl->parse('if_pages_block', 'if_pages', true);
		}
		else 
		{
			$tpl->parse('no_pages_block', 'no_pages', true);
		}
		#display added info
		if (isset($_SESSION['static_link_array']))
		{
			foreach ($_SESSION['static_link_array'] as $key => $val)
			{
				if ($key == "target")
				{
					if ($val == "_blank"){$tpl->set_var('BLANK_SEL', 'selected');}
					else {$tpl->set_var('SELF_SEL', 'selected');}
				}
				$tpl->set_var(strtoupper($key), $val);
			}
			unset($_SESSION['static_link_array']);
		}
		$tpl->parse('MAIN', 'tpl_manage');
	break;

	case 'rearenge':
		$_SESSION['admin_info'] = 'Item position successfully updated !';
		$_SESSION['admin_info_type'] = 'info';
		ReorderMenus($param3, $param1);
		RearrangeMenus($param2);
		header ('location: '.$_SERVER['HTTP_REFERER']);
		exit;
	break;

	case 'delete_items':
		$_SESSION['admin_info'] = 'Item successfully deleted !';
		$_SESSION['admin_info_type'] = 'info';
		DeleteMenuItem(intval($param1));
		header ('location: '.$_SERVER['HTTP_REFERER']);
		exit;
	break;

	case 'add_module':
		$_SESSION['admin_info'] = 'Module successfully added to menu !';
		$_SESSION['admin_info_type'] = 'info';
		AddModuleToMenu(intval($param1), intval($param2));
		header ('location: '.$_SERVER['HTTP_REFERER']);
		exit;
	break;

	case 'add_page':
		$_SESSION['admin_info'] = 'Page successfully added to menu !';
		$_SESSION['admin_info_type'] = 'info';
		AddPageToMenu(intval($param1), intval($param2));
		header ('location: '.$_SERVER['HTTP_REFERER']);
		exit;
	break;

	case 'submenu':
		switch ($param1)
		{
			default :
				#select the item for which to create the submenu
				$tpl->set_file('tpl_submenu', 'menus/submenu.tpl');
				#page main title
				$tpl->set_var('MAIN_TITLE', 'Manage Top Submenu');
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
				#set colors
				$tpl->set_var('BGCOLOR1', 'row1');
				$tpl->set_var('BGCOLOR2', 'row2');
				#blocks
				$tpl->set_block('tpl_submenu', 'modules', 'modules_block');
				$tpl->set_block('tpl_submenu', 'pages', 'pages_block');
				$modules = GetModules('-1');
				if (count($modules) != '0')
				{
					while (list($k,$v) = each($modules))
					{
						$tpl->set_var('MODULE_ID', $v['id']);
						$tpl->set_var('MODULE_NAME', $v['name']);
						$tpl->parse('modules_block', 'modules', true);
					}
				}
				$pages = GetPages('');
				if (count($pages) != '0')
				{
					while (list($k, $v) = each($pages))
					{
						$tpl->set_var('PAGE_ID', $v['id']);
						$tpl->set_var('PAGE_NAME', $v['name']);
						$tpl->parse('pages_block', 'pages', true);
					}
				}
				$tpl->parse('MAIN', 'tpl_submenu');
			break;

			case 'edit':
				#if there is nothing selected
				if (isset($_POST['item']))
				{
					$_SESSION['item'] = $_POST['item'];
				}
				if ($_SESSION['item'] == '0')
				{
					$_SESSION['admin_info'] = 'Please select an item !';
					$_SESSION['admin_info_type'] = 'warning';
					header ('location: '.$_SERVER['HTTP_REFERER']);
					exit;
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
				#set the parent id
				$tpl->set_var('PARENT_ID', $_SESSION['item']);
				$tpl->set_file('tpl_edit', 'menus/edit_submenu.tpl');
				$name_n_link = GetParentNameAndLink($_SESSION['item']);
				$exclude_items['0'] = $name_n_link['link'];
				$tpl->set_var('PARENT_NAME', $name_n_link['name']);
				#page main title
				$tpl->set_var('MAIN_TITLE', 'Manage Top Submenu items for '.$name_n_link['name']);
				#set blocks
				$tpl->set_block('tpl_edit', 'items', 'items_block');
				$tpl->set_block('tpl_edit', 'if_items', 'if_items_block');
				$tpl->set_block('tpl_edit', 'no_items', 'no_items_block');
				#Get the current items for this parent $_POST['item']
				$get_items = GetItemsForParent($_SESSION['item']);
				if (count($get_items) != '0')
				{
					$i = 0;
					while (list($k, $v) = each($get_items))
					{
						#set colors
						$bc = ($i % 2)+1;
						$tpl->set_var("BGCOLOR",'row'.$bc);
						$tpl->set_var("ID", $v['id']);
						$tpl->set_var("NAME", $v['name']);
						$get_the_links[$i] = $v['link'];
						$link = $v['link'];
						if ($v['type'] != "external")
						{
							$link = str_replace(".", "_", $v['link']);
							$link .= FILE_EXTENSION;
						}
						$tpl->set_var('LINK', $link);
						$i++;
						#leave this array here because the 0 hkey is at top
						$exclude_items[$i] = $v['link'];
						$tpl->parse('items_block', 'items', true);
					}
					$tpl->parse('if_items_block', 'if_items', true);
				}
				else 
				{
					$tpl->parse('no_items_block', 'no_items', true);
				}
				#create here the modules and pages that the admin can use
				$tpl->set_block('tpl_edit', 'modules', 'modules_block');
				$tpl->set_block('tpl_edit', 'if_modules', 'if_modules_block');
				$modules = GetModulesForMenu($exclude_items);
				if (count($modules) != '0')
				{
					$i = 0;
					while (list($k, $v) = each($modules))
					{
						#set colors
						$bc = ($i % 2)+1;
						$tpl->set_var("BGCOLOR",'row'.$bc);
						$tpl->set_var('MODULE_ID', $v['id']);
						$tpl->set_var('MODULE_NAME', $v['name']);
						$link = str_replace(".", "_", $v['link']);
						$tpl->set_var('MODULE_LINK', $link);
						$i++;
						$tpl->parse('modules_block', 'modules', true);
					}
					$tpl->parse('if_modules_block', 'if_modules', true);
				}
				$tpl->set_block('tpl_edit', 'pages', 'pages_block');
				$tpl->set_block('tpl_edit', 'if_pages', 'if_pages_block');
				$pages = GetPagesForMenu($exclude_items);
				if (count($pages) != '0')
				{
					while (list($k, $v) = each($pages))
					{
						#set colors
						$bc = ($i % 2)+1;
						$tpl->set_var("BGCOLOR",'row'.$bc);
						$tpl->set_var('PAGE_ID', $v['id']);
						$tpl->set_var('PAGE_NAME', $v['name']);
						$link = str_replace(".", "_", $v['link']);
						$tpl->set_var('PAGE_LINK', $link);
						$i++;
						$tpl->parse('pages_block', 'pages', true);
					}
					$tpl->parse('if_pages_block', 'if_pages', true);
				}
				#display added info
				if (isset($_SESSION['static_link_array']))
				{
					foreach ($_SESSION['static_link_array'] as $key => $val)
					{
						if ($key == "target")
						{
							if ($val == "_blank"){$tpl->set_var('BLANK_SEL', 'selected');}
							else {$tpl->set_var('SELF_SEL', 'selected');}
						}
						$tpl->set_var(strtoupper($key), $val);
					}
					unset($_SESSION['static_link_array']);
				}
				$tpl->parse('MAIN', 'tpl_edit');
			break;

			case 'add_module':
				$_SESSION['admin_info'] = 'Module successfully added to menu !';
				$_SESSION['admin_info_type'] = 'info';
				AddModuleChild($param2, $param3);
				header ('location: '.$_SERVER['HTTP_REFERER']);
				exit;
			break;

			case 'add_page':
				$_SESSION['admin_info'] = 'Page successfully added to menu !';
				$_SESSION['admin_info_type'] = 'info';
				AddPageChild($param2, $param3);
				header ('location: '.$_SERVER['HTTP_REFERER']);
				exit;
			break;

			case 'delete':
				$_SESSION['admin_info'] = 'Item successfully deleted !';
				$_SESSION['admin_info_type'] = 'info';
				DeleteSubmenuItem(intval($param2));
				header ('location: '.$_SERVER['HTTP_REFERER']);
				exit;
			break;

			case 'rearenge':
				$_SESSION['admin_info'] = 'Item position successfully updated !';
				$_SESSION['admin_info_type'] = 'info';
				ReorderSubMenuItems($param4, $param2);
				$link = GetParentNameAndLink($param3);
				RearrangeSubMenuItems($link['link']);
				header ('location: '.$_SERVER['HTTP_REFERER']);
				exit;
			break;
		}
	break;

	case 'add_static':
		#check for errors
		$errors = array();
		if (trim($_POST['title']) == "")
		{
			$errors[] = "Please provide the item title !";
		}
		if (trim($_POST['url']) == "")
		{
			$errors[] = "Please provide the item url !";
		}
		if (count($errors) != "")
		{
			$display_errors = "";
			foreach ($errors as $key => $val)
			{
				$display_errors .= $val."<br />";
			}
			$_SESSION['admin_info'] = $display_errors;
			$_SESSION['admin_info_type'] = 'error';
			$_SESSION['static_link_array'] = array('title' => ''.$_POST['title'].'',
																						 'url' => ''.$_POST['url'].'',
																						 'target' => ''.$_POST['target'].'',);
			header ('location: '.GetReferer());
			exit;
		}
		#this is for the submenu section
		$parent_link = 0;
		if (trim($param2) != "")
		{
			$page_type = explode("_", $param2);
			switch ($page_type['0'])
			{
				case 'page':
					$query = "SELECT link FROM pages WHERE id = '".$page_type['1']."'";
				break;

				case 'module':
					$query = "SELECT link FROM modules WHERE id = '".$page_type['1']."'";
				break;
			}
			$db->query($query);
			$db->next_record();
			$parent_link = $db->f('link');
		}
		#add to database
		AddMenuStaticLink($_POST['title'], $_POST['url'], $_POST['target'], $param1, $parent_link);
		$_SESSION['admin_info'] = 'Page successfully added to menu !';
		$_SESSION['admin_info_type'] = 'info';
		header ('location: '.GetReferer());
		exit;
	break;
}
?>