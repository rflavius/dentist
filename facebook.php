<?php
/**
* this was created for the facebook app
*/

require('./preload.php');
#Start templates object
$tpl = new Template(FB_TEMPLATES_DIR);
#Get the main template page
$tpl->set_file("tpl_index", "index.tpl");

#### updated at: 17-11-2011
#### made by: flaffy
#### here we will see wich header we display !!!!

$tpl->set_var('SITE_BASEE',SSL_SITE_BASE );

switch($_GET['page'])
{
	case 'anunturi':
		$tpl->set_file('tpl_facebook',"anunturi.tpl");
		
	break;
}
#parse the output
$tpl->pparse("OUTPUT", "tpl_index");