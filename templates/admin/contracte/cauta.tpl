<script language="javascript" type="text/javascript">
<!--
	function redirect()
	{
		if(document.contracte.valoare_cautare.value)
		{
			document.location.href = "index.php?page=contracte.cauta."+document.contracte.list_type.value+"."+document.contracte.valoare_cautare.value;
			
		}
		else
		{
			alert("Nu ati introdus valoarea de cautare!");
		}
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
					<td class="{B1}"  width="120" align="center"><strong>Cauta Contracte Dupa : </strong></td>
					<td class="{B2}" width="60" align="left">
					
					<select name="list_type" >
						<option value="id_contract" {ID_CONTRACT}>Id contract</option>
						
							<option value="username_contract" {USERNAME_CONTRACT}>Username</option>
						<option value="user_id_contract" {USER_ID_CONTRACT}>User id</option>
						<option value="nume_firma_contract" {NUME_FIRMA_CONTRACT}>Nume Firma</option>
						<option value="perioada_contract" {PERIOADA_CONTRACT}>Perioada (1,2) ani</option>
						<option value="adaugare_contract_contract" {ADAUGARE_CONTRACT_CONTRACT}>Data Adaugare contract</option>
							<option value="expirare_contract_contract" {EXPIRARE_CONTRACT_CONTRACT}>Data Expirare contract</option>
						<option value="type_contract" {TYPE_FACTURA}>Tip - firma,persoana_fizica </option>
						<option value="factura_fiscala_id_contract" {FACTURA_FISCALA_ID_CONTRACT}>Id factura fiscala</option>
						<option value="factura_proforma_id_contract" {FACTURA_PROFORMA_ID_CONTRACT}>Id factura proforma</option>
					</select>
					</td>
					<td class="{B1}"  width="100" align="center"><b>Valoare</b></td>
					<td class="{B2}"  width="100" align="left">
						<input type="text" name="valoare_cautare" value="{VALOARE_CAUTARE}" />
					</td>
					<td class="{B2}"  width="100" align="left">
						<input type="button" name="sbmtbtn" class="button" value="Cauta" onclick="redirect();" />
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
					<td class="tbhead" colspan="12">Contracte ce indeplinesc criteriul : {CE_CAUTAM} = {VALOARE_CAUTARE}</td>
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
					<td class="bgmain" width="7%">Cost</td>
					
					<td class="bgmain" width="7%">Id Proforma</td>
					<td class="bgmain" width="7%">Id Fiscala</td>
					<td class="bgmain" width="7%">Status</td>
					<td class="bgmain" width="7%">Delete</td>
				</tr>
				<!-- BEGIN list_messages -->
				<tr class="{BGCOLOR}">
					<td valign="top"><b>{ID}</b></td>
					<td valign="top"><b><a href="?page=users.details.{USER_ID}.{USERNAME}">{USERNAME}</a></b></td>
					<td valign="top"> <a href="?page=cabinete.edit.{FIRMA_ID}.{USER_ID}">{NUME_FIRMA}</a></td>
					<td valign="top">{TYPE}</td>
					<td valign="top"><a href="?page=contracte.schimba.{ID}.{ACHITAT}">change</a> - {ACHITAT}</td>
					<td valign="top">{ADAUGARE_CONTRACT}</td>
					<td valign="top" align="center" {CLASSEXP}>{EXPIRARE_CONTRACT}</td>
					<td align="center" valign="top">{COST}</td>
					
					<td valign="top" align="center">{ID_PROFORMA}</td>
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
	<td>
	<center><b>{NOTFOUND}</b></center>
	<br /><br />
	<ol>
		<li>Formatul datei este <b>an-luna-zi</b> ex: 2008-01-03<br /> </li>
		<li>Status - este <b>activ</b> inseamna ca contractul este inca valid. Un status <b>inactiv</b> inseamna ca contractul a expirat<br /></li>
		<li>Data Expirari se refera la expirarea contractului<br /></li>
		<li>Liniile cu <b>verde</b> sunt contracte incheiate astazi!</li>
		</ol>
	</td>
	</tr>
</table>