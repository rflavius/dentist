<!-- Commercial plugins -->
<script language="javascript" type="text/javascript" src="../third_party/tinymce/jscripts/mcfilemanager.js"></script>
<script language="javascript" type="text/javascript" src="../third_party/tinymce/jscripts/mcimagemanager.js"></script>
<!-- /Commercial plugin -->

<!-- tinyMCE -->
<script language="javascript" type="text/javascript" src="../third_party/tinymce/jscripts/tiny_mce.js"></script>

<script language="javascript" type="text/javascript">
	tinyMCE.init({
		mode : "exact",
		elements : "cabinet_content",
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

<table align="center" border="0" cellspacing="0" cellpadding="0" width="97%">
	<tr>
		<td>
			{INFORMATION}
			<form method="post" action="?page=pages.insert" enctype="multipart/form-data">
				<table width="100%" class="grey" cellpadding="4" cellspacing="1">
					<tr>
						<td class="tbhead" colspan="2">Add new page</td>
					</tr>
					<tr>
						<td class="bgmain">Content</td>
						<td class="bgmain" width="35%">Additional Information</td>
					</tr>
					<tr>
						<td class="{BGCOLOR1}" valign="top" align="center">
							<textarea name="content" id="cabinet_content" rows="45" cols="97">{CONTENT}</textarea>
						</td>
						<td class="{BGCOLOR2}" valign="top">
							<table border="0" class="grey" cellpadding="4" cellspacing="1">
								<tr class="{BGCOLOR1}">
									<td width="50%"><b>Page title</b><p class="star">*</p></td>
									<td width="50%">
										<input type="text" name="name" value="{NAME}" />
									</td>
								</tr>
								<tr>
									<td class="link_hint" colspan="2">The <b>Page Url</b> must be provided using only numbers and lowercased letters. You can separate words using the <b>subtraction (-)</b> sign.<br />Providing <b>new-page</b> it will result <b>new-page{FILE_EXTENSION}</b></td>
								</tr>
								<tr class="{BGCOLOR1}">
									<td><b>Page Url</b><p class="star">*</p></td>
									<td>
										<input type="text" name="link" value="{LINK}" />
									</td>
								</tr>
								<tr class="{BGCOLOR1}">
									<td valign="top"><b>Meta keywords</b></td>
									<td>
										<textarea name="meta_keywords" rows="5" cols="25">{META_KEYWORDS}</textarea>
									</td>
								</tr>
								<tr class="{BGCOLOR1}">
									<td valign="top" nowrap><b>Meta description</b></td>
									<td>
										<textarea name="meta_description" rows="5" cols="25">{META_DESCRIPTION}</textarea>
									</td>
								</tr>
								<tr class="{BGCOLOR1}">
									<td><b>Published</b></td>
									<td>
										<select name="status">
											<option value="1" {SEL_AC}>Yes</option>
											<option value="0" {SEL_IN}>No</option>
										</select>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr class="{BGCOLOR1}">
						<td colspan="2" align="center">
							<input type="submit" class="button" value="Add Page" />
						</td>
					</tr>
				</table>
			</form>
		</td>
	</tr>
</table>