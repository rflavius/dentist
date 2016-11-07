<!-- BEGIN if_facturi -->
<table border="0" cellspacing="0" cellpadding="0">
<tr>
	<td> 
		<table class="dark_bg" cellpadding="4" cellspacing="1">
		<tr>
			<td class="tbhead" colspan="6"><b>Factura proforma </b>numarul <b>{SERIE_PROFORMA}</b> a fost trimisa pe adresa de email: {ADRESA_EMAIL}<br /></td>
		</tr>
		<tr>
			<td class="bgmain" width="15%">Data Emiterii</td>
			<td class="bgmain" width="15%">Data Expirarii</td>
			<td class="bgmain" width="10%">Cost</td>
			<td class="bgmain" width="20%">Nume firma</td>
			<td class="bgmain" width="30%">Servici</td>
		</tr>
		<tr>
			<td class="row1" align="center">{DATA_EMITERII}</td>
			<td class="row1" align="center">{DATA_EXPIRARII}</td>
			<td class="row1" align="center">{COST} RON</td>
			<td class="row1">{NUME_FIRMA}</td>
			<td class="row1">{SERVICI}</td>
		</tr>
		</table>
	</td>
</tr>
<tr>
	<td><br />{NO_INFO_FISCALA}</td>
</tr>
<!-- BEGIN if_fiscala -->
<tr>
	<td>
		<table class="dark_bg" cellpadding="4" cellspacing="1">
		<tr>
			<td class="tbhead" colspan="6"><b>Factura fiscala</b> seria: <b>{SERIE_FISCALA}</b> a fost emisa.<br /></td>
		</tr>
		<tr>
			<td class="bgmain" width="15%">Data Eliberarii</td>
			<td class="bgmain" width="20%">Beneficiar</td>
			<td class="bgmain" width="50%">Servici</td>
				<td class="bgmain" width="10%">Pret</td>
		</tr>
		<tr>
			<td class="row1" align="center">{DATA_ELIBERARII}</td>
			<td class="row1">{NUME_FIRMA}</td>
			<td class="row1">{SERVICI_FISCALA}</td>
			<td class="row1" align="center">{COST} RON</td>

		</tr>
		</table>
	</td>
</tr>
<!-- END if_fiscala -->
<tr>
	<td colspan="6" valign="middle" style="border-bottom:dotted; border-width:0.05em;border-color:#95CE05" width="200px">&nbsp;</td>
</tr>
<tr>
	<td >&nbsp;</td>
</tr>
<!-- END if_facturi -->
</table>
<table align="center" width="600" > 
<tr>
	<td colspan="2" valign="middle" align="center" ><br />{NO_FACTURA}</td>
</tr>
</table>