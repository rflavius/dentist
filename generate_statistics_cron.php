<?php
/*
 * here we get the coordonates for each cabinet and store it
 */

require('preload.php');
$cab='';$i=0;
$sql = "SELECT id,phone_views,nr_visits,done FROM cabinete  WHERE `done_statistics`='N' ORDER BY id ASC LIMIT 3";
$db->query($sql);
if($db->num_rows()>0)
{
	while($db->next_record())
	{
		$cab[$i]['id'] = $db->f('id');
		$cab[$i]['phone_views'] = $db->f('phone_views');
		$cab[$i]['nr_visits'] = $db->f('nr_visits');
		$i++;
	}
	//print_r($cab);exit;
	foreach($cab as $ky => $val)
	{
		$sql = "SELECT * FROM mesaje_utilizator  WHERE id_cabinet='".$val['id']."'";
		$db->query($sql);
		$cab[$ky]['emails'] = 0;
		$nr_mesaje = $db->affected_rows();
		if($nr_mesaje!="0")
		{
			$cab[$ky]['emails'] = $nr_mesaje;
		}
		
		$sql = "INSERT INTO cabinete_statistics(`cab_id`,`phone_views`,`visitors`,`emails`,`cron_date`) VALUES('".$cab[$ky]['id']."','".$cab[$ky]['phone_views']."','".$cab[$ky]['nr_visits']."', '".$cab[$ky]['emails']."', CURDATE())";
		$db->query($sql);
		$sql = "UPDATE cabinete SET `done_statistics`='Y' WHERE `id`='".$cab[$ky]['id']."'";
		$db->query($sql);
	}
}
else
{
	
}