<script type="text/javascript" src="{SITE_BASEE}/templates/js/prototype.js"></script>

<!-- BEGIN error -->
<div id="error_messages" style="border:none;"><br />{ERROR_MSG}</div>
<!-- END error -->
<script language="javascript" type="text/javascript">
<!--
	function CompleteLocalitate()
	{
		var target ='localitate_ajax_addfirm'; 
		var url="./sources/ajax_search.php?tpl_selected=addfirm&search_judet="+document.edit_anunt.judet.value;
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
		
		document.forms['edit_anunt']['caractere_'+field.name].value = maxcaractere - field.value.length;
	}
//-->
</script>
<form name="edit_anunt" method="post" action="{UPDATE_ANUNT}" enctype="multipart/form-data">
<table border="0" cellpadding="4" cellspacing="1" width="100%" class="text">
<tr> 
	<td class="text2">Categoria: <span>*</span></td>
		<td>
				<select name="category_id" >
					<!-- BEGIN display_cats -->
					<option value="{CAT_ID}" {SELECTTEDCAT}>{CAT_NAME}</option>
					<!-- END display_cats -->
			</select>
	</td>
</tr>
	
<tr> 
		<td class="text2">Titlu anunt: <span>*</span></td>
		<td><input name="titlu" size="42"  value="{TITLU}" type="text" ></td>
</tr> 

<tr> 
		<td class="text2">Autor: <span>*</span></td>
		<td><input name="autor" size="42"  value="{AUTOR}" type="text" ></td>
</tr> 
<tr> 
		<td class="text2">Email: <span>*</span></td>
		<td><input name="email" size="42"  value="{EMAIL}" type="text" ></td>
</tr>
	<tr> 
	<td class="text2">Judet: <span>*</span></td>
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
      <td class="text2">Localitate; <span>*</span></td>
      <td>
					<div id="localitate_ajax_addfirm" >
					{LOC_DIV_ADAUGAFIRMA}
					</div>
			</td>
  </tr>
<tr> 
	<td class="text2">Descriere anunt:<span>*</span></td>
	<td> <textarea name="continut" rows="15" cols="50" onkeydown="CountChars(continut, 1500)">{CONTINUT}</textarea>
	<br />Caractere disponibile :<input readonly type="text" name="caractere_continut" size="3" value="1500">
	</td>
</tr>
<tr> 
<td class="text2">Imagine:</td>
	<td ><img src="{THUMBNAIL}" ></td>
</tr>
<tr> 
	<td class="text2">Modifica imagine: <br /><!-- Latimea maxima :{MAX_PICTURE_WIDTH} px --></td>
	<td><br /><input type="file" name="imagine"></td>
</tr>
<tr> 
	<td><input type="hidden" name="meta_description" value="{META_DESCRIPTION}" />
		<input type="hidden" name="meta_keywords" value="{META_KEYWORDS}" />
	</td>
</tr>
</table>
<div align="center"><br />
<input name="Submit" value="Modifica" type="submit" class="button"></div>
</form>

<table border="0" cellspacing="4" cellpadding="1" class="text">
<tr>
	<td class="attention_albastru"><b>Atentie!</b></td>
</tr>
<tr>
	<td><li>Anuntul dvs. a fost adaugat in data de: <b>{SUBMISION_DATE}</b></li></td>
</tr>
<tr>
	<td><li>Anuntul dvs. va fi activ pana in data de :<b>{EXPIRE_DATE}</b></li></td>
</tr>
<tr>
	<td><li>Anuntul dvs. va ramne valabil timp de 6 luni, sau daca veti dori sa il stergeti aveti acesta posiblilitate din meniul dvs. de membru al site-ului DentistOnline.</li></td>
</tr>

</table>