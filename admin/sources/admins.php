<?php
/*------------------------------------------------------------------------------------------------
	|		dotBoost Self Managed Content | SMC Users Framework | support@dotboost.com
	+---------------------------------------------------------------------------
	|		SMC Users Framework IS NOT FREE SOFTWARE!
	+---------------------------------------------------------------------------
	|		Name : admin/admins.php
	|		Date started: Aug 3 2006
	|		Description : list, edit, delete, add admins
	|		Version : 0.9
	+---------------------------------------------------------------------------------------------*/
switch ($action)
{
	case 'list':
		$tpl->set_file("tpl_list", "admins/list.tpl");
		$tpl->set_var("MAIN_TITLE", "List Admin Users");
		$tpl->set_block("tpl_list", "list", "list_block");
		$get_admins = GetAdmins();
		if (count($get_admins) != "0")
		{
			#list current admins
			$i = 0;
			while (list($k, $v) = each($get_admins))
			{
				$bc = ($i % 2)+1;
				$tpl->set_var("BGCOLOR",'row'.$bc);
				$tpl->set_var("ID", $v['id']);
				$tpl->set_var("USERNAME", $v['user']);
				$tpl->set_var("EMAIL", $v['email']);
				$tpl->parse("list_block", "list", true);
				$i++;
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
			#inserted good variables
			if (isset($_SESSION['admin_add_array']))
			{
				foreach ($_SESSION['admin_add_array'] as $key => $val)
				{
					$tpl->set_var(strtoupper($key), $val);
				}
				unset($_SESSION['admin_add_array']);
			}
		}
		$tpl->parse("MAIN", "tpl_list");
	break;

	case 'add':
		#errors
		$errors = array();
		$admin_username = CheckAdminUsername($_POST['user']);
		if ($admin_username != "")
		{
			$errors[0] = $admin_username;
		}
		#password
		if (trim($_POST["pass_1"]) == "" || trim($_POST["pass_2"]) == "")
		{
			$errors[1] = "The passwords fields must not be empty !";
		}
		elseif ($_POST["pass_1"] != $_POST["pass_2"])
		{
			$errors[1] = "The passwords in the 2 fields must be the same !";
		}
		#email
		if (!ValidEmail($_POST['add_email']))
		{
			$errors[2] = "Please provide a valid email address";
		}
		if (count($errors) != "0")
		{
			$display_errors = "";
			foreach ($errors as $key => $val)
			{
				$display_errors .= $val."<br />";
			}
			$_SESSION['admin_info'] = $display_errors;
			$_SESSION['admin_info_type'] = 'error';
			$_SESSION["admin_add_array"] = array("user" => ''.$_POST["user"].'',
																					 "add_email" => ''.$_POST["add_email"].'');
			header ('location: '.$_SERVER["HTTP_REFERER"]);
			exit;
		}
		#insert into db
		InsertAdminAccount(addslashes($_POST["user"]), addslashes($_POST["pass_2"]), addslashes($_POST["add_email"]));
		$_SESSION['admin_info'] = 'Admin account successfully created !';
		$_SESSION['admin_info_type'] = 'info';
		header ('location: '.$_SERVER["HTTP_REFERER"]);
		exit;
	break;

	case 'edit':
		$tpl->set_file("tpl_edit", "admins/edit.tpl");
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
		$admin_account = GetSelectedAdmin(intval($param1));
		$tpl->set_var("ID", $admin_account['id']);
		$tpl->set_var("USER", $admin_account['user']);
		$tpl->set_var("EMAIL", $admin_account['email']);
		$tpl->set_var("MAIN_TITLE", "Edit ".$admin_account['user']."'s admin account");
		$tpl->parse("MAIN", "tpl_edit");
	break;

	case 'save_changes':
		$errors = array();
		#email
		if (!ValidEmail($_POST['email']))
		{
			$errors[0] = "Please provide a valid email address";
		}
		if (count($errors) != "0")
		{
			$display_errors = "";
			foreach ($errors as $key => $val)
			{
				$display_errors .= $val."<br />";
			}
			$_SESSION['admin_info'] = $display_errors;
			$_SESSION['admin_info_type'] = 'error';
			header ('location: '.$_SERVER["HTTP_REFERER"]);
			exit;
		}
		SaveAdminChanges('email', $_POST['email'], intval($param1));
		$_SESSION['admin_info'] = 'Modificarile au fost realizate cu succes !';
		$_SESSION['admin_info_type'] = 'info';
		header ('location: '.$_SERVER["HTTP_REFERER"]);
		exit;
	break;

	case 'password':
		$tpl->set_file("tpl_pass", "admins/password.tpl");
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
		$admin_account = GetSelectedAdmin(intval($param1));
		$tpl->set_var("ID", $admin_account['id']);
		$tpl->set_var("USER", $admin_account['user']);
		$tpl->set_var("EMAIL", $admin_account['email']);
		$tpl->set_var("MAIN_TITLE", "Edit ".$admin_account['user']."'s admin password");
		$tpl->parse("MAIN", "tpl_pass");
	break;

	case 'save_password':
		$errors = array();
		#old password must not be empty
		if (trim($_POST["old_password"]) == "")
		{
			$errors[0] = "Va rugam introduceti vechea parola !";
		}
		elseif (OldPassword(intval($param1)) != md5($_POST["old_password"]))
		{
			$errors[0] = "Vechea parola este invalida!";
		}
		#new password
		if (trim($_POST["new_password_1"]) == "" || trim($_POST["new_password_2"]) == "")
		{
			$errors[1] = "Noua parola trebuie setata !";
		}
		elseif ($_POST["new_password_1"] != $_POST["new_password_2"])
		{
			$errors[1] = "Noua parola trebuie sa fie aceeasi in ambele locuri !";
		}
		if (count($errors) != "0")
		{
			$display_errors = "";
			foreach ($errors as $key => $val)
			{
				$display_errors .= $val."<br />";
			}
			$_SESSION['admin_info'] = $display_errors;
			$_SESSION['admin_info_type'] = 'error';
			header ('location: '.$_SERVER["HTTP_REFERER"]);
			exit;
		}
		SaveAdminChanges('pasw', $_POST['new_password_1'], intval($param1));
		$_SESSION['admin_info'] = 'Parola a fost schimbata cu succes!';
		$_SESSION['admin_info_type'] = 'info';
		header ('location: '.$_SERVER["HTTP_REFERER"]);
		exit;
	break;
}
?>