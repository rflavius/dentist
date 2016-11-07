<script language="JavaScript" type="text/JavaScript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
<!-- select and pagination table -->
<table align="center" class="tbpagination" cellspacing="{CS}" cellpadding="{CP}" width="95%">
	<tr>
		<td class="{B2}" width="55" align="center">
			<select name="type" onChange="MM_jumpMenu('parent',this,0)">
				<option value="?page=stats_robots&type=all"> = ALL =</option>
				<!-- BEGIN rowc -->
					<option value="?page=stats_robots&type={CATVAL}" {CATSEL}>{CATNAME}</option>
				<!-- END rowc -->
			</select>
		</td>
		<td class="{B1}"  width="65" align="center" nowrap><strong>{TLOGINS}</strong> Hits </td>
		<td class="{B2}"  align="center" width="75">Pages <strong>({PAGES}) : </strong>
		<td class="{B1}" align="center">{PAGINATION}</td>
	</tr>
</table>
<br />
<!-- end select and pagination -->
<table width="95%" border="0" cellspacing="{CS}" cellpadding="{CP}" class="grey"  align="center">
	<tr > 
		<td  class="tbhead" colspan="6">Last Search Engine Spiders Hits</td>
	</tr>
	<tr>
		<td  align="center" class="bgmain" nowrap>Search Bot</td>
		<td  align="center" class="bgmain">IP</td>
		<td  align="center" class="bgmain" colspan="2">USER AGENT</td>
		<td  align="center" class="bgmain" nowrap>Date</td>
		<td  align="center" class="bgmain">Page</td>
	</tr>
	<!-- BEGIN ror -->
	<tr class="{BGCOLOR}"> 
		<td  valign="top" ><strong>{BOT}</strong></td>
		<td ><a href="http://www.whois.sc/{BIP}" target="_blank">{BIP}</a></td>
		<td >{BUAS}</td>
		<td>		<img src="../images/admin/help.gif" onMouseOver="return overlib('{BUA}',  CAPTION, 'DETAILS');" onmouseout="return nd();"></td>
		<td  align="center" nowrap>{BDATE}</td>
		<td >{BPAGE}</td>
	</tr>
	<!-- END ror -->
</table>
<br />
<table align="center" class="tbpagination" cellspacing="{CS}" cellpadding="{CP}" width="95%">
	<tr>
		<td class="{B2}" width="55" align="center">
			<select name="type" onChange="MM_jumpMenu('parent',this,0)">
				<option value="?page=stats_robots&type=all"> = ALL =</option>
				<!-- BEGIN rowc -->
					<option value="?page=stats_robots&type={CATVAL}" {CATSEL}>{CATNAME}</option>
				<!-- END rowc -->
			</select>
		</td>
		<td class="{B1}"  width="65" align="center" nowrap><strong>{TLOGINS}</strong> Hits </td>
		<td class="{B2}"  align="center" width="75">Pages <strong>({PAGES}) : </strong>
		<td class="{B1}" align="center">{PAGINATION}</td>
	</tr>
</table>
<br />