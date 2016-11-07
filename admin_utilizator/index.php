<?php
require('../preload.php');
error_reporting(2047);
ini_set('display_errors', '0');

#we require this for admin,to realese from frontend
require('../classes/admin_modules/news.inc.php');
require('../classes/admin_modules/anunturi.inc.php');
require('../classes/admin_modules/contact_us.inc.php');
require('../classes/admin_modules/massmail.inc.php');
require('../classes/admin_modules/articole.inc.php');
require('../classes/admin_modules/recomandate.inc.php');
require('../classes/admin_modules/cabinete.inc.php');
require('../classes/admin_modules/dictionar_stomatologic.inc.php');
require('../classes/admin_modules/users.inc.php');
require('../classes/admin_modules/plati.inc.php');
require('../classes/admin_utilizator/functions.php');

if(!isset($_SESSION['userinfo']->username))
{
	$_SESSION['login_error'] = 'Login incorect.Va rugam incercati din nou!';
	header('location: http://www.dentistonline.ro');
	exit;
}

$tpl = new Template(USER_ADMIN_TEMPLATES_DIR);
if (isset($_GET['page']))
{
	$tmpvar=explode('.',$_GET['page']);
	$module = $tmpvar[0];
	if (isset($tmpvar[1])) $action = $tmpvar[1]; else $action='';
	if (isset($tmpvar[2])) $param1 = $tmpvar[2]; else $param1='';
	if (isset($tmpvar[3])) $param2 = $tmpvar[3]; else $param2='';
	if (isset($tmpvar[4])) $param3 = $tmpvar[4]; else $param3='';
	if (isset($tmpvar[5])) $param4 = $tmpvar[5]; else $param4='';
}

$admin_utilizator = $_SESSION['userinfo'];
#Cheek if file exists , and display error if not
if (file_exists("sources/$module.php"))
{
	require("sources/$module.php");
}
else
{
	$tpl->set_file('tpl_main',"error.tpl");
	$tpl->set_var('ERRORMSG','The page request is invalid !');
	$tpl->parse('MAIN', 'tpl_index');
}
#get the id of the current menu
$the_module = !isset($tmpvar[0]) ? 'index.php' : $tmpvar[0];


$current_page_id = GetCurrentMenuItem($the_module, $action);
$current_parent_id = GetCurrentMenuIDUtilizator($the_module, $action);

$tpl->set_file("tpl_index", "index_user.tpl");
$tpl->set_var("SITETITLE", $conf->site_name." Panou de administartor");
$tpl->set_var('FILE_EXTENSION', FILE_EXTENSION);
$tpl->set_var('SITE_BASE', SITE_BASE);
$tpl->set_var("USERNAME", $admin_utilizator->username);
$tpl->set_block("tpl_index", "bannere_panou_administrare", "bannere_panou_administrare2");

#Begin admin menu
	$tpl->set_file('tpl_menu', 'user_menu.tpl');
	$tpl->set_block("tpl_menu", "main_menu", "main_menu2");
	$main_menu = GetMenuUtilizator(0);
	foreach($main_menu as $ky => $val)
	{
		$tpl->set_var("MAIN_MENU", $val['name']);
		if($val['id']==$current_parent_id)
		{
			$tpl->set_var("SELECTED_MENU","class='selected_menu'" );
		}
		else
		{
			$tpl->set_var("SELECTED_MENU","");
		}
		$tpl->set_var("MAIN_MENU_URL", $val['url']);
		$tpl->parse("main_menu2", "main_menu", true);
	}
	$tpl->parse("MENU", "tpl_menu", true);

#the menu for each submenu
$tpl->set_file("tpl_submenu", "user_submenu.tpl");
$tpl->set_block("tpl_submenu", "list_submenu", "list_submenu2");
$user_submenu = GetMenuUtilizator($current_parent_id);
//echo $current_parent_id;
//print_r($user_submenu);
	if(is_array($user_submenu))
	{
		foreach($user_submenu as $ky => $val)
		{
			$tpl->set_var("SUBMENU", $val['name']);
			$tpl->set_var("SUBMENU_URL", $val['url']);
			$tpl->parse("list_submenu2", "list_submenu", true);
		}
	}
	else
	{
		$tpl->parse("list_submenu2", "");
	}
	$tpl->parse("MENU_2", "tpl_submenu");
#lets parse the banners from admin panel
/*$array_banners = array (array(link_url => "http://www.dentalog.ro",banner => "dentalog.jpg",banner_id=>"406"), 
						array(link_url => "http://www.qdental.ro",banner => "qdental_uti.jpg",banner_id=>"163"),
						array(link_url => "http://www.vizualdent.ro",banner => "vizualdent.jpg",banner_id=>"404"));
 shuffle ($array_banners);*/

 $array_banners = array(array(link_url => "http://www.qdental.ro",banner => "qdental_uti.jpg",banner_id=>"163"),array(link_url => "http://www.dentistonline.ro/Evenimente-Medicale/Curs-esential-de-stratificare-pe-zona-frontala.html",banner => "curs-stratificare.jpg",banner_id=>"553"));
//print_r($array_banners);
foreach($array_banners as $ky => $val)
{
	//echo $ky;
	//print_r($val);
	$tpl->set_var("LINK_TO_SITE", $val['link_url']);
	$tpl->set_var("BANNER_IMAGE_NAME", $val['banner']);
	$tpl->set_var("BANNER_ID", $val['banner_id']);
	$tpl->parse("bannere_panou_administrare2", "bannere_panou_administrare", true);
}



$tpl->set_var('LINK_BEYOND',$_GET['page'] );
#row backgound
$tpl->set_var("B1", "row1");
$tpl->set_var("B2", "row2");

#table settings
$tpl->set_var("CP", CELLPADDING);
$tpl->set_var("CS", CELLSPACING);

#finally we parse the output
$tpl->pparse("OUTPUT", "tpl_index");
?>