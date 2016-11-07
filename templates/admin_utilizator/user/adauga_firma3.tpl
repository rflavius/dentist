
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
		// if we clicked on the gratuit radio button
		if(document.adauga_firma.selected_level.value=='1')
		{
			document.getElementById('cost_promovare').innerHTML = 0;
			document.getElementById('cost_final_promovare').innerHTML = "0 RON";
			document.adauga_firma.cost_final.value = 0;
			document.adauga_firma.cost_abonament.value = 0;
			document.adauga_firma.cost_recomandat.value = 0;
			document.adauga_firma.selected_cost_recomandat.value = 0;
			document.adauga_firma.selected_cost_abonament.value = 0;
			document.getElementById('view_abonament').style.display = 'none';
		//document.getElementById('discount_abonament').style.display = 'none';
		}
		else
		{
			document.getElementById('cost_promovare').innerHTML = cost_recomandat;
			document.getElementById('cost_final_promovare').innerHTML = cost_recomandat+" RON";
			document.adauga_firma.cost_final.value = Number(0) + Number(cost_recomandat);
			document.adauga_firma.cost_abonament.value = 0;
			document.adauga_firma.selected_cost_abonament.value = 0;
		}
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

function makeDefault()
{
	document.getElementById('view_abonament').style.display = 'block';
	document.getElementById('discount_abonament').style.display = 'block';

	discount_procent = document.adauga_firma.abonament_nr.value*document.adauga_firma.abonament_discount_procentaj.value;
	discount_val = (200*discount_procent)/100;
	final_cost = 200-discount_val;

	document.getElementById('discount_procent').innerHTML = discount_procent+"%";
	document.getElementById('cost_promovare').innerHTML = '200';
	document.getElementById('cost_final_promovare').innerHTML = final_cost+" RON";
	document.adauga_firma.cost_final.value = final_cost;
}





function AddAjaxAbonamentCost(val)
{
	var url="index.php?page=ajax&type=abonament";
	url=url+"&level="+val;
	var target = 'cost_final_promovare';
	var myAjax = new Ajax.Updater(target, url, {	method: 'get'});
	$('loading').show();
	$(target).hide();
	var myAjax = new Ajax.Updater(target, url, { method: 'get', onSuccess:											function(){
									$('loading').hide();
									$(target).show();
									}
								
								});

}

function AddAjaxRecomandCost(val)
{
	var url="index.php?page=ajax&type=recomand";
	url=url+"&level="+val;
	var target = 'cost_final_promovare';
	var myAjax = new Ajax.Updater(target, url, {	method: 'get'});
	$('loading').show();
	$(target).hide();
	var myAjax = new Ajax.Updater(target, url, { method: 'get', onSuccess:											function(){
									$('loading').hide();
									$(target).show();
									}
								
								});

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
<!-- BEGIN error -->
<br>
<table border='0' width='100%' align='center' cellspacing='0' cellpadding='0' class="error">
<tr>
	<td>{ERROR_MSG}</td>
</tr>
</table>

<br><!-- END error -->

<br>
<form name="adauga_firma" method="post" action="{INSERT_FIRMA3}" enctype="multipart/form-data" >
<input type="hidden" name="selected_level" value="">

<input type="hidden" name="selected_cost_abonament" value="{SELL_COST_ABONAMENT}">
<input type="hidden" name="selected_cost_recomandat" value="{SELL_COST_RECOMANDAT}">

<input type="hidden" name="cost_final" value="{SEL_COST_FINAL}">
<input type="hidden" name="cost_abonament" value="0">
<input type="hidden" name="cost_recomandat" value="0">
<input type="hidden" name="abonament_nr" value="{ABONAMENT_NR}">
<input type="hidden" name="abonament_discount_procentaj" value="{ABONAMENT_DISCOUNT_PROCENTAJ}">
<table border="0" cellpadding="4" cellspacing="1" width="100%" class="big_table form">
	<tr> 
		<td colspan="2" class="table_subhead">Finalizare  - Alege promovarea care te avantajeaza</td>
	</tr>

	<tr>
			<td colspan="2" class="row1"><p><br><b>Gratuit</b>&nbsp;&nbsp;<input type="radio" name="level" value="1" onClick="ViewAbonamentDiv2(this.value);">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Abonament - Recomandat</b>&nbsp;&nbsp;<input type="radio" name="level" value="2" onClick="ViewAbonamentDiv2(this.value);" checked> <a href="http://www.dentistonline.ro/admin_utilizator/?page=user.publicitate" target="_blank" style="display:inline-block;padding-left:200px;float:right;margin:0px;padding:0px;font-weight:bold;">[ NU stii ce sa alegi ?]</a></p></td>
		</tr>
</table>

<div id="view_abonament">
	<table border='0' width='100%' align='center' cellspacing='1' cellpadding='1' class="big_table form">
		<tr> 
			<td class="row2" width="300">Abonament</td>
			<td class="row2">
				<select name="perioada">
					<option value="1" selected onclick="AddAjaxAbonamentCost('1');">Alege optiunea</option>
					<option value="2" {SELECTED_2} onclick="AddAjaxAbonamentCost('2');">12 luni ---- pret {PRET_UN_AN} RON</option>
					<option value="1" {SELECTED_1} onclick="AddAjaxAbonamentCost('1');">NU</option>
				</select>
				<p align="right" style="display:inline;padding-left:230px;">
				Detalii <a href="http://www.dentistonline.ro/admin_utilizator/?page=user.publicitate#abonament" target="_blank" title="Alege promovarea care te avantajeaza!!">[ <b>ABONAMENT</b> ]</a></p>
			</td>
		</tr>
		<tr> 
			<td class="row1">Recomandat pe judetul meu<p></td>
			<td class="row1">
				<select name="recomandata" onChange="AddAjaxRecomandCost(this.value);">
					<option value="N" selected>Alege optiunea</option>
					<option value="6" {SELECTED_6}>6 luni ---- pret 240RON</option>
					<option value="5" {SELECTED_5}>12 luni ---- pret 400RON</option>
					<option value="N" {SELECTED_N}>NU</option>
				</select>
				<p align="right" style="display:inline;padding-left:230px;">Detalii <a href="http://www.dentistonline.ro/admin_utilizator/?page=user.publicitate#recomandat" target="_blank" title="Alege promovarea care te avantajeaza!!">[ <b>RECOMANDAT</b> ]</a></p>
			</td>
		</tr>

		<tr> 
      <td class="row2">Emitere factura pe: <span>*</span></td>
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
		<td class="row1" colspan="2" style="text-align:right;color:#A60000;font-size:14px;"><div id="discount_abonament">
				<div style="text-align:right;font-size:14px;">Discount: <div id="discount_procent" style="display:inline;">{DISCOUNT_PR}</div></div>
				<div style="text-align:right;color:#A60000;font-size:14px;"><b>COST FINAL PROMOVARE</b>: <div id="loading" style="display:none;text-decoration:blink;color:#41A7D8;font-size:12px;"><b>Va rugam asteptati pana se calculeaza costul final!</b></div><div id="cost_final_promovare" style="display:inline-block;">{COST_FINAL}</div></div>
			</div>
		</td>
</tr>
	<tr> 
			<td class="row1" colspan="2" style="text-align:center;"><input name="Submit" value="Finalizare" type="submit" class="button"></td>
	</tr>
</table>
<br>
<p style="color:red;">**** Pentru fiecare cabinet deja adaugat, ce foloseste tipul de promovare ABONAMENT, ve-ti primi un <b>DISCOUNT</b> de {ABONAMENT_DISCOUNT_PROCENTAJ}%.</p>
<table border="0" cellspacing="1" cellpadding="4" width="100%" class="big_table form">
<tr>
	<td class="table_subhead"><b>Ajutor pentru dvs.</b></td>
</tr>
<tr>
	<td>
			
				<li>Daca alegeti planul de promovare <b>GRATUIT</b> doar accesati <b>Finalizare</b>  si firma dvs. va fi inregistrata pe Dentistonline, dar va fi inactiva.</li> 
				<li>Dupa ce informatiile adaugate de dvs. vor fi verificate vom realiza activarea firmei dvs.</li>
				<br>
				<li>Daca alegeti <b>ABONAMENT - RECOMANDAT</b> va trebui sa completati informatiile pentru generarea facturii proforme. </li>
				<li>Datele ce tin de emitere factura sunt strict confidentiale, fiind necesare pentru emiterea facturi.</li>
				<li>Completarea campurilor  cu * este obligatorie!</li>
				<li>Detalii <a href="http://www.dentistonline.ro/admin_utilizator/?page=user.publicitate#abonament" target="_blank" title="Alege promovarea care te avantajeaza!!">[ <b>ABONAMENT</b> ]</a> - Detalii <a href="http://www.dentistonline.ro/admin_utilizator/?page=user.publicitate#recomandat" target="_blank" title="Alege promovarea care te avantajeaza!!">[ <b>RECOMANDAT</b> ]</a> </li>
				<li>Vi se va emite o factura proforma pe adresa de e-mail: <b>{EMAIL_FACTURA}</b>. </li>
				<li>Accesand <a href="http://www.dentistonline.ro/admin_utilizator/?page=user.facturiproforme">[ <b>FACTURI</b> ]</a> din meniul principal - se vor afisa toate facturile emise pentru dvs. </li>
				<li>Dupa ce vom avea confirmarea platii vom activa firma dumneavoastra, in caz contrar va fi trecuta in planul de promovare GRATUIT.</li>
				<li>Pentru informatii suplimentare<a href="http://www.dentistonline.ro/admin_utilizator/?page=user.publicitate" target="_blank">[ click aici ]</a> sau ne puteti contacta la adresa: admin@dentistonline.ro</li>
		
	</td>
</tr>
</table>

