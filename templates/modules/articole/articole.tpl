<div class='related {HIDE_SMALL_VIEW}'>
	<ul class='list-group list-inline'>
		<!-- BEGIN rowdoiart -->
		<li class='list-group-item col-xs-6 col-sm-3 col-md-2 text-center small {SELL_CAT_CLASS}'>
			<p class="list-group-item-heading">
				<a href="{REWRITECAT_ID}" title="{CAT_NAME}">
					<img src="{IMAGE_CATEGORY}" title="{CAT_NAME}" alt="title="{CAT_NAME}" class='img-thumbnail img-responsive'>
				</a>
			</p>
			<p class="list-group-item-text orange_title"><a href="{REWRITECAT_ID}" title="{CAT_NAME}">{CAT_NAME}</a><br>({NR_ART})</p>
		</li>
		<!-- END rowdoiart -->
	</ul>
</div>

<div class='clearfix'></div>
<h2>Articole de stomatologie din {CATEGORY_NAME}</h2>
<div class="row">
	<!-- BEGIN rowunucabs -->
	<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
		<div class="thumbnail">
			<div class="caption">
				<h3><a href="{URLCITESTE}" title="{TITLE_URL_ANUNTURI}" class='orange_title'>{TITLU_ANUNT}</a></h3>
				<p class='caption-text'>
					<a href="{URLCITESTE}" title="{AHREFCABS}">
						<img src="{IMAGE}" title="{TITLU_ANUNT}" alt="Imagine {TITLU_ANUNT}" class='pull-left img-thumbnail img-responsive'>
					</a>
					{DESCRIERE} 
				</p>
				{CATEGORY_DISPLAY}
			</div>
		</div>
	</div>
	<!-- END rowunucabs -->
</div>

<!-- BEGIN pagination_table -->
<ul class="pagination pagination-md">
	<li>{PAGINATION}</li>
	<li class='active'>&nbsp;&nbsp;&nbsp;<a href='#'>{COUNT_ARTICLES} Articole medicale</a></li>
</ul>
<!-- END pagination_table -->
<br>