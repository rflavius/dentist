<table border='0' width='100%' align='center' cellspacing='0' cellpadding='0'>
<tr>
	<td valign="top" width="30%">
				<table  class="grey" cellpadding="4" cellspacing="1" valign="top">
				<tr>
					<td class="tbhead" colspan="10">All Anunturi Categories for dentistonline.ro</td>
				</tr>
				<tr>
					<td class="bgmain" width="5%">Id</td>
					<td class="bgmain" width="45%">Name</td>
					
				</tr>
				<!-- BEGIN list_categories -->
				<tr class="{BGCOLOR}">
					<td align="center">{CAT_ID}</td>
					<td><b>{CAT_NAME}</b></td>
				</tr>
				<!-- END list_categories -->
			</table>
	</td>
	<td width="70%">
			<table  class="grey" cellpadding="4" cellspacing="1">
				<tr>
					<td class="tbhead" colspan="10">All Anunturi Categories for dentistonline.ro</td>
				</tr>
				<tr>
					<td class="bgmain" width="5%">Curent id</td>
					<td class="bgmain" width="70%">Anunt</td>
					<td class="bgmain" width="10%">New cat id</td>

					
				</tr>
				<form method=post action="?page=script_bigcat_anunturi.change">
					<!-- BEGIN list_anunturi -->
				<tr class="{BGCOLOR}">
					<td align="center">{BIG_CAT_ID}</td>
					<td><b>{ANUNT}</b> {DESCRIERE}</td>
					<td><b><input type="text" name="{ID_ANUNT}" value="{BIG_CAT_ID}"></b></td>
				</tr>
				<!-- END list_anunturi -->
				<tr>
				  <td><input type="submit" class="button" value="CHANGE">
					</td>
				</tr>
				</form>
			</table>
	
	</td>
</tr>
</table>



			