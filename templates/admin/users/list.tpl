<script language="javascript" type="text/javascript">
<!--
	function redirect()
	{
			document.location.href = "index.php?page=users.list."+document.aboutusers.list_users.value+"."+document.aboutusers.users_type.value;
	}
//-->
</script>
<br />
<table align="center" border="0" cellspacing="0" cellpadding="0" width="95%">
	<tr>
		<td>
			{INFORMATION}
			
			<form method="post" action="" name="aboutusers">
			<table align="center" class="tbpagination" cellspacing="{CS}" cellpadding="{CP}" width="100%">
				<tr>
					<td class="{B1}"  width="80" align="center"><strong>List users by : </strong></td>
					<td class="{B2}" width="60" align="left">
					
					<select name="list_users" onchange="redirect();">
						<option value="username_list_asc" {USERNAME_LIST_ASC} >Username-ASC</option>
						<option value="username_list_desc" {USERNAME_LIST_DESC}>Username-DESC</option>
						<option value="creation_date_asc" {CREATION_DATE_ASC}>Creation Date ASC</option>
						<option value="creation_date_desc" {CREATION_DATE_DESC}>Creation Date DESC</option>
						<option value="last_login_asc" {LAST_LOGIN_ASC}>Last Login ASC</option>
						<option value="last_login_desc" {LAST_LOGIN_DESC}>Last Login DESCC</option>
					</select>
					</td>
					<td class="{B1}"  width="100" align="center"><b>Users type:</b></td>
					<td class="{B2}"  width="100" align="left">
					
					<select name="users_type" onchange="redirect();">
						<option value="all" {SELECTEDALL}>All</option>
						<option value="1" {SELECTED1}>Active</option>
						<option value="0" {SELECTED0}>Inactive</option>
					</select>
					</td>
				</tr>
			</table>
			</form>
				<br />
			<table align="center" class="tbpagination" cellspacing="{CS}" cellpadding="{CP}" width="100%">
				<tr>
					<td class="{B1}"  width="80" align="center"><strong>{COUNT_USERS} Users</strong></td>
					<td class="{B2}" width="60" align="center">Pages <strong>({PAGES}) : </strong></td>
					<td class="{B1}" align="center">{PAGINATION}</td>
				</tr>
			</table>
			<br />
			<table width="100%" class="grey" cellpadding="4" cellspacing="1">
				<tr>
					<td class="tbhead" colspan="10">List all users</td>
				</tr>
				<!-- BEGIN if_messages -->
				<tr>
					<td class="bgmain">Username</td>
					<td class="bgmain" nowrap>Name</td>
					<td class="bgmain">Email</td>
					<td class="bgmain" nowrap>Submit date</td>
					<td class="bgmain" nowrap>Last login</td>
					<td class="bgmain" width="10%" nowrap>&nbsp;</td>
					<td class="bgmain" nowrap>Cabinet</td>
					<td class="bgmain" width="7%">Status</td>
					<td class="bgmain" width="7%">Delete</td>
				</tr>
				<!-- BEGIN list_messages -->
				<tr class="{BGCOLOR}">
					<td valign="top"><b><a href="?page=users.details.{ID}.{USERNAME}">{USERNAME}</a></b></td>
					<td valign="top">{LASTNAME}, {FIRSTNAME}</td>
					<td valign="top">{EMAIL}</td>
					<td valign="top">{SUBMIT_DATE}</td>
					
					<td valign="top">{LAST_LOGIN}</td>
					<td valign="top" align="center">[ <a href="?page=users.logins&user_id={ID}">View logins</a> ]</td>
					<td align="center"><a href="?page=users.details.{ID}.{USERNAME}">{ARECABINET}</a></td>
					<td align="center" valign="top">
						<a href="?page=users.set.{IMAGE_TITLE}.{ID}">
							<img src="../images/admin/{IMAGE}" title="Turn {USERNAME}'s account to {IMAGE_TITLE}">
						</a>
					</td>
					<td align="center" valign="top">
						<a href="?page=delete.user.{ID}">
							<img src="../images/admin/delete.png" title="Delete {USERNAME}'s account">
						</a>
					</td>
				</tr>
				<!-- END list_messages -->
				<!-- END if_messages -->
			</table>
		</td>
	</tr>
</table>