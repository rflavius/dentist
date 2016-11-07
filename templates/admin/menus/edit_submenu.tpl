<script LANGUAGE="JavaScript">
<!--
function confirmSubmit()
{
var agree=confirm("Are you sure you want to delete selected item ?");
if (agree)
	return true ;
else
	return false ;
}
// -->
</script>
<table align="center" border="0" cellspacing="0" cellpadding="0" width="90%">
	<tr>
		<td>
			{INFORMATION}
			<!-- BEGIN if_items -->
			<table width="100%" class="grey" cellpadding="4" cellspacing="1">
				<tr>
					<td class="tbhead" colspan="5">Items displayed in your submenu when the selected page is {PARENT_NAME}.</td>
				</tr>
				<tr>
					<td class="bgmain" width="5%">Id</td>
					<td class="bgmain" width="35%">Name</td>
					<td class="bgmain" width="35%">Link</td>
					<td class="bgmain" width="15%">Position</td>
					<td class="bgmain" width="10%">Delete</td>
				</tr>
				<!-- BEGIN items -->
				<tr class="{BGCOLOR}">
					<td align="center">{ID}</td>
					<td><b>{NAME}</b></td>
					<td>{LINK}</td>
					<td align="center">
						<a href="?page=menus.submenu.rearenge.up.{PARENT_ID}.{ID}">
						<img src="../images/admin/up.png" title="Move up">
						</a>&nbsp;
						<a href="?page=menus.submenu.rearenge.down.{PARENT_ID}.{ID}">
							<img src="../images/admin/down.png" title="Move down">
						</a>
					</td>
					<td align="center">
						<a onclick="return confirmSubmit()" href="?page=menus.submenu.delete.{ID}">
							<img src="../images/admin/delete.png" title='Exclude "{NAME}" item'>
						</a>
					</td>
				</tr>
				<!-- END items -->
			</table>
			<!-- END if_items -->
			<!-- BEGIN no_items -->
			<table width="100%" class="grey" cellpadding="4" cellspacing="1">
				<tr>
					<td class="tbhead">There are no items displayed in your submenu when the selected page is {PARENT_NAME}. Add some from the box bellow.</td>
				</tr>
			</table>
			<!-- END no_items -->
			<br />
			<table width="100%" class="grey" cellpadding="4" cellspacing="1">
				<tr>
					<td class="tbhead" colspan="4">Available items.</td>
				</tr>
				<!-- BEGIN if_modules -->
					<tr>
						<td class="bgmain" colspan="4">Available modules.</td>
					</tr>
					<!-- BEGIN modules -->
					<tr class="{BGCOLOR}">
						<td align="center">{MODULE_ID}</td>
						<td><b>{MODULE_NAME}</b></td>
						<td>{MODULE_LINK}{FILE_EXTENSION}</td>
						<td align="center">
							<a href="?page=menus.submenu.add_module.{PARENT_ID}.{MODULE_ID}">Add as child for item.</a>
						</td>
					</tr>
					<!-- END modules -->
				<!-- END if_modules -->
				<!-- BEGIN if_pages -->
					<tr>
						<td class="bgmain" colspan="4">Available pages.</td>
					</tr>
					<!-- BEGIN pages -->
					<tr class="{BGCOLOR}">
						<td align="center">{PAGE_ID}</td>
						<td><b>{PAGE_NAME}</b></td>
						<td>{PAGE_LINK}{FILE_EXTENSION}</td>
						<td align="center">
							<a href="?page=menus.submenu.add_page.{PARENT_ID}.{PAGE_ID}">Add as child for item.</a>
						</td>
					</tr>
					<!-- END pages -->
				<!-- END if_pages -->
			</table>
			<form method="post" action="?page=menus.add_static.2.{PARENT_ID}">
				<br />
				<table width="100%" class="grey" cellpadding="4" cellspacing="1">
					<tr>
						<td class="tbhead" colspan="10">Add static link. </td>
					</tr>
						<tr>
							<td width="50%" class="row2"><b>Item title</b><p class="star">*</p></td>
							<td width="50%" class="row1">
								<input type="text" name="title" value="{TITLE}" size="63"/>
							</td>
						</tr>
						<tr>
							<td width="50%" class="row2"><b>Item url</b><p class="star">*</p></td>
							<td width="50%" class="row1">
								<input type="text" name="url" value="{URL}" size="63"/>
							</td>
						</tr>
						<tr>
							<td width="50%" class="row2"><b>Item target</b><p class="star">*</p></td>
							<td width="50%" class="row1">
								<select name="target">
									<option value="_blank" {BLANK_SEL}>New Window</option>
									<option value="_self" {SELF_SEL}>Same Window</option>
								</select>
							</td>
						</tr>
						<tr>
							<td class="row1" colspan="2" align="center">
								<input type="submit" value="add link" class="button">
							</td>
						</tr>
				</table>
				<br />
			</form>
		</td>
	</tr>
</table>