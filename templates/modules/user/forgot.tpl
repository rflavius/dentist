<h2>Recuperare parola</h2>
<div class='clearfix'></div>
<form class="form-horizontal" role="form" action="{USER_GENERATE_LINK}" method='post'>
<div class='row well well-lg login_form'>
	<div class="help-block text-left">Noua parola va fi generata si trimisa pe adresa dvs de e-mail.</div>
	<div class='col-sm-7 col-xs-12 text-left'>
		<div class="form-group form-group-lg">
			<div class="input-group col-sm-7">
				<div class="input-group-addon" id='email'><span class='glyphicon glyphicon-envelope'></span></div>
				<input type="text" name='email' class="form-control" placeholder="Adresa de email ..." value="{EMAIL}" aria-describedby="email">
			</div>
		</div>
		<div class="form-group form-group-lg">
			<div class="input-group col-sm-7">
				<div class="input-group-addon" id='security'><img src="{SITE_BASE}/security_image.php?code={SECURITYID}" alt="Security Image"></div>
				<input type="text" name="security_code" class="form-control" placeholder="Cod ..." value="" aria-describedby="security">
			</div>
		</div>
		<div class="form-group form-group-lg">
			<div class="input-group col-sm-7">
				<button type="submit" name="login" class="btn btn-info btn-lg">Trimite</button>
			</div>
		</div>
	</div>
	<div class='col-sm-5 col-xs-12 text-center'>
		<p class="article_details_title"> Ai nevoie de ajutor?</p>
		<p class="help_phone">Ne puteti contacta de Luni-Vineri la numarul de telefon: <br><b>0727-380-368</b>.</p>
	</div>
</div>
</form>
</div>