<table align="center" border="0" cellspacing="0" cellpadding="0" width="75%">
	<tr>
		<td>
			{INFORMATION}
			<table border="0" cellspacing="0" cellpadding="0" width="100%">
				<tr>
					<td valign="top">
						<form method="post" action="?page=contact.save.{ID}">
							<table width="100%" class="grey" cellpadding="4" cellspacing="1" border="0">
								<tr>
									<td class="tbhead" colspan="10">Edit "{NAME}" form field</td>
								</tr>
								<tr>
									<td class="row2" width="50%"><b>Field Title</b><p class="star">*</p></td>
									<td class="row1"><input type="text" name="name" value="{NAME}" size="58"/></td>
								</tr>
								<tr>
									<td class="row2"><b>Field Type</b><p class="star">*</p></td>
									<td class="row1">
										<select name="field_type">
											<!-- BEGIN field_type -->
												<option value="{FIELD_VALUE}" {FIELD_SELECTED}>{FIELD_VALUE}</option>
											<!-- END field_type -->
										</select>
									</td>
								</tr>
								<tr>
									<td class="row2"><b>Content Type</b><p class="star">*<br /> if selected field type is textbox or textarea</p></td>
									<td class="row1">
										<select name="content_type">
											<!-- BEGIN content_type -->
												<option value="{CONTENT_VALUE}" {CONTENT_SELECTED}>{CONTENT_VALUE}</option>
											<!-- END content_type -->
										</select>
									</td>
								</tr>
								<tr>
									<td class="row2" valign="top"><b>Option Values</b><p class="star">* <br /> for pulldown lists, checkboxes and radio buttons please enter the values separated by comma.</p></td>
									<td class="row1">
										<textarea name="option_values" rows="3" cols="55">{OPTION_VALUES}</textarea>
									</td>
								</tr>
								<tr>
									<td class="row2"><b>Used</b><p class="star">*</p></td>
									<td class="row1">
										<select name="used">
											<option value="Y" {USED_Y}>Yes</option>
											<option value="N" {USED_N}>No</option>
										</select>
									</td>
								</tr>
								<tr>
									<td class="row2"><b>Required</b><p class="star">*</p></td>
									<td class="row1">
										<select name="required">
											<option value="Y" {REQUIRED_Y}>Yes</option>
											<option value="N" {REQUIRED_N}>No</option>
										</select>
									</td>
								</tr>
								<tr>
									<td class="row2" valign="top"><b>Error message</b><p class="star">*<br /> if "{NAME}" field is required</p></td>
									<td class="row1">
										<textarea name="error_message" rows="3" cols="55">{ERROR_MESSAGE}</textarea>
									</td>
								</tr>
								<tr class="row1">
									<td colspan="2" align="center">
										<input type="submit" class="button" value="Save Changes" />
									</td>
								</tr>
							</table>
						</form>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>