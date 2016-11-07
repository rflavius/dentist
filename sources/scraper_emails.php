<?php
require('../preload.php');
set_time_limit(0);
function storeLink($email="",$type)
{
	global $db;
	$sql = "INSERT INTO new_emails(`email`, `type`) VALUES ('".$email."','".$type."')";
	
	$db->query($sql);
}
/*function storeLink($url="",$email="",$judet="",$type)
{
	global $db;
	$sql = "INSERT INTO url_cabinete_directe(`url`,`email`, `type`,`judet`) VALUES ('".addslashes($url)."','".$email."','".$type."','".$judet."')";
	
	$db->query($sql);
}

#***************************WebIndex***********************************
#we scarpe http://www.webindex.ro/cabinete_stomatologice.html
$url = "http://www.webindex.ro/cabinete_stomatologice.html";
$search_engine="google";
$cookies="";
$a = http_gett($url, $cookies,$search_engine) ;

$dom = new DOMDocument();
@$dom->loadHTML($a);

// grab all the on the page
$xpath = new DOMXPath($dom);
$hrefs = $xpath->evaluate("/html/body//img");

for ($i = 0; $i < $hrefs->length; $i++)
{
	$href = $hrefs->item($i);
	$url = $href->getAttribute('alt');
	if(stristr($url,"www")!==FALSE)
	{
	storeLink($url);
	echo "<p>found URL : ".$url."</p>";
	$j++;
	echo "<p>Numbers of URL's found: ".$j."</p>";
	}
}


#***************************Util21**********************************
#lets scrape something elese
#here we scarpe util21.ro/sanatate/cabinete-stomatologice
$judete = array("Suceava","Timis","Tulcea","Dolj","Satu_Mare","Sibiu","Alba","Arad","Arges","Iasi","Maramures","Bistrita","Braila","Brasov","Bucuresti","Buzau","Cluj","Constanta");
foreach($judete as $ky => $val)
{
$url = "http://www.util21.ro/sanatate/cabinete-stomatologice-".$val.".htm";
$search_engine="google";$cookies="";
$a = http_gett($url, $cookies,$search_engine) ;


	$dom = new DOMDocument();
	@$dom->loadHTML($a);
	
	$xpath = new DOMXPath($dom);
	$hrefs = $xpath->evaluate("/html/body//ul/li//a");
	$j=0;
	for ($i = 0; $i < $hrefs->length; $i++) 
	{
	$href = $hrefs->item($i);
	$url = $href->getAttribute('href');
	if(stristr($url,"mailto:")!==FALSE)
	{	$judet = $val;
		$addres_mail = substr($url,7);
		storeLink("",$addres_mail,$judet);
		echo "<p>found URL : ".$url."</p>";
		$j++;
		echo "<p>Numbers of URL's found: ".$j."</p>";
	}
	echo "<br />Link stored: $url";
}
}


#***************************ABCDENT****************************** scarpat azi 2008*****
#here we scarpe from www.abcdent.ro
#am scarpat cabinte stomatologice si laboratoare

$url = "http://www.abcdent.ro/index.php?x=cabinete_stomatologice&jud1=&cab1=&pag=14&order=";
//$url = "http://www.abcdent.ro/index.php?x=laboratoare";
$search_engine="google";$cookies="";
$a = http_gett($url, $cookies,$search_engine) ;


	$dom = new DOMDocument();
	@$dom->loadHTML($a);
	
	$xpath = new DOMXPath($dom);
	$hrefs = $xpath->evaluate("/html/body//a");
	$j=0;
	for ($k = 0; $k < $hrefs->length; $k++) 
	{
	$href = $hrefs->item($k);
	$url = $href->getAttribute('href');
	if(stristr($url,"mailto:")!==FALSE)
	{
		$addres_mail = substr($url,7);
		echo "emails: ".$addres_mail."<br />";
		storeLink($addres_mail,"cab_td");
		//echo "<p>found URL : ".$url."</p>";
		$j++;
		//echo "<p>Numbers of URL's found: ".$j."</p>";
	}
	//echo "<br />Link stored: $url";
	}
*/

class scraper {
     function browse($s_url, $s_user_agent) 
			 {
        print "scraper: browse: Calling $s_url...\n";
        $o_ch = curl_init();
        curl_setopt ($o_ch, CURLOPT_URL, $s_url);
        curl_setopt ($o_ch, CURLOPT_USERAGENT, $s_user_agent);
        curl_setopt ($o_ch, CURLOPT_HEADER, 0);
        curl_setopt ($o_ch, CURLOPT_RETURNTRANSFER, 1);
        $s_html = curl_exec ($o_ch);
        curl_close ($o_ch);
        unset($o_ch);
        
        // Clean html ---------------------
        for ($ascii = 0; $ascii <= 9; $ascii++) $s_html = str_replace(chr($ascii), "", $s_html);
        for ($ascii = 11; $ascii < 32; $ascii++) $s_html = str_replace(chr($ascii), "", $s_html);
        for ($ascii = 127; $ascii <= 255; $ascii++) $s_html = str_replace(chr($ascii), "", $s_html);

        if (!$s_html) print "scraper: WARNING: no results...\n\n";
        return $s_html;

    } //end function
    
    
    // ------------------------------------------------------------------
    function extract ($s_html, $s_start_pattern, $s_end_pattern, $s_model) {
        
        print "scraper: OK. extracting...\n";
        $a_result = array();
        // Cut first block -----------------------
        $i_pos = strpos($s_html, $s_start_pattern);
        $s_html = substr($s_html, $i_pos);
        // Cut last block ----------------------
        $i_pos = strpos($s_html, $s_end_pattern);
        $s_html = substr($s_html, 0, $i_pos);
    
        $s_model = strtolower($s_model);
        $a_model = explode ("\n", $s_model);
        $i_model = count($a_model);
        if (!$a_model[$i_model - 1]) unset($a_model[$i_model - 1]);
        
        $a_html = explode ("<", $s_html);
        $i_cnt = count($a_html);

        // Extract data within tags -----
        for ($f = 0; $f < $i_cnt; $f++) {
            $tag = "<" . $a_html[$f];
            $closepos = strpos ($tag, ">");
            $value = substr($tag, $closepos + 1, strlen($tag) - $closepos);
            $tag = substr($tag,0,strlen($tag) - strlen($value));
            $a_html[$f] = strtolower($tag);
            $dat[$f] = $value;
        }

        $pat = 0;
        $a_pat = array();
        
        for ($f=0; $f < $i_cnt; $f++) {
        
            if ($a_model[$pat]=="<field>") {
                
                // Get data --------
                $value = $dat[$f-1];
                $value = str_replace ("\t", "", $value);
                $value = str_replace ("\n", "", $value);
                $value = str_replace ("\r", "", $value);
                $value = trim ($value);
                if (!$value) $value = "{e}";

                array_push($a_pat,$dat[$f-1]);
                $pat++;
                $f--;
            
            } else {
                
                // check pattern ---------------------
                if (substr($a_model[$pat],0,1) == "<") {
                    $result = strpos (" " . $a_html[$f], $a_model[$pat],0);
                } else {
                    $result = strpos (" " . strtolower($dat[$f]), $a_model[$pat],0);
                }
    
                if (is_integer($result)) { $pat++; }
            }

            if ($pat == count($a_model)-1) {
                $pat = 0;
                if (count($a_pat)) array_push($a_result, $a_pat);
                $a_pat = array();
            }

        } // end for each tag

        return $a_result;

    } // end function


} // end class

#aici n-am reusit sa iau cu httpget
/***************************Clinici Stomatologice.ro**********************************
function InsertCliniciLinks($link,$type)
{
	global $db;
	$query="Insert into clinicistomatologice_links (link,type) values('".addslashes($link)."','".$type."')";
	$db->query($query);
}
function GetClinicstomLinks()
{
	global $db;
	$info = array();$i=0;
	$query="Select * from clinicistomatologice_links limit 140,170";
	$db->query($query);
	while($db->next_record())
	{
		$info[$i]=$db->f('link');
		$i++;
	}
	return $info;
}


#lets scrape http://www.clinicistomatologice.ro
#first lets get the links for our emails
/*for($i = 1; $i < 3; $i++)
{
$o_sc = new scraper();
//$s_url = "http://www.clinicistomatologice.ro/Cabinete_Stomatologice_Bucuresti-cat/Cabinete_Sector_6/".$i."/";
//$s_url = "http://www.clinicistomatologice.ro/Radiologie_Dentara-cat.html";
//$s_url="http://www.clinicistomatologice.ro/Tehnica_Dentara-cats/pag-".$i."/";
//$s_url = "http://www.clinicistomatologice.ro/Distribuitori_Materiale_Medicale-cats/pag-".$i."/";

$s_user_agent = 'Mozilla/5.0 (X11; U; SunOS sun4u; en-US; rv:1.0.1) Gecko/20020921 Netscape/7.0';
$s_html = $o_sc->browse($s_url, $s_user_agent);

$step1 = explode("http://pagead2.googlesyndication.com/pagead/show_ads.js",$s_html);
$step2 = explode("Subcategorii:",$step1[1]);

$step3 = explode("<a href=\"/",$step2[0]);
array_pop($step3);
array_pop($step3);
array_pop($step3);
foreach($step3 as $ky => $val)
{
	$link =substr($val,0,strpos($val,"\""));
	if(substr($link,0,4)=="Dist")
	{
		echo $link." <br />";
		InsertCliniciLinks($link,"cab_dm");
	}
}
}
#merge doar cu limit can le iau...cam si mai multe de 15

$links = GetClinicstomLinks();
$unique_links = array_unique($links);
$i=1;
foreach($unique_links as $ky => $val)
{
	$o_sc = new scraper();
	$s_url = "http://www.clinicistomatologice.ro/".$val;

	$s_user_agent = 'Mozilla/5.0 (X11; U; SunOS sun4u; en-US; rv:1.0.1) Gecko/20020921 Netscape/7.0';
	$s_html = $o_sc->browse($s_url, $s_user_agent);
	
	$get_email = explode("<b>Email</b>:",$s_html);
	if(isset($get_email[1])&&($get_email[1]!=""))
	{
		
	
	$get_email2 = explode("<td class=txt12px>",$get_email[1]);
	$get_email3 = explode("</td></tr>",$get_email2[1]);
	
	if(substr($val,0,4)=="Cabi")
	{
		storeLink($url="",trim($get_email3[0]),"Bucuresti","cab_st");
	}
		elseif(substr($val,0,4)=="Tehn")
	{
			storeLink($url="",trim($get_email3[0]),$judet="","cab_td");
	}
	elseif(substr($val,0,4)=="Dist")
	{
		storeLink($url="",trim($get_email3[0]),$judet="","cab_dm");
	}
	else
	{
		storeLink($url="",trim($get_email3[0]),$judet="","cab_rad");
	}
	}
}
echo "done";*/




/***************************Dentalsite.ro**********************************
function InsertDentalsiteLinks($link,$type)
{
	global $db;
	$query="Insert into dentalsite_links (link,type) values('".addslashes($link)."','".$type."')";
	$db->query($query);
}
function GetDentalsites()
{
	global $db;
	$info = array();$i=0;
	$query="Select * from dentalsite_links limit 260,300";
	$db->query($query);
	while($db->next_record())
	{
		$info[$i]['link']=$db->f('link');
		$info[$i]['type']=$db->f('type');
		$i++;
	}
	return $info;
	
}
#lets scrape http://www.clinicistomatologice.ro
#first lets get the links for our emails
/*for($i = 1; $i < 4; $i++)
{
$o_sc = new scraper();
//$s_url = "http://dentalsite.ro/page.php?page=cat&cat=stomatologi&pageNo=".$i;
//$s_url = "http://dentalsite.ro/page.php?page=cat&cat=tehnicieni&pageNo=".$i;

$s_url = "http://dentalsite.ro/page.php?page=cat&cat=distribuitori&pageNo=".$i;
$s_user_agent = 'Mozilla/5.0 (X11; U; SunOS sun4u; en-US; rv:1.0.1) Gecko/20020921 Netscape/7.0';
$s_html = $o_sc->browse($s_url, $s_user_agent);

$step1 = explode("page=view&id=",$s_html);
//array_shift($step1);
//array_pop($step1);


foreach($step1 as $ky => $val)
{
	$link = substr($val,0,strpos($val,"\""));
	
	$id=array("301",300,294,299,293,298,292,297,296,295);
	if( !in_array($link,$id))
	{
		echo $link."<br />";
		InsertDentalsiteLinks($link,"cab_dm");
	}
}
}


$get_dentalsite_links = GetDentalsites();
foreach($get_dentalsite_links as $ky => $val)
{
	$o_sc = new scraper();
	$s_url = "http://dentalsite.ro/page.php?page=view&id=".$val['link'];
	$s_user_agent = 'Mozilla/5.0 (X11; U; SunOS sun4u; en-US; rv:1.0.1) Gecko/20020921 Netscape/7.0';
	$s_html = $o_sc->browse($s_url, $s_user_agent);
	
	
	$step1 = explode("Email:",$s_html);
	$step2 =explode("<td width=\"190\"><font class=\"body11\">", $step1[1]);
	$email =substr($step2[1],0,strpos($step2[1],"<")); 
	print_r($email);
	storeLink($url="",$email,$judet="",$val['type']);
	echo "<br />";
}*/


#***************************http://www.stomatologie.3x.ro/**********************************
#doar o pagina in care am doar linkuri
/*$url = "http://www.stomatologie.3x.ro/";
$search_engine="google";
$cookies="";
$a = http_gett($url, $cookies,$search_engine) ;
$step1 = explode("z-index:18",$a);
$step2 = explode("z-index:17",$step1[1]);
$cabst_links = $step2[0];

$dom = new DOMDocument();
@$dom->loadHTML($cabst_links );

// grab all the on the page
$xpath = new DOMXPath($dom);
$hrefs = $xpath->evaluate("/html/body//a");

for ($i = 0; $i < $hrefs->length; $i++)
{
	$href = $hrefs->item($i);
	$url = $href->getAttribute('href');
	if(stristr($url,"www")!==FALSE)
	{
	storeLink($url,"","","cab_st");
	echo "<p>found URL : ".$url."</p>";

	
	}
}
*/

#**************************http://www.timisoaraonline.net/timisoara/anunturi_cabinete_stomatologice_timisoara_online/28,0,0.html
/*function InsertTmLinks($link,$type)
{
	global $db;
	$query="Insert into tm_links (link,type) values('".addslashes($link)."','".$type."')";
	$db->query($query);
}
function GetTmEmails()
{
	global $db;
	$info = array();$i=0;
	$query="Select * from tm_links ";
	$db->query($query);
	while($db->next_record())
	{
		$info[$i]['link']=$db->f('link');
		$info[$i]['type']=$db->f('type');
		$i++;
	}
	return $info;
	
}
*/
#first lets get the links for our emails
/*for($i = 0; $i < 5; $i++)
{
$o_sc = new scraper();
$s_url = "http://www.timisoaraonline.net/timisoara/anunturi_cabinete_stomatologice_timisoara_online/28,".$i.",0.html";
$s_user_agent = 'Mozilla/5.0 (X11; U; SunOS sun4u; en-US; rv:1.0.1) Gecko/20020921 Netscape/7.0';
$s_html = $o_sc->browse($s_url, $s_user_agent);

$step1 = explode("<div class=\"itemoff\">",$s_html);
array_shift($step1);

foreach($step1 as $ky => $val)
{
	$step1 = explode("<a href=\"/",$val);
	$url = substr($step1[1],0,strpos($step1[1],"\""));
	InsertTmLinks($url,"cab_st");
}

}

$get_tm_links = GetTmEmails();
foreach($get_tm_links as $ky => $val)
{
	$o_sc = new scraper();
	$s_url = "http://www.timisoaraonline.net/".$val['link'];
	$s_user_agent = 'Mozilla/5.0 (X11; U; SunOS sun4u; en-US; rv:1.0.1) Gecko/20020921 Netscape/7.0';
	$s_html = $o_sc->browse($s_url, $s_user_agent);
	
	$step1 = explode("<div class=\"itemon\">",$s_html);
	$step2 = explode("<div class=\"itemoff\">",$step1[1]);
	
	$only_item = $step2[0];

	$dom = new DOMDocument();
	@$dom->loadHTML($only_item );

	// grab all the on the page
	$xpath = new DOMXPath($dom);
	$hrefs = $xpath->evaluate("/html/body//a");
	for ($i = 0; $i < $hrefs->length; $i++)
	{
		$href = $hrefs->item($i);
		$url = $href->getAttribute('href');
		if(stristr($url,"http")!==FALSE)
		{
		storeLink($url,"","Timisoara","cab_st");
		echo "<p>found URL : ".$url."</p>";
		}
		
		if(stristr($url,"mailto:")!==FALSE)
		{
			$email = substr($url,7);
			storeLink("",$email,"Timisoara","cab_st");
			echo "<p>email found : ".$email."</p>";
		}
	}
	
	
}*/

#**************************http://www.ghidul.ro/rezultat.php?idd=3713** scarpat 2008*******************

#from here we take directly emails
/*for($i = 9; $i <14; $i++)
{
$o_sc = new scraper();
$s_url ="http://www.ghidul.ro/rezultat.php?idd=3713&items=30&page=".$i;
//$s_url ="http://www.ghidul.ro/rezultat.php?idd=3711";
//$s_url ="http://www.ghidul.ro/rezultat.php?idd=3849&items=30&page=".$i;
//$s_url ="http://www.ghidul.ro/rezultat.php?idd=3850&items=30&page=".$i;
//$s_url ="http://www.ghidul.ro/rezultat.php?idd=3290&items=30&page=2";
$s_user_agent = 'Mozilla/5.0 (X11; U; SunOS sun4u; en-US; rv:1.0.1) Gecko/20020921 Netscape/7.0';
$s_html = $o_sc->browse($s_url, $s_user_agent);

$step1 = explode("class='firma_titlu'",$s_html);
array_shift($step1);

foreach($step1 as $ky => $val)
{
	$step1 = explode("mailto:",$val);
	if(isset($step1[1])&&($step1[1]!=""))
	{
		$email = substr($step1[1],0,strpos($step1[1],"\""));
		echo "email:".$email."<br />";
		storeLink(addslashes($email),"cab_rad");
	}
	
}

}



/*************************************Doctor bun site e bun si pt adrese directe!!!*****************
function InsertDoctorBun($url)
{
	global $db;
	$query="Insert into doctor_bun (url) values('".addslashes($url)."')";
	$db->query($query);

}
function GetDoctorBunLinks($start,$end)
{
	global $db;
	$info = array();$i=0;
	$query="Select * from doctor_bun LIMIT  610,70";
	$db->query($query);
	//echo $query."<br />";
	//print_r($db->affected_rows());exit;
	while($db->next_record())
	{
		$info[$i] = $db->f('url');
		$i++;
	}
	return $info;
}
function InsertDoctorBunEmails($email)
{
	global $db;
	$query="Insert into doctor_bun_emails (emails) values('".trim(addslashes($email))."')";
	$db->query($query);
}
#$url = "http://www.doctorbun.ro/doctori.php?LiteraHtml=&cautareJudet=&cautareSpecialitate=47&pagina=1";
$search_engine="google";$cookies="";
#we have 24 pages whit 30 stomatologi on a line
#here we take the links whith doctors
/*$k=0;
$url = "http://www.doctorbun.ro/doctori.php?LiteraHtml=&cautareJudet=&cautareSpecialitate=47&pagina=24";
$a = http_gett($url, $cookies,$search_engine) ;

	$dom = new DOMDocument();
	@$dom->loadHTML($a);

	// grab all the on the page
	$xpath = new DOMXPath($dom);
	$hrefs = $xpath->evaluate("/html/body//a");
	for ($j = 0; $j < $hrefs->length; $j++)
	{
		$href = $hrefs->item($j);
		$url = $href->getAttribute('href');
		if((stristr($url,"doctori.php?doctor")!==FALSE)&&(stristr($url,"act=1")!==FALSE))
		{
			InsertDoctorBun($url);
			echo "<p>found URL : ".$url."</p>";
			 $k++;
		}
	}
	echo "<br />mmmmmmmmmmmmmmmmmmmmmmmmm:".$k;

	#step 2 ...we take their emails:D
	$i=0;
	$doctor_links = GetDoctorBunLinks(280,300);
	
	foreach($doctor_links as $ky => $val)
	{
		
		$url="http://www.doctorbun.ro/".$val;
		echo ($url);

		$a = http_gett($url, $cookies,$search_engine) ;
		if(strpos($a,"Website:")!=FALSE)
		{
			$get_email = explode("mail:",$a);
			$email = substr($get_email[1],0,strpos($get_email[1],"<"));
			InsertDoctorBunEmails($email);
		}
		elseif(strpos($a,"E-mail:")!=FALSE)
		{
			$get_email = explode("E-mail:",$a);
			$get_email1 = explode("<td>",$get_email[1]);
			$get_email2 = $get_email1[1];
			$email = substr($get_email2,0,strpos($get_email2,"<"));
			InsertDoctorBunEmails($email);
		}
		$i++;
		echo $email."<br />";
	}
echo "linkuriiiiiiiiiiiiiiiiiiiiiiii:".$i;*/
/************************8cabinete stomatologice sibiu*******************
$url = "http://www.sibiu.ro/directory/listing.php?cat=121";
$search_engine = "google";
$a = http_gett($url, $cookies,$search_engine) ;


	$dom = new DOMDocument();
	@$dom->loadHTML($a);
	$get_email = explode("mailto:",$a);
	foreach($get_email as $ky => $val)
	{
		$addres_mail = substr($val,0,strpos($val,"\""));
		echo "emails: ".$addres_mail."<br />";
		storeLink($addres_mail,"cab_td");
	}

	//	echo "emails: ".$addres_mail."<br />";
		//storeLink($addres_mail,"cab_td");


/************************************emailuri unice******************************/
function GetAllEmails()
{
	global $db;
	$info = array();$i=0;
	$query="Select * from new_emails ";
	$db->query($query);
	while($db->next_record())
	{
		$info[$i] = $db->f('email');
		$i++;
	}
	return $info;
	
}
function InsertUnique($email,$type)
{
	global $db;
	$query="Insert into unique_emails (email,type) values('".addslashes($email)."','".$type."')";
	$db->query($query);
}
function CheckEmailUnique($email)
{
	global $db;
	$query="Select * from unique_emails where email='".addslashes($email)."' ";
	$db->query($query);

	if($db->affected_rows()<1)
	{
		return "YES";
	}
	else
	{
		return "NO";
	}
}

/*$all_emails = GetAllEmails();
foreach($all_emails as $ky => $val)
{
	echo "un email:".$val."<br />";
	$check_email = CheckEmailUnique($val);
	if($check_email=="YES")
	{
		echo "unique: ".$val."<br />";
		$insert_unique = InsertUnique($val,"cab_st");
	}
}*/
###################http://www.medici-online.ro/categ14.php?jud=Bacau,Brasov,Iasi##############
/*$url = "http://www.medici-online.ro/categ14.php?jud=Iasi";
$a = http_gett($url, $cookies,$search_engine) ;
$search_engine="google";
/*$url = explode("medici.php?jud=Iasi",$a);
	print_r($url);
	$nr_urls = count($url);
for($i = 1; $i <= $nr_urls; $i++)
{
	$new_url = substr($url[$i],0,strpos($url[$i],"\""));
	$newurl = "jud=Iasi".$new_url;
	echo $newurl."<br />";
	storeLink($newurl,"cab_st");

}
$urls = GetAllEmails();
foreach($urls as $ky => $val)
{
	
	$url = "http://www.medici-online.ro/medici.php?".$val;
	$a = http_gett($url, $cookies,$search_engine) ;	

}*/
/*********************** Luat pe litere pe fiecare judet**************************
$search_engine = "google";
$letters = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'V', 'W', 'Z');
$cookies="";
foreach($letters as $ky => $val)
{
	$letter = $val;
	for($i = 0; $i < 6; $i++)
	{ 
		$url ="http://www.pa.ro/results/result.php3?judet=25&book_type=1&include_all=Y&pa_domeniu2=cabinete%20stomatologice&dom_id=17800&pa_domeniu=CABINETE%20STOMATOLOGICE&numef=".$letter."&begcont=begins&isqs=1&nrrez=15&srtby=&pcount=".$i;
		
		$somecontent = http_gett($url, $cookies,$search_engine);
		$filename = "c:/iasi/fis_".$letter."_".$i.".html";
		$handle = fopen($filename , "w");
		 if (fwrite($handle, $somecontent) === FALSE) {
        echo "Cannot write to file ($filename)";
        exit;
    }
		fclose($handle);
	}
}

/*********************** luat primele 7 apgini*****************
$search_engine = "google";

$cookies="";
	for($i = 0; $i < 8; $i++)
	{ 
		$url ="http://www.pa.ro/results/result.php3?book_type=1&include_all=Y&dom_id=113200&pa_domeniu=STOMATOLOGIE%20-%20RADIOLOGIE&nrrez=15&srtby=&pcount=".$i;
		
		$somecontent = http_gett($url, $cookies,$search_engine);
		$filename = "c:/radiologie/fis_".$i.".html";
		$handle = fopen($filename , "w");
		 if (fwrite($handle, $somecontent) === FALSE) {
        echo "Cannot write to file ($filename)";
        exit;
    }
		fclose($handle);
	}
***********/
/******************88aici am luat din pagini aurii de pe localhost din foldere**********************/
/*$judete=array("Teleoramn","timis","Tulcea","valcea","Vaslui","suceava","Vrancea");
foreach($judete as $ky => $vall)
{

	$judet = $vall;
	echo "<br />sssssssssssssssss:".$judet."<br />";

if ($handle = opendir('d://stomatologi/'.$judet)) 
	{
    echo "Directory handle: $handle\n";
    echo "Files:\n";$i=0;
    /* This is the correct way to loop over the directory.
    while (false !== ($file = readdir($handle))) 
		{
						echo "$file\n";
						$file_handle = file_get_contents('d://stomatologi/'.$judet.'/'.$file);
						if(stristr($file_handle,'mailto:'))
						{
							$get_emails = explode('mailto:',$file_handle);
							foreach($get_emails as $ky => $val)
							{
								$email=substr($val,0,strpos($val,"\""));
								if(!stristr($email,"contact@paginiaurii.ro?")&&(!stristr($email,"HTTP/1.1 200")))
								{
									echo $email."<br />";
									$i++;
									$type="cab_st";
									$query = "Insert into pagini_aurii (email,judet,type)values('".addslashes($email)."','".$judet."','".$type."')";
									$db->query($query);
								}
								
							}

						}
		   }
	echo "<br />numar emails".$i;
      closedir($handle);
}
	
} */


?>