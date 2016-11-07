<?php
class User
{
	var $id;
	var $username;
	var $email;
	var $firstname;
	var $lastname;
	var $last_login;
	var $max_cabinete;
	#class constructor
	function User()
	{
		global $conf;
		global $db;
		$query = "SELECT * FROM sessions WHERE sid='".session_id()."'";
		$db->query($query);
		if ($db->num_rows() == 0)
		{
			$query = "INSERT INTO sessions (sid, expire)
								VALUES ('".session_id()."', NOW()+INTERVAL '".$conf->user_session_period."' MINUTE)";
			$db->query($query);
		}
		else
		{
			#session already exists...
			$db->next_record();
			if ($db->f('user_id') == 0)
			{
				$_SESSION['userinfo'] = array();
				#update timeout
				$query = "UPDATE sessions SET
									expire = NOW()+INTERVAL '".$conf->user_session_period."' MINUTE
									WHERE sid = '".session_id()."'";
				$db->query($query);
			}
			else
			{
				#someone is logged in here...
				#look for non expired sessions for this user id in the login database...
				if (isset($_SESSION['userinfo']->id))
				{
					$query = "SELECT * FROM sessions
										WHERE user_id = '".(int)$_SESSION['userinfo']->id."'
										AND sid = '".session_id()."' AND expire > NOW()";
					$db->query($query);
					if ($db->num_rows() == 0)
					{
						#was logged once but expired now
						#turn expired session into guest session
						$_SESSION['userinfo'] = array();
						$query = "UPDATE sessions SET user_id = 0,
											expire = NOW()+INTERVAL '".$conf->user_session_period."' MINUTE
											WHERE sid = '".session_id()."'";
						$db->query($query);
						$_SESSION['login_error'] = 'Sesiunea a expirat !Logati-va din nou';
						header ('location: '.ReWrite("default", "?p=home"));
						exit;
					}
					else
					{
						#someone is corectly logged in with this session
						#update the login time so that it expires after $conf->user_session_period minutes of #_inactivity_
						$query = "UPDATE sessions SET
											expire = NOW()+INTERVAL '".$conf->user_session_period."' MINUTE
											WHERE id = '".$db->f('id')."'";
						$db->query($query);
					}
				}
				else
				{
					#invalid session file, possibly deleted and recreated on script execution
					$_SESSION['userinfo'] = array();
					$query = "UPDATE sessions SET user_id = 0,
										expire = NOW()+INTERVAL '".$conf->user_session_period."' MINUTE
										WHERE sid = '".session_id()."'";
					$db->query($query);
				}
			}
		}
	}

	#create a new account for a new user
	function AddUser ()
	{
		global $db;
		$query = "INSERT INTO users (username,
									 password,
									 email,
									 first_name,
									 last_name,
									 creation_date,
									 last_login,
									 status,
									 ip)
						VALUES ('".addslashes($this->username)."',
								'".md5(addslashes($this->pass_1))."',
								'".addslashes($this->email)."',
								'".addslashes($this->firstname)."',
								'".addslashes($this->lastname)."',
								now(),
								now(),
								'1', 
								'".GetUserIP()."')";
		$db->query($query);
		if ($db->affected_rows() == '1')
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	#updates the user info
	function UpdateUser ($user_id)
	{
		global $db;
		$query = "UPDATE users SET first_name = '".$this->firstname."',
															 last_name = '".$this->lastname."',
															 email = '".$this->email."'
							WHERE id = '".$user_id."'";
		$db->query($query);
		if ($db->affected_rows() == '1')
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	#check if the old password is fairly provided
	function CheckOldPassword ($password)
	{
		global $db;
		$query = "SELECT password FROM users WHERE id = '".$_SESSION['userinfo']->id."'";
		$db->query($query);
		$db->next_record();
		if ($db->f("password") == md5(addslashes($password)))
		{
			return false;
		}
		else 
		{
			return true;
		}
	}

	#change password
	function ChangePassword ($password)
	{
		global $db;
		if(($this->id=="")||(!isset($this->id)))
		{
			$query = "SELECT id FROM users
							WHERE email = '".trim($this->email)."'";
			$db->query($query);
			$db->next_record();
			$this->id = $db->f('id');
		}
		
		$query = "UPDATE users 
							SET password = '".md5(addslashes($password))."' 
							WHERE id = '".$this->id."'";
		$db->query($query);
		if ($db->affected_rows() == '1')
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	#verify the username and password. if it is a valid login, return an array with the user data
	function Login($username, $password)
	{
		global $conf;
		global $db;
		$query = "SELECT * FROM users
							WHERE username = '".addslashes($username)."' AND password = '".md5(addslashes($password))."'";
		$db->query($query);
		if ($db->num_rows() == 1)
		{
			$db->next_record();
			#check the status of the users account
			if ($db->f("status") == '0')
			{
				$_SESSION["login_error"] = "Nu va puteti loga ! Contul dvs. este inactiv";
				header ('location: '.GetReferer());
				exit;
			}
			#save account info
			$this->id = $db->f('id');
			$this->username = $db->f('username');
			$this->firstname = $db->f('first_name');
			$this->lastname = $db->f('last_name');
			$this->email = $db->f('email');
			$this->last_login = $db->f('last_login');
			$this->max_cabinete = $db->f('max_cabinete');

			#next we update lastlogin from users table
			$query = " UPDATE users SET last_login = now() 
									WHERE id = '".$this->id."'";
			$db->query($query);
			#log login event
			$query="INSERT INTO logins (user_id,
																	date,
																	ip,
																	refferer,
																	user_agent)
														VALUES ('".intval($this->id)."',
																		now(),
																		'".addslashes(GetUserIp())."',
																		'".addslashes(GetReferer())."',
																		'".addslashes(GetUserAgent())."')";
			$db->query($query);
			#update sessions table
			$query="UPDATE sessions SET user_id = ".$this->id.",
														expire = now() + INTERVAL '".$conf->user_session_period."' MINUTE
							WHERE sid = '".session_id()."'";
			$db->query($query);
			return true;
		}
		else
		{
			return false;
		}
	}

	#logout
	function Logout()
	{
		global $conf;
		global $db;
		$_SESSION['userinfo'] = array();
		$query = "UPDATE sessions SET user_id = 0,
							expire = NOW()+INTERVAL '".$conf->user_session_period."' MINUTE
							WHERE sid = '".session_id()."'";
		$db->query($query);
	}

	#the username must be unique
	function UsernameExists($username)
	{
		global $db;
		$query = "SELECT id FROM users WHERE username LIKE '%".$username."%'";
		$db->query($query);
		if($db->num_rows() == 1)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	#the email must be unique; no user can have 2 accounts with the same email
	function EmailExists($email)
	{
		global $db;
		$query = "SELECT id FROM users WHERE email = '".$email."'";
		$db->query($query);
		if($db->num_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	#verify if the email is like user@domain.com
	function EmailValid($email)
	{
		if (!preg_replace("/^[\.A-z0-9_\-\+]+[@][A-z0-9_\-]+([.][A-z0-9_\-]+)+[A-z]{1,4}$/", $email)) 
		{
			return false;
		}
		else return true; 
	}

	#check security code
	function SecurityImage()
	{
		global $db;
		$query = "SELECT * FROM security_codes 
							WHERE id = '$this->security_id' AND code='$this->security_code'";
		$db->query($query);
		if($db->num_rows() == 1)
		{
			return false;
		}
		else
		{
			return true;
		}
	}

	#validate the information, and return the error number
	function ValidateSignup ()
	{
		global $conf;
		$err_number = array();
		#if firstname is empty
		if (trim($this->firstname) == "")
		{
			$err_number[] = 0;
		}
		#if lastname is empty
		if (trim($this->lastname) == "")
		{
			$err_number[] = 1;
		}
		#check email validity
		if ($this->EmailValid($this->email))
		{
			$err_number[] = 2;
		}

		
		#check for illegal characters in username ; only letters and numbers allowed
		if (!eregi("^[0-9a-z]+$", $this->username))
		{
			$err_number[] = 3;
		}
		#username lenght
		$username_lenght = strlen($this->username);
		if ($username_lenght < $conf->min_user_len)
		{
			$err_number[] = 4;
		}
		if ($username_lenght > $conf->max_user_len)
		{
			$err_number[] = 5;
		}
		#check if the username already exists
		if ($this->UsernameExists($this->username))
		{
			$err_number[] = 6;
		}
		#password not empty
		if (trim($this->pass_1) == "" || trim($this->pass_2) == "")
		{
			$err_number[] = 7;
		}
		#matching passwords
		elseif ($this->pass_1 != $this->pass_2)
		{
			$err_number[] = 8;
		}
		else 
		{
			#lenght of password
			$pass_lenght = strlen($this->pass_1);
			if ($pass_lenght > $conf->max_pass_len)
			{
				$err_number[] = 9;
			}
			if ($pass_lenght < $conf->min_pass_len)
			{
				$err_number[] = 10;
			}
		}
		#check security id
		if ($this->SecurityImage())
		{
			$err_number[] = 11;
		}
		#check if the email does not already exist in db
		if ($this->EmailExists($this->email))
		{
			$err_number[] = 12;
		}
		return $err_number;
	}

	#validate the forgot form
	function ValidateForgotForm ()
	{
		global $conf;
		$err_number = array();
		#check email validity
		if ($this->EmailValid($this->email))
		{
			$err_number[] = 2;
		}
		#check for illegal characters in username ; only letters and numbers allowed
		/* if (!eregi("^[0-9a-z]+$", $this->username))
		{
			$err_number[] = 3;
		} */
		#check security id
		if ($this->SecurityImage())
		{
			$err_number[] = 11;
		}
		#if the form until now its good check to see if the info exists in database
		if (count($err_number) == 0)
		{
			//print_r($this->EmailExistence());exit;
			if ($this->EmailExistence()!='1')
			{
				$err_number[] = 13;
			}
		}
		return $err_number;
	}

	#function used to see if the user and given info realy exists
	function EmailExistence()
	{
		global $db;
		$query = "SELECT id FROM users WHERE email = '".trim($this->email)."'";
		//echo $query;exit;
		$db->query($query);
		if($db->num_rows() == 1)
		{
			
			return true;
		}
		else
		{
			return false;
		}
	}

	#generate new random password and send a email to the user
	function GeneratePassword ()
	{
		$maxlen = 6;
		$crypt = strtotime("+ 10 seconds");
		$crypt = substr($crypt,8,6);
		$username_crypt = crypt($this->username, $crypt);
		$username_crypt = stripslashes($username_crypt);
		$generated_password = substr($username_crypt, 0, $maxlen);
		#first change password in the database
		global $user;
		$user->ChangePassword($generated_password);
		#now send a message to the user with the new password using the function bellow
		$user->SendPasswordToUser($generated_password);
	}
	
	
	#send email to the user
	function SendPasswordToUser ($generated_password)
	{
		global $conf;
		global $db;
		$query = "SELECT username FROM users
							WHERE email = '".$this->email."'";
		$db->query($query);
		$db->next_record();
		$this->username = $db->f('username');
		$username_bd =  $db->f('username');
		#get the template file for the message

		$text = GetFileContent('./templates/emails/user_password.tpl');
		#replace the tags with the info*/
		$text = str_replace("%USERNAME%", $username_bd , $text);
		$text = str_replace("%PASSWORD%", $generated_password, $text);

		$Sender = 'Admin DentistOnline.ro<'.$conf->contact_recipient.'>';
		$Recipiant = $this->email;
		$CustomHeaders = '';

		$Subject = 'Noua parola';
		$message = new Email($Recipiant, $Sender, $Subject, $CustomHeaders);
		$message->SetHtmlContent($text);
		$message->Send();
	}
	
	#validate change of old password and new inserted passwords
	function ValidateChangePassword ()
	{
		global $user;
		global $conf;
		$err_number = array();
		#old password
		if ($user->CheckOldPassword($this->password))
		{
			$err_number[] = 14;
		}
		#password not empty
		if (trim($this->pass_1) == "" || trim($this->pass_2) == "")
		{
			$err_number[] = 15;
		}
		#matching passwords
		elseif ($this->pass_1 != $this->pass_2)
		{
			$err_number[] = 8;
		}
		else 
		{
			#lenght of password
			$pass_lenght = strlen($this->pass_1);
			if ($pass_lenght > $conf->max_pass_len)
			{
				$err_number[] = 9;
			}
			if ($pass_lenght < $conf->min_pass_len)
			{
				$err_number[] = 10;
			}
		}
		return $err_number;
	}

	#validate account information on user change
	function ValidateChangeAccountInfo ()
	{
		global $user;
		$err_number = array();
		#if firstname is empty
		if (trim($this->firstname) == "")
		{
			$err_number[] = 0;
		}
		#if lastname is empty
		if (trim($this->lastname) == "")
		{
			$err_number[] = 1;
		}
		#if the new provided email address is valid
		if ($this->EmailValid($this->email))
		{
			$err_number[] = 2;
		}
		#if the new email does not exist at other user
		if ($user->NewEmailExists($this->email, $_SESSION['userinfo']->id))
		{
			$err_number[] = 16;
		}
		return $err_number;
	}

	#if the new email does not exist at other user
	function NewEmailExists ($email, $id)
	{
		global $db;
		$query = "SELECT email FROM users WHERE id != '".$id."' AND email = '".$email."'";
		$db->query($query);
		if ($db->num_rows() == 0)
		{
			return false;
		}
		else 
		{
			return true;
		}
	}

	#check if the old password is fairly provided
	function GetPassword ()
	{
		global $db;
		$query = "SELECT password FROM users WHERE id = '".$_SESSION['userinfo']->id."'";
		$db->query($query);
		$db->next_record();
		return $db->f("password");
	}
	
	/*
	 ** here we validate the short form from the oferta page !
	*/
	public function ValidateFastSignup()
	{
		global $conf;
		$err_number = array();
		#if firstname is empty
		if (trim($this->firstname) == "")
		{
			$err_number[] = 0;
		}
		#if lastname is empty
		if (trim($this->lastname) == "")
		{
			$err_number[] = 1;
		}
		#check email validity
		if ($this->EmailValid($this->email))
		{
			$err_number[] = 2;
		}
	
		#check if the username already exists
		if ($this->EmailExistence())
		{
			$err_number[] = 12;
		}
		#password not empty
		if (trim($this->pass_1) == "")
		{
			$err_number[] = 7;
		}
		else
		{
			#lenght of password
			$pass_lenght = strlen($this->pass_1);
			if ($pass_lenght > $conf->max_pass_len)
			{
				$err_number[] = 9;
			}
			if ($pass_lenght < $conf->min_pass_len)
			{
				$err_number[] = 10;
			}
		}
		#check security id
		if ($this->SecurityImage())
		{
			$err_number[] = 11;
		}
		return $err_number;
	}
	
	function generateUsername()
	{
		$username = trim($this->firstname).' '.trim($this->lastname);
		$username = preg_replace("/[^a-zA-Z0-9_ -]+/", "", html_entity_decode($username, ENT_QUOTES));
		$username = str_replace(' ', '.', $username);
		if($this->UsernameExists($username))
		{
			for ($i = 1; $i < 11; $i++)
			{
				$username.='.'.$i;
				if(!$this->UsernameExists($username))
				{
					$this->username = $username;
					return $username;
				}
			}
		}
		else 
		{
			$this->username = $username;
			return $username;
		}
	}
	
	function AddFastUser()
	{
		global $db;
		$query = "INSERT INTO users (username,
									 password,
									 email,
									 first_name,
									 last_name,
									 creation_date,
									 last_login,
									 status,
									ip)
						VALUES ('".$this->generateUsername()."',
								'".md5(addslashes($this->pass_1))."',
								'".addslashes($this->email)."',
								'".addslashes($this->firstname)."',
								'".addslashes($this->lastname)."',
								now(),
								now(),
								'1',
								'".GetUserIP()."')";
		$db->query($query);
		if ($db->affected_rows() == '1')
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
}






/*  here starts other functions !!!  */

function GetUserName($val)
{
	global $db;
	$query ="Select username from users where id='".$val."'";
	$db->query($query);
	$db->next_record();
	return $db->f('username');
	
}
function GetUsernameId($val)
{
	global $db;
	$query ="Select id from users where lower(username)='".strtolower($val)."'";
	$db->query($query);
	$db->next_record();
	return $db->f('id');
	
}
function ChechIfHasfirmAdd($user_id)
{
	global $db;
	$query ="Select user_id from cabinete where user_id='".$user_id."'";
	//	$query ="Select user_id from cabinete where user_id='".$user_id."' and date_sub(creation_date,interval  '5' minutes)>0";
	$db->query($query);
	if($db->affected_rows()>0)
	{
		return true;
	}
	return false;
	
}
function SavePicturesMap ($file_extension, $id,$front_back)
{
	global $conf;	global $db;
	
	if($front_back=="frontend")
	{			$uploaddir = '../images/users_cabinete/'.$id.'/'; }
	else
	{			$uploaddir = '../images/users_cabinete/'.$id.'/';}

	if(is_dir($uploaddir))
	{		chmod($uploaddir,0777);	}
	else
	{
		mkdir($uploaddir, 0777);
		chmod($uploaddir, 0777);
	}

	
		/*create photo name*/
		$today = date("Ymd");
		$filename = 'cabinete_'.$today.'_harta_'.$id.'.'.$file_extension;

		$filename = $_FILES['picture_harta']['name'];
		$filename = GenerateImageNameCabinete($filename);
		$uploadfile = $uploaddir.$filename;
		/*do query*/
		$sql = "INSERT INTO images(`image_name`, `folder_id`,`type`,`position`) VALUES ('".$filename."','".$id."','harta','22')";
		$db->query($sql);

			#lets insert to reseze table images
							$sql2 = "INSERT INTO resize_img_cron(`id`, `image_name`, `item_id`, `size`, `status`, `date`) VALUES ('','".$filename."','".$id."','".$_FILES['picture_harta']['size']."','N','')";
							$db->query($sql2);

		/*upload picture*/
		if (!move_uploaded_file($_FILES['picture_harta']['tmp_name'], $uploadfile))
		{
			print "Possible file upload attack!  Here's some debugging info:\n";
			print_r($_FILES);
		}
		chmod($uploaddir,0777);
}

function CheckAcceslink($acces_link)
{
	global $db;
	$query="Select * from users_messages_links where acces_link='".$acces_link."'";
	$db->query($query);
	$db->next_record();
	if($db->affected_rows()<1)
	{
		#means we didn't foun the link in our data base
		return false;
	}
	return true;
}
#OTHER RELATED FUNCTIONS
function GetUserModuleTitleNTags ($conf_var)
{
	$result = array();
	
	global $conf;
	$config = "user_".$conf_var."_page";
	if(!isset($conf->$config))
	{
		//$result['title'] = "Detalii plati, facturi, contracte";
		$result['title'] = "Galerie imagini";
		if($conf_var=='trimitemail')
		{
			$result['title'] = "Trimite mesaj";
		}
		if($conf_var=='detaliimesaj')
		{
			$result['title'] = "Mesaj detaliat";
		}
		if($conf_var=='mesaje')
		{
			$result['title'] = "Mesajele mele";
		}
		if($conf_var=='cabinete')
		{
			$result['title'] = "Cabinete stomatologice, laboratoare, clinici stomatologie recent vizitate";
		}
		
	}
	else
	{
		$result['title'] = $conf->$config;
	}
	
	$result['keywords'] = $conf->def_meta_keywords;
	$result['description'] = $conf->def_meta_description;
	return $result;
}

function CheckUserPrivileges ($module, $action)
{
	
	#the pages from the user.php that need login to be viewed
	//print_r($_SESSION['login_error']);exit;
	//echo $module."-".$action;exit;
	$user_unprivileged_pages = array("home", "account", "save_changes", "password", "save_password","addfirm","insertfirma","listfirms","editfirme","updatefirma","addanunt","insertanunt","listanunturi","editanunt","updateanunt","deleteanunt");
	if ($module == "user" and in_array($action, $user_unprivileged_pages))
	{
		if ((!isset($_SESSION['userinfo']->id) || $_SESSION['userinfo']->id=="") && !isset($_SESSION['login_error']))
		{
			return "Acces interzis ! Va rugam sa va logati";
		}
	}

}
###################################################ADD,Modify CAbinete Functions#######################################
function InsertPartFromFirma($nume_firma,$user_id,$type,$perioada)
{
	global $db;
	global $conf;
	$get_alias = GenerateAlias($nume_firma);
	
	$expire_date = date("y-m-d", mktime(0, 0, 0, date("m"), date("d"), date("Y")+$perioada));
	$query ="INSERT INTO cabinete (nume_firma,user_id,submision_date,meta_description,meta_keywords,type,expire_date,alias) values('".addslashes($nume_firma)."','".$user_id."',now(),'".$conf->def_meta_description."','".$conf->def_meta_keywords."','".$type."','".$expire_date."','".$get_alias."')";
	$db->query($query);
	return $db->last_insert_id();
}
function CheckNumeFirma($nume_firma)
{
	global $db;
		$query = "SELECT * FROM cabinete WHERE nume_firma= '".addslashes($nume_firma)."'";
		$db->query($query);
		if($db->affected_rows()>0)
		{
			return "<li> Acest nume de firma exista deja <li>";
		}
		
}
function GetFirme($user_id,$firm_id=-1)
{
		global $db;$info=array();$i=0;
		switch($firm_id)
		{
			default:
				$query = "SELECT * FROM cabinete WHERE user_id= '".$user_id."' and id='".$firm_id."'  order by submision_date DESC";
			break;
			case '-1':
					$query = "SELECT * FROM cabinete WHERE user_id= '".$user_id."'   order by submision_date DESC";
			break;
		}
	
		$db->query($query);
		while($db->next_record())
		{
			$info[$i]['id'] = $db->f('id');
			$info[$i]['category_id'] = $db->f('category_id');
			$info[$i]['nume_firma'] = $db->f('nume_firma');
			$info[$i]['descriere'] = $db->f('descriere');
			$info[$i]['date'] = $db->f('submision_date');
			$info[$i]['idfirma'] = $db->f('id');
			$info[$i]['tarife']=$db->f('tarife');
			$info[$i]['orar']=$db->f('orar');
			$info[$i]['adresa_web']=$db->f('adresa_web');
			$info[$i]['echipa_medicala']=$db->f('echipa_medicala');
			$info[$i]['inreg_fiscala_cnp']=$db->f('inreg_fiscala_cnp');
			$info[$i]['reg_comert_bi']=$db->f('reg_comert_bi');
			$info[$i]['judet']=$db->f('judet');
			$info[$i]['nume_loc_sector']=$db->f('nume_loc_sector');
			$info[$i]['fax']=$db->f('fax');
			$info[$i]['pers_contact']=$db->f('pers_contact');
			$info[$i]['persc_email']=$db->f('persc_email');
			$info[$i]['email_firma']=$db->f('email_firma');
			$info[$i]['persc_tel']=$db->f('persc_tel');
			$info[$i]['persc_adresa']=$db->f('persc_adresa');
			$info[$i]['zip_code']=$db->f('zip_code');
			$info[$i]['adresa_firma']=$db->f('adresa_firma');
			$info[$i]['status']=$db->f('status');
			$info[$i]['submision_date']=TimeFormatShort($db->f('submision_date'));
			$info[$i]['expire_date'] = TimeFormatShort($db->f('expire_date'));
			$info[$i]['perioada']=$db->f('perioada');
			$info[$i]['type']=$db->f('type');
			$info[$i]['alias']=$db->f('alias');
			$info[$i]['comment']=$db->f('comment');
			$info[$i]['phone_views']=$db->f('phone_views');
			$info[$i]['nr_visits']=$db->f('nr_visits');
			$info[$i]['level']=$db->f('level');
			$info[$i]['recomandat']=$db->f('recomandata');
			$info[$i]['meta_keywords']=$db->f('meta_keywords');
			$info[$i]['home_page']=$db->f('home_page');
			$info[$i]['meta_description']=$db->f('meta_description');

				$i++;
		}
		return $info;
}

function CheckPictureItemHarta()
{
	global $conf;
	$allowed_types = array("image/pjpeg","image/jpeg","image/png","image/gif");
	$allowed_extension = array("jpg","jpeg","gif","png");
	
	$ext = explode(".",$_FILES['picture_harta']['name']);
	$extension = strtolower($ext[count($ext)-1]); // the real extension of the image !!!
	
	if(in_array($_FILES['picture_harta']['type'], $allowed_types) && ($_FILES['picture_harta']['name']!="") && in_array($extension, $allowed_extension))
	{
		
		return 'ok';
	}
	else 
	{
		/*not a valid file type*/
		return '0';
	}
}
#we just insert images
function changemode()
{
	$uploaddir = './betaversion/';
	chmod($uploaddir,0777);
}

function InsertCabinetToCat($id_cabinet , $big_cat_id , $judet_code)
{
	global $db;
	$query ="Select * from cabinete_categories where parent_module='".$big_cat_id."' and cat_code='".$judet_code."'";
	$db->query($query);
	$db->next_record();
	
	if($db->affected_rows()<1)
	{
		#we hav to creat our small category (bihor,alba,arad judetele sunt small categories)
		$query = "Select name from judete where code='".$judet_code."'";
		$db->query($query);
		$db->next_record();
		$judet_name = $db->f('name');
		
		#insert into cabinete_categories
		$query="INSERT into cabinete_categories (cat_name,parent_module,active,cat_code) values ('".$judet_name."','".$big_cat_id."','Y','".$judet_code."')";
		$db->query($query);
		
		$small_cat_id = $db->last_insert_id();
	}
	else
	{
			$small_cat_id = $db->f('id_cat');
	}

	$query="INSERT into cabinete_cat (cabinet_id, cat_id) values ('".$id_cabinet."','".$small_cat_id."')";
	$db->query($query);
}
function UpdateCabinetToCat($id_cabinet , $big_cat_id , $judet_code)
{
	global $db;
	$query ="Select * from cabinete_categories where parent_module='".$big_cat_id."' and cat_code='".$judet_code."'";
	$db->query($query);
	$db->next_record();
	
	if($db->affected_rows()<1)
	{
		#we hav to creat our small category (bihor,alba,arad judetele sunt small categories)
		$query = "Select name from judete where code='".$judet_code."'";
		$db->query($query);
		$db->next_record();
		$judet_name = $db->f('name');
		
		#insert into cabinete_categories
		$query="INSERT into cabinete_categories (cat_name,parent_module,active,cat_code) values ('".$judet_name."','".$big_cat_id."','Y','".$judet_code."')";
		$db->query($query);
		
		$small_cat_id = $db->last_insert_id();
	}
	else
	{
			$small_cat_id = $db->f('id_cat');
	}

	$query="Update cabinete_cat set cat_id='".$small_cat_id."' where cabinet_id='".$id_cabinet."'";
	$db->query($query);
}

function getCabinetNumeFirma($cab_id)
{
	global $db;
	$sql = "SELECT nume_firma FROM cabinete WHERE id='$cab_id'";
	$db->query($sql);
	$db->next_record();
	return $db->f('nume_firma');
}

########################################MESAJE FUNCTIONS ###########################################

function  GetMesaje($user_id,$msj_id)
{
	global $db;$info=array();$i=0;
	switch($msj_id)
	{
		default:
				$query = "SELECT * FROM mesaje_utilizator WHERE user_id='".$user_id."' and id='".$msj_id."' order by submision_date DESC";
		break;
		
		case 'all':
			$query = "SELECT * FROM mesaje_utilizator WHERE user_id='".$user_id."' order by submision_date DESC";
		break;
	}
	
		$db->query($query);
		while($db->next_record())
		{
			$info[$i]['id'] = $db->f('id');
			$info[$i]['status'] = $db->f('status');
			$info[$i]['submision_date'] = $db->f('submision_date');
			$info[$i]['id_cabinet'] = $db->f('id_cabinet');
			$info[$i]['subiect'] = $db->f('subiect');
			$info[$i]['mesaj'] = $db->f('mesaj');
			$info[$i]['telefon'] = $db->f('telefon');
			$info[$i]['user_id'] = $db->f('user_id');
			$info[$i]['email_utilizator'] = $db->f('email_utilizator');
			$info[$i]['nume_utilizator'] = $db->f('nume_utilizator');
			$i++;
		}
		return $info;
}
function GetMesajDetails($msj_id)
{

	global $db;$info=array();$i=0;

	$query = "SELECT * FROM mesaje_utilizator WHERE id='".$msj_id."' order by submision_date DESC";
	$db->query($query);
		while($db->next_record())
		{
			$info[$i]['id'] = $db->f('id');
			$info[$i]['submision_date'] = $db->f('submision_date');
			$info[$i]['id_cabinet'] = $db->f('id_cabinet');
			$info[$i]['subiect'] = $db->f('subiect');
			$info[$i]['mesaj'] = $db->f('mesaj');
			$info[$i]['user_id'] = $db->f('user_id');
			$info[$i]['email_utilizator'] = $db->f('email_utilizator');
			$info[$i]['nume_utilizator'] = $db->f('nume_utilizator');
			$info[$i]['type'] = $db->f('type');
			$i++;
		}
		return $info;

}
?>