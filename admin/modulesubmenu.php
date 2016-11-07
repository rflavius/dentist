<?php
$tpl->set_file('tpl_submenu', 'modulesubmenu.tpl');
$tpl->set_block('tpl_submenu', 'mod_sub_menu', 'mod_sub_menu_block');

//echo $the_module;
$menu_id = GetCurrentMenuID($the_module,$action);
$menu_name = GetMenuNameFromID($menu_id);
$tpl->set_var('MAIN_MENU_TITLES', $menu_name );


$getsubmenu = GetMenu($menu_id,$admin->level);
	foreach($getsubmenu as $ky => $val)
	{
	
		$tpl->set_var('SELECTED_MENU_ITEMM', '');
		if ($val['id'] == $current_page_id)
		{
			$tpl->set_var('SELECTED_MENU_ITEMM', '-selected');
		}


		$tpl->set_var('ACTIVEYN', '');
		$tpl->set_var('CUURENTYN', '');
		if ($val['id'] == $current_page_id)
		{
			$tpl->set_var('CUURENTYN', 'current');
			$tpl->set_var('ACTIVEYN', 'active');
		}

		$tpl->set_var('MENU_LINK_TEXT', $val['name']);
		$tpl->set_var('MENU_LINK', $val['link']);
		$tpl->parse('mod_sub_menu_block', 'mod_sub_menu', true);
	
	
	}
$tpl->parse('MENUTABLE','tpl_submenu' );
?>