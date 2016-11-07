<?php
$pachete = new Pachete_Servicii($db);

switch ($action)
{
	case 'categories':
		switch ($param1)
		{
			case 'list_categories':
			$tpl->set_file('tpl_edit', 'articles/list_categories.tpl');
			$tpl->set_var('MAIN_TITLE', 'List and add articles categories');
			#set colors
			$tpl->set_var('BGCOLOR1', 'row1');$tpl->set_var('BGCOLOR2', 'row2');
			

			$tpl->set_block('tpl_edit', 'if_add_errors', 'if_add_errors_block');
			if (isset($_SESSION['add_category']))
			{
				$tpl->set_var('ADD_ERROR', $_SESSION['add_category']);
				$tpl->parse('if_add_errors_block', 'if_add_errors', true);
				unset($_SESSION['add_category']);
			}

			#the block for the article categories for this module and the error block
			$tpl->set_block('tpl_edit', 'list_categories', 'list_categories_block');
			$tpl->set_block('tpl_edit', 'if_categories', 'if_categories_block');
			$get_module_categories = GetArticlesCategories('-1', '');
			if (count($get_module_categories) != '0')
			{
				$i = 0;
				while (list($k, $v) = each($get_module_categories))
				{
					#set colors
					$bc = ($i % 2)+1;
					$tpl->set_var("BGCOLOR", 'row'.$bc);
					$tpl->set_var('CAT_ID', $v['id_cat']);
					$tpl->set_var('CAT_NAME', $v['cat_name']);
					if ($v['active'] == 'Y')
					{
						$tpl->set_var('IMAGE', 'active.png');
						$tpl->set_var('IMAGE_TITLE', 'inactive');
					}
					else 
					{
						$tpl->set_var('IMAGE', 'inactive.png');
						$tpl->set_var('IMAGE_TITLE', 'active');
					}
					$tpl->parse('list_categories_block', 'list_categories', true);
					$i++;
				}
				$tpl->parse('if_categories_block', 'if_categories', true);
			}
			$tpl->set_var('MESSAGE', 'Add, edit and delete article module categories.');
			$tpl->parse('CATEGORY_INFORMATION', 'tpl_catinfo');
			$tpl->parse('MAIN', 'tpl_edit');
		break;
		
		case 'add':
			if ((trim($_POST['cat_name']) == "")||(!isset($_POST['cat_name'])))
			{
				$_SESSION['add_category'] = "Please provide a name for the category !";
				header ('location: ?page=articles.categories.list_categories');
				exit;
			}
			if (ArticleCategoryExists($_POST['cat_name']))
			{
				$_SESSION['add_category'] = "Category already exists for this module !";
				header ('location: ?page=articles.categories.list_categories');
				exit;
			}


			
			#no errors - add the category and return with success message
			$cat_id = InsertArticleCategory($_POST['cat_name'],$_POST['meta_keywords'],$_POST['meta_description']);

			if ($_FILES['imagine']['type'] != "" )
			{
				$extension = explode('/',$_FILES['imagine']['type']);
				$file_extension = $extension[1];
				SavePicturesCatArticles($file_extension, $cat_id);
			}
			else
			{
				SavePicturesCatArticles("default", $cat_id);
			}

			$_SESSION['add_category'] = "Category added successfully !";
			header ('location: ?page=articles.categories.list_categories');
			exit;
		break;

		case 'delete':
			$query = "DELETE FROM articles_categories WHERE id_cat = '".intval($param2)."'";
			$db->query($query);
			$_SESSION['add_category'] = "Category successfully deleted !";
			
			#lets delete the image too
			$image_path = "";

			header ('location: '.$_SERVER['HTTP_REFERER']);
			exit;
		break;

		case 'set':
			switch ($param2)
			{
				case 'active':
					$status = 'Y';
				break;

				case 'inactive':
					$status = 'N';
				break;
			}
				$query = "UPDATE articles_categories SET active = '".$status."'
									WHERE id_cat = '".$param3."'";
				$db->query($query);
			$_SESSION['add_category'] = "Category status successfully changed !";
			header ('location: '.$_SERVER['HTTP_REFERER']);
			exit;
		break;

		case 'edit':
			$tpl->set_file('tpl_categories', 'articles/edit_cat.tpl');
			$tpl->set_var('MAIN_TITLE', 'Edit Category');
			$tpl->set_block('tpl_categories', 'if_errors', 'if_errorss');
			#for the form
			$tpl->set_var('ID', $param2);
			#set colors
			$tpl->set_var('BGCOLOR1', 'row1');
			$tpl->set_var('BGCOLOR2', 'row2');
			#if we have information messages
			if (isset($_SESSION['admin_info']))
			{
				$tpl->set_file('tpl_info', 'info/'.$_SESSION['admin_info_type'].'.tpl');
				$tpl->set_var('MESSAGE', $_SESSION['admin_info']);
				$tpl->parse('INFORMATION', 'tpl_info');
				#uset sessions
				unset($_SESSION['admin_info']);
				unset($_SESSION['admin_info_type']);
				$tpl->parse('if_errorss', 'if_errors', true);
			}
			
			$get_cat_info = GetArticleCategoryInfos($param2) ;
			$tpl->set_var('CAT_NAME', $get_cat_info['cat_name']);
			$tpl->set_var('META_KEYWORDS', $get_cat_info['meta_keywords']);
			$tpl->set_var('META_DESCRIPTION', $get_cat_info['meta_description']);
			$tpl->set_var('IMAGE_CATEGORY', "../images/admin/articles_categories_image/".$get_cat_info['image_name']);

			$tpl->parse('MAIN', 'tpl_categories');
		break;

		case 'save':
			if (trim($_POST['cat_name']) == "")
			{
				$_SESSION['admin_info'] = "Please provide a name for the category !";
				$_SESSION['admin_info_type'] = 'error';
				header ('location: '.$_SERVER['HTTP_REFERER']);
				exit;
			}
			#no errors - add the category and return with success message
			SaveArticleCategory($_POST['cat_name'],$_POST['meta_keywords'],$_POST['meta_description'], $param2);
			if ($_FILES['imagine']['type'] != "" )
			{
				$extension = explode('/',$_FILES['imagine']['type']);
				$file_extension = $extension[1];
				SavePicturesCatArticles($file_extension, $param2);
				//Generate_Small_Images_Article($id_anunt);
			}
			else
			{
				SavePicturesCatArticles("default", $param2);
			}

			$_SESSION['admin_info'] = "Category changes successfully saved !";
			$_SESSION['admin_info_type'] = 'info';
			header ('location: ?page=articles.categories.list_categories');
			exit;
		break;
	}
	break;

	#all from here is about article 
	case 'add':
		$tpl->set_file('tpl_add', 'articles/add_article.tpl');
		$tpl->set_var('BGCOLOR1', 'row1');
		$tpl->set_var('BGCOLOR2', 'row2');
		$tpl->set_var('META_KEYWORDS', $conf->def_meta_keywords);
		$tpl->set_var('META_DESCRIPTION', $conf->def_meta_description);
		$tpl->set_var('MAX_PICTURE_WIDTH',$conf->max_img_anunt );
		#page main title
		$tpl->set_var('MAIN_TITLE', 'Add new article');
		#get the parent module or category
		$tpl->set_block('tpl_add', 'cats', 'cats_block');
		$get_cats = GetArticlesCategories('-1', '');
		//print_r($get_cats );
		if (count($get_cats) != '0')
		{
			while (list($k, $v) = each($get_cats))
			{
				$tpl->set_var('CATEGORY_ID', $v['id_cat']);
				$tpl->set_var('CATEGORY_NAME', $v['cat_name']);
				$tpl->parse('cats_block', 'cats', true);
			}
		}
		#if previuos info
		if (isset($_SESSION['add_article_array']))
		{
			
			foreach ($_SESSION['add_article_array'] as $key => $val)
			{
				$tpl->set_var(strtoupper($key), $val);
			}
			unset($_SESSION['add_article_array']);
		}
		#if we have information messages
		if (isset($_SESSION['admin_info']))
		{
			$tpl->set_file('tpl_info', 'info/'.$_SESSION['admin_info_type'].'.tpl');
			$tpl->set_var('MESSAGE', $_SESSION['admin_info']);
			$tpl->parse('INFORMATION', 'tpl_info');
			#uset sessions
			unset($_SESSION['admin_info']);
			unset($_SESSION['admin_info_type']);
		}
		$tpl->parse('MAIN', 'tpl_add');
	break;

	case 'insert':
		$error = array(); 
		#verify category
		if ($_POST['category_id'] == '0')
		{
			$error[0] = 'Va rugam selectati categoria dorita!';
		}
		#verify title
		$title = $_POST['titlu'];
		if (trim($_POST['titlu']) == '')
		{
			$error[1] = 'Va rugam dati un titlu articolului dvs. !';
			$title = '';
		}

		#verify content
		if (trim($_POST['continut']) == '')
		{
			$error[3] = 'Va rugam adaugati continut !';
			$continut = '';
		}
		else
		{
			$continut = $_POST['continut'];
		}
		$autor = $_POST['autor']; $tags=$_POST['tags'];
		if(isset($_POST['meta_keywords'])&&($_POST['meta_keywords']!=""))
		{
			$meta_keywords =  $_POST['meta_keywords'];
		}
		else
		{
			$meta_keywords="";
		}
		if(isset($_POST['meta_description'])&&($_POST['meta_description']!=""))
		{
			$meta_description =  $_POST['meta_description'];
		}
		else
		{
			$meta_description="";
			
		}
		
		if(isset($_POST['email'])&&($_POST['email']!=""))
		{	$email = $_POST['email'];

			$email_valid = ValidEmail($_POST['email']);
			if(!$email_valid)
				{	$error[4] = "Adresa de email este invalida";}
		}
		else
		{	$email = "";}
			
		if ($_FILES['imagine']['type']!= "")
		{
			$result =  CheckPictureItemAnunt();
			if ($result == '0')
			{	$display_errors .=  '<li>'.'Imaginea pentru articol nu are una din extensiile acceptate!'.'</li>';}
			elseif ($result == '1')
			{	$display_errors .= '<li>'. 'Imagine articol - Va rugam respectati dimensiunile maxime admise!'.'</li>';	}
		}
		
		#if errors exist create arrays and return to previous pages
		if (count($error) != 0)
		{
			$display_errors = "";
			foreach ($error as $key => $val)
			{
				$display_errors .= $val."<br />";
			}
			$_SESSION['admin_info'] = $display_errors;
			$_SESSION['admin_info_type'] = 'error';
			$_SESSION['add_article_array'] = array("titlu" => ''.$title.'',
													"continut" => ''.$continut.'',
													"meta_keywords" => ''.$meta_keywords.'',
													"meta_description" => ''.$meta_description.'',
													"autor"=>''.$autor.'',
													"email"=>''.$email.'',
													"tags"=>''.$tags.'');
			header ('location: ?page=articles.add');
			exit;
		}
		#use function to insert article
		$user_id = "-1";
		$id_anunt =	InsertAdminArticle($user_id, $_POST['titlu'], $_POST['continut'], $_POST['category_id'],$_POST['autor'],$_POST['email'],$_POST['meta_keywords'],$_POST['meta_description'],$_POST['tags']);
		#daca avem setata poza pt cabinet o salvam
			if ($_FILES['imagine']['type'] != "" )
			{
				$extension = explode('/',$_FILES['imagine']['type']);
				$file_extension = $extension[1];
				SavePicturesArticles($file_extension, $id_anunt,"backend" );
				Generate_Small_Images_Article($id_anunt);
			}
			else
			{
				SavePicturesArticles("default", $id_anunt,"backend" );
			}
			
			$_SESSION['admin_info_type'] = 'info';
			$_SESSION['admin_info'] = "Articolul a fost adaugat cu succes!";
			header('location: ?page=articles.list');exit;
	break;

	case 'list':

		$tpl->set_file('tpl_list', 'articles/list.tpl');
		$tpl->set_var('MAIN_TITLE', 'List articles');
		#if we have information messages
		if (isset($_SESSION['admin_info']))
		{
			$tpl->set_file('tpl_info', 'info/'.$_SESSION['admin_info_type'].'.tpl');
			$tpl->set_var('MESSAGE', $_SESSION['admin_info']);
			$tpl->parse('INFORMATION', 'tpl_info');
			#uset sessions
			unset($_SESSION['admin_info']);
			unset($_SESSION['admin_info_type']);
		}

		if(isset($param1)&&($param1!=""))
		{			$cat_id = $param1;		}
		else
		{			$cat_id ="all";		}

		if(isset($param2)&&($param2!=""))
		{			$status = $param2;		}
		else
		{			$status ="all";		}

		$total_records = CountArticlesTotalRecords($cat_id, $status);

		#get the modules and categories
		$tpl->set_block('tpl_list', 'categories', 'categories_block');
		$get_cats = GetArticlesCategories('-1',  '');

		if (count($get_cats) != '0')
		{
			while (list($key, $val) = each($get_cats))
			{
				$tpl->set_var('SELECTED_CAT', '');
				if (isset($cat_id) && $cat_id == $val['id_cat'])
				$tpl->set_var('SELECTED_CAT', 'selected');

				$tpl->set_var('CATEGORY_ID', $val['id_cat']);
				$tpl->set_var('CATEGORY_NAME', $val['cat_name']);
				$tpl->parse('categories_block', 'categories', true);
			}
		}

		#articles count
		$tpl->set_var('COUNT_ARTICLES', $total_records);
		$pages_number = ceil($total_records/$conf->admin_cabinete_per_page);
		$tpl->set_var("PAGES", $pages_number);
		#create de pagination page_name
		
		$page_name = $module.'.'.$action;
		//var_dump($page_name);
		if ($param1 != '')
		{
			$page_name = $page_name.'.'.$param1;
		}
		if ($param2 != '')
		{
			$page_name .= '.'.$param2;
		}
		if(isset($_GET['start'])&&($_GET['start']!=""))
		{
			$start=$_GET['start'];
		}
		if(!isset($start))
		{
			$start_q = 0;
			$start = 1;
		}
		else
		{
			$start_q = $conf->admin_cabinete_per_page*($start-1);
		}
		if(isset($_GET['displaymode'])&&($_GET['displaymode']!=""))
		{
				$dispmode = $_GET['displaymode'];
		}
		 else
		{
			$dispmode = "data-data_adaugarii-DESC";
		}
		#Create and parse pagination
		$html_pages = AdminPaginationCabineteAnuntArticole($conf->admin_cabinete_per_page, $total_records, $page_name, $start,$dispmode);
		$tpl->set_var("PAGINATION", $html_pages);
		$tpl->set_var("PAGE_NAME",$page_name );
		
		#Set blocks
		$tpl->set_block('tpl_list', 'list_articles', 'list_articles_block');
		$tpl->set_block('tpl_list', 'if_articles', 'if_articles_block');
		$tpl->set_block('tpl_list', 'if_no_articles', 'if_no_articles_block');
		#Create query limit and get the articles for displaing
		$query_limit = " LIMIT $start_q, $conf->admin_cabinete_per_page";
		if (($cat_id=='all')&&($status=='all'))
		{
			$articles = ListAdminArticles('all', 'all', $query_limit);
		}
		else 
		{
			$articles = ListAdminArticles($cat_id, $status, $query_limit);
		}
		if (count($articles) != '0')
		{
			$i = 0;
			while (list($k, $v) = each($articles))
			{
				#set colors
				$bc = ($i % 2)+1;
				$tpl->set_var("BGCOLOR",'row'.$bc);
			
				if($v['data_adaugarii']== date("Y-m-d")||(substr($v['data_modificarii'],0,10)== date("Y-m-d")))
				{	$tpl->set_var("BGCOLOR", "today_add"); }
				
				$tpl->set_var('ID', $v['id']);
				$tpl->set_var('CONTENT',text_best_fit($v['continut'],150));
				$tpl->set_var('TITLU', $v['titlu']);
				$tpl->set_var('LINK_TO_ARTICLE',  ReWrite('articole', 'articole-medicale.articol.'.$v['bigcat_id'].'.'.$v['id']));
				$tpl->set_var('THUMBNAILS', "../sources/thumbnails.php?target=".$v['imagine'].'&max_size='.$conf->admin_gallery_max.'&articles=yes');
				$tpl->set_var('NR_VISITS',$v['nr_visits']);
				if($v['user_id']=="-1")
				{
					$tpl->set_var('USER',"admin" );
					$tpl->set_var('USER_ID',"-1");
				}
				else
				{
					$get_user_info = GetUser($v['user_id']);
					$tpl->set_var('USER',$get_user_info );
					$tpl->set_var('USER_ID',$v['user_id'] );
					$user_pachet = $pachete->getTipPromovareByUser($v['user_id']);
					$get_tip_promovare = "GRATUIT";
					if(is_array($user_pachet))
					{
						
						$pkInfo = $pachete->getPachetInfo($user_pachet['pachet']);
						$get_tip_promovare = $pkInfo['name']." - ".$user_pachet['pret']." RON";
					}
					$tpl->set_var('LEVEL',$get_tip_promovare);
				}
				$tpl->set_var('DATE_ADDED',AdminTimeFormat($v['data_adaugarii'],'Y'));
				$tpl->set_var('DATE_MOD', AdminTimeFormat($v['data_modificarii'],'Y'));
		
				if ($v['status'] == '1')
				{
					$tpl->set_var('IMAGE', 'active.png');
					$tpl->set_var('IMAGE_TITLE', 'inactive');
				}
				else 
				{
					$tpl->set_var('IMAGE', 'inactive.png');
					$tpl->set_var('IMAGE_TITLE', 'active');
				}
			
				$tpl->parse('list_articles_block', 'list_articles', true);
				$i++;
			}
			$tpl->parse('if_articles_block', 'if_articles', true);
		}
		else 
		{
			$tpl->parse('if_no_articles_block', 'if_no_articles', true);
		}
		$tpl->parse('MAIN', 'tpl_list');
	break;

	case 'set':
		ChangeArticleStatus($param1, $param2);
		$_SESSION['admin_info'] = 'Status successfully changed !';
		$_SESSION['admin_info_type'] = 'info';
		header ('location: '.$_SERVER['HTTP_REFERER']);
		exit;
	break;

	case 'edit':
		$tpl->set_file('tpl_edit', 'articles/edit_article.tpl');
		$tpl->set_var('BGCOLOR1', 'row1');
		$tpl->set_var('BGCOLOR2', 'row2');
		#get the category
		$tpl->set_var('MAIN_TITLE', 'Edit article');
		$get_article = GetSelectedArticle(intval($param1));

		//print_r($get_article);
		if (isset($_SESSION['edit_article_content']))
		{
			$get_article = $_SESSION['edit_article_content'];
			unset($_SESSION['edit_article_content']);
		}
		
			$tpl->set_var('SUBMISION_DATE',$get_article['data_adaugarii']);
			$tpl->set_var('BIG_CAT_ID',$get_article ['category_id']);
			$tpl->set_var('TITLU', $get_article['titlu']);
			$tpl->set_var('ID', $param1);
			$tpl->set_var('CONTINUT', $get_article['continut']);
			$tpl->set_var('AUTOR', $get_article['autor']);
			$tpl->set_var('TAGS', $get_article['tags']);
			$tpl->set_var('EMAIL', $get_article['email']);

			$tpl->set_var('NR_VISTS_ART', $get_article['nr_visits']);

			$tpl->set_var('USER_ID',$get_article['user_id'] );
			$tpl->set_var('META_KEYWORDS', $get_article['meta_keywords']);
			$tpl->set_var('META_DESCRIPTION', $get_article['meta_description']);
			$tpl->set_var('NUME_IMAGINE',$get_article['imagine']);
			$tpl->set_var('THUMBNAIL', "../sources/thumbnails.php?target=".$get_article['imagine'].'&max_size='.$conf->admin_gallery_max.'&articles=yes');
			$filename = '../images/smallimages/articole/'.$param1.'/'.$get_article['imagine'];
			if (!file_exists($filename)) 
			{
				echo '<img src="http://www.dentistonline.ro/upload_js/resize_image_thumb.inc.php?what_to_resize=articole&width=80&height=80&cropratio=1:1&firma_id='.$param1.'&image=//images/users_articole/'.$get_article['imagine'].'">';
				
			}

			if($get_article['status']=='0')
			{	$tpl->set_var('EMAILACTIVARE', " Emailul de activare a articolului nu a fost trimis!!");
			}
			else
			{			$tpl->set_var('EMAILACTIVARE', " ");			}


		$tpl->set_block('tpl_edit', 'categories', 'categories_block');
		$get_cats = GetArticlesCategories('-1',  '');
		if (count($get_cats) != '0')
		{
			while (list($key, $val) = each($get_cats))
			{
				$tpl->set_var('SELECTED_CAT', '');
				if ($get_article['category_id'] == $val['id_cat'])
				$tpl->set_var('SELECTED_CAT', 'selected');
				
				if(isset($_SESSION['add_article_array'])&&($_SESSION['add_article_array']!=""))
				{
					if($_SESSION['add_article_array']['category_id']==$val['id_cat'])
					{
							$tpl->set_var('SELECTED_CAT', 'selected');
					}
				}

				$tpl->set_var('CATEGORY_ID', $val['id_cat']);
				$tpl->set_var('CATEGORY_NAME', $val['cat_name']);
				$tpl->parse('categories_block', 'categories', true);
			}
		}

		### get artcol file stuff
		$art_file = getArticolServiciiFile($param1);
		if (is_array($art_file) )
		{
			$file_type = explode(".",$art_file['name']);
			$file_ext = $file_type[count($file_type)-1];
			$tpl->set_var('ARTICOL_FILE', "<A HREF='?page=user.downloadarticolfile.".$param1."'><b>".$art_file['name']."</b>&nbsp;&nbsp;&nbsp;&nbsp; <img src='../images/".$file_ext.".jpg'></A><br><i>Fisierul a fost adaugat in: </i>".TimeFormatShort($art_file['date'])); 
		}
		else 
		{
			$tpl->set_var('ARTICOL_FILE',"Nu aveti nici un fisier adaugat !" ); 
		}
		
		#lets get the related article for this one
		$tpl->set_block('tpl_edit', 'articole_related', 'articole_related_block');
		if(isset($get_article['related'])&&($get_article['related']!=""))
			{
				$tpl->set_var('ALL_RELATED', $get_article['related']);
				$articole_related = explode(",",$get_article['related']);
				foreach($articole_related as $ky => $val)
				{
					if($val!="")
					{
							$get_art_det= GetArticole(-1,intval($val));
							$get_related = $get_art_det[0]['related'];
							if(strpos($get_related,$param1)!==false)
							{
								$tpl->set_var('REALATED_ALREADY', "Yes");
							}else
							{
								$tpl->set_var('REALATED_ALREADY', "No");
							}
							$tpl->set_var('REALATED_ID', $get_art_det[0]['id']);		
							$tpl->set_var('ARTICLE_RELATED_LINK',  ReWrite('articole', 'articole-medicale.articol.'.$get_art_det[0]['category_id'].'.'.$get_art_det[0]['id']));
							$tpl->set_var('ARTICLE_REALATED_TITLE',$get_art_det[0]['titlu'] );					
							$tpl->parse('articole_related_block', 'articole_related', true);
					}
					
				}
			}

		if (isset($_SESSION['add_article_array']))
			{
				foreach ($_SESSION['add_article_array'] as $key => $val)
				{
					$tpl->set_var(strtoupper($key), $val);
				}
				unset($_SESSION['add_article_array']);
			}
		#if we have information messages
		if (isset($_SESSION['admin_info']))
		{
			$tpl->set_file('tpl_info', 'info/'.$_SESSION['admin_info_type'].'.tpl');
			$tpl->set_var('MESSAGE', $_SESSION['admin_info']);
			$tpl->parse('INFORMATION', 'tpl_info');
			#uset sessions
			unset($_SESSION['admin_info']);
			unset($_SESSION['admin_info_type']);
		}
		$tpl->parse('MAIN', 'tpl_edit');
	break;

	case 'save_edit':
		
		$error = array(); 
		#verify category
		if ($_POST['category_id'] == '0')
		{		$error[0] = 'Va rugam selectati categoria dorita!';	}
		#verify title
		$title = $_POST['titlu'];
		if (trim($_POST['titlu']) == '')
		{	$error[1] = 'Va rugam dati un titlu articolului dvs. !';
			$title = '';
		}
		#verify content
		if (trim($_POST['continut']) == '')
		{
			$error[3] = 'Va rugam adaugati continut !';
			$continut = '';
		}
		else
		{			$continut = $_POST['continut'];		}

		$autor = $_POST['autor']; $tags=$_POST['tags'];
		if(isset($_POST['meta_keywords'])&&($_POST['meta_keywords']!=""))
		{			$meta_keywords =  $_POST['meta_keywords'];		}
		else
		{			$meta_keywords=$conf->meta_keywords;		}

		if(isset($_POST['meta_description'])&&($_POST['meta_description']!=""))
		{
			$meta_description =  $_POST['meta_description'];
		}
		else
		{		$meta_description=$conf->meta_description;		}

		
		if(isset($_POST['email'])&&($_POST['email']!=""))
		{	$email = $_POST['email'];

			$email_valid = ValidEmail($_POST['email']);
			if(!$email_valid)
				{	$error[4] = "Adresa de email este invalida";}
		}
		else
		{	$email = "";}
			$continut=str_replace("../","http://www.dentistonline.ro/",$continut);
			//print_r($continut);exit;
		if ($_FILES['imagine']['type']!= "")
		{
			$result =  CheckPictureItemAnunt();
			if ($result == '0')
			{	$display_errors .=  '<li>'.'Imaginea pentru articol nu are una din extensiile acceptate!'.'</li>';}
			elseif ($result == '1')
			{	$display_errors .= '<li>'. 'Imagine articol - Va rugam respectati dimensiunile maxime admise!'.'</li>';	}
		}
		$user_id = $_POST['user_id'];
			#we check if we hav a pdf, word for our erticle
		if($_FILES['articol_file']['type']!="")
		{
			$result = CheckArticolFile();
			if ($result == '0')
			{
				$display_errors.= '<li>Extensia fisierului nu este acceptata ! Va rugam sa adaugati doar fisier PDF sau Microsoft Office.</li>';
			}
		}
		
		#if errors exist create arrays and return to previous pages
		if (count($error) != 0)
		{
			$display_errors = "";
			foreach ($error as $key => $val)
			{
				$display_errors .= $val."<br />";
			}
			$_SESSION['admin_info'] = $display_errors;
			$_SESSION['admin_info_type'] = 'error';
			$_SESSION['add_article_array'] = array(
			"category_id" => ''.$_POST['category_id'].'',										
			"titlu" => ''.$title.'',
													"continut" => ''.$continut.'',
													"meta_keywords" => ''.$meta_keywords.'',
													"meta_description" => ''.$meta_description.'',
													"autor"=>''.$autor.'',
													"email"=>''.$email.'',
													"tags"=>''.$tags.'');
			header ('location: ?page=articles.edit.'.$param1);
			exit;
		}
		#use function to update article
		UpdateAdminArticle($_POST['category_id'], $title, $continut, intval($param1),$meta_keywords, $meta_description,$autor,$email,$tags);
		$id_articlol=$param1;
		if ($_FILES['imagine']['type'] != "" )
		{
			$extension = explode('/',$_FILES['imagine']['type']);
			$file_extension = $extension[1];//echo "extenis:".$file_extension;
			SavePicturesArticles($file_extension, $id_articlol,"backend" );
		}
		### save article pdf,doc file !!!
		if($_FILES['articol_file']['type']!="")
			{
				saveArticolPdfFile($param1);
			}

		#modificam numele imagini doar daca e diferit de ce e in baza de date
		if ($_POST['nume_img_vechi']!= $_POST['nume_imagine'])
		{
			$_POST['nume_imagine']= GenerateImageNameArticles($_POST['nume_imagine']);
			Update_Image_Name_Articles($id_articlol,addslashes($_POST['nume_imagine']),addslashes($_POST['nume_img_vechi']));	
		}
		Generate_Small_Images_Article($id_articlol);
		
		$_SESSION['admin_info_type'] = 'info';
		$_SESSION['admin_info'] = "Articolul a fost modificat cu succes!";
		//header('location: ?page=articles.list');
		//exit;
		header ('location: ?page=articles.edit.'.$param1);
		exit;
	break;

	case 'move':
		$get_article = GetSelectedArticle(intval($param1));
		$get_has_cab = GetFirme($param2,"-1");
		foreach($get_has_cab  as $ky => $val)
		{
			$judet = $val['judet'];
			$localitate = $val['nume_loc_sector'];
			$category_id = $val['category_id'];
		}
		//print_r($get_article );exit;
		MoveArticleToAnunturi($get_article,$category_id,$judet,$localitate);//print_R($get_article);exit;
		$_SESSION['admin_info_type'] = 'info';
		$_SESSION['admin_info'] = "Articolul a fost mutat la anunturi cu succes!";
		header('location: '.$_SERVER['HTTP_REFERER']);exit;
	break;
	
	case 'sendemail':
		$id_article = $param1;
		$user_id = $param2;
		$CustomHeaders = '';
		$bigcat_id = $param3;

		$linkfirma = ReWrite('articole', 'articole-medicale.articol.'.$bigcat_id.'.'.$id_article);

		$Sender = $conf->contact_recipient;
		if(!isset($_POST['emaill'] )||($_POST['emaill'] ==""))
		{			$Recipiant = GetAutorEmail($user_id);		}
		else
		{			$Recipiant = $_POST['emaill'] ;		}
		
		
		$text = GetFileContent("../templates/emails/articole/".$_POST['emailform'].".tpl");
		switch($_POST['emailform'])
		{
			
			case 'articol_activat':
				$text = str_replace("%NUMEPERSOANA%",	$_POST['autorr'] , $text);
				$text = str_replace("%NUMEFIRMA%",ucfirst($_POST['titluu']),$text);
				$text = str_replace("%DATAEXPIRARII%",date("d/m/Y", mktime(0, 0, 0, date("m")+6, date("d"), date("Y"))),$text);
				$text = str_replace("%LINKFIRMA%",$linkfirma,$text);
				$Subject = "Articolul ".ucfirst($_POST['titluu'])." este activ pe DentistOnline.ro";	
				$_SESSION['submit_errors'] = "<li>Emailul de activare a articolului a fost trimis cu succes!</li>";
				$query = "Update articles set status='1' Where id='".$param1."'";
				$db->query($query);
			break;
		
			case 'articol_dezactivat':
					$text = str_replace("%NUMEPERSOANA%",$_POST['autorr'], $text);
					$text = str_replace("%NUMEFIRMA%",ucfirst($_POST['titluu']),$text);
					$Subject ="Articolul ".ucfirst($_POST['titluu'])." este inactiv pe DentistOnline.ro";
					$_SESSION['submit_errors'] = "<li>Emailul de dezactivare a articolului a fost trimis cu succes!</li>";
					$query="Update articles set status='0' Where id='".$param1."'";
					$db->query($query);
			break;
		}
		
		$message = new Email($Recipiant, $Sender, $Subject, $CustomHeaders);
		$message->SetHtmlContent($text);
		if (ValidHeader($Sender))
		{
			$message->Send();
		}
		
		header('location: ?page=articles.edit.'.$param1.".".$param2);
		exit;
		
	break;

	case 'related':
		switch($param1)
		{
				case 'delete':
					$article_id = $param3;
					$article_related = $param2;
					$get_article = GetSelectedArticle(intval($article_id ));
					$curent_related = $get_article['related'];
					$new_related = str_replace($article_related,",",$curent_related);
					$new_related = str_replace(",,","",$new_related);
					$sql = "Update articles set related ='".$new_related."' where id='".$article_id."'";
					$db->query($sql);
					$_SESSION['admin_info_type'] = 'info';
					$_SESSION['admin_info'] = "Related article was successfully removed!";
					header('location: ?page=articles.edit.'.$article_id);
								
				break;

				case 'add':
					if(isset($param3)&&($param3!=""))
					{
						$article_related = $param3;
						$article_id = $param2;
						$return = $param3;
					}
					else
					{
							$article_related = $_POST['new_related'];
							$article_id = $param2;
							$return = $param2;
					}

					$get_article = GetSelectedArticle(intval($article_id ));
					$curent_related = $get_article['related'];
					$new_related = $article_related.",".$curent_related;
				
					$sql = "Update articles set related ='".$new_related."' where id='".$article_id."'";
					$db->query($sql);

					$_SESSION['admin_info_type'] = 'info';
					$_SESSION['admin_info'] = "Related article was successfully add!";
					header('location: ?page=articles.edit.'.$return);
					
				break;
		}
		
	break;

	case 'add_redirect':
		$article_id = $param1;
		$get_article = GetSelectedArticle(intval($article_id ));
		$current_link_art = ReWrite('articole', 'articole-medicale.articol.'.$get_article['category_id'].'.'.$article_id);
		$alias = explode('/',$current_link_art );
		$old_link = "articole-medicale/Stomatologie/".$alias[5];
		$insert_to_redirect_links = InsertToRedirectLinks($old_link,$current_link_art );
		
			
		$_SESSION['admin_info_type'] = 'info';
		$_SESSION['admin_info'] = "The redirection has been made!";
		header('location: ?page=articles.edit.'.$article_id );

	break;
}
?>