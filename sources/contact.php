<?php
switch ($action)
{
	default :
		$tpl->set_file('tpl_contact', 'modules/contact/contact.tpl');
		#form target
		$tpl->set_var('CONTACT_US_ACTION', ReWrite('contact', 'contact.post'));
		$tpl->set_var('REFERER',  ReWrite('default', 'contact'));
		#get the custom form fields from the database and display them

		$tpl->set_var('SECURITYID', md5(time()));
		$tpl->parse('MAIN', 'tpl_contact');
	break;

	case 'post':
		$error = array(); $i = 0;
		$forms = GetForms('-1', 'active');
		#browser does not suport only numeric values for the field name
		#strip the "field_" tag from the $_POST array keys
		foreach ($_POST as $key => $val)
		{
			if($key!='referer')
			{
				$new_key = str_replace("field_", "", $key);
				$post_values[$new_key] = $val;
			}
		}
		#we have all the form fields from the database; now we go through every
		#item and see the proprieties and validate the post values
		while (list($key, $form_row) = each($forms))
		{
			#if the field is required : different for the checkboxes, because multiple post values
			switch ($form_row['type'])
			{
				default :
					if ($form_row['required'] == "Y")
					{
						#if the field type is a radio button and no option is selected,
						#the post array wont have that key, so we have an error
						if (!array_key_exists($form_row['id'], $post_values))
						{
							$error[$i] = $form_row['error_message'];
							$i++;
						}
						#if the key exists verify its content and content type
						else 
						{
							$content_info = VerifyContent($form_row['content_type'], $post_values[$form_row['id']]);
							#if there is something wrong display message
							if ($content_info == 'error')
							{
								$error[$i] = $form_row['error_message'];
								$i++;
							}
						}
					}
				break;

				case 'checkbox':
					#if checkbox field values are required
					if ($form_row['required'] == "Y")
					{
						if (!isset($post_values[$form_row['id']]))
						{
							$error[$i] = $form_row['error_message'];
							$i++;
						}
					}
				break;
			}
		}
		
		
		$check = SecurityImageGeneral($_POST['security_code2'], @$_SESSION['security_code']);
		unset($_SESSION['security_code']);
			
		if(!$check)
		{
			$error[$i+1] = "Codul de siguranta este gresit!"; 
		}
		
		#see if the $error array is !empty
		if (count($error) != '0')
		{
			$_SESSION['error']['type'] = 'error';
			$_SESSION['error']['post'] = $_POST;
			$_SESSION['error']['message'] = '';
			
			foreach ($error as $key => $value)
			{
				$_SESSION['error']['message'].=$value."<br>";
			}
			$goto = !empty($_POST['referer'])? $_POST['referer'] : ReWrite('default', 'home');
			header ('location: '.$goto);
			exit;
		}
		
		#insert messages into the DB, and send email to admin
		unset($post_values['security_code2']);
		//var_dump($post_values);exit;
		Contact($post_values);
		$_SESSION['error']['type'] = 'info';
		$_SESSION['error']['message'] = 'Mesajul a fost trimis cu succes, te rugam sa astepti un raspuns in urmatoarele 48h.';
		header ("HTTP/1.1 301 Moved Permanently");
		header ('location: '.ReWrite('default', 'contact'));
		exit;
	break;

	case 'abonament':
		if(!isset($_POST['nume']) || $_POST['nume']=='')
		{
			$tpl->set_file('tpl_contact', 'modules/contact/abonament.tpl');
			$tpl->set_var('ACTION',ReWrite('default', 'contact-abonament'));
			if(isset($_SESSION['request_abonament']))
			{
				$tpl->set_var('MESSAGE',"<h2 style='color:red;'>".$_SESSION['request_abonament']."</h2>");
				unset($_SESSION['request_abonament']);
			}

			$tpl->parse('MAIN', 'tpl_contact');
		}
		else
		{
			$text = "Cerere pachet Abonament \n";
			$text.= "***************************** \n";
			$text.= "Denumire firma/ Nume prenume:  ".$_POST['nume']."\n";
			$text.= "CUI/CNP:  ".$_POST['cnp']."\n";
			$text.= "Nr. Reg.Com:  ".$_POST['nr_reg']."\n";
			$text.= "Adresa:  ".$_POST['adresa']."\n";
			$text.= "Telefon:  ".$_POST['telefon']."\n";
			$text.= "E-mail:  ".$_POST['mail']."\n";
			$text.= "Observatii:  ".$_POST['obs']."\n";

			$text.= "Date:  ".date('Y-m-d H:i:s')."\n";
			$text.= "***************************** \n";
			#send email to admin
			$Sender = $_POST['nume']."<".$_POST['mail'].">";
			$Recipiant = 'admin@dentistonline.ro';
			$CustomHeaders ='';

			$Subject = 'Cerere pachet Abonament';
			$message = new Email($Recipiant, $Sender, $Subject, $CustomHeaders);
			$message->SetTextContent($text);
			$message->Send();

			$_SESSION['request_abonament'] = 'Cererea dvs a fost trimisa cu succes. Veti fi contactat in cel mai scurt timp, va multumim.';
			header ("HTTP/1.1 301 Moved Permanently");
			header ('location: '.ReWrite('default', 'contact-abonament'));
			exit;
		}
	break;

	case 'newsletter':
		if(strlen($_POST['email'])>4 && stristr($_POST['email'],'@')!==false && stristr($_POST['email'],'.')!==false)
		{
			$name = ucwords(strtolower($_POST['name']));
			$sql = "INSERT INTO newsletter(`name`, `email`, `date`, `ip`) VALUES('".mysql_real_escape_string($name)."', '".mysql_real_escape_string(trim($_POST['email']))."', '".date('Y-m-d')."', '".GetUserIP()."')";
			$db->query($sql);
			
			$_SESSION['error']['type'] = 'info';
			$_SESSION['error']['message'] = 'Din acest moment '.$name.', sunteti abonat la newsletter-ul DentistOnline ! Felicitari <span class="glyphicon glyphicon-thumbs-up"></span>';
		}
		else
		{
			$_SESSION['error']['type'] = 'error';
			$_SESSION['error']['message'] = 'Te rugam sa folosesti o adresa de email valida pentru abonare.';
		}
		header('Location: '.GetReferer());
		exit;
	break;

}
?>