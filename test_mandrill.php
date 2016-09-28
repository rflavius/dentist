<?php
/**
 * here we will test the mandrill library
 */

require_once 'library/mandrillEmails.php';

$email = new mandrillEmails();
print_r($email->getUserInfo());