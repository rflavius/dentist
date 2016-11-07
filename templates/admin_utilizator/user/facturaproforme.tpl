<!-- BEGIN no_facturi -->
<table align="center"  cellpadding="4" cellspacing="1" class="big_table form" width="100%"> 
<tr>
	<td colspan="2" valign="middle" align="center" class="table_subhead">{NO_FACTURA}</td>
</tr>
</table>
<!-- END no_facturi -->
{INFORMATION}
<!-- BEGIN if_facturi -->
<fieldset >
			<legend> <i>{USERNAME}</i>  aici ai toate facturile proforme pentru serviciile oferite. </legend>
<table border="0" cellspacing="1" cellpadding="4" class="big_table form" width="100%">
		<tr>
			<td class="table_subhead" width="15%" align="center">Serie factura</td>
			<td class="table_subhead" width="15%" align="center">Data Emiterii</td>
			<td class="table_subhead" width="15%" align="center">Data Expirarii</td>
			<td class="table_subhead" width="7%" align="center">Cost</td>
			<td class="table_subhead" width="20%" align="center">Email </td>
			<td class="table_subhead" width="10%" align="center">ACTIUNI</td>
		</tr>
		<!-- BEGIN afiseaza_proforme -->
		<tr class="row2">
			<td  align="center">Proforma: {SERIE_PROFORMA} <br>{DET_FISCALA}</td>
			<td align="center">{DATA_EMITERII}</td>
			<td  align="center">{DATA_EXPIRARII}</td>
			<td  align="center">{COST} RON</td>
			<td >{ADRESA_EMAIL}</td>
			<td ><a href="?page=user.vizualizareproforma.{SERIE_PROFORMA}" align="center"  title='Vizualizeaza continutul facturii proforme cu seria  "{SERIE_PROFORMA}"' class="button2" style="text-decoration: none;">Vizualizare</a>
						<a href="?page=user.printproforma.{SERIE_PROFORMA}" target="blank" title='Printeaza factura proforma cu seria "{SERIE_PROFORMA}"' class="button2" style="text-decoration: none;">Print</a>
						<!-- <a href="?page=user.salveazaproforma.{SERIE_PROFORMA}" title='Salveaza factura proforma cu seria "{SERIE_PROFORMA}"' class="button" style="text-decoration: none;"><input type="submit" name="sbmtbtn" value="Salveaza"  class="button"/></a> --></td>
		</tr>
		<!-- END afiseaza_proforme -->
<tr>
	<td class="row2" colspan="6"><br />{NO_INFO_FISCALA}</td>
</tr>
</table>
</fieldset>
<table border="0" cellspacing="1" cellpadding="4" width="100%" class="big_table form">
<tr>
	<td class="table_subhead"><b>Ajutor pentru dvs.</b></td>
</tr>
<tr>
	<td class="row1"> 
		<li><b>"Factura proforma"</b>  - este valabila 5 zile lucratoare de la data emiterii.</li>
		<li><b>"Vizualizare"</b> - afisarea facturi proforme. </li>
		<li><b>"Print"</b> - imprimarea facturi proforme.</li>
		<li> <b>"Salveaza"</b> - salvati factura proforma in calculatorul dvs.</li>
		<li> <b>"Email"</b> - reperezinta emailul pe care s-a trimis factura proforma.</li>
	</td>
</tr>
</table>

<!-- END if_facturi -->
