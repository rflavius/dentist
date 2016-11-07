<table align="center" border="0" cellspacing="0" cellpadding="0" width="95%">
	<tr>
		<td>
			{INFORMATION}
			<table align="center" class="tbpagination" cellspacing="{CS}" cellpadding="{CP}" width="100%">
				<tr>
					<td class="{B1}" width="80" align="center"><strong>{COUNT_MESSAGES} Messages</strong></td>
					<td class="{B2}" width="60" align="center">Pages <strong>({PAGES}) : </strong></td>
					<td class="{B1}" align="center">{PAGINATION}</td>
				</tr>
			</table>
			<br />
			<table width="100%" class="grey" cellpadding="4" cellspacing="1">
				<tr>
					<td class="tbhead" colspan="9">List all contact us messages</td>
				</tr>
				<!-- BEGIN if_messages -->
				<tr>
					<td class="bgmain" width="4%">Id</td>
					<td class="bgmain" width="17%">Name</td>
					<td class="bgmain" width="20%">Subject</td>
					<td class="bgmain" width="20%">Message</td>
					<td class="bgmain" width="6%">Reply</td>
					<td class="bgmain" width="20%">Follow Up Note</td>
					<td class="bgmain" width="7%">Details</td>
					<td class="bgmain" width="6%">Delete</td>
				</tr>
				<!-- BEGIN list_messages -->
				<tr class="{BGCOLOR}">
					<td align="center" valign="top">
						<a href="?page=contact.details.{ID}" title='View details for message from {NAME}'>{ID}</a>
					</td>
					<td valign="top">
						<b>{NAME}</b>
					</td>
					<td valign="top"><div id="norows">{SUBJECT}</div></td>
					<td valign="top"><div id="norows">{MESSAGE}</div></td>
					<td valign="top" align="center"><b>{REPLY}</b></td>
					<td valign="top"><div id="norows">{FOLLOW_UP}</div></td>
					<td align="center" valign="top">
						<a href="?page=contact.details.{ID}"><img src="../images/admin/edit.png" title='View details for message from {NAME}'></a>
					</td>
					<td align="center" valign="top">
						<a href="?page=delete.contact.{ID}">
							<img src="../images/admin/delete.png" title='Delete message from {NAME}'>
						</a>
					</td>
				</tr>
				<!-- END list_messages -->
				<!-- END if_messages -->
			</table>
		</td>
	</tr>
</table>