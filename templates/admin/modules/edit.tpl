<form method="post" action="?page=modules.save_changes.{ID}" enctype="multipart/form-data">
<br>
	<table width="90%" class="grey" cellpadding="4" cellspacing="1">
		<tr>
			<td class="head-menu" colspan="10">Edit {NAME} module</td>
		</tr>
		<!-- BEGIN if_errors -->
		<tr>
			<td colspan="2" class="error_msg">
			<!-- BEGIN errors --><li>{ERROR}</li><!-- END errors -->
			</td>
		</tr>
		<!-- END if_errors -->
		<tr bgcolor="{BGCOLOR1}">
			<td width="50%">Id</td>
			<td width="50%">{ID}</td>
		</tr>
		<tr bgcolor="{BGCOLOR2}">
			<td>Name</td>
			<td><input type="text" name="name" value="{NAME}" /></td>
		</tr>
		<tr bgcolor="{BGCOLOR1}">
			<td>Link</td>
			<td>{LINK}</td>
		</tr>
		<tr bgcolor="{BGCOLOR2}">
			<td>Status</td>
			<td>
				<select name="status">
					<option value="0" {STATUS_INACTIVE}>Inactive</option>
					<option value="1" {STATUS_ACTIVE}>Active</option>
				</select>
			</td>
		</tr>
		<tr bgcolor="{BGCOLOR1}">
			<td>Displayed on top menu</td>
			<td>
				<select name="top_menu">
					<option value="Y" {TOP_MENU_Y}>Yes</option>
					<option value="N" {TOP_MENU_N}>No</option>
				</select>
			</td>
		</tr>
		<tr bgcolor="{BGCOLOR2}">
			<td>Displayed on left menu</td>
			<td>
				<select name="left_menu">
					<option value="Y" {LEFT_MENU_Y}>Yes</option>
					<option value="N" {LEFT_MENU_N}>No</option>
				</select>
			</td>
		</tr>
		<tr bgcolor="{BGCOLOR1}">
			<td>Displayed on footer menu</td>
			<td>
				<select name="footer_menu">
					<option value="Y" {FOOTER_MENU_Y}>Yes</option>
					<option value="N" {FOOTER_MENU_N}>No</option>
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
			<td width="50%">Current graphic symbol</td>
			<td width="50%">
				<img src="../images/left_menu_symbols/{SYMBOL}">
			</td>
		</tr>
		<tr bgcolor="{BGCOLOR2}">
			<td colspan="2" align="center">
				<input type="submit" class="button" value="Save Changes" />
			</td>
		</tr>
	</table>
</form>
<!-- BEGIN if_content -->
<script type="text/javascript">
		_editor_url = "../third_party/htmlarea/";
		_editor_lang = "en";
</script>
<script type="text/javascript" src="../third_party/htmlarea/htmlarea.js"></script>
<br>
<form method="post" enctype="multipart/form-data" action="?page=modules.template_created.{LINK}">
<table width="80%" class="grey" cellpadding="4" cellspacing="1">
	<tr>
		<td class="head-menu">Edit static page : {LINK}</td>
	</tr>
	<tr bgcolor="{BGCOLOR1}">
		<td width="100%">
			<textarea name="content" id="cabinet_content" rows="11" cols="121">{HTML_CONTENT_TEXTAREA}</textarea>
			<script type="text/javascript">HTMLArea.replace("cabinet_content");</script>
		</td>
	</tr>
	<tr bgcolor="{BGCOLOR2}">
		<td align="center">
			<input type="submit" value="Save template" class="button">
		</td>
	</tr>
</table>
<br>
</form>
<!-- END if_content -->