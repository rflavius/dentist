<?php
#Use $tpl->parse("OUTPUT", "tpl_index"); so the script can catch all the
#array keys from $tpl->get_vars(); so we have all the menus and latest blocks

$tpl->parse("OUTPUT", "tpl_index");

#get all the variables that the template class uses for the menus and last items boxes
$all_tamplate_variables = $tpl->get_vars();
#Display the Preview boxes
$the_main_content = '';
#search for the main block where the content will be parsed

foreach ($all_tamplate_variables as $key => $val)
{
	if ($key == 'OUTPUT'){$the_main_content = $val;}
}
#get the modules that can have a latest block
$get_modules_tags = GetTheModulesBoxes();
#search for the tags
$display_blocks = array();
foreach ($get_modules_tags as $key => $val)
{
	if (strpos($the_main_content, $val)){$display_blocks[] = $val;}
}
#if our array is not empty we should display the preview boxes
if (count($display_blocks) != 0)
{
	#get the modules ids
	$i = 0;
	foreach ($display_blocks as $key => $val)
	{
		$get_modules_ids[$i] = str_replace("LATEST_BLOCK_", "", $val);
		$i++;
	}

	
	#include the modules for the blocks preview
	$tpl->set_file('tpl_box', 'box.tpl');
	
	#LAST CABINETE ADDED ON SITE
	#block and stuffs for last cabinetes added on website
	$tpl->set_block('tpl_box', 'list_last_oferte', 'list_last_ofertee');
	$get_last_12 = GetLastOferte("Limit 0,10");
	foreach ($get_last_12 as $key => $val)
	{
			$tpl->set_var('TITLU_OFERTA',$val['nume_firma']);
			$tpl->set_var('AHREF_OFERTA',$val['nume_firma']);
			$tpl->set_var('OFERTA_URL',ReWrite('cabinete_detalii','cabinete.detalii.'.$val['id']));
			$tpl->parse('list_last_ofertee', 'list_last_oferte', true);
	}

	#LAST EVENTS ADDED ON SITE
	#block and stuffs for last events added on website
	$tpl->set_block('tpl_box', 'list_last_eveniment', 'list_last_evenimente');
	$get_last_12 = GetNews(0,5);
	foreach ($get_last_12 as $key => $val)
		{
			$tpl->set_var('TITLU_EVENIMENT',$val['title']);
			$tpl->set_var('AHREF_EVENIMENT',$val['title']);
			$tpl->set_var('EVENIMET_URL',ReWrite('news','news.detalii.'.$val['id']));
			$tpl->parse('list_last_evenimente', 'list_last_eveniment', true);
		}
	
	
	

	#block and stuffs for last anounces added on website
	$tpl->set_block('tpl_index', 'list_anunturi_homepg', 'list_anunturi_homepgg');
	$tpl->set_block('tpl_box', 'list_anunturi_homepg2', 'list_anunturi_homepgg2');
	
	#ANUNTURI RECOMANDATE
	#let's parse in the right part only anunturi from who pay,has an pachet business or premium by rand mode
	$get_anunturi_right_part = GetAnunturiMainPagePaid("all"," limit 0,3 ");
	foreach ($get_anunturi_right_part as $key => $val)
	{
		$tpl->set_var('TITLUANUNT',$val['titlu']);
		$tpl->set_var('CONTINUT',text_best_fit($val['continut'],80));
		$tpl->set_var('AHREF_ANUNTURI',"Anunt :".$val['titlu'] );
		$tpl->set_var('IMAGINEANUNT',SITE_BASE."/images/smallimages/anunturi/".$val['imagine']);
		$tpl->set_var('IDANUNT',$val['id']);
		$tpl->set_var('CITESTEANUNT',ReWrite('anunturi_detalii','anunturi.detalii.'.$val['id']));
		$tpl->parse('list_anunturi_homepgg', 'list_anunturi_homepg', true);
	}
	
	
	#ANUNTURI MAIN PAGE 
	$getanunturi = GetAnunturiMainPage("all"," limit 0,4 ");
	if (count($getanunturi ) > 0)
	{
		foreach ($getanunturi as $key => $val)
		{
			$tpl->set_var('TITLUANUNT',$val['titlu']);
			$tpl->set_var('CONTINUT',text_best_fit($val['continut'],80));
			$tpl->set_var('AHREF_ANUNTURI',"Anunt :".$val['titlu'] );
			$tpl->set_var('IMAGINEANUNTLEFT',SITE_BASE."/images/smallimages/anunturi/".$val['imagine']);
			$tpl->set_var('IDANUNT',$val['id']);
			$tpl->set_var('CITESTEANUNT',ReWrite('anunturi_detalii','anunturi.detalii.'.$val['id']));
			$tpl->parse('list_anunturi_homepgg2', 'list_anunturi_homepg2', true);
		}
	}
	
	###################################
	### right side articles for the abonament package !!!
	$tpl->set_file('tpl_privilegiat', './modules/acasa/articole_privilegiate.tpl');
	$tpl->set_block('tpl_privilegiat', 'list_recomandam_articole', 'list_recomandam_articole2');
	$recomandam_articles = getRecomandArticles();
	if(is_array($recomandam_articles))
	{
		foreach($recomandam_articles as $ky => $val)
		{
			$tpl->set_var('RECOMAND_ART', $val['titlu']);
			$tpl->set_var('RECOMAND_ART_IMG', $val['imagine']);
			$tpl->set_var('RECOMAND_ART_DESCR', substr($val['continut'],0,126));
			$tpl->set_var('RECOMAND_ART_LINK', ReWrite('articole', 'articole-medicale.articol.'.$val['bigcat_id'].'.'.$val['id']));

			$tpl->parse('list_recomandam_articole2', 'list_recomandam_articole',true);
		}
	}
	else
	{
		$tpl->parse('list_recomandam_articole2', '');
	}

	$tpl->parse('ARTICOLE_PRIVILEGIATE','tpl_privilegiat');

	###################################
	### right side recomandam banner !!!!
	$tpl->set_file('tpl_recbanner', 'recomandam_banner.tpl');
	$tpl->set_block('tpl_recbanner', 'list_recomandam_banner', 'list_recomandam_banner2');
	$banners = getRecomandBanner();
	//var_dump($banners);
	if(is_array($banners))
	{
		foreach($banners as $ky => $val)
		{
			$tpl->set_var('BANNER_CAB_LINK', ReWrite('cabinete_detalii', 'cabinete.detalii.'.$val['cabinet_id']));
			updateCabinetRecomandBannerView($val['id']);
			$tpl->set_var('BANNER_CAB', $val['nume_firma'] );
			$tpl->set_var('BANNER_PATH',SITE_BASE."/sources/thumbnails.php?target=".$val['name']."&max_size=210.'&banner=yes" );
			$tpl->parse('list_recomandam_banner2','list_recomandam_banner', true);
		}
		
	}
	else
	{
		$tpl->parse('list_recomandam_banner2', '');
	}
	$tpl->parse('RECOMANDAM_BANNER', 'tpl_recbanner');

	#tag clouds by search
	/*$tpl->set_block('tpl_box', 'tags', 'tags_block');
	$tags = GetUniqueASearchAppearance();
	$max_size = 250; // max font size in %
	$min_size = 80; // min font size in %
	foreach($tags as $ky => $val)
	{
		$tags_appearance[$ky] = $val['appearance'];
	}
	
	$max_appearance = max(array_values($tags_appearance));
	$min_appearance = min(array_values($tags_appearance));
	$spread = $max_appearance - $min_appearance;
		if (0 == $spread)
			{ $spread = 1;}
	$step = ($max_size - $min_size)/($spread);
	foreach($tags as $ky => $val)
	{
		$tpl->set_var("CLOUDYTAGS",$val['word']);
		$tpl->set_var("NR",$val['appearance']);
		$size = $min_size + (($val['appearance'] - $min_appearance) * $step);
		$size = ceil($size);
		$tpl->set_var("FONTSIZE",$size );	
		
		$tpl->set_var("URLFORWORD",ReWrite("search","search.tag.".$val['word'].".".$val['judet']));
		//$t->set_var("SETCOLOR",$get_font_size['2']);
		$tpl->parse("tags_block","tags",true);
	}
*/
	
	$the_boxes_name = 'LATEST_BLOCK_3';
	$tpl->parse($the_boxes_name, 'tpl_box');
}

#get the available tags that could be filled by a menu
$get_available_menu = GetTheAvailableMenus();
#search for the tags
$display_menus = array();
foreach ($get_available_menu as $key => $val)
{
	if (strpos($the_main_content, $val)){$display_menus[] = $val;}
}
#if our array is not empty we should display the menus
$get_menus_ids = array();
if (count($display_menus) != '0')
{
	#get the menus ids
	$i = 0;
	foreach ($display_menus as $key => $val)
	{
		$get_menus_ids[$i] = str_replace("DISPLAY_MENU_", "", $val);
		$i++;
	}
}
$tpl->set_var('TODAY_DATE',date("d M Y ") );
#get each menu and display it into its place
if (count($get_menus_ids) != '0')
{
	foreach ($get_menus_ids as $key => $val)
	{
		if ($val != "2")#because the id menu is for the sub menu
		{
			CreateMenu($val, $module, $action, @$param1);
		}
		else 
		{
			CreateSubMenu($module, $action, @$param1);
		}
	}
}
?>