<!-- BEGIN if_not_imported -->
<br />
<form method="post" action="?page=modules.clone" name="">
	<table width="500" class="grey" cellpadding="4" cellspacing="1">
		<tr>
			<td class="tbhead" colspan="2">Clone an existent module</td>
		</tr>
		<tr>
			<td width="50%" class="{BGCOLOR2}"><b>Select module</b></td>
			<td width="50%" class="{BGCOLOR1}">
				<select name="clone_module">
					<!-- BEGIN available_clones -->
					<option value="{CLONE_ID}">{CLONE_NAME}</option>
					<!-- END available_clones -->
				</select>
			</td>
		</tr>
		<tr class="{BGCOLOR2}">
			<td colspan="2" align="center">
				<input type="submit" class="button" value="Select" />
			</td>
		</tr>
	</table>
</form>
<!-- END if_not_imported -->
<!-- BEGIN if_imported -->
<table border="0" cellspacing="1" cellpadding="4" width="90%">
	<!-- BEGIN if_errors -->
	<tr>
		<td colspan="2" class="error">
		<!-- BEGIN errors --><li>{ERROR}</li><!-- END errors -->
		</td>
	</tr>
	<!-- END if_errors -->
</table>
<form method="post" action="?page=modules.save_clone.{CLONE_ID}" enctype="multipart/form-data">
<br>
	<table width="90%" class="grey" cellpadding="4" cellspacing="1">
		<tr>
			<td class="tbhead" colspan="10">Clone {MODULE_NAME} module</td>
		</tr>
		<tr>
			<td class="{BGCOLOR2}"><b>Name</b><p class="star">*</p></td>
			<td class="{BGCOLOR1}"><input type="text" name="name" value="{NAME}" size="50" /></td>
		</tr>
		<tr>
			<td class="{BGCOLOR2}"><b>Published</b></td>
			<td class="{BGCOLOR1}">
				<select name="active">
					<option value="1">Yes</option>
					<option value="0">No</option>
				</select>
			</td>
		</tr>
		<tr>
			<td class="{BGCOLOR2}" valign="top"><b>Meta Keywords</b></td>
			<td class="{BGCOLOR1}">
				<textarea name="keywords" rows="3" cols="67">{KEYWORDS}</textarea>
			</td>
		</tr>
		<tr>
			<td class="{BGCOLOR2}" valign="top"><b>Meta Description</b></td>
			<td class="{BGCOLOR1}">
				<textarea name="description" rows="3" cols="67">{DESCRIPTION}</textarea>
			</td>
		</tr>
		<tr>
			<td class="{BGCOLOR2}" valign="top"><b>Page Content</b></td>
			<td class="{BGCOLOR1}">
				<textarea name="content" rows="4" cols="67"></textarea>
			</td>
		</tr>
		<tr>
			<td width="50%" class="{BGCOLOR2}"><b>Graphic symbol</b> (this will appear before the link in the left and top menus). Choosing none , the default symbol will be used. The current size accepted is : {SYMBOL_MAX_WIDTH} * {SYMBOL_MAX_HEIGHT}</td>
			<td width="50%" class="{BGCOLOR1}">
				<input type="file" name="graphic_symbol">
			</td>
		</tr>
		<tr>
			<td width="50%" class="{BGCOLOR2}"><b>Page picture</b> (this will appear on top of each page). The current size accepted is : {PICTURE_MAX_WIDTH} * {PICTURE_MAX_HEIGHT}</td>
			<td width="50%" class="{BGCOLOR1}">
				<input type="file" name="page_picture">
			</td>
		</tr>
		<tr class="{BGCOLOR1}">
			<td colspan="2" align="center">
				<input type="submit" class="button" value="Save" />
			</td>
		</tr>
	</table>
</form>
<!-- END if_imported -->