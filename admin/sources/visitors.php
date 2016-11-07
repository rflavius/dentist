<?php
switch ($action)
{
	case 'list':
		$tpl->set_file('tpl_list', 'visitors/list.tpl');
		#page main title
		$tpl->set_var('MAIN_TITLE', 'List all visitors');
		#set blocks
		$tpl->set_block("tpl_list", "list", "list_block");
		#count all messages
		$total_records = CountVisitors();
		$tpl->set_var('TOTAL_VISITORS', $total_records);
		$pages_number = ceil($total_records/$conf->users_per_page);
		$tpl->set_var('PAGES', $pages_number);
		#create de pagination page_name
		$page_name = $module.'.'.$action;
		if(isset($_GET['start'])&&($_GET['start']!=""))
		{
			$start = $_GET['start'];
		}
		if(!isset($start))
		{
			$start_q = 0;
			$start = 1;
		}
		else
		{
			$start_q = $conf->users_per_page*($start-1);
		}
		#Create and parse pagination
		$html_pages = AdminPagination($conf->users_per_page, $total_records, $page_name, $start);
		$tpl->set_var("PAGINATION", $html_pages);
		$query_limit = " LIMIT $start_q, $conf->users_per_page";
		#get messages*/
		$users = GetVisitors( $query_limit);
		if (count($users) != '0')
		{
			$i = 0;
			while (list($k, $v) = each($users))
			{
				#set colors*/
				$bc = ($i % 2)+1;
				$tpl->set_var("BGCOLOR", 'row'.$bc);
				$tpl->set_var("USERNAME",$v["IP"]);
				$tpl->set_var("DATE", AdminTimeFormat($v["date"],'Y'));
				$tpl->set_var("IP", $v["IP"]);
				$tpl->set_var("USER_AGENT", $v["browser"]);
				$ip2country = Ip2Country($v["IP"]);
				$tpl->set_var("COUNTRY_IMAGE", strtolower($ip2country[0]));
				$tpl->set_var("COUNTRY_NAME", $ip2country[1]);
				$tpl->set_var("ICON", GetBrowserIcon(strtolower($v["browser"])));
				if($v['refferer']!="")
				{
					$tpl->set_var('REFFERER', $v['refferer']);
					
				}
				else
				{
					$tpl->set_var('REFFERER', "none");
					
				}
				
				$tpl->parse("list_block", "list", true);
				$i++;
			}
		}
		$tpl->parse('MAIN', 'tpl_list');
	break;
}
?>