<?php 
/**
 * here it will be the gmap search modules
 */

switch ($action)
{
	default:
		$tpl->set_file('tpl_gmap', 'modules/gmap/home.tpl');
		$tpl->parse('MAIN', 'tpl_gmap');
	break;
}