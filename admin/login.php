<?php
/*-------------------------------------------------------------------------------------------------
	|		dotBoost Self Managed Content | SMC Users Framework | support@dotboost.com
	+---------------------------------------------------------------------------
	|		SMC Users Framework IS NOT FREE SOFTWARE!
	+---------------------------------------------------------------------------
	|		Name : admin/login.php
	|		Date started: Aug 3 2006
	|		Description : admin login
	|		Version : 0.9
	+----------------------------------------------------------------------------------------------*/
require('../preload.php');
session_destroy ();
$tpl = new Template(ADMIN_TEMPLATES_DIR);
$tpl->set_file("tpl_index", "index.tpl");
$tpl->set_var("SITETITLE", "Please Login ");
$tpl->set_var("HEADERTEXT", " Admin Panel ");
$get_ip = GetUserIP();
if($get_ip=="89.123.13.145")
{
	die();
}
#main panel
$tpl->set_file("tpl_main", "login.tpl");
if ((isset($_POST['user'])) && (isset($_POST['pass'])) && ($_POST['user'] != ''))
{
	$admin = new Admin;
	$admin->ip = GetUserIP();

	$admin->user_agent = $_SERVER['HTTP_USER_AGENT'];
	if(($admin->Login($_POST['user'],$_POST['pass'], GetUserIP()) == '1'))
	{
		#optimize all tables
		//$db->optimize();

		########## empty the sessions DB table !
		## delete all records from previous months, kip only the records for this month !
		$sql = "DELETE FROM sessions WHERE YEAR(`expire`)='".date('Y')."' AND MONTH(`expire`)<'".date('m')."'";
		$db->query($sql);

		session_start();
		$_SESSION['admin'] = $admin;
		#daca face logarea sa facem si update la tabela de facturi proforme:)
		UpdateStatusFacturiProforme();
		//UpdateDataAdaugariiMagazinTerapeutic();
		header("Location: index.php");
		exit;
	}
	else 
	{
		SendAdminWarning();
		unset($_SESSION['admin']);
		header("Location: index.php");
		exit;
	}
}
else
{
	$tpl->set_var("MAINTEXT", "Admin Panel Login");
	$tpl->set_var("IPADDRESS", GetUserIP());
	$tpl->parse("MAIN", "tpl_main");
}
#don't display the help icon
//$tpl->set_block('tpl_index', 'help', 'help_box');
#finally we parse the output
$tpl->pparse("OUTPUT", "tpl_index");
?>