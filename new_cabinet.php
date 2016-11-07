<?php 
/**
 * here we will do the design for new cabinete view
 */

define('TEMPLATES_DIR', './templates/');
require('classes/api/templates.php');

$tpl = new Template(TEMPLATES_DIR);
$tpl->set_file("tpl_index", "index_responsive.tpl");
$tpl->set_var('ADVSEARCH_WORD',"");
$tpl->set_var('PAGETITLE', 'Oferte promovare medic dentist, cabinete stomatologice, clinici de stomatologie si radiologie');

$tpl->set_file('tpl_main', "modules/cabinete/cabinet_new.tpl");
	
$tpl->parse('MAIN', 'tpl_main');
$tpl->pparse("OUTPUT", "tpl_index");