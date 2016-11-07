<?php

switch ($action)
{
	default :
		$tpl->set_file('tpl_news', 'news/general.tpl');
		#set colors
		$tpl->set_var('BGCOLOR1', 'row1');
		$tpl->set_var('BGCOLOR2', 'row2');
		$tpl->set_var('MAX_NEWS', $conf->max_news_list);
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
		if ($action == ""){$get_id = GetModuleID($module);}
		elseif (!is_numeric($action)){$get_id = GetModuleID($module.'.'.$action);}
		else {$get_id = $action;}
		#get info
		$get_module = GetModules(intval($get_id));
		$the_module = $get_module['0'];
		if (isset($_SESSION['edit_modules_content']))
		{
			$the_module = $_SESSION['edit_modules_content'];
			unset($_SESSION['edit_modules_content']);
		}
		#parse all the variables
		$tpl->set_var('MOD_ID', $the_module['id']);
		$tpl->set_var('NAME', $the_module['name']);
		$tpl->set_var('KEYWORDS', $the_module['meta_keywords']);
		$tpl->set_var('DESCRIPTION', $the_module['meta_description']);
		$tpl->set_var('CONTENT', $the_module['content']);
		#page main title
		$tpl->set_var('MAIN_TITLE', 'Edit '.$the_module['name'].' module');
		$tpl->set_var('LINK', $the_module['link']);
		#status
		if ($the_module['active'] == '1')
		{
			$tpl->set_var('STATUS_ACTIVE', 'selected');
		}
		else 
		{
			$tpl->set_var('STATUS_INACTIVE', 'selected');
		}
		$tpl->parse('MAIN', 'tpl_news');
	break;

	case 'save':
		SaveConfig('max_news_list', intval($_POST['max_news']));
		$_SESSION['admin_info'] = 'Modificarile au fost realizate cu succes !';
		$_SESSION['admin_info_type'] = 'info';
		header ('location: ?page=news');
		exit;
	break;

	case 'list':
		$tpl->set_file('tpl_list', 'news/list.tpl');
		#page main title
		$tpl->set_var('MAIN_TITLE', 'List all news');
		$tpl->set_block('tpl_list', 'list_news', 'list_news_block');
		$tpl->set_block('tpl_list', 'if_news', 'if_news_block');
		$tpl->set_block('tpl_list', 'no_news', 'no_news_block');
		$get_news = GetNews('-1', '0');
		if (count($get_news) != '0')
		{
			$i = 0;
			while (list($k, $v) = each($get_news))
			{
				#set colors
				$bc = ($i % 2)+1;
				$tpl->set_var("BGCOLOR",'row'.$bc);
				$tpl->set_var('TITLE', $v['title']);
				$tpl->set_var('ID', $v['id']);
				$tpl->set_var('UPDATED_DATE', TimeFormatShort($v['submision_date']));
				$tpl->set_var('EVENT_DATE',$v['event_date'] );
				$tpl->set_var('NEWS_LINK_FRONTEND',ReWrite('news', 'news.detalii.'.$v['id']) );
				
				
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
				$tpl->parse('list_news_block', 'list_news', true);
				$i++;
			}
			$tpl->parse('if_news_block', 'if_news', true);
		}
		else 
		{
			$tpl->parse('no_news_block', 'no_news', true);
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
		$_SESSION['admin_info'] = 'Position successfully saved !';
		$_SESSION['admin_info_type'] = 'info';
		#rearrange the news according to the admin's wish
		switch ($param1)
		{
			case 'up':
				ReorderNews($param2, $param1);
				RearrangeNews();
				header ('location: ?page=news.list');
				exit;
			break;

			case 'down':
				ReorderNews($param2, $param1);
				RearrangeNews();
				header ('location: ?page=news.list');
				exit;
			break;
		}
	break;


	case 'set':
		$_SESSION['admin_info'] = 'Status successfully saved !';
		$_SESSION['admin_info_type'] = 'info';
		switch ($param1)
		{
			case 'active':
				$query = "UPDATE news SET status = '1' WHERE id = '".intval($param2)."'";
				$db->query($query);
				header ('location: ?page=news.list');
				exit;
			break;

			case 'inactive':
				$query = "UPDATE news SET status = '0' WHERE id = '".intval($param2)."'";
				$db->query($query);
				header ('location: ?page=news.list');
				exit;
			break;
		}
	break;

	case 'edit':
		$tpl->set_file('tpl_edit', 'news/edit.tpl');
		$tpl->set_var('BGCOLOR1', 'row1');
		$tpl->set_var('BGCOLOR2', 'row2');
		$news = GetNews(intval($param1), '');
		$news = $news['0'];
		if (isset($_SESSION['edit_news_content']))
		{
			$news = $_SESSION['edit_news_content'];
			unset($_SESSION['edit_news_content']);
		}
		$tpl->set_var('TITLE', $news['title']);
		#page main title
		$tpl->set_var('MAIN_TITLE', 'Edit '.$news['title'].' news');
		$tpl->set_var('ID', $news['id']);
		$tpl->set_var('CONTENT', $news['content']);
		$tpl->set_var('PLACE', $news['location']);
		$tpl->set_var('EVENT_DATE',$news['event_date2']);
		$tpl->set_var('META_KEYWORDS', $news['meta_keywords']);
		$tpl->set_var('META_DESCRIPTION', $news['meta_description']);
				$tpl->set_var('THUMBNAIL', "../sources/thumbnails.php?target=".$news['imagine'].'&max_size='.$conf->admin_gallery_max.'&news=yes');
		if ($news['status'] == '0')
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
			$error['0'] = 'Please provide a title for the news.';
		}
		if (trim($_POST['content']) == '')
		{
			$error['1'] = 'Please provide content for the news.';
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
			$_SESSION['edit_news_content'] = $_POST;
			header ('location: ?page=news.edit.'.$param1);
			exit;
		}
		$query = "UPDATE news SET title = '".addslashes($_POST['title'])."', content = '".addslashes($_POST['content'])."',meta_keywords = '".addslashes($_POST['meta_keywords'])."', meta_description = '".addslashes($_POST['meta_description'])."', status = '".$_POST['status']."',event_date='".$_POST['event_date']."',place='".ucfirst($_POST['place'])."' WHERE id = '".intval($param1)."'";
		$db->query($query);

		$update_alias_name = GenerateAlias($_POST['title']);
		$query="Update news set alias='".addslashes($update_alias_name)."' WHERE id='".$param1."'";
		$db->query($query);

		#daca avem setata poza pt anunt o salvam
		if ($_FILES['imagine']['type'] != "" )
		{
			$extension = explode('/',$_FILES['imagine']['type']);
			$file_extension = $extension[1];//echo "extenis:".$file_extension;
			SavePicturesNews($file_extension, $param1,"backend" );
		}

		$_SESSION['admin_info'] = 'Changes successfully updated !';
		$_SESSION['admin_info_type'] = 'info';
		header ('location: ?page=news.list');
		exit;
	break;

	case 'add':
		$tpl->set_file('tpl_add', 'news/add.tpl');
		$tpl->set_var('BGCOLOR1', 'row1');
		$tpl->set_var('BGCOLOR2', 'row2');
		#page main title
		$tpl->set_var('MAIN_TITLE', 'Add news');
		#poast values
		if (@$_SESSION['add_news_array']['status'] == '0')
		{
			$tpl->set_var('SEL_IN', 'selected');
		}
		else 
		{
			$tpl->set_var('SEL_AC', 'selected');
		}
		if (isset($_SESSION['add_news_array']))
		{
			foreach ($_SESSION['add_news_array'] as $key => $val)
			{
				$tpl->set_var(strtoupper($key), $val);
			}
			unset($_SESSION['add_news_array']);
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
			$error['0'] = 'Please provide a title for the new concurs,event,conferinta.';
		}
		if (trim($_POST['content']) == '')
		{
			$error['1'] = 'Please provide content for the new concurs,event,conferinta.';
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
			$_SESSION['add_news_array'] = array("title" => ''.$_POST['title'].'',
																					"content" => ''.$_POST['content'].'',
															"meta_keywords" => ''.$_POST['meta_keywords'].'',
															"meta_description" => ''.$_POST['meta_description'].'',
																					
																					"status" => ''.$_POST['status'].'');
			header ('location: ?page=news.add');
			exit;
		}
		$query = "INSERT into news (title,
									content,
									submision_date,
									meta_keywords,
									meta_description,
									position,
									event_date,
									place,
									status)
						VALUES ('".addslashes($_POST['title'])."',
								'".addslashes($_POST['content'])."',
									now(),
								'".addslashes($_POST['meta_keywords'])."',
								'".addslashes($_POST['meta_description'])."',
								'5',
								'".$_POST['event_date']."',
								'".$_POST['place']."',
								'".$_POST['status']."')";
		$db->query($query);
		$id_anunt = $db->last_insert_id();
		#reorder news so this one goes at the top
		RearrangeNews ();

		#daca avem setata poza pt cabinet o salvam
		if ($_FILES['imagine']['type'] != "" )
		{
			$extension = explode('/',$_FILES['imagine']['type']);
			$file_extension = $extension[1];
			SavePicturesAnunturi($file_extension, $id_anunt,"backend" );
		}
		else
		{
			SavePicturesAnunturi("default", $id_anunt,"backend" );
		}
		$_SESSION['admin_info'] = 'News successfully added !';
		$_SESSION['admin_info_type'] = 'info';
		header ('location: ?page=news.list');
		exit;
	break;
}
?>