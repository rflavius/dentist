<table align="center" border="0" cellspacing="0" cellpadding="0" width="90%">
	<tr>
		<td>
			{INFORMATION}
			<table width="100%" class="grey" cellpadding="4" cellspacing="1">
				<tr>
					<td class="tbhead" colspan="11">List news</td>
				</tr>
				<!-- BEGIN if_news -->
				<tr>
					<td class="bgmain" width="10%">Title</td>
					<td class="bgmain" width="8%" nowrap>Updated date</td>
								<td class="bgmain" width="8%" nowrap>Event date</td>
					<td class="bgmain" width="8%" nowrap>Order</td>
					<td class="bgmain" width="8%" nowrap>Published</td>
					<td class="bgmain" width="5%">Edit</td>
					<td class="bgmain" width="5%">Delete</td>
				</tr>
				<!-- BEGIN list_news -->
				<tr class="{BGCOLOR}">
					<td><a href="{NEWS_LINK_FRONTEND}" target="_blank"><b>{TITLE}</b></a></td>
					<td valign="top">{UPDATED_DATE}</td>
					<td valign="top">{EVENT_DATE}</td>
					<td align="center" valign="top">
						<a href="?page=news.rearenge.up.{ID}">
							<img src="../images/admin/up.png" title="Move up">
						</a>&nbsp;
						<a href="?page=news.rearenge.down.{ID}">
							<img src="../images/admin/down.png" title="Move down">
						</a>
					</td>
					<td align="center" valign="top">
						<a href="?page=news.set.{IMAGE_TITLE}.{ID}">
					<img src="../images/admin/{IMAGE}" title='Turn "{TITLE}" news to {IMAGE_TITLE}'>
						</a>
					</td>
					<td align="center" valign="top"><a href="?page=news.edit.{ID}"><img src="../images/admin/edit.png" title='Edit "{TITLE}" news'></a></td>
					<td align="center" valign="top">
						<a href="?page=delete.news.{ID}">
							<img src="../images/admin/delete.png" title='Delete "{TITLE}" news'>
						</a>
					</td>
					</td>
				</tr>
				<!-- END list_news -->
				<!-- END if_news -->
				<!-- BEGIN no_news -->
				<tr>
					<td class="bgmain">No news in database</td>
				</tr>
				<!-- END no_news -->
			</table>
		</td>
	</tr>
</table>