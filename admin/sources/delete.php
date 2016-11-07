<?php

if ($param2 != 'confirm')
{
	$tpl->set_var('THE_ACTION', $action);
	$tpl->set_var('THE_PARAM', $param1);
	$tpl->set_file("tpl_main", "delete.tpl");
	switch ($action)
	{
		case 'modules':
			$module_name = GetModuleName(intval($param1));
			$tpl->set_var('DELWHO', $module_name.' module');
			$tpl->set_var('MAIN_TITLE', 'Delete '.$module_name.' module');
		break;

		case 'pages':
			$this_page_name = GetSelectedPage(intval($param1));
			$tpl->set_var('DELWHO', $this_page_name['name'].' page');
			$tpl->set_var('MAIN_TITLE', 'Delete '.$this_page_name['name'].' page');
		break;

		case 'menus':
			$menu_name = GetMenuName(intval($param1));
			$tpl->set_var('DELWHO', $menu_name);
			$tpl->set_var('MAIN_TITLE', 'Delete '.$menu_name);
		break;

		case 'cabinete':
			$get_cabinet = GetSelectedCabinet(intval($param1));
			$tpl->set_var('DELWHO', $get_cabinet['nume_firma'].' cabinet');
			$tpl->set_var('MAIN_TITLE', 'Delete '.$get_cabinet['nume_firma'].' cabinet');
		break;
		
		case 'dictionar_medical':
			$get_term = GetSelectedTerm(intval($param1));
			$tpl->set_var('DELWHO', $get_term['titlu'].' medical term');
			$tpl->set_var('MAIN_TITLE', 'Delete '.$get_term['titlu'].' term from dictionary?');
		break;
		
		case 'anunturi':
			$get_cabinet = GetAnunturi('-1',intval($param1));
			$tpl->set_var('DELWHO', $get_cabinet[0]['titlu'].' anunt');
			$tpl->set_var('MAIN_TITLE', 'Delete '.$get_cabinet[0]['titlu'].' anunt');
		break;


		
		case 'articles':
			$get_cabinet = GetSelectedArticle(intval($param1));
			$tpl->set_var('DELWHO', $get_cabinet['titlu'].' articol');
			$tpl->set_var('MAIN_TITLE', 'Delete '.$get_cabinet['titlu'].' articol');
		break;

		case 'news':
			$news = GetNews(intval($param1), '');
			$news = $news['0'];
			$tpl->set_var('DELWHO', $news['title']);
			$tpl->set_var('MAIN_TITLE', 'Delete '.$news['title'].' news');
		break;

		case 'links':
			$link = GetLinks(intval($param1), '');
			$link = $link['0'];
			$tpl->set_var('DELWHO', $link['title'].' link');
			$tpl->set_var('MAIN_TITLE', 'Delete '.$link['title'].' link');
		break;

		case 'admin':
			$admin_username = GetSelectedAdmin(intval($param1));
			$tpl->set_var('DELWHO', $admin_username['user']."'s admin account");
			$tpl->set_var('MAIN_TITLE', "Delete ".$admin_username['user']."'s admin account");
		break;

		case 'contact':
			$message = ContactUsMessages(intval($param1), '');
			$tpl->set_var('DELWHO', $message['1']."'s email");
			$tpl->set_var('MAIN_TITLE', "Delete ".$message['1']."'s email");
		break;

		case 'user':
			$get_item = GetUser(intval($param1));
			$tpl->set_var('DELWHO', "Delete ".$get_item."'s account");
			$tpl->set_var('MAIN_TITLE', "Delete ".$get_item."'s account");
		break;
		
		case 'bots':
			$get_item = $param1;
			$tpl->set_var('DELWHO', "Delete ".$get_item." bot ");
			$tpl->set_var('MAIN_TITLE', "Delete ".$get_item." bot ");
		break;
		
		case 'facturafiscala':
			$get_item = $param1;
			$tpl->set_var('DELWHO', "Delete ".$get_item." factura fiscala ");
			$tpl->set_var('MAIN_TITLE', "Delete ".$get_item." factura fiscala ");
		break;
		case 'facturaproforma':
			$get_item = $param1;
			$tpl->set_var('DELWHO', "Delete ".$get_item." factura proforma ");
			$tpl->set_var('MAIN_TITLE', "Delete ".$get_item." factura proforma ");
		break;
		
		case 'contract':
			$get_item = $param1;
			$tpl->set_var('DELWHO', "Delete ".$get_item." contract ");
			$tpl->set_var('MAIN_TITLE', "Delete ".$get_item." contract ");
		break;
	}
	$tpl->parse("MAIN", "tpl_main");
}
else
{
	if (isset($_POST['what']))
	{
		switch ($action)
		{
			case 'modules':
				DeleteModule(intval($param1));//and all entries, items , etc.
				$the_return_page = '?page=modules.list';
				#send info message
				$_SESSION['admin_info'] = 'Module successfully deleted !';
				$_SESSION['admin_info_type'] = 'info';
			break;

			case 'pages':
				DeletePage(intval($param1));
				$the_return_page = '?page=pages.list';
				#send info message
				$_SESSION['admin_info'] = 'Page successfully deleted !';
				$_SESSION['admin_info_type'] = 'info';
			break;

			case 'menus':
				DeleteMenu(intval($param1));
				$the_return_page = '?page=menus';
				#send info message
				$_SESSION['admin_info'] = 'Menu successfully deleted !';
				$_SESSION['admin_info_type'] = 'info';
			break;

			case 'cabinete':
				DeleteCabinet(intval($param1));
				$the_return_page = '?page=cabinete.list';
				#send info message
				$_SESSION['admin_info'] = 'Cabinet successfully deleted !';
				$_SESSION['admin_info_type'] = 'info';
			break;

		case 'anunturi':
			DeleteAnunt(intval($param1));
				$the_return_page = '?page=anunturi.list';
				#send info message
				$_SESSION['admin_info'] = 'Anunt successfully deleted !';
				$_SESSION['admin_info_type'] = 'info';
		break;
		case 'articles':
			DeleteArticle(intval($param1));
				$the_return_page = '?page=articles.list';
				#send info message
				$_SESSION['admin_info'] = 'Article successfully deleted !';
				$_SESSION['admin_info_type'] = 'info';
		break;
	
		case 'dictionar_medical':
			DeleteTerm(intval($param1));
			$the_return_page = '?page=dictionar_medical.listwords';
			#send info message
			$_SESSION['admin_info'] = 'Term sucessfully deleted !';
			$_SESSION['admin_info_type'] = 'info';
		break;
		
			case 'news':
				#delete from db
				$query = "DELETE FROM news WHERE id = '".intval($param1)."'";
				$db->query($query);
				#optimeze pages table
				$query = "OPTIMIZE TABLE `news`";
				$db->query($query);
				#make auto increment from 1
				$query = "ALTER TABLE `news`
									PACK_KEYS = 0 CHECKSUM = 0 DELAY_KEY_WRITE = 0 AUTO_INCREMENT = 1";
				$db->query($query);
				$the_return_page = '?page=news.list';
				#send info message
				$_SESSION['admin_info'] = 'News successfully deleted !';
				$_SESSION['admin_info_type'] = 'info';
			break;

			case 'links':
				#delete from db
				$query = "DELETE FROM links WHERE id = '".intval($param1)."'";
				$db->query($query);
				#optimeze links table
				$query = "OPTIMIZE TABLE `links`";
				$db->query($query);
				#make auto increment from 1
				$query = "ALTER TABLE `links`
									PACK_KEYS = 0 CHECKSUM = 0 DELAY_KEY_WRITE = 0 AUTO_INCREMENT = 1";
				$db->query($query);
				$the_return_page = '?page=links.list';
				#send info message
				$_SESSION['admin_info'] = 'Link successfully deleted !';
				$_SESSION['admin_info_type'] = 'info';
			break;

			case 'admin':
				$query = "DELETE FROM admin_accounts WHERE id = '".intval($param1)."'";
				$db->query($query);
				#delete logins too
				$query = "DELETE FROM admin_login WHERE user_id = '".intval($param1)."'";
				$db->query($query);
				$the_return_page = "?page=admins.list";
				#send info message
				$_SESSION['admin_info'] = 'Administrator account successfully deleted !';
				$_SESSION['admin_info_type'] = 'info';
			break;

			case 'contact':
				$query = "DELETE FROM contact_us WHERE id = '".intval($param1)."'";
				$db->query($query);
				$the_return_page = "?page=contact.list";
				#send info message
				$_SESSION['admin_info'] = 'Message successfully deleted !';
				$_SESSION['admin_info_type'] = 'info';
			break;
			
			case 'facturafiscala':
				$query = "DELETE FROM facturi_fiscale WHERE serie_factura = '".intval($param1)."'";
				$db->query($query);

				$the_return_page = "?page=plati.facturifiscale";
				#send info message
				$_SESSION['admin_info'] = 'Factura Fiscala successfully deleted !';
				$_SESSION['admin_info_type'] = 'info';
			break;
			
			case 'facturaproforma':
				$get_detalii_proforma = GetInfoProforma($param1);
			
				//$query = "DELETE FROM recomandate WHERE id = '7'";
				//$db->query($query);
				//exit;
				$query = "DELETE FROM facturi_proforme WHERE id = '".intval($param1)."'";
				$db->query($query);

				#delete form recomandat
				$query = "DELETE FROM recomandate WHERE factura_id = '".intval($param1)."'";
				$db->query($query);

				#delete from cumparator
				$query = "DELETE FROM cumparatori WHERE id= '".intval($get_detalii_proforma['cumparator_id'])."'";
				$db->query($query);
				
				
				
				
				#delete the html file
				chmod('../facturi/facturi_proforme/proforma_'.$param1.'.html', 777);
				unlink("../facturi/facturi_proforme/proforma_".$param1.".html");	
				
				$the_return_page = "?page=plati.facturiproforme";
				#send info message
				$_SESSION['admin_info'] = 'Factura proforma successfully deleted !';
				$_SESSION['admin_info_type'] = 'info';
			break;
			
			case 'contract':
				$query = "DELETE FROM contracte WHERE id = '".intval($param1)."'";
				$db->query($query);
				$the_return_page = "?page=contracte.list";
				#send info message
				$_SESSION['admin_info'] = 'Contractul successfully deleted !';
				$_SESSION['admin_info_type'] = 'info';
			break;
			case 'user':
				DeleteUserAccount(intval($param1));
				$the_return_page = "?page=users.list";
				#send info message
				$_SESSION['admin_info'] = 'User successfully deleted !';
				$_SESSION['admin_info_type'] = 'info';
			break;
			
			case 'bots':
				DeleteBots($param1);
				$the_return_page = "?page=stats_robots";
				#send info message
				$_SESSION['admin_info'] = 'Bot successfully deleted!';
				$_SESSION['admin_info_type'] = 'info';
			break;
		}
	}
	header("HTTP/1.1 301 Moved Permanently");
	header("Location: ".$the_return_page);
	exit;
}
?>