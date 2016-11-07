<table align="center" border="0" cellspacing="0" cellpadding="0" width="45%">
	<tr>
		<td>
			<form method="post" action="?page=admins.save_password.{ID}">
				{INFORMATION}
				<table width="100%" class="grey" cellpadding="4" cellspacing="1">
					<tr>
						<td class="tbhead" colspan="11">Edit {USER}'s admin password</td>
					</tr>
					<tr>
						<td class="{B2}"><b>Old Password</b></td>
						<td class="{B1}">
							<input type="password" name="old_password" />
						</td>
					</tr>
					<tr>
						<td class="{B2}"><b>New Password</b></td>
						<td class="{B1}">
							<input type="password" name="new_password_1" />
						</td>
					</tr>
					<tr>
						<td class="{B2}"><b>Re-type new Password</b></td>
						<td class="{B1}">
							<input type="password" name="new_password_2" />
						</td>
					</tr>
					<tr>
						<td class="{B2}" colspan="2" align="center">
							<input type="submit" class="button" value="Save Password" />
						</td>
					</tr>
				</table>
			</form>
		</td>
	</tr>
</table>