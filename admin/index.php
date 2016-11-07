<?php
require('../preload.php');
error_reporting(2047);
set_magic_quotes_runtime(0);
ini_set('display_errors', '1');
//echo md5('2daniel2');//57b7ba8dd82976284febeb7c784cd731

//echo md5('1lumi1');


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




if(!isset($_SESSION['admin']->username))
{
	header("Location: login.php");
	exit;
}
$tpl = new Template(ADMIN_TEMPLATES_DIR);
if (isset($_GET['page']))
{
	$tmpvar=explode('.',$_GET['page']);
	$module = $tmpvar[0];
	if (isset($tmpvar[1])) $action = $tmpvar[1]; else $action='';
	if (isset($tmpvar[2])) $param1 = $tmpvar[2]; else $param1='';
	if (isset($tmpvar[3])) $param2 = $tmpvar[3]; else $param2='';
	if (isset($tmpvar[4])) $param3 = $tmpvar[4]; else $param3='';
	if (isset($tmpvar[5])) $param4 = $tmpvar[5]; else $param4='';
	if (isset($tmpvar[6])) $param5 = $tmpvar[6]; else $param5='';
}
else
{
	$module = 'static';
	$action = 'home';
}
$admin = $_SESSION['admin'];


switch($admin->level)
{
	case '1':
		####### this is for admin
	break;

	case '2':
		######## this is for marketing area

	break;
}


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

		$current_page_id = GetCurrentMenuItem($the_module, $action,$admin->level);
		$tpl->set_file("tpl_index", "index.tpl");
		$tpl->set_var("SITETITLE", $conf->site_name." Admin Control Panel");
		$tpl->set_var('FILE_EXTENSION', FILE_EXTENSION);
		$tpl->set_var("COMPANY_NAME", $conf->site_name);
		#front panel
		$tpl->set_file("tpl_top_menu", "top_menu.tpl");
			$tpl->set_var("USERNAME", $admin->username);
			$tpl->set_var("USERTYPE", getAdminType($admin->level));
			$tpl->set_var("LASTLOGIN", AdminTimeFormat($admin->last_login, 'N'));
			$tpl->set_var("LINK_TO_SITE", $conf->admin_link_to_site);
			$tpl->set_var('LINK_TO_SITE_NAME', $conf->admin_link_name_to_site);
		$tpl->parse("TOP_MENU", "tpl_top_menu");
		#Begin admin menu
		$tpl->set_file('tpl_menu', 'menu.tpl');
		$tpl->set_block('tpl_menu', 'sub_menu', 'sub_menu_block');
		$tpl->set_block('tpl_menu', 'menu', 'menu_block');
		$getmenu = GetMenu(0,$admin->level);
		while (list($k, $v) = each($getmenu))
		{
			$tpl->set_var('MENU_TITLES', $v['name']);
			$getsubmenu = GetMenu($v['id'],$admin->level);
			while (list($kl, $vl) = each($getsubmenu))
			{
				$tpl->set_var('SELECTED_MENU_ITEM', '');
				if ($vl['id'] == $current_page_id)
				{
					$tpl->set_var('SELECTED_MENU_ITEM', '-selected');
				}
				$tpl->set_var('MENU_LINK_TEXT', $vl['name']);
				$tpl->set_var('MENU_LINK', $vl['link']);
				$tpl->parse('sub_menu_block', 'sub_menu', true);
			}
			$tpl->parse('menu_block', 'menu', true);
			$tpl->parse('sub_menu_block', '');
		}
		$tpl->parse('LEFT_MENU', 'tpl_menu');


		#the menu for each submenu
		require('modulesubmenu.php');






#row backgound
$tpl->set_var("B1", "row1");
$tpl->set_var("B2", "row2");

#table settings
$tpl->set_var("CP", CELLPADDING);
$tpl->set_var("CS", CELLSPACING);

#copyright
$tpl->set_file("tpl_copy", "copyright.tpl");
$tpl->set_var('LICENSE_LINK', $conf->license_url);
$tpl->set_var("LICENSE_NAME", $conf->license_name);
$tpl->set_var("LICENSE_VERSION", LICENSE_VERSION);
$tpl->parse("COPYRIGHT", "tpl_copy");
#From here we shall parse the title and the content for the help box
//$tpl->set_block('tpl_index', 'help', 'help_box');
#create the page name (link) for the help table
$help_link = $module;
if (!is_numeric($action) && $action != "") {$help_link = $module.'.'.$action;}
if (!is_numeric(@$param1) && @$param1 != "") {$help_link = $help_link.'.'.$param1;}
$tpl->set_var("COMPANY_LINK", $conf->company_link);
#End counting generated time , and query count
$tpl->set_var("PAGEGENERATE", "page generated in <strong>".$debug->endTimer()."</strong> seconds, using <strong>".$db->get_query_count()."</strong> queries.");
#finally we parse the output
$tpl->pparse("OUTPUT", "tpl_index");
?>