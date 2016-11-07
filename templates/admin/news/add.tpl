<!-- Commercial plugins -->
<script language="javascript" type="text/javascript" src="../third_party/tinymce/jscripts/mcfilemanager.js"></script>
<script language="javascript" type="text/javascript" src="../third_party/tinymce/jscripts/mcimagemanager.js"></script>
<!-- /Commercial plugin -->

<!-- tinyMCE -->
<script language="javascript" type="text/javascript" src="../third_party/tinymce/jscripts/tiny_mce.js"></script>

<script language="javascript" type="text/javascript">
	tinyMCE.init({
		mode : "exact",
		elements : "content",
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
<table align="center" border="0" cellspacing="0" cellpadding="0" width="80%" >
	<tr>
		<td>
			{INFORMATION}
			<form method="post" action="?page=news.insert" enctype="multipart/form-data">
				<table width="100%" class="grey" cellpadding="4" cellspacing="1">
					<tr>
						<td class="tbhead" colspan="10">Edit news</td>
					</tr>
					<tr>
						<td width="40%" class="{BGCOLOR2}"><b>News title</b><p class="star">*</p></td>
						<td width="60%" class="{BGCOLOR1}">
							<input type="text" name="title" value="{TITLE}" size="100"/>
						</td>
					</tr>
					<tr>
						<td class="{BGCOLOR2}" valign="top" colspan="2"><b>Content</b><p class="star">*</p></td>
					</tr>
					<tr>
						<td class="{BGCOLOR1}" colspan="2">
							<textarea name="content" rows="30" cols="125">{CONTENT}</textarea>
						</td>
					</tr>
					<tr >
						<td valign="top"class="{BGCOLOR2}"><b>Meta Keywords</b></td>
						<td class="{BGCOLOR1}">
							<textarea name="meta_keywords" rows="5" cols="50">{META_KEYWORDS}</textarea>
						</td>
					</tr>
					<tr >
						<td  class="{BGCOLOR2}"><strong>Meta Description</strong></td>
						<td class="{BGCOLOR1}">
							<textarea name="meta_description" rows="5" cols="50">{META_DESCRIPTION}</textarea>
						</td>
					</tr>
					<tr> 
						<td class="{BGCOLOR1}">Adauga imagine <br />Latimea maxima :{MAX_PICTURE_WIDTH} px</td>
						<td class="{BGCOLOR2}"><input type="file" name="imagine"></td>
					</tr>
									
					<tr>
						<td class="{BGCOLOR2}"><b>Published</b></td>
						<td class="{BGCOLOR1}">
							<select name="status">
								<option value="1" {SEL_AC}>Yes</option>
								<option value="0" {SEL_IN}>No</option>
							</select>
						</td>
					</tr>
													
					<tr>
						<td class="{BGCOLOR2}"><b>Data evenimentului</b> format 2008-23-03 an/ll/zi</td>
						<td class="{BGCOLOR1}"><input type="text" name="event_date" value="{EVENT_DATE}" />
							
						</td>
					</tr>
							<tr>
						<td class="{BGCOLOR2}"><b>Locul evenimentului</b></td>
						<td class="{BGCOLOR1}"><input type="text" name="place" value="{PLACE}" />
							
						</td>
					</tr>
					<tr class="{BGCOLOR1}">
						<td colspan="2" align="center">
							<input type="submit" class="button" value="Save" />
						</td>
					</tr>
				</table>
			</form>
		</td>
	</tr>
</table>