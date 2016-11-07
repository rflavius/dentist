{INFORMATION}
{IF_ABONAMENT}
<!-- BEGIN if_anunturi -->
<fieldset >
			<legend> <b>{USERNAME}</b>  aici ai toate articolele publicate. </legend>
<table align="center" border="0" cellspacing="0" cellpadding="0" width="100%" class="text">
	<tr>
		<td width="100%">
			<table width="100%"  cellpadding="4" cellspacing="1" class="big_table form">
				<tr>
						<td class="table_subhead" width="20%">Titlu </td>
						<td class="table_subhead" width="30%">Descriere</td>
						<td class="table_subhead" width="15%" align="center">Imagine</td>
						<td class="table_subhead" width="7%" align="center">Status</td>
						<td class="table_subhead" width="7%" align="center">Actiuni </td>
				</tr>
				<!-- BEGIN list_anunturi -->
				<tr class="row1">
					<td valign="top">	<b>	{FRONTENDANUNT}	</b>	</td>
					<td valign="top">	{CONTINUT}....<a href="{EDITANUNT}"><b>[ citeste tot ]</b></a>		</td>
					<td align="center" ><a href="{EDITANUNT}"><img src="{THUMBNAIL}" border="0"></a></td>
					<td align="center">	<b>	{STATUSANUNT}	</b>	</td>
					<td align="center" >
						<a href="{EDITANUNT}" class="button2">Modifica</a>
						<a href="{PREVIEW}" target="_blank" class="button2">Preview</a>
						<!-- BEGIN if_abonament -->
						<a href="?page=user.add_articol_recomandat.{IDANUNT}" class="button2">Recomandat</a>
						<!-- END if_abonament -->
						{IF_RECOMANDAT}
					</td>
				</tr>
				<!-- END list_anunturi -->
			</table>
		</td>
	</tr>
</table>				
</fieldset>			

<table border="0" cellspacing="1" cellpadding="4" width="100%" class="big_table form">
<tr>
	<td class="table_subhead"><b>Ajutor pentru dvs.</b></td>
</tr>
<tr>
	<td class="row1">
		<li>Doar dupa ce statusul articolului dvs va fi <b>"Activ"</b> ,acesta va aparea pe site-ul nostru.</li>
		<li><b>"Modifica"</b>  - datele caracteristice articolului dvs.(imagine, descriere etc.)</li>
		<li><b>"Preview"</b> -  veti vedea cum arata articolul dvs. pe website-ul nostru.</li>
		<li><b>"Recomandat"</b> - datorita faptului ca ati achizitionat pachetul de promovare abonament, aveti posibilitatea de a alege care dintre articolele dvs va fii promovat in sectiunea articole recomandate ! Mentionam ca doar un singur articol poate fi recomandat avand un numar maxim de afisari de 10.000/an .</p></li>
		<li>In momentul in care alegeti un nou articolul recomandat, numarul de afisari de la articolul recomandat precedent se transfera automat la noul articol ales.</li>
	</td>
</tr>
</table>

<!-- END if_anunturi -->

				
<!-- BEGIN if_no_anunt -->
<table border="0" cellspacing="0" cellpadding="0" width="100%" class="big_table form">
<tr>
	<td class="table_subhead" >Momentan nu aveti nici un articol. Click <a href="{USERADDARTICOL}">[ adaugare articol ]</a> </td>
</tr>

<tr>
	<td class="row1">Promoveaza-ti imaginea cabinetului tau si prin articolele adaugate. Mai multe articole - implicit mai multi vizitatori pentru cabinetul, clinica, laboratorul, depozitul tau. Articolele bine detaliate si cu <b>imagine</b> sunt postate pe <b>prima pagina</b> a site-ul nostru pentru o anumita perioada de timp.</td>
</tr>
<tr>
	<td class="row1"><a href="{USERADDARTICOL}"><img src="../images/promovare_articole.jpg"></a><br><br></td>
</tr>
</table>
	
<!-- END if_no_anunt -->


