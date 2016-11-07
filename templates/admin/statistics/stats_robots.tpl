<table width="60%" border="0" cellspacing="{CS}" cellpadding="{CP}" class="grey"  align="center">
	<tr > 
		<td  class="tbhead" colspan="5">Saved Search Engine Spider Logs</td>
	</tr>
	<tr>
		<td  align="center" class="bgmain" nowrap>Bot Name</td>
		<td  align="center" class="bgmain">Hits</td>
		<td  align="center" class="bgmain" >Last Hit</td>
		<td  align="center" class="bgmain" nowrap>Details</td>
		<td  align="center" class="bgmain">Remove By Bot</td>
	</tr>
	<!-- BEGIN ror -->
	<tr class="{BGCOLOR}"> 
		<td  valign="top" ><strong>{BOTNAME}</strong></td>
		<td align="center"><strong>{HITS}</strong></td>
		<td align="center">{LASTHIT}</td>
		<td align="center">[ <a href="index.php?page=stats_robots&type={BOTTYPE}">View by bot</a> ]</td>
		<td  align="center" nowrap>
			<a href="index.php?page=delete.bots.{BOTTYPE}">
			<img src="../images/admin/delete.png" border='0' alt="DELETE"  title="DELETE"></a></td>
	</tr>
	<!-- END ror -->
</table>
<br />