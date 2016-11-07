<table align="center" border="0" cellspacing="0" cellpadding="0" width="100%" valign="top">
	<tr>
		<td > 
			{INFORMATION}
			<!-- BEGIN if_termeni -->
			<table width="100%" class="dark_bg" cellpadding="4" cellspacing="1">
				<tr>
					<td class="tbhead" colspan="8"> <b>{USERNAME}</b> acestea sunt termeni medicali,definitiile adaugate de dvs.</td>
				</tr>
			
				<tr>
					<td class="bgmain" width="20%">Termen</td>
					<td class="bgmain" width="25%" >Continut</td>
					<td class="bgmain" width="20%" >Data Publicarii</td>
					<td class="bgmain" width="20%" >Status</td>
					<td class="bgmain" width="20%" >Editeaza</td>
					
					</tr>
				<!-- BEGIN list_termeni -->
				<tr class="row1">
					<td >{TERMEN}	</td>
					<td  >{DETALII}</td>
					<td >{DATA_PUBLICARII}</td>
					<td><img src="{SITE_BASE}/templates/skins/images/admin/{IMAGE}"></td>
					<td >{EDITEAZA} </td>
				</tr>
				<!-- END list_termeni -->

			</table>
					<br />	<table border="0" cellspacing="4" cellpadding="1" width="100%">
				<tr>
					<td class="attention_verde"><b>Atentie!</b></td>
				</tr>
				<tr>
					<td>
						<li>Accesati <b>editeaza</b> pentru a modifica termenul, definitia introdusa de dvs. </li> 
						
					</td>
				</tr>
				</table>
		<!-- END if_termeni -->

</td>
</tr>
</table>

				
<!-- BEGIN if_no_termeni -->
<table border="0" cellspacing="4" cellpadding="1" width="100%" align="center">
<tr>
	<td  colspan="8" >Momentan nu aveti nici un termen adaugat de dvs.<br /> </td>
</tr>
</table>
<!-- END if_no_termeni -->