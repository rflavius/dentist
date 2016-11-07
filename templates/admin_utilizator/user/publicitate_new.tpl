<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="{SITE_BASE}/resources/bootstrap-3.3.5/css/bootstrap.min.css">

<!-- Latest compiled JavaScript -->
<script src="{SITE_BASE}/resources/bootstrap-3.3.5/js/bootstrap.min.js"></script>


<div class='oferta'>
	<h2>De ce sa aleg promovarea prin serviciul DentistOnline.ro ?</h2>
	<h4>Pentru ca vreau sa fiu reprezentat de cel mai bun portal stomatologic din Romania.</h4>
	<p>DentistOnline.ro este site-ul ce ocupa prima pozitie in domeniul stomatologic, conform Trafic.ro , fiind cel mai important portal stomatologic din tara.</p>
	<p><img src='http://www.dentistonline.ro/images/trafic_stats.jpg' title='statistica trafic.ro'></p>

	<h2>Nu stii care din pachetele de promovare este cel mai potrivit pentru nevoile tale ?</h2>
	<p>Pentru a raspunde cat mai multor cerinte va punem la dispozitie 3 planuri de promovare: GRATUIT, BUSINESS, RECOMANDAT ; beneficiile promovarii fiind in functie de nivelul pachetului ales.</p>
	<p>Mai multe informatii referitor la beneficiile fiecarui pachet de promovare sunt prezentate mai jos.</p>

	<h2>Ce inseamna afisarea preferentiala ?</h2>
	<p>Afisarea pe pagina a cabinetelor/clinicilor se va face in functie de planul de promovare ales astfel: RECOMANDAT, BUSINESS, GRATUIT.</p>
	<p>Cabinetele/Clinicile ce folosesc planul de promovare BASIC sunt afisate in partea de subsol a paginii, in fata lor fiind afisate pachetele RECOMANDAT respectiv BUSINESS.</p>

	<ul class='list-group list-inline'>
		<!-- BEGIN list_pachete -->
		<li class='col-xs-12 col-sm-4 col-md-4'>
			<div class='pachet rounded-corners '>
				<div class='head icon-{PACHET_STYLE}'><strong>{PACHET}</strong></div>
				<div class="panel-group" id="accordion_{PACHET_STYLE}">
					<!-- BEGIN list_servicii -->
					<div class="panel panel-default ">
						<div class="panel-heading">
							<h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion_{PACHET_STYLE}" href="#collapse_{PACHET_STYLE}_{NR}">{SERVICE}</a></h4>
						</div>
						<div id="collapse_{PACHET_STYLE}_{NR}" class="panel-collapse collapse">
							<div class="panel-body small">{DESCRIPTION}</div>
						</div>
					</div>
					<!-- END list_servicii -->
				</div>
				<div class='head text-center' style='line-height:22px;'>
					<b>{PACHET_PRICE}</b><br>RON/luna
					<p><u>{PACHET_OFERTA}</u></p>
				</div>
			</div>
		</li>
		<!-- END list_pachete -->
	</ul>
	
	<div class='clearfix'>&nbsp;</div>
	<br>
	<div class='row text-center'>
		<ul class='list-group list-inline'>
			<li class='col-xs-12 col-sm-4 col-md-4'><button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">exemplu pachet GRATUIT</button></li>
			<li class='col-xs-12 col-sm-4 col-md-4'><button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">exemplu pachet BUSINESS</button></li>
			<li class='col-xs-12 col-sm-4 col-md-4'><button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">exemplu pachet RECOMANDAT</button></li>
		</ul>
		
		<!-- Modal -->
		<div id="myModal" class="modal fade" role="dialog">
			<div class="modal-dialog">
				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">exemplu pachet BUSINESS</h4>
					</div>
					<div class="modal-body">
						<p><img src='{SITE_BASE}/images/printscreendentist_final.jpg' class='img-responsive' alt='' title=''></p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class='clearfix'>&nbsp;</div>
	<h2>Pentru cei interesati de serviciile noastre de promovare puteti sa ne contactati prin e-mail: admin@dentistonline.ro sau telefonic la numarul: 0727-380-368.</h2>
</div>