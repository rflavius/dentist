<?php
/*------------------------------------------------------------------------------------------------
	|		dotBoost Self Managed Content | SMC Users Framework | support@dotboost.com
	+---------------------------------------------------------------------------
	|		SMC Users Framework IS NOT FREE SOFTWARE!
	+---------------------------------------------------------------------------
	|		Name : admin/links.php
	|		Date started: Aug 3 2006
	|		Description : list, add, edit links
	|		Version : 0.9
	+---------------------------------------------------------------------------------------------*/
switch ($action)
{
	default :
		$tpl->set_file('tpl_links', 'links/general.tpl');
		#set colors
		$tpl->set_var('BGCOLOR1', 'row1');
		$tpl->set_var('BGCOLOR2', 'row2');
		$tpl->set_var('LINKS_PER_PAGE', $conf->links_per_page);
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
		#get info
		$get_module = GetModules(intval($action));
		$the_module = $get_module['0'];
		if (isset($_SESSION['edit_modules_content']))
		{
			$the_module = $_SESSION['edit_modules_content'];
			unset($_SESSION['edit_modules_content']);
		}
		$tpl->set_var('ID', $the_module['id']);
		$tpl->set_var('NAME', $the_module['name']);
		$tpl->set_var('KEYWORDS', $the_module['meta_keywords']);
		$tpl->set_var('DESCRIPTION', $the_module['meta_description']);
		$tpl->set_var('CONTENT', $the_module['content']);
		#page main title
		$tpl->set_var('MAIN_TITLE', 'Edit '.$the_module['name'].' module');
		$link = str_replace(".", "_", $the_module['link']);
		$tpl->set_var('LINK', $link);
		#status
		if ($the_module['active'] == '1')
		{
			$tpl->set_var('STATUS_ACTIVE', 'selected');
		}
		else 
		{
			$tpl->set_var('STATUS_INACTIVE', 'selected');
		}
		$tpl->parse('MAIN', 'tpl_links');
	break;

	case 'save':
		SaveConfig('links_per_page', intval($_POST['links_per_page']));
		$_SESSION['admin_info'] = 'Modificarile au fost realizate cu succes !';
		$_SESSION['admin_info_type'] = 'info';
		header ('location: '.$_SERVER['HTTP_REFERER']);
		exit;
	break;

	case 'list':
		$tpl->set_file('tpl_list', 'links/list.tpl');
		#set the current mod id for the rearenge option
		$tpl->set_var("CURRENT_MODULE_ID", intval($param1));
		#page main title
		$tpl->set_var('MAIN_TITLE', 'List all links');
		$tpl->set_block('tpl_list', 'list_links', 'list_links_block');
		$tpl->set_block('tpl_list', 'if_links', 'if_links_block');
		$tpl->set_block('tpl_list', 'no_links', 'no_links_block');
		$get_links = GetLinksForAdmin();
		if (count($get_links) != '0')
		{
			$i = 0;
			while (list($k, $v) = each($get_links))
			{
				#set colors
				$bc = ($i % 2)+1;
				$tpl->set_var("BGCOLOR",'row'.$bc);
				$tpl->set_var('TITLE', $v['title']);
				$tpl->set_var('ID', $v['id']);
				$tpl->set_var('LINK', $v['link']);
				$tpl->set_var('DESCRIPTION', nl2br($v['description']));
				if ($v['status'] == '1')
				{
					$tpl->set_var('IMAGE', 'active.png');
					$tpl->set_var('IMAGE_TITLE', 'inactive');
				}
				else 
				{
					$tpl->set_var('IMAGE', 'inactive.png');
					$tpl->set_var('IMAGE_TITLE', 'active');
				}
				#display the fucking blocks
				if ($param1 != "")
				{
					$tpl->parse("position_block", "position", true);
				}
				$tpl->parse('list_links_block', 'list_links', true);
				$i++;
			}
			$tpl->parse('if_links_block', 'if_links', true);
		}
		else 
		{
			$tpl->parse('no_links_block', 'no_links', true);
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

	case 'rearenge':
		#rearrange the l according to the admin's wish
		ReorderLinks(intval($param2), $param1);
		RearrangeLinks();
		$_SESSION['admin_info'] = 'Position successfully updated !';
		$_SESSION['admin_info_type'] = 'info';
		header ('location: '.$_SERVER['HTTP_REFERER']);
		exit;
	break;

	case 'set':
		$_SESSION['admin_info'] = 'Status successfully updated !';
		$_SESSION['admin_info_type'] = 'info';
		switch ($param1)
		{
			case 'active':
				$query = "UPDATE links SET status = '1' WHERE id = '".intval($param2)."'";
				$db->query($query);
				header ('location: ?page=links.list');
				exit;
			break;

			case 'inactive':
				$query = "UPDATE links SET status = '0' WHERE id = '".intval($param2)."'";
				$db->query($query);
				header ('location: ?page=links.list');
				exit;
			break;
		}
	break;

	case 'edit':
		$tpl->set_file('tpl_edit', 'links/edit.tpl');
		#set colors
		$tpl->set_var('BGCOLOR1', 'row1');
		$tpl->set_var('BGCOLOR2', 'row2');
		$link = GetLinks(intval($param1), '');
		$link = $link['0'];
		if (isset($_SESSION['edit_link_content']))
		{
			$link = $_SESSION['edit_link_content'];
			unset($_SESSION['edit_link_content']);
		}
		$tpl->set_var('TITLE', $link['title']);
		#page main title
		$tpl->set_var('MAIN_TITLE', 'Edit '.$link['title'].' link');
		$tpl->set_var('LINK', $link['link']);
		$tpl->set_var('DESCRIPTION', $link['description']);
		$tpl->set_var('ID', $link['id']);
		if ($link['status'] == '0')
		{
			$tpl->set_var('SEL_IN', 'selected');
		}
		else 
		{
			$tpl->set_var('SEL_AC', 'selected');
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
		$tpl->parse('MAIN', 'tpl_edit');
	break;

	case 'save_changes':
		#title and content
		$error = array();
		if (trim($_POST['title']) == '')
		{
			$error['0'] = 'Please provide a title for the links.';
		}
		if (!ValidateURL($_POST['link']))
		{
			$error['1'] = 'Please provide a valid url.';
		}
		if (count($error) != '0')
		{
			$display_errors = "";
			foreach ($error as $key => $val)
			{
				$display_errors .= $val."<br />";
			}
			$_SESSION['admin_info'] = $display_errors;
			$_SESSION['admin_info_type'] = 'error';
			#put info that doesn't come from the post into array
			$tempArray = array("id" => intval($param1));
			$_POST = array_merge($_POST, $tempArray);
			$_SESSION['edit_link_content'] = $_POST;
			header ('location: ?page=links.edit.'.$param1);
			exit;
		}
		$query = "UPDATE links SET title = '".addslashes($_POST['title'])."',
															 link = '".addslashes($_POST['link'])."',
															 description = '".addslashes($_POST['description'])."',
															 status = '".$_POST['status']."'
							WHERE id = '".intval($param1)."'";
		$db->query($query);
		$_SESSION['admin_info'] = 'Changes successfully updated !';
		$_SESSION['admin_info_type'] = 'info';
		header ('location: ?page=links.list');
		exit;
	break;

	case 'add':
		$tpl->set_file('tpl_add', 'links/add.tpl');
		#page main title
		$tpl->set_var('MAIN_TITLE', 'Add new link');
		#set colors
		$tpl->set_var('BGCOLOR1', 'row1');
		$tpl->set_var('BGCOLOR2', 'row2');
		#good added values in next step
		if (@$_SESSION['add_links_array']['status'] == '0')
		{
			$tpl->set_var('SEL_IN', 'selected');
		}
		else 
		{
			$tpl->set_var('SEL_AC', 'selected');
		}
		if (isset($_SESSION['add_links_array']))
		{
			foreach ($_SESSION['add_links_array'] as $key => $val)
			{
				$tpl->set_var(strtoupper($key), $val);
			}
			unset($_SESSION['add_links_array']);
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
		$tpl->parse('MAIN', 'tpl_add');
	break;

	case 'insert':
		#title and content
		$error = array();
		if (trim($_POST['title']) == '')
		{
			$error['0'] = 'Please provide a title for the links !';
		}
		if (!ValidateURL($_POST['link']))
		{
			$error['1'] = 'Please provide a valid url !';
		}
		if (count($error) != '0')
		{
			$display_errors = "";
			foreach ($error as $key => $val)
			{
				$display_errors .= $val."<br />";
			}
			$_SESSION['admin_info'] = $display_errors;
			$_SESSION['admin_info_type'] = 'error';
			$_SESSION['add_links_array'] = array("title" => ''.$_POST['title'].'',
																					"link" => ''.$_POST['link'].'',
																					"description" => ''.$_POST['description'].'',
																					"status" => ''.$_POST['status'].'');
			header ('location: ?page=links.add');
			exit;
		}
		$query = "INSERT into links (title,
																 link,
																 description,
																 position,
																 status)
													VALUES ('".addslashes($_POST['title'])."',
																	'".addslashes($_POST['link'])."',
																	'".addslashes($_POST['description'])."',
																	'5',
																	'".$_POST['status']."')";
		$db->query($query);
		#reorder news so this one goes at the top
		RearrangeLinks();
		$_SESSION['admin_info'] = 'Information successfully added !';
		$_SESSION['admin_info_type'] = 'info';
		header ('location: ?page=links.list');
		exit;
	break;
}
?>