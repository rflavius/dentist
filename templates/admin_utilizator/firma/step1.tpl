<div class='row col-sm-12'>
	<ul class="nav nav-tabs">
		<li class="active"><a data-toggle="tab" href="#step1">Detalii firma</a></li>
		<li><a data-toggle="tab" href="#step2">Servicii & Media</a></li>
		<li><a data-toggle="tab" href="#step3">Finalizare</a></li>
	</ul>
	
	<div class="tab-content">
		<div id="step1" class="tab-pane fade in active">
			<h3>HOME</h3>
			<p>Some content.</p>
		</div>
		<div id="step2" class="tab-pane fade">
			<h3>Menu 1</h3>
			<p>Some content in menu 1.</p>
		</div>
		<div id="step3" class="tab-pane fade">
			<h3>Menu 2</h3>
			<p>Some content in menu 2.</p>
		</div>
	</div>
</div>



<div class="steps">
	<span class="step1_active"></span>
	<span class="step2_inactive"></span>
	<span class="step3_inactive"></span>
	<div style="color: #255A82;font-size:16px;">
		<p style="float:left;">Detalii firma & Localizare</p>
		<p style="float:left;margin-left:250px;">Servicii si Tarife & Galerie Imagini & Video</p>
		<p style="float:right;">Finalizare</p>
	</div>
</div>
<br>
{ERROR_MSG}
<br>
<!-- BEGIN ADD_FIRM_BLOCK -->
<form name="adauga_firma" method="post" action="{INSERT_FIRMA}" enctype="multipart/form-data">
<input type='hidden' name='lat' id='lat' value=''>
<input type='hidden' name='lng' id='lng' value=''>
<table border="0" cellpadding="4" cellspacing="1" width="100%" class="big_table form">
 <tr> 
	<td colspan="2" class="table_subhead">Detalii firma</td>
</tr>
<tr> 
	<td colspan="2"> Exemplul adaugare firma, click [ <a href="{DETALIIADAUGAFIRMA}"><b>aici</b></a> ]</td>
</tr>
<tr> 
	<td class="row1" width="300">Categoria : <span>*</span></td>
		<td class="row1">
				<select name="category_id" >
					<option value="">--------------------- Alege --------------------</option>
					<!-- BEGIN display_cats -->
					<option value="{CAT_ID}" {SELECTTEDCAT}>{CAT_NAME}</option>
					<!-- END display_cats -->
				</select>
	</td>
</tr>
<tr> 
		<td class="row1">Numele firmei <span>*</span></td>
		<td class="row1"><input name="nume_firma" size="43"  value="{NUME_FIRMA}" type="text"></td>
</tr> 
<tr> 
	<td class="row1">Judet <span>*</span></td>
	<td class="row1">
			<select name="judet" id="judetselected" onchange="CompleteLocalitateFirma();" class="select_option_style" >
					<option value="">Alege Judet</option>
				<!-- BEGIN judet -->
				<option value="{COD_JUDET}" {SELECTTEDJUDET}>{NUMEJUDET}</option>
				<!-- END judet -->
			</select>
	</td>
</tr>
<tr> 
	<td class="row1">Localitate <span>*</span></td>
	<td class="row1">
		<div id="localitate_ajax_addfirm" >
		{LOC_DIV_ADAUGAFIRMA}
		</div>
	</td>
</tr>
<tr>
	<td class="row1"> Adresa <span>*</span><br><i>Puteti furniza anumite puncte de reper pentru a facilita gasirea locatiei.</i></td>
	<td class="row1"> <textarea name="adresa_firma" rows="5" cols="40"  >{ADRESA_FIRMA}</textarea><br /></td>
</tr>
<tr> 
	<td class="row1">Telefon/ Fax/ Mobil</td>
	<td class="row1"><input name="fax" id="fax" value="{FAX}" size="43" type="text"></td>
</tr>
<tr> 
	<td class="row1">E-mail <br /> </td>
	<td class="row1"><input name="email_firma" maxlength="100" size="43" value="{EMAIL_FIRMA}" type="text"></td>
</tr>
<tr> 
	<td class="row1"><b>Adresa WEB</b> <br /> ex: http://www.dentistonline.ro</td>
	<td class="row1"><input name="adresa_web" maxlength="100" size="43" value="{ADRESA_WEB}" type="text"></td>
</tr>
<tr> 
	<td class="row1">Persoana de contact <span>*</span></td>
	<td class="row1"><input name="pers_contact" size="43" value="{PERS_CONTACT}" type="text"></td>
</tr>
<tr> 
	<td class="row1">E-mail Persoana de contact <span>*</span></td>
	<td class="row1"><input name="persc_email" size="43"  value="{PERSC_EMAIL}" type="text"></td>
</tr>
<tr> 
	<td colspan="2" class="table_subhead">Localizare pe harta</td>
</tr>
<tr> 
	<td class="row1"> Adresa localizare<span>*</span></td>
	<td class="row1"> 
		<input type='text' name="address" size='60' id='address' value='{ADRESA_FIRMA}' placeholder='Ex: Bucuresti, str. Victoriei, nr. 32A'> <input name="check_address" value="Verifica" type="button" class="button" onClick='codeAddress()'>
	</td>
</tr>
<tr>
	<td colspan='2' class='row1'>
		Va rugam sa faceti click pe butonul "Verifica" dupa complectarea campului adresa, pentru pozitionarea pe harta. 
		<br><font style='font-size:20px;font-weight:bold;color:red;'>!</font>  Puteti modifica pozitia, miscand marker-ul pozitiei dvs folosind mouse-ul, pentru a corecta pozitia.
	</td>
</tr>
<tr>
	<td colspan='2'><div id="map-canvas" style="width: 100%; height: 300px;"></div></td>
</tr>

</table>




<table border='0' width='100%' align='center' cellspacing='0' cellpadding='0'>
<tr> 
	<td class="row1" colspan="2" style="text-align:center;"><input name="Submit" value="Pasul urmator" type="submit" class="button"></td>
</tr>
</table>

<br>
<br>


<table border="0" cellspacing="1" cellpadding="4" width="100%" class="big_table form">
<tr>
	<td class="table_subhead"><b>Ajutor pentru dvs.</b></td>
</tr>
<tr>
	<td>
		<li>Completarea campurilor  cu * este obligatorie!</li>
		<li>Completarea campurilor <b>Email, E-mail Persoana de contact</b> este importanta, aici ve-ti primi mesaje, se vor face programari de catre vizitatori.</li> 
		<li>Extensiile acceptate pentru imagini sunt jpg, jpeg, png, gif. </li>
		<li>Daca ati adaugat imagini, dupa acesare "Pasul urmator" va rugam sa asteptati pana salvarea imaginilor are loc. </li>
	</td>
</tr>
</table>
<!-- END ADD_FIRM_BLOCK -->

<table border="0" cellspacing="0" cellpadding="0">
<tr>
	<td>{MAX_CABINTE_REACH}</td>
</tr>
</table>
</form>

<!-- BEGIN fara_cabinet -->
<table border="0" cellpadding="4" cellspacing="1" width="100%" class="big_table form">
 <tr> 
	<td colspan="2" class="table_subhead">{USERNAME} promoveaza-ti imaginea in universul Internetului </td>
</tr>
<tr>
	<td> <b>Promoveaza-ti GRATUIT cabinetul</b>, clinica, laboratorul, depozitul de materiale stomatologice</td>
</tr>
<tr>
	<td><b> [ <a href="?page=user.addanunt">Adauga anunturi de ultima ora</a> ] </b>  - cu produsele, serviciile, facilitatile oferite de dvs.</td>
</tr>
<tr>
	<td><b>[ <a href="?page=user.listarticole">Publicati articole extraordinare</a> ]</b> din domeniul medical.</td>
</tr>
</table>
<!-- END fara_cabinet -->
