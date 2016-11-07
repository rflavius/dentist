<table align="center" border="0" cellspacing="0" cellpadding="0" width="90%">
	<tr>
		<td>
			{INFORMATION}
			<form method="post" action="?page=modules.save_changes.{ID}" enctype="multipart/form-data">
				<table width="100%" class="grey" cellpadding="4" cellspacing="1">
					<tr>
						<td class="tbhead" colspan="10">Edit {NAME} module</td>
					</tr>
					<tr>
						<td width="50%" class="{BGCOLOR2}"><b>Id</b></td>
						<td width="50%" class="{BGCOLOR1}">{ID}</td>
					</tr>
					<tr>
						<td class="{BGCOLOR2}"><b>Name</b><p class="star">*</p></td>
						<td class="{BGCOLOR1}"><input type="text" name="name" value="{NAME}" size="60" /></td>
					</tr>
					<tr>
						<td class="{BGCOLOR2}"><b>Link</b></td>
						<td class="{BGCOLOR1}">{LINK}{FILE_EXTENSION}</td>
					</tr>
					<tr>
						<td class="{BGCOLOR2}" valign="top"><b>Meta Keywords</b></td>
						<td class="{BGCOLOR1}">
							<textarea name="meta_keywords" rows="3" cols="67">{KEYWORDS}</textarea>
						</td>
					</tr>
					<tr>
						<td class="{BGCOLOR2}" valign="top"><b>Meta Description</b></td>
						<td class="{BGCOLOR1}">
							<textarea name="meta_description" rows="3" cols="67">{DESCRIPTION}</textarea>
						</td>
					</tr>
					<tr>
						<td class="{BGCOLOR2}" valign="top"><b>Page Content</b></td>
						<td class="{BGCOLOR1}">
							<textarea name="content" rows="4" cols="67">{CONTENT}</textarea>
						</td>
					</tr>
					<tr>
						<td class="{BGCOLOR2}"><b>Published</b></td>
						<td class="{BGCOLOR1}">
							<select name="active">
								<option value="1" {STATUS_ACTIVE}>Yes</option>
								<option value="0" {STATUS_INACTIVE}>No</option>
							</select>
						</td>
					</tr>
					<tr class="{BGCOLOR1}">
						<td colspan="2" align="center">
							<input type="submit" class="button" value="Save Changes" />
						</td>
					</tr>
				</table>
			</form>
			<br>
			<form method="post" action="?page=links.save">
				<table width="100%" class="grey" cellpadding="4" cellspacing="1">
					<tr>
						<td class="tbhead" colspan="2">Links General Seetings</td>
					</tr>
					<tr>
						<td width="70%" class="{BGCOLOR2}">The number of links dispayed per page (Pagination will be created if there are too many links)</td>
						<td width="30%" class="{BGCOLOR1}">
							<input type="text" name="links_per_page" value="{LINKS_PER_PAGE}" />
						</td>
					</tr>
					<tr class="{BGCOLOR1}">
						<td colspan="2" align="center">
							<input type="submit" class="button" value="Save settings"/>
						</td>
					</tr>
				</table>
			</form>
		</td>
	</tr>
</table>