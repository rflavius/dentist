<table align="center" border="0" cellspacing="0" cellpadding="0" width="90%">
	<tr>
		<td>
			{INFORMATION}
			<table width="100%" class="grey" cellpadding="4" cellspacing="1">
				<tr>
					<td class="tbhead" colspan="11">List all pages
					</td>
				</tr>
				<!-- BEGIN if_pages -->
					<tr>
						<td class="bgmain" width="24%">
							Title
							<!-- BEGIN title_order -->
								<a href="?page=pages.list&order=title"><img src="../images/admin/up.png"></a>
							<!-- END title_order -->
						</td>
						<td class="bgmain" width="23%">
							Link
							<!-- BEGIN link_order -->
								<a href="?page=pages.list&order=link"><img src="../images/admin/up.png"></a>
							<!-- END link_order -->
						</td>
						<td class="bgmain" width="10%">Published</td>
						<td class="bgmain" width="10%">Edit</td>
						<td class="bgmain" width="10%">Delete</td>
					</tr>
					<!-- BEGIN list_pages -->
					<tr class="{BGCOLOR}">
						<td><b>{TITLE}</b></td>
						<td>{LINK}{FILE_EXTENSION}</td>
						<td align="center">
							<a href="?page=pages.set.{IMAGE_TITLE}.{ID}">
						<img src="../images/admin/{IMAGE}" title='Turn "{TITLE}" page to {IMAGE_TITLE}'>
							</a>
						</td>
						<td align="center"><a href="?page=pages.edit.{ID}"><img src="../images/admin/edit.png" title='Edit "{TITLE}" page'></a></td>
						<td align="center">
							<a href="?page=delete.pages.{ID}">
								<img src="../images/admin/delete.png" title='Delete "{TITLE}" page'>
							</a>
						</td>
						</td>
					</tr>
					<!-- END list_pages -->
				<!-- END if_pages -->
				<!-- BEGIN no_pages -->
				<tr>
					<td class="bgmain">No pages.</td>
				</tr>
				<!-- END no_pages -->
			</table>
		</td>
	</tr>
</table>