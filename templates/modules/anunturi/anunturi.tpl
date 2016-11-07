<div class='related {HIDE_SMALL_VIEW}'>
	<ul class='list-group list-inline'>
		<!-- BEGIN display_cats_anunturi -->
		<li class='col-xs-6 col-sm-3 col-md-3'>
			<a href="{REWRITECAT_ID}" title="{CAT_NAME}" class="list-group-item text-center small orange_title {SELL_CAT_CLASS}">{CAT_NAME}</a>
		</li>
		<!-- END display_cats_anunturi -->
	</ul>
</div>

<div class='clearfix'></div>
<h2>Anunturi medicale: {SELL_CAT} {SELL_SUBCAT}</h2>
<div class="row">
	<!-- BEGIN rowdoicabs -->
	<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
		<div class="thumbnail">
			<div class="caption">
				<h3><a href="{URLCITESTE}" title="{TITLE_URL_ANUNTURI}" class='orange_title'>{TITLU_ANUNT}</a></h3>
				<p class='caption-text'>
					<a href="{URLCITESTE}" title="{TITLU_ANUNT}">
						<img src="{IMAGE}" title="{TITLU_ANUNT}" alt="Imagine {TITLU_ANUNT}" class='pull-left img-thumbnail img-responsive' style='max-width:70px;'>
					</a>
					{DESCRIERE} ...
				</p>
				<span class='small'><a href="{ART_CAT}" class="small">{BIGCAT}</a></span>
			</div>
		</div>
	</div>
	<!-- END rowdoicabs -->
</div>

<br>
<!-- BEGIN pagination_table -->
<ul class="pagination pagination-md">
	<li>{PAGINATION}</li>
	<li class='active'>&nbsp;&nbsp;&nbsp;<a href='#'>{COUNT_ANUNTURI} Anunturi medicale</a></li>
</ul>
<!-- END pagination_table -->
<br>
<br>