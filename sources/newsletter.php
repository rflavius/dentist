<?php

require('../preload.php');
//$email= "dentistonline@dentistonline.ro";
//echo md5('1test1');
#now send the email
//$email= "rflavius@gmail.com";
$text = GetFileContent("../templates/emails/newsletter.tpl");
print_r($text);exit;
$CustomHeaders = '';
//$Subject = "Clinica stomatologica activata";	
$Subject = "RoDentExpo si Denta 2009 ";	
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
	$message->Send();
	echo "done";
}
echo $text;
?>