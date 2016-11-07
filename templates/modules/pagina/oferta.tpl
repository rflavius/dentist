<script>
function expandOferta(id)
{
	if($('#'+id).is(":hidden"))
	{
		$("#"+id).slideDown(800);
	}
	else
	{
		$("#"+id).hide();
	}
}
</script>

<div class='oferta'>
	<h2>De ce sa aleg promovarea prin serviciul DentistOnline.ro ?</h2>
	<h4>Pentru ca vreau sa fiu reprezentat de cel mai bun portal stomatologic din Romania.</h4>
	<p>DentistOnline.ro este site-ul ce ocupa prima pozitie in domeniul stomatologic, conform Trafic.ro , fiind cel mai important portal stomatologic din tara.</p>
	<p><img src='http://www.dentistonline.ro/images/trafic_stats.jpg' title='statistica trafic.ro'></p>

	<h2>Nu stii care din pachetele de promovare este cel mai potrivit pentru nevoile tale ?</h2>
	<p>Pentru a raspunde cat mai multor cerinte va punem la dispozitie 3 planuri de promovare: BASIC, BUSINESS, PREMIUM ; beneficiile promovarii fiind in functie de nivelul pachetului ales.</p>
	<p>Mai multe informatii referitor la beneficiile fiecarui pachet de promovare sunt prezentate mai jos.</p>

	<h2>Ce inseamna afisarea preferentiala ?</h2>
	<p>Afisarea pe pagina a cabinetelor/clinicilor se va face in functie de planul de promovare ales astfel: PREMIUM, BUSINESS, BASIC.</p>
	<p>Cabinetele/Clinicile ce folosesc planul de promovare BASIC sunt afisate in partea de subsol a paginii, in fata lor fiind afisate pachetele PREMIUM respectiv BUSINESS.</p>
	<h2>Daca alegeti pachetul BASIC aveti posibilitatea de a alege separat fiecare serviciu de promovare contra cost.</h2>
	<table class='planuri_promovare' cellpadding='0' cellspacing='1'>
		<tr>
			<th class='col1'>Beneficii promovare</th>
			<!-- BEGIN list_pachete -->
			<th class='col{COL_NR}'>{PACHET}</th>
			<!-- END list_pachete -->
		</tr>
		<!-- BEGIN list_servicii -->
		<tr>
			<td class='col1'>
				<a onclick='expandOferta("proposal{NR}");'>{SERVICE} <font style="font-size:11px !important;float:right;margin-right:20px;"> Detalii</font></a>
				<div id='proposal{NR}'>
				{DESCRIPTION}
				</div>
			</td>
			<!-- BEGIN list_pachete_col -->
			<td class='col{COL_NR}'><font style="font-size:12px !important;">{SERV_VAL}</font></td>
			<!-- END list_pachete_col -->
		</tr>
		<!-- END list_servicii -->
		<tr>
			<th class='col1'>Tarif promovare</th>
			<th class='col2'>{BASIC_PRICE} RON</th>
			<th class='col3'>{BUSINESS_ABONAMENT_PRICE} RON</th>
			<th class='col4'>{PREMIUM_RECOMANDAT_PRICE} RON</th>
		</tr>
	</table>
	<p>Tarifele percepute sunt pentru o perioada de 1 an de promovare, TVA inclus.</>
	<br>
	<a name='form'></a>
	<h2>Beneficiaza acum de promovare, creeaza cont aici.</h2>
	<!-- BEGIN error -->
		<ul class="error_messages">{ERROR_MSG}</ul>
	<!-- END error -->
	
	<form action="{USER_CREATE_LINK}" method="post">
		<input type='hidden' name='type' value='short'>
		<input class="rounded-corners2" type="text" name='firstname' value="{FIRSTNAME}" placeholder="Numele dvs ...">
		<input class="rounded-corners2" type="text" name='lastname' value="{LASTNAME}" placeholder="Prenumele dvs ... ">
		<input class="rounded-corners2" type="text" name='email' value="{EMAIL}" placeholder="Adresa dvs de email ... ">
		<input class="rounded-corners2" type="text" name='pass_1' value="" placeholder="Parola dvs de administrare ... ">
		<input class="rounded-corners2" type="text" name='security_code' value="" placeholder="Cod securitate ... " style='width:140px;'><img src="security_image.php?code={SECURITYID}" alt="Security Image" style='vertical-align:middle;'>
		<input class="rounded-corners2" type="submit" value="CREEAZA" name="send">
	</form>
</div>
<br>
<br>
<br>