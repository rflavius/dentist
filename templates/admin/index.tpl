<html>
<head>
<title>{SITETITLE}</title>
<meta http-equiv="Content-Type" content="text/html;charset=iso-8859-2">
<script type="text/javascript" src="../templates/js/prototype.js"></script>
<link type="text/css" href="../templates/skins/admin/style.css" rel="stylesheet">
{ADDITIONAL_HEAD_JS}
<script type="text/javascript" src="../templates/js/mini/overlib_mini.js">

<!-- overLIB (c) Erik Bosrup --></script>
<div id="overDiv" style="position:absolute; visibility:hidden; z-index:1000;"></div>
<script type="text/javascript" src="http://www.dentistonline.ro/jwplayer/jwplayer.js"></script>
</head>
<body bgcolor="#F7F7F7">
<table width="100%"  height="100%" cellpadding="0" cellspacing="2" border="0" align="center">
	<tr>
		<td>
			<!-- header -->
			<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
				<tr>
					<td valign="top" class="header_leftside"></td>
					<td valign="top" align="right" class="logo">DentistOnline Admin Panel</td>
					<td valign="top" class="header_rightside"></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
				<tr>
					<td valign="top" class="menu_leftside"> </td>
					<td class="topmenu">{TOP_MENU}&nbsp;</td>
					<td valign="top" class="menu_rightside"> </td>
				</tr>
			</table>
		</td>
	</tr>
<!-- end header -->
	<tr>
		<td height="100%"  valign="top" >
			<table width="100%" height="100%" cellpadding="0" cellspacing="0" border="0">
				<tr>
					{LEFT_MENU}
					<td valign="top" bgcolor="white">
						<table border="0" cellspacing="0" cellpadding="0" width="100%">
						<tr><td>			{MENUTABLE}
						</td></tr>
						<!-- <tr>
							<td class="title" width="95%">{MAIN_TITLE}</td>
							<td>
							<!-- BEGIN help<img src="../templates/skins/admin/images/info.gif" onMouseOver="return overlib('{HELP_CONTENT}', CAPTION, '{HELP_TITLE}');" onmouseout="return nd();"><!-- END help </td>
						</tr> -->
						</table>
							<div align="center">{MAIN}</div>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
	<td>
		<table width="100%" cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td valign="top" class="footer_leftside"> </td>
					<td class="footer" align="center">
						<div class="small">{PAGEGENERATE}</div>
						{COPYRIGHT}&nbsp;
					</td>
					<td valign="top" class="footer_rightside"> </td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</body>
</html>