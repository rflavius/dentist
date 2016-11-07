<?php

require('../preload.php');
$password = md5(addslashes('zahariateh'));
echo $password ;exit;

#this script send a meeage to all form category: distribuitori materiale

$query ="Select * from cabinete where category_id='4' and status='1' and contactat='N' Limit 0,1";
$db->query($query);
$db->next_record();
$email_adr1 = strtolower(trim($db->f('email_firma')));
$email_adr2 = strtolower(trim($db->f('persc_email')));
$id_cabinet = $db->f('id');
$type_cabinet = $db->f('category_id');
$nume_firma = $db->f('nume_firma');

echo "Emailul a fost trimis la:".$email_adr1 ." ".$email_adr2;
//$email_adr1='lumy_r@yahoo.com';
//$email_adr2='lumy_r@yahoo.com';

#lets_take the content;
$text = GetFileContent("../templates/emails/mass_email.tpl");

$CustomHeaders = '';
$Sender = 'DentistOnline<'.$conf->contact_recipient.'>';
$Subject = "Achizitionare computer tomograf stomatologie";
	
if($email_adr1!=$email_adr2)
{
	
	for($i = 1; $i <=2 ; $i++)
	{
		if($i=="1")
		{
			$Recipiant = $email_adr1;
		}
		else
		{
			$Recipiant = $email_adr2;
		}
	//	echo $text;exit;
		$message = new Email($Recipiant, $Sender, $Subject, $CustomHeaders);
		$message->SetTextContent($text);
		if (ValidHeader($Sender))
		{
			$message->Send();
		}
	}
}
else
{
	#if email adreses are the same send the email to just one address
	//echo $email_adr1;
	$Recipiant = trim($email_adr1);
	$message = new Email($Recipiant, $Sender, $Subject, $CustomHeaders);
	$message->SetHtmlContent($text);
	if (ValidHeader($Sender))
	{
		$message->Send();
		$emis_fact = "Y";
		echo $email;
	}


}

$query ="Update cabinete set contactat='Y' where id='".$id_cabinet."'";
$db->query($query);
exit;

?>