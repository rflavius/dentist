<?php
/*
- Function used in : sources / news.php
-                  : admin / news.php
-                  : admin / delete.php
-                  : classes / general_functions.inc.php
*/
function GetNews ($display, $limit)
{
	global $db;
	$get_news = array();
	switch ($display)
	{
		#for the admin edit
		default:
			$query = "SELECT * FROM news WHERE id = '".$display."'";
		break;
		#all for admin
		case '-1':
			$query = "SELECT * FROM news ORDER by position ASC";
		break;
		#for the main pages or news page
		case '0':
			switch ($limit)
			{
				default :
					$query = "SELECT * FROM news WHERE status = '1' ORDER by position ASC
										LIMIT ".$limit;
				break;

				case '0':
					$query = "SELECT * FROM news WHERE status = '1' ORDER by position ASC";
				break;
			}
		break;
	}
	//echo $query;
	$db->query($query);
	$i = 0;
	while ($db->next_record())
	{
		$get_news[$i]['id'] = $db->f('id');
		$get_news[$i]['title'] = $db->f('title');
		$get_news[$i]['content'] = $db->f('content');
		$get_news[$i]['meta_keywords'] = $db->f('meta_keywords');
		$get_news[$i]['meta_description'] = $db->f('meta_description');
		$get_news[$i]['submision_date'] = $db->f('submision_date');
		$get_news[$i]['position'] = $db->f('position');
		$get_news[$i]['imagine'] = $db->f('imagine');
		$get_news[$i]['alias'] = $db->f('alias');
		$get_news[$i]['status'] = $db->f('status');
		$get_news[$i]['location'] = $db->f('Place');
		$get_news[$i]['event_date'] = TimeFormatEvents($db->f('event_date'));
		$get_news[$i]['event_date2'] = $db->f('event_date');
		$i++;
	}
	return $get_news;
}
#used in front end
function GetNewsIdByAlias($alias)
{
	
	global $db;
	$query = "SELECT id FROM news
						WHERE alias = '".trim($alias)."'";

	$db->query($query);
	$db->next_record();
	return $db->f('id');

}

function CountNewsTotalRecords ()
{
	global $db;
	$query = "SELECT * FROM news where status='1'";
	$db->query($query);
	return $db->num_rows();
}

?>