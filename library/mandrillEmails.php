<?php
/**
 * DentistOnline Application
 *
 * @copyright  Copyright (c) 2007-2016 Rosu Flavius & Luminita, DentistOnline.ro
 * @version    $Id$
 */

/**
 * mandrillEmails : here we handle the mandrill API library to send/track emails
 * @category   none
 * @package    DentistOnlineLibrary
 */
 
class mandrillEmails
{
	private $mandrill;
	private $apiKey = 'JHxkBlCuxOCLY9Pm9npwag';
	
	/**
	 * here is the contructor here we initialize the mandrill library and others
	 * @access public
	 * @param none
	 * @return void
	 */
	public function __construct()
	{
		$this->mandrill = new Mandrill($this->apiKey);
	}
	
	/**
	 * get mandrill user account info
	 * @access public
	 * @param none
	 * @return array
	 */
	public function getUserInfo()
	{
		try
		{
			$info = $this->mandrill->users->info();
			return $info;
		} 
		catch(Mandrill_Error $e)
		{
			// Mandrill errors are thrown as exceptions
			echo 'A mandrill error occurred: ' . get_class($e) . ' - ' . $e->getMessage();
			// A mandrill error occurred: Mandrill_Invalid_Key - Invalid API key
			throw $e;
		}
	}
}