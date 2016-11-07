<?php
require('../preload.php');
$tpl = new Template("../templates/");

$tpl->set_file("tpl_formular_plata","./modules/user/".$_GET['plata'].".tpl");
$tpl->pparse('LOC_FORM_PLACE','tpl_formular_plata');


?>