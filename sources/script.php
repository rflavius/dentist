<?php

require('../preload.php');
error_reporting(2047);
set_magic_quotes_runtime(0);
ini_set('display_errors', '1');
ini_set('memory_limit', '256M');

/*$google_query  = 'http://www.google.com/search?hl=ro&q=%22cabinete+stomatologice%22';
//echo $google_query;exit;
$userAgent = 'Googlebot/2.1 (http://www.googlebot.com/bot.html)'; // change the userAgent
$domain = 'net';

$k=0;
while($k<200)
{
	$j=0;
	$search_query = $google_query."&num=100&start=".$k."&btnG=Search&lr=";
	//echo "<p> Google QUERY: ".$search_query."</p>";//exit;

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
	curl_setopt($ch, CURLOPT_URL,$search_query);
	curl_setopt($ch, CURLOPT_FAILONERROR, true);
	@curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_AUTOREFERER, true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
	curl_setopt($ch, CURLOPT_TIMEOUT, 60);
	$html= curl_exec($ch);
	//print_r($html);
	if(stristr($html,"did not match any documents")!==FALSE)
	{
		$sql = "UPDATE cron SET status='Y' WHERE query='".$google_query."'";
		$db->query($sql);
		//echo "Didn't found any results!";
		//exit;
	}
	//print_r($html);
	if (!$html) {
		//echo "cURL error number:".curl_errno($ch);
		//echo "cURL error:".curl_error($ch);
		exit;
	}

	// parse the html into a DOMDocument
	$dom = new DOMDocument();
	@$dom->loadHTML($html);

	// grab all the on the page
	$xpath = new DOMXPath($dom);
	$hrefs = $xpath->evaluate("/html/body/div//a");

	for ($i = 0; $i < $hrefs->length; $i++)
	{
		$href = $hrefs->item($i);
		$url = $href->getAttribute('href');
		if((stristr($url,"q=")===FALSE) && (stristr($url,"hl=")===FALSE) && (stristr($url,"google")===FALSE))
		{
			storeLink($url,$search_query,$domain);
			echo "<p>found URL : ".$url."</p>";
			$j++;
			echo "<p>Numbers of URL's found: ".$j."</p>";
		}
	}

	$k = $k + 100;
}
*/

/***************insert into unique emails*********************
function storeemail($email)
{
	global $db;
	$sql = "INSERT INTO unique_emails( `email`) VALUES ('".$email."')";
	
	$db->query($sql);
}
function CheckEmail($mail)
{	
	global $db;
	$query ="Select * from unique_emails where email='".$mail."'";
	$db->query($query);
	if($db->affected_rows()>0)
	{
		return false;
	}
	return true;
}

$i=0;
$query ="Select * from emails2 Limit 1600,1800";
$db->query($query);
while($db->next_record())
{
	$emails[$i] = $db->f('email');
	$i++;
}
foreach($emails as $ky => $val)
{
	if(strpos($val,"%20")!=FALSE)
	{
		$val=substr($val,0,-3);
	}
		if(CheckEmail($val))
	{
		
		storeemail($val);
		echo $val."<br />";
	}
}*/

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
#clean dictionary table

$sql="Select * from dictionary where (id>20000 and id<30000)";
$db->query($sql);$i=0;$dict_term = array();
while($db->next_record())
	{
		$dict_term[$i]['id'] =$db->f('id');
		$dict_term[$i]['titlu'] =$db->f('titlu');
		$dict_term[$i]['continut'] =$db->f('continut');
		$dict_term[$i]['alias'] =$db->f('alias');
		$i++;
	}

foreach($dict_term as $ky => $val)
{
		$term_name = ucfirst(strtolower($val['titlu']));
		$term_name = ucfirst(trim($term_name));
		$meta_k =  $term_name.",dictionar stomatologic,definitii stomatologie,explicatii stomatologice,medicina,termen medical,dictionar on line";
		$meta_d = $term_name.", explicatia cuvantului ".$term_name.",dictionar stomatologic on line,termen medical.";
	

		

		$content = $val['continut'];
		

		if(stristr($content,"â")!=FALSE)
		{
			$content =str_replace("â","a",$content);
		}
			if(stristr($content,"î")!=FALSE)
		{
			$content=str_replace("î","i",$content);
		}
		
		if(stristr($content,"ă")!=FALSE)
		{
			$content=str_replace("ă","a",$content);
		}

		if(stristr($content,"ş")!=FALSE)
		{
			$content = str_replace("ş","s",$content);
		}
			if(stristr($content,"ţ")!=FALSE)
		{
			$content=str_replace("ţ","t",$content);
		}
		
		
		$alias = GenerateAlias($term_name);
		$first_letter = ucfirst(substr($term_name,0,1));
		$q = "SELECT * from dictionary_categories where cat_name ='".$first_letter ."'";
		$db->query($q);
		$db->next_record();
		$category_id = $db->f('id_cat');

	
	$query = "Update dictionary set titlu='".trim($term_name)."',continut='".addslashes($content)."',bigcat_id='".$category_id."',data_adaugarii=now(),meta_keywords='".$meta_k."',meta_description='".$meta_d."',alias='".$alias."' where id='".$val['id']."'";
	$db->query($query);
		

}
?>