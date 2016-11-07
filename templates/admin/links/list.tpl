<script language="JavaScript" type="text/JavaScript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>

<table align="center" border="0" cellspacing="0" cellpadding="0" width="90%">
	<tr>
		<td>
			{INFORMATION}
			<table width="100%" class="grey" cellpadding="4" cellspacing="1">
				<tr>
					<td class="tbhead" colspan="11">List links</td>
				</tr>
				<!-- BEGIN if_links -->
				<tr>
					<td class="bgmain" width="15%">Title</td>
					<td class="bgmain" width="15%">Link</td>
					<td class="bgmain" width="30%">Description</td>
					<td class="bgmain" width="10%">Order</td>
					<td class="bgmain" width="10%">Published</td>
					<td class="bgmain" width="10%">Edit</td>
					<td class="bgmain" width="10%">Delete</td>
				</tr>
				<!-- BEGIN list_links -->
				<tr class="{BGCOLOR}">
					<td valign="top"><b>{TITLE}</b></td>
					<td valign="top"><a href="{LINK}" target="_blank">{LINK}</a></td>
					<td valign="top"><div id="norows">{DESCRIPTION}</div></td>
					<td align="center" valign="top">
						<a href="?page=links.rearenge.up.{ID}">
							<img src="../images/admin/up.png" title="Move up">
						</a>&nbsp;
						<a href="?page=links.rearenge.down.{ID}">
							<img src="../images/admin/down.png" title="Move down">
						</a>
					</td>
					<td align="center" valign="top">
						<a href="?page=links.set.{IMAGE_TITLE}.{ID}">
					<img src="../images/admin/{IMAGE}" title='Turn "{TITLE}" link to {IMAGE_TITLE}'>
						</a>
					</td>
					<td align="center" valign="top"><a href="?page=links.edit.{ID}"><img src="../images/admin/edit.png" title='Edit "{TITLE}" news'></a></td>
					<td align="center" valign="top">
						<a href="?page=delete.links.{ID}">
							<img src="../images/admin/delete.png" title='Delete "{TITLE}" link'>
						</a>
					</td>
					</td>
				</tr>
				<!-- END list_links -->
				<!-- END if_links -->
				<!-- BEGIN no_links -->
				<tr>
					<td class="bgmain">No links in database.</td>
				</tr>
				<!-- END no_links -->
			</table>
		</td>
	</tr>
</table>