<script src="{SITE_BASE}/resources/plugins/validator/jquery.validate.js" type="text/javascript"></script>
<script src="{SITE_BASE}/resources/jquery/jquery_mask.min.js" type="text/javascript"></script>

<div class='col-sm-12' id="new_contract">
	<div style='position:fixed;top:40%;left:50%;padding:15px 30px;background:white;border:2px solid #DDDDDD;border-radius:6px;z-index:100;' id='newContractLoading' class='hide'>
		<span><img src='{SITE_BASE}/images/admin/crontab_loader.gif'></span>
		<span style='font-size:16px; color:#337AB7;padding-left:10px;line-height:31px;'>Va rugam asteptati ...</span>
	</div>
	
	<ul class="nav nav-tabs">
		<li id='tab1'><a data-toggle="tab" data-div='step1' href="#step1">Info firma</a></li>
		<li id='tab2'><a data-toggle="tab" data-div='step2' href="#step2">Servicii & Media</a></li>
		<li id='tab3'><a data-toggle="tab" data-div='step3' href="#step3">Finalizare</a></li>
	</ul>
	<form name="adauga_firma" method="post" action="{INSERT_FIRMA}" enctype="multipart/form-data" class='form' id="orderForm">
		<input type='hidden' name='current_step' id='current_step' value='1'>
		<input type="hidden" name="cost_final" value="{SEL_COST_FINAL}">
		<input type="hidden" name="selected_level" value="{DEFAULT_LEVEL}">
		
		<div class="tab-content">
			<div id="step1" class="tab-pane fade in active">
				<div class="page-header">
					<h3>Info firma</h3>
				</div>
				<div class='col-sm-12 lead'>
					<i class="fa fa-question-circle" aria-hidden="true" style='font-size:24px;'></i>&nbsp;Ai nevoie de ajutor? Vezi exemplul adaugare firma, [ <a href="{DETALIIADAUGAFIRMA}"><b>click aici</b></a> ]
				</div>
				<div class='clearfix'>&nbsp;</div>
				<div class='jumbotron'>
					<div class='form-group'>
						<div class='col-sm-6'>
							<label>Categoria *</label>
							<select name="category_id" class='form-control' required>
								<option value="">--------------------- Alege --------------------</option>
								<!-- BEGIN display_cats -->
								<option value="{CAT_ID}" {SELECTTEDCAT}>{CAT_NAME}</option>
								<!-- END display_cats -->
							</select>
						</div>
						<div class='col-sm-6'>
							<label>Numele firmei *</label>
							<input name="nume_firma" size="43"  value="{NUME_FIRMA}" type="text" class='form-control' required placeHolder="Numele unitatii dvs ...">
						</div>
					</div>
					<div class='clearfix'>&nbsp;</div>
					<div class='form-group'>
						<div class='col-sm-6'>
							<label>Judet *</label>
							<select name="judet" id="judetselected" onchange="CompleteLocalitateFirma(this.value);" class="form-control" required>
								<option value="">Alege Judet</option>
								<!-- BEGIN judet -->
								<option value="{COD_JUDET}" {SELECTTEDJUDET}>{NUMEJUDET}</option>
								<!-- END judet -->
							</select>
						</div>
						<div class='col-sm-6'>
							<label>Localitate *</label>
							<div id="localitate_ajax_addfirm" >
								<select name="localitate" class="form-control" required>
									<option value="">Alege Localitatea</option>
								</select>
							</div>
						</div>
					</div>
					<div class='clearfix'>&nbsp;</div>
					<div class='form-group'>
						<div class='col-sm-12'>
							<label>Adresa *</label>
							<textarea name="adresa_firma" rows="5" class='form-control' required placeHolder="Adresa unitatii ...">{ADRESA_FIRMA}</textarea>
							<i>Puteti furniza anumite puncte de reper pentru a facilita gasirea locatiei.</i>
						</div>
					</div>
					<div class='clearfix'>&nbsp;</div>
					<div class='form-group'>
						<div class='col-sm-12'>
							<label>Imagine Localizare</label>
							<input type="file" name="picture_harta">
						</div>
					</div>
					<div class='clearfix'>&nbsp;</div>
					<div class='form-group'>
						<div class='col-sm-4'>
							<label>Telefon/ Fax/ Mobil</label>
							<input name="fax" id="fax" value="{FAX}" type="text" class='form-control' placeHolder="Telefon/Fax/Mobil ...">
						</div>
						<div class='col-sm-4'>
							<label>E-mail</label>
							<input name="email_firma" maxlength="100" value="{EMAIL_FIRMA}" type="email" class='form-control' placeHolder="Adresa email ...">
						</div>
						<div class='col-sm-4'>
							<label>Adresa WEB</label>
							<input name="adresa_web" maxlength="100" value="{ADRESA_WEB}" type="url" class='form-control'  placeHolder="Adresa web ...">
						</div>
					</div>
					<div class='clearfix'>&nbsp;</div>
					<div class='form-group'>
						<div class='col-sm-6'>
							<label>Persoana de contact *</label>
							<input name="pers_contact" value="{PERS_CONTACT}" type="text" class='form-control' required placeHolder="Numele persoanei de contact ...">
						</div>
						<div class='col-sm-6'>
							<label>E-mail Persoana de contact*</label>
							<input name="persc_email" value="{PERSC_EMAIL}" type="email" class='form-control' required placeHolder="Email persoana de contact ...">
						</div>
					</div>
					<div class='clearfix'>&nbsp;</div>
					<div class='form-group'>
						<div class='col-sm-12 text-center'>
							<br>
							<br>
							<button name="Submit" type="button" class="btn btn-default btn-lg" onClick="nextStep('1', false)">
								<i class="fa fa-angle-double-right" aria-hidden="true" style='font-size:22px;'></i>&nbsp;Pasul urmator
							</button>
						</div>
					</div>
					<div class='clearfix'>&nbsp;</div>
				</div>
			</div>
			<div id="step2" class="tab-pane fade"></div>
			<div id="step3" class="tab-pane fade"></div>
		</div>
	</form>
</div>