<script language="javascript" type="text/javascript">
<!--
	function redirect()
	{
		if(document.facturi.valoare_cautare.value)
		{
			document.location.href = "index.php?page=plati.cauta."+document.facturi.list_type.value+"."+document.facturi.valoare_cautare.value+"."+document.facturi.facturi_type.value;
			
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
			<form method="post" action="" name="facturi">
			<table align="center" class="tbpagination" cellspacing="{CS}" cellpadding="{CP}" width="100%">
				<tr>
					<td class="{B1}"  width="120" align="center"><strong>Cauta Facturi Dupa  </strong></td>
					<td class="{B2}" width="100" align="left">
					<select name="list_type" >
						<option value="id_factura" {ID_FACTURA}>Id factura</option>
						<option value="username_factura" {USERNAME_FACTURA}>Username</option>
						<option value="user_id_factura" {USER_ID_FACTURA}>User id</option>
						<option value="nume_firma_factura" {NUME_FIRMA_FACTURA}>Nume Firma</option>
						<option value="perioada_factura" {PERIOADA_FACTURA}>Perioada (1,2) ani</option>
						<option value="status_factura" {STATUS_FACTURA}>Status (Y,N)</option>
						<option value="adaugare_factura" {ADAUGARE_FACTURA}>Data Adaugare factura</option>
						<option value="expirare_factura" {EXPIRARE_FACTURA}>Data Expirare factura</option>
						<option value="type_factura" {TYPE_FACTURA}>Tip - firma,persoana_fizica </option>
					</select>
					</td>
					<td class="{B1}"  width="120" align="center"><b>Cauta in</b></td>
					<td class="{B2}"  align="left">
					<select name="facturi_type">
						<option value="facturi_proforme" {FACTURI_PROFORME}>Facturi proforme</option>
						<option value="facturi_fiscale" {FACTURI_FISCALE}>Facturi Fiscale</option>
					</select>
					</td>
					<td class="{B1}"  width="80" align="center"><b>Valoare</b></td>
					<td class="{B2}"  width="100" align="left">
						<input type="text" name="valoare_cautare" value="{VALOARE_CAUTARE}" />
					</td>
					<td class="{B2}"  width="100" align="left">
						<input type="button" name="sbmtbtn" value="Cauta" onclick="redirect();" />
					</td>

				</tr>
			</table>
			</form>
				<br />
			<table align="center" class="tbpagination" cellspacing="{CS}" cellpadding="{CP}" width="100%">
				<tr>
					<td class="{B1}"  width="80" align="center"><strong>{COUNT_FACTURAI} Facturi </strong></td>
					<td class="{B2}" width="60" align="center">Pages <strong>({PAGES}) : </strong></td>
					<td class="{B1}" align="center">{PAGINATION}</td>
				</tr>
			</table>
			<br />
			<table width="100%" class="grey" cellpadding="4" cellspacing="1">
				<tr>
					<td class="tbhead" colspan="12">{FEL_FACTURA} ce indeplinesc criteriul : {CE_CAUTAM} = {VALOARE_CAUTARE}</td>
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
					<td class="bgmain" width="7%">Status</td>
					<td class="bgmain" width="7%">Delete</td>
				</tr>
				<!-- BEGIN list_messages -->
				<tr class="{BGCOLOR}">
					<td valign="top"><b>{ID}</b></td>
					<td valign="top"><b><a href="?page=users.details.{USER_ID}.{USERNAME}">{USERNAME}</a></b></td>
					<td valign="top"> <a href="?page=cabinete.edit.{FIRMA_ID}.{USER_ID}">{NUME_FIRMA}</a></td>
					<td valign="top">{TYPE}</td>
					<td valign="top"><a href="?page=plati.schimba.{ID}.{ACHITAT}">change</a> - {ACHITAT}</td>
					<td valign="top">{ADAUGARE_FACTURA}</td>
					<td valign="top" align="center" {CLASSEXP}>{EXPIRARE_FACTURA}</td>
					<td align="center" valign="top">{COST}</td>
					<td valign="top" align="center">
							<img src="../images/admin/{IMAGE}" title="Turn {USERNAME}'s account to {IMAGE_TITLE}">
						</td>
					<td align="center" valign="top">
						<a href="?page=delete.factura.{ID}">
							<img src="../images/admin/delete.png" title="Delete factura {ID}">
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
		<li >Status <b style="color:red">activ</b> insemna ca factura proforma a fost achitata sau inca nu a expirat . </li>
		<li>Status <b style="color:red">inactiv</b> factura proforma a expirat, si nu a fost platita.</li>
		<li>Data Expirari se refera la expirarea contractului<br /></li>
		<li>Liniile cu <b>verde</b> sunt contracte incheiate astazi!</li>
		</ol>
	</td>
	</tr>
</table>