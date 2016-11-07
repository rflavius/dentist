<div class='the_search'>
	<div class='left_search'>
		<div class='search_tab rounded-corners2' style="color:ff0000;"><strong>Filtreaza rezultate</strong></div>
		<div class='search_filter_content'>
			<ul class='search_filter_categories'>
				<!-- BEGIN list_filter_cats -->
				<li><a href="{FILTER_CAT_LINK}" {FILTER_CAT_ACTIVE}>{FILTER_CAT} ({FILTER_CAT_NR})</a></li>
				<!-- END list_filter_cats -->
			</ul>
			<p><b>Medici dentisti din alte locatii</b></p>
			<ul class='search_filter_locatii'>
				<!-- BEGIN list_filter_loc -->
				<li><a href="{FILTER_LOC_LINK}" {FILTER_LOC_ACTIVE}>{FILTER_LOC} ({FILTER_LOC_NR})</a></li>
				<!-- END list_filter_loc -->
			</ul>
		</div>
	</div>
	<div class='right_search'>
		<div class='search_tab rounded-corners2'>
			<span class='search_first_tab_item'>Lista rezultate</span>
			<!-- <span>Vezi harta</span> -->
		</div>
		<h2>Rezultatele cautarii dupa: {SEARCH_STRING} - {SEARCH_LOC}</h2>
		{NO_FIRM_HERE}
		
		<div class="cabinete_boxes">
			<!-- BEGIN results -->
			<div class="home_cab_box">
				<div class="{BOX_TAB_CLASS} rounded-corners2" style="font-size:14px;font-weight:normal;">{JUDET}</div>
				<img src="{THUMBNAIL}" title="{NUME_FIRMA}" alt="{NUME_FIRMA}"><span class="home_cab_box_text">
				<a href="{URLCITESTE}" title="{URLCITESTE}">{NUME_FIRMA}</a><p style="font-size:12px !important;font-weight:normal;">{DESCRIERE} ...<a href="{URLCITESTE}" >citeste</a></p>
			</div>
			<!-- END results -->
		</div>
		<div class='clearfix'></div>
		<div class="pagination" >
			<span class="pages">{PAGINATION}</span>
			<span class="count_pages"><b>{COUNT_REZ}</b> Rezultate</span>
		</div>
	</div>
</div>
<div class='clearfix'></div>