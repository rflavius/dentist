<form method="post" action="{USER_SAVE-PASSWORD_LINK}">
<div >
	<!-- BEGIN error -->
	<div class="info">{ERROR_MSG}</div>
	<!-- END error -->
<br>
	<table border="0" cellspacing="1" cellpadding="1" width="60%" align="center" class="big_table form">
		<tr>
			<td colspan="2"  class="table_subhead">Schimbarea parolei de la contul de utilizator </td>
		</tr>
		<tr>
			<td class="row2" width="40%">Vechea parola:<span>*</span></td>
			<td class="row2" width="60%"><input type="password" size="40" name="old_password"  /></td>
		</tr>
		<tr>
			<td class="row1">Noua parola :<span>*</span></td>
			<td class="row1"> <input type="password" size="40" name="new_pass_1" /></td>
		</tr>
		<tr>
			<td class="row2">Retipareste noua parola :<span>*</span></td>
			<td class="row2"><input type="password" size="40" name="new_pass_2" class="submit_input" /></td>
		</tr>
		<tr>
			<td class="row1" align="center" colspan="2" style="text-align:center;"><input type="submit" class="button" value="modifica"/></td>
		</tr>
	</table>
</div>
</form>