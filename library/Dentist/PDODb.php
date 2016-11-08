<?php 
/**
 * WebDesignRR Application
 * developer: Flavius Rosu
 * email: rflavius@gmail.com
 * @copyright  Copyright (c) 2003-2015
 */

/**
 * here we track the PDO errors and send them by email
 * @category   Dentist
 * @package    Library
 */

class Dentist_PDODb extends Zend_Db_Adapter_Pdo_Mysql
{
	/**
	 * Wrapper function for query method
	 * @access public
	 * @param string|Zend_Db_Select $sql
	 * @param array $bind - an array of data to bind to the placeholders.
	 * @return Zend_Db_Pdo_Statement
	 * @throws send an email with the error.
	 */
	public function query($sql, $bind = array())
	{
		try
		{
			return parent::query($sql, $bind);
		}
		catch (Exception $e)
		{
			// send an email warning with the error
			$this->sendDeveloperEmailWarning($e);
			die('We will be back later. Thank you.');
		}
	}
	/**
	 * send warning email with the PDO error
	 * @access public
	 * @param object $error - an Exception object for the error
	 * @return void
	 */
	public function sendDeveloperEmailWarning($error)
	{
		if (isSet($_SERVER))
		{
			if (isSet($_SERVER["HTTP_X_FORWARDED_FOR"]))
			{$realip = $_SERVER["HTTP_X_FORWARDED_FOR"];}
			elseif (isSet($_SERVER["HTTP_CLIENT_IP"]))
			{$realip = $_SERVER["HTTP_CLIENT_IP"];}
			else
			{$realip = $_SERVER["REMOTE_ADDR"];}
		}
		else
		{
			if ( getenv( 'HTTP_X_FORWARDED_FOR' ) )
			{$realip = getenv( 'HTTP_X_FORWARDED_FOR' );}
			elseif ( getenv( 'HTTP_CLIENT_IP' ) )
			{$realip = getenv( 'HTTP_CLIENT_IP' );}
			else
			{$realip = getenv( 'REMOTE_ADDR' );}
		}
		
		$user_ip = $realip;
		$user_agent = $_SERVER["HTTP_USER_AGENT"];
		$request_uri  = $_SERVER["REQUEST_URI"];
		$request_referer  = $_SERVER["HTTP_REFERER"];
		$date_now = date("l dS of F Y h:i:s A");
		
		if(APPLICATION_ENV!='development')
		{
			$mailFrom = "admin@dentistonline.ro";
			$mailTo = "flavius@rospace.com";
			$mailSubject = "PDO Error at DentistOnline";
			$mailHeader = "From: ".$mailFrom."\r\n" .
									"Reply-To:".$mailFrom."\r\n" .
									"X-Mailer: PHP/".phpversion();
			$mailContent = <<<MMAIL
PDO ERROR ar: {$date_now} 
		
Error: {$error->getMessage()}
Error Full Message: {$error->getTraceAsString()}
		
Request page: {$request_uri}
Referer : {$request_referer}
		
User IP: {$user_ip}
User Agent: {$user_agent}
		
		
MMAIL;
			//send email
			mail($mailTo,$mailSubject,$mailContent,$mailHeader);
		}
		else
		{
			// this is for localhost
			echo $error->getMessage()."<br>";
			echo $error->getTraceAsString();
		}
		
	}
}

