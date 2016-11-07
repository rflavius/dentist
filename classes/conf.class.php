<?php
class Config
{
	function Config()
	{
		global $db;
		$db->query('Select * from config');
		while ($db->next_record())
		{
			$variable = $db->f('variable');
			if ($variable != '') $this->$variable = $db->f('value');
		}
	}
}
?>