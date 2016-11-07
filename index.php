<?php
/*------------------------------------------------------------------------------------------------
	|		dotBoost Self Managed Content | SMC Users Framework | support@dotboost.com
	+---------------------------------------------------------------------------
	|		SMC Users Framework IS NOT FREE SOFTWARE!
	+---------------------------------------------------------------------------
	|		Name : index.php
	|		Date started: Aug 3 2006
	|		Description : this is were all the magic happens
	|		Version : 0.9
	+---------------------------------------------------------------------------------------------*/

//echo 'Pagina este in lucru. Va rugam reveniti, multumim';exit;
// define application path
define('APPLICATION_PATH', realpath(dirname(__FILE__)));

require(APPLICATION_PATH.'/preload.php');

#Create OLD database object
$db = api_db_connect();
$db2 = api_db_connect();

if(isset($_GET['reff']) && !empty($_GET['reff']))
{
	$redirection_type = (isset($_GET['type']) && !empty($_GET['type'])) ? $_GET['type'] : '';
	switch ($redirection_type)
	{
		default:
			// this is when someone gets back from emails...folowing his cab page
			redirectToCabinetFromEmail($_GET['reff']);
		break;
		
		case 'feedback':
			$_SESSION['feedback']['email'] = $_GET['email'];
			$_SESSION['feedback']['name'] = $_GET['name'];
			header("Location: ".ReWrite("default","pagina-feedback"));
			exit;
		break;
	}
}

$tpl = new Template(TEMPLATES_PATH);

#Start URL route
Dentist_Init::setRoute();

$module = (!empty($registry->route['module'])) ? $registry->route['module'] : '' ;
$action = (!empty($registry->route['action'])) ? $registry->route['action'] : '' ;
$param1 = (!empty($registry->route['param1'])) ? $registry->route['param1'] : '' ;
$param2 = (!empty($registry->route['param2'])) ? $registry->route['param2'] : '' ;
$param3 = (!empty($registry->route['param3'])) ? $registry->route['param3'] : '' ;
$param4 = (!empty($registry->route['param4'])) ? $registry->route['param4'] : '' ;
$param5 = (!empty($registry->route['param5'])) ? $registry->route['param5'] : '' ;
$param6 = (!empty($registry->route['param6'])) ? $registry->route['param6'] : '' ;

$module = basename(stripslashes($module));

if (file_exists("./sources/$module.php"))
{
	#if the curent page is cabinet's details
	if ($module == "cabinete" && $action == "detalii")
	{
		$section = 'cabinete';
		$cabinet_id = $param1;
	}
	elseif((isset($param1))&&($module=="news" && $param1!=""))
	{
		$section = 'module';
		$news_alias = str_replace(".html","",$param1);
		$cabinet_id = GetNewsIdByAlias($news_alias);
	}
	else
	{
		$section = 'module';
		$cabinet_id = "";
	}
	#create the filename with parameters
	if ($action != "")
	{
		$file_name = $module.'.'.$action;
	}
	else
	{
		$file_name = $module;
	}

	#now use function
	Dentist_Init::$published = FilePublished($file_name, $section, $cabinet_id);
	if (Dentist_Init::$published)
	{
		require("./sources/$module.php");
	}
	else
	{
		#display error message
		$tpl->set_file('tpl_main', 'unpublished.tpl');
		$tpl->set_var('ERRORMSG', 'Aceasta pagina nu este disponibila');
		$tpl->parse('MAIN', 'tpl_main');
	}
}
else
{
	#if the page is just static grab the content here - parse later
	$template_content = PageExists($module);
	if (count($template_content) != 0)
	{
		#see if it is published of not
		$file_name = $module;
		Dentist_Init::$published = FilePublished($file_name, 'page', "");
		if (Dentist_Init::$published)
		{
			$page_to_display = $template_content[0];
		}
		else
		{
			#display error message
			$tpl->set_file('tpl_main','unpublished.tpl');
			$tpl->set_var('ERRORMSG','The page has been unpublished !');
			$tpl->parse('MAIN', 'tpl_main');
		}
	}
	else FakeError (); #stop execution
}

Dentist_Init::gallop();


$tpl->set_var("PAGEGENERATE", "Pagina generata in <b>".$debug->endTimer()."</b> secunde, folosind <b>".$db->get_query_count()."</b> query.");

## developer IP for development mode..here we track and debug !!!!
if($_SERVER['REMOTE_ADDR']=='79.119.43.154')
{
	//echo $db->debug_html();
}

#parse the output
$tpl->parse("OUTPUT", "tpl_index");
$tpl->p("OUTPUT");
?>