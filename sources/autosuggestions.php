<?php

require ('../preload.php');

function super_unique($array)
{
	$result = array_map("unserialize", array_unique(array_map("serialize", $array)));

	foreach ($result as $key => $value)
	{
		if ( is_array($value) )
		{
			$result[$key] = super_unique($value);
		}
	}
	return $result;
}

if (!isset($_GET['str']) || $_GET['str']=="")
{
	## default data store..
	$array_jud_res =array ("Sfantu Gheorghe" => "Covasna",
			"Focsani" => "Vrancea",
			"Oradea"=>"Bihor",
			"Timisoara"=>"Timis",
			"Resita"=>"Caras-Severin",
			"Drobeta turnu Severin"=>"Mehedinti",
			"Zalau"=>"Salaj",
			"Baia Mare"=>"Maramures",
			"Miercurea Ciuc"=>"Harghita",
			"Tragoviste"=>"Dambovita",
			"Tragu Jiu"=>"Gorj",
			"Craiova"=>"Dolj",
			"Slatina"=>"Olt",
			"Pitesti"=>"Arges",
			"Alexandria"=>"Teleorman",
			"Ploiesti"=>"Prahova",
			"Slobozia"=>"Ialomita");
	$i=0;
	foreach($array_jud_res as $ky => $val)
	{
		$location[$i] = $ky;
		$i++;
	}
}
else 
{
	## get only data starting with the desired characters
	$searchObj = new Search($db);
	$limit = 'LIMIT 0,12';
	$loc = $searchObj->listAllLocalitati($_GET['str'],$limit);
	$i=0;
	foreach($loc as $ky => $val)
	{
		$location[$i] = $val['name'];
		$i++;
	}
	
}

if(isset($location) && is_array($location))
{
    $location = super_unique($location);
    $i=0;
    foreach ($location as $key => $val)
    {
    	$authors[$i] = array('location' => $val);
    	$i++;
    }
}
else
{
	$authors[0] = array('location' => '');
}







// output JSON
echo json_encode(array('identifier' => 'location', 'items' => $authors));

