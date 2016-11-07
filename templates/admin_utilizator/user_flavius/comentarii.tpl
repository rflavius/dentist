<h1>Comentarii</h1>
<br>
{INFORMATION}
<br>
<fieldset>
	<legend>COMENTARII</legend>
	<table cellpadding="0" cellspacing="1" class="big_table" width="100%">
		<tr>
			<td class="table_subhead">#</td>
			<td class="table_subhead"><b>IP</b></td>
			<td class="table_subhead"><b>Denumire unitate</b></td>
			<td class="table_subhead" width="250"><b>Comentariu</b></td>
			<td class="table_subhead"><b>Activ</b></td>
			<td class="table_subhead"><b>Data</b></td>
			<td class="table_subhead">&nbsp;</td>
		</tr>
		<!-- BEGIN if_no_records -->
		<tr>
			<td class="row1" colspan="7">{NO_RECORDS}</td>
		</tr>
		<!-- END if_no_records -->
		<!-- BEGIN list_row -->
		<tr>
			<td class="{BGROW}">{NR}</td>
			<td class="{BGROW}"><b>{IP}</b></td>
			<td class="{BGROW}"><b>{HOTEL_NAME}</b></td>
			<td class="{BGROW}">{COMENTARIU}</td>
			<td class="{BGROW}"><img src="../images/{STATUS}.png">&nbsp;&nbsp;<a href="?page=user.comentariustatus.{NEXT_STATUS}.{ID}">modifica</a></td>
			<td class="{BGROW}">{DATE}</td>
			<td nowrap class="{BGROW}"></td>
		</tr>
		<!-- END list_row -->
	</table>
</fieldset>


<form method="post" action="?page=user.sendcomentariu.{HOTEL_ID}">
<fieldset>
	<legend>ADAUGA COMENTARIU</legend>
	<table cellpadding="0" cellspacing="1" class="big_table" width="100%">
		<tr>
			<td class="row2"><b>Scrie mesajul/comentariul tau aici</b></td>
			<td  class="row2"><textarea name="comment" rows="5" cols="70"></textarea></td>
		</tr>
		<tr>
			<td class="row1" colspan="2"><input type="submit" class="button" value="Trimite"></td>
		</tr>
	</table>
</fieldset>
</form>