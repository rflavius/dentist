<?php 
/*
 * here we will have the new search
 */
#let make the redireckt for back tab
if(isset($_POST) && array_key_exists('search_word',$_POST)) 
{ 
	## store POST in session
	foreach ($_POST as $key => $value)
	{
		$_SESSION['adv_search'][$key] = strtolower($value);
	}
	//$_SESSION['adv_search'] = $_POST; 
	## empty the POST variable
	$_POST = array();
	header("Location: ".ReWrite("default","advsearch"));
	exit;
}

$tpl->set_var('PAGETITLE', 'Oferte promovare medic dentist, cabinete stomatologice, clinici de stomatologie si radiologie');

$tpl->set_var('ADVSEARCH_WORD',ReWrite("default","advsearch"));

$searchObj = new Search($db);

//print_r($_SESSION['adv_search']);

switch($action)
{
	default:
		if(isset($action) && $action!='')
		{
			if(isset($_SESSION['adv_search']) && count($_SESSION['adv_search'])>0)
			{
		
			}
			$_POST['search_word'] = str_replace("_"," ",$param1);
			$_POST['search_location'] = $param2;
			//this variable we are using the know wich results we are parsing in the right side the real results
			$default_view = $action;
		}
		else
		{
			if(isset($_SESSION['adv_search']) && count($_SESSION['adv_search'])>0)
			{
				$_POST = $_SESSION['adv_search'];
			}
			//this variable we are using the know wich results we are parsing in the right side the real results
			$default_view = 'dentisti';
		}
		
		$tpl->set_file('tpl_main', 'modules/search/search_responsive.tpl');
		$tpl->set_block('tpl_main','if_recomandat','if_recomandat2');
		$tpl->set_block('tpl_main','if_business','if_business2');
		$tpl->set_block('tpl_main','results','results2');
		$tpl->set_block('tpl_main','list_filter_cats','list_filter_cats2');
		//echo $_POST['search_word'];
		if(isset($_POST['search_word']) && $_POST['search_word']!='' )
		{
			// remember the search log
			$searchObj->saveSearch($_POST['search_word'],$_POST['search_location']);
				
			$filter_count = array();
			$tpl->set_var('SEARCH_STRING',$_POST['search_word']);
			$tpl->set_var('SEARCH_LOC',$_POST['search_location']);
				
			// go for the filter categories
			$filter_cats = array('dentisti'=>'Cabinete','articole'=>'Articole','anunturi'=>'Anunturi');
			foreach($filter_cats as $ky=>$val)
			{
				$nr = $searchObj->countFilterCategoryResults($ky,$_POST['search_word'],$_POST['search_location']);
				$tpl->set_var('FILTER_CAT',$val);
				$tpl->set_var('FILTER_CAT_NR',$nr);
		
				$filter_count = array_merge($filter_count,array($ky => $nr));
				//set up the default view based on the results
				if(!isset($action) || $action=='')
				{
					foreach($filter_count as $k => $v)
					{
						if($v<>0)
						{
							$default_view = $k;
							break;
						}
					}
				}
				
				if($nr>0)
				{
					$tpl->set_var('FILTER_CAT_NORESULTS','');
					$tpl->set_var('FILTER_CAT_LINK',ReWrite('advsearch','advsearch.'.$ky.'.'.str_replace(" ","_",$_POST['search_word'])));
				}
				else 
				{
					$tpl->set_var('FILTER_CAT_NORESULTS', 'disabled');
					$tpl->set_var('FILTER_CAT_LINK', '#');
				}
				
				if($default_view==$ky && $filter_count[$default_view]>0)
				{
					$tpl->set_var('FILTER_CAT_ACTIVE', "active");
				}
				else
				{
					$tpl->set_var('FILTER_CAT_ACTIVE', "");
				}
				$tpl->parse('list_filter_cats2','list_filter_cats',true);
			}
				
			// display pagination if any
			$total_records = $filter_count[$default_view];
			$per_page = '20';
			$tpl->set_var('COUNT_REZ', $total_records);
			$pages_number = ceil($total_records/$per_page);
			$tpl->set_var("PAGES", $pages_number);
			if(isset($param3) && $param3!='')
			{
				$start = $param3;
				$start_q = $per_page*($start-1);
			}
			else
			{
				$start_q = 0;
				$start = 1;
			}
			$page_name = $module.'.'.$default_view.'.'.str_replace(" ","_",$_POST['search_word']).'.'.$_POST['search_location'];
				
			#Create and parse pagination
			$html_pages = $searchObj->Pagination($per_page, $total_records, $page_name, $start);
			$tpl->set_var("PAGINATION", $html_pages);
		
			#Create query limit and get the cabinete for displaing
			$limit = " LIMIT $start_q, $per_page";
				
			//display the results based on the default view
			$searchObj->displaySearchResults($default_view,$_POST['search_word'],$_POST['search_location'],$limit);
		}
		else
		{
			$tpl->set_file('tpl_error', 'info/error.tpl');
			$tpl->set_var('MESSAGE', 'Ne pare rau dar cautarea dvs este fara rezultat.');
			$tpl->parse('NO_FIRM_HERE', 'tpl_error');
		}
	break;
	
	case 'view':
		$tpl->set_file('tpl_main', 'modules/search/new_search_results.tpl');
		$tpl->set_block('tpl_main','results','results2');
		$tpl->set_block('tpl_main','list_filter_cats','list_filter_cats2');
		$tpl->set_block('tpl_main','list_filter_loc','list_filter_loc2');
		print_r($tmpvar);
	break;
	
}



$tpl->parse('MAIN', 'tpl_main');
