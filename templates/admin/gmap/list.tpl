<script language="JavaScript" type="text/JavaScript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
<br>
<table align="center" border="0" cellspacing="0" cellpadding="0" width="98%">
	<tr>
		<td>
			{INFORMATION} 
			<table align="center" class="tbpagination" cellspacing="{CS}" cellpadding="{CP}" width="100%">
				<tr>
					<td class="{B1}" width="200"><strong>GMAP status: </strong>   </td>
					<td class="{B2}" width="80">
						<select name="status" onChange="window.location.href='index.php?page=gmap&status='+this.value;">
							<option value="" {ALL_STATUS}>All</option>
							<option value="N" {N_STATUS}>NOT DONE</option>
							<option value="Y" {Y_STATUS}>DONE</option>
						</select>
					</td>
					<td class="{B1}"  width="120" align="center"><strong>{COUNT_CABINETE}</strong> Cabinete</td>
					<td class="{B2}" width="120" align="center">Pages <strong>({PAGES}) : </strong></td>
					<td class="{B1}" align="center">{PAGINATION}</td>
				</tr>
			</table>
			<br>
			<table width="100%" class="grey" cellpadding="4" cellspacing="1">
				<tr>
					<td class="tbhead" colspan="14">LIST ALL CABINETE , LABOARATOARE, CLINICI</td>
				</tr>
				<tr>
					<td class="bgmain" width="3%">#</td>
					<td class="bgmain" width="15%">Cabinet/Clinica</td>
					<td class="bgmain" width="10%" nowrap>Parent module/Cat</td>
					<td class="bgmain">Coordonates done</td>
					<td class="bgmain" >GMAP Address</td>
					<td class="bgmain" width="10%" >GMAP LAT</td>
					<td class="bgmain" width="10%" >GMAP LNG</td>
					<td class="bgmain">Actions</td>
				</tr>
				<!-- BEGIN list_cabinete -->
				<tr class="{BGCOLOR}">
					<td>{NR}.</td>
					<td valign="top">
						<a href="?page=cabinete.edit.{CAB_ID}" title='Edit "{NUME_CABINET}" cabinet'>{NUME_CABINET}</a><br>
						[ <a href="{LINK_TO_CABINET}" target="_blank">visit page</a> ]
					</td>
					<td valign="top">{PARENT_MODULE}</td>
					<td align="center"><img src="../images/admin/{IMAGE}" title='{IMAGE_TITLE}'></td>
					<td valign="top">{GMAP_ADDRESS}</td>
					<td valign="top">{GMAP_LAT}</td>
					<td valign="top">{GMAP_LNG}</td>
					<td align="left" valign="top">
						[ <a href="?page=gmap.generate.{CAB_ID}">generate</a> ]<br>
						[ <a href="?page=gmap.delete.{ID}">delete</a> ]<br>
					</td>
				</tr>
				<!-- END list_cabinete -->
			</table>
		</td>
	</tr>
</table>