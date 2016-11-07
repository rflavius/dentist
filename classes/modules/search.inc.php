<?php
function SearchFirme($judet_code,$cat_id,$cuvant_cautat,$id_localitate)
{
	//echo $judet_code." ".$cat_id." ".$cuvant_cautat." ".$id_localitate;
	global $db;
	$word = addslashes($cuvant_cautat);
	$table = "cabinete";
	if(isset($cuvant_cautat)&&($cuvant_cautat!=""))
	{
		
	
	switch($cat_id)
	{
		default:
				switch($id_localitate)
				{
					default:
						$query= "SELECT * FROM ".$table." WHERE nume_firma like '%".$word."%'and (judet='".$judet_code."' and nume_loc_sector='".$id_localitate."' and category_id='".$cat_id."' and status='1') "; 
					break;
					
					case 'all':
						$query= "SELECT * FROM ".$table." WHERE nume_firma like '%".$word."%' and (judet='".$judet_code."' and category_id='".$cat_id."' and status='1')  "; 
					break;
				}
		break;

		
		case 'all':
			switch($id_localitate)
				{
					default:
						$query= "SELECT * FROM ".$table." WHERE nume_firma like '%".$word."%' and (judet='".$judet_code."' and  nume_loc_sector='".$id_localitate."' and status='1') "; 
					break;
					
					case 'all':
						$query= "SELECT * FROM ".$table." WHERE nume_firma like '%".$word."%'and judet='".$judet_code."' and status='1' "; 
					break;
				}
			
		break;
		}
	}
	else
	{
				switch($cat_id)
			{
				default:
						switch($id_localitate)
						{
							default:
								$query= "SELECT * FROM ".$table." WHERE judet='".$judet_code."' and nume_loc_sector='".$id_localitate."' and category_id='".$cat_id."' and status='1'"; 
							break;
							
							case 'all':
								$query= "SELECT * FROM ".$table." WHERE judet='".$judet_code."' and category_id='".$cat_id."' and status='1' "; 
							break;
						}
				break;

				
				case 'all':
					switch($id_localitate)
						{
							default:
								$query= "SELECT * FROM ".$table." WHERE judet='".$judet_code."' and  nume_loc_sector='".$id_localitate."' and status='1' "; 
							break;
							
							case 'all':
								$query= "SELECT * FROM ".$table." WHERE  judet='".$judet_code."' and status='1' "; 
							break;
						}
					
				break;
				}
	
	}

	$db->query($query);$i=0;$items=array();
	if($db->num_rows()>0)
	{
		while($db->next_record())
		{
			$items[$i]['id'] = $db->f('id');
			$items[$i]['nume_firma'] = $db->f('nume_firma');
			$items[$i]['descriere'] = $db->f('descriere');
			
		$i++;
		}
	
	}
	
	if(isset($cuvant_cautat)&&($cuvant_cautat!=""))
	{

		switch($cat_id)
		{
			default:
					switch($id_localitate)
					{
						default:
							$query= "SELECT *,MATCH (nume_firma,descriere,echipa_medicala,tarife) AGAINST ('".$word."*' IN BOOLEAN MODE) as score FROM ".$table." WHERE MATCH (nume_firma,descriere,echipa_medicala,tarife) AGAINST ('".$word."*' IN BOOLEAN MODE) and (judet='".$judet_code."' and nume_loc_sector='".$id_localitate."' and category_id='".$cat_id."' and status='1')  ORDER BY score DESC "; 
						break;
						
						case 'all':
							$query= "SELECT *,MATCH (nume_firma,descriere,echipa_medicala,tarife) AGAINST ('".$word."*' IN BOOLEAN MODE) as score FROM ".$table." WHERE MATCH (nume_firma,descriere,echipa_medicala,tarife) AGAINST ('".$word."*' IN BOOLEAN MODE) and (judet='".$judet_code."' and category_id='".$cat_id."' and status='1')  ORDER BY score DESC "; 
						break;
					}
			break;

			
			case 'all':
				switch($id_localitate)
					{
						default:
							$query= "SELECT *,MATCH (nume_firma,descriere,echipa_medicala,tarife) AGAINST ('".$word."*' IN BOOLEAN MODE) as score FROM ".$table." WHERE MATCH (nume_firma,descriere,echipa_medicala,tarife) AGAINST ('".$word."*' IN BOOLEAN MODE) and (judet='".$judet_code."' and  nume_loc_sector='".$id_localitate."' and status='1') ORDER BY score DESC "; 
						break;
						
						case 'all':
							$query= "SELECT *,MATCH (nume_firma,echipa_medicala,descriere,tarife) AGAINST ('".$word."*' IN BOOLEAN MODE) as score FROM ".$table." WHERE MATCH (nume_firma,echipa_medicala,descriere,tarife) AGAINST ('".$word."*' IN BOOLEAN MODE) and judet='".$judet_code."' and status='1' ORDER BY score DESC "; 
						break;
					}
				
			break;
			
		}
	}
	else
	{
			switch($cat_id)
			{
				default:
						switch($id_localitate)
						{
							default:
								$query= "SELECT * FROM ".$table." WHERE MATCH judet='".$judet_code."' and nume_loc_sector='".$id_localitate."' and category_id='".$cat_id."' and status='1'  ORDER BY nume_firma ASC "; 
							break;
							
							case 'all':
								$query= "SELECT * FROM ".$table." WHERE judet='".$judet_code."' and category_id='".$cat_id."' and status='1'  ORDER BY nume_firma ASC "; 
							break;
						}
				break;

				
				case 'all':
					switch($id_localitate)
						{
							default:
								$query= "SELECT * FROM ".$table." WHERE judet='".$judet_code."' and  nume_loc_sector='".$id_localitate."' and status='1' ORDER BY nume_firma ASC "; 
							break;
							
							case 'all':
								$query= "SELECT * FROM ".$table." WHERE  judet='".$judet_code."' and status='1' ORDER BY nume_firma ASC "; 
							break;
						}
					
				break;
				
			}
		
	}
	
	//echo $query;
	$db->query($query);

	while($db->next_record())
	{
		//$check_if = check_if_exists($items,$db->f('id'));
		$items[$i]['id'] = $db->f('id');
		$items[$i]['nume_firma'] = $db->f('nume_firma');
		$items[$i]['descriere'] = $db->f('descriere');
		
	$i++;
	}

$array_uniq = array();$i=0;

foreach($items as $ky => $val)
{
	$exist='N';
	foreach($array_uniq as $kyy => $vall)
	{
		if($vall['id']==$val['id'])
		{
			$exist='Y';
		}
	}
	if($exist=='N')
	{
		$array_uniq[$i]['id'] = $val['id'];
		$array_uniq[$i]['nume_firma'] = $val['nume_firma'];
		$array_uniq[$i]['descriere'] = $val['descriere'];
		$i++;
	}
	
}
return $array_uniq;

}

function CheckIfCountyCity($new_word)
{
	$word = strtolower(trim($new_word));
	$judet_info=array();
	$county_city_array = array("alba" =>"ab", "alba iulia"=>"ab", "arad" =>"ar", "arges"=>"ag", "pitesti"=>"ag", "bacau"=>"bc", "bihor"=>"bh","oradea"=>"bh","bistrita"=>"bn","botosani"=>"bt","braila"=>"br","brasov"=>"bv","bucuresti"=>"b","buzau"=>"bz", "calarasi"=>"cl","caras_severin"=>"cs","resita"=>"cs","cluj"=>"cj","constanta"=>"ct","covasna"=>"cv","sfantu gheorghe"=>"cv", "dambovita"=>"db", "targoviste"=>"db", "dolj"=>"dj", "craiova"=>"dj","galati"=>"gl","giurgiu"=>"gr","gorj"=>"gj","targu jiu"=>"gj","harghita"=>"hr","miercurea ciuc"=>"hr",	"hunedoara"=>"hd", "deva"=>"hd","ialomita"=>"il","slobozia"=>"il", "iasi"=>"is", "ilfov"=>"if", "maramures"=>"mm", "baia mare"=>"mm", "mehedinti"=>"mh","turnu severin"=>"mh", "drobeta"=>"mh", "mures"=>"ms","targu mures"=>"ms", "neamt"=>"nt", "piatra neamt"=>"nt", "olt"=>"ot","slatina"=>"ot", "prahova"=>"ph", "ploiesti"=>"ph", "salaj"=>"sj", "zalau"=>"sj","satu mare"=>"sm", "sibiu"=>"sb", "suceava"=>"sv", "teleorman"=>"tr", "alexandria"=>"tr", "timis"=>"tm", "timisoara"=>"tm", "tulcea"=>"tl","valcea"=>"vl","ramnicu valcea"=>"vl", "vaslui"=>"vs", "vrancea"=>"vn", "focsani"=>"vn");

	foreach($county_city_array as $ky => $val)
	{
			if($word==$ky)
			{
				$judet_info['cod'] =$val;
				$judet_info['name'] = $word;

			}elseif($word==$val)
			{
				$judet_info['cod'] =$val;
				$judet_info['name'] =$ky ;

			}
	}
	return $judet_info;
}
function CheckIfArticleCategory($word)
{
	$categor_array = array("stomatologice"=>"12","stomatologie"=>"12", "tehnica dentara"=>"13", "radiolgie dentara"=>"14", "radiolgie"=>"14" ,"medicina"=>"15","tratamenete naturiste"=>"16","naturiste"=>"16", "endodontie"=>"35", "estetica dentara"=>"29", "ginecologie"=>"19", "implantologie"=>"31","ortodontie"=>"30", "pardontologie"=>"32", "pedodontie"=>"33", "profilaxie dentara"=>"36", "protetica"=>"34", "produse si echipamente"=>"25", "echipamente"=>"25","produse"=>"25");
	$cat_info="";
	foreach($categor_array as $ky => $val)
	{
			if($word==$ky)
			{
				$cat_info =$val;
			}elseif($word==$val)
			{
				$cat_info =$ky;
			}	
	}
return $cat_info;
}
#---------------------------------------------HERE WE SEARCH ANUNTURI--------------------------------
function SearchAnunturi($word,$limitt)
{
	$final_word = $word;
	$items = array();$i=0;
	global $db;global $conf;
	$limit=" Limit ".$limitt;
	
	#check if we have anunt, anunturi in our word and replace then with space
	if(stristr($word, 'anunturi') == TRUE)
	{
		$final_word = str_replace("anunturi","",$final_word );
	}
	elseif(stristr($word, 'anunt') == TRUE) 
	{
		$final_word = str_replace("anunt","",$final_word );
	}
	#lets check what we have now is a county, city, or county code
	$check_new_word = CheckIfCountyCity(trim($final_word));
	if(count($check_new_word )<1)
	{
		#de obicei ultimul cuvant dintr un strin e judetul sau orasul care ma intereseaza, explodez si verific
		#daca ultimul cuvant e judet,localitate si restrictionez queryul

		#means we have more words not just one
		if(stristr($final_word," " )== TRUE)
		{
			$last_word1 = explode(" ",$final_word);
			$last_word = $last_word1[count($last_word1)-1];
			
			$check_new_word = CheckIfCountyCity(trim($last_word));
			if(count($check_new_word )>0)
			{
					$query = "SELECT *,MATCH (titlu,continut,autor) AGAINST ('+".$final_word."') as score FROM anunturi WHERE MATCH (titlu,continut,autor) AGAINST ('".$final_word."*' )  and (status='1' and lower(judet)='".$check_new_word['cod']."') ORDER BY score DESC ".$limit; 
			}
			else
			{
				$query = "SELECT *,MATCH (titlu,continut,autor) AGAINST ('+".$final_word."') as score FROM anunturi WHERE MATCH (titlu,continut,autor) AGAINST ('".$final_word."')  and status='1' ORDER BY score DESC ".$limit; 
			}
		}
		else
		{
			$query = "SELECT *,MATCH (titlu,continut,autor) AGAINST ('+".$final_word."') as score FROM anunturi WHERE MATCH (titlu,continut,autor) AGAINST ('".$final_word."*')  and status='1' ORDER BY score DESC ".$limit; 
		}
		
	
	}
	else
	{
		$query = "SELECT * FROM anunturi WHERE lower(judet)='".$check_new_word['cod']."' ORDER BY data_adaugarii DESC ".$limit; 
	}
	$db->query($query);
	//echo $db->affected_rows();exit;
	while($db->next_record())
	{
		
		$items[$i]['id'] = $db->f('id');
		$items[$i]['titlu'] = $db->f('titlu');
		$items[$i]['continut'] = $db->f('continut');
		$items[$i]['imagine'] = $db->f('imagine').'&max_size='.$conf->admin_gallery_max.'&anunturi=yes';
		$items[$i]['url1'] = "anunturi_detalii";
		$items[$i]['url2'] ="anunturi.detalii.".$db->f('id');
		$judet_name = CheckIfCountyCity($db->f('judet'));
		$items[$i]['judet'] = "Anunt ".ucfirst($judet_name['name']);

		$i++;
	}
		#if we want to make an section the results Anunturi/cabinete/articole
		//$items['anunturi'][$i]['imagine'] = $db->f('imagine');
		//print_r($items);
	return $items;

}

#---------------------------------------------HERE WE SEARCH ARTICOLE--------------------------------
function SearchArticole($word,$limitt)
{
	$final_word = $word;
	$items = array();$i=0;
	global $db;global $conf;$limit=" Limit ".$limitt;
	
	#check if we have anunt, anunturi in our word and replace then with space
	if(stristr($word, 'articole') == TRUE)
	{
		$final_word = str_replace("articole","",$final_word );
	}
	elseif(stristr($word, 'articol') == TRUE) 
	{
		$final_word = str_replace("articol","",$final_word );
	}
	
	#lets check what we have now is a county, city, or county code
	$check_new_word = CheckIfArticleCategory(trim($final_word));
	if($check_new_word =="")
	{
		#de obicei ultimul cuvant dintr un strin e judetul sau orasul care ma intereseaza, explodez si verific
		#daca ultimul cuvant e judet,localitate si restrictionez queryul

		#means we have more words not just one
		if(stristr($final_word," " )== TRUE)
		{
			$last_word1 = explode(" ",$final_word);
			$last_word = $last_word1[count($last_word1)-1];
			
			$check_new_word = CheckIfArticleCategory(trim($last_word));
			if($check_new_word!="" )
			{
					$query = "SELECT *,MATCH (titlu,continut,autor) AGAINST ('".$final_word."*') as score FROM articles WHERE MATCH (titlu,continut,autor) AGAINST ('".$final_word."*')  and (status='1' and bigcat_id='".$check_new_word."') ORDER BY score DESC ".$limit; 
			}
			else
			{
				$query = "SELECT *,MATCH (titlu,continut,autor) AGAINST ('".$final_word."*') as score FROM articles WHERE MATCH (titlu,continut,autor) AGAINST ('".$final_word."*')  and status='1' ORDER BY score DESC ".$limit; 
			}
		}
		else
		{
			$query = "SELECT *,MATCH (titlu,continut,autor) AGAINST ('".$final_word."*') as score FROM articles WHERE MATCH (titlu,continut,autor) AGAINST ('".$final_word."*')  and status='1' ORDER BY score DESC ".$limit; 
		}
		
	
	}
	else
	{
		$query = "SELECT * FROM articles WHERE bigcat_id='".$check_new_word."' ORDER BY data_adaugarii DESC ".$limit; 
	}
	$db->query($query);
	//echo $db->affected_rows();exit;
	while($db->next_record())
	{
		
		$items[$i]['id'] = $db->f('id');
		$items[$i]['titlu'] = $db->f('titlu');
		$items[$i]['continut'] = $db->f('continut');
		$items[$i]['imagine'] = $db->f('imagine').'&max_size='.$conf->admin_gallery_max.'&&articles=yes';
		$items[$i]['url1'] = "articole";
		$items[$i]['url2'] ="articole-medicale.articol.".$db->f('bigcat_id').'.'.$db->f('id');
		$cat_name = CheckIfArticleCategory($db->f('bigcat_id'));
		$items[$i]['judet'] = "Articol ".ucfirst($cat_name);

		$i++;
	}
		#if we want to make an section the results Anunturi/cabinete/articole
		//$items['anunturi'][$i]['imagine'] = $db->f('imagine');
		//print_r($items);
	return $items;

}
#---------------------------------------------HERE WE SEARCH CABINETE--------------------------------
function SearchCabinete($word,$limitt)
{
	$final_word = $word;
	$items = array();$i=0;
	global $db;global $conf;
	$limit=" Limit ".$limitt;
	$query_expand ="";
	
	
	#check if we have anunt, anunturi in our word and replace then with space
	if(stristr($word, 'cabinete') == TRUE)
	{
		$final_word = str_replace("cabinete","",$final_word );
		$query_expand = "and category_id='1'";
	}
	elseif(stristr($word, 'cabinet') == TRUE) 
	{
		$final_word = str_replace("cabinet","",$final_word );
		$query_expand = "and category_id='1'";
	}

	
	if(stristr($word, 'clinici') == TRUE)
	{
		$final_word = str_replace("clinici","",$final_word );
		$query_expand = "and category_id='5'";
	}
	elseif(stristr($word, 'clinica') == TRUE) 
	{
		$final_word = str_replace("clinica","",$final_word );
		$query_expand = "and category_id='5'";
	}

	if(stristr($word, 'laboratoare') == TRUE)
	{
		$final_word = str_replace("laboratoare","",$final_word );
		$query_expand = "and category_id='2'";
	}
	elseif(stristr($word, 'laborator') == TRUE) 
	{
		$final_word = str_replace("laborator","",$final_word );
		$query_expand = "and category_id='2'";
	}
	
	if(stristr($word, 'tehnica dentara') == TRUE)
	{
		$final_word = str_replace("tehnica dentara","",$final_word );
		$query_expand = "and category_id='2'";
	}
	elseif(stristr($word, 'tehnica') == TRUE) 
	{
		$final_word = str_replace("tehnica","",$final_word );
		$query_expand = "and category_id='2'";
	}


	if(stristr($word, 'ditribuitori') == TRUE)
	{
		$final_word = str_replace("ditribuitori","",$final_word );
		$query_expand = "and category_id='4'";
	}
	elseif(stristr($word, 'distribuitor') == TRUE) 
	{
		$final_word = str_replace("distribuitor","",$final_word );
		$query_expand = "and category_id='4'";
	}

	#lets check what we have now is a county, city, or county code
	$check_new_word = CheckIfCountyCity(trim($final_word));
	if(count($check_new_word )<1)
	{
		#de obicei ultimul cuvant dintr un strin e judetul sau orasul care ma intereseaza, explodez si verific
		#daca ultimul cuvant e judet,localitate si restrictionez queryul

		#means we have more words not just one
		if(stristr($final_word," " )== TRUE)
		{
			$last_word1 = explode(" ",$final_word);
			$last_word = $last_word1[count($last_word1)-1];
			
			//print_r($last_word1);
			//$final_word = implode(" +",$last_word1 );echo $final_word;
			$check_new_word = CheckIfCountyCity(trim($last_word));
			
			if(count($check_new_word )>0)
			{
					$query = "SELECT *,MATCH (nume_firma,echipa_medicala,descriere,tarife) AGAINST ('".$final_word."') as score FROM cabinete WHERE MATCH (nume_firma,echipa_medicala,descriere,tarife) AGAINST ('".$final_word."')  and (status='1' and lower(judet)='".$check_new_word['cod']."'  ".$query_expand.") ORDER BY score DESC ".$limit; 
			}
			else
			{
				$query = "SELECT *,MATCH (nume_firma,echipa_medicala,descriere,tarife) AGAINST ('".$final_word."') as score FROM cabinete WHERE MATCH (nume_firma,echipa_medicala,descriere,tarife) AGAINST ('".$final_word."' )  and status='1' ".$query_expand." ORDER BY score DESC ".$limit; 
			}
		}
		else
		{
			$query = "SELECT *,MATCH (nume_firma,echipa_medicala,descriere,tarife) AGAINST ('".$final_word."' ) as score FROM cabinete WHERE MATCH (nume_firma,echipa_medicala,descriere,tarife) AGAINST ('".$final_word."' )  and status='1' ".$query_expand." ORDER BY score DESC ".$limit; 
		}
	
	}
	else
	{
		$query = "SELECT * FROM cabinete WHERE lower(judet)='".$check_new_word['cod']."' and status='1' ".$query_expand." ORDER BY submision_date DESC ".$limit; 
	}
	//echo $query;
	$db->query($query);
	$cabinete_type = array("1"=>"Cabinet stomatologic", "2"=>"Tehnica dentara","3"=>"Laborator radiologie","4"=>"Distribuitori ","5"=>"Clinici stomatologice");
	while($db->next_record())
	{
		
		$items[$i]['id'] = $db->f('id');
		$items[$i]['titlu'] = $db->f('nume_firma');
		$items[$i]['continut'] = $db->f('descriere');
		$items[$i]['url1'] = "cabinete_detalii";
		$items[$i]['url2'] ="cabinete.detalii.".$db->f('id');
		$judet_name = CheckIfCountyCity($db->f('judet'));
		$items[$i]['judet'] =$cabinete_type[$db->f('category_id')]." ".ucfirst($judet_name['name']);
		//echo $items[$i]['judet']."</p>";
		$i++;
	}
	//lets add anca rusu at the beginig
	/*
	if(stristr($word, 'non stop') == TRUE)
	{
		$anca_rusu = array();
		$anca_rusu['id'] = '601';
		$anca_rusu['titlu'] = 'DENTAL PREMIER';
		$anca_rusu['continut'] = strip_tags('ZAMBETUL PACIENTILOR NOSTRI REPREZINTA SUCCESUL NOSTRU! De ce sa ne alegi? Pentru ca oricine se bucura de dinti sanatosi,');
		$anca_rusu['url1'] = "cabinete_detalii";
		$anca_rusu['url2'] ="cabinete.detalii.601";
		$anca_rusu['judet'] ='Cabinet stomatologic Bucuresti';
		array_unshift($items,$anca_rusu);
}*/
	

		#if we want to make an section the results Anunturi/cabinete/articole
		//$items['anunturi'][$i]['imagine'] = $db->f('imagine');
		//print_r($items);exit;
	return $items;

}




?>