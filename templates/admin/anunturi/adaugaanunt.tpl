<script language="javascript" type="text/javascript">
<!--
	function CompleteLocalitate()
	{
		var target ='localitate_ajax_addfirm'; 
		var url="../sources/ajax_search.php?tpl_selected=addfirm&search_judet="+document.adauga_anunt.judet.value;
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
		
		document.forms['adauga_anunt']['caractere_'+field.name].value = maxcaractere - field.value.length;
	}

//-->
</script>
<!-- BEGIN error -->
<div class="error_messages">{ERROR_MSG}</div>
<!-- END error -->
<br />

<form name="adauga_anunt" method="post" action="{INSERT_ANUNT}" enctype="multipart/form-data">
<table border="0" cellpadding="4" cellspacing="1" width="80%" class="grey">
<tr> 
	<td class="{BGCOLOR1}">Categoria <span>*</span></td>
		<td class="{BGCOLOR2}">
				<select name="category_id" >
					<!-- BEGIN display_cats -->
					<option value="{CAT_ID}" {SELECTTEDCAT}>{CAT_NAME}</option>
					<!-- END display_cats -->
			</select>
	</td>
</tr>
	
<tr> 
		<td class="{BGCOLOR1}">Titlu anunt<span>*</span></td>
		<td class="{BGCOLOR2}"><input name="titlu" size="42"  value="{TITLU}" type="text" ></td>
</tr> 

<tr> 
		<td class="{BGCOLOR1}">Autor:<span">*</span></td>
		<td class="{BGCOLOR2}"><input name="autor" size="42"  value="{AUTOR}" type="text" ></td>
</tr> 
<tr> 
		<td class="{BGCOLOR1}">Email <span">*</span></td>
		<td class="{BGCOLOR2}"><input name="email" size="42"  value="{EMAIL}" type="text" ></td>
</tr> 	
<tr> 
	<td class="{BGCOLOR1}">Judet <span>*</span></td>
	<td class="{BGCOLOR2}">
			<select name="judet" id="judet" onchange="CompleteLocalitate();" class="select_option_style" >
					<option value="">Alege Judet</option>
				<!-- BEGIN judet -->
				<option value="{COD_JUDET}" {JUDET}>{NUMEJUDET}</option>
				<!-- END judet -->
			</select>
	</td>
  </tr>
	<tr> 
      <td class="{BGCOLOR1}">Localitate <span>*</span></td>
      <td class="{BGCOLOR2}">
					<div id="localitate_ajax_addfirm" >
					{LOC_DIV_ADAUGAFIRMA}
					</div>
			</td>
</tr>
<tr> 
		<td class="{BGCOLOR1}">Meta keywords <span">*</span></td>
		<td class="{BGCOLOR2}"> <textarea name="meta_keywords" rows="5" cols="30">{META_KEYWORDS}</textarea></td>
</tr> 
<tr> 
		<td class="{BGCOLOR1}">Meta Description <span">*</span></td>
		<td class="{BGCOLOR2}"><textarea name="meta_description" rows="5" cols="30">{META_DESCRIPTION}</textarea></td>
</tr> 
<tr> 
	<td class="{BGCOLOR1}"> Descriere anunt <span>*</span></td>
	<td class="{BGCOLOR2}"> <textarea name="continut" rows="20" cols="80" onkeydown="CountChars(continut, 1500)">{CONTINUT}</textarea><br />
	Caractere disponibile :<input readonly type="text" name="caractere_continut" size="3" value="1500">
	</td>
</tr>
<tr> 
	<td class="{BGCOLOR1}">Adauga imagine <br />Latimea maxima :{MAX_PICTURE_WIDTH} px</td>
	<td class="{BGCOLOR2}"><input type="file" name="imagine"></td>
</tr>
</table>
<div align="center"><input name="Submit" value="Adauga" type="submit" class="button"></div>
</form>