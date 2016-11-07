<?php
/**
 * WebDesignRR Application
 * developer: Flavius Rosu
 * email: rflavius@gmail.com
 * @copyright  Copyright (c) 2003-2015
 */

/**
 * here is the gmap module
 * @category   Dentist
 * @package    DentistLibrary
 */
 

class Dentist_Gmap
{
	
	var $userIP = '';
	var $geolocationURL = 'http://maps.googleapis.com/maps/api/geocode/json?';
	var $clientInfo = array();
	
	/*
	 * the construct method here we initialize the DB and conf objects
	 * @access public
	 * @param none
	 * @return void
	 */
	public function __construct()
	{
		$this->db = Zend_Registry::get('database');
		$this->conf = Zend_Registry::get('settings');
	}
	
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
	
	/**
	 * here we get results for the gmap search
	 * @access public
	 * @param none
	 * @return array
	 */
	public function getCliniciCabineteResults()
	{
		$select = $this->db->select()
							->from(array('b' => 'cabinete'), array('b.nume_firma', 'b.adresa_firma', 'b.fax', 'b.descriere', 'b.submision_date', 'b.level'))
							->join(array('a' => 'cabinete_coord'), "a.cabinet_id = b.id", array('a.lat', 'a.lng','a.localitate','a.judet'))
							->join(array('c' => 'images'), "a.cabinet_id=c.folder_id", array('c.image_name'))
							->where('b.status = ?', '1')
							->where('c.position = ?', '1')
							->order('b.submision_date DESC');
		$results = $this->db->fetchAll($select);
		return $results;
	}
	
	/**
	 * here we count how many cabinete has the gmap coords made
	 * @access public
	 * @param optional string $status
	 * @return int
	 */
	public function countCabineteCoordonate($status = false)
	{
		$select = $this->db->select()
							->from('cabinete', 'id');
		if($status!==false) $select->where('gmap_status = ?', $status);
		return count($this->db->fetchAll($select));
	}
	
	/**
	 * here we list cabinete that has the gmap coords made
	 * @access public
	 * @param array $limit
	 * @param string|boolean $status
	 * @return array
	 */
	public function listCabineteCoordonate($limit, $status)
	{
		$select = $this->db->select()
							->from(array('a' => 'cabinete'), array('a.id', 'a.nume_firma', 'a.gmap_status'))
							->joinLeft(array('b' => 'cabinete_coord'), "a.id=b.cabinet_id", array("b.address", 'b.lat', 'b.lng', 'coord_id' => 'b.id'))
							->order('a.id asc')
							->limit($limit[0], $limit[1]);
		if($status!==false) $select->where('a.gmap_status = ?', $status);
		return $this->db->fetchAll($select);
	}
	
	/**
	 * here we select the cabinet we want to generate coords for
	 * @access public
	 * @param int $id
	 * @return array
	 */
	public function selectCabinetToGenerateCoords($id)
	{
		$select = $this->db->select()
							->from(array('a' => 'cabinete'), array('a.id','a.adresa_firma','a.judet'))
							->join(array('b' => 'localitati'), "a.nume_loc_sector = b.id", array("localitate" => "b.name"))
							->where('a.id = ?', $id);
		$results = $this->db->fetchRow($select);
		return $results;
	}
	
	public function getCabinetGmap($id)
	{
		$select = $this->db->select()
							->from('cabinete_coord')
							->where('cabinet_id = ?', $id);
		$results = $this->db->fetchRow($select);
		return $results;
	}
	
	/**
	 * add GMAP location for cabinet
	 * @access public
	 * @param array $data
	 * @return boolean
	 */
	public function addCabinetCoordonates($data)
	{
		$this->db->insert('cabinete_coord', $data);
		return true;
	}
	
	/**
	 * here we update cabinete Gmap coords
	 * @access public
	 * @param array $data
	 * @param array $where
	 * @return boolean
	 */
	public function updateCabineteCoordonates($data, $where)
	{
		$this->db->update('cabinete_coord', $data, $where);
		return true;
	}
	
	/**
	 * update cabinet info
	 * @access public
	 * @param array $data
	 * @param array $where
	 * @return boolean
	 */
	public function updateCabinet($data, $where)
	{
		$this->db->update('cabinete', $data, $where);
		return true;
	}
	
	/**
	 * delete record from gmap coords
	 * @access public
	 * @param array $where
	 * @return boolean
	 */
	public function deleteCoordonate($where)
	{
		$this->db->delete('cabinete_coord', $where);
		return true;
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