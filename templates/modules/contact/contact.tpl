<h2>Formular de contact</h2>
<p>Dorim sa fim in stransa legatura cu dumneavoastra, de accea daca doriti anumite informatii suplimentare sau aveti nelamuriri va stam la dispozitie. Completati formularul de mai jos
 si vom raspunde cat mai rapid posibil. Mesajul dvs va fi trimis la adresa: <b>admin@dentistonline.ro</b></p>

<form class="form-horizontal" role="form" action="{CONTACT_US_ACTION}" method='post'>
<input type="hidden" name="referer" value="{REFERER}">
	<div class="form-group">
		<label class="control-label col-sm-2" for="email">Nume: *</label>
		<div class="col-sm-4">
			<input type="text" name='field_1' class="form-control" placeholder="Numele dvs ..." value="{FIELD_1}">
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-2" for="email">Email: *</label>
		<div class="col-sm-4">
			<input type="text" name='field_2' class="form-control" placeholder="Adresa email ..." value="{FIELD_2}">
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-2" for="email">Judet: *</label>
		<div class="col-sm-4">
			<input type="text" name='field_6' class="form-control" placeholder="Judetul dvs ..." value="{FIELD_6}">
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-2" for="email">Subiect: *</label>
		<div class="col-sm-4">
			<input type="text" name='field_3' class="form-control" placeholder="Subiectul acestui email ..." value="{FIELD_3}">
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-2" for="email">Telefon: </label>
		<div class="col-sm-4">
			<input type="text" name='field_5' class="form-control" placeholder="Numarul de telefon ..." value="{FIELD_5}">
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-2" for="email">Securitate: *</label>
		<div class="col-sm-4">
			<div class="input-group">
				<span class="input-group-addon" id='contact_security'><img src="{SITE_BASE}/security_image.php?code={SECURITYID}" alt="Security Image"></span>
				<input type="text" class="form-control" placeholder="" name="security_code2" aria-describedby="contact_security">
			</div>
			<span class="help-block">Te rugam sa introduci textul din imaginea de mai sus in campul alaturat, din motive de securitate.</span>
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-2" for="email">Mesaj: *</label>
		<div class="col-sm-6">
			<textarea name="field_4" rows="6" class="form-control">{FIELD_4}</textarea>
		</div>
	</div>
	<div class="form-group">
		<div class="col-xs-offset-2 col-xs-10">
			<button type="submit" class="btn btn-default">Trimite</button>
		</div>
	</div>
</form>
<p ><b style="color:red;"> !!! Va rugam sa verificati si in SPAM</b>, in cazul in care nu primiti mesajul nostru in INBOX. Marcati ca si NOT SPAM pentru a primi in continuare 
mesajele de la admin@dentistonline.ro in INBOX.</p>