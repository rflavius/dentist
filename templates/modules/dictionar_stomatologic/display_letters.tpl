<div class='row'>
	<h2>Termeni medicali, definitii pentru termeni ce incep cu litera: {LETTER}</h2>
	<p>
		<a href="{ADD_TERM}" class='btn btn-info'>Adauga termen medical</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="{SEARCH_TERM}" class='btn btn-info'>Cauta termen medical</a>
	</p>
	
	<p> Acum sunt listati toti termeni medicali ce incep cu litera <b>{LETTER}</b>. Acestia sunt in numar de <b>{NR_TEREMENI}</b>  termeni. Pentru a vedea definitia,explicatiile 
	corespunzatoare fiecarui termen dati un click pe cuvantul dorit,cautat.</p>
	
	<ul class='pagination'>
		<!-- BEGIN list_categories -->  
		<li class='{LETER_STYLE}'><a href="{URL_LETTER}" title="{URL_TITLE}">{CAT_NAME}</a></li>
		<!-- END list_categories -->
	</ul>
	
	<div class='row related'>
		<div class='col-sm-12 text-left'>
			<ul class='list-group list-inline small'>
				<!-- BEGIN list_terms --> 
				<li class='col-xs-12 col-sm-4 col-md-4' style='min-height:130px;'>
					<a href="{URL_LETTER}" title="{URL_TITLE_TERM}" class="list-group-item text-center">
						<p class="list-group-item-heading orange_title">{TITLU}</p>
						<p class="list-group-item-text center-block">
							{DESCR} ...
						</p>
					</a>
				</li>
				<!-- END list_terms -->
			</ul>
		</div>
	</div>
	
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