<?php
switch ($action )
{
	case 'send':
	$db = new Db_Sql();
	if (isset($_POST))
	{
		if($param1!="single")
		{

			#it means we have users from levels to send mail
			if (($_POST['destination'] == '1')||($_POST['destination'] == '2')||($_POST['destination'] == '3'))
			{
				$query = "Select * from users where status='1' and user_level='".$_POST['destination']."'";
				$id_level = $_POST['destination'];
				$others = "";
			}
			elseif($_POST['destination']=="allpackages")
			{
				$query = "Select * from users where status='1' and user_level>'0'";
				$id_level = "";
				$others = "allpackages";
			}
			elseif($_POST['destination']=="users")
			{
					$query = "SELECT * FROM users WHERE user_level='0' AND status='1' ORDER BY id";
					$id_level = "";
					$others = "users";
			}

			
			#count all users
			$all_user_per_level = CountUsersPerLevel($id_level,$others);
			$all_user_per_level = 100;
			
			#first time let's insert the message, subject,from
			$id_info = InsertMailInformations( $_POST['message'],$_POST['subject'],$_POST['from'],$all_user_per_level);

			#let's insert informations into send_mails table
			$rows_to_insert = ceil($all_user_per_level/$conf->nr_emails_send_once);
			$x=0;
			for($i = 0; $i < $rows_to_insert; $i++)
			{
				$limit = $x + $conf->nr_emails_send_once;
				InsertQueryCronJob($id_info ,$query,$limit);	
				$x = $x+$conf->nr_emails_send_once; 
			}
	
			$type="mass";
			header("location: ?page=massmail.sent.".$type);
		}
		else
		{	$type = "single";
			$Sender = $conf->contact_recipient;
			$Recipiant = trim($_POST['destination']);
			$CustomHeaders = '';
			$Subject = trim($_POST['subject']);
			$text = GetFileContent("../templates/emails/normal_email.tpl");
			$text = str_replace("%MESAJ%",	nl2br($_POST['message']) , $text);
			$text = str_replace("%FINAL_MESSAJE%",	$_POST['final_message'] , $text);
			
			$message = new Email($Recipiant, $Sender, $Subject, $CustomHeaders);
			$message->SetHtmlContent($text);
			if (ValidHeader($Sender))
			{
				$message->Send();
			}
			header("location: ?page=massmail.sent.".$type);exit;
		}
	
	}
	break;

	case 'sent':
		$tpl->set_file('tpl_main', $module.'/'.$action.'.tpl');
		$tpl->set_var('SENT_MSG',"The ".$param1." mail was successfully sent !" );
		$tpl->parse('MAIN', 'tpl_main');
	break;

	case 'single':
		$tpl->set_file('tpl_main', $module.'/'.$action.'.tpl');
		$tpl->set_var('MAIN_TITLE','Send Single Mail');
		$tpl->set_var('DEF_FROM', $conf->contact_recipient);
		$tpl->parse('MAIN', 'tpl_main');
	break;

	case 'mass':
		$tpl->set_file('tpl_main', $module.'/'.$module.'.tpl');
		$tpl->set_var('MAIN_TITLE','Send Mail on a Group');
		$tpl->set_var('DEF_FROM', $conf->site_email);
		$tpl->parse('MAIN', 'tpl_main');
	break;
}
?>