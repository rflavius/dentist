<script type="text/javascript" src="{SITE_BASE}/templates/js/prototype.js"></script>
<script type="text/javascript" src="{SITE_BASE}/templates/js/mini/overlib.js"></script>
<script type="text/javascript" src="{SITE_BASE}/templates/js/mini/overlib_mini.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="{SITE_BASE}/templates/js/calendar-win2k-cold-1.css" title="blue">
<script type="text/javascript" src="{SITE_BASE}/templates/js/calendar.js"></script>
<script type="text/javascript" src="{SITE_BASE}/templates/js/calendar-en.js"></script>
<script type="text/javascript" src="{SITE_BASE}/templates/js/calendar-setup.js"></script>

<script language="JavaScript" type="text/javascript">
<!--

function ValidateStep2()
{
	var error = 0;
	if(document.getElementById('f_date_vv').value=="" || document.getElementById('f_date_bb').value=="")
	{
		alert('Nu ati complectat perioada ofertei de cazare !');
		error = 1;
	}

	if(error==0)
	{
		document.cazare_info.modify.value='on';
		document.cazare_info.submit();
	}
}

//-->
</script>
<h1>Modifica oferta de cazare</h1>
<form method="post" action="{EDIT_CAZARE_FORM}" name="cazare_info">
<input type="hidden" name="modify" value="" />
<fieldset>
	<legend>Oferta de cazare</legend>
	<table border="0" cellspacing="1" cellpadding="0" width="100%" align="center" class="big_table form">
		<tr>
			<td class="table_subhead" colspan="2">Perioada de cazare</td>
		</tr>
		<tr>
			<td class="row1" align="center">De la: &nbsp;&nbsp;&nbsp;
				<input type="text" name="start_date" id="f_date_vv" value="{STARTDATE}" size="10" maxlength="10"/>&nbsp;
					<button type="reset" id="f_trigger_vv" class = 'calendar2'></button>
					<script type="text/javascript">
						Calendar.setup({
						inputField     :    "f_date_vv",      // id of the input field
						ifFormat       :    "%Y-%m-%d",       // format of the input field
						showsTime      :   false,            // will display a time selector
						 timeFormat     :    "24",
						button         :    "f_trigger_vv",   // trigger for the calendar (button ID)
						singleClick    :    false            // double-click mode
													});
					</script>
				</td>
			<td class="row1" align="center">Pana la: &nbsp;&nbsp;&nbsp;
				<input type="text" name="end_date" id="f_date_bb" value="{ENDDATE}" size="10" maxlength='10' />&nbsp;
					<button type="reset" id="f_trigger_bb" class = 'calendar2'></button>
					<script type="text/javascript">
						Calendar.setup({
						inputField     :    "f_date_bb",      // id of the input field
						ifFormat       :    "%Y-%m-%d",       // format of the input field
						showsTime      :   false,            // will display a time selector
						 timeFormat     :    "24",
						button         :    "f_trigger_bb",   // trigger for the calendar (button ID)
						singleClick    :    false            // double-click mode
													});
					</script>
			</td>
		</tr>
		<tr>
			<td class="row2" colspan="2"><b>Preturile sunt exprimate in:</b>&nbsp;&nbsp;&nbsp;<input type="radio" name="valuta" value="RON" {VALUTA_1} />&nbsp;&nbsp;RON&nbsp;&nbsp;&nbsp;<input type="radio" name="valuta" value="EURO" {VALUTA_2} />&nbsp;&nbsp;EURO</td>
		</tr>
		<tr>
			<td colspan="2" class="row1">
			<table border="0" cellspacing="1" cellpadding="0" width="100%" align="center" >
			<tr>
				<td class="table_subhead" colspan="2" width="200">&nbsp;&nbsp;<b>Tip Camera</b></td>
				<td class="table_subhead">&nbsp;&nbsp;<b>Pret / Noapte / Camera</b></td>
			</tr>
			<tr>
				<td class="row2">&nbsp;&nbsp;Single </td>
				<td class="row2" align="center"><input type="text" name="nr_cam_single" value="{CAM_SINGLE}" size="3" maxlength="3"  />&nbsp;&nbsp;nr camere&nbsp;&nbsp;&nbsp;<img src="{SITE_BASE}/templates/skins/admin/images/help2.gif" onMouseOver="return overlib('Acesta este numarul de camere SINGLE pe care le detineti in cadrul unitatii dvs.', CAPTION, 'Numar Camere Single');" onmouseout="return nd();" ></td>
				<td class="row2" align="center">&nbsp;&nbsp;Pret&nbsp;&nbsp;<input type="text" name="pret_single" value="{PRET_SINGLE}" class="loginbox_input" /> &nbsp;&nbsp;&nbsp;<img src="{SITE_BASE}/templates/skins/admin/images/help2.gif" onMouseOver="return overlib('Acesta este pretul unei camere SINGLE, pretul este pe noapte. Va rugam sa scrieti doar pretul fara moneda in care este exprimat pretul.<br>Exemplu: 120', CAPTION, 'Pret Camera Single');" onmouseout="return nd();" ></td>
			</tr>
			<tr>
				<td class="row1">&nbsp;&nbsp;Double</td>
				<td class="row1" align="center"><input type="text" name="nr_cam_double" value="{CAM_DOUBLE}" size="3" maxlength="3" />&nbsp;&nbsp;nr camere&nbsp;&nbsp;&nbsp;<img src="{SITE_BASE}/templates/skins/admin/images/help2.gif" onMouseOver="return overlib('Acesta este numarul de camere DOUBLE pe care le detineti in cadrul unitatii dvs.', CAPTION, 'Numar Camere Double');" onmouseout="return nd();" ></td>
				<td class="row1" align="center">&nbsp;&nbsp;Pret&nbsp;&nbsp;<input type="text" name="pret_double" value="{PRET_DOUBLE}" class="loginbox_input" /> &nbsp;&nbsp;&nbsp;<img src="{SITE_BASE}/templates/skins/admin/images/help2.gif" onMouseOver="return overlib('Acesta este pretul unei camere DOUBLE, pretul este estimat pe noapte. Va rugam sa scrieti doar pretul fara moneda in care este exprimat pretul.<br>Exemplu: 120', CAPTION, 'Pret Camera Double');" onmouseout="return nd();" ></td>
			</tr>
			<tr>
				<td class="row2">&nbsp;&nbsp;Triple</td>
				<td class="row2" align="center"><input type="text" name="nr_cam_triple" value="{CAM_TRIPLE}" size="3" maxlength="3" />&nbsp;&nbsp;nr camere&nbsp;&nbsp;&nbsp;<img src="{SITE_BASE}/templates/skins/admin/images/help2.gif" onMouseOver="return overlib('Acesta este numarul de camere TRIPLE pe care le detineti in cadrul unitatii dvs.', CAPTION, 'Numar Camere Triple');" onmouseout="return nd();" ></td>
				<td class="row2" align="center">&nbsp;&nbsp;Pret&nbsp;&nbsp;<input type="text" name="pret_triple" value="{PRET_TRIPLE}" class="loginbox_input" /> &nbsp;&nbsp;&nbsp;<img src="{SITE_BASE}/templates/skins/admin/images/help2.gif" onMouseOver="return overlib('Acesta este pretul unei camere TRIPLE, pretul este estimat pe noapte. Va rugam sa scrieti doar pretul fara moneda in care este exprimat pretul.<br>Exemplu: 120', CAPTION, 'Pret Camera Triple');" onmouseout="return nd();" ></td>
			</tr>
			<tr>
				<td class="row1">&nbsp;&nbsp;Matrimonial</td>
				<td class="row1" align="center"><input type="text" name="nr_cam_matrimonial" value="{CAM_MATRIMONIAL}" size="3" maxlength="3" />&nbsp;&nbsp;nr camere&nbsp;&nbsp;&nbsp;<img src="{SITE_BASE}/templates/skins/admin/images/help2.gif" onMouseOver="return overlib('Acesta este numarul de camere MATRIMONIAL pe care le detineti in cadrul unitatii dvs.', CAPTION, 'Numar Camere Matrimonial');" onmouseout="return nd();" ></td>
				<td class="row1" align="center">&nbsp;&nbsp;Pret&nbsp;&nbsp;<input type="text" name="pret_matrimonial" value="{PRET_MATRIMONIAL}" class="loginbox_input" /> &nbsp;&nbsp;&nbsp;<img src="{SITE_BASE}/templates/skins/admin/images/help2.gif" onMouseOver="return overlib('Acesta este pretul unei camere MATRIMONIAL, pretul este estimat pe noapte. Va rugam sa scrieti doar pretul fara moneda in care este exprimat pretul.<br>Exemplu: 120', CAPTION, 'Pret Camera Matrimonial');" onmouseout="return nd();" ></td>
			</tr>
			</table>
			</td>
		</tr>
		<tr>
			<td class="table_subhead" valign="top" align="left" colspan="2"><b>Alte Posibilitati / Oferte :</b></td>
		</tr>
		<tr>
			<td align="center" class="row1" colspan="2"><textarea name="alte_posibilitati" rows="7" cols="70">{ALTE_POSIBILITATI}</textarea></td>
		</tr>
		<tr>
			<td class="table_subhead" valign="top" colspan="2"><b>Servicii Incluse</b></td>
		</tr>
		<tr>
			<td class="row2" colspan="2" align="left">
				<table border="0" cellspacing="0" cellpadding="0" align="left" class="text">
				<tr>
					<td><input type="radio" name="servicii_incluse" value="cazare" {SERVICII_CAZARE}/>&nbsp;&nbsp;Cazare</td>
				</tr>
				<tr>
					<td><input type="radio" name="servicii_incluse" value="mic_dejun" {SERVICII_MIC_DEJUN}/>&nbsp;&nbsp;Cazare si Mic Dejun</td>
				</tr>
				<tr>
					<td><input type="radio" name="servicii_incluse" value="demipensiune" {SERVICII_DEMIPENSIUNE}/>&nbsp;&nbsp;Cazare si demipensiune</td>
				</tr>
				<tr>
					<td><input type="radio" name="servicii_incluse" value="pensiune" {SERVICII_PENSIUNE}/>&nbsp;&nbsp;Cazare si pensiune completa</td>
				</tr>
				<tr>
					<td><input type="radio" name="servicii_incluse" value="all_inclusive" {SERVICII_ALL_INCLUSIVE}/>&nbsp;&nbsp;Cazare si all inclusive</td>
				</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td class="table_subhead" colspan="2">Oferta 1 Mai</td>
		</tr>
		<tr>
			<td align="center" class="row1" colspan="2"><textarea name="oferta_1mai" rows="7" cols="70">{OFERTA_1MAI}</textarea></td>
		</tr>
		<tr>
			<td class="table_subhead" colspan="2">Oferta Sarbatorile de Paste</td>
		</tr>
		<tr>
			<td align="center" class="row2" colspan="2"><textarea name="oferta_paste" rows="7" cols="70">{OFERTA_PASTE}</textarea></td>
		</tr>
		<tr>
			<td class="table_subhead" colspan="2">Oferta Craciun</td>
		</tr>
		<tr>
			<td align="center" class="row1" colspan="2"><textarea name="oferta_craciun" rows="7" cols="70">{OFERTA_CRACIUN}</textarea></td>
		</tr>
		<tr>
			<td class="table_subhead" colspan="2">Oferta Revelion</td>
		</tr>
		<tr>
			<td align="center" class="row2" colspan="2"><textarea name="oferta_revelion" rows="7" cols="70">{OFERTA_REVELION}</textarea></td>
		</tr>
		<tr>
			<td align="center" class="row1" colspan="2"><input type="button" class="button" value="Modifica" onClick="ValidateStep2();"/></td>
		</tr>
	</table>
</fieldset>
</form>