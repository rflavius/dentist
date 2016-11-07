<script language="javascript" type="text/javascript">
<!--
	function CompleteLocalitate()
	{
		var target ='localitate_ajax_addfirm'; 
		var url="../sources/ajax_search.php?tpl_selected=addfirm&search_judet="+document.edit_cabinete.judet.value;
		var myAjax = new Ajax.Updater(target, url, { method: 'get'}); 
		$(target).show(); 
	}
	function CountChars( field, maxcaractere )
	{
		if ( field.value.length > maxcaractere )
		{
			field.value = field.value.substr(0,maxcaractere);
		}
		
		document.forms['edit_cabinete']['caractere_'+field.name].value = maxcaractere - field.value.length;
	}
		function loademailtype( )
	{
		document.location.href="?page=cabinete.edit.{ID_CABINET}.{ID_USER}."+document.emailtype.emailform.value;
	}

//-->
</script>

	{INFORMATION}{ERROR_MSG}
	<br />
<table border="0" cellspacing="0" cellpadding="0" width="80%" >
<tr>
	<td width="50%">
			<form method="post" action="?page=cabinete.sendemail.{ID_CABINET}.{ID_USER}.{PERIOADA}" name="emailtype">
			<table border="0" cellspacing="1" cellpadding="4"  class="grey" width="98%">
			<tr>
				<td style ="color:#990000 " class="{BGCOLOR1}" colspan="2"><b>Trimite email</b></td>
			</tr>
			<tr>
				<td class="{BGCOLOR1}"><b>Tip email</b></td>
				<td class="{BGCOLOR2}">
					<select name="emailform" onchange="loademailtype();">
						<option value="none" {selected_none}>None</option>
						<option value="cab_activat" {selected_cab_activat}>Cabinet activat format .html</option>
						<option value="cab_activat_txt" {selected_cab_activat_txt}>Cabinet activat format .txt</option>
						<option value="fara_img_fara_scris" {selected_fara_img_fara_scris}>Fara img, fara scris</option>
						<option value="imagine_logo"{selected_imagine_logo}>Imagine logo creata</option>
						<option value="cab_inactiv" {selected_cab_inactiv}>Cabinet dezactivat</option>
					</select>
				</td>
				</tr>
				<tr>
								<td colspan="2"class="{BGCOLOR1}" align="center">{EMAIL_CONTENT1}
								<textarea name="email_content" rows="40" cols="140" style="display:{VISABILITI_OPTION};"> {EMAIL_CONTENT2}</textarea></td>
				</tr>
				<tr>
				<td colspan="2"class="{BGCOLOR1}" align="center">
				<input type="submit" name="sbmtbtn" value="Trimite" /></td>
			</tr>
			</table>
				<input type="hidden" name="pers_contact" value="{PERS_CONTACT}" />
				<input type="hidden" name="pers_email" value="{PERSC_EMAIL}" />
				<input type="hidden" name="email_firma" value="{EMAIL_FIRMA}" />
				<input type="hidden" name="nume_fir" value="{NUME_FIRMA}" />
		</form>
</td>
	<td width="50%"> 
	<table border="0" cellspacing="1" cellpadding="4" class="grey" width="98%">
	<tr> 
      <td  colspan="2" class="{BGCOLOR1}" style ="color:#990000 "><b>Detalii plata</b> </td>
  </tr>
	<tr> 
      <td  class="{BGCOLOR1}" width="50%"><b>Id factura proforma</b> </td>
      <td class="{BGCOLOR2}" align="center"> <a href="?page=plati.detaliiproforma.{PROFORMA_ID}">{PROFORMA_ID}</a></td>
  </tr>
	<tr> 
      <td  class="{BGCOLOR1}"><b>Id contract</b> </td>
      <td class="{BGCOLOR2}" align="center"> <a href="?page=contracte.detaliicontract.{CONTRACT_ID}">{CONTRACT_ID}</a></td>
  </tr>
		<tr> 
      <td  class="{BGCOLOR1}"><b>Modifica imagini</b> </td>
      <td class="{BGCOLOR2}" align="center"> <a href="?page=cabinete.modificaimg.{ID_CABINET}.{ID_USER}.{PERS_CONTACT}">[ Imagini - id cabinet {ID_CABINET} ]</a></td>
  </tr>
	<tr> 
      <td  class="{BGCOLOR1}"><b>Modifica video</b> </td>
      <td class="{BGCOLOR2}" align="center"> <a href="?page=cabinete.modificavideo.{ID_CABINET}.{ID_USER}">[ Video - pentru {ID_CABINET} ]</a></td>
  </tr>
	<tr> 
      <td  class="{BGCOLOR1}"><b>User ID</b> </td>
      <td class="{BGCOLOR2}" align="center"> <a href="index.php?page=users.details.{ID_USER}">[ {ID_USER} ]</a></td>
  </tr>
  <tr> 
      <td  class="{BGCOLOR1}"><b>Vizite</b> </td>
      <td class="{BGCOLOR2}" align="center">[ {VIZITE_CABINET} ]</td>
  </tr>

 
</table>
</td>
</tr>
</table>


<br />
<table border="0" cellspacing="1" cellpadding="4" width="80%" >
	<tr>
		<td style="color:red;">{EMAILACTIVARE}</td>
		</tr>
</table>

<br />
<form name="edit_cabinete" method="post" action="?page=cabinete.save_edit.{ID_CABINET}" enctype="multipart/form-data">

<table width="80%" class="grey" cellpadding="4" cellspacing="1" align="center">
<tr>
		<td class="tbhead" colspan="2">Edit {NUME_FIRMA} cabinet</td>
</tr>
<tr>
	<td class="{BGCOLOR1}" valign="top" width="30%"><b>Chose parent</b><p class="star">*</p></td>	
	<td class="{BGCOLOR2}">
					<select name="cabinet_category">
						<!-- BEGIN modules -->
							<option value="module_{MODULE_ID}" {SELECTED_MODULE}>{MODULE_NAME}</option>
							<!-- BEGIN cats -->
								<option value="category_{CATEGORY_ID}" {SELECTED_CATEGORY}> ... {CATEGORY_NAME}</option>
							<!-- END cats -->
						<!-- END modules -->
					</select>
	</td>
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
	<td class="{BGCOLOR1}"><b>Alias</b><p class="star">*</p></td>
	<td class="{BGCOLOR2}" ><input name="alias" size="35"  value="{ALIAS}" type="text"></td>
</tr> 
<tr> 
	 <td class="{BGCOLOR1}"> <b>Adresa firma</b> <span>*</span></td>
		<td class="{BGCOLOR2}"> <textarea name="adresa_firma" rows="5" cols="80" ">{ADRESA_FIRMA}</textarea><br />
	

	</td>
	</tr>
	<!-- <tr> 
	 <td class="{BGCOLOR1}"> <b>Adresa firma</b> <span>*</span></td>
		<td class="{BGCOLOR2}"> <textarea name="adresa_firma" rows="5" cols="50"  onkeydown="CountChars(adresa_firma, 150)">{ADRESA_FIRMA}</textarea><br />
	Caractere disponibile :<input readonly type="text" name="caractere_adresa_firma" size="3" value="150">

	</td>
	</tr> -->
	<tr> 
	<td class="{BGCOLOR1}"><b>Judet</b> <p class="star">*</p></td>
	<td  class="{BGCOLOR2}" >
			<select name="judet" id="judet" onchange="CompleteLocalitate();" class="select_option_style" >
					<option value="">Alege Judet</option>
				<!-- BEGIN judet -->
				<option value="{COD_JUDET}" {JUDET}>{NUMEJUDET}</option>
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
      <td class="{BGCOLOR1}"><b>Telefon/Fax/Mobil</b></td>
      <td class="{BGCOLOR2}" ><input name="fax" size="40" id="fax" value="{FAX}" type="text"></td>
    </tr>
	<tr> 
      <td class="{BGCOLOR1}"><b>Echipa medicala</b></td>
      <td class="{BGCOLOR2}"><textarea name="echipa_medicala" rows="10" cols="80" >{ECHIPA_MEDICALA}</textarea><br />
			
			</td>
   </tr>
	<tr> 
			<td class="{BGCOLOR1}"><b>Email</b> <br /> </td>
			<td class="{BGCOLOR2}"><input name="email_firma" size="40" value="{EMAIL_FIRMA}" type="text"></td>
	 </tr>
	<tr> 
      <td class="{BGCOLOR1}"><b>Adresa WEB</b></td>
      <td  class="{BGCOLOR2}"><input name="adresa_web" size="40" value="{ADRESA_WEB}" type="text"><br>
			<a href="{ADRESA_WEB}" target="_blank">{ADRESA_WEB}</a></td>
   </tr class="{BGCOLOR2}" >
	
	<tr> 
     <td class="{BGCOLOR1}"><b>Orar</b> <span>*</span></td>
      <td class="{BGCOLOR2}"><textarea name="orar" rows="10" cols="80" >{ORAR}</textarea><br />
		</td>
	  		
	</tr>
	
	<tr> 
      <td class="{BGCOLOR1}"><b>Descriere </b> <span>*</span></td>
      <td class="{BGCOLOR2}"><textarea name="descriere"  rows="10" cols="80" >{DESCRIERE}</textarea><br />
		
			</td>
		</tr>
			

		<tr> 
      <td class="{BGCOLOR1}"><b>Servicii si Tarife</b></td>
      <td class="{BGCOLOR2}"><textarea name="tarife" rows="10" cols="80" >{TARIFE}</textarea><br />
	</td>
		</tr>
	<tr>
		<td class="{BGCOLOR1}"><b>Adauga servicii in format doc sau pdf 	</b>	
		<br>{SERVICII_FILE}</td>
		<td class="{BGCOLOR2}"><input type="file" name="servicii" size='30' value="" ><br>Puteti adauga fisiere cu extensia PDF sau fisiere Microsoft Office</td>
	</tr>
	<tr> 
      <td class="{BGCOLOR1}"><b>Comment</b></td>
      <td class="{BGCOLOR2}" ><textarea name="comment" rows="10" cols="80">{COMMENT}</textarea></td>
    </tr>
	<tr> 
      <td class="{BGCOLOR1}"><b>Meta keywords</b></td>
      <td class="{BGCOLOR2}" ><textarea name="meta_keywords" rows="10" cols="80">{META_KEYWORDS}</textarea></td>
    </tr>
		<tr> 
      <td class="{BGCOLOR1}"><b>Meta description</b></td>
      <td class="{BGCOLOR2}" ><textarea name="meta_description" rows="10" cols="80">{META_DESCRIPTION}</textarea></td>
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
      <td  class="{BGCOLOR1}"><b>Perioada contractului</b> </td>
      <td class="{BGCOLOR2}" > {PERIOADA} an/ani</td>
  </tr>
	<tr> 
      <td  class="{BGCOLOR1}"><b>Factura a fost emisa pe:</b></td>
      <td class="{BGCOLOR2}" >{FACTURA_TYPE}</td>
    </tr>	
		<tr>
			<td colspan="2" align="center" style="background-color:#DEF3E1;" >
				<div id="form_place" >
					{LOC_FORM_PLACE}
				</div>

			</td>
		</tr>
		<tr> 
      <td  class="{BGCOLOR1}"><b>Firma a fost adaugata in:</b> </td>
      <td class="{BGCOLOR2}" > {SUBMISION_DATE}</td>
  </tr>
	<tr> 
      <td  class="{BGCOLOR1}"><b>Data expirarii:</b> </td>
      <td class="{BGCOLOR2}" > {EXPIRE_DATE}</td>
  </tr>
<tr class="{BGCOLOR1}">
	<td align="center" width="100%" colspan="2">
		<input type="submit" value="Update Changes" class="button" />
	</td>
</tr>
</table>
</form>
	
