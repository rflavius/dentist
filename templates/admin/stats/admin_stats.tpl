
<link rel="stylesheet" type="text/css" media="all" href="{SITE_BASE}/templates/js/calendar-win2k-cold-1.css" title="blue">
<script type="text/javascript" src="{SITE_BASE}/templates/js/calendar.js"></script>
<script type="text/javascript" src="{SITE_BASE}/templates/js/calendar-en.js"></script>
<script type="text/javascript" src="{SITE_BASE}/templates/js/calendar-setup.js"></script>


<br>
<table align="center" border="0" cellspacing="0" cellpadding="0" width="98%">
	<tr>
		<td>
			{INFORMATION} 
				<form method=post action="">
				<table align="center" class="tbpagination" cellspacing="{CS}" cellpadding="{CP}" width="100%">
				<tr>
					<td class="{B1}" width="200"><b>VEZI BILANT ECONOMIC</b>   </td>
					<td class="{B1}" width="200">Alege agent vanzari&nbsp;&nbsp;&nbsp;
						<select name='admin_id'>
							<!-- BEGIN list_agents -->
							<option value='{AGENT_ID}'>{AGENT}</option>
							<!-- END list_agents -->
						</select>
					</td>
					<td class="{B2}" width="220">Din data:&nbsp;&nbsp;<input type="text" name="start" id="f_date_vv" value="{START}" size="10" maxlength="10"/>&nbsp;
					<button type="reset" id="f_trigger_vv" class="calendar2"></button>
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
					<td class="{B2}" width="220">Pana la data:&nbsp;&nbsp;<input type="text" name="end" id="f_date_vv2" value="{END}" size="10" maxlength="10"/>&nbsp;
					<button type="reset" id="f_trigger_vv2" class="calendar2"></button>
					<script type="text/javascript">
						Calendar.setup({
						inputField     :    "f_date_vv2",      // id of the input field
						ifFormat       :    "%Y-%m-%d",       // format of the input field
						showsTime      :   false,            // will display a time selector
						timeFormat     :    "24",
						button         :    "f_trigger_vv2",   // trigger for the calendar (button ID)
						singleClick    :    false            // double-click mode
													});
					</script>
					</td>
					<td class="{B1}" align="left"><input type="submit" class="button" value="Afiseaza bilant"></td>
				</tr>
			</table>
			</form>
			<br>

			<table width="100%" class="grey" cellpadding="4" cellspacing="1">
				<tr>
					<td class="tbhead" colspan="11">Bilant:: ({NR_CONTRACTS}) Contracte</td>
				</tr>
				<tr>
					<td class="bgmain" >CabinetID</td>
					<td class="bgmain" >Facturi</td>
					<td class="bgmain" >Nume Cabinet</td>
					<td class="bgmain" >Client</td>
					<td class="bgmain" >E-mail</td>
					<td class="bgmain" >Telefon</td>
					<td class="bgmain" >Promovare</td>
					<td class="bgmain" nowrap>Tip/Judet</td>
					<td class="bgmain">Data facturare</td>
					<td class="bgmain">Cost</td>
					<td class="bgmain">Achitat</td>
				</tr>
				<!-- BEGIN list_bilant -->
				<tr class="{BGCOLOR}">
					<td align="center" valign="top"><a href="index.php?page=cabinete.edit.{CAB_ID}" target="_blank">{CAB_ID}</a></td>
					<td align="left" valign="top" nowrap>
						Proforma: [<a href="index.php?page=plati.viewproforma.{PROFORMA_ID}" target="_blank">{PROFORMA_ID}</a>]<br>
						Fiscala [<a href="index.php?page=plati.viewfiscala.{FISCALA_ID}" target="_blank">{FISCALA_ID}</a>]<br>
					</td>
					<td valign="top"><a href="{LINK_TO_CABINET}" target="_blank">{CABINET}</a></td>
					<td valign="top"><a href="index.php?page=users.details.{USERID}" target="_blank">{USERID}</a></td>
					<td valign="top"><div id="norows">{EMAIL}</div></td>
					<td valign="top"><div id="norows">{TELEFON}</div></td>
					<td valign="top">{LOCPROMOVARE}</td>
					<td valign="top">{PARENT_MODULE}</td>
					<td valign="top">{DATE}</td>
					<td valign="top">{COST} RON</td>
					<td align="left" valign="top"><img src="../images/admin/{IMAGE}" title='{IMAGE_TITLE}'></td>
				</tr>
				<!-- END list_bilant -->
				<tr>
					<td colspan="11" class="row3" align="right" style="font-size:14px;">TOTAL: &nbsp;&nbsp;&nbsp;<b>{INCOME}</b> RON</td>
				</tr>
				<!-- <tr>
					<td colspan="11" class="row3" align="right" style="font-size:14px;">Castig agent marketing: &nbsp;&nbsp;&nbsp;<b>{MARKETING_COST}</b> RON</td>
				</tr> -->
			</table>
		</td>
	</tr>
</table>