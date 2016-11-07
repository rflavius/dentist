<?php

require('../preload.php');
//$email= "dr_lena_stoma@yahoo.com";

#now send the email
$text = GetFileContent("../templates/emails/new_cab_activat.tpl");
$CustomHeaders = '';
//$Subject = "Clinica stomatologica activata";	
$Subject = "Cabinet stomatologic activat";	
//$Subject = "Cabinet existent";	
//$Subject = "Laborator stomatologic activat";	
//$Subject = "Laborator tehnica dentara activat";	
//$Subject = "Clinica activata";
//$Subject = "Specificare";
//$Subject = "Anunt activat";

$Sender = 'Dentist Online<'.$conf->contact_recipient.'>';
$Recipiant = trim($email);
$message = new Email($Recipiant, $Sender, $Subject, $CustomHeaders);
$message->SetHtmlContent($text);
if (ValidHeader($Sender))
{
//	$message->Send();
	echo "done";
}
?>