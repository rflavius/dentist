<?php 
/**
 * WebDesignRR Application
 * developer: Flavius Rosu
 * email: rflavius@gmail.com
 * @copyright  Copyright (c) 2003-2016
 */

/**
 * here is the cabinete library
 * @category   Dentist
 * @package    DentistLibrary
 */
 
class Dentist_Cabinete
{
	protected $cabinetID = "";
	protected $galleryObj = "";
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
		$this->galleryObj = new Dentist_Gallery();
	}
	
	/**
	 * calculate expire date adding a specific no of months to current date
	 * @access protected
	 * @param int $months
	 * @return date
	 */
	protected function calculateExpireDate($months)
	{
		$date = new DateTime();
		$date->add(new DateInterval('P'.$months.'M'));
		return $date->format('Y-m-d');
	}
	
	/**
	 * store cabinet info to DB and keep the inserted id
	 * @access public
	 * @param array $data
	 * @return void
	 */
	public function addCabinet($data)
	{
		$this->db->insert('cabinete', $data);
		$this->cabinetID = $this->db->lastInsertId();
	}
	
}