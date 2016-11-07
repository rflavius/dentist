<?php 
/*
 * here we will have the new search
 */
#let make the redireckt for back tab
if(isset($_POST) && array_key_exists('search_word',$_POST)) 
{ 
	 ## store POST in session
     $_SESSION['adv_search'] = $_POST; 
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
		
		$tpl->set_file('tpl_main', 'modules/search/new_search_results.tpl');
		$tpl->set_block('tpl_main','results','results2');
		$tpl->set_block('tpl_main','list_filter_cats','list_filter_cats2');
		$tpl->set_block('tpl_main','list_filter_loc','list_filter_loc2');
		//echo $_POST['search_word'];
		if(isset($_POST['search_word']) && $_POST['search_word']!='' )
		{
			
			// remember the search log
			$searchObj->saveSearch($_POST['search_word'],$_POST['search_location']);
			
			$filter_count = array();
			$tpl->set_var('SEARCH_STRING',$_POST['search_word']);
			$tpl->set_var('SEARCH_LOC',$_POST['search_location']);
			
			// go for the filter categories
			$filter_cats = array('dentisti'=>'Cabinete si Clinici','tehnica'=>'Tehnica dentara','radiologie'=>'Radiologie dentara','distribuitori'=>'Distribuitori materiale','articole'=>'Articole Stomatologie','anunturi'=>'Anunturi Stomatologie','evenimente'=>'Evenimente Medicale');
			foreach($filter_cats as $ky=>$val)
			{
				$tpl->set_var('FILTER_CAT',$val);
				$nr = $searchObj->countFilterCategoryResults($ky,$_POST['search_word'],$_POST['search_location']);

				$tpl->set_var('FILTER_CAT_NR',$nr);
				$tpl->set_var('FILTER_CAT_LINK',ReWrite('advsearch','advsearch.'.$ky.'.'.str_replace(" ","_",$_POST['search_word']).'.'.$_POST['search_location']));
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
				
				if($default_view==$ky && $filter_count[$default_view]>0)
				{
					$tpl->set_var('FILTER_LOC_ACTIVE',"");
					$tpl->set_var('FILTER_CAT_ACTIVE', "class='active'");
				}
				else
				{
					$tpl->set_var('FILTER_CAT_ACTIVE', "");
				}
				$tpl->parse('list_filter_cats2','list_filter_cats',true);
			}
			
			// go for the filter judete
			$localitati = $searchObj->listAllJudete();
			$nr=0;
			foreach($localitati as $ky => $val)
			{
				if($nr<=10)
				{
					$loc_dentist = $searchObj->countFilterCategoryResults('dentisti',$_POST['search_word'],$val['name']);
					if($loc_dentist>1)
					{
						$tpl->set_var('FILTER_LOC',$val['name']);
						if(isset($param2) && $param2!='' && $param2==$val['name'])
						{
							$tpl->set_var('FILTER_CAT_ACTIVE', "class=''");
							$tpl->set_var('FILTER_LOC_ACTIVE',"class='active'");
						}
						else 
						{
							$tpl->set_var('FILTER_LOC_ACTIVE',"");
						}
						$tpl->set_var('FILTER_LOC_LINK',ReWrite('advsearch','advsearch.dentisti.'.str_replace(" ","_",$_POST['search_word']).'.'.$val['name']));
						$tpl->set_var('FILTER_LOC_NR',$loc_dentist);
						$tpl->parse('list_filter_loc2','list_filter_loc',true);
						$nr++;
					}
				}
			}
			
			
			// display pagination if any
			$total_records = $filter_count[$default_view];
			$per_page = '18';
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
			$results = $searchObj->displaySearchResults($default_view,$_POST['search_word'],$_POST['search_location'],$limit);
		}
		else 
		{
			$tpl->set_var('NO_FIRM_HERE','Cautarea dvs este incorecta, va rugam sa complectati cele 2 campuri.');
			$tpl->parse('results2','');
			$tpl->parse('list_filter_cats2','');
			$tpl->parse('list_filter_loc2','');
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
