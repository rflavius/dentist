<form method="post" action="{USER_GENERATE_LINK}">
<div style="padding-left: 3px;">
	<!-- BEGIN if_error -->
	<table border="0" cellspacing="0" cellpadding="0" width="400" align="center">
	<tr>
		<td class="error">
		<!-- BEGIN error -->
		<div class="text">{ERROR_MSG}</div>
		<!-- END error -->
		</td>
	</tr>
	</table>
	<!-- END if_error -->
	<table border="0" cellspacing="2" cellpadding="2" width="70%" align="center" class="table_content_border">
		<tr>
			<td colspan="2" class="notice">Pentru masuri de securitate va rugam sa complectati campurile de mai jos. In urma complectari campurilor va fi trimis un e-mail ce va contine datele contului la adresa indicata de dvs.</td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<td class="text" width="40%" style="padding-left: 10px;">Adresa de e-mail :<b class="star">*</b></td>
			<td><input type="text" name="email" class="loginbox_input" value="{EMAIL}" /></td>
		</tr>
		<tr>
			<td class="text" width="40%" style="padding-left: 10px;">Numele utilizatorului :<b class="star">*</b></td>
			<td><input type="text" name="username" class="loginbox_input" value="{USERNAME}" />&nbsp;&nbsp;<img src="{SITE_BASE}/templates/skins/admin/images/help2.gif" onMouseOver="return overlib('Acesta este numele ( USERNAME-ul ) cu ajutorul caruia intrati in contul dvs.', CAPTION, 'Utilizator');" onmouseout="return nd();" ></td>
		</tr>
		<tr>
			<td class="text" width="40%" style="padding-left: 10px;">Cod de securitate :<b class="star">*</b></td>
			<td><input type="text" name="security_code" class="loginbox_input" /></td>
		</tr>
		<tr>
			<td colspan="2" align="center">
				<img src="{SITE_BASE}/security_image.php?code={SECURITYID}" alt="Security Image">
			</td>
		</tr>
		<tr>
			<td align="center" colspan="2"><input type="submit" class="button" value="Trimite"/></td>
		</tr>
	</table>
</div>
</form>