<script type="text/javascript" src="../templates/js/mini/overlib_mini.js">
<!-- overLIB (c) Erik Bosrup --></script>
 <div id="overDiv" style="position:absolute; visibility:hidden; z-index:1000;"></div>
 <!-- select and pagination table -->
<table align="center" class="tbpagination" cellspacing="{CS}" cellpadding="{CP}" width="75%">
	<tr>
		<td class="{B1}"  width="60" align="center"><strong>{TLOGINS}</strong> Logins </td>
		<td class="{B2}"  align="center"  width="60">Pages <strong>({PAGES}) : </strong></td>
		<td class="{B1}"  align="center">{PAGINATION}</td>
	</tr>
</table>
<br />
<!-- end select and pagination -->
<table align=center class=grey cellspacing="{CS}" cellpadding="{CP}" width="75%">
	<tr><td colspan=5 class=tbhead>LIST ADMIN LOGINS IN SITE</td>
	</tr>
	<tr>
		<td  class=bgmain align=center>Username</td>
		<td  class=bgmain align=center>IP</td>
		<td  class=bgmain align=center>Browser</td>
		<td  class=bgmain align=center>Date/Time</td>
	</tr>
	<!-- BEGIN row -->
	<tr class="{BGCOLOR}">
		<td><strong>{LUSERNAME}</strong></td>
		<td  >
			<img src="../images/flags/{COUNTRYIMAGE}.png" onMouseOver="return overlib('{COUNTRYNAME}',  CAPTION, 'Country');" onmouseout="return nd();">&nbsp;
			<a href="http://www.whois.sc/{LIP}" target="_blank">{LIP}</a></td>
		<td  align=center><img src="../images/browsers/{ICON}.png"  border=0 width="14" onMouseOver="return overlib('{LUSERAGENT}',  CAPTION, 'Browser');" onmouseout="return nd();"></td>
		<td align="right">{LDATE}</td>
	</tr>
	<!-- END row -->
</table>
<br />