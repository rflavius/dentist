<?php
/**
 * Gmap Search class
 */

class Gmap_Search
{
	
	var $userIP = '';
	var $geolocationURL = 'http://maps.googleapis.com/maps/api/geocode/json?';
	var $clientInfo = array();
	
	
	public function getUserIP()
	{
		if (getenv("HTTP_CLIENT_IP")) $ip = getenv("HTTP_CLIENT_IP");
		else
		{
			if (getenv('HTTP_X_FORWARDED_FOR'))
			{
				$ip = getenv('HTTP_X_FORWARDED_FOR');
			}
			else
			{
				$ip = getenv('REMOTE_ADDR');
			}
		}
		$this->userIP = $ip;
	}
	
	public function getCenterAreaByIP()
	{
		$this->getUserIP();
		$this->calculateLocationByIP();
		
		return $this->clientInfo['coords'];
	}

	public function getIpDetails()
	{
		$this->getUserIP();
		$this->calculateLocationByIP();
		return $this->clientInfo;

	}

	
	public function calculateLocationByIP()
	{
		echo $this->userIP;
		$details = file_get_contents("http://ipinfo.io/".$this->userIP);
		print_r($details);
		$this->clientInfo['city'] = $details->city;
		$this->clientInfo['region'] = $details->region;
		$this->clientInfo['country'] = $details->country;
		$this->clientInfo['coords'] = $details->loc;
	}
	
	public function getCliniciCabineteResults()
	{
		global $db;
		$query = "SELECT a.*,b.nume_firma,b.adresa_firma,b.fax,b.descriere,b.submision_date,b.level,c.image_name
								FROM cabinete_coord a, cabinete b, images c
								WHERE b.status = '1' AND a.cabinet_id=b.id AND a.cabinet_id=c.folder_id AND c.position='1' 
								ORDER by b.submision_date DESC";
		$db->query($query);
		if($db->num_rows()>0)
		{
			$i = 1;
			while ($db->next_record())
			{
				$cabinet[$i]['cabinet_id'] = $db->f('cabinet_id');
				$cabinet[$i]['nume_firma'] = $db->f('nume_firma');
				$cabinet[$i]['adresa_firma'] = $db->f('adresa_firma');
				$cabinet[$i]['phone'] = $db->f('fax');
				$cabinet[$i]['descriere'] = strip_tags($db->f('descriere'));
				$cabinet[$i]['judet'] = $db->f('judet');
				$cabinet[$i]['lng'] = $db->f('lng');
				$cabinet[$i]['lat'] = $db->f('lat');
				$cabinet[$i]['localitate'] = $db->f('localitate');
				$cabinet[$i]['level'] = $db->f('level');
				$cabinet[$i]['image_name'] = SITE_BASE.'/images/smallimages/cabinete/'.$db->f('cabinet_id').'/'.$db->f('image_name');
				$cabinet[$i]['submision_date'] = TimeFormatShort($db->f('submision_date'));
				$i++;
			}
		}
		return $cabinet;
	}
	
	public function getGmapCoords($adr)
	{
		// create a new cURL resource
		$ch = curl_init();
		// set URL and other appropriate options
		echo $this->geolocationURL.'address={'.urlencode($adr).'}&sensor=false';exit;
		curl_setopt($ch, CURLOPT_URL, $this->geolocationURL.'address={'.urlencode($adr).'}&sensor=false');
		//curl_setopt($ch, CURLOPT_URL, 'http://rpc.geocoder.us/service/namedcsv?address='.urlencode($address).'&parse_address=1');
		
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		// grab URL and pass it to the browser
		$r = curl_exec($ch);
		//print_r($r);exit;
		// close cURL resource, and free up system resources
		curl_close($ch);
		$r = json_decode($r);
		return $r;
	}

}