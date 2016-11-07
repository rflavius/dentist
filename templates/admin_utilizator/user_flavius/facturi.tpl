<h1>Facturi</h1>
<p>In cadrul acestei pagini aveti acces la toate facturile Proforme si Fiscale generate pentru dvs.</p>
<br>
<fieldset>
	<legend>FACTURI PROFORME</legend>
	<table cellpadding="0" cellspacing="1" class="big_table" width="100%">
		<tr>
			<td class="table_subhead">#</td>
			<td class="table_subhead"><b>Beneficiar</b></td>
			<td class="table_subhead" width="250"><b>Servicii</b></td>
			<td class="table_subhead"><b>Pachet</b></td>
			<td class="table_subhead"><b>Data</b></td>
			<td class="table_subhead"><b>Pret</b></td>
			<td class="table_subhead"><b>Achitata</b></td>
			<td class="table_subhead">&nbsp;</td>
		</tr>
		<!-- BEGIN if_no_records -->
		<tr>
			<td class="row1" colspan="8">{NO_RECORDS}</td>
		</tr>
		<!-- END if_no_records -->
		<!-- BEGIN list_row -->
		<tr>
			<td class="{BGROW}">{NR_FACT}</td>
			<td class="{BGROW}"><b>{BENEFICIAR}</b></td>
			<td class="{BGROW}">{SERVICII}</td>
			<td class="{BGROW}"><img src="../images/pachet_{PACHET}.png"></td>
			<td class="{BGROW}">{DATE}</td>
			<td class="{BGROW}"><b>{PRICE}</b></td>
			<td class="{BGROW}"><img src="../images/{PAYED}.png"></td>
			<td nowrap class="{BGROW}">
				<ul>
					<li><a href="?page=user.viewfacturaproforma.{NR_FACT}" target="_blank">vezi factura</a></li>
					<li><a href="?page=user.downloadfacturaproforma.{NR_FACT}">download factura</a></li>
					<li><a href="?page=user.printfacturaproforma.{NR_FACT}" target="_blank">listeaza factura</a></li>
				</ul>
			</td>
		</tr>
		<!-- END list_row -->
	</table>
</fieldset>
<br><br>

<fieldset>
	<legend>FACTURI FISCALE</legend>
	<table cellpadding="0" cellspacing="1" class="big_table" width="100%">
		<tr>
			<td class="table_subhead">#</td>
			<td class="table_subhead"><b>Fact.Proforma</b></td>
			<td class="table_subhead"><b>Beneficiar</b></td>
			<td class="table_subhead" width="300"><b>Servicii</b></td>
			<td class="table_subhead"><b>Data</b></td>
			<td class="table_subhead"><b>Pret</b></td>
			<td class="table_subhead"><b>Achitata</b></td>
			<td class="table_subhead">&nbsp;</td>
		</tr>
		<!-- BEGIN if_no_fisc_records -->
		<tr>
			<td class="row1" colspan="8">{NO_RECORDS_FISC}</td>
		</tr>
		<!-- END if_no_fisc_records -->
		<!-- BEGIN list_fisc_row -->
		<tr>
			<td class="{BGROW}">{NR_FACT_FISC}</td>
			<td class="{BGROW}">{NR_FACT_PRO}</td>
			<td class="{BGROW}"><b>{BENEFICIAR_FISC}</b></td>
			<td class="{BGROW}">{SERVICII_FISC}</td>
			<td class="{BGROW}">{DATE_FISC}</td>
			<td class="{BGROW}"><b>{PRICE_FISC}</b></td>
			<td class="{BGROW}"><img src="../images/{PAYED}.png"></td>
			<td nowrap class="{BGROW}">
				<ul>
					<li><a href="?page=user.viewfacturafiscala.{NR_FACT_FISC}" target="_blank">vezi factura</a></li>
					<li><a href="?page=user.downloadfacturafiscala.{NR_FACT_FISC}">download factura</a></li>
					<li><a href="?page=user.printfacturafiscala.{NR_FACT_FISC}" target="_blank">listeaza factura</a></li>
				</ul>
			</td>
		</tr>
		<!-- END list_fisc_row -->
	</table>
</fieldset>

