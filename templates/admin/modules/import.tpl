<!-- BEGIN if_not_imported -->
<br />
<form method="post" action="?page=modules.import" name="">
	<table width="90%" class="grey" cellpadding="4" cellspacing="1">
		<tr>
			<td class="head-menu" colspan="2">Clone an existent module</td>
		</tr>
		<tr bgcolor="{BGCOLOR1}">
			<td width="50%">Select module</td>
			<td width="50%">
				<select name="clone_module">
					<!-- BEGIN available_clones -->
					<option value="{CLONE_ID}">{CLONE_NAME}</option>
					<!-- END available_clones -->
				</select>
			</td>
		</tr>
		<tr bgcolor="{BGCOLOR2}">
			<td colspan="2" align="center">
				<input type="submit" class="button" value="Select" />
			</td>
		</tr>
	</table>
</form>
<!-- END if_not_imported -->
<!-- BEGIN if_imported -->
<form method="post" action="?page=modules.save_imported.{CLONE_ID}" enctype="multipart/form-data">
<br>
	<table width="90%" class="grey" cellpadding="4" cellspacing="1">
		<tr>
			<td class="head-menu" colspan="10">Clone {MODULE_NAME} module</td>
		</tr>
		<!-- BEGIN if_errors -->
		<tr>
			<td colspan="2" class="error_msg">
			<!-- BEGIN errors --><li>{ERROR}</li><!-- END errors -->
			</td>
		</tr>
		<!-- END if_errors -->
		<tr bgcolor="{BGCOLOR1}">
			<td>Name</td>
			<td><input type="text" name="name" value="{NAME}" /></td>
		</tr>
		<tr bgcolor="{BGCOLOR2}">
			<td>Status</td>
			<td>
				<select name="active">
					<option value="0">Inactive</option>
					<option value="1">Active</option>
				</select>
			</td>
		</tr>
		<tr bgcolor="{BGCOLOR1}">
			<td>Displayed on top menu</td>
			<td>
				<select name="top_menu">
					<option value="Y">Yes</option>
					<option value="N">No</option>
				</select>
			</td>
		</tr>
		<tr bgcolor="{BGCOLOR2}">
			<td>Displayed on left menu</td>
			<td>
				<select name="left_menu">
					<option value="Y">Yes</option>
					<option value="N">No</option>
				</select>
			</td>
		</tr>
		<tr bgcolor="{BGCOLOR1}">
			<td>Displayed on footer menu</td>
			<td>
				<select name="footer_menu">
					<option value="Y">Yes</option>
					<option value="N">No</option>
				</select>
			</td>
		</tr>
		<tr bgcolor="{BGCOLOR2}">
			<td width="50%">Graphic symbol (this will appear before the link in the left menu). Choosing none , the default symbol will be used. The current size accepted is : {SYMBOL_MAX_WIDTH} * {SYMBOL_MAX_HEIGHT}</td>
			<td width="50%">
				<input type="file" name="graphic_symbol">
			</td>
		</tr>
		<tr bgcolor="{BGCOLOR1}">
			<td colspan="2" align="center">
				<input type="submit" class="button" value="Save" />
			</td>
		</tr>
	</table>
</form>
<!-- END if_imported -->