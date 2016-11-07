<br>
<table border="0" cellspacing="0" cellpadding="0" width="100%">
<tr>
	<td width="60%" align="center" valign="top">
		<table width="90%" class="grey" cellpadding="4" cellspacing="1">
			<tr>
				<td class="tbhead" colspan="11">List Admins</td>
			</tr>
			<tr>
				<td class="bgmain" width="10%" nowrap>Username</td>
				<td class="bgmain" width="8%" nowrap>Email</td>
				<td class="bgmain" width="5%">Edit</td>
				<td class="bgmain" width="5%">Delete</td>
				<td class="bgmain" width="5%" nowrap>View Logins</td>
			</tr>
			<!-- BEGIN list -->
			<tr class="{BGCOLOR}">
				<td><b>{USERNAME}</b></td>
				<td>{EMAIL}</td>
				<td align="center"><a href="?page=admins.edit.{ID}"><img src="../images/admin/edit.png" title="Edit {USERNAME}'s admin account"></a></td>
				<td align="center">
					<a href="?page=delete.admin.{ID}">
						<img src="../images/admin/delete.png" title="Delete {USERNAME}'s admin account">
					</a>
				</td>
				<td align="center">
					<a href="?page=logins&admin={ID}">View</a>
				</td>
			</tr>
			<!-- END list -->
		</table>
	</td>
	<td width="40%" valign="top" align="center">
		<form method="post" action="?page=admins.add">
			{INFORMATION}
			<table width="100%" class="grey" cellpadding="4" cellspacing="1">
				<tr>
					<td class="tbhead" colspan="11">Add new admin</td>
				</tr>
				<tr>
					<td class="{B2}"><b>Username</b></td>
					<td class="{B1}"><input type="text" name="user" value="{USER}" /></td>
				</tr>
				<tr>
					<td class="{B2}"><b>Password</b></td>
					<td class="{B1}"><input type="password" name="pass_1" /></td>
				</tr>
				<tr>
					<td class="{B2}"><b>Re-Type Password</b></td>
					<td class="{B1}"><input type="password" name="pass_2" /></td>
				</tr>
				<tr>
					<td class="{B2}"><b>Email Address</b></td>
					<td class="{B1}"><input type="text" name="add_email" value="{ADD_EMAIL}" /></td>
				</tr>
				<tr>
					<td class="{B2}" colspan="2" align="center">
						<input type="submit" class="button" value="Add user" />
					</td>
				</tr>
			</table>
		</form>
	</td>
</tr>
</table>