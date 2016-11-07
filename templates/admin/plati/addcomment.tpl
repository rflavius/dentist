<br>
<table border="0"  width="30%" class="tbhead">
<tr>
	<td class="{B1}" >Adauga un comentariu pentru factura fiscala: {ID}</td>
</tr>
<tr>
	<td class="{B2}" >
	<form method="post" action="?page=plati.insertcomment.{ID}">
		<textarea name="comment_bill" rows="7" cols="63"></textarea>
		<input type="submit" value="Insert comment" onclick="" class="button"><input type="button" name="sbmtbtn" class="button" value="Back" onclick="history.back();"/>
	</form>
	</td>
</tr>
</table>