<script type="text/javascript" src="{SITE_BASEE}/templates/js/prototype.js"></script>

<!-- BEGIN error -->
<div class="error" style="border:#DDDDDD;">{ERROR_MSG}</div>
<br />
<!-- END error -->
<script language="javascript" type="text/javascript">
<!--
	function CompleteLocalitate()
	{
		var target ='localitate_ajax_addfirm'; 
		var url="../sources/ajax_search.php?tpl_selected=addfirm&search_judet="+document.edit_anunt.judet.value;
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
<table border="0" cellpadding="4" cellspacing="1" width="90%"  class="big_table form">
<tr> 
		<td class="table_subhead" colspan="2">Modifica informatiile caracteristice anuntului</td>
		
</tr> 
<tr> 
	<td class="row1">Categoria: <span>*</span></td>
		<td class="row1">
				<select name="category_id" >
					<!-- BEGIN display_cats -->
					<option value="{CAT_ID}" {SELECTTEDCAT}>{CAT_NAME}</option>
					<!-- END display_cats -->
			</select>
	</td>
</tr>
	
<tr> 
		<td class="row1">Titlu anunt: <span>*</span></td>
		<td class="row1"><input name="titlu" size="42"  value="{TITLU}" type="text" ></td>
</tr> 

<tr> 
		<td class="row1">Autor: <span>*</span></td>
		<td class="row1"><input name="autor" size="42"  value="{AUTOR}" type="text" ></td>
</tr> 
<tr> 
		<td class="row1">Email: <span>*</span></td>
		<td class="row1"><input name="email" size="42"  value="{EMAIL}" type="text" ></td>
</tr>
	<tr> 
	<td class="row1">Judet: <span>*</span></td>
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
      <td class="row1">Localitate; <span>*</span></td>
      <td class="row1">
					<div id="localitate_ajax_addfirm" >
					{LOC_DIV_ADAUGAFIRMA}
					</div>
			</td>
  </tr>
<tr> 
	<td class="row1">Descriere anunt:<span>*</span>
	<br>
	<font size="" color="ff0000">Va rugam specificati datele de contact - telefon, adresa de email </font>pentru a fi contactat de cei care vizualizeaza anuntul dvs.</td>
	<td class="row1"> <textarea name="continut" rows="15" cols="50" onkeydown="CountChars(continut, 1500)">{CONTINUT}</textarea>
	<br />Caractere disponibile :<input readonly type="text" name="caractere_continut" size="3" value="1500">
	</td>
</tr>
<tr> 
<td class="row1">Imagine:</td>
	<td class="row1"><img src="{THUMBNAIL}" ></td>
</tr>
<tr> 
	<td class="row1">Modifica imagine: <br /><!-- Latimea maxima :{MAX_PICTURE_WIDTH} px --></td>
	<td class="row1"><br /><input type="file" name="imagine" ></td>
</tr>
<tr> 
	<td class="row2" colspan="2" valign="center"><input type="hidden" name="meta_description" value="{META_DESCRIPTION}" />
		<input type="hidden" name="meta_keywords" value="{META_KEYWORDS}" /><input name="Submit" value="Modifica" type="submit" class="button">
	</td>
</tr>
</table>
</form>

<table border="0" cellspacing="1" cellpadding="4" width="100%" class="big_table form">
<tr>
	<td class="table_subhead"><b>Ajutor pentru dvs.</b></td>
</tr>
<tr>
	<td>
			<li>Anuntul dvs. a fost adaugat in data de: <b>{SUBMISION_DATE}</b></li>
			<li>Anuntul dvs. va fi activ pana in data de :<b>{EXPIRE_DATE}</b></li>
			<li>Anuntul dvs. va ramne valabil timp de 6 luni. Acesta se poate sterge sau se poate prelungi.</li>
	</td>
</tr>
</table>