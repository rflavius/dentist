<?php


/*
- Function used in : sources / sitemap.php
*/
function SitemapModules ()
{
	global $db;
	$query = "SELECT * FROM modules WHERE `sitemap` = 'Y' AND `active`='1'";
	$db->query($query);
	$modules = array();
	$i = 0;
	while ($db->next_record())
	{
		if(($db->f('link')!="anunturi.emailtrimis")&&($db->f('link')!="anunturi.trimitemail"))
		{
			$modules[$i]['id'] = $db->f('id');
			$modules[$i]['name'] = $db->f('name');
			$modules[$i]['link'] = $db->f('link');
			$modules[$i]['type'] = $db->f('type');
			$modules[$i]['active'] = $db->f('active');
			$modules[$i]['support'] = $db->f('support');
			$i++;	
		}
	}
	return $modules;
}
/*
- Function used in : sources / sitemap.php
*/
function SitemapPages ()
{
	global $db;
	$pages = array();
	$query = "SELECT * FROM pages WHERE `active` = '1' AND `sitemap` = 'Y'";
	$db->query($query);
	$i = 0;
	while ($db->next_record())
	{
		$pages[$i]['id'] = $db->f('id');
		$pages[$i]['name'] = $db->f('name');
		$pages[$i]['link'] = $db->f('link');
		$pages[$i]['meta_keywords'] = $db->f('meta_keywords');
		$pages[$i]['meta_description'] = $db->f('meta_description');
		$pages[$i]['active'] = $db->f('active');
		$i++;
	}
	return $pages;
}
?>