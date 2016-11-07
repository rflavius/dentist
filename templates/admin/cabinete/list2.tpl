<script language="JavaScript" type="text/JavaScript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
<table align="center" border="0" cellspacing="0" cellpadding="0" width="98%">
	<tr>
		<td>
			{INFORMATION} 
			<table align="center" class="tbpagination" cellspacing="{CS}" cellpadding="{CP}" width="100%">
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
					<td class="{B1}"  width="80" align="center"><strong>{COUNT_CABINETE}</strong> Cabinete</td>
					<td class="{B2}" width="60" align="center">Pages <strong>({PAGES}) : </strong></td>
					<td class="{B1}" align="center">{PAGINATION}</td>
				</tr>
			</table>
			<br>
			<table width="100%" class="grey" cellpadding="4" cellspacing="1">
				<tr>
					<td class="tbhead" colspan="13">LIST ALL CABINETE , LABOARATOARE, CLINICI</td>
				</tr>
				<!-- BEGIN if_cabinete -->
				<tr>
					<td class="bgmain" width="2%">Id</td>
					<td class="bgmain" width="10%">Nume Cabinet</td>
					<td class="bgmain" width="10%">Media</td>
					<td class="bgmain" width="5%">User</td>
					<td class="bgmain" width="12%">E-mail</td>
					<td class="bgmain" width="7%">Telefon</td>
					<td class="bgmain" width="7%">Promovare</td>
					<td class="bgmain" width="7%">Agent</td>
					<td class="bgmain" width="10%">Date add <a href="?page={PAGE_NAME}&displaymode=data-submision_date-ASC">
							<img src="../images/admin/down.png" title="Ascending A to Z">
						</a>&nbsp;
						<a href="?page={PAGE_NAME}&displaymode=data-submision_date-DESC">
							<img src="../images/admin/up.png" title="Descending Z to A">
						</a>
					</td>
					<td class="bgmain" width="11%" nowrap>Tip/Judet</td>
					<td class="bgmain" width="5%" nowrap>Visits <a href="?page={PAGE_NAME}&displaymode=vizite-nr_visits-ASC">
							<img src="../images/admin/down.png" title="Ascending A to Z">
						</a>&nbsp;
						<a href="?page={PAGE_NAME}&displaymode=vizite-nr_visits-DESC">
							<img src="../images/admin/up.png" title="Descending Z to A"></td>
					<td class="bgmain" width="5%">Status</td>
					<td class="bgmain" width="10%">Actions</td>
				</tr>
				<!-- BEGIN list_cabinete -->
				<tr class="{BGCOLOR}">
					<td align="center" valign="top">
						{ID}
					</td>
					<td valign="top">
						<b>
							<a href="{LINK_TO_CABINET}" title='View "{NUME_CABINET}" cabinet' target="_blank">{NUME_CABINET}</a><br /> 
						</b>{COMMENT}
					</td>
					<td valign="top" align="center"><img src="{IMAGINE}"><br />
					{NR_IMAGINI} imag  <br>
					{NR_VIDEO} video  <br>
					{NR_BANNER} banner </td>
					<td valign="top"><div id="norows"><a href="?page=users.details.{USER_ID}">{USER}</a></div></td>
					<td valign="top"><div id="norows">{EMAIL}</div></td>
					<td valign="top"><div id="norows">{TELEFON}</div></td>
					<td valign="top">{LOCPROMOVARE}</td>
					<td valign="top">{AGENT}</td>
					<td valign="top">{SUBMISION_DATE}</td>
					<td valign="top">{PARENT_MODULE}</td>
					<td valign="top">{NR_VISITS}</td>
					<td align="center" valign="top"><img src="../images/admin/{IMAGE}" title='Turn "{TITLE}" cabinet to {IMAGE_TITLE}'></td>
					<td align="left" valign="top">
						
						<a href="?page=marketing.addcontact.{ID}">Adauga contact</a><br />
						<a href="?page=plati.genereazaproforma.{ID}.{USER_ID}.{JUDET_ID}.{TYPE_ID}">Generate proforma</a><br />
					</td>
				</tr>
				<!-- END list_cabinete -->
				<!-- END if_cabinete -->
				<!-- BEGIN if_no_cabinete -->
					<td class="bgmain" colspan="12">No cabinet for this section</td>
				<!-- END if_no_cabinete -->
			</table>
		</td>
	</tr>
</table>
<p style="text-align:left;font-size:16px;"><b>*** AJUTOR</b></p>
<p style="font-size:14px;text-align:left;">Adauga contact - cabinet/laborator firma care a foat sunata <span style="background:#D9E8F9;width:40px;display:inline-block;">&nbsp;</span> au fost contactate deja.</p>
<p style="font-size:14px;text-align:left;">Cabinetele colorate cu <span style="background:#D9E8F9;width:40px;display:inline-block;">&nbsp;</span> au fost contactate deja.</p>
