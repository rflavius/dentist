<?php	

	if (isset($param1)&&(stristr($param1,'litera')!=FALSE))
	{
		$param2 = substr($param1,-1);
		$action = "litera";
	}
	elseif (isset($param1)&&(stristr($param1,'adauga')!=FALSE))
	{
		//$param2 = substr($param1,-1);
		$action = "adauga";
	}
	elseif (isset($param1)&&(stristr($param1,'insert')!=FALSE))
	{
		//$param2 = substr($param1,-1);
		$action = "insert";
	}
	elseif (isset($param1)&&(stristr($param1,'cautacuvant')!=FALSE))
	{
		//$param2 = substr($param1,-1);
		$action = "cautacuvant";
	}
	elseif (isset($param1)&&(stristr($param1,'cauta')!=FALSE))
	{
		//$param2 = substr($param1,-1);
		$action = "cauta";
	}

	elseif(isset($param1)&&(stristr($param1,'html')!=FALSE))
	{
		$param1 = GetTermIdByAlias($param1);
		$action = 'term_details';
	}

$registry->route['action'] = $action;
$registry->route['param1'] = $param1;
$registry->route['param2'] = $param2;
	
switch($action)
{

	default:
		$tpl->set_file('tpl_main', 'modules/dictionar_stomatologic/defaultpage.tpl');
		$tpl->set_block('tpl_main', 'list_categories', 'list_categories_block');
		$get_dictionary_categories = GetDictionaryArticlesCategories('-1', '');
		$i = 0;
		while (list($k, $v) = each($get_dictionary_categories))
		{
			#set colors
			$bc = ($i % 2)+1;
			$count_terms = CountDictionaryTotalRecords($v['id_cat'], '1');
			if($count_terms=='0')
			{
				$tpl->set_var('LETER_STYLE', 'disabled');
				$tpl->set_var('URL_LETTER', '#');
			}
			else
			{
				$tpl->set_var('URL_LETTER',ReWrite('dictionar_stomatologic','dictionar_stomatologic.litera.'.$v['cat_name']) );
				$tpl->set_var('LETER_STYLE', '');
			}
			
			$tpl->set_var('CAT_ID', $v['id_cat']);
			$tpl->set_var('CAT_NAME', $v['cat_name']);
			
			$tpl->set_var('URL_TITLE', "Definitii,Explicati, Dictionar medical, Litera ".$v['cat_name']);
			$tpl->parse('list_categories_block', 'list_categories', true);
			$i++;
		}
		$tpl->set_var('ADD_TERM', ReWrite('dictionar_stomatologic','dictionar_stomatologic.adauga'));
		$tpl->set_var('SEARCH_TERM', ReWrite('dictionar_stomatologic','dictionar_stomatologic.cauta'));
		$tpl->set_var('ADD_TERM_CONDITIONS',ReWrite('dictionar_stomatologic','dictionar_stomatologic.conditii'));

		// list related terms
		$tpl->set_block('tpl_main', 'related_terms', 'related_terms2');
		$terms = getDictionarRandomTerms(13);
		foreach ($terms as $key => $value)
		{
			$tpl->set_var('TERM_TITLE', $value['titlu']);
			$tpl->set_var('TERM_LINK', ReWrite('dictionar_stomatologic','dictionar_stomatologic.termen.'.$value['id']));
			$tpl->set_var('TERM_DESCR', text_best_fit(ucfirst(strtolower($value['continut'])),200));
			$tpl->parse('related_terms2', 'related_terms', true);
		}
		
		$tpl->parse('MAIN', 'tpl_main');
	break;

	case 'litera':
		$tpl->set_file('tpl_main', 'modules/dictionar_stomatologic/display_letters.tpl');
		$tpl->set_block('tpl_main', 'list_terms', 'list_termss');
		$tpl->set_block('tpl_main', 'list_categories', 'list_categories_block');

		$cat_name = $param2;
		$cat_id = GetCatId($cat_name);
		
		$get_dictionary_categories = GetDictionaryArticlesCategories('-1', '');
		$i = 0;
		while (list($k, $v) = each($get_dictionary_categories))
		{
			#set colors
			$tpl->set_var('CAT_ID', $v['id_cat']);
			$tpl->set_var('CAT_NAME', $v['cat_name']);
			$count_terms = CountDictionaryTotalRecords($v['id_cat'], '1');
			if($count_terms=='0')
			{
				$tpl->set_var('LETER_STYLE', 'disabled');
				$tpl->set_var('URL_LETTER', '#');
			}
			else
			{
				if($v['id_cat'] == $cat_id) $tpl->set_var('LETER_STYLE', 'active');
				else $tpl->set_var('LETER_STYLE', '');
				$tpl->set_var('URL_LETTER',ReWrite('dictionar_stomatologic','dictionar_stomatologic.litera.'.$v['cat_name']) );
			}
			$tpl->set_var('URL_TITLE', "Definitii,Explicati, Dictionar medical, Litera ".$v['cat_name']);
			$tpl->parse('list_categories_block', 'list_categories', true);
			$i++;
		}

		$status = 1;
		$query_limit = "LIMIT 100";
		$terms = ListDictionaryTerms($cat_id, $status, $query_limit);
		$tpl->set_var('LETTER',$cat_name );
		$tpl->set_var('NR_TEREMENI',count($terms) );
		$exceptions = array();
		foreach($terms  as $ky => $val)
		{
			$tpl->set_var('ID', $val['id']);
			$exceptions[] = $val['id'];
			$tpl->set_var('TITLU', $val['titlu']);
			$tpl->set_var('DESCR', text_best_fit(ucfirst(strtolower($val['continut'])),200));
			$tpl->set_var('URL_TITLE_TERM', "Definitie termen medical :".$val['titlu']);
			$tpl->set_var('URL_LETTER',ReWrite('dictionar_stomatologic','dictionar_stomatologic.termen.'.$val['id']) );
			$tpl->parse('list_termss', 'list_terms', true);
		}
		$tpl->set_var('ADD_TERM', ReWrite('dictionar_stomatologic','dictionar_stomatologic.adauga'));
		$tpl->set_var('SEARCH_TERM', ReWrite('dictionar_stomatologic','dictionar_stomatologic.cauta'));
		$tpl->set_var('ADD_TERM_CONDITIONS',ReWrite('dictionar_stomatologic','dictionar_stomatologic.conditii'));
		
		// list related terms
		$where = 'id NOT IN ('.implode($exceptions,",").')';
		$tpl->set_block('tpl_main', 'related_terms', 'related_terms2');
		$terms = getDictionarRandomTerms(9, $where);
		foreach ($terms as $key => $value)
		{
			$tpl->set_var('TERM_TITLE', $value['titlu']);
			$tpl->set_var('TERM_LINK', ReWrite('dictionar_stomatologic','dictionar_stomatologic.termen.'.$value['id']));
			$tpl->set_var('TERM_DESCR', text_best_fit(ucfirst(strtolower($value['continut'])),200));
			$tpl->parse('related_terms2', 'related_terms', true);
		}
		
		$tpl->parse('MAIN', 'tpl_main');
	break;

	case 'term_details':
		$tpl->set_file('tpl_main', 'modules/dictionar_stomatologic/details.tpl');
		$tpl->set_block('tpl_main', 'list_categories', 'list_categories_block');
		$get_dictionary_categories = GetDictionaryArticlesCategories('-1', '');
		$i = 0;
		$term = $param1;
		$term_details = GetSelectedTerm($term);
		$tpl->set_var('TITLE', $term_details ['titlu']);
		$tpl->set_var('CONTINUT', $term_details ['continut']);
		$cat_id = $term_details['category_id'];
		
		while (list($k, $v) = each($get_dictionary_categories))
		{
			#set colors
			$tpl->set_var('CAT_ID', $v['id_cat']);
			$tpl->set_var('CAT_NAME', $v['cat_name']);
			$count_terms = CountDictionaryTotalRecords($v['id_cat'], '1');
			if($count_terms=='0')
			{
				$tpl->set_var('LETER_STYLE', 'disabled');
				$tpl->set_var('URL_LETTER', '#');
			}
			else
			{
				if($v['id_cat'] == $cat_id) $tpl->set_var('LETER_STYLE', 'active');
				else $tpl->set_var('LETER_STYLE', '');
				$tpl->set_var('URL_LETTER',ReWrite('dictionar_stomatologic','dictionar_stomatologic.litera.'.$v['cat_name']) );
			}
			$tpl->set_var('URL_TITLE', "Definitii,Explicati, Dictionar medical, Litera ".$v['cat_name']);
			$tpl->parse('list_categories_block', 'list_categories', true);
			$i++;
		}


		$tpl->set_var('ADD_TERM', ReWrite('dictionar_stomatologic','dictionar_stomatologic.adauga'));
		$tpl->set_var('SEARCH_TERM', ReWrite('dictionar_stomatologic','dictionar_stomatologic.cauta'));
		$tpl->set_var('ADD_TERM_CONDITIONS',ReWrite('dictionar_stomatologic','dictionar_stomatologic.conditii'));
		
		// list related terms
		$db_pdo = Zend_Registry::get('database');
		$where = $db_pdo->quoteInto('id <> ?', $term);
		$tpl->set_block('tpl_main', 'related_terms', 'related_terms2');
		$terms = getDictionarRandomTerms(12, $where);
		foreach ($terms as $key => $value)
		{
			$tpl->set_var('TERM_TITLE', $value['titlu']);
			$tpl->set_var('TERM_LINK', ReWrite('dictionar_stomatologic','dictionar_stomatologic.termen.'.$value['id']));
			$tpl->set_var('TERM_DESCR', text_best_fit(ucfirst(strtolower($value['continut'])),200));
			$tpl->parse('related_terms2', 'related_terms', true);
		}
		
		$tpl->parse('MAIN', 'tpl_main');
	break;
		
		case 'adauga':
		$tpl->set_file('tpl_main', 'modules/dictionar_stomatologic/adauga.tpl');
		$tpl->set_var('AD_FORM_URL',ReWrite('dictionar_stomatologic','dictionar_stomatologic.insert') );
		$tpl->set_var('DICTIONAR_STOMATOLOGIC_URL',ReWrite('dictionar_stomatologic','dictionar_stomatologic') );
		#we have som errors to insert
		if (isset($_SESSION['add_term_array']))
		{
			foreach ($_SESSION['add_term_array'] as $key => $val)
			{
				$tpl->set_var(strtoupper($key), $val);
			}
			unset($_SESSION['add_term_array']);
		}

		#if we have information messages
		if (isset($_SESSION['errors_info']))
		{
			$tpl->set_var('MESSAGE', $_SESSION['errors_info']);
			unset($_SESSION['errors_info']);
		}

		
		$tpl->set_var('ADD_TERM', ReWrite('dictionar_stomatologic','dictionar_stomatologic.adauga'));
		$tpl->set_var('SEARCH_TERM', ReWrite('dictionar_stomatologic','dictionar_stomatologic.cauta'));
		$tpl->set_var('ADD_TERM_CONDITIONS',ReWrite('dictionar_stomatologic','dictionar_stomatologic.conditii'));
		$tpl->set_var('SECURITYID', md5(time()));
		$tpl->parse('MAIN', 'tpl_main', true);
		break;

		case 'insert':
		$error = array(); 
		$display_errors = "";
		$title = $_POST['titlu'];
		if (trim($_POST['titlu']) == '')
		{
			$display_errors .= "<li>Va rugam dati un titlu noului termen medical !</li>";
			$title = '';
		}

		#verify content
		if (trim($_POST['continut']) == '')
		{
			$display_errors .= "<li>Va rugam adaugati definitia,descrierea termenului medical!";
			$continut = '';
		}
		else
		{		$continut = $_POST['continut'];		}
		$autor = $_POST['autor'];

		if(isset($_POST['email'])&&($_POST['email']!=""))
		{	$email = $_POST['email'];

			$email_valid = ValidEmail($_POST['email']);
			if(!$email_valid)
				{	$display_errors .= "<li>Adresa de email este invalida</li>";}
		}
		else
		{	$email = "";}

				if($_POST['security_code2']=="")
		{
			$display_errors .= "<li>Ati uitat sa complectati codul de siguranta </li>";	
		}
		$check = SecurityImageGeneral($_POST['security_code2'],$_SESSION['security_code']);
		unset($_SESSION['security_code']);
			
		if(!$check)
		{
			$display_errors .= "<li>Codul de siguranta este gresit!</li>"; 
		}	
			
		#if errors exist create arrays and return to previous pages
		if ($display_errors != "")
		{
			$_SESSION['errors_info'] = $display_errors;
			$_SESSION['add_term_array'] = array("titlu" => ''.$title.'',
													"continut_termen" => ''.$continut.'',
													"autor"=>''.$autor.'',
													"email"=>''.$email.'');
			header ('location: '.ReWrite("dictionar_stomatologic","dictionar_stomatologic.adauga"));
			exit;
		}
		#use function to insert article
		$meta_keywords= $title.",dictionar stomatologic,definitii,explicatii,medicina,termen medical";
		$meta_description= "Definitie ". $title.", explicatia cuvantului ". $title.". Dictionar stomatologic on line,termeni medicali";

		$id_anunt =	InsertDictionaryTerm($_POST['titlu'], $_POST['continut'], "",$_POST['autor'],$_POST['email'],$meta_keywords,$meta_description);
		$_SESSION['errors_info'] = "<li>Termenul <B>".$_POST['titlu']."</b> a fost adaugat cu succes! Adaugati un nou termen daca doriti.</li>";
		header ('location: '.ReWrite("dictionar_stomatologic","dictionar_stomatologic.adauga"));
			
		break;

		case 'cauta':
		$tpl->set_file('tpl_main', 'modules/dictionar_stomatologic/cauta.tpl');
		$tpl->set_var('SEARCH_URL',ReWrite('dictionar_stomatologic','dictionar_stomatologic.cautacuvant') );
		$tpl->set_var('DICTIONAR_STOMATOLOGIC_URL',ReWrite('dictionar_stomatologic','dictionar_stomatologic') );
		
		#we have som errors to insert
		if (isset($_SESSION['add_term_array']))
		{
			foreach ($_SESSION['add_term_array'] as $key => $val)
			{
				$tpl->set_var(strtoupper($key), $val);
			}
			unset($_SESSION['add_term_array']);
		}

		#if we have information messages
		if (isset($_SESSION['errors_info']))
		{
			$tpl->set_var('MESSAGE', $_SESSION['errors_info']);
			unset($_SESSION['errors_info']);
		}

		
		$tpl->set_var('ADD_TERM', ReWrite('dictionar_stomatologic','dictionar_stomatologic.adauga'));
		$tpl->set_var('SEARCH_TERM', ReWrite('dictionar_stomatologic','dictionar_stomatologic.cauta'));
		$tpl->set_var('ADD_TERM_CONDITIONS',ReWrite('dictionar_stomatologic','dictionar_stomatologic.conditii'));
		$tpl->set_var('SECURITYID', md5(time()));
		$tpl->parse('MAIN', 'tpl_main', true);
		break;

		case 'cautacuvant':
		$error = array(); 
		$display_errors = "";
		$title = $_POST['titlu'];
		if (trim($_POST['titlu']) == '')
		{
			$display_errors .= "<li>Va rugam introduceti un cuvant pentru cautare!</li>";
			$title = '';
		}

		if($_POST['security_code2']=="")
		{
			$display_errors .= "<li>Ati uitat sa complectati codul de siguranta </li>";	
		}
		$check = SecurityImageGeneral($_POST['security_code2'],$_SESSION['security_code']);
		unset($_SESSION['security_code']);
		if(!$check)
		{
			$display_errors .= "<li>Codul de siguranta este gresit!</li>"; 
		}	
			
		#if errors exist create arrays and return to previous pages
		if ($display_errors != "")
		{
			$_SESSION['errors_info'] = $display_errors;
			$_SESSION['add_term_array'] = array("titlu" => ''.$title.'');
			header ('location: '.ReWrite("dictionar_stomatologic","dictionar_stomatologic.cauta"));
			exit;
		}
		$terms = ListTermsDefinitions($title);
		if(count($terms)>0)
		{

			$tpl->set_file('tpl_main', 'modules/dictionar_stomatologic/results.tpl');
			$tpl->set_block('tpl_main', 'list_terms', 'list_termss');
			$tpl->set_var('CUVANT_CAUTAT',ucfirst($title));
			$tpl->set_var('NR_RESULTS',count($terms) );
			
			foreach($terms  as $ky => $val)
			{
					$tpl->set_var('ID', $val['id']);
					$tpl->set_var('TITLU', $val['titlu']);
					$tpl->set_var('URL_TITLE_TERM', "Definitie termen medical :".$val['titlu']);
					$tpl->set_var('URL_LETTER',ReWrite('dictionar_stomatologic','dictionar_stomatologic.termen.'.$val['id']) );
					$tpl->parse('list_termss', 'list_terms', true);
			}


			$tpl->set_var('ADD_TERM', ReWrite('dictionar_stomatologic','dictionar_stomatologic.adauga'));
			$tpl->set_var('SEARCH_TERM', ReWrite('dictionar_stomatologic','dictionar_stomatologic.cauta'));
			$tpl->set_var('ADD_TERM_CONDITIONS',ReWrite('dictionar_stomatologic','dictionar_stomatologic.conditii'));
			$tpl->parse('MAIN', 'tpl_main', true);
			

		}
		else
		{

		$_SESSION['errors_info'] = "Termenul ".$_POST['titlu']." nu a fost gasit, sunteti bine venit sa il adaugati dvs.";
		header ('location: '.ReWrite("dictionar_stomatologic","dictionar_stomatologic.cauta"));
		exit;
		}
	
			
		break;
}
?>