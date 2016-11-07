<?php
switch($action)
{
	default:
	$tpl->set_file('tpl_main', './modules/'.$module.'/acasa.tpl');
	#to parse cabintele stomatologice
	$tpl->set_block('tpl_main', 'cab_alldoi', 'cab_alldoii');
	$tpl->set_block('tpl_main', 'art_alldoi', 'art_alldoii');
	
	$get_all_cabinete = getHomePageCabinete();
	$tpl->set_var("USERSUBMIT",ReWrite("user","user.submit"));
	if (count($get_all_cabinete) != '0')
	{	$mm=0;
		while (list($k, $v) = each($get_all_cabinete))
		{
			$tpl->set_var('NUME_FIRMA', ucwords(strtolower(text_best_fit($v['nume_firma'],34))));
			$tpl->set_var('DESCRIERE', ucfirst(strtolower(text_best_fit($v['descriere'],115))));
			//$main_image = GetCabineteMainPhoto($v['id'],'cabinet');
			//$tpl->set_var('IMAGE', SITE_BASE."/sources/thumbnails.php?target=".$v['image_name'].'&max_size='.$conf->admin_gallery_max.'&folder='.$v['id']);
			//echo $v['image_name']."</br>";
			$tpl->set_var('IMAGE',SITE_BASE.'/images/smallimages/cabinete/'.$v['id'].'/'.$v['image_name']);	
			//$tpl->set_var('IMAGE','./images/gallery/thumbs/'.$v['id'].'/80x60/qdent3d.png');

			$tpl->set_var('URLCITESTE', ReWrite('cabinete_detalii', 'cabinete.detalii.'.$v['id']));
		
			$cat_name = Get_Dentist_Cats($v['category_id']);
			$cat_n =$cat_name[0]['name'];
			$tpl->set_var("BIGCAT",$cat_n);
			$tpl->set_var('ANUNTURIBYCAT',ReWrite("cabinete",'cabinete.'.$v['category_id']));

			$judet_code = $v['judet'];
			$get_judet_infoss = JudetIdFromCategories($judet_code,$v['category_id']);
			$judet_name=$get_judet_infoss['name'];
			$tpl->set_var('URL_CATEGORIE',ReWrite("cabinete","cabinete.".$v['category_id'].".".$get_judet_infoss['id']) );

			switch($cat_n)
			{
				case 'Cabinete stomatologice':
					$tpl->set_var('AHREFCABTITLE',"Cabinet stomatologic ".$v['nume_firma'] );
					$tpl->set_var('CATEGORY_NAME', "Cabinete stomatologice ".$judet_name);
					$tpl->set_var('AHREFCATEGORY_CAB',"Lista cabinete stomatologice din ".$judet_name);
					
				break;
				case 'Clinici Stomatologice':
					$tpl->set_var('AHREFCABTITLE',"Clinica stomatologica ".$v['nume_firma'] );
				$tpl->set_var('CATEGORY_NAME', "Clinici stomatologice ".$judet_name);
				$tpl->set_var('AHREFCATEGORY_CAB',"Lista clinici ".$judet_name);

				break;
				case 'Tehnica dentara':
					$tpl->set_var('AHREFCABTITLE',"Laborator tehnica dentara ".$v['nume_firma'] );
					$tpl->set_var('CATEGORY_NAME', "Tehnica dentara ".$judet_name);
					$tpl->set_var('AHREFCATEGORY_CAB',"Lista laboratoare tehnica dentara din ".$judet_name);
				break;
				case 'Distribuitori materiale':
					$tpl->set_var('AHREFCABTITLE',"Distribuitor materiale ".$v['nume_firma'] );
					$tpl->set_var('CATEGORY_NAME', "Distribuitori materiale ".$judet_name);
					$tpl->set_var('AHREFCATEGORY_CAB',"Lista distribuitori materiale din ".$judet_name);
				break;
				case 'Radiologie dentara':
					$tpl->set_var('AHREFCABTITLE',"Cabinet radiologie dentara ".$v['nume_firma'] );
					$tpl->set_var('CATEGORY_NAME', "Radiologie dentara ".$judet_name);
					$tpl->set_var('AHREFCATEGORY_CAB',"Lista laboratoarelor de radiologie dentara din ".$judet_name );
				break;
			}
			
		$tpl->parse('cab_alldoii', 'cab_alldoi', true);	
		
		}
	}
	$query_limit = " LIMIT 0, 9";$j=0;
	$get_last_articles = ListAdminArticles ("all", 1, $query_limit);
	foreach ($get_last_articles as $key => $val)
	{
		$tpl->set_var('TITLU_ARTICOL',$val['titlu']);
		$tpl->set_var('AHREF_ARTICOL',$val['titlu']);
		$contiunut = ucfirst(strtolower(text_best_fit(strip_tags($val['continut']),130)));
		$tpl->set_var('CONTENT_ARTICOL',$contiunut);
		$tpl->set_var('IMG_ARTICOL', SITE_BASE."/images/smallimages/articole/".$val['id']."/".$val['imagine']);
		$tpl->set_var('ARTICOL_URL',ReWrite('articole', 'articole-medicale.articol.'.$val['bigcat_id'].'.'.$val['id']));
		$tpl->parse('art_alldoii', 'art_alldoi', true);	
	}
	$tpl->parse('MAIN', 'tpl_main', true);
	break;
}
?>