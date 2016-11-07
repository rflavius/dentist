<?php
/*------------------------------------------------------------------------------------------------
	|		dotBoost Self Managed Content | SMC Users Framework | support@dotboost.com
	+---------------------------------------------------------------------------
	|		SMC Users Framework IS NOT FREE SOFTWARE!
	+---------------------------------------------------------------------------
	|		Name : admin/logins.php
	|		Date started: Aug 3 2006
	|		Description : list admin logins
	|		Version : 0.9
	+---------------------------------------------------------------------------------------------*/
$tpl->set_file("tpl_logins", "static/logins.tpl");
$tpl->set_var("MAIN_TITLE", "List Admin Logins");
# pagination variable
$logins_per_page = '30'; # no need to make it in config
$p = isset($_GET['start']) ? $_GET['start']: 1;
#for one admin only
if (isset($_GET['admin']))
{
	$admin_id = $_GET['admin'];
	$page_name = "logins&admin=".$admin_id;
}
else
{
	$admin_id = '-1';
	$page_name = "logins";
}
$start = ($p-1)*$logins_per_page;
# pagination query
$query_limit = " LIMIT $start, $logins_per_page ";
#
# count logins and display pagination
#
$total_prod = CountAdminLogins ($admin_id);
$tpl->set_var("TLOGINS", $total_prod);
$pages = ceil($total_prod/$logins_per_page);
$tpl->set_var("PAGES", $pages);
$tpl->set_var("PAGINATION", AdminPagination($logins_per_page, $total_prod, $page_name, $p));
#	end pagination
switch ($admin_id)
{
	default :
		$query = "SELECT a.user, b.ip, b.user_agent, b.data
							FROM admin_accounts As a , admin_login As b 
							WHERE a.id = b.user_id AND b.user_id = '".intval($admin_id)."' ORDER BY b.data DESC ".$query_limit;
	break;

	case '-1':
		$query = "SELECT a.user, b.ip, b.user_agent, b.data
							FROM admin_accounts As a , admin_login As b 
							WHERE a.id = b.user_id ORDER BY b.data DESC ".$query_limit;
	break;
}
$db->query($query);
$i = 0;
//build the output
$tpl->set_block("tpl_logins", "row", "rows");
while ($db->next_record())
{
	$bc = ($i % 2)+1;
	$tpl->set_var("BGCOLOR", 'row'.$bc);
	$tpl->set_var("LUSERNAME",$db->f("user"));
	$tpl->set_var("LDATE",AdminTimeFormat($db->f("data"),'N'));
	$ip = $db->f("ip");
	$tpl->set_var("LIP",$ip);
	$tpl->set_var("LUSERAGENT", $db->f("user_agent"));
	# ip 2 country
	$ip2country = Ip2Country($ip);
	$tpl->set_var("COUNTRYIMAGE", strtolower($ip2country[0]));
	$tpl->set_var("COUNTRYNAME", $ip2country[1]);
	$user_agent = strtolower($db->f("user_agent"));
	$tpl->set_var("ICON", GetBrowserIcon($user_agent));
	$tpl->parse("rows", "row", true);
	$i++;
}
$tpl->parse("MAIN", "tpl_logins");
?>