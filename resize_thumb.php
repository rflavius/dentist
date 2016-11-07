<?php
require('preload.php');
ini_set("memory_limit", "256M");
set_time_limit(0);
ini_set('display_errors', '1');
$i = 1;$info = array();
//chmod("./images/smallimages/cabinete/802/", 0755);
//exit;
if(isset($_GET['what_to_resize'])&&($_GET['what_to_resize'])!="")
{
	if($_GET['what_to_resize']=='articole')
	{
		$sql = "SELECT * FROM articles WHERE done_thumb='N' LIMIT 0,10";
		$db->query($sql);
		//echo $db->num_rows();exit;
		if($db->num_rows()>0)
		{
				while($db->next_record())
				{
					$info[$i]['id_articol'] = $db->f('id');
					$info[$i]['id_record'] = $db->f('id');
					$info[$i]['image_name'] = $db->f('imagine');
					$i++;
				}
			foreach ($info as $key =>$val)
			{
				$id_record = $val['id_record'];
				$image_name = $val['image_name'];
				unlink('./images/smallimages/articole/'.$id_record.'/'.$image_name );
				echo '<img src="http://www.dentistonline.ro/upload_js/resize_image_thumb.inc.php?what_to_resize=articole&width=80&height=80&cropratio=1:1&image=//images/users_articole/'.$image_name.'&firma_id='.$id_record.'">';
				$sql_update = "Update articles  set done_thumb='Y' where id='".$id_record."'";
				$db->query($sql_update);
			}
			
		}
	}
	elseif($_GET['what_to_resize']=='anunturi')
	{
		
		$sql = "SELECT * FROM anunturi WHERE done='N' LIMIT 0,10";
		$db->query($sql);
		if($db->num_rows()>0)
		{
				while($db->next_record())
				{
					$info[$i]['id_record'] = $db->f('id');
					$info[$i]['image_name'] = $db->f('imagine');
					$i++;
				}
		
			foreach ($info as $key =>$val)
			{
				$id_record = $val['id_record'];
				$image_name = $val['image_name'];
				unlink('./images/smallimages/anunturi/'.$image_name );
				echo '<img src="http://www.dentistonline.ro/upload_js/resize_image_thumb.inc.php?what_to_resize=anunturi&width=80&height=80&cropratio=1:1&image=//images/users_anunturi/'.$image_name.'&firma_id='.$id_record.'">';
				$sql_update = "Update anunturi  set done='Y' where id='".$id_record."'";
				$db->query($sql_update);
			}
			
		}
	}
	elseif($_GET['what_to_resize']=='cabinete')
	{//echo "s";
		$sql = "SELECT * FROM images WHERE small_resized='N' and type='cabinet' LIMIT 0,20";
		$db->query($sql);
		if($db->num_rows()>0)
		{
				while($db->next_record())
				{
					$info[$i]['id_record'] = $db->f('id');
					$info[$i]['image_name'] = $db->f('image_name');
					$info[$i]['folder_id'] = $db->f('folder_id');
					$i++;
				}
				$i=1;$info_images=array();
				
				foreach ($info as $key =>$val)
				{
					$id_record = $val['id_record'];
					$image_name = $val['image_name'];
					unlink('./images/smallimages/cabinete/'.$image_name );
					echo '<img src="http://www.dentistonline.ro/upload_js/resize_image_thumb.inc.php?what_to_resize=cabinete&width=80&height=80&cropratio=1:1&image=//images/users_cabinete/'.$val['folder_id'].'/'.$image_name.'&firma_id='.$val['folder_id'].'">';
					/*$image_location = '//images/users_cabinete/'.$val['folder_id'].'/'.$image_name;
					$folder_id_what_to_resize = $val['folder_id'];
					$what_to_resize = "cabinete";
					$width = '80';
					$height='80';
					$crop_ratio='1:1';
					if($image_name!="default.jpg")
					generateThumb($image_location,$folder_id_what_to_resize,$what_to_resize,$width,$height,$crop_ratio);
					//echo "ss";*/
					$sql_update = "Update images  set small_resized='Y' where id='".$id_record."'";
					$db->query($sql_update);
				}
		}
	}
}

exit;

?>