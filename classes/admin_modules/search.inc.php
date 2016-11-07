<?php
function SearchFirme($judet_code,$cat_id,$cuvant_cautat,$id_localitate)
{
	//echo $judet_code." ".$cat_id." ".$cuvant_cautat." ".$id_localitate;
	global $db;
	$word = addslashes($cuvant_cautat);
	$table = "cabinete";
	switch($cat_id)
	{
		default:
				switch($id_localitate)
				{
					default:
						$query= "SELECT *,MATCH (descriere,echipa_medicala,nume_firma,tarife) AGAINST ('".$word."*' IN BOOLEAN MODE) as score FROM ".$table." WHERE MATCH (descriere,echipa_medicala,nume_firma,tarife) AGAINST ('".$word."*' IN BOOLEAN MODE) and (judet='".$judet_code."' and nume_loc_sector='".$id_localitate."' and category_id='".$cat_id."' and status='1')  ORDER BY score DESC "; 
					break;
					
					case 'all':
						$query= "SELECT *,MATCH (descriere,echipa_medicala,nume_firma,tarife) AGAINST ('".$word."*' IN BOOLEAN MODE) as score FROM ".$table." WHERE MATCH (descriere,echipa_medicala,nume_firma,tarife) AGAINST ('".$word."*' IN BOOLEAN MODE) and (judet='".$judet_code."' and category_id='".$cat_id."' and status='1')  ORDER BY score DESC "; 
					break;
				}
		break;

		
		case 'all':
			switch($id_localitate)
				{
					default:
						$query= "SELECT *,MATCH (descriere,echipa_medicala,nume_firma,tarife) AGAINST ('".$word."*' IN BOOLEAN MODE) as score FROM ".$table." WHERE MATCH (descriere,echipa_medicala,nume_firma,tarife) AGAINST ('".$word."*' IN BOOLEAN MODE) and (judet='".$judet_code."' and  nume_loc_sector='".$id_localitate."' and status='1') ORDER BY score DESC "; 
					break;
					
					case 'all':
						$query= "SELECT *,MATCH (echipa_medicala,descriere,nume_firma,tarife) AGAINST ('".$word."*' IN BOOLEAN MODE) as score FROM ".$table." WHERE MATCH (echipa_medicala,descriere,nume_firma,tarife) AGAINST ('".$word."*' IN BOOLEAN MODE) and judet='".$judet_code."' and status='1' ORDER BY score DESC "; 
					break;
				}
			
		break;
		
	}
	
	//echo $query;
	$db->query($query);
	$items=array();$i=0;
	
	while($db->next_record())
	{
		$items[$i]['id'] = $db->f('id');
		$items[$i]['nume_firma'] = $db->f('nume_firma');
		$items[$i]['descriere'] = $db->f('descriere');
		
	$i++;
	}
return $items;

}

?>