<script LANGUAGE="JavaScript">
<!--
function confirmSubmit()
{
var agree=confirm("Are you sure you want to delete selected item from menu ?");
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
					<td class="tbhead" colspan="6">Curent Items for {THE_MENU_NAME}</td>
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
						<a href="?page=menus.rearenge.up.{PARENT_ID}.{ID}">
						<img src="../images/admin/up.png" title="Move up">
						</a>&nbsp;
						<a href="?page=menus.rearenge.down.{PARENT_ID}.{ID}">
							<img src="../images/admin/down.png" title="Move down">
						</a>
					</td>
					<td align="center">
						<a onclick="return confirmSubmit()" href="?page=menus.delete_items.{ID}">
							<img src="../images/admin/delete.png" title='Exclude "{NAME}" item from this menu'>
						</a>
					</td>
				</tr>
				<!-- END items -->
			</table>
			<!-- END if_items -->
			<!-- BEGIN if_no_items -->
			<br />
			<table width="100%" class="grey" cellpadding="4" cellspacing="1">
				<tr>
					<td class="tbhead" colspan="10">There are no items for this menu. Add your items from the tables bellow.</td>
				</tr>
			</table>
			<!-- END if_no_items -->
			<br />
			<div align="center"><b>Add new items to your menu</b></div>
			<br />
			<!-- BEGIN if_modules -->
			<table width="100%" class="grey" cellpadding="4" cellspacing="1">
				<tr>
					<td class="tbhead" colspan="6">Modules</td>
				</tr>
				<tr>
					<td class="bgmain" width="5%">Id</td>
					<td class="bgmain" width="25%">Name</td>
					<td class="bgmain" width="25%">Link</td>
					<td class="bgmain" width="10%">Add</td>
				</tr>
				<!-- BEGIN modules -->
				<tr class="{BGCOLOR}">
					<td align="center">{MODULE_ID}</td>
					<td><b>{MODULE_NAME}</b></td>
					<td>{MODULE_LINK}{FILE_EXTENSION}</td>
					<td align="center" nowrap>
						<a href="?page=menus.add_module.{PARENT_ID}.{MODULE_ID}">Add this item to menu</a>
					</td>
				</tr>
				<!-- END modules -->
			</table>
			<!-- END if_modules -->
			<!-- BEGIN no_modules -->
			<table width="100%" class="grey" cellpadding="4" cellspacing="1">
				<tr>
					<td class="tbhead" colspan="10">No modules available to add to this menu.</td>
				</tr>
			</table>
			<!-- END no_modules -->
			<!-- BEGIN if_pages -->
			<br />
			<table width="100%" class="grey" cellpadding="4" cellspacing="1">
				<tr>
					<td class="tbhead" colspan="6">Pages</td>
				</tr>
				<tr>
					<td class="bgmain" width="5%">Id</td>
					<td class="bgmain" width="25%">Name</td>
					<td class="bgmain" width="25%">Link</td>
					<td class="bgmain" width="10%">Add</td>
				</tr>
				<!-- BEGIN pages -->
				<tr class="{BGCOLOR}">
					<td align="center">{PAGE_ID}</td>
					<td><b>{PAGE_NAME}</b></td>
					<td>{PAGE_LINK}{FILE_EXTENSION}</td>
					<td align="center" nowrap>
						<a href="?page=menus.add_page.{PARENT_ID}.{PAGE_ID}">Add this item to menu</a>
					</td>
				</tr>
				<!-- END pages -->
			</table>
			<!-- END if_pages -->
			<!-- BEGIN no_pages -->
			<br />
			<table width="100%" class="grey" cellpadding="4" cellspacing="1">
				<tr>
					<td class="tbhead" colspan="10">No pages available to add to this menu.</td>
				</tr>
			</table>
			<!-- END no_pages -->
			<form method="post" action="?page=menus.add_static.{PARENT_ID}">
				<br />
				<table width="100%" class="grey" cellpadding="4" cellspacing="1">
					<tr>
						<td class="tbhead" colspan="10">Add static link.</td>
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