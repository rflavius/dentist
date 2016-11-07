<!-- BEGIN if_anunturi -->
<table align="center" border="0" cellspacing="0" cellpadding="0" width="100%" class="text">
	<tr>
		<td width="100%">
			{INFORMATION}
			<table width="100%"  cellpadding="4" cellspacing="1" class="dark_bg">
				<tr>
					<td class="tbhead" colspan="6">Listare articole pentru <b>{USERNAME}</b></td>
				</tr>
				
				<tr>
						<td   class="bgmain" width="20%">Titlu </td>
						<td   class="bgmain" width="20%" align="center">Imagine</td>
						<td   class="bgmain" width="10%" align="center">Status</td>
						<td   class="bgmain" width="10%" align="center">Editeaza </td>
						<!-- <td   class="bgmain" width="10%" align="center">Sterge </td> -->
				</tr>
				<!-- BEGIN list_anunturi -->
				<tr class="row1">
					<td valign="top">	<b>	{FRONTENDANUNT}	</b>	</td>
					<td align="center" ><a href="{EDITANUNT}"><img src="{THUMBNAIL}" border="0"></a></td>
					<td align="center">	<b>	{STATUSANUNT}	</b>	</td>
					<td align="center" >
						<a href="{EDITANUNT}" align="center"><img src="./images/admin/edit.png" title='Editati articolul  "{TITLU}" '></a>
					</td>
					<!-- <td align="center" valign="top">
						<a href="{DELETEANUNT}"><img src="./images/admin/delete.png" title='Stergeti anuntul "{TITLU}"'></a>
					</td> -->
				</tr>
				<!-- END list_anunturi -->
			</table>
		</td>
	</tr>
</table>
				
				
<table border="0" cellspacing="4" cellpadding="1" width="100%">
<tr>
	<td class="attention_verde"><b>Atentie!</b></td>
</tr>
<tr>
	<td><li>Doar dupa ce statusul articolului dvs va fi <b>"Activ"</b> ,acesta va aparea pe site-ul nostru.</li>

	<li>Accesati</div>  <b>"Titlul"</b> articolului si veti vedea cu arata anuntul pe website-ul DentistOnline.</li>
	</td>
</tr>
</table>

<!-- END if_anunturi -->

				
<!-- BEGIN if_no_anunt -->
<table border="0" cellspacing="0" cellpadding="0" width="100%" align="center">
<tr>
	<td ><br />Momentan nu aveti nici un articol. Click <a href="{USERADDARTICOL}">adaugare articol</a> </td>
</tr>
</table>
	
<!-- END if_no_anunt -->


