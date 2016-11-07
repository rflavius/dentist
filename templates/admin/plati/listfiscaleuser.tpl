<script language="javascript" type="text/javascript">
<!--
	function redirect()
	{
			document.location.href = "index.php?page=plati.facturifiscale."+document.facturifiscale.fiscale_trimise.value;
	}
//-->
</script>
<br />
<table align="right" border="0" cellspacing="0" cellpadding="0" width="99%">
	<tr>
		<td align="right">
			{INFORMATION}
			<p><b><a class="button" style="text-transform: uppercase;" href="?page=plati.facturifiscale"> &nbsp;Vezi Facturi Fiscale pe users [ {COUNT_FISCALE_TOTAL} ] &nbsp;</a></b></p>
									</td>
				</tr>
			</table>
	
<p>&nbsp;</p>
			<table width="100%" class="grey" cellpadding="4" cellspacing="1" >
				<tr>
					<td class="tbhead" colspan="11">Toate facturile pentru utilizatorul:&nbsp;[  <a href="?page=users.details.{USER_ID}.{USERNAME}">{USERNAME}</a> ] &nbsp;</td>
				</tr>
				<!-- BEGIN if_messages -->
				<tr>
					<td class="bgmain" style="text-align:left;">ID</td>
					<td class="bgmain" >Nume firma</td>
						<td class="bgmain" >Perioada</td>
					<td class="bgmain" width="5%">Cost</td>
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
				
					<td valign="top"><a href="?page=cabinete.edit.{ID_CABINET}.{USER_ID}">[ {NUME_FIRMA} ] <b>{TYPE_CAB} {JUDET}</b> </a>	</td>
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
		<li >Aici sunt listate facturile Fiscale pe useri. De ex. daca un user are 3 facturi fiscale din care 2 au expirat o vad doar pe a 3-a cu termenele de valabilitate. Cele expirate de 1,2 ani nu are rost sa le vad. </li>
		<li>Facturi fiscale <b style="color:red">trimise/netrimise</b> prin posta la utilizatori </li>
		<li>Daca accesez <b style="color:red">Facturi </b> - voi vedea facturile fiecarui user</li>
		<li>Daca accesez <b style="color:red">Vezi Toate Facturile Fiscale [ xx]  </b> vad toate facturile la gramada, nu sortate pe utilizatori</li>
		<li>Liniile cu <b style="color:green">verde</b> sunt facturi fiscale emise astazi!</li>
	</ol>
	</td>
	</tr>
</table>