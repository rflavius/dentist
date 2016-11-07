<table align="center" border="0" cellspacing="0" cellpadding="0" width="50%">
	<tr>
		<td>
			{INFORMATION}
			<form method="post" action="?page=recomandate.insert.{CABINET_ID}.{USER_ID}">
				<table width="100%" class="grey" cellpadding="4" cellspacing="1">
					<tr>
						<td class="tbhead" colspan="10">Add  " {CAB_TITLE} " to Recomanded </td>
					</tr>
					<tr>
						<td width="50%" class="{BGCOLOR2}"><b>Comment</b><br />* add some comment about this cabinet</td>
						<td width="50%" class="{BGCOLOR1}">
							<textarea name="comment" rows="4" cols="55"></textarea>
						</td>
					</tr>
					<tr>
						<td width="50%" class="{BGCOLOR2}"><b>Perioada</b> <br />*it's about months (one year or half	year)</td>
						<td width="50%" class="{BGCOLOR1}">
							<select name="perioada">
								<option value="6" selected>6</option>
								<option value="12">12</option>
							</select>
						</td>
					</tr>
					
					
					
					<tr class="{BGCOLOR1}">
						<td colspan="2" align="center">
							<input type="submit" class="button" value="Add" />
						</td>
					</tr>
				</table>
			</form>
		</td>
	</tr>
</table>