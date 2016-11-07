<table align="center" border="0" cellspacing="0" cellpadding="0" width="100%" valign="top">
	<tr>
		<td > 
			{INFORMATION}
			<!-- BEGIN if_mesaje -->
			<fieldset >
			<legend> <b>{USERNAME}</b> acestea sunt mesajele, programarile primite .</legend>
			<table width="100%" cellpadding="1" cellspacing="1" class="big_table form">
			<tr>
					<td class="table_subhead" width="20%">De la</td>
					<!-- <td class="table_subhead" width="20%">Email</td> -->
					<td class="table_subhead" width="25%" >Subiect</td>
					<td class="table_subhead" width="25%" >Mesaj </td>
					<td class="table_subhead" width="15%" >Data </td>
					</tr>
				<!-- BEGIN list_mesaje -->
				<tr class="{BGCOLOR}">
					<td >{NUME_UTILIZATOR}	</td>
					<!-- <td  >{EMAIL}</td>  -->
					<td  >{SUBIECT_MESAJ}</td>
					<td >{MESAJ}...<a href="{DETALIIMESAJ}">[ citeste tot ]</a></td>
					<td >{DATA} </td>
				</tr>
				<!-- END list_mesaje -->

			</table>
		<!-- END if_mesaje -->

</td>
</tr>
</table>
</fieldset>

				
<!-- BEGIN if_no_mesaje -->
<table border="0" cellspacing="1" cellpadding="4" width="100%" align="center" class="big_table form">
<tr>
	<td  class="table_subhead">Momentan nu aveti nici un mesaj  </td>
</tr>

<tr>
	<td class="row1">
	<li>Dentistonline.ro vine in sprijinul dvs. in realizarea programarilor online, comunicarii dentist-pacient</li>
	<li>Veti primi un email de atentionare in momentul in care  primiti o programare sau un nou mesaj!</li>   </td>
</tr>
</table>
<!-- END if_no_mesaje -->
