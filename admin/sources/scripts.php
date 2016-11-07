<?php

#first script gets all the related ids for an article
#lets take articles
$limit = " Limit 0,9";
$articles = ListAdminArticles ("all", "all", $limit);
//print_r($articles);exit;
$articles[0]['tags']='dinti';
foreach($articles as $ky => $val)
{
	$tags = $val['tags'];
	$items = array();
	$related="";$i=0; 

	echo "<br><br><br>".$val['titlu']."<br>";
	echo "<b>====================================== ".$tags." ==============================================</b><br>";

	$query = "SELECT *,MATCH (titlu,continut,tags) AGAINST ('*".$tags."*') as score FROM articles WHERE MATCH (titlu,continut,tags) AGAINST ('*".$tags."*') AND id <>'".$val['id']."' and bigcat_id='".$val['bigcat_id']."' LIMIT 6 "; 
		$db->query($query);
		while($db->next_record())
		{
			$items[$i]['id'] = $db->f('id');	
			$items[$i]['score'] = $db->f('score');
			$items[$i]['titlu'] = $db->f('titlu');
			//$items[$i]['continut'] = substr($db->f('continut'),0,300);
		
			if($items[$i]['score']>0.97)
			{
				$related = $related.$items[$i]['id'].",";
			}
			$i++;
		}
		print_r($items);
		echo "                   __________________________________________<br>";
		/*if($related!="")
		{
			$sql = "Update articles set related='".$related."' where id='".$val['id']."'";
			//echo $sql;exit;
			$db->query($sql);
		}*/
		
		echo "0000000000000000000000000000000 ".$related."0000000000000000000000000000000000000000000";
}
exit;
#let's make the situation reciproca
$limit = " Limit 0,1";
$articles = ListAdminArticles ("all", "all", $limit);
//print_r($articles);exit;
foreach($articles as $ky => $val)
{
	$rel = $val['related'];
	$get_rel=explode(",",$rel);
	foreach($get_rel as $ky => $vall)
	{
		if($vall!="" && $vall!='46')
		{
			$sql = "Update articles set related=Concat(related,'".$val['id'].",') where id='".$vall."'";
			echo $sql."<br>";
			$db->query($sql);
		}
		
	}
}
exit;

?>