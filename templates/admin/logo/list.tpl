<table align="center" border="0" cellspacing="0" cellpadding="0" width="92%">
	<tr>
		<td>
			{INFORMATION}
			<table border="0" cellspacing="1" cellpadding="4" width="100%">
				<tr>
					<td width="65%" valign="top">
						<table width="100%" class="grey" cellpadding="4" cellspacing="1">
							<tr>
								<td class="tbhead" colspan="6">Current Logo</td>
							</tr>
							<tr>
								<td class="bgmain" nowrap><a href="../images/{LOGO}" target="_blank">Click here for original size</a></td>
							</tr>
							<tr class="row1">
								<td align="center">
									<a href="../images/{LOGO}" target="_blank">
										<img src="../images/{LOGO}" title="Logo Preview" {IF_WIDTH}/>
									</a>
								</td>
							</tr>
						</table>
					</td>
					<td width="35%" valign="top">
					<form method="post" action="?page=logo.upload" enctype="multipart/form-data">
						<table width="100%" class="grey" cellpadding="4" cellspacing="1">
							<tr>
								<td class="tbhead" colspan="3">Change logo</td>
							</tr>
							<tr class="{BGCOLOR1}">
								<td align="center" width="50%">
									<input type="file" name="logo">
								</td>
							</tr>
							<tr class="{BGCOLOR2}">
								<td align="center" colspan="3" width="50%">
									<input type="submit" value="Change Logo" class="button">
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