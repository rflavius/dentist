<table align="center" border="0" cellspacing="0" cellpadding="0" width="50%">
	<tr>
		<td>
			{INFORMATION}
			<form method="post" action="?page=cabinete.categories.save.{ID}.{PARENT_ID}">
				<table width="100%" class="grey" cellpadding="4" cellspacing="1">
					<tr>
						<td class="tbhead" colspan="10">Edit {NAME} category</td>
					</tr>
					<tr>
						<td width="50%" class="{BGCOLOR2}"><b>Id</b></td>
						<td width="50%" class="{BGCOLOR1}">{ID}</td>
					</tr>
					<tr>
						<td class="{BGCOLOR2}"><b>Name</b><p class="star">*</p></td>
						<td class="{BGCOLOR1}"><input type="text" name="cat_name" value="{CAT_NAME}" /></td>
					</tr>
					<tr>
						<td class="{BGCOLOR2}"><b>Meta keywords</b><p class="star">*</p></td>
						<td class="{BGCOLOR1}"><textarea name="meta_keywords" rows="5" cols="35">{META_KEYWORDS}</textarea>
						</td>
					</tr>
					<tr>
						<td class="{BGCOLOR2}"><b>Meta description</b><p class="star">*</p></td>
						<td class="{BGCOLOR1}"><textarea name="meta_description"  rows="5" cols="35">{META_DESCRIPTION}</textarea>
						</td>
					</tr>
					<tr class="{BGCOLOR1}">
						<td colspan="2" align="center">
							<input type="submit" class="button" value="Save Changes" />
						</td>
					</tr>
				</table>
			</form>
		</td>
	</tr>
</table>