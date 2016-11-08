<?php
/*
* here we have all the methods for pachete class
*/

class Pachete_Servicii
{
	function __construct($d)
	{
		$this->db = $d;
		$this->dbPDO = Zend_Registry::get('database');
	}
	
	/**
	 * here we list pachete from DB for frontend use
	 * @access public
	 * @param optional string $frontend
	 * @return array
	 */
	public function listPacheteFrontend($frontend = false)
	{
		$select = $this->dbPDO->select()
								->from('pachete')
								->where('active = ?', 'Y')
								->order('id');
		if($frontend!==false) $select->where('frontend = ?', 'Y');
		else $select->where('luni = ?', '12');
		$results = $this->dbPDO->fetchAll($select);
		return $results;
	}
	/*
	 * here we list pachete from DB for backend use
	*/
	public function listPacheteBackend()
	{
		$info = array();
		$sql = "SELECT * FROM pachete ORDER BY id";
		$this->db->query($sql);
		if($this->db->num_rows()>0)
		{
			$i=0;
			while ($this->db->next_record())
			{
				$info[$i]['id'] = $this->db->f('id');
				$info[$i]['name'] = $this->db->f('name');
				$info[$i]['servicii'] = $this->db->f('servicii');
				$info[$i]['pret'] = $this->db->f('pret');
				$info[$i]['active'] = $this->db->f('active');
				$info[$i]['luni'] = $this->db->f('luni');
				$i++;
			}
		}
		return $info;
	}
	
	/*
	 * list servicii from DB
	 */
	public function listServiciiFrontend()
	{
		$sql = "SELECT * FROM servicii WHERE `active`='Y' ORDER BY position";
		$this->db->query($sql);
		if($this->db->num_rows()>0)
		{
			$i=0;
			while ($this->db->next_record())
			{
				$info[$i]['id'] = $this->db->f('id');
				$info[$i]['name'] = $this->db->f('name');
				$info[$i]['description'] = $this->db->f('description');
				$info[$i]['value'] = $this->db->f('value');
				$info[$i]['price'] = $this->db->f('price');
				$i++;
			}
		}
		return $info;
	}
	
	/*
	 * list servicii from DB
	*/
	public function listServiciiBackend()
	{
		$sql = "SELECT * FROM servicii ORDER BY position";
		$this->db->query($sql);
		if($this->db->num_rows()>0)
		{
			$i=0;
			while ($this->db->next_record())
			{
				$info[$i]['id'] = $this->db->f('id');
				$info[$i]['name'] = $this->db->f('name');
				$info[$i]['description'] = $this->db->f('description');
				$info[$i]['value'] = $this->db->f('value');
				$info[$i]['price'] = $this->db->f('price');
				$info[$i]['active'] = $this->db->f('active');
				$i++;
			}
		}
		return $info;
	}
	
	/*
	 * list servicii care sunt contra cost
	 */
	public function listServiciiPreferentiale()
	{
		$sql = "SELECT * FROM servicii WHERE `price`<>'0' ORDER BY position";
		$this->db->query($sql);
		if($this->db->num_rows()>0)
		{
			$i=0;
			while ($this->db->next_record())
			{
				$info[$i]['id'] = $this->db->f('id');
				$info[$i]['name'] = $this->db->f('name');
				$info[$i]['description'] = $this->db->f('description');
				$info[$i]['value'] = $this->db->f('value');
				$info[$i]['price'] = $this->db->f('price');
				$info[$i]['active'] = $this->db->f('active');
				$i++;
			}
		}
		return $info;
	}
	
	/*
	 * here we get all servicii for the selected pk
	 */
	public function listPachetServicii($id)
	{
		$sql = "SELECT servicii FROM pachete WHERE `id`='$id'";
		$this->db->query($sql);
		while ($this->db->next_record())
		{
			$serv = $this->db->f('servicii');
		}
		
		$s = explode(";",$serv);
		$info='';
		$i=0;
		foreach($s  as $ky => $val)
		{
			if($val!='')
			{
				$info[$i] = $this->getServiciuInfo($val);
				$i++;
			}
		}
		return $info;
	}
	
	/*
	 * this is used for the details page
	 * and here we check if a service is in the customer package
	 */
	public function checkIfServiciuAvailable($servs,$str)
	{
		$found = false;
		foreach($servs as $ky => $val)
		{
			if(stristr($val['name'],$str)!==false)
			{
				$found = true;
			}
		}
		return $found;
	}
	
	/*
	 * here we get serviciu info
	 */
	public function getServiciuInfo($id)
	{
		$sql = "SELECT * FROM servicii WHERE `id`='$id'";
		$this->db->query($sql);
		$this->db->next_record();
		$info['id'] = $this->db->f('id');
		$info['name'] = $this->db->f('name');
		$info['description'] = $this->db->f('description');
		$info['value'] = $this->db->f('value');
		$info['price'] = $this->db->f('price');
		$info['active'] = $this->db->f('active');
		$info['position'] = $this->db->f('position');
		return $info;
	}
	
	/*
	 * update the pachet status
	 */
	public function updatePachetStatus($st,$id)
	{
		$query = "UPDATE `pachete` SET `active` = '".$st."' WHERE `id` = '".$id."'";
		$this->db->query($query);
	}
	
	/*
	 * update the serviciu status
	*/
	public function updateServiciuStatus($st,$id)
	{
		$query = "UPDATE `servicii` SET `active` = '".$st."' WHERE `id` = '".$id."'";
		$this->db->query($query);
	}
	
	/*
	 * remove selected pachet
	 */
	public function removePachet($id)
	{
		$sql = "DELETE FROM pachete WHERE `id`='$id'";
		$this->db->query($sql);
	}
	
	/*
	 * remove selected serviciu
	 */
	public function removeServiciu($id)
	{
		$sql = "DELETE FROM servicii WHERE `id`='$id'";
		$this->db->query($sql);
	}
	
	/**
	 * here we get all the info for the selected pachet
	 * @access public
	 * @param int $id
	 * @return array
	 */
	public function getPachetInfo($id)
	{
		$select = $this->dbPDO->select()
								->from('pachete')
								->where('id = ?', $id);
		$result = $this->dbPDO->fetchRow($select);
		return $result;
	}
	
	/**
	 * check if a given pachet id is free
	 * @access public
	 * @param int $id
	 * @return boolean
	 */
	public function ifPachetFree($id)
	{
		if(!empty($id))
		{
			$select = $this->dbPDO->select()
									->from('pachete', 'pret')
									->where('id = ?', $id);
			$result = $this->dbPDO->fetchOne($select);
			if($result != '0') return false;
			else return true;
		}
		else return true;
	}
	
	/*
	 * here we make the edit upon pachet level
	 */
	public function updatePachet($id)
	{
		$serv_sql='';
		foreach($_POST['servicii'] as $ky=>$val)
		{
			if($val!='')
			{
				$serv_sql.= $val.";";
			}
		}
		$sql = "UPDATE pachete SET `name`='".addslashes($_POST['name'])."', `pret`='".$_POST['pret']."', `servicii`='$serv_sql', `luni` = '".$_POST['luni']."' WHERE `id`='$id'";
		$this->db->query($sql);
	}
	
	/*
	 * here we make the edit upon serviciu level
	*/
	public function updateServiciu($id)
	{
		$sql = "UPDATE servicii SET 
								`name`='".addslashes($_POST['name'])."', 
								`price`='".$_POST['price']."', 
								`description`='".addslashes($_POST['description'])."', 
								`value` = '".$_POST['value']."' 
							WHERE `id`='$id'";
		$this->db->query($sql);
	}
	
	/*
	 * add new pachet
	 */
	public function addPachet()
	{
		$serv_sql='';
		if(isset($_POST['servicii']))
		{
			foreach($_POST['servicii'] as $ky=>$val)
			{
				if($val!='')
				{
					$serv_sql.= $val.";";
				}
			}
		}
		$sql = "INSERT INTO pachete(`name`, `pret`, `servicii`,`luni`) VALUES ('".addslashes($_POST['name'])."', '".$_POST['pret']."', '".$serv_sql."','".$_POST['luni']."')";
		$this->db->query($sql);
	}
	
	/*
	 * add new serviciu
	*/
	public function addServiciu()
	{
		$sql = "INSERT INTO pachete(`name`, `price`, `description`, `value`) 
							VALUES ('".addslashes($_POST['name'])."', 
									'".$_POST['price']."',
									'".addslashes($_POST['description'])."',
									'".$_POST['value']."')";
		$this->db->query($sql);
	}
	
	/*
	 * return servicii for pachet in array object
	 */
	public function getPachetServiciiToArray($id)
	{
		$pk = $this->getPachetInfo($id);
		$serv = explode(";",$pk['servicii']);
		foreach($serv as $ky=>$val)
		{
			if($val=='')
			{
				unset($serv[$ky]);
			}
		}
		return $serv;
	}
	
	/*
	 * here we insert the coords into DB
	 */
	public function addCabinetCoords($id)
	{
		$sql = "INSERT INTO cabinete_coord(`cabinet_id`, `lat`, `lng`, `judet`, `localitate`) VALUES ('$id','".$_POST['lat']."','".$_POST['lng']."','".$_POST['judet']."','".$_POST['nume_loc_sector']."')";
		$this->db->query($sql);
	}
	
	/*
	 * check if he has free package
	 */
	public function hasFreePackage($id,$cab_id)
	{
		$sql = "SELECT * FROM users_pachete WHERE user_id='$id' AND pachet='1' AND `cabinet_id`<>'$cab_id'";
		$this->db->query($sql);
		if($this->db->num_rows()>0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public function addPachetAndServicii($uid,$cid)
	{
		$sql = "INSERT INTO users_pachete(`user_id`, `cabinet_id`, `pachet`, `servicii`, `pret`) VALUES ('$uid','$cid','".$_POST['pachet']."','".$_POST['servicii']."','".$_POST['total']."')";
		$this->db->query($sql);
	}
	
	/*
	 * update/change/edit pachet for a selected cabinet
	 */
	public function updatePachetAndServicii($post)
	{
		$sql = "UPDATE users_pachete SET `pachet`='".$post['firma_pachet']."', `servicii`='".$post['firma_servicii']."', `pret`='".$post['total']."' WHERE `cabinet_id`='".$post['cabinet_id']."'";
		$this->db->query($sql);
	}
	
	/*
	 * add pachet si servicii for old client
	 */
	public function addFreeClientPachetAndServicii($post)
	{
		$sql = "INSERT INTO users_pachete(`user_id`, `cabinet_id`, `pachet`, `servicii`, `pret`, `achitat`, `start_date`, `end_date`)
							VALUES('".$post['user_id']."', '".$post['cabinet_id']."', '".$post['firma_pachet']."', '".$post['firma_servicii']."','".$post['total']."','Y',NOW(),'')";
		$this->db->query($sql);
	}
	
	/*
	 * 
	 */
	public function updateUserPacheteFromProforma($id)
	{
		$get_info_proforma = GetInfoProforma($id);
		
		$sql = "UPDATE users_pachete SET `pachet`='".$get_info_proforma['tip_promovare']."', `servicii`='".$get_info_proforma['servicii_promovare']."', `pret`='".$get_info_proforma['cost']."' WHERE `cabinet_id`='".$get_info_proforma['firma_id']."'";
		$this->db->query($sql);
	}
	
	/*
	 * 
	 */
	public function insertUserPacheteFromProforma($id)
	{
		$get_info_proforma = GetInfoProforma($id);
		$end = date("Y-m-d", mktime(0, 0, 0, date("m")+$get_info_proforma['perioada'], date("d")+3, date("Y")));
		$tomorrow = date("Y-m-d",mktime(0, 0, 0, date("m"), date("d")+1, date("Y")));
		
		$sql = "INSERT INTO `users_pachete`(`user_id`, `cabinet_id`, `pachet`, `servicii`, `pret`, `achitat`, `start_date`, `end_date`)
							 VALUES('".$get_info_proforma['user_id']."',
							 		'".$get_info_proforma['firma_id']."',
							 		'".$get_info_proforma['tip_promovare']."',
							 		'".$get_info_proforma['servicii_promovare']."',
							 		'".$get_info_proforma['cost']."',
							 		'Y',
							 		'$tomorrow',
							 		'$end')";
		$this->db->query($sql);
	}
	
	/*
	 * 
	 */
	public function getRecomandatServiceId()
	{
		$sql = "SELECT id FROM servicii WHERE name LIKE 'Recomandat%'";
		$this->db->query($sql);
		$this->db->next_record();
		return $this->db->f('id');
	}
	
	/*
	 * 
	 */
	public function getTipPromovare($cab_id)
	{
		$info = '';
		$sql = "SELECT * FROM users_pachete WHERE cabinet_id='$cab_id' and pret <>'0'";
		$this->db->query($sql);
		if($this->db->num_rows()>0)
		{
			$this->db->next_record();
			$info['id'] = $this->db->f('id');
			$info['user_id'] = $this->db->f('user_id');
			$info['cabinet_id'] = $this->db->f('cabinet_id');
			$info['pachet'] = $this->db->f('pachet');
			$info['servicii'] = $this->db->f('servicii');
			$info['pret'] = $this->db->f('pret');
		}
		return $info;
	}
	
	/*
	 * this we use in list articels and anunturi to see witch user still pays and who's free
	 */
	public function getTipPromovareByUser($user_id)
	{
		$info = '';
		$sql = "SELECT * FROM users_pachete WHERE user_id='$user_id' and end_date > CURDATE() ";
		$this->db->query($sql);
		if($this->db->num_rows()>0)
		{
			$this->db->next_record();
			$info['id'] = $this->db->f('id');
			$info['user_id'] = $this->db->f('user_id');
			$info['cabinet_id'] = $this->db->f('cabinet_id');
			$info['pachet'] = $this->db->f('pachet');
			$info['servicii'] = $this->db->f('servicii');
			$info['pret'] = $this->db->f('pret');
		}
		return $info; 
	}
	
	/*
	 * 
	 */
	public function listFreeServicii()
	{
		$sql = "SELECT id FROM servicii WHERE price='0' AND active='Y'";
		$this->db->query($sql);
		$i=0;
		while ($this->db->next_record())
		{
			$info[$i]['id'] = $this->db->f('id');
			$i++;
		}
		return $info;
	}
	
	/*
	 * check if it has recomandat in his package
	 */
	public function hasRecomandat($pk)
	{
		$servicii = $this->listPachetServicii($pk);
		$servs = '';
		foreach($servicii as $ky => $val)
		{
			$servs.=",".$val['id'];
		}
		$serviciu_recomandat = $this->getRecomandatServiceId();
		if(stristr($servs,$serviciu_recomandat)!==false)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	/**
	 * get default package ID
	 * @access public
	 * @param none
	 * @return int
	 */
	public function defaultPachetID()
	{
		$select = $this->dbPDO->select()
								->from('pachete', 'id')
								->where('default_view = ?', 'Y');
		return $this->dbPDO->fetchOne($select);
	}
	
	/**
	 * get pachet gratuit ID
	 * @access public
	 * @param none
	 * @return int
	 */
	public function getFreePackageID()
	{
		$select = $this->dbPDO->select()
								->from('pachete', 'id')
								->where('frontend = ?', 'Y')
								->where('price = ?', '0');
		return $this->dbPDO->fetchOne($select);
	}
	
	/**
	 * get package ID for details view
	 * @access public
	 * @param int $id
	 * @return mixed array|int
	 */
	public function getPromovareView($cab_level)
	{
		//echo $cab_level;
		$last_day_of_free = date('Y-m-d');
		$today = date('Y-m-d');
		
		if($this->ifPachetFree($cab_level) || empty($cab_level))
		{
			if($cab_level=="22")
				return $cab_level;

			if($today >= $last_day_of_free) 
				return $this->defaultPachetID();
		}
		else 
		{
			return $cab_level;
		}
	}
}
