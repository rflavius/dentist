<div class="col-xs-8 visible-md-block visible-lg-block hidden-sm hidden-xs" style='margin-top:20px;'>
	<form method="post" action="{ADVSEARCH_WORD}" name='advsearch_form' role="form">
	<div class="form-group form-group-lg col-xs-10 col-xs-offset-2">
		<div class="input-group pull-right">
			<input type="text" name='search_word' class="form-control" value='{SEARCH_STRING}' placeholder="Cauta cabinet/clinica/articol stomatologie ...">
			<span class="input-group-btn">
				<button class="btn btn-info btn-lg" type="submit"><span class='glyphicon glyphicon-search'></span> Cauta</button>
			</span>
		</div>
	</div>
	</form>
</div>


<div class="top_menu col-xs-8 visible-sm-block visible-xs-block hidden-md hidden-lg">
	<!-- Trigger the modal with a button -->
	<button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-search"></span>&nbsp; Cauta ...</button>
	<!-- Modal -->
	<div id="myModal" class="modal fade small" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content text-center">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Cauta cabinet medical</h4>
				</div>
				<div class="modal-body">
					<form method="post" action="{ADVSEARCH_WORD}" name='advsearch_form'>
						<input type="text" name="search_word" value='{SEARCH_STRING}' placeholder='Cauta cabinet, clinica stomatologica' class='well well-sm'>
						<button type='submit' class='btn btn-info btn-sm'><span class="glyphicon glyphicon-search"></span>&nbsp;Cauta</button>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Inchide</button>
				</div>
			</div>
		</div>
	</div>
</div>