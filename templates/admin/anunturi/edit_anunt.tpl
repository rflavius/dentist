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
<!-- BEGIN error -->
<div id="error_messages"><br />{ERROR_MSG}</div>
<!-- END error -->
<br />
<form method="post" action="?page=anunturi.sendemail.{ID_ANUNT}.{ID_USER}" name="">
	<table border="0" cellspacing="1" cellpadding="4" width="80%" class="grey">
	<tr>
		<td class="tbhead">Trimite email:</td>
		<td class="tbhead">
			<select name="emailform">
				<option value="anunt_activat" selected>Anunt activat</option>
				<option value="anunt_dezactivat">Anunt dezactivat</option>
			</select>
		</td>
		<td class="tbhead" align="center"><input type="submit" name="sbmtbtn" value="Trimite" /></td>
		<td class="tbhead" align="center">Vizite: {NR_VISITS}</td>
	</tr>
	</table>
		<input type="hidden" name="autorr" value="{AUTOR}" />
		<input type="hidden" name="emaill" value="{EMAIL}" />
		<input type="hidden" name="titluu" value="{TITLU}" />
</form>
<br />

<table border="0" cellspacing="1" cellpadding="4" width="80%" >
	<tr>
		<td style="color:red;">{EMAILACTIVARE}</td>
		</tr>
</table>
<form name="edit_anunt" method="post" action="{UPDATE_ANUNT}" enctype="multipart/form-data">
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
		<td class="{BGCOLOR1}">Alias<span>*</span></td>
		<td class="{BGCOLOR2}"><input name="alias" size="42"  value="{ALIAS}" type="text" ></td>
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
		<td class="{BGCOLOR1}">Comments <span">*</span></td>
		<td class="{BGCOLOR2}"><textarea name="comments" rows="5" cols="30">{COMMENTS_TEXT}</textarea></td>
</tr> 
<tr> 
	<td class="{BGCOLOR1}"> Descriere anunt <span>*</span></td>
	<td class="{BGCOLOR2}"> <textarea name="continut" rows="40" cols="90" onkeydown="CountChars(continut, 2000)">{CONTINUT}</textarea><br />
	Caractere disponibile :<input readonly type="text" name="caractere_continut" size="3" value="2000">
	</td>
</tr>
<tr>
<td class="{BGCOLOR1}">Imagine</td>
	<td class="{BGCOLOR2}"><img src="{THUMBNAIL}" ></td>
</tr>
<tr> 
	<td class="{BGCOLOR1}">Modifica imagine <br />Latimea maxima :{MAX_PICTURE_WIDTH} px</td>
	<td class="{BGCOLOR2}"><br /><input type="file" name="imagine"></td>
</tr>
<tr> 
	<td class="{BGCOLOR1}">Modifica nume imagine  <br /></td>
	<td class="{BGCOLOR2}"><br /><input type="text" name="nume_imagine" value="{NUME_IMAGINE}" size="80">
	<input type="hidden" name="nume_img_vechi" value="{NUME_IMAGINE}"></td>
</tr>
</table>
<div align="center"><br />
<input name="Submit" value="Modifica" type="submit" class="button"></div>
</form>

<table border="0" cellspacing="4" cellpadding="1" align="left" style="padding-left:30px;" >
<tr>
	<td>Anuntul a fost adaugat in data de: {SUBMISION_DATE}</td>
</tr>
<tr>
	<td>Anuntul va fi activ pana in data de :{EXPIRE_DATE}</td>
</tr>
</table>