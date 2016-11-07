<form method="post" action="{USER_GENERATE_LINK}">
<!-- BEGIN error -->
	<div id="error_messages"><br />{ERROR_MSG}</div>
	<!-- END error -->
	<table border="0" cellspacing="2" cellpadding="2" width="70%" align="center">
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<td class="text2" width="40%">Adresa de E-mail :<span>*</span></td>
			<td><input type="text" name="email"  value="{EMAIL}" /></td>
		</tr>
		<!-- <tr>
			<td class="text2">Utilizator :<span>*</span></td>
			<td><input type="text" name="username"  value="{USERNAME}" /></td>
		</tr> -->
		<tr>
			<td class="text2">Cod de siguranta :<span>*</span></td>
			<td><input type="text" name="security_code" class="submit_input" /></td>
		</tr>
		<tr>
			<td colspan="2" align="center">
				<img src="security_image.php?code={SECURITYID}" alt="Security Image">
			</td>
		</tr>
		<tr>
			<td colspan="2" align="center">&nbsp;	</td>
		</tr>
		<tr>
			<td align="center" colspan="2"><input type="submit" value="Trimite" class="button"/></td>
		</tr>
	</table>
</form>