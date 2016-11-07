<?php
/*------------------------------------------------------------------------------------------------
	|		dotBoost Self Managed Content | SMC Users Framework | support@dotboost.com
	+---------------------------------------------------------------------------
	|		SMC Users Framework IS NOT FREE SOFTWARE!
	+---------------------------------------------------------------------------
	|		Name : admin/settings.php
	|		Date started: Aug 3 2006
	|		Description : config settings
	|		Version : 0.9
	+---------------------------------------------------------------------------------------------*/
switch ($action)
{
	default :
		$tpl->set_file('tpl_settings', 'settings/list.tpl');
		#page main title
		$tpl->set_var('MAIN_TITLE', 'Edit settings');
		$tpl->set_block('tpl_settings', 'textarea', 'textarea_block');
		$tpl->set_block('tpl_settings', 'radios', 'radios_block');
		$tpl->set_block('tpl_settings', 'radio', 'radio_block');
		$tpl->set_block('tpl_settings', 'options', 'options_block');
		$tpl->set_block('tpl_settings', 'option', 'option_block');
		$get_config_variable = GetConfVariables();
		if (count($get_config_variable) != "0")
		{
			while (list($k, $v) = each($get_config_variable))
			{
				switch ($v['type'])
				{
					case 'radio':
						$tpl->set_var('TITLE', $v['title']);
						$tpl->set_var('EXPLANATION', nl2br($v['comment']));
						$tpl->set_var('VARIABLE', $v['variable']);
						$posible_values = explode(";", $v['posible_values']);
						foreach ($posible_values as $key => $val)
						{
							$tpl->set_var('CHECKED_OPTION', '');
							if ($v['value'] == $val)
							{
								$tpl->set_var('CHECKED_OPTION', 'checked');
							}
							$tpl->set_var('POSIBLE_VALUE', $val);
							$tpl->parse('radios_block', 'radios', true);
						}
						$tpl->parse('radio_block', 'radio', true);
						$tpl->parse('radios_block', '');
					break;

					case 'option':
						$tpl->set_var('TITLE', $v['title']);
						$tpl->set_var('EXPLANATION', nl2br($v['comment']));
						$tpl->set_var('VARIABLE', $v['variable']);
						$posible_values = explode(";", $v['posible_values']);
						foreach ($posible_values as $key => $val)
						{
							$tpl->set_var('SELECTED_OPTION', '');
							if ($v['value'] == $val)
							{
								$tpl->set_var('SELECTED_OPTION', 'selected');
							}
							$tpl->set_var('LIST_OPTION', $val);
							$tpl->parse('options_block', 'options', true);
						}
						$tpl->parse('option_block', 'option', true);
						$tpl->parse('options_block', '');
					break;

					case 'textarea':
						$tpl->set_var('TITLE', $v['title']);
						$tpl->set_var('EXPLANATION', nl2br($v['comment']));
						$tpl->set_var('CURRENT_VALUE', $v['value']);
						$tpl->set_var('VARIABLE', $v['variable']);
						$tpl->parse('textarea_block', 'textarea', true);
					break;
				}
			}
		}
		#if we have information messages
		if (isset($_SESSION['admin_info']))
		{
			$tpl->set_file('tpl_info', 'info/'.$_SESSION['admin_info_type'].'.tpl');
			$tpl->set_var('MESSAGE', $_SESSION['admin_info']);
			$tpl->parse('INFORMATION', 'tpl_info');
			#uset sessions
			unset($_SESSION['admin_info']);
			unset($_SESSION['admin_info_type']);
		}
		$tpl->parse('MAIN', 'tpl_settings');
	break;

	case 'save':
		foreach ($_POST as $key => $val)
		{
			SaveConfig($key, $val);
		}
		$_SESSION['admin_info'] = 'Settings successfully updated !';
		$_SESSION['admin_info_type'] = 'info';
		header ('location: '.$_SERVER['HTTP_REFERER']);
		exit;
	break;
}
?>