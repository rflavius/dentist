<?php
function CountUsersPerLevel($id_level,$others)
{
	global $db;
	$nr_users = 0;

	if(isset($others)&&($others!=""))
	{
			switch($others)
			{
				case 'allpackages':
						$query = "SELECT count(id) as nr_users FROM users WHERE user_level>'0' AND status='1'";
				break;
				
				case 'users':
					$query = "SELECT count(id) as nr_users FROM users WHERE user_level='0' AND status='1'";
				break;
			}
	}
	else
	{
		$query = "SELECT count(id) as nr_users FROM users WHERE user_level='".$id_level."' AND status='1'";
	}
	
	$db->query($query);
	$db->next_record();
	if($db->affected_rows()>1)
	{
		$nr_users = $db->f("nr_users");
	}
	return $nr_users;
}

function InsertMailInformations( $message, $subject, $from, $all_user_per_level)
{
global $db;
$query = " INSERT INTO mails_informations (`message`,
																						`from`,
																						`subject`,
																						`total_users`,
																						`date`)
																	VALUES ('".addslashes($message)."',
																					'".addslashes($from)."',
																					'".addslashes($subject)."',
																					'".intval($all_user_per_level)."',
																						now())";
	$db->query($query);
	return $db->last_insert_id();
}


function InsertQueryCronJob($id_info ,$query,$limit)
{
global $db;
$query = "INSERT INTO send_mails (id_info,
																	query_db,
																	limit_rows,
																	done,
																	date)
																	VALUES ('".intval($id_info)."',
																					'".addslashes($query)."',
																					'".addslashes($limit)."',
																		'N',
																		now())";
	$db->query($query);
}

function GetMessageSubject($id_mail)
{
	global $db;
	$info = array();
	$query = "SELECT * FROM mails_informations WHERE id='".$id_mail."'";
	$db->query($query);
	$db->next_record();
	if($db->affected_rows()>1)
	{
		$info['message'] = $db->f("message");
		$info['from'] = $db->f("from");
		$info['subject'] = $db->f("subject");
		$info['date'] = $db->f("date");
	}
	return $info;
}
?>