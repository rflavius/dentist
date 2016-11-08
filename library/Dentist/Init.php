<?php 
/**
 * WebDesignRR Application
 * developer: Flavius Rosu
 * email: rflavius@gmail.com
 * @copyright  Copyright (c) 2003-2015
 */

/**
 * Bunch of miscelaneous functions, used to initiate the application
 * @category   Dentist
 * @package    Frontend
 */


class Dentist_Init
{
	static $published;
	static $noLeftPanel = false;
	/**
	 * Initialize the global variables
	 * @access public
	 * @static
	 */
	public static function initialize($startTime)
	{
		Dentist_Init::includeRequiredFiles();
		
		// Create registry object, as read-only object to store there config, settings, and database
		$registry = new Zend_Registry(array(), ArrayObject::ARRAY_AS_PROPS);
		Zend_Registry::setInstance($registry);
		$registry->startTime = $startTime;
		//Load configuration settings from application.ini file and store it in registry
		$config = new Zend_Config_Ini(CONFIGURATION_PATH.'/application.ini', APPLICATION_ENV);
		$registry->configuration = $config;
		//print_r($config);exit;
		$t = new Template(TEMPLATES_PATH);
		
		// here we will start the new class based on PDO
		$new_db = new Dentist_PDODb($config->database->params->toArray());
		$registry->database = $new_db;
		//Load specific configuration settings from database, and store it in registry
		$settings = Dentist_Settings::getSettings();
		$registry->settings = $settings;
		
		define('SITE_BASE', $registry->configuration->website->params->url);
		define('SSL_SITE_BASE', str_replace("http:","https:",$registry->configuration->website->params->url));
	}
	
	/**
	 * here we include all the old files that hae been in the preload.php file !
	 * @access public
	 * @static
	 */
	public static function includeRequiredFiles()
	{
		#configure files
		require(APPLICATION_PATH.'/config/db.php');
		require(APPLICATION_PATH.'/config/settings.php');
		#config class
		require(APPLICATION_PATH.'/classes/conf.class.php');
		require(APPLICATION_PATH.'/classes/modules.class.php');
		require(APPLICATION_PATH.'/classes/api/db_mysql.inc.php');
		#rss reader
		require(APPLICATION_PATH.'/classes/api/rss.php');
		#templates usage
		require(APPLICATION_PATH.'/classes/api/templates.php');
		#debug class
		require(APPLICATION_PATH.'/classes/api/debug.inc.php');
		#email class
		require(APPLICATION_PATH.'/classes/api/email.inc.php');
		#session class
		require(APPLICATION_PATH.'/classes/api/sessions.inc.php');
		#users auth class
		require(APPLICATION_PATH.'/classes/api/user.inc.php');
		
		require(APPLICATION_PATH.'/classes/api/pachete.php');
		require(APPLICATION_PATH.'/classes/api/marketing.php');
		require(APPLICATION_PATH.'/classes/api/facturi.php');
		require(APPLICATION_PATH.'/classes/api/search.php');
		#general functions
		require(APPLICATION_PATH.'/classes/general_functions.inc.php');
		
		#modules classes
		#improved
		require(APPLICATION_PATH.'/classes/modules/anunturi.inc.php');
		require(APPLICATION_PATH.'/classes/modules/contact_us.inc.php');
		require(APPLICATION_PATH.'/classes/modules/news.inc.php');
		require(APPLICATION_PATH.'/classes/modules/search.inc.php');
		require(APPLICATION_PATH.'/classes/modules/articole.inc.php');
		require(APPLICATION_PATH.'/classes/modules/sitemap.inc.php');
		
		require(APPLICATION_PATH.'/classes/modules/cabinete.inc.php');
		require(APPLICATION_PATH.'/classes/modules/links.inc.php');
		require(APPLICATION_PATH.'/classes/modules/plati.inc.php');
		require(APPLICATION_PATH.'/classes/modules/contracte.inc.php');
		require(APPLICATION_PATH.'/classes/modules/dictionar_stomatologic.inc.php');
		require(APPLICATION_PATH.'/classes/modules/pachetePromovare.inc.php');
		
		#admin authentification class
		require(APPLICATION_PATH.'/classes/admin/admin.inc.php');
		#admin functions
		require(APPLICATION_PATH.'/classes/admin/functions.inc.php');
		#system emails
		require(APPLICATION_PATH.'/classes/emails/system_emails.php');
		#ips to contry class
		
		require(APPLICATION_PATH.'/classes/admin/geoIp/geoip.inc.php');
	}
	
	/**
	 * here we set up the route for URL
	 * @access public
	 * @param none
	 * @return void
	 */
	public static function setRoute()
	{
		global $conf;
		global $tpl;
		$registry = Zend_Registry::getInstance();
		$registry->route = array();
		
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
				if(stristr($_GET['p'],"/")!==FALSE)
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
						//echo $get_module_link;
						$first_part = explode('.',$get_module_link);
						$module = $first_part[0];
						if(isset( $first_part[1])&&( $first_part[1]!=""))
						{
							$action = $first_part[1];
						}
						else
						{
							$action="";
						}
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
						{
							$action = $first_part[1];
						}
						else
						{
							$action="";
						}
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
		
		(!empty($module)) ? $registry->route = array_merge($registry->route, array('module' => $module)) : '' ;
		(!empty($action)) ? $registry->route = array_merge($registry->route, array('action' => $action)) : '' ;
		(!empty($param1)) ? $registry->route = array_merge($registry->route, array('param1' => $param1)) : '' ;
		(!empty($param2)) ? $registry->route = array_merge($registry->route, array('param2' => $param2)) : '' ;
		(!empty($param3)) ? $registry->route = array_merge($registry->route, array('param3' => $param3)) : '' ;
		(!empty($param4)) ? $registry->route = array_merge($registry->route, array('param4' => $param4)) : '' ;
		(!empty($param5)) ? $registry->route = array_merge($registry->route, array('param5' => $param5)) : '' ;
		(!empty($param6)) ? $registry->route = array_merge($registry->route, array('param6' => $param6)) : '' ;
		
		//print_r($registry->route);
		#Cheek if file exists and its published - modules first
	}
	
	/**
	 * here we have the work process
	 * @access public
	 * @param none
	 * @return void
	 */
	public static function gallop()
	{
		// here we check to see if the page we display is wide or has left panel
		Dentist_Init::setupLeftPanel();
		
		#Start templates object
		Dentist_Init::initFrontendTemplate();
		
		Dentist_Init::setSeo();
		
		Dentist_Init::buildMenus();

		Dentist_Init::buildSearchBar();
		
		Dentist_Init::buildLeftPanel();
		
		Dentist_Init::buildFooter();
		
		Dentist_Init::buildErrorBlock();
	}
	
	/**
	 * here we setup the noleftpanel static var
	 * @access public
	 * @param none
	 * @return void
	 */
	public static function setupLeftPanel()
	{
		$registry = Zend_Registry::getInstance();
		
		$key = array_search($registry->route['module'], $registry->configuration->resources->noLeftPanel->module->toArray());
		if($key!==false)
		{
			$structure = $registry->configuration->resources->noLeftPanel->structure->toArray();
			$structure = $structure[$key];
			$route_structure = '';
			
			foreach ($registry->route as $key => $value)
			{
				if(!isset($registry->route['param2']) || stristr($registry->route['param2'],'pagina') === false)
				{
					// if the route param was found with no specific value then add it to the structure as it is
					if(stristr($structure, $key.',')!==false)
					{
						$route_structure.= $key.',';
					}
					elseif(stristr($structure, $key.'=')!==false)
					{
						// then find out what value has
						$route_structure.= $key.'='.$value.",";
					}
				}
			}
			if($structure == $route_structure) self::$noLeftPanel = true;
		}
	}
	
	/**
	 * here we initializa the template and the blocks
	 * @access public
	 * @param none
	 * @return void
	 */
	public static function initFrontendTemplate()
	{
		global $tpl;
		global $conf;
		#Get the main template page
		if(self::$noLeftPanel)
		{
			$tpl->set_file("tpl_index", "index_wide.tpl");
		}
		else $tpl->set_file("tpl_index", "index_responsive.tpl");
		
		
		$tpl->set_var("CURRENT_YEAR",date('Y'));
		$tpl->set_var('SITE_BASE',SITE_BASE );
		$tpl->set_var('NEWSLETTER_ACTION',ReWrite('default','contact-newsletter') );
		
		$tpl->set_var('LOGO', $conf->logo);
		#footer information
		$tpl->set_var('TODAY', date("F d Y"));
		$tpl->set_var('LICENSE_LINK', $conf->license_url);
		$tpl->set_var('LICENSE_NAME', $conf->license_name);
		$tpl->set_var('LICENSE_VERSION', LICENSE_VERSION);
	}
	
	/**
	 * here we build the left side
	 * @access public
	 * @param none
	 * @return void
	 */
	public static function buildLeftPanel()
	{
		global $tpl;
		$registry = Zend_Registry::getInstance();
		
		if(self::$noLeftPanel === false)
		{
			$tpl->set_file('tpl_box', 'box.tpl');
			$tpl->set_var('FEEDBACK_LINK', ReWrite('default', 'pagina-feedback'));
			#block and stuffs for last cabinetes added on website
			$tpl->set_block('tpl_box', 'list_last_oferte', 'list_last_ofertee');
			$get_last_12 = GetLastOferte("Limit 0,10");
			foreach ($get_last_12 as $key => $val)
			{
				$tpl->set_var('TITLU_OFERTA',$val['nume_firma']);
				$tpl->set_var('AHREF_OFERTA',$val['nume_firma']);
				$tpl->set_var('OFERTA_URL',ReWrite('cabinete_detalii','cabinete.detalii.'.$val['id']));
				$tpl->parse('list_last_ofertee', 'list_last_oferte', true);
			}
			
			
			#block and stuffs for last events added on website
			$tpl->set_block('tpl_box', 'list_last_eveniment', 'list_last_evenimente');
			$get_last_12 = GetNews(0,5);
			foreach ($get_last_12 as $key => $val)
			{
				$tpl->set_var('TITLU_EVENIMENT',$val['title']);
				$tpl->set_var('AHREF_EVENIMENT',$val['title']);
				$tpl->set_var('EVENIMET_URL',ReWrite('news','news.detalii.'.$val['id']));
				$tpl->parse('list_last_evenimente', 'list_last_eveniment', true);
			}
			
			#block and stuffs for last anounces added on website
			$tpl->set_block('tpl_box', 'list_anunturi_homepg', 'list_anunturi_homepgg');
			$tpl->set_block('tpl_box', 'list_anunturi_homepg2', 'list_anunturi_homepgg2');
			
			#let's parse in the right part only anunturi from who pay,has an pachet business or premium by rand mode
			$get_anunturi_right_part = GetAnunturiMainPagePaid("all"," limit 0,3 ");
			
			//echo $db->debug_html();
			//print_r($get_anunturi_right_part);
			foreach ($get_anunturi_right_part as $key => $val)
			{
				$tpl->set_var('TITLUANUNT',$val['titlu']);
				$tpl->set_var('CONTINUT',text_best_fit($val['continut'],80));
				$tpl->set_var('AHREF_ANUNTURI',"Anunt :".$val['titlu'] );
				$tpl->set_var('IMAGINEANUNT',SITE_BASE."/images/smallimages/anunturi/".$val['imagine']);
				$tpl->set_var('IDANUNT',$val['id']);
				$tpl->set_var('CITESTEANUNT',ReWrite('anunturi_detalii','anunturi.detalii.'.$val['id']));
				$tpl->parse('list_anunturi_homepgg', 'list_anunturi_homepg', true);
			}
			
			
			$getanunturi = GetAnunturiMainPage("all"," limit 0,4 ");
			if (count($getanunturi ) > 0)
			{
				foreach ($getanunturi as $key => $val)
				{
					$tpl->set_var('TITLUANUNT',$val['titlu']);
					$tpl->set_var('CONTINUT',text_best_fit($val['continut'],80));
					$tpl->set_var('AHREF_ANUNTURI',"Anunt :".$val['titlu'] );
					$tpl->set_var('IMAGINEANUNTLEFT',SITE_BASE."/images/smallimages/anunturi/".$val['imagine']);
					$tpl->set_var('IDANUNT',$val['id']);
					$tpl->set_var('CITESTEANUNT',ReWrite('anunturi_detalii','anunturi.detalii.'.$val['id']));
					$tpl->parse('list_anunturi_homepgg2', 'list_anunturi_homepg2', true);
				}
			}
			
			###################################
			### right side articles for the abonament package !!!
			$tpl->set_block('tpl_box', 'list_recomandam_articole', 'list_recomandam_articole2');
			$recomandam_articles = getRecomandArticles();
			if(is_array($recomandam_articles))
			{
				foreach($recomandam_articles as $ky => $val)
				{
					$tpl->set_var('RECOMAND_ART', $val['titlu']);
					$tpl->set_var('RECOMAND_ART_IMG', $val['imagine']);
					$tpl->set_var('RECOMAND_ART_DESCR', substr(strip_tags($val['continut']),0,126));
					$tpl->set_var('RECOMAND_ART_LINK', ReWrite('articole', 'articole-medicale.articol.'.$val['bigcat_id'].'.'.$val['id']));
					updateArticlesRecomandView($val['id']);
					$tpl->parse('list_recomandam_articole2', 'list_recomandam_articole',true);
				}
			}
			else
			{
				$tpl->parse('list_recomandam_articole2', '');
			}
			
			###################################
			### right side recomandam banner !!!!
			$tpl->set_file('tpl_recbanner', 'recomandam_banner.tpl');
			$tpl->set_block('tpl_recbanner', 'list_recomandam_banner', 'list_recomandam_banner2');
			$banners = getRecomandBanner();
			//var_dump($banners);
			if(is_array($banners))
			{
				foreach($banners as $ky => $val)
				{
					$tpl->set_var('BANNER_CAB_LINK', ReWrite('cabinete_detalii', 'cabinete.detalii.'.$val['cabinet_id']));
					updateCabinetRecomandBannerView($val['id']);
					$tpl->set_var('BANNER_CAB', $val['nume_firma'] );
					$tpl->set_var('BANNER_PATH',SITE_BASE."/sources/thumbnails.php?target=".$val['name']."&max_size=210.'&banner=yes" );
					$tpl->parse('list_recomandam_banner2','list_recomandam_banner', true);
				}
			}
			else
			{
				$tpl->parse('list_recomandam_banner2', '');
			}
			$tpl->parse('RECOMANDAM_BANNER', 'tpl_recbanner');
			
			$tpl->parse('LATEST_BLOCK_3', 'tpl_box');
		}
	}
	
	/**
	 * here we parse the dynamic menus
	 * @access public
	 * @param none
	 * @return void
	 */
	public static function buildMenus()
	{
		$registry = Zend_Registry::getInstance();
		#get the available tags that could be filled by a menu
		$get_available_menu = GetTheAvailableMenus();
		$get_menus_ids = array();
		if (count($get_available_menu) != '0')
		{
			#get the menus ids
			$i = 0;
			foreach ($get_available_menu as $key => $val)
			{
				$get_menus_ids[$i] = str_replace("DISPLAY_MENU_", "", $val);
				$i++;
			}
		}
		#get each menu and display it into its place
		if (count($get_menus_ids) != '0')
		{
			foreach ($get_menus_ids as $key => $val)
			{
				if ($val != "2")#because the id menu is for the sub menu
				{
					CreateMenu($val, $registry->route['module'], @$registry->route['action'], @$registry->route['param1']);
				}
				else
				{
					CreateSubMenu($registry->route['module'], @$registry->route['action'], @$registry->route['param1']);
				}
			}
		}
	}
	
	/**
	 * here we set the SEO page title, description..etc
	 * @access public
	 * @param none
	 * @return void
	 */
	public static function setSeo()
	{
		global $tpl;
		global $conf;
		$registry = Zend_Registry::getInstance();
		
		if (self::$published)
		{
			//print_r($registry->route);
			$get_title_n_tags = GetTitleAndTags($registry->route['module'], $registry->route['action'], @$registry->route['param1']);
			//print_r($get_title_n_tags);
			$get_title_n_tags_navigation = self::buildBreadcrumb();
			#see if we have user module and add the title and tags part
			if ($conf->users_module == "1" && trim($get_title_n_tags['title']) == "")
			{
				$get_title_n_tags = GetUserModuleTitleNTags(@$registry->route['action']);
			}
			$tpl->set_var('GENERAL_META_DESCRIPTION', $get_title_n_tags['description']);
			$tpl->set_var('GENERAL_META_KEYWORDS', $get_title_n_tags['keywords']);
			$tpl->set_var('EXPAND_PAGE', "<p>".@$get_title_n_tags['expand_title']."</p>");
		
		
			if($registry->route['module']=="acasa")
			{
				$tpl->set_var('PAGETITLE', $conf->home_page_title);
				$tpl->set_var('PAGE_TITLE',"Cabinete Stomatologice, Clinici de Stomatologie, Laboratoare Stomatologice Din Romania");
			}
			else
			{
				//print_r($registry->route['action']);
				if(($registry->route['module']=="cabinete")&&($registry->route['action']=="1"))
				{
					$tpl->set_var('PAGETITLE', $get_title_n_tags['title'].', Dentist, Stomatolog, Cabinet stomatologie');
				}
				elseif(($registry->route['module']=="cabinete")&&($registry->route['action']=="5"))
				{
					$tpl->set_var('PAGETITLE', $get_title_n_tags['title'].', Dentisti,  Stomatologi, Clinici de Stomatologie');
				}
				elseif(($registry->route['module']=="cabinete")&&($registry->route['action']=="2"))
				{
					$tpl->set_var('PAGETITLE', $get_title_n_tags['title'].', Tehnicieni dentari, Laborator tehnica dentara, Laboratoare');
				}
				elseif(($registry->route['module']=="cabinete")&&($registry->route['action']=="3"))
				{
					$tpl->set_var('PAGETITLE', $get_title_n_tags['title'].', Laborator, Radiologii dentare, Radiografii dentare');
				}
				elseif(($registry->route['module']=="cabinete")&&($registry->route['action']=="detalii"))
				{
					$tpl->set_var('PAGETITLE', $get_title_n_tags['title']);
				}
				elseif(stristr($get_title_n_tags['title'],"Cabinet stomatologic")!==FALSE)
				{
					$tpl->set_var('PAGETITLE', $get_title_n_tags['title'].', Cabinet Stomatologic, Dentist, Tehnica dentara');
				}
				elseif(($registry->route['module']=="cabinete")&&($registry->route['action']=="4"))
				{
					$tpl->set_var('PAGETITLE', $get_title_n_tags['title'].', Distributitori materiale stomatologice');
				}
				elseif(($registry->route['module']=="pagina")&&($registry->route['action']=="cabinete"))
				{
					$tpl->set_var('PAGETITLE', 'Dentist, cabinet stomatologic, laborator tehnica dentara, clinica stomatologica recent vizitate');
				}
				else
				{
					$tpl->set_var('PAGETITLE', $get_title_n_tags['title']);
				}
				$tpl->set_var('PAGE_TITLE',	$get_title_n_tags['title']);
			}
		}
		else
		{
			$tpl->set_var('PAGETITLE', $conf->home_page_title);
			$tpl->set_var('PAGE_TITLE', $conf->home_page_title);
		}
		Dentist_Init::displayBreadcrumb($get_title_n_tags_navigation);
	}
	
	/**
	 * here we display the breacrumb navigation
	 * @access public
	 * @param array $tags
	 * @return void
	 */
	public static function displayBreadcrumb($tags)
	{
		global $tpl;
		$registry = Zend_Registry::getInstance();
		
		$tpl->set_file('tpl_breadcrumb', 'menus/navigation.tpl');
		$tpl->set_block('tpl_breadcrumb', 'if_wide_breadcrumb', 'if_wide_breadcrumb2');
		$tpl->set_block('tpl_breadcrumb', 'list_breadcrumb', 'list_breadcrumb2');
		$tpl->set_block('tpl_breadcrumb', 'if_breadcrumb', 'if_breadcrumb2');
		if(self::$noLeftPanel)
		{
			$tpl->parse('if_wide_breadcrumb2', 'if_wide_breadcrumb', true);
		}
		else $tpl->parse('if_wide_breadcrumb2', '');
		
		if(count($tags)>0)
		{
			$i=1;
			foreach ($tags as $key => $value)
			{
				// if we are at the last element then do not parse it as link
				if($i < count($tags))
				{
					$tpl->set_var('BREADCRUMB', "<a href='".$value['url']."' title='".$value['name']."'>".$value['name']."</a>");
					$tpl->set_var('BREADCRUMB_ACTIVE', '');
				}
				else
				{
					$tpl->set_var('BREADCRUMB_ACTIVE', 'active');
					$tpl->set_var('BREADCRUMB', $value['name']);
				}
				
				$tpl->parse('list_breadcrumb2', 'list_breadcrumb', true);
				$i++;
			}
			$tpl->parse('if_breadcrumb2', 'if_breadcrumb', true);
		}
		else
		{
			$tpl->parse('list_breadcrumb2', '');
			if(self::$noLeftPanel) $tpl->parse('if_breadcrumb2', 'if_breadcrumb', true);
			else $tpl->parse('if_breadcrumb2', '');
		}
		#lets parse the expand seo description
		if (count($tags)==2)
		{
			//var_dump($tags);
			//var_dump($tags[0]['name']);
			$cat_name2 = $tags[1]['name'];
			$array_jud_res =array ("Sfantu Gheorghe"=>"Covasna" ,"Focsani"=>"Vrancea","Oradea"=>"Bihor","Timisoara"=>"Timis","Resita"=>"Caras-Severin","Drobeta turnu Severin"=>"Mehedinti","Zalau"=>"Salaj","Baia Mare"=>"Maramures","Miercurea Ciuc"=>"Harghita","Tragoviste"=>"Dambovita","Tragu Jiu"=>"Gorj","Craiova"=>"Dolj","Slatina"=>"Olt","Pitesti"=>"Arges","Alexandria"=>"Teleorman","Ploiesti"=>"Prahova","Slobozia"=>"Ialomita");
			if(in_array($tags[1]['name'],$array_jud_res))
			{
				$resedinta = array_keys($array_jud_res, $tags[1]['name']); 
				$res = $resedinta[0];
				$cat_name2 = $res.' - '.$tags[1]['name'];
			}

			switch($tags[0]['name'])
						{
							case 'Cabinete Stomatologice':
							$get_tags_n_title['expand_title'] ="Cabinete de stomatologie din ".$tags[1]['name'].". Alege un dentist din judetul ".$tags[1]['name'].".Cabinete stomatologice ".$cat_name2.". Aici sunt afisate toate cabinetele stomatologice din ".$tags[1]['name']." promovate pe directorul stomatologic. Contactati cu un medic dentist, stomatolog din ".$cat_name2.".<br /> <div class=\"navigation_expand_text rounded-corners\"> Vezi si :<a href=\"http://www.dentistonline.ro/Clinici-Stomatologice/".$tags[1]['name'].".html\" >Clinici stomatologice ".$cat_name2."</a>  </div>";
							$all_cat_name = "Cabinete stomatologice ".$cat_name2;
							break;

							case 'Tehnica Dentara':
							$get_tags_n_title['expand_title'] ="Lista laboratoarelor de tehnica dentara din ".$tags[1]['name'].".Pentru o usoara accesare a laboratoarelor dentare acestea au fost structurate pe judete. Acum suntetipe judetul ".$tags[1]['name'].".Aici sunt afisate toate laboratoarele de tehnica dentara  din ".$tags[1]['name']." prezente pe directorulstomatologic. Tehnicieni cu un nivel inalt de pregatire in domeniul tehnicii dentare din ".$tags[1]['name'];
								$all_cat_name = "Tehnica dentara ".$cat_name2;
							break;

							case 'Radiologie Dentara':
								$get_tags_n_title['expand_title'] ="Vizualizati laboratoarele de radiologie dentara din ".$cat_name2.". Pentru o usoara accesare a laboratoarelor de radiologie acestea au fost structurate pe judete, radiografii dentare din ".$cat_name2.".Aici sunt afisate toate laboratoarele de radiologie dentara  din ".$tags[1]['name']." promovate pe website-ul nostru.";
								$all_cat_name = "Radiologie dentara ".$cat_name2;
							break;

							case 'Distribuitori Materiale':
								$get_tags_n_title['expand_title'] ="Lista distribuitorilor de materiale medicale, stomatologice  din ".$tags[1]['name'].". Pentru o usoara accesare a distribuitorilor, producatorilor acestia au fost structurati pe judete. Acum sunteti pe judetul ".$tags[1]['name'].". Aici sunt afisati toti distribuitorii, producatorii de materiale medicale din ".$cat_name2." promovati pe directorul stomatologic.Aparatura stomatologica si produse medicale de calitate din ".$cat_name2;
							$all_cat_name = "Distribuitori ".$cat_name2;
							break;

							case 'Clinici Stomatologice':
								$get_tags_n_title['expand_title'] ="Clinici stomatologice din ".$tags[1]['name'].". Alege cu incredere o clinica stomatologica din ".ucfirst($cat_name2).". Aici sunt afisate clinici de stomatologie din ".$tags[1]['name']." promovate pe directorul stomatologic. <br /> Vezi si: [ <a href=\"http://www.dentistonline.ro/Cabinete-Stomatologice/".$tags[1]['name'].".html\" >cabinete stomatologice din ".$tags[1]['name']."</a> ]";
							$all_cat_name = "Clinici stomatologice ".$cat_name2;
							break;
						}
						$tpl->set_var('EXPAND_TITLE_TAGS', $get_tags_n_title['expand_title']);
		}
		else
		{
			$tpl->set_var('EXPAND_TITLE_TAGS', "");
		}
		
		
		$tpl->parse('NAVIGATION', 'tpl_breadcrumb');
	}
	
	/**
	 * parse the footer block
	 * @access public
	 * @param none
	 * @return void
	 */
	public static function buildFooter()
	{
		global $tpl;
		$tpl->set_file('tpl_footer', 'footer.tpl');
		$tpl->parse('FOOTER_BLOCK', 'tpl_footer');
	}
	
	/**
	 * build the search bar
	 * @access public
	 * @param none
	 * @return void
	 */
	public static function buildSearchBar()
	{
		global $tpl;
		$tpl->set_file('tpl_search', 'search_bar.tpl');
		$tpl->set_var('ADVSEARCH_WORD',ReWrite("default","advsearch") );
		$tpl->parse('SEARCH_BLOCK', 'tpl_search');
	}
	
	/**
	 * here we parse the errors block
	 * @access public
	 * @param none
	 * @return void
	 */
	public static function buildErrorBlock()
	{
		global $tpl;
		if(isset($_SESSION['error']) && !empty($_SESSION['error']['message']))
		{
			// parse completed fields form
			if(isset($_SESSION['error']['post']))
			{
				foreach ($_SESSION['error']['post'] as $key => $value)
				{
					if(!empty($value)) $tpl->set_var( strtoupper($key), $value);
				}
			}
			
			$tpl->set_file('tpl_error', 'info/'.$_SESSION['error']['type'].'.tpl');
			$tpl->set_var('MESSAGE', $_SESSION['error']['message']);
			$tpl->parse('ERROR_BLOCK', 'tpl_error');
			unset($_SESSION['error']);
		}
	}
	
	/**
	 * here we will build the breadcrumb navigation
	 * @access public
	 * @param none
	 * @return array
	 */
	public static function buildBreadcrumb()
	{
		$registry = Zend_Registry::getInstance();
		$breadcrumb = array();
		$url = SITE_BASE;
		//print_r($registry->route);
		switch($registry->route['module'])
		{
			default:
			break;
			
			case 'anunturi':
				// here we added hardcoded the anunturi main category
				if(!empty($registry->route['action'])) $breadcrumb [] = array('name' => 'Anunturi', 'url' => SITE_BASE.'/anunturi'.FILE_EXTENSION);
			break;
		}
		
		if(!empty($_GET['p']))
		{
			$page = explode("/", $_GET['p']);
			foreach ($page as $key => $value)
			{
				if(!empty($value) && stristr($value,'pagina')===false)
				{
					$name = str_replace(FILE_EXTENSION,"",strtolower($value));
					$name = ucwords(ereg_replace("[^a-zA-Z]", " ", $name));
					$url.= '/'.$value;
					$breadcrumb[] = array('name' => $name, 'url' => $url.FILE_EXTENSION);
				}
			}
		}
		return $breadcrumb;
	}
	
	public static function checkSessionHijack()
	{
		if( $_SESSION['user_agent'] === $_SERVER['HTTP_USER_AGENT'] )
		{
			# The User's Browser Hasn't Changed Since The Last Login
		
			if( $_SESSION['ip_address'] === $_SERVER['REMOTE_ADDR'] ){
		
				# The User's IP Address Hasn't Changed Since The Last Login
				// The User's Session Isn't Hijacked. You Can Continue :)
			}
			else{
		
				# The User's IP Address Has Changed.
				# This Might Be A Session Hijacking Attempt
		
				# Destroy The Session
				$_SESSION = null;
				session_destroy(); # Destroy The Session
				session_unset(); # Unset The Session
		
			}
		}
		else
		{
			# The User's Browser Has Changed.
			# This Might Be A Session Hijacking Attempt
		
			# Destroy The Session
			$_SESSION = null;
			session_destroy(); # Destroy The Session
			session_unset(); # Unset The Session
		}
	}
}