<table align="center" border="0" cellspacing="0" cellpadding="0" width="80%">
	<tr>
		<td>
			{INFORMATION}
			<form method="post" action="?page=news.insert">
				<table width="100%" class="grey" cellpadding="4" cellspacing="1">
					<tr>
						<td class="tbhead" colspan="10">Add news</td>
					</tr>
					<tr>
						<td width="50%" class="{BGCOLOR2}"><b>News title</b><p class="star">*</p></td>
						<td width="50%" class="{BGCOLOR1}">
							<input type="text" name="title" value="{TITLE}" size="53"/>
						</td>
					</tr>
					<tr>
						<td class="{BGCOLOR2}" valign="top"><b>Content</b><p class="star">*</p></td>
						<td class="{BGCOLOR1}">
							<textarea name="content" rows="5" cols="50">{CONTENT}</textarea>
						</td>
					</tr>
					<tr>
						<td class="{BGCOLOR2}" valign="top"><b>Bottom notes</b></td>
						<td class="{BGCOLOR1}">
							<textarea name="bottom_notes" rows="5" cols="50">{BOTTOM_NOTES}</textarea>
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
							<input type="submit" class="button" value="Add" />
						</td>
					</tr>
				</table>
			</form>
		</td>
	</tr>
</table>