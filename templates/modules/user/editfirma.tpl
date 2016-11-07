	<script type="text/javascript" src="{SITE_BASEE}/templates/js/prototype.js"></script>

<script language="javascript" type="text/javascript">
<!--
	function CompleteLocalitate()
	{
		var target ='localitate_ajax_addfirm'; 
		var url="./sources/ajax_search.php?tpl_selected=addfirm&search_judet="+document.adauga_firma.judet.value;
		//alert(url);
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
//-->
</script>
<!-- BEGIN error -->
	<div id="error_messages"><br />{ERROR_MSG}</div>
	<!-- END error -->

<form name="adauga_firma" method="post" action="{UPDATE_FIRMA}" enctype="multipart/form-data">
 <table border="0" cellpadding="4" cellspacing="1" width="100%">
 	<tr> 
			<td class="text2">Categoria<span>*</span></td>
				<td>
					<b>{CAT_NAME}<input type="hidden" name="category_id" value="{CAT_ID}" /></b>
			</td>
		</tr>
	
<tr> 
		<td class="text2">Numele firmei <span>*</span></td>
			<td><input name="nume_firma" size="43"  value="{NUME_FIRMA}" type="text" readonly></td>
</tr> 
<tr> 
			<td class="text2"> Adresa <span>*</span></td>
			<td> <textarea name="adresa_firma" rows="8" cols="40"  onkeydown="CountChars(adresa_firma, 150)">{ADRESA_FIRMA}</textarea><br />
			Caractere disponibile :<input readonly type="text" name="caractere_adresa_firma" size="3" value="150">
		</td>
</tr>
<tr> 
	<td class="text2">Judet <span>*</span></td>
	<td>
			<select name="judet" id="judet" onchange="CompleteLocalitate();" class="select_option_style" >
					<option value="">Alege Judet</option>
				<!-- BEGIN judet -->
				<option value="{COD_JUDET}" {JUDET}>{NUMEJUDET}</option>
				<!-- END judet -->
			</select>
	</td>
  </tr>
	<tr> 
      <td class="text2">Localitate <span>*</span></td>
      <td>
					<div id="localitate_ajax_addfirm" >
					{LOC_DIV_ADAUGAFIRMA}
					</div>
			</td>
  </tr>
	<tr> 
      <td class="text2">Telefon/ Fax/ Mobil</td>
      <td><input name="fax" id="fax" value="{FAX}" size="43" type="text"></td>
    </tr>

	<tr> 
      <td class="text2">Echipa medicala</td>
      <td><textarea name="echipa_medicala" rows="8" cols="40" onkeydown="CountChars(echipa_medicala, 500)">{ECHIPA_MEDICALA}</textarea><br />
			Caractere disponibile :<input readonly type="text" name="caractere_echipa_medicala" size="3" value="500">
			</td>
   </tr>
	<tr> 
			<td class="text2">Email <br /> </td>
			<td ><input name="email_firma" maxlength="100" size="43" value="{EMAIL_FIRMA}" type="text"></td>
	 </tr>
	<tr> 
			<td ><b>Adresa WEB</b> <br /> ex: http://www.dentistonline.ro</td>
			<td ><input name="adresa_web" maxlength="100" size="43" value="{ADRESA_WEB}" type="text"></td>
	 </tr>
	
	<tr> 
      <td class="text2">Orar <span>*</span></td>
      <td><textarea name="orar" rows="8" cols="40" onkeydown="CountChars(orar, 150)" >{ORAR}</textarea><br />
			Caractere disponibile :<input readonly type="text" name="caractere_orar" size="3" value="150"></td>
	  		
	</tr>
	
	<tr> 
      <td class="text2">Descriere  <span>*</span></td>
      <td><textarea name="descriere"  rows="8" cols="40" onkeydown="CountChars(descriere, 1500)">{DESCRIERE}</textarea><br />
			Caractere disponibile :<input readonly type="text" name="caractere_descriere" size="3" value="1500">
			</td>
		</tr>
			

		<tr> 
      <td class="text2">Servicii si Tarife </td>
      <td><textarea name="tarife" rows="8" cols="40" onkeydown="CountChars(tarife, 600)">{TARIFE}</textarea><br />
			Caractere disponibile :<input readonly type="text" name="caractere_tarife" size="3" value="600">
			</td>
		</tr>
		<tr> 
      <td class="text2">Pers. contact <span>*</span></td>
      <td><input name="pers_contact" value="{PERS_CONTACT}" type="text" size="43"></td>
    </tr>	
		<tr> 
      <td class="text2">Email <span>*</span></td>
      <td><input name="persc_email" maxlength="100" size="43"  value="{PERSC_EMAIL}" type="text"></td>
  </tr>
	<!-- <tr> 
      <td class="text2">Perioada contractului </td>
      <td> {PERIOADA} an/ani</td>
  </tr>
	<tr> 
      <td class="text2">Factura a fost emisa pe:</td>
      <td>{FACTURA_TYPE}</td>
    </tr>	
		<tr>
			<td colspan="2" align="center">
				<div id="form_place" >
					{LOC_FORM_PLACE}
				</div>
			</td>
		</tr> -->
</table>
 <div align="center"><br /><input name="Submit" value="Modifca!" class="button" type="submit"></div>
</form>

<table border="0" cellspacing="4" cellpadding="1" width="100%">
	<tr>
		<td colspan="2" class="attention_albastru"><b>Atentie!</b></td>
	</tr>
	<tr>
		<td><li> Campurile cu * sunt obligatorii! </li></td>
	</tr>
	<tr>
		<td><li>Firma dvs. a fost adaugata in data de: {SUBMISION_DATE}.</li></td>
	</tr>
	<tr>
		<td><li>Daca doriti sa modificati imaginile pentru <b>{NUME_FIRMA}</b> doar accesati "Galerie imagini".</li></td>
	</tr>
	<tr>
		<td>{DATA_EXPIRARE}</td>
	</tr>
</table>