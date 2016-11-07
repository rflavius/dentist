<script language="javascript" type="text/javascript">
<!--
	function redirect()
	{
		if(document.cabinete.valoare_cautare.value)
		{
			document.location.href = "index.php?page=cabinete.cauta."+document.cabinete.list_type.value+"."+document.cabinete.valoare_cautare.value;
			
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
			<form method="post" action="" name="cabinete">
			<table align="center" class="tbpagination" cellspacing="{CS}" cellpadding="{CP}" width="100%">
				<tr>
					<td class="{B1}"  width="120" align="center"><strong>Cauta Cabinete Dupa </strong></td>
					<td class="{B2}" width="100" align="left">
					<select name="list_type" >
						<option value="nume_firma" {NUME_FIRMA}>Nume firma</option>
						<option value="inreg_fiscala_cnp" {INREG_FISCALA_CNP}>Inregistrare fiscala- CNP</option>
						<option value="ref_comert_bi" {REG_COMERT_BI}>Registru comertului - BI</option>
						<option value="pers_contact" {PERS_CONTACT}>Persoana contact</option>
						<option value="submission_date" {SUBMISSION_DATE}>Data adaugarii</option>
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
			<table width="100%" class="grey" cellpadding="4" cellspacing="1">
				<tr>
					<td class="tbhead" colspan="13">LIST ALL CABINETE , LABOARATOARE, CLINICI</td>
				</tr>
				<!-- BEGIN if_cabinete -->
				<tr>
					<td class="bgmain" width="2%">Id</td>
					<td class="bgmain" width="10%">Nume Cabinet</td>
					<td class="bgmain" width="10%">Media</td>
					<td class="bgmain" width="5%">User</td>
					<td class="bgmain" width="12%">E-mail</td>
					<td class="bgmain" width="7%">Telefon</td>
					<td class="bgmain" width="7%">Promovare</td>
					<td class="bgmain" width="7%">Agent</td>
					<td class="bgmain" width="10%">Date add</td>
					<td class="bgmain" width="11%" nowrap>Parent module/Cat</td>
					<td class="bgmain" width="5%" nowrap>Visits </td>
					<td class="bgmain" width="5%">Status</td>
					<td class="bgmain" width="10%">Actions</td>
				</tr>
				<!-- BEGIN list_cabinete -->
				<tr class="{BGCOLOR}">
					<td align="center" valign="top">
						{ID}
					</td>
					<td valign="top">
						<b>
							<a href="{LINK_TO_CABINET}" title='View "{NUME_CABINET}" cabinet' target="_blank">{NUME_CABINET}</a><br /> 
						</b>
					</td>
					<td valign="top" align="center"><img src="{IMAGINE}"><br />
					{NR_IMAGINI} imag<br>
					{NR_VIDEO} video  <br>
					{NR_BANNER} banner </td>
					<td valign="top"><div id="norows"><a href="?page=users.details.{USER_ID}">{USER}</a></div></td>
					<td valign="top"><div id="norows">{EMAIL}</div></td>
					<td valign="top"><div id="norows">{TELEFON}</div></td>
					<td valign="top">{LOCPROMOVARE}</td>
					<td valign="top">{AGENT}</td>
					<td valign="top">{SUBMISION_DATE}</td>
					<td valign="top">{PARENT_MODULE}</td>
					<td valign="top">{NR_VISITS}</td>
					<td align="center" valign="top"><img src="../images/admin/{IMAGE}" title='Turn "{TITLE}" cabinet to {IMAGE_TITLE}'></td>
					<td align="left" valign="top">
						<a href="?page=marketing.addcontact.{ID}">Adauga contact</a><br />
						<a href="?page=plati.genereazaproforma.{ID}.{USER_ID}.{JUDET_ID}.{TYPE_ID}">Generate proforma</a><br />
					</td>
				</tr>
				<!-- END list_cabinete -->
				<!-- END if_cabinete -->
				<!-- BEGIN if_no_cabinete -->
					<td class="bgmain" colspan="12">No cabinet for this section</td>
				<!-- END if_no_cabinete -->
			</table>
		</td>
	</tr>
</table>