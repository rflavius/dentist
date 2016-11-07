<?php
/*------------------------------------------------------------------------------------------------
	|		dotBoost Self Managed Content | SMC Users Framework | support@dotboost.com
	+---------------------------------------------------------------------------
	|		SMC Users Framework IS NOT FREE SOFTWARE!
	+---------------------------------------------------------------------------
	|		Name : db_mysql.inc.php
	|		Date started: Aug 3 2006
	|		Description : database functions API
	|		Version : 0.9
	+---------------------------------------------------------------------------------------------*/
#initiates a Db object 
function api_db_connect()
{
	return new Db_Sql;
}

class DB_Sql
{
	# PRIVATE: connection parameters 
	var $host					= '';
	var $database			= '';
	var $type					= 'mysql';
	var $seq_table		= 'db_sequence';
	var $auto_free		= 1;			# 1 for automatic mysql_free_result()
	var $debug				= 0;			#  1 for debugging messages.
	var $query_count	= 0;			#  Number of queries used
	var $debug_html		= "<div align=center><table width='95%' border='0' cellpadding='4' cellspacing='1' bgcolor='#E2E2E2' align='center'>";			# Debug information 
	var $query_time		= 0;			# time for running queries
	
	# PRIVATE: errors debug, current error number and error text
	var $halt_on_error = 'yes';	# "yes" (halt with message)
															# "no" (ignore errors quietly)
	 
	var $errno				= 0;
	var $error				= '';

	# PRIVATE: result array and current row number 
	var $record				= array();
	var $row;

	# PRIVATE: link and query handles 
	var $link_id  = 0;
	var $query_id = 0;

	# PUBLIC: constructor 
	function DB_Sql($query = "")
	{
		$registry = Zend_Registry::getInstance();
		$r = $registry->configuration->database->params->toArray();
		# if we are not already connected
		if( 0 == $this->link_id )
		{
			$this->link_id = $this->connect( $r['dbname'], 
											$r['host'], 
											$r['username'], 
											$r['password']
											);
		}
	}

	# PUBLIC: Return the current connection link identifier
	function link_id()
	{
		return $this->link_id;
	}
	# PUBLIC: 	Return the current query identifier
	function query_id()
	{
		return $this->query_id;
	}

	# PUBLIC:	
	# Opens a connection to the SQL server and select the database
	# RETURN:  - link identifier
	function connect($database = '', $host = '', $user = '', $password = '')
	{
		$this->database = $database;
		$this->host = $host;
		#
		# establish connection, select database 
		if ( 0 == $this->link_id )
		{
			$this->link_id = mysql_connect($host, $user, $password);
			if (!$this->link_id)
			{
				$this->halt("connect($Host, $User, \$Password) failed.");
				return 0;
			}
			
			if (!@mysql_select_db($database,$this->link_id))
			{
				$this->halt("cannot use database.".$this->link_id.$database);
				return 0;
			}
		}
		return $this->link_id;
	}

	# PUBLIC: discard the query result 
	function free()
	{
			@mysql_free_result($this->query_id);
			$this->query_id = 0;
	}

	# PUBLIC: perform a query 
	function query($query_string)
	{
		$ip=GetUserip();
	/*	if($ip=="86.127.119.35")
	if($ip=="79.113.86.142")
	
		{
			echo $query_string."<br>";
		}*/
		# No empty queries
		if ($query_string == '')
		{
			# The empty query string is passed on from the constructor,
			# when calling the class without a query, e.g. in situations
			# like these: '$db = new DB_Sql_Subclass;'
			return 0;
		}
		if (!$this->connect())
		{
			return 0; # already catched in connect() 
		}

		# New query, discard previous result.
		if ($this->query_id)
		{
			$this->free();
		}
		# load all queries in an array , with time 
		if ($this->debug)	printf("debug: query = %s<br>\n", $query_string);
		# clean the query string
		$query_string = $this->clean_query_string($query_string);

		$startsqltime = explode(" ", microtime());

		$this->query_id = @mysql_query($query_string, $this->link_id);
		$this->row   = 0;
		$this->errno = mysql_errno();
		$this->error = mysql_error();
		if (!$this->query_id)
		{
			$this->halt("Invalid SQL: ".$query_string);
		}
		#
		# Load Query Information in HTML 
		#
		$endsqltime = explode(" ", microtime());
		$totalsqltime = round($endsqltime[0]-$startsqltime[0]+$endsqltime[1]-$startsqltime[1],4);
		$this->query_time += $totalsqltime;
		$this->query_count++;
		$this->debug_html .= "
				<tr>
					<td style='font-size:10px' bgcolor='#F9F9F9'><b>Query Number: # $this->query_count </b></td>
					<td style='font-size:10px' bgcolor='#F9F9F9'><b>Querytime:</b> $totalsqltime</td>
				</tr>
				<tr>
					<td colspan=2 style='font-size:10px' bgcolor='#FFFFFF'>$query_string</td>
				</tr>\n";
	
		return $this->query_id;
	}

	# PUBLIC: walk result set 
	function next_record()
	{
		if (!$this->query_id)
		{
			$this->halt('next_record called with no query pending.');
			return 0;
		}

		$this->record = @mysql_fetch_array($this->query_id);
		$this->row   += 1;
		$this->errno  = mysql_errno();
		$this->error  = mysql_error();

		$stat = is_array($this->record);
		if (!$stat && $this->auto_free)
		{
			$this->free();
		}
		return $stat;
	}

	# PUBLIC: position in result set 
	function seek($pos = 0)
	{
		$status = @mysql_data_seek($this->query_id, $pos);
		if ($status) 	$this->row = $pos;
		else
		{
			$this->halt("seek($pos) failed: result has ".$this->num_rows()." rows.");
			return 0;
		}
		return 1;
	}


	# PUBLIC: Fetch current row 
	function fetch_row ()
	{
		return mysql_fetch_row($this->query_id);
	}

	# PUBLIC: Get number of affected rows in previous operation
	function affected_rows()
	{
		return @mysql_affected_rows($this->link_id);
	}
	# PUBLIC:  Get number of rows in result
	function num_rows()
	{
		return mysql_num_rows($this->query_id);
	}
	# PUBLIC:  Get number of fields in result
	function num_fields()
	{
		return @mysql_num_fields($this->query_id);
	}
	# PUBLIC:  return last insert id
	function last_insert_id()
	{
		return mysql_insert_id( $this->link_id() );
	}
	# PUBLIC:  Get the value of a field in the current row
	# PARAMETER: The name of the field
	# RETURN: - The value of the field
	function f($Name)
	{
			return $this->record[$Name];
	}
	
	# PUBLIC: Returns current number of parsed and run queries
	# RETURN: return	integer	Value stored in var $query_count
	function get_query_count()
	{
		return $this->query_count;
	}
	
	# PUBLIC: Returns time needed for queries
	# RETURN: return	float	Value stored in var $query_time
	function get_query_time()
	{
		return $this->query_time;
	}
	# PUBLIC: Returns html code for each query details and time
	# RETURN: return	integer	Value stored in var $debug_html
	function debug_html()
	{
		return $this->debug_html."</table>\n<br />\n</div>";
	}

	# PUBLIC: Cleaning the query string with all kind of functions
	# RETURN: return	a clean query string
	function clean_query_string($query_string)
	{
			#$clean_string = mysql_real_escape_string($query_string,$this->link_id);
			#$clean_string = str_replace('\r\n','',$clean_string);
			#$clean_string =stripslashes($clean_string);
			#$clean_string =addslashes($clean_string);
			return $query_string;
	}

	# PUBLIC: Return the version number of the SQL server
	# RETURN: Should return  version string (ie: 3.23.0)
	function get_version()
	{
		$this->query("SELECT VERSION() AS version");
		$this->next_record();
		return $this->f("version");
	}

	# PUBLIC: Return the table metadata
	# PARAMETER  The name of the table
	# RETURN:  Full or partial info
	/* result array - <pre>
	 - full is false (default):
		 result[]:
			 [0]["table"]  table name
			 [0]["name"]   field name
			 [0]["type"]   field type
			 [0]["len"]    field length
			 [0]["flags"]  field flags
		 - full is true
		 result[]:
			 ["num_fields"] number of metadata records
			 [0]["table"]  table name
			 [0]["name"]   field name
			 [0]["type"]   field type
			 [0]["len"]    field length
			 [0]["flags"]  field flags
			 ["meta"][field name]  index of field named "field name"
			 The last one is used, if you have a field name, but no index.
			 Test:  if (isset($result['meta']['myfield'])) { ... }</pre> 
	*/
	function metadata($table = '', $full = false)
	{
		$count = 0;
		$id    = 0;
		$res   = array();
		global $_CONFIG;

		# if no $table specified, assume that we are working with a query
		# result
		if ($table)
		{
			$id = @mysql_list_fields($_CONFIG['db_name'], $table);
			if (!$id)
			{
				$this->halt("Metadata query failed.");
				return false;
			}
		}
		else
		{
			$id = $this->query_id; 
			if (!$id)
			{
				$this->halt("No query specified.");
				return false;
			}
		}

		$count = @mysql_num_fields($id);

		# made this IF due to performance (one if is faster than $count if's)
		if (!$full)
		{
			for ($i=0; $i<$count; $i++)
			{
				$res[$i]["table"] = @mysql_field_table ($id, $i);
				$res[$i]["name"]  = @mysql_field_name  ($id, $i);
				$res[$i]["type"]  = @mysql_field_type  ($id, $i);
				$res[$i]["len"]   = @mysql_field_len   ($id, $i);
				$res[$i]["flags"] = @mysql_field_flags ($id, $i);
			}
		} 
		else 
		{ 
			# full
			$res["num_fields"]= $count;
		
			for ($i=0; $i<$count; $i++)
			{
				$res[$i]["table"] = @mysql_field_table ($id, $i);
				$res[$i]["name"]  = @mysql_field_name  ($id, $i);
				$res[$i]["type"]  = @mysql_field_type  ($id, $i);
				$res[$i]["len"]   = @mysql_field_len   ($id, $i);
				$res[$i]["flags"] = @mysql_field_flags ($id, $i);
				$res["meta"][$res[$i]["name"]] = $i;
			}
		}
		
		# free the result only if we were called on a table
		if ($table) $this->free();;
		return $res;
	}

	# PUBLIC: Return the table names from the database
	function  table_names()
	{
		$tables =array();
		global $_CONFIG;
		$query = "SHOW TABLES FROM ".$_CONFIG['db_name'];
		$result = $this->query($query);
		while ($row = $this->fetch_row($result))
		{
			$tables[] = $row[0];
		}
		return $tables;
	}
	function optimize ()
	{
		$tables = 	$this->table_names();
		foreach ($tables as $key => $val)
		{
			# Check All Tables
			$query = "CHECK TABLE ".$val." extended";
			$this->query($query);

			# Repair All Tables
			$query = "REPAIR TABLE ".$val." extended";
			$this->query($query);

			# Check All Tables, Again
			$query = "CHECK TABLE ".$val." extended";
			$this->query($query);

			# Optimize All Tables
			$query = "OPTIMIZE TABLE ".$val;
			$this->query($query);
		}
	}
	# PRIVATE: error handling 
	function halt($msg)
	{
		$this->error = @mysql_error($this->link_id);
		$this->errno = @mysql_errno($this->link_id);

		if ($this->halt_on_error == "no")		return;

		$this->haltmsg($msg);
	}

	# PRIVATE: output error message
	function haltmsg($msg)
	{
		$the_error ='';
		$the_error .= "\n\n Error: ".$msg."\n";
		$the_error .= "\n\nSQL error: ".$this->error."\n";
		$the_error .= "SQL error code: ".$this->errno."\n";
		$the_error .= "Date: ".date("l dS of F Y h:i:s A");

		$out = "<html><head><title>Database Driver Error</title>
					<style>P,BODY{ font-family: trebuchet MS,sans-serif; font-size:11px; 
					}</style></head><body>&nbsp;<br><br><blockquote><b>There is an error with the 
					database.</b><br>
					You can try to refresh the page by clicking <a href=\"javascript:window.location=window.location;\">here</a>.
					<br><br><b>Error Returned</b><br>
					<form name='mysql'><textarea rows=\"15\" cols=\"60\">".htmlspecialchars($the_error)."</textarea></form></blockquote></body></html>";
		print $out;
		exit();
	}
}
?>