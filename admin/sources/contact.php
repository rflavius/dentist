<?php
switch ($action)
{
	default :
		$tpl->set_file('tpl_contact', 'contact/general.tpl');
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
		#set colors
		$tpl->set_var('BGCOLOR1', 'row1');
		$tpl->set_var('BGCOLOR2', 'row2');
		#set colors
		$tpl->set_var('BGCOLOR1', 'row1');
		$tpl->set_var('BGCOLOR2', 'row2');
		if ($action == ""){$get_id = GetModuleID($module);}
		elseif (!is_numeric($action)){$get_id = GetModuleID($module.'.'.$action);}
		else {$get_id = $action;}
		#get info
		$get_module = GetModules(intval($get_id));
		$the_module = $get_module['0'];
		if (isset($_SESSION['edit_modules_content']))
		{
			$the_module = $_SESSION['edit_modules_content'];
			unset($_SESSION['edit_modules_content']);
		}
		$tpl->set_var('ID', $the_module['id']);
		$tpl->set_var('NAME', $the_module['name']);
		$tpl->set_var('KEYWORDS', $the_module['meta_keywords']);
		$tpl->set_var('DESCRIPTION', $the_module['meta_description']);
		$tpl->set_var('CONTENT', $the_module['content']);
		#page main title
		$tpl->set_var('MAIN_TITLE', 'Edit '.$the_module['name'].' module');
		$link = str_replace(".", "_", $the_module['link']);
		$tpl->set_var('LINK', $link);
		#status
		if ($the_module['active'] == '1')
		{
			$tpl->set_var('STATUS_ACTIVE', 'selected');
		}
		else 
		{
			$tpl->set_var('STATUS_INACTIVE', 'selected');
		}
		$tpl->parse('MAIN', 'tpl_contact');
	break;

	case 'list':
		$tpl->set_file('tpl_list', 'contact/list.tpl');
		#page main title
		$tpl->set_var('MAIN_TITLE', 'List all contact us messages');
		#set blocks
		$tpl->set_block('tpl_list', 'list_messages', 'list_messages_block');
		$tpl->set_block('tpl_list', 'if_messages', 'if_messages_block');
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
		#count all messages
		$total_records = CountMessages();
		$tpl->set_var('COUNT_MESSAGES', $total_records);
		$pages_number = ceil($total_records/$conf->messages_per_page);
		$tpl->set_var('PAGES', $pages_number);
		#create de pagination page_name
		$page_name = $module.'.'.$action;
		if(isset( $_GET['start'])&&(	$start = $_GET['start']!=""))
		{
				$start = $_GET['start'];
		}
	
		if(!isset($start))
		{
			$start_q = 0;
			$start = 1;
		}
		else
		{
			$start_q = $conf->messages_per_page*($start-1);
		}
		#Create and parse pagination
		$html_pages = AdminPagination($conf->messages_per_page, $total_records, $page_name, $start);
		$tpl->set_var("PAGINATION", $html_pages);
		$query_limit = " LIMIT $start_q, $conf->messages_per_page";
		#get messages
		$messages = ContactUsMessages('-1', $query_limit);
		if (count($messages) != '0')
		{
			$i = 0;
			while (list($k, $v) = each($messages))
			{
				#set colors
				$bc = ($i % 2)+1;
				$tpl->set_var("BGCOLOR", 'row'.$bc);
				#set variables
				$tpl->set_var("ID", $v['id']);
				$tpl->set_var("NAME", $v['name']);
				$tpl->set_var("SUBJECT", $v['subject']);
				$tpl->set_var("MESSAGE", $v['message']);
				$tpl->set_var("FOLLOW_UP", nl2br($v['note']));
				$tpl->set_var("REPLY", "No");
				if (trim($v['reply']) != "")
				{
					$tpl->set_var("REPLY", "Yes");
				}
				$tpl->parse('list_messages_block', 'list_messages', true);
				$i++;
			}
			$tpl->parse('if_messages_block', 'if_messages', true);
		}
		$tpl->parse('MAIN', 'tpl_list');
	break;

	case 'details':
		$tpl->set_file('tpl_details', 'contact/details.tpl');
		$tpl->set_block('tpl_details', 'form_fields', 'form_fields_block');
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
		$message = ContactUsMessages(intval($param1), '');
		#values that are allways the same
		$tpl->set_var("ID", $message['id']);
		$tpl->set_var("FOLLOW_UP_NOTE", $message['note']);
		$tpl->set_var("REPLY", $message['reply']);
		$tpl->set_var("DATE", AdminTimeFormat($message['date'],'N'));
		#values that depend on the contact custom fields
		$i = 1;
		foreach ($message as $key => $val)
		{
			#set colors
			$bc = ($i % 2)+1;
			$tpl->set_var("BGCOLOR", 'row'.$bc);
			$i++;
			#if the key uis numeric display custom form name and content
			if (intval($key))
			{
				$form = GetForms($key, "");
				$tpl->set_var("FIELD_NAME", $form['0']['name']);
				$tpl->set_var("FIELD_VALUE", $val);
				$tpl->parse('form_fields_block', 'form_fields', true);
			}
		}
		#page main title
		$tpl->set_var('MAIN_TITLE', 'View details for message from '.$message['1']);
		$tpl->parse('MAIN', 'tpl_details');
	break;

	case 'update_follow_up':
		#update the database
		UpdateFollowUpNote(addslashes($_POST['follow_up_note']), intval($param1));
		#send info message
		$_SESSION['admin_info'] = 'Follow Up Note successfully updated !';
		$_SESSION['admin_info_type'] = 'info';
		header ('location: '.$_SERVER['HTTP_REFERER']);
		exit;
	break;

	case 'reply':
		#update the database and then inside the SendReply function call uppon the Reply function to send the email
		SendReply(addslashes($_POST['reply']), intval($param1));
		#send info message
		$_SESSION['admin_info'] = 'Reply E-mail successfully sent !';
		$_SESSION['admin_info_type'] = 'info';
		header ('location: '.$_SERVER['HTTP_REFERER']);
		exit;
	break;

	case 'form':
		$tpl->set_file("tpl_form", "contact/form.tpl");
		$tpl->set_block("tpl_form", "list", "list_block");
		#page main title
		$tpl->set_var('MAIN_TITLE', 'Edit Contact form');
		$forms = GetForms('-1', "");
		if (count($forms) != '0')
		{
			$i = 0;
			while (list($k, $v) = each($forms))
			{
				#set colors
				$bc = ($i % 2)+1;
				$tpl->set_var("BGCOLOR", 'row'.$bc);
				$tpl->set_var("ID", $v['id']);
				$tpl->set_var("NAME", $v['name']);
				#if there are too many option values send a class to the browser and make the design a little bit nicer
				$tpl->set_var("NOROWS", "");
				if (strlen($v['option_values']) > "60")
				{
					$tpl->set_var("NOROWS", "norows");
				}
				$tpl->set_var("VALUES", $v['option_values']);
				$tpl->set_var("FIELD_TYPE", $v['type']);
				$tpl->set_var("CONTENT_TYPE", $v['content_type']);
				#used
				$tpl->set_var('USED_IMAGE', 'inactive.png');
				$tpl->set_var('USED_IMAGE_TITLE', 'used');
				if ($v['used'] == "Y")
				{
					$tpl->set_var('USED_IMAGE', 'active.png');
					$tpl->set_var('USED_IMAGE_TITLE', 'unused');
				}
				#required
				$tpl->set_var('REQUIRED_IMAGE', 'inactive.png');
				$tpl->set_var('REQUIRED_IMAGE_TITLE', 'required');
				if ($v['required'] == "Y")
				{
					$tpl->set_var('REQUIRED_IMAGE', 'active.png');
					$tpl->set_var('REQUIRED_IMAGE_TITLE', 'unrequired');
				}
				$tpl->parse("list_block", "list", true);
				$i++;
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
		$tpl->parse("MAIN", "tpl_form");
	break;

	case 'set':
		ChangeField($param1, intval($param2));
		$_SESSION['admin_info'] = 'Field status successfully changed !';
		$_SESSION['admin_info_type'] = 'info';
		header ('location: '.$_SERVER['HTTP_REFERER']);
		exit;
	break;

	case 'edit':
		$tpl->set_file("tpl_edit", "contact/edit.tpl");
		$tpl->set_block("tpl_edit", "field_type", "field_type_block");
		$tpl->set_block("tpl_edit", "content_type", "content_type_block");
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
		#if the user has done changes and there are still erorrs the $form will take the value of the session else get it from the db
		if (isset($_SESSION['field_content']))
		{
			$form = $_SESSION['field_content'];
			unset($_SESSION['field_content']);
		}
		else 
		{
			$forms = GetForms(intval($param1), "");
			$form = $forms[0];
		}
		#page main title
		$tpl->set_var('MAIN_TITLE', 'Edit "'.$form['name'].'" form field');
		$tpl->set_var("ID", $form['id']);
		$tpl->set_var("NAME", $form['name']);
		#field type
		$field_type = GetEnumValues("type");
		foreach ($field_type as $key => $val)
		{
			$tpl->set_var("FIELD_VALUE", $val);
			$tpl->set_var("FIELD_SELECTED", "");
			if ($val == $form['type']){$tpl->set_var("FIELD_SELECTED", "selected");}
			$tpl->parse("field_type_block", "field_type", true);
		}
		#content type
		$content_type = GetEnumValues("content_type");
		foreach ($content_type as $key => $val)
		{
			$tpl->set_var("CONTENT_VALUE", $val);
			$tpl->set_var("CONTENT_SELECTED", "");
			if ($val == $form['content_type']){$tpl->set_var("CONTENT_SELECTED", "selected");}
			$tpl->parse("content_type_block", "content_type", true);
		}
		#option values
		$tpl->set_var("OPTION_VALUES", $form['option_values']);
		#used
		if ($form['used'] == "Y"){$tpl->set_var("USED_Y", "selected");}
		else {$tpl->set_var("USED_N", "selected");}
		#required
		if ($form['required'] == "Y"){$tpl->set_var("REQUIRED_Y", "selected");}
		else {$tpl->set_var("REQUIRED_N", "selected");}
		#erorr_message
		$tpl->set_var("ERROR_MESSAGE", $form['error_message']);
		$tpl->parse("MAIN", "tpl_edit");
	break;

	case 'save':
		$errors = array();
		if (trim($_POST['name']) == "")
		{
			$errors[0] = "Please provide a title for the field";
		}
		#if the required filed = Y verify that the error message is not empty
		if ($_POST['required'] == "Y" && trim($_POST['error_message']) == "")
		{
			$errors[1] = "You have set this field as being required. Please provide an error message !";
		}
		#check the type of the field; if the field is checkbox, pulldown or radio verify if Option Values are given
		$field = $_POST['field_type'];
		if ($field == "radio" || $field == "checkbox" || $field == "pulldown")
		{
			if (trim($_POST['option_values']) == "")
			{
				$errors[2] = "You have set the type of this field as being a ".$field.". Please set some Option Values !";
			}
		}
		#if there are errors return to previous screen
		if (count($errors) != 0)
		{
			$display_errors = "";
			foreach ($errors as $key => $val)
			{
				$display_errors .= $val."<br />";
			}
			$_SESSION['admin_info'] = $display_errors;
			$_SESSION['admin_info_type'] = 'error';
			$_SESSION['field_content'] = array('id' => ''.intval($param1).'',
																				 'name' => ''.$_POST['name'].'',
																				 'type' => ''.$_POST['field_type'].'',
																				 'content_type' => ''.$_POST['content_type'].'',
																				 'option_values' => ''.$_POST['option_values'].'',
																				 'used' => ''.$_POST['used'].'',
																				 'required' => ''.$_POST['required'].'',
																				 'error_message' => ''.$_POST['error_message'].'');
			header ('location: '.$_SERVER['HTTP_REFERER']);
			exit;
		}
		SaveFormField(intval($param1), $_POST);
		$_SESSION['admin_info'] = 'Changes successfully updated !';
		$_SESSION['admin_info_type'] = 'info';
		header ('location: '.$_SERVER['HTTP_REFERER']);
		exit;
	break;

	case 'rearenge':
		#rearrange the fields according to the admin's wish
		ReorderForms(intval($param2), $param1);
		RearrangeForms();
		$_SESSION['admin_info'] = 'Field position successfully changed !';
		$_SESSION['admin_info_type'] = 'info';
		header ('location: '.$_SERVER['HTTP_REFERER']);
		exit;
	break;

	case 'add':
		$tpl->set_file("tpl_add", "contact/add.tpl");
		#page main title
		$tpl->set_var('MAIN_TITLE', 'Add custom form field');
		$tpl->set_block("tpl_add", "field_type", "field_type_block");
		$tpl->set_block("tpl_add", "content_type", "content_type_block");
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
		#if the user has added info and there are still erorrs the $form will take the value of the session else get a new empty array
		if (isset($_SESSION['field_add_content']))
		{
			$form = $_SESSION['field_add_content'];
			unset($_SESSION['field_add_content']);
		}
		else 
		{
			$form = EmptyFormArray();
		}
		$tpl->set_var("NAME", $form['name']);
		#field type
		$field_type = GetEnumValues("type");
		foreach ($field_type as $key => $val)
		{
			$tpl->set_var("FIELD_VALUE", $val);
			$tpl->set_var("FIELD_SELECTED", "");
			if ($val == $form['type']){$tpl->set_var("FIELD_SELECTED", "selected");}
			$tpl->parse("field_type_block", "field_type", true);
		}
		#content type
		$content_type = GetEnumValues("content_type");
		foreach ($content_type as $key => $val)
		{
			$tpl->set_var("CONTENT_VALUE", $val);
			$tpl->set_var("CONTENT_SELECTED", "");
			if ($val == $form['content_type']){$tpl->set_var("CONTENT_SELECTED", "selected");}
			$tpl->parse("content_type_block", "content_type", true);
		}
		#option values
		$tpl->set_var("OPTION_VALUES", $form['option_values']);
		#used
		if ($form['used'] == "Y"){$tpl->set_var("USED_Y", "selected");}
		else {$tpl->set_var("USED_N", "selected");}
		#required
		if ($form['required'] == "Y"){$tpl->set_var("REQUIRED_Y", "selected");}
		else {$tpl->set_var("REQUIRED_N", "selected");}
		#erorr_message
		$tpl->set_var("ERROR_MESSAGE", $form['error_message']);
		$tpl->parse("MAIN", "tpl_add");
	break;

	case 'insert':
		$errors = array();
		if (trim($_POST['name']) == "")
		{
			$errors[0] = "Please provide a title for the field";
		}
		#if the required filed = Y verify that the error message is not empty
		if ($_POST['required'] == "Y" && trim($_POST['error_message']) == "")
		{
			$errors[1] = "You have set this field as being required. Please provide an error message !";
		}
		#check the type of the field; if the field is checkbox, pulldown or radio verify if Option Values are given
		$field = $_POST['field_type'];
		if ($field == "radio" || $field == "checkbox" || $field == "pulldown")
		{
			if (trim($_POST['option_values']) == "")
			{
				$errors[2] = "You have set the type of this field as being a ".$field.". Please set some Option Values !";
			}
		}
		#if there are errors return to previous screen
		if (count($errors) != 0)
		{
			$display_errors = "";
			foreach ($errors as $key => $val)
			{
				$display_errors .= $val."<br />";
			}
			$_SESSION['admin_info'] = $display_errors;
			$_SESSION['admin_info_type'] = 'error';
			$_SESSION['field_add_content'] = array('name' => ''.$_POST['name'].'',
																				 'type' => ''.$_POST['field_type'].'',
																				 'content_type' => ''.$_POST['content_type'].'',
																				 'option_values' => ''.$_POST['option_values'].'',
																				 'used' => ''.$_POST['used'].'',
																				 'required' => ''.$_POST['required'].'',
																				 'error_message' => ''.$_POST['error_message'].'');
			header ('location: '.$_SERVER['HTTP_REFERER']);
			exit;
		}
		InsertFormField($_POST);
		$_SESSION['admin_info'] = 'Field successfully added !';
		$_SESSION['admin_info_type'] = 'info';
		header ('location: ?page=contact.form');
		exit;
	break;

	case 'delete':
		$protected = array(1, 2, 3, 4);//protected fileds ... cannot be deleted
		if (in_array($param1, $protected))
		{
			$_SESSION['admin_info'] = 'Field cannot be deleted ! Every E-mail must contain the selected field.';
			$_SESSION['admin_info_type'] = 'warning';
		}
		else 
		{
			#delete from the form table
			$query = "DELETE FROM form WHERE id = '".intval($param1)."'";
			$db->query($query);
			#change contact us table structure
			$query = "ALTER TABLE `contact_us` DROP `field_".intval($param1)."`";
			$db->query($query);
			$_SESSION['admin_info'] = 'Field successfully deleted !';
			$_SESSION['admin_info_type'] = 'info';
		}
		header ('location: '.$_SERVER['HTTP_REFERER']);
		exit;
	break;
}
?>