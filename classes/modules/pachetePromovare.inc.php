<?php

 ###########################
 ### here we have all the functions that we need for the new packages: abonament and recomandat !!!!

function check_ip_judet_code($ip_visitor)
{

	global $db; $answer = "";
	$sql = "SELECT * from visitors where ip='".$ip_visitor."'";
	//echo $sql;
	$db->query($sql);
	if($db->num_rows()>0)
	{
		$db->next_record();
		$answer = $db->f('judet_code');
		//$answer['found_ip'] = 
	}
	
	return $answer;

}
##############
## select only cabinete from abonament, untill 10.000 visits, abonament level id is 2
##let take cabs on visitor ip
function getHomePageCabinete()
{
	global $db;
	/*$level = 2; // abonament level id
	$level_details = getPromovareLevelDetails($level);
	$cabinete = array();
	$sql = "SELECT a.*,b.image_name FROM cabinete as a,images as b WHERE  a.id = b.folder_id AND a.`level` LIKE '%".$level."%' AND a.`home_page`<'".$level_details['home_page']."' AND a.`status`='1' AND a.`achitat`='Y'  Group by a.id ORDER BY RAND() LIMIT 8";
	$db->query($sql);
	if($db->num_rows()>0)
	{
		$i=0;
		while($db->next_record())
		{
			$cabinete[$i]['id'] = $db->f('id');
			$cabinete[$i]['nume_firma'] = $db->f('nume_firma');
			$cabinete[$i]['descriere'] = strip_tags($db->f('descriere'));
			$cabinete[$i]['category_id'] = $db->f('category_id');
			$cabinete[$i]['judet'] = $db->f('judet');
			$cabinete[$i]['image_name'] = $db->f('image_name');
			$cabinete[$i]['level'] = $db->f('level');
			$i++;//print_r($cabinete);
			updateCabinetHomePageView($db->f('id'));
		}
	}

	## if we do not have 8 cabinete from abonament get other cabinete
	if(count($cabinete)<8)
	{
		$cab_limit = (8-count($cabinete));
		$sql = "SELECT a.*,b.image_name FROM cabinete as a,images as b WHERE a.id=b.folder_id AND a.`status`='1' AND  b.type<>'harta' AND b.position='1' AND b.image_name<>'default.jpg' GROUP BY a.id ORDER BY RAND() LIMIT ".$cab_limit;
		$db->query($sql);
		if($db->num_rows()>0)
		{
			$i=count($cabinete);
			while($db->next_record())
			{
				$cabinete[$i]['id'] = $db->f('id');
				$cabinete[$i]['nume_firma'] = $db->f('nume_firma');
				$cabinete[$i]['descriere'] = strip_tags($db->f('descriere'));
				$cabinete[$i]['category_id'] = $db->f('category_id');
				$cabinete[$i]['judet'] = $db->f('judet');
				$cabinete[$i]['image_name'] = $db->f('image_name');
				$cabinete[$i]['level'] = $db->f('level');
				$i++;
			}
		}
	}
	*/

	#lets change the display on the first page by ip and region, only the one witch pay will be dispalyed
	$level_details['home_page'] = 600000;
	
	/*
	 * TODO:
	 * - check if cookie is set for the visiting IP: 
	 * if YES:
	 * 			- then retrieve area info from the cookie
	 * if NO: 
	 *			- add new cookie for each visiting IP (give unique cookie name based on it's IP) * make the cookie life time as high as possible(4-5days should be fine)
	 *			- make a call to get all info based on IP from that external resource and store it to cookie 
	 */
	
	//$obj_ip_details = new Gmap_Search();
	//$ip_details = $obj_ip_details->getIpDetails();
	//print_r($ip_details);
	//$region = $ip_details['region'];
	//print_r($obj_ip_details);
	/*$get_judet = GetJudet("name",$region);
	$get_judet['judet_code'] = '';
	if(is_array($get_judet)&&(isset($get_judet['judet_code'])))
	{
		$judet_code = $get_judet['judet_code'];
		$text_to_sql = " AND a.`level`>1 AND a.`judet`='".$judet_code."'";
	
	}
	else
	{
		$text_to_sql = " AND a.`level`>1";
	}*/
		
	 //$_SERVER['REMOTE_ADDR']="79.117.19.249";
	//return the judet code
	$check_judet_for_ip = check_ip_judet_code($_SERVER['REMOTE_ADDR']);
	//var_dump($check_judet_for_ip);
	if(isset($check_judet_for_ip)&&($check_judet_for_ip!=""))
	{
		$the_code = $check_judet_for_ip;
	}
	else
	{
		// comment to see if from here comes the error 500, here we get the ip of the user
		/*
		$location = file_get_contents('http://freegeoip.net/json/'.$_SERVER['REMOTE_ADDR']);
		$get_judet_code = explode("region_code",$location); 
		$get_judet_codee = explode(",",$get_judet_code['1']);
		$the_code = str_replace("\"","",$get_judet_codee['0']);
		$the_code = str_replace(":","",$the_code);
		$sql = "Update visitors set judet_code='".$the_code."' where ip='".$_SERVER['REMOTE_ADDR']."'";
		$db->query($sql);*/
	}

	//print_r($_SERVER['REMOTE_ADDR']);
	// try to get location with oteher site witch allow 10.000 acces by hour 

	//print_r($get_judet);
	
	if(isset($the_code)&&($the_code!=""))
	{
		$judet_code = $the_code;
		$text_to_sql = " AND a.`level`>1 AND a.`judet`='".$judet_code."'";
		$judet_to_sql = "AND a.`judet`='".$judet_code."'";
	}
	else
	{
		$text_to_sql = " AND a.`level`>1";
		$judet_to_sql = "";
	}

	
	//echo $text_to_sql;
	$cabinete = array();
	$sql = "SELECT a.*,b.image_name FROM cabinete as a,images as b WHERE  a.id = b.folder_id ".$text_to_sql." AND b.position='1' AND a.`home_page`<'".$level_details['home_page']."' AND a.`status`='1' AND a.`achitat`='Y' OR a.id='473'  Group by a.id ORDER BY RAND() LIMIT 9";
	$db->query($sql);
	if($db->num_rows()>0)
	{
		$i=0;
		while($db->next_record())
		{
			$cabinete[$i]['id'] = $db->f('id');
			$cabinete[$i]['nume_firma'] = $db->f('nume_firma');
			$cabinete[$i]['descriere'] = strip_tags($db->f('descriere'));
			$cabinete[$i]['category_id'] = $db->f('category_id');
			$cabinete[$i]['judet'] = $db->f('judet');
			$cabinete[$i]['image_name'] = $db->f('image_name');
			$cabinete[$i]['level'] = $db->f('level');
			$i++;//print_r($cabinete);
			updateCabinetHomePageView($db->f('id'));
		}
	}

	## if we do not have 8 cabinete witch pay on this county get other cabinete from the same county
	if(count($cabinete)<8)
	{
		//echo "b";
		$cab_limit = (8-count($cabinete));
		$sql = "SELECT a.*,b.image_name FROM cabinete as a,images as b WHERE a.id=b.folder_id ".$judet_to_sql." AND a.`status`='1' AND a.level='1' AND  b.type<>'harta' AND b.position='1' AND b.image_name<>'default.jpg'  GROUP BY a.id ORDER BY RAND() LIMIT ".$cab_limit;
		$db->query($sql);
		if($db->num_rows()>0)
		{
			$i=count($cabinete);
			while($db->next_record())
			{
				$cabinete[$i]['id'] = $db->f('id');
				$cabinete[$i]['nume_firma'] = $db->f('nume_firma');
				$cabinete[$i]['descriere'] = strip_tags($db->f('descriere'));
				$cabinete[$i]['category_id'] = $db->f('category_id');
				$cabinete[$i]['judet'] = $db->f('judet');
				$cabinete[$i]['image_name'] = $db->f('image_name');
				$cabinete[$i]['level'] = $db->f('level');
				$i++;
			}
		}
	}
	//echo $sql;
	##if we are on a county witch doesn't have cabinete then we take them all
	if(count($cabinete)<8)
	{//echo "a";
		$cab_limit = (8-count($cabinete));
		$sql = "SELECT a.*,b.image_name FROM cabinete as a,images as b WHERE a.id=b.folder_id AND a.`status`='1' AND  b.type<>'harta' AND b.position='1' AND b.image_name<>'default.jpg' GROUP BY a.id ORDER BY RAND() LIMIT ".$cab_limit;
		$db->query($sql);
		if($db->num_rows()>0)
		{
			$i=count($cabinete);
			while($db->next_record())
			{
				$cabinete[$i]['id'] = $db->f('id');
				$cabinete[$i]['nume_firma'] = $db->f('nume_firma');
				$cabinete[$i]['descriere'] = strip_tags($db->f('descriere'));
				$cabinete[$i]['category_id'] = $db->f('category_id');
				$cabinete[$i]['judet'] = $db->f('judet');
				$cabinete[$i]['image_name'] = $db->f('image_name');
				$cabinete[$i]['level'] = $db->f('level');
				$i++;
			}
		}
	}
	return $cabinete;
}

function getPromovareLevelsArray()
{
	global $db;
	$sql = "SELECT * FROM level";
	$db->query($sql);
	if($db->num_rows()>0)
	{
		$i=0;
		while($db->next_record())
		{
			$info[$i] = $db->f('id');
			$i++;
		}
		return $info;
	}
}

##############
## get level details for a specific level
function getPromovareLevelDetails($level)
{
	global $db;
	$info='';
	$expected = array('id', 'name', 'pret', 'perioada', 'images', 'servicii_tarife', 'video', 'afisare_in_fata', 'anunturi', 'home_page', 'recomandam_banner', 'recomandam_articole');

	$sql = "SELECT * FROM level WHERE id='$level'";
	$db->query($sql);
	while($db->next_record())
	{
		foreach($expected as $ky)
		{
			$info[$ky] = $db->f($ky);
		}
	}
	return $info;
}

##############
## update the home_page column for this cabinet_id
function updateCabinetHomePageView($cab_id)
{
	global $db2;
	$sqll = "UPDATE cabinete SET `home_page`=`home_page`+1 WHERE id='$cab_id'";
	$db2->query($sqll);
}

##############
## get banners for the right side for abonament
function getRecomandBanner()
{
	global $db;
	$level = 2; // abonament level id
	$level_details = getPromovareLevelDetails($level);
	$info=array();
	$sql = "SELECT a.*,b.nume_firma FROM banner as a,cabinete as b WHERE a.recomandam_banner<a.total_afisari AND a.cabinet_id=b.id AND b.status='1' AND b.`achitat`='Y' AND b.level LIKE '%".$level."%' ORDER BY RAND() LIMIT 2";

	$db->query($sql);

	if($db->num_rows()>0)
	{
		$i=0;
		while($db->next_record())
		{
			$info[$i]['id'] = $db->f('id');
			$info[$i]['name'] = $db->f('name');
			$info[$i]['cabinet_id'] = $db->f('cabinet_id');
			$info[$i]['nume_firma'] = $db->f('nume_firma');
			$i++;
			
		}
		return $info;
	}
	else
	{
		return '';
	}
}

##############
## update recomand banner view
function updateCabinetRecomandBannerView($banner_id)
{
	global $db;
	$sql = "UPDATE banner SET `recomandam_banner`=`recomandam_banner`+1 WHERE id='$banner_id'";
	$db->query($sql);
}

##getbannerdetails

function getBannerDetails($cabinet_id)
{
	global $db; $info = "";
	$expected = array('id', 'name', 'cabinet_d', 'recomandam_banner','total_afisari');

	$sql = "SELECT * FROM banner WHERE cabinet_id='$cabinet_id'";
	$db->query($sql);
	while($db->next_record())
	{
		foreach($expected as $ky)
		{
			$info[$ky] = $db->f($ky);
		}
	}
	return $info;
}

/**
 * get the articles for the sidebar
 * @access public
 * @param none
 * @return array
 */
function getRecomandArticles()
{
	$db = Zend_Registry::get('database');
	$select = $db->select()
					->from('articles')
					->where('status = ?', '1')
					->where('recomandat = ?', 'Y')
					->order(new Zend_Db_Expr('RAND()'))
					->limit(7);
	$results = $db->fetchAll($select);
	return $results;
	/*
	global $db;
	$level = 2; // abonament level id
	$level_details = getPromovareLevelDetails($level);

	$sql = "SELECT a.* FROM articles as a,cabinete as b WHERE a.status='1' AND a.recomandam_articole<'".$level_details['recomandam_articole']."' AND a.user_id=b.user_id AND b.`achitat`='Y' AND b.level LIKE '%".$level."%' ORDER BY RAND() LIMIT 5";
	$db->query($sql);
	if($db->num_rows()>0)
	{
		$i=0;
		while($db->next_record())
		{
			$info[$i]['id'] = $db->f('id');
			$info[$i]['user_id'] = $db->f('user_id');
			$info[$i]['titlu'] = $db->f('titlu');
			$info[$i]['imagine'] = $db->f('imagine');
			$info[$i]['continut'] = $db->f('continut');
			$info[$i]['bigcat_id'] = $db->f('bigcat_id');
			$info[$i]['alias'] = $db->f('alias');
			$i++;
			updateArticlesRecomandView($db->f('id'));
		}
		return $info;
	}
	else
	{
		return '';
	}*/
}

function updateArticlesRecomandView($art_id)
{
	global $db;
	$sql = "UPDATE articles SET `recomandam_articole`=`recomandam_articole`+1 WHERE id='$art_id'";
	$db->query($sql);
}

function getIfUserHasAbonament($u_id)
{
	global $db;
	$abonament = '2';
	$sql = "SELECT level FROM cabinete WHERE user_id='$u_id'";
	$db->query($sql);
	if($db->num_rows()>0)
	{
		while($db->next_record())
		{
			$level = $db->f('level');
			if(stristr($level,$abonament)!==false)
			{
				return true;
				break;
			}
			else
			{
				return false;
			}
		}
	}
	else
	{
		return false;
	}
}

function showPromovareFunction($level,$idfirma)
{
	$pachete ='';
	$pk = '';
	if(stristr($level,',')!==false)
	{
		$pk = explode(",",$level);
		foreach($pk as $ky2 => $val2)
		{
			$lvl = getPromovareLevelDetails($val2);
			$pachete.="<li>".$lvl['name']." - ".$lvl['perioada']." luni</li>";
		}
	}
	else
	{
		$lvl = getPromovareLevelDetails($level);
		$pachete.="<li>".$lvl['name']." - ".$lvl['perioada']." luni</li>";
	}

	##if we have only abonament then we display the alege recomandat
	if(stristr($level,'2')!==false && stristr($level,'5')===false && stristr($level,'6')===false)
	{
		$pachete.="<p>[ <a href='?page=user.updatepachet.".$idfirma.".recomandat'>Alege Recomandat</a> ]</p>";
	}
	elseif((stristr($level,'2')!==false && stristr($level,'5')!==false) || (stristr($level,'2')!==false && stristr($level,'6')!==false))
	{
		$pachete.="";
	}
	elseif((stristr($level,'2')===false && stristr($level,'5')!==false) || (stristr($level,'2')===false && stristr($level,'6')!==false))
	{
		$pachete.="<p>[ <a href='?page=user.updatepachet.".$idfirma.".abonament'>Alege Abonament</a> ]</p>";
	}
	else
	{
		$pachete.="<p>[ <a href='?page=user.updatepachet.".$idfirma.".abonament'>Alege Abonament</a> ]</p>";
		$pachete.="<p>[ <a href='?page=user.updatepachet.".$idfirma.".recomandat'>Alege Recomandat</a> ]</p>";
	}
	return $pachete;
}








?>