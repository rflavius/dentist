<script language="javascript" type="text/javascript">
<!--
	function redirect()
	{
			document.location.href = "index.php?page=plati.facturifiscale."+document.facturifiscale.list_fiscale.value+"."+document.facturifiscale.fiscale_trimise.value+"."+document.facturifiscale.fiscale_status.value;
	}
//-->
</script>
<br />
<table align="center" border="0" cellspacing="0" cellpadding="0" width="99%">
	<tr>
		<td>
			{INFORMATION}
			<form method="post" action="" name="facturifiscale">
			<table align="center" class="tbpagination" cellspacing="{CS}" cellpadding="{CP}" width="100%">
				<tr>
					<td class="{B1}"  width="100" align="center"> <strong>Listeaza Facturi Dupa : </strong></td>
					<td class="{B2}" width="60" align="left">
					
					<select name="list_fiscale" onchange="redirect();">
						<option value="data_eliberarii_desc" {DATA_ELIBERARII_DESC}>Data emiterii - DESC</option>
						<option value="data_eliberarii_asc" {DATA_ELIBERARII_ASC} >Data emiterii ASC</option>
						<option value="id_proforma_asc" {ID_PROFORMA_ASC}>Id proforma - ASC</option>
						<option value="id_proforma_desc" {ID_PROFORMA_DESC}>Id Proforma - DESC</option>
						<option value="id_contract_asc" {ID_CONTRACT_ASC}>Id contract - ASC</option>
						<option value="id_contract_desc" {ID_CONTRACT_DESC}>Id contract - DESC</option>
						<option value="user_id_asc" {USER_ID_ASC}>User id  - ASC</option>
						<option value="user_id_desc" {USER_ID_DESC}>User id  - DESC</option>		
						<option value="serie_factura_asc" {SERIE_FACTURA_ASC}>Serie Factura  - ASC</option>
						<option value="serie_factura_desc" {SERIE_FACTURA_DESC}>Serie Factura  - DESC</option>

					</select>
					</td>
					<td class="{B1}"  width="60" align="right"><b>Fiscale trimise:</b></td>
					<td class="{B2}"  width="60" align="left">
					
					<select name="fiscale_trimise" onchange="redirect();">
						<option value="all" {SELECTEDALL}>All</option>
						<option value="Y" {SELECTEDY}>Trimise</option>
						<option value="N" {SELECTEDN}>Netrimise</option>
					</select>
					</td>
						<td class="{B2}"  width="100" align="left"><b>Total Facturi: {CASTIG_DENTIST} RON </td>
					<td class="{B2}" width="240" align="right">&nbsp;&nbsp; <a class="button" style="text-transform: uppercase;" href="?page=plati.facturifiscale">&nbsp; Vezi facturi fiscale curente &nbsp;[ {COUNT_FISCALE_ONUSERS} ]&nbsp;</b> </a> </b>
				</tr>
			</table>
			</form>
				<br />
			<table align="center" class="tbpagination" cellspacing="{CS}" cellpadding="{CP}" width="100%">
				<tr>
					<td class="{B1}"  width="120" align="center"><strong>{COUNT_FISCALE} Facturi fiscale </strong></td>
					<td class="{B2}" width="60" align="center">Pages <strong>({PAGES}) : </strong></td>
					<td class="{B1}" align="center">{PAGINATION}</td>
				</tr>
			</table>
			<br />
			<table width="100%" class="grey" cellpadding="4" cellspacing="1">
				<tr>
					<td class="tbhead" colspan="11">Toate facturile fiscale</td>
				</tr>
				<!-- BEGIN if_messages -->
				<tr>
					<td class="bgmain" style="text-align:left;">ID</td>
					<td class="bgmain" >Username</td>
					<td class="bgmain" >Nume firma</td>
					<td class="bgmain" >Perioada</td>
					<td class="bgmain" width="7%">Cost</td>
					<td class="bgmain">Trimisa</td>
					<td class="bgmain" nowrap>Emisa in</td>
					<td class="bgmain" nowrap>Date promovare</td>
					<td class="bgmain" nowrap>Print</td>
					<td class="bgmain" width="5%">Actions</td> 
				</tr>
				<!-- BEGIN list_messages -->
				<tr class="{BGCOLOR}">
					<td valign="top">
							<b>Fisc: {ID_FACTURA}</b><br>
							<b>Prof: <a href="?page=plati.detaliiproforma.{ID_PROFORMA}">{ID_PROFORMA}</a>
					</td>
					<td valign="top"><b><a href="?page=users.details.{USER_ID}.{USERNAME}">{USERNAME}</a></b></td>
					<td valign="top"><a href="?page=cabinete.edit.{ID_CABINET}.{USER_ID}">[ {NUME_FIRMA} ] <b>{TYPE_CAB} {JUDET}</b></a>	</td>
					<td valign="top"> {PERIOADA_PROMOV} luni</td>
					<td valign="top"> {COST} Ron</td>
					<td valign="top" align="center">{TRIMISA}</td>
					<td valign="top" align="center" {CLASSEXP}>{DATA_ELIBERARII}</td>
					<td valign="top" align="center" {CLASSEXPIRE}>{DATE_PROMOVARE} - {DATA_EXPIRE}</td>
						
					<td valign="top" align="center" ><a href="?page=plati.print.{ID_FACTURA}"><img src="../images/allstufs/{IMAGEPRINT}"></a></td>
					<td align="center" valign="top">
						[ <a href="?page=delete.facturafiscala.{ID_FACTURA}">Delete </a>]<br>

						[ <a href="?page=plati.viewfiscala.{ID_FACTURA}">View</a> ]

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
		<li >Aici  sunt listate toate facturile la gramada, nu pe useri si cate au fiecare</li>
		<li>Liniile cu <b style="color:green">verde</b> sunt facturi fiscale emise astazi!</li>
	</ol>
	</td>
	</tr>
</table>