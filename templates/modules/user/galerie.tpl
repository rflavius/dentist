<table align="center" border="0" cellspacing="0" cellpadding="0" width="99%" valign="top">
	<tr>
		<td > 
			{INFORMATION}
			
			<!-- BEGIN if_firme -->
			<table width="100%" class="dark_bg" cellpadding="4" cellspacing="1">
				<tr>
					<td class="tbhead" colspan="8">Galerie imagini pentru cabinete, laboratoare, clinici pentru <b>{USERNAME}</b></td>
				</tr>
				
				<tr>
					<td class="bgmain" width="20%">Nume firma</td>
					<td class="bgmain" width="25%" >Imagine principala</td>
					<td class="bgmain" width="20%" >Editeaza </td>
					</tr>
				<!-- BEGIN list_firme -->
				<tr class="row1">
					<td valign="top"><b>{FRONTENDFIRMA}</b>	</td>
					<td align="center" valign="top"><a href="{MODIFICA_IMAGINI}"><img src="{THUMBNAIL}" border="0" title="{NUME_FIRMA}"></a> </td>
					<td align="center" valign="top"><b>{NR_IMAGINI} </b>imagini 
						<a href="{MODIFICA_IMAGINI}">modifica </a>
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
								<li>Prin "modifica" se schimba imaginile din galeria dvs, cat si pozitia lor in galerie.</li> 
								<li>Accesati <b>"Numele"</b> firmei dvs. si veti vedea cum arata acesta pe website-ul nostru.</li>
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
	<td  colspan="8" >Nu aveti nici un cabinet, clinica, laborator, depozit  adaugate.
	Doar dupa ce veti adauga o firma veti avea acces la galerie. </td>
</tr>
</table>
<!-- END if_no_firme -->