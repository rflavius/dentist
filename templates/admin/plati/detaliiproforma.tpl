<br /><br />
<form method="post" action="?page=plati.updateproforma.{ID}">

<table border="0" cellspacing="1" cellpadding="4" width="50%" class="grey">
<tr>
	<td class="tbhead" colspan="2">Informatii factura proforma - {ID} - </td>
</tr>
<tr>
	<td class="{BGCOLOR1}" width="50%"><b>USERNAME</b></td><td class="{BGCOLOR2}"><a href="?page=users.details.{USER_ID}.{USERNAME}">{USERNAME}</a></td>
</tr>
<tr>
	<td class="{BGCOLOR1}"><b>Nume firma</b></td><td class="{BGCOLOR2}"><a href="?page=cabinete.edit.{FIRMA_ID}.{USER_ID}">{NUME_FIRMA}</a></td>
</tr>
<tr>
	<td class="{BGCOLOR1}"><b>Email</b></td><td class="{BGCOLOR2}"><input type="text" name="email" value="{EMAIL}" size="50"></td>
</tr>
<tr>
	<td class="{BGCOLOR1}"><b>Perioada</b></td><td class="{BGCOLOR2}"> <input type="text" name="perioada" value="{PERIOADA}"> luni</td>
</tr>
<tr>
	<td class="{BGCOLOR1}"><b>Type</b></td><td class="{BGCOLOR2}" > <input type="text" name="type" value="{TYPE}"></td>
</tr>
<tr>
	<td class="{BGCOLOR1}"><b>Emis factura proforma</b></td><td class="{BGCOLOR2}"><input type="text" name="emis_fact_proforma" value="{EMIS_FACT_PROFORMA}"></td>
</tr>
<tr>
	<td class="{BGCOLOR1}"><b>Achitat</b></td><td class="{BGCOLOR2}"><a href="?page=plati.schimba.{ID}.{ACHITAT}.{EXPIRARE_PROFORMA}">change</a> - <b {CLASSNOTPAYED}>{ACHITAT}</b></td>
</tr>
<tr>
	<td class="{BGCOLOR1}"><b>Cost</b></td><td class="{BGCOLOR2}"><input type="text" name="cost" value="{COST}"></td>
</tr>

<tr>
	<td class="{BGCOLOR1}"><b>Adaugare proforma</b></td><td class="{BGCOLOR2}"><input type="text" name="adaugare_proforma" value="{ADAUGARE_PROFORMA}"></td>
</tr>
<tr>
	<td class="{BGCOLOR1}"><b>Expirare Proforma</b></td><td class="{BGCOLOR2}"><input type="text" name="expirare_proforma" value="{EXPIRARE_PROFORMA}"></td>
</tr>
<tr>
	<td class="{BGCOLOR1}"><b>Status</b></td><td class="{BGCOLOR2}"><input type="text" name="status" value="{STATUS}"></td>
</tr>

<tr>
	<td class="{BGCOLOR1}"><b>Recomandata</b></td><td class="{BGCOLOR2}"><input type="text" name="recomandata" value="{RECOMANDATA}"></td>
</tr>
<tr>
	<td colspan="2" align="center" class="{BGCOLOR1}"> <br /><input type="button" name="sbmtbtn" class="button" value="Back" onclick="history.back();"/> <input type="submit" name="sbmtbtn" class="button" value="Update" /></td>
</tr>

<tr>
	<td class="{BGCOLOR1}" colspan="2">
	<br /><br />
	<ol>
		<li >Status <b style="color:red">activ</b> insemna ca factura proforma a fost achitata sau inca nu a expirat . </li>
		<li>Status <b style="color:red">inactiv</b> factura proforma a expirat, si nu a fost platita.</li>
		<li >Trimisa <b style="color:red">N</b> insemna ca factura proforma nu a fost trimisa clientului!! . </li>
		<li>Data Expir ari se refera la expirarea facturii proforme.</li>
		
		<li>Liniile cu <b style="color:green">verde</b> sunt facturi proforme emise astazi!</li>
		<li style="color:#990000">Cand se schimba statusul in <b>"Achitat-Y"</b> la factura proforma ,aceasta este introdusa automat la contracte si facturi fiscale!!!
		&nbsp;<br />Deasemenea la db cabinete s epune recomandat pe 'Y', iar la db recomandate finalizat='Y';
		</li>
		</ol>
	</td>
	</tr>
</table>
</form>