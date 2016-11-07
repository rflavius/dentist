<script type="text/javascript" src="{SITE_BASEE}/templates/js/prototype.js"></script>

<script src="{SITE_BASEE}/templates/js/gmap/jquery/lib/jquery-1.5.1.min.js" type="text/javascript"></script>
<script src="{SITE_BASEE}/templates/js/gmap/jquery/ui/js/jquery-ui-1.8.12.custom.min.js" type="text/javascript"></script>
<script src="{SITE_BASEE}/templates/js/gmap/jquery/plugins/jquery.cookie.js" type="text/javascript"></script>
<script src="{SITE_BASEE}/templates/js/gmap/jquery/plugins/jquery.json-2.2.min.js" type="text/javascript"></script>

<script type="text/javascript" src="{SITE_BASEE}/templates/js/admin_utilizator/shopping_cart.js"></script>


<script type="text/javascript">
<!--
	function CompleteLocalitateFirma()
	{
		var target ='localitate_ajax_addfirm'; 
		var url="../sources/ajax_search.php?tpl_selected=addfirm&search_judet="+document.adauga_firma.judetselected.value;
		var myAjax = new Ajax.Updater(target, url, { method: 'get'}); 
		$(target).show(); 
	}

function CountChars( field, maxcaractere )
	{
		if ( field.value.length > maxcaractere )
		{
			field.value = field.value.substr(0,maxcaractere);
		}
		
		document.forms['adauga_firma']['caractere_'+field.name].value = maxcaractere - field.value.length;
	}

function loadform(val)
{
	if(val=="persoana_fizica")
	{
		document.getElementById("firma_div").style.display = 'none';
	}
	else if(val=='firma')
	{
		document.getElementById("persoana_fizica_div").style.display = 'none';
	}
	else
	{
		document.getElementById("firma_div").style.display = 'none';
		document.getElementById("persoana_fizica_div").style.display = 'none';
	}
	document.getElementById(val+"_div").style.display = 'block';
}

function ViewAbonamentDiv2(type)
{
	document.adauga_firma.selected_level.value = type;
	if(type=='1')
	{
		// gratuit
			document.getElementById('cost_final_promovare').innerHTML = "0 RON";
			document.adauga_firma.cost_final.value = 0;
			document.adauga_firma.cost_abonament.value = 0;
			document.adauga_firma.cost_recomandat.value = 0;
			document.adauga_firma.selected_cost_recomandat.value = 0;
			document.adauga_firma.selected_cost_abonament.value = 0;
			document.getElementById('view_abonament').style.display = 'none';
	}
	else
	{
		// abonament
		document.getElementById('view_abonament').style.display = 'block';
		document.getElementById('discount_abonament').style.display = 'block';

		discount_procent = document.adauga_firma.abonament_nr.value*document.adauga_firma.abonament_discount_procentaj.value;
		discount_val = (200*discount_procent)/100;
		final_cost = 200-discount_val;

		document.getElementById('discount_procent').innerHTML = discount_procent+"%";
		document.getElementById('cost_final_promovare').innerHTML = "0 RON";
		document.adauga_firma.cost_final.value = 0;
		document.adauga_firma.cost_abonament.value = 0;

	}
}

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

//-->
</script>



<div class="steps">
	<span class="step1_inactive"></span>
	<span class="step2_inactive"></span>
	<span class="step3_active"></span>
	<div style="color: #255A82;font-size:16px;">
		<p style="float:left;">Detalii firma & Localizare</p>
		<p style="float:left;margin-left:250px;">Servicii si Tarife & Galerie Imagini & Video</p>
		<p style="float:right;">Finalizare</p>
	</div>
</div>
<br>
<a name="error"></a>
{ERROR_MSG}
<br>
<form name="adauga_firma" method="post" action="{INSERT_FIRMA3}" enctype="multipart/form-data" >
<input type='hidden' name='pachet' value='{DEF_PACHET}' id='firma_pachet'>
<input type='hidden' name='servicii' value='{SERVICII}' id='firma_servicii'>
<input type='hidden' name='total' value='{TOTAL}' id='firma_total'>


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
</div>
<div class='oferta_final'>Promovare pachet: PREMIUM - 6luni - 240RON, ne puteti contacta la numarul: 0727.380.368</div>
<div class='oferta_total'>
	<div class='oferta_total_left'>
		<h2>Costuri finale</h2>
		<p>Daca alegeti pachetul BASIC aveti posibilitatea de a alege separat fiecare serviciu de promovare contra cost.</p>
	</div>
	<div class='oferta_total_right'>
		<table align='right' cellpadding='2' cellspacing='2'>
		<tr>
			<td width='140'>Pachet:</td>
			<td>
				<select name='pachet' onChange="updatePachet(this.value)">
					<!-- BEGIN list_total_pachete -->
					<option value='{PK_ID}' {PK_SELL}>{PK} - 1 an</option>
					<!-- END list_total_pachete -->
				</select>
			</td>
		</tr>
		<tr>
			<td>TOTAL:</td>
			<td><span id='total_price'>{TOTAL}</span> RON</td>
		</tr>
		<tr>
			<td colspan='2' align='right' style='font-size:11px;'>Preturile includ TVA.</td>
		</tr>
		</table>
	</div>
</div>
<div class='oferta' style='background:#acdbed;'>
	<h2 style='color:white !important;'>Date facturare<span>*</span>
					<select name="type" onchange="loadform(this.value);">
						<option value="" selected>Alegeti</option>
						<option value="persoana_fizica" {PERSOANA_FIZICA_SELL}>Persoana fizica</option>
						<option value="firma" {FIRMA_SELL}>Firma</option>
					</select>
	</h2>
	<div id="persoana_fizica_div" {PERSOANA_FIZICA_BLOCK_STYLE} class='cform2'>
		<input class="rounded-corners2" type="text" name='cnp' value="{CNP}" placeholder="CNP  ...">
		<input class="rounded-corners2" type="text" name='persc_adresa' style='width:370px;' value="{PERSC_ADRESA}" placeholder="Adresa dvs ... ">
	</div>
	
	<div id="firma_div" {FIRMA_BLOCK_STYLE} class='cform2'>
		<input class="rounded-corners2" type="text" name='cui' value="{CUI}" placeholder="Cod unic  ...">
		<input class="rounded-corners2" type="text" name='reg_comert_bi' value="{REG_COMERT_BI}" placeholder="Nr. Reg. Comertului ... ">
		<input class="rounded-corners2" type="text" name='adresa_firma' value="{ADRESA_FIRMA}" style='width:370px;' placeholder="Adresa dvs ... ">
	</div>
	<div class='cform2'>
		<input class="rounded-corners2" type="submit" value="Finalizeaza" name="send">
	</div>
</div>
</form>
<br>
<br>
<br>
<br>

