<?php
/*
* here we have all the methods for marketing class
*/

class Marketing
{
	function __construct($d)
	{
		$this->db = $d;
	}
	/*
	 * check if we have this cabinet into contacte
	 */
	public function contactAlreadyExists($id)
	{
		$sql = "SELECT * FROM cabinete_marketing WHERE `cabinet_id`='$id'";
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
}