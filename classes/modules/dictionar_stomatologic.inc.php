<?php

#if I have an article in dictionary I can see his category
function GetDictionaryArticlesCategories ($active, $article_id)
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
		$query = "SELECT bigcat_id FROM dictionary WHERE id = '".$article_id."'";
	}
	else 
	{
		$query = "SELECT * FROM dictionary_categories	 ".$status;
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

function GetCatId($cat_name)
{
	global $db;
	$query = "SELECT * FROM dictionary_categories
							WHERE cat_name = '".$cat_name."'";
	$db->query($query);
	$db->next_record();
	return $db->f('id_cat');
}

function InsertDictionaryTerm($titlu, $continut,$category_id,$autor,$email,$meta_keywords=1,$meta_description=1)
{
	global $db;
	global $conf;
	$alias = GenerateAlias($titlu);
	$query ="Insert into dictionary (titlu,continut,bigcat_id,data_adaugarii,autor,email,meta_keywords,meta_description,alias) values('".addslashes($titlu)."','".addslashes($continut)."','".$category_id."',now(),'".addslashes($autor)."','".addslashes($email)."','".addslashes($meta_keywords)."','".addslashes($meta_description)."','".$alias."')";
	$db->query($query);
	return $db->last_insert_id();
}


function CountDictionaryTotalRecords ($cat_id, $status)
{
	global $db;
	if($status!="all")
	{
		$status_q="and status = '".$status."'";
	}
	else
	{
		$status_q="";
	}

	switch ($cat_id)
	{
		case 'all':
			if($status_q!="")
			{
					$status_q="where status = '".$status."'";
			}
		$query = "SELECT id FROM dictionary ".$status_q;
		break;
		
		default:
			$query = "SELECT id FROM dictionary
											WHERE bigcat_id = '".$cat_id."' ".$status_q;
		break;
	
	}

	$db->query($query);
	return $db->num_rows();
}
function ListDictionaryTerms ($cat_id, $status, $limit)
{
	global $db;
	if($status!="all")
	{	 $status_q="and status = '".$status."'";}
	else
	{		$status_q="";	}

	switch ($cat_id)
	{
		case 'all':
			if($status_q!="")
			{
					$status_q="where status = '".$status."'";
			}
			$query = "SELECT * FROM dictionary ".$status_q." ORDER by  titlu ASC".$limit;
		break;
		
		default:
			$query = "SELECT * FROM dictionary
											WHERE bigcat_id = '".$cat_id."' ".$status_q." ORDER by  titlu ASC ".$limit;
		break;
	
	}
	
	$db->query($query);
	$i = 0; $get_info = array();
	$db->query($query);
	while ($db->next_record())
	{
		$get_info[$i]['id'] = $db->f('id');
		$get_info[$i]['titlu'] = ucfirst($db->f('titlu'));
		$get_info[$i]['data_adaugarii'] = $db->f('data_adaugarii');
		$get_info[$i]['data_modificarii'] = $db->f('data_modificarii');
		$get_info[$i]['email'] = $db->f('email');
		$get_info[$i]['autor'] = $db->f('autor');
		$get_info[$i]['user_id'] = $db->f('user_id');
		$get_info[$i]['meta_keywords'] = $db->f('meta_keywords');
		$get_info[$i]['meta_description'] = $db->f('meta_description');
		$get_info[$i]['continut'] = $db->f('continut');
		$get_info[$i]['status'] = $db->f('status');
		$get_info[$i]['alias'] = $db->f('alias');
		$i++;
	}

	return $get_info;
}



function GetSelectedTerm($id,$user_id=-1)
{
	
	global $db;$i=0;
	if($user_id=='-1')
	{
		$query = "SELECT * FROM dictionary WHERE id = '".$id."'";
	}
	else
	{
		$query = "SELECT * FROM dictionary WHERE id = '".$id."' and user_id='".$user_id."'";
	}
	
	$db->query($query);
	$db->next_record();
	$article = array();
	$info[$i]['id'] = $db->f('id');
	$article['category_id'] = $db->f('bigcat_id');
	$article['titlu'] = $db->f('titlu');
	$article['status'] = $db->f('status');
	$article['continut'] = $db->f('continut');
	$article['email'] = $db->f('email');
	$article['alias'] = $db->f('alias');
	$article['autor'] = $db->f('autor');
	$article['meta_keywords'] = $db->f('meta_keywords');
	$article['meta_description'] = $db->f('meta_description');
	$article['data_adaugarii'] = TimeFormatShort($db->f('data_adaugarii'));
	$article['data_modificarii'] = $db->f('data_modificarii');
	return $article;
}
function UpdateTerm($category, $title, $continut,$id,$meta_keywords, $meta_description,$autor,$email)
{
	global $db;
	$alias=GenerateAlias($title);
	$query = "UPDATE dictionary SET titlu = '".addslashes($title)."',
																continut = '".CleanImagePath(addslashes($continut))."',
																meta_keywords = '".addslashes($meta_keywords)."',
																meta_description = '".addslashes($meta_description)."',
																bigcat_id = '".addslashes($category)."',
																autor = '".addslashes($autor)."',
																alias='".addslashes($alias)."',
																email = '".addslashes($email)."'
						WHERE id = '".$id."'";
	$db->query($query);
	return '0';
}
function DeleteTerm($id)
{
	global $db;
	$query="Delete from dictionary where id=".$id;
	$db->query($query);
	return 0;
}
function GetTermIdByAlias($alias)
{
	if(stristr($alias,'html')!=FALSE)
	{
		$alias=substr($alias,0,-5); 
	}
	global $db;$i=0;
	$query = "SELECT id FROM dictionary WHERE alias = '".$alias."'";
	$db->query($query);
	$db->next_record();
	
	return $db->f('id');

}
function ListTermsDefinitions ($term)
{
	global $db;
	$term=addslashes($term);

$query= "SELECT *,MATCH (titlu,continut) AGAINST ('".$term."*' IN BOOLEAN MODE) as score FROM dictionary WHERE MATCH (titlu,continut) AGAINST ('".$term."*' IN BOOLEAN MODE) and status='1' ORDER BY score DESC "; 
	
	$db->query($query);
	$i = 0; $get_info = array();
	$db->query($query);
	while ($db->next_record())
	{
		$get_info[$i]['id'] = $db->f('id');
		$get_info[$i]['titlu'] = $db->f('titlu');
		$get_info[$i]['continut'] = $db->f('continut');

		$i++;
	}

	return $get_info;
}

#========================================UTILIZATOR PARTS=============================================
function  GetUserTerms($user_id,$msj_id)
{
	global $db;$get_info=array();$i=0;
	switch($msj_id)
	{
		default:
				$query = "SELECT * FROM dictionary WHERE user_id='".$user_id."' and id='".$msj_id."' order by submision_date DESC";
		break;
		
		case 'all':
			$query = "SELECT * FROM dictionary WHERE user_id='".$user_id."' order by submision_date DESC";
		break;
	}
	
		$db->query($query);
		while($db->next_record())
		{
			$get_info[$i]['id'] = $db->f('id');
			$get_info[$i]['titlu'] = $db->f('titlu');
			$get_info[$i]['data_adaugarii'] = $db->f('data_adaugarii');
			$get_info[$i]['email'] = $db->f('email');
			$get_info[$i]['autor'] = $db->f('autor');
			$get_info[$i]['user_id'] = $db->f('user_id');
			$get_info[$i]['continut'] = $db->f('continut');
			$get_info[$i]['status'] = $db->f('status');
			$i++;
		}
		return $info;
}
function CheckTermStatus($alias)
{
	global $db;
	$get_info = array();$i=0;
	$query = "SELECT * FROM dictionary WHERE alias='".$alias."'";
	$db->query($query);
	if($db->affected_rows()>1)
	{
		while($db->next_record())
		{
			$get_info[$i]['id'] = $db->f('id');
			$i++;
		}
	}
	else
	{
		$get_info = array();
	}
	return $get_info;
}
/**
 * list terms from dictionar random
 * @param int $limit
 * @param optional array $where
 * @return array
 */
function getDictionarRandomTerms($limit, $where = false)
{
	$db = Zend_Registry::get('database');
	$select = $db->select()
					->from('dictionary')
					->where('status = ?', '1')
					->order(new Zend_Db_Expr('RAND()'))
					->limit($limit);
	if($where!==false) $select->where($where);
	$results = $db->fetchAll($select);
	return $results;
}

?>