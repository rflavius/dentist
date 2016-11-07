<!-- here is the newsletter -->
<!-- <a href='http://www.gepi-mattout.com/inscription-formation-targu-mures/3' target='_blank' rel='nofollow'>
			<img src="http://www.dentistonline.ro/images/banner/curs-paradontologie2.jpg" onclick="countBannerClicks('528');" class='img-responsive'>
		</a>
<div class='clearfix'></div><br> -->

<!-- <a href='http://www.gepi-mattout.com/inscription-formation-targu-mures/3' target='_blank' rel='nofollow'>
			<img src="http://www.dentistonline.ro/images/banner/produse-stomatologice-Dentka.jpg" onclick="countBannerClicks('528');" class='img-responsive'>
		</a>
<div class='clearfix'></div><br> -->

<div class="dropdown">
	<button class="btn btn-success btn-lg dropdown-toggle col-md-12 col-xs-12" type="button" data-toggle="dropdown">
		<span class="glyphicon glyphicon-envelope"></span> Abonare Newsletter
	</button>
	<ul class="dropdown-menu" role="menu" style='padding:15px;'>
		<li class="dropdown-header"><h4>Abonare la newsletter <span class='glyphicon glyphicon-thumbs-up'></span></h4></li>
		<li>
			<form method="post" action="{NEWSLETTER_ACTION}" role="form">
				<div class="form-group">
					<input type="text" class="form-control" name="name" placeHolder='Numele / Prenumele dvs ...'>
				</div>
				<div class="form-group">
					<input type="text" class="form-control" name="email" placeHolder='Adresa email ...'>
				</div>
				<div class="form-group text-center">
					<button type="submit" class="btn btn-primary">Trimite</button>
				</div>
			</form>
		</li>
	</ul>
</div>
<div class='clearfix'></div>

<br>
<a class="btn btn-info btn-lg col-md-12 col-xs-12" href='{FEEDBACK_LINK}'><span class='glyphicon glyphicon-pencil'></span>&nbsp;&nbsp;Sugestii, propuneri</a>
<div class='clearfix'></div>
<br>
<div class='light_orange_tab well well-lg'><strong>Va recomandam</strong></div>
<ul class="list-group">
	<li class="list-group-item">
		<a href='http://www.qdental.ro' target='_blank' rel='nofollow'>
			<img src="http://www.dentistonline.ro/images/banner/qdental.jpg" onclick="countBannerClicks('163');" class='img-responsive'>
		</a>
	</li>
	 <!-- <li class="list-group-item">
		<a href='http://www.dentistonline.ro/Distribuitori-Materiale/Bihor/Andredent-Srl.html'>
			<img src="http://www.dentistonline.ro/images/banner/produse-stomatologice-Dentka.jpg" onclick="countBannerClicks('538');" class='img-responsive'>
		</a>
	</li>  -->
		
	<!-- <li class="list-group-item">
		<a href="http://dentalmobility.com/parodontoza.html" target="_blank" rel="nofollow">
			<img src="{SITE_BASEE}/images/banner/electronic-doctor-paradontoza.gif" alt="Tratament sigur si eficient pentru paradontoza,electronic doctor" title="Electronic doctor, tratament pentru paradontoza."  onclick="countBannerClicks('428');" class='img-responsive'>
		</a>
	</li> -->
		<!-- <li class="list-group-item">
		<a href="http://www.socialdental.ro/" target="_blank" rel="nofollow">
			<img src="{SITE_BASEE}/images/banner/social-dental2.jpg" alt="Social Dental laborator tehnica dentara" title="Tehnica dentara un zambet mai frumos!"  onclick="countBannerClicks('504');" class='img-responsive'>
		</a>
	</li> -->
	{RECOMANDAM_BANNER}
</ul>

<div class='hidden-sm hidden-xs visible-md-block visible-lg-block'>
	<div class='light_orange_tab well well-lg'><strong>Anunturi recomandate</strong></div>
	<ul class="list-group">
		<!-- BEGIN list_anunturi_homepg -->
		<li class="list-group-item small">
			<div class='list-group-item-heading '><a href="{CITESTEANUNT}" title="{AHREF_ANUNTURI}" class='orange_title'><strong>{TITLUANUNT}</strong></a></div>
			<div class='list-group-item-text '>
				<img src="{IMAGINEANUNT}" title="{TITLUANUNT}" alt="{TITLUANUNT}" class='pull-left img-thumbnail img-responsive' width="80" height="80">
				<p>{CONTINUT} ...</p>
			</div>
		</li>
		<!-- END list_anunturi_homepg -->
	</ul>
	
	<div class='light_green_tab well well-lg'><strong>Evenimente importante</strong></div>
	<ul class="list-group">
		<!-- BEGIN list_last_eveniment -->
		<li class="list-group-item small">
			<a href="{EVENIMET_URL}" title="{AHREF_EVENIMET}" class='orange_title'><strong>{TITLU_EVENIMENT}</strong></a>
		</li>
		<!-- END list_last_eveniment -->
	</ul>
	
	<div class='dark_green_tab well well-lg'><strong>Anunturi recente</strong></div>
	<ul class="list-group">
		<!-- BEGIN list_anunturi_homepg2 -->
		<li class="list-group-item small">
			<div class='list-group-item-heading'><a href="{CITESTEANUNT}" title="{AHREF_ANUNTURI}" class='orange_title'><strong>{TITLUANUNT}</strong></a></div>
			<div class='list-group-item-text'>
				<img src="{IMAGINEANUNTLEFT}" title="{TITLUANUNT}" alt="{TITLUANUNT}" class='pull-left img-thumbnail img-responsive' width="80" height="80">
				<p>{CONTINUT} ...</p>
			</div>
		</li>
		<!-- END list_anunturi_homepg2 -->
	</ul>

	<div class='light_green_tab well well-lg'><strong>Cabinete, clinici recente</strong></div>
	<ul class="list-group">
		<li class="list-group-item small">
			<!-- BEGIN list_last_oferte -->
			<a href="{OFERTA_URL}" title="{AHREF_OFERTA}" class='orange_title'>{TITLU_OFERTA}</a> ,
			<!-- END list_last_oferte -->
		</li>
	</ul>
	
	<div class='dark_green_tab well well-lg'><strong>Articole medicale</strong></div>
	<ul class="list-group">
		<!-- BEGIN list_recomandam_articole -->
		<li class="list-group-item small">
			<div class='list-group-item-heading'><a href="{RECOMAND_ART_LINK}" title="{RECOMAND_ART}" class='orange_title'><strong>{RECOMAND_ART}</strong></a></div>
			<div class='list-group-item-text'>
				<img src="{SITE_BASE}/sources/thumbnails.php?target={RECOMAND_ART_IMG}&max_size=80&articles=yes" title="{RECOMAND_ART}" alt="{RECOMAND_ART}" class='pull-left img-thumbnail img-responsive' width="80" height="80">
				<p>{RECOMAND_ART_DESCR} ...</p>
			</div>
		</li>
		<!-- END list_recomandam_articole -->
	</ul>
</div>