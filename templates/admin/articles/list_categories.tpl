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
<table border="0" cellspacing="1" cellpadding="4" width="90%">
	<!-- BEGIN if_add_errors -->
	<tr>
		<td colspan="2" style="color:#990000;font-weight:bold;" >
			<li>{ADD_ERROR}</li>
		</td>
	</tr>
	<!-- END if_add_errors -->
</table>
<table border="0" cellspacing="1" cellpadding="4" width="99%">
<tr>
	<td valign="top" width="60%">
			<!-- BEGIN if_categories -->
			<table width="100%" class="grey" cellpadding="4" cellspacing="1">
				<tr>
					<td class="tbhead" colspan="10">All Categories for dentistonline.ro</td>
				</tr>
				<tr>
					<td class="bgmain" width="5%">Id</td>
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
						<a href="?page=articles.categories.set.{IMAGE_TITLE}.{CAT_ID}">
					<img src="../images/admin/{IMAGE}" title='Turn "{CAT_NAME}" category to {IMAGE_TITLE}'>
						</a>
					</td>
					<td align="center">
						<a href="?page=articles.categories.edit.{CAT_ID}"><img src="../images/admin/edit.png" title='Edit "{CAT_NAME}" category'></a>
					</td>
					<td align="center">
						<a onclick="return confirmSubmit()" href="?page=articles.categories.delete.{CAT_ID}">
							<img src="../images/admin/delete.png" title='Delete "{CAT_NAME}" category'>
						</a>
					</td>
				</tr>
				<!-- END list_categories -->
			</table>
			<br />
			<!-- END if_categories -->
			<br />
			</td>
			<td valign="top">
			<form method="post" action="?page=articles.categories.add" enctype="multipart/form-data">
				<table width="100%" class="grey" cellpadding="4" cellspacing="1">
					<tr>
						<td class="tbhead" colspan="10">Add articles category </td>
					</tr>
					<tr class="{BGCOLOR1}">
						<td valign="top"><b>Category Name:</b></td>
						<td align="center" width="50%">
							<input type="text" name="cat_name" size="37"/>
						</td>
									</tr>
					<tr class="{BGCOLOR1}">
						<td valign="top"><b>Meta Keywords</b></td>
						<td>
							<textarea name="meta_keywords" rows="4" cols="34">{META_KEYWORDS}</textarea>
						</td>
					</tr>
					<tr class="{BGCOLOR1}">
						<td nowrap valign="top"><strong>Meta Description</strong></td>
						<td>
							<textarea name="meta_description" rows="4" cols="34">{META_DESCRIPTION}</textarea>
						</td>
					</tr>
					<tr>
						<td class="{BGCOLOR1}">Adauga imagine <br />Latimea maxima :{MAX_PICTURE_WIDTH} px</td>
						<td class="{BGCOLOR2}"><input type="file" name="imagine"></td>
					</tr>
					<tr>
					<td align="center" width="50%" class="{BGCOLOR1}" colspan="2">
							<input type="submit" class="button" value="Add Category" />
						</td>
					</tr>
				</table>
			</form>
	</td>
</tr>
</table>