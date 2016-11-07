<?php
#judetul in baza de date este MM,B,CJ
$judet_prescurtare = "CJ";

#county name
$judet_name = "Cluj";

#means we are on the clinics category
$big_category_id = "5";

#see if everything is okk the we mark like done that cabinet
$allok = "notok";

$query_limit = " LIMIT 1";
$cabinet = GetCabinetForPromotion($big_category_id,$judet_prescurtare);
print_r($cabinet);
//exit;
//$cabinet['persc_email'] = 'lumy_r@yahoo.com';
//$cabinet['email_firma'] = 'flavius_r2002@yahoo.com';
//print_r(count($cabinet));exit;
if (count($cabinet)>0&& ($cabinet['id']!=""))
{
		$oferta_name = $cabinet['nume_firma'];
		$subject = " Buna ziua ";
		$email_content ="Buna ziua,  \n\n";
		$email_content .="Mii de vizitatori pot accesat ACUM mult mai rapid clinica ".$oferta_name.".\n\n";
		$email_content .= "Promovati la un Standard European imaginea clinicii dvs., ".$oferta_name." poate fi RECOMANDATA PE JUDETUL ".$judet_name.".\n\n";
		$email_content .= "Pentru vizualizare accesati: http://www.dentistonline.ro/Clinici-Stomatologice/Cluj.html \n\n";
		$email_content .= " Costul promovarii este de 240 RON /6 luni, 400 Ron/an.\n\n Fiecare vizitator e un posibil pacient!\n";
		$email_content .= "\n O zi frumoasa,\n Ing.Luminita Rosu \n 0727380368 \n www.dentistonline.ro\n admin@dentistonline.ro";


		$email_utilizator1 = $cabinet['persc_email'];
		$email_utilizator2 = $cabinet['email_firma'];
	
		$CustomHeaders = '';
		$sender = 'DentistOnline.ro<'.$conf->contact_recipient.'>';
		
		$Recipiant = array();
		$Recipiant[0] = $cabinet['persc_email'];		
		if(isset($email_utilizator1) && ($email_utilizator1 != $email_utilizator2))
		{
			$Recipiant[0] = $cabinet['persc_email'];		
			$Recipiant[1] = $cabinet['email_firma'];		
		}
		//echo count($Recipiant);exit;
		for($i = 0; $i < count($Recipiant) ; $i++)
		{
			$message = new Email($Recipiant[$i], $sender, $subject, $CustomHeaders);
			$message->SetTextContent($email_content);
			if (ValidHeader($sender))
			{
				$message->Send();
				$allok = "ok";
			}
		}

		if ($allok=="ok")
		{
			#lets update cabinete databesa and set don='Y'
			$sql = " Update cabinete set done='Y' where id='".$cabinet['id']."'";
			$db->query($sql);
			echo "\n Mesaj trimis catre clinica: ".$oferta_name;
		}

}
else
{
	echo "\n <br> Am terminat cu judetul ".$judet_prescurtare."<br>";
	echo "<br>Suntem pe modulul clinici";
}

exit;
?>