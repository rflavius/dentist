<?php
/**
 * here we will test the mandrill library
 */

$allowedIPs = array('89.34.170.32');
if(!in_array($_SERVER['REMOTE_ADDR'], $allowedIPs))
{
	die('NOT allowed !');
}

require_once('vendor/autoload.php');
require_once 'library/mandrillEmails.php';

$email = new mandrillEmails();
$tpl_name = 'joinUS v2.0';
//$email->getTemplateInfo($tpl_name);
$email->sendTemplateEmail($tpl_name);