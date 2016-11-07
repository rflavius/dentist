<?php 
/**
 * WebDesignRR Application
 * developer: Flavius Rosu
 * email: rflavius@gmail.com
 * @copyright  Copyright (c) 2003-2015
 */

/**
 * here is the scrapper module
 * @category   Dentist
 * @package    DentistLibrary
 */

class Dentist_Scrapper
{
	/*
	 * the construct method here we initialize the DB and conf objects
	* @access public
	* @param none
	* @return void
	*/
	public function __construct()
	{
		$this->db = Zend_Registry::get('database');
		$this->conf = Zend_Registry::get('settings');
	}
	
	/**
	 * this is the main process
	 * @access public
	 * @param none
	 * @return void
	 */
	public function run()
	{
		$page = $this->getPageToScrap();
		if(!empty($page))
		{
			$this->scrap($page);
		}
		else echo 'we have finished them all ! :D';
	}
	
	/**
	 * here we srapp the intermediary page
	 * @access public
	 * @param string $url
	 * @return void
	 */
	public function buildPagesToScrap($url)
	{
		echo $url."<br>";
		$xml = simplexml_load_file($url);
		foreach ($xml->url as $key => $value)
		{
			$this->storePage($value->loc);
		}
		echo 'done';exit;
		
		$content = $this->curl_simple($url);
		
		
		
		$content = $this->scrapeBetween($content, '<ul>', '</ul>');
		if(!empty($content))
		{
			$dom = new DOMDocument;
			$dom->loadHTML($content);
			foreach ($dom->getElementsByTagName('a') as $node)
			{
				$link = $node->getAttribute('href');
				if(stristr($link,'m=29')!==false) $this->storePage('http://www.sfatuldentistului.ro'.$link);
			}
			echo 'done<br>';
		}
		/*
		echo $content;exit;
		
		$dom = new DOMDocument;
		$dom->loadHTML($content);
		foreach ($dom->getElementsByTagName('a') as $node)
		{
			$link = $node->getAttribute('href');
			if(stristr($link,'cabinete-stomatologice')!==false) $this->storePage('http://www.util21.ro/sanatate/'.$link);
		}
		echo 'done';exit;
		
		foreach ($pages as $key => $value)
		{
			$dom->loadHTML($value);
			foreach ($dom->getElementsByTagName('a') as $node)
			{
				$link = $node->getAttribute('href');
				if($link!=$url) $this->storePage($link);
			}
			$i++;
		}
		echo 'done';*/
	}
	
	/**
	 * here we store the page we need to scrap
	 * @access public
	 * @param string $link
	 * @return void
	 */
	public function storePage($link)
	{
		if($this->uniquePage($link))
		{
			$this->db->insert('scrapper_pages', array('page' => $link));
		}
	}
	
	/**
	 * check if page to scrap is unique
	 * @access public
	 * @param string $link
	 * @return boolean
	 */
	public function uniquePage($link)
	{
		$select = $this->db->select()
							->from('scrapper_pages')
							->where('page = ?', $link);
		$results = $this->db->fetchAll($select);
		if(count($results)>0) return false;
		else return true;
	}
	
	/**
	 * here we get the page to scrap
	 * @access public
	 * @param none
	 * @return array
	 */
	public function getPageToScrap()
	{
		$select = $this->db->select()
							->from('scrapper_pages')
							->where('done = ?', 'N')
							->order('id asc')
							->limit(1);
		return $this->db->fetchRow($select);
	}
	
	/**
	 * here is the scrapping process
	 * @access public
	 * @param array $page
	 * @return void
	 */
	public function scrap($page)
	{
		//echo "<p>URL => ".$page['page']."</p>****************<br>";
		$content = $this->curl_simple($page['page']);
		if(!empty($content)) $this->prepareData($content, $page['page']);
		
		$data = array('done' => 'Y');
		$where = array('id = ?' => $page['id']);
		$this->pageDone($data, $where);
	}
	
	/**
	 * here we prepare data from content to be ready for store
	 * @access public
	 * @param string $data
	 * @return void
	 */
	public function prepareData($data, $website)
	{
		// get each listing
		$info = '';
		$i=0;
		
		if(stristr($website,'util21.ro')!==false)
		{
			// get email
			$i=1;
			$dom = new DOMDocument;
			$boxes = explode( "casuta_nume_evidentiat_inregistrare", $data);
			for ($i = 1; $i <= count($boxes); $i++)
			{
				$info[$i]['name'] = $this->scrapeBetween($boxes[$i], '<b>', ',');
				$info[$i]['address'] = '';
				$info[$i]['phone'] = '';
				$judet = str_replace('http://www.util21.ro/sanatate/cabinete-stomatologice-','',$website);
				$judet = str_replace('.htm','',$judet);
				$info[$i]['judet'] = $judet;
				$info[$i]['email'] = $this->scrapeBetween($boxes[$i], 'mailto:', '"');
			}
		}
		elseif(stristr($website,'catalogulsanatatii.ro')!==false)
		{
			$judet_id = explode("loc=",$website);
			$judet_id = $judet_id[1];
			$judete = array('BV','B','IS','BC','TM','CJ','BT','MS','CT','BR');
			$judet = $judete[$judet_id-1];
			$boxes = explode('<p style="font-weight:bold; margin:0px;padding:0px;">',$data);
			$i=0;
			foreach ($boxes as $key => $value)
			{
				if(!empty($value))
				{
					$info[$i]['name'] = $this->scrapeBetween($value, '.', '</p>');
					$info[$i]['address'] = '';
					$info[$i]['phone'] = '';
					$info[$i]['judet'] = $judet;
					if(stristr($value,'Email:')!==false) $info[$i]['email'] = $this->scrapeBetween($value, 'Email:', '<br>');
					else  $info[$i]['email'] = $this->scrapeBetween($value, 'E-mail:', '<br>');
					$i++;
				}
			}
		}
		elseif(stristr($website, 'sfatuldentistului.ro')!==false)
		{
			$i=0;
			$info[$i]['name'] = trim($this->scrapeBetween($data, 'font-weight:bold; font-size:18px; float:left">', '</div>'));
			$info[$i]['address'] = '';
			$info[$i]['phone'] = '';
			$info[$i]['judet'] = trim(strip_tags($this->scrapeBetween($data, 'Judet', '</tr>')));
			$info[$i]['email'] = trim(strip_tags($this->scrapeBetween($data, 'Email cabinet', '</tr>')));
			if($info[$i]['email']=='nespecificat') $info[$i]['email'] = "";
		}
		elseif(stristr($website, 'dentistul.info')!==false)
		{
			$dom = new DOMDocument;
			$dom->loadHTML($data);
			$i=0;
			$info[$i]['name'] = trim($this->scrapeBetween($data, '<h1 itemprop="name">', '</h1>'));
			$info[$i]['address'] = trim(strip_tags($this->scrapeBetween($data, '<span itemprop="streetAddress">', '</span>')));
			$info[$i]['phone'] = '';
			$info[$i]['judet'] = '';
			
			foreach ($dom->getElementsByTagName('input') as $node)
			{
				$name =  $node->getAttribute('name');
				if(!empty($name) && $name=='author_email')
				{
					$info[$i]['email'] = $node->getAttribute('value');
				}
			}
		}
		else
		{
			// get email address
			/*
			 $dom = new DOMDocument;
			 $dom->loadHTML($data);
			 //echo $data;exit;
			 foreach ($dom->getElementsByTagName('a') as $node)
			 {
			 $email = $node->getAttribute('href');
			 echo $email."<br>";
			 if(stristr($email,'mailto:')!==false)
			 {
			 $info[$i]['email'] = str_replace('mailto:','',$email);
			 }
			 }*/
			
			$html = strip_tags($data);
			$s = explode("var addy", $html);
			$string = $s[1];
			if(!empty($string))
			{
			// get the JS var name
			$var_id = trim(substr($string,0,strpos($string,'=')));
			$var_name = "addy".$var_id;
				
									// remove the JS var name and var ID
									$string = str_replace($var_name,"",$string);
									$string = str_replace($var_id,"",$string);
									// clean the unwanted characters
									$str = str_replace(array("=","'","+"), "", $string);
															//remove empty spaces
															$str = preg_replace('/\s+/', '', $str);
															// decode the chars and then replace the rest of the ; char
															$str = html_entity_decode($str);
															$str = str_replace(array(";"), "", $str);
															$info[$i]['email'] = trim($str);
			}
			else $info[$i]['email'] = '';
			
			$info[$i]['phone'] = $this->scrapeBetween($data, '<span itemprop="telephone">', '</span>');
			$info[$i]['name'] = str_ireplace('date de contact:','',$this->scrapeBetween($data, '<h2>', '</h2>'));
			$info[$i]['address'] = strip_tags($this->scrapeBetween($data, '<strong>Adresa: </strong>', '<iframe'));
			$info[$i]['judet'] = 'CJ';
			
			//print_r($info);exit;
			/*
			 $list = explode('itemListElement', $data);
			
			 if(count($list)>0)
			 {
			 foreach ($list as $key => $value)
			 {
			 $info[$i]['name'] = iconv('UTF-8', 'ASCII//TRANSLIT', $this->scrapeBetween($value, '<span itemprop="name">', '</span>'));
			 $info[$i]['address'] = trim(strip_tags($this->scrapeBetween($value, '<span itemprop="streetAddress">', '</address>')));
			 $info[$i]['email'] = $this->scrapeBetween($value, '<span itemprop="telephone">', '</span>');
			
			 $i++;
			 }
			 }*/
		}
		
		
		
		
		
		// now store the info if we have any
		if(is_array($info))
		{
			foreach ($info as $key => $value)
			{
				if(!empty($value['email']))
				{
					$data = $value;
					//print_r($data);exit;
					$this->storeData($data);
				}
			}
		}
	}
	
	/**
	 * update page done after scrap
	 * @access public
	 * @param array $data
	 * @param array $where
	 * @return void
	 */
	public function pageDone($data, $where)
	{
		$this->db->update('scrapper_pages', $data, $where);
	}
	
	/**
	 * store scraped data into db
	 * @access public
	 * @param array $data
	 * @return void
	 */
	public function storeData($data)
	{
		if($this->uniqueData($data))
		{
			$this->db->insert('scrapper', $data);
		}
	}
	
	/**
	 * check to see if we already have this record
	 * @access public
	 * @param array $data
	 * @return boolean
	 */
	public function uniqueData($data)
	{
		$select = $this->db->select()
							->from('scrapper')
							->where('name = ?', $data['name'])
							->where('phone = ?', $data['phone']);
		$results = $this->db->fetchAll($select);
		if(count($results)>0) return false;
		else return true;
	}
	
	/**
	 * make the connection to the URL page
	 * @access public
	 * @param string $url
	 * @return string
	 */
	public function curl($url)
	{
		$userAgent = 'Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.9.1a2pre) Gecko/2008073000 Shredder/3.0a2pre ThunderBrowse/3.2.1.8';
		//echo $userAgent;exit;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_FAILONERROR, true);
		@curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_AUTOREFERER, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 60);
		$html= curl_exec($ch);
		return $this->scrapeBetween($html, 'midCol', 'rightcolumn');
	}
	
	public function curl_simple($url)
	{
		$userAgent = 'Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.9.1a2pre) Gecko/2008073000 Shredder/3.0a2pre ThunderBrowse/3.2.1.8';
		//echo $userAgent;exit;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_FAILONERROR, true);
		@curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_AUTOREFERER, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 60);
		$html= curl_exec($ch);
		return $html;
	}
	
	/**
	 * get string between certain keywords, tags, etc
	 * @access public
	 * @param string $data
	 * @param string $start
	 * @param string $end
	 * @return string
	 */
	public function scrapeBetween($data, $start, $end)
	{
		$data = stristr($data, $start); // Stripping all data from before $start
		$data = substr($data, strlen($start));  // Stripping $start
		$stop = stripos($data, $end);   // Getting the position of the $end of the data to scrape
		$data = substr($data, 0, $stop);    // Stripping all data from after and including the $end of the data to scrape
		return $data;   // Returning the scraped data from the function
	}
}