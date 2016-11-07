<?php

/*
- Function used in : admin / contact_us.php
                     admin / delete.php
*/
function ContactUsMessages ($selected, $limit)
{
	global $db;
	$i = 0;
	$contact_msg = array();
	#queries
	switch ($selected)
	{
		default :
			#get form fields
			$full_fields = GetForms('-1', "");
			$fields = array();
			foreach ($full_fields as $key => $val)
			{
				$fields[$key] = "field_".$val['id'];
			}
			$query_fields = "";
			foreach ($fields as $key => $val)
			{
				$query_fields .= $val.", ";
			}
			$query = "SELECT id, ".$query_fields." date, reply, note
								FROM contact_us WHERE id = '".$selected."'";
			$db->query($query);
			$db->next_record();
			#array values
			$contact_msg['id'] = $db->f('id');
			foreach ($fields as $key => $val)
			{
				$contact_msg[str_replace("field_", "", $val)] = $db->f($val);
			}
			$contact_msg['date'] = $db->f('date');
			$contact_msg['reply'] = $db->f('reply');
			$contact_msg['note'] = $db->f('note');
		break;

		case '-1':
			$query = "SELECT id, field_1, field_2, field_3, field_4, date, reply, note
								FROM contact_us ORDER by id DESC ".$limit;
			$db->query($query);
			while ($db->next_record())
			{
				$contact_msg[$i]['id'] = $db->f('id');
				$contact_msg[$i]['name'] = $db->f('field_1');
				$contact_msg[$i]['email'] = $db->f('field_2');
				$contact_msg[$i]['subject'] = $db->f('field_3');
				$contact_msg[$i]['message'] = $db->f('field_4');
				$contact_msg[$i]['date'] = $db->f('date');
				$contact_msg[$i]['reply'] = $db->f('reply');
				$contact_msg[$i]['note'] = $db->f('note');
				$i++;
			}
		break;
	}
	return $contact_msg;
}
/*
- Function used in : admin / contact_us.php
*/
function CountMessages ()
{
	global $db;
	$query = "SELECT COUNT(id) as total_messages 
							FROM contact_us";
	$db->query($query);
	$db->next_record();
	return $db->f('total_messages');
}
/*
- Function used in : admin / contact_us.php
*/
function UpdateFollowUpNote ($note, $id)
{
	global $db;
	$query = "UPDATE contact_us SET note = '".$note."' WHERE id = '".$id."'";
	$db->query($query);
}
/*
- Function used in : admin / contact_us.php
*/
function SendReply ($reply, $id)
{
	global $db;
	$query = "UPDATE contact_us SET reply = '".$reply."' WHERE id = '".$id."'";
	$db->query($query);
	#get all the info from this user
	$message = ContactUsMessages(intval($id), '');
	#create the info for the reply message
	$subject = 'Re : '.$message['3'];
	$original_message = $message['4'];
	$name = $message['1'];
	$email = $message['2'];
	#send the reply
	Reply($subject, $name, $email, $original_message, $reply);
}
/*
- Function used in : admin / contact_us.php
*/
function ChangeField ($section, $id)
{
	global $db;
	switch ($section)
	{
		case 'used':
			$query = "UPDATE form SET used = 'Y' WHERE id = '".$id."'";
		break;

		case 'unused':
			$query = "UPDATE form SET used = 'N', required = 'N' WHERE id = '".$id."'";
		break;

		case 'required':
			$query = "UPDATE form SET required = 'Y', used = 'Y' WHERE id = '".$id."'";
		break;

		case 'unrequired':
			$query = "UPDATE form SET required = 'N' WHERE id = '".$id."'";
		break;
	}
	$db->query($query);
}
/*
- Function used in : admin / contact_us.php
*/
function GetEnumValues ($column)
{
	global $db;
	$query = "SHOW COLUMNS FROM form LIKE '".$column."'";
	$db->query($query);
	$current_row = $db->fetch_row();
	preg_match_all("/'(.*?)'/", $current_row['1'], $values);
	return $values[1];
}
/*
- Function used in : admin / contact_us.php
*/
function SaveFormField ($id, $post_values)
{
	global $db;
	$name = addslashes($post_values['name']);
	$field_type = addslashes($post_values['field_type']);
	$content_type = addslashes($post_values['content_type']);
	$option_values = addslashes($post_values['option_values']);
	$used = addslashes($post_values['used']);
	$required = addslashes($post_values['required']);
	$error_message = addslashes($post_values['error_message']);
	$query = "UPDATE form SET name = '".$name."',
														type = '".$field_type."',
														content_type = '".$content_type."',
														option_values = '".$option_values."',
														used = '".$used."',
														required = '".$required."',
														error_message = '".$error_message."'
						WHERE id = '".$id."'";
	$db->query($query);
}
/*
- Function used in : admin / contact_us.php
*/
function ReorderForms ($id, $order_type)
{
	global $db;
	$query="SELECT position FROM form WHERE `id`='".$id."'";
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
	UpdateFormOrder($id, $new_order);
}
/*
- Function used in : admin / contact_us.php
*/
function UpdateFormOrder ($id, $order_value)
{
	global $db;
	$query="UPDATE form SET position = '".$order_value."'
					WHERE id='".$id."'";
	$db->query($query);
}
/*
- Function used in : admin / contact_us.php
*/
function RearrangeForms ()
{
	global $db;
	$query="SELECT id FROM form ORDER BY position ASC";
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
		UpdateFormOrder($val, $i);
		$i+=10;
	}
}
/*
- Function used in : admin / contact_us.php
*/
function EmptyFormArray ()
{
	$array = array('id' => '', 'name' => '', 'type' => '', 'content_type' => '', 'option_values' => '', 'used' => '', 'required' => '', 'error_message' => '');
	return $array;
}
/*
- Function used in : admin / contact_us.php
*/
function InsertFormField ($post_values)
{
	global $db;
	$name = addslashes($post_values['name']);
	$field_type = addslashes($post_values['field_type']);
	$content_type = addslashes($post_values['content_type']);
	$option_values = addslashes($post_values['option_values']);
	$used = addslashes($post_values['used']);
	$required = addslashes($post_values['required']);
	$error_message = addslashes($post_values['error_message']);
	#select last position
	$query = "SELECT position FROM form ORDER by position DESC LIMIT 1";
	$db->query($query);
	$db->next_record();
	$position = $db->f("position") + 10;
	$query = "INSERT INTO form (name,
															type,
															content_type,
															option_values,
															position,
															used,
															required,
															error_message)
											VALUES ('".$name."',
															'".$field_type."',
															'".$content_type."',
															'".$option_values."',
															'".$position."',
															'".$used."',
															'".$required."',
															'".$error_message."')";
	$db->query($query);
	#get last id and alter contact_us table
	$last_id = $db->last_insert_id();
	$query = "ALTER TABLE contact_us ADD `field_".$last_id."` TEXT NOT NULL ;";
	$db->query($query);
}
?>