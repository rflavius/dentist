<script language="javascript" type="text/javascript">
<!--
	function CompleteLocalitate()
	{
		var target ='localitate_ajax_addfirm'; 
		var url="../sources/ajax_search.php?tpl_selected=addfirm&search_judet="+document.adauga_firma.judet.value;
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

function loadform()
{
		var target ='form_place'; 
		var url="../sources/ajax_plata.php?plata="+document.adauga_firma.type.value;
		var myAjax = new Ajax.Updater(target, url, { method: 'get'}); 
		$(target).show(); 

}
//-->
</script>
<!-- BEGIN error -->
<div id="error_messages"><br />{ERROR_MSG}</div>
<!-- END error -->

<form name="adauga_firma" method="post" action="?page=cabinete.insert" enctype="multipart/form-data">
<table width="90%" class="grey" cellpadding="4" cellspacing="1" align="center">
<tr>
		<td class="tbhead" colspan="2">Add new cabinet</td>
</tr>
<tr> 
	<td class="{BGCOLOR1}"><b>Categoria</b><p class="star">*</p></td>
		<td class="{BGCOLOR2}" >
				<select name="category_id" class="select_option_style">
					<option value="">--------------------- Alege --------------------</option>
					<!-- BEGIN display_cats -->
					<option value="{CAT_ID}" {CATEGORY_ID}>{CAT_NAME}</option>
					<!-- END display_cats -->
			</select>
	</td>
</tr>

<tr> 
	<td class="{BGCOLOR1}"><b>Numele firmei</b><p class="star">*</p></td>
	<td class="{BGCOLOR2}" ><input name="nume_firma" size="35"  value="{NUME_FIRMA}" type="text"></td>
</tr> 
<tr> 
	 <td class="{BGCOLOR1}"> <b>Adresa firma</b> <p class="star">*</p></td>
		<td class="{BGCOLOR2}"> <textarea name="adresa_firma" rows="5" cols="50"  onkeydown="CountChars(adresa_firma, 150)">{ADRESA_FIRMA}</textarea><br />
	Caractere disponibile :<input readonly type="text" name="caractere_adresa_firma" size="3" value="150">

		</td>
	</tr>
		<tr> 
	<td class="{BGCOLOR1}"><b>Judet</b> <p class="star">*</p></td>
	<td  class="{BGCOLOR2}" >
			<select name="judet" id="judet" onchange="CompleteLocalitate();" class="select_option_style" >
					<option value="">Alege Judet</option>
				<!-- BEGIN judet -->
				<option value="{COD_JUDET}" {SELECTTEDJUDET}>{NUMEJUDET}</option>
				<!-- END judet -->
			</select>
	</td>
  </tr>
	<tr > 
      <td class="{BGCOLOR1}" ><b>Localitate</b> <p class="star">*</p></td>
     <td class="{BGCOLOR2}">
					<div id="localitate_ajax_addfirm" >
					{LOC_DIV_ADAUGAFIRMA}
					</div>
			</td>
  </tr>
	<tr> 
      <td class="{BGCOLOR1}"><b>Telefon/Fax</b></td>
      <td class="{BGCOLOR2}" ><input name="fax" size="40" id="fax" value="{FAX}" type="text"></td>
    </tr>
	<tr> 
      <td class="{BGCOLOR1}">Echipa medicala</td>
      <td class="{BGCOLOR2}"><textarea name="echipa_medicala" rows="10" cols="50" onkeydown="CountChars(echipa_medicala, 500)">{ECHIPA_MEDICALA}</textarea><br />
			Caractere disponibile :<input readonly type="text" name="caractere_echipa_medicala" size="3" value="500">
			</td>
   </tr>
	<tr> 
			<td class="{BGCOLOR1}"><b>Email</b> <br /> </td>
			<td class="{BGCOLOR2}"><input name="email_firma" size="40" value="{EMAIL_FIRMA}" type="text"></td>
	 </tr>
	<tr> 
      <td class="{BGCOLOR1}"><b>Adresa WEB</b></td>
      <td  class="{BGCOLOR2}"><input name="adresa_web" size="40" value="{ADRESA_WEB}" type="text"></td>
   </tr class="{BGCOLOR2}" >
	
	<tr> 
     <td class="{BGCOLOR1}"><b>Orar</b> <p class="star">*</p></td>
      <td class="{BGCOLOR2}"><textarea name="orar" rows="10" cols="50" onkeydown="CountChars(orar, 150)" >{ORAR}</textarea><br />
			Caractere disponibile :<input readonly type="text" name="caractere_orar" size="3" value="150"></td>
	  		
	</tr>
	
	<tr> 
      <td class="{BGCOLOR1}"><b>Descriere </b> <p class="star">*</p></td>
      <td class="{BGCOLOR2}"><textarea name="descriere"  rows="10" cols="50" onkeydown="CountChars(descriere, 500)">{DESCRIERE}</textarea><br />
			Caractere disponibile :<input readonly type="text" name="caractere_descriere" size="3" value="500">
			</td>
		</tr>
			

		<tr> 
      <td class="{BGCOLOR1}"><b>Servicii si Tarife</b></td>
      <td class="{BGCOLOR2}"><textarea name="tarife" rows="10" cols="50" onkeydown="CountChars(tarife, 600)">{TARIFE}</textarea><br />
			Caractere disponibile :<input readonly type="text" name="caractere_tarife" size="3" value="600">
			</td>
		</tr>
		 <tr> 
      <td class="{BGCOLOR1}"><b>Meta keywords</b></td>
      <td class="{BGCOLOR2}" ><textarea name="meta_keywords" rows="10" cols="50">{META_KEYWORDS}</textarea></td>
    </tr>
		<tr> 
      <td class="{BGCOLOR1}"><b>Meta description</b></td>
      <td class="{BGCOLOR2}" ><textarea name="meta_description" rows="10" cols="50">{META_DESCRIPTION}</textarea></td>
 </tr>
		<tr> 
      <td class="{BGCOLOR1}"><b>Pers. contact</b> <p class="star">*</p></td>
      <td class="{BGCOLOR2}" ><input name="pers_contact" size="40" value="{PERS_CONTACT}" type="text"></td>
    </tr>	
		<tr> 
      <td class="{BGCOLOR1}"><b>Email</b> <p class="star">*</p></td>
      <td class="{BGCOLOR2}" ><input name="persc_email" maxlength="100" size="120"  value="{PERSC_EMAIL}" type="text"></td>
	 </tr>
	
	 	<tr> 
      <td  class="{BGCOLOR1}"><b>Perioada contractului</b> <p class="star">*</p></td>
      <td  class="{BGCOLOR2}">
						<select name="perioada">
						<option value="" selected>Alegeti</option>
						<option value="1" {SELECTED_1}>1 an</option>
						<option value="2" {SELECTED_2}>2 ani</option>
						</select>
				</td>
		 </tr>
		<tr> 
      <td  class="{BGCOLOR1}"><b>Emitere factura pe</b> <p class="star">*</p></td>
      <td  class="{BGCOLOR2}">
					<select name="type" onchange="loadform();">
					<option value="" selected>Alegeti</option>
					<option value="persoana_fizica" {SELECTED_PERSOANA_FIZICA}>Persoana fizica</option>
					<option value="firma" {SELECTED_FIRMA}>Firma</option>
					<option value="none" {SELECTED_NONE}>None</option>
				</select>
			</td>
    </tr>	
		<tr>
			<td colspan="2" align="center" class="{BGCOLOR1}">
				<div id="form_place" >
					{LOC_FORM_PLACE}
				</div>
			</td>
		</tr>
		
<tr class="{BGCOLOR1}">
	<td align="center" width="100%" colspan="2">
		<input type="submit" value="Add" class="button" />
	</td>
</tr>
</table>
</form>