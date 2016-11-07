<script language="javascript" type="text/javascript">
<!--
	function redirect()
	{
			document.location.href = "?page=articles.list."+document.articlesform.select_cat.value+"."+document.articlesform.select_status.value;
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
		<td class="tbhead" colspan="10">LIST ALL ARTICLES</td>
	</tr>
	<!-- BEGIN if_articles -->
<tr>
					<td class="bgmain" width="10%">Add by</td>
					<td class="bgmain" width="13%">Level</td>
					<td class="bgmain" width="10%">Title</td>
					<td class="bgmain" width="10%">Image</td>
					<td class="bgmain" width="20%">Content</td>
					<td class="bgmain" width="10%">Date add <a href="?page={PAGE_NAME}&displaymode=data-submision_date-ASC">
							<img src="../images/admin/down.png" title="Ascending A to Z">
						</a>&nbsp;
						<a href="?page={PAGE_NAME}&displaymode=data-submision_date-DESC">
							<img src="../images/admin/up.png" title="Descending Z to A">
						</a>
					</td>

					<td class="bgmain" width="10%">Date modify <a href="?page={PAGE_NAME}&displaymode=data-data_modificarii-ASC">
							<img src="../images/admin/down.png" title="Ascending A to Z">
						</a>&nbsp;
						<a href="?page={PAGE_NAME}&displaymode=data-data_modificarii-DESC">
							<img src="../images/admin/up.png" title="Descending Z to A">
						</a></td>
					<td class="bgmain" width="8%" nowrap>Published</td>
					<td class="bgmain" width="8%" nowrap>Vizite <a href="?page={PAGE_NAME}&displaymode=vizite-nr_visits-ASC">
							<img src="../images/admin/down.png" title="Ascending A to Z">
						</a>&nbsp;
						<a href="?page={PAGE_NAME}&displaymode=vizite-nr_visits-DESC">
							<img src="../images/admin/up.png" title="Descending Z to A"></td>
					<td class="bgmain" width="8%">Actions</td>
					
				</tr>
				<!-- BEGIN list_articles -->
				<tr class="{BGCOLOR}">
					<td><b><a href="?page=users.details.{USER_ID}.{USER}">{USER}</a></b></td>
					<td><b><a href="?page=plati.listfiscaleuser.{USER_ID}" >{LEVEL}</a></b></td>
					
					<td><b><a href="{LINK_TO_ARTICLE}" title='View "{TITLU}" ' target="_blank">{TITLU}</a></b></td>
					<td valign="top" align="center"><img src="{THUMBNAILS}" ></td>
						<td valign="top" >{CONTENT}</td>
				<td valign="top" align="center">{DATE_ADDED}</td>
					<td valign="top">{DATE_MOD}</td>
					<td align="center" valign="top">
						<a href="?page=articles.set.{IMAGE_TITLE}.{ID}">
					<img src="../images/admin/{IMAGE}" title='Turn "{TITLU}" article to {IMAGE_TITLE}'>
						</a>
					</td>
					<td>{NR_VISITS}</td>
				<td align="center" valign="top">
					[ <a href="?page=articles.edit.{ID}.{USER_ID}" title='Edit "{TITLU}" article'>Edit</a> ]<br>
					[	<a href="?page=articles.move.{ID}.{USER_ID}" title='Move "{TITLU}" article to anunturi'>Move </a> ]<br>
					[	<a href="?page=delete.articles.{ID}" title='Delete "{TITLU}" article'>Delete </a> ]
						
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