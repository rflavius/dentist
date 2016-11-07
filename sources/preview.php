<?php
switch($action)
{
	case 'cabinet':
		$array_type=array(1=>'cabinetul', 2=>'laboratorul',3=>'laboratorul',4=>'firma',5=>'clinica');
		$array_gen=array(1=>'activ', 2=>'activ',3=>'activ',4=>'activa',5=>'activa');
		$get_cabinet = GetSelectedCabinet(intval($param1));
		//print_r($get_cabinet );exit;
		if(($_SESSION['userinfo']->id=='')||(!isset($_SESSION['userinfo']->id)))
		{
			FakeError ();
			$tpl->set_file('tpl_main', 'unpublished.tpl');
			$tpl->set_var('ERRORMSG', 'Aceasta pagina nu este disponibila');
			$tpl->parse('MAIN', 'tpl_main');
		}
		else
		{
		$tpl->set_file('tpl_details', 'modules/cabinete/details.tpl');
		$tpl->set_block('tpl_details', 'articole_create', 'articole_createe');
		#lets inser_nr wievs
		$tpl->set_var('SITEBASE', SITE_BASE);
		$tpl->set_var('IMAGESDIR',SITE_BASE.'/images/allstufs' );
		$tpl->set_var('MAXTHUMBNAILSIZE',$conf->normal_img_cabinete);
		$get_image_map = GetCabineteMainPhoto(intval($param1),"harta");
		$map_exists = 0;
		if(count($get_image_map)>0 &&($get_image_map['image_name']!="" ))
		{
			$map_exists=1;	$tpl->set_var('THUMBNAIL2',SITE_BASE."/sources/thumbnails.php?target=".$get_image_map['image_name'].'&max_size='.$conf->normal_img_cabinete.'&folder='.$param1);
			$tpl->set_var('SRC_FINAL',$param1."/".$get_image_map['image_name'] );
		}
		else
		{
			$tpl->set_var('THUMBNAIL2',SITE_BASE.'/sources/thumbnails.php?target=default.jpg&max_size='.$conf->normal_img_cabinete);
			$tpl->set_var('SRC_FINAL','default.jpg' );
		}
		$tpl->set_var('WEBSITE_URL',ReWrite('cabinete_detalii', 'cabinete.detalii.'.$param1) );
		foreach($get_cabinet  as $ky => $val)
			{
				if($ky=="judet")
				{
					$get_judet = GetJudet("code",$val);
					$tpl->set_var('JUDET',$get_judet['name']  );
				}
				elseif($ky=="nume_loc_sector")
				{
					$nume_loc = GetLocalitate($val);
					$tpl->set_var('NUME_LOC_SECTOR',$nume_loc['name'] );
				}

				else
				{
					if(!isset($val)||($val==" "))
					{
						$tpl->set_var(strtoupper($ky),"-");
					}
					else
					{
						$tpl->set_var(strtoupper($ky),nl2br($val));
					}
				}
			}
			
			$tpl->set_block('tpl_details', 'imgessmall', 'images_block3');
			$main_photo = GetCabineteMainPhoto($param1,"cabinet");
			if($main_photo['image_name']=="")
			{
					$tpl->set_var('MAIN_PHOTO',SITE_BASE.'/images/users_cabinete/default.jpg');
			}
			else
			{
					$tpl->set_var('MAIN_PHOTO', SITE_BASE."/sources/thumbnails.php?target=".$main_photo['image_name'].'&max_size='.$conf->normal_img_cabinete.'&folder='.$param1);
					$tpl->set_var('IMAGENAME_MAIN', $main_photo['image_name']);
					
					$pic_list = GetCabineteImages($param1);
					$tpl->set_var('PICNUM',count($pic_list) - $map_exists );
					$tpl->set_var('FOLDER_ID', $param1);
					$i=1;
					foreach ($pic_list as $key => $val)
					{
						if($val['type']=="cabinet")
						{
							$tpl->set_var('IMAGEINDEX',$i);
							$tpl->set_var('IMAGENAME',$val['image_name']);
							$tpl->set_var('SMALL_IMGES', SITE_BASE."/sources/thumbnails.php?target=".$val['image_name'].'&max_size=70&folder='.$param1);
							
							if($i>1)
							{
									$tpl->parse('images_block3','imgessmall',true);
							}
							//$tpl->parse('images_block2','images_block',true);
						
							$i++;
							
						}
					}
				}
		if($get_cabinet['user_id']!="-1")
		{
			$tpl->set_var('PARSE_EMAIL', "<b>Programare online - Trimite email</b>");
			$tpl->set_var('URLTRIMITEEMAIL',ReWrite('cabinete_trimitemail','cabinete.trimitemail.'.$param1));
		}
			#let's find out the post articles on dentistonline.ro
			$all_articles = GetAllArticlesForUser($get_cabinet['user_id']);
			//print_r($all_articles);
			if((count($all_articles)>0)&&($all_articles!="0"))
			{
					foreach($all_articles as $ky => $val)
					{
						$tpl->set_var('ARTICOL_DETAILS',"<a href=\"".Rewrite('articole', 'articole-medicale.articol.'.$val['bigcat_id'].'.'.$val['id'])."\">".$val['titlu']."</a>" );

						$tpl->parse('articole_createe', 'articole_create', true);
					}
			}
			else
			{
				$tpl->set_var('ARTICOL_DETAILS',$get_cabinet['nume_firma']. " momentan nu  are nici un articol adaugat." );
				$tpl->parse('articole_createe', 'articole_create', true);

			}
		$tpl->parse('MAIN', 'tpl_details');
	}
		
	break;
	
	case 'articol':
		$tpl->set_file('tpl_details', 'modules/articole/detalii.tpl');
		$get_cabinet = GetArticole(-1,intval($param1));
		if (count($get_cabinet)<1)
		{
			FakeError ();
			$tpl->set_file('tpl_main', 'unpublished.tpl');
			$tpl->set_var('ERRORMSG', 'Aceasta pagina nu este disponibila');
			$tpl->parse('MAIN', 'tpl_main');
		}
		$tpl->set_var('SITEBASE', SITE_BASE);
		if (count($get_cabinet) != '0')
		{
			$tpl->set_var("TITLU",$get_cabinet[0]['titlu']);
			$tpl->set_var("CONTINUT",$get_cabinet[0]['continut']);
			$tpl->set_var('EMAIL', $get_cabinet[0]['email']);
			$tpl->set_var('NR_VIZUALIZARI',$get_cabinet[0]['nr_visits']);
			$tpl->set_var("IMAGINE",SITE_BASE."/sources/thumbnails.php?target=".$get_cabinet[0]['imagine'].'&max_size=160&articles=yes');
			$tpl->set_var('IMAGNAME',$get_cabinet[0]['imagine']);
			
			if($get_cabinet[0]['user_id']!="-1")
				{
					$tpl->set_var('PARSE_EMAIL', "<b>Trimite E-mail</b>");
				}
		}
		#let't take the contact details , to meake some links to ther mai area - cabinetele
		$tpl->set_block('tpl_details', 'AUTOR_DET', 'AUTOR_DETT');
		if($get_cabinet[0]['user_id']!="-1")
		{
			$get_gabinet_for_anunce = GetFirme($get_cabinet[0]['user_id'],"-1");
		$tpl->set_var('AUTOR_NAME',$get_cabinet[0]['autor'] );
		$tpl->set_var('AUTOR_LINK', ReWrite('cabinete_detalii', 'cabinete.detalii.'.$get_gabinet_for_anunce[0]['id']) );
		$tpl->set_var('ADRESA',ucfirst($get_gabinet_for_anunce[0]['adresa_firma']) );
		$nume_loc = GetLocalitate($get_gabinet_for_anunce[0]['nume_loc_sector']);
		$tpl->set_var('NUME_LOC_SECTOR',$nume_loc['name'] );
		$tpl->set_var('LOCALITATE', $nume_loc['name'] );
		$tpl->set_var('TELEFON',$get_gabinet_for_anunce[0]['fax'] );
		$tpl->set_var('WEBSITE',$get_gabinet_for_anunce[0]['adresa_web'] );
		$tpl->parse('AUTOR_DETT', 'AUTOR_DET', true);
		}
		$tpl->parse('MAIN', 'tpl_details');
	break;

	
	case 'anunt':
		$tpl->set_file('tpl_details', 'modules/anunturi/details.tpl');
		$tpl->set_block('tpl_details', 'if_email', 'if_emaill');
		$get_cabinet = GetAnunturi('-1',intval($param1));
		$tpl->set_var('SITEBASE', SITE_BASE);
		if (count($get_cabinet) != '0')
		{
			$tpl->set_var("TITLU",$get_cabinet[0]['titlu']);
			$tpl->set_var("CONTINUT",$get_cabinet[0]['continut']);
			$tpl->set_var('AUTOR', $get_cabinet[0]['autor']);
			$tpl->set_var('EMAIL', $get_cabinet[0]['email']);
			$tpl->set_var('NR_VIZUALIZARI',$get_cabinet[0]['nr_visits']);
			if(isset($get_cabinet[0]['email'])&&($get_cabinet[0]['email']!=""))
			{
				$tpl->parse('if_emaill', 'if_email', true);

			}
			$tpl->set_var("IMAGINE",SITE_BASE."/sources/thumbnails.php?target=".$get_cabinet[0]['imagine'].'&max_size=120&anunturi=yes');
			$tpl->set_var('IMAGNAME',$get_cabinet[0]['imagine']);
			$cat_name = Get_Dentist_Cats($get_cabinet[0]['category_id']);
			$cat_n =$cat_name[0]['name'];
			$tpl->set_var("BIGCAT",$cat_n);
			$tpl->set_var('ANUNTURIBYCAT',ReWrite("anunturi",'anunturi.'.$get_cabinet[0]['category_id']));
			
			$get_judet = GetJudet("code",$get_cabinet[0]['judet']);
			$tpl->set_var('JUDET',$get_judet['name']  );
			
			$nume_loc = GetLocalitate($get_cabinet[0]['localitate']);
			$tpl->set_var('LOCALITATE',$nume_loc['name']);
			$tpl->set_var('CONTACT_PERS', $get_cabinet[0]['autor']);
			
			$tpl->set_var('DATA_ADAUGARII',$get_cabinet[0]['data_adaugarii']);
			$tpl->set_var('DATA_EXPIRARII',$get_cabinet[0]['data_expirarii']);
			
		}

		#let't take the contact details , to meake some links to ther mai area - cabinetele
		$tpl->set_block('tpl_details', 'AUTOR_DET', 'AUTOR_DETT');
		$check_cabinet_activate = CheckCabinetStatus($get_cabinet[0]['user_id']);
		if(($get_cabinet[0]['user_id']!="-1")&&($check_cabinet_activate=='1'))
		{
		$get_gabinet_for_anunce = GetFirme($get_cabinet[0]['user_id'],"-1");
		$tpl->set_var('AUTOR_NAME',$get_cabinet[0]['autor'] );
		$tpl->set_var('AUTOR_LINK', ReWrite('cabinete_detalii', 'cabinete.detalii.'.$get_gabinet_for_anunce[0]['id']) );
		$tpl->set_var('ADRESA',$get_gabinet_for_anunce[0]['adresa_firma'] );
		$nume_loc = GetLocalitate($get_gabinet_for_anunce[0]['nume_loc_sector']);
		$tpl->set_var('NUME_LOC_SECTOR',$nume_loc['name'] );
		$tpl->set_var('LOCALITATE', $nume_loc['name'] );
		$tpl->set_var('TELEFON',$get_gabinet_for_anunce[0]['fax'] );
		$tpl->set_var('WEBSITE',$get_gabinet_for_anunce[0]['adresa_web'] );
		$tpl->parse('AUTOR_DETT', 'AUTOR_DET', true);
		}
		$tpl->parse('MAIN', 'tpl_details');
	break;
	
	
}
?>