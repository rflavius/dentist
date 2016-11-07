<?php
/**
 * here we will handle the backend part for GMAP
 *  
 */

$gmap = new Dentist_Gmap();

switch ($action)
{
	default:
		$tpl->set_file('tpl_list', 'gmap/list.tpl');
		$tpl->set_var('MAIN_TITLE', 'List GMAP Coordonates status for: cabinete , laboratoare, clinici din Romania');
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
		
		$status = (isset($_GET['status']) && !empty($_GET['status'])) ? $_GET['status'] : false;
		#check if the selected parent is a category or a module
		$total_records = $gmap->countCabineteCoordonate($status);

		if($status===false)
		{
			$tpl->set_var('ALL_STATUS', 'selected');
			$tpl->set_var('Y_STATUS', '');
			$tpl->set_var('N_STATUS', '');
		}
		elseif($status=='Y')
		{
			$tpl->set_var('ALL_STATUS', '');
			$tpl->set_var('Y_STATUS', 'selected');
			$tpl->set_var('N_STATUS', '');
		}
		else 
		{
			$tpl->set_var('ALL_STATUS', '');
			$tpl->set_var('Y_STATUS', '');
			$tpl->set_var('N_STATUS', 'selected');
		}
		#cabinete count
		$tpl->set_var('COUNT_CABINETE', $total_records);
		$pages_number = ceil($total_records/$conf->admin_cabinete_per_page);
		$tpl->set_var("PAGES", $pages_number);
		#create de pagination page_name
		
		$page_name = ($status!==false) ? $module.'&status='.$status : $module;
		
		if(isset($_GET['start'])&&($_GET['start']!=""))
		{
			$start = $_GET['start'];
			$start_q = $conf->admin_cabinete_per_page*($start-1);
		}
		else
		{
			$start_q = 0;
			$start = 1;
		}

		#Create and parse pagination
		$html_pages = AdminPaginationCabineteAnuntArticole($conf->admin_cabinete_per_page, $total_records, $page_name, $start,'');
		$tpl->set_var("PAGINATION", $html_pages);
		$tpl->set_var("PAGE_NAME",$page_name );
		
		#Set blocks
		$tpl->set_block('tpl_list', 'list_cabinete', 'list_cabinete_block');
		#Create query limit and get the cabinete for displaing
		$query_limit[] = $conf->admin_cabinete_per_page;
		$query_limit[] = $start_q;
		
		$cabinete = $gmap->listCabineteCoordonate($query_limit, $status);
		if (count($cabinete)>'0')
		{
			$i = $start_q+1;
			foreach ($cabinete as $key => $v)
			{
				#set colors
				$bc = ($i % 2)+1;
				$tpl->set_var("BGCOLOR",'row'.$bc);
				
				$tpl->set_var('NR', $i);
				$tpl->set_var('CAB_ID', $v['id']);
				$tpl->set_var('ID', $v['coord_id']);
				$tpl->set_var('NUME_CABINET', $v['nume_firma']);
				$tpl->set_var('GMAP_ADDRESS', $v['address']);
				$tpl->set_var('GMAP_LAT', $v['lat']);
				$tpl->set_var('GMAP_LNG', $v['lng']);

				if ($v['gmap_status'] == 'Y')
				{
					$tpl->set_var('IMAGE', 'active.png');
					$tpl->set_var('IMAGE_TITLE', 'Gmap coordonates are done');
				}
				else
				{
					$tpl->set_var('IMAGE', 'inactive.png');
					$tpl->set_var('IMAGE_TITLE', 'Gmap coordonates are NOT done');
				}
				$tpl->set_var('PARENT_MODULE', GetCabinetParents($v['id']));
				$tpl->set_var('LINK_TO_CABINET', ReWrite('cabinete_detalii', 'cabinete.detalii.'.$v['id']));
				
				$tpl->parse('list_cabinete_block', 'list_cabinete', true);
				$i++;
			}
		}
		else 
		{
			$tpl->parse('list_cabinete_block', '');
		}
		$tpl->parse('MAIN', 'tpl_list');
	break;
	
	case 'generate':
		if(isset($_POST['resend']))
		{
			$adr = $_POST['adresa'];
			$ch = curl_init();
			// set URL and other appropriate options
			curl_setopt($ch, CURLOPT_URL, 'http://maps.googleapis.com/maps/api/geocode/json?address={'.urlencode($adr).'}&sensor=false&language=en');
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			// grab URL and pass it to the browser
			$r = curl_exec($ch);
			//print_r($r);exit;
			// close cURL resource, and free up system resources
			curl_close($ch);
			$r = json_decode($r);
			$rez = $r->results;
			if(count($rez)>0)
			{
				// if we have multiple results
				if(count($rez)>1)
				{
					$tpl->set_file("tpl_main", "gmap/generate.tpl");
					$_SESSION['admin_info_type'] = 'warning';
					$_SESSION['admin_info'] = "Am gasit mai multe locatii ce corespund adresei introduse de dvs:";
					foreach ($rez as $key => $value)
					{
						$string = iconv('UTF-8', 'ASCII//TRANSLIT', $value->formatted_address);
						$_SESSION['admin_info'].= "<div class='multiple_adr_selector'><a onClick='changeAddress(\"".$string."\")' >".$string."</a></div>";
					}
					
					
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
					
					$tpl->set_var('ADRESA', $_POST['adresa']);
					$tpl->set_var('JUDET', $_POST['judet']);
					$tpl->set_var('LOCALITATE', $_POST['localitate']);
					$tpl->set_var('ID', $_POST['cabinet_id']);
					$tpl->parse('MAIN', 'tpl_main');
				}
				else 
				{
					// we have a single result
					// add coords
					if($gmap->getCabinetGmap($_POST['cabinet_id'])!==false)
					{
						//we have it..we need to update
						$data = array(
										'lat' => $r->results[0]->geometry->location->lat,
										'lng' => $r->results[0]->geometry->location->lng,
										'judet' => $_POST['judet'],
										'localitate' => $_POST['localitate'],
										'address' => $_POST['adresa']
									);
						$where = array('cabinet_id = ?' => $_POST['cabinet_id']);
						$gmap->updateCabineteCoordonates($data, $where);
					}
					else 
					{
						// this is new ... we need to add it
						$data = array(
							'cabinet_id' => $_POST['cabinet_id'],
							'lat' => $r->results[0]->geometry->location->lat,
							'lng' => $r->results[0]->geometry->location->lng,
							'judet' => $_POST['judet'],
							'localitate' => $_POST['localitate'],
							'address' => $_POST['adresa']
						);
						$gmap->addCabinetCoordonates($data);
					}
					
					// update cabinet gmap_coord status
					$data = array('gmap_status' => 'Y');
					$where = array('id = ?' => $_POST['cabinet_id']);
					$gmap->updateCabinet($data, $where);
					
					$_SESSION['admin_info_type'] = 'info';
					$_SESSION['admin_info'] = "Locatie GMAP generata cu succes !";
					header("location: index.php?page=gmap&status=N");
					exit;
				}
			}
			else
			{
				$tpl->set_file("tpl_main", "gmap/generate.tpl");
				$_SESSION['admin_info_type'] = 'error';
				$_SESSION['admin_info'] = "Nu s-au gasit rezultate pentru aceasta adresa, va rugam sa curatati adresa.";
				
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
				
				$tpl->set_var('ADRESA', $_POST['adresa']);
				$tpl->set_var('JUDET', $_POST['judet']);
				$tpl->set_var('LOCALITATE', $_POST['localitate']);
				$tpl->set_var('ID', $_POST['cabinet_id']);
				$tpl->parse('MAIN', 'tpl_main');
			}
		}
		else
		{
			$cab = $gmap->selectCabinetToGenerateCoords($param1);
			$tpl->set_file("tpl_main", "gmap/generate.tpl");
			$tpl->set_var('ADRESA', $cab['adresa_firma'].', '.$cab['localitate'].' Romania');
			$tpl->set_var('JUDET', $cab['judet']);
			$tpl->set_var('LOCALITATE', $cab['localitate']);
			$tpl->set_var('ID', $cab['id']);
			$tpl->parse('MAIN', 'tpl_main');
		}
	break;
	
	case 'delete':
		$where = array('id = ?' => $param1);
		$gmap->deleteCoordonate($where);
		$_SESSION['admin_info_type'] = 'info';
		$_SESSION['admin_info'] = "Locatie GMAP stearsa cu succes !";
		header("location: ".GetReferer());
		exit;
	break;
}