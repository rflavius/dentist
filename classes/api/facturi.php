<?php
/*
 * here we have all functions for payment and billing
 */

class Facturi extends Pachete_Servicii
{
	public function addAdminProforma($user_id,$id_firma,$post,$recomandata,$cump_id)
	{
		global $conf;
	
		#it's about 5 working days
		$day = date("D");
		if(($day=="Sun")||($day=="Dum"))
		{
		$data_expirarii = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d")+$conf->expirare_proforma, date("Y")));
		}
		elseif(($day=="Sat")||($day=="Sam"))
		{
				$data_expirarii = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d")+$conf->expirare_proforma+1, date("Y")));
		}
		else
		{
		$data_expirarii = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d")+$conf->expirare_proforma+2, date("Y")));
		}
	
		if($post['pachet']==1)
		{
			$servicii = $post['servicii'];
		}
		else
		{
			$servicii='';
		}
	
		$pk_info = $this->getPachetInfo($post['pachet']);
	
		$query ="INSERT INTO facturi_proforme (
								`user_id`,
								`firma_id`,
								`nume_firma`,
								`perioada`,
								`type`,
								`emis_fact_proforma`,
								`achitat`,
								`cost`,
								`adaugare_proforma`,
								`expirare_proforma`,
								`status`,
								`content`,
								`email`,
								`cumparator_id`,
								`recomandata`,
								`tip_promovare`,
								`servicii_promovare`
								)
						VALUES('".$user_id."',
								'".$id_firma."',
								'".addslashes($post['nume_firma'])."',
								'".$pk_info['luni']."',
								'".$post['type']."',
								'Y',
								'N',
								'".$post['total_price']."',
								now(),
								'".$data_expirarii."',
								'Y',
								'".$post['serviciu']."',
								'".$post['persc_email']."',
								'$cump_id',
								'$recomandata',
								'".$post['pachet']."',
								'$servicii'
								)";
		$this->db->query($query);
		return $this->db->last_insert_id();
	}
	
	public function addProforma($user_id,$id_firma,$post,$recomandata,$cump_id)
	{
		global $conf;
		
		#it's about 5 working days
		$day = date("D");
		if(($day=="Sun")||($day=="Dum"))
		{
			$data_expirarii = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d")+$conf->expirare_proforma, date("Y")));
		}
		elseif(($day=="Sat")||($day=="Sam"))
		{
			$data_expirarii = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d")+$conf->expirare_proforma+1, date("Y")));
		}
		else
		{
			$data_expirarii = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d")+$conf->expirare_proforma+2, date("Y")));
		}
		
		$text = $this->generateFacturaText($post['pachet'],$post['servicii'],$id_firma);
		
		if($post['pachet']==1)
		{
			$servicii = $post['servicii'];
		}
		else
		{
			$servicii='';
		}
		
		$pk_info = $this->getPachetInfo($post['pachet']);
		
		$query ="INSERT INTO facturi_proforme (
												`user_id`,
												`firma_id`, 
												`nume_firma`, 
												`perioada`, 
												`type`, 
												`emis_fact_proforma`, 
												`achitat`, 
												`cost`, 
												`adaugare_proforma`, 
												`expirare_proforma`, 
												`status`,
												`content`,
												`email`,
												`cumparator_id`,
												`recomandata`,
												`tip_promovare`,
												`servicii_promovare`
												) 
										VALUES('".$user_id."',
												'".$id_firma."',
												'".addslashes($post['nume_firma'])."',
												'".$pk_info['luni']."',
												'".$post['type']."',
												'Y',
												'N',
												'".$post['total']."',
												now(),
												'".$data_expirarii."',
												'Y',
												'$text',
												'".$post['persc_email']."',
												'$cump_id',
												'$recomandata',
												'".$post['pachet']."',
												'$servicii'
												)";
		$this->db->query($query);
		return $this->db->last_insert_id();
	}
	/*
	 * here we generate the text for the bill
	 */
	public function generateFacturaText($pachet,$servicii,$cab_id)
	{
		$pk_info = $this->getPachetInfo($pachet);
		$text='';
		if($pk_info['pret']=='0' && $servicii!="")
		{
			$serv = explode(";",$servicii);
			$text = "Promovare online, pachet ".$pk_info['name']." serviciile: <br>";
			foreach($serv as $ky => $val)
			{
				if($val!='')
				{
					$serv_info = $this->getServiciuInfo($val);
					$text.=" - ".$serv_info['name']."<br>";
				}
			}
			$text.="<br> pentru <b>".ucwords(getCabinetNumeFirma($cab_id))."</b> pe o perioada de ".$pk_info['luni']." luni, in cadrul portalului stomatologic www.dentistonline.ro .";
		}
		else
		{
			$text = "Promovare online, pachet ".$pk_info['name']."  pentru <b>".ucwords(getCabinetNumeFirma($cab_id))."</b> pe o perioada de ".$pk_info['luni']." luni, in cadrul portalului stomatologic www.dentistonline.ro .";
		}
		return $text;
	}
	/*
	 * get proforma info
	 */
	public function getProformaInfo($id)
	{
		$sql = "SELECT * FROM facturi_proforme WHERE `id`='$id'";
		$this->db->query($sql);
		while ($this->db->next_record())
		{
			$proforme['id'] = $this->db->f("id");
			$proforme['user_id'] = $this->db->f("user_id");
			$proforme['firma_id'] = $this->db->f("firma_id");
			$proforme['nume_firma'] = $this->db->f("nume_firma");
			$proforme['perioada'] = $this->db->f("perioada");
			$proforme['type'] = $this->db->f("type");
			$proforme['achitat'] = $this->db->f("achitat");
			$proforme['cost'] = $this->db->f("cost");
			$proforme['status'] = $this->db->f("status");
			$proforme['adaugare_proforma'] = $this->db->f("adaugare_proforma");
			$proforme['expirare_proforma'] = $this->db->f("expirare_proforma");
			$proforme['emis_fact_proforma'] = $this->db->f("emis_fact_proforma");
			$proforme['email'] = $this->db->f("email");
			$proforme['content'] = $this->db->f("content");
			$proforme['recomandata'] = $this->db->f("recomandata");
			$proforme['cumparator_id'] = $this->db->f("cumparator_id");
			$proforme['tip_promovare'] = $this->db->f("tip_promovare");
		}
		return $proforme;
	}
	/*
	 * get cumparator info
	 */
	public function getCumparatorInfo($id)
	{
		$sql = "SELECT * FROM cumparatori WHERE `id`='$id'";
		$this->db->query($sql);
		$this->db->next_record();
		$facturi['nume'] = $this->db->f("nume");
		$facturi['adresa'] = $this->db->f("adresa");
		$facturi['cui'] = $this->db->f("cui");
		$facturi['cnp'] = $this->db->f("cnp");
		$facturi['bi'] = $this->db->f("bi");
		$facturi['rc'] = $this->db->f("rc");
		return $facturi;
	}
	/*
	 * here we ganerate and save the file for the bill
	 */
	public function saveProformaFile($id)
	{
		global $conf;
		
		$get_proforma_details = $this->getProformaInfo($id);
		$get_cumparator = $this->getCumparatorInfo($get_proforma_details['cumparator_id']);
		
		$text = GetFileContent("../templates/emails/factura_proforma.tpl");
		$text = str_replace("%NUME_PERS_CONTACT%", ucfirst($get_cumparator['nume']) , $text);
		$text = str_replace("%NUMAR_FACTURA_PROFORMA%",$id, $text);
		$text =str_replace("%EXPIRARE_FACTURA_PROFORMA%",$conf->expirare_proforma,$text);
		$text = str_replace("%DATA%",date("d.m.Y"),$text);
		$text = str_replace("%PRET_TOTAL%",$get_proforma_details['cost'],$text);
		$text = str_replace("%DENUMIRE_SERVICI%",$get_proforma_details['content'] ,$text);
		
		
		if(isset($get_cumparator['cui'])&&($get_cumparator['cui']!=""))
		{
			$text = str_replace("%COD_FISCAL_CNP%", $get_cumparator['cui'], $text);
		}
		else
		{
			$text = str_replace("%COD_FISCAL_CNP%", $get_cumparator['cnp'] , $text);
		}
		
		
		if(isset($get_cumparator['rc'])&&($get_cumparator['rc']!=""))
		{
			$text = str_replace("%NR_REG_COM_BI%", $get_cumparator['rc'] , $text);
		}
		else
		{
			$text = str_replace("%NR_REG_COM_BI%", $get_cumparator['bi'] , $text);
		}
		
		$text = str_replace("%NUME_PERS_CONTACT_FIRMA%",addslashes($get_cumparator['nume']) , $text);
		$text = str_replace("%ADRESA%", $get_cumparator['adresa'] , $text);
		#scriem continutul intr-un fisier
		/////////////////////////
		$filename = '../facturi/facturi_proforme/proforma_'.$id.".html";
		$somecontent = $text;
		if (!$handle = fopen($filename, 'w'))
		{
			echo "Cannot open file ($filename)";
			exit;
		}
		if (fwrite($handle, $somecontent) === FALSE)
		{
			echo "Cannot write to file ($filename)";
			exit;
		}
		fclose($handle);
	}
	/*
	 * 
	 */
	public function addCumparator()
	{
		$sql = "INSERT INTO cumparatori(`nume`, `adresa`, `cui`, `bi`,`cnp`,`rc`) VALUES ('".addslashes($_POST['nume'])."', '".addslashes($_POST['adresa'])."', '".addslashes($_POST['cui'])."','".addslashes($_POST['bi'])."','".$_POST['cnp']."', '".$_POST['rc']."')";
		$this->db->query($sql);
		$cump_id = $this->db->last_insert_id();
		return $cump_id;
	}
	/*
	 * 
	 */
	public function getCumparatorLastInfo($user_id)
	{
		$sql = "SELECT * FROM cumparatori WHERE `user_id`='$user_id' ORDER BY id DESC LIMIT 1";
		$this->db->query($sql);
		while ($this->db->next_record())
		{
			$info['id'] = $this->db->f('id');
			$info['nume'] = $this->db->f('nume');
			$info['adresa'] = $this->db->f('adresa');
			$info['cui'] = $this->db->f('cui');
			$info['bi'] = $this->db->f('bi');
			$info['cnp'] = $this->db->f('cnp');
			$info['rc'] = $this->db->f('rc');
			$info['user_id'] = $this->db->f('user_id');
		}
		return $info;
	}
	/*
	 * 
	 */
	public function sendProformaByEmail($plata_id,$level,$servicii,$id_some_info)
	{
		global $conf;
		
		$text = GetFileContent("../templates/emails/factura_proforma.tpl");
		
		#acestea sunt aceleasi indiferent pe cine se emite factura proforma
		$text = str_replace("%NUME_PERS_CONTACT%", ucfirst($_POST['pers_contact']) , $text);
		$text = str_replace("%NUMAR_FACTURA_PROFORMA%",$plata_id, $text);
		$text =str_replace("%EXPIRARE_FACTURA_PROFORMA%",$conf->expirare_proforma,$text);
		$text = str_replace("%DATA%",date("d.m.Y"),$text);
		$text = str_replace("%PRET_TOTAL%",$_POST['total'],$text);
		$servicii_text = $this->generateFacturaText($level,$servicii,$id_some_info);
		$text = str_replace("%DENUMIRE_SERVICI%",$servicii_text ,$text);
		$text = str_replace("%COD_FISCAL_CNP%", $_POST['inreg_fiscala_cnp'] , $text);
		$text = str_replace("%NR_REG_COM_BI%", $_POST['reg_comert_bi'] , $text);
		#daca se emite factura pe firma
		if($_POST['type']=="firma")
		{
			#aici emitem factura pentru firma
			$text = str_replace("%NUME_PERS_CONTACT_FIRMA%",addslashes($_POST['nume_firma']) , $text);
			$text = str_replace("%ADRESA%",$_POST['adresa_firma'], $text);
		}
		else
		{
			$text = str_replace("%NUME_PERS_CONTACT_FIRMA%",$_POST['pers_contact'] , $text);
			$text = str_replace("%ADRESA%",$_POST['adresa_firma'], $text);
		}
		
		$CustomHeaders = '';
		$Subject = "Factura proforma";
		$nr_fact_proforma = $plata_id;
		$Sender = 'DentistOnline.ro<'.$conf->contact_recipient.'>';
		$Recipiant = trim($_POST['persc_email']);
			
		$message = new Email($Recipiant, $Sender, $Subject, $CustomHeaders);
		$message->SetHtmlContent($text);
		if (ValidHeader($Sender))
		{
			$message->Send();
			$emis_fact = "Y";
		}
		else
		{
			$emis_fact="N";
			$query ="UPDATE facturi_proforme SET emis_fact_proforma='N' WHERE id='".$nr_fact_proforma."'";
			$this->db->query($query);
		}
		
		if($emis_fact==="N")
		{
			$_SESSION['admin_info'] = "Exista o problema in emiterea facturi proforme,vom incerca sa o retrimitem in cel mai scurt timp!";
		}
		else
		{
			$_SESSION['admin_info'] = "Tipul de promovare si serviciile oferite au fost modificate cu succes !";
		}
	}
	/*
	 * 
	 */
	public function updatePachetAchitat($cab_id)
	{
		$sql = "UPDATE users_pachete SET achitat='Y' WHERE cabinet_id='$cab_id'";
		$this->db->query($sql);
	}
	/*
	 * here we assign  the agent for each cabinet
	 */
	public function assignCabinetAgent($cabid,$agentid)
	{
		$sql = " UPDATE cabinete SET `admin_id`='$agentid' WHERE id='$cabid'";
		$this->db->query($sql);
	}
	/*
	 * assign agent for factura proforma
	 */
	public function assignProformaAgent($fid,$agentid)
	{
		$sql = "UPDATE facturi_proforme SET admin_id='$agentid' WHERE id='$fid'";
		$this->db->query($sql);
	}
}