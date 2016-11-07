<?php
/*
* here we have all the methods for search class
*/

class Search
{
	function __construct($d)
	{
		$this->db = $d;
	}
	/*
	 * add log for the search 
	 */
	public function saveSearch($word,$location)
	{
		if($this->uniqueSearch($word,$location,GetUserIP()))
		{
			$sql = "INSERT INTO searches(`search`,`location`,`date`,`ip`) VALUES('".addslashes($word)."', '".addslashes($location)."', NOW(), '".GetUserIP()."')";
			$this->db->query($sql);
		}
	}
	/*
	 * check if uniques search before saving the log
	 */
	public function uniqueSearch($word,$location,$ip)
	{
		$sql = "SELECT id FROM searches WHERE search='".addslashes($word)."' AND location='".addslashes($location)."' AND `ip`='$ip' AND DATEDIFF(NOW(),`date`)<1";
		$this->db->query($sql);
		if($this->db->num_rows()>0)
		{
			return false;
		}
		else 
		{
			return true;
		}
	}
	public function getSectoareCapitala()
	{
		$sql = "SELECT id FROM localitati WHERE judet_code='B'";
		$this->db->query($sql);
		$rez = '';
		$i=0;
		while ($this->db->next_record())
		{
			if($i==0)
			{
				$rez = "'".$this->db->f('id')."'";
			}
			else 
			{
				$rez.= ", '".$this->db->f('id')."'";
			}
			$i++;
		}
		return $rez;
	}
	/*
	 * here we count the results for the search for each category from the filter section( or module )
	 */
	public function countFilterCategoryResults($cat,$word,$location)
	{
		//echo $cat." ".$word." ".$location."</br>";
		//clean the location from search string
		//var_dump($word) ;
		$str = explode(" ",$word);
		foreach($str as $ky => $val)
		{
			#here we make verification for sector 1 or sector1 in the search box (with space or no space)
			if(stristr(strtolower($val), 'sector') == TRUE)
			{
				$word = str_replace($val,"",$word);
				if (isset($str[$ky+1]))
				{
					$val = $val." ".$str[$ky+1]; 
					$word = str_replace($str[$ky+1],"",$word);
				}
				else
				{	$val = "Sector ".substr($val,-1);}	
			}
			
			
			#only if is not set the localitate then we set the localitate, otherwise will overwrite
			if (!isset($localitate) || ($localitate==""))
			{
				$localitate = $this->checkIfLocalitate($val);
				//var_dump($localitate);
				if($localitate!='')
				{	
					$word = str_replace($val,"",$word);
					//$query_expand.= " AND nume_loc_sector = '".$localitate."'";
				}
				
			}
			//echo $word;
			#only if is not set judet then we set the judet
			if (!isset($judet) || ($judet==""))
			{
				$judet = $this->getJudetCode($val);
				if($judet!='')
				{	$word = str_replace($val,"",$word);	}
			}

			#if we have the word bucuresti then we set to judet search
			if(strtolower($val)=='bucuresti')
			{	$judet = 'B'; $localitate="";	}
		}
		//echo $word;

		#since only articole and events dont't have localitate and judet we can make here the expand query
		$query_expand="";
		$final_word = $word;

		
		switch ($cat)
		{
			case 'dentisti':
				if(stristr($word, 'dentisti') == TRUE)
				{
					$final_word = str_replace("dentisti","",$final_word );
					$query_expand = "and (category_id='1' OR category_id='5')";
				}
				elseif(stristr($word, 'dentist') == TRUE)
				{
					$final_word = str_replace("dentist","",$final_word );
					$query_expand = "and (category_id='1' OR category_id='5')";
				}
				
				if(stristr($word, 'medici') == TRUE)
				{
					$final_word = str_replace("medici","",$final_word );
					$query_expand = "and (category_id='1' OR category_id='5')";
				}
				elseif(stristr($word, 'medic') == TRUE)
				{
					$final_word = str_replace("medic","",$final_word );
					$query_expand = "and (category_id='1' OR category_id='5')";
				}

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
				
				if(stristr($word, 'clinica dentara') == TRUE)
				{
					$final_word = str_replace("clinica","",$final_word );
					$final_word = str_replace("dentara","",$final_word );
					$query_expand = "and (category_id='1' OR category_id='5')";

				}
				elseif(stristr($word, 'clinici') == TRUE)
				{
					$final_word = str_replace("clinici","",$final_word );
					$query_expand = "and category_id='5'";
				}
				elseif(stristr($word, 'clinica') == TRUE)
				{
					$final_word = str_replace("clinica","",$final_word );
					$query_expand = "and category_id='5'";
				}

				
				if(stristr($word, 'cabinete stomatologice') == TRUE)
				{
					$final_word = str_replace("cabinete","",$final_word );
					$final_word = str_replace("stomatologice","",$final_word );
					$query_expand = "and (category_id='1' OR category_id='5')";
				}
				if(stristr($word, 'cabinete dentare') == TRUE)
				{
					$final_word = str_replace("cabinete","",$final_word );
					$final_word = str_replace("dentare","",$final_word );

					$query_expand = "and (category_id='1' OR category_id='5')";
				}
				
				if(stristr($word, 'medic dentist') == TRUE)
				{
					$final_word = str_replace("medic","",$final_word );
					$final_word = str_replace("dentist","",$final_word );
					$query_expand = "and (category_id='1' OR category_id='5')";
				}
				if(stristr($word, 'cabinet stomatologic') == TRUE)
				{
					$final_word = str_replace("cabinet","",$final_word );
					$final_word = str_replace("stomatologic","",$final_word );
					
					$query_expand = "and (category_id='1' OR category_id='5')";
				}
				if(stristr($word, 'stomatologie') == TRUE)
				{
					$final_word = str_replace("stomatologie","",$final_word );
					$query_expand = "and (category_id='1' OR category_id='5')";
				}
				/*tehnica dentara*/
				if(stristr($word, 'tehnica dentara') == TRUE)
				{
					$final_word = str_replace("tehnica","",$final_word );
					$final_word = str_replace("dentara","",$final_word );
					$query_expand = "and category_id='2'";
				}
				if(stristr($word, 'tehnician dentar') == TRUE)
				{
					$final_word = str_replace("tehnician","",$final_word );
					$final_word = str_replace("dentar","",$final_word );
					$query_expand = "and category_id='2'";
				}
				/*radiografie dentara*/
				if(stristr($word, 'radiologie dentara') == TRUE)
				{
					$final_word = str_replace("radiologie","",$final_word );
					$final_word = str_replace("dentara","",$final_word );
					$query_expand = "and category_id='3'";
				}
				if(stristr($word, 'radiologie') == TRUE)
				{
					$final_word = str_replace("radiologie","",$final_word );
					$query_expand = "and category_id='3'";
				}
				if(stristr($word, 'radiografie dentara') == TRUE)
				{
					$final_word = str_replace("radiografie","",$final_word );
					$final_word = str_replace("dentara","",$final_word );
					$query_expand = "and category_id='3'";
				}
				if(stristr($word, 'radiografie') == TRUE)
				{
					$final_word = str_replace("radiografie","",$final_word );
					$query_expand = "and category_id='3'";
				}
				
				
				if(isset($localitate) && ($localitate !="") )
				{
					$query_expand.= " AND nume_loc_sector = '".$localitate."'";
					
				}
				elseif(isset($judet) && ($judet !="") )  
				{
				$query_expand.= " AND judet = '".$judet."'";
				}
				else
				{
					$localitate = $this->checkIfLocalitate($location);
					$judet = $this->getJudetCode($location);
					if($localitate!='')
					{
						if($location == 'Bucuresti')
						{
							$sectoare = $this->getSectoareCapitala();
							$query_expand.= " AND nume_loc_sector IN (".$sectoare.")";
						}
						else
						{
							$query_expand.= " AND nume_loc_sector = '".$localitate."'";
						}
					}
					else 
					{
						$judet = $this->getJudetCode($location);
						if($judet!='')
						{
							$query_expand.= " AND judet = '".$judet."'";
						}
					}
				}
				//var_dump($final_word);
				//$final_word = trim($final_word).' '.$location;
				$final_word = trim($final_word);
				if($final_word!='')
				{
					//$sql = " SELECT id FROM cabinete WHERE MATCH (nume_firma,echipa_medicala,descriere,tarife) AGAINST ('".addslashes($final_word)."' IN BOOLEAN MODE) AND status='1' ".$query_expand;
					$sql = " SELECT id,MATCH (nume_firma,echipa_medicala,descriere,tarife) AGAINST ('".$final_word."') as score FROM cabinete WHERE MATCH (nume_firma,echipa_medicala,descriere,tarife) AGAINST ('".addslashes($final_word)."') AND status='1' ".$query_expand;
				}
				else 
				{
					$sql = " SELECT id FROM cabinete WHERE status='1' ".$query_expand;
				}
			//	echo $sql;
				$this->db->query($sql);
				/*if we have no answer on localitate we try on judet*/
				if ($this->db->num_rows()<1)
				{
							if(isset($judet) && ($judet !="") )  
							{			
								$query_expand.= " OR judet = '".$judet."'";
							}
						if($final_word!='')
						{
							$sql = " SELECT *,MATCH (nume_firma,echipa_medicala,descriere,tarife) AGAINST ('".$final_word."') as score FROM cabinete WHERE MATCH (nume_firma,echipa_medicala,descriere,tarife) AGAINST ('".addslashes($final_word)."') AND status='1' ".$query_expand;
						}
						else
						{
							$sql = " SELECT * FROM cabinete WHERE status='1' ".$query_expand;
							
						}
				}
				//echo $sql;
			break;
			
			case 'tehnica':
				if(stristr($word, 'tehnica dentara') == TRUE)
				{
					$final_word = str_replace("tehnica","",$final_word );
					$final_word = str_replace("dentara","",$final_word );
				}
				elseif(stristr($word, 'tehnica') == TRUE)
				{
					$final_word = str_replace("tehnica","",$final_word );
				}
				
				if(stristr($word, 'laboratoare') == TRUE)
				{
					$final_word = str_replace("laboratoare","",$final_word );
				}
				elseif(stristr($word, 'laborator') == TRUE)
				{
					$final_word = str_replace("laborator","",$final_word );
				}
				
				
				if(isset($localitate) && ($localitate !="") )
				{
					$query_expand.= " AND nume_loc_sector = '".$localitate."'";
					
				}
				elseif(isset($judet) && ($judet !="") )  
				{
				$query_expand.= " AND judet = '".$judet."'";
				}
				else
				{
					$localitate = $this->checkIfLocalitate($location);
					if($localitate!='')
					{
						if($location == 'Bucuresti')
						{
							$sectoare = $this->getSectoareCapitala();
							$query_expand.= " AND nume_loc_sector IN (".$sectoare.")";
						}
						else
						{
							$query_expand.= " AND nume_loc_sector = '".$localitate."'";
						}
					}
					else 
					{
						$judet = $this->getJudetCode($location);
						if($judet!='')
						{
							$query_expand.= " AND judet = '".$judet."'";
						}
					}
				
				}

				$query_expand.=" AND category_id='2'";
				$final_word = trim($final_word);
				if($final_word!='')
				{
					$sql = " SELECT id FROM cabinete WHERE MATCH (nume_firma,echipa_medicala,descriere,tarife) AGAINST ('*".addslashes($final_word)."*' IN BOOLEAN MODE) AND status='1' ".$query_expand;
				}
				else
				{
					$sql = " SELECT id FROM cabinete WHERE status='1' ".$query_expand;
				}
				
			break;
			
			case 'distribuitori':
				if(stristr($word, 'materiale') == TRUE)
				{
					$final_word = str_replace("materiale","",$final_word );
				}
				elseif(stristr($word, 'distribuitori') == TRUE)
				{
					$final_word = str_replace("distribuitori","",$final_word );
				}
				elseif(stristr($word, 'distribuitor') == TRUE)
				{
					$final_word = str_replace("distribuitor","",$final_word );
				}
				
				$query_expand = " AND category_id='4'";
				if(isset($localitate) && ($localitate !="") )
				{
					$query_expand.= " AND nume_loc_sector = '".$localitate."'";
					
				}
				elseif(isset($judet) && ($judet !="") )  
				{
				$query_expand.= " AND judet = '".$judet."'";
				}
				else
				{
					$localitate = $this->checkIfLocalitate($location);
					if($localitate!='')
					{
						if($location == 'Bucuresti')
						{
							$sectoare = $this->getSectoareCapitala();
							$query_expand.= " AND nume_loc_sector IN (".$sectoare.")";
						}
						else
						{
							$query_expand.= " AND nume_loc_sector = '".$localitate."'";
						}
					}
					else 
					{
						$judet = $this->getJudetCode($location);
						if($judet!='')
						{
							$query_expand.= " AND judet = '".$judet."'";
						}
					}
				
				}
				
				$final_word = trim($final_word);
				if($final_word!='')
				{
					$sql = " SELECT id FROM cabinete WHERE MATCH (nume_firma,echipa_medicala,descriere,tarife) AGAINST ('*".addslashes($final_word)."*' IN BOOLEAN MODE) AND status='1' ".$query_expand;
				}
				else
				{
					$sql = " SELECT id FROM cabinete WHERE status='1' ".$query_expand;
				}
			break;
			
			case 'radiologie':
				if(stristr($word, 'radiologie') == TRUE)
				{
					$final_word = str_replace("radiologie","",$final_word );
					
				}
				elseif(stristr($word, 'radiografie') == TRUE)
				{
					$final_word = str_replace("radiografie","",$final_word );
					
				}
				elseif(stristr($word, 'radiografii') == TRUE)
				{
					$final_word = str_replace("radiografii","",$final_word );
					
				}
				$query_expand = " AND category_id='3'";
					if(isset($localitate) && ($localitate !="") )
				{
					$query_expand.= " AND nume_loc_sector = '".$localitate."'";
					
				}
				elseif(isset($judet) && ($judet !="") )  
				{
				$query_expand.= " AND judet = '".$judet."'";
				}
				else
				{
					$localitate = $this->checkIfLocalitate($location);
					if($localitate!='')
					{
						if($location == 'Bucuresti')
						{
							$sectoare = $this->getSectoareCapitala();
							$query_expand.= " AND nume_loc_sector IN (".$sectoare.")";
						}
						else
						{
							$query_expand.= " AND nume_loc_sector = '".$localitate."'";
						}
					}
					else 
					{
						$judet = $this->getJudetCode($location);
						if($judet!='')
						{
							$query_expand.= " AND judet = '".$judet."'";
						}
					}
				}
				
				$final_word = trim($final_word);
				if($final_word!='')
				{
					$sql = " SELECT id FROM cabinete WHERE MATCH (nume_firma,echipa_medicala,descriere,tarife) AGAINST ('*".addslashes($final_word)."*' IN BOOLEAN MODE) AND status='1' ".$query_expand;
				}
				else
				{
					$sql = " SELECT id FROM cabinete WHERE status='1' ".$query_expand;
				}
				
			break;
			
			case 'articole':
				if(stristr($word, 'articole') == TRUE)
				{				$final_word = str_replace("articole","",$final_word );			}
				elseif(stristr($word, 'articol') == TRUE)
				{				$final_word = str_replace("articol","",$final_word );			}
				$check_new_word ="";
				#we check if it is an article category, yes - we display all articles form that category
				if($check_new_word =="")
				{
					#means we have more words not just one
					if(stristr($final_word," " )== TRUE)
					{
							$last_word1 = explode(" ",$final_word);
							$last_word = $last_word1[count($last_word1)-1];
							$check_new_word = CheckIfArticleCategory(trim($last_word));
							if($check_new_word!="" )
							{
								$sql = "SELECT * FROM articles WHERE MATCH (titlu,continut) AGAINST ('".addslashes($final_word)."*' IN BOOLEAN MODE)  AND status='1' AND bigcat_id=".$check_new_word;
							}
							elseif($final_word!='')
							{
								$sql = " SELECT *,MATCH (titlu,continut,autor) AGAINST ('".$final_word."') as score FROM articles WHERE MATCH (titlu,continut,autor) AGAINST ('".addslashes($final_word)."') HAVING score > 0.2 AND status='1' ";
							}
					}
					else
					{
						if($final_word!='')
						{
							$sql = " SELECT *,MATCH (titlu,continut,autor) AGAINST ('".$final_word."') as score FROM articles WHERE MATCH (titlu,continut,autor) AGAINST ('".addslashes($final_word)."') HAVING score > 0.2 AND status='1' ";
						}
					}
				}
				else
				{
					$sql = "SELECT * FROM articles WHERE bigcat_id='".$check_new_word."'";
				}
			break;
			
			case 'anunturi':
				if(stristr($word, 'anunturi') == TRUE)
				{
					$final_word = str_replace("anunturi","",$final_word );
				}
				elseif(stristr($word, 'anunt') == TRUE)
				{
					$final_word = str_replace("anunt","",$final_word );
				}
				
			
				if(isset($localitate) && ($localitate !="") )
				{
					$query_expand.= " AND localitate = '".$localitate."'";
				
				}
				elseif(isset($judet) && ($judet !="") )  
				{
				$query_expand.= " AND judet = '".$judet."'";
				}
				else
				{
				$localitate = $this->checkIfLocalitate($location);
				if($localitate!='')
				{
					if($location == 'Bucuresti')
					{
						$sectoare = $this->getSectoareCapitala();
						$query_expand.= " AND localitate IN (".$sectoare.")";
					}
					else
					{
						$query_expand.= " AND localitate = '".$localitate."'";
					}
				}
				else
				{
					$judet = $this->getJudetCode($location);
					if($judet!='')
					{
						$query_expand.= " AND judet = '".$judet."'";
					}
				}
				}
				$final_word = trim($final_word);
				
				if($final_word!='')
				{
					$sql = "SELECT id FROM anunturi WHERE MATCH (titlu,continut,autor) AGAINST ('".addslashes($final_word)."*' IN BOOLEAN MODE)  AND status='1' ".$query_expand;
				}
				else
				{
					$sql = "SELECT id FROM anunturi WHERE status='1' ".$query_expand;
				}
			break;
			
			case 'evenimente':
				if(stristr($word, 'eveniment') == TRUE)
				{
					$final_word = str_replace("eveniment","",$final_word );
				}
				elseif(stristr($word, 'evenimente') == TRUE)
				{
					$final_word = str_replace("eveniment","",$final_word );
				}
				
				if($final_word!='')
				{
					$sql = "SELECT id FROM news WHERE MATCH(title,content) AGAINST('".addslashes($final_word)."*' IN BOOLEAN MODE) AND status='1' AND Place LIKE '%".$location."%'";
				}
				else 
				{
					$sql = "SELECT id FROM news WHERE status='1' AND Place LIKE '%".$location."%'";
				}
			break;
		}
		//echo $sql."<br>";
		$this->db->query($sql);
		return $this->db->num_rows();
	}
	/*
	 * here we list the search results
	 */
	public function listSearchResults($cat,$word,$location,$limit)
	{
		global $conf;$query_expand="";
		//	echo $cat." ".$word."".$location."".$limit."</br>";
		//clean the location from search string
		$str = explode(" ",$word);
		foreach($str as $ky => $val)
		{
			#here we make verification for sector 1 or sector1 in the search box
			if(stristr(strtolower($val), 'sector') == TRUE)
			{ 
				$word = str_replace($val,"",$word);
				if (isset($str[$ky+1]))
				{
					$val = $val." ".$str[$ky+1]; 
					$word = str_replace($str[$ky+1],"",$word);
				}
				else
				{
					$val = "Sector ".substr($val,-1);					
				}	
			}
			
			#only if is not set the localitate then we set the localitate
			if (!isset($localitate) || ($localitate==""))
			{
				$localitate = $this->checkIfLocalitate($val);
				if($localitate!='')
				{	$word = str_replace($val,"",$word);		}
			}
			#only if is not set judet then we set the judet
			if (!isset($judet) || ($judet==""))
			{
				$judet = $this->getJudetCode($val);
				if($judet!='')
				{	$word = str_replace($val,"",$word);		}
			}

				#if we have the word bucuresti then we set to judet search
				if(strtolower($val)=='bucuresti')
				{
					$judet = 'B'; $localitate="";
				}
		}
		//var_dump($localitate);
		//var_dump($localitate);
		//var_dump($judet);
		//var_dump($word);
		//echo $cat;
		//////////////////////////////////////////////////
		#here we make the query expand ,and only if localiate is nost set we sercah if location is set
		if(isset($localitate) && ($localitate !="") )
		{
			$query_expand.= " AND nume_loc_sector = '".$localitate."'";
		}
		elseif(isset($judet) && ($judet !="") )  
		{			
			$query_expand.= " AND judet = '".$judet."'";
		}
		else
		{
				$localitate = $this->checkIfLocalitate($location);
				$judet = $this->getJudetCode($location);
				if($localitate!='')
				{
					if($location == 'Bucuresti')
					{
						$sectoare = $this->getSectoareCapitala();
						$query_expand.= " AND nume_loc_sector IN (".$sectoare.")";
					}
					else
					{
						$query_expand.= " AND nume_loc_sector = '".$localitate."'";
					}
				}
				else
				{
					$judet = $this->getJudetCode($location);
					if($judet!='')
					{
						$query_expand.= " AND judet = '".$judet."'";
					}
				}
		}	
		//echo $query_expand;
		/////////////////////////////////////////////
		$final_word = $word;
		switch ($cat)
		{
			
			case 'dentisti':
				if(stristr($word, 'dentisti') == TRUE)
				{
					$final_word = str_replace("dentisti","",$final_word );
					$query_expand .= "and (category_id='1' OR category_id='5')";
				}
				elseif(stristr($word, 'dentist') == TRUE)
				{
					$final_word = str_replace("dentist","",$final_word );
					$query_expand .= "and (category_id='1' OR category_id='5')";
				}
				if(stristr($word, 'cabinete stomatologice') == TRUE)
				{
					$final_word = str_replace("cabinete","",$final_word );
					$final_word = str_replace("stomatologice","",$final_word );
					$query_expand .= "and (category_id='1' OR category_id='5')";
				}
				if(stristr($word, 'cabinete dentare') == TRUE)
				{
					$final_word = str_replace("cabinete","",$final_word );
					$final_word = str_replace("dentare","",$final_word );
					$query_expand .= "and (category_id='1' OR category_id='5')";
				}
				
				if(stristr($word, 'medic dentist') == TRUE)
				{
					$final_word = str_replace("medic","",$final_word );
					$final_word = str_replace("dentist","",$final_word );
					$query_expand .= "and (category_id='1' OR category_id='5')";
				}
				if(stristr($word, 'cabinet stomatologic') == TRUE)
				{
					$final_word = str_replace("cabinet","",$final_word );
					$final_word = str_replace("stomatologic","",$final_word );
					
					$query_expand .= "and (category_id='1' OR category_id='5')";
				}
				
				if(stristr($word, 'medici') == TRUE)
				{
					$final_word = str_replace("medici","",$final_word );
					$query_expand .= "and (category_id='1' OR category_id='5')";
				}
				elseif(stristr($word, 'medic') == TRUE)
				{
					$final_word = str_replace("medic","",$final_word );
					$query_expand .= "and (category_id='1' OR category_id='5')";
				}
				if(stristr($word, 'cabinete') == TRUE)
				{
					$final_word = str_replace("cabinete","",$final_word );
					$query_expand .= "and (category_id='1' OR category_id='5')";
				}
				elseif(stristr($word, 'cabinet') == TRUE)
				{
					$final_word = str_replace("cabinet","",$final_word );
					$query_expand .= "and (category_id='1' OR category_id='5')";
				}
		

				if(stristr($word, 'clinica dentara') == TRUE)
				{
					$final_word = str_replace("clinica","",$final_word );
					$final_word = str_replace("dentara","",$final_word );
					$query_expand .= "and (category_id='1' OR category_id='5')";

				}
				elseif(stristr($word, 'clinici') == TRUE)
				{
					$final_word = str_replace("clinici","",$final_word );
					$query_expand .= "and category_id='5'";
				}
				elseif(stristr($word, 'clinica') == TRUE)
				{
					$final_word = str_replace("clinica","",$final_word );
					$query_expand .= "and category_id='5'";
				}
				/*made by lumi*/
				if(stristr($word, 'cmi') == TRUE)
				{
					$final_word = str_replace("cmi","",$final_word );
					$final_word = str_replace("CMI","",$final_word );
					$query_expand .= "and (category_id='1' OR category_id='5')";
				}
				
				if(stristr($word, 'stomatologie') == TRUE)
				{
					$final_word = str_replace("stomatologie","",$final_word );
					$query_expand .= "and (category_id='1' OR category_id='5')";
				}

				/*tehnica dentara*/
				if(stristr($word, 'tehnica dentara') == TRUE)
				{
					$final_word = str_replace("tehnica","",$final_word );
					$final_word = str_replace("dentara","",$final_word );
					$query_expand .= "and category_id='2'";
				}
				if(stristr($word, 'tehnician dentar') == TRUE)
				{
					$final_word = str_replace("tehnician","",$final_word );
					$final_word = str_replace("dentar","",$final_word );
					$query_expand .= "and category_id='2'";
				}
				/*radiografie dentara*/
				if(stristr($word, 'radiologie dentara') == TRUE)
				{
					$final_word = str_replace("radiologie","",$final_word );
					$final_word = str_replace("dentara","",$final_word );
					$query_expand .= "and category_id='3'";
				}
				if(stristr($word, 'radiologie') == TRUE)
				{
					$final_word = str_replace("radiologie","",$final_word );
					$query_expand .= "and category_id='3'";
				}
				if(stristr($word, 'radiografie dentara') == TRUE)
				{
					$final_word = str_replace("radiografie","",$final_word );
					$final_word = str_replace("dentara","",$final_word );
					$query_expand .= "and category_id='3'";
				}
				if(stristr($word, 'radiografie') == TRUE)
				{
					$final_word = str_replace("radiografie","",$final_word );
					$query_expand .= "and category_id='3'";
				}
								
				$final_word = trim($final_word);
				if($final_word!='')
				{
					//$sql = " SELECT * FROM cabinete WHERE MATCH (nume_firma,echipa_medicala,descriere,tarife) AGAINST ('+".addslashes($final_word)."' IN BOOLEAN MODE) AND status='1' ".$query_expand;
					
					$sql = " SELECT *,MATCH (nume_firma,echipa_medicala,descriere,tarife) AGAINST ('".$final_word."') as score FROM cabinete WHERE MATCH (nume_firma,echipa_medicala,descriere,tarife) AGAINST ('".addslashes($final_word)."') AND status='1' ".$query_expand;
					$order = ' ORDER BY level DESC,score DESC ';

					//$sql = " SELECT *,MATCH (nume_firma,echipa_medicala,descriere,tarife) AGAINST ('".$final_word."')  FROM cabinete WHERE MATCH (nume_firma,echipa_medicala,descriere,tarife) AGAINST ('".addslashes($final_word)."') AND status='1' ".$query_expand;

					//$sql = " SELECT * FROM cabinete WHERE MATCH (nume_firma,echipa_medicala,descriere,tarife) AGAINST ('".addslashes($final_word)."') AND status='1' ".$query_expand;

					//$order = ' ORDER BY level DESC';

				}
				else
				{
					$sql = " SELECT * FROM cabinete WHERE status='1' ".$query_expand;
					$order = ' ORDER BY level DESC ';
				}
				$sql.=$order.$limit;
				//echo $sql;
				$this->db->query($sql);
				$cabinete_type = array("1"=>"Cabinet stomatologic", "2"=>"Tehnica dentara","3"=>"Laborator radiologie","4"=>"Distribuitori ","5"=>"Clinici stomatologice");
				//var_dump($sql);
				/*if we have no answer on localitate we try on judet*/
				if ($this->db->num_rows()<1)
				{
					
						if(isset($judet) && ($judet !="") )  
						{			
							$query_expand.= " OR judet = '".$judet."'";
						}
						if($final_word!='')
						{
							//$sql = " SELECT * FROM cabinete WHERE MATCH (nume_firma,echipa_medicala,descriere,tarife) AGAINST ('".addslashes($final_word)."' IN BOOLEAN MODE) AND status='1' ".$query_expand;
							$sql = " SELECT *,MATCH (nume_firma,echipa_medicala,descriere,tarife) AGAINST ('".$final_word."') as score FROM cabinete WHERE MATCH (nume_firma,echipa_medicala,descriere,tarife) AGAINST ('".addslashes($final_word)."') AND status='1' ".$query_expand;
							$order = ' ORDER BY level DESC,score DESC ';
						}
						else
						{
							$sql = " SELECT * FROM cabinete WHERE status='1' ".$query_expand;
							$order = ' ORDER BY level DESC ';
						}
						$sql.=$order.$limit;
				}
				//var_dump($sql);
				$this->db->query($sql);
				$i=0;
				while ($this->db->next_record())
				{
					$items[$i]['id'] = $this->db->f('id');
					$items[$i]['titlu'] = $this->db->f('nume_firma');
					$items[$i]['continut'] = $this->db->f('descriere');
					$items[$i]['level'] = $this->db->f('level');
					$items[$i]['url1'] = "cabinete_detalii";
					$items[$i]['url2'] ="cabinete.detalii.".$this->db->f('id');
					$judet_name = CheckIfCountyCity($this->db->f('judet'));
					$items[$i]['judet'] = $cabinete_type[$this->db->f('category_id')]." ".ucfirst($judet_name['name']);
					$i++;
				}
				return $items;
			break;
					
			case 'articole':
				if(stristr($word, 'articole') == TRUE)
				{	$final_word = str_replace("articole","",$final_word );		}
				elseif(stristr($word, 'articol') == TRUE)
				{	$final_word = str_replace("articol","",$final_word );       }

				$check_new_word = CheckIfArticleCategory(trim($final_word));
				if($check_new_word =="")
				{
					#means we have more words not just one
					if(stristr($final_word," " )== TRUE)
					{
							$last_word1 = explode(" ",$final_word);
							$last_word = $last_word1[count($last_word1)-1];
							$check_new_word = CheckIfArticleCategory(trim($last_word));
							if($check_new_word!="" )
							{
								$sql = "SELECT * FROM articles WHERE MATCH (titlu,continut) AGAINST ('".addslashes($final_word)."*' IN BOOLEAN MODE)  AND status='1' AND bigcat_id=".$check_new_word;
							}
							elseif($final_word!='')
							{
								$sql = " SELECT *,MATCH (titlu,continut,autor) AGAINST ('".$final_word."') as score FROM articles WHERE MATCH (titlu,continut,autor) AGAINST ('".addslashes($final_word)."') HAVING score > 0.2 AND status='1' ";
							}
					}
					else
					{
						if($final_word!='')
						{
							$sql = " SELECT *,MATCH (titlu,continut,autor) AGAINST ('".$final_word."') as score FROM articles WHERE MATCH (titlu,continut,autor) AGAINST ('".addslashes($final_word)."') HAVING score > 0.2 AND status='1' ";
						}
					}
				}
				else
				{
					$sql = "SELECT * FROM articles WHERE bigcat_id='".$check_new_word."'";
				}
				$sql.=$limit;
				$this->db->query($sql);
				$i=0;
				while($this->db->next_record())
				{
					$items[$i]['id'] = $this->db->f('id');
					$items[$i]['titlu'] = $this->db->f('titlu');
					$items[$i]['continut'] = $this->db->f('continut');
					$items[$i]['imagine'] = $this->db->f('imagine').'&max_size='.$conf->admin_gallery_max.'&&articles=yes';
					$items[$i]['url1'] = "articole";
					$items[$i]['url2'] ="articole-medicale.articol.".$this->db->f('bigcat_id').'.'.$this->db->f('id');
					$cat_name = CheckIfArticleCategory($this->db->f('bigcat_id'));
					$items[$i]['judet'] = "Articol ".ucfirst($cat_name);
					$i++;
				}
				return $items;
			break;
			
			case 'anunturi':
				if(stristr($word, 'anunturi') == TRUE)
				{
					$final_word = str_replace("anunturi","",$final_word );
				}
				elseif(stristr($word, 'anunt') == TRUE)
				{
					$final_word = str_replace("anunt","",$final_word );
				}
				$query_expand= "";
				#here we make the query expand
				if(isset($localitate) && ($localitate !="") )
				{
					$query_expand.= " AND localitate = '".$localitate."'";
				}
				elseif(isset($judet) && ($judet !="") )  
				{
					
					$query_expand.= " AND judet = '".$judet."'";

				}
				else
				{
				$localitate = $this->checkIfLocalitate($location);
				if($localitate!='')
				{
					if($location == 'Bucuresti')
					{
						$sectoare = $this->getSectoareCapitala();
						$query_expand.= " AND localitate IN (".$sectoare.")";
					}
					else
					{
						$query_expand.= " AND localitate = '".$localitate."'";
					}
				}
				else
				{
					$judet = $this->getJudetCode($location);
					if($judet!='')
					{
						$query_expand.= " AND judet = '".$judet."'";
					}
				}
				}
		
				$final_word = trim($final_word);
				if($final_word!='')
				{
					$sql = "SELECT * FROM anunturi WHERE MATCH (titlu,continut,autor) AGAINST ('".addslashes($final_word)."*' IN BOOLEAN MODE)  AND status='1' ".$query_expand;
				}
				else
				{
					$sql = "SELECT * FROM anunturi WHERE status='1' ".$query_expand;
				}
				
				$sql.=$limit;
				$this->db->query($sql);
				//echo $db->affected_rows();exit;
				while($this->db->next_record())
				{
				
					$items[$i]['id'] = $this->db->f('id');
					$items[$i]['titlu'] = $this->db->f('titlu');
					$items[$i]['continut'] = $this->db->f('continut');
					$items[$i]['imagine'] = $this->db->f('imagine').'&max_size='.$conf->admin_gallery_max.'&anunturi=yes';
					$items[$i]['url1'] = "anunturi_detalii";
					$items[$i]['url2'] ="anunturi.detalii.".$this->db->f('id');
					$judet_name = CheckIfCountyCity($this->db->f('judet'));
					$items[$i]['judet'] = "Anunt ".ucfirst($judet_name['name']);
					$i++;
				}
				return $items;
			break;
		
			case 'tehnica':
				if(stristr($word, 'tehnica dentara') == TRUE)
				{
					$final_word = str_replace("tehnica dentara","",$final_word );
				}
				elseif(stristr($word, 'tehnica') == TRUE)
				{
					$final_word = str_replace("tehnica","",$final_word );
				}
			
				if(stristr($word, 'laboratoare') == TRUE)
				{
					$final_word = str_replace("laboratoare","",$final_word );
				}
				elseif(stristr($word, 'laborator') == TRUE)
				{
					$final_word = str_replace("laborator","",$final_word );
				}
			
				$query_expand.=" AND category_id='2'";
				$final_word = trim($final_word);
				if($final_word!='')
				{
					$sql = " SELECT * FROM cabinete WHERE MATCH (nume_firma,echipa_medicala,descriere,tarife) AGAINST ('*".addslashes($final_word)."*' IN BOOLEAN MODE) AND status='1' ".$query_expand;
				}
				else
				{
					$sql = " SELECT * FROM cabinete WHERE status='1' ".$query_expand;
				}
				$order = ' ORDER BY level DESC ';
				$sql.=$order.$limit;
				$this->db->query($sql);
				$cabinete_type = array("1"=>"Cabinet stomatologic", "2"=>"Tehnica dentara","3"=>"Laborator radiologie","4"=>"Distribuitori ","5"=>"Clinici stomatologice");
				$i=0;
				while ($this->db->next_record())
				{
					$items[$i]['id'] = $this->db->f('id');
					$items[$i]['titlu'] = $this->db->f('nume_firma');
					$items[$i]['continut'] = $this->db->f('descriere');
					$items[$i]['level'] = $this->db->f('level');
					$items[$i]['url1'] = "cabinete_detalii";
					$items[$i]['url2'] ="cabinete.detalii.".$this->db->f('id');
					$judet_name = CheckIfCountyCity($this->db->f('judet'));
					$items[$i]['judet'] =$cabinete_type[$this->db->f('category_id')]." ".ucfirst($judet_name['name']);
					$i++;
				}
				return $items;
			break;
			
			case 'radiologie':
				if(stristr($word, 'radiologie') == TRUE)
				{
					$final_word = str_replace("radiologie","",$final_word );
						
				}
				elseif(stristr($word, 'radiografie') == TRUE)
				{
					$final_word = str_replace("radiografie","",$final_word );
						
				}
				elseif(stristr($word, 'radiografii') == TRUE)
				{
					$final_word = str_replace("radiografii","",$final_word );
						
				}
				$query_expand .= " AND category_id='3'";
				$final_word = trim($final_word);
				if($final_word!='')
				{
					$sql = " SELECT * FROM cabinete WHERE MATCH (nume_firma,echipa_medicala,descriere,tarife) AGAINST ('*".addslashes($final_word)."*' IN BOOLEAN MODE) AND status='1' ".$query_expand;
				}
				else
				{
					$sql = " SELECT * FROM cabinete WHERE status='1' ".$query_expand;
				}
				$order = ' ORDER BY level DESC ';
				$sql.=$order.$limit;
				
				$this->db->query($sql);
				$cabinete_type = array("1"=>"Cabinet stomatologic", "2"=>"Tehnica dentara","3"=>"Laborator radiologie","4"=>"Distribuitori ","5"=>"Clinici stomatologice");
				$i=0;
				while ($this->db->next_record())
				{
					$items[$i]['id'] = $this->db->f('id');
					$items[$i]['titlu'] = $this->db->f('nume_firma');
					$items[$i]['continut'] = $this->db->f('descriere');
					$items[$i]['level'] = $this->db->f('level');
					$items[$i]['url1'] = "cabinete_detalii";
					$items[$i]['url2'] ="cabinete.detalii.".$this->db->f('id');
					$judet_name = CheckIfCountyCity($this->db->f('judet'));
					$items[$i]['judet'] =$cabinete_type[$this->db->f('category_id')]." ".ucfirst($judet_name['name']);
					$i++;
				}
				return $items;
			break;
			
			case 'distribuitori':
				if(stristr($word, 'materiale') == TRUE)
				{
					$final_word = str_replace("materiale","",$final_word );
				}
				elseif(stristr($word, 'distribuitori') == TRUE)
				{
					$final_word = str_replace("distribuitori","",$final_word );
				}
				elseif(stristr($word, 'distribuitor') == TRUE)
				{
					$final_word = str_replace("distribuitor","",$final_word );
				}
			
				$query_expand .= " AND category_id='4'";
			
				$final_word = trim($final_word);
				if($final_word!='')
				{
					$sql = " SELECT * FROM cabinete WHERE MATCH (nume_firma,echipa_medicala,descriere,tarife) AGAINST ('*".addslashes($final_word)."*' IN BOOLEAN MODE) AND status='1' ".$query_expand;
				}
				else
				{
					$sql = " SELECT * FROM cabinete WHERE status='1' ".$query_expand;
				}
				$order = ' ORDER BY level DESC ';
				$sql.=$order.$limit;
				
				$this->db->query($sql);
				$cabinete_type = array("1"=>"Cabinet stomatologic", "2"=>"Tehnica dentara","3"=>"Laborator radiologie","4"=>"Distribuitori ","5"=>"Clinici stomatologice");
				$i=0;
				while ($this->db->next_record())
				{
					$items[$i]['id'] = $this->db->f('id');
					$items[$i]['titlu'] = $this->db->f('nume_firma');
					$items[$i]['continut'] = $this->db->f('descriere');
					$items[$i]['level'] = $this->db->f('level');
					$items[$i]['url1'] = "cabinete_detalii";
					$items[$i]['url2'] ="cabinete.detalii.".$this->db->f('id');
					$judet_name = CheckIfCountyCity($this->db->f('judet'));
					$items[$i]['judet'] =$cabinete_type[$this->db->f('category_id')]." ".ucfirst($judet_name['name']);
					$i++;
				}
				return $items;
			break;
			
			case 'evenimente':
				if(stristr($word, 'eveniment') == TRUE)
				{
					$final_word = str_replace("eveniment","",$final_word );
				}
				elseif(stristr($word, 'evenimente') == TRUE)
				{
					$final_word = str_replace("eveniment","",$final_word );
				}

				if($final_word!='')
				{
					$sql = "SELECT * FROM news WHERE MATCH(title,content) AGAINST('".addslashes($final_word)."*' IN BOOLEAN MODE) AND status='1' AND Place LIKE '%".$location."%'";
				}
				else
				{
					$sql = "SELECT * FROM news WHERE status='1' AND Place LIKE '%".$location."%'";
				}
				$sql.=$limit;
				
				$this->db->query($sql);
				$i=0;
				while ($this->db->next_record())
				{
					$items[$i]['id'] = $this->db->f('id');
					$items[$i]['titlu'] = $this->db->f('title');
					$items[$i]['continut'] = $this->db->f('content');
					$items[$i]['imagine'] = $this->db->f('imagine');
					$items[$i]['location'] = $this->db->f('Place');
					$items[$i]['submision_date'] = $this->db->f('submision_date');
					$items[$i]['position'] = $this->db->f('position');
					$items[$i]['alias'] = $this->db->f('alias');
					$items[$i]['status'] = $this->db->f('status');
					$i++;
				}
				return $items;
				
			break;
		}
	}
	/*
	 * here we display the results
	 */
	public function displaySearchResults($cat,$word,$location,$limit)
	{
		global $tpl,$conf;
		
		$rez = $this->listSearchResults($cat,$word,$location,$limit);
		//print_r($rez);
		
		switch ($cat)
		{
			case 'dentisti':
			default:
				$pachete = new Pachete_Servicii($this->db);
				foreach($rez as $ky => $val)
				{
					$tpl->parse('if_recomandat2','');
					$tpl->parse('if_business2','');
					$recomandat = false;
					$tpl->set_var('NUME_FIRMA', ucwords(strtolower($val['titlu'])) );
					$tpl->set_var('DESCRIERE',text_best_fit(ucfirst(strtolower($val['continut'])),160));
					$main_photo = GetCabineteMainPhoto($val['id'],"cabinet");
					$levels = explode(",",$val['level']);
					foreach($levels as $k => $v)
					{
						if($pachete->hasRecomandat($v))
						{
							$recomandat = true;
						}
					}
					
					if($recomandat)
					{
						$tpl->set_var('RECOMANDAT_CLASS','recomandat');
						$tpl->parse('if_recomandat2','if_recomandat',true);
					}
					else 
					{
						// if the package is not FREE and is not RECOMANDAT it means this is business or what ever
						if($pachete->ifPachetFree($val['level'])===false && $recomandat===false)
						{
							$tpl->parse('if_business2','if_business',true);
						}
						$tpl->set_var('RECOMANDAT_CLASS','');
					}

					$tpl->set_var('THUMBNAIL', SITE_BASE."/sources/thumbnails.php?target=".$main_photo['image_name'].'&max_size='.$conf->admin_gallery_max.'&folder='.$val['id']);
					$tpl->set_var('URLCITESTE',Rewrite($val['url1'],$val['url2']));
					$tpl->set_var('JUDET',$val['judet']);
					$tpl->parse('results2','results',true);
				}
			break;
			
			case 'articole':
				foreach($rez as $ky => $val)
				{
					$tpl->parse('if_recomandat2','');
					$tpl->parse('if_business2','');
					$tpl->set_var('BOX_TAB_CLASS','home_cab_box_head');
					$tpl->set_var('NUME_FIRMA',$val['titlu'] );
					$tpl->set_var('DESCRIERE',ucfirst(strtolower(text_best_fit($val['continut'],130))));
					$tpl->set_var('THUMBNAIL', SITE_BASE."/sources/thumbnails.php?target=".$val['imagine']);
					$tpl->set_var('URLCITESTE',Rewrite($val['url1'],$val['url2']));
					$tpl->set_var('JUDET',$val['judet']);
					$tpl->parse('results2', 'results', true);
				}
			break;
			
			case 'anunturi':
				foreach($rez as $ky => $val)
				{
					$tpl->parse('if_recomandat2','');
					$tpl->parse('if_business2','');
					$tpl->set_var('BOX_TAB_CLASS','home_cab_box_head');
					$tpl->set_var('NUME_FIRMA',$val['titlu'] );
					$tpl->set_var('DESCRIERE',ucfirst(strtolower(text_best_fit($val['continut'],130))));
					$tpl->set_var('THUMBNAIL', SITE_BASE."/sources/thumbnails.php?target=".$val['imagine']);
					$tpl->set_var('URLCITESTE',Rewrite($val['url1'],$val['url2']));
					$tpl->set_var('JUDET',$val['judet']);
					$tpl->parse('results2', 'results', true);
				}
			break;
			
			case 'evenimente':
			foreach($rez as $ky => $val)
				{
					$tpl->parse('if_recomandat2','');
					$tpl->parse('if_business2','');
					$tpl->set_var('BOX_TAB_CLASS','home_cab_box_head');
					$tpl->set_var('NUME_FIRMA',ucwords(strtolower($val['titlu'])));
					$tpl->set_var('DESCRIERE',ucfirst(strtolower(text_best_fit($val['continut'],130))));
					$tpl->set_var('THUMBNAIL', SITE_BASE."/sources/thumbnails.php?target=".$val['imagine']);
					$tpl->set_var('URLCITESTE',ReWrite('news', 'news.detalii.'.$val['id']));
					$tpl->set_var('JUDET','Evenimente medicale '.$val['location']);
					$tpl->parse('results2', 'results', true);
				}
			break;
		}
		
	}
	/*
	 * check if this is localitate and if so return the id
	 */
	public function checkIfLocalitate($loc)
	{
		$sql = "SELECT id FROM localitati WHERE name = '$loc'";
		$this->db->query($sql);
		if($this->db->num_rows()>0)
		{
			$this->db->next_record();
			return $this->db->f('id');
		}
		else 
		{
			return '';
		}
	}
	/*
	 * check if this is judet and if so return the code
	*/
	public function getJudetCode($loc)
	{
		$sql = "SELECT code FROM judete WHERE name = '$loc'";
		$this->db->query($sql);
		if($this->db->num_rows()>0)
		{
			$this->db->next_record();
			return $this->db->f('code');
		}
		else
		{
			return '';
		}
	}
	/*
	 * list all localitati
	 */
	public function listAllLocalitati($str=false,$limit=false)
	{
		if($str!==false)
		{
			$sql = "SELECT * FROM localitati WHERE status='Y' AND name LIKE '".$str."%' ORDER BY name ASC ".$limit;
		}
		else 
		{
			$sql = "SELECT * FROM localitati WHERE status='Y' ORDER BY name ASC";
		}
		
		$this->db->query($sql);
		$i=0;
		while ($this->db->next_record())
		{
			$info[$i]['id'] = $this->db->f('id');
			$info[$i]['name'] = $this->db->f('name');
			$info[$i]['judet_code'] = $this->db->f('judet_code');
			$i++;
		}
		return $info;
	}
	/*
	 * list all judete
	*/
	public function listAllJudete()
	{
		$sql = "SELECT * FROM judete ORDER BY name ASC";
		$this->db->query($sql);
		$i=0;
		while ($this->db->next_record())
		{
			$info[$i]['id'] = $this->db->f('id');
			$info[$i]['name'] = $this->db->f('name');
			$info[$i]['code'] = $this->db->f('code');
			$i++;
		}
		return $info;
	}
	/*
	 * here is the pagination
	 */
	public function Pagination ($per_page, $totals, $page_name, $p)
	{
		global $conf;
		global $tpl;
		
		$html_pages = ''; 
		if($conf->url_rewrite_mode == 'N')
		{
				$start = ($p-1)*$per_page; 
				$pages = ceil($totals/$per_page); 
	
				if ($pages > 1 )
				{
					if (($p-1) > 0 )
					{
						$html_pages.="<a href=?p=".$page_name."&start=1 >&laquo; Prima </a>";
					}
					for($i = max(($p-8), 1); $i <= min(($p+8),$pages) ; $i++)
					{
						if ($p == $i)
						{
							$html_pages.= "<strong>".$i." </strong>";
						}
						else
						{
						$html_pages.="<a href=?p=".$page_name."&start=".$i." >".$i."</a>";
						}
					}
					if ($p < $pages)
					{
					$html_pages.=" <a href=?p=".$page_name."&start=".$pages." >Ultima &raquo;</a>";
					}
				}	
		}
		else
		{
			#means we have urlrewrite on
			$start = ($p-1)*$per_page; 
			$pages = ceil($totals/$per_page); 
			
			if ($pages > 1 )
			{
				if (($p-1) > 0 )
				{
					$html_pages.="<li><a href=".ReWrite('advsearch',$page_name.'.1')." >&laquo; Prima </a></li>";
				}
				for($i = max(($p-8), 1); $i <= min(($p+8),$pages) ; $i++)
				{
					if ($p == $i)
					{
						$html_pages.= "<li class='active'><a href='#'>".$i."</a></li>";
					}
					else
					{
						$html_pages.="<li><a href=".ReWrite('advsearch',$page_name.'.'.$i).">".$i."</a></li>";
					}
				}
				if ($p < $pages)
				{
					$html_pages.=" <li><a href=".ReWrite('advsearch',$page_name.'.'.$pages)." >Ultima &raquo;</a></li>";
				}
				
				// display into head the pagination relation
				if($p>1) $tpl->set_var('PAGINATION_PREV', '<link rel="prev" href="'.ReWrite('advsearch',$page_name.'.'.($p-1)).'">');
				else $tpl->set_var('PAGINATION_PREV', '');
					
				if ($p < $pages) $tpl->set_var('PAGINATION_NEXT', '<link rel="next" href="'.ReWrite('advsearch',$page_name.'.'.($p+1)).'">');
				else $tpl->set_var('PAGINATION_NEXT', '');
				
			}
		}
		
		return $html_pages;
	}
	
}