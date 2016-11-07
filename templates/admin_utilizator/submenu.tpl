<table align="center" border="0" cellspacing="0" cellpadding="0" width="90%">
	<tr>
		<td>
			{INFORMATION}
			<form method="post" action="?page=menus.submenu.edit">
				<table width="100%" class="grey" cellpadding="4" cellspacing="1">
					<tr>
						<td class="tbhead" colspan="2">Edit Top Submenu</td>
					</tr>
					<tr class="{BGCOLOR1}">
						<td width="50%" align="center">Select the item for which to edit submenu</td>
						<td width="50%">
							<select name="item">
								<option value="0">Modules</option>
								<!-- BEGIN modules -->
									<option value="module_{MODULE_ID}">&nbsp;... {MODULE_NAME}</option>
								<!-- END modules -->
								<option value="0">Pages</option>
								<!-- BEGIN pages -->
									<option value="page_{PAGE_ID}">&nbsp;... {PAGE_NAME}</option>
								<!-- END pages -->
							</select>
						</td>
					</tr>
					<tr class="{BGCOLOR2}">
						<td align="center" colspan="2">
							<input type="submit" value="Select" class="button"/>
						</td>
					</tr>
				</table>
			</form>
		</td>
	</tr>
</table>