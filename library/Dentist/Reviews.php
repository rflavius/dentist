<?php 
/**
 * WebDesignRR Application
 * developer: Flavius Rosu
 * email: rflavius@gmail.com
 * @copyright  Copyright (c) 2003-2015
 */

/**
 * here is the gallery module
 * @category   Dentist
 * @package    DentistLibrary
 */

class Dentist_Reviews
{
	public $limit = 3;
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
	
	/**
	 * list reviews
	 * @access public
	 * @param none
	 * @return array
	 */
	public function listReviews()
	{
		$select = $this->db->select()
							->from('reviews')
							->order('date desc');
		$results = $this->db->fetchAll($select);
		return $results;
	}
	
	/**
	 * list random reviews
	 * @access public
	 * @param none
	 * @return array
	 */
	public function listRandomReviews()
	{
		$select = $this->db->select()
							->from('reviews')
							->order('RAND()')
							->limit($this->limit);
		$results = $this->db->fetchAll($select);
		return $results;
	}
	
}