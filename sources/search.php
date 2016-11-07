<?php
 if(isset($_POST) && array_key_exists('search_word',$_POST)) 
{ 
	 ## store POST in session 
     $_POST['search_word'] = trim($_POST['search_word']); 
     $_SESSION['cuvant_cautat2'] = $_POST['search_word']; 
     ## empty the POST variable
     $_POST = array();
     header("Location: ".ReWrite("search","search.word"));
     exit;
}

switch($action)
{
	default:
		$tpl->set_file('tpl_main', "modules/".$module.'/search_form.tpl');
		$tpl->set_var('SEARCH_ACTION',ReWrite('search','search.word'));
		$tpl->parse('MAIN', 'tpl_main', true);
	break;
		case 'word':
		 if(isset($_SESSION['cuvant_cautat2']) && count($_SESSION['cuvant_cautat2'])>0)
          {
			 $_POST['search_word'] = $_SESSION['cuvant_cautat2'];
          }

		$tpl->set_file('tpl_main', "modules/".$module.'/search_results.tpl');
		$tpl->set_block('tpl_main', 'errors', 'errorss');
		$tpl->set_block('tpl_main','rowunucabs','rowunucabss' );
		$tpl->set_block('tpl_main','results_head','results_headd' );
	
		$error = "";
		#we set the session for the serch from left part
		$tpl->parse('results_headd','');
		if((isset($_POST['search_word'])&&($_POST['search_word']!="")) )
			{
				$_SESSION['cuvant_cautat'] = addslashes($_POST['search_word']);
				if(isset($_POST['cauta_option'])&&( $_POST['cauta_option']!=""))
				{
					$_SESSION['cauta_option'] = $_POST['cauta_option'];
					if($_POST['cauta_option']=="anunturi")
					{
						$results = SearchAnunturi(addslashes($_POST['search_word']));
					}
					elseif($_POST['cauta_option']=="articole")
					{
						$results = SearchArticole(addslashes($_POST['search_word']));
					}
					elseif($_POST['cauta_option']=="cabinete")
					{
						$results = SearchCabinete(addslashes($_POST['search_word']));
					}
					#here we have advance serch, some option set
					#if we have some results let's diplay them
					if(count($results)>0)
					{
							$complete  ="";
							if(count($results)>34)
							{
									$tpl->set_var('NO_FIRM_HERE',"Pentru cuvantul cheie: <b>\"".$_SESSION['cuvant_cautat']."\"</B> sunt afisate doar primele 35 de rezultate din sectiunea <b>".ucfirst($_SESSION['cauta_option'])."</b>.Doriti alte rezultate ? Incercati si in sectiunile <b>Articole, Anunturi</b>");
							}
							else
							{
									$tpl->set_var('NO_FIRM_HERE',"Pentru cuvantul cheie: <b>\"".$_SESSION['cuvant_cautat']."\"</B> am gasit ".count($results). " rezultate in sectiunea <b>".ucfirst($_SESSION['cauta_option'])."</b>. Doriti mai multe rezultate ? Incercati si in sectiunile <b>Articole, Anunturi</b>");
							}
							$i=0;
							if($_SESSION['cauta_option']=="cabinete")
							{
								foreach($results as $ky => $val)
									{
										$tpl->set_var('NUME_FIRMA',$val['titlu'] );
										$tpl->set_var('DESCRIERE',text_best_fit($val['continut'],100));
										$main_photo = GetCabineteMainPhoto($val['id'],"cabinet");
									
										$tpl->set_var('THUMBNAIL', SITE_BASE."/sources/thumbnails.php?target=".$main_photo['image_name'].'&max_size='.$conf->admin_gallery_max.'&folder='.$val['id']);
										$tpl->set_var('URLCITESTE',Rewrite($val['url1'],$val['url2']));
										$tpl->set_var('JUDET',$val['judet']);
										
										$tpl->parse('rowdoicabss', 'rowdoicabs', true);	
										$i++;
										if(($i%2==0)||($i==count($results)))
										{
											$tpl->parse('rowunucabss', 'rowunucabs', true);	
											$tpl->parse('rowdoicabss', '');
										}
										
									}
							}
							else
							{
									foreach($results as $ky => $val)
									{
										$tpl->set_var('NUME_FIRMA',$val['titlu'] );
										$tpl->set_var('DESCRIERE',text_best_fit($val['continut'],100));
										$tpl->set_var('THUMBNAIL', SITE_BASE."/sources/thumbnails.php?target=".$val['imagine']);
										$tpl->set_var('URLCITESTE',Rewrite($val['url1'],$val['url2']));
										$tpl->set_var('JUDET',$val['judet']);
										
										$tpl->parse('rowdoicabss', 'rowdoicabs', true);	
										$i++;
										if(($i%2==0)||($i==count($results)))
										{
											$tpl->parse('rowunucabss', 'rowunucabs', true);	
											$tpl->parse('rowdoicabss', '');
										}
										
									}
							}
						#for tag clouds search
						$sql="Insert into tagclouds_search (search_word,judet) values ('".addslashes($_SESSION['cuvant_cautat'])."','".$_SESSION['cauta_option']."')";
						$db->query($sql);
					}
					else
					{
						$tpl->set_var('NO_FIRM_HERE',"Nici un rezultat pentru cuvantul cheie: <b>\"".$_SESSION['cuvant_cautat']."\"</B>. Ati cautat in categoria: <b>".$_POST['cauta_option']."</b>. Va rugam alegeti alt cuvant sau schimbati sectiunea de cautare!");
					}
				}
				else
				{
					###########################GLOBAL SEARCH###################################
					$i=1; $limit=15;
					$results_cab = SearchCabinete(addslashes($_POST['search_word']),$limit);
					$results_art = SearchArticole(addslashes($_POST['search_word']),$limit);
					$results_an = SearchAnunturi(addslashes($_POST['search_word']),$limit);
					#if no result found for the word
					if((count($results_cab)==0)&&(count($results_art)==0)&&(count($results_an)==0))
					{
						$tpl->set_var('NO_FIRM_HERE',"Nici un rezultat pentru cuvantul cheie: <b>\"".$_SESSION['cuvant_cautat']."\"</B>. <br>Va rugam redefiniti cautarea dvs.!");
					}
					else
					{	#if we have results let's parse them
						#first we parse cabinete	
						$tpl->set_var('CUVANT_CAUTAT',$_POST['search_word']);
						$search_options = array("cabinete","articole","anunturi");

						foreach($search_options as $ky2 => $val2)
						{
							/*$tpl->pparse('results_headd', '');
											$tpl->set_var('CABINETE_RESULTS',"<a href=\"http://beta.dentistonline.ro/search-word-.html#cabinete\">".count($results_cab)." cabinete</a>");
											$tpl->set_var('BIG_CAT_NAME_NR_RESULTS',"<a name=\"cabinete\">".count($results_cab)." cabinete</a>");
											foreach($results_cab as $ky => $val)
											{
												$tpl->set_var('NUME_FIRMA',$val['titlu'] );
												$tpl->set_var('DESCRIERE',text_best_fit($val['continut'],150));
												$main_photo = GetCabineteMainPhoto($val['id'],"cabinet");
												$tpl->set_var('THUMBNAIL', SITE_BASE."/sources/thumbnails.php?target=".$main_photo['image_name'].'&max_size='.$conf->admin_gallery_max.'&folder='.$val['id']);
												$tpl->set_var('URLCITESTE',Rewrite($val['url1'],$val['url2']));
												$tpl->set_var('JUDET',$val['judet']);
												$tpl->parse('rowunucabss', 'rowunucabs', true);	
											}
							$tpl->parse('results_headd', 'results_head', true);*/

							switch($val2)
							{
								case 'cabinete':
									if(count($results_cab)>0)
									{
											$tpl->set_var('CABINETE_RESULTS',"<a href=\"http://www.dentistonline.ro/search-word-.html#cabinete\" style=\"display:inline-block;\">".count($results_cab)." cabinete
											<br>
											<img src=\"../images/allstufs/cabinete.jpg\" ></a>");
											$tpl->set_var('BIG_CAT_NAME_NR_RESULTS',"<a name=\"cabinete\">".count($results_cab)." cabinete</a>");
											foreach($results_cab as $ky => $val)
											{
												if($val['titlu']!="")
												{
													$tpl->set_var('NUME_FIRMA',$val['titlu'] );
													$tpl->set_var('DESCRIERE',text_best_fit($val['continut'],150));
													$main_photo = GetCabineteMainPhoto($val['id'],"cabinet");
													$tpl->set_var('THUMBNAIL', SITE_BASE."/sources/thumbnails.php?target=".$main_photo['image_name'].'&max_size='.$conf->admin_gallery_max.'&folder='.$val['id']);
													$tpl->set_var('URLCITESTE',Rewrite($val['url1'],$val['url2']));
													$tpl->set_var('JUDET',$val['judet']);
													$tpl->parse('rowunucabss', 'rowunucabs', true);	
												}
											}
											$tpl->parse('results_headd', 'results_head', true);
											$tpl->parse('rowunucabss','');
									}
								break;
								case 'articole':
									#here we parse articles
									if(count($results_art)>0)
									{
										$tpl->set_var('ARTICOLE_RESULTS',"<a href=\"http://www.dentistonline.ro/search-word-.html#articole\" style=\"display:inline-block;padding-left:20px;\">".count($results_art)." articole 
											<br> <img src=\"../images/allstufs/articole.jpg\"></a> ");
										$tpl->set_var('BIG_CAT_NAME_NR_RESULTS',"<a name=\"articole\">".count($results_art)." articole</a>");

										foreach($results_art as $ky => $val)
												{
													$tpl->set_var('NUME_FIRMA',$val['titlu'] );
													$tpl->set_var('DESCRIERE',text_best_fit($val['continut'],150));
													$tpl->set_var('THUMBNAIL', SITE_BASE."/sources/thumbnails.php?target=".$val['imagine']);
													$tpl->set_var('URLCITESTE',Rewrite($val['url1'],$val['url2']));
													$tpl->set_var('JUDET',$val['judet']);
													$tpl->parse('rowunucabss', 'rowunucabs', true);	
											}
											$tpl->parse('results_headd', 'results_head', true);
											$tpl->parse('rowunucabss','');
										}
								break;
								case 'anunturi':
									#here we parse anunturi if we have
									if(count($results_an)>0)
									{
										$tpl->set_var('ANUNTURI_RESULTS',"<a href=\"http://www.dentistonline.ro/search-word-.html#anunturi\" style=\"display:inline-block;padding-left:20px;\">".count($results_an)." anunturi 
											<br> <img src=\"../images/allstufs/anunturi.jpg\"></a>");
										$tpl->set_var('BIG_CAT_NAME_NR_RESULTS',"<a name=\"anunturi\">".count($results_an)." anunturi</a>");
										foreach($results_an as $ky => $val)
												{
													$tpl->set_var('NUME_FIRMA',$val['titlu'] );
													$tpl->set_var('DESCRIERE',text_best_fit($val['continut'],150));
													$tpl->set_var('THUMBNAIL', SITE_BASE."/sources/thumbnails.php?target=".$val['imagine']);
													$tpl->set_var('URLCITESTE',Rewrite($val['url1'],$val['url2']));
													$tpl->set_var('JUDET',$val['judet']);
													$tpl->parse('rowunucabss', 'rowunucabs', true);	

												}
											$tpl->parse('results_headd', 'results_head', true);
											$tpl->parse('rowunucabss','');

										}
								break;
							}

						}
					}
				}
					
		}
		else
		{
			$tpl->set_var('NO_FIRM_HERE',"ATENTIE!!! Va rugam introduceti un cuvant pentru cautarea dvs.");
		}
		/*
			#let's make the search
			$search_firme = SearchFirme($_SESSION['judet_code'],$_SESSION['cat_id'],$_SESSION['cuvant_cautat'],$_SESSION['id_localitate'] ); 
			
			if(count($search_firme)<1)
			{
				$tpl->set_var('NO_FIRM_HERE',"Nici un rezulatat pentru cuvantul cheie: <b>\"".$_SESSION['cuvant_cautat']."\"</B>. Ati cautat in categoria: <b>".$_POST['cauta_option']."</b>. Va rugam alegeti alt cuvant!");
			}
			else
			{
				
				#for tag clouds search
				$sql="Insert into tagclouds_search (search_word,judet) values ('".addslashes($_SESSION['cuvant_cautat'])."','".$_SESSION['judet_code']."')";
				$db->query($sql);

				$tpl->set_var('NO_FIRM_HERE',"Pentru cuvantul cheie: <b>\"".$_SESSION['cuvant_cautat']."\"</B> am gasit ".count($search_firme). " rezultate!");

				$tpl->set_var('COUNT_CABINETE',count($search_firme));
				$tpl->set_var('PAGES',1);

				$i=0;
				foreach($search_firme as $ky => $val)
				{
					$tpl->set_var('NUME_FIRMA',$val['nume_firma'] );
					$tpl->set_var('DESCRIERE',text_best_fit($val['descriere'],100));
					
					
					$main_photo = GetCabineteMainPhoto($val['id'],"cabinet");
					$tpl->set_var('THUMBNAIL', SITE_BASE."/sources/thumbnails.php?target=".$main_photo['image_name'].'&max_size='.$conf->admin_gallery_max.'&folder='.$val['id']);
				
									
					$tpl->set_var('URLCITESTE',ReWrite("cabinete_detalii","cabinete.detalii.".$val['id']) );
					$tpl->parse('rowdoicabss', 'rowdoicabs', true);	
					$i++;
					if(($i%2==0)||($i==count($search_firme)))
					{
						$tpl->parse('rowunucabss', 'rowunucabs', true);	
						$tpl->parse('rowdoicabss', '');
					}
					
				}
				$tpl->parse('pagination_tablee', 'pagination_table', true);
				
			}*/
		
$tpl->parse('MAIN', 'tpl_main', true);
break;

case 'tag':
$tpl->set_file('tpl_main', "modules/".$module.'/tag_results.tpl');
$tpl->parse('MAIN', 'tpl_main', true);
break;

}
?>