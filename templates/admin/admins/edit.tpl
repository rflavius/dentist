<table align="center" border="0" cellspacing="0" cellpadding="0" width="45%">
	<tr>
		<td>
			<form method="post" action="?page=admins.save_changes.{ID}">
				{INFORMATION}
				<table width="100%" class="grey" cellpadding="4" cellspacing="1">
					<tr>
						<td class="tbhead" colspan="11">Edit {USER}'s admin account</td>
					</tr>
					<tr>
						<td class="{B2}"><b>Username</b></td>
						<td class="{B1}">{USER}</td>
					</tr>
					<tr>
						<td class="{B2}"><b>Email Address</b></td>
						<td class="{B1}"><input type="text" name="email" value="{EMAIL}" /></td>
					</tr>
					<tr>
						<td class="{B2}" colspan="2" align="center"><a href="?page=admins.password.{ID}">Change Password</a></td>
					</tr> 
					<tr>
						<td class="{B2}" colspan="2" align="center">
							<input type="submit" class="button" value="Save Changes" />
						</td>
					</tr>
				</table>
			</form>
		</td>
	</tr>
</table>