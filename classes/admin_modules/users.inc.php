<?php

function DeleteMesaj($id_msj)
{
	global $db;
	$query="Delete from mesaje_utilizator where id='".$id_msj."'";
	$db->query($query);
	return 1;
}
function ChangeMesajStatus ($new_status, $id,$acces_link)
{
	global $db;
	switch ($new_status)
	{
		case 'active':
			global $conf;
			$status = 'Y';
			#"daca aprobam un mesaj sa si trimitem un email destinatarulului"
			$msj_details = GetMesajDetails($id);
			$id_cabinet = $msj_details[0]['id_cabinet'];
			
			if($msj_details[0]['type']=="cabinete")
			{
				$get_cab_info = GetSelectedCabinet($id_cabinet);
				$cont_type = "oferta";
			}
			elseif($msj_details[0]['type']=="anunturi")
			{
				$get_anunt_info = GetAnunturi('-1',$id_cabinet);
				$get_cab_info['nume_firma'] = $get_anunt_info[0]['titlu'];
				$get_cab_info['pers_contact'] =  $get_anunt_info[0]['autor'];
				$get_cab_info['persc_email'] =  $get_anunt_info[0]['email'];
				$cont_type = "anuntul";
			}
			else
			{
				$get_article_info = GetArticole('-1',$id_cabinet);
				$get_cab_info['nume_firma'] = $get_article_info[0]['titlu'];
				$get_cab_info['pers_contact'] = $get_article_info[0]['autor'];
				$get_cab_info['persc_email'] = $get_article_info[0]['email'];
				$cont_type = "articolul";
			}
						
			$email_content = $msj_details[0]['mesaj'];
			$subject = $msj_details[0]['subiect'];
			$email_utilizator = $msj_details[0]['email_utilizator'];
			$nume_utilizator = $msj_details[0]['nume_utilizator'];
						
			#trimite email clientului ca a primit un mesaj pe dentistonline.ro!!
			$text = GetFileContent('../templates/emails/mesajutilizator.tpl');
			$text = str_replace("%OFERTA_CABINET%", $get_cab_info['nume_firma'], $text);
			$text = str_replace("%PERSOANA_CONTACT%", $get_cab_info['pers_contact'] , $text);
			$text = str_replace("%CONTENT_TYPE%", $cont_type , $text);
			
			$text = str_replace("%CODED_LINK%", $acces_link , $text);
			$text = str_replace("%LINK%", "http://www.dentistonline.ro/citeste_mesaje.html" , $text);
			
			$CustomHeaders = '';
			$Sender = 'DentistOnline.ro<'.$conf->contact_recipient.'>';
			$Subject = "Ati primit un mesaj pe Dentistonline.ro ";

			$Recipiant = array();
			$Recipiant[0] = $get_cab_info['persc_email'];		
			if(isset($get_cab_info['email_firma']) && ($get_cab_info['email_firma'] != $get_cab_info['persc_email']))
			{
				$Recipiant[0] = $get_cab_info['persc_email'];		
				$Recipiant[1] = $get_cab_info['email_firma'];		
			}

			for($i = 0; $i < count($Recipiant) ; $i++)
			{
				$message = new Email($Recipiant[$i], $Sender, $Subject, $CustomHeaders);
				$message->SetHtmlContent($text);
				if (ValidHeader($Sender))
				{
					$message->Send();
				}
			}
		break;

		case 'inactive':
			$status = 'N';
		break;
	}
	$query = "UPDATE mesaje_utilizator SET status = '".$status."'
						WHERE id = '".$id."'";
	$db->query($query);
	return '0';
}
function GetUserDetails($user_id)
{
	global $db;
	$query = "SELECT * FROM users where id = '".$user_id."' ";		
	
	$db->query($query);
	$db->next_record();
	$users = array();

	$users['username'] = $db->f("username");
	$users['email'] = $db->f("email");
	$users['first_name'] = $db->f("first_name");
	$users['last_name'] = $db->f("last_name");
	$users['creation_date'] = $db->f("creation_date");
	$users['last_login'] = $db->f("last_login");
	$users['status'] = $db->f("status");

	return $users;
	
}

#user related functions
function CountUsers ($list_by,$users_type)
{
	global $db;
	$how_to_list1 = explode("_",$list_by);
	
	if($how_to_list1[0]=="username")
	{		$how_to_list = $how_to_list1[0];	}
	else
	{		$how_to_list = $how_to_list1[0]."_".$how_to_list1[1];	}

	$how_to_list_ascdesc = $how_to_list1[2];
	switch($users_type)
	{
		default:
		$query = "SELECT COUNT(id) as total_users FROM users where status = '".$users_type."' order by ".$how_to_list." ".$how_to_list_ascdesc;		
		break;

		case 'all':
				$query = "SELECT COUNT(id) as total_users FROM users order by ".$how_to_list." ".$how_to_list_ascdesc;		
		break;
	}
	
	$db->query($query);
	$db->next_record();
	return $db->f("total_users");
}
function  GetUser($id_user)
{
	global $db;
		$query = "SELECT * FROM users where id='".$id_user."'";		
	$db->query($query);
	$users = array();
	$db->next_record();
	
	$username = $db->f("username");
	return $username;
}

function GetUsers ($list_by, $users_type, $query_limit)
{
	global $db;
	$how_to_list1 = explode("_",$list_by);
	
	if($how_to_list1[0]=="username")
	{		$how_to_list = $how_to_list1[0];	}
	else
	{		$how_to_list = $how_to_list1[0]."_".$how_to_list1[1];	}

	$how_to_list_ascdesc = $how_to_list1[2];
	switch($users_type)
	{
		default:
		$query = "SELECT * FROM users where status = '".$users_type."' order by ".$how_to_list." ".$how_to_list_ascdesc." ".$query_limit;		
		break;

		case 'all':
				$query = "SELECT * FROM users order by ".$how_to_list." ".$how_to_list_ascdesc." ".$query_limit;		
		break;
	}
	$db->query($query);
	$users = array();
	$i = 0;
	while ($db->next_record())
	{
		$users[$i]['id'] = $db->f("id");
		$users[$i]['username'] = $db->f("username");
		$users[$i]['email'] = $db->f("email");
		$users[$i]['first_name'] = $db->f("first_name");
		$users[$i]['last_name'] = $db->f("last_name");
		$users[$i]['creation_date'] = $db->f("creation_date");
		$users[$i]['last_login'] = $db->f("last_login");
		$users[$i]['status'] = $db->f("status");
		$i++;
	}
	return $users;
}

function ChangeUserStatus ($new_status, $id)
{
	global $db;
	switch ($new_status)
	{
		case 'active':
			$status = '1';
		break;

		case 'inactive':
			$status = '0';
		break;
	}
	$query = "UPDATE users SET status = '".$status."'
						WHERE id = '".$id."'";
	$db->query($query);
	return '0';
}

function DeleteUserAccount ($id)
{
	global $db;
	$query = "DELETE FROM users WHERE id = '".$id."'";
	$db->query($query);
	$query = "OPTIMIZE TABLE `users`";
	$db->query($query);
	#delete logins
	$query = "DELETE FROM logins WHERE user_id = '".$id."'";
	$db->query($query);
	$query = "OPTIMIZE TABLE `logins`";
	$db->query($query);
}

function CountUserLogins($user_id)
{
	global $db;
	switch ($user_id)
	{
		default :
			$query = "SELECT COUNT(id) as total_logins FROM logins
								WHERE user_id = '".intval($user_id)."'";
		break;

		case '-1':
			$query = "SELECT COUNT(id) as total_logins FROM logins
								WHERE user_id != '0'";
		break;
	}
	$db->query($query);
	$db->next_record();
	return $db->f("total_logins");;
}
function GenerateAccesLink($user_id,$message_id)
{
	global $db;

	$a = rand(123,32768);
	$code = md5($a);
	$acces_link ="http://www.dentistonline.ro/user-readmessage-".$user_id."-".$message_id."-".substr($code,0,7).".html";
	$query="Insert into users_messages_links  (user_id,acces_link) values('".$user_id."','".$acces_link."')";
	$db->query($query);
	return $acces_link;

}
?>