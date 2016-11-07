<table align="center" class="tbpagination" cellspacing="{CS}" cellpadding="{CP}" width="98%">
	<tr>
		<td class="{B1}" width="60" align="center"><b>{TOTAL_VISITORS} Visitors </b></td>
		<td class="{B2}" align="center"  width="60">Pages <b>({PAGES}) : </b></td>
		<td class="{B1}" align="center">{PAGINATION}</td>
	</tr>
</table>
<br />
<table align="center" class="grey" cellspacing="{CS}" cellpadding="{CP}" width="98%">
	<tr><td colspan="5" class="tbhead">List all visitors</td>
	</tr>
	<tr>
		<td  class="bgmain" align="center">Visitor</td>
		<td  class="bgmain" align="center">IP</td>
		<td  class="bgmain" align="center"><img src="../images/allstufs/earth.gif"></td>
		<td  class="bgmain" align="center">Refferer</td>
		<td  class="bgmain" align="center">Date/Time</td>
	</tr>
	<!-- BEGIN list -->
	<tr class="{BGCOLOR}">
		<td><b>{IP}</b></td>
		<td>
			<img src="../images/flags/{COUNTRY_IMAGE}.png" onMouseOver="return overlib('{COUNTRY_NAME}',  CAPTION, 'Country');" onmouseout="return nd();"> &nbsp;
			<a href="http://www.whois.sc/{IP}" target="_blank">{IP}</a>
		</td>
		<td align="center">
			<img src="../images/browsers/{ICON}.png"  border=0 width="14" onMouseOver="return overlib('{USER_AGENT}',  CAPTION, 'Browser');" onmouseout="return nd();">
		</td>
		<td align="center"><a href="{REFFERER}" target="_blank" style="color:#330000;">{REFFERER}</a></td>
		<td align="right">{DATE}</td>
	</tr>
	<!-- END list -->
</table>
<br />