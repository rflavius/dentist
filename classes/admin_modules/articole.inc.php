<?php
#- Function used in : admin / articles.php
	function ArticleCategoryExists ($cat_name)
	{
		global $db;
		$query = "SELECT id_cat FROM articles_categories
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

function SavePicturesCatArticles ($file_extension, $id_cat_art)
{
	global $conf;
	global $db;
	$uploaddir = '../images/admin/articles_categories_image/'; 

	if ($file_extension!="default" )
	{
			#daca anuntul are imagine sa o stergem
			$sql = "SELECT * from articles_categories where id_cat='".$id_cat_art."'";
			$db->query($sql);
			if($db->affected_rows()>0)
			{
				$db->next_record();
				$img_name = $db->f('image_name');
				if((strpos($img_name,"default")===false)&&($img_name!=""))
				{		unlink($uploaddir.$img_name);	}
			
			}
			$filename = $_FILES['imagine']['name'];
			$filename = GenerateImageNameArticles($filename);
			$uploadfile = $uploaddir.$filename;
			//echo $uploadfile;exit;

			/*do query*/
			$query = "UPDATE articles_categories SET image_name = '".$filename."' WHERE id_cat = '".$id_cat_art."'";
			$db->query($query);
			
			
			/*upload picture*/
			if (!move_uploaded_file($_FILES['imagine']['tmp_name'], $uploadfile))
			{
				print "Possible file upload attack!  Here's some debugging info:\n";
				print_r($_FILES);
			}
			/*change chmode*/
			chmod($uploadfile, 0777);
			chmod($uploaddir, 0755);
	}
	else 
	{
			$filename = 'default.jpg';
			$query = "UPDATE articles_categories SET image_name = '".$filename."' WHERE id_cat = '".$id_cat_art."'";
			$db->query($query);
	
	}
	
}

#- Function used in : admin / articles.php
function InsertArticleCategory ($cat_name,$meta_key,$meta_desc)
{
	global $db;
	$alias = GenerateAlias($cat_name);
	$query = "INSERT into articles_categories(cat_name, meta_keywords,meta_description,alias)
						VALUES ('".addslashes($cat_name)."','".addslashes($meta_key)."','".addslashes($meta_desc)."','".addslashes($alias)."')";
	$db->query($query);
	return $db->last_insert_id();
}


#- Function used in : admin / articles.php

function SaveArticleCategory ($name,$meta_key,$meta_desc, $id)
{
	global $db;
	$alias = GenerateAlias($name);
	$query = "UPDATE articles_categories SET cat_name = '".addslashes($name)."',meta_keywords='".addslashes($meta_key)."',meta_description='".addslashes($meta_desc)."',alias='".addslashes($alias)."'
							WHERE id_cat = '".$id."'";
	$db->query($query);
	return 0;
}


#- Function used in : admin / articles.php

function ChangeArticleStatus ($new_status, $id)
{
	global $db;
	switch ($new_status)
	{
		case 'active':
			$status = '1';
		break;

		case 'inactive':
			$status = '0';
		break;
	}
	$query = "UPDATE articles SET status = '".$status."'
						WHERE id = '".$id."'";
	$db->query($query);
	return '0';
}


function Update_Image_Name_Articles($id_anunt,$image_name,$old_img_name)
{
	global $db;
	
	#we have to rename the file name
	$old_picture = '../images/users_articole/'.$old_img_name;
	$new_pict = '../images/users_articole/'.$image_name;
	$response = rename($old_picture,$new_pict);
	
	if ($response)
	{
		#we update the db
		$sql =  "Update articles Set imagine='".$image_name."' where id='".$id_anunt."'";
		$db->query($sql);
	}
	return 1;
}

function MoveArticleToAnunturi($article,$category_id,$judet,$localitate)
{
	
	global $db;
	global $conf;
	$alias = GenerateAlias($article['titlu']);
	$exp_date = date("y-m-d", mktime(0, 0, 0, date("m")+6, date("d"), date("Y")));

	$query ="Insert into anunturi (user_id,titlu,continut,bigcat_id,data_adaugarii,data_expirarii,autor,email,judet,localitate,meta_keywords,meta_description,alias,imagine) values('".$article['user_id']."','".addslashes($article['titlu'])."','".addslashes(strip_tags($article['continut']))."','".$category_id."',now(),'".$exp_date."','".addslashes($article['autor'])."','".addslashes($article['email'])."','".addslashes($judet)."','".addslashes($localitate)."','".addslashes($article['meta_keywords'])."','".addslashes($article['meta_description'])."','".$alias."','".$article['imagine']."')";
	$db->query($query);

	//$query = "Delete from articles where id='".$article['id']."'";
	//$db->query($query);
	
	return 1;

}
/*



- Function used in : sources / articles.php
-                  : sources / sitemap.php

function GetArticles ($module, $category)
{
	global $db;
	global $conf;
	if ($module != '' && $category == '')
	{
		$query = "SELECT * FROM articles
							WHERE status = '1' AND parent_module = '".$module."'
							ORDER by submision_date DESC";
	}
	else
	{
		$query = "SELECT A.*, B.* FROM articles A, articles_cat B
							WHERE B.cat_id = '".$category."'
							AND A.status = '1'
							AND A.id = B.article_id
							ORDER by A.submision_date DESC";
	}
	$db->query($query);
	$i = 0;
	$article = array();
	while ($db->next_record())
	{
		$article[$i]['id'] = $db->f('id');
		$article[$i]['title'] = $db->f('title');
		$article[$i]['short_description'] = $db->f('short_description');
		$article[$i]['submision_date'] = TimeFormatShort($db->f('submision_date'));
		$i++;
	}
	return $article;
}

- Function used in : sources / articles.php
-                  : admin / articles.php







#- Function used in : admin / articles.php




/*
- Function used in : admin / articles.php

function GetCategoryName ($id)
{
	global $db;
	$query = "SELECT cat_name FROM articles_categories
							WHERE id_cat = '".$id."'";
	$db->query($query);
	$db->next_record();
	return $db->f('cat_name');
}
/*
- Function used in : admin / articles.php

function GetArticlesModules ()
{
	global $db;
	$mods = array();
	$query = "SELECT id, name FROM modules WHERE active = '1' AND support = 'articles'";
	$db->query($query);
	$i = 0;
	while ($db->next_record())
	{
		$mods[$i]['id'] = $db->f('id');
		$mods[$i]['name'] = $db->f('name');
		$i++;
	}
	return $mods;
}
/*- Function used in : admin / articles.php

function InsertArticle ($article_category, $title, $short_description, $content, $meta_keywords, $meta_description, $print)#, $dwd_pdf, $email_to_friend)
{

	global $db;
	$query = "INSERT into articles(title,
																 short_description,
																 content,
																 meta_keywords,
																 meta_description,
																 print,
																 submision_date)
													VALUES('".addslashes($title)."',
																 '".addslashes($short_description)."',
																 '".CleanImagePath(addslashes($content))."',
																 '".addslashes($meta_keywords)."',
																 '".addslashes($meta_description)."',
																 '".$print."',
																 now())";
	$db->query($query);
	$last_id = $db->last_insert_id();

	$parent = explode("_", $article_category);
	$parent_mod = $parent['0'];
	$parent_id = $parent['1'];
	switch ($parent_mod)
	{
the article has been inserted for a certain module
		case 'module':
			$query = "UPDATE articles SET parent_module = '".$parent_id."'
								WHERE id = '".$last_id."'";
			$db->query($query);
		break;
the article has been inserted for a certain category under a module
		case 'category':
			$query = "INSERT into articles_cat(article_id,
																				 cat_id)
																	VALUES('".$last_id."',
																				 '".$parent_id."')";
			$db->query($query);
		break;
	}
	return '0';
}

- Function used in : admin / articles.php
-                  : admin / static.php

function CountArticlesTotalRecords ($parent, $parent_id)
{
	global $db;
	switch ($parent)
	{
		case 'category':
			$query = "SELECT A.id , B.*
								FROM articles A, articles_cat B
								WHERE B.cat_id = '".$parent_id."'
								AND A.id = B.article_id";
		break;

		case 'module':
			$query = "SELECT id FROM articles
											WHERE parent_module = '".$parent_id."'";
		break;

		case '-1':
			$query = "SELECT id FROM articles";
		break;
	}
	$db->query($query);
	return $db->num_rows();
}



- Function used in : admin / articles.php

function GetArticleParents ($article_id)
{
	global $db;
	$query = "SELECT parent_module FROM articles WHERE id = '".$article_id."'";
	$db->query($query);
	$db->next_record();
	if ($db->f('parent_module') != '0')//article is child of module
	{
		return GetNameOfParent('module', $db->f('parent_module'));
	}
	else//article is child of category
	{
		$query = "SELECT cat_id FROM articles_cat WHERE article_id = '".$article_id."'";
		$db->query($query);
		$db->next_record();
		return GetNameOfParent('category', $db->f('cat_id'));
	}
}



- Function used in : admin / articles.php

function UpdateArticle ($article_category, $title, $content, $id, $short_description, $meta_keywords, $meta_description, $print)#, $dwd_pdf, $email_to_friend)
{
insert into articles table the title and content
	global $db;
from query :	dwd_pdf = '".$dwd_pdf."',
								email_to_friend = '".$email_to_friend."',
	$query = "UPDATE articles SET title = '".addslashes($title)."',
																short_description = '".addslashes($short_description)."',
																content = '".CleanImagePath(addslashes($content))."',
																meta_keywords = '".addslashes($meta_keywords)."',
																meta_description = '".addslashes($meta_description)."',
																print = '".$print."',
																parent_module = '0'
						WHERE id = '".$id."'";
	$db->query($query);
/*see where the article goes
	$parent = explode("_", $article_category);
	$parent_mod = $parent['0'];
	$parent_id = $parent['1'];
	switch ($parent_mod)
	{
/*the article has been inserted for a certain module
		case 'module':
			$query = "UPDATE articles SET parent_module = '".$parent_id."'
								WHERE id = '".$id."'";
			$db->query($query);
			$query = "DELETE FROM articles_cat WHERE article_id = '".$id."'";
			$db->query($query);
		break;
/*the article has been inserted for a certain category under a module
		case 'category':
			$query = "DELETE FROM articles_cat WHERE article_id = '".$id."'";
			$db->query($query);
			$query = "INSERT into articles_cat(article_id,
																				 cat_id)
																	VALUES('".$id."',
																				 '".$parent_id."')";
			$db->query($query);
		break;
	}
	return '0';
}

function GetPreviousOrNextArticles ($id)
{
	global $db;
	$this_articles = array();
	$query = "SELECT submision_date, parent_module
						FROM articles
						WHERE id = '".$id."'
						AND parent_module <> '0'";
	$db->query($query);
/*if article is child of module
	if ($db->num_rows() != 0)
	{
		$db->next_record();
		$parent = $db->f("parent_module");
		$submision_date = $db->f("submision_date");
/*select previous if exists - article is newer than current
		$query = "SELECT id FROM articles
							WHERE parent_module = '".$parent."'
							AND submision_date > '".$submision_date."'
							ORDER by submision_date ASC
							LIMIT 1";
		$db->query($query);
		if ($db->num_rows() != 0)
		{
			$db->next_record();
			$this_articles["previous"] = $db->f("id");
		}
/*select next if exists - article is older than current
		$query = "SELECT id FROM articles
							WHERE parent_module = '".$parent."'
							AND submision_date < '".$submision_date."'
							ORDER by submision_date DESC
							LIMIT 1";
		$db->query($query);
		if ($db->num_rows() != 0)
		{
			$db->next_record();
			$this_articles["next"] = $db->f("id");
		}
	}
/*the article is a category's child
	else 
	{
/*get parents category id
		$query = "SELECT cat_id FROM articles_cat
							WHERE article_id = '".$id."'";
		$db->query($query);
		$db->next_record();
		$category_id = $db->f('cat_id');
/*get articles submision date
		$query = "SELECT submision_date FROM articles WHERE id = '".$id."'";
		$db->query($query);
		$db->next_record();
		$submision_date = $db->f('submision_date');
/*Select previous if exists
		$query = "SELECT A.*, B.*
							FROM articles_cat as A, articles as B
							WHERE A.cat_id = '".$category_id."'
							AND A.article_id = B.id
							AND B.submision_date > '".$submision_date."'
							ORDER by B.submision_date ASC
							LIMIT 1";
		$db->query($query);
		if ($db->num_rows() != 0)
		{
			$db->next_record();
			$this_articles["previous"] = $db->f("id");
		}
/*select next if exists - article is older than current
		$query = "SELECT A.*, B.*
							FROM articles_cat as A, articles as B
							WHERE A.cat_id = '".$category_id."'
							AND A.article_id = B.id
							AND B.submision_date < '".$submision_date."'
							ORDER by B.submision_date DESC
							LIMIT 1";
		$db->query($query);
		if ($db->num_rows() != 0)
		{
			$db->next_record();
			$this_articles["next"] = $db->f("id");
		}
	}
	return $this_articles;
}*/
?>