<?
/*-------------------------------------------------------------------------------------------------
	|		dotBoost Self Managed Content | SMC Users Framework | support@dotboost.com
	+---------------------------------------------------------------------------
	|		SMC Users Framework IS NOT FREE SOFTWARE!
	+---------------------------------------------------------------------------
	|		Name : gzip.php
	|		Date started: Aug 3 2006
	|		Description : gzip archive class
	|		Version : 0.9
	+----------------------------------------------------------------------------------------------*/
define("_GZIP",true);
define("_GZIP_VER", 1.3);
define("_GZIP_BUILD", '03.04.2002');
class gzip {
	# Array to store compressed data
	var $_datasec = array();
	var $debug = true;
	
	function gzip(){}
	# Adds "file content" to archive
	function add($data, $name)
	{
		$unc_len = strlen($data);
		$crc = crc32($data);
		$zdata = gzdeflate($data,9);
		$c_len = strlen($zdata);
		$fr= "\x1f"."\x8B"."\x08"."\x08"."\x00\x00\x00\x00"."\x00"."\x00".$name."\x00".$zdata.$this->_pack($crc, 4).$this->_pack($unc_len, 4);
		$this->_datasec[] = $fr;
	}

	function file()
	{
		$data = implode('', $this->_datasec);
		return $data;
	}

	function _pack($val, $bytes=2)
	{
		for($ret='', $i=0; $i<$bytes; $i++, $val=floor($val/256) )
			$ret .= chr($val % 256);
		return $ret;
	}

	function add_file($name, $binary=false)
	{
		if(!file_exists($name))return false;
		$fd = $binary? fopen($name,'rb') : fopen($name,'r');
		if(! $content = fread($fd, filesize($name)) )return false;
		fclose($fd);
		$this->add($content,$name);
		return true;
	}

	function write_file($name)
	{
		$size = -1;
		if($fd = fopen($name,'wb'))
		{
			$size = fwrite($fd,$this->file());
			fclose($fd);
		}
		return $size;
	}
}
?>