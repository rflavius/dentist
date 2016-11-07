<script LANGUAGE="JavaScript">
<!--
function confirmSubmit()
{
var agree=confirm("Are you sure you want to delete message ?");
if (agree)
	return true ;
else
	return false ;
}
// -->
</script>
<script language="JavaScript" type="text/javascript">
<!--
function close_div (id)
{
	opened_var = "opened_"+id;
	close_var = "close_"+id;
	restore_var = "restore_"+id;
	document.getElementById(opened_var).style.display = "none";
	document.getElementById(close_var).style.display = "none";
	document.getElementById(restore_var).style.display = "block";
}

function open_div (id)
{
	opened_var = "opened_"+id;
	close_var = "close_"+id;
	restore_var = "restore_"+id;
	document.getElementById(opened_var).style.display = "block";
	document.getElementById(close_var).style.display = "block";
	document.getElementById(restore_var).style.display = "none";
}
//-->
</script>
<table width="95%" border="0" cellpadding="5" cellspacing="10" align="center">
<tr>
	<td valign="top">
		<table width="230" border="0" cellspacing="{CS}" cellpadding="{CP}" class="grey" valign="top">
		<tr > 
			<td class="tbhead" colspan="3">Today Statistics</td>
		</tr>
			<tr >
			<td class="row1" rowspan="8"><img src="../images/allstufs/statistics.jpg"></td>
		</tr>
				<tr>
			<td class="row2"><strong>Users</strong></td>
			<td align="center" class="row1" width="35" >
				<a href="?page=users.list" style="color:#FF0000">[ {COUNT_TODAY_USERS} ]</a>
			</td>
		</tr>
					<tr>
			<td class="row2"><strong>Cabinete</strong></td>
			<td align="center" class="row1" width="35" style="color:#CC0000;">
				<a href="?page=cabinete.list" style="color:#FF0000">[ {COUNT_TODAY_CABINETE} ] </a>
			</td>
		</tr>
		<tr>
			<td class="row2"><strong>Anunturi</strong></td>
			<td align="center" class="row1" width="35" style="color:#CC0000;">
				<a href="?page=anunturi.list" style="color:#FF0000">[ {COUNT_TODAY_ANUNTURI} ]</a>
		</td>
			<tr>
			<td class="row2"><strong>Articole</strong> {NEW_IMAGE_ARTICOLE}</td>
			<td align="center" class="row1" width="35" style="color:#CC0000;">
				<a href="?page=articles.list" style="color:#FF0000">[ {COUNT_TODAY_ARTICOLE} ]</a>
		</td>
		</tr>
		<tr>
			<td class="row2"><strong>Visitors</strong></td>
			<td align="center" class="row1" width="35" style="color:#CC0000;">
				<a href="?page=visitors.list" style="color:#FF0000">[ {COUNT_TODAY_VIZITATORI} ]</a>
			</td>
		</tr>
		<tr>
			<td class="row2"><strong>Mesaje admin</strong> {NEW_IMAGE_MESAJE}</td>
			<td align="center" class="row1" width="35" style="color:#CC0000;">
				<a href="?page=contact.list" style="color:#FF0000">[ {COUNT_MESAJE} ]</a>
			</td>
		</tr>
		<tr>
			<td class="row2"><strong>Mesaje utilizatori</strong> {NEW_IMAGE_MESAJE_UTILIZATOR}</td>
			<td align="center" class="row1" width="35" style="color:#CC0000;">
				<a href="?page=users.listmesaje" style="color:#FF0000">[ {COUNT_MESAJE_UTILIZATORI} ]</a>
			</td>
		</tr>
	</table> 
	</td>
	<td valign="top">
		<table border='0' width='100%' align='center' cellspacing='0' cellpadding='0'>
		<tr>
			<td>
						<table width="230" border="0" cellspacing="{CS}" cellpadding="{CP}" class="grey">
							<tr >
								<td class="tbhead" colspan="3">Cabinete statistics 1{NEW_IMAGE_CABINETE}</td>
							</tr>
							<tr >
								<td class="row1" rowspan="7"><img src="../images/allstufs/tooth2.JPG"></td>
							</tr>
							<tr>
								<td class="row2"><strong>Cabinete stom.</strong></td>
								<td align="center" class="row1" width="45">
									<a href="?page=cabinete.list.module_1">[ {COUNT_CABINETE_STOMATOLOGICE} ]</a>
								</td>
							</tr>
							<tr>
								<td class="row2"><strong>Radiologie dentara</strong></td>
								<td align="center" class="row1" width="45">
									<a href="?page=cabinete.list.module_3">[ {COUNT_RADIOLOGIE_DENTARA} ]</a>
								</td>
							</tr>
							<tr>
								<td class="row2"><strong>Tehnica dentara</strong></td>
								<td align="center" class="row1" width="45">
									<a href="?page=cabinete.list.module_2">[ {COUNT_TEHNICA_DENTARA} ]</a>
								</td>
							</tr>
							<tr>
								<td class="row2"><strong>Distribuitori</strong></td>
								<td align="center" class="row1" width="45">
									<a href="?page=cabinete.list.module_4">[ {COUNT_DISTRIBUITORI} ]</a>
								</td>
							</tr>
							<tr>
								<td class="row2"><strong>Clinici Stom.</strong></td>
								<td align="center" class="row1" width="45">
									<a href="?page=cabinete.list.module_5">[ {COUNT_CLINICI_STOMATOLOGICE} ]</a>
								</td>
							</tr>
							<tr>
								<td class="row2"><strong>All</strong></td>
								<td align="center" class="row1" width="45">
									<a href="?page=cabinete.list">[ {COUNT_CABINETE} ]</a>
								</td>
							</tr>
						</table> 
			</td>
		</tr>
		<tr>
			<td><br>
					&nbsp;
				
			</td>
		</tr>
		</table>
		
		
	</td>
	<td valign="top">
		<table>
		<tr>
			<td>
				<table width="200" border="0" cellspacing="{CS}" cellpadding="{CP}" class="grey">
					<tr >
						<td class="tbhead" colspan="3">Users statistics {NEW_IMAGE_USERS}</td>
					</tr>
					<tr >
						<td class="row1" rowspan="4"><img src="../images/allstufs/users_into.png"></td>
					</tr>
					<tr>
						<td class="row2"><strong>Active</strong></td>
						<td align="center" class="row1" width="40">
							<a href="?page=users.list.creation_date_desc.1">[ {COUNT_ACTIVE_USERS} ]</a>
						</td>
					</tr>
					<tr>
						<td class="row2"><strong>Inactive</strong></td>
						<td align="center" class="row1" width="40">
							<a href="?page=users.list.creation_date_desc.0">[ {COUNT_INACTIVE_USERS} ]</a>
						</td>
					</tr>
					<tr>
						<td class="row2"><strong>All</strong></td>
						<td align="center" class="row1" width="40">
							<a href="?page=users.list">[ {COUNT_ALL_USERS} ]</a>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td>
				<table width="200" border="0" cellspacing="{CS}" cellpadding="{CP}" class="grey">
				<tr >
					<td class="tbhead" colspan="3">Anunturi statistics {NEW_IMAGE_ANUNTURI}</td>
				</tr>
				<tr >
					<td class="row1" rowspan="4"><img src="../images/allstufs/newspaperanunt.png"></td>
				</tr>
				<tr>
					<td class="row2"><strong>Active</strong></td>
					<td align="center" class="row1" width="35">
						<a href="?page=anunturi.list.all.1">[ {COUNT_ACTIVE_ANUNTURI} ]</a>
					</td>
				</tr>
				<tr>
					<td class="row2"><strong>Inactive</strong></td>
					<td align="center" class="row1" width="35">
						<a href="?page=anunturi.list.all.0">[ {COUNT_INACTIVE_ANUNTURI} ]</a>
					</td>
				</tr>
				<tr>
					<td class="row2"><strong>All</strong></td>
					<td align="center" class="row1" width="35">
						<a href="?page=anunturi.list">[ {COUNT_ALL_ANUNTURI} ]</a>
					</td>
				</tr>
				</table>
			</td>
		</tr>
		</table>
	</td>
	<td valign="top">
			<table border='0' width='100%' align='center' cellspacing='0' cellpadding='0'>
			<tr>
				<td>
					<table width="220" border="0" cellspacing="{CS}" cellpadding="{CP}" class="grey">
						<tr >
							<td class="tbhead" colspan="3">Update database "NEW"</td>
						</tr>
						<tr >
							<td class="row1" rowspan="4"><img src="../images/allstufs/attention1.gif"></td>
						</tr>
						<tr>
							<td class="row2"><strong>Last update</strong></td>
							<td align="center" class="row1" width="35" {CLASS_UPDATE}>{LASTUPDATE}	</td>
						</tr>
						<tr>
							<td class="row2"><strong>Update</strong></td>
							<td align="center" class="row1" width="35">
								<form method="post" action="?page=static.update" name="">
									<input type="submit" name="sbmtbtn" style="background-color:#FFDE00; font-weight:bold" value="Update New" />
								</form>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td><br>
						<table width="220" border="0" cellspacing="{CS}" cellpadding="{CP}" class="grey">
							<tr >
								<td class="tbhead" colspan="3">Generate XML files</td>
							</tr>
							<tr>
								<td class="row2"><strong>Update Categories Xml</strong></td>
								<td align="center" class="row1" width="35">
									<form method="post" action="?page=static.generatexml" name="">
										<input type="submit" name="sbmtbtn" style="background-color:#FFDE00; font-weight:bold" value="Update " />
									</form>
								</td>
							</tr>
								<tr>
								<td class="row2"><strong>Update BiG Modules Xml</strong></td>
								<td align="center" class="row1" width="35">
									<form method="post" action="?page=static.generatexmlmodule" name="">
										<input type="submit" name="sbmtbtn" style="background-color:#FFDE00; font-weight:bold" value="Update" />
									</form>
								</td>
							</tr>
								<tr>
								<td class="row2"><strong>Update Big Feed.xml</strong></td>
								<td align="center" class="row1" width="35">
									<form method="post" action="?page=static.generatebigfeed" name="">
										<input type="submit" name="sbmtbtn" style="background-color:#FFDE00; font-weight:bold" value="Update" />
									</form>
								</td>
							</tr>
							</table>
				
				</td>
			</tr>
			</table>
				
	</td>
</tr>
<tr>
	<td valign="top">
		<table width="230" border="0" cellspacing="{CS}" cellpadding="{CP}" class="grey">
		<tr >
			<td class="tbhead" colspan="4">Facturi proforme statistics {NEW_IMAGE_FACTURI_PROFORME}</td>
		</tr>
		<tr >
			<td class="row1" rowspan="5"><img src="../images/allstufs/factura.gif"></td>
		</tr>
		<tr>
			<td class="row2"><strong>Achitate</strong></td>
			<td align="center" class="row1" width="35">
				<a href="?page=plati.facturiproforme.adaugare_proforma_desc.Y.all">[ {COUNT_PROFORME_PLATITE} ]</a>
			</td>
		</tr>
		<tr>
			<td class="row2"><strong>Neachitate active</strong></td>
			<td align="center" class="row1" width="35">
				<a href="?page=plati.facturiproforme.adaugare_proforma_desc.N.Y">[ {COUNT_PROFORME_NEPLATITE_ACTIVE} ]</a>
			</td>
		</tr>
		<tr>
			<td class="row2"><strong>Neachitate Inactive</strong></td>
			<td align="center" class="row1" width="35">
				<a href="?page=plati.facturiproforme.adaugare_proforma_desc.N.N">[ {COUNT_PROFORME_NEPLATITE_INACTIVE} ]</a>
			</td>
		</tr>
		<tr>
			<td class="row2"><strong>All</strong></td>
			<td align="center" class="row1" width="35">
				<a href="?page=plati.facturiproforme">[ {COUNT_ALL_PROFORME} ]</a>
			</td>
		</tr>
		</table>
	</td>
	<td valign="top">
		<table width="220" border="0" cellspacing="{CS}" cellpadding="{CP}" class="grey">
		<tr >
			<td class="tbhead" colspan="5">Facturi Fiscale statistics</td>
		</tr>
		<tr >
			<td class="row1" rowspan="6"><img src="../images/allstufs/printer.gif"></td>
		</tr>
		<tr>
			<td class="row2"><strong>Trimise</strong></td>
			<td align="center" class="row1" width="35">
				<a href="?page=plati.facturifiscale.data_eliberarii_desc.Y.all">[ {COUNT_FISCALE_TRIMISE} ]</a>
			</td>
		</tr>
		<tr>
			<td class="row2"><strong>Netrimise</strong></td>
			<td align="center" class="row1" width="35">
				<a href="?page=plati.facturifiscale.data_eliberarii_desc.N.all">[ {COUNT_FISCALE_NETRIMISE} ]</a>
			</td>
		</tr>
		<tr>
			<td class="row2"><strong>All</strong></td>
			<td align="center" class="row1" width="35">
				<a href="?page=plati.facturifiscale">[ {COUNT_ALL_FISCALE} ]</a>
			</td>
		</tr>
		</table>

	</td>
	<td valign="top">
		<table width="210" border="0" cellspacing="{CS}" cellpadding="{CP}" class="grey">
			<tr>
				<td class="tbhead" colspan="2">Sitemap Statistics</td>
			</tr>
			<tr>
				<td class="row1" colspan="2">
					[<b> <a href="?page=sitemap.generate">Generate Sitemap</a> </b>]</td>
			</tr>
			<tr>
				<td class="row2" width="50%">
					{SITEMAP_PAGES} pages
				</td>
				<td class="row2" width="50%">
					{SITEMAP_GENERATED}
				</td>
			</tr>
		</table>
		<br>
		<table width="210" border="0" cellspacing="{CS}" cellpadding="{CP}" class="grey">
			<tr>
				<td class="tbhead" colspan="2">GMAP statistics</td>
			</tr>
			<tr>
				<td class="row2"><strong><font color='red'>NOT DONE</font></strong></td>
				<td align="center" class="row1" width="75">
					<a href="?page=gmap&status=N">[ {COUNT_GMAP_NOTDONE} ]</a>
				</td>
			</tr>
			<tr>
				<td class="row2"><strong><font color='blue'>DONE</font></strong></td>
				<td align="center" class="row1" width="75">
					<a href="?page=gmap&status=Y">[ {COUNT_GMAP_DONE} ]</a>
				</td>
			</tr>
			<tr>
				<td class="row2"><strong>TOTAL</strong></td>
				<td align="center" class="row1" width="75">
					<a href="?page=gmap">[ {COUNT_GMAP} ]</a>
				</td>
			</tr>
		</table>
	</td>
	<td valign="top">
		<table width="310" border="0" cellspacing="{CS}" cellpadding="{CP}" class="grey">
						<tr>
							<td class="tbhead" colspan="3">Generate thumbs</td>
						</tr>
						<tr>
							<td class="tbhead" rowspan="4"><img src="../images/admin/my_images.png"></td>
						</tr>
						<tr>
							<td class="row1" colspan="2">
								[<b> <a href="http://www.dentistonline.ro/resize_thumb.php?what_to_resize=anunturi">Generate Anunturi</a> </b>]</td>
						</tr>
								<tr>
							<td class="row1" colspan="2">
								[<b> <a href="http://www.dentistonline.ro/resize_thumb.php?what_to_resize=articole">Generate Articole</a> </b>]</td>
						</tr>
								<tr>
							<td class="row1" colspan="2">
								[<b> <a href="http://www.dentistonline.ro/resize_thumb.php?what_to_resize=cabinete">Generate Cabinete</a> </b>]</td>
						</tr>
						
					</table>
	
</td>
</tr>
				
<tr>
		<td valign="top" colspan="3">
			<table width="100%" border="0" cellspacing="{CS}" cellpadding="{CP}" class="grey" align="center">
				<tr>
					<td class="tbhead" colspan="2">System Overview</td>
				</tr>
				<tr>
					<td valign="top" class="{B2}"><strong>SQL Version</strong></td>
					<td class="{B1}">MYSQL {MYSQL}</td>
				</tr>
				<tr> 
					<td valign="top" class="{B2}"><strong>PHP Version</strong></td>
					<td class="{B1}">{PHP} ({PHPAPI}) &nbsp;&nbsp;[ <a href="index.php?page=phpinfo">Php Info</a> ]</td>
				</tr>
				<tr> 
					<td valign="top" class="{B2}" width="25%"><strong>Writable Folders</strong></td>
					<td class="{B1}">
						<!-- BEGIN writable_folders -->
						<div id="div_title">
							<span id="left">{FOLDER_NAME}</span>
							<span><img src="../images/admin/{FOLDER_STATUS}" title="{IMAGE_TITLE}"></span>
						</div>
						<!-- END writable_folders -->
					</td>
				</tr>
				<tr> 
					<td valign="top" class="{B2}" width="25%"><strong>Cronuri</strong></td>
					<td class="{B1}">
						Update pentru <b style="color:#990000">status factura din facturi proforme</b> - pus cand se logheaza admin
					</td>
				</tr>
			</table>
		<br>
		{INFORMATION}
		<table border="0" cellpadding="{CP}" cellspacing="{CS}" class="grey" width="100%">
			<form action="?page=static.add" method="post" name="mess">
				<tr>
					<td class="tbhead" colspan="2">ADD NEW REMINDER</td>
				</tr>
				<tr>
					<td valign="top" class="row2">
						<textarea name="message" rows="2" cols="80"></textarea>
					</td>
					<td align="center" class="row1">
						<input type="submit" value=" Add " class="button">
					</td>
				</tr>
			</form>
			</table>
			<br>
			<table width="100%" border="0" cellspacing="{CS}" cellpadding="{CP}" class="grey">
				<tr> 
					<td class="tbhead" colspan="4">REMINDERS</td>
				</tr>
				<!-- BEGIN if_messages -->
				<tr>
					<td class="bgmain" nowrap width="10%">From </td>
					<td class="bgmain" width="60%">Subject </td>
					<td class="bgmain" width="20%">Date </td>
					<td class="bgmain" width="10%">Delete </td>
				</tr>
				<!-- BEGIN messages -->
				<tr class="{BGCOLOR}">
					<td><strong>{EXP}</strong></td>
					<td>{MESSAGE}</td>
					<td>{DATE}</td>
					<td align="center">
						<a onclick="return confirmSubmit()" href="?page=static.delete.{ID}">
							<img src="../images/admin/delete.png" title="Delete Message">
						</a>
					</td>
				</tr>
				<!-- END messages -->
				<!-- END if_messages -->
			</table>
		</td>
	</tr>
</table>
<br />