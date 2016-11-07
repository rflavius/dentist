<form method="post" action="?page=pachete.save_edit.{ID}">
	<table width="95%" class="grey" cellpadding="4" cellspacing="1">
		<tr>
			<td class="tbhead" colspan="2">Edit pachet</td>
		</tr>
		<tr> 
			<td class="{BGCOLOR1}"><b>Nume Pachet</b><p class="star">*</p></td>
			<td class="{BGCOLOR2}"><input name="name" value="{NAME}" type="text" ></td>
		</tr> 
		<tr> 
			<td class="{BGCOLOR1}"><b>Pret</b>:</td>
			<td class="{BGCOLOR2}"><input name="pret" value="{PRET}" type="text" > RON</td>
		</tr> 
		<tr> 
			<td class="{BGCOLOR1}"><b>Servicii</b></td>
			<td class="{BGCOLOR2}">
				<ul>
				<!-- BEGIN list_servs -->
				<li>{SERV}  <input type='checkbox' name='servicii[]' value='{SERV_ID}' {CHECK}></li>
				<!-- END list_servs -->
				</ul>
			</td>
		</tr>
		<tr class="{BGCOLOR1}">
			<td align="center" colspan="2">
				<input type="submit" value="Update" class="button" />
			</td>
		</tr>
	</table>
</form>