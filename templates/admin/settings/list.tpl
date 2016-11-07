<table align="center" border="0" cellspacing="0" cellpadding="0" width="70%">
	<tr>
		<td>
			{INFORMATION}
			<form method="post" action="?page=settings.save">
				<table width="100%" class="grey" cellpadding="4" cellspacing="1">
					<tr>
						<td class="tbhead" colspan="2">Change settings</td>
					</tr>
					<!-- BEGIN textarea -->
					<tr>
						<td class="{B1}" width="50%" valign="top"><b>{TITLE}</b></td>
						<td class="{B1}" width="50%">
							<textarea name="{VARIABLE}" rows="6" cols="51">{CURRENT_VALUE}</textarea>
						</td>
					</tr>
					<tr>
						<td colspan="2" class="{B2}">{EXPLANATION}</td>
					</tr>
					<!-- END textarea -->
					<!-- BEGIN option -->
					<tr>
						<td class="{B1}" width="50%" valign="top"><b>{TITLE}</b></td>
						<td class="{B1}" width="50%">
							<select name="{VARIABLE}">
								<!-- BEGIN options -->
								<option value="{LIST_OPTION}" {SELECTED_OPTION}>{LIST_OPTION}</option>
								<!-- END options -->
							</select>
						</td>
					</tr>
					<tr>
						<td colspan="2" class="{B2}">{EXPLANATION}</td>
					</tr>
					<!-- END option -->
					<!-- BEGIN radio -->
					<tr>
						<td class="{B1}" width="50%"><b>{TITLE}</b></td>
						<td class="{B1}" width="50%" valign="middle">
							<!-- BEGIN radios -->
								<input type="radio" name="{VARIABLE}" value="{POSIBLE_VALUE}" {CHECKED_OPTION}/> {POSIBLE_VALUE} 
							<!-- END radios -->
						</td>
					</tr>
					<tr>
						<td colspan="2" class="{B2}">{EXPLANATION}</td>
					</tr>
					<!-- END radio -->
					<tr>
						<td class="{B1}" colspan="2" align="center">
							<input type="submit" value="Save changes" class="button"/>
						</td>
					</tr>
				</table>
			</form>
		</td>
	</tr>
</table>