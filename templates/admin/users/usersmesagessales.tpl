<table align="center" class="tbpagination" cellspacing="{CS}" cellpadding="{CP}" width="98%">
	<tr>
		<td class="{B1}" width="60" align="center"><b>{TOTAL_MESAGES} Mesages </b></td>
		<td class="{B2}" align="center"  width="60">Pages <b>({PAGES}) : </b></td>
		<td class="{B1}" align="center">{PAGINATION}</td>
	</tr>
</table>
<br />
<table align="center" class="grey" cellspacing="{CS}" cellpadding="{CP}" width="98%">
	<tr><td colspan="9" class="tbhead">List users mesages</td>
	</tr>
	<tr>
			<td class="bgmain" width="10%">Username</td>
			<td class="bgmain" width="10%">De la</td>
			<td class="bgmain" width="10%">Email</td>
			<td class="bgmain" width="15%" >Subiect</td>
			<td class="bgmain" width="40%" >Mesaj </td>
			<td class="bgmain" width="5%" >Citit</td>
			
			<td class="bgmain" width="10%" >Data </td>
			
		
	</tr>
	<!-- BEGIN list -->
	<tr class="{BGCOLOR}">
		<td><b>{USERNAME}</b></td>
		 <td >{NUME_EXPEDITOR}	</td>
		 <td >{EMAIL}</td> 
		<td >{SUBIECT_MESAJ}</td>
		<td >{MESAJ}  <br> <b>Telefon:</b> {TELEFON}<!-- ...<a href="{DETALIIMESAJ}">citeste</a> --></td>
		<td  style="color:{COLOR_MESAGE};">{MESAJ_STATUS} </td>
		
		<td >{DATA} </td>
		
	</tr>
	<!-- END list -->
<tr>
			<td colspan="9"  width="10%" style="text-align:left;"><br /><br />
			<font size="" color="#CC0000"><b>*Citit-Necitit:</b></font> imi arata daca mesajul a fost sau nu citit de utilizator
			</td>
</tr>
</table>