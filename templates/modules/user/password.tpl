<form method="post" action="{USER_SAVE-PASSWORD_LINK}">
<div style="padding-left: 3px;">
	<!-- BEGIN error -->
	<div id="error_messages"><br />{ERROR_MSG}</div>
	<!-- END error -->

	<table border="0" cellspacing="2" cellpadding="2" width="70%" align="center">
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<td class="text2" width="50%">Vechea parola:<span>*</span></td>
			<td width="50%"><input type="password" name="old_password"  /></td>
		</tr>
		<tr>
			<td class="text2">Noua parola :<span>*</span></td>
			<td><input type="password" name="new_pass_1" /></td>
		</tr>
		<tr>
			<td class="text2">Retipareste noua parola :<span>*</span></td>
			<td><input type="password" name="new_pass_2" class="submit_input" /></td>
		</tr>
		<tr>
			<td align="center" colspan="2"><br /><input type="submit" class="button" value="modifica"/></td>
		</tr>
	</table>
</div>
</form>