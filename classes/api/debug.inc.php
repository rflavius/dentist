<?php
/*-------------------------------------------------------------------------------------------------
	|		dotBoost Self Managed Content | SMC Users Framework | support@dotboost.com
	+---------------------------------------------------------------------------
	|		SMC Users Framework IS NOT FREE SOFTWARE!
	+---------------------------------------------------------------------------
	|		Name : debug.inc.php
	|		Date started: Aug 3 2006
	|		Description : Useful Debug Tools
	|		Version : 0.9
	+----------------------------------------------------------------------------------------------*/
class Debug
{
	function startTimer()
	{
			global $starttime;
			$mtime = microtime ();
			$mtime = explode (' ', $mtime);
			$mtime = $mtime[1] + $mtime[0];
			$starttime = $mtime;
	}
	function endTimer()
	{
			global $starttime;
			$mtime = microtime ();
			$mtime = explode (' ', $mtime);
			$mtime = $mtime[1] + $mtime[0];
			$endtime = $mtime;
			$totaltime = round (($endtime - $starttime), 2);
			return $totaltime;
	}
}

function print_a ($array)
{
	echo '<div align="left"><pre>';
	print_r($array);
	echo '</pre></div>';
}
?>