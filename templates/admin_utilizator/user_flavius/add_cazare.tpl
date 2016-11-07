<script type="text/javascript" src="{SITE_BASE}/templates/js/prototype.js"></script>
<script type="text/javascript" src="{SITE_BASE}/templates/js/mini/overlib.js"></script>
<script type="text/javascript" src="{SITE_BASE}/templates/js/mini/overlib_mini.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="{SITE_BASE}/templates/js/calendar-win2k-cold-1.css" title="blue">
<script type="text/javascript" src="{SITE_BASE}/templates/js/calendar.js"></script>
<script type="text/javascript" src="{SITE_BASE}/templates/js/calendar-en.js"></script>
<script type="text/javascript" src="{SITE_BASE}/templates/js/calendar-setup.js"></script>

<script language="javascript" type="text/javascript">
<!--

function ListLocalitate(val)
{
	if(val!="")
	{
		var target ='localitate_ajax'; 
		var url="../sources/ajax.php?judet="+val;
		var myAjax = new Ajax.Updater(target, url, { method: 'get',
													onLoading: function(){
																			$('load').show();
																		},
													onCompleted: function(){
																			$('load').hide();
																		}
																		});
		$(target).show();
		$('not_localitate').hide();
	}
	else
	{
		alert('Va rugam sa selectati judetul !');
	}
}

function ValidateStep1()
{
	var expected = new Array("name","adresa","descriere","zona","judet");
	var error = 0;
	if(document.add_cazare.name.value=="")
	{
		alert('Va rugam sa complectati denumirea hotelului,vilei sau pensiunii !');
		error = 1;
	}
	if(document.add_cazare.adresa.value=="")
	{
		alert('Va rugam sa complectati adresa hotelului,vilei sau pensiunii !');
		error = 1;
	}
	if(document.add_cazare.descriere.value=="")
	{
		alert('Va rugam sa complectati descrierea hotelului,vilei sau pensiunii !');
		error = 1;
	}
	if(document.add_cazare.zona.value=="")
	{
		alert('Va rugam sa alegeti zona turistica a hotelului,vilei sau pensiunii !');
		error = 1;
	}
	if(document.add_cazare.judet.value=="")
	{
		alert('Va rugam sa alegeti judetul hotelului,vilei sau pensiunii !');
		error = 1;
	}

	if(error==0)
	{
		var target = 'step2';
		$(target).show();
	}
}

function ValidateStep2()
{
	ValidateStep1();
	// the rest of the function...
	var error = 0;

	if(document.getElementById('f_date_vv').value=="")
	{
		alert('Va rugam sa alegeti data de inceput a perioadei de cazare !');
		error = 1;
	}
	if(document.getElementById('f_date_bb').value=="")
	{
		alert('Va rugam sa alegeti data terminarii perioadei de cazare !');
		error = 1;
	}

	if(error==0)
	{
		$('step2').show();
		var target = 'step3';
		$(target).show();
	}
}

function ShowHelpWindow()
{
window.open("../templates/modules/user/showhelp.html", 'showhelp', 'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=640,height=600,left = 262,top = 84');
}

//-->
</script>

<h1>Adauga oferta de cazare</h1>
<form method="post" action="{USER_ADD_CAZARE}" name='add_cazare' ENCTYPE="multipart/form-data">
<div style="padding-left: 3px;" >
	{INFORMATION}
	<!-- BEGIN if_no_error -->
	<div class="step_number"><img src="{SITE_BASE}/images/step1.png" width="65" height="61" border="0" alt=""></div>
	<h2 class="step_title">Pasul 1: Informatii despre unitate</h2>

	<table border="0" cellspacing="1" cellpadding="0" width="100%" align="center" class="big_table form">
		<tr>
			<td colspan="2" class="row1"><b>Daca aveti nevoie de ajutor dati un click aici:</b> <a onclick="ShowHelpWindow()" style="cursor: pointer;color:#CC0000;"><b>EXEMPLU ADAUGARE UNITATE</b></a></td>
		</tr>
		<tr>
			<td class="row2" style="padding-left: 10px;" width="180">Denumire unitate :<b class="star">*</b></td>
			<td class="row2"><input type="text" name="name"  value="{NAME}" /><p class="red_text"><b>Nu folositi tipul unitatii in campul denumire, adica fara: Hotel, Pensiune, Vila, ... etc</b></p><b>ex: Continental</b></td>
		</tr>
		<tr>
			<td class="row1" style="padding-left: 10px;">Zona turistica :<b class="star">*</b></td>
			<td class="row1">
			<select name="zona">
				<option value="">- - - - - Alege Zona turistica - - - - - </option>
				<!-- BEGIN zona_list -->
				<option value="{ZONA}">{ZONA}</option>
				<!-- END zona_list -->
			</select>
			</td>
		</tr>
		<tr>
			<td class="row2"  style="padding-left: 10px;">Judet :<b class="star">*</b></td>
			<td class="row2">
			<select name="judet" onChange="ListLocalitate(this.value)">
				<option value="">- - - - - Alege Judetul - - - - - </option>
				<!-- BEGIN judet_list -->
				<option value="{JUDET_CODE}" >{JUDET}</option>
				<!-- END judet_list -->
			</select>
			</td>
		</tr>
		<tr>
			<td class="row1"  style="padding-left: 10px;">Localitate :<b class="star">*</b></td>
			<td class="row1">
				<div id="localitate_ajax" >
				{LOC_DIV}
				</div>
				<div id="not_localitate">
						<select name="">
							<option value=""> - - - - - - Selectati judetul prima data ! - - - - - </option>
						</select>
				</div>
			</td>
		</tr>
		<tr>
			<td class="row2" style="padding-left: 10px;">Categorie :<b class="star">*</b></td>
			<td class="row2">
			<select name="category">
				<!-- BEGIN cat_list -->
				<option value="{CAT}">{CAT}</option>
				<!-- END cat_list -->
			</select>
			</td>
		</tr>
		<tr>
			<td class="row1" style="padding-left: 10px;">Stele / Margarete :<b class="star">*</b></td>
			<td class="row1">
			<select name="star">
				<!-- BEGIN star_list -->
				<option value="{STAR}">{STAR}</option>
				<!-- END star_list -->
			</select>
			</td>
		</tr>
		<tr>
			<td class="row2" style="padding-left: 10px;">Persoana de contact :<b class="star">*</b></td>
			<td class="row2"><input type="text" name="pers_contact"  value="{PERS_CONTACT}"/></td>
		</tr>
		<tr>
			<td class="row1"  style="padding-left: 10px;">Adresa :<b class="star">*</b></td>
			<td class="row1"><textarea name="adresa" rows="3" cols="45">{ADRESA}</textarea></td>
		</tr>
		<tr>
			<td class="row2"  style="padding-left: 10px;">Telefon :</td>
			<td class="row2"><textarea name="telefon" rows="3" cols="45">{TELEFON}</textarea></td>
		</tr>
		<tr>
			<td class="row1"  style="padding-left: 10px;">Fax :</td>
			<td class="row1"><input type="text" name="fax"  value="{FAX}" /></td>
		</tr>
		<tr>
			<td class="row2"  style="padding-left: 10px;">E-mail :<b class="star">*</b></td>
			<td class="row2"><input type="text" name="email" value="{EMAIL}"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b  class="red_text">OBLIGATORIU : In cadrul acestei adrese veti primi cererile de rezervare !</b></td>
		</tr>
		<tr>
			<td class="row1"  style="padding-left: 10px;">WebSite :</td>
			<td class="row1"><input type="text" name="website"  value="{WEBSITE}"/></td>
		</tr>
		<tr>
			<td class="row2"  style="padding-left: 10px;" valign="top">Descriere :<b class="star">*</b></td>
			<td class="row2"><textarea name="descriere" rows="6" cols="45">{DESCRIERE}</textarea></td>
		</tr>
		<tr>
			<td class="row1"  style="padding-left: 10px;" valign="top"><b>Facilitati</b> :<b class="star">*</b></td>
			<td class="row1">
			<table border="0" cellspacing="2" cellpadding="3" width="100%">
			<!-- BEGIN facilitati_row -->
			<tr>
				<!-- BEGIN facilitati_item -->
				<td class="text" nowrap><input type="checkbox" name="facilitati[]" value="{FACIL_ID}" />&nbsp;&nbsp;{FACILITATE}</td>
				<!-- END facilitati_item -->
			</tr>
			<!-- END facilitati_row -->
			</table>
			</td>
		</tr>
		<tr>
			<td align="center" class="row2" colspan="2"><input type="button" class="button" value="Pas Urmator" onClick="ValidateStep1();"/></td>
		</tr>
	</table>
	<div id="step2" style="display: none;">
		<div class="step_number"><img src="{SITE_BASE}/images/step2.png" width="65" height="61" border="0" alt=""></div>
		<h2 class="step_title">Pasul 2: Pretul si perioada de cazare</h2>
		<table border="0" cellspacing="1" cellpadding="0" width="100%" align="center" class="big_table form">
		<tr>
			<td class="table_subhead" colspan="2"><b>Perioada de cazare</b></td>
		</tr>
		<tr>
			<td class="row1" align="center" nowrap>De la: &nbsp;&nbsp;&nbsp;
				<input type="text" name="start_date" id="f_date_vv" value="{STARTDATE}" size="10" >&nbsp;
				<b>Exemplu:</b> 2008-01-28
				<button type="reset" id="f_trigger_vv" class = 'calendar2'></button>
				<script type="text/javascript">
					Calendar.setup({
					inputField     :    "f_date_vv",      // id of the input field
					ifFormat       :    "%Y-%m-%d",       // format of the input field
					showsTime      :   false,            // will display a time selector
					 timeFormat     :    "24",
					button         :    "f_trigger_vv",   // trigger for the calendar (button ID)
					singleClick    :    false            // double-click mode
												});
				</script>
			</td>
			<td class="row1" align="center" nowrap>Pana la: &nbsp;&nbsp;&nbsp;
				<input type="text" name="end_date" id="f_date_bb" value="{ENDTDATE}" size="10" >&nbsp;
				<b>Exemplu:</b> 2008-03-28
				<button type="reset" id="f_trigger_bb" class = 'calendar2'></button>
				<script type="text/javascript">
					Calendar.setup({
					inputField     :    "f_date_bb",      // id of the input field
					ifFormat       :    "%Y-%m-%d",       // format of the input field
					showsTime      :   false,            // will display a time selector
					 timeFormat     :    "24",
					button         :    "f_trigger_bb",   // trigger for the calendar (button ID)
					singleClick    :    false            // double-click mode
												});
				</script>
			</td>
		</tr>
		<tr>
			<td class="row2" colspan="2"><b>Preturile sunt exprimate in:</b>&nbsp;&nbsp;&nbsp;<input type="radio" name="valuta" value="RON" checked />&nbsp;&nbsp;RON&nbsp;&nbsp;&nbsp;<input type="radio" name="valuta" value="EURO" />&nbsp;&nbsp;EURO</td>
		</tr>
		<tr>
			<td colspan="2" class="row1">
			<table border="0" cellspacing="0" cellpadding="0" width="90%" align="center" >
			<tr>
				<td class="table_content_border text" colspan="2" width="200">&nbsp;&nbsp;<b>Tip Camera</b></td>
				<td class="table_content_border text">&nbsp;&nbsp;<b>Pret / Noapte / Camera</b></td>
			</tr>
			<tr>
				<td class="table_content_border text">&nbsp;&nbsp;Single </td>
				<td class="table_content_border text" align="center"><input type="text" name="nr_cam_single" value="" size="3" maxlength="3"  />&nbsp;&nbsp;nr camere&nbsp;&nbsp;&nbsp;<img src="{SITE_BASE}/templates/skins/admin/images/help2.gif" onMouseOver="return overlib('Acesta este numarul de camere SINGLE pe care le detineti in cadrul unitatii dvs.', CAPTION, 'Numar Camere Single');" onmouseout="return nd();" style="border:none;"></td>
				<td class="table_content_border text" align="center">&nbsp;&nbsp;Pret&nbsp;&nbsp;<input type="text" name="pret_single" value=""  /> &nbsp;&nbsp;&nbsp;<img src="{SITE_BASE}/templates/skins/admin/images/help2.gif" onMouseOver="return overlib('Acesta este pretul unei camere SINGLE, pretul este pe noapte. Va rugam sa scrieti doar pretul fara moneda in care este exprimat pretul.<br>Exemplu: 120', CAPTION, 'Pret Camera Single');" onmouseout="return nd();" style="border:none;"></td>
			</tr>
			<tr>
				<td class="table_content_border text">&nbsp;&nbsp;Double</td>
				<td class="table_content_border text" align="center"><input type="text" name="nr_cam_double" value="" size="3" maxlength="3" />&nbsp;&nbsp;nr camere&nbsp;&nbsp;&nbsp;<img src="{SITE_BASE}/templates/skins/admin/images/help2.gif" onMouseOver="return overlib('Acesta este numarul de camere DOUBLE pe care le detineti in cadrul unitatii dvs.', CAPTION, 'Numar Camere Double');" onmouseout="return nd();" style="border:none;"></td>
				<td class="table_content_border text" align="center">&nbsp;&nbsp;Pret&nbsp;&nbsp;<input type="text" name="pret_double" value=""  /> &nbsp;&nbsp;&nbsp;<img src="{SITE_BASE}/templates/skins/admin/images/help2.gif" onMouseOver="return overlib('Acesta este pretul unei camere DOUBLE, pretul este estimat pe noapte. Va rugam sa scrieti doar pretul fara moneda in care este exprimat pretul.<br>Exemplu: 120', CAPTION, 'Pret Camera Double');" onmouseout="return nd();" style="border:none;" ></td>
			</tr>
			<tr>
				<td class="table_content_border text">&nbsp;&nbsp;Triple</td>
				<td class="table_content_border text" align="center"><input type="text" name="nr_cam_triple" value="" size="3" maxlength="3" />&nbsp;&nbsp;nr camere&nbsp;&nbsp;&nbsp;<img src="{SITE_BASE}/templates/skins/admin/images/help2.gif" onMouseOver="return overlib('Acesta este numarul de camere TRIPLE pe care le detineti in cadrul unitatii dvs.', CAPTION, 'Numar Camere Triple');" onmouseout="return nd();" style="border:none;" ></td>
				<td class="table_content_border text" align="center">&nbsp;&nbsp;Pret&nbsp;&nbsp;<input type="text" name="pret_triple" value=""  /> &nbsp;&nbsp;&nbsp;<img src="{SITE_BASE}/templates/skins/admin/images/help2.gif" onMouseOver="return overlib('Acesta este pretul unei camere TRIPLE, pretul este estimat pe noapte. Va rugam sa scrieti doar pretul fara moneda in care este exprimat pretul.<br>Exemplu: 120', CAPTION, 'Pret Camera Triple');" onmouseout="return nd();" style="border:none;"></td>
			</tr>
			<tr>
				<td class="table_content_border text">&nbsp;&nbsp;Matrimonial</td>
				<td class="table_content_border text" align="center"><input type="text" name="nr_cam_matrimonial" value="" size="3" maxlength="3" />&nbsp;&nbsp;nr camere&nbsp;&nbsp;&nbsp;<img src="{SITE_BASE}/templates/skins/admin/images/help2.gif" onMouseOver="return overlib('Acesta este numarul de camere MATRIMONIAL pe care le detineti in cadrul unitatii dvs.', CAPTION, 'Numar Camere Matrimonial');" onmouseout="return nd();"style="border:none;" ></td>
				<td class="table_content_border text" align="center">&nbsp;&nbsp;Pret&nbsp;&nbsp;<input type="text" name="pret_matrimonial" value=""  /> &nbsp;&nbsp;&nbsp;<img src="{SITE_BASE}/templates/skins/admin/images/help2.gif" onMouseOver="return overlib('Acesta este pretul unei camere MATRIMONIAL, pretul este estimat pe noapte. Va rugam sa scrieti doar pretul fara moneda in care este exprimat pretul.<br>Exemplu: 120', CAPTION, 'Pret Camera Matrimonial');" onmouseout="return nd();"style="border:none;" ></td>
			</tr>
			</table>
			</td>
		</tr>
		<tr>
			<td class="table_subhead" valign="top" align="left" colspan="2"><b>Alte Posibilitati / Oferte :</b></td>
		</tr>
		<tr>
			<td align="center" class="row1" colspan="2"><textarea name="alte_posibilitati" rows="7" cols="70"></textarea></td>
		</tr>
		<tr>
			<td class="row2" valign="top" width="160"><b>Servicii Incluse</b></td>
			<td class="row2" align="left">
			<table border="0" cellspacing="0" cellpadding="0" align="left" class="text">
			<tr>
				<td><input type="radio" name="servicii_incluse" value="cazare" checked/>&nbsp;&nbsp;Cazare</td>
			</tr>
			<tr>
				<td><input type="radio" name="servicii_incluse" value="mic_dejun" />&nbsp;&nbsp;Cazare si Mic Dejun</td>
			</tr>
			<tr>
				<td><input type="radio" name="servicii_incluse" value="demipensiune" />&nbsp;&nbsp;Cazare si demipensiune</td>
			</tr>
			<tr>
				<td><input type="radio" name="servicii_incluse" value="pensiune" />&nbsp;&nbsp;Cazare si pensiune completa</td>
			</tr>
			<tr>
				<td><input type="radio" name="servicii_incluse" value="all_inclusive" />&nbsp;&nbsp;Cazare si all inclusive</td>
			</tr>
			</table>
			</td>
		</tr>
		<tr>
			<td class="table_subhead" colspan="2">Oferta 1 Mai</td>
		</tr>
		<tr>
			<td align="center" class="row1" colspan="2"><textarea name="oferta_1mai" rows="7" cols="70"></textarea></td>
		</tr>
		<tr>
			<td class="table_subhead" colspan="2">Oferta Sarbatorile de Paste</td>
		</tr>
		<tr>
			<td align="center" class="row1" colspan="2"><textarea name="oferta_paste" rows="7" cols="70"></textarea></td>
		</tr>
		<tr>
			<td class="table_subhead" colspan="2">Oferta Craciun</td>
		</tr>
		<tr>
			<td align="center" class="row1" colspan="2"><textarea name="oferta_craciun" rows="7" cols="70"></textarea></td>
		</tr>
		<tr>
			<td class="table_subhead" colspan="2">Oferta Revelion</td>
		</tr>
		<tr>
			<td align="center" colspan="2" class="row1"><textarea name="oferta_revelion" rows="7" cols="70"></textarea></td>
		</tr>
		<tr>
			<td align="center" colspan="2" class="row2"><input type="button" class="button" value="Pas Urmator" onClick="ValidateStep2();"/></td>
		</tr>
		</table>
	</div>
	<div id="step3" style="display: none;">
		<div class="step_number"><img src="{SITE_BASE}/images/step3.png" width="65" height="61" border="0" alt=""></div>
		<h2 class="step_title">Pasul 3: Adauga imagini in cadrul galeriei</h2>
		<table border="0" cellspacing="1" cellpadding="0" width="100%" align="center" class="big_table form">
		<tr>
			<td class="table_subhead">Puteti sa adaugati <b>{NR_MAX_IMG}</b> imagini pentru aceasta oferta ! <!-- Tipul imaginilor sa fie <b>JPG</b>. Dimensiunea maxima a imaginii sa fie <b>640 x 480 pixeli</b> . --></td>
		</tr>
		<!-- BEGIN upload_block -->
		<tr>
			<td class="{UPLOAD_BG}" nowrap>&nbsp;&nbsp;Imaginea nr <b>{IMG_NR}</b>:&nbsp;&nbsp;<input type="file" name="image_{IMG_NR}" size='20' value="" ><!-- &nbsp;dimensiune maxima <b>640 x 480 pixeli</b> --></td>
		</tr>
		<!-- END upload_block -->
		<tr>
			<td align="center" colspan="2" class="row2"><input type="submit" class="button" value="Adauga Cazare"/></td>
		</tr>
		</table>
	</div>
	<!-- END if_no_error -->
</div>
</form>