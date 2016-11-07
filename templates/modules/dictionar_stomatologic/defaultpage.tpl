<div class='row'>
	<h2>Termeni medicali, definitii</h2>
	<p>
		<a href="{ADD_TERM}" class='btn btn-info'>Adauga termen medical</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="{SEARCH_TERM}" class='btn btn-info'>Cauta termen medical</a>
	</p>
	
	<p>Satisfactia dumneavoastra este implinirea noastra, de accea tuturor utilizatorilor acestui website dorim sa le punem la dipozitie un dictionar stomatologic de termeni medicali. 
	Aici veti gasi definitii, explicatii din diferite ramuri ale medicinei dentare si nu numai.</p>
	
	<p>Dorim sa fie un lucru interactiv de accea va oferim si dvs. posibilitatea de a adauga termeni medicali. Adaugarea este gratuita. Mult succes!</p>
	
	<ul class='pagination'>
		<!-- BEGIN list_categories -->  
		<li class='{LETER_STYLE}'><a href="{URL_LETTER}" title="{URL_TITLE}">{CAT_NAME}</a></li>
		<!-- END list_categories -->
	</ul>
	
	<div class='row related'>
		<div class='col-sm-12 text-left'>
			<h3 class='orange_title'>Cei mai uzuali termeni medicali</h3>
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
