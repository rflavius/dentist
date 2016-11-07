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
							<option value="?page=cabinete.recomandate">All  </option>
							<!-- BEGIN modules -->
								<option value="?page=cabinete.recomandate.module_{MODULE_ID}" {SELECTED_MODULE}>{MODULE_NAME}</option>
								<!-- BEGIN categories -->
									<option value="?page=cabinete.recomandate.category_{CATEGORY_ID}" {SELECTED_CAT}> ... {CATEGORY_NAME}</option>
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
			<table width="100%" class="grey" cellpadding="5" cellspacing="1">
				<tr>
					<td class="tbhead" colspan="11">LIST ALL CABINETE , LABOARATOARE, CLINICI</td>
				</tr>
				<!-- BEGIN if_cabinete -->
				<tr>
					<td class="bgmain" width="2%">Id</td>
					<td class="bgmain" width="18%">Cabinet</td>
					<td class="bgmain" width="10%">Imagine</td>
					<td class="bgmain" width="11%" nowrap>Parent module/Cat</td>
					<td class="bgmain" width="7%">Perioada</td>
					<td class="bgmain" width="7%">Recomandat</td>
					<td class="bgmain" width="10%">Facturi</td>
				
					<td class="bgmain" width="10%">Date ADD  <a href="?page={PAGE_NAME}&displaymode=data-date_add-ASC">
							<img src="../images/admin/down.png" title="Ascending A to Z">	</a>&nbsp;
						<a href="?page={PAGE_NAME}&displaymode=data-date_add-DESC">
							<img src="../images/admin/up.png" title="Descending Z to A">
						</a>
					</td>
					<td class="bgmain" width="10%">Date EXP <a href="?page={PAGE_NAME}&displaymode=data-date_exp-ASC">
							<img src="../images/admin/down.png" title="Ascending A to Z">
						</a>&nbsp;
						<a href="?page={PAGE_NAME}&displaymode=data-date_exp-DESC">
							<img src="../images/admin/up.png" title="Descending Z to A">
						</a></td>
					<!-- 		<td class="bgmain" width="7%" nowrap>Visits <a href="?page={PAGE_NAME}&displaymode=vizite-nr_visits-ASC">
							<img src="../images/admin/down.png" title="Ascending A to Z">
						</a>&nbsp;
						<a href="?page={PAGE_NAME}&displaymode=vizite-nr_visits-DESC">
							<img src="../images/admin/up.png" title="Descending Z to A"></td> -->
					<td class="bgmain" width="15%">Actions</td>
				</tr>
				<!-- BEGIN list_cabinete -->
				<tr class="{BGCOLOR}">
					<td align="center" valign="top">
						<a href="?page=cabinete.edit.{ID}" title='Edit "{NUME_CABINET}" cabinet'>{ID}</a>
					</td>
					<td valign="top">  
						<b>Cab:	 <a href="{LINK_TO_CABINET}" title='View "{NUME_CABINET}" cabinet' target="_blank">[ {NUME_CABINET} ]</a> 
							<br>
							User: <a href="?page=users.details.{USER_ID}">[ {USER} ]</a> <br /> 
						</b>{COMMENT}
					</td>
					<td valign="top" align="center"><a href="{MODIFICA_IMAGINI}"><img src="{IMAGINE}"></a><br />
					{NR_IMAGINI} img  <a href="{MODIFICA_IMAGINI}">modifica</a></td>
						<td valign="top">{PARENT_MODULE}</td>
					<td valign="top">{PERIOADA_LUNI} luni</td>
					<td valign="top">{RECOMANDED}  <a href="?page=cabinete.schimba.{RECOMANDED}.{ID}">change</a></td>
					<td valign="top"> Prof: <a href="?page=plati.detaliiproforma.{FACTURA_PROFORMA}">[ {FACTURA_PROFORMA} ]</a><br> Fisc: <a href="?page=plati.viewfiscala.{FACTURA_FISCALA}">[ {FACTURA_FISCALA} ]</a></td>
					<td valign="top">{ADAUGAT_RECOMANDAT}</td>
					<td valign="top" {CLASSEXPIRE} >{EXPIRA_RECOMANDAT}</td>
				
					<!-- <td valign="top">{NR_VISITS}</td> -->
					<td align="left" valign="top">
						<a href="?page=cabinete.edit.{ID}.{USER_ID}">[ Edit cab ]</a><br />
						<a href="?page=delete.cabinete.{ID}">[ Delete cab ]</a><br />
					<!-- 	<a href="?page=plati.genereazaproforma.{ID}.{USER_ID}.{JUDET_ID}.{TYPE_ID}">Generate proforma</a><br />
						<a href="?page=recomandate.add.{ID}.{USER_ID}.{JUDET_ID}.{TYPE_ID}">Add recomended</a><br /> -->
						[ {PRELUNGESTE_PROMOVARE} ]
						
						
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