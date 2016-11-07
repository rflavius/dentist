{INFORMATION}
<fieldset style="width:100%;border:0px;">
	<!-- <legend> <b>{USERNAME}</b>  aici ai toate ofertele adaugate </legend> -->

			<!-- BEGIN if_firme -->
			<table width="100%"  cellpadding="1" cellspacing="1" class="big_table form">
				<!-- BEGIN alert_email_activare -->
				<tr>
					<td class="tbhead" colspan="8" ><b style="color:#E10000;font-weight:bold;">!!! ATENTIE Va rugam sa verificati si in SPAM, in cazul in care nu primiti mesajul nostru de activare in INBOX.</b> Marcati ca si NOT SPAM pentru a primi in continuare mesajele de la admin@dentistonline.ro in INBOX.</td>
				</tr>
				<!-- END alert_email_activare -->
				<tr>
					<td class="tbhead" colspan="8">Cabinete, laboratoare, clinici pentru <b>{USERNAME}</b></td>
				</tr>
				<!-- 	<tr>
					<td class="tbhead" colspan="8" style="color:#E10000;font-weight:bold;text-decoration:blink;">Echipa dentistonline.ro va  raspunde mesajului dvs dupa revenirea din concediu. Multumim pentru intelegere.</td>
				</tr> -->
	
				<tr>
					<td class="table_subhead" style="text-align:center;" width="15%">Denumire </td>
					<td class="table_subhead" style="text-align:center;" width="10%" >Imagini</td>
					<td class="table_subhead"style="text-align:center;"  width="10%" >Video</td>
					<td class="table_subhead"style="text-align:center;"  width="14%" >Promovare</td>
					<td class="table_subhead" style="text-align:center;" width="20%" >Actiuni </td>
					</tr>
				<!-- BEGIN list_firme -->
				<tr class="row1">
					<td valign="top">	<a href="{EDITFIRMA}"><b>[ {NUME_FIRMA} ]</b></a></td>
					<!-- <td valign="top"><div id="norows">{DESCRIERE}</div></td> -->
				<!--  	<td align="center" valign="top"><a href="{MODIFICA_IMAGINI}"><img src="{THUMBNAIL}" border="0" title="{NUME_FIRMA}"></a> <br /> <a href="{MODIFICA_IMAGINI}" title="Adaugati noi imagini, modificati imaginile curente pentru: {NUME_FIRMA}"><b>Adauga/modifica imagini</b>  </a> 
					</td> 
					<td valign="top" align="center" ><b>{NR_VIDEO} </b>video<br>[ <a href="?page=user.modifyvideo.{CAB_ID}" title="Promoveaza-ti imaginea printr-un video, adauga/modifica video  pentru: {NUME_FIRMA}">Modifica Video</a> ]</td>
					--> 
					<td  valign="top"> <a href="{MODIFICA_IMAGINI}" title="Adaugati noi imagini, modificati imaginile curente pentru: {NUME_FIRMA}"><img src="../images/allstufs/test-adauga.jpg"> </a> 
					</td> 
					
					<td valign="top" align="center" > <a href="?page=user.modifyvideo.{CAB_ID}" title="Promoveaza-ti imaginea printr-un video, adauga/modifica video  pentru: {NUME_FIRMA}"><img src="../images/allstufs/test-adauga-video.jpg"></a> </td>
					<!-- <td valign="top" align="center" style="color:black;">{PACHET_PROMOVARE}</td> -->
					<td valign="top" align="center" >{PACHET_PROMOVARE}</td> 

					<!-- <td valign="top" align="center" ><strong>{STATUSFIRMA}</strong><br />{DATA_EXPIRARII}</td> -->
					<td  valign="top" align="center" >[ <a href="{EDITFIRMA}" title="Modifica/adauga informatii caracteristice pentru {NUME_FIRMA}" >Modifica informatii</a> ]<br>[ <a href="{PREVIEW}"  title="Vezi cum arata {NUME_FIRMA}, pe www.dentistonline.ro, promovarea care te avantajeaza" target="_blank" >Vezi cum arata {TYPE_CABINET} tau pe dentistonline.ro </a> ] <br>Status:<strong>{STATUSFIRMA}</strong>{DATA_EXPIRARII}
					</td>
				</tr>
				<!-- END list_firme -->
				</table>
				<br />
<!-- END if_firme -->
</fieldset>

{PROMOVARE_TEXT}

<table border="0" cellspacing="1" cellpadding="4" width="100%" class="big_table form">
<tr>
	<td class="table_subhead"><b>Ajutor pentru dvs.</b></td>
</tr>
<tr>
	<td>
			<li>In momentul in care statusul firmei dvs. va fi <b>"Activ"</b> aceasta va aparea pe DentistOnline.</li> 
			<li>Accesati <b>"Modifica Imagini"</b> si veti putea modifca imaginile firmei dvs.</li>
			<li>Accesati <b>"Modifica "</b> si veti putea modifca informatiile caracteristice firmei dvs.</li>
			<li>Accesati <b>"Preview"</b> -  veti vedea cum arata cabinetul/clinica/laboratorul dvs.  pe website-ul nostru.</li>
			<!-- <li>Accesati <b>"Numele"</b> firmei dvs. si veti vedea cum arata acesta pe website-ul nostru.</li> -->
	</td>
</tr>
</table>
