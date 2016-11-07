<?php
/*------------------------------------------------------------------------------------------------
	|		dotBoost Self Managed Content | SMC Users Framework | support@dotboost.com
	+---------------------------------------------------------------------------
	|		SMC Users Framework IS NOT FREE SOFTWARE!
	+---------------------------------------------------------------------------
	|		Name : classes/api/rss.php
	|		Date started: Aug 3 2006
	|		Description : rss class
	|		Version : 0.9
	+---------------------------------------------------------------------------------------------*/
class class_rss
{
	var $ipsclass;
	var $class_file_management;
	var $doc_type = 'ISO-8859-2';
	var $errors = array();
	var $use_sockets   = 0;
	var $in_item       = 0;
	var $in_image	   = 0;
	var $in_channel    = 0;
	var $rss_count     = 0;
	var $rss_max_show  = 99999;
	var $cur_item      = 0;
	var $cur_channel   = 0;
	var $set_ttl        = 60;
	var $tag           = "";
	var $rss_items     = array();
	var $rss_headers   = array();
	var $rss_images    = array();
	var $rss_tag_names = array();
	var $rss_title;
	var $rss_description;
	var $rss_chan_title;
	var $rss_chan_desc;
	var $rss_chan_date;
	var $rss_chan_lang;
	var $channels       = array();
	var $items          = array();
	var $channel_images = array();
	#Constructor
	function class_rss()
	{
		$this->rss_tag_names = array('RSS' => 'RSS',
																 'CHANNEL' => 'CHANNEL',
																 'TITLE' => 'TITLE',
																 'LINK' => 'LINK',
																 'DESCRIPTION' => 'DESCRIPTION',
																 'PUBDATE' => 'PUBDATE',
																 'WEBMASTER' => 'WEBMASTER',
																 'TTL' => 'TTL',
																 'ITEM' => 'ITEM',
																 'TITLE' => 'TITLE',
																 'DESCRIPTION' => 'DESCRIPTION'
			);
	}
	#Create RSS 2.0 document
	function rss_create_document()
	{
		if (! count($this->channels))
		{
			$this->errors[] = "No channels defined";
		}
		$this->rss_document  = '<?xml version="1.0" encoding="'.$this->doc_type.'"?'.'>'."\n";
		$this->rss_document .= '<rss version="2.0" xmlns:dc="http://purl.org/dc/elements/1.1/">'."\n";
		#Add channels
		foreach($this->channels as $idx => $channel)
		{
			$tmp_data = "";
			$had_ttl  = 0;
			#Add channel data
			foreach($channel as $tag => $data)
			{
				if (strtolower($tag) == 'ttl')
				{
					$had_ttl = 1;
				}
						#nedded tab | for the form
				$tmp_data .= "\t	<" . $tag . ">" .$data. "</" . $tag . ">\n";
			}
			#Added TTL?
			if (!$had_ttl)
			{
						#nedded tab | for the form
				$tmp_data .= "\t	<ttl>" . intval($this->set_ttl) . "</ttl>\n";
			}
			#Got image?
			if (@is_array($this->channel_images[$idx]) and @count($this->channel_images[$idx]))
			{
				foreach($this->channel_images[$idx] as $i => $image)
				{
					$tmp_data .= "\t	<image>\n";
					
					foreach($image as $tag => $data)
					{
						$tmp_data .= "\t\t	<" . $tag . ">" .$data. "</" . $tag . ">\n";
					}
					$tmp_data .= "\t	</image>\n";
				}
			}
			#Add item data
			if (@is_array($this->items[$idx]) and count($this->items[$idx]))
			{
				foreach($this->items[$idx] as $i => $item)
				{
							#nedded tab | for the form
					$tmp_data .= "\t	<item>\n";
					foreach($item as $tag => $data)
					{
						$extra = "";
						if ($tag == 'guid' AND ! strstr($data, 'http://'))
						{
							$extra = ' isPermaLink="false"';
						}
									#nedded tab | for the form
						$tmp_data .= "\t\t	<" . $tag . $extra . ">" .$data. "</" . $tag . ">\n";
					}
					$tmp_data .= "\t	</item>\n";
				}
			}
			#Compute
			$this->rss_document .= "	<channel>\n";
			$this->rss_document .= $tmp_data;
			$this->rss_document .= "	</channel>\n";
		}
		$this->rss_document .= "</rss>";
	}
	#Add Channel
	function create_add_channel($in=array())
	{
		$this->channels[$this->cur_channel] = $in;
		#Increment and return
		$return = $this->cur_channel;
		$this->cur_channel++;
		return $return;
	}
	#Add channel image item
	function create_add_image($channel_id=0, $in=array())
	{
		$this->channel_images[$channel_id][] = $in;
	}
	#Add item
	function create_add_item($channel_id=0, $in=array())
	{
		$this->items[$channel_id][] = $in;
	}
	#Format image
	function rss_format_image($in=array())
	{
		if (!$in['url'])
		{
			$this->errors[] = "Cannot format image, not enough input";
		}
		$title  = "";
		$alt    = "";
		$width  = "";
		$height = "";
		if ($in['description'])
		{
			$title = " title='".$this->_xml_encode_attribute($in['description'])."' ";
		}
		if ($in['title'])
		{
			$alt = " alt='".$this->_xml_encode_attribute($in['title'])."' ";
		}
		if ($in['width'])
		{
			if ($in['width'] > 144)
			{
				$in['width'] = 144;
			}
			
			$width = " width='".$this->_xml_encode_attribute($in['width'])."' ";
		}
		if ($in['height'])
		{
			if ($in['height'] > 400)
			{
				$in['height'] = 400;
			}
			$height = " height='".$this->_xml_encode_attribute($in['height'])."' ";
		}
		$img = "<img src='".$in['url']."' $title $alt $width $height />";
		if ($in['link'])
		{
			$img = "<a href='".$in['link']."'>".$img."</a>";
		}
		return $img;
	}
	#Parse Feed (FROM URL)
	function rss_parse_feed_from_url($feed_location)
	{
		#Create file management object from file management class
		$this->class_file_management = new class_file_management();
		$this->class_file_management->use_sockets = $this->use_sockets;
		$this->rss_items = array();
		$this->rss_channels = array();
		#Generate XML parser
		$xml_parser = xml_parser_create();
		xml_set_element_handler($xml_parser, array(&$this, "parse_startElement"), array(&$this, "parse_endElement"));
		xml_set_character_data_handler($xml_parser, array(&$this, "parse_characterData"));
		#Get data
		$data = $this->class_file_management->get_file_contents($feed_location);
		#if the provider of the xml provided an xml without the header
		$if_xml_header = strpos($data, '?xml');
		if ($if_xml_header == '')
		{
			$data = '<?xml version="1.0" encoding="iso-8859-1"?'.'>'.$data;
		}
		#REMINDER - If encoding != "iso-8859-1" eg.: = "UTF-8" it doesn't work
		#with this encoder works
		$if_xml_encoder = strpos($data, 'encoding="iso-8859-1"');
		if ($if_xml_encoder == '')
		{
			#find position of first string
			$pos = strpos($data, 'encoding="');
			#find start of the beginig of the %
			$start = $pos + strlen('encoding="');
			#find the end of the beginig of the %
			$end = strpos($data, '"', $start);
			#calculate the lenght betwen the quotes
			$num = ($end - $start);
			#get the form of the string that is going to be replaced
			$new_encoding = substr($data, $start, $num);
			$data = str_replace($new_encoding, 'iso-8859-1', $data);
		}
		if (count($this->class_file_management->errors))
		{
			$this->errors = $this->class_file_management->errors;
			return FALSE;
		}
		#Parse data
		if (! xml_parse($xml_parser, $data))
		{
			$this->errors[] = sprintf("XML error: %s at line %d",  xml_error_string(xml_get_error_code($xml_parser)), xml_get_current_line_number($xml_parser));
		}
		#Free memory used by XML parser
		xml_parser_free($xml_parser);
	}
	#Parse Feed (FROM FILE)
	function rss_parse_feed_from_file($feed_location)
	{
		#Same as parse from url
		$this->rss_parse_feed_from_url($feed_location);
	}
	#Parse Feed (FROM DATA)
	function rss_parse_feed_from_data($data)
	{
		$this->rss_items    = array();
		$this->rss_channels = array();
		#Generate XML parser
		$xml_parser = xml_parser_create();
		xml_set_element_handler($xml_parser, array(&$this, "parse_startElement"), array(&$this, "parse_endElement"));
		xml_set_character_data_handler($xml_parser, array(&$this, "parse_characterData"));
		if (!xml_parse($xml_parser, $data, TRUE))
		{
			$this->errors[] = sprintf("XML error: %s at line %d",  xml_error_string(xml_get_error_code($xml_parser)), xml_get_current_line_number($xml_parser));
		}
		#Free memory used by XML parser
		xml_parser_free($xml_parser);
	}
	#START ELEMENT
	function parse_startElement($parser, $name, $attrs)
	{
		$name = strtoupper($name);
		if ($this->in_item)
		{
			$this->in_item++;
			$this->tag = @$this->rss_tag_names[$name];
		}
		if ($this->in_image)
		{
			$this->in_image++;
			$this->tag = $this->rss_tag_names[$name];
		}
		if ($this->in_channel)
		{
			$this->in_channel++;
			$this->tag = @$this->rss_tag_names[$name];
		}
		if (@$this->rss_tag_names[$name] == "ITEM")
		{
			$this->in_item = 1;
		} 
		else if (@$this->rss_tag_names[$name] == "IMAGE")
		{
			$this->in_image = 1;
		}
		else if (@$this->rss_tag_names[$name] == "CHANNEL")
		{
			$this->in_channel = 1;
		}
	}
	#END ELEMENT
	function parse_endElement($parser, $name)
	{
		$name = strtoupper($name);
		if (@$this->rss_tag_names[$name] == "IMAGE")
		{
			$this->rss_images[$this->cur_channel]['url']         = $this->rss_img_image;
			$this->rss_images[$this->cur_channel]['title']       = $this->rss_img_title;
			$this->rss_images[$this->cur_channel]['link']        = $this->rss_img_link;
			$this->rss_images[$this->cur_channel]['width']       = $this->rss_img_width;
			$this->rss_images[$this->cur_channel]['height']      = $this->rss_img_height;
			$this->rss_images[$this->cur_channel]['description'] = $this->rss_img_desc;
			$this->_kill_image_elements();
			$this->in_image = 0;
		}
		else if (@$this->rss_tag_names[$name] == "CHANNEL")
		{
			#Add data
			$this->rss_channels[$this->cur_channel]['title']       = $this->_format_string($this->rss_chan_title);
			$this->rss_channels[$this->cur_channel]['description'] = $this->_format_string($this->rss_chan_desc);
			$this->rss_channels[$this->cur_channel]['unixdate']    = @strtotime($this->_format_string($this->rss_chan_date));
			#Increment item
			$this->cur_channel++;
			#Clean up
			$this->_kill_channel_elements();
			$this->in_channel = 0;
		}
		else if (@$this->rss_tag_names[$name] == "ITEM")
		{
			if ($this->rss_count < $this->rss_max_show)
			{
				$this->rss_count++;
				if ($this->cur_channel > 0 AND (! @is_array($this->rss_items[$this->cur_channel])))
				{
					$this->cur_channel--;
				}
				$this->rss_items[$this->cur_channel][$this->cur_item]['title'] = $this->rss_title;
				$this->rss_items[$this->cur_channel][$this->cur_item]['description'] = $this->rss_description;
				#Increment item
				$this->cur_item++;
				#Clean up
				$this->_kill_elements();
				$this->in_item = 0;
			}
			else if ($this->rss_count >= $this->rss_max_show)
			{
				#Clean up
				$this->_kill_elements();
				$this->in_item = 0;
			}
		}
		if ($this->in_channel)
		{
			$this->in_channel--;
		}
		if ($this->in_item)
		{
			$this->in_item--;
		}
		if ($this->in_image)
		{
			$this->in_image--;
		}
	}
	#Character data
	function parse_characterData($parser, $data)
	{
		if ($this->in_image == 2)
		{
			switch ($this->tag)
			{
				case "URL":
					$this->rss_img_image .= $data;
					break;
				case "TITLE":
					$this->rss_img_title .= $data;
					break;
				case "LINK":
					$this->rss_img_link .= $data;
					break;
				case "WIDTH":
					$this->rss_img_width .= $data;
					break;
				case "HEIGHT":
					$this->rss_img_height .= $data;
					break;
				case "DESCRIPTION":
					$this->rss_img_desc .= $data;
					break;
			}
		}
		
		if ($this->in_item == 2)
		{
			switch ($this->tag)
			{
				case "TITLE":
					$this->rss_title .= $data;
					break;
				case "DESCRIPTION":
					$this->rss_description .= $data;
					break;
			}
		}
		
		if ($this->in_channel == 2)
		{
			switch ($this->tag)
			{
				case "TITLE":
					$this->rss_chan_title .= $data;
					break;
				case "DESCRIPTION":
					$this->rss_chan_desc .= $data;
					break;
				case "DATE":
					$this->rss_chan_date .= $data;
					break;
				case "LANGUAGE":
					$this->rss_chan_lang .= $data;
					break;
			}
		}
	}
	#INTERNAL : Encodes an attribute string
	function _xml_encode_attribute($t)
	{
		$t = preg_replace("/&(?!#[0-9]+;)/s", '&amp;', $t);
		$t = str_replace("<", "&lt;"  , $t);
		$t = str_replace(">", "&gt;"  , $t);
		$t = str_replace('"', "&quot;", $t);
		$t = str_replace("'", '&#039;', $t);
		return $t;
	}
	#INTERNAL: Encodes an attribute string
	function _xml_decode_attribute($t)
	{
		$t = str_replace("&amp;" , "&", $t);
		$t = str_replace("&lt;"  , "<", $t);
		$t = str_replace("&gt;"  , ">", $t);
		$t = str_replace("&quot;", '"', $t);
		$t = str_replace("&#039;", "'", $t);
		return $t;
	}
	#INTERNAL: Ensures no embedding of cdata
	function _xml_convert_safecdata($v)
	{
		$v = str_replace("![CDATA[", "!¢|CDATA|", $v);
		$v = str_replace("]]"      , "|¢]"      , $v);
		return $v;
	}
	#INTERNAL: Uncoverts safe embedding
	function _xml_unconvert_safecdata($v)
	{
		$v = str_replace("!¢|CDATA|", "![CDATA[", $v);
		$v = str_replace("|¢]"      , "]]"      , $v);
		return $v;
	}
	#Format text string
	function _format_string($t)
	{
		return trim($t);
	}
	#Kill work elements
	function _kill_elements()
	{
		$this->rss_title       = "";
		$this->rss_description     = "";
	}
	#Kill img elements
	function _kill_image_elements()
	{
		$this->rss_img_image  = "";
		$this->rss_img_title  = "";
		$this->rss_img_link   = "";
		$this->rss_img_width  = "";
		$this->rss_img_height = "";
		$this->rss_img_desc   = "";
	}
	#Kill channel elements
	function _kill_channel_elements()
	{
		$this->rss_chan_title = "";
		$this->rss_chan_link  = "";
		$this->rss_chan_desc  = "";
		$this->rss_chan_date  = "";
	}
}
#CLASS used when importing info
class class_file_management
{
	var $use_sockets = 0;
	var $errors      = array();
	#Constructor
	function class_file_management(){}
	#Get file contents (accepts URL or path)
	function get_file_contents($file_location)
	{
		$contents = "";
		$file_location = str_replace('&amp;', '&', $file_location);
		if (!$file_location)
		{
			return FALSE;
		}
		if (!stristr($file_location, 'http://'))
		{
			if (!file_exists($file_location))
			{
				$this->errors[] = "File '$file_location' does not exist, please check the template link settings.";
				return;
			}
			$contents = $this->get_contents_with_fopen($file_location);
		}
		else
		{
			if ($this->use_sockets)
			{
				$contents = $this->get_contents_with_socket($file_location);
			}
			else
			{
				$contents = $this->get_contents_with_fopen($file_location);
			}
		}
		return $contents;
	}
	#USE FOPEN TO GET TEXT
	function get_contents_with_fopen($file_location)
	{
		set_time_limit(0);
		$buffer = "";
		@clearstatcache();
		if ($FILE = @fopen($file_location, "r"))
		{
			while (! feof($FILE))
			{
				$buffer .= fgets($FILE, 4096);
			}
			fclose($FILE);
		}
		return $buffer;
	}
	#USE SOCKET TO GET TEXT
	function get_contents_with_socket($file_location)
	{
		$data            = null;
		$fsocket_timeout = 10;
		$url_parts = parse_url($file_location);
		if (!$url_parts['host'])
		{
			$this->errors[] = "No host found in the URL '$file_location'!";
			return FALSE;
		}
		$host = $url_parts['host'];
		$port = (isset($url_parts['port'])) ? $url_parts['port'] : 80;
		if (!empty($url_parts["path"]))
		{
			$path = $url_parts["path"];
		}
		else
		{
			$path = "/";
		}
		if (!empty($url_parts["query"]))
		{
			$path .= "?" . $url_parts["query"];
		}
		if (!$fp = @fsockopen($host, $port, $errno, $errstr, $fsocket_timeout))
		{
			$this->errors[] = "No response from $host!";
			return FALSE;
		}
		else
		{
			if (! fputs($fp, "GET $path HTTP/1.0\r\nHost:$host\r\nCache-Control: max-age=0\r\nConnection: Close\r\n\r\n"))
			{
				$this->errors[] = "Unable to send request to $host!";
				return FALSE;
			}
		}
		@stream_set_timeout($fp, $fsocket_timeout);
		$status = @socket_get_status($fp);
		while(! feof($fp) && !$status['timed_out'])
		{
			$data .= fgets ($fp,8192);
			$status = socket_get_status($fp);
		}
		fclose ($fp);
		$tmp = split("\r\n\r\n", $data, 2);
		$data = $tmp[1];
		return $data;
	}
}
?>