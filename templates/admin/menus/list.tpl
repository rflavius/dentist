<table align="center" border="0" cellspacing="0" cellpadding="0" width="90%">
	<tr>
		<td>
			{INFORMATION}
			<!-- BEGIN if_menus -->
				<table width="100%" class="grey" cellpadding="4" cellspacing="1">
					<tr>
						<td class="tbhead" colspan="10">Manage Menus</td>
					</tr>
					<tr>
						<td class="bgmain" width="5%">Id</td>
						<td class="bgmain" width="40%">Menu provided name</td>
						<td class="bgmain" width="40%">Menu Tag</td>
						<td class="bgmain" width="7%">Edit</td>
						<td class="bgmain" width="8%">Delete</td>
					</tr>
					<!-- BEGIN items -->
					<tr class="{BGCOLOR}">
						<td width="5%" align="center">{ID}</td>
						<td width="40%"><b>{MENU_NAME}</b></td>
						<td width="40%">&#123;DISPLAY_MENU_{ID}&#125;</td>
						<td width="7%" align="center">
							<a href="?page=menus.{EDIT_PATH}">
							<img src="../images/admin/edit.png" title='Manage "{MENU_NAME}" menu'></a>
						</td>
						<td width="7%" align="center">
							<a href="?page=delete.menus.{ID}">
								<img src="../images/admin/delete.png" title='Delete "{MENU_NAME}" menu'>
						</a>
						</td>
					</tr>
					<!-- END items -->
				</table>
			<!-- END if_menus -->
			<!-- BEGIN if_no_menus -->
				<table width="90%" class="grey" cellpadding="4" cellspacing="1">
					<tr>
						<td class="tbhead" colspan="10">There are no menus at this time. Please create your own menus.</td>
					</tr>
				</table>
			<!-- END if_no_menus -->
		</td>
	</tr>
</table>