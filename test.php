<?php
/**
 * here we will test the mandrill library
 */

require_once('vendor/autoload.php');

$allowedIPs = array('89.34.170.32');
if(!in_array($_SERVER['REMOTE_ADDR'], $allowedIPs))
{
	die('NOT allowed !');
}

$m = new Mandrill('JHxkBlCuxOCLY9Pm9npwag');
print_r($m);exit;

require_once 'library/mandrillEmails.php';
$email = new mandrillEmails();

print_r($email->getUserInfo());