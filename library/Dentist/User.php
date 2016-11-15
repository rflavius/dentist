<?php 
/**
 * WebDesignRR Application
 * developer: Flavius Rosu
 * email: rflavius@gmail.com
 * @copyright  Copyright (c) 2003-2016
 */

/**
 * here is the user module
 * @category   Dentist
 * @package    DentistLibrary
 */
 
class Dentist_User extends Dentist_Cabinete
{
	/*
	 * the construct method here we initialize the DB and conf objects
	 * @access public
	 * @param none
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}
	
	/**
	 * here we check if the submitted info for the new add are valid or not
	 * @access public
	 * @param int $step
	 * @param array $data
	 * @return boolean
	 */
	public function validNewAdd($step, $data)
	{
		try
		{
			switch ($step)
			{
				case '1':
					$array_obligatorii = array(
												"category_id" => "Categoria nu e setata",
												"nume_firma" => "Numele firmei nu e setat",
												"adresa_firma" => "Adresa firmei nu e setata",
												"judet" => "Judetul nu e setat",
												"nume_loc_sector" => "Localitate/sector nu e setat",
												"pers_contact" => "Persoana de contact nu e setata",
												"persc_email" => "Adresa de email persoana contact nu e setata");
					foreach($data as $ky => $val)
					{
						if((array_key_exists($ky, $array_obligatorii)) && empty($val))
						{
							throw new Exception($array_obligatorii[$ky]);
						}
					}
					if(!empty(CheckNumeFirma($data['nume_firma']))) throw new Exception('Acest nume de firma exista deja in baza noastra de date.');
					
					$this->galleryObj->validateFile($data['file'], 'map_file');
				break;
				
				case '2':
					$array_obligatorii = array(
												"orar" => "Nu ati introdus orarul",
												"descriere" => "Descrierea unitatii nu e setata");
					foreach($data as $ky => $val)
					{
						if((array_key_exists($ky, $array_obligatorii)) && empty($val))
						{
							throw new Exception($array_obligatorii[$ky]);
						}
					}
					
					$this->galleryObj->validateFile($data['servicii_file'], 'servicii_file');
					$this->galleryObj->validateFile($data['video_file'], 'video_file');
					$this->galleryObj->validateFile($data['banner_file'], 'banner_file');
					$this->galleryObj->validateFile($data['gallery_file'], 'gallery_file');
				break;
			}
		} 
		catch (Exception $e)
		{
			$_SESSION['error']['type'] = 'error';
			$_SESSION['error']['message'] = $e->getMessage();
			return false;
		}
		return true;
	}
	
	public function saveNewAdd()
	{
		try
		{
			if(empty($_SESSION['userinfo'])) throw new Exception('Sesiunea dvs a expirat va rugam sa va autentificati din nou.');
			
			$data = array(
							'nume_firma' => $_POST['nume_firma'], 
							'user_id' => $_SESSION['userinfo']->id, 
							'submision_date' => new Zend_Db_Expr('NOW()'), 
							'meta_description' => $this->conf->def_meta_description, 
							'meta_keywords' => $this->conf->def_meta_keywords, 
							'type' => $_POST['type'], 
							'expire_date' => $this->calculateExpireDate($_POST['perioada']), 
							'alias' => GenerateAlias($_POST['nume_firma']));
			$this->addCabinet($data);
			
		}
		catch (Exception $e)
		{
			$_SESSION['error']['type'] = 'error';
			$_SESSION['error']['message'] = $e->getMessage();
			return false;
		}
		return true;
	}
}