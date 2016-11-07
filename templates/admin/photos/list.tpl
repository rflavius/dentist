<script LANGUAGE="JavaScript">
<!--
// Nannette Thacker http://www.shiningstar.net
function confirmSubmit()
{
var agree=confirm("Are you sure you want to delete selected photo ? It will be removed for ever! ");
if (agree)
	return true ;
else
	return false ;
}
// -->
</script>

<table align="center" border="0" cellspacing="0" cellpadding="0" width="90%">
	<tr>
		<td>
			{POSTSIZE_INFORMATION}
			{INFORMATION}
			<table border="0" cellspacing="1" cellpadding="4" width="100%">
				<tr>
					<td width="65%" valign="top">
						<table width="100%" class="grey" cellpadding="4" cellspacing="1">
							<tr>
								<td class="tbhead" colspan="6">List all photos</td>
							</tr>
							<tr>
								<td class="bgmain" nowrap>Picture name</td>
								<td class="bgmain">Thumbnail</td>
								<td class="bgmain">Width</td>
								<td class="bgmain">Height</td>
								<td class="bgmain">Size</td>
								<td class="bgmain">Delete</td>
							</tr>
							<!-- BEGIN if_photos  -->
							<!-- BEGIN photos -->
							<tr class="{BGCOLOR}">
								<td align="center" width="10%" valign="top"><b>{PICTURE_NAME}</b></td>
								<td align="center">
									<a href="../images/uploaded_photos/{PICTURE}" target="_blank">
										<img width="150" src="../images/uploaded_photos/{PICTURE}" title="Preview">
									</a>
								</td>
								<td align="center" width="10%" valign="top">{WIDTH}</td>
								<td align="center" width="10%" valign="top">{HEIGHT}</td>
								<td align="center" width="10%" valign="top">{SIZE}</td>
								<td align="center" width="6%" valign="top">
									<a onclick="return confirmSubmit()" href="?page=photos.delete.{PHOTO_ID}"><img src="../images/admin/delete.png"></a>
								</td>
							</tr>
							<!-- END photos -->
							<!-- END if_photos -->
						</table>
					</td>
					<td width="35%" valign="top">
						<form method="post" action="?page=photos.upload" enctype="multipart/form-data">
						<table width="100%" class="grey" cellpadding="4" cellspacing="1">
							<tr>
								<td class="tbhead" colspan="3">Add new image</td>
							</tr>
							<tr class="{BGCOLOR1}">
								<td align="center" width="50%">
									<input type="file" name="userfile_1">
								</td>
							</tr>
							<tr class="{BGCOLOR1}">
								<td align="center" width="50%">
									<input type="file" name="userfile_2">
								</td>
							</tr>
							<tr class="{BGCOLOR1}">
								<td align="center" width="50%">
									<input type="file" name="userfile_3">
								</td>
							</tr>
							<tr class="{BGCOLOR1}">
								<td align="center" width="50%">
									<input type="file" name="userfile_4">
								</td>
							</tr>
							<tr class="{BGCOLOR1}">
								<td align="center" width="50%">
									<input type="file" name="userfile_5">
								</td>
							</tr>
							<tr class="{BGCOLOR2}">
								<td align="center" colspan="3" width="50%">
									<input type="submit" value="Add Image" class="button">
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