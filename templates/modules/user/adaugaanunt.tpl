<script type="text/javascript" src="{SITE_BASEE}/templates/js/prototype.js"></script>
<script language="javascript" type="text/javascript">
<!--
function CompleteLocalitateFront()
	{
		var target ='localitate_ajax_addfirm'; 
		var url="./sources/ajax_search.php?tpl_selected=addfirm&search_judet="+document.adauga_anunt.judetselectat.value;
	
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
<div class="error_messages" style="border:none;">{ERROR_MSG}</div>
<!-- END error -->
<!-- BEGIN display_anunt -->
<form name="adauga_anunt" method="post" action="{INSERT_ANUNT}" enctype="multipart/form-data">
<table border="0" cellpadding="4" cellspacing="1" width="100%" class="text">
 <tr> 
		<td colspan="2"><div class="first_word"> Doriti</div> sa adaugati un anunt, aici este locul potrivit. Complectati formularul de mai jos si anuntul dvs. va fi publicat pe site-ul nostru, dar intai acesta va fi verificat de administrator de accea exista posibilitatea ca anuntul sa apara urmatoarea zi.<br /><br />
		</td>
</tr>
<tr> 
	<td class="text2" width="30%">Categoria: <span>*</span></td>
		<td>
				<select name="category_id" >
					<!-- BEGIN display_cats -->
					<option value="{CAT_ID}" {SELECTTEDCAT}>{CAT_NAME}</option>
					<!-- END display_cats -->
			</select>
	</td>
</tr>
	
<tr> 
		<td class="text2">Titlu anunt:<span>*</span></td>
		<td><input name="titlu" size="42"  value="{TITLU}" type="text" ></td>
</tr> 
<tr> 
		<td class="text2">Autor:<span>*</span></td>
		<td><input name="autor" size="42"  value="{AUTOR}" type="text" ></td>
</tr> 
<tr> 
		<td class="text2">Email: <span>*</span></td>
		<td><input name="email" size="42"  value="{EMAIL}" type="text" ></td>
</tr> 

<tr> 
	<td class="text2">Judet: <span>*</span></td>
	<td>
			<select name="judet" id="judetselectat" onchange="CompleteLocalitateFront();" class="select_option_style" >
					<option value="">Alege Judet</option>
				<!-- BEGIN judet -->
				<option value="{COD_JUDET}" {JUDET}>{NUMEJUDET}</option>
				<!-- END judet -->
			</select>
	</td>
  </tr>
	<tr> 
      <td class="text2">Localitate: <span>*</span></td>
      <td>
					<div id="localitate_ajax_addfirm" >
					{LOC_DIV_ADAUGAFIRMA}
					</div>
			</td>
</tr>
		
<tr> 
	<td class="text2">Descriere anunt:<span>*</span> </td>
	<td> <textarea name="continut_anunt" rows="15" cols="50" onkeydown="CountChars(continut_anunt, 1500)">{CONTINUT_ANUNT}</textarea>
	<br />Caractere disponibile :<input readonly type="text" name="caractere_continut_anunt" size="3" value="1500">
	</td>
</tr>

<tr> 
	<td class="text2">Adauga imagine: <br /></td>
	<td><input type="file" name="imagine" size="30"></td>
</tr>
<tr> 
	<td><input type="hidden" name="meta_description" value="{META_DESCRIPTION}" />
		<input type="hidden" name="meta_keywords" value="{META_KEYWORDS}" />
	</td>
</tr>
</table>
<div align="center"><input name="Submit" value="Adauga" type="submit"  class="button"></div>
</form>

<table border="0" cellspacing="4" cellpadding="1" class="text">
<tr>
	<td class="attention_albastru"><b>Atentie!</b></td>
</tr>
<tr>
	<td><li>Campurile cu * sunt obligatorii .</li></td>
</tr>
<tr>
	<td> <li>Pe aceasta <b>adresa de email</b> veti primi oferte cu privire la anuntul dvs.</li></td>
</tr>
<tr>
	<td>
	<li>Anuntul dvs. va ramne valabil timp de 6 luni,daca veti dori sa il stergeti aveti acesta posiblilitatea din meniul dvs. de membru al site-ului dentistonline.ro. </li></td>
</tr>
<!-- cu plata<tr>
	<td>Doar daca aveti cel putin un cabinet, clinica, laborator adugat, atunci veti putea aduga gratuit anunturi pe acest site. Anuntul dvs. trebuie sa respecte <a href="{TERMENIICONDITII}">Termenii si Conditiile</a> noastre.</td>
</tr> -->
</table>
<!-- END display_anunt -->
<table border="0" cellspacing="0" cellpadding="0" align="center" >
<tr>
	<td align="center">{NO_FIRM_ADD}</td>
</tr>
</table>
