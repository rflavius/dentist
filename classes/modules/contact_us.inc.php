<?php


/*
- Function used in : admin / contact_us.php
                     classes / emails / system_emails.php
                     sources / contact.php
*/
function GetForms ($id, $used)
{
	global $db;
	switch ($id)
	{
		default :
			$query = "SELECT * FROM form WHERE id = '".intval($id)."'";
		break;

		case '-1':
			$condition = "";
			switch ($used)
			{
				case 'active':
					$condition = "WHERE used = 'Y'";
				break;
			}
			$query = "SELECT * FROM form ".$condition." ORDER BY position ASC";
		break;
	}
	$db->query($query);
	$forms = array();
	$i = 0;
	while ($db->next_record())
	{
		$forms[$i]['id'] = $db->f('id');
		$forms[$i]['name'] = $db->f('name');
		$forms[$i]['type'] = $db->f('type');
		$forms[$i]['content_type'] = $db->f('content_type');
		$forms[$i]['option_values'] = $db->f('option_values');
		$forms[$i]['used'] = $db->f('used');
		$forms[$i]['required'] = $db->f('required');
		$forms[$i]['error_message'] = $db->f('error_message');
		$i++;
	}
	return $forms;
}

/*
- Function used in : sources / contact.php
*/
function GetOptionValues ($id)
{
	global $db;
	$query = "SELECT option_values FROM form WHERE id = '".intval($id)."'";
	$db->query($query);
	$db->next_record();
	$values = explode(",", $db->f("option_values"));
	foreach ($values as $key => $val)
	{
		$new_values[$key] = trim($val);//remove whitespaces from left and right of text
	}
	return $new_values;
}
/*
- Function used in : sources / contact.php
*/
function VerifyContent ($content_type, $post_value)
{
	if (trim($post_value) == "")
	{
		#the field is empty
		return 'error';
	}
	#if the filed is not empty verify the content (exclude plain text and password)
	switch ($content_type)
	{
		case 'email':
			if (!ValidEmail($post_value))
			{
				#not a valid email
				return 'error';
			}
		break;

		case 'numeric':
			if (!is_numeric($post_value))
			{
				return 'error';
			}
		break;
	}
}
/*
- Function used in : sources / contact.php
*/
function StripFieldTags ($old_array)
{
	foreach ($old_array as $key_option => $val_option)
	{
		$new_key = str_replace("field_", "", $key_option);
		$new_array[$new_key] = $val_option;
	}
	return $new_array;
}
/*
- Function used in : classes / emails / system_emails.php
*/
function ValidHeader ($value)
{
	$neg_values = array("\r\n", "\n", "to:", "bcc:", "cc:", "reply-to:");
	foreach ($neg_values as $key => $val)
	{
		if (eregi($val, $value)){return false;}
	}
	return true;
}
?>