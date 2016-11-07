<script type="text/javascript" src="{SITE_BASEE}/templates/js/prototype.js"></script>
<!-- Commercial plugins -->
<script language="javascript" type="text/javascript" src="../third_party/tinymce/jscripts/mcfilemanager.js"></script>
<script language="javascript" type="text/javascript" src="../third_party/tinymce/jscripts/mcimagemanager.js"></script>
<!-- /Commercial plugin -->

<!-- tinyMCE -->
<script language="javascript" type="text/javascript" src="../third_party/tinymce/jscripts/tiny_mce.js"></script>

<script language="javascript" type="text/javascript">
	tinyMCE.init({
		mode : "exact",
		elements : "continut_anunt",
		theme : "advanced",
/*REMOVED PLUGINS : advimage, advlink*/
/*THIS LITTLE FUCKER KILLS EVERYTHING ON I.E. . DON'T USE IT : contextmenu*/
		plugins : "table,insertdatetime,preview,searchreplace,paste,directionality,noneditable",
/*TOTTALY REMOVED ELEMENTS : visualaid, unlink, anchor, save, newdocument, help, removeformat, iespell, flash, advhr, emotions, print, fullscreen*/
/*bold, italic, underline : editor_template.js -- theme_advanced_buttons1*/
		theme_advanced_buttons1_add : "strikethrough,separator,formatselect,fontselect,fontsizeselect",
/*cut,copy,paste,pastetext,pasteword : editor_template.js -- theme_advanced_buttons2*/
		theme_advanced_buttons2_add : "separator,justifyleft,justifycenter,justifyright,justifyfull,separator,search,replace,separator,bullist,numlist,separator,outdent,indent",
/*tablecontrols,separator : editor_template.js -- theme_advanced_buttons3*/
		theme_advanced_buttons3_add : "undo,redo,separator,charmap",
/*ltr,rtl : editor_template.js -- theme_advanced_buttons4*/
		theme_advanced_buttons4_add : "separator,sub,sup,separator,hr,separator,cleanup,separator,link,image,separator,forecolor,backcolor,separator,insertdate,inserttime,preview,separator,code",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_path_location : "bottom",
		content_css : "../templates/skins/default/style.css",
		plugin_insertdate_dateFormat : "%Y-%m-%d",
		plugin_insertdate_timeFormat : "%H:%M:%S",
		extended_valid_elements : "hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style]",
		file_browser_callback : "mcFileManager.filebrowserCallBack",
		theme_advanced_resize_horizontal : true,
		theme_advanced_resizing : true
	});
</script>
<!-- /tinyMCE -->

<!-- BEGIN error -->
<div class="error" style="border:#D5D5D5;">{ERROR_MSG}</div>
<br>
<!-- END error -->

<!-- BEGIN display_anunt -->
<form name="adauga_anunt" method="post" action="{INSERT_ARTICOL}" enctype="multipart/form-data">
<table border="0" cellpadding="4" cellspacing="1" width="100%" class="big_table form">
 <tr> 
		<td colspan="2" class="table_subhead" > Mai <i><u>multe articole</u></i> vor aduce mai <i><u>multi vizitatori</u></i> ofertei tale si implicit mai <i><u>multi pacienti</u></i>.
		</td>
</tr>
 <tr> 
		<td colspan="2" > Informatiile oferite de <b>tine</b> vor ajuta si vor fi folositoare miilor de utilizatori care viziteaza acest website. Investeste in imaginea ta !! 
		</td>
</tr>

<tr> 
	<td class="row1" width="30%">Categoria: <span>*</span></td>
		<td class="row1">
				<select name="category_id" >
					<!-- BEGIN display_cats -->
					<option value="{CAT_ID}" {SELECTTEDCAT}>{CAT_NAME}</option>
					<!-- END display_cats -->
			</select>
	</td>
</tr>
	
<tr> 
		<td class="row2">Titlu articol:<span>*</span></td>
		<td class="row2"><input name="titlu" size="42"  value="{TITLU}" type="text" ></td>
</tr> 
<tr> 
		<td class="row1">Autor:<span>*</span></td>
		<td class="row1"><input name="autor" size="42"  value="{AUTOR}" type="text" ></td>
</tr> 
<tr> 
		<td class="row2">Email: <span>*</span></td>
		<td class="row2"><input name="email" size="42"  value="{EMAIL}" type="text" ></td>
</tr> 


<tr> 
	<td class="row1" colspan="2">Continut articol:<span>*</span> </td>
</tr>

		
<tr> 
	<td class="row1" colspan="2"> <textarea name="continut_anunt" rows="30" cols="65" >{CONTINUT_ANUNT}</textarea>
	
	</td>
</tr>

<tr> 
	<td class="row2" >Adauga imagine: <br /></td>
	<td class="row2"><input type="file" name="imagine" size="43"></td>
</tr>
	<tr> 
      <td class="row1">Adauga Fisier Articol <p style="font-size:10px;"><i>Puteti adauga fisier PDF sau fisier Microsoft Office</i></p>.</td>
       <td class="row2">
			<input  type="file" name="articol_file" size="43"> 
			</td>
	</tr>
<tr > 
	<td class="row1" colspan="2" align="center"><input type="hidden" name="meta_description" value="{META_DESCRIPTION}" />
		<input type="hidden" name="meta_keywords" value="{META_KEYWORDS}" />
		<input name="Submit" value="Adauga" type="submit" align="center" class="button">
	</td>
</tr>

</table>
</form>

<table border="0" cellspacing="4" cellpadding="1" class="text">
<tr>
	<td class="attention_albastru"><b>Atentie!</b></td>
</tr>
<tr>
	<td><li>Campurile cu * sunt obligatorii .</li></td>
</tr>
<tr>
	<td>
	<li>Veti primi un email cand articolul dvs. va fi activat. </li></td>
</tr>
</table>
<!-- END display_anunt -->

<table border="0" cellspacing="0" cellpadding="0" align="center" class="big_table form">
<tr>
	<td align="center" class="table_subhead">{NO_FIRM_ADD}</td>
</tr>
</table>

<table border="0" cellspacing="0" cellpadding="0" width="100%" class="big_table form">
<tr>
	<td >Promoveaza-ti imaginea cabinetului tau si prin articolele adaugate. Mai multe articole - implicit mai multi vizitatori pentru cabinetul, clinica, laboratorul, depozitul tau. Articolele bine detaliate si cu <b>imagine</b> sunt postate pe <b>prima pagina</b> a site-ul nostru pentru o anumita perioada de timp.</td>
</tr>
<tr>
	<td ><a href="{USERADDARTICOL}"><img src="../images/promovare_articole.jpg"></a><br><br></td>
</tr>
</table>


