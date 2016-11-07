<table align="center" border="0" cellspacing="0" cellpadding="0" width="80%">
	<tr>
		<td>
			{INFORMATION}
			<form method="post" action="?page=links.save_changes.{ID}">
				<table width="100%" class="grey" cellpadding="4" cellspacing="1">
					<tr>
						<td class="tbhead" colspan="10">Edit link</td>
					</tr>
					<tr>
						<td width="50%" class="{BGCOLOR2}"><b>Link title</b><p class="star">*</p></td>
						<td width="50%" class="{BGCOLOR1}">
							<input type="text" name="title" value="{TITLE}" size="63"/>
						</td>
					</tr>
					<tr>
						<td class="{BGCOLOR2}"><b>Url</b><p class="star">*</p></td>
						<td class="{BGCOLOR1}">
							<input type="text" name="link" value="{LINK}"  size="63"/>
						</td>
					</tr>
					<tr>
						<td class="{BGCOLOR2}" valign="top"><b>Description</b></td>
						<td class="{BGCOLOR1}">
							<textarea name="description" rows="5" cols="60">{DESCRIPTION}</textarea>
						</td>
					</tr>
					<tr>
						<td class="{BGCOLOR2}"><b>Published</b></td>
						<td class="{BGCOLOR1}">
							<select name="status">
								<option value="1" {SEL_AC}>Yes</option>
								<option value="0" {SEL_IN}>No</option>
							</select>
						</td>
					</tr>
					<tr class="{BGCOLOR1}">
						<td colspan="2" align="center">
							<input type="submit" class="button" value="Save" />
						</td>
					</tr>
				</table>
			</form>
		</td>
	</tr>
</table>