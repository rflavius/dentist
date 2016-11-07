<script language="javascript" type="text/javascript">
<!--
	function redirect()
	{
			document.location.href = "index.php?page=contracte.list."+document.contracte.list_proforme.value+"."+document.contracte.proforme_achitat.value;
	}
//-->
</script>
<br />
<table align="center" border="0" cellspacing="0" cellpadding="0" width="98%">
	<tr>
		<td>
			{INFORMATION}
			
			<form method="post" action="" name="contracte">
			<table align="center" class="tbpagination" cellspacing="{CS}" cellpadding="{CP}" width="100%">
				<tr>
					<td class="{B1}"  width="80" align="center"><strong>Listeaza Contracte Dupa : </strong></td>
					<td class="{B2}" width="60" align="left">
					
					<select name="list_proforme" onchange="redirect();">
						<option value="adaugare_contract_desc" {ADAUGARE_CONTRACT_DESC}>Adaugare Contract - DESC</option>
						<option value="adaugare_contract_asc" {ADAUGARE_CONTRACT_ASC} >Adaugare Contract- ASC</option>
						<option value="expirare_contract_asc" {EXPIRARE_CONTRACT_ASC}>Expirare Contract - ASC</option>
						<option value="expirare_CONTRACT_desc" {EXPIRARE_CONTRACT_DESC}>Expirare Contract - DESC</option>
						<option value="nume_firma_asc" {NUME_FIRMA_ASC}>Nume Firma - ASC</option>
						<option value="nume_firma_desc" {NUME_FIRMA_DESC}>Nume Firma - DESC</option>
					</select>
					</td>
					<td class="{B1}"  width="100" align="center"><b>Status Contract</b></td>
					<td class="{B2}"  width="100" align="left">
					
					<select name="proforme_achitat" onchange="redirect();">
						<option value="all" {SELECTEDALL}>All</option>
						<option value="Y" {SELECTEDY}>Activ</option>
						<option value="N" {SELECTEDN}>Inactiv</option>
					</select>
					</td>
				</tr>
			</table>
			</form>
				<br />
			<table align="center" class="tbpagination" cellspacing="{CS}" cellpadding="{CP}" width="100%">
				<tr>
					<td class="{B1}"  width="80" align="center"><strong>{COUNT_CONTRACTE} Contracte </strong></td>
					<td class="{B2}" width="60" align="center">Pages <strong>({PAGES}) : </strong></td>
					<td class="{B1}" align="center">{PAGINATION}</td>
				</tr>
			</table>
			<br />
			<table width="100%" class="grey" cellpadding="4" cellspacing="1">
				<tr>
					<td class="tbhead" colspan="12">Toate contractele</td>
				</tr>
				<!-- BEGIN if_messages -->
				<tr>
					<td class="bgmain">Id</td>
					<td class="bgmain" nowrap>Username</td>
					<td class="bgmain" nowrap>Nume firma</td>
					<td class="bgmain">Tip</td>
					<td class="bgmain" nowrap>Achitat</td>
					<td class="bgmain" nowrap>Date add</td>
					<td class="bgmain" width="10%" nowrap>Expire date</td>
					<td class="bgmain" width="5%">Cost</td>
					<td class="bgmain" width="7%">Id Proforma</td>
					<td class="bgmain" width="7%">Serie Fiscala</td>
					<td class="bgmain" width="5%">Status</td>
					<td class="bgmain" width="5%">Delete</td>
				</tr>
				<!-- BEGIN list_messages -->
				<tr class="{BGCOLOR}">
					<td valign="top"><a href="?page=contracte.detaliicontract.{ID}"><b>{ID}</b></a></td>
					<td valign="top"><b><a href="?page=users.details.{USER_ID}.{USERNAME}">{USERNAME}</a></b></td>
					<td valign="top"> <a href="?page=cabinete.edit.{FIRMA_ID}.{USER_ID}">{NUME_FIRMA}</a></td>
					<td valign="top">{TYPE}</td>
					<td valign="top"><a href="?page=contracte.schimba.{ID}.{ACHITAT}">change</a> - {ACHITAT}</td>
					<td valign="top" align="center">{ADAUGARE_CONTRACT}</td>
					<td valign="top" align="center" {CLASSEXP}>{EXPIRARE_CONTRACT}</td>
					<td align="center" valign="top">{COST}</td>
					
					<td valign="top" align="center"><a href="?page=plati.detaliiproforma.{ID_PROFORMA}">{ID_PROFORMA}</a></td>
					<td valign="top" align="center">{ID_FISCALA}</td>
					<td valign="top" align="center"><a href="?page=contracte.set.{IMAGE_TITLE}.{ID}">
							<img src="../images/admin/{IMAGE}" title="Turn contract to {IMAGE_TITLE}">
						</a></td>
					<td align="center" valign="top">
						<a href="?page=delete.contract.{ID}">
							<img src="../images/admin/delete.png" title="Delete contract {ID}">
						</a>
					</td>
				</tr>
				<!-- END list_messages -->
				<!-- END if_messages -->
			</table>
		</td>
	</tr>
	<tr>
	<td><br /><br />
	<ol>
		<li>Status - este <b style="color:#990000">activ</b> inseamna ca contractul este inca valid. Un status <b style="color:#990000">inactiv</b> inseamna ca contractul a expirat</li>
		<li>Data Expirari se refera la expirarea contractului</li>
		<li>Liniile cu <b>verde</b> sunt contracte incheiate astazi!</li>
		</ol>
	</td>
	</tr>
</table>