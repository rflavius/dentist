<?php
/*
 * here we get the coordonates for each cabinet and store it
 */

require('preload.php');


$cab='';
$sql = "SELECT a.id,a.adresa_firma,a.judet,b.name FROM cabinete as a,localitati as b WHERE a.`done`='N' AND a.nume_loc_sector=b.id ORDER BY id ASC LIMIT 1";
$db->query($sql);
if ($db->num_rows()>0)
{
	$db->next_record();
	$cab['adresa_firma'] = $db->f('adresa_firma');
	$cab['judet'] = $db->f('judet');
	$cab['id'] = $db->f('id');
	$cab['localitate'] = $db->f('name');
	$cab['adresa_firma'] = $cab['adresa_firma'].", ".$cab['localitate'].",Romania";
}

//echo $cab['adresa_firma'] ;exit;
#means we have a cab witch is not done
if(is_array($cab))
{
	#let's take the coord from google map
	$adr = $cab['adresa_firma'];
	//echo $adr."<br>*************<br>";
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
	if(count($rez)==1)
	{
		$sql2 = "INSERT INTO cabinete_coord(`cabinet_id`,`lat`,`lng`,`judet`,`localitate`,`address`) VALUES('".$cab['id']."','".$r->results[0]->geometry->location->lat."','".$r->results[0]->geometry->location->lng."', '".$cab['judet']."', '".$cab['localitate']."', '".$r->results[0]->formatted_address."')";
		$db->query($sql2);
		
		$sql3 = "UPDATE cabinete SET `done`='Y',`gmap_status`='Y' WHERE `id`='".$cab['id']."'";
		$db->query($sql3);
	}
	else
	{
		$sql3 = "UPDATE cabinete SET `done`='Y',`gmap_status`='N' WHERE `id`='".$cab['id']."'";
		$db->query($sql3);
		//echo "not done";
	}
}
else
{
	echo "WE ARE DONE WITH ALL !!!!!!!!";exit;
}