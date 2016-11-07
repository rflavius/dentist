<script language="javascript" type="text/javascript">
<!--
	function redirect()
	{
			document.location.href = "index.php?page=anunturi.list."+document.anunturiform.select_cat.value+"."+document.anunturiform.select_status.value;
	}

//-->
</script>	

<form method="post" action="" name="anunturiform">
<table align="center" border="0" cellspacing="0" cellpadding="0" width="98%">
	<tr>
		<td>
			{INFORMATION}
			<table align="center" class="tbpagination" cellspacing="{CS}" cellpadding="{CP}" width="100%">
				<tr>
					<td class="{B1}" width="80"><strong>List anunturi: </strong></td>
					<td class="{B2}" width="80">
						<select name="select_cat" onChange="redirect();">
							<option value="all">All</option>
							<!-- BEGIN bigcat -->
								<option value="{CAT_ID}" {SELECTED_CAT}>{CAT_NAME}</option>
							<!-- END bigcat -->
						</select>
					</td>
					<td class="{B1}" width="50"><strong>Status: </strong></td>
					<td class="{B2}" width="50">
						<select name="select_status" onChange="redirect();">
							<option value="all" {SELECTEDALL}>All</option>
							<option value="1" {SELECTED1}>Active</option>
							<option value="0" {SELECTED0}>Inactive</option>
						</select>
					</td>
					<td class="{B1}"  width="80" align="center"><strong>{COUNT_ANUNTURI}</strong> Anunturi</td>
					<td class="{B2}" width="60" align="center">Pages <strong>({PAGES}) : </strong></td>
					<td class="{B1}" align="center">{PAGINATION}</td>
				</tr>
				
			</table>
			<br />
			<table width="100%" class="grey" cellpadding="4" cellspacing="1">
				<tr>
					<td class="tbhead" colspan="12">List anunturi</td>
				</tr>
				<!-- BEGIN if_anunturi -->
				<tr>
					<td class="bgmain" width="10%">Username</td>
					<td class="bgmain" width="10%">Title</td>
					<td class="bgmain" width="10%">Image</td>
					<td class="bgmain" width="20%">Content</td>
					<td class="bgmain" width="8%" nowrap>Date Add
					<a href="?page={PAGE_NAME}&displaymode=data-data_adaugarii-ASC">
							<img src="../images/admin/down.png" title="Ascending A to Z">
						</a>&nbsp;
						<a href="?page={PAGE_NAME}&displaymode=data-data_adaugarii-DESC">
							<img src="../images/admin/up.png" title="Descending Z to A">
						</a>
					</td>
					<td class="bgmain" width="8%" nowrap>Date Mod
					<a href="?page={PAGE_NAME}&displaymode=data-data_modificarii-ASC">
							<img src="../images/admin/down.png" title="Ascending A to Z">
						</a>&nbsp;
						<a href="?page={PAGE_NAME}&displaymode=data-data_modificarii-DESC">
							<img src="../images/admin/up.png" title="Descending Z to A">
						</a>
					</td>
					<td class="bgmain" width="8%" nowrap>Date Exp
					<a href="?page={PAGE_NAME}&displaymode=data-data_expirarii-ASC">
							<img src="../images/admin/down.png" title="Ascending A to Z">
						</a>&nbsp;
						<a href="?page={PAGE_NAME}&displaymode=data-data_expirarii-DESC">
							<img src="../images/admin/up.png" title="Descending Z to A">
						</a>
					</td>
					<td class="bgmain" width="8%" nowrap>Nr.vizite <a href="?page={PAGE_NAME}&displaymode=vizite-nr_visits-ASC">
							<img src="../images/admin/down.png" title="Ascending A to Z">
						</a>&nbsp;
						<a href="?page={PAGE_NAME}&displaymode=vizite-nr_visits-DESC">
							<img src="../images/admin/up.png" title="Descending Z to A"></td>
					<td class="bgmain" width="8%" nowrap>Published</td>
					<td class="bgmain" width="5%">Edit</td>
					<td class="bgmain" width="5%">Delete</td>
				</tr>
				<!-- BEGIN list_anunturi -->
				<tr class="{BGCOLOR}">
					<td><b><a href="?page=users.details.{USER_ID}.{USER}">{USER}</a> {LEVEL}</b>  {COMMENTS}</td>
					<td><b><a href="{LINK_TO_ANUNT}" title='View "{TITLU}" ' target="_blank">{TITLU}</a></b></td>
					<td valign="top" align="center"><img src="{THUMBNAILS}" ></td>
						<td valign="top" >{CONTENT}</td>
				<td valign="top" align="center">{DATE_ADDED}</td>
					<td valign="top">{DATE_MOD}</td>
					<td valign="top">{DATE_EXP}</td>
					<td>{NR_VISITS}</td>
					<td align="center" valign="top">
						<a href="?page=anunturi.set.{IMAGE_TITLE}.{ID}">
					<img src="../images/admin/{IMAGE}" title='Turn "{TITLU}" anunturi to {IMAGE_TITLE}'>
						</a>
					</td>
					<td align="center" valign="top"><a href="?page=anunturi.edit.{ID}.{USER_ID}"><img src="../images/admin/edit.png" title='Edit "{TITLU}" anunturi'></a></td>
					<td align="center" valign="top">
						<a href="?page=delete.anunturi.{ID}">
							<img src="../images/admin/delete.png" title='Delete "{TITLU}" anunturi'>
						</a>
					</td>
					</td>
				</tr>
				<!-- END list_anunturi -->
				<!-- END if_anunturi -->
				<!-- BEGIN no_anunturi -->
				<tr>
					<td class="bgmain">No anunturi in database</td>
				</tr>
				<!-- END no_anunturi -->
			</table>
		</td>
	</tr>
</table>
			</form>