<!-- BEGIN no_facturi -->
<table align="center"  cellpadding="4" cellspacing="1" class="big_table form" width="100%"> 
<tr>
	<td colspan="2" valign="middle" align="center" class="table_subhead">{NO_FACTURA}</td>
</tr>
</table>
<!-- END no_facturi -->

<!-- BEGIN if_facturi -->
<fieldset >
			<legend> <i>{USERNAME}</i>  aici ai toate facturile pentru serviciile oferite. </legend>
<table border="0" cellspacing="1" cellpadding="4" class="big_table form" width="100%">
		<tr>
			<td class="table_subhead" width="13%" align="center">Serie factura</td>
			<td class="table_subhead" width="13%" align="center">Data eliberarii</td>
			<td class="table_subhead" width="7%" align="center">Cost</td>
			 <td class="table_subhead" width="13%" align="center">Serviciu din</td>
			<td class="table_subhead" width="15%" align="center">Serviciu pana in</td>
			
			<td class="table_subhead" width="7%" align="center">ACTIUNI</td>
		</tr>
		<!-- BEGIN afiseaza_proforme -->
		<tr class="row2">
			<td  align="center">Factura : {SERIE_PROFORMA} <br>{DET_FISCALA}</td>
			<td align="center">{DATA_EMITERII}</td>
			<td >{COST}</td>
			<td align="center">{SERVICIU_DIN}</td>
			<td  align="center">{SERVICIU_EXPIRARE}</td> 
			<td ><a href="?page=user.vizualizarefiscala.{SERIE_PROFORMA}" align="center"  title='Vizualizeaza continutul facturii cu seria  "{SERIE_PROFORMA}"' class="button2" style="text-decoration: none;">Vizualizare</a>
						<a href="?page=user.printfiscala.{SERIE_PROFORMA}" target="blank" title='Printeaza factura cu seria "{SERIE_PROFORMA}"' class="button2" style="text-decoration: none;">Print</a><!-- </a>
						<a href="?page=user.salveazafiscala.{SERIE_PROFORMA}" title='Salveaza factura  cu seria "{SERIE_PROFORMA}"' class="button" style="text-decoration: none;"><input type="submit" name="sbmtbtn" value="Salveaza"  class="button"/></a> --></td>
		</tr>
		<!-- END afiseaza_proforme -->
<tr>
	<td  class="row2" colspan="6"><br />{NO_INFO_FISCALA}</td>
</tr>


</table>
</fieldset>

<table border="0" cellspacing="1" cellpadding="4" width="100%" class="big_table form">
<tr>
	<td class="table_subhead"><b>Ajutor pentru dvs.</b></td>
</tr>
<tr>
	<td class="row1"> 
		<li><b>"Vizualizare"</b> - afisarea facturi . </li>
		<li><b>"Print"</b> - imprimarea facturi .</li>
		<li> <b>"Salveaza"</b> - salvati factura  in calculatorul dvs.</li>
		<li> <b>"Email"</b> - reperezinta emailul pe care s-a trimis factura proforma.</li>
		<li>Conform Legii 571/2003 coroborata cu Hotararea de Guvern 44/2004, facturile fiscale emise nu mai trebuie sa fie semnate si stampilate pe suport fizic, este suficienta trimiterea lor in format electronic. Drept urmare, toate facturile de pe site-ul www.dentistonline.ro sunt perfect valide si legale. </li>
	</td>
</tr>
</table>
<!-- END if_facturi -->