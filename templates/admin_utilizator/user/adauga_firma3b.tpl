<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>

<script language="javascript" type="text/javascript">

$(document).ready(function()
{
	$("#firma_step3").validate();
	// this is the first time we load the page
	if(document.adauga_firma.cost_final.value=="") $("#freeModal").modal();
});



function AddAjaxAbonamentCost(pachet, months)
{
	var target = 'cost_final_promovare';
	if(pachet=="") pachet = document.adauga_firma.selected_level.value;
	if(months=="") months = document.adauga_firma.perioada.value;

	document.adauga_firma.selected_level.value = pachet;
	$.ajax({
		type: "GET",
		dataType: "json",
		url: "index.php",
		async: true,
		cache: false,
		data: {page: 'ajax', type: 'amount', level: pachet, perioada: months},
		beforeSend: function()
		{
			$("#loading").removeClass("hide").addClass("show");
		},
		success: function(html)
		{
			$("#loading").removeClass("show").addClass("hide");
			var parsedJson = JSON.parse(JSON.stringify(html));
			document.adauga_firma.cost_final.value = parsedJson.amount;
			if(document.adauga_firma.cost_final.value != '0')
			{
				$('#factura_details').removeClass("hide").addClass("show");
			}
			else
			{
				$("#freeModal").modal();
				$('#factura_details').removeClass("show").addClass("hide");
				document.getElementById("firma_div").style.display = 'none';
				document.getElementById("persoana_fizica_div").style.display = 'none';
			}
			
			$('#promovare_discount').html(parsedJson.text);
			$("#"+target).html(parsedJson.amount+" RON");
		}
	});
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

//-->
</script>

<!-- Modal for FREE selected package -->
<div id="freeModal" class="modal fade modal_popup" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">DentistOnline.ro platforma stomatologica nr.1 din Romania!</h4>
			</div>
			<div class="modal-body">
				<div class='text-center'>
					<h2>Alege BUSINESS pentru imaginea ta !</h2>
				</div>
				<div class='clearfix'>&nbsp;</div>
				<br>
				<div class='row text-center'>
					<div>
						<img src='{SITE_BASE}/images/popup_oferta.jpg' class='img-thumbnail img-responsive'>
					</div>
				</div>
				<!-- 
				<div class='row'>
					<div class='col-sm-3'><br><span class='glyphicon glyphicon-gift' style='font-size:5em;color:#FFED3D;'></span></div>
					<div class='col-sm-9 text-center'>
						<br>
						<h4>ACUM REDUCERE 40% pentru oricare dintre pachetele de promovare BUSINESS, PREMIUM !</h4>
					</div>
				</div>
				<div class='clearfix'>&nbsp;</div>
				<br> -->
				
				<div class='row'>
					
					<span class="col-xs-12 col-md-6 text-center">
						<p class="lead orange_title">GRATUIT</p>
						<img class="img-responsive" title="exemplu pachet gratuit" alt="exemplu pachet gratuit" src="{SITE_BASE}/images/pachete_preview/gratuit.png">
					</span>
					<span class="col-xs-12 col-md-6 text-center">
						<p class="lead orange_title">BUSINESS</p>
						<img class="img-responsive" title="exemplu pachet business" alt="exemplu pachet business" src="{SITE_BASE}/images/pachete_preview/business.png">
					</span>
				</div>
			</div>
		</div>
	</div>
</div>


{ERROR_MSG}
<br>
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
<br>
<div class='clearfix'></div>
<form name="adauga_firma" method="post" action="{INSERT_FIRMA3}" enctype="multipart/form-data" id='firma_step3' novalidate="novalidate">
<input type="hidden" name="cost_final" value="{SEL_COST_FINAL}">
<input type="hidden" name="selected_level" value="{DEFAULT_LEVEL}">
<table border="0" cellpadding="4" cellspacing="1" width="100%" class="big_table form">
	<tr> 
		<td colspan="4" class="table_subhead">Finalizare  - Alege promovarea care te avantajeaza</td>
	</tr>
	<tr>
		<!-- BEGIN list_pachete -->
		<td class="row1" style='text-align:center;background:#D6F4FF;border:1px solid #ACDBED;'>
			<p><b>{PACHET}</b><p>
			<p>{PACHET_PRICE} RON/luna<br><input type="radio" name="level" value="{PACHET_ID}" onClick="AddAjaxAbonamentCost(this.value,'')" {PACHET_SELL}></p>
			<p>{PACHET_OFERTA}<a href="{SITE_BASE}/admin_utilizator/?page=user.publicitate#{PACHET_HASHTAG}" target="_blank">[ Detalii pachet ]</a></p>
		</td>
		<!-- END list_pachete -->
		<td class="row1" style='text-align:center;background:#D6F4FF;border:1px solid #ACDBED;' width='24%'>
			<p><b>Promovare BANNER</b><p>
			<p>Pentru detalii ne puteti contacta prin email la: admin@dentistonline.ro, sau telefonic la: 0727.380.368 .</p>
			<p><a href="{SITE_BASE}/admin_utilizator/?page=user.publicitate#bannere" target="_blank">[ Detalii pachet ]</a></p>
		</td>
		
	</tr>
</table>

<div id="view_abonament">
	<table border='0' width='100%' align='center' cellspacing='1' cellpadding='1' class="big_table form">
		<tr> 
			<td class="row2" width='50%' style='text-align:center;'>
				Perioada: <span>*</span>&nbsp;
				<select name="perioada" id='perioadaPachet' onChange='AddAjaxAbonamentCost("", this.value)' >
					<option value=""> - - - - - - - - - - </option>
					<!-- BEGIN list_perioada -->
					<option value="{PERIOADA}" {PERIOADA_SELL}>{PERIOADA_VALUE}</option>
					<!-- END list_perioada -->
				</select>
			</td>
			<td class="row2" style='text-align:center;'>
				<div id='factura_details' class='hide'>
				Emitere factura pe: <span>*</span>&nbsp;
				<select name="type" onchange="loadform(this.value);" title='Emitere factura pe ?' required>
					<option value="" selected>Alegeti</option>
					<option value="persoana_fizica" >Persoana fizica</option>
					<option value="firma" >Firma</option>
				</select>
				</div>
			</td>
		</tr>
		<tr>
			<td colspan="2" align="center" class="row2">
				<div id="persoana_fizica_div" style="display:none;">
					<table border="0" cellspacing="1" cellpadding="4" class="table_border" width="100%">
						<tr> 
							<td class="text2" width="30%"> CNP <span>*</span></td>
								<td> <input name="cnp" size="40" value="{CNP}" type="text" {EDITABLE} title='Va rugam sa introduceti CNP-ul dvs.' required></td>
						</tr>
						<tr> 
							<td class="text2">Adresa <span>*</span></td>
							<td><textarea name="persc_adresa" rows="5" cols="30" {EDITABLE} title='Ati uitat sa introduceti adresa.' required>{PERSC_ADRESA}</textarea></td>
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
								<td> <input name="cui" size="40" value="{CUI}" type="text" {EDITABLE} title='Va rugam sa introduceti CUI.' required></td>
							</tr>
							<tr> 
								<td class="text2">Registru comertului<span>*</span></td>
								<td><input name="reg_comert_bi" maxlength="100" size="40" value="{REG_COMERT_BI}" type="text" {EDITABLE} title='Va rugam sa introduceti Nr. Registrul Comertului.' required></td>
							</tr> 
								<tr> 
									<td class="text2">Adresa <span>*</span></td>
									<td><textarea name="adresa_firma" rows="5" cols="30" {EDITABLE} title='Ati uitat sa specificati adresa.' required>{ADRESA_FIRMA}</textarea></td>
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
		<td class="row1" colspan="2" style="text-align:right;color:#A60000;font-size:14px;">
			<div id="discount_abonament">
				<div id="promovare_discount" style="text-align:right;color:blue;font-size:14px;"></div>
				<button id='loading' class='btn btn-warning hide'><span class='glyphicon glyphicon-refresh'></span>&nbsp;Se calculeaza pretul ...</button>
				<div style="text-align:right;color:#A60000;font-size:14px;vertical-align:bottom;">
					<b>COST FINAL PROMOVARE</b>:
					<div id="cost_final_promovare" style="display:inline-block;">
						{COST_FINAL}
					</div>
				</div>
			</div>
		</td>
	</tr>
	<tr> 
		<td class="row1" colspan="2" style="text-align:center;"><input name="Submit" value="Finalizare" type="submit" class="button" id='finalButton'></td>
	</tr>
</table>
<br>
<table border="0" cellspacing="1" cellpadding="4" width="100%" class="big_table form">
<tr>
	<td class="table_subhead"><b>Ajutor pentru dvs.</b></td>
</tr>
<tr>
	<td>
		<li>Daca alegeti planul de promovare <b>GRATUIT</b> doar accesati <b>Finalizare</b>  si firma dvs. va fi inregistrata pe Dentistonline, dar va fi inactiva.</li> 
		<li>Dupa ce informatiile adaugate de dvs. vor fi verificate vom realiza activarea firmei dvs.</li>
		<br>
		<li>Daca alegeti <b>BUSINESS / RECOMANDAT</b> va trebui sa completati informatiile pentru generarea facturii proforme. </li>
		<li>Datele ce tin de emitere factura sunt strict confidentiale, fiind necesare pentru emiterea facturi.</li>
		<li>Completarea campurilor  cu * este obligatorie!</li>
		<li>Vi se va emite o factura proforma pe adresa de e-mail: <b>{EMAIL_FACTURA}</b>. </li>
		<li>Accesand <a href="http://www.dentistonline.ro/admin_utilizator/?page=user.facturiproforme">[ <b>FACTURI</b> ]</a> din meniul principal - se vor afisa toate facturile emise pentru dvs. </li>
		<li>Dupa ce vom avea confirmarea platii vom activa firma dumneavoastra, in caz contrar va fi trecuta in planul de promovare GRATUIT.</li>
		<li>Pentru informatii suplimentare<a href="http://www.dentistonline.ro/admin_utilizator/?page=user.publicitate" target="_blank">[ click aici ]</a> sau ne puteti contacta la adresa: admin@dentistonline.ro</li>
	</td>
</tr>
</table>

