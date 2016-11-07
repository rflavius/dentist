<table border="0" cellspacing="1" cellpadding="4" width="90%">
	<!-- BEGIN if_errors -->
	<tr>
		<td colspan="2" class="{MESSAGE_STYLE}">
		{INFORMATION}
		</td>
	</tr>
	<!-- END if_errors -->
</table>

<form method="post" action="?page=articles.categories.save.{ID}"  enctype="multipart/form-data">
<br>
	<table width="50%" class="grey" cellpadding="4" cellspacing="1">
		<tr>
			<td class="tbhead" colspan="10">Edit {NAME} category</td>
		</tr>
		<tr>
			<td width="50%" class="{BGCOLOR2}"><b>Id</b></td>
			<td width="50%" class="{BGCOLOR1}">{ID}</td>
		</tr>

		<tr>
			<td class="{BGCOLOR2}"><b>Name</b><p class="star">*</p></td>
			<td class="{BGCOLOR1}"><input type="text" name="cat_name"size="50" value="{CAT_NAME}" /></td>
		</tr>

		<tr >
			<td  class="{BGCOLOR2}" valign="top"><b>Meta Keywords</b></td>
			<td class="{BGCOLOR1}">
				<textarea name="meta_keywords" rows="4" cols="50">{META_KEYWORDS}</textarea>
			</td>
		</tr>

		<tr >
			<td class="{BGCOLOR2}"><strong>Meta Description</strong></td>
			<td class="{BGCOLOR1}">
				<textarea name="meta_description" rows="4" cols="50">{META_DESCRIPTION}</textarea>
			</td>
		</tr>

		<tr >
			<td class="{BGCOLOR2}"><strong>Image</strong></td>
			<td class="{BGCOLOR1}">
				<img src="{IMAGE_CATEGORY}" >
			</td>
		</tr>
		<tr>
					<td class="{BGCOLOR1}">Adauga imagine <br />Latimea maxima 40px</td>
					<td class="{BGCOLOR2}"><input type="file" name="imagine"></td>
		</tr>
	
		<tr class="{BGCOLOR1}">
			<td colspan="2" align="center">
				<input type="submit" class="button" value="Save Changes" />
			</td>
		</tr>
	</table>
</form>