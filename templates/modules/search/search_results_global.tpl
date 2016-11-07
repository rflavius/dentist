<div class="error_messages" style="border:none;display:none;">
	<!-- BEGIN errors -->
		<li>{ERROR_MESSAGE}</li>
	<!-- END errors -->
	</div>
<table border="0" cellspacing="4" cellpadding="3" width="100%" align="center" valign="top">
<tr>
		<td colspan="2">{NO_FIRM_HERE}<br /></td>
</tr>

<!-- BEGIN RESULTS_HEAD -->
<tr>
		<td colspan="2">{BIG_CAT_NAME} , {NR_REZULTTE} rezultate<br /></td>
</tr>
<!-- END RESULTS_HEAD -->
	<!-- BEGIN rowunucabs -->
	<tr>
			<!-- BEGIN rowdoicabs -->
			<td width="45%" valign="top" class="cabinet" > 
					<img src="{THUMBNAIL}" title="{NUME_FIRMA}" ><p class="cabinet_title"><a href="{URLCITESTE}"><b>{NUME_FIRMA}</b></a></p><br>
					<p class="cabinet_description">
					{DESCRIERE}...<a href="{URLCITESTE}">citeste</a><br>
					</p>
						<b>{JUDET}</b>
			</td>
			<!-- END rowdoicabs -->
</tr>
<!-- END rowunucabs -->
	
</table>


<!-- BEGIN pagination_table -->
<table border="0" cellspacing="0" cellpadding="0" width="100%" align="left" class="pagination">
<tr>
	<td width="300" align="left"><b>{COUNT_CABINETE}</b> Cabinete</td>
	<td width="80" align="left">Pagini <b>{PAGES} : </b></td>
	<td align="left">{PAGINATION}</td>
	
</tr>
</table>
<!-- END pagination_table -->

