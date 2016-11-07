<table align="center" border="0" cellspacing="0" cellpadding="0" width="80%">
	<tr>
		<td>
			{INFORMATION}
			<table width="100%" class="grey" cellpadding="4" cellspacing="1">
				<tr>
					<td class="tbhead" colspan="9">Edit contact form</td>
				</tr>
				<tr>
					<td class="bgmain" width="22%" nowrap>Field Title</td>
					<td class="bgmain" width="12%" nowrap>Field Type</td>
					<td class="bgmain" width="13%" nowrap>Content Type</td>
					<td class="bgmain" width="21%" nowrap>Option Values</td>
					<td class="bgmain" width="9%">Order</td>
					<td class="bgmain" width="7%">Used</td>
					<td class="bgmain" width="10%">Required</td>
					<td class="bgmain" width="6%">Edit</td>
					<td class="bgmain" width="6%">Delete</td>
				</tr>
				<!-- BEGIN list -->
					<tr class="{BGCOLOR}">
						<td valign="top"><b>{NAME}</b></td>
						<td valign="top">{FIELD_TYPE}</td>
						<td valign="top">{CONTENT_TYPE}</td>
						<td valign="top"><div id="{NOROWS}">{VALUES}</div></td>
						<td valign="top" align="center">
							<a href="?page=contact.rearenge.up.{ID}">
								<img src="../images/admin/up.png" title="Move up">
							</a>&nbsp;
							<a href="?page=contact.rearenge.down.{ID}">
								<img src="../images/admin/down.png" title="Move down">
							</a>
						</td>
						<td align="center" valign="top">
							<a href="?page=contact.set.{USED_IMAGE_TITLE}.{ID}">
								<img src="../images/admin/{USED_IMAGE}" title='Turn "{NAME}" field to {USED_IMAGE_TITLE}'>
							</a>
						</td>
						<td align="center" valign="top">
							<a href="?page=contact.set.{REQUIRED_IMAGE_TITLE}.{ID}">
								<img src="../images/admin/{REQUIRED_IMAGE}" title='Turn "{NAME}" field to {REQUIRED_IMAGE_TITLE}'>
							</a>
						</td>
						<td align="center" valign="top">
							<a href="?page=contact.edit.{ID}">
								<img src="../images/admin/edit.png" title='Edit field "{NAME}"'>
							</a>
						</td>
						<td align="center" valign="top">
							<a href="?page=contact.delete.{ID}">
								<img src="../images/admin/delete.png" title='Delete field "{NAME}"'>
							</a>
						</td>
					</tr>
				<!-- END list -->
			</table>
		</td>
	</tr>
</table>