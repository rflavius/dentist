<script language="JavaScript" type="text/javascript">
<!--
function PlayThis(v)
{
	if (v=='Y')
	{
		$('expeditia').show();
	}
	else
	{
		$('expeditia').hide();
	}
}

function completPret(val)
{
	if(val=='2')
	{
		document.adauga_firma.price.value="200";
	}
		if(val=='3')
	{
		document.adauga_firma.price.value="200";
	}
		if(val=='4')
	{
		document.adauga_firma.price.value="200";
	}
		if(val=='5')
	{
		document.adauga_firma.price.value="400";
	}
		if(val=='6')
	{
		document.adauga_firma.price.value="400";
	}
	if(val=='7')
	{
		document.adauga_firma.price.value="240";
	}
}

function ShowSistemPromovare(val)
{
	if(val=='vechi')
	{
		$('nou').hide();
	}
	else
	{
		$('vechi').hide();
	}
	$(val).show();
}

loadImage1 = new Image();
loadImage1.src = "http://www.dentistonline.ro/images/allstufs/imagine_recomandate.gif";
staticImage1 = new Image();
staticImage1.src = "http://www.dentistonline.ro/images/allstufs/imagine_recomandate_mica.gif";
//-->
</script>


{INFORMATION}
<form method="post" action="?page={LINK_NAME}" name="adauga_firma">
<br>
<h1>Informatii Factura Proforma</h1>
<table border="0" cellspacing="3" cellpadding="4" width='60%' class="grey">
	<tr>
		<td><b>Sistem promovare vechi</b><input type='radio' name='promovare_tip' value='vechi' onClick='ShowSistemPromovare(this.value)' style='margin-left:50px;' checked></td>
		<td><b>Sistem promovare nou</b><input type='radio' name='promovare_tip' value='nou' onClick='ShowSistemPromovare(this.value)' style='margin-left:50px;'></td>
	</tr>
</table>
<br>
<div id='vechi'>
<table border="0" cellspacing="1" cellpadding="4" width='60%' class="grey">
<tr>
	<td width='30%' valign='top' class="row1"><b>Servici:</b><br />
	*textul se va genera conform datelor introduse
	</td>
	<td class="row1">
		<textarea name="serviciu" rows="5" cols="60">{SERVICIU}</textarea>
	</td>
</tr>
<tr>
	<td  class="row2"><b>Tip promovare:</b><br>
	*tipul promovarii de care va beneficia
	</td>
	<td  class="row2">
				<select name="type_promovare" onchange="completPret(this.value)">
						<option value="">------- Alege -------</option>
						<!-- BEGIN display_types -->
						<option value="{TYPE_ID}" {SELECTTEDTYPE}>{TYPE_NAME} -------- {TYPE_COST} RON--------{TYPE_PERIOADA} luni</option>
						<!-- END display_types -->
				</select>
	</td> 
</tr>
<tr>
	<td  class="row2"><b>Pret:</b></td>
	<td  class="row2"><input type="text" name="price" value="{PRICE}" /></td>
</tr>

<tr>
	<td  class="row1"><b>Moneda:</b></td>
	<td  class="row1">RON&nbsp;<input type="radio" name="moneda" value="RON" {RON_CHK} checked></td>
</tr>
<tr class="row2">
	<td><b>Perioada:</b></td>
	<td><select name="perioada">
			<option value="1" selected>1 luni </option>
		<option value="2" >2 luni </option>
		<option value="3" >3 luni </option>
		<option value="4" >4 luni </option>
		<option value="5" >5 luni </option>
		<option value="6" >6 luni </option>
		<option value="12">12 luni</option>
		<option value="12">14 luni</option>
		<option value="24">24 luni</option>
	</select></td>
</tr>
<tr class="row2">
	<td><b>Type:</b></td>
	<td><select name="type">
		<option value="persoana_fizica" selected>Persoana fizica </option>
		<option value="firma">Firma</option>
		
	</select></td>
</tr>
</table>
<br>
<h1>Informatii Cumparator</h1>
<table border="0" cellspacing="1" cellpadding="4" width='60%' class="grey">
<tr class="row1">
	<td width='30%'><b>Nume & Prenume / Denumire firma:</b></td>
	<td><input type="text" name="name" value="{NAME}" size="60" /></td>
</tr>
<tr class="row2">
	<td><b>Adresa:</b></td>
	<td><textarea name="adresa_vechi" rows="5" cols="60">{ADRESA}</textarea></td>
</tr>
<tr class="row1">
	<td><b>CUI:</b></td>
	<td><input type="text" name="cui" value="{CUI}" /></td>
</tr>
<tr  class="row1">
	<td><b>Nr RC:</b></td>
	<td><input type="text" name="rc" value="{RC}" /></td>
</tr>
<tr  class="row2">
	<td><b>CNP:</b></td>
	<td><input type="text" name="cnp" value="{CNP}" /></td>
</tr>
<tr class="row2">
	<td><b>BI:</b></td>
	<td><input type="text" name="bi" value="{BI}" /></td>
</tr>


<tr  class="row2">
	<td><b>User ID:</b></td>
	<td><input type="text" name="user_id" value="{USER_ID}" /></td>
</tr>
<tr  class="row1">
	<td><b>Firma ID</b></td>
	<td><input type="text" name="firma_id" value="{FIRMA_ID}" /></td>
</tr>
<tr  class="row1">
	<td><b>Email destinatar</b></td>
	<td><input type="text" name="email_vechi" value="{EMAIL}" size="50"/></td>
</tr>

<tr class="row2">
	<td><b>Nume Firma:</b></td>
	<td><input type="text" name="nume_firma" value="{NUME_FIRMA}" /></td>
</tr>

<tr class="row2">
	<td colspan='2'><input type="submit" name="sbmtbtn" value="Genereaza Factura" class='button' /></td>
</tr>
</table>
<br />
<table border="0" cellspacing="0" cellpadding="0" align="left" style="padding-left:25px;">
<tr>
	<td>INFORMATII:</td>
</tr>
<tr>
	<td ><b>* Daca cabinetul este recomandat acesta se adauga in tabela de " <u>cabinete recomandate</u>" .</b></td>
</tr>
<tr>
	<td></td>
</tr>
<tr>
	<td></td>
</tr>
</table>
</div>
<div id='nou' style='display:none;'>
<script type="text/javascript" src="{SITE_BASEE}/templates/js/admin/promovare.js"></script>

<br>
<input type='hidden' name='firma_pachet' value='1' id='firma_pachet'>
<input type='hidden' name='firma_servicii' value='{SELL_SERVS}' id='firma_servicii'>
<input type='hidden' name='total' value='{TOTAL}' id='firma_total'>
<input type='hidden' name='cabinet_id' value='{CAB_ID}' id='cabinet_id'>
<input type='hidden' name='user_id' value='{USER_ID}'> 

	<table width="45%" class="grey" cellpadding="4" cellspacing="1">
		<tr>
			<td class="tbhead" colspan="2">Adauga Tip Promovare</td>
		</tr>
		<tr> 
			<td class="row1" width='120'><b>Pachet</b><p class="star">*</p></td>
			<td class="row2">
				<select name="pachet" onChange="updatePachet2(this.value)">
					<!-- BEGIN list_pachete -->
					<option value='{PACHET_ID}' {PACHET_SELL}>{PACHET} - {COST} RON</option>
					<!-- END list_pachete -->
				</select>
			</td>
		</tr>
		<tr>
			<td class="row1"><b>Servicii</b><p class="star">*</p></td>
			<td class="row2">
				<table cellpadding="4" cellspacing="1">
				<!-- BEGIN list_servicii -->
				<tr>
					<td width='240'>{SERV} {VALUE} - {SERV_PRET}RON</td>
					<td align='center'><input type='checkbox' name='services[]' value='{SERV_ID}' {SERV_CHECK} onClick=addPachetService('{SERV_ID}')></td>
				</tr>
				<!-- END list_servicii -->
				</table>
			</td>
		</tr>
		<tr> 
			<td class="row1"><b>Total Promovare</b>:</td>
			<td class="row2"><input type='text' id='total_price' name='total_price' value='{TOTAL}' width='20'><b>RON</b></td>
		</tr>
		<tr> 
			<td class="row1"><b>Continut factura</b>:</td>
			<td class="row2" valign='top'>
				<textarea name='serviciu' rows='10' cols='70' id='factura_text'></textarea>
			</td>
		</tr>
		<tr>
			<td colspan='2' class='tbhead'>Date facturare</td>
		</tr>
		<tr>
			<td colspan='2'>
				{FACTURARE_BLOCK}
			</td>
		</tr>
		<tr  class="row2">
			<td><b>User ID:</b></td>
			<td><input type="text" name="user_id" value="{USER_ID}" /></td>
		</tr>
		<tr  class="row1">
			<td><b>Firma ID</b></td>
			<td><input type="text" name="firma_id" value="{FIRMA_ID}" /></td>
		</tr>
		<tr  class="row1">
			<td><b>Email destinatar</b></td>
			<td><input type="text" name="email" value="{EMAIL}" size="50"/></td>
		</tr>
		
		<tr class="row2">
			<td><b>Nume Firma:</b></td>
			<td><input type="text" name="nume_firma" value="{NUME_FIRMA}" /></td>
		</tr>
		<tr>
			<td align="center" colspan="2" class='row1'>
				<input type="submit" value="genereaza factura" class="button" />
			</td>
		</tr>
	</table>
</div>
</form>