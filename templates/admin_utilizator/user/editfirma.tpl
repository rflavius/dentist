	<script type="text/javascript" src="{SITE_BASEE}/templates/js/prototype.js"></script>

<script language="javascript" type="text/javascript">
<!--
	function CompleteLocalitate()
	{
		var target ='localitate_ajax_addfirm'; 
		var url="../sources/ajax_search.php?tpl_selected=addfirm&search_judet="+document.adauga_firma.judet.value;
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
<div class="error" style="border:#E9A031;">{ERROR_MSG}</div>
<br />
<!-- END error -->

<form name="adauga_firma" method="post" action="{UPDATE_FIRMA}" enctype="multipart/form-data">
<table border="0" cellpadding="4" cellspacing="1" width="90%" class="big_table form">
<tr> 
	<td class="table_subhead" colspan="2">Modifica informatiile caracteristice pentru :{NUME_FIRMA} </td>
</tr>
<tr>
	<td class="row1">Categoria<span>*</span></td>
	<td class="row1"><b>{CAT_NAME}<input type="hidden" name="category_id" value="{CAT_ID}" /></b></td>
</tr>
<tr>
	<td class="row1">Numele firmei <span>*</span></td>
	<td class="row1"><input name="nume_firma" size="43"  value="{NUME_FIRMA}" type="text" ></td>
</tr>
<tr>
	<td class="row1"> Adresa <span>*</span></td>
	<td class="row1"> <textarea name="adresa_firma" rows="8" cols="40"  >{ADRESA_FIRMA}</textarea><br />
	</td>
</tr>
<tr> 
	<td class="row1">Judet <span>*</span></td>
	<td class="row1">
			<select name="judet" id="judet" onchange="CompleteLocalitate();" class="select_option_style" >
					<option value="">Alege Judet</option>
				<!-- BEGIN judet -->
				<option value="{COD_JUDET}" {JUDET}>{NUMEJUDET}</option>
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
      <td class="row1">Telefon/ Fax/ Mobil</td>
      <td class="row1"><input name="fax" id="fax" value="{FAX}" size="43" type="text"></td>
    </tr>

	<tr> 
      <td class="row1">Echipa medicala</td>
      <td class="row1"><textarea name="echipa_medicala" rows="8" cols="40" >{ECHIPA_MEDICALA}</textarea><br />
			
			</td>
   </tr>
	<tr> 
			<td class="row1">Email <br /> </td>
			<td class="row1"><input name="email_firma" maxlength="100" size="43" value="{EMAIL_FIRMA}" type="text"></td>
	 </tr>
	<tr> 
			<td class="row1"><b>Adresa WEB</b> <br /> ex: http://www.dentistonline.ro</td>
			<td class="row1"><input name="adresa_web" maxlength="100" size="43" value="{ADRESA_WEB}" type="text"></td>
	 </tr>
	
	<tr> 
      <td class="row1">Orar <span>*</span></td>
      <td class="row1"><textarea name="orar" rows="8" cols="40"  >{ORAR}</textarea><br />
			</td>
	  		
	</tr>
	
	<tr> 
      <td class="row1">Descriere  <span>*</span></td>
      <td class="row1" ><textarea name="descriere"  rows="8" cols="40" >{DESCRIERE}</textarea><br />
			
			</td>
		</tr>
	<tr> 
      <td class="row1">Servicii si Tarife </td>
      <td class="row1"> <textarea name="tarife" rows="8" cols="40" >{TARIFE}</textarea><br />
			
			</td>
	</tr>
	<tr> 
      <td class="row2" colspan="2"><B>Servicii si Tarife in format electronic</B> </td>
	</tr>
	<tr>
		<td class="row1">{SERVICII_FILE}</td>
		<td class="row1"><input type="file" name="servicii" size='30' value="" ><br>Puteti adauga fisiere cu extensia PDF sau fisiere Microsoft Office</td>
	</tr>

	<tr> 
      <td class="row1">Pers. contact <span>*</span></td>
      <td class="row1"><input name="pers_contact" value="{PERS_CONTACT}" type="text" size="43"></td>
    </tr>	
		<tr> 
      <td class="row1">Email <span>*</span></td>
      <td class="row1"><input name="persc_email" maxlength="100" size="43"  value="{PERSC_EMAIL}" type="text"></td>
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
		<tr> 
      <td class="row1" colspan="2"  style="text-align:center;"><input name="Submit" value="Modifca" class="button" type="submit" align="center"></td>
</tr>
		
</table>

</form>

<table border="0" cellspacing="1" cellpadding="4" width="100%" class="big_table form">
<tr>
	<td class="table_subhead"><b>Ajutor pentru dvs.</b></td>
</tr>
<tr>
	<td> 
		<li> Campurile cu * sunt obligatorii! </li>
		<li>Daca doriti sa modificati imaginile pentru <b>{NUME_FIRMA}</b> doar accesati <a href="{MODIFICA_IMAGINI}"> [ <b>Galerie imagini </b>]</a>.</li>
		<!-- <li>{DATA_EXPIRARE}</li> -->
		<li>Firma dvs. a fost adaugata in data de: <b>{SUBMISION_DATE}</b>.</li>
	</td>
</tr>
</table>
