<?php
switch ($action)
{
//var_dump($action);
	case 'readmessage':
			$tpl->set_file("read_messages", "modules/user/citeste_mesaj.tpl");	
			$tpl->set_block('read_messages', 'if_gratuit', 'if_gratuitt');
			$tpl->set_block('read_messages', 'all_messages', 'all_messagess');

			$acces_link = "http://www.dentistonline.ro/user-readmessage-".$param1."-".$param2."-".$param3.".html";
			$response = CheckAcceslink($acces_link);
			if($response)
			{
				$id_msj = $param2;
				$user_id = $param1;
				$get_mesaje = GetMesaje($user_id,$id_msj);
				$get_mesaje2 = GetMesaje($user_id,"all");
				//print_r($get_mesaje2);
				foreach($get_mesaje as $ky => $val)
				{
					$x = ($i%2)+1;
					$tpl->set_var("BGCOLOR","row".$x);
					$tpl->set_var('NUME_UTILIZATOR',ucwords($val['nume_utilizator']) );
					$tpl->set_var('EMAIL',$val['email_utilizator'] );
					$tpl->set_var('SUBIECT_MESAJ',$val['subiect'] );
					$tpl->set_var('TELEFON',$val['telefon']. " " );
					$tpl->set_var('MESAJ',$val['mesaj']);
					$tpl->set_var('DETALIIMESAJ', ReWrite('user','user.detaliimesaj.'.$val['id']));
					$tpl->set_var('DATA',TimeFormatShort($val['submision_date'] ));
					$query="Update mesaje_utilizator set citit ='Y' where id='".$val['id']."'";
					$db->query($query);
					$i++;
				}
				$query="Update users_messages_links set read_messages='Y' where acces_link='".$acces_link ."'";
				$db->query($query);

				#daca e membru gratuit sa primeasca mesajul de alerta cu upadte la pachet Abonament
				$get_firme = GetFirme($user_id,"-1");
					if(count($get_firme )>0)
					{
						foreach($get_firme as $ky => $val)
						{
							if($val['level']==1)
							{
								$tpl->parse('if_gratuitt', 'if_gratuit', true);
							}
						}
					}
					else
					{	
						$tpl->parse('if_gratuitt', 'if_gratuit', false);
					}

					#lest parse all emails received by dentistonline.ro
						$query_limit="LIMIT 0, 50";
						$get_mesaje2 = GetUsersMesages($user_id,$query_limit);
						$i = 0;
						
					if (count($get_mesaje2)>1)
					{
						array_shift($get_mesaje2);
						foreach($get_mesaje2 as $ky => $val)
							{
								$x = ($i%2)+1;
								$tpl->set_var("BGCOLOR","row".$x);
								$tpl->set_var('NUME_UTILIZATOR2',ucwords($val['nume_utilizator']) );
								$tpl->set_var('EMAIL2',$val['email_utilizator'] );
								$tpl->set_var('SUBIECT_MESAJ2',$val['subiect'] );
								$tpl->set_var('TELEFON2',$val['telefon']. " " );
								$tpl->set_var('MESAJ2',$val['mesaj']);
								$tpl->set_var('DETALIIMESAJ2', ReWrite('user','user.detaliimesaj.'.$val['id']));
								$tpl->set_var('DATA2',TimeFormatShort($val['submision_date'] ));
								$query="Update mesaje_utilizator set citit ='Y' where id='".$val['id']."'";
								$db->query($query);
								$tpl->parse('all_messagess', 'all_messages', true);
								$i++;
							}
						
					}
				$tpl->parse("MAIN", "read_messages");
			}
			else
			{
				$tpl->set_var('BAD_LINK',"<font color=\"#990000\";>* Linkul dvs. este incorect - contactati administratorul pentru rezolvarea problemei, adresa e-mail :  admin@dentistonline.ro</font><br /><br />" );
				$tpl->set_file("errors", "error.tpl");	
				$tpl->parse("MAIN", "errors");
			}
			//$tpl->parse("MAIN", "read_messages");
	break;
	
	#create new account form 
	case 'submit':
		$tpl->set_file("tpl_submit", "modules/user/submit.tpl");
		#set the action var
		$tpl->set_var('USER_CREATE_LINK', ReWrite('user', 'user.create'));
		$tpl->set_var('TERMENICONDITII', ReWrite("pagina","pagina.termeniconditii"));
		$tpl->set_var('CONTNOU', ReWrite("pagina","pagina.contnou"));
		$tpl->set_var('SECURITYID', md5(time()));
		$tpl->parse("MAIN", "tpl_submit");
	break;

	case 'create':
		if(isset($_POST['type']) && $_POST['type']!='')
		{
			#insert the post variables in the User class vars
			$user->firstname = $_POST['firstname'];
			$user->lastname = $_POST['lastname'];
			$user->email = $_POST['email'];
			$user->pass_1 = $_POST['pass_1'];
			$user->security_code = $_POST['security_code'];
			$user->security_id = $_SESSION['security_code'];
			unset($_SESSION['security_code']);
			#do signup nalidation
			$errors = array();
			$errors = $user->ValidateFastSignup();
			//print_r($errors);exit;
			$display_errors = '';
			if ((count($errors) != 0)||($display_errors!=""))
			{
				foreach ($errors as $val)
				{
					$display_errors .= $err_string[$val].'<br>';
				}
				$_SESSION['error']['message'] = $display_errors;
				$_SESSION['error']['type'] = 'error';
				$_SESSION['error']['post'] = array('firstname' => ''.$_POST['firstname'].'',
												'lastname' => ''.$_POST['lastname'].'',
												'email' => ''.$_POST['email'].'',
												'username' => ''.$_POST['username'].'');
				header ('location: '.GetReferer());
				exit;
			}
		
			$user->AddFastUser();
			#on sign up login directly
			$user->Login($user->username, $user->pass_1);
			#add user information to our session variable
			$_SESSION['userinfo'] = $user;
			
			#sa trimitem mail noului utilizator pt a avea datele
			$text = GetFileContent("./templates/emails/account_created.tpl");
			$text = str_replace("%firstname%",	ucfirst($_POST['firstname']) , $text);
			$text = str_replace("%lastname%",ucfirst($_POST['lastname']), $text);
			$text =str_replace("%username%",$user->username,$text);
			$text = str_replace("%pasw%",$_POST['pass_1'],$text);
			$Sender = "DentistOnline <".$conf->contact_recipient.">";
			$Recipiant = addslashes($_POST['email']) ;
			$CustomHeaders = '';
			#send text email
			$Subject = "Contul dumneavostra a fost creat!";
			$message = new Email($Recipiant, $Sender, $Subject, $CustomHeaders);
			$message->SetHtmlContent($text);
			if (ValidHeader($Sender))
			{
				$message->Send();
			}
			$_SESSION['admin_info']="Bine ati venit - ".$user->username.". Acesta este panoul de administrare a ofertelor dvs.";
			header ('location: '.SITE_BASE.'/admin_utilizator/?page=firma');
			exit;
		}
		else
		{
			#insert the post variables in the User class vars
			$user->firstname = $_POST['firstname'];
			$user->lastname = $_POST['lastname'];
			$user->email = $_POST['email'];
			$user->username = $_POST['username'];
			$user->pass_1 = $_POST['pass_1'];
			$user->pass_2 = $_POST['pass_2'];
			$user->security_code = $_POST['security_code'];
			$user->security_id = $_SESSION['security_code'];
			unset($_SESSION['security_code']);
			#do signup nalidation
			$errors = array();
			$errors = $user->ValidateSignup();
			$display_errors = '';
			if(!isset($_POST['agree'])||($_POST['agree']==""))
			{
				$display_errors.= 'Trebuie sa acceptati termenii si conditiile noastre pentru a va inregistra<br>';
			}
			if ((count($errors) != 0)||($display_errors!=""))
			{
				
				foreach ($errors as $val)
				{
					$display_errors .= $err_string[$val].'<br>';
				}
				$_SESSION['error']['message'] = $display_errors;
				$_SESSION['error']['type'] = 'error';
				$_SESSION['error']['post'] = array('firstname' => ''.$_POST['firstname'].'',
													'lastname' => ''.$_POST['lastname'].'',
													'email' => ''.$_POST['email'].'',
													'username' => ''.$_POST['username'].'');
				header ('location: '.GetReferer());
				exit;
			}
			
			$user->AddUser();
			#on sign up login directly
			$user->Login($user->username, $user->pass_1);
			#add user information to our session variable
			$_SESSION['userinfo'] = $user;
			
			#sa trimitem mail noului utilizator pt a avea datele
			$text = GetFileContent("./templates/emails/account_created.tpl");
			$text = str_replace("%firstname%",	ucfirst($_POST['firstname']) , $text);
			$text = str_replace("%lastname%",ucfirst($_POST['lastname']), $text);
			$text =str_replace("%username%",$_POST['username'],$text); 
			$text = str_replace("%pasw%",$_POST['pass_1'],$text);
			$Sender = "DentistOnline <".$conf->contact_recipient.">";
			$Recipiant = addslashes($_POST['email']) ;
			$CustomHeaders = '';
			#send text email
			$Subject = "Contul dumneavostra a fost creat!";
			$message = new Email($Recipiant, $Sender, $Subject, $CustomHeaders);
			$message->SetHtmlContent($text);
			if (ValidHeader($Sender))
			{
				$message->Send();
			}
			$_SESSION['admin_info']="Bine ati venit - ".$user->username.". Acesta este panoul de administrare a ofertelor dvs.";
			header ('location: '.SITE_BASE.'/admin_utilizator/?page=user.listfirms');
			exit;
		}
	break;
	
	#login
	case 'login':
		if(isset($_POST['login']))
		{
			if ($user->Login($_POST['username'], $_POST['password']))
			{
				$_SESSION['userinfo'] = $user;
				header ('location: '.SITE_BASE.'/admin_utilizator/?page=user.listfirms');
				exit;
			}
			else 
			{
				$_SESSION['error']['message'] = 'Login incorect ! Va rugam incercati din nou.';
				$_SESSION['error']['type'] = 'error';
				header('location: '.$_SERVER['HTTP_REFERER']);
				exit;
			}
		}
		else
		{
			$tpl->set_file('tpl_main', "modules/".$module.'/login.tpl');
			$tpl->set_var('CONT_NOU', ReWrite("user","user.submit"));
			$tpl->set_var('USER_FORGOT_LINK', ReWrite("user","user.forgot"));
			$tpl->parse('MAIN', 'tpl_main');
		}

	break;

	#forgot password
	case 'forgot':
		$tpl->set_file("tpl_forgot", "./modules/user/forgot.tpl");
		#action var
		$tpl->set_var('USER_GENERATE_LINK',ReWrite('user', 'user.generate'));
		$tpl->parse("MAIN", "tpl_forgot");
	break;

	########################################### forgot password script - generate and send email to user ##########################################
	case 'generate':
		#insert the post variables in the User class vars
		$user->email = $_POST['email'];
		//echo $_POST['email'];exit;
		//$user->username = $_POST['username'];
		$user->security_code = $_POST['security_code'];
		$user->security_id = $_SESSION['security_code'];
		unset($_SESSION['security_code']);
		#validate the form
		$errors = array();
		$errors = $user->ValidateForgotForm();
	
		if (count($errors) != 0)
		{
			$display_errors = '';
			foreach ($errors as $val)
			{
				$display_errors .= '<li>'.$err_string[$val].'</li>';
			}
			$_SESSION['forgot_errors'] = $display_errors;
			$_SESSION['forgot_array'] = array('email' => ''.$_POST['email'].'');
			header ('location: '.GetReferer());
			exit;
		}
		#send new password to user
		$user->GeneratePassword();
		#send some kind of success msg
		$display_errors = '<li>Pe adresa de e-mail v-a fost trimis un mesaj cu noua parola.<br>
		!!!E-mailul cu noua parola poate fi si in folderul SPAM, va rugam sa verificati.</li>';
		$_SESSION['forgot_errors'] = $display_errors;
		header ('location: '.GetReferer());
		exit;
	break;
}
?>