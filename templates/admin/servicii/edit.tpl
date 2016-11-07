<form method="post" action="?page=servicii.save_edit.{ID}">
	<table width="95%" class="grey" cellpadding="4" cellspacing="1">
		<tr>
			<td class="tbhead" colspan="2">Edit serviciu</td>
		</tr>
		<tr> 
			<td class="{BGCOLOR1}"><b>Nume</b><p class="star">*</p></td>
			<td class="{BGCOLOR2}"><input name="name" value="{NAME}" type="text" ></td>
		</tr> 
		<tr> 
			<td class="{BGCOLOR1}"><b>Pret</b>:</td>
			<td class="{BGCOLOR2}"><input name="price" value="{PRET}" type="text" > RON</td>
		</tr> 
		<tr> 
			<td class="{BGCOLOR1}"><b>Descriere</b></td>
			<td class="{BGCOLOR2}"><textarea name='description'>{DESCRIPTION}</textarea></td>
		</tr>
		<tr> 
			<td class="{BGCOLOR1}"><b>Valoare</b>:</td>
			<td class="{BGCOLOR2}"><input name="value" value="{VALUE}" type="text" > - nr afisari</td>
		</tr> 
		<tr class="{BGCOLOR1}">
			<td align="center" colspan="2">
				<input type="submit" value="Update" class="button" />
			</td>
		</tr>
	</table>
</form>