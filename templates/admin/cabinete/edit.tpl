<script LANGUAGE="JavaScript">
<!--
// Nannette Thacker http://www.shiningstar.net
function confirmSubmit()
{
var agree=confirm("Are you sure you want to delete selected category ?");
if (agree)
	return true ;
else
	return false ;
}
// -->
</script>
<table align="center" border="0" cellspacing="0" cellpadding="0" width="95%">
	<tr>
		<td>
			{INFORMATION}
			<table border="0" cellspacing="0" cellpadding="0" width="95%">
				<tr>
					<td valign="top" width="70%">
						<form method="post" action="?page=cabinete.save.{ID}" enctype="multipart/form-data">
							<table width="99%" class="grey" cellpadding="4" cellspacing="1" border="0">
								<tr>
									<td class="tbhead" colspan="10">Edit {NAME} module</td>
								</tr>
								<tr>
									<td width="50%" class="{BGCOLOR2}"><b>Id</b></td>
									<td width="50%" class="{BGCOLOR1}">{ID}</td>
								</tr>
								<tr>
									<td class="{BGCOLOR2}"><b>Name</b><p class="star">*</p></td>
									<td class="{BGCOLOR1}"><input type="text" name="name" value="{NAME}" size="53"/></td>
								</tr>
								<tr>
									<td class="{BGCOLOR2}"><b>Link</b></td>
									<td class="{BGCOLOR1}">{LINK}</td>
								</tr>
								<tr>
									<td class="{BGCOLOR2}" valign="top"><b>Meta Keywords</b></td>
									<td class="{BGCOLOR1}">
										<textarea name="meta_keywords" rows="3" cols="50">{KEYWORDS}</textarea>
									</td>
								</tr>
								<tr>
									<td class="{BGCOLOR2}" valign="top"><b>Meta Description</b></td>
									<td class="{BGCOLOR1}">
										<textarea name="meta_description" rows="3" cols="50">{DESCRIPTION}</textarea>
									</td>
								</tr>
								<tr>
									<td class="{BGCOLOR2}" valign="top"><b>Page Content</b></td>
									<td class="{BGCOLOR1}">
										<textarea name="content" rows="4" cols="50">{CONTENT}</textarea>
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
					</td>
					<td valign="top">
						<!-- BEGIN if_categories -->
						<table width="100%" class="grey" cellpadding="4" cellspacing="1">
							<tr>
								<td class="tbhead" colspan="10">Categories for this module</td>
							</tr>
							<tr>
								<td class="bgmain" width="10%">Id</td>
								<td class="bgmain" width="45%">Name</td>
								<td class="bgmain" width="15%">Status</td>
								<td class="bgmain" width="15%">Edit</td>
								<td class="bgmain" width="15%">Delete</td>
							</tr>
							<!-- BEGIN list_categories -->
							<tr class="{BGCOLOR}">
								<td align="center">{CAT_ID}</td>
								<td><b>{CAT_NAME}</b></td>
								<td align="center">
									<a href="?page=cabinete.categories.set.{IMAGE_TITLE}.{CAT_ID}">
								<img src="../images/admin/{IMAGE}" title='Turn "{CAT_NAME}" category to {IMAGE_TITLE}'>
									</a>
								</td>
								<td align="center">
									<a href="?page=cabinete.categories.edit.{CAT_ID}.{PARENT_ID}"><img src="../images/admin/edit.png" title='Edit "{CAT_NAME}" category'></a>
								</td>
								<td align="center">
									<a onclick="return confirmSubmit()" href="?page=cabinete.categories.delete.{CAT_ID}">
										<img src="../images/admin/delete.png" title='Delete "{CAT_NAME}" category'>
									</a>
								</td>
							</tr>
							<!-- END list_categories -->
						</table>
						<br />
						<!-- END if_categories -->
						{CATEGORY_INFORMATION}
						<form method="post" action="?page=cabinete.categories.add.{ID}">
							<table width="90%" class="grey" cellpadding="4" cellspacing="1">
								<tr>
									<td class="tbhead" colspan="10">Add cabinete category for this module</td>
								</tr>
								<tr class="{BGCOLOR1}">
									<td align="center" width="50%">
										<input type="text" name="cat_name" size="37"/>
									</td>
									<td align="center" width="50%">
										<input type="submit" class="button" value="Add Category" />
									</td>
								</tr>
							</table>
						</form>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>