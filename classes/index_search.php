<?php
#let make the search part
$tpl->set_file("tpl_search","./modules/search/search_box.tpl");
if(isset($_SESSION['cauta_option'])&&($_SESSION['cauta_option']!=""))
{
	$whatoptionselected = strtoupper($_SESSION['cauta_option']);
}
else
{
	$whatoptionselected = "CABINETE";
}
$tpl->set_var("CHECKED_".$whatoptionselected,"checked" );

if(isset($_SESSION['cuvant_cautat'])&&($_SESSION['cuvant_cautat']!=""))
{
	$tpl->set_var('CUVANT_CAUTAT',$_SESSION['cuvant_cautat'] );
}

/*$tpl->set_block('tpl_search', 'display_caats', 'display_caatss');
$tpl->set_block('tpl_search', 'juudet', 'juudett');

$get_dentist_categ = Get_Dentist_Cats('-1');
foreach($get_dentist_categ as $ky => $val)
{
	if(isset($_SESSION['cat_id'])&&($_SESSION['cat_id']!=""))
	{
		if($val['id'] == $_SESSION['cat_id'])
		{ $tpl->set_var('SELECTED_CAT',"selected" ); }
		else
		{ $tpl->set_var('SELECTED_CAT',"" );	}
	}
			
	$tpl->set_var('CAT_NAME',$val['name'] );
	$tpl->set_var('CAT_ID',$val['id'] );
	$tpl->parse('display_caatss', 'display_caats', true);
}

$get_dentist_judete = GetJudete();
foreach($get_dentist_judete as $ky => $val)
{
	if(isset($_SESSION['judet_code'])&&($_SESSION['judet_code']!=""))
	{
		if($val['code'] == $_SESSION['judet_code'])
		{ $tpl->set_var('SELECTEDCOUNTRY','selected' ); }				
		else
		{	$tpl->set_var('SELECTEDCOUNTRY','' );	}
	}
	else
	{		$tpl->set_var('LOC_DIV',"Alegeti judetul intai!" );	}

	$tpl->set_var('COD_JUDET',$val['code'] );
	$tpl->set_var('NUMEJUDET',$val['name'] );
	$tpl->parse('juudett', 'juudet', true);
}*/



$tpl->set_var('ADVSEARCH_WORD',ReWrite("default","advsearch") );
$tpl->parse("SEARCH_BLOCK", "tpl_search");

?>