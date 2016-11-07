<?php
/*------------------------------------------------------------------------------------------------
	|		dotBoost Self Managed Content | SMC Users Framework | support@dotboost.com
	+---------------------------------------------------------------------------
	|		SMC Users Framework IS NOT FREE SOFTWARE!
	+---------------------------------------------------------------------------
	|		Name : admin/pages.php
	|		Date started: Aug 3 2006
	|		Description : list, add, edit static pages
	|		Version : 0.9
	+---------------------------------------------------------------------------------------------*/
switch ($action)
{
	case 'list':
		$tpl->set_file('tpl_list', 'pages/list.tpl');
		#page main title
		$tpl->set_var('MAIN_TITLE', 'List all pages');
		#get and list pages
		$tpl->set_block('tpl_list', 'no_pages', 'no_pages_block');
		$tpl->set_block('tpl_list', 'list_pages', 'list_pages_block');
		#order blocks
		$tpl->set_block("tpl_list", "title_order", "title_order_block");
		$tpl->set_block("tpl_list", "link_order", "link_order_block");
		$tpl->set_block('tpl_list', 'if_pages', 'if_pages_block');
		#order variable
		$order = "";
		if (!isset($_GET['order']))
			{$order = "name"; $tpl->parse("link_order_block", "link_order", true);}
		elseif($_GET['order'] == "title")
			{$order = "name"; $tpl->parse("link_order_block", "link_order", true);}
		elseif($_GET['order'] == "link")
			{$order = "link"; $tpl->parse("title_order_block", "title_order", true);}
		$get_pages = GetPages($order);
		if (count($get_pages) != '0')
		{
			$i = 0;
			while (list($k, $v) = each($get_pages))
			{
				#set colors
				$bc = ($i % 2)+1;
				$tpl->set_var("BGCOLOR",'row'.$bc);
				$tpl->set_var('ID', $v['id']);
				$tpl->set_var('TITLE', $v['name']);
				$tpl->set_var('LINK', $v['link']);
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
				$tpl->parse('list_pages_block', 'list_pages', true);
				$i++;
			}
			$tpl->parse('if_pages_block', 'if_pages', true);
		}
		else 
		{
			$tpl->parse('no_pages_block', 'no_pages', true);
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

	case 'edit':
		$tpl->set_file('tpl_edit', 'pages/edit.tpl');
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
		#get info
		$get_page = GetSelectedPage(intval($param1));
		if (isset($_SESSION['edit_page_content']))
		{
			$get_page = $_SESSION['edit_page_content'];
			unset($_SESSION['edit_page_content']);
		}
		#parse all the variables
		$tpl->set_var('ID', $get_page['id']);
		$tpl->set_var('NAME', $get_page['name']);
		#page main title
		$tpl->set_var('MAIN_TITLE', 'Edit '.$get_page['name'].' page');
		$tpl->set_var('LINK', $get_page['link']);
		#status
		if ($get_page['active'] == '1')
		{
			$tpl->set_var('SEL_AC', 'selected');
		}
		else 
		{
			$tpl->set_var('SEL_IN', 'selected');
		}
		$tpl->set_var('META_KEYWORDS', $get_page['meta_keywords']);
		$tpl->set_var('META_DESCRIPTION', $get_page['meta_description']);
		#set variable for htmlarea
		$page_content = htmlentities($get_page['content']);
		$page_content = RestoreImagePath($page_content);
		$page_content = str_replace("{", "&#123;", $page_content);
		$page_content = str_replace("}", "&#125;", $page_content);
		$tpl->set_var('CONTENT', $page_content);
		$tpl->parse('MAIN', 'tpl_edit');
	break;

	case 'save_changes':
		#title and link
		$errors = array();
		if (trim($_POST['name']) == '')
		{
			$errors['0'] = 'Please provide a name for the page !';
		}
		if (count($errors) != '0')
		{
			$display_errors = "";
			foreach ($errors as $key => $val)
			{
				$display_errors .= $val."<br />";
			}
			$_SESSION['admin_info'] = $display_errors;
			$_SESSION['admin_info_type'] = 'error';
			#put info that doesn't come from the post into array
			$get_page = GetSelectedPage(intval($param1));
			$link = $get_page['link'];
			$tempArray = array("id" => intval($param1), "link" => $link);
			$_POST = array_merge($_POST, $tempArray);
			$_SESSION['edit_page_content'] = $_POST;
			header ('location: '.$_SERVER['HTTP_REFERER']);
			exit;
		}
		else 
		{
			UpdatePage(addslashes($_POST['name']), addslashes($_POST['meta_keywords']), addslashes($_POST['meta_description']), $_POST['active'], addslashes($_POST['content']), intval($param1));
		}
		$_SESSION['admin_info'] = 'Update succesfully made !';
		$_SESSION['admin_info_type'] = 'info';
		header ('location: ?page=pages.list');
		exit;
	break;

	case 'set':
		ChangeStatus('pages', 'active', $param1, $param2);
		$_SESSION['admin_info'] = 'Status successfully changed !';
		$_SESSION['admin_info_type'] = 'info';
		header ('location: ?page=pages.list');
		exit;
	break;

	case 'add':
		$tpl->set_file('tpl_add', 'pages/add.tpl');
		#page main title
		$tpl->set_var('MAIN_TITLE', 'Add a new page');
		$tpl->set_var('META_KEYWORDS', $conf->def_meta_keywords);
		$tpl->set_var('META_DESCRIPTION', $conf->def_meta_description);
		$tpl->set_var('BGCOLOR1', 'row1');
		$tpl->set_var('BGCOLOR2', 'row2');
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
		#status
		if (@$_SESSION['add_page_array']['status'] == '0')
		{
			$tpl->set_var('SEL_IN', 'selected');
		}
		else 
		{
			$tpl->set_var('SEL_AC', 'selected');
		}
		#good values
		if (isset($_SESSION['add_page_array']))
		{
			if (count($_SESSION['add_page_array']) != 0)
			{
				foreach ($_SESSION['add_page_array'] as $key => $val)
				{
					$tpl->set_var(strtoupper($key), $val);
				}
			}
			unset($_SESSION['add_page_array']);
		}
		$tpl->parse('MAIN', 'tpl_add');
	break;

	case 'insert':
		#title and link
		$errors = array();
		if (trim($_POST['name']) == '')
		{
			$errors['0'] = 'Please provide a name for the page !';
		}
		if (PageLinkIsInvalid($_POST['link']) === false)
		{
			$errors['1'] = 'Please provide a valid page url for this page (only alpha numeric characters, lowercase format)! You can use - as a separator.';
		}
		if (UrlExists($_POST['link']) == '1')
		{
			$errors['2'] = 'Link provided already exists !';
		}
		if (count($errors) != '0')
		{
			$display_errors = "";
			foreach ($errors as $key => $val)
			{
				$display_errors .= $val."<br />";
			}
			$_SESSION['admin_info'] = $display_errors;
			$_SESSION['admin_info_type'] = 'error';
			$_SESSION['add_page_array'] = array("name" => ''.$_POST['name'].'',
																		"link" => ''.$_POST['link'].'',
																		"meta_keywords" => ''.$_POST['meta_keywords'].'',
																		"meta_description" => ''.$_POST['meta_description'].'',
																		"content" => ''.$_POST['content'].'',
																		"status" => ''.$_POST['status'].'');
			header ('location: ?page=pages.add');
			exit;
		}
		#insert page
		$last_id = InsertPage($_POST['name'], $_POST['content'], $_POST['link'], $_POST['meta_keywords'], $_POST['meta_description'], $_POST['status']);
		$_SESSION['admin_info'] = 'Page added successfully !';
		$_SESSION['admin_info_type'] = 'info';
		header ('location: ?page=pages.list');
		exit;
	break;
}
?>