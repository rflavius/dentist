<?php
switch ($action)
{
	default :
		$tpl->set_file('tpl_links', 'sitemap/general.tpl');
		$tpl->set_var('SYMBOL_MAX_WIDTH', $conf->symbol_max_width);
		$tpl->set_var('SYMBOL_MAX_HEIGHT', $conf->symbol_max_height);
		$tpl->set_var('BGCOLOR1', 'row1');
		$tpl->set_var('BGCOLOR2', 'row2');
/*the settings all the modules have*/
/*set error blocks*/
			$tpl->set_block('tpl_links', 'errors', 'errors_block');
			$tpl->set_block('tpl_links', 'if_errors', 'if_errors_block');
			if (isset($_SESSION['edit_modules']))
			{
				foreach ($_SESSION['edit_modules'] as $key => $val)
				{
					$tpl->set_var('ERROR', $val);
					$tpl->parse('errors_block', 'errors', true);
				}
				unset($_SESSION['edit_modules']);
				$tpl->parse('if_errors_block', 'if_errors', true);
			}
/*set colors*/
			$tpl->set_var('BGCOLOR1', 'row1');
			$tpl->set_var('BGCOLOR2', 'row2');
			if ($action == ""){$get_id = GetModuleID($module);}
			elseif (!is_numeric($action)){$get_id = GetModuleID($module.'.'.$action);}
			else {$get_id = $action;}
/*get info*/
			$get_module = GetModules(intval($get_id));
			$tplhe_module = $get_module['0'];
			if (isset($_SESSION['edit_modules_content']))
			{
				$tplhe_module = $_SESSION['edit_modules_content'];
				unset($_SESSION['edit_modules_content']);
			}
			$tpl->set_var('ID', $tplhe_module['id']);
			$tpl->set_var('NAME', $tplhe_module['name']);
			$tpl->set_var('KEYWORDS', $tplhe_module['meta_keywords']);
			$tpl->set_var('DESCRIPTION', $tplhe_module['meta_description']);
			$tpl->set_var('CONTENT', $tplhe_module['content']);
/*page main title*/
			$tpl->set_var('MAIN_TITLE', 'Edit '.$tplhe_module['name'].' module');
			$link = explode('?p=', $tplhe_module['link']);
			$link = $link['1'];
			$tpl->set_var('LINK', $link);
			$tpl->set_var('SYMBOL', $tplhe_module['graphic_symbol']);
			$tpl->set_var('PAGE_PICTURE', $tplhe_module['page_picture']);
			$tpl->set_var('PICTURE_MAX_WIDTH', $conf->picture_max_width);
			$tpl->set_var('PICTURE_MAX_HEIGHT', $conf->picture_max_height);
/*status*/
			if ($tplhe_module['active'] == '1')
			{
				$tpl->set_var('STATUS_ACTIVE', 'selected');
			}
			else 
			{
				$tpl->set_var('STATUS_INACTIVE', 'selected');
			}
		$tpl->parse('MAIN', 'tpl_links');
	break;

case 'generate':
	$tpl->set_file("tpl_generate", "sitemap/generate.xml");
	$tpl->set_var("LAST_MOD", date("Y-m-d"));
	$tpl->set_var("CHANGE_FREQ", "daily");
	$tpl->set_var("PRIORITY", "0.5");
	$site_link = "http://www.dentistonline.ro";
	$tpl->set_block("tpl_generate", "display", "display_block");
	
	$i = 0;
	/*first get the pages*/
	$get_pages = SitemapPages();
	/*start counting pages*/
	if (count($get_pages) != '0')
	{
		while (list($k, $v) = each($get_pages))
		{
			$tplhe_link = ReWrite('default', $v['link']);
			$tpl->set_var("LINK", $tplhe_link);
			if ($tplhe_link == "/"){$tpl->set_var("LINK", $site_link);}
			$i++;
			$tpl->parse("display_block", "display", true);
		}
	}
		
	
	/*display modules*/
	$get_modules = SitemapModules('-1');
	if (count($get_modules) != '0')
	{
		while (list($key, $val) = each($get_modules))
		{
			$section = '';
			$result = explode(".", $val['link']);
			
			/*if the resulting array has just one key the rewrite will be default*/
			#but is special for news and dictionar stomatologic
			if ((count($result) == '1')&&($result[0]!='news'))
			{
				$tpl->set_var('LINK', ReWrite('default', $val['link']));
			}
			else 
			{
				$section = $result[0];
				$tpl->set_var('LINK',ReWrite($section, $val['link']));
			}

			/*count pages - increment right before parsing, to be sure*/
			$i++;
			$tpl->parse("display_block", "display", true);
			/*get evenimente medicale*/
			if($result['0']=='news')
			{
					$tpl->set_var('LINK', ReWrite('news', 'news'));
					$i++;
					$query_limit = " 100";
					$get_all_news = GetNews('0', $query_limit);
					foreach($get_all_news as $kyn => $valn)
					{
						$tpl->set_var('LINK', ReWrite('news', 'news.detalii.'.$valn['id']));
						$i++;
						$tpl->parse("display_block", "display", true);
					}
			}
			
			if($result['0']=='dictionar_stomatologic')
			{
					
				$get_dictionary_categories = GetDictionaryArticlesCategories('-1', '');
				
					while (list($k, $v) = each($get_dictionary_categories))
					{
						$tpl->set_var('LINK',ReWrite('dictionar_stomatologic','dictionar_stomatologic.litera.'.$v['cat_name']) );
						$i++;
						$tpl->parse("display_block", "display", true);
						$query_limit = ' Limit 100';$status = 1;
						$terms = ListDictionaryTerms($v['id_cat'], $status, $query_limit);
						foreach($terms  as $ky_dic => $val_dic)
						{
							$tpl->set_var('LINK', ReWrite('dictionar_stomatologic','dictionar_stomatologic.termen.'.$val_dic['id']));
							$i++;
							$tpl->parse("display_block", "display", true);
						}
					}
			
			
			}
			if ($section == 'cabinete')
			{
				/*list categories*/
				$tplhe_cats = GetCabineteCategories($result[1], 'Y', '');
				if (count($tplhe_cats) != '0')
				{
					while (list($cat_key, $cat_val) = each($tplhe_cats))
					{
						$tpl->set_var('LINK', ReWrite('cabinete', 'cabinete.'.$result[1].'.'.$cat_val['id_cat']));
						/*count pages - increment right before parsing, to be sure*/
						$i++;
						$tpl->parse("display_block", "display", true);
						$category_cabinete = GetCabinete('', $cat_val['id_cat'],"","");
						if (count($category_cabinete) != '0')
						{
							while (list($ky, $vl) = each($category_cabinete))
							{
								$tpl->set_var('LINK', ReWrite('cabinete_detalii', 'cabinete.detalii.'.$vl['id']));
									/*count pages - increment right before parsing, to be sure*/
								$i++;
								$tpl->parse("display_block", "display", true);
							}
						}
					}
				}
			}
			/*get anunturi items  items*/
		if ($section == 'anunturi')
			{
			/*get the anunturi items for the current module*/
				$get_anunturi_items = GetAnunturiFrontend($result[1], '','');
				if (count($get_anunturi_items) != '0')
				{
					while (list($g_k, $g_v) = each($get_anunturi_items))
					{
						$tpl->set_var('LINK', ReWrite('anunturi_detalii', 'anunturi.detalii.'.$g_v['id']));
						$i++;
						$tpl->parse("display_block", "display", true);
					}
				}
			}
			
		}
	}
	/*insert in the config table the number of pages and the last generated date*/
	$tplhe_config_value = $i.','.date("Y-m-d");
	SaveConfig("sitemap_info", $tplhe_config_value);
	
	$content = $tpl->parse("MAIN", "tpl_generate");
//print_r($content);exit;
	/*write into file*/
	$handle = fopen("../sitemap.xml", "w+");
	fwrite($handle, stripslashes($content));
	fclose($handle);
	/*create gz file*/
	include("../classes/admin/gzip.php");
	/*the name of the resulting gz(archive) file*/
	$path = "sitemap.xml.gz";
	/*file to add to archive*/
	$filedata = "../sitemap.xml";

	#create new gz object
	$gz = new gzip();
	#add file to archive
	$gz->add_file($filedata, $path);
	#and write gzip file
	$gz->write_file("../".$path);
	header ('location: '.$_SERVER['HTTP_REFERER']);
	exit;
break;
}
?>