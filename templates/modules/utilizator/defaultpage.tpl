<table align="center" border="0" cellspacing="0" cellpadding="0" width="100%" valign="top">
	<tr>
		<td > 
			{INFORMATION}
			<!-- BEGIN if_mesaje -->
			<table width="100%" class="dark_bg" cellpadding="4" cellspacing="1">
				<tr>
					<td class="tbhead" colspan="8"> <b>{USERNAME}</b> acestea sunt mesajele dvs.</td>
				</tr>
			
				<tr>
					<td class="bgmain" width="20%">De la</td>
					<!-- <td class="bgmain" width="20%">Email</td> -->
					<td class="bgmain" width="25%" >Subiect</td>
					<td class="bgmain" width="20%" >Mesaj </td>
					<td class="bgmain" width="20%" >Data </td>
					</tr>
				<!-- BEGIN list_mesaje -->
				<tr class="row1">
					<td >{NUME_UTILIZATOR}	</td>
					<!-- <td  >{EMAIL}</td> -->
					<td  >{SUBIECT_MESAJ}</td>
					<td >{MESAJ}...<a href="{DETALIIMESAJ}">citeste</a></td>
					<td >{DATA} </td>
				</tr>
				<!-- END list_mesaje -->

			</table>
					<br />	<table border="0" cellspacing="4" cellpadding="1" width="100%">
				<tr>
					<td class="attention_verde"><b>Atentie!</b></td>
				</tr>
				<tr>
					<td>
						<li>Accesati <b>citeste</b> pentru a vedea tot mesajul. </li> 
						
					</td>
				</tr>
				</table>
		<!-- END if_mesaje -->

</td>
</tr>
</table>

				
<!-- BEGIN if_no_mesaje -->
<table border="0" cellspacing="4" cellpadding="1" width="100%" align="center">
<tr>
	<td  colspan="8" >Momentan nu aveti nici un mesaj.<br /> Veti primi un email de atentionare in momentul in care veti primi un nou mesaj!  </td>
</tr>
</table>
<!-- END if_no_mesaje -->