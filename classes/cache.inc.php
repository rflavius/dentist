<?php


//ini_set('display_errors','2047');
//set_magic_quotes_runtime(0);

global $db;
global $cfg;

class Cache
{
	var $cache_dir = "./cache/";
	var $admin_cache_dir = "../../cache/";
	var $cache_extension = '.html';

	function WeHaveCache($type)
	{
		global $db;
		$sql = "SELECT * FROM `cache` WHERE 
												`type`='$type'
												AND `status`='Y'
												AND CURDATE() < `expiration_date`";
		$db->query($sql);
		if($db->num_rows()>0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	function WeHaveAdminCache($county,$state)
	{
		global $db;
		$sql = "SELECT * FROM admin_cache WHERE 
												file_name LIKE '%".strtolower(str_replace(" ","_",$state)).'_'.strtolower(str_replace(" ","_",$county))."%'
												AND status='Y'
												AND CURDATE()<expiration_date";
		$db->query($sql);
		if($db->num_rows()>0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	function CreateCache($type,$value)
	{
		global $db;
		global $cfg;

		$ExpirationDate = mktime (0, 0, 0, date("m"), date("d")+10, date("Y"));
		$ExpirationDate = date ("Y-m-d", $ExpirationDate);
		$filename = $this->cache_dir.$type.$this->cache_extension;

		### if is on old cache file..just update it...
		if($this->OldCache($type))
		{
			$sql = "UPDATE cache 
									SET expiration_date='".$ExpirationDate."',status='Y' 
											WHERE type='$type'";

			
			##### write into the file 
			@chmod($filename, 0777);
			if (!$handle = fopen($filename, 'w+')) 
			{
				echo "Cannot open file ($filename)"; 
				exit; 
			}
			if(fwrite($handle, $value) === FALSE)
			{
				echo "Cannot write to file ($filename)"; 
				exit;
			}
			fclose($handle);
			@chmod($filename, 0755);
		}
		else
		{
			$sql = "INSERT 
									INTO cache(`id`,`type`,`expiration_date`,`status`)
											VALUES('','$type','".$ExpirationDate."','Y')";

			##### write into the file 
			@chmod($filename, 0777);
			if (!$handle = fopen($filename, 'w+')) 
				{
					echo "Cannot open file ($filename)"; 
					exit; 
				}
			if(fwrite($handle, $value) === FALSE)
			{
				echo "Cannot write to file ($filename)"; 
				exit;
			}
			fclose($handle);
			@chmod($filename, 0755);
		}
		$db->query($sql);
	}

	function CreateAdminCache($county,$state,$value)
	{
		global $db;
		global $cfg;

		$value = explode("</form>",$value);
		$value = $value[0];
		$value = $value.'</form><table border="0" cellspacing="0" cellpadding="2" width="100%">
<tr>
	<td id="cart_content" width="98%" align="center" valign="top">{SHOPPING_CART_CONTENT}</td>
</tr>
</table>
</div>
<br>';


		$ExpirationDate = mktime (0, 0, 0, date("m"), date("d")+$cfg['cache_expiration'], date("Y"));
		$ExpirationDate = date ("Y-m-d", $ExpirationDate);
		$filename = $this->admin_cache_dir.'/admin/county/'.strtolower(str_replace(" ","_",$state)).'_'.strtolower(str_replace(" ","_",$county)).$this->cache_extension;

		### if is on old cache file..just update it...
		if($this->AdminOldCache($county,$state))
		{
			$sql = "UPDATE admin_cache 
									SET created_date=NOW(),expiration_date='".$ExpirationDate."',status='Y' 
											WHERE file_name='".strtolower(str_replace(" ","_",$state)).'_'.strtolower(str_replace(" ","_",$county))."'";

			
			##### write into the file 
			@chmod($filename, 0777);
			if (!$handle = fopen($filename, 'w+')) 
			{
				echo "Cannot open file ($filename)"; 
				exit; 
			}
			if(fwrite($handle, $value) === FALSE)
			{
				echo "Cannot write to file ($filename)"; 
				exit;
			}
			fclose($handle);
			@chmod($filename, 0755);
		}
		else
		{
			$sql = "INSERT 
									INTO admin_cache(`id`,`file_name`,`created_date`,`expiration_date`,`status`)
											VALUES('','".strtolower(str_replace(" ","_",$state)).'_'.strtolower(str_replace(" ","_",$county))."', NOW(), '".$ExpirationDate."','Y')";

			##### write into the file 
			@chmod($filename, 0777);
			if (!$handle = fopen($filename, 'w+')) 
				{
					echo "Cannot open file ($filename)"; 
					exit; 
				}
			if(fwrite($handle, $value) === FALSE)
			{
				echo "Cannot write to file ($filename)"; 
				exit;
			}
			fclose($handle);
			@chmod($filename, 0755);
		}
		$db->query($sql);
	}

	function OldCache($type)
	{
		global $db;
		$sql = "SELECT * FROM cache WHERE 
																	type='$type'";
		$db->query($sql);
		if($db->num_rows()>0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	function AdminOldCache($county,$state)
	{
		global $db;
		$sql = "SELECT * FROM admin_cache WHERE 
																	file_name LIKE '%".strtolower(str_replace(" ","_",$state)).'_'.strtolower(str_replace(" ","_",$county))."%'";
		$db->query($sql);
		if($db->num_rows()>0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	function GetCacheContent($type)
	{
		$filename = $this->cache_dir.$type.$this->cache_extension;
		$handle = fopen($filename, "r"); 
		$content = fread($handle, filesize($filename)); 
		fclose($handle);
		return $content;
	}

	function GetAdminCacheContent($county,$state)
	{
		$filename = '../../cache/admin/county/'.strtolower(str_replace(" ","_",$state)).'_'.strtolower(str_replace(" ","_",$county)).$this->cache_extension;
		$handle = fopen($filename, "r"); 
		$content = fread($handle, filesize($filename)); 
		fclose($handle);
		return $content;
	}


}
?>