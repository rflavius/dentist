<script language="javascript" type="text/javascript">
<!--
	function redirect()
	{
			document.location.href = "?page=dictionar_medical.listwords."+document.articlesform.select_cat.value+"."+document.articlesform.select_status.value;
	}

//-->
</script>	
<br />
<form method="post" action="" name="articlesform">
<table align="center" class="tbpagination" cellspacing="{CS}" cellpadding="{CP}" width="95%">
	<tr>
		<td class="{B1}" width="115"><strong>LIST ARTICLES FROM : </strong></td>
		<td class="{B2}" width="80">
			<select name="select_cat" onChange="redirect();">
				<option value="all">All categories</option>
					<!-- BEGIN categories -->
						<option value="{CATEGORY_ID}" {SELECTED_CAT}> {CATEGORY_NAME}</option>
					<!-- END categories -->
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
		<td class="{B1}"  width="80" align="center"><strong>{COUNT_ARTICLES}</strong> Articles</td>
		<td class="{B2}" width="60" align="center">Pages <strong>({PAGES}) : </strong></td>
		<td class="{B1}" align="center">{PAGINATION}</td>
	</tr>
</table>
<br>
<table width="95%" class="grey" cellpadding="4" cellspacing="1">
	<tr>
		<td class="tbhead" colspan="9">LIST ALL ARTICLES</td>
	</tr>
	<!-- BEGIN if_articles -->
<tr>
						<td class="bgmain" width="5%">Add by</td>
					<td class="bgmain" width="10%">Title</td>

					<td class="bgmain" width="20%">Content</td>
					<td class="bgmain" width="8%" nowrap>Date Add</td>
					<td class="bgmain" width="8%" nowrap>Date Mod</td>
					<td class="bgmain" width="8%" nowrap>Status</td>
					<td class="bgmain" width="8%" nowrap>Published</td>
					<td class="bgmain" width="5%">Edit</td>
					<td class="bgmain" width="5%">Delete</td>
				</tr>
				<!-- BEGIN list_articles -->
				<tr class="{BGCOLOR}">
				<td><b><a href="{USER_LINK}">{USER_ID}</a></b></td>
					<td><b>{TITLU}</b></td>
					<td valign="top" >{CONTENT}</td>
				<td valign="top" align="center">{DATE_ADDED}</td>
					<td valign="top">{DATE_MOD}</td>
					<td valign="top" align="center">{TERMEN_STATUS}</td>

					<td align="center" valign="top">
						<a href="?page=dictionar_medical.set.{IMAGE_TITLE}.{ID}">
					<img src="../images/admin/{IMAGE}" title='Turn "{TITLU}" article to {IMAGE_TITLE}'>
						</a>
					</td>
					<td align="center" valign="top"><a href="?page=dictionar_medical.edit.{ID}"><img src="../images/admin/edit.png" title='Edit "{TITLU}" article'></a></td>
					<td align="center" valign="top">
						<a href="?page=delete.dictionar_medical.{ID}">
							<img src="../images/admin/delete.png" title='Delete "{TITLU}" article'>
						</a>
					</td>
					</td>
				</tr>
	<!-- END list_articles -->
	<!-- END if_articles -->
	<!-- BEGIN if_no_articles -->
		<td class="bgmain" colspan="8">No articles for this section</td>
	<!-- END if_no_articles -->
</table>
<br />