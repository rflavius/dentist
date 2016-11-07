<table border="0" cellspacing="0" cellpadding="0" width="95%">
<tr>
	<td>{INFORMATION}</td>
</tr>
</table>

<br />
<input type="hidden" name="user_id" value="{USER_ID}" />
<form method="post" action="?page=dictionar_medical.save_edit.{ID}" enctype="multipart/form-data">
	<table width="95%" class="grey" cellpadding="4" cellspacing="1">
		<tr>
			<td class="tbhead" colspan="2">Editeaza termen medical </td>
		</tr>
		<tr>
			<td class="bgmain">Content</td>
			<td class="bgmain">Additional Information</td>
		</tr>
		<tr>
			<td class="{BGCOLOR1}" valign="top">
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