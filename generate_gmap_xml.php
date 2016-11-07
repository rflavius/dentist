<?php
/**
 * here we will generate the markers for the gmap
 */

require('preload.php');
$tpl = new Template(TEMPLATES_DIR);
$tpl->set_file('tpl_main','modules/gmap/generate.xml');
$tpl->set_block('tpl_main','display','display2');


$gmap = new Gmap_Search();

$center_coords = $gmap->getCenterAreaByIP();

if($center_coords!='')
{
	$coords = explode(",",$center_coords);
	$center_lat = $coords[0];
	$center_lng = $coords[1];
}

$rez = $gmap->getCliniciCabineteResults();

function parseToXML($htmlStr)
{
	$xmlStr=str_replace('<','&lt;',$htmlStr);
	$xmlStr=str_replace('>','&gt;',$xmlStr);
	$xmlStr=str_replace('"','&quot;',$xmlStr);
	$xmlStr=str_replace("'",'&#39;',$xmlStr);
	$xmlStr=str_replace("&",'&amp;',$xmlStr);
	return $xmlStr;
}


$i=0;
$markers=array();

if (is_array($rez))
{
	foreach($rez as $ky=>$val)
	{
		$tpl->set_var('NAME',parseToXML($val['nume_firma']));
		$tpl->set_var('ADDRESS',parseToXML($val['adresa_firma']));
		$tpl->set_var('FORMATED_ADDRESS',parseToXML($val['adresa_firma']));
		$tpl->set_var('LAT',$val['lat']);
		$tpl->set_var('LNG',$val['lng']);
		$tpl->set_var('TYPE','establishment');
		$tpl->set_var('DESCRIPTION',parseToXML(substr($val['descriere'],0,210)));
		$tpl->set_var('IMG',$val['image_name']);
		$tpl->set_var('PHONE',parseToXML($val['phone']));
		$tpl->set_var('LOCALITATE',$val['localitate']);
		$tpl->set_var('JUDET',$val['judet']);
		$tpl->set_var('CENTER_LAT',$center_lat);
		$tpl->set_var('CENTER_LNG',$center_lng);
		$level = getPromovareLevelDetails($val['level']);
		$tpl->set_var('LEVEL',$level['name']);
		$tpl->set_var('CABID',$val['cabinet_id']);
		$tpl->set_var('DATE',$val['submision_date']);
		
		/*$markers[$i]['name'] = $val['nume_firma'];
		$markers[$i]['address'] = $val['adresa_firma'];
		$markers[$i]['formated_address'] = $val['adresa_firma'];
		
		$markers[$i]['lat'] = $val['lat'];
		$markers[$i]['lng'] = $val['lng'];
		
		$markers[$i]['type'] = 'establishment';
		$markers[$i]['description'] = substr($val['descriere'],0,210);
		$markers[$i]['img'] = $val['image_name'];
		$markers[$i]['phone'] = $val['phone'];
		$markers[$i]['localitate'] = $val['localitate'];
		$markers[$i]['judet'] = $val['judet'];
		$level = getPromovareLevelDetails($val['level']);
		$markers[$i]['level'] = $level['name'];
		$markers[$i]['cabID'] = $val['cabinet_id'];
		$markers[$i]['date'] = $val['submision_date'];
		
		$i++;*/
		$tpl->parse('display2','display',true);
	}
	$content = $tpl->parse("MAIN", "tpl_main");
	//print_r($content);exit;
	/*write into file*/
	$handle = fopen("./gmap.xml", "w+");
	fwrite($handle, stripslashes($content));
	fclose($handle);
	echo 'done';
}
exit;







header("Content-type: text/xml");

// Start XML file, echo parent node
echo '<markers>';
// Iterate through the rows, adding XML nodes for each
foreach($markers as $ky => $val)
{
	echo '<marker ';
	echo 'name="' . parseToXML($val['name']) . '" ';
	echo 'address="' . parseToXML($val['address']) . '" ';
	echo 'center_lat="' . $center_lat . '" ';
	echo 'center_lng="' . $center_lng . '" ';
	echo 'lat="' . $val['lat'] . '" ';
	echo 'lng="' . $val['lng'] . '" ';
	echo 'type="' . $val['type'] . '" ';
	echo 'img="' . $val['img'] . '" ';
	echo 'phone="' . $val['phone'] . '" ';
	echo 'judet="' . $val['judet'] . '" ';
	echo 'localitate="' . $val['localitate'] . '" ';
	echo 'date="'.$val['date'].'" ';
	echo 'level="'.$val['level'].'" ';
	echo 'description="'.parseToXML($val['description']).'" ';
	echo 'cabID="' . $val['cabID'] . '"/>';
}


// End XML file
echo '</markers>';
