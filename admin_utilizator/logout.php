<?php
/*-------------------------------------------------------------------------------------------------
	|		dotBoost Self Managed Content | SMC Users Framework | support@dotboost.com
	+---------------------------------------------------------------------------
	|		SMC Users Framework IS NOT FREE SOFTWARE!
	+---------------------------------------------------------------------------
	|		Name : admin/logout.php
	|		Date started: Aug 3 2006
	|		Description : admin logout
	|		Version : 0.9
	+----------------------------------------------------------------------------------------------*/
require('../preload.php');
session_unset();
session_destroy();
header("location: index.php");
exit;
?>