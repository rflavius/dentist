<br>
<br>
{INFORMATION}
<br>
[ <a href='index.php?page=servicii.add'>Adauga Serviciu Nou</a> ]
<br>
<table width="100%" class="grey" cellpadding="4" cellspacing="1">
	<tr>
		<td class="tbhead" colspan="10">View All Servicii</td>
	</tr>
	<tr>
		<td class="bgmain" width="5%">Id</td>
		<td class="bgmain" width="10%">Name</td>
		<td class="bgmain" width="30%">Description</td>
		<td class="bgmain" width="10%">Value</td>
		<td class="bgmain" width="10%">Price</td>
		<td class="bgmain" width="10%">Active</td>
		<td class="bgmain" width="10%">&nbsp;</td>
	</tr>
	<!-- BEGIN list_servicii -->
	<tr class="{BGCOLOR}">
		<td align="center">{ID}</td>
		<td><b>{NAME}</b></td>
		<td><b>{DESCRIPTION}</b></td>
		<td align='center'><b>{VALUE}</b></td>
		<td align='center'><b>{PRICE} RON</b></td>
		<td align="center">
			<a href="?page=servicii.set.{IMAGE_TITLE}.{ID}">
			<img src="../images/admin/{IMAGE}" title='Turn "{NAME}" serviciu into {IMAGE_TITLE}'>
			</a>
		</td>
		<td align="center">
			<a href="?page=servicii.edit.{ID}"><img src="../images/admin/edit.png" title='Edit "{NAME}" serviciu promovare'></a>
			<a onclick="return confirmSubmit()" href="?page=servicii.delete.{ID}">
				<img src="../images/admin/delete.png" title='Delete "{NAME}" serviciu promovare'>
			</a>
		</td>
	</tr>
	<!-- END list_servicii -->
</table>
