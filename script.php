<?php
echo 'done';exit;

#this script update all articles off users that paid to recomandate=Y, to be displayed in te reight part
#just the articles of paid users are displayed

require('preload.php');
$get_paid_users = array();$i=0;
$sql = "Select * from cabinete where level >1 and level<>22";
$db->query($sql);

if ($db->num_rows()>0 )
{
	while($db->next_record())
	{
		$get_paid_users[$i]['id'] = $db->f('id');
		$get_paid_users[$i]['user_id'] = $db->f('user_id');
		$get_paid_users[$i]['nume_firma'] = $db->f('nume_firma');
		$i++;
	}
	
}

foreach($get_paid_users as $ky => $val)
{
	$sql = "Update articles set recomandat='Y' where user_id='".$val['user_id']."'";
	$db->query($sql);
}


?>