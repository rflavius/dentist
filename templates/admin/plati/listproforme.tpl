<script language="javascript" type="text/javascript">
<!--
	function redirect()
	{
			document.location.href = "index.php?page=plati.facturiproforme."+document.facturiproforme.list_proforme.value+"."+document.facturiproforme.proforme_achitat.value+"."+document.facturiproforme.proforme_status.value;
	}
//-->
</script>
<br />
<table align="center" border="0" cellspacing="0" cellpadding="0" width="99%">
	<tr>
		<td>
			{INFORMATION}
			<table border="0" cellspacing="0" cellpadding="0" width="100%">
			<tr>
				<td>
					<form method="post" action="" name="facturiproforme">
					<table align="left" class="tbpagination" cellspacing="{CS}" cellpadding="{CP}" width="98%" >
					<tr>
						<td class="{B1}"  width="120" align="center"><strong>Listeaza Proforme Dupa : </strong></td>
						<td class="{B2}" width="60" align="left">
						
						<select name="list_proforme" onchange="redirect();">
							<option value="adaugare_proforma_desc" {ADAUGARE_PROFORMA_DESC}>Adaugare Proforma - DESC</option>
							<option value="adaugare_proforma_asc" {ADAUGARE_PROFORMA_ASC} >Adaugare Proforma- ASC</option>
							<option value="expirare_proforma_asc" {EXPIRARE_PROFORMA_ASC}>Expirare Proforma - ASC</option>
							<option value="expirare_proforma_desc" {EXPIRARE_PROFORMA_DESC}>Expirare Proforma - DESC</option>
							<option value="nume_firma_asc" {NUME_FIRMA_ASC}>Nume Firma - ASC</option>
							<option value="nume_firma_desc" {NUME_FIRMA_DESC}>Nume Firma - DESC</option>
						</select>
						</td>
						<td class="{B1}"  width="100" align="center"><b>Proforme achitate</b></td>
						<td class="{B2}"  width="100" align="left">
						<select name="proforme_achitat" onchange="redirect();">
							<option value="all" {SELECTEDALL}>All</option>
							<option value="Y" {SELECTEDY}>Achitate</option>
							<option value="N" {SELECTEDN}>Neachitate</option>
						</select>
						</td>
						<td  class="{B1}"  width="80" align="center"><b>Status</b>
						</td>
						<td  class="{B2}"  width="100" align="left">
						<select name="proforme_status" onchange="redirect();">
							<option value="all" {SELECTEDSTATUSALL}>All</option>
							<option value="Y" {SELECTEDSTATUSY}>Activ</option>
							<option value="N" {SELECTEDSTATUSN}>Inactiv</option>
						</select>
						</td>
					</tr>
					</table>
					</form>
				</td>
				</tr>
			</table>
			<br />
			<table align="center" class="tbpagination" cellspacing="{CS}" cellpadding="{CP}" width="100%">
				<tr>
					<td class="{B1}"  width="80" align="center"><strong>{COUNT_PROFORME} Proforme </strong></td>
					<td class="{B2}" width="60" align="center">Pages <strong>({PAGES}) : </strong></td>
					<td class="{B1}" align="center">{PAGINATION}</td>
				</tr>
			</table>
			<br />
			<table width="100%" class="grey" cellpadding="4" cellspacing="1">
				<tr>
					<td class="tbhead" colspan="13">Toate facturile proforme</td>
				</tr>
				<!-- BEGIN if_messages -->
				<tr>
					<td class="bgmain">Id</td>
					<td class="bgmain" nowrap>Username</td>
					<td class="bgmain" nowrap>Nume firma</td>
					<td class="bgmain">Tip</td>
					<td class="bgmain" nowrap>An</td>
					<td class="bgmain" nowrap>Achitat</td>
					<td class="bgmain" nowrap>Date add</td>
					<td class="bgmain" width="7%" nowrap>Expire date</td>
					<td class="bgmain" width="10%">Promovare</td>
					<td class="bgmain" width="5%">SENT @</td>
					<td class="bgmain" width="7%">Cost</td>
					<td class="bgmain" width="7%">Status</td>
					<td class="bgmain" width="7%">Actions</td> 
				</tr>
				<!-- BEGIN list_messages -->
				<tr class="{BGCOLOR}">
					<td valign="top">Prof: [ <a href="?page=plati.detaliiproforma.{ID}"><b>{ID}</b></a> ]<br>
					Fisc: [ <a href="?page=plati.viewfiscala.{FACTURA_FISALA_ID}"><b>{FACTURA_FISALA_ID}</b></a> ]
					</td>
					<td valign="top"><b><a href="?page=users.details.{USER_ID}.{USERNAME}">{USERNAME}</a></b></td>
					<td valign="top"> <a href="?page=cabinete.edit.{FIRMA_ID}.{USER_ID}">{NUME_FIRMA}</a></td>
					<td valign="top">{TYPE}</td>
					<td valign="top">{AN_FACTURA}</td>
					<td valign="top"><a href="?page=plati.schimba.{ID}.{ACHITAT}.{EXPIRARE_PROFORMA}">change</a> - <b {CLASSNOTPAYED}>{ACHITAT}</b></td>
					<td valign="top">{ADAUGARE_PROFORMA}</td>
					<td valign="top" align="center" {CLASSEXP}>{EXPIRARE_PROFORMA}</td>
					<td valign="top" align="center" >{LOCPROMOVARE}</td>
					<td align="center" valign="top" {NOTSENT}>{EMISA}</td>
					<td align="center" valign="top">{COST}</td>
					<td valign="top" align="center">
							<img src="../images/admin/{IMAGE}" title="Turn {USERNAME}'s account to {IMAGE_TITLE}">
						</td>
					<td align="center" valign="top">
						<a href="?page=delete.facturaproforma.{ID}">[ Delete ]
							
						</a><br />
						<a href="?page=plati.viewproforma.{ID}">[ View ]
							
						</a><br />
						<a href="?page=plati.trimiteproforma.{ID}">[ Trimite ]
							
						</a>
					</td>
				</tr>
				<!-- END list_messages -->
				<!-- END if_messages -->
			</table>
		</td>
	</tr>
	<tr>
	<td >	<center><b>{NOTFOUND}</b></center>
	<br /><br />
	<ol>
		<li>Status <b style="color:red">activ</b> insemna ca factura proforma a fost achitata sau inca nu a expirat . </li>
		<li>Status <b style="color:red">inactiv</b> factura proforma a expirat, si nu a fost platita.</li>
		<li >SENT <b style="color:red">N</b> insemna ca factura proforma nu a fost trimisa clientului!! . </li>
		<li>Data Expir ari se refera la expirarea facturii proforme.</li>
		
		<li>Liniile cu <b style="color:green">verde</b> sunt facturi proforme emise astazi!</li>
		<li style="color:#990000">Cand se schimba statusul in <b>"Achitat-Y"</b> la factura proforma ,aceasta este introdusa automat la contracte si facturi fiscale!!!</li>
		<li>&nbsp;<br />Deasemenea la baza de date CABINETE se pune recomandat pe 'Y', iar la  RECOMANDATE finalizat='Y';</li>
	</ol>
	</td>
	</tr>
</table>