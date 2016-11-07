<?php

require_once('preload.php');
$tpl = new Template(TEMPLATES_PATH);
//var_dump($_GET['id']);exit;
switch($_GET['type'])
{
	case 'banner':
		$sql = "UPDATE banner SET `hits`=`hits`+1 WHERE id='".$_GET['id']."'";
		$db->query($sql);
		
		#lets insert only 30 min acces on the same banner with the same ip
		$referer = GetReferer();
		$ip = GetUserIP();
		$useragent = GetUserAgent();
		$date_now = date("Y-m-d H:i:s"); 
		$check_ip = CheckIpBannerAcces($ip,$_GET['id']);
		#if was acces form this ip lets check time (doar daca accesarea  e mai veche de 30min inseram in baza de date)
		if ($check_ip!==false)
		{
			$date_acces = strtotime($check_ip);
			$date_now_convert = strtotime($date_now);
			$dif = 	$date_now_convert - $date_acces; echo $dif."\n";
				#we insert only if has passed 30 min before last acces
				if($date_now_convert - $date_acces > 1800 )
				{
					$sql = "Insert into banner_trafic (id_banner,referer,ip,date,browser) values ('".mysql_real_escape_string($_GET['id'])."','".$referer."','".$ip."','".$date_now."','".$useragent."')";
					$db->query($sql);
				}
			
		}
		else
		{
			$sql = "Insert into banner_trafic (id_banner,referer,ip,date,browser) values ('".mysql_real_escape_string($_GET['id'])."','".$referer."','".$ip."','".$date_now."','".$useragent."')";
			$db->query($sql);
		}
		
	break;

	case 'phone_views':
		#lets insert only 30 min acces on the same ip
		updateCabinePhoneViews($_GET['id'],$_GET['tip_element']);
	break;
	
	case 'oferta_modal':
		if(showOfertaModal())
		{
			$tpl->set_file('tpl_ajax', 'oferta_modal.tpl');
			$tpl->pparse('OFERTA_MODAL','tpl_ajax');
		}
		else $tpl->set_var('OFERTA_MODAL','');
	break;
}


?>