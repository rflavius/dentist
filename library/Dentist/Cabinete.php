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
		$this->pacheteObj = new Pachete_Servicii($this->db);
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
	
	/**
	 * here we save the media resources for the cabinet ad
	 * @access public
	 * @param none
	 * @throws Exception
	 * @return boolean
	 */
	public function addCabinetMedia()
	{
		try
		{
			#daca avem poza pt harta o salvam:D
			if (!empty($_FILES['picture_harta']['name']))
			{
				$file_extension = $this->galleryObj->getFileExtension($_FILES['picture_harta']['name']);
				SavePicturesMap($file_extension, $this->cabinetID, "frontend" );
				unset($_FILES['picture_harta']);
			}
			### save the banner image
			if(!empty($_FILES['banner']['name']))
			{
				saveBannerCabinet($this->cabinetID);
			}
			### save the video file !!!
			if(!empty($_FILES['video']['name']))
			{
				saveVideoCabinet($this->cabinetID);
			}
			### save servicii si tarife file !!!
			if(!empty($_FILES['servicii']['name']))
			{
				saveServiciiFileCabinet($this->cabinetID);
			}
			
			$this->galleryObj->saveCabinetGallery();
			
			//SavePicturesCabinete($this->cabinetID, "frontend" );
			
			if(count($_FILES)>0)
			{
				#let's create small images for cabinet
				GenerateSmallImages($this->cabinetID);
			}
		}
		catch (Exception $e)
		{
			throw $e;
		}
		return true;
	}
	
}