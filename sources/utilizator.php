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
			$tpl->set_var("BGCOLOR", 'row'.$bc);
			$tpl->set_var('CAT_ID', $v['id_cat']);
			$tpl->set_var('CAT_NAME', $v['cat_name']);
			$tpl->set_var('URL_LETTER',ReWrite('dictionar_stomatologic','dictionar_stomatologic.litera.'.$v['cat_name']) );
			$tpl->set_var('URL_TITLE', "Definitii,Explicati, Dictionar medical, Litera ".$v['cat_name']);
			$tpl->parse('list_categories_block', 'list_categories', true);
			$i++;
		}
		$tpl->set_var('ADD_TERM', ReWrite('dictionar_stomatologic','dictionar_stomatologic.adauga'));
		$tpl->set_var('SEARCH_TERM', ReWrite('dictionar_stomatologic','dictionar_stomatologic.cauta'));
		$tpl->set_var('ADD_TERM_CONDITIONS',ReWrite('dictionar_stomatologic','dictionar_stomatologic.conditii'));

		$tpl->parse('MAIN', 'tpl_main', true);
	break;

		
		case 'litera':
			$tpl->set_file('tpl_main', 'modules/dictionar_stomatologic/display_letters.tpl');
			$tpl->set_block('tpl_main', 'list_terms', 'list_termss');
			$tpl->set_block('tpl_main', 'list_categories', 'list_categories_block');

			$get_dictionary_categories = GetDictionaryArticlesCategories('-1', '');
			$i = 0;
			while (list($k, $v) = each($get_dictionary_categories))
			{
				#set colors
				$bc = ($i % 2)+1;
				$tpl->set_var("BGCOLOR", 'row'.$bc);
				$tpl->set_var('CAT_ID', $v['id_cat']);
				$tpl->set_var('CAT_NAME', $v['cat_name']);
				$tpl->set_var('URL_LETTER',ReWrite('dictionar_stomatologic','dictionar_stomatologic.litera.'.$v['cat_name']) );
				$tpl->set_var('URL_TITLE', "Definitii,Explicati, Dictionar medical, Litera ".$v['cat_name']);
				$tpl->parse('list_categories_block', 'list_categories', true);
				$i++;
			}

			$cat_name = $param2;

			$cat_id = GetCatId($cat_name);
			$status = 1;
			$query_limit = "LIMIT 100";
			$terms = ListDictionaryTerms($cat_id, $status, $query_limit);
			$tpl->set_var('LETTER',$cat_name );
			$tpl->set_var('NR_TEREMENI',count($terms) );
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
		break;

		case 'term_details':
			$tpl->set_file('tpl_main', 'modules/dictionar_stomatologic/details.tpl');
			$tpl->set_block('tpl_main', 'list_categories', 'list_categories_block');
			$get_dictionary_categories = GetDictionaryArticlesCategories('-1', '');
			$i = 0;
			while (list($k, $v) = each($get_dictionary_categories))
			{
				#set colors
				//$tpl->set_var("BGCOLOR", 'row'.$bc);
				$tpl->set_var('CAT_ID', $v['id_cat']);
				$tpl->set_var('CAT_NAME', $v['cat_name']);
				$tpl->set_var('URL_LETTER',ReWrite('dictionar_stomatologic','dictionar_stomatologic.litera.'.$v['cat_name']) );
				$tpl->set_var('URL_TITLE', "Definitii,Explicati, Dictionar medical, Litera ".$v['cat_name']);
				$tpl->parse('list_categories_block', 'list_categories', true);
				$i++;
			}

			$term = $param1;
			$term_details = GetSelectedTerm($term);
			$tpl->set_var('TERM_TITLE', $term_details ['titlu']);
			$tpl->set_var('TERM_CONTINUT', $term_details ['continut']);

		$tpl->set_var('ADD_TERM', ReWrite('dictionar_stomatologic','dictionar_stomatologic.adauga'));
		$tpl->set_var('SEARCH_TERM', ReWrite('dictionar_stomatologic','dictionar_stomatologic.cauta'));
		$tpl->set_var('ADD_TERM_CONDITIONS',ReWrite('dictionar_stomatologic','dictionar_stomatologic.conditii'));
		$tpl->parse('MAIN', 'tpl_main', true);
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


	
	#===========================================List medical terms======================
	case 'listeazatermeni':
		$tpl->set_file("tpl_mesaje", "modules/utilizator/listeazatermeni.tpl");
		$tpl->set_block('tpl_mesaje', 'list_termeni', 'list_termenii');
		$tpl->set_block('tpl_mesaje','if_termeni','if_termenii' );
		$tpl->set_block('tpl_mesaje', 'if_no_termeni', 'if_no_termenii');
		$tpl->set_var('USERMESAJEDETALII',ReWrite("user","utilizator.editeazatermen") );
		$user_id = $_SESSION['userinfo']->id;
		$get_terms = GetUserTerms($user_id,"all");
		if(count($get_terms )>0)
		{
				$i=0;
				foreach($get_terms as $ky => $val)
				{
					#set colors
					$bc = ($i % 2)+1;
					$tpl->set_var("BGCOLOR",'row'.$bc);
			
					$tpl->set_var('ID', $v['id']);
					$tpl->set_var('DETALII',text_best_fit($v['continut'],150));

					$tpl->set_var('TERMEN', $v['titlu']);

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
					$tpl->set_var('DATA_PUBLICARII',TimeFormatShort($val['submision_date'] ) );
				
					$i++;
					$tpl->parse('list_termenii', 'list_termeni', true);
			}
			$tpl->parse('if_termenii', 'if_termeni', true);
		}
		else
		{	$tpl->parse('if_no_termenii', 'if_no_termeni', true);	}
	
		#if we have information messages
		if (isset($_SESSION['admin_info'])&&($_SESSION['admin_info']!=""))
		{
			$tpl->set_file('tpl_info', './admin/info/'.$_SESSION['admin_info_type'].'.tpl');
			$tpl->set_var('MESSAGE', $_SESSION['admin_info']);
			$tpl->parse('INFORMATION', 'tpl_info');
			#uset sessions
			unset($_SESSION['admin_info']);
			unset($_SESSION['admin_info_type']);
		}
		$tpl->parse("MAIN", "tpl_mesaje");
	break;
	
	case 'editeazatermen':
		$id_termen = $param1;
		$tpl->set_file("tpl_termen", "modules/utilizator/edit_termen.tpl");
		$user_id = $_SESSION['userinfo']->id;
		$get_termen = GetSelectedTerm($id_termen,$user_id);

		$tpl->set_var('SUBMISION_DATE',$get_termen['data_adaugarii']);
		$tpl->set_var('TITLU', $get_termen['titlu']);
		$tpl->set_var('ID', $param1);
		$tpl->set_var('CONTINUT', $get_termen['continut']);
		$tpl->set_var('AUTOR', $get_termen['autor']);
		$tpl->set_var('EMAIL', $get_termen['email']);

		$tpl->parse("MAIN", "tpl_termen");
	break;


}


/*

switch ($action)
{
	case 'galerie':
		$tpl->set_file("tpl_listfirm", "modules/user/galerie.tpl");
		$tpl->set_block('tpl_listfirm', 'list_firme', 'list_firmee');
		$tpl->set_block('tpl_listfirm','if_firme','if_firmes' );
		$tpl->set_block('tpl_listfirm', 'if_no_firme', 'if_no_firmee');
		$tpl->set_var('USERADDFIRM',ReWrite("user","user.addfirm") );
		$user_id = $_SESSION['userinfo']->id;
		$get_firme = GetFirme($user_id,"-1");
		if(count($get_firme )>0)
		{
			$i=0;
			foreach($get_firme as $ky => $val)
			{
				$x = ($i%2)+1;
				$tpl->set_var("BGCOLOR","row".$x);
				$tpl->set_var('NUME_FIRMA',$val['nume_firma'] );
				if($val['status']=='1')
				{		$tpl->set_var('STATUSFIRMA',"Activ" );
						$tpl->set_var('FRONTENDFIRMA',"<a href=\"".ReWrite('cabinete_detalii','cabinete.detalii.'.$val['idfirma'])."\">".$val['nume_firma']."</a>" );
				}
				else
				{	
				$tpl->set_var('STATUSFIRMA',"Inactiv" );
				$tpl->set_var('FRONTENDFIRMA',$val['nume_firma'] );
				}
	
			
				$main_image = GetCabineteMainPhoto($val['id'],'cabinet');
				if($main_image['image_name']=="")
				{	
					$main_image['image_name']="default.jpg";
				}
				$count_images = GetCabineteImages($val['id']);
				$tpl->set_var('NR_IMAGINI',count($count_images) );
				$tpl->set_var('MODIFICA_IMAGINI', ReWrite("user","user.modificaimg.". $val['id'].".".$val['nume_firma']));
				$tpl->set_var('THUMBNAIL', "./sources/thumbnails.php?target=".$main_image['image_name'].'&max_size='.$conf->admin_gallery_max.'&folder='.$val['id']);
				$tpl->set_var('IDFIRMA', $val['idfirma']);
				$tpl->parse('list_firmee', 'list_firme', true);
				$i++;
			}
				$tpl->parse('if_firmes', 'if_firme', true);
		}
		else
		{	$tpl->parse('if_no_firmee', 'if_no_firme', true);	}
	
		#if we have information messages
		if (isset($_SESSION['admin_info'])&&($_SESSION['admin_info']!=""))
		{
			$tpl->set_file('tpl_info', './admin/info/'.$_SESSION['admin_info_type'].'.tpl');
			$tpl->set_var('MESSAGE', $_SESSION['admin_info']);
			$tpl->parse('INFORMATION', 'tpl_info');
			#uset sessions
			unset($_SESSION['admin_info']);
			unset($_SESSION['admin_info_type']);
		}
		$tpl->parse("MAIN", "tpl_listfirm");
	break;

	case 'mesaje':
		$tpl->set_file("tpl_mesaje", "modules/user/mesaje.tpl");
		$tpl->set_block('tpl_mesaje', 'list_mesaje', 'list_mesajee');
		$tpl->set_block('tpl_mesaje','if_mesaje','if_mesajes' );
		$tpl->set_block('tpl_mesaje', 'if_no_mesaje', 'if_no_mesajee');
		$tpl->set_var('USERMESAJEDETALII',ReWrite("user","user.mesajedetalii") );
		$user_id = $_SESSION['userinfo']->id;
		$get_mesaje = GetMesaje($user_id,"all");
		if(count($get_mesaje )>0)
		{
					$i=0;
					foreach($get_mesaje as $ky => $val)
					{
						$x = ($i%2)+1;
						$tpl->set_var("BGCOLOR","row".$x);
						$tpl->set_var('NUME_UTILIZATOR',ucwords($val['nume_utilizator']) );
						$tpl->set_var('EMAIL',$val['email_utilizator'] );
						$tpl->set_var('SUBIECT_MESAJ',ucfirst($val['subiect']));
						$tpl->set_var('MESAJ',ucfirst(substr($val['mesaj'],0,10)));
						$tpl->set_var('DETALIIMESAJ', ReWrite('user','user.detaliimesaj.'.$val['id']));
						$tpl->set_var('DATA',TimeFormatShort($val['submision_date'] ) );
						$i++;
						$tpl->parse('list_mesajee', 'list_mesaje', true);
				}
				$tpl->parse('if_mesajes', 'if_mesaje', true);
		}
		else
		{	$tpl->parse('if_no_mesajee', 'if_no_mesaje', true);	}
	
		#if we have information messages
		if (isset($_SESSION['admin_info'])&&($_SESSION['admin_info']!=""))
		{
			$tpl->set_file('tpl_info', './admin/info/'.$_SESSION['admin_info_type'].'.tpl');
			$tpl->set_var('MESSAGE', $_SESSION['admin_info']);
			$tpl->parse('INFORMATION', 'tpl_info');
			#uset sessions
			unset($_SESSION['admin_info']);
			unset($_SESSION['admin_info_type']);
		}
		$tpl->parse("MAIN", "tpl_mesaje");
	break;
	
	case 'detaliimesaj':
		$id_msj = $param1;
		$tpl->set_file("tpl_mesaje", "modules/user/detaliimesaj.tpl");
		$user_id = $_SESSION['userinfo']->id;
		$get_mesaje = GetMesaje($user_id,$id_msj);
		foreach($get_mesaje as $ky => $val)
		{
			$x = ($i%2)+1;
			$tpl->set_var("BGCOLOR","row".$x);
			$tpl->set_var('NUME_UTILIZATOR',ucwords($val['nume_utilizator']) );
			$tpl->set_var('EMAIL',$val['email_utilizator'] );
			$tpl->set_var('SUBIECT_MESAJ',$val['subiect'] );
			$tpl->set_var('MESAJ',$val['mesaj']);
			$tpl->set_var('DETALIIMESAJ', ReWrite('user','user.detaliimesaj.'.$val['id']));
			$tpl->set_var('DATA',TimeFormatShort($val['submision_date'] ));
			$i++;
		}
		$tpl->parse("MAIN", "tpl_mesaje");
	break;

	case 'adauga':
		$tpl->set_file('tpl_main', 'modules/utilizator/adauga.tpl');
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
		echo $param2;
		if(isset($param1)&&($param1!=""))
		{			$cat_id = $param1;		}
		else
		{			$cat_id ="all";		}
		

		if(isset($param2)&&($param2!=""))
		{			$status = $param2;		}
		else
		{			$status ="all";		}
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
			$page_name = '.'.$param2;
		}
		if(!isset($start))
		{
			$start_q = 0;
			$start = 1;
		}
		else
		{
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
			$articles = ListDictionaryTerms('all', 'all', $query_limit);
		}
		else 
		{
			$articles = ListDictionaryTerms($cat_id, $status, $query_limit);
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
#===========================================List medical terms======================
	case 'listeazatermeni':
		$tpl->set_file("tpl_mesaje", "modules/utilizator/listeazatermeni.tpl");
		$tpl->set_block('tpl_mesaje', 'list_mesaje', 'list_mesajee');
		$tpl->set_block('tpl_mesaje','if_mesaje','if_mesajes' );
		$tpl->set_block('tpl_mesaje', 'if_no_mesaje', 'if_no_mesajee');
		$tpl->set_var('USERMESAJEDETALII',ReWrite("user","utilizator.editeazatermen") );
		$user_id = $_SESSION['userinfo']->id;
		$get_mesaje = GetMesaje($user_id,"all");
		if(count($get_mesaje )>0)
		{
					$i=0;
					foreach($get_mesaje as $ky => $val)
					{
						$x = ($i%2)+1;
						$tpl->set_var("BGCOLOR","row".$x);
						$tpl->set_var('NUME_UTILIZATOR',ucfirst($val['nume_utilizator']) );
						$tpl->set_var('EMAIL',$val['email_utilizator'] );
						$tpl->set_var('SUBIECT_MESAJ',ucfirst($val['subiect']));
						$tpl->set_var('MESAJ',ucfirst(substr($val['mesaj'],0,10)));
						$tpl->set_var('DETALIIMESAJ', ReWrite('user','user.detaliimesaj.'.$val['id']));
						$tpl->set_var('DATA',TimeFormatShort($val['submision_date'] ) );
						$i++;
						$tpl->parse('list_mesajee', 'list_mesaje', true);
				}
				$tpl->parse('if_mesajes', 'if_mesaje', true);
		}
		else
		{	$tpl->parse('if_no_mesajee', 'if_no_mesaje', true);	}
	
		#if we have information messages
		if (isset($_SESSION['admin_info'])&&($_SESSION['admin_info']!=""))
		{
			$tpl->set_file('tpl_info', './admin/info/'.$_SESSION['admin_info_type'].'.tpl');
			$tpl->set_var('MESSAGE', $_SESSION['admin_info']);
			$tpl->parse('INFORMATION', 'tpl_info');
			#uset sessions
			unset($_SESSION['admin_info']);
			unset($_SESSION['admin_info_type']);
		}
		$tpl->parse("MAIN", "tpl_mesaje");
	break;
}*/
?>


