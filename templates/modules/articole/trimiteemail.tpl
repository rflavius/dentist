<!-- BEGIN error -->
<div class="error_messages">{ERROR_MSG}</div>
<!-- END error -->

	<!-- END if_errors -->
		<form action="{CABINETETRIMITEEMAIL}" method="post">
			<table align="center" border="0" cellspacing="1" cellpadding="2" class="contact" width="90%">
				<tr>
					<td colspan="2" class="text" ><div class="first_word">Complectand </div> formularul de mai jos  veti trimite un email autorului articolulului: <b>{ARTICOL}</b>
					<br />
					</td>
				</tr>
				<tr>
					<td colspan="2"><input type="hidden" name="id_articol" value="{ID_ARTICOL}" /></td>
				</tr>
				<!-- BEGIN order -->
				<tr>
					<td align="right" width="30%" valign="top" class="text2"><b>Nume :</b><span> *</span></td>
					<td align="left">	<input type="text" name="field_1" size="40" value="{FIELD_1}"></td>
				</tr>

				<tr>
					<td align="right" width="30%" valign="top" class="text2"><b>Email :</b><span> *</span></td>
					<td align="left"><input type="text" name="field_2" size="40" value="{FIELD_2}">	</td>
				</tr>
				<tr>
					<td align="right" width="30%" valign="top" class="text2"><b>Subiect :</b><span> *</span></td>
					<td align="left">		<input type="text" name="field_3" size="40" value="{FIELD_3}">	</td>
				</tr>
				<tr>
					<td align="right" width="30%" valign="top" class="text2"><b>Mesaj :</b><span> *</span></td>
					<td align="left">	<textarea name="field_4" rows="10" cols="33" value="{FIELD_4}"></textarea>	</td>
				</tr>
				<tr>
					<td align="right" width="30%" valign="top" class="text2"><b>Telefon :</b></td>
					<td align="left">	<input type="text" name="field_5" size="40" value="{FIELD_5}">	</td>
				</tr>
				<tr>
					<td class="text2"><b>Cod de siguranta </b>:<span>*</span></td>
					<td><input type="text" name="security_code2" size="40" /></td>
				</tr>
				<tr>
					<td colspan="2" align="center">
						<img src="{SITEBASE}/security_image.php?code={SECURITYID}" alt="Security Image"><input type="hidden" name="id_articol" value="{ID_ARTICOL}" />
					</td>
				</tr>
				<tr>
					<td colspan="2" align="center"><br />
						<input type="submit" class="button" value=" Trimite ">
					</td>
				</tr>
			</table>
		</form>