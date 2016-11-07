<?php

/*
- Function used in : admin / news.php
*/
function ReorderNews ($id, $order_type)
{
	global $db;
	$query="SELECT position FROM news WHERE `id`='".$id."'";
	$db->query($query);
	$db->next_record();
	$new_order = $db->f('position');
	if ($order_type == 'up')
	{
		$new_order += -15;
	}
	else 
	{
		$new_order += +15;
	}
	UpdateNewsOrder($id, $new_order);
}
/*
- Function used in : admin / news.php
*/
function UpdateNewsOrder ($id, $order_value)
{
	global $db;
	$query="UPDATE news SET position = '".$order_value."'
					WHERE id='".$id."'";
	$db->query($query);
}
/*
- Function used in : admin / news.php
*/
function RearrangeNews ()
{
	global $db;
	$query="SELECT id FROM news WHERE status = '1'
																	ORDER BY position ASC";
	$db->query($query);
	$y = 0;
	$ids = array();
	while ($db->next_record())
	{
		$ids[$y] = $db->f('id');
		$y++;
	}
	$i = 20;
	foreach ($ids as $key => $val)
	{
		UpdateNewsOrder($val, $i);
		$i+=10;
	}
}
function GetCursuriEvCategories ($active, $article_id)
{
	global $db;
	$cats = array();
	switch ($active)
	{
		default :
			$status = " WHERE active = '".$active."'";
		break;

		case '-1':
			$status = "";
		break;
	}
	if ($article_id != "")
	{
		/*select the parent_module*/
		$query = "SELECT bigcat_id FROM news WHERE id = '".$article_id."'";
	}
	else 
	{
		$query = "SELECT * FROM news_categories	 ".$status;
	}
	$db->query($query);
	$i = 0;
	while ($db->next_record())
	{
		$cats[$i]['id_cat'] = $db->f('id_cat');
		$cats[$i]['cat_name'] = $db->f('cat_name');
		$cats[$i]['active'] = $db->f('active');
		$cats[$i]['alias'] = $db->f('alias');
		
		$i++;
	}
	return $cats;
}

#- Function used in : admin / articles.php
	function CursuriEvCategoryExists ($cat_name)
	{
		global $db;
		$query = "SELECT id_cat FROM news_categories
							WHERE cat_name = '".addslashes($cat_name)."'";
		$db->query($query);
		if ($db->num_rows() != '0')
		{
			return true;
		}
		else 
		{
			return false;
		}
	}
function SavePicturesNews($file_extension, $id,$front_back)
{
	global $conf;
	global $db;
	
	if($front_back=="frontend")
	{		$uploaddir = './images/news/'; }
	else
	{		$uploaddir = '../images/news/';	}

	
	if ($file_extension!="default" )
	{
			#daca anuntul are imagine sa o stergem
			$sql = "SELECT * from news where id='".$id."'";
			$db->query($sql);
			if($db->affected_rows()>0)
			{
				$db->next_record();
				$img_name = $db->f('imagine');
				if((strpos($img_name,"default")===false)&&($img_name!=""))
				{		unlink($uploaddir.$img_name);	}
			
			}

			/*create photo name*/
			$today = date("Ymd");                           
			$filename = 'news_'.$today.'_'.$id.'.'.$file_extension;
			$uploadfile = $uploaddir.$filename;
			/*do query*/
			$query = "UPDATE news SET imagine = '".$filename."' WHERE id = '".$id."'";
			$db->query($query);
			/*upload picture*/
			if (!move_uploaded_file($_FILES['imagine']['tmp_name'], $uploadfile))
			{
				print "Possible file upload attack!  Here's some debugging info:\n";
				print_r($_FILES);
			}
			/*change chmode*/
			chmod($uploadfile, 0777);
	}
	else 
	{
			$filename = 'default.jpg';
			$query = "UPDATE news SET imagine = '".$filename."' WHERE id = '".$id."'";
			$db->query($query);
	
	}
	
}

?>