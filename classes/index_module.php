<?php
/*------------------------------------------------------------------------------------------------
	|		dotBoost Self Managed Content | SMC Users Framework | support@dotboost.com
	+---------------------------------------------------------------------------
	|		SMC Users Framework IS NOT FREE SOFTWARE!
	+---------------------------------------------------------------------------
	|		Name : sources/fetch_module.php
	|		Date started: Nov 2 2006
	|		Description : get _GET vars , adn include chosen module
	|		Version : 0.9
	+---------------------------------------------------------------------------------------------*/

if (isset($_GET['p']))
{

		$test_link = $_GET['p'];
		$check = CheckLink($test_link);
		if($check['response']=="Y")
		{
			header( "HTTP/1.1 301 Moved Permanently" );
			header("location: ".$check['new_url'] );
			exit;
		}

	if(stristr($_GET['p'],'admin_utilizator')!=FALSE)
	{
		$_GET['p'] = str_replace("admin_utilizator/","",$_GET['p']);
	}
		
	if ($conf->url_rewrite_mode == 'N')
	{
		$tmpvar = explode('.',$_GET['p']);
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
			
			if(strpos($_GET['p'],"/")!==FALSE)
			{
				$tmpvar = explode('/',$_GET['p']);
				//var_dump($tmpvar);exit;
				$module = $tmpvar[0];
				if((isset($tmpvar[1]))&&(($tmpvar[1]=='trimitemail')||(($tmpvar[1]=='emailtrimis'))))
				{
					$module = $tmpvar[0];
					$action = $tmpvar[1];
					
				}
				else
				{
						$get_module_link = GetModuleLinkByAlias($module);
						$first_part = explode('.',$get_module_link);
						$module = $first_part[0];
						if(isset( $first_part[1])&&( $first_part[1]!=""))
						{			$action = $first_part[1];		}
						else
						{	$action="";	}
				}
					if (isset($tmpvar[1])) $param1 = $tmpvar[1]; else $param1='';
					if (isset($tmpvar[2])) $param2 = $tmpvar[2]; else $param2='';
					if (isset($tmpvar[3])) $param3 = $tmpvar[3]; else $param3='';
					if (isset($tmpvar[4])) $param4 = $tmpvar[4]; else $param4='';
					if (isset($tmpvar[5])) $param5 = $tmpvar[5]; else $param5='';
					if (isset($tmpvar[6])) $param6 = $tmpvar[6]; else $param6='';
			}
			else
			{
					
					$whitouthtml = str_replace(".html","",$_GET['p']);
					$get_module_link = GetModuleLinkByAlias($whitouthtml);
					if(count($get_module_link)>0)
					{
							$first_part = explode('.',$get_module_link);
							$module = $first_part[0];
							if(isset($first_part[1])&&($first_part[1]!=""))
							{	$action = $first_part[1];	}
							else
							{	$action="";	}
					}
					else
					{	
						$tmpvarr = explode('-',$whitouthtml);
						$module = $tmpvarr[0];
						if (isset($tmpvarr[1])) $action = $tmpvarr[1]; else $action='';
						if (isset($tmpvarr[2])) $param1 = $tmpvarr[2]; else $param1='';
						if (isset($tmpvarr[3])) $param2 = $tmpvarr[3]; else $param2='';
						if (isset($tmpvarr[4])) $param3 = $tmpvarr[4]; else $param3='';
					}
			}
		}

}
else 
{
	$module = 'acasa';
	$action = '';
}
//echo $module." ".$action;exit;
if($module!="search")
{
	unset($_SESSION['judet_code']);
	unset($_SESSION['cat_id']);
	unset($_SESSION['id_localitate']);
	unset($_SESSION['cuvant_cautat']);
}
#Cheek if file exists and its published - modules first
$module = basename(stripslashes($module));
if (file_exists("sources/$module.php"))
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
		{$file_name = $module.'.'.$action;} 
	else 
		{$file_name = $module;}
	
	#now use function
	$published = FilePublished($file_name, $section, $cabinet_id);
	if ($published){require("sources/$module.php");}
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
		$published = FilePublished($file_name, 'page', "");
		if ($published){$page_to_display = $template_content[0];}
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
?>