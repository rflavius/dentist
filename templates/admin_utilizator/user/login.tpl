<script language="JavaScript" type="text/javascript">
<!--
function dosubmit()
{
	document.do_login.submit();
}

//-->
</script>
<!-- BEGIN login_error -->
<div class="login_error">{LOGIN_ERROR}</div>
<!-- END login_error -->
<td valign="bottom" class="login_bg" align="right">
		<form method="post" action="{USER_LOGIN_LINK}" name="do_login">
			<table border="0" cellspacing="0" cellpadding="0" width="80%" align="right">
			<tr>
				<td width="100" class="login_text" align="center">Utilizator:</td>
				<td align="left"><input type="text" name="username"  size="20" class="login_input" /></td>
			</tr>
			<tr>
				<td width="100" class="login_text" align="center">Parola:</td>
				<td align="left"><input type="password" name="password" size="20" class="login_input" /></td>
			</tr>
			<tr>
				<td colspan="2" >&nbsp;</td>
			</tr>
			<tr>
				<td colspan="2" style="padding-left: 25px;">
					<img src="{SITE_BASEE}/templates/skins/default/images/login_btn.png" alt="Login" title="Login" onclick="dosubmit();" style="cursor:pointer;">
				</td>
			</tr>
			<tr>
				<td colspan="2" >&nbsp;</td>
			</tr>
			<tr>
				<td align="center"><a href="{USER_FORGOT_LINK}">Mi-am uitat parola</a></td>
				<td align="center"><a href="{USER_SUBMIT_LINK}">Inregistrare cabinet</a></td>
			</tr>
			<tr>
				<td colspan="2" >&nbsp;</td>
			</tr>
			</table>
			</form>
</td>