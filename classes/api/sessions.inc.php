<?php
/*------------------------------------------------------------------------------------------------
	|		dotBoost Self Managed Content | SMC Users Framework | support@dotboost.com
	+---------------------------------------------------------------------------
	|		SMC Users Framework IS NOT FREE SOFTWARE!
	+---------------------------------------------------------------------------
	|		Name : session.inc.php
	|		Date started: Aug 3 2006
	|		Description : sessions object
	|		Version : 0.9
	+---------------------------------------------------------------------------------------------*/
class GeneralSession
{
	var $ip_address;
	var $user_agent;
	var $location ;
	var $botmap;
	# class constructor
	function GeneralSession ()
	{
		global $conf;
		$this->ip_address = GetUserIP();
		$this->user_agent = '';
		if (isset($_SERVER["HTTP_USER_AGENT"]) )
		{
			$this->user_agent = $_SERVER["HTTP_USER_AGENT"];
		}
		$this->location = $_SERVER["PHP_SELF"];
		if ($_SERVER["QUERY_STRING"])
		{
			$this->location .= '?'.$_SERVER["QUERY_STRING"];
		}
		$this->botmap = $conf->search_engine_bots;
	}
	# start the session
	function SessionStart ()
	{
		global $db;
		global $SESSION;
		global $conf;
		session_start();
		# let see if it is a robot or a human
		foreach( explode( "\n", $this->botmap) as $bot )
		{
			list($ua, $n) = @explode("=", $bot);
			if ( $ua and $n )
			{
				$this->bot_map[ strtolower($ua) ] = $n;
				$this->bot_safe[] = preg_quote( $ua, "/" );
			}
		}
		/*echo $this->user_agent."<br />";
		print_R(implode('|', $this->bot_safe));
		$a = implode('|', $this->bot_safe);
		$boots_fara_spatiu = str_replace(" ","",$a);
		if(strpos($k," ")!==FALSE)
		{
			echo "sssss";
		}
		echo $k;*/

		if (preg_match('/('.implode('|', $this->bot_safe).')/i', $this->user_agent, $match)  || $this->user_agent=="")
		{
			# YES, is a robot, so let's record the visit
			$i_am_robot = 'Y';
			
			# exclude visits to some useless pages
			$count_page = 0;
			/*$nocount_page = array('');
			while (list($kno, $vno) = each($nocount_page))
			{
				if (strstr($this->location, $vno))
				{
					$count_page++;
				}
			}*/
			# record the visit only if is not a useless page
			if ($count_page == 0)
			{
				$agent = trim($match[0]);
				$query = "INSERT INTO log_spiders (bot, page, visit_date, ip_address, user_agent)
									VALUES ('$agent', '$this->location', now(), '$this->ip_address', '$this->user_agent')";
				$db->query($query);
			}
		}else
		{
			$visitor_ip = GetUserIP();
			AddVisitorIP($visitor_ip);
		}

		if (!isset($SESSION))
		{
			$SESSION = array();

			# record if is a robots a special variable
			$SESSION['robot'] = 'N';
			if (isset($i_am_robot))
			{	$SESSION['robot'] = $i_am_robot; }

			if (!isset($SESSION['refferer']))
			{	$SESSION['refferer'] = GetReferer(); }

		}
		return $SESSION;
	}
}
?>