<script language="javascript" type="text/javascript">
<!--
	function redirect()
	{
			document.location.href = "index.php?page=plati.facturilunare."+document.facturilunare.fiscala_luna.value+"."+document.facturilunare.fiscala_an.value;
	}
//-->
</script>
<br />
<table align="center" border="0" cellspacing="0" cellpadding="0" width="99%">
	<tr>
		<td >
			{INFORMATION}
			<form method="post" action="" name="facturilunare">
			<table align="left" class="tbpagination" cellspacing="{CS}" cellpadding="{CP}" width="99%" height="35">
				<tr>
					<td class="{B1}" align="right" width="10%"> <b>Emise in luna </b>:</td>
					<td class="{B2}"  width="10%" align="left">
						<select name="fiscala_luna" onchange="redirect();">
							<option value="all" {SELECTED_ALL}>All</option>
							<!-- BEGIN fiscale_luni -->
							<option value="{LUNA_ID}" {SELECTED_LUNA}>{LUNA_NAME}</option>
							<!-- END fiscale_luni -->
						</select>
					</td>
					
					<td class="{B1}" align="right"  width="5%"> <b>An emiterii:</b></td>
					<td class="{B2}"  width="10%" align="left">
					<select name="fiscala_an" onchange="redirect();">
							<option value="all" {SELECTEDALL}>All</option>
							<!-- BEGIN list_years -->
							<option {SELECTED_YEAR}>{YEAR}</option>
							<!-- END list_years -->
					</select>
					</td>
					<td class="{B1}"  width="100" align="center"><strong>{COUNT_FISCALE_TOTAL} Facturi Fiscale </strong></td>
					<td class="{B1}"  width="200" align="center"><strong>{TOTAL_MONEY} RON Total Venit </strong></td>
					<td class="{B2}" width="60" align="center">Pages <strong>({PAGES}) : </strong></td>
					<td class="{B1}" align="center">{PAGINATION}</td>

				</tr>
			</table>
		</form>
			
			
<p>&nbsp;</p>
			<table width="100%" class="grey" cellpadding="4" cellspacing="1" >
				<tr>
					<td class="tbhead" colspan="12">Afiseaza facturi emise pe luna curenta, anul curent</td>
				</tr>
				<!-- BEGIN if_messages -->
				<tr>
					<td class="bgmain" style="text-align:left;">ID</td>
					<td class="bgmain" >Username</td>
					<td class="bgmain" >Nume firma</td>
					<td class="bgmain" width="5%">Bills</td>
					<td class="bgmain">Promovare</td>
					<td class="bgmain" width="5%">Cost</td>
					<td class="bgmain">Send <img src="../images/allstufs/envelope_icon.gif"></td>
					<td class="bgmain">Send @</td>
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
					<td valign="top"><a href="?page=cabinete.edit.{ID_CABINET}.{USER_ID}">[ {NUME_FIRMA} ] <b>{TYPE_CAB} {JUDET}</b> </a>	</td>
					<td valign="top" align="center"> <a href="?page=plati.listfiscaleuser.{USER_ID}.{USERNAME}.{NR_FACT_FISCALE}">[ {NR_FACT_FISCALE} ]</a>	</td>
					<td valign="top" align="center"> {LOCPROMOVARE} </td>
					<td valign="top"> {COST} Ron</td>
					<td valign="top" align="center">{TRIMISA}[ <a href="?page=plati.schimbafacturatrimisa.{TRIMISA}.{ID_FACTURA}"> change</a>] </td>
					<td valign="top" align="center">{TRIMISA_EMAIL} </td>
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
		<li >Aici sunt listate facturile Fiscale pe useri. De ex. daca un user are 3 facturi fiscale din care 2 au expirat o vad doar pe a 3-a cu termenele de valabilitate. Cele expirate de 1,2 ani nu are rost sa le vad. </li>
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