<?php
/*------------------------------------------------------------------------------------------------
	|		dotBoost Self Managed Content | SMC Users Framework | support@dotboost.com
	+---------------------------------------------------------------------------
	|		SMC Users Framework IS NOT FREE SOFTWARE!
	+---------------------------------------------------------------------------
	|		Name : admin/photos.php
	|		Date started: Aug 3 2006
	|		Description : list, add photos ofr static pages
	|		Version : 0.9
	+---------------------------------------------------------------------------------------------*/
switch ($action)
{
	default :
		$tpl->set_file('tpl_list', 'photos/list.tpl');
		#page main title
		$tpl->set_var('MAIN_TITLE', 'Uploaded Photos');
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
		#post size information
		$max_post_size = ini_get('post_max_size');
		$tpl->set_file('tpl_warning', 'info/warning.tpl');
		$tpl->set_var('MESSAGE', "Maximum Post Size : ".$max_post_size);
		$tpl->parse('POSTSIZE_INFORMATION', 'tpl_warning');
		#show images
		$show_pictures = ShowUploadedPhotos();
		$tpl->set_block('tpl_list', 'photos', 'photos_block');
		$tpl->set_block('tpl_list', 'if_photos', 'if_photos_block');
		if (count($show_pictures) != '0')
		{
			$i = 0;
			while (list($kl, $vl) = each($show_pictures))
			{
				#set colors
				$bc = ($i % 2)+1;
				$tpl->set_var("BGCOLOR",'row'.$bc);
				$tpl->set_var('PHOTO_ID', $vl['photo_id']);
				$tpl->set_var('PICTURE_NAME', $vl['photo_name']);
				$tpl->set_var('WIDTH', $vl['width']);
				$tpl->set_var('HEIGHT', $vl['height']);
				$tpl->set_var('SIZE', intval($vl['size']/1024).' Kb');
				$tpl->set_var('PICTURE', $vl['photo_name']);
				$tpl->parse('photos_block', 'photos', true);
				$i++;
			}
			$tpl->parse('if_photos_block', 'if_photos', true);
		}
		$tpl->parse('MAIN', 'tpl_list');
	break;

	case 'upload':
		$return_msg = array();
		$_SESSION['admin_info_type'] = 'info';
		for($i = 1; $i < 6; $i++)//just 5 forms
		{
			set_time_limit(0);
			if ($_FILES['userfile_'.$i]['type'] != "")
			{
				$extension = explode('/',$_FILES['userfile_'.$i]['type']);
				$file_extension = $extension[1];
				$return_msg[$i] = SaveUploadedPhoto($file_extension, $i);
			}
		}
		#if no image added ... so we don't display empty info box
		if (count($return_msg) == 0)
		{
			$return_msg[] = 'Please provide at least one image !';
			$_SESSION['admin_info_type'] = 'error';
		}
		
		$display_errors = "";
		foreach ($return_msg as $key => $val)
		{
			$display_errors .= $val."<br />";
		}
		$_SESSION['admin_info'] = $display_errors;
		header ('location: ?page=photos');
		exit;
	break;

	case 'delete':
		#ftp delete
		$query = "SELECT *
							FROM uploaded_photos
							WHERE photo_id='".intval($param1)."'";
		$db->query($query);
		$db->next_record();
		$photo_name = $db->f('photo_name');
		$file = '../images/uploaded_photos/'.$photo_name;
		if (@unlink($file))
		{
			#db delete
			$query = "DELETE from uploaded_photos WHERE photo_id='".intval($param1)."'";
			$db->query($query);
			#db optimize
			$query = "OPTIMIZE TABLE `uploaded_photos`";
			$db->query($query);
			#db auto increment 1
			$query = "ALTER TABLE
			`uploaded_photos` PACK_KEYS =0 CHECKSUM =0 DELAY_KEY_WRITE =0 AUTO_INCREMENT =1";
			$db->query($query);
			$_SESSION['admin_info'] = 'Image successfully deleted !';
			$_SESSION['admin_info_type'] = 'info';
			header ('location: ?page=photos');
			exit;
		}
		else
		{
			$_SESSION['admin_info'] = 'Error while trying to delete selected image !';
			$_SESSION['admin_info_type'] = 'error';
			header ('location: ?page=photos');
			exit;
		}
	break;
}
?>