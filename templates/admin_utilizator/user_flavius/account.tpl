<form method="post" action="?page=user.savechanges">
<div style="padding-left: 3px;min-height: 300px;">
{INFORMATION}
	<table border="0" cellspacing="1" cellpadding="3" width="70%" align="left" class="big_table form">
		<tr>
			<td colspan="2" class="table_subhead"><b>DETALIILE CONTULUI</b></td>
		</tr>
		<tr>
			<td width="40%" style="padding-left: 10px;"  class="row1">Nume :<b class="star">*</b></td>
			<td width="50%" class="row1"><input type="text" name="firstname" value="{FIRSTNAME}" size="50" ></td>
		</tr>
		<tr>
			<td  class="row2" width="40%" style="padding-left: 10px;">Prenume :<b class="star">*</b></td>
			<td class="row2"><input type="text" name="lastname" value="{LASTNAME}"  size="50" ></td>
		</tr>
		<tr>
			<td class="row1" width="40%" style="padding-left: 10px;">Adresa de E-mail :<b class="star">*</b></td>
			<td class="row1"><input type="text" name="email" value="{EMAIL}"  size="50" ></td>
		</tr>
		<tr>
			<td  class="row2" colspan="2" align="center">
				<a href="{USER_PASSWORD_LINK}">[ Modifica parola ]</a>
			</td>
		</tr>
		<tr >
			<td align="center" class="row1" colspan="2"><input type="submit" class="button" value="Salveaza" ></td>
		</tr>
	</table>
</div>
</form>