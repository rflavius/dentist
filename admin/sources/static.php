<?php
/*------------------------------------------------------------------------------------------------
	|		dotBoost Self Managed Content | SMC Users Framework | support@dotboost.com
	+---------------------------------------------------------------------------
	|		SMC Users Framework IS NOT FREE SOFTWARE!
	+---------------------------------------------------------------------------
	|		Name : admin/static.php
	|		Date started: Aug 3 2006
	|		Description : home page information
	|		Version : 0.9
	+---------------------------------------------------------------------------------------------*/
switch ($action)
{
	
	case 'home':
		
	/*insert images defalut into images table 
	global $db; 
		$query = "SELECT id FROM cabinete Order by id ASC";
		$db->query($query);
		$i = 1;
		$cabinet = array();
			while ($db->next_record())
			{
				$cabinet[$i]['id'] = $db->f('id');
				$i++;
			}	
			foreach($cabinet as $ky => $val)
			{
					$query = "SELECT id FROM images Where folder_id='".$val['id']."'  and type='cabinet'";
					$db->query($query);
					if($db->affected_rows()<1)
					{
						echo $val['id']."a<br>";
							$sql = "INSERT INTO images(`image_name`, `folder_id`, `type`,`position`) VALUES ('default.jpg','".$val['id']."','cabinet','1')";
							$db->query($sql);
					}
			
			}
print_r(count(($cabinet)));exit;*/

		switch($admin->level)
		{
			case '1':
				$tpl->set_file('tpl_home', 'static/home.tpl');
				$tpl->set_var("MAIN_TITLE", "Admin Control Panel Main Page");
				
				#today statistics
				$tpl->set_var('COUNT_TODAY_USERS', CountToday('users'));
				$tpl->set_var('COUNT_TODAY_CABINETE', CountToday('cabinete'));
				$tpl->set_var('COUNT_TODAY_ANUNTURI',CountToday('anunturi'));
				$tpl->set_var('COUNT_TODAY_ARTICOLE',CountToday('articole'));
				$tpl->set_var('COUNT_TODAY_VIZITATORI', CountToday('vizitatori')); 
				$tpl->set_var('COUNT_MESAJE',CountToday('mesajeadmin'));
				$tpl->set_var('COUNT_MESAJE_UTILIZATORI',CountToday('mesjutilizator') );
				$mesaje_utilizator = CountToday('mesjutilizator');
				$articole = CountArticlesTotalRecords ("all","all");
				
				$gmap = new Dentist_Gmap();
				# GMAP statistics
				$tpl->set_var('COUNT_GMAP_NOTDONE', $gmap->countCabineteCoordonate('N'));
				$tpl->set_var('COUNT_GMAP_DONE', $gmap->countCabineteCoordonate('Y'));
				$tpl->set_var('COUNT_GMAP', $gmap->countCabineteCoordonate());
				
				
				#statistics
				$tpl->set_var('COUNT_PAGES', CountPages());
				$tpl->set_var('COUNT_CABINETE', CountCabineteTotalRecords('-1', ''));
				$tpl->set_var('COUNT_NEWS', CountNews()); 
				$tpl->set_var('COUNT_LINKS', CountLinks());
				$mesaje = CountMessages();

				#users statistics
				$tpl->set_var('COUNT_ACTIVE_USERS', CountUsers("creation_date_desc","1"));
				$tpl->set_var('COUNT_INACTIVE_USERS', CountUsers("creation_date_desc","0"));
				$tpl->set_var('COUNT_ALL_USERS',CountUsers("creation_date_desc","all"));
				$users = CountUsers("creation_date_desc","all");
				#anunturi statistics
				$tpl->set_var('COUNT_ACTIVE_ANUNTURI', CountAnunturi('all','1'));
				$tpl->set_var('COUNT_INACTIVE_ANUNTURI', CountAnunturi('all','0'));
				$tpl->set_var('COUNT_ALL_ANUNTURI',CountAnunturi('all','all'));
				$anunturi = CountAnunturi('all','all');

				#contracte statistics
				$tpl->set_var('COUNT_ACTIVE_CONTRACTE', CountContracte('adaugare_contract_desc','Y'));
				$tpl->set_var('COUNT_INACTIVE_CONTRACTE', CountContracte('adaugare_contract_desc','N'));
				$tpl->set_var('COUNT_ALL_CONTRACTE',CountContracte('adaugare_contract_desc','all'));
				
				#facturi proforme statistics
				$tpl->set_var('COUNT_PROFORME_PLATITE', CountProforme('adaugare_proforma_asc_desc','Y:all'));
				$tpl->set_var('COUNT_PROFORME_NEPLATITE_ACTIVE', CountProforme('expirare_proforma_desc','N:Y'));
				$tpl->set_var('COUNT_PROFORME_NEPLATITE_INACTIVE',CountProforme('expirare_proforma_desc','N:N'));
				$tpl->set_var('COUNT_ALL_PROFORME',CountProforme('adaugare_proforma_desc','all:all'));
				$facturi_proforme = CountProforme('adaugare_proforma_desc','all:all');
				
				#facturi fiscale
				$tpl->set_var('COUNT_FISCALE_ACTIVE', CountFiscale('data_eliberarii_desc','all:Y'));
				$tpl->set_var('COUNT_FISCALE_INACTIVE', CountFiscale('data_eliberarii_desc','all:N'));
				$tpl->set_var('COUNT_FISCALE_TRIMISE', CountFiscale('data_eliberarii_desc','Y:all'));
				$tpl->set_var('COUNT_FISCALE_NETRIMISE',CountFiscale('data_eliberarii_desc','N:all'));
				$tpl->set_var('COUNT_ALL_FISCALE',CountFiscale('data_eliberarii_desc','all:all'));
				$facturi_fiscale = CountFiscale('data_eliberarii_desc','all:all');
				
				#cabinete statistics2
				$tpl->set_var('COUNT_CABINETE_STOMATOLOGICE', CountCabineteTotalRecords("module", '1'));
				$tpl->set_var('COUNT_RADIOLOGIE_DENTARA',CountCabineteTotalRecords("module", '3'));
				$tpl->set_var('COUNT_TEHNICA_DENTARA',CountCabineteTotalRecords("module", '2'));
				$tpl->set_var('COUNT_DISTRIBUITORI',CountCabineteTotalRecords("module", '4'));
				$tpl->set_var('COUNT_CLINICI_STOMATOLOGICE',CountCabineteTotalRecords("module", '5')); 
				$cabinete = CountCabineteTotalRecords('-1', '');
				$array_all_stuffs = array('users'=>$users,'anunturi'=>$anunturi,'facturi_proforme'=>$facturi_proforme,'cabinete'=>$cabinete,'mesaje'=>$mesaje,'facturi_fiscale'=>$facturi_fiscale,'articole'=>$articole,'mesaje_utilizator'=>$mesaje_utilizator);
				$_SESSION['values_new'] = $array_all_stuffs;
				$get_new = GetNewStuffs();

				
				$tpl->set_var('LASTUPDATE',AdminTimeFormat($get_new['date_a'] ,"N"));
				$time_difference = strtotime("now")-strtotime($get_new['date_a']);
				$day_seconds = 3600*20;
				if($time_difference>$day_seconds)
				{
					$tpl->set_var('CLASS_UPDATE',"style=\" color:red;text-decoration:blink\"" );
				}

				foreach($get_new as $ky => $val)
				{
					
					if($ky!="date_a")
					{
						if($array_all_stuffs[$ky]>$val)
						{
						$tpl->set_var('NEW_IMAGE_'.strtoupper($ky),"<img style=\"padding-left:15px\" src=\"../images/allstufs/new.jpg\">" );
						}
					}
					
				}
				//<img style="padding-left:15px" src="../images/allstufs/new.jpg">
				//$tpl->set_var('NEW_IMAGE_', );
				
				#system overview
				$tpl->set_var("MYSQL", $db->get_version());
				$tpl->set_var("PHP", phpversion());
				$tpl->set_var("PHPAPI", php_sapi_name());
				# Messages
				$tpl->set_block('tpl_home', 'messages', 'messages_block');
				$tpl->set_block('tpl_home', 'if_messages', 'if_messages_block');
				#if we have information messages
				if (isset($_SESSION['admin_info']))
				{
					$tpl->set_file('tpl_info', 'info/'.$_SESSION['admin_info_type'].'.tpl');
					$tpl->set_var('MESSAGE', $_SESSION['admin_info']);
					$tpl->parse('INFORMATION', 'tpl_info');
					#uset sessions
					unset($_SESSION['admin_info']);
					unset($_SESSION['admin_info_type']);
				}
				#get admin messages
				$get_admin_messages = GetAdminMessages();
				$i = 0;
				if (count($get_admin_messages) != '0')
				{
					while (list($k, $v) = each($get_admin_messages))
					{
						$bc = ($i % 2)+1;
						$tpl->set_var("BGCOLOR",'row'.$bc);
						$tpl->set_var('ID', $v['id']);
						$tpl->set_var('MESSAGE', stripslashes($v['msg']));
						$tpl->set_var('DATE', TimeFormatShort($v['date']));
						$tpl->set_var('EXP', GetTheExpeditor($v['exp']));
						$tpl->parse('messages_block', 'messages', true);
						$i++;
					}
					$tpl->parse('if_messages_block', 'if_messages', true);
				}
				#writables folders
				$tpl->set_block("tpl_home", "writable_folders", "writable_folders_block");
				$server_path = "http://".$_SERVER["HTTP_HOST"];
				$php_self = str_replace("/admin/index.php", "", $_SERVER["PHP_SELF"]);
				$server_path = $server_path.$php_self;
				$writable_folders = array("../images/uploaded_photos/","../images/users_cabinete/","../images/users_anunturi/");
				foreach ($writable_folders as $key => $val)
				{
					$tpl->set_var("FOLDER_STATUS", "inactive.png");
					$tpl->set_var("IMAGE_TITLE", "The current folder is not writable");
					if (is_writable($val))
					{
						$tpl->set_var("FOLDER_STATUS", "active.png");
						$tpl->set_var("IMAGE_TITLE", "The current folder is writable");
					}
					$no_dots_folder = str_replace("..", "", $val);
					$folder_name = $server_path.$no_dots_folder;
					$tpl->set_var("FOLDER_NAME", $folder_name);
					$tpl->parse("writable_folders_block", "writable_folders", true);
				}
				#sitemap statistics
				$sitemap_info = explode(",", $conf->sitemap_info);
				$tpl->set_var("SITEMAP_PAGES", $sitemap_info['0']);
				$tpl->set_var("SITEMAP_GENERATED", TimeFormatShort($sitemap_info['1']));
				$tpl->parse('MAIN', 'tpl_home');
			break;

			case '2':
				$tpl->set_file('tpl_home', 'static/home_marketing.tpl');
				$tpl->set_var("MAIN_TITLE", "Admin Control Panel Main Page");
				$tpl->parse('MAIN', 'tpl_home');
			break;
		}


	break;

	case 'delete':
		DeleteSelectedItem('admin_messages', 'id', intval($param1));
		$_SESSION['admin_info'] = 'Message successfully deleted.';
		$_SESSION['admin_info_type'] = 'info';
		header ('location: '.$_SERVER['HTTP_REFERER']);
		exit;
	break;

	case 'add':
		if (trim($_POST['message']) == "")
		{
			$_SESSION['admin_info'] = 'Please provide content for your message.';
			$_SESSION['admin_info_type'] = 'error';
			header ('location: '.$_SERVER['HTTP_REFERER']);
			exit;
		}
		InsertAdminMessage(addslashes($_POST['message']));
		$_SESSION['admin_info'] = 'Message successfully added.';
		$_SESSION['admin_info_type'] = 'info';
		header ('location: '.$_SERVER['HTTP_REFERER']);
		exit;
	break;
	
	case 'update':
		$query ="Update new_stuffs set users='".$_SESSION['values_new']['users']."',anunturi='".$_SESSION['values_new']['anunturi']."',facturi_proforme='".$_SESSION['values_new']['facturi_proforme']."',cabinete='".$_SESSION['values_new']['cabinete']."',mesaje='".$_SESSION['values_new']['mesaje']."',articole='".$_SESSION['values_new']['articole']."',mesaje_utilizator='".$_SESSION['values_new']['mesaje_utilizator']."',date_a=now()";
		$db->query($query);
		header ('location: '.$_SERVER['HTTP_REFERER']);
		exit;
	break;

	case 'generatexml':
		$dentist_categories = Get_Dentist_Cats(-1);
		foreach($dentist_categories as $ky => $val)
		{
			$module_name = strtolower(str_replace(" ","_",$val['name']));
			$module_id = $val['id'];
			switch($val['name'])
			{
				default:
					$module_description= $val['name']." din";
				break;
				case 'Tehnica dentara':
					$module_description= "Laboratoare tehnica dentara din";
				break;
				
				case 'Radiologie Dentara':
					$module_description= "Laboratoare de radiologie dentara din";
				break;
	
			}
				GenerateXmlOnJudete($module_name,$module_id,$module_description);
			}
		header ('location: '.$_SERVER['HTTP_REFERER']);
		exit;
	break;

	case 'generatexmlmodule':
		$dentist_categories = Get_Dentist_Cats(-1);
		foreach($dentist_categories as $ky => $val)
		{
			$module_name = strtolower(str_replace(" ","_",$val['name']));
			$module_id = $val['id'];
			switch($val['name'])
			{
				default:
					$module_description= $val['name'];
				break;
				case 'Tehnica dentara':
					$module_description= "Laboratoare tehnica dentara";
				break;
				
				case 'Radiologie Dentara':
					$module_description= "Laboratoare de radiologie dentara";
				break;
	
			}
				GenerateXmlOnModules($module_name,$module_id,$module_description);
			}
		header ('location: '.$_SERVER['HTTP_REFERER']);
		exit;
	break;

	case 'generatebigfeed':
		GenerateBigFeed();
		header ('location: '.$_SERVER['HTTP_REFERER']);
		exit;

	break;
}
?>