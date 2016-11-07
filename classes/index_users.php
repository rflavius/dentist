<?php
/*------------------------------------------------------------------------------------------------
	|		dotBoost Self Managed Content | SMC Users Framework | support@dotboost.com
	+---------------------------------------------------------------------------
	|		SMC Users Framework IS NOT FREE SOFTWARE!
	+---------------------------------------------------------------------------
	|		Name : sources/fetch_module.php
	|		Date started: Nov 2 2006
	|		Description : users part in the index
	|		Version : 0.9
	+---------------------------------------------------------------------------------------------*/
	$tpl->set_file("tpl_login", "modules/user/login.tpl");
	$tpl->set_var('USER_LOGIN_LINK', ReWrite('user', 'user.login'));
	$tpl->set_var('USER_FORGOT_LINK', ReWrite('user', 'user.forgot'));
	$tpl->set_var('USER_SUBMIT_LINK', ReWrite('user', 'user.submit'));
	$tpl->parse("LOGIN_BLOCK", "tpl_login");

	
	#if the user session is not set display login box
	if (!isset($_SESSION['userinfo']) || count($_SESSION['userinfo']) == 0)
	{
			$tpl->set_file("tpl_login", "modules/user/login.tpl");
			$tpl->set_block("tpl_login", "login_error", "login_error_block");
			#if error , show message
			if (isset($_SESSION['login_error']))
			{
				$tpl->set_var("LOGIN_ERROR", $_SESSION['login_error']);
				$tpl->parse("login_error_block", "login_error", true);
				#and show as an error page
				$tpl->set_file('tpl_main','unpublished.tpl');
				$tpl->set_var('ERRORMSG', $_SESSION['login_error']);
				$tpl->parse('MAIN', 'tpl_main');
				#unset session msg
				unset($_SESSION['login_error']);
			}
			#user link actions
			$tpl->set_var('USER_LOGIN_LINK', ReWrite('user', 'user.login'));
			$tpl->set_var('USER_FORGOT_LINK', ReWrite('user', 'user.forgot'));
			$tpl->set_var('USER_SUBMIT_LINK', ReWrite('user', 'user.submit'));
		$tpl->parse("LOGIN_BLOCK", "tpl_login");
	}
	#display user box
	/*else 
	{
		$tpl->set_file("tpl_login", "modules/user/menu.tpl");
			$tpl->set_var("USERNAME", $_SESSION['userinfo']->username);
			$tpl->set_var('USER_HOME_LINK', ReWrite('user', 'user.home'));
			$tpl->set_var('USER_ACCOUNT_LINK', ReWrite('user', 'user.account'));
			$tpl->set_var('USER_PASSWORD_LINK', ReWrite('user', 'user.password'));
			$tpl->set_var('USER_ADD_FIRMA', ReWrite('user', 'user.addfirm'));
			$tpl->set_var('USER_LIST_FIRM',ReWrite('user', 'user.listfirms') );
			$tpl->set_var('USER_ADD_ANUNT',ReWrite('user','user.addanunt') );
			$tpl->set_var('USER_LIST_ANUNT',ReWrite('user','user.listanunturi') );
			$tpl->set_var('USER_LOGOUT_LINK', ReWrite('user', 'user.logout'));
			//$tpl->set_var('USER_LIST_FACTURA',  ReWrite('user', 'user.factura'));
			//$tpl->set_var('USER_LIST_CONTRACT',  ReWrite('user', 'user.contract'));
			$tpl->set_var('USER_HELP_LINK', ReWrite('user', 'user.help') );
			$tpl->set_var('USER_LIST_MESAJE', ReWrite('user', 'user.mesaje') );
			$tpl->set_var('USER_GALERIE',  ReWrite('user', 'user.galerie'));



			#user afirmation stuffs
			$tpl->set_var('USER_ADD_DICTIONARY_TERMS',  ReWrite('utilizator', 'utilizator.adauga'));
			$tpl->set_var('USER_LIST_DICTIONARY_TERMS',  ReWrite('utilizator', 'utilizator.listeazatermeni'));

			$tpl->set_var('USER_ADD_ARTICOL', ReWrite('user', 'user.addarticol') );
			$tpl->set_var('USER_LIST_ARTICOLE',  ReWrite('user', 'user.listarticole'));
			
			$tpl->parse('LOGIN_MENU', "tpl_login");
			
			$tpl->set_file('tpl_login_on',"modules/user/login_on.tpl");
			$tpl->set_var('LAST_LOGIN',TimeFormatShort($_SESSION['userinfo']->last_login));

			$tpl->parse("LOGIN_BLOCK", "tpl_login_on");
	}*/

# See if the user has privileges to be on current page
$see_privileges = CheckUserPrivileges($module, $action);//user.inc.php
if (trim($see_privileges) != "")//there is an error and a message to be displayed
{
	$_SESSION["login_error"] = $see_privileges;
	header ('location: '.ReWrite("default", "home"));
	exit;
}
?>