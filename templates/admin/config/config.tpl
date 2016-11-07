<form method="post" action="?page=config.save" name="config_changes">
<br>
	<table border="0" class="grey" cellpadding="4" cellspacing="1" width="90%">
		<tr>
			<td align="left" class="tbhead" colspan="9">General Configuration
			</td>
		</tr>
		<!-- BEGIN conf -->
		<tr class="{BGCOLOR}">
			<td align="left">{VARIABLE}
			</td>
			<td class="hint" valign="top"><li>{COMMENT}</li>
			</td>
			<td align="center"><input type="text" name="{ID}" value='{VALUE}' size="40">
			</td>
		</tr>
		<!-- END conf -->
		<tr>
			<td bgcolor="{BGCOLOR1}" colspan="3" align="center">
				<input type="submit" value="Save Changes" class="button">
			</td>
		</tr>
	</table>
</form>
<br>