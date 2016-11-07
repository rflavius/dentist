<?php
/*------------------------------------------------------------------------------------------------
	|		dotBoost Self Managed Content | SMC Users Framework | support@dotboost.com
	+---------------------------------------------------------------------------
	|		SMC Users Framework IS NOT FREE SOFTWARE!
	+---------------------------------------------------------------------------
	|		Name : admin/logo.php
	|		Date started: Nov 3 2006
	|		Description : change site logo
	|		Version : 0.9
	+---------------------------------------------------------------------------------------------*/
switch ($action)
{
	default :
		$tpl->set_file('tpl_list', 'logo/list.tpl');
		#page main title
		$tpl->set_var('MAIN_TITLE', 'Change Logo');
		#current_logo
		$tpl->set_var('LOGO', $conf->logo);
		#set width for logo , if larger than owr space
		$image_proprieties = GetImageSize("../images/".$conf->logo);
		$image_width = $image_proprieties[0];
		if ($image_width > 480)
		{
			$tpl->set_var('IF_WIDTH', 'width="480"');
		}
		#set colors
		$tpl->set_var('BGCOLOR1', 'row1');
		$tpl->set_var('BGCOLOR2', 'row2');
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
		$tpl->parse('MAIN', 'tpl_list');
	break;

	case 'upload':
		if (@$_FILES['logo']['type'] != "")
		{
			$extension = explode('/',$_FILES['logo']['type']);
			$file_extension = $extension[1];
			$return_msg[] = SaveLogo($file_extension);
		}
		else 
		{
			$return_msg[] = 'Please provide a logo !';
			$_SESSION['admin_info_type'] = 'error';
		}
		$display_errors = "";
		foreach ($return_msg as $key => $val)
		{
			$display_errors .= $val."<br />";
		}
		$_SESSION['admin_info'] = $display_errors;
		header ('location: ?page=logo');
		exit;
	break;
}
?>