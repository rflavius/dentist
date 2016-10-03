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
	
	/**
	 * here we actually send the email
	 * @access public
	 * @param
	 * @return boolean
	 * @throws Mandrill_Error
	 */
	public function sendEmail()
	{
		try {
			$message = array(
								'html' => '<p>This is just an example</p>',
								'text' => 'Example text content',
								'subject' => 'example subject',
								'from_email' => 'admin@dentistonline.ro',
								'from_name' => 'DentistOnline',
								'to' => array(
												array(
																'email' => 'flavius@rospace.com',
																'name' => 'Flavius Rosu',
																'type' => 'to'
												),
												array(
																'email' => 'flavius_r2002@yahoo.com',
																'name' => 'Flavius Rosu',
																'type' => 'bcc'
												)
								),
								'headers' => array('Reply-To' => 'admin@dentistonline.ro'),
							);
			$async = false;
			$ip_pool = 'Main Pool';
			$send_at = 'example send_at';
			$result = $this->mandrill->messages->send($message);
			print_r($result);
		}
		catch(Mandrill_Error $e)
		{
			// Mandrill errors are thrown as exceptions
			echo 'A mandrill error occurred: ' . get_class($e) . ' - ' . $e->getMessage();
			// A mandrill error occurred: Mandrill_Unknown_Subaccount - No subaccount exists with the id 'customer-123'
			throw $e;
		}
	}
	
	public function getTemplateInfo($name)
	{
		try
		{
			$result = $this->mandrill->templates->info($name);
			print_r($result);
			return true;
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