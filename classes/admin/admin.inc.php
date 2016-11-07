<?php

class Admin
{
	var $username;
	var $last_login;
	var $email;
	var $password;
	var $ip;
	var $user_agent;

	#
	# @function Login
	#	@abstract - verify the username and password.  if it is a valid login, return an array with the #user data and write all in the $SESSIONID  as array
	#
	function Login ($username, $password, $ip)
	{
		global $db;
		$username = addslashes($username);
		$password = addslashes($password);
		$ip = addslashes($ip);
		$query = "SELECT * FROM admin_accounts
							WHERE user = '$username' AND pasw = '".md5($password)."'";
		$db->query($query);
		$login = $db->num_rows();
		$db->next_record();
		if ($login == '1')
		{
			$this->userID = $db->f("id");
			$this->username = $db->f("user");
			$this->password = $db->f("pasw"); 
			$this->last_login = $db->f("last_login");
			$this->level = $db->f("level");

			#
			#update last login
			$query = "UPDATE admin_accounts SET last_login=now() WHERE user ='$username'";
			$db->query($query);

			# update login table
			$query = "INSERT INTO admin_login (ip, user_id, username,  user_agent, data) 
								VALUES ('$this->ip', '$this->userID', '$this->username', '$this->user_agent',now())";
			$db->query($query);
			return $login;
		}
		else
		{
			return false;
		}
	}
}

function getAdminType($level)
{
	global $db;
	$sql = "SELECT name FROM admin_level WHERE id='$level'";
	$db->query($sql);
	$db->next_record();
	return $db->f('name');
}

?>