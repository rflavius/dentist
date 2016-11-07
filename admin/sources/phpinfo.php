<?php
/*------------------------------------------------------------------------------------------------
	|		dotBoost Self Managed Content | SMC Users Framework | support@dotboost.com
	+---------------------------------------------------------------------------
	|		SMC Users Framework IS NOT FREE SOFTWARE!
	+---------------------------------------------------------------------------
	|		Name : admin/photos.php
	|		Date started: Aug 3 2006
	|		Description : list, add photos ofr static pages
	|		Version : 0.9
	+---------------------------------------------------------------------------------------------*/
$tpl->set_file("tpl_main", "static/phpinfo.tpl");
$tpl->set_var("MAIN_TITLE", "PHP Information");
ob_start();
phpinfo();
$parsed = ob_get_contents();
ob_end_clean();
preg_match("#<body>(.*)</body>#is", $parsed, $match1);
$php_body = $match1[1];
# PREVENT WRAP: Most cookies
$php_body  = str_replace( "; " , ";<br />"   , $php_body );
# PREVENT WRAP: Very long string cookies
$php_body  = str_replace( "%3B", "<br />"    , $php_body );
# PREVENT WRAP: Serialized array string cookies
$php_body  = str_replace( ";i:", ";<br />i:" , $php_body );
$php_body  = str_replace( ":", ";<br>" , $php_body );
$php_body = preg_replace('#<table#', '<table class="grey" align="center"', $php_body);
$php_body = preg_replace('#<th#', '<th  class="bgmain"', $php_body);
$php_body = preg_replace('#(\w),(\w)#', '\1, \2', $php_body);
$php_body = preg_replace('#border="0" cellpadding="3" width="600"#', 'border="0" cellspacing="1" cellpadding="4" width="95%"', $php_body);
$php_body = preg_replace('#<hr />#', '', $php_body);
$tpl->set_var("PHPINFO", $php_body);
$tpl->parse("MAIN", "tpl_main");
?>