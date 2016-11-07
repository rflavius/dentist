<br>
<!-- BEGIN login_error -->
<div class="login_error">
	{LOGIN_ERROR}
</div>
<!-- END login_error -->
<form method="post" action="{USER_LOGIN_LINK}">
<table border="0" cellspacing="1" cellpadding="3" width="50%" align="center" style="border: 1px solid #DFDFDF;">
<tr>
	<td colspan="2" style="height: 24px;background-color: #51ADD7; color: white; font-family: tahoma;font-size: 12px;"><b>Intra in contul tau de utilizator !</b></td>
</tr>
<tr>
	<td><img src="./images/admin/lock.gif" style="border:none;"></td>
	<td><font color="#A8171B"> <b>*** Campurile de mai jos sunt obligatorii. Va multumim !</b></font></td>
</tr>
<tr>
	<td nowrap><b>Utilizator :</b> </td>
	<td><input type="text" name="username" class="search_field" size="35"></td>
</tr>
<tr>
	<td nowrap><b>Parola :</b> </td>
	<td><input type="password" name="password" class="search_field" size="30"></td>
</tr>
<tr>
	<td style="height: 35px;line-height: 35px;" colspan="2" valign="bottom" align="center"><input type="submit" value="Intra in cont" CLASS='send_email'></td>
</tr>
<tr>
	<td nowrap><a href="{USER_FORGOT_LINK}" >Am uitat parola</a></td>
	<td align="right" nowrap><a href="{USER_SUBMIT_LINK}" style="color:#CC0000;"><b>Adauga Cazare</b></a></td>
</tr>
</table>
</form>