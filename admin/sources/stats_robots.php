<?php
/*--------------------------------------------------------------------------------------------
	|		dotBoost DoItYourself v1.0
	|		====================================================
	|		by Marius marius@rospace.com
	|		(c) 2005 6416136 CANADA INC http://www.dotboost.com
	|		====================================================
	+---------------------------------------------------------------------------
	|		DOTBOOST DOITYOURSELF IS NOT FREE SOFTWARE!
	+---------------------------------------------------------------------------
	|		Name : stats_robots.php
	|		Date started: Sept 21 2005
	|		Description :  List all search engine spiders hits
	|		Version : 1.0
+--------------------------------------------------------------------------------------------*/
$action = isset($_GET['action']) && ($_GET['action']!='')?  $_GET['action']:'';

# details by bot
if (isset($_GET['type']) && $_GET['type'] !='')
{
	$tpl->set_file("tpl_main", "statistics/stats_robots_bot.tpl");
	# pagination variable
	$per_page = '30'; # no need to make it in config
	# pagination variable
	$p = isset($_GET['p']) ? $_GET['p']: 1;
	$bot_type = $_GET['type'];

	# display robots type
	$robots = ListRobotsType();
	$tpl->set_block("tpl_main", "rowc", "rowsc");
	$tpl->set_var('MAIN_TITLE', 'Search Engine Spiders');
	while(list($k, $v) = each($robots))
	{
		$tpl->set_var("CATSEL","");
		$tpl->set_var("CATNAME",$v);
		$tpl->set_var("CATVAL",$k);
		if ($bot_type == $k )
		{
			$tpl->set_var('MAIN_TITLE', $v.' Search Engine Spider');
			$tpl->set_var("CATSEL","selected");
		}
		$tpl->parse("rowsc", "rowc", true);
	}


	# count logins and display pagination
	#
	$total_hits = StatsCountRobots ($bot_type);
	$tpl->set_var("TLOGINS", $total_hits);

	$tpl->set_var("PAGINATION", BotsPagination($per_page, $total_hits, 'stats_robots&type='.$bot_type, $p));

	$pages = ceil($total_hits/$per_page);
	$tpl->set_var("PAGES", $pages);
	#	end pagination

	$visits = ListRobots($p, $per_page, $bot_type);
	$j=0;
	$tpl->set_block("tpl_main", "ror", "rors");
	while(list($k, $v) = each($visits))
	{
		$bc = ($j % 2)+1;
		$tpl->set_var("BGCOLOR", 'row'.$bc);
		$tpl->set_var("BOT",$v['bot']);
		$tpl->set_var("BPAGE",CleanSessionUrl($v['page']));
		$tpl->set_var("BIP",$v['ip_address']);
		$tpl->set_var("BUAS",ShortUA($v['user_agent']));
		$tpl->set_var("BUA",$v['user_agent']);
		$tpl->set_var("BDATE",AdminTimeFormat($v['visit_date'], 'N'));
		$tpl->parse("rors", "ror", true);
		$j++;
	}
}
else 
{
	$tpl->set_file("tpl_main", "statistics/stats_robots.tpl");
	$tpl->set_var('MAIN_TITLE', 'Search Engine Spiders');
	$robots = ListRobotsType();
	$tpl->set_block("tpl_main", "ror", "rors");
	while(list($k, $v) = each($robots))
	{
		$total_hits = StatsCountRobots ($k);
		if ($total_hits >0 )
		{
			$j=0;
			$bc = ($j % 2)+1;
			$tpl->set_var("BGCOLOR", 'row'.$bc);
			$tpl->set_var("BOTNAME",$v);
			$tpl->set_var("BOTTYPE",$k);
			$tpl->set_var("HITS",$total_hits);
			$last_hit = LastHitBot($k);
			$tpl->set_var("LASTHIT", TimeFormatShort($last_hit));
			$tpl->parse("rors", "ror", true);
			$j++;
		}
	}
}
$tpl->parse("MAIN", "tpl_main");
?>