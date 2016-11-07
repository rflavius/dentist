<script language="javascript" type="text/javascript">
<!--
	function redirect()
	{
			document.location.href = "index.php?page=plati.facturifiscale."+document.facturifiscale.fiscale_trimise.value;
	}
	function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>

<br />
<table align="center" border="0" cellspacing="0" cellpadding="0" width="99%">
	<tr>
		<td >
			{INFORMATION}
			<table align="center" class="tbpagination" cellspacing="{CS}" cellpadding="{CP}" width="100%">
				<tr>
					<td class="{B1}" width="200"><strong>Afisare clienti : </strong>   </td>
					<td class="{B2}" width="80">
						<select name="select_parent" onChange="MM_jumpMenu('parent',this,0)">
							<option value="?page=plati.clienti">All  </option>
							<!-- BEGIN modules -->
								<option value="?page=plati.clienti.module_{MODULE_ID}" {SELECTED_MODULE}>{MODULE_NAME}</option>
								<!-- BEGIN categories -->
									<option value="?page=plati.clienti.category_{CATEGORY_CODE}_{MODULE_ID}" {SELECTED_CAT}> ... {CATEGORY_NAME}</option>
								<!-- END categories -->
							<!-- END modules -->
						</select>
					</td>
					<td class="{B1}"  width="80" align="center"><strong>{COUNT_CLIENTI}</strong> Clienti</td>
					<td class="{B2}" width="60" align="center">Pages <strong>({PAGES}) : </strong></td>
					<td class="{B1}" align="center">{PAGINATION}</td>
				</tr>
			</table>
			
		<p>&nbsp;</p>
			<table width="100%" class="grey" cellpadding="4" cellspacing="1" >
				<tr>
					<td class="tbhead" colspan="12">Clienti curenti, activi</td>
				</tr>
				<!-- BEGIN if_messages -->
				<tr>
					<td class="bgmain" style="text-align:left;">#</td>
					<td class="bgmain" >Username</td>
					<td class="bgmain" >Media</td>
					<td class="bgmain" >Firma</td>
					<td class="bgmain" >Promovare</td>
					<td class="bgmain" width="5%">Cost</td>
					<td class="bgmain" nowrap>Date promovare</td>
					<td class="bgmain" width="15%">Actions</td> 
				</tr>
				<!-- BEGIN list_messages -->
				<tr class="{BGCOLOR}">
					<td valign="top">
						<b>Facturi: <a href="?page=plati.listfiscaleuser.{USER_ID}.{USERNAME}.{NR_FACT_FISCALE}">[ {NR_FACT_FISCALE} ]</a><br>
							<b>User ID: <a href="?page=users.details.{USER_ID}.{USERNAME}">[ {USER_ID} ]</a></b><br>
							<b>Cabinet ID: <a href="?page=cabinete.edit.{ID_CABINET}.{USER_ID}">[ {ID_CABINET} ]</a><br>
						
					</td>
					<td valign="top"><b><a href="?page=users.details.{USER_ID}.{USERNAME}">{USERNAME}</a></b></td>
					<td valign="top">
						<a href="{MODIFICA_IMAGINI}"><img src="{IMAGINE}"></a><br />
					{NR_IMAGINI} imag [ <a href="{MODIFICA_IMAGINI}">modifica</a> ] <br>
					{NR_VIDEO} video  [ <a href="{MODIFICA_VIDEO}">modifica</a> ]<br>
					{NR_BANNER} banner [ <a href="{MODIFICA_IMAGINI}">modifica</a> ]</td>
					<td valign="top"> <a href="?page=cabinete.edit.{ID_CABINET}.{USER_ID}">[ {NUME_FIRMA} ] <b>{TYPE_CAB} {JUDET}</b> </a><br></td>
					<td valign="top">{LOCPROMOVARE} {PERIOADA_PROMOV} luni</td>
	
					<td valign="top"> {COST} Ron</td>
					<td valign="top" align="center" {CLASSEXPIRE}>{DATE_PROMOVARE} - {DATA_EXPIRE}</td>
						
					
					<td align="left" valign="top">
							<b>Fisc: <a href="?page=plati.viewfiscala.{ID_FACTURA}"> [ {ID_FACTURA} ]</a></b><br>
							<b>Prof: <a href="?page=plati.detaliiproforma.{ID_PROFORMA}">[ {ID_PROFORMA} ]</a><br>
						<a href="?page=plati.genereazaproforma.{ID_CABINET}.{USER_ID}.{JUDET}.{TYPE_ID}">Generate proforma</a><br />
						
						{PRELUNGESTE_PROMOVARE}
						Recomandat:		<a href="?page=cabinete.">{RECOMANDED}</a>  <a href="?page=cabinete.schimba.{RECOMANDED}.{ID_CABINET}.{USER_ID}.{JUDET}.{TYPE_ID}">change</a><br>
					
					</td>
				</tr>
				<!-- END list_messages -->
				<!-- END if_messages -->
			</table>
		</td>
	</tr>
	<tr>
	<td >	<center><b>{NOTFOUND}</b></center>
	<br /><br />
	<ol>
		<li >Aici sunt afisati toti clienti <b style="color:red">activi</b>pe www.dentistonline.ro <br>Se afiseaza si clienti a caror serviciu a expirat in urma cu 2 luni maxim!!! </li>
		<li>Facturi fiscale <b style="color:red">trimise/netrimise</b> prin posta la utilizatori </li>
		<li>Daca accesez <b style="color:red">Bills </b> - voi vedea facturile fiecarui user</li>
		<li>Daca accesez <b style="color:red">[ change ] </b> - voi putea sa schimb daca factura a fost sau nu trimisa postal</li>
		<li>Daca accesez <b style="color:red">Vezi Toate Facturile Fiscale [ xx ]  </b> vad toate facturile la gramada, nu sortate pe utilizatori</li>
		<li><b style="color:red">Send <img src="../images/allstufs/envelope_icon.gif"> </b>- se refera trimisa postal</li>
		<li><b style="color:red">Send @</b>- se refera trimisa prin e-mail</li>
		<li>Liniile cu <b style="color:green">verde</b> sunt facturi fiscale emise astazi!</li>
	</ol>
	</td>
	</tr>
</table>