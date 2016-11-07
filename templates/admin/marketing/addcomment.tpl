<br>
<form method="post" action="?page=marketing.savecomment.{ID}">
	<table width="50%" class="grey" cellpadding="4" cellspacing="1" border="0">
		<tr>
			<td class="tbhead" colspan="10">Adauga comentariu pentru {CABINET}</td>
		</tr>
		<tr>
			<td width="120" class="row1"><b>Contactat la data:</b></td>
			<td class="row1">{DATE}</td>
		</tr>
		<tr>
			<td class="row2"><b>Comentarii ulterioare</b></td>
			<td class="row2">{COMMENTS}</td>
		</tr>
		<tr>
			<td class="row1"><b>Comentariu nou</b></td>
			<td class="row1"><textarea name="comment" rows="10" cols="80"></textarea></td>
		</tr>
		<tr class="row2">
			<td colspan="2" align="center">
				<input type="submit" class="button" value="Adauga" />
			</td>
		</tr>
	</table>
</form>
