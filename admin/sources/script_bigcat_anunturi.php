<?php

	switch($action)
	{
		default:
			$tpl->set_file('tpl_edit', 'anunturi/script.tpl');
			
			#firs we display the cats and the id_s
		/*	#we took all anunturi and set the default bigcatid and them change with the new ones
			$array_dates=array();$i=0;
			$query = "Select * from anunturi where bigcat_id <> bigcat_idd limit 200,100";
			$db->query($query);
			while($db->next_record())
			{
				$array_dates[$i]['id'] = $db->f('id');
				$array_dates[$i]['bigcat_id'] = $db->f('bigcat_id');
				$array_dates[$i]['bigcat_idd'] = $db->f('bigcat_idd');
				$i++;
			}
			foreach($array_dates as $ky => $val)
			{
				echo $val['bigcat_id']. " ".$val['bigcat_idd']."<br>";
				$old_link = ReWrite('anunturi_detalii', 'anunturi.detalii.'.$val['id']);
				$old_link = str_replace("http://www.dentistonline.ro/","",$old_link);
				//echo $old_link." <br>"; 
				$cat_det = GetAnunturiCategoryInfos($val['bigcat_id']);
				$cat_alias_old = $cat_det['alias'];
				if($cat_alias_old=='distribuitori-materiale' )
				{
					$cat_alias_old = 'Distributii-Materiale';
				}
				$cat_det = GetAnunturiCategoryInfos($val['bigcat_idd']);
				$cat_alias_new = $cat_det['alias'];
				
				//echo "<br>".$cat_alias_old." ".$cat_alias_new."<br>";  
				$new_link = str_ireplace($cat_alias_old,$cat_alias_new,$old_link);
				$new_link ="http://www.dentistonline.ro/".$new_link;
				//echo $new_link."<br><br>";
				
				$query="Insert into redirect_links (old_link,new_link) values ('".$old_link."','".$new_link."')";
				$db->query($query);
				
				//$query="Update anunturi set bigcat_idd='".$val['bigcat_id']."' where id='".$val['id']."'";
				//$db->query($query);
			//	echo $query."<br>";
			}
			exit;*/

			$get_module_categories = GetAnunturiCategories('-1', '');
			$tpl->set_block('tpl_edit', 'list_categories', 'list_categories_block');
				while (list($k, $v) = each($get_module_categories))
				{
					$tpl->set_var('CAT_ID', $v['id_cat']);
					$tpl->set_var('CAT_NAME', $v['cat_name']);
					$tpl->parse('list_categories_block', 'list_categories', true);
				}

		
			$dispmode = "data-data_adaugarii-DESC";
			$query_limit ="Limit 0,60";
			$get_anunturi = GetAnunturiByCat("all","all",$dispmode,$query_limit);
		
			$tpl->set_block('tpl_edit', 'list_anunturi', 'list_anunturi_block');
				while (list($k, $v) = each($get_anunturi))
				{
					$tpl->set_var('ID_ANUNT', $v['id']);
					$tpl->set_var('BIG_CAT_ID', $v['bigcat_idd']);
					$tpl->set_var('DESCRIERE',substr($v['continut'],0,200));
					$tpl->set_var('ANUNT', $v['titlu']);
					$tpl->parse('list_anunturi_block', 'list_anunturi', true);
				}

			$tpl->parse("MAIN",'tpl_edit');
		break;
		
		case 'change':
		
		foreach($_POST as $ky => $val)
		{
			
			$query = "Update anunturi set bigcat_idd='".$val."' where id='".$ky."'";
			$db->query($query);
		}
		header ('location: ?page=script_bigcat_anunturi');
		exit;
		
		break;
	}


?>