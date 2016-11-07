<?php
/*-------------------------------------------------------------------------------------------------
	|		dotBoost Self Managed Content | SMC Users Framework | support@dotboost.com
	+---------------------------------------------------------------------------
	|		SMC Users Framework IS NOT FREE SOFTWARE!
	+---------------------------------------------------------------------------
	|		Name : links.php
	|		Date started: Nov 2 2006
	|		Description : display links
	|		Version : 0.9
	+----------------------------------------------------------------------------------------------*/
$tpl->set_file('tpl_links', 'modules/links/links.tpl');
#the content
$get_module_content = GetModuleContent($module, $action);
$tpl->set_block('tpl_links', 'if_content', 'if_content_block');
if ($get_module_content != "")
{
	$tpl->set_var('CURENTS_PAGE_CONTENT', nl2br($get_module_content));
	$tpl->parse('if_content_block', 'if_content', true);
}
$tpl->set_block('tpl_links', 'list', 'list_block');
#pagination
$query = "SELECT * FROM links WHERE status = '1'";
$db->query($query);
$totalrec = $db->num_rows();
$page_name = $module.'.'.$action;
if(!intval($param1))
{
	$start_q = 0;
	$param1 = 1;
}
else
{
	$start_q = $conf->links_per_page*($param1-1);
}
$html_pages = Pagination($conf->links_per_page, $totalrec, $page_name, $param1);
$tpl->set_var("PAGINATION", $html_pages);
$query_limit = " $start_q, $conf->links_per_page";
$get_links = GetFrontEndLinks(intval($action), $query_limit);
if (count($get_links) != '0')
{
	while (list($k, $v) = each($get_links))
	{
		$tpl->set_var('TITLE', $v['title']);
		$tpl->set_var('LINK', $v['link']);
		$tpl->set_var('DESCRIPTION', nl2br($v['description']));
		$tpl->parse('list_block', 'list', true);
	}
}
$tpl->parse('MAIN', 'tpl_links');
?>