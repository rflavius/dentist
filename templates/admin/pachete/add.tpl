<form method="post" action="?page=pachete.save">
	<table width="95%" class="grey" cellpadding="4" cellspacing="1">
		<tr>
			<td class="tbhead" colspan="2">Add pachet</td>
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
		<tr>
			<td class="{BGCOLOR1}"><b>Perioada</b>:</td>
			<td class="{BGCOLOR2}">
				<select name='luni'>
					<option value='1'>1 luni</option>
					<option value='2'>2 luni</option>
					<option value='3'>3 luni</option>
					<option value='4'>4 luni</option>
					<option value='5'>5 luni</option>
					<option value='6'>6 luni</option>
					<option value='7'>7 luni</option>
					<option value='8'>8 luni</option>
					<option value='9'>9 luni</option>
					<option value='10'>10 luni</option>
					<option value='11'>11 luni</option>
					<option value='12'>12 luni</option>
				</select>
			</td>
		</tr>
		<tr class="{BGCOLOR1}">
			<td align="center" colspan="2">
				<input type="submit" value="Add" class="button" />
			</td>
		</tr>
	</table>
</form>