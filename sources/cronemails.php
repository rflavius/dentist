<?php

require('../preload.php');
//$password = md5(addslashes('zahariateh'));
echo $password ;exit;



$query ="Select * from cabinete where done='N' and recomandata='N' and user_id>'0' Limit 0,1";
$db->query($query);
$db->next_record();
$email_adr1 = strtolower(trim($db->f('email_firma')));
$email_adr2 = strtolower(trim($db->f('persc_email')));
$id_cabinet = $db->f('id');
$type_cabinet = $db->f('category_id');
$nume_firma = $db->f('nume_firma');

$email_adr1='dentistonline.info@yahoo.com';
$email_adr2='rflavius2@gmail.com';


	#lets_take the content;
	$text = GetFileContent("../templates/emails/recomandat.tpl");
	switch($type_cabinet)
	{
		case '1':
			$text = str_replace("%TYPE%",	"Cabinetul tau - ".$nume_firma ." - poate fi recomandat!" , $text);
			$text = str_replace('%TYPE_PLURAL%',	"cabinete" , $text);
			$Subject = "Cabinetul tau ".$nume_firma ." recomandat ";	
		break;
		case '2':
			$text = str_replace("%TYPE%",	"Laboratorul tau - ".$nume_firma ." -  poate fi recomandat !" , $text);
		  $text = str_replace("%TYPE_PLURAL%",	"laboratoare" , $text);
			$Subject = "Laboratorul tau ".$nume_firma ." recomandat ";	
		break;
		case '':
			
		break;
		case '3':
			$text = str_replace("%TYPE%",	"Laboratorul tau - ".$nume_firma ." -  poate fi recomandat !" , $text);
		$text = str_replace("%TYPE_PLURAL%",	"laboratoare" , $text);
			$Subject = "Laboratorul tau ".$nume_firma ." recomandat ";	
		break;
		case '4':
			$text = str_replace("%TYPE%",	"Depozitul tau - ".$nume_firma ." -  poate fi recomandat !" , $text);
			$text = str_replace("%TYPE_PLURAL%",	" distribuitori" , $text);
			$Subject = "Depozitul tau ".$nume_firma ." recomandat ";	
		break;

		case '5':
			$text = str_replace("%TYPE%",	"Clinica ta - ".$nume_firma ." -  poate fi recomandata !" , $text);
		$text = str_replace("%TYPE_PLURAL%",	"clinici" , $text);
			$Subject = "Clinica ta ".$nume_firma ." recomandata ";	
		break;
	}


	$CustomHeaders = '';
	$Sender = 'DentistOnline<'.$conf->contact_recipient.'>';
	
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
	echo $email_adr1;
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
$query ="Update cabinete set done='Y' where id='".$id_cabinet."'";
$db->query($query);
exit;

	/*$query ="Select * from unique_emails where sent='N'Limit 0,1";
	$db->query($query);
	$db->next_record();
	$id_email =$db->f('id');
	
	//$email= trim($db->f('email'));
	//echo $email;
	$email = "muresanm2001@yahoo.co.uk";

	#now send the email
	//$text = GetFileContent("../templates/emails/cron_send_mail.tpl");
	$text = GetFileContent("../templates/emails/proforma.tpl");
	$CustomHeaders = '';
	//$Subject = "Promovare online GRATUITA!";	
	$Subject = "Factura Proforma!";	
	$Sender = 'DentistOnline.ro<'.$conf->contact_recipient.'>';
	$Recipiant = trim($email);
	$message = new Email($Recipiant, $Sender, $Subject, $CustomHeaders);
	$message->SetHtmlContent($text);
	if (ValidHeader($Sender))
	{
		$message->Send();
		$emis_fact = "Y";
		echo $email;
	}exit;
	$query ="Update unique_emails set sent='Y',date_send=now(),subject_gratuit='Y' where id='".$id_email."'";
	$db->query($query);*/

?>