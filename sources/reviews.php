<?php 
/**
 * here we have the reviews for dentist
 */

$reviews = new Dentist_Reviews();

switch ($action)
{
	default:
		$tpl->set_file('tpl_main', 'modules/pagina/reviews.tpl');
		$tpl->set_block('tpl_main','list_reviews','list_reviews2');
		$list = $reviews->listReviews();
		if(count($list)>0)
		{
			foreach ($list as $key => $value)
			{
				$tpl->set_var('REVIEW', nl2br($value['review']));
				$tpl->set_var('ID', $value['id']);
				$tpl->set_var('NAME', $value['name']);
				$get_cabinet = GetSelectedCabinet($value['cabinet_id']);
				$tpl->set_var('START_DATE', TimeFormatEvents($get_cabinet['date']));
				$tpl->set_var('CABINET_LINK', ReWrite('cabinete_detalii', 'cabinete.detalii.'.$value['cabinet_id']));
				$tpl->set_var('REVIEW_IMAGE', SITE_BASE.$value['image']);
				$tpl->parse('list_reviews2','list_reviews', true);
			}
		}
		else $tpl->parse('list_reviews2','');
		$tpl->parse('MAIN','tpl_main');
	break;
}