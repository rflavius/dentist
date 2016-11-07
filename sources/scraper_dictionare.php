<?php

require('../preload.php');
error_reporting(2047);
set_magic_quotes_runtime(0);
ini_set('display_errors', '1');

function average_words_sentence_domo($text)
{
	$real_sent="";

	if(stristr($text,"Click")!=FALSE)
	{
		$sentences = preg_replace('#\<[^>]*\>#', '', $text);
		$sent = explode("Click",$sentences );
		for($i = 0; $i < count($sent); $i++)
		{
			if(stristr($sent[$i],">")!=FALSE)
			{
				$real_sent .= substr($sent[$i],strpos($sent[$i],">")+1 );
			}
			else
			{
				$real_sent .= $sent[$i];
			}
			
		}
		
	}
	else
	{
		$real_sent = $text;
	}
	
	return ($real_sent);
}

function storeLink($url,$gathered_from,$domain)
{
	global $db;
	$sql = "INSERT INTO scraped_sites(`url`,`scraped`, `type`) VALUES ('".$url."','N','cab_st')";
	
	$db->query($sql);
}

function http_curlconnect($url)
	{
		$html="";
		$userAgent = $_SERVER['HTTP_USER_AGENT'];
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_FAILONERROR, true);
		@curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_AUTOREFERER, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 60);
		$html = curl_exec($ch);
		return $html;
	}



#------------------------scrape again www.sfatuldentistului.ro------------------------DONE ALL------#
/*$letters = array('A','B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'V', 'W', 'Z');
foreach($letters as $ky => $val)
{
	$url = "http://www.sfatuldentistului.ro/index.php?Dictionar+stomatologic&m=30&filtru=".$val;
	$content = http_curlconnect($url);
	$dom = new DOMDocument();
	@$dom->loadHTML($content);

	// grab all the on the page
	$xpath = new DOMXPath($dom);
	$hrefs = $xpath->evaluate("/html/body//a");
	for ($j = 0; $j < $hrefs->length; $j++)
	{
		$href = $hrefs->item($j);
		$urll = $href->getAttribute('href');
		
	//	echo $urll;
	//	echo "<br />";
		if((stristr($urll,"Dictionar+stomatologic&m=30&filtru=".$val."&articol=")!=FALSE))
		{
			echo $urll;
			echo "<br />";
			$id++;
			storeLink($id, $urll,"","");
		}
	}
}
	$i=1;$url=array();
	$query="Select * from scraped_sites where id>549 and id<645";
	$db->query($query);
	while($db->next_record())
	{
		$url[$i] =$db->f('url');
		$i++;
	}
	
	foreach($url as $ky => $val)
	{
		$val="http://www.sfatuldentistului.ro".$val;;
		$content = http_curlconnect($val);
		$cont1 = explode("padding:10px 5px 10px 5px; text-align:justify",$content);
		$cont2 = explode("</div>",$cont1[1]);
		$cont3 = substr($cont2[0],2);
		$term = explode("articol=" ,$val);
		$term1 = substr($term[1],0,strpos($term[1],"&"));
	echo $term1."<br /><br />".$cont3;
		

	
		$meta_k =  $term.", dictionar stomatologic,definitii stomatologie,explicatii stomatologice,medicina,termen medical,dictionar on line";
		$meta_d = $term.", explicatia cuvantului ".$term.",dictionar stomatologic on line,termen medical.";
		echo "<br />";

		$alias = GenerateAlias($term);
		$q = "SELECT * from dictionary_categories where cat_name like '%".ucfirst(substr($term,1,1))."%'";
		$db->query($q);
		$db->next_record();
		$category_id = $db->f('id_cat');
		$category_id="";$alias="";$meta_k="";$meta_d="";

		$query = "Insert into dictionary (titlu,continut,bigcat_id,data_adaugarii,meta_keywords,meta_description,alias) values('".addslashes($term1)."','".addslashes($cont3)."','".$category_id."',now(),'".addslashes($meta_k)."','".addslashes($meta_d)."','".$alias."')";
		$db->query($query);

	}
exit;*/

#in scraped_sites de la 6243 pana la 8367--------------------!!!!!!!!!!!!!!!!!!!!!!!
#-----------------------Scarapre http://www.dmo.ro/-------------------------------------Not DONE- Content -#

	/*	$letters = array('I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'V', 'W', 'Z');
	foreach($letters as $ky => $val)
	{
		$url = "http://www.dmo.ro/litera/".$val.".html";
		$content = http_curlconnect($url);

			$dom = new DOMDocument();
			@$dom->loadHTML($content);

			// grab all the on the page
			$xpath = new DOMXPath($dom);
			$hrefs = $xpath->evaluate("/html/body//a");
			for ($j = 0; $j < $hrefs->length; $j++)
			{
				$href = $hrefs->item($j);
				$urll = $href->getAttribute('href');
				
				if((stristr($urll,"http://www.dmo.ro/".$val)!==FALSE))
				{
					echo $urll;
					echo "<br />";
					$id++;
					storeLink($urll,"","");
				}
			}
	}

	$i=1;$url=array();
	$query="Select * from scraped_sites where id>7999 and id <8367";
	$db->query($query);
	while($db->next_record())
	{
		$url[$i] =$db->f('url');
		$i++;
	}
	
	foreach($url as $ky => $val)
	{
		$content = http_curlconnect($val);
		$cont1=explode("Descriere",$content);
		$conte=Explode("</td>",$cont1[1]);
		$cont = $conte[0];
		$cont = str_replace('<br />',"",$cont);
		$cont = str_replace('Äƒ',"a",$cont);
		$cont = str_replace('ÅŸ',"s",$cont);
		$cont = str_replace('Ã®',"a",$cont);
		$cont = str_replace('Å£',"t",$cont);
		$cont = str_replace(':'," ",$cont);
		$cont = str_replace('Ã¢',"i",$cont);
		$cont = average_words_sentence_domo($cont);
		
		$content = $cont;
		$term = str_replace("http://www.dmo.ro/"," ",$val);
		$term = str_replace(".html"," ",$term);
		if(stristr($term,'(1)')!=FALSE)
		{
			$term = str_replace("(1)"," ",$term);
		}
		echo $term;
		echo $cont;

		$meta_k =  $term.", dictionar stomatologic,definitii stomatologie,explicatii stomatologice,medicina,termen medical,dictionar on line";
		$meta_d = $term.", explicatia cuvantului ".$term.",dictionar stomatologic on line,termen medical.";
		echo "<br />";

		$alias = GenerateAlias($term);
		$q = "SELECT * from dictionary_categories where cat_name like '%".ucfirst(substr($term,1,1))."%'";
		$db->query($q);
		$db->next_record();
		$category_id = $db->f('id_cat');
		$category_id="";$alias="";$meta_k="";$meta_d="";


		$query = "Insert into dictionary (titlu,continut,bigcat_id,data_adaugarii,meta_keywords,meta_description,alias) values('".addslashes($term)."','".addslashes($cont)."','".$category_id."',now(),'".addslashes($meta_k)."','".addslashes($meta_d)."','".$alias."')";
		$db->query($query);

	}
*/
	#de scrapat http://www.sfatulmedicului.ro
	#http://www.netmedic.ro/dictionar-medical/A
	#http://www.copilul.ro/
	
	
#in scraped_sites de la 1 pana la 6243-----------------------!!!!!!!!!!!!!!!!!!!!!!!
/*----------------------SCRAPAT   #http://www.sfatmedical.ro/-------------- DONE CONTENT-----------*/


/*
$letters = array('A'=>'19','B'=>'9' ,'C'=>'19', 'D'=>'3', 'E'=>'3', 'F'=>'2', 'G'=>'2', 'H'=>'3', 'I'=>'2', 'J'=>'1', 'K'=>'1', 'L'=>'2', 'M'=>'3', 'N'=>'1', 'O'=>'2', 'P'=>'4', 'R'=>'2', 'S'=>'4', 'T'=>'3', 'U'=>'1', 'V'=>'2', 'W'=>'1', 'Z'=>'1','X'=>'1');

foreach($letters as $ky => $val)
{

	for($i = 1; $i <= $val; $i++)
	{
		$url= "http://www.sfatmedical.ro/Dictionar_medical/".$ky."/".$i;
		$content=http_curlconnect($url);
		$dom = new DOMDocument();
		@$dom->loadHTML($content);

				// grab all the on the page
				$xpath = new DOMXPath($dom);
				$hrefs = $xpath->evaluate("/html/body//a");
				for ($j = 0; $j < $hrefs->length; $j++)
				{
					$href = $hrefs->item($j);
					$urll = $href->getAttribute('href');
					
					if((stristr($urll,"http://www.sfatmedical.ro/Dictionar_medical/".$ky)!==FALSE))
					{
						echo $urll;
						echo "<br />";
					
						storeLink($urll,"","");
					}
				}
		}

}

	$i=1;$url=array();
	$query="Select * from scraped_sites where id>4999 and id <6244";
	$db->query($query);
	while($db->next_record())
	{
		$url[$i] =$db->f('url');
		$i++;
	}
	
	foreach($url as $ky => $val)
	{
		$content = http_curlconnect($val);
		$cont1=explode("<td valign=\"top\" style=\"text-indent:20px;\">",$content);
		$conte=Explode("</td>",$cont1[1]);
		$cont = $conte[0];
				
		$content = $cont;
		$term = str_replace("http://www.sfatmedical.ro/Dictionar_medical/"," ",$val);
		$term = str_replace("_"," ",$term);
		echo $term;
		echo $cont;
	$meta_k =  $term.", dictionar stomatologic,definitii stomatologie,explicatii stomatologice,medicina,termen medical,dictionar on line";
		$meta_d = $term.", explicatia cuvantului ".$term.",dictionar stomatologic on line,termen medical.";
		echo "<br />";

		$alias = GenerateAlias($term);
		$q = "SELECT * from dictionary_categories where cat_name like '%".ucfirst(substr($term,1,1))."%'";
		$db->query($q);
		$db->next_record();
		$category_id = $db->f('id_cat');
		$category_id="";$alias="";$meta_k="";$meta_d="";


		$query = "Insert into dictionary (titlu,continut,bigcat_id,data_adaugarii,meta_keywords,meta_description,alias) values('".addslashes($term)."','".addslashes($cont)."','".$category_id."',now(),'".addslashes($meta_k)."','".addslashes($meta_d)."','".$alias."')";
		$db->query($query);

	}
*/
#---------------------------de scrapat http://www.sfatulmedicului.ro-------Done#
/*
$letters = array('A'=>'30','B'=>'9' ,'C'=>'15', 'D'=>'12', 'E'=>'12', 'F'=>'10', 'G'=>'8', 'H'=>'12', 'I'=>'16', 'J'=>'1', 'K'=>'3', 'L'=>'14', 'M'=>'13', 'N'=>'5', 'O'=>'8', 'P'=>'20', 'R'=>'7', 'S'=>'25', 'T'=>'14', 'U'=>'3', 'V'=>'6', 'W'=>'1', 'Z'=>'1','X'=>'1');

foreach($letters as $ky => $val)
{

	for($i = 1; $i <= $val; $i++)
	{
		$url= "http://www.sfatulmedicului.ro/Dictionar_medical/".$ky.".html?pag=".$i;
		$content=http_curlconnect($url);
		$dom = new DOMDocument();
		@$dom->loadHTML($content);

				// grab all the on the page
				$xpath = new DOMXPath($dom);
				$hrefs = $xpath->evaluate("/html/body//a");
				for ($j = 0; $j < $hrefs->length; $j++)
				{
					$href = $hrefs->item($j);
					$urll = $href->getAttribute('href');
					
					if((stristr($urll,"/Dictionar_medical/")!=FALSE))
					{
						echo $urll;
						echo "<br />";
					
					storeLink($urll,"","");
					}
				}
		}

}

	$i=1;$url=array();
	$query="Select * from scraped_sites where id>25000 and id <26000";
	$db->query($query);
	while($db->next_record())
	{
		$url[$i] =$db->f('url');
		$i++;
	}
	
	foreach($url as $ky => $val)
	{
		$val = "http://www.sfatulmedicului.ro".$val;

		$content = http_curlconnect($val);
		$cont1=explode("<div id=\"dictDef\">",$content);
		$conte = substr($cont1[1],0,strpos($cont1[1],"</div>"));
		//$cont = str_replace("<p align=\"justify\"><font size=\"2\">","",$conte);
		if(stristr($conte,"<font face=\"verdana,geneva\" size=\"2\">")!=FALSE)
		{
			$conte=str_replace("<font face=\"verdana,geneva\" size=\"2\">","",$conte);
		}
			if(stristr($conte,"</font>")!=FALSE)
		{
			$conte=str_replace("</font>","",$conte);
		}
		
		if(stristr($conte,"</div>")!=FALSE)
		{
			$conte=str_replace("</div>","",$conte);
		}

		if(stristr($conte,"<br clear=\"<br />")!=FALSE)
		{
			$conte = str_replace("<br clear=\"<br />","",$conte);
		}
			if(stristr($conte,"<br />")!=FALSE)
		{
			$conte=str_replace("<br />","",$conte);
		}
		
			if(stristr($conte,"na,geneva\" size=\"2\">")!=FALSE)
		{
			$conte=str_replace("na,geneva\" size=\"2\">","",$conte);
		}
		
				
		$content = $conte;
		$term = str_replace("http://www.sfatulmedicului.ro/Dictionar_medical/"," ",$val);
		$term = str_replace("_"," ",$term);
		$term = substr($term,0,-10);
		
		$meta_k =  $term.", dictionar stomatologic,definitii stomatologie,explicatii stomatologice,medicina,termen medical,dictionar on line";
		$meta_d = $term.", explicatia cuvantului ".$term.",dictionar stomatologic on line,termen medical.";
		echo "<br />";

		$alias = GenerateAlias($term);
		$q = "SELECT * from dictionary_categories where cat_name like '%".ucfirst(substr($term,1,1))."%'";
		$db->query($q);
		$db->next_record();
		$category_id = $db->f('id_cat');
		$category_id="";$alias="";$meta_k="";$meta_d="";

	if(isset($conte)&&($conte!=""))
	{
		echo $term." ";
		echo $conte;
		echo "<br />";
		$query = "Insert into dictionary (titlu,continut,bigcat_id,data_adaugarii,meta_keywords,meta_description,alias) values('".addslashes($term)."','".addslashes($conte)."','".$category_id."',now(),'".addslashes($meta_k)."','".addslashes($meta_d)."','".$alias."')";
		$db->query($query);
	}
		

	}
*/
?>