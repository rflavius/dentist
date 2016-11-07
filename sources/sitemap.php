<?php

require('./classes/cache.inc.php');
$tpl->set_file('tpl_sitemap', 'modules/sitemap/display.tpl');
$content="";
$cache = new Cache;
if($cache->WeHaveCache('sitemap'))
{
	## we have the sitemap page
	### if we have the cache file....then use that one
	$content = $cache->GetCacheContent('sitemap');
}
else
{
	## let's make it
	### if don't have the cache file....then create one
	$site_link = SITE_BASE;
	/*first get the pages*/
	/*start counting pages*/
	$i = 0;
	$content = '';
	$get_pages = SitemapPages();
	if (count($get_pages) != '0')
	{
		while (list($k, $v) = each($get_pages))
		{
			$the_link = ReWrite('default', $v['link']);
			$content .= "<tr><td><a href='".$the_link."' title='".$v['name']."'>".$v['name']."</a></td></tr>";
			$i++;
		}
	}
	/*display modules*/
	$get_modules = SitemapModules();
	
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
				$content .= "<tr><td><a href='".ReWrite('default', $val['link'])."' title='".$val['name']."'> ".$val['name']."</a></td></tr>";
			}
			else 
			{
				$section = $result[0];
				$content .= "<tr><td><a href='". ReWrite($section, $val['link'])."' title='".$val['name']."'><b>".$val['name']."</b></a></td></tr>";
			}
			
			/*
			if($result['0']=='news')
			{
					$tpl->set_var('LINK', ReWrite('news', 'news'));
					$query_limit = "100";
					$get_all_news = GetNews('0', $query_limit);
					foreach($get_all_news as $kyn => $valn)
					{
						$content .= "<tr><td class=\"padding_categories\"><a href='". ReWrite('news', 'news.detalii.'.$valn['id'])."' title=".$valn['title'].">".$valn['title']."</a></td></tr>";
					}
			}
			
			if($result['0']=='dictionar_stomatologic')
			{
					
				$get_dictionary_categories = GetDictionaryArticlesCategories('-1', '');
					while (list($k, $v) = each($get_dictionary_categories))
					{
						$content .= "<tr><td class=\"padding_categories\"><a href='".ReWrite('dictionar_stomatologic','dictionar_stomatologic.litera.'.$v['cat_name']) ."' title='Termeni medicali litera ".$v['cat_name']."'>".$v['cat_name']."</a></td></tr>";
						$query_limit = ' Limit 100';$status = 1;
						$terms = ListDictionaryTerms($v['id_cat'], $status, $query_limit);
						foreach($terms  as $ky_dic => $val_dic)
						{
							$content .= "<tr><td class=\"padding_cabinete\"><a href='".ReWrite('dictionar_stomatologic','dictionar_stomatologic.termen.'.$val_dic['id'])."' title='".$val_dic['titlu']."'>".$val_dic['titlu']."</a></td></tr>";
						}
					}
			
			
			}
				#make link for cabinete
				if ($section == 'cabinete')
				{
					$tplhe_cats = GetCabineteCategories($result[1], 'Y', '');
					if (count($tplhe_cats) != '0')
					{
							while (list($cat_key, $cat_val) = each($tplhe_cats))
							{
								$content .= "<tr><td class=\"padding_categories\"><a href='".ReWrite('cabinete', 'cabinete.'.$result[1].'.'.$cat_val['id_cat'])."' title='Cabinete ".$cat_val['cat_name']."'>".$cat_val['cat_name']."</a></td></tr>";
								$category_cabinete = GetCabinete('', $cat_val['id_cat'],"","");
								if (count($category_cabinete) != '0')
								{
									while (list($ky, $vl) = each($category_cabinete))
									{
										$content .= "<tr><td class=\"padding_cabinete\"><a href='". ReWrite('cabinete_detalii', 'cabinete.detalii.'.$vl['id'])."' title='".$vl['nume_firma']."'>".$vl['nume_firma'] ."</a></td></tr>";
									}
								}
							}
					}
				}
			//get anunturi items  items
			if ($section == 'anunturi')
			{
					//get the anunturi items for the current module
					$get_anunturi_items = GetAnunturiFrontend($result[1], '','');
					if (count($get_anunturi_items) != '0')
					{
						while (list($g_k, $g_v) = each($get_anunturi_items))
						{
							$content .= "<tr><td class=\"padding_categories\"><a href='".ReWrite('anunturi_detalii', 'anunturi.detalii.'.$g_v['id'])."' title='Anunturi ".$g_v['titlu']."'>".$g_v['titlu']."</a></td></tr>";
						}
					}
			}*/
			
		}
	}
	$cache_val = "<table border='0' width='100%' align='center' cellspacing='2' cellpadding='3'>
".$content."</table>";
	$content = $cache_val;
	$cache->CreateCache('sitemap',$cache_val);
}

$tpl->set_var('SITEMAP_CONTENT', $content);
$tpl->parse('MAIN', 'tpl_sitemap');
?>