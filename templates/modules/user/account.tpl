<form method="post" action="{USER_SAVE_CHANGES_LINK}">
<div style="padding-left: 3px;">
	<!-- BEGIN error -->
	<div id="error_messages"><br />{ERROR_MSG}</div>
	<!-- END error -->
	<table border="0" cellspacing="1" cellpadding="4" width="60%" align="center" class="table_border">
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<td class="text2" width="50%">Nume :<span>*</span></td>
			<td width="50%"><input type="text" size="30" name="firstname" value="{FIRSTNAME}" /></td>
		</tr>
		<tr>
			<td class="text2">Prenume :<span>*</span></td>
			<td><input type="text" name="lastname" size="30"  value="{LASTNAME}" /></td>
		</tr>
		<tr>
			<td class="text2">E-mail :<span>*</span></td>
			<td><input type="text" name="email"  size="30" value="{EMAIL}" /></td>
		</tr>
		<tr>
			<td class="text2" colspan="2" align="center">
				<a href="{USER_PASSWORD_LINK}">Schimba parola</a>
			</td>
		</tr>
		<tr>
			<td align="center" colspan="2"><input type="submit" class="button" value="Modifica"/></td>
		</tr>
	</table>
</div>
</form>