
<script type="text/javascript" src="{SITE_BASEE}/templates/js/prototype.js"></script>

<script language="javascript" type="text/javascript">
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

function ViewAbonamentDiv(type)
{

	var cost_recomandat = document.adauga_firma.cost_recomandat.value;

	// remember the old price if we submitted the form and we got errrors
	if(document.adauga_firma.selected_cost_recomandat.value!="0" && document.adauga_firma.selected_cost_recomandat.value!="")
	{
		cost_recomandat = document.adauga_firma.selected_cost_recomandat.value;
	}


	if(type=='1')
	{
		// gratuit
		//document.getElementById('view_abonament').style.display = 'none';
		//document.getElementById('discount_abonament').style.display = 'none';
		document.getElementById('cost_promovare').innerHTML = cost_recomandat;
		document.getElementById('cost_final_promovare').innerHTML = cost_recomandat+" RON";
		document.adauga_firma.cost_final.value = Number(0) + Number(cost_recomandat);
		document.adauga_firma.cost_abonament.value = 0;
		document.adauga_firma.selected_cost_abonament.value = 0;
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
		document.getElementById('cost_promovare').innerHTML = Number(cost_recomandat) + Number(200);
		document.getElementById('cost_final_promovare').innerHTML = Number(cost_recomandat)+Number(final_cost)+" RON";
		document.adauga_firma.cost_final.value = Number(final_cost)+Number(cost_recomandat);
		document.adauga_firma.cost_abonament.value = final_cost;
	}
}

function AddRecomandatCost(val)
{
	// setup some variables to use !
	if(val=='6')
	{
		var pret_recomandat = 240;
		document.adauga_firma.cost_recomandat.value = '240';
		document.adauga_firma.selected_cost_recomandat.value = '240';
	}
	else if(val=='12')
	{
		var pret_recomandat = 400;
		document.adauga_firma.cost_recomandat.value = '400';
		document.adauga_firma.selected_cost_recomandat.value = '400';
	}
	var pret_abonament = document.adauga_firma.cost_abonament.value;

	// remember the old price if we submitted the form and we got errrors
	if(document.adauga_firma.selected_cost_abonament.value!="0" && document.adauga_firma.selected_cost_abonament.value!="" && document.adauga_firma.selected_cost_abonament.value!=document.adauga_firma.cost_abonament.value)
	{
		pret_abonament = document.adauga_firma.selected_cost_abonament.value;
	}

	// remember the old price if we submitted the form and we got errrors
	if(document.adauga_firma.selected_cost_recomandat.value!="0" && document.adauga_firma.selected_cost_recomandat.value!="")
	{
		pret_recomandat = document.adauga_firma.selected_cost_recomandat.value;
	}

	if(val!='N' && val!="")
	{
		discount_procent = document.adauga_firma.abonament_nr.value*document.adauga_firma.abonament_discount_procentaj.value;
		discount_val = (pret_abonament*discount_procent)/100;
		final_cost = pret_abonament-discount_val;

		document.getElementById('cost_final_promovare').innerHTML = Number(pret_recomandat)+Number(final_cost)+" RON";
		document.getElementById('cost_promovare').innerHTML = Number(pret_recomandat)+Number(final_cost);
		document.adauga_firma.cost_final.value = Number(final_cost)+Number(pret_recomandat);
	}
	else
	{
		discount_procent = document.adauga_firma.abonament_nr.value*document.adauga_firma.abonament_discount_procentaj.value;
		discount_val = (pret_abonament*discount_procent)/100;
		final_cost = pret_abonament-discount_val;

		document.getElementById('cost_final_promovare').innerHTML = final_cost+" RON";
		document.getElementById('cost_promovare').innerHTML = final_cost;
		document.adauga_firma.cost_final.value = final_cost;

	}
}

//-->
</script>

<!-- BEGIN error -->
<br>
<table border='0' width='100%' align='center' cellspacing='0' cellpadding='0' class="error">
<tr>
	<td>{ERROR_MSG}</td>
</tr>
</table>
<br>
<!-- END error -->

<form name="adauga_firma" method="post" action="{UPDATE_PACHET_ACTION}" enctype="multipart/form-data" >
<input type="hidden" name="selected_cost_abonament" value="{SELL_COST_ABONAMENT}">
<input type="hidden" name="selected_cost_recomandat" value="{SELL_COST_RECOMANDAT}">

<input type="hidden" name="cost_final" value="{SEL_COST_FINAL}">
<input type="hidden" name="cost_abonament" value="0">
<input type="hidden" name="cost_recomandat" value="0">
<input type="hidden" name="abonament_nr" value="{ABONAMENT_NR}">
<input type="hidden" name="abonament_discount_procentaj" value="{ABONAMENT_DISCOUNT_PROCENTAJ}">
<table border="0" cellpadding="4" cellspacing="1" width="100%" class="big_table form">
	<tr> 
		<td colspan="3" class="table_subhead">Alege Promovarea care te avantajeaza!!</td>
	</tr>
</table>
<!-- 
<p>Veti beneficia de extra serviciile oferite de Abonament timp de 1 an.</p> -->
<div id="view_abonament">
	<table border='0' width='100%' align='center' cellspacing='1' cellpadding='1' class="big_table form">
		<tr> 
			<td class="row2" width="300">Abonament </td>
			<td class="row2" >
				<select name="perioada">
					<option value="" selected>Alege optiunea</option>
					<option value="2" {SELECTED_2} onclick="ViewAbonamentDiv('2');">12 luni ---- pret {PRET_UN_AN} RON</option>
					<option value="1" {SELECTED_1} onclick="ViewAbonamentDiv('1');">NU</option>
				</select>
				<p align="right" style="display:inline;padding-left:230px;">
				Detalii <a href="http://www.dentistonline.ro/admin_utilizator/?page=user.publicitate#abonament" target="_blank" title="Alege promovarea care te avantajeaza!!">[ <b>ABONAMENT</b> ]</a></p>
			</td>

		</tr>
		<tr> 
			<td class="row1">Recomandat pe judetul meu
			</td>
			<td class="row1">
				<select name="recomandata" onChange="AddRecomandatCost(this.value);">
					<option value="" selected>Alege optiunea</option>
					<option value="6" {SELECTED_6}>6 luni ---- pret 240RON</option>
					<option value="12" {SELECTED_12}>12 luni ---- pret 400RON</option>
					<option value="N" {SELECTED_N}>Nu</option>
				</select>
				<p align="right" style="display:inline;padding-left:230px;">Detalii <a href="http://www.dentistonline.ro/admin_utilizator/?page=user.publicitate#recomandat" target="_blank" title="Alege promovarea care te avantajeaza!!">[ <b>RECOMANDAT</b> ]</a></p>
			</td>

		</tr>

		<tr> 
      <td class="row2" >Emitere factura pe: <span>*</span></td>
      <td class="row2">
					<select name="type" onchange="loadform(this.value);">
						<option value="" selected>Alegeti</option>
						<option value="persoana_fizica" >Persoana fizica</option>
						<option value="firma" >Firma</option>
				</select>
			</td>
    </tr>	
		<tr>
			<td colspan="2" align="center" class="row2">
				<div id="persoana_fizica_div" style="display:none;">
					<table border="0" cellspacing="1" cellpadding="4" class="table_border" width="100%">
						<tr> 
							<td class="text2" width="30%"> CNP <span>*</span></td>
								<td> <input name="cnp" size="40" value="{CNP}" type="text" {EDITABLE}></td>
						</tr>
						<tr> 
							<td class="text2">Adresa <span>*</span></td>
							<td><textarea name="persc_adresa" rows="5" cols="30" {EDITABLE}>{PERSC_ADRESA}</textarea></td>
					 </tr>
						<tr> 
							<td class="text2">Cod postal </td>
							<td ><input name="zip_code"  size="6" id="zip" value="{ZIP_CODE}" type="text" {EDITABLE}></td>
						</tr>
						<tr> 
							<td class="text2" colspan="2">Va rugam specificati in adresa Orasul,Judetul</td>
						</tr>
					</table>
				</div>
				<div id="firma_div" style="display:none;">
					<table border="0" cellspacing="1" cellpadding="4" class="table_border" width="100%">
						<tr> 
								<td class="text2" > CUI <span>*</span></td>
								<td> <input name="cui" size="40" value="{CUI}" type="text" {EDITABLE}></td>
							</tr>
							<tr> 
								<td class="text2">Registru comertului<span>*</span></td>
								<td><input name="reg_comert_bi" maxlength="100" size="40" value="{REG_COMERT_BI}" type="text" {EDITABLE}></td>
							</tr> 
								<tr> 
									<td class="text2">Adresa <span>*</span></td>
									<td><textarea name="adresa_firma" rows="5" cols="30" {EDITABLE}>{ADRESA_FIRMA}</textarea></td>
							 </tr>
							<tr> 
									<td class="text2">Cod postal adresa firma </td>
									<td ><input name="zip_code2"  size="6" id="zip" value="{ZIP_CODE}" type="text" {EDITABLE}></td>
								</tr>
							<tr> 
								<td class="text2" colspan="2"><br /><br />Factura se va emite pe numele si adresa firmei complectate mai sus.</td>
							</tr> 
					</table>
				</div>

			</td>
		</tr>
	</table>
</div>

<table border='0' width='100%' align='center' cellspacing='1' cellpadding='1' class="big_table form">
<tr> 
		<td class="row1" colspan="2" style="text-align:right;color:#A60000;font-size:14px;"><b>COST PROMOVARE</b>: <div id="cost_promovare" style="display:inline;">{COST_PROMOVARE}</div> RON
			<div id="discount_abonament">
				<div style="text-align:right;font-size:14px;">Discount: <div id="discount_procent" style="display:inline;">{DISCOUNT_PR}</div></div>
				<div style="text-align:right;color:#A60000;font-size:14px;"><b>COST FINAL PROMOVARE</b>: <div id="cost_final_promovare" style="display:inline;">{COST_FINAL}</div></div>
			</div>
		</td>
</tr>
	<tr> 
			<td class="row1" colspan="2" style="text-align:center;"><input name="Submit" value="Alege" type="submit" class="button"></td>
	</tr>
</table>
<br>
<p style="color:red">
****  <b>{EMAIL_FACTURA}</b> factura proforma  va fi trimisa  la acesta adresa de e-mail. Va rugam verificati si in folderul SPAM si marcati ca NOTSPAM.</p>
<!-- **** Pentru fiecare cabinet deja adaugat, ce foloseste tipul de promovare ABONAMENT, ve-ti primi un <b>DISCOUNT</b> de {ABONAMENT_DISCOUNT_PROCENTAJ}%. -->
<br>
<table border="0" cellspacing="1" cellpadding="4" width="100%" class="big_table form">
<tr>
	<td class="table_subhead"><b>Ajutor pentru dvs.</b></td>
</tr>
<tr>
	<td>
			<li>Completarea campurilor  cu * este obligatorie!</li>
			<li>Detalii <a href="http://www.dentistonline.ro/admin_utilizator/?page=user.publicitate#abonament" target="_blank" title="Alege promovarea care te avantajeaza!!">[ <b>ABONAMENT</b> ]</a> - Detalii <a href="http://www.dentistonline.ro/admin_utilizator/?page=user.publicitate#recomandat" target="_blank" title="Alege promovarea care te avantajeaza!!">[ <b>RECOMANDAT</b> ]</a> </li>
			<li>Datele ce tin de emitere factura sunt strict confidentiale, fiind necesare pentru emiterea facturi.</li>
			<li><b>Email</b> - aici se va trimite factura proforma generata </li>
			<li>Accesand <a href="http://www.dentistonline.ro/admin_utilizator/?page=user.facturiproforme">[ <b>FACTURI</b> ]</a> din meniul principal - se vor afisa toate facturile emise pentru dvs. </li>
			<li>Dupa ce vom avea confirmarea platii,firma dvs va beneficia de serviciile oferite in pachetele de promovare.</li>
			<li>Pentru informatii suplimentare<a href="http://www.dentistonline.ro/admin_utilizator/?page=user.publicitate" target="_blank">[ click aici ]</a> sau ne puteti contacta la adresa: admin@dentistonline.ro</li>
		
	</td>
</tr>
</table>
