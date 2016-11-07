<?php
/*------------------------------------------------------------------------------------------------
	|		dotBoost Self Managed Content | SMC Users Framework | support@dotboost.com
	+---------------------------------------------------------------------------
	|		SMC Users Framework IS NOT FREE SOFTWARE!
	+---------------------------------------------------------------------------
	|		Name : system_emails.php
	|		Date started: Aug 3 2006
	|		Description : e-mails are sent from here
	|		Version : 0.9
	+---------------------------------------------------------------------------------------------*/
#Contact us
function Contact ($post_values)
{
	$referer = $post_values['referer'];
	global $conf;
	#add all to the database for safe keeping
	global $db;
	#with the post array do some changes before adding to the database : were the array values are arrays implode the into strings separated by comma
	//array_pop($post_values);
	foreach ($post_values as $key => $val)
	{
		if (is_array($val))
		{
			$key_values = implode(", ", $val);
			$post_values[$key] = $key_values;
		}
	}
	#foreach of the keys create the specific section of the database query, and email
	$query_start = "INSERT into contact_us (";
	$query_table_fields = "";
	$query_fields_values = "";
	$email_content = "";
	//var_dump($post_values);exit;
	foreach ($post_values as $key => $val)
	{
		#database content
		$query_table_fields .= "field_".$key.", ";
		$query_fields_values .= "'".addslashes($val)."', ";
		#email content
		$email_form = GetForms($key, "");
		$email_content .= "<b>".$email_form[0]['name']." : </b>".$val."<br />";
		#get the email of the sender
		if ($key == "2"){$email = $val;}
		#get the subject
		if ($key == "3"){$subject = $val;}
	}
	#additional info for the database
	$query_table_fields .= "user_ip, user_agent, date, referer";
	$query_fields_values .= "'".addslashes(GetUserIP())."','".addslashes(GetUserAgent())."', now(),'".addslashes($referer)."'";
	#compute query
	$query = $query_start.$query_table_fields.") VALUES (".$query_fields_values.")";
	$db->query($query);
	#get the template file for the message
	$text = GetFileContent('./templates/emails/contact_us.tpl');
	#replace the tags with the info
	$text = str_replace("%EMAIL_CONTENT%", $email_content, $text);
	$text = str_replace("%USER_IP%", GetUserIP(), $text);
	$text = str_replace("%USER_AGENT%", GetUserAgent(), $text);
	$text = str_replace("%REFERER%", $referer, $text);
	$Sender = $email;
	$Recipiant = $conf->contact_recipient;
	$CustomHeaders = '';
	#send text email
	$Subject = $subject;
	$message = new Email($Recipiant, $Sender, $Subject, $CustomHeaders);
	$message->SetHtmlContent($text);
	if (ValidHeader($Sender))
	{
		$message->Send();
	}
	return $text;
}

#Send warning email to admin if somebody tries to enter the admin panel and fails
function SendAdminWarning()
{
	global $conf;
	global $_POST;
	global $admin;
	# body of the email
	$text = "FAILURE LOGIN at ".$conf->admin_link_to_site." Admin Panel!!! \n";
	$text.= "***************************** \n";
	$text.= "Username:  ".$_POST['user']."\n";
	$text.= "Password:  ".$_POST['pass']."\n";
	$text.= "User IP:  ".$admin->ip."\n";
	$text.= "User_Agent:  ".$admin->user_agent."\n";
	$text.= "Date:  ".date('l F-j-Y H:i:s')."\n";
	$text.= "***************************** \n";
	#send email to admin
	$Sender = 'Admin <'.$conf->admin_email.'>';
	$Recipiant = $conf->admin_email;
	$CustomHeaders ='';

	$Subject = 'Failure Login on '.$conf->admin_link_to_site;
	$message = new Email($Recipiant, $Sender, $Subject, $CustomHeaders);
	$message->SetTextContent($text);
	$message->Send();
}

#Send reply to user's contact email
function Reply ($subject, $name, $email, $original_message, $reply)
{
	global $conf;
	#get the template file for the reply message
	$text = GetFileContent('../templates/emails/admin_reply.tpl');
	#replace the tags with the info
	$text = str_replace("%REPLY%", stripslashes($reply), $text);
	$text = str_replace("%NAME%", stripslashes($name), $text);
	$text = str_replace("%EMAIL%", stripslashes($email), $text);
	$text = str_replace("%ORIGINAL_MESSAGE%", stripslashes($original_message), $text);
	#send email
	$Sender = 'Admin <'.$conf->admin_email.'>';
	$Recipiant = $email;
	$CustomHeaders ='';

	$Subject = $subject;
	$message = new Email($Recipiant, $Sender, $Subject, $CustomHeaders);
	$message->SetHtmlContent($text);
	$message->Send();
}
?>