<table align="center" border="0" cellspacing="0" cellpadding="0" width="99%" valign="top">
	<tr>
		<td > 
			{INFORMATION}
			<!-- BEGIN if_firme -->
			<table width="100%" class="dark_bg" cellpadding="4" cellspacing="1">
				<tr>
					<td class="tbhead" colspan="8">Listare cabinete, laboratoare, clinici pentru <b>{USERNAME}</b></td>
				</tr>
				<tr>
					<td class="bgmain" width="20%">Nume </td>
					<td class="bgmain" width="35%">Descriere</td>
					<td class="bgmain" width="25%" >Imagini</td>
					<td class="bgmain" width="10%" >Status</td>
					<td class="bgmain" width="10%" >Editeaza </td>
					</tr>
				<!-- BEGIN list_firme -->
				<tr class="row1">
					<td valign="top">	<b>{FRONTENDFIRMA}</b>	</td>
					<td valign="top"><div id="norows">{DESCRIERE}</div></td>
					<td align="center" valign="top"><a href="{MODIFICA_IMAGINI}"><img src="{THUMBNAIL}" border="0" title="{NUME_FIRMA}"></a> <br /><b>{NR_IMAGINI} </b>imagini  <a href="{MODIFICA_IMAGINI}">modifca</a></td>
					<td valign="top" align="center" ><strong>{STATUSFIRMA}</strong><br />{DATA_EXPIRARII}</td>
					<td align="center" valign="top">
						<a href="{EDITFIRMA}"><img src="./images/admin/edit.png" title='Editeaza "{NUME_FIRMA}" '></a>
					</td>
				</tr>
				<!-- END list_firme -->
				</table>
				
		<br />
				
				<table border="0" cellspacing="4" cellpadding="1" width="100%">
						<tr>
							<td class="attention_verde"><b>Atentie!</b></td>
						</tr>
						<tr>
							<td>
								<li>In momentul in care statusul firmei dvs. va fi <b>"Activ"</b> aceasta va aparea pe DentistOnline.</li> 
								<li>Accesati <b>"Numele"</b> firmei dvs. si veti vedea cum arata acesta pe website-ul nostru.</li>
								<li>Accesati <b>"modifica"</b> si veti putea modifca imaginile firmei dvs.</li>
							</td>
						</tr>
						</table>
						
				<!-- END if_firme -->
</td>
			</tr>
		</table>
				
<!-- BEGIN if_no_firme -->
<table border="0" cellspacing="4" cellpadding="1" width="100%">
<tr>
	<td  colspan="8" >Nu aveti nici un cabinet, clinica, laborator, depozit  adaugate. Click <a href="{USERADDFIRM}">adaugare firma</a> </td>
</tr>
</table>
<!-- END if_no_firme -->