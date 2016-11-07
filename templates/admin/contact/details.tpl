<table align="center" border="0" cellspacing="0" cellpadding="0" width="60%">
	<tr>
		<td>
			{INFORMATION}
			<table width="100%" class="grey" cellpadding="4" cellspacing="1">
				<tr>
					<td class="tbhead" colspan="9">View details for message from {NAME}</td>
				</tr>
				<!-- BEGIN form_fields -->
				<tr class="{BGCOLOR}">
					<td width="30%" valign="top"><b>{FIELD_NAME}</b></td>
					<td>{FIELD_VALUE}</td>
				</tr>
				<!-- END form_fields -->
				<tr class="{BGCOLOR}">
					<td width="30%"><b>Date</b></td>
					<td>{DATE}</td>
				</tr>
			<form method="post" action="?page=contact.update_follow_up.{ID}">
					<tr>
					<td colspan="2" class="bgmain">Follow Up Note</td>
				</tr>
				<tr class="{B1}">
					<td valign="top"><b>Note</b></td>
					<td>
						<textarea name="follow_up_note" rows="3" cols="63">{FOLLOW_UP_NOTE}</textarea>
					</td>
				</tr>
				<tr class="{B2}">
					<td colspan="2" align="center">
						<input type="submit" class="button" value="Add/Save Note"/>
					</td>
				</tr>
			</form>
			<form method="post" action="?page=contact.reply.{ID}">
				<tr>
					<td colspan="2" class="bgmain">Reply E-mail</td>
				</tr>
				<tr class="{B1}">
					<td valign="top"><b>Message</b> (if the message box is not empty a reply was already sent to user.)</td>
					<td>
						<textarea name="reply" rows="3" cols="63">{REPLY}</textarea>
					</td>
				</tr>
				<tr class="{B2}">
					<td colspan="2" align="center">
						<input type="submit" class="button" value="Send reply"/>
					</td>
				</tr>
			</form>
			</table>
		</td>
	</tr>
</table>