<h2 class='text-left'>Rezultatele cautarii dupa: {SEARCH_STRING}</h2>
<div class='row'>
	{NO_FIRM_HERE}
	<div class='col-sm-12 responsive-search'>
		<ul class="nav nav-tabs small">
			<!-- BEGIN list_filter_cats -->
			<li class='{FILTER_CAT_ACTIVE} {FILTER_CAT_NORESULTS}'><a href="{FILTER_CAT_LINK}">{FILTER_CAT} ({FILTER_CAT_NR})</a></li>
			<!-- END list_filter_cats -->
		</ul>
		<br>
		<div class="tab-content">
			<!-- BEGIN results -->
			<div class="{RECOMANDAT_CLASS} col-xs-12 col-sm-6 col-md-4 col-lg-3">
				<!-- BEGIN if_business -->
				<div class='ribbon ribbon-blue'>
					<span class='ribbon-text'>business</span>
				</div>
				<!-- END if_business -->
				<!-- BEGIN if_recomandat -->
				<div class='ribbon ribbon-orange'>
					<span class='ribbon-text'>premium</span>
				</div>
				<!-- END if_recomandat -->
				<div class="thumbnail">
					<div class="caption">
						<h3><a href="{URLCITESTE}" title="{AHREFCABS}" class='orange_title'>{NUME_FIRMA}</a></h3>
						<p class='caption-text'>
							<a href="{URLCITESTE}" title="{AHREFCABS}">
								<img src="{THUMBNAIL}" title="{NUME_FIRMA},{JUDET}" alt="{NUME_FIRMA}" class='pull-left img-thumbnail img-responsive'>
							</a>
							{DESCRIERE} ...
						</p>
					</div>
				</div>
			</div>
			<!-- END results -->
		</div>
		<div class='clearfix'></div>
		<ul class="pagination">
			<li>{PAGINATION}</li>
			<li class='active'>&nbsp;&nbsp;&nbsp;<a href='#'>{COUNT_REZ} Rezultate</a></li>
		</ul>
	</div>
</div>