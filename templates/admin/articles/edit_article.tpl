<!-- Commercial plugins -->
<script language="javascript" type="text/javascript" src="../third_party/tinymce/jscripts/mcfilemanager.js"></script>
<script language="javascript" type="text/javascript" src="../third_party/tinymce/jscripts/mcimagemanager.js"></script>
<!-- /Commercial plugin -->

<!-- tinyMCE -->
<script language="javascript" type="text/javascript" src="../third_party/tinymce/jscripts/tiny_mce.js"></script>

<script language="javascript" type="text/javascript">
	tinyMCE.init({
		mode : "exact",
		elements : "continut",
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
<table border="0" cellspacing="0" cellpadding="0" width="95%">
<tr>
	<td>{INFORMATION}</td>
</tr>
</table>

<br />
<form method="post" action="?page=articles.sendemail.{ID}.{USER_ID}.{BIG_CAT_ID}" name="">
	<table border="0" cellspacing="1" cellpadding="4" width="95%" class="grey">
	<tr>
		<td class="tbhead">Trimite email:</td>
		<td class="tbhead">
			<select name="emailform">
				<option value="articol_activat" selected>Articol activat</option>
				<option value="articol_dezactivat">Articol dezactivat</option>
				<option value="general">Email General</option>
			</select>
		</td>
		<td class="tbhead" align="center"><input type="submit" name="sbmtbtn" value="Trimite" /></td>
		<td class="tbhead" align="center" style="color:red;">{EMAILACTIVARE}</td>
	</tr>
	</table>
		<input type="hidden" name="autorr" value="{AUTOR}" />
		<input type="hidden" name="emaill" value="{EMAIL}" />
		<input type="hidden" name="titluu" value="{TITLU}" />
</form>
<br />
<input type="hidden" name="user_id" value="{USER_ID}" />
<form method="post" action="?page=articles.save_edit.{ID}" enctype="multipart/form-data">
	<table width="95%" class="grey" cellpadding="4" cellspacing="1">
		<tr>
			<td class="tbhead" colspan="2">Edit article &nbsp;&nbsp;&nbsp;<a href="?page=users.details.{USER_ID}">add by: {USER_ID}</a>, Vizite {NR_VISTS_ART}</td>
		</tr>
		<tr>
			<td class="bgmain">Content</td>
			<td class="bgmain">Additional Information</td>
		</tr>
		<tr>
			<td class="{BGCOLOR1}" valign="top"><input type="hidden" name="user_id" value="{USER_ID}" />
				<textarea name="continut" id="continut" rows="25" cols="90">{CONTINUT}</textarea>
			</td>
			<td class="{BGCOLOR2}" valign="top">
				<table border="0" class="grey" cellpadding="4" cellspacing="1">
					<tr class="{BGCOLOR1}">
						<td width="30%"><b>Alege categorie</b><p class="star">*</p></td>
						<td colspan="2">
							<select name="category_id">
								<option value="0">Select</option>
								<!-- BEGIN categories -->
										<option value="{CATEGORY_ID}" {SELECTED_CAT}> ... {CATEGORY_NAME}</option>
									<!-- END categories -->
								</select>
						</td>
					</tr>
					<tr> 
						<td class="{BGCOLOR1}"><b>Titlu articol</b><p class="star">*</p></td>
						<td class="{BGCOLOR2}"><input name="titlu" size="42"  value="{TITLU}" type="text" ></td>
				</tr> 

				<tr> 
						<td class="{BGCOLOR1}"><b>Autor</b>:</td>
						<td class="{BGCOLOR2}"><input name="autor" size="42"  value="{AUTOR}" type="text" ></td>
				</tr> 
				<tr> 
						<td class="{BGCOLOR1}"><b>Email</b>:</td>
						<td class="{BGCOLOR2}"><input name="email" size="42"  value="{EMAIL}" type="text" ></td>
				</tr> 	
					<tr >
						<td valign="top" class="{BGCOLOR1}"><b>Meta Keywords</b></td>
						<td class="{BGCOLOR2}">
							<textarea name="meta_keywords" rows="4" cols="40">{META_KEYWORDS}</textarea>
						</td>
					</tr>
					<tr >
						<td  class="{BGCOLOR1}"><strong>Meta Description</strong></td>
						<td class="{BGCOLOR2}">
							<textarea name="meta_description" rows="4" cols="40">{META_DESCRIPTION}</textarea>
						</td>
					</tr>
					<tr >
						<td  class="{BGCOLOR1}"><strong>Tags</strong><br>Words sperated by " , "</td>
						<td class="{BGCOLOR2}">
							<textarea name="tags" rows="4" cols="40">{TAGS}</textarea>
						</td>
					</tr>
					<tr> 
					<td class="{BGCOLOR1}">Imagine</td>
						<td class="{BGCOLOR2}"><img src="{THUMBNAIL}" ></td>
					</tr>
					<tr>
					<td class="{BGCOLOR1}">Adauga imagine <br />Latimea maxima :{MAX_PICTURE_WIDTH} px</td>
					<td class="{BGCOLOR2}"><input type="file" name="imagine"></td>
				</tr>
				<tr> 
					<td class="{BGCOLOR1}">Modifica nume imagine  <br /></td>
					<td class="{BGCOLOR2}"><br /><input type="text" name="nume_imagine" value="{NUME_IMAGINE}" size="60">
				<input type="hidden" name="nume_img_vechi" value="{NUME_IMAGINE}"></td>
			</tr>
			<tr> 
				 <td class="row2" colspan="2"><B>Articol in format electronic</B> </td>
			</tr>
			<tr>
				<td class="row1">{ARTICOL_FILE}</td>
				<td class="row1"><input type="file" name="articol_file" size='30' value="" ><br>Puteti adauga fisiere cu extensia PDF sau fisiere Microsoft Office</td>
			</tr>
				</table>
			</td>
		</tr>
		<tr class="{BGCOLOR1}">
			<td align="center" width="100%" colspan="2">
				<input type="submit" value="Update" class="button" />
			</td>
		</tr>
	</table>
</form>
<br>

<table>
<tr>
			<form method="post" action="?page=articles.add_redirect.{ID}" enctype="multipart/form-data">
			 <td class="bgmain" width="8%"><input type="submit" value="Add to redirect" class="button" /></td>
			</form>
	</tr>
</table>

<table width="65%" class="grey" cellpadding="4" cellspacing="1">
	<tr>
		<td class="tbhead" colspan="10">LIST ALL Related ARTICLES &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[ {ALL_RELATED} ]</td>
	</tr>
	<tr>
			<td class="bgmain" width="5%">ID RELATED</td>
			<td class="bgmain" width="60%">TITLE</td>
			<td class="bgmain" width="10%">Related</td>
			<td class="bgmain" width="8%">Delete</td>
			
	</tr>
		<!-- BEGIN articole_related -->
			<tr class="{BGCOLOR1}">
				<td><a href="?page=articles.edit.{REALATED_ID}" title='View "{ARTICLE_REALATED_TITLE}" ' target="_blank">{REALATED_ID}</a></td>
				<td><b><a href="{ARTICLE_RELATED_LINK}" title='View "{ARTICLE_REALATED_TITLE}" ' target="_blank">{ARTICLE_REALATED_TITLE}</a></b></td>
				
				<td align="center" valign="top">[	<a href="?page=articles.related.add.{REALATED_ID}.{ID}" title='Make related "{ARTICLE_REALATED_TITLE}" article'>{REALATED_ALREADY} make related </a> ]
				</td>
				<td align="center" valign="top">[	<a href="?page=articles.related.delete.{REALATED_ID}.{ID}" title='Delete "{ARTICLE_REALATED_TITLE}" article'>Delete </a> ]
					
				</td>
			</tr>
		<!-- END articole_related -->
	<tr>
			<form method="post" action="?page=articles.related.add.{ID}" enctype="multipart/form-data">
			<td class="tbhead" colspan="3" align="left">Add new related ID: &nbsp;<input type="text" name="new_related" size="50"></td>
			<td class="bgmain" width="8%"><input type="submit" value="Add related" class="button" /></td>
			</form>
	</tr>

	
</table>

