<?php
/*------------------------------------------------------------------------------------------------
	|		dotBoost Self Managed Content | SMC Users Framework | support@dotboost.com
	+---------------------------------------------------------------------------
	|		SMC Users Framework IS NOT FREE SOFTWARE!
	+---------------------------------------------------------------------------
	|		Name : links.inc.php
	|		Date started: Aug 3 2006
	|		Description : this file holds all the function used by the mainadmin
	|		Version : 0.9
	+---------------------------------------------------------------------------------------------*/
/*
- Function used in : sources / links.php
*/
function Pagination ($per_page, $totals, $page_name, $p)
{
	$html_pages = ''; 
	$start = ($p-1)*$per_page; 
	$pages = ceil($totals/$per_page); 
	if ($pages ==  '1')
	{
		$html_pages = '<b>'.$pages.'&nbsp; Page</b>';
	}
	else
	{
		$html_pages = '<b>'.$pages.'&nbsp; Pages</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
	}
	if ($pages > 1 )
	{
		if (($p-1) > 0 )
		{
			$html_pages.="<a href=".ReWrite('links', $page_name.'.1').">&laquo; First </a>&nbsp;";
		}
		for($i = max(($p-8), 1); $i <= min(($p+8),$pages) ; $i++)
		{
			if ($p == $i)
			{
				$html_pages.= "[ <strong>".$i." </strong>]&nbsp;";
			}
			else
			{
			$html_pages.="<a href=".ReWrite('links', $page_name.'.'.$i).">".$i."</a>&nbsp;&nbsp;";
			}
		}
		if ($p < $pages)
		{
		$html_pages.=" <a href=".ReWrite('links', $page_name.'.'.$pages).">Last &raquo;</a>";
		}
	}
	return $html_pages;
}
/*
- Function used in : sources / links.php
-                  : admin / links.php
-                  : admin / delete.php
*/
function GetLinks ($display, $limit)
{
	global $db;
	$get_link = array();
	switch ($display)
	{
		#for the admin edit
		default:
			$query = "SELECT * FROM links WHERE id = '".$display."'";
		break;
		#all for admin
		case '-1':
			$query = "SELECT * FROM links ORDER by position ASC";
		break;
		#for the main pages or news page
		case '0':
			switch ($limit)
			{
				default :
					$query = "SELECT * FROM links WHERE status = '1' ORDER by position ASC
										LIMIT ".$limit;
				break;

				case '0':
					$query = "SELECT * FROM links WHERE status = '1' ORDER by position ASC";
				break;
			}
		break;
	}
	$db->query($query);
	$i = 0;
	while ($db->next_record())
	{
		$get_link[$i]['id'] = $db->f('id');
		$get_link[$i]['title'] = $db->f('title');
		$get_link[$i]['link'] = $db->f('link');
		$get_link[$i]['description'] = $db->f('description');
		$get_link[$i]['position'] = $db->f('position');
		$get_link[$i]['status'] = $db->f('status');
		$i++;
	}
	return $get_link;
}
/*
- Function used in : admin / links.php
*/
function ReorderLinks ($id, $order_type)
{
	global $db;
	$query="SELECT position FROM links WHERE `id`='".$id."'";
	$db->query($query);
	$db->next_record();
	$new_order = $db->f('position');
	if ($order_type == 'up')
	{
		$new_order += -15;
	}
	else 
	{
		$new_order += +15;
	}
	UpdateLinksOrder($id, $new_order);
}
/*
- Function used in : admin / links.php
*/
function UpdateLinksOrder ($id, $order_value)
{
	global $db;
	$query="UPDATE links SET position = '".$order_value."'
					WHERE id = '".$id."'";
	$db->query($query);
}
/*
- Function used in : admin / links.php
*/
function RearrangeLinks ()
{
	global $db;
	$query="SELECT id FROM links WHERE status = '1' ORDER BY position ASC";
	$db->query($query);
	$y = 0;
	$ids = array();
	while ($db->next_record())
	{
		$ids[$y] = $db->f('id');
		$y++;
	}
	$i = 20;
	foreach ($ids as $key => $val)
	{
		UpdateLinksOrder($val, $i);
		$i+=10;
	}
}
/*
- Function used in : sources / links.php
*/
function GetFrontEndLinks ($module_id, $limit)
{
	global $db;
	$get_links = array();
	$query = "SELECT * FROM links
						ORDER BY position ASC
						LIMIT ".$limit;
	$db->query($query);
	$i = 0;
	while ($db->next_record())
	{
		$get_links[$i]['id'] = $db->f('id');
		$get_links[$i]['title'] = $db->f('title');
		$get_links[$i]['link'] = $db->f('link');
		$get_links[$i]['description'] = $db->f('description');
		$get_links[$i]['position'] = $db->f('position');
		$get_links[$i]['status'] = $db->f('status');
		$i++;
	}
	return $get_links;
}
/*
- Function used in : admin / links.php
*/
function GetLinksForAdmin ()
{
	global $db;
	$get_links = array();
	$query = "SELECT * FROM links ORDER by position ASC";
	$db->query($query);
	$i = 0;
	while ($db->next_record())
	{
		$get_links[$i]['id'] = $db->f('id');
		$get_links[$i]['title'] = $db->f('title');
		$get_links[$i]['link'] = $db->f('link');
		$get_links[$i]['description'] = $db->f('description');
		$get_links[$i]['position'] = $db->f('position');
		$get_links[$i]['status'] = $db->f('status');
		$i++;
	}
	return $get_links;
}
?>