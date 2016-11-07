<?php
require('../preload.php');
$today = date("Y-m-d");
$get_info=array();
$i=0;
#we send just one oance
$query ="Select a.id,a.user_id ,a.adaugare_proforma,a.expirare_proforma,a.nume_firma,b.category_id from facturi_proforme as a,cabinete as b where a.firma_id=b.id and Date_Sub(a.expirare_proforma, INTERVAL 3 DAY) ='".$today."' and a.achitat='N' and a.warning_email='N' Limit 0,1";
$db->query($query);

if($db->affected_rows()>0)
{
	$db->next_record();
	$get_info['id_proforma'] = $db->f('id');
	$get_info['user_id'] = $db->f('user_id');
	$get_info['adaugare_proforma'] = AdminTimeFormat($db->f('adaugare_proforma'),'Y');
	$get_info['expirare_proforma'] = AdminTimeFormat($db->f('expirare_proforma'),'Y');
	$get_info['nume_firma'] = $db->f('nume_firma');
	$get_info['type_firma'] = $db->f('category_id');
	switch($get_info['type_firma'])
	{
		case '1':
			$typefirma=" cabinetul stomatologic ";
		break;
		case '2':
			$typefirma="laboratorul de tehnica dentara";
		break;
		case '3':
			$typefirma="laboratorul de radiologie";
		break;
		case '4':
			$typefirma="depozitul de materiale stomatologice";
		break;
		case '5':
			$typefirma="clinica stomatologica";
		break;
	}

		
	
	#for proforma lest take some info and send mail to user
	$sql="Select * from users where id='".$get_info['user_id']."'";
	$db->query($sql);
	$db->next_record();
	$get_info['email'] = $db->f('email');
	$get_info['first_name'] = $db->f('first_name');
	$get_info['last_name'] = $db->f('last_name');

	#now send the email
	$text = GetFileContent("../templates/emails/factura_proforma_expira.tpl");
	$text = str_replace("%NUME_PERS_CONTACT%",	ucfirst($get_info['first_name'])." ".ucfirst($get_info['last_name']) , $text);
	$text = str_replace("%NUMAR_FACTURA_PROFORMA%",$get_info['id_proforma'], $text);
	$text =str_replace("%EXPIRARE_FACTURA_PROFORMA%",$get_info['expirare_proforma'] ,$text); 
	$text = str_replace("%DATA_EMITERII%",$get_info['adaugare_proforma'],$text);
	$text = str_replace("%NUME_FIRMA%",ucfirst($get_info['nume_firma']),$text);
	$text = str_replace("%TYPE_FIRMA%",$typefirma,$text);
	$CustomHeaders = '';
	$Subject = "Factura proforma expira ";	
	$Sender = 'DentistOnline.ro<'.$conf->contact_recipient.'>';
	$Recipiant = trim($get_info['email']);
	$message = new Email($Recipiant, $Sender, $Subject, $CustomHeaders);
	$message->SetHtmlContent($text);
	if (ValidHeader($Sender))
	{
		$message->Send();
		$emis_fact = "Y";
	}
	$query="Update facturi_proforme set warning_email='Y' where id='".$get_info['id_proforma'] ."'";
	$db->query($query);
}


?>