<br>
<br>
{INFORMATION}
<br>
[ <a href='index.php?page=pachete.add'>Adauga Pachet Nou</a> ]
<br>
<table width="100%" class="grey" cellpadding="4" cellspacing="1">
	<tr>
		<td class="tbhead" colspan="7">View All Pachete Promovare</td>
	</tr>
	<tr>
		<td class="bgmain" width="5%">Id</td>
		<td class="bgmain" width="15%">Name</td>
		<td class="bgmain" width="10%">Status</td>
		<td class="bgmain" width="10%">Pret</td>
		<td class="bgmain" width="5%">Perioada</td>
		<td class="bgmain" width="35%">Servicii</td>
		<td class="bgmain" width="10%">&nbsp;</td>
	</tr>
	<!-- BEGIN list_pachete -->
	<tr class="{BGCOLOR}">
		<td align="center">{ID}</td>
		<td><b>{NAME}</b></td>
		<td align="center">
			<a href="?page=pachete.set.{IMAGE_TITLE}.{ID}">
			<img src="../images/admin/{IMAGE}" title='Turn "{NAME}" pachet promovare into {IMAGE_TITLE}'>
			</a>
		</td>
		<td align="center">{PRET} RON</td>
		<td align="center">{LUNI} luni</td>
		<td>
			<ul>
				<!-- BEGIN list_servicii -->
				<li>{SERV}</li>
				<!-- END list_servicii -->
			</ul>
		</td>
		<td align="center">
			<a href="?page=pachete.edit.{ID}"><img src="../images/admin/edit.png" title='Edit "{NAME}" pachet promovare'></a>
			<a onclick="return confirmSubmit()" href="?page=pachete.delete.{ID}">
				<img src="../images/admin/delete.png" title='Delete "{NAME}" pachet promovare'>
			</a>
		</td>
	</tr>
	<!-- END list_pachete -->
</table>
