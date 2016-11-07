<?php
/*
$array_letters=array('A','B','C','D',' E', 'F',' G', 'H', 'I', 'J', 'K', 'L', 'M',' N', 'O', 'P', 'Q', 'R', 'S', 'T','U', 'V', 'W', 'X', 'Y', 'Z');
global $db;
foreach($array_letters as $ky => $val)
{print_r($val);

	$meta_key ="litera ".$val.",dictionar medical,dictionar medicina,termeni medicali,definitii,explicatii";
	$meta_desc = "Litera ".$val.",diferiti termeni medicali ce incep cu litera ".$val;
	$query = "INSERT into dictionary_categories(cat_name, meta_keywords,meta_description,alias)
						VALUES ('".trim($val)."','".addslashes($meta_key)."','".addslashes($meta_desc)."','".trim($val)."')";
	$db->query($query);
}
exit;*/
switch ($action)
{
case 'categories':
	switch ($param1)
	{
		case 'list_categories':
			$tpl->set_file('tpl_edit', 'dictionar_medical/list_categories.tpl');
			$tpl->set_var('MAIN_TITLE', 'List dictionar medical categories');
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
			$get_module_categories = GetDictionaryArticlesCategories('-1', '');
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
		

		case 'set':
			ChangeDictionaryCategoryStatus($param2,$param3);
			$_SESSION['add_category'] = "Category status successfully changed !";
			header ('location: '.$_SERVER['HTTP_REFERER']);
			exit;
		break;

		case 'edit':
			$tpl->set_file('tpl_categories', 'dictionar_medical/edit_cat.tpl');
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
			
			$get_cat_info = GetDictionaryCategoryInfos($param2) ;
			$tpl->set_var('CAT_NAME', $get_cat_info['cat_name']);
			$tpl->set_var('META_KEYWORDS', $get_cat_info['meta_keywords']);
			$tpl->set_var('META_DESCRIPTION', $get_cat_info['meta_description']);
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
			SaveDictionaryCategory($_POST['cat_name'],$_POST['meta_keywords'],$_POST['meta_description'], $param2);
			$_SESSION['admin_info'] = "Category changes successfully saved !";
			$_SESSION['admin_info_type'] = 'info';
			header ('location:?page=dictionar_medical.categories.edit.'.$param2);
			exit;
		break;

		case 'delete':
			global $db;
			$query="Delete from dictionary_categories where id=".$param2;
			$db->query();
			$_SESSION['add_category'] = "Category deleted!";
			header ('location: '.$_SERVER['HTTP_REFERER']);
			exit;
		break;

	}
	break;



#all from here is about article 
	case 'addword':
		$tpl->set_file('tpl_add', 'dictionar_medical/add_word.tpl');
		$tpl->set_var('BGCOLOR1', 'row1');
		$tpl->set_var('BGCOLOR2', 'row2');
	
		
		$tpl->set_var('META_KEYWORDS', "DorAMatic,dictionar stomatologic,definitii stomatologie,explicatii stomatologice,medicina,termen medical,dictionar on line");
		$tpl->set_var('META_DESCRIPTION',"Definitie DorAMatic, explicatia cuvantului DorAMatic,dictionar stomatologic on line,termen medical.");
		
		$tpl->set_var('MAX_PICTURE_WIDTH',$conf->max_img_anunt );
		
		#page main title
		$tpl->set_var('MAIN_TITLE', 'Add new medical term');
		#get the parent module or category
		$tpl->set_block('tpl_add', 'cats', 'cats_block');
		$get_cats = GetDictionaryArticlesCategories('Y', '');
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
			$error[1] = 'Va rugam dati un titlu noului termen medical !';
			$title = '';
		}

		#verify content
		if (trim($_POST['continut']) == '')
		{
			$error[3] = 'Va rugam adaugati definitia,descrierea termenului medical!';
			$continut = '';
		}
		else
		{
			$continut = $_POST['continut'];
		}
		$autor = $_POST['autor'];
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
													"email"=>''.$email.'');
			header ('location: ?page=dictionar_medical.addword');
			exit;
		}
		#use function to insert article
		$user_id = "-1";
		$id_anunt =	InsertDictionaryTerm($_POST['titlu'], $_POST['continut'], $_POST['category_id'],$_POST['autor'],$_POST['email'],$_POST['meta_keywords'],$_POST['meta_description']);
		
			$_SESSION['admin_info_type'] = 'info';
			$_SESSION['admin_info'] = "Termenul a fost adaugat cu succes!";
			header('location: ?page=dictionar_medical.listwords');exit;
	break;

	case 'listwords':
		$tpl->set_file('tpl_list', 'dictionar_medical/list.tpl');
		$tpl->set_var('MAIN_TITLE', 'List medical terms');
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
		{			$cat_id ="all";	
					$param1='all';
		}
		

		if(isset($param2)&&($param2!=""))
		{			$status = $param2;		}
		else
		{			$status ="all";		$param2='all';}
		$tpl->set_var('SELECTED'.strtoupper($status),'selected' );

		$total_records = CountDictionaryTotalRecords($cat_id, $status);

		#get the modules and categories
		$tpl->set_block('tpl_list', 'categories', 'categories_block');
		$get_cats = GetDictionaryArticlesCategories('-1',  '');

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
		if ($param1 != '')
		{
			$page_name = $page_name.'.'.$param1;
		}
		if ($param2 != '')
		{
			$page_name = $page_name.'.'.$param2;
		}
		
		if(isset($_GET['start']))
		{
			$start = $_GET['start'];
		}
		
		if(!isset($start))
		{
			$start_q = 0;
			$start = 1;
			
		}
		else
		{

			$conf->admin_articles_per_page=25;
			$start_q = $conf->admin_articles_per_page*($start-1);
		}
		#Create and parse pagination
		$html_pages = AdminPagination($conf->admin_cabinete_per_page, $total_records, $page_name, $start);
		$tpl->set_var("PAGINATION", $html_pages);
		#Set blocks
		$tpl->set_block('tpl_list', 'list_articles', 'list_articles_block');
		$tpl->set_block('tpl_list', 'if_articles', 'if_articles_block');
		$tpl->set_block('tpl_list', 'if_no_articles', 'if_no_articles_block');
		#Create query limit and get the articles for displaing
		$query_limit = " LIMIT $start_q, $conf->admin_cabinete_per_page";
		
		if (($cat_id=='all')&&($status=='all'))
		{
			$articles = ListAdminDictionaryTerms('all', 'all', $query_limit);
		}
		else 
		{
			$articles = ListAdminDictionaryTerms($cat_id, $status, $query_limit);
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
				$tpl->set_var('DATE_ADDED',AdminTimeFormat($v['data_adaugarii'],'Y'));
				$tpl->set_var('DATE_MOD', AdminTimeFormat($v['data_modificarii'],'Y'));
		
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
					$tpl->set_var('USER_LINK',"?page=user.details.".$v['user_id'].'.'.$get_user_info);
				}
				
				#let check if word is unique or not
				$chheck_term_status = CheckTermStatus($v['alias']);
				if(count($chheck_term_status)<1)
				{
					$tpl->set_var('TERMEN_STATUS','Unique Term' );
				}
				else
				{
					$ids ="";
					foreach($chheck_term_status as $kyy => $vall)
					{
						$ids .= $vall['id'].", ";
					}
					$tpl->set_var('TERMEN_STATUS',$ids );
				
				}

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
		ChangeDictionaryTermStatus($param1, $param2);
		$_SESSION['admin_info'] = 'Status successfully changed !';
		$_SESSION['admin_info_type'] = 'info';
		header ('location: '.$_SERVER['HTTP_REFERER']);
		exit;
	break;

	case 'edit':
		$tpl->set_file('tpl_edit', 'dictionar_medical/edit_article.tpl');
		$tpl->set_var('BGCOLOR1', 'row1');
		$tpl->set_var('BGCOLOR2', 'row2');
		#get the category
		$tpl->set_var('MAIN_TITLE', 'Edit article');
		$get_article = GetSelectedTerm(intval($param1),'-1');
		if (isset($_SESSION['edit_article_content']))
		{
			$get_article = $_SESSION['edit_article_content'];
			unset($_SESSION['edit_article_content']);
		}
		
			$tpl->set_var('SUBMISION_DATE',$get_article['data_adaugarii']);
			$tpl->set_var('TITLU', $get_article['titlu']);
			$tpl->set_var('ID', $param1);
			$tpl->set_var('CONTINUT', $get_article['continut']);
			$tpl->set_var('AUTOR', $get_article['autor']);
			$tpl->set_var('EMAIL', $get_article['email']);
			$tpl->set_var('META_KEYWORDS', $get_article['meta_keywords']);
			$tpl->set_var('META_DESCRIPTION', $get_article['meta_description']);
			
			if($get_article['status']=='0')
			{	$tpl->set_var('EMAILACTIVARE', " Emailul de activare a articolului nu a fost trimis!!");
			}
			else
			{			$tpl->set_var('EMAILACTIVARE', " ");			}


		$tpl->set_block('tpl_edit', 'categories', 'categories_block');
		$get_cats = GetDictionaryArticlesCategories('-1',  '');
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

		$autor = $_POST['autor'];
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
													"email"=>''.$email.'');
			header ('location: ?page=dictionar_medical.edit.'.$param1);
			exit;
		}
		#use function to update article
		UpdateTerm($_POST['category_id'], $title, $continut, intval($param1),$meta_keywords, $meta_description,$autor,$email);
			$_SESSION['admin_info_type'] = 'info';
			$_SESSION['admin_info'] = "Termenul medical a fost modificat cu succes!";
			header('location: ?page=dictionar_medical.listwords');
			exit;
	break;


case 'listuserswords':
	$tpl->set_file('tpl_list', 'dictionar_medical/list_users.tpl');
		$tpl->set_var('MAIN_TITLE', 'List medical terms added by users');
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
		{			$cat_id ="all";	
					$param1='all';
		}
		

		if(isset($param2)&&($param2!=""))
		{			$status = $param2;		}
		else
		{			$status ="all";		$param2='all';}
		$tpl->set_var('SELECTED'.strtoupper($status),'selected' );

		$total_records = CountDictionaryTotalRecordsUsers($cat_id, $status);

		#get the modules and categories
		$tpl->set_block('tpl_list', 'categories', 'categories_block');
		$get_cats = GetDictionaryArticlesCategories('-1',  '');

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
		if ($param1 != '')
		{
			$page_name = $page_name.'.'.$param1;
		}
		if ($param2 != '')
		{
			$page_name = $page_name.'.'.$param2;
		}
		
		if(isset($_GET['start']))
		{
			$start = $_GET['start'];
		}
		
		if(!isset($start))
		{
			$start_q = 0;
			$start = 1;
			
		}
		else
		{

			$conf->admin_articles_per_page=25;
			$start_q = $conf->admin_articles_per_page*($start-1);
		}
		#Create and parse pagination
		$html_pages = AdminPagination($conf->admin_cabinete_per_page, $total_records, $page_name, $start);
		$tpl->set_var("PAGINATION", $html_pages);
		#Set blocks
		$tpl->set_block('tpl_list', 'list_articles', 'list_articles_block');
		$tpl->set_block('tpl_list', 'if_articles', 'if_articles_block');
		$tpl->set_block('tpl_list', 'if_no_articles', 'if_no_articles_block');
		#Create query limit and get the articles for displaing
		$query_limit = " LIMIT $start_q, $conf->admin_cabinete_per_page";
		
		if (($cat_id=='all')&&($status=='all'))
		{
			$articles = ListAdminDictionaryTermsUsers('all', 'all', $query_limit);
		}
		else 
		{
			$articles = ListAdminDictionaryTermsUsers($cat_id, $status, $query_limit);
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
				$tpl->set_var('DATE_ADDED',AdminTimeFormat($v['data_adaugarii'],'Y'));
				$tpl->set_var('DATE_MOD', AdminTimeFormat($v['data_modificarii'],'Y'));
		
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
					$tpl->set_var('USER_LINK',"?page=user.details.".$v['user_id'].'.'.$get_user_info);
				}
				
				#let check if word is unique or not
				$chheck_term_status = CheckTermStatus($v['alias']);
				if(count($chheck_term_status)<1)
				{
					$tpl->set_var('TERMEN_STATUS','Unique Term' );
				}
				else
				{
					$ids ="";
					foreach($chheck_term_status as $kyy => $vall)
					{
						$ids .= $vall['id'].", ";
					}
					$tpl->set_var('TERMEN_STATUS',$ids );
				
				}

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
}
?>