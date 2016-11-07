<table align="center" border="0" cellspacing="0" cellpadding="0" width="90%">
	<tr>
		<td>
			{INFORMATION}
			<table width="100%" class="grey" cellpadding="4" cellspacing="1">
				<tr>
					<td class="tbhead" colspan="11">List all modules</td>
				</tr>
				<tr>
					<td class="bgmain" width="10%">Title</td>
					<td class="bgmain" width="10%">Link</td>
					<td class="bgmain" width="10%">Type</td>
					<td class="bgmain" width="8%">Published</td>
					<td class="bgmain" width="5%">Edit</td>
					<td class="bgmain" width="5%">Delete</td>
				</tr>
				<!-- BEGIN list_modules -->
				<tr class="{BGCOLOR}">
					<td><b>{TITLE}</b></td>
					<td>{LINK}{FILE_EXTENSION}</td>
					<td>{TYPE}</td>
					<td align="center">
						<a href="?page=modules.set.{IMAGE_TITLE}.{ID}">
					<img src="../images/admin/{IMAGE}" title='Turn "{TITLE}" module to {IMAGE_TITLE}'>
						</a>
					</td>
					<td align="center"><a href="?page={EDIT_LINK}"><img src="../images/admin/edit.png" title='Edit "{TITLE}" module'></a></td>
					<td align="center">
						<a href="?page=delete.modules.{ID}">
							<img src="../images/admin/delete.png" title='Delete "{TITLE}" module'>
						</a>
					</td>
					</td>
				</tr>
				<!-- END list_modules -->
			</table>
		</td>
	</tr>
</table>