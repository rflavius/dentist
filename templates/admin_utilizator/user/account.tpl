<form method="post" action="{USER_SAVE_CHANGES_LINK}">
<div style="padding-left: 3px;">
	<!-- BEGIN error -->
	<div class="info">{ERROR_MSG}</div>
	<!-- END error -->

	<table border="0" cellspacing="1" cellpadding="4" width="60%" align="center" class="big_table form">
		<tr>
			<td colspan="2" class="table_subhead">Informatii cont utilizator</td>
		</tr>
		<tr>
			<td class="row2" width="40%">Nume :<span>*</span></td>
			<td width="50%" class="row2"><input type="text" size="40" name="firstname" value="{FIRSTNAME}" /></td>
		</tr>
		<tr>
			<td class="row1">Prenume :<span>*</span></td>
			<td class="row1"><input type="text" name="lastname" size="40"  value="{LASTNAME}" /></td>
		</tr>
		<tr>
			<td class="row2">E-mail :<span>*</span></td>
			<td class="row2"><input type="text" name="email"  size="40" value="{EMAIL}" /></td>
		</tr>
		<tr>
			<td class="row1" colspan="2" align="center">
				<a href="{USER_PASSWORD_LINK}">[ Schimba parola ]</a>
			</td>
		</tr>
		<tr>
			<td align="center" colspan="2" class="row2" style="text-align:center;"><input type="submit" class="button" value="Salveaza"/></td>
		</tr>
	</table>
</div>
</form>