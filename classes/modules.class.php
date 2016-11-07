<?php
class Modules
{
	var $module=array(); // this return object will be an array !!!

	public function Modules()
	{
		global $db;
		$this->module = array();
		$sql = "SELECT * FROM modules WHERE `active`='1' ";
		$db->query($sql);
		if ($db->num_rows()>0 )
		{
			while($db->next_record())
			{
				$this->module[$db->f('link')] = array(
														'name'=>$db->f('name'),
														'link'=>$db->f('link'),
														'id'=>$db->f('id'),
														'alias'=>$db->f('alias'),
														'type'=>$db->f('type'),
														'meta_keywords'=>$db->f('meta_keywords'),
														'meta_description'=>$db->f('meta_description'),
														'content'=>$db->f('content')
														);
			}
		}
	}
}
?>