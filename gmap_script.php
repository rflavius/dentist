<?php
/*
 * here we get the coordonates for each cabinet and store it
 */

require('preload.php');

if(isset($_POST['resend']))
{
	$adr = $_POST['adresa']."-------------";
	echo $adr."<br>*************<br>";
	$ch = curl_init();
	// set URL and other appropriate options
	curl_setopt($ch, CURLOPT_URL, 'http://maps.googleapis.com/maps/api/geocode/json?address={'.urlencode($adr).'}&sensor=false');
	//curl_setopt($ch, CURLOPT_URL, 'http://rpc.geocoder.us/service/namedcsv?address='.urlencode($address).'&parse_address=1');
	
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	// grab URL and pass it to the browser
	$r = curl_exec($ch);
	//print_r($r);exit;
	// close cURL resource, and free up system resources
	curl_close($ch);
	$r = json_decode($r);
	$rez = $r->results;
	if(count($rez)>0)
	{
		$sql2 = "INSERT INTO cabinete_coord(`cabinet_id`,`lat`,`lng`,`judet`,`localitate`) VALUES('".$_POST['cabinet_id']."','".$r->results[0]->geometry->location->lat."','".$r->results[0]->geometry->location->lng."', '".$_POST['judet']."', '".$_POST['localitate']."')";
		$db->query($sql2);
		
		$sql3 = "UPDATE cabinete SET `done`='Y' WHERE `id`='".$_POST['cabinet_id']."'";
		$db->query($sql3);
		
		$sql4 = "SELECT id FROM cabinete WHERE `status`='1' AND `done`='N'";
		$db->query($sql4);
		
		echo 'done locatie';
		echo "<p>Mai sunt : ".$db->num_rows()." , locatii de gasit!</p>";exit;
	}
	else
	{
		$tpl = new Template(TEMPLATES_DIR);
		$tpl->set_file("tpl_index", "script.tpl");
		$tpl->set_var('ADRESA', $_POST['adresa']);
		$tpl->set_var('JUDET', $_POST['judet']);
		$tpl->set_var('LOCALITATE', $_POST['localitate']);
		$tpl->set_var('ID', $_POST['cabinet_id']);
		echo $tpl->pparse("OUTPUT", "tpl_index");
	}
}
else
{
	$cab='';
	$sql = "SELECT a.id,a.adresa_firma,a.judet,b.name FROM cabinete as a,localitati as b WHERE a.`status`='1' AND a.`done`='N' AND  a.nume_loc_sector=b.id ORDER BY id ASC LIMIT 1";
	$db->query($sql);
	if ($db->num_rows()>0)
	{
		$db->next_record();
		$cab['adresa_firma'] = $db->f('adresa_firma');
		$cab['judet'] = $db->f('judet');
		$cab['id'] = $db->f('id');
		$cab['localitate'] = $db->f('name');
	}
	
	if(is_array($cab))
	{
		$tpl = new Template(TEMPLATES_DIR);
		$tpl->set_file("tpl_index", "script.tpl");
		$tpl->set_var('ADRESA', $cab['adresa_firma'].', '.$cab['localitate'].' Romania');
		$tpl->set_var('JUDET', $cab['judet']);
		$tpl->set_var('LOCALITATE', $cab['localitate']);
		$tpl->set_var('ID', $cab['id']);
		echo $tpl->pparse("OUTPUT", "tpl_index");
		
		/*
		
		$adr = $cab['adresa_firma'];
		$ch = curl_init();
		// set URL and other appropriate options
		curl_setopt($ch, CURLOPT_URL, 'http://maps.googleapis.com/maps/api/geocode/json?address={'.urlencode($adr).'}&sensor=false');
		//curl_setopt($ch, CURLOPT_URL, 'http://rpc.geocoder.us/service/namedcsv?address='.urlencode($address).'&parse_address=1');
		
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		// grab URL and pass it to the browser
		$r = curl_exec($ch);
		//print_r($r);exit;
		// close cURL resource, and free up system resources
		curl_close($ch);
		$r = json_decode($r);
		$rez = $r->results;
		if(count($rez)>0)
		{
			$sql2 = "INSERT INTO cabinete_coord(`cabinet_id`,`lat`,`lng`,`judet`,`localitate`) VALUES('".$cab['id']."', '".$r->results[0]->geometry->location->lat."', '".$r->results[0]->geometry->location->lng."', '".$cab['judet']."', '".$cab['localitate']."')";
			$db->query($sql2);
			
			$sql3 = "UPDATE cabinete SET `done`='Y' WHERE `id`='".$cab['id']."'";
			$db->query($sql3);
			
			echo 'done';exit;
		}
		else
		{
			$tpl = new Template(TEMPLATES_DIR);
			$tpl->set_file("tpl_index", "script.tpl");
			$tpl->set_var('ADRESA', $cab['adresa_firma']);
			$tpl->set_var('JUDET', $cab['judet']);
			$tpl->set_var('LOCALITATE', $cab['localitate']);
			$tpl->set_var('ID', $cab['id']);
			echo $tpl->pparse("OUTPUT", "tpl_index");
		}*/
	}
	else
	{
		echo "WE ARE DONE WITH ALL !!!!!!!!";exit;
	}
}