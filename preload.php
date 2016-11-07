<?php

setlocale(LC_TIME, 'ro_RO');
$startTime = microtime();

// Define application path
define('APPLICATION_PATH', realpath(dirname(__FILE__)));

// Define application environment
define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

//Set error reporting
if(APPLICATION_ENV != 'production') error_reporting(-1);

//Set include  path to library directory
set_include_path(implode(PATH_SEPARATOR, array(APPLICATION_PATH . '/library', get_include_path())));

// Define PATH's (absolute paths)  to configuration, controllers, DotKernel, templates  directories
define('CONFIGURATION_PATH', APPLICATION_PATH . '/config');
define('TEMPLATES_PATH', APPLICATION_PATH . '/templates');

// Load Zend Framework
require_once 'Zend/Loader/Autoloader.php';
$zend_loader = Zend_Loader_Autoloader::getInstance();

//includes all classes in library folder. That class names must start with Web_
$zend_loader->registerNamespace('Dentist_');

// initialize the ZendFramework Enviromnment
Dentist_Init::initialize($startTime);

$registry = Zend_Registry::getInstance();

#Start counting the time nedded to display all content
$debug = new Debug;
$debug->startTimer();

#Create OLD database object
$db = api_db_connect();
$db2 = api_db_connect();

#Create config object
$conf = new Config;
$modules = new Modules;

//if (getenv('REMOTE_ADDR')=='79.119.53.166'){echo 'aaaa';exit;}
#Create session and start session object
$session_obj = new GeneralSession;
$SESSION = $session_obj->SessionStart();
#Clean array , posts and cookies
array_walk($_GET, 'array_clean');
array_walk($_POST, 'array_clean');
array_walk($_COOKIE, 'array_clean');

#create user object
$user = new User;

require('errors.php');