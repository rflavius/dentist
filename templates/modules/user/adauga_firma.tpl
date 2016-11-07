<script type="text/javascript" src="{SITE_BASEE}/templates/js/prototype.js"></script>

<script language="javascript" type="text/javascript">
<!--
	function CompleteLocalitateFirma()
	{
		var target ='localitate_ajax_addfirm'; 
		var url="./sources/ajax_search.php?tpl_selected=addfirm&search_judet="+document.adauga_firma.judetselected.value;
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
	var url="./sources/ajax_plata.php?plata="+document.adauga_firma.type.value;
	var myAjax = new Ajax.Updater(target, url, { method: 'get'}); 
		$(target).show(); 
}

//-->
</script>


<!-- BEGIN error -->
	<div id="error_messages">{ERROR_MSG}</div>
	<!-- END error -->
<br />
<!-- BEGIN ADD_FIRM_BLOCK -->
<form name="adauga_firma" method="post" action="{INSERT_FIRMA}" enctype="multipart/form-data">
<table border="0" cellpadding="4" cellspacing="1" width="100%" class="text">
<tr> 
	<td colspan="2"> Exemplul adaugare firma, click <a href="{DETALIIADAUGAFIRMA}"><b>aici</b></a>!</td>
</tr>
<tr> 
	<td class="text2">Categoria : <span>*</span></td>
		<td>
				<select name="category_id" >
					<option value="">--------------------- Alege --------------------</option>
					<!-- BEGIN display_cats -->
					<option value="{CAT_ID}" {SELECTTEDCAT}>{CAT_NAME}</option>
					<!-- END display_cats -->
			</select>
	</td>
</tr>
	
	<tr> 
    <td class="text2">Numele firmei <span>*</span></td>
      <td><input name="nume_firma" size="43"  value="{NUME_FIRMA}" type="text"></td>
    </tr> 
		<tr> 
      <td class="text2"> Adresa <span>*</span></td>
      <td> <textarea name="adresa_firma" rows="5" cols="40"  onkeydown="CountChars(adresa_firma, 150)">{ADRESA_FIRMA}</textarea><br />
			Caractere disponibile :<input readonly type="text" name="caractere_adresa_firma" size="3" value="150">
			</td>
    </tr>
	<tr> 
	<td class="text2">Judet <span>*</span></td>
	<td>
			<select name="judet" id="judetselected" onchange="CompleteLocalitateFirma();" class="select_option_style" >
					<option value="">Alege Judet</option>
				<!-- BEGIN judet -->
				<option value="{COD_JUDET}" {SELECTTEDJUDET}>{NUMEJUDET}</option>
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
	 
      <td class="text2">Imagine Harta <br /> </td>
      <td><input type="file" name="picture_5" size="43"></td>
			</tr>
			
			<tr> 
      <td class="text2">Imagine 1 <br /></td>
      <td><input type="file" name="picture_1" size="43"></td>
		</tr>	
		<tr> 
      <td class="text2">Imagine  2 <br /> </td>
      <td><input type="file" name="picture_2" size="43"></td>
		</tr>
		<tr> 
      <td class="text2">Imagine 3 <br /> </td>
      <td><input type="file" name="picture_3" size="43"></td>
		</tr>
			<tr> 
      <td class="text2">Imagine 4 <br /></td>
      <td><input type="file" name="picture_4" size="43"></td>
		</tr>
		<tr> 
      <td class="text2">Pers. contact <span>*</span></td>
      <td><input name="pers_contact" size="43" value="{PERS_CONTACT}" type="text"></td>
    </tr>	
		<tr> 
      <td class="text2">Email <span>*</span></td>
      <td><input name="persc_email" size="43"  value="{PERSC_EMAIL}" type="text"></td>
  </tr>
	
	<!-- <tr> 
      <td class="text2">Perioada contractului <span>*</span></td>
      <td>
					<select name="perioada">
					<option value="" selected>Alegeti</option>
					<option value="1" {SELECTED_1}>1 an   -&nbsp;-&nbsp;-&nbsp;-&nbsp;-&nbsp;-   Pret {PRET_UN_AN} RON</option>
					<option value="2" {SELECTED_2}>2 ani   -&nbsp;-&nbsp;-&nbsp;-&nbsp;-&nbsp;-  Pret {PRET_DOI_ANI} RON</option>
					</select></td>
  </tr>
		
		<tr> 
      <td class="text2">Emitere factura pe: <span>*</span></td>
      <td>
					<select name="type" onchange="loadform();">
					<option value="" selected>Alegeti</option>
					<option value="persoana_fizica" {SELECTED_PERSOANA_FIZICA}>Persoana fizica</option>
					<option value="firma" {SELECTED_FIRMA}>Firma</option>
				</select>
			</td>
    </tr>	
		<tr>
			<td colspan="2" align="center">
				<div id="form_place" >
					{LOC_FORM_PLACE}
				</div>
			</td>
		</tr> -->
		
			
	
	<tr> 
			<td colspan="2" align="center"><input name="Submit" value="Adauga!" type="submit" class="button"></td>
	</tr>
	<tr> 
			<td colspan="2" > &nbsp;</td>
		</tr>

<tr>
	<td colspan="2" class="attention_albastru"><b>Atentie!</b></td>
</tr>
<tr> 
		<td colspan="2" ><li>Complectarea campurilor  cu * este obligatorie!</li></td>
</tr>
 <tr> 
		 <td colspan="2" ><li>Click pe <b>"Adauga"</b> si firma dvs. va fi inregistrata pe dentistonline, dar va fi inactiva.</li>
		 <li>Dupa ce informatiile adugate de dvs vor fi verificate vom realiza activarea firmei dvs.</li>
		 <!-- <li>Dimensiunea maxima pentru imagini este de :{MAX_PICTURE_WIDTH} px.</li> -->
		  <li>Extensiile acceptate pentru imagini sunt jpg, jpeg, png, gif. </li>
			 <!-- <li>Vi se va emite o factura proforma pe adresa de email a personei de contact introdusa in formularul de mai sus. </li>
		 <li>Dupa ce vom avea confirmarea platii vom activa firma dumneavoastra.</li>
		 <li>Datele ce tin de emitere factura sunt strict confidentiale, fiind necesare pentru emiterea facturi si incheierea unui contract.</li> -->
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