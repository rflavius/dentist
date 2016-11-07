<?php

if($conf->url_rewrite_mode == 'Y')
{
	if((isset($param1))&&($param1!=null)&&(substr($param1,0,6)!="pagina"))
	{
		$news_alias = str_replace(".html","",$param1);
		$param1 = GetNewsIdByAlias($news_alias);
		$action = "detalii";
	}
}

$registry->route['action'] = $action;
$registry->route['param1'] = $param1;

switch ($action )
{
	default:
		$tpl->set_file('tpl_anunturi', 'modules/news/news.tpl');
		$tpl->set_block('tpl_anunturi','rowdoicabs','rowdoicabss' );
		//$tpl->set_block('tpl_anunturi','rowunucabs','rowunucabss' );
		$tpl->set_block('tpl_anunturi', 'pagination_table', 'pagination_tablee');

		/**************************for pagination***********************/
		#create de pagination page_name
		$total_records = CountNewsTotalRecords();
		$tpl->set_var('COUNT_NEWS', $total_records);
		$pages_number = ceil($total_records/$conf->cabinete_anunturi_per_page);
		$tpl->set_var("PAGES", $pages_number);
		//var_dump($param1);
		if($conf->url_rewrite_mode == 'Y')
		{
			if(isset($param1)&&(substr($param1,0,6)=="pagina"))
			{	$startt = explode(".",$param1);	
				$start = substr($startt[0],6);	//echo $start;
			}
		}
		$page_name = $module;
		if(!isset($start))
		{
			$start_q = 0;
			$start = 1;
		}
		else
		{
			$start_q = $conf->cabinete_anunturi_per_page*($start-1);
		}
		#Create and parse pagination
		$html_pages = FrontEndPagination($conf->cabinete_anunturi_per_page, $total_records, $page_name, $start);
		$tpl->set_var("PAGINATION", $html_pages);
		
		#Create query limit and get the cabinete for displaing
		$query_limit = " $start_q,". $conf->cabinete_anunturi_per_page;
		$get_news = GetNews('0', $query_limit);
		$i=0;		
		while (list($k, $v) = each($get_news))
		{
			$tpl->set_var('TITLU_NEWS', $v['title']);
			$tpl->set_var('DESCRIERE', text_best_fit(strtolower(strip_tags($v['content'])), 130));
			$tpl->set_var('URLCITESTE', ReWrite('news', 'news.detalii.'.$v['id']));

			$tpl->set_var("IMAGINE",SITE_BASE."/sources/thumbnails.php?target=".$v['imagine'].'&max_size=70&news=yes');
			$tpl->set_var('IMAGNAME',$v['imagine']);
			$tpl->set_var('LOCATION',$v['location']);
			$tpl->set_var('EVENT_DATE',$v['event_date']);
			$tpl->set_var('TITLE_URL_NEWS',$v['title'] );
			$tpl->parse('rowdoicabss', 'rowdoicabs', true);	
			/*$i++;
			if(($i%2==0)||($i==count($get_news)))
			{
				$tpl->parse('rowunucabss', 'rowunucabs', true);	
				$tpl->parse('rowdoicabss', '');
			}*/
		}
	$tpl->parse('pagination_tablee', 'pagination_table', true);
	$tpl->parse('MAIN', 'tpl_anunturi');
	break;
	
	
	case 'detalii':
		// if no eveniment id fould then redirect it to the evenimente main page
		if(intval($param1)<=0)
		{
			header("HTTP/1.1 301 Moved Permanently");
			header("Location: ".ReWrite('news', 'news'));
			exit;
		}
		
		
		$tpl->set_file('tpl_details', 'modules/news/detalii.tpl');
		#next and previous links
		$get_cabinet = GetNews(intval($param1),'');
		// parse social links
		$tpl->set_var('SHARE_URL', ReWrite('news', 'news.detalii.'.$param1));
		
		$tpl->set_var("IMAGINE",SITE_BASE."/sources/thumbnails.php?target=".$get_cabinet[0]['imagine'].'&max_size=500&news=yes');
		$tpl->set_var('IMAGNAME',$get_cabinet[0]['imagine']);
		$tpl->set_var("CONTINUT",$get_cabinet[0]['content']);
		$tpl->set_var('TITLU_NEWS', $get_cabinet[0]['title']);
		$tpl->parse('MAIN', 'tpl_details');
	break;
	
}
?>