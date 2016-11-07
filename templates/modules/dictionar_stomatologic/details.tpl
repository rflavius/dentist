<div class='row'>
	<h2>Definitie termen medical: {TITLE}</h2>
	<p class='lead'>{CONTINUT}</p>
	<br>
	<p>
		<a href="{ADD_TERM}" class='btn btn-info'>Adauga termen medical</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="{SEARCH_TERM}" class='btn btn-info'>Cauta termen medical</a>
	</p>
	
	<p>Doar un click pe o litera pentru a vedea termeni medicali din dictionarul stomatologic. Daca aveti anumite sugestii, sau definitii pentru acest termen nu ezitati sa adaugati 
	si astfel veti contribui si dvs. la dezvoltarea acestui dictionar medical. <br />
	Definitii, explicatii pentru termenul medical:  {TITLE}.</p>
	
	<ul class='pagination'>
		<!-- BEGIN list_categories -->  
		<li class='{LETER_STYLE}'><a href="{URL_LETTER}" title="{URL_TITLE}">{CAT_NAME}</a></li>
		<!-- END list_categories -->
	</ul>
	
	<!-- related terms -->
	<div class='row related'>
		<div class='col-sm-12 text-left'>
			<h3 class='orange_title'>Termeni medicali relevanti</h3>
			<ul class='list-group list-inline small'>
				<!-- BEGIN related_terms --> 
				<li class='col-xs-12 col-sm-4 col-md-4' style='min-height:130px;'>
					<a href="{TERM_LINK}" class="list-group-item text-center">
						<p class="list-group-item-heading orange_title">{TERM_TITLE}</p>
						<p class="list-group-item-text center-block">
							{TERM_DESCR} ...
						</p>
					</a>
				</li>
				<!-- END related_terms -->
			</ul>
		</div>
	</div>
</div>