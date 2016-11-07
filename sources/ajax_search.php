<?php

//echo 'aaaaaa';exit;

require('../preload.php');

$tpl = new Template("../templates/");

if($_GET['tpl_selected']=="tplsearch")
{
		$tpl->set_file("tpl_search_ajax","./modules/search/localitati_ajax.tpl");
		$tpl->set_block('tpl_search_ajax', 'loocalitati', 'loocalitatii');
		$cod_judet = $_GET['search_judet'];
		$get_dentist_localitati = GetLocalitati($cod_judet);
		foreach($get_dentist_localitati as $ky => $val)
		{
			$tpl->set_var('ID_LOCALITATE',$val['id'] );
			$tpl->set_var('NUMELOCALITATE',$val['name'] );
			$tpl->parse('loocalitatii', 'loocalitati', true);
		}
		$tpl->pparse('LOC_DIV','tpl_search_ajax');
}
elseif($_GET['tpl_selected']=="addfirm")
{
		$tpl->set_file("tpl_search_ajax","./modules/search/localitati_ajax_faratoate.tpl");
		$tpl->set_block('tpl_search_ajax', 'loocalitati', 'loocalitatii');
		$cod_judet = $_GET['search_judet'];
		$get_dentist_localitati = GetLocalitati($cod_judet);
		foreach($get_dentist_localitati as $ky => $val)
		{
			$tpl->set_var('ID_LOCALITATE',$val['id'] );
			$tpl->set_var('NUMELOCALITATE',$val['name'] );
			$tpl->parse('loocalitatii', 'loocalitati', true);
		}
		$tpl->pparse('LOC_DIV_ADAUGAFIRMA','tpl_search_ajax');
}

?>