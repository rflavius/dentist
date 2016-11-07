<?php

#php settings
	error_reporting(2047);
	//set_magic_quotes_runtime(0);
	
	if (getenv('REMOTE_ADDR')=='79.119.53.166')
	{
	ini_set('display_errors', '1');
	}
	else
	{
		ini_set('display_errors', '0');
	}
#front-end usage variables
	define('TEMPLATES_DIR', './templates');
	define('SSL_TEMPLATES_DIR', '../templates');
#admin panel usage variables
	define('CELLSPACING', '1');
	define('CELLPADDING', '4');
	define('ADMIN_TEMPLATES_DIR', '../templates/admin');
	define('FB_TEMPLATES_DIR', './templates/facebook');
	define('USER_ADMIN_TEMPLATES_DIR', '../templates/admin_utilizator');


#License Version
	define('LICENSE_VERSION', 'v0.9');
#File Extension
	define('FILE_EXTENSION', '.html');
	define('SITE_BASE', 'http://www.dentistonline.ro');
	define('SSL_SITE_BASE', 'https://www.dentistonline.ro');
	
	
	
?>