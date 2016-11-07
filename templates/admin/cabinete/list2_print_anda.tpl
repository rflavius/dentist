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
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
</head>
<body bgcolor="#F7F7F7" style="color:#00005E !important;">

	<table align="center" border="0" cellspacing="0" cellpadding="0" width="98%" >
		<tr>
			<td>
				{INFORMATION} 
				<table align="center" class="tbpagination" cellspacing="{CS}" cellpadding="{CP}" width="100%" style="background:#00005E !important;">
					<tr>
						<td class="{B1}" width="200"><strong>LIST CABINETE , LAB., CLINICI: </strong>   </td>
						<td class="{B2}" width="80">
							<select name="select_parent" onChange="MM_jumpMenu('parent',this,0)">
								<option value="?page=cabinete.list">All  </option>
								<!-- BEGIN modules -->
									<option value="?page=cabinete.list.module_{MODULE_ID}" {SELECTED_MODULE}>{MODULE_NAME}</option>
									<!-- BEGIN categories -->
										<option value="?page=cabinete.list.category_{CATEGORY_ID}" {SELECTED_CAT}> ... {CATEGORY_NAME}</option>
									<!-- END categories -->
								<!-- END modules -->
							</select>
						</td>
						
						<td class="{B2}" width="120">Sort by Date<a href="?page={PAGE_NAME}&displaymode=data-submision_date-ASC">
								<img src="../images/admin/down.png" title="Ascending A to Z">
							</a>&nbsp;
							<a href="?page={PAGE_NAME}&displaymode=data-submision_date-DESC">
								<img src="../images/admin/up.png" title="Descending Z to A">
							</a>
						</td>
						<td class="{B1}"  width="80" align="center"><strong>{COUNT_CABINETE}</strong> Cabinete</td>
						<td class="{B2}" width="80" align="center">Pages <strong>({PAGES}) : </strong></td>
						<td class="{B1}" align="center">{PAGINATION}</td>
						
					</tr>
				
				</table>

				<br>
				<table width="100%" cellpadding="1" cellspacing="1"style="color:#00005E !important;" border='1'>
					<tr>
						<td class="tbhead" colspan="5"style="color:#00005E !important;">LIST ALL CABINETE , LABOARATOARE, CLINICI</td>
					</tr>
					<!-- BEGIN if_cabinete -->
					<tr>
						<td class="bgmain" width="10%"style="color:#00005E !important;">Nume Cabinet</td>
						<td class="bgmain" width="5%"style="color:#00005E !important;">Media</td>
						<td class="bgmain" width="15%"style="color:#00005E !important;">Contact</td>
		
						<td class="bgmain" width="15%" style="color:#00005E !important;" nowrap >Info Firma</td>
						<td class="bgmain" style="color:#00005E !important;">Comentarii/Date facturare</td>
					</tr>
					<!-- BEGIN list_cabinete -->
					<tr>
						<td valign="top">
							<b>
								<a href="{LINK_TO_CABINET}" title='View "{NUME_CABINET}" cabinet' target="_blank">{NUME_CABINET}</a><br /> 
							</b>
						</td>
						<td valign="top" align="center"><img src="{IMAGINE}"><br />
						{NR_IMAGINI} imag  <br>
						{NR_VIDEO} video  <br>
						{NR_BANNER} banner </td>
						<td valign="top"><b style="color:red;">Persoana Contact: </b>{PERSOANA_CONTACT}<br><br><b style="color:red;">Email:</b> {EMAIL}<br><br><b style="color:red;">Telefon:</b> {TELEFON}<br>
						<br><B style="color:red;">Adresa:</b> {ADDRESS}<br></td>
						<td valign="top" nowrap>{PARENT_MODULE}<br><b style="color:red;">Vizite:</b> {NR_VISITS}<br><br><b style="color:red;">Promovare: </b>{LOCPROMOVARE}<br><br>
						<b style="color:red;">Data adaugare:</b> {SUBMISION_DATE}</td>
						<td align="left" valign="top">&nbsp;
							
							
						</td>
					</tr>
					<!-- END list_cabinete -->
					<!-- END if_cabinete -->
					<!-- BEGIN if_no_cabinete -->
						<td class="bgmain" colspan="5">No cabinet for this section</td>
					<!-- END if_no_cabinete -->
				</table>
			</td>
		</tr>
	</table>
</body>
</html>