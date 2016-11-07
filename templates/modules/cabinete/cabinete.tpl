<div>
	<!-- BEGIN Recomandam -->
	<a name="ex_recomandat"></a>
	<h2>{RECOMANT_CATEGORY_NAME} recomandate din {JUDET_NAME}</h2>
	<div class="row recomandat">
		{DISPLAY_RECOMANDAT}
		<!-- BEGIN display_image -->
		<div class='col-xs-12 col-sm-6 col-md-4 col-lg-4'>
			<a href="http://www.dentistonline.ro/contact.html" rel="nofollow">
				<img src="{SITE_BASE}/images/no_recomandat.png" alt='imagine dentist recomandat' title='imagine dentist recomandat' class='img-responsive'>
			</a>
		</div>
		<!-- END display_image -->
	</div>
	<!-- END Recomandam -->
	
	<h2>{CATEGORY_NAME}</h2>

	<div class="row">
		<!-- BEGIN rowdoicabs -->
		<div class="{RECOMANDAT_CLASS} col-xs-12 col-sm-6 col-md-4 col-lg-4">
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
							<img src="{IMAGE}" title="{NUME_FIRMA},{JUDET_NAME}" alt="{NUME_FIRMA}" class='pull-left img-thumbnail img-responsive'>
						</a>
						{DESCRIERE} ...
					</p>
					<div class='small'>{CAT_DETAILS_HERE}</div>
				</div>
			</div>
		</div>
		<!-- END rowdoicabs -->
	</div>
	
	<!-- BEGIN pagination_table -->
	<ul class="pagination pagination-md">
		<li>{PAGINATION}</li>
		<li class='active'>&nbsp;&nbsp;&nbsp;<a href='#'>{COUNT_CABINETE} Cabinete</a></li>
	</ul>
	<!-- END pagination_table -->
</div>

</div>