<div class="contact_form_tab rounded-corners">Formular de contact</div>
<!-- BEGIN error -->
<div class="error_messages">{ERROR_MSG}</div>
<!-- END error -->


<form action="{CABINETETRIMITEEMAIL}" method="post">
<input type="hidden" name="id_cabinet" value="{ID_CABINET}" />
	<div class="contact_form">
		<p>Completand formularul de mai jos  veti trimite un email catre: <b>{PERSOANA_CONTACT}</b>.<br> Pentru programari va rugam contactati medicul dentist si telefonic. Multumim pentru intelegere!</p>
		<div class="contact_form_leftside">
			<p><b>Nume:</b> *<br><input type="text" name="field_1" size="30" value="{FIELD_1}"></p>
			<p><b>E-mail:</b> *<br><input type="text" name="field_2" size="30" value="{FIELD_2}"></p>
			<p><b>Telefon:</b> <br><input type="text" name="field_5" size="30" value="{FIELD_5}"></p>
			<p><b>Subiect:</b> *<br><input type="text" name="field_3" size="30" value="{FIELD_3}"></p>
			<p><b>Cod de siguranta:</b> *<br><input type="text" name="security_code2" size="20"></p>
			<p><img src="{SITEBASE}/security_image.php?code={SECURITYID}" alt="Security Image"></p>
		</div>
		<div class="contact_form_rightside">
			<p><b>Mesaj:</b> *<br><textarea name="field_4" rows="15" cols="34">{FIELD_4}</textarea></p>
			<p align="right"><input type="submit" class="article_send_email" value=""></p>
		</div>
	</div>
</form>