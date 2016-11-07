	<script type="text/javascript" src="{SITE_BASEE}/templates/js/prototype.js"></script>

<!-- Commercial plugins -->
<script language="javascript" type="text/javascript" src="./third_party/tinymce/jscripts/mcfilemanager.js"></script>
<script language="javascript" type="text/javascript" src="./third_party/tinymce/jscripts/mcimagemanager.js"></script>
<!-- /Commercial plugin -->

<!-- tinyMCE -->
<script language="javascript" type="text/javascript" src="./third_party/tinymce/jscripts/tiny_mce.js"></script>
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
		content_css : "./templates/skins/default/style.css",
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
<div id="error_messages" style="border:none;"><br />{ERROR_MSG}</div>
<!-- END error -->
<form name="edit_anunt" method="post" action="{UPDATE_ARTICOL}" enctype="multipart/form-data">
<table border="0" cellpadding="4" cellspacing="1" width="100%" class="text">
<tr> 
	<td class="text2">Categoria: <span>*</span></td>
		<td>	{CAT_NAME}<input type="hidden" name="category_id" value="{CAT_ID}" /></td>
</tr>
	
<tr> 
		<td class="text2">Titlu articol: <span>*</span></td>
		<td><input name="titlu" size="42"  value="{TITLU}" type="text" readonly></td>
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
	<td class="text2" colspan="2">Continut articol:<span>*</span> </td>
</tr>

		
<tr> 
	<td colspan="2"> <textarea name="continut_anunt" rows="30" cols="65" >{CONTINUT}</textarea>
	
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
	<td><li>Articolul  dvs. a fost adaugat in data de: <b>{SUBMISION_DATE}</b></li></td>
</tr>
</table>