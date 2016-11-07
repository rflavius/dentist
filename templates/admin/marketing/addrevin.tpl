<link rel="stylesheet" type="text/css" media="all" href="{SITE_BASE}/templates/js/calendar-win2k-cold-1.css" title="blue">
<script type="text/javascript" src="{SITE_BASE}/templates/js/calendar.js"></script>
<script type="text/javascript" src="{SITE_BASE}/templates/js/calendar-en.js"></script>
<script type="text/javascript" src="{SITE_BASE}/templates/js/calendar-setup.js"></script>


<br>
<form method="post" action="?page=marketing.saverevin.{ID}">
	<table width="50%" class="grey" cellpadding="4" cellspacing="1" border="0">
		<tr>
			<td class="tbhead" colspan="2">Adauga revin cu telefon pentru {CABINET}</td>
		</tr>
		<tr>
			<td width="160" class="row1"><b>Contactat initial la data:</b></td>
			<td class="row1">{DATE}</td>
		</tr>
		<tr>
			<td class="row2"><b>Comentarii ulterioare</b></td>
			<td class="row2">{COMMENTS}</td>
		</tr>
		<tr>
			<td class="row1"><b>Revin cu telefon in data:</b></td>
			<td class="row1">
					<input type="text" name="revin" id="f_date_vv" value="{REVIN}" size="10" maxlength="10"/>&nbsp;
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
		</tr>
		<tr class="row2">
			<td colspan="2" align="center">
				<input type="submit" class="button" value="Adauga" />
			</td>
		</tr>
	</table>
</form>
