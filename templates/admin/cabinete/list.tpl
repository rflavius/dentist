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
					<td class="tbhead" colspan="14">LIST ALL CABINETE , LABOARATOARE, CLINICI</td>
				</tr>
				<!-- BEGIN if_cabinete -->
				<tr>
					
					<td class="bgmain" width="15%">Details</td>
					<td class="bgmain" width="10%">Media</td>
					<td class="bgmain" width="7%">Promovare</td>
					<td class="bgmain" width="7%">Agent</td>
					<td class="bgmain" width="11%" nowrap>Parent module/Cat</td>
					<td class="bgmain" width="7%">Date add<br> <a href="?page={PAGE_NAME}&displaymode=data-submision_date-ASC">
							<img src="../images/admin/down.png" title="Ascending A to Z">
						</a>&nbsp;
						<a href="?page={PAGE_NAME}&displaymode=data-submision_date-DESC">
							<img src="../images/admin/up.png" title="Descending Z to A">
						</a>
					</td>

					<td class="bgmain" width="7%">Date mod <br><a href="?page={PAGE_NAME}&displaymode=data-data_modificarii-ASC">
							<img src="../images/admin/down.png" title="Ascending A to Z">
						</a>&nbsp;
						<a href="?page={PAGE_NAME}&displaymode=data-data_modificarii-DESC">
							<img src="../images/admin/up.png" title="Descending Z to A">
						</a></td>
					
					
					<td class="bgmain" width="7%" nowrap>Visits <br><a href="?page={PAGE_NAME}&displaymode=vizite-nr_visits-ASC">
							<img src="../images/admin/down.png" title="Ascending A to Z">
						</a>&nbsp;
						<a href="?page={PAGE_NAME}&displaymode=vizite-nr_visits-DESC">
							<img src="../images/admin/up.png" title="Descending Z to A"></td>
					
					<td class="bgmain" width="7%" nowrap>Phone show<br><a href="?page={PAGE_NAME}&displaymode=accesaritel-phone_views-ASC">
							<img src="../images/admin/down.png" title="Ascending A to Z">
						</a>&nbsp;
						<a href="?page={PAGE_NAME}&displaymode=vizite-phone_views-DESC">
							<img src="../images/admin/up.png" title="Descending Z to A"></td>


					<td class="bgmain" width="5%">Status</td>
					<td class="bgmain" width="5%">Trimis e-mail</td>
					<td class="bgmain" width="15%">Actions</td>
				</tr>
				<!-- BEGIN list_cabinete -->
				<tr class="{BGCOLOR}">
					
					<td valign="top">
					<p>Id cab: <a href="?page=cabinete.edit.{ID}" title='Edit "{NUME_CABINET}" cabinet'>{ID}</a></p>
					<p>User: <a href="?page=users.details.{USER_ID}">{USER}</a></p>
					Name: 
						<b>
							<a href="{LINK_TO_CABINET}" title='View "{NUME_CABINET}" cabinet' target="_blank">{NUME_CABINET}</a><br /> 
						</b>{COMMENT}
					</td>
					<td valign="top" align="center"><a href="{MODIFICA_IMAGINI}"><img src="{IMAGINE}"></a><br />
					{NR_IMAGINI} imag [ <a href="{MODIFICA_IMAGINI}">modifica</a> ] <br>
					{NR_VIDEO} video  [ <a href="{MODIFICA_VIDEO}">modifica</a> ]<br>
					{NR_BANNER} banner [ <a href="{MODIFICA_IMAGINI}">modifica</a> ]</td>
					<td valign="top" nowrap>{LOCPROMOVARE}</td>
					<td valign="top" nowrap>{AGENT}</td>
					<td valign="top">{PARENT_MODULE}</td>
					<td valign="top">{SUBMISION_DATE}</td>
					<td valign="top">{MODIFY_DATE}</td>

					
					
					<td valign="top">{NR_VISITS}</td>
					<td valign="top">{ACCES_TELEPHONES}</td>
					<td align="center" valign="top">
						<a href="?page=cabinete.set.{IMAGE_TITLE}.{ID}">
							<img src="../images/admin/{IMAGE}" title='Turn "{TITLE}" cabinet to {IMAGE_TITLE}'>
						</a>
					</td>
					<td align="center" valign="top">
						<a href="?page=cabinete.setemail.{IMAGE_TITLE2}.{ID}">
							<img src="../images/admin/{IMAGE2}" title='Turn "{TITLE}" cabinet to {IMAGE_TITLE2}'>
						</a>
					</td>
					<td align="left" valign="top">
						<a href="?page=cabinete.edit.{ID}.{USER_ID}">Edit cab<img src="../images/admin/edit.png" title='Edit "{NUME_CABINET}" cabinet'></a><br />
						<a href="?page=delete.cabinete.{ID}">Delete cab<img src="../images/admin/delete.png" title='Delete "{NUME_CABINET}" cabinet'></a><br />
						<a href="?page=cabinete.generatemail.{ID}">Generate e-mail</a><br />
						<a href="?page=cabinete.sendemailplata.{ID}">Send Plata E-mail</a><br />
						<a href="?page=plati.genereazaproforma.{ID}.{USER_ID}.{JUDET_ID}.{TYPE_ID}">Generate proforma</a><br />
						<a href="?page=recomandate.add.{ID}.{USER_ID}.{JUDET_ID}.{TYPE_ID}">Add recomended</a><br />
						{PRELUNGESTE_PROMOVARE}
						Recomandat:
						<a href="?page=cabinete.">{RECOMANDED}</a>  <a href="?page=cabinete.schimba.{RECOMANDED}.{ID}.{USER_ID}.{JUDET_ID}.{TYPE_ID}">change</a>
						
						
					</td>
				</tr>
				<!-- END list_cabinete -->
				<!-- END if_cabinete -->
				<!-- BEGIN if_no_cabinete -->
					<td class="bgmain" colspan="8">No cabinet for this section</td>
				<!-- END if_no_cabinete -->
			</table>
		</td>
	</tr>
</table>