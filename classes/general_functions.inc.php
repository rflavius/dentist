<?php
#Returns the time in a fancy format
function TimeFormatShort($date)
{
	if ($date)
	{
		global $conf;
		$time = strtotime($date);
		$time = strftime($conf->time_format, $time);
		return $time;
	}
}

function TimeFormatEvents($date)
{
	if ($date)
	{
		global $conf;
		$time = strtotime($date);
		//echo $conf->time_format;
		$time = strftime('%d %B %Y', $time);
		return $time;
	}
}
function TimeFormatFacturi($date)
{
	if ($date)
	{
		global $conf;
		$time = strtotime($date);
		$time = strftime("%d.%m.%G", $time);
		return $time;
	}
}

#Cleans the arrays
function array_clean(&$value) 
{
	#PHP 4 only
	if (is_array($value))
	{
		array_walk($value, 'array_clean');
	return;
	}
	if (ini_get('magic_quotes_gpc'))
	{
		$value = stripslashes($value);
	}
}

function ClearContent($content)
{
	$content_clear = $content;
	$mystring = preg_replace("*<a\W+*>", '',$content);
	return $mystring; ;

}
#Gets the referef
function GetReferer()
{
	return getenv('HTTP_REFERER');
}

#Gets the user ip
function GetUserIP() 
{
	if (getenv("HTTP_CLIENT_IP")) $ip = getenv("HTTP_CLIENT_IP");
	else
	{
		if (getenv('HTTP_X_FORWARDED_FOR'))
		{
			$ip = getenv('HTTP_X_FORWARDED_FOR');
		}
		else
		{
			$ip = getenv('REMOTE_ADDR');
		}
	}
	return $ip;
}

#Gets the user agent
function GetUserAgent()
{
	return $_SERVER["HTTP_USER_AGENT"];
}

#Verifies the validity of an email
function ValidEmail($email)
{
	if (eregi("^[0-9a-z]([-_.]?[0-9a-z])*@[0-9a-z]([-.]?[0-9a-z])*\\.[a-z]{2,3}$", $email)) return true;
	return false;
}

#Returns the content of a file
function GetFileContent($path)
{
	if (@fopen($path, "r"))
	{
		$fp = fopen($path, "r");
		$text = fread ($fp, filesize($path));
		fclose($fp);
		return $text;
	}
	else 
	{
		echo 'File : '.$path.' doesn\'t exist !';
		exit;
	}
}

#Validate a external url
function ValidateURL($url)
{
	if (eregi("^(http|https)+(:\/\/)+[a-z0-9_-]+\.+[a-z0-9_-]", $url ))
	return true;
	return false;
}
#Check if an ip cliked a banner in the last 30min
function CheckIpBannerAcces($ip,$banner_id)
{
	global $db;
	$query = "SELECT date FROM banner_trafic
						WHERE ip = '".trim($ip)."' and id_banner ='".$banner_id."' order by id DESC";

	$db->query($query);
	if ($db->num_rows() != 0)
	{
		$db->next_record();
		return $db->f('date');
	}
	else
	{
	 return false;
	}
	

}

#Rewrite Function , turn the php get codes in html formats
function ReWrite ($section, $link_url)
{
	//echo $link_url;
	global $conf;global $modules;
	global $db;
/*	$a= GetUserIP();
	if($a=='79.113.85.151')
	{
		echo "ccc";
	}*/

	switch ($section)
	{
		case 'default'://default : simple links, no parameters
			if ($conf->url_rewrite_mode == 'Y')
			{
				if ($link_url == 'acasa')
				{
					$url = SITE_BASE;
					return $url;
				}
				else 
				{	$url = SITE_BASE."/".$link_url.FILE_EXTENSION;	}
			}
			else 
			{	$url = $link_url;}
		break;

		case 'preview':
			if ($conf->url_rewrite_mode == 'Y')
			{
				$split = explode(".", $link_url);
				$url = $split[0].'-'.$split[1].'-'.$split[2];
				$url = $url.FILE_EXTENSION;
			}
			else 
			{
				$url = $link_url;
			}
		break;
		
		case 'links':
			if ($conf->url_rewrite_mode == 'Y')
			{
				$split = explode(".", $link_url);
				$url = $split[0].'_'.$split[1];
				if (isset($split[2]))
				{
					$url = $url.'_'.$split[2];
				}
				#get the module name
				$section=$split[1];
				$module_name =  $modules->module[$section]['alias'];
				if (trim($module_name) != "")
				{
					$module_name = strtolower($module_name);
					$module_name = str_replace(" ", "_", $module_name);
					$url = $url.'_'.$module_name;
				}
				$url = $url.FILE_EXTENSION;
			}
			else 
			{
				$url = $link_url;
			}
		break;
		
		case 'articole':
			if ($conf->url_rewrite_mode == 'Y')
			{	
				$split = explode(".", $link_url);
				$section=$split[0];
				$module_name =  $modules->module[$section]['alias'];

				if(isset($split[1])&&(strlen($split[1])<4))
				{
						$category_name = GetArticleCategoryInfos($split[1]);
						$category_name = ucfirst($category_name['alias']);
				}
				elseif (isset($split[2])&&(substr($split[2],0,6)!="pagina")&&(!isset($split[3])))//a category of a cabinet_module
				{
					
					$category_name = GetArticleCategoryInfos($split[2]);
					$category_name = ucfirst($category_name['alias']);
				}
				elseif(isset($split[2])&&(substr($split[2],0,6)=="pagina"))
				{	
					$category_name = $split[2];			
				}
				elseif((isset($split[1])&&($split[1])=='articol')&&(!isset($split[3])))
				{
					$category_name = GetArticleCategoryInfos($split[2]);
					$category_name = ucfirst($category_name['alias']);
				}
				elseif(isset($split[3])&&($split[3]!='')&&($split[3]!='pagina'))
				{
					
					$category_name = GetArticleCategoryInfos($split[2]);
					$category_name = ucfirst($category_name['alias']);
					$article_name = GetArticole(-1,$split[3]);
					$art_name = strtolower($article_name[0]['alias']);
					
				}
					
				$url = $module_name;
				
				if(isset($split[1])&&(strlen($split[1])<4)&&($split[1]!=""))
				{
						$url = $url.'/'.$category_name;
				}
				if (isset($split[2])&&(substr($split[2],0,6)!="pagina"))
				{
					$url = $url.'/'.$category_name;
				}
				elseif(isset($split[2])&&(substr($split[2],0,6)=="pagina"))
				{
					$url = $url.'/'.$split[2];
				}
				if(isset($art_name)&&($art_name!=""))
				{
					$url = $url.'/'.$art_name;
				}elseif (isset($split[3])&&(substr($split[2],0,6)!="pagina"))//a category of a cabinet_module
				{
					$url = $url.'/'.$split[3];
				}
				$url = SITE_BASE."/".$url.".html";
				}
			else 
			{
				$url = $link_url;
			}
		break;
		case 'articol_trimitemail':
			if ($conf->url_rewrite_mode == 'Y')
			{
				$split = explode(".", $link_url);
				$get_cab_info = GetArticole("-1",$split[2]);
				$module_name = $split['0'];
				$category_name = $split['1'];
				$cabinet_title = $get_cab_info[0]['alias'];
				$url = SITE_BASE."/". $module_name."/".$category_name."/".$cabinet_title.FILE_EXTENSION;
			}
			else 
			{
				$url = $link_url;
			}
		break;

		case 'anunturi':
			if ($conf->url_rewrite_mode == 'Y')
			{	
				$split = explode(".", $link_url);
			//	print_r($split);
				
				if((substr($split[1],0,6)=="pagina")||($split[1]==="produse"))
				{
					$section = $split[0];
				}else
				{
					$section = $split[0].".".$split[1];
				}
				$module_name =  $modules->module[$section]['alias'];
				
				if($split[1]==="produse")
				{
					if(isset($split[2])&&($split[2])!="")
					{
						$module_name = "anunturi"; 
						$url = SITE_BASE."/".$module_name."/".$split[2].FILE_EXTENSION;
					}
				}elseif($split[1]==="trimitemail")
				{
					if(isset($split[2])&&($split[2])!="")
					{
						$url = SITE_BASE."/".$module_name."/".$split[2].FILE_EXTENSION;
					}
				}
				elseif($split[1]==="emailtrimis")
				{
					$url = SITE_BASE."/".$module_name."/".$split[2].FILE_EXTENSION;
				}
				elseif(substr($split[1],0,6)=="pagina")
				{
					$url = SITE_BASE."/anunturi/".$split[1].FILE_EXTENSION;
				}
				else
				{
					
					if (isset($split[2])&&(substr($split[2],0,6)!="pagina"))//a category of a cabinet_module
					{	$category_name = GetAnuntCategoryName($split[2]);}
					
					elseif(isset($split[2])&&(substr($split[2],0,6)=="pagina"))
					{	$category_name = $split[2];			}
						
					$url = $module_name;
					if (isset($split[2])&&(substr($split[2],0,6)!="pagina"))
					{	$url = $url.'/'.$category_name;}
					elseif(isset($split[2])&&(substr($split[2],0,6)=="pagina"))
					{	$url = $url.'/'.$split[2];}
					if (isset($split[3])&&(substr($split[2],0,6)!="pagina"))//a category of a cabinet_module
					{	$url = $url.'/'.$split[3];}
						$url = SITE_BASE."/".$url."/";

					}
			}
			else 
			{
				$url = $link_url;
			}
		break;

		case 'anunturi_detalii':
			if ($conf->url_rewrite_mode == 'Y')
			{
				$split = explode(".", $link_url);
				$get_cab_info = GetAnuntInfo($split[2]);
				$section = "anunturi.".$get_cab_info['bigcat_id'];
				$module_name =  $modules->module[$section]['alias'];
				$category_name = GetJudetName($get_cab_info['judet']);
				$cabinet_title =$get_cab_info['alias'];
				$url = SITE_BASE."/". $module_name."/".$category_name."/".$cabinet_title.FILE_EXTENSION;
			}
			else 
			{	$url = $link_url;	}
		break;
		
		case 'pagina':
			if ($conf->url_rewrite_mode == 'Y')
			{	
				$get_pagina = explode(".",$link_url);
				if(count($get_pagina )>2)
				{		
						//$link =$get_pagina[0].'.'.$get_pagina[1];
						//$get_alias = GetAliasModule($link);
						$section = $get_pagina[0].'.'.$get_pagina[1];
						$get_alias =  $modules->module[$section]['alias'];
						$url = SITE_BASE."/".$get_alias.'/'.$get_pagina[2].FILE_EXTENSION;
				}
				else
				{
					///$link = $link_url;
					//$get_alias = GetAliasModule($link);
					$section = $link_url;
					$get_alias =  $modules->module[$section]['alias'];
					$url = SITE_BASE."/".$get_alias.FILE_EXTENSION;
				}
			}
			else 
			{	$url = $link_url;}
		break;
	
		case 'search':
			if ($conf->url_rewrite_mode == 'Y')
			{
				$link_url = str_replace("?p=", "", $link_url);
				$split = explode(".", $link_url);
				$judet_cautare = count($split);
				if(isset($split[3])&&($split[3]!=""))
				{
					$judet = GetJudetName($split[3]);
				}
				else
				{
					$judet = "";
				}
				
				$url = $split[0].'-'.$split[1];
				if (isset($split[2]) )
				{$url = $url.'-'.$split[2];}
			
				$url = $url.'-'.$judet;
				
				
				/*get the module name*/
				$module_name = GetModuleName($split[1]);
				if (trim($module_name) != "")
				{
					$module_name = strtolower($module_name);
					$module_name = str_replace(" ", "-", $module_name);
					$url = $url.'-'.$module_name;
				}
				$url = SITE_BASE.'/'.$url.'.html';
			}
			else 
			{		$url = $link_url;	}
		break;
		
		case 'advsearch':
			if ($conf->url_rewrite_mode == 'Y')
			{
				$link_url = str_replace("?p=", "", $link_url);
				$split = explode(".", $link_url);
				foreach($split as $ky => $val)
				{
					if($ky==0)
					{
						$url= $val;
					}
					else 
					{
						$url.='-'.$val;
					}
				}
				$url = SITE_BASE.'/'.$url.'.html';
			}
			else
			{		$url = $link_url;	}
		break;
		
		
		case 'dictionar_stomatologic':
			if ($conf->url_rewrite_mode == 'Y')
			{	
				$split = explode(".", $link_url);
				$section = $split[0];
				$module_name =  $modules->module[$section]['alias'];
				$url = $module_name;
				if(isset($split[1])&&($split[1]==='litera'))
				{
					$url = $url.'/Litera-'.$split[2];
					$url = SITE_BASE."/".$url."/";
				}
				elseif(isset($split[1])&&($split[1]==='termen'))
				{
						$get_alias_term = GetSelectedTerm($split[2]);
						$url = $url.'/'.$get_alias_term['alias'];
						$url = SITE_BASE."/".$url.".html";
				}
				elseif(!isset($split[1]))
				{
					$url = SITE_BASE."/".$url.".html";
				}
				else
				{
					$url = $url.'/'.$split[1];
					$url = SITE_BASE."/".$url.".html";
				}
			
					
			}
			else 
			{
				$url = $link_url;
			}
			
		break;

		case 'contact':
			if ($conf->url_rewrite_mode == 'Y')
			{
				$split = explode(".", $link_url);
				$url = $split[0].'-'.$split[1];
				if (isset($split[2]))
				{
					$url = $url.'-'.$split[2];
				}
				#get the module name
				$module_name = GetModuleName($split[1]);
				if (trim($module_name) != "")
				{
					$module_name = strtolower($module_name);
					$module_name = str_replace(" ", "-", $module_name);
					$url = $url.'-'.$module_name;
				}
				
				$url = SITE_BASE."/".$url.FILE_EXTENSION;
				
			}
			else 
			{
				$url = $link_url;
			}
		break;

		case 'cabinete':
			if ($conf->url_rewrite_mode == 'Y')
			{
					$split = explode(".", $link_url);
					//GetAliasModule($split[0].".".$split[1]);
					$section = $split[0].".".$split[1];
					$module_name =  $modules->module[$section]['alias'];

					if (isset($split[2])&&(substr($split[2],0,6)!="pagina"))//a category of a cabinet_module
					{
						$category_name = GetCabineteCategoryName($split[2]);
						$category_name = ucfirst($category_name);
					}
					elseif(isset($split[2])&&(substr($split[2],0,6)=="pagina"))
						{	$category_name = $split[2];			}
						
					$url = $module_name;
					if (isset($split[2])&&(substr($split[2],0,6)!="pagina"))
					{
						$url = $url.'/'.$category_name;
					}
					elseif(isset($split[2])&&(substr($split[2],0,6)=="pagina"))
					{
						$url = $url.'/'.$split[2];
					}
					
					if (isset($split[3])&&(substr($split[2],0,6)!="pagina"))//a category of a cabinet_module
					{
						$url = $url.'/'.$split[3];
					}

					$url = SITE_BASE."/".$url.FILE_EXTENSION;
					
			}
			else 
			{		$url = $link_url;	}
		break;

		case 'cabinete_detalii':
			if ($conf->url_rewrite_mode == 'Y')
			{
				$split = explode(".", $link_url);
				$get_cab_info = GetCabInfo($split[2]);
				$section = "cabinete.".$get_cab_info['category_id'];
				$module_name =  $modules->module[$section]['alias'];
				$category_name = GetJudetName($get_cab_info['judet']);
				$category_name = ucfirst($category_name);
				$cabinet_title = $get_cab_info['alias'];
				$url = SITE_BASE."/". $module_name."/".$category_name."/".$cabinet_title.FILE_EXTENSION;
			}
			else 
			{
				$url = $link_url;
			}
		break;
		
		case 'cabinete_trimitemail':
			if ($conf->url_rewrite_mode == 'Y')
			{
				$split = explode(".", $link_url);
				$get_cab_info = GetCabInfo($split[2]);

				$module_name = $split['0'];
				$category_name = $split['1'];
				$cabinet_title = $get_cab_info['alias'];
				$url = SITE_BASE."/". $module_name."/".$category_name."/".$cabinet_title.FILE_EXTENSION;
			}
			else 
			{
				$url = $link_url;
			}
		break;
		case 'cabinete_emailtrimis':
			if ($conf->url_rewrite_mode == 'Y')
			{
				$split = explode(".", $link_url);
				$get_cab_info = GetCabInfo($split[2]);

				$module_name = $split['0'];
				$category_name = $split['1'];
				$cabinet_title = $get_cab_info['alias'];
				$url = SITE_BASE."/". $module_name."/".$category_name."/".$cabinet_title.FILE_EXTENSION;
			}
			else 
			{
				$url = $link_url;
			}
		break;


		case 'user':
			if ($conf->url_rewrite_mode == 'Y')
			{
				$url = str_replace(".", "-", $link_url);
				$url =SITE_BASE."/".$url.FILE_EXTENSION;

			}
			else 
			{	$url = $link_url;}
		break;
		
		case 'news':
			if ($conf->url_rewrite_mode == 'Y')
			{	
						//echo $link_url."<br>";
						$split = explode(".", $link_url);
						$section = $split[0];
						$module_name =  $modules->module[$section]['alias'];
						$url = $module_name;
						if(isset($split[2])&&($split[2]!=''))
						{
							$get_news = GetNews($split[2],'');
							$get_news_alias =$get_news[0]['alias'];

							$url = $url.'/'.$get_news_alias.'.html';
							$url = SITE_BASE."/".$url;
						}
						elseif(isset($split[1])&&($split[1]!=''))
						{
							$url = $url.'/'.$split[1].'.html';
							$url = SITE_BASE."/".$url;
						}
						else
						{
								$url = SITE_BASE."/".$url.'.html';
						}
				}
				else 
				{
					$url = $link_url;
				}
		break;

		case 'utilizator':
			if ($conf->url_rewrite_mode == 'Y')
			{
				$url = str_replace(".", "-", $link_url);
				$url =SITE_BASE."/".$url.FILE_EXTENSION;

			}
			else 
			{	$url = $link_url;}
		break;
	}

	#remove non alpha numeric or "-" , "." characters if the url rewrite is on
	if ($conf->url_rewrite_mode == 'Y')
	{
		$url = ereg_replace("[^a-zA-Z0-9_.:/\-]", "", $url);
	}
	else 
	{
		$url = '?p='.$url;
	}
	return $url;
}

function GetAliasById($category_id)
{
	global $db;global $conf;
	$query = "SELECT alias FROM modules
								WHERE id = '".$category_id."'";

	$db->query($query);
	$db->next_record();
	return 	$db->f('alias');
	
}

function GetAliasModule($link)
{
	global $modules;
	$alias = $modules->module[$link]['alias'];
	return $alias;
}

function GetModuleLinkByAlias($module)
{
	global $db;
	$query = "SELECT link FROM modules
								WHERE alias = '".trim($module)."'";
	$db->query($query);
	$db->next_record();
	return $db->f('link');
}
#Get Title and meta description / keywords ofr each page
function GetTitleAndTags ($module, $action, $param1)
{
	global $db;
	global $modules;
	global $conf;

	$get_tags_n_title = array();
	switch ($module)
	{
		default ://all modules and pages
			$section = $module;
			//print_r($modules);
			if (isset($modules->module[$section])&& count($modules->module[$section]) >0)
			{
			
				$get_tags_n_title['title'] = $modules->module[$section]['name'];
				$get_tags_n_title['description'] = $modules->module[$section]['meta_description'];
				$get_tags_n_title['keywords'] =  $modules->module[$section]['meta_keywords'];
				$get_tags_n_title['content'] = $modules->module[$section]['content'];
			}
			else 
			{
				$query = "SELECT name, meta_keywords, meta_description FROM pages
									WHERE link = '".$section."'";
				$db->query($query);
				$db->next_record();
				$get_tags_n_title['title'] = $db->f('name');
				$get_tags_n_title['description'] = $db->f('meta_description');
				$get_tags_n_title['keywords'] = $db->f('meta_keywords');
			}
		break;
		
		case 'reviews':
			$get_tags_n_title['title'] = "Impresii DentistOnline, pareri, reviews";
			$get_tags_n_title['description'] = $modules->module[$section]['meta_description'];
			$get_tags_n_title['keywords'] =  $modules->module[$section]['meta_keywords'];
		break;

		case 'cabinete':
			switch ($action)
			{
				default :
					#get the name of the parent module
					$link = $module.'.'.$action;
					$section = $link;
					$get_tags_n_title['title'] = $modules->module[$section]['name'];
					$get_tags_n_title['description'] = $modules->module[$section]['meta_description'];
					$get_tags_n_title['keywords'] =  $modules->module[$section]['meta_keywords'];
					$get_tags_n_title['content'] = $modules->module[$section]['content'];
					#get the name of the category, if there is one
					if ($param1 != "" && intval($param1))
					{
						$query = "SELECT cat_name,meta_description,meta_keywords FROM cabinete_categories
											WHERE id_cat = '".intval($param1)."'";
						$db->query($query);
						$db->next_record();
						if($db->f('meta_description')!="")
						{
							$get_tags_n_title['description'] = $db->f('meta_description');
							$get_tags_n_title['keywords'] = $db->f('meta_keywords');
						}
						$array_jud_res =array ("Sfantu Gheorghe"=>"Covasna" ,"Focsani"=>"Vrancea","Oradea"=>"Bihor","Timisoara"=>"Timis","Resita"=>"Caras-Severin","Drobeta turnu Severin"=>"Mehedinti","Zalau"=>"Salaj","Baia Mare"=>"Maramures","Miercurea Ciuc"=>"Harghita","Tragoviste"=>"Dambovita","Tragu Jiu"=>"Gorj","Craiova"=>"Dolj","Slatina"=>"Olt","Pitesti"=>"Arges","Alexandria"=>"Teleorman","Ploiesti"=>"Prahova","Slobozia"=>"Ialomita");
						if(in_array($db->f('cat_name'),$array_jud_res))
						{
							$resedinta = array_keys($array_jud_res, $db->f('cat_name')); 
							$res = $resedinta[0];
							$get_tags_n_title['title'] = $get_tags_n_title['title'].' '.$res.' - '.$db->f('cat_name');
						}
						else
						{
							$get_tags_n_title['title'] = $get_tags_n_title['title'].' '.$db->f('cat_name');
						}
						
					}
				break;

				case 'detalii':
					
					$query = "SELECT nume_firma, meta_keywords, meta_description,category_id,judet,nume_loc_sector
										FROM cabinete WHERE id = '".intval($param1)."'";
					$db->query($query);
					$db->next_record();
					$nume_firma = ucfirst($db->f('nume_firma'));
					$id_category = $db->f('category_id');
					$get_tags_n_title['description'] = $db->f('meta_description');
					$get_tags_n_title['keywords'] = $db->f('meta_keywords');
					$bigcat_id = $db->f('category_id');
					$localitate_id = $db->f('nume_loc_sector');
					$judet = GetJudetName($db->f('judet'));
					$localitate_name = GetLocalitate($localitate_id );
					$loc_name = $localitate_name['name'];
					if(strtolower($judet)!=strtolower($loc_name ))
					{
						$judet = $loc_name."- ".$judet;
					}
					

					$section = 'cabinete.'.intval($bigcat_id);
					$big_catname = $modules->module[$section]['name'];

					switch($id_category )
					{
						case '1':
						$part_of_title=", Cabinet Stomatologic";
						break;
						case '5':
							$part_of_title=", Clinica Stomatologica";
						break;
							case '2':
							$part_of_title=", Laborator tehnica dentara";
						break;
						case '4':
							$part_of_title=", Distribuitor materiale";
						break;
						case '3':
							$part_of_title=", Laborator Radiologie dentara ";
						break;
					}
					if(stripos($nume_firma,$big_catname)!==FALSE)
					{
							$get_tags_n_title['title'] = $nume_firma.$part_of_title." ".$judet;
					} 
					else
					{
						$get_tags_n_title['title'] = $nume_firma.$part_of_title." ".$judet;
					}
						
				break;
			}
		break;
		case 'articole-medicale':
			switch ($action)
			{
				default :
					$section = $module;
					$get_tags_n_title['title'] = $modules->module[$section]['name'];
					$get_tags_n_title['description'] = $modules->module[$section]['meta_description'];
					$get_tags_n_title['keywords'] =  $modules->module[$section]['meta_keywords'];
					$get_tags_n_title['content'] = $modules->module[$section]['content'];
					#get the name of the category, if there is one
					if ($param1 != "" && intval($param1))
					{
						$query = "SELECT cat_name,meta_description,meta_keywords FROM articles_categories
											WHERE id_cat = '".intval($param1)."'";
						$db->query($query);
						$db->next_record();
						
					$get_tags_n_title['description'] = $db->f('meta_description');
					$get_tags_n_title['keywords'] = $db->f('meta_keywords');
					$get_tags_n_title['title'] = $db->f('cat_name').'- '.$get_tags_n_title['title'];
		
						
					}
				break;

				case 'detalii':
					
					$query = "SELECT titlu, meta_keywords, meta_description 
										FROM articles WHERE id = '".intval($param1)."'";
					$db->query($query);
					$db->next_record();
					$nume_firma = ucfirst($db->f('titlu'));
					$id_category = $db->f('bigcat_id');
					$get_tags_n_title['description'] = $db->f('meta_description');
					$get_tags_n_title['keywords'] = $db->f('meta_keywords');
					$get_tags_n_title['title'] = $nume_firma;
						
				break;
			}
		break;

		case 'links':
					$section = $module.'.'.$action;
					$get_tags_n_title['title'] = $modules->module[$section]['name'];
					$get_tags_n_title['description'] = $modules->module[$section]['meta_description'];
					$get_tags_n_title['keywords'] =  $modules->module[$section]['meta_keywords'];
					$get_tags_n_title['content'] = $modules->module[$section]['content'];
		break;
	
		case 'pagina':
			$section = $module.'.'.$action;
			$get_tags_n_title['title'] = $modules->module[$section]['name'];
			$get_tags_n_title['description'] = $modules->module[$section]['meta_description'];
			$get_tags_n_title['keywords'] =  $modules->module[$section]['meta_keywords'];
			$get_tags_n_title['content'] = $modules->module[$section]['content'];
		break;
	
	case 'anunturi':
		switch ($action)
			{
				default :
					#get the name of the parent module
					$link = $module;
					if(isset($action)&&($action!=""))
					{
						$link = $module.'.'.$action;
					}
					
					$section = $link;
					//echo $section;
					$get_tags_n_title['title'] = ucwords($modules->module[$section]['name']);
					$get_tags_n_title['description'] = $modules->module[$section]['meta_description'];
					$get_tags_n_title['keywords'] =  $modules->module[$section]['meta_keywords'];
					$get_tags_n_title['content'] = $modules->module[$section]['content'];
					#get the name of the category, if there is one
					if ($param1 != "")
					{
						$get_tags_n_title['title'] = ucwords($get_tags_n_title['title'].' '.GetJudetName($param1));
						$get_tags_n_title['description'] = $get_tags_n_title['description']." ".GetJudetName($param1);
					}
					if($action=="trimitemail")
					{
						$get_tags_n_title['title'] = ucfirst($module).' - '."Trimite email";
					}
				break;

				case 'detalii':
					$query = "SELECT titlu, meta_keywords, meta_description
										FROM anunturi WHERE id = '".intval($param1)."'";
					$db->query($query);
					$db->next_record();
					$get_tags_n_title['title'] = ucfirst($db->f('titlu'));
					$get_tags_n_title['description'] = $db->f('meta_description');
					$get_tags_n_title['keywords'] = $db->f('meta_keywords');
				break;
			}
	break;
	
	
		case 'dictionar_stomatologic':
			
		switch($action)
		{
			default:
					$section = $module;
					$get_tags_n_title['title'] = $modules->module[$section]['name'];
					$get_tags_n_title['description'] = $modules->module[$section]['meta_description'];
					$get_tags_n_title['keywords'] =  $modules->module[$section]['meta_keywords'];
					$get_tags_n_title['content'] = $modules->module[$section]['content'];
			break;
			
			case 'litera':
			$param1 = substr($param1,-1);		
			$query = "SELECT cat_name, meta_keywords, meta_description
										FROM dictionary_categories WHERE alias = '".$param1."'";
					$db->query($query);
					$db->next_record();
					$get_tags_n_title['title'] = "Termeni medicali litera ".ucfirst($db->f('cat_name')).", definitii, explicatii stomatologice";
					$get_tags_n_title['description'] = $db->f('meta_description');
					$get_tags_n_title['keywords'] = $db->f('meta_keywords');
			break;
			
			case 'term_details':
				$query = "SELECT titlu, meta_keywords, meta_description
										FROM dictionary WHERE id = '".$param1."'";
					$db->query($query);
					$db->next_record();
					$get_tags_n_title['title'] = ucfirst($db->f('titlu')).", termen medical, definitii, explicatii";
					$get_tags_n_title['description'] = $db->f('meta_description');
					$get_tags_n_title['keywords'] = $db->f('meta_keywords');
			break;
		}
		break;

		
			case 'news':
					if(!isset($action)||($action==''))
					{
							$section = $module;
							$get_tags_n_title['title'] = $modules->module[$section]['name'];
							$get_tags_n_title['description'] = $modules->module[$section]['meta_description'];
							$get_tags_n_title['keywords'] =  $modules->module[$section]['meta_keywords'];
							$get_tags_n_title['content'] = $modules->module[$section]['content'];
					}
					else
					{
						$query = "SELECT title, meta_keywords, meta_description
											FROM news WHERE id = '".$param1."'";
						$db->query($query);
						$db->next_record();
						$get_tags_n_title['title'] = ucfirst($db->f('title'));
						$get_tags_n_title['description'] = $db->f('meta_description');
				  	$get_tags_n_title['keywords'] = $db->f('meta_keywords');
					}
			break;
	}
	
	return $get_tags_n_title;
}

function GetTitleAndTagsNavigation ($module, $action, $param1)
{
	global $db;
	global $conf;
	global $modules;
	
	$registry = Zend_Registry::getInstance();
	print_r($modules);exit;
	
	$get_tags_n_title = array();
	switch ($module)
	{
		case 'cabinete':
			switch ($action)
			{
				default:
					$section = $module.'.'.$action;
					$cab_module  =  $modules->module[$section]['name'];
					$get_tags_n_title[] = array('name' => $cab_module, 'url' => ReWrite("cabinete","cabinete.".$action));
					
					#get the name of the category, if there is one
					if ($param1 != "" && intval($param1))
					{
						$query = "SELECT cat_name FROM cabinete_categories
											WHERE id_cat = '".intval($param1)."'";
						$db->query($query);
						$db->next_record();
						$cat_name = $db->f('cat_name');
						$cat_name2 = $db->f('cat_name');
						
						#here we solved the problem with satu_mare and satumare!!
						if (($action=="1") and ($cat_name2)=="Satu_Mare")
						{
							$cat_name2 = "SatuMare";
							$a = ReWrite("cabinete","cabinete.".$action);
							var_dump($a);
						}elseif(($action=="5") and ($cat_name2)=="SatuMare")
						{
							$cat_name2 = "Satu_Mare";
						}
																		
						$array_jud_res =array ("Sfantu Gheorghe"=>"Covasna" ,"Focsani"=>"Vrancea","Oradea"=>"Bihor","Timisoara"=>"Timis","Resita"=>"Caras-Severin","Drobeta turnu Severin"=>"Mehedinti","Zalau"=>"Salaj","Baia Mare"=>"Maramures","Miercurea Ciuc"=>"Harghita","Tragoviste"=>"Dambovita","Tragu Jiu"=>"Gorj","Craiova"=>"Dolj","Slatina"=>"Olt","Pitesti"=>"Arges","Alexandria"=>"Teleorman","Ploiesti"=>"Prahova","Slobozia"=>"Ialomita");
						if(in_array($cat_name,$array_jud_res))
						{
							$resedinta = array_keys($array_jud_res, $cat_name); 
							$res = $resedinta[0];
							$cat_name = $res.' - '.$cat_name;
						}
						$all_cat_name="";
						
						switch($action)
						{
							case '1':
							$get_tags_n_title['expand_title'] ="Cabinete de stomatologie din ".$cat_name.". Cabinete stomatologice structurate pe judete. Acum vizualizati dentisti din judetul ".$cat_name.". Aici sunt afisate toate cabinetele stomatologice din ".$cat_name." promovate pe directorul stomatologic. Aveti posibilitatea de a lua legatura cu un medic dentist, stomatolog din ".$cat_name.".<br /> <div class=\"navigation_expand_text rounded-corners\"> Vezi si :<a href=\"http://www.dentistonline.ro/Clinici-Stomatologice/".$cat_name2.".html\" >Clinici stomatologice ".$cat_name."</a>  </div>";
							$all_cat_name = "Cabinete stomatologice ".$cat_name2;
							break;

							case '2':
							$get_tags_n_title['expand_title'] ="Lista laboratoarelor de tehnica dentara din ".$cat_name.".Pentru o usoara accesare a laboratoarelor dentare acestea au fost structurate pe judete. Acum suntetipe judetul ".$cat_name.".Aici sunt afisate toate laboratoarele de tehnica dentara  din ".$cat_name." prezente pe directorulstomatologic. Tehnicieni cu un nivel inalt de pregatire in domeniul tehnicii dentare din ".$cat_name;
								$all_cat_name = "Tehnica dentara ".$cat_name2;
							break;

							case '3':
								$get_tags_n_title['expand_title'] ="Lista laboratoarelor de radiologie dentara din ".$cat_name.". Pentru o usoara accesare a laboratoarelor de radiologie acestea au fost structurate pe judete. Acum sunteti pe judetul ".$cat_name.".<br /> Aici sunt afisate toate laboratoarele de radiologie dentara  din ".$cat_name."<br /> prezente pe website-ul nostru.";
								$all_cat_name = "Radiologie dentara ".$cat_name2;
							break;

							case '4':
								$get_tags_n_title['expand_title'] ="Lista distribuitorilor de materiale medicale,stomatologice  din ".$cat_name.". Pentru o usoara accesare adistribuitorilor, producatorilor acestia au fost structurati pe judete. Acum sunteti pe judetul ".$cat_name.". Aici sunt afisati toti distribuitorii, producatorii de materiale medicale din ".$cat_name."<br /> prezente pe directorul stomatologic. Produse medicale de calitate din ".$cat_name;
							$all_cat_name = "Distribuitori ".$cat_name2;
							break;

							case '5':
								$get_tags_n_title['expand_title'] ="Lista clinicilor stomatologice din ".$cat_name.". Clinici stomatologice din judetul ".ucfirst($cat_name2).". Aici sunt afisate clinici de stomatologie din ".$cat_name." prezente pe directorul stomatologic. <br /> Vezi si: [ <a href=\"http://www.dentistonline.ro/Cabinete-Stomatologice/".$cat_name2.".html\" >cabinete stomatologice din ".$cat_name."</a> ]";
							$all_cat_name = "Clinici stomatologice ".$cat_name2;
							break;
						}

						$get_tags_n_title[] = array('name' => $all_cat_name, 'url' => ReWrite("cabinete","cabinete.".$action.".".$param1));
					}
				break;

				case 'detalii':
					$query = "SELECT nume_firma, meta_keywords, meta_description,category_id,judet
										FROM cabinete WHERE id = '".intval($param1)."'";
					$db->query($query);
					$db->next_record();
					$nume_firma = ucfirst($db->f('nume_firma'));
					$judet_code = $db->f('judet');
					$bigcat_id = $db->f('category_id');
					
					#get judet_name
					$query = "SELECT cat_name,id_cat from cabinete_categories WHERE cat_code = '".$judet_code."'";
					$db->query($query);
					$db->next_record();
					$nume_judet = ucfirst($db->f('cat_name'));
					$id_judet = $db->f('id_cat');

					
					$section = "cabinete.".intval($bigcat_id);
					$big_cat =  $modules->module[$section]['alias'];
					

					switch($bigcat_id)
						{
							case '1':
								$all_cat_name = "Cabinete ".$nume_judet;
							break;

							case '2':
								$all_cat_name = "Tehnica dentara ".$nume_judet;
							break;

							case '3':
								$all_cat_name = "Radiologie dentara ".$nume_judet;
							break;

							case '4':
								$all_cat_name = "Distribuitori ".$nume_judet;
							break;

							case '5':
								$all_cat_name = "Clinici ".$nume_judet;
							break;
						}
						
						$get_tags_n_title[] = array('name' => str_replace("-"," ",$big_cat), 'url' => ReWrite("cabinete","cabinete.".$bigcat_id));
						$get_tags_n_title[] = array('name' => $all_cat_name, 'url' => ReWrite("cabinete","cabinete.".$bigcat_id.".".$id_judet));
				break;
			}
		break;
		
		case 'articole-medicale':
			$section = $module;
			$cab_module  =  $modules->module[$section]['name'];
			$get_tags_n_title[] = array('name' => $cab_module, 'url' => ReWrite("articole","articole-medicale.".$action));
			
			switch ($action)
			{
				default :
					#get the name of the category, if there is one
					if ($param1 != "" && intval($param1))
					{
						
						$query = "SELECT cat_name FROM articles_categories
											WHERE id_cat = '".intval($param1)."'";
						$db->query($query);
						$db->next_record();
						$cat_name = $db->f('cat_name');
						$get_tags_n_title[] = array('name' => $cat_name, 'url' => ReWrite("articole","articole-medicale.".$param1));
					}
				break;

				case 'detalii':
					$query = "SELECT bigcat_id
										FROM articles WHERE id = '".intval($param1)."'";
					$db->query($query);
					$db->next_record();
					$cat_code = ucfirst($db->f('bigcat_id'));
					
					#get judet_name
					$query = "SELECT cat_name,id_cat from articles_categories WHERE id_cat = '".$cat_code."'";
					$db->query($query);
					$db->next_record();
					$cat_name = ucfirst($db->f('cat_name'));
					$get_tags_n_title[] = array('name' => $cat_name, 'url' => ReWrite("articole","articole-medicale.".$cat_code));
				break;
			}
		break;

		case 'anunturi':
			switch ($action)
			{
				default :
					#get the name of the parent module
					if($action!="trimitemail" && $action!="emailtrimis")
					{
						if(isset($action)&&($action!=""))
						{
							$link = $module.'.'.$action;
							$section = $link;
							$alias  =  $modules->module[$section]['alias'];
							$get_tags_n_title[] = array('name' => $alias, 'url' => ReWrite("anunturi","anunturi.".$action));
						}
						else
						{
							$section = $module;
							$alias  =  $modules->module[$section]['alias'];
							$get_tags_n_title[] = array('name' => $alias, 'url' => ReWrite("default","anunturi"));
						}
						
						#get the name of the category, if there is one
						if ($param1 != "" && substr($param1,0,6)!=="pagina")
						{
							$query = "SELECT name FROM judete
												WHERE code = '".$param1."'";
							$db->query($query);
							$db->next_record();
							$name2 = $db->f('name');
							$get_tags_n_title[] = array('name' => $name2, 'url' => ReWrite("anunturi","anunturi.".$action.".".$param1));
						}
					}
				break;

				case 'detalii':
					$query = "SELECT alias,judet,bigcat_id
										FROM anunturi WHERE id = '".intval($param1)."'";
					$db->query($query);
					$db->next_record();
					$alias_anunt = ucfirst($db->f('alias'));
					$big_cat_id = $db->f('bigcat_id');
					$judet = $db->f('judet');

					$section = 'anunturi.'.intval($big_cat_id);
					$big_cat_name  =  $modules->module[$section]['alias'];

					$query = "SELECT name FROM judete
											WHERE code = '".$judet."'";
					$db->query($query);
					$db->next_record();
					$judet_name = $db->f('name');

					$get_tags_n_title[] = array('name' => $big_cat_name, 'url' => ReWrite("anunturi","anunturi.".$big_cat_id));
					$get_tags_n_title[] = array('name' => $judet_name, 'url' => ReWrite("anunturi","anunturi.".$big_cat_id.".".$judet));
				break;
			}
		break;

		case 'news':
			switch ($action)
			{
				
				default :
					#get the name of the parent module
					$section = $module;
					$alias = $modules->module[$section]['alias'];
					$get_tags_n_title[] = array('name' => $alias, 'url' => ReWrite('news','news'));
				break;

				case 'detalii':
					$section = $module;
					$alias = $modules->module[$section]['alias'];
					$get_tags_n_title[] = array('name' => $alias, 'url' => ReWrite('news','news'));
				break;
			}
		break;
	}
	return $get_tags_n_title;
}
#Get the modules latest boxes
function GetTheModulesBoxes ()
{
	global $db;
	$query = "SELECT id FROM modules WHERE active = '1' AND type = 'dynamic'";
	$db->query($query);
	$i = 0;
	$the_mods = array();
	while ($db->next_record())
	{
		$the_mods[$i] = 'LATEST_BLOCK_'.$db->f('id');
		$i++;
	}
	return $the_mods;
}

#Get the latest links
function GetLatestLinks ()
{
	global $conf;
	global $db;
	$get_links = array();
	$query = "SELECT title, link, description FROM links
						WHERE status = '1'
						ORDER by position ASC
						LIMIT ".$conf->latest_links;
	$db->query($query);
	$i = 0;
	while ($db->next_record())
	{
		$get_links[$i]['title'] = $db->f('title');
		$get_links[$i]['content'] = $db->f('description');
		$get_links[$i]['link'] = $db->f('link');
		$i++;
	}
	return $get_links;
}

#Fetch the content of the block boxes for the desired module
function GetTheBoxContent ($current_module)
{
	global $conf;
	$the_result = array();
	switch ($current_module)
	{
		case '3'://latest news
			$the_result = GetNews('0', $conf->max_news_list);
		break;

		case '5'://latest links
			$the_result = GetLatestLinks();
			#print_a($the_result);
		break;

		default ://here are the latest cabinete(or what ever they will be called)
			$the_result = GetLatestCabinete($current_module);
		break;
	}
	return $the_result;
}

#Fetch the block box title
function GetBoxTitle ($id)
{
	global $db;
	$query = "SELECT name, support FROM modules WHERE id = '".$id."'";
	$db->query($query);
	$db->next_record();
	if ($db->f('support') != 'cabinete')
	{
		return 'Latest '.$db->f('name');
	}
	else 
	{
		return 'Latest cabinete from '.$db->f('name');
	}
}

#Fetch latest cabinete
function GetLatestCabinete ($parent_module)
{
	global $db;
	global $conf;
	#select from the db the cabinete that have as parent a category from a module
	$query = "SELECT A.*, B.*, C.* FROM cabinete A, cabinete_categories B, cabinete_cat C
						WHERE B.parent_module = '".$parent_module."'
						AND A.status = '1'
						AND B.id_cat = C.cat_id
						AND C.cabinet_id = A.id
						ORDER by A.submision_date DESC";
	$db->query($query);
	$cabinete = array();
	while ($db->next_record())
	{
		$cabinete[$db->f('id')] = $db->f('submision_date');
	}
	#select from the db the cabinete that are direct children to the module
	$query = "SELECT id, submision_date FROM cabinete
						WHERE status = '1'
						AND parent_module = '".$parent_module."'
						ORDER by submision_date DESC";
	$db->query($query);
	$new = array();
	while ($db->next_record())
	{
		$new[$db->f('id')] = $db->f('submision_date');
	}
	#merge the two arrays but keep the keys the same
	foreach ($new as $key => $val)
	{
		$cabinete[$key] = $val;
	}
	#sort the array by date DESC
	arsort($cabinete);
	$new_cabinete = array();
	#cut the dates and retain the ids
	foreach ($cabinete as $key => $val)
	{
		$new_cabinete[$key] = $key;
	}
	#count the results of the new array and retaind only the ids that are nedded : limit
	if (count($new_cabinete) > $conf->latest_cabinete)
	{
		$new_cabinete = array_slice($new_cabinete, '0', $conf->latest_cabinete);
	}
	$the_cabinete = array();
	#now get the cabinete
	foreach ($new_cabinete as $key => $val)
	{
		$query = "SELECT title, submision_date, content, short_description
							FROM cabinete WHERE id = '".$val."'";
		$db->query($query);
		$db->next_record();
		#hold in the link key of the array only the id of the cabinet and we will get it later, because of the global $db the Database object overwrites itsself in the Rewrite function
		$the_cabinete[$val] = array('link' => $val,
																'title' => $db->f('title'),
																'submision_date' => $db->f('submision_date'),
																'content' => $db->f('short_description'));
	}
	#now get the links of the cabinete
	foreach ($the_cabinete as $key => $val)
	{
		$the_cabinete[$key]['link'] = ReWrite('cabinete_detalii', 'cabinete.detalii.'.$key);
	}
	return $the_cabinete;
}

#Fetch the available menus
function GetTheAvailableMenus ()
{
	global $db;
	$query = "SELECT id FROM menus";
	$db->query($query);
	$i = 0;
	$the_mods = array();
	while ($db->next_record())
	{
		$the_mods[$i] = 'DISPLAY_MENU_'.$db->f('id');
		$i++;
	}
	return $the_mods;
}

#Create one of the top / sub top / footer menus
function CreateMenu ($id, $module, $action, $param1)
{
	#use object from class templates as a global, so we can parse the content from here
	global $tpl;
	global $db;
	
	$file = 'tpl_menu_'.$id;
	$tpl->set_file($file, 'menus/menu_'.$id.'.tpl');
	if ($id == "3")//one more block - left menu
	{
		$tpl->set_block($file, 'sub_repetitive', 'sub_repetitive_block');
	}
	$tpl->set_block($file, 'repetitive', 'repetitive_block');
	
	$query = "SELECT name, link, type, target,ahref_title FROM menus_items
						WHERE parent_menu = '".$id."'
						AND active != '0'
						ORDER by position ASC";
	$db->query($query);
	$i = 0;
	$get_them = array();
	#create an array here because of using of the global $db
	while ($db->next_record())
	{
		$get_them[$i]['name'] = $db->f('name');
		$get_them[$i]['link'] = $db->f('link');
		$get_them[$i]['type'] = $db->f('type');
		$get_them[$i]['target'] = $db->f('target');
		$get_them[$i]['ahref_title'] = $db->f('ahref_title');
		$i++;
	}
	$i = 0;
	#now use the array and do all operations
	while (list($k, $v) = each($get_them))
	{
		$tpl->set_var('THE_MENU_TARGET', '');
		#see if the link is not an external one
		if ($v['type'] == 'external')
		{
			$tpl->set_var('THE_MENU_LINK', $v['link']);
			#set link window
			if ($v['target'] == "_blank")
			{
				$tpl->set_var('THE_MENU_TARGET', 'target="_blank"');
			}
		}
		else 
		{
			#explode the link after the "."
			$result = explode(".", $v['link']);
			#if the resulting array has just one key the rewrite will be default
			if (count($result) == '1')
			{
				$tpl->set_var('THE_MENU_LINK', ReWrite('default', $v['link']));
			}
			else 
			{
				$tpl->set_var('THE_MENU_LINK', ReWrite($result[0], $v['link']));
			}
		

			if(($id==3)&&(isset($result[1])))
			{
				//echo $result[1]."<br />";
				$cat_name = Get_Dentist_Cats($result[1]);
				if(count($cat_name)>0)
				{
					$cat_name[0]['name'] = strtolower(str_replace(" ","_",$cat_name[0]['name']));
					$tpl->set_var('RSSLINKMENU',SITE_BASE."/rss/".$cat_name[0]['name']."/feed.xml" );
				}
				$total_recordss = CountCabineteTotalRecordsFront("module", $result[1]);
				$tpl->set_var('OFFERTS_NR',$total_recordss );
			}
			if(($result[0]=='Evenimente-Medicale')&&($id==3))
			{
			
				$tpl->set_var('RSSLINKMENU',SITE_BASE."/rss/news/feed.xml" );
				$total_recordss = CountTotalRecordsNotCabs('news');
				$tpl->set_var('OFFERTS_NR',$total_recordss );
			}

		}
		$tpl->set_var('THE_MENU_TEXT', ucwords($v['name']));
		$tpl->set_var('AHREFTITLEE',$v['ahref_title'] );
		

		#the submenu items
		#curently just for the left menu - show the children
		if ($id == '3' && ItIsCurrentLink($module, $action, $param1, $v['link']))
		{
			$tpl->set_var('MENU_ACTIVE', 'active');
			#see if it hasen't got some children
			$see_if = explode(".", $v['link']);
			if (isset($see_if[0])){$this_module = $see_if[0];}
			if (isset($see_if[1])){$this_action = $see_if[1];}
			if (isset($see_if[2])){$this_param1 = $see_if[2];}
			
			//echo $this_module." action: ". @$this_action." param1: ". @$this_param1;
			$the_children = GetSubmenuItems (@$this_module, @$this_action, @$this_param1);
			unset($the_children[0]);
			$cat_name = Get_Dentist_Cats($action);
			
			switch($action)
			{
				case '1':
						$first_part= "Cabinete ";
				break;
				
				case '5':
					$first_part=  "Clinici ";
				break;
				
				case '2':
					$first_part= "Tehnica dentara ";
				break;
				
				case '4':
					$first_part= "Distribuitori ";
				break;
				
				case '3':
					$first_part= "Radiologie dentara ";			
				break;
			}
			if(count($cat_name)>0)
			{
				$cat_name[0]['name'] = strtolower(str_replace(" ","_",$cat_name[0]['name']));
				$tpl->set_var('RSSLINKMENU',SITE_BASE."/rss/".$cat_name[0]['name']."/feed.xml" );
			}
			if (count($the_children) != '0')
			{
				$page = SITE_BASE.'/'.$_GET['p'];
				while (list($key, $val) = each($the_children))
				{
					if($page == $val['link'])
					{
						$tpl->set_var('SUBMENU_ACTIVE', 'active');
						$tpl->set_var('MENU_ACTIVE', '');
					}
					else $tpl->set_var('SUBMENU_ACTIVE', '');
					$tpl->set_var('SUB_THE_MENU_TARGET', '');
					#set link window
					if ($val['target'] == "_blank")
					{
						$tpl->set_var('SUB_THE_MENU_TARGET', 'target="_blank"');
					}
					$tpl->set_var('SUB_THE_MENU_LINK', $val['link']);
					$tpl->set_var('SUB_THE_MENU_TEXT',ucwords($first_part.strtolower(str_replace("_"," ",$val['name']))));
					$tpl->set_var('SUB_AHREFTITLE',$val['ahref_title'] );
					$cat_name = Get_Dentist_Cats($action);
					$cat_name[0]['name'] = strtolower(str_replace(" ","_",$cat_name[0]['name']));
					$rss_link = SITE_BASE."/rss/".$cat_name[0]['name']."/".$val['name'].".xml";
					//$tpl->set_var('RSS_FILE',"<a href=\"$rss_link\"><img width=\"14\" height=\"14\" border=\"0\" align=\"right\" src=\"{SITE_BASE}/images/allstufs/rss.gif\" title=\"Fisier Rss $jud_namee\" alt=\"Rss $cat_name[0]['name'] $val['name']\"></a>" );
					
					$tpl->parse('sub_repetitive_block', 'sub_repetitive', true);
				}
			}
		}
		else $tpl->set_var('MENU_ACTIVE', '');
		$tpl->parse('repetitive_block', 'repetitive', true);
		$tpl->parse('sub_repetitive_block', '');
		$i++;
	}
	$width = @ceil(100/$i);
	$tpl->set_var('TD_WIDTH', $width.'%');
	$tpl->parse('DISPLAY_MENU_'.$id, $file);
	$tpl->parse('repetitive_block', '');
}

#Create the submenus
function GetSubmenuItems ($module, $action, $param1)
{
	$results = array();
	global $db;
	$parent_link = $module;
	if ($action != "")
	{
		$parent_link = $parent_link.'.'.$action;
	}
	#if the parent is selected
	$query = "SELECT name, link, type, target,ahref_title FROM menus_items
						WHERE parent_link = '".$parent_link."'
						AND active != '0'
						ORDER by position ASC";
	$db->query($query);
	if ($db->num_rows() == '0')//if a child is selected
	{
		#if the child is selected show all "brothers"
		$query = "SELECT parent_link FROM menus_items
							WHERE link = '".$parent_link."'
							AND parent_link != '0'";
		$db->query($query);
		$db->next_record();
		$parent_link = $db->f('parent_link');
		#check if the curent parent is an cabinet module
		if (IsCabinetModule($parent_link))
		{
			#make the $modul = 'cabinete' so we have the brothers(artilces categories) of the link too
			$link = explode(".", $parent_link);
			$module = $link[0];
			if (@is_numeric($link[1])){$action = $link[1];}
		}
		#if there are children
		$query = "SELECT name, link, type, target,ahref_title FROM menus_items
							WHERE parent_link = '".$parent_link."'
							AND active != '0'
							ORDER by position ASC";
		$db->query($query);
	}
	$j = 0;
	$links = array();
	while ($db->next_record())
	{
		$links[$j]['link'] = $db->f('link');
		$links[$j]['name'] = $db->f('name');
		$links[$j]['type'] = $db->f('type');
		$links[$j]['target'] = $db->f('target');
		$links[$j]['ahref_title'] = $db->f('ahref_title');
		$j++;
	}
	$i = 0;
	foreach ($links as $key => $val)
	{
		#see if the link is not an external one
		if ($val['type'] == 'external')
		{
			$results[$i]['link'] = $val['link'];
		}
		else 
		{
			#explode the link after the "."
			$result = explode(".", $val['link']);
			#if the resulting array has just one key the rewrite will be default
			if (count($result) == '1')
			{
				$results[$i]['link'] = ReWrite('default', $val['link']);
			}
			else 
			{
				$results[$i]['link'] = ReWrite($result[0], $val['link']);
			}
		}
		$results[$i]['name'] = $val['name'];
		$results[$i]['target'] = $val['target'];
		$results[$i]['ahref_title'] = $val['ahref_title'];

		$i++;
	}
	#if the module is cabinete - show always the artciles categories
	if ($module == 'cabinete')
	{
		if ($action == 'details')
		{
			#use here the option to see other links on the second menu than the cabinete categories
			$get_cabinete_children = GetSubmenuNonCategoryItems($param1);
			#add to array
			if (count($get_cabinete_children) != '0')
			{
				while (list($k, $v) = each($get_cabinete_children))
				{
					$results[$i]['name'] = $v['name'];
					if ($v['type'] == "external")
					{
						$results[$i]['link'] = $v['link'];
						$results[$i]['target'] = $v['target'];
					}
					else 
					{
						#explode the link after the "."
						$result = explode(".", $v['link']);
						#if the resulting array has just one key the rewrite will be default
						if (count($result) == '1')
						{
							$results[$i]['link'] = ReWrite('default', $v['link']);
						}
						else 
						{
							$results[$i]['link'] = ReWrite($result[0], $v['link']);
						}
					}
					$i++;
				}
			}
			#now get categories
			$the_cats = GetCabineteCategories('', 'Y', $param1);//used by admin too
		}
		else 
		{
			$the_cats = GetCabineteCategories(intval($action), 'Y', '');//used by admin too
		}
		//print_r($the_cats);
		while (list($k, $v) = each($the_cats))
		{
			$results[$i]['name'] = $v['cat_name'];
			$results[$i]['ahref_title'] = $v['ahref_title'];
			//	$results[$i]['link'] = ReWrite('cabinete', 'cabinete.'.$v['parent_module'].'.'.$v['id_cat'].'.'.$v['cat_code']);
			$results[$i]['link'] = ReWrite('cabinete', 'cabinete.'.$v['parent_module'].'.'.$v['id_cat']);
			$results[$i]['target'] = "_self";
			$i++;
		}
	}
	return $results;
}

#Fetch what the function name says :)
function GetSubmenuNonCategoryItems ($cabinet_id)
{
	global $db;
	#get the cabinete parent_module
	$query = "SELECT parent_module FROM cabinete
						WHERE id = '".$cabinet_id."'
						AND parent_module != '0'";
	$db->query($query);
	if ($db->num_rows() != '0')
	{
		$db->next_record();
		$module_id = $db->f('parent_module');
	}
	else 
	{
		#get the cabinete category parent
		$query = "SELECT cat_id FROM cabinete_cat WHERE cabinet_id = '".$cabinet_id."'";
		$db->query($query);
		$db->next_record();
		#get the categories parent module id
		$query = "SELECT parent_module FROM cabinete_categories
													WHERE id_cat = '".$db->f('cat_id')."' order by cat_name ASC";
		$db->query($query);
		$db->next_record();
		$module_id = $db->f('parent_module');
	}
	#get the static children for this module
	$query = "SELECT name, link, type, target FROM menus_items
						WHERE parent_link = 'cabinete.".$module_id."'
						AND active != '0'
						ORDER by position ASC";
	$db->query($query);
	$i = 0;
	$items = array();
	while ($db->next_record())
	{
		$items[$i]['name'] = $db->f('name');
		$items[$i]['link'] = $db->f('link');
		$items[$i]['type'] = $db->f('type');
		$items[$i]['target'] = $db->f('target');
		$i++;
	}
	return $items;
}

#Get curent link to display children for it
function ItIsCurrentLink ($module, $action, $param1, $link)
{
	global $db;
	$current_link = $module;
	#the links module has got a pagination - explains the inclusion
	if ($action != "" && $module != "links"){$current_link = $current_link.'.'.$action;}
	if ($link == $current_link){return true;}
	#if the selected link is an detail of the cabinet
	elseif ($module == 'cabinete' && $action == 'details')
	{
		#if the cabinet is a child of the module
		$query = "SELECT parent_module FROM cabinete
							WHERE id = '".$param1."'
							AND parent_module != '0'";
		$db->query($query);
		if ($db->num_rows() != '0')
		{
			$db->next_record();
			$module_id = $db->f('parent_module');
		}
		else 
		{
			#get the cabinete category parent
			$query = "SELECT cat_id FROM cabinete_cat WHERE cabinet_id = '".$param1."'";
			$db->query($query);
			$db->next_record();
			#get the categories parent module id
			$query = "SELECT parent_module FROM cabinete_categories
														WHERE id_cat = '".$db->f('cat_id')."' order by cat_name ASC";
			$db->query($query);
			$db->next_record();
			$module_id = $db->f('parent_module');
		}
		$the_link = 'cabinete.'.$module_id;
		if ($the_link == $link){return true;}else {return false;}
	}
	else
	{
		#if the child is selected select link "brothers" 
		$query = "SELECT parent_link FROM menus_items
							WHERE link = '".$current_link."'
							AND parent_link != '0'";
		$db->query($query);
		$db->next_record();
		if ($db->f('parent_link') == $link){return true;}else{return false;}
	}
}

#Check is link is cabinet module
function IsCabinetModule ($parent_link)
{
	global $modules;
	if(isset( $modules->module[$parent_link]['id'])&&( $modules->module[$parent_link]['id']!=""))
	{
			return true;
	}
	else
	{
			return false;
	}
}

#Create submenu
function CreateSubMenu ($module, $action, $param1)
{
	global $tpl;
	$items = GetSubmenuItems($module, $action, $param1);
	$tpl->set_file('tpl_menu_2', 'menus/menu_2.tpl');
	$tpl->set_block('tpl_menu_2', 'repetitive', 'repetitive_block');
	while (list($k, $v) = each($items))
	{
		#set link window
		$tpl->set_var('THE_MENU_TARGET', '');
		if ($v['target'] == "_blank")
		{
			$tpl->set_var('THE_MENU_TARGET', 'target="_blank"');
		}
		$tpl->set_var('THE_MENU_LINK', $v['link']);
		$tpl->set_var('THE_MENU_TEXT', $v['name']);
		$tpl->parse('repetitive_block', 'repetitive', true);
	}
	$tpl->set_var('SUBMENU_TD_WIDTH', '10%');
	$tpl->parse('DISPLAY_MENU_2', 'tpl_menu_2');
	$tpl->parse('repetitive_block', '');
}

#Get current available menus
function GetCurrentMenus ($id)
{
	global $db;
	switch ($id)
	{
		default :
			$query = "SELECT * FROM menus WHERE id = '".$id."'";
		break;

		case '-1':
			$query = "SELECT * FROM menus";
		break;
	}
	$menus = array();
	$db->query($query);
	$i = 0;
	while ($db->next_record())
	{
		$menus[$i]['id'] = $db->f('id');
		$menus[$i]['name'] = $db->f('name');
		$i++;
	}
	return $menus;
}

#Templates exist in database. If page is found return it
function PageExists ($page_name)
{
	global $db;
	$query = "SELECT content from pages WHERE link = '".$page_name."'";
	$db->query($query);
	$content = array();
	$db->next_record();
	if (trim($db->f('content')) != "")
	{
		$content[0] = $db->f('content');
	}
	return $content;
}

#Get parent category name
function GetCabineteCategoryName ($id)
{
	global $db;
	$query = "SELECT cat_name FROM cabinete_categories
						WHERE id_cat = '".intval($id)."' order by cat_name ASC";
	$db->query($query);
	if($db->affected_rows()>0)
	{
		$db->next_record();
		return $db->f('cat_name');
	}
	else
	{
		return "";
	}
}

#Get cabinete title
function GetCabineteTitle ($id)
{
	global $db;
	$query = "SELECT alias FROM cabinete
						WHERE id = '".intval($id)."'";
	$db->query($query);
	$db->next_record();
	$title = ShortVersionOfString($db->f('alias'), '50');
	return $title;
}

#Make a short version of the provided string
function ShortVersionOfString ($item, $max_length)
{
	if (strlen($item) <= $max_length)
	{
		$exit_desc = stripslashes($item);
	}
	else 
	{
		$short_description = wordwrap($item, $max_length, "?%?");
		$short_description = substr($short_description, 0, strpos($short_description,'?%?'));
		$exit_desc = stripslashes($short_description);
	}
	return stripslashes($exit_desc);
}

#check the curent status(active) of a file
function FilePublished ($file_name, $section, $cabinet_id)
{
	//echo $file_name."  ". $cabinet_id;
	#make exceptions for some pages
	$exc_pages = array("gmap", "reviews", "pagina.ofertanew", "pagina.feedback", "pagina.oferta", "cabinete.print", "downloads.provide", "preview.cabinet","preview.articol","preview.anunt","contact.post","cabinete.downloadservicii","cabinete.trimitemail","cabinete.emailtrimis","articole-medicale.trimitemail","articole-medicale.emailtrimis","articole-medicale.downloadarticol","contact.abonament","contact.newsletter");
	if (in_array($file_name, $exc_pages)){return true;}
	#user page
	$user_page = explode(".", $file_name);
	if ($user_page[0] == "user"){return true;}
	if ($user_page[0] == "search"){return true;}
	if ($user_page[0] == "pagina"){return true;}
	if ($user_page[0] == "anunturi"){return true;}
	if ($user_page[0] == "acasa"){return true;}
	if ($user_page[0] == "dictionar-stomatologic"){return true;}
	if ($user_page[0] == "utilizator"){return true;}
	if ($user_page[0] == "advsearch"){return true;}
	
	global $db;
	switch ($section)
	{
		case 'module':
				$query = "SELECT active FROM modules WHERE link = '".$file_name."'";
				if(isset($cabinet_id)&&($cabinet_id!="")&&($file_name=='news'))
					{
						$query = "SELECT status AS active FROM news WHERE id = '".$cabinet_id."'";
					}
		break;

		case 'page':
			$query = "SELECT active FROM pages WHERE link = '".$file_name."'";
		break;

		case 'cabinete':
			$query = "SELECT status AS active FROM cabinete WHERE id = '".$cabinet_id."'";
		break;
	}
	
	$db->query($query);
	$db->next_record();
	if ($db->f('active') == '1')
		{return true;} 
	else 
		{return false;}
}

#Get thecontent of a module
function GetModuleContent ($mod, $act)
{
	global $db;global $modules;
	$link = $mod;
	switch ($mod)
	{
		case 'cabinete':
			$link = $link.'.'.$act;
		break;

		case 'news':
			$link = $link;
		break;

		case 'links':
			$link = $link;
		break;

		case 'contact':
			$link = $link;
		break;

		case 'sitemap':
			$link = $link;
		break;
	}
	$module_name =  $modules->module[$link]['content'];
	return $content;
}

#Stop the execution of the script, send a NOT FOUND header and redirect in javascript to error page
function FakeError()
{
	# send the 404 header
	header("HTTP/1.0 404 Not Found");
	# redirect to 404 page
	echo '<SCRIPT LANGUAGE=JAVASCRIPT> 
				function go()
				{
					window.location.href="'.ReWrite('default', 'error').'" 
					}
					</SCRIPT>
				</HEAD>
				<BODY onLoad="go()">
				<!-- afgsdfggsfgsfgsfgsfdgsfgsdfgsdfgsdfgsdfgsdfgsdfgsdfgsdfgfkjsrdkjgkshkdfjgkshdjkfgjshkjdfhgskjdhfkjgjsdhkjgkshdkjfhgjshkjdhfgkjdhfgjshdkjfhgjshkjdhfgskjdhghskjhdfkgksjdhfkghskdjhfgskjdhfgshjkdhfgjshkjdfhgjdshkjfgkjsdhkfjgksjdhfjsdhkjghksjhdfjhsdjhgkshkjfhjgshkdjfgjsdhkjgsdhjkfgdfgdfgdfgdfgdfgdfgdfgdfgdfgdfgdfgdfgdfgdfgdfgdfgdfgdfgdfgdfgdfgdfgdfgdfggdfgredgt tger tre tretretgretgretretertretretretretretre tre tre t ret re tre t ret retg re t ret re tge rt re t ert wre t er t ert re t ret re t reter t re tert   -->';
	exit;
}

#clean the post variables
function Clean($value)
{
	$value = preg_replace('/\\n/','',$value);
	$value = preg_replace('/\\r/','',$value);
	$value = addslashes($value);
	return $value;
}

function http_gett($url, $cookies,$search_engine) 
 { 
 /*Parsing the given url*/ 
      $url_info = parse_url($url); 
  
 /*Building referrer*/ 
      $referrer = $url; 
  
 /*Making string from $cookies*/ 
      $values = array(); 
      $cookie_string = ""; 

    /*  foreach($cookies as $key=>$value) 
      { 
           $values[] = "$key=".urlencode($value); 
           $cookie_string = implode("; ",$values); 
      } */
  
 /*Find out which port is needed - if not given use standard (=80)*/ 
      if(!isset($url_info["port"])) 
      { 
           $url_info["port"]=80; 
      } 
  
 /*Building POST-request:*/ 
      $request = ""; 
      $request.= "GET ".$url." HTTP/1.1\r\n"; 
			 $request.= "Host: ".@$url_info["host"]."\r\n"; 
      $request.= "Referer: ".$referrer."\r\n"; 
 
			 switch($search_engine)
			 {
					case 'google':
						$request.= "User-Agent: Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)\r\n"; 
					break;
					
					case 'yahoo':
					$request.="User-Agent:	Mozilla/5.0 (compatible; Yahoo! Slurp; http://help.yahoo.com/help/us/ysearch/slurp)\r\n";
					break;
					
					case 'msn':
						
					break;
					case 'ask':
						
					break;
			 }
			$request.= "Cookie: ".$cookie_string."\r\n"; 
      $request.= "Connection: close\r\n"; 
      $request.= "\r\n"; 
  
      $proxy["host"] = $url_info["host"]; 
      $proxy["port"] = $url_info["port"]; 
      $fp = @fsockopen($proxy["host"], $proxy["port"], $num, $error, 10); 
      $start = time(); 
      $timeout = false; 
      if($fp) 
      { 
           stream_set_timeout($fp, 30); 
           $result = ""; 
           fputs($fp, $request); 
           while(!feof($fp)) 
           { 
                set_time_limit(0); 
                $result.= fgets($fp, 128); 
                if(time() - $start > 30){ 
 /*Abort after 30 seconds.*/ 
                     $timeout = true; 
                     break; 
                } 
           } 
           fclose($fp); 
           if($timeout) 
           { 
                return "TIMEOUT"; 
           } 
           else{ 
                return $result; 
           } 
      } 
      else{ 
           return "FAILED"; 
      } 
 }
 function text_best_fit($string,$max_length)
 {//echo $string;
	if(strlen($string)>$max_length)
	{	$string = strrev(stristr(strrev(substr($string,0,$max_length)),' ')); } 

	//return strip_tags(ucfirst($string));
	$string = ucfirst($string);
	$string = preg_replace("/([.!?]\s*\w)/e", "strtoupper('$1')", $string);
	return strip_tags($string);
 }
 
 function SecurityImageGeneral($security_code,$security_id)
	{
		global $db;
		$query = "SELECT * FROM security_codes 
							WHERE id = '$security_id' AND code='$security_code'";
		$db->query($query);
		if($db->num_rows() == 1)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	function GenerateAlias($name)
	{
		$fname = trim($name);
		$fname = str_replace(".","",$fname);
		$fname = str_replace("'","",$fname);
		$fname = ereg_replace("[^a-zA-Z0-9 ]", "", $fname);
		$fname = str_replace(" ","-",$fname);
		return $fname;

	}
function CheckLink($test_link)
{
		global $db;$info=array();
		$query = "SELECT * FROM redirect_links 
							WHERE old_link = '".addslashes($test_link)."'";
		$db->query($query);
		if($db->affected_rows()>0)
		{
			$db->next_record();
			$info['response']="Y";
			$info['new_url']=$db->f('new_link');
		}
		else
		{
			$info['response']="N";
		}
		
		$ip=GetUserIP();
		if($ip =="79.116.51.130")
		{
				if(strpos($test_link,"/")!==FALSE)
				{
					
					$get_modules = explode("/",$test_link);
					if(isset($get_modules[0])&&($get_modules[1]==""))
					{
						$info['new_url']="http://www.dentistonline.ro/".$get_modules[0].".html";
						$info['response']="Y";
					}
					elseif(isset($get_modules[0])&&($get_modules[1]!="")&&($get_modules[2]=="")&&(strpos($get_modules[1],'.html')==FALSE))
					{
						$info['new_url']="http://www.dentistonline.ro/".$get_modules[0]."/".$get_modules[1].".html";
						$info['response']="Y";
					}
					
					
				}
		}
		return $info;
}

/**
 * add visitor IP record into DB
 * @param string $v_ip
 * @return void
 */
function AddVisitorIP ($v_ip)
{
	$db = Zend_Registry::get('database');
	if(!isset($_COOKIE['visitors']) || $_COOKIE['visitors']=='')
	{
		## set the cookie for 180 days
		setcookie('visitors', $v_ip ,time()+(1 * 24 * 60 * 60), "/", ".dentistonline.ro",0);
		$new = false;
		$browser = GetUserAgent();
		$refferer = GetReferer();
		$select = $db->select()
						->from('visitors')
						->where('IP = ?', $v_ip);
		$results = $db->fetchAll($select);
		if(count($results)>0) $new = false;
 		else $new = true;

		# unique IP
		if($new)
		{
			$data = array('IP' => $v_ip, 'browser' => $browser, 'refferer' => $refferer, 'date' => new Zend_Db_Expr('NOW()'));
			$db->insert('visitors', $data);
		}
	}
}

/*
 * here we update the no of hits for the phone NO based on a cookie set for 30min
 * @access public
 * @param int $id
 * @return void
*/
function updateCabinePhoneViews($id,$tip_element)
{
	 //echo $id." ".$tip_element; exit;
	global $db;
	if($tip_element=="cabinet")
	{
		if(!isset($_COOKIE['cabinet_phone_view_'.$id]) || $_COOKIE['cabinet_phone_view_'.$id]=='')
		{
			## set the cookie for 3min
			setcookie('cabinet_phone_view_'.$id, $id ,time()+180, "/", ".dentistonline.ro",0);
			$sql = "UPDATE `cabinete` SET `phone_views`=`phone_views`+1 WHERE `id`='".$id."'";
			$db->query($sql);
		}
	}
	if($tip_element=="anunt")
	{
		if(!isset($_COOKIE['anunt_phone_view_'.$id]) || $_COOKIE['anunt_phone_view_'.$id]=='')
		{
			## set the cookie for 3min
			setcookie('anunt_phone_view_'.$id, $id ,time()+180, "/", ".dentistonline.ro",0);
			$sql = "UPDATE `cabinete` SET `phone_views`=`phone_views`+1 WHERE `id`='".$id."'";
			$db->query($sql);
		}
	}
	if($tip_element=="articol")
	{
		if(!isset($_COOKIE['articol_phone_view_'.$id]) || $_COOKIE['articol_phone_view_'.$id]=='')
		{
			## set the cookie for 3min
			setcookie('articol_phone_view_'.$id, $id ,time()+180, "/", ".dentistonline.ro",0);
			$sql = "UPDATE `cabinete` SET `phone_views`=`phone_views`+1 WHERE `id`='".$id."'";
			$db->query($sql);
		}
	}

}

function CountTotalRecordsNotCabs($module)
{
	global $db;
	$query = "SELECT * FROM ".$module."
						WHERE status='1' ";
	$db->query($query);
	return $db->affected_rows();
}

function getCabinetMapCoords($id)
{
	$db = Zend_Registry::get('database');
	$select = $db->select()
					->from('cabinete_coord')
					->where('cabinet_id = ?', $id);
	$results = $db->fetchRow($select);
	return $results;
}

function formatGmapAddress($adr, $loc)
{
	$localitate = $loc['name'];
	if($loc['judet_code']=='B')
	{
		$adr = str_replace($localitate,"", $adr);
		$adr = str_ireplace('bucuresti',"", $adr);
		$adr.= ", ".$localitate.",Bucuresti Romania";
	}
	else 
	{
		$adr = str_replace($localitate,"", $adr);
		$adr.= ", ".$localitate.", Romania";
	}
	return urlencode($adr);
}

function displayResponsiveBreadcrumb($tags)
{
	global $tpl;
	$tpl->set_file('tpl_breadcrumb', 'menus/navigation.tpl');
	$tpl->set_block('tpl_breadcrumb', 'list_breadcrumb', 'list_breadcrumb2');
	if(!empty($tags['title']))
	{
		$str = explode("<a ", $tags['title']);
		foreach ($str as $key => $value)
		{
			if(!empty($value))
			{
				$tpl->set_var('BREADCRUMB', '<a '.$value);
				$tpl->parse('list_breadcrumb2', 'list_breadcrumb', true);
			}
		}
	}
	else $tpl->parse('list_breadcrumb2', '');
	$tpl->parse('NAVIGATION', 'tpl_breadcrumb');
}

/**
 * here we add the read more BOOTSTRAP collapse button
 * @access public
 * @param string $string
 * @param string $div
 * @return string
 */
function addReadMore($string, $div)
{
	$limit = '500';
	$descriere = "";
	if(!empty($string) && strlen($string)>$limit)
	{
		$first_split = substr($string, 0, $limit);
		$second_split = substr($string, $limit, strlen($string));
		$space = strpos($second_split," ");
		if($space!==false)
		{
			$first_poz = $limit + $space;
		}
		else 
		{
			// this means the remaining text after split is too small so..do not add read more
			$first_poz = 0;
		}
		
		if($first_poz!=0)
		{
			// add the expand plugin for view more
			$descriere = substr($string,0, $first_poz).'&nbsp;<a href="#'.$div.'" class="btn btn-info btn-xs" data-toggle="collapse">citeste tot</a>
															<span id="'.$div.'" class="collapse list-inline"> '.substr($string,$first_poz, strlen($string)).'</span>';
		}
		else $descriere = $string;
	}
	else $descriere = $string;
	return $descriere;
}

/**
 * redirecto to cabinet for those who came from emails
 */
function redirectToCabinetFromEmail($cab_id)
{
	$get_has_cab = GetSelectedCabinet(intval($cab_id));
	if(!empty($get_has_cab))
	{
		header("Location: ".ReWrite('cabinete_detalii', 'cabinete.detalii.'.intval($cab_id)));
		exit;
	}
}

/**
 * here we add feedback for sugestii / pareri
 * @access public
 * @param array $data
 * @return boolean
 */
function addFeedback($data)
{
	$db = Zend_Registry::get('database');
	$db->insert('feedback', $data);
	return true;
}

/**
 * here we set the cookie oferta modal and we show/hide it
 * @param none
 * @return boolean
 */
function showOfertaModal()
{
	return false;
	/*if(!isset($_COOKIE['oferta_modal']) || $_COOKIE['oferta_modal']=='')
	{
		## set the cookie for 30mins
		setcookie('oferta_modal', GetUserIP() ,time()+1800, "/", ".dentistonline.ro",0);
		return true;
	}
	else return false;*/
}

/**
 * here we set the cookie oferta modal and we show/hide it
 * @param none
 * @return boolean
 */
function showFreeUserModal()
{
	if(!isset($_COOKIE['free_user_modal']) || $_COOKIE['free_user_modal']=='')
	{
		## set the cookie for 2days
		setcookie('free_user_modal', GetUserIP() ,time()+(2 * 24 * 60 * 60), "/", ".dentistonline.ro",0);
		return true;
	}
	else return false;
}

 ?>
