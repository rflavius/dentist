<?php
/*-------------------------------------------------------------------------------------------------
	|		dotBoost Self Managed Content | SMC Users Framework | support@dotboost.com
	+---------------------------------------------------------------------------
	|		SMC Users Framework IS NOT FREE SOFTWARE!
	+---------------------------------------------------------------------------
	|		Name : admin/browse_image.php
	|		Date started: Aug 3 2006
	|		Description :  browse the images present on the server
	|		Version : 0.9
	+----------------------------------------------------------------------------------------------*/
$tpl->set_file('tpl_browse', 'browse_image/list.tpl');
$tpl->set_block('tpl_browse', 'chose_pictures', 'chose_pictures_block');
$query = "SELECT * FROM uploaded_photos ORDER by photo_id DESC";
$db->query($query);
while ($db->next_record())
{
	$tpl->set_var('PICTURE_ID', $db->f('photo_id'));
	$tpl->set_var('PICTURE', $db->f('photo_name'));
	$tpl->parse('chose_pictures_block', 'chose_pictures', true);
}
$tpl->pparse('MAIN', 'tpl_browse');
exit;
?>