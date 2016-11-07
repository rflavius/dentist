<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>

<script>

/*  here we have the code that makes collapse for blocks  */
$(function()
{
	var noOfDisplayedBlock = 5;
	
	$('div#anunturi_produse').each(function()
	{
		var LiN = $(this).find('a').length;
	
		if( LiN > noOfDisplayedBlock)
		{
			$('a', this).eq(noOfDisplayedBlock-1).nextAll().hide().addClass('toggleable');
			$(this).append('<button class="btn btn-info btn-sm more">vezi toate anunturile</button>');
		}
	});
	$('div#anunturi_produse').on('click','.more', function()
	{
		if($(this).hasClass('less'))
		{
			$(this).text('vezi toate anunturile').removeClass('less');
		}
		else
		{
			$(this).text('ascunde anunturi').addClass('less'); 
		}
		$(this).siblings('a.toggleable').slideToggle('fast');
	});
	
	$('div#articole_create').each(function()
	{
		var LiN = $(this).find('a').length;
	
		if( LiN > noOfDisplayedBlock)
		{
			$('a', this).eq(noOfDisplayedBlock-1).nextAll().hide().addClass('toggleable');
			$(this).append('<button class="btn btn-info btn-sm more">vezi toate articolele</button>');
		}
	});
	$('div#articole_create').on('click','.more', function()
	{
		if($(this).hasClass('less'))
		{
			$(this).text('vezi toate articolele').removeClass('less');
		}
		else
		{
			$(this).text('ascunde articole').addClass('less'); 
		}
		$(this).siblings('a.toggleable').slideToggle('fast');
	});
});

$(document).ready(function()
{
	$("#programareForm").validate({
		messages:
			{
				field_1: "Va rugam sa introduceti numele dvs.",
				field_2: "Nu ati complectat adresa de email.",
				field_3: "Mesajul dvs nu are nici un subiect.",
				field_4: "Ati uitat sa scrieti un mesaj.",
				security_code2: "Va rugam introduceti codul de siguranta."
			}
		});
});
</script>

<!-- this is the briefing info -->
<div class='row'>
	<!-- this is the left side from the briefing info -->
	<div class='col-sm-12 col-md-6 text-left'>
		<h2 class='cabinet_descriere_title'>{NUME_FIRMA}</h2>
		<div class='article_details_contact small'>
			<p><b>Persoana de contact:</b>  {PERS_CONTACT}</p>
			<p><b>Adresa:</b>  {ADRESA_FIRMA}</p>
			<p><b>Judet/Localitate:</b>  {JUDET}/ {NUME_LOC_SECTOR}</p>
			<p>
				<b>Telefon/fax:</b>
				<button class="btn btn-info btn-sm" type="button" data-html="true" onClick='countPhoneNumberViews("{CAB_ID}","cabinet");'  title="" data-original-title='Informatii telefon, fax<button type="button" data-dismiss="popover" id="closePopup" class="close">&times;</button>' data-placement="bottom" data-toggle="popover" data-trigger="click focus" data-content="{TELEFON}{FAX}">
					<span class='glyphicon glyphicon-earphone'></span>&nbsp;Vezi telefon
				</button>
			</p>
			<p><b>Website:</b> {ADRESA_WEB}</p>
			<p class='orange_title'><b>{NR_VISITS} persoane au fost interesate de acest anunt.</b></p>
			<!-- BEGIN recomandat_badge -->
			<br>
			<div class='recomandat_badge'><img src='{SITE_BASE}/images/recomandat_badge.png' class='img-responsive' title='DentistOnline RECOMANDA: {NUME_FIRMA}' alt='DentistOnline RECOMANDA: {NUME_FIRMA}'></div>
			<!-- END recomandat_badge -->
		</div>
		<div class='cabinet_orar'>
			<p class='lead'>Program de lucru</p>
			<p>{ORAR}</p>
			
			<!-- BEGIN programare_online -->
			<button type="button" class="btn btn-success btn-md" data-toggle="modal" data-target="#emailModal"><span class='glyphicon glyphicon-envelope'></span>&nbsp;Trimite email/ Programare online</button>
			<!-- Modal -->
			<div id="emailModal" class="modal fade small" role="dialog">
				<div class="modal-dialog">
					<!-- Modal content-->
					<div class="modal-content text-center">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">Trimite email / Programare online</h4>
						</div>
						<div class="modal-body text-left">
							<form role="form" action="{CABINETETRIMITEEMAIL}" method='post' id='programareForm' novalidate="novalidate" role="form">
								<input type="hidden" name="id_cabinet" value="{ID_CABINET}" />
								<div class="help-block text-left">Completand formularul de mai jos  veti trimite un email catre: <b>{PERSOANA_CONTACT}</b>.<br> Pentru programari va rugam contactati medicul dentist si telefonic. Multumim pentru intelegere!</div>
								<div class="form-group">
									<div class="input-group col-sm-7">
										<div class="input-group-addon" id='username'><span class='glyphicon glyphicon-user'></span></div>
										<input type="text" name='field_1' id='field_1' class="form-control" placeholder="Numele dvs ..." value="{FIELD_1}" required>
									</div>
								</div>
								<div class="form-group">
									<div class="input-group col-sm-7">
										<div class="input-group-addon" id='email'><span class='glyphicon glyphicon-envelope'></span></div>
										<input type="text" name='field_2' id='field_2' class="form-control" placeholder="Adresa dvs de email ..." value="{FIELD_2}" required>
									</div>
								</div>
								<div class="form-group">
									<div class="input-group col-sm-7">
										<div class="input-group-addon" id='email'><span class='glyphicon glyphicon-phone-alt'></span></div>
										<input type="text" name='field_5' class="form-control" placeholder="Numar telefon ..." value="{FIELD_5}">
									</div>
								</div>
								<div class="form-group">
									<div class="input-group col-sm-7">
										<div class="input-group-addon" id='email'><span class='glyphicon glyphicon-pencil'></span></div>
										<input type="text" name='field_3' id='field_3' class="form-control" placeholder="Subiectul mesajului ..." value="{FIELD_3}" required>
									</div>
								</div>
								<div class="form-group">
									<div class="input-group col-sm-7">
										<textarea name="field_4" id='field_4' rows="6" placeHolder='Scrieti mesajul dvs ...' class="form-control" required>{FIELD_4}</textarea>
									</div>
								</div>
								<div class="form-group form-group-lg">
									<div class="input-group col-sm-7">
										<div class="input-group-addon" id='security'><img src="{SITE_BASE}/security_image.php?code={SECURITYID}" alt="Security Image"></div>
										<input type="text" name="security_code2" id='security_code2' class="form-control" placeholder="Cod securitate ..." value="" required>
									</div>
								</div>
								<div class="form-group">
									<div class="input-group col-sm-7">
										<button type='submit' class='btn btn-info'>Trimite</button>
									</div>
								</div>
							</form>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Inchide</button>
						</div>
					</div>
				</div>
			</div>
			
			
			
			<!-- END programare_online -->
		</div>
	</div>
	<!-- this is the right side from the briefing info with media-->
	<div class='col-sm-12 col-md-6 cabinet_media'>
		<ul class="nav nav-tabs">
			<li class="active"><a data-toggle="tab" href="#galerie">Galerie foto</a></li>
			<li class="{HARTA_OFF}"><a data-toggle="tab" href="#harta">Pozitie harta</a></li>
			<li class="{VIDEO_OFF}"><a data-toggle="tab" href="#video">Video</a></li>
		</ul>
		
		<div class="tab-content">
			<div id="galerie" class="tab-pane fade in active">
				
				<div id="myCarousel" class="carousel slide" data-ride="carousel">
					<!-- Wrapper for slides -->
					<div class="carousel-inner" role="listbox">
						<!-- BEGIN carousel_big -->
						<div class="item {CAROUSELL_BIG_ACTIVE}"><img src="{CAROUSEL_BIG_IMG}" alt="" title="" class='img-responsive'></div>
						<!-- END carousel_big -->
					</div>

					<!-- BEGIN foto_gallery -->
					<!-- Left and right controls -->
					<a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
						<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
						<span class="sr-only">Anterior</span>
					</a>
					<a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
						<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
						<span class="sr-only">Urmator</span>
					</a>
					<!-- Indicators -->
					
					<div class="carousel-indicators">
						<!-- BEGIN imgessmall -->
						<a  href="#" data-target="#myCarousel" data-slide-to="{CAROUSEL_NR}" class="{CAROUSEL_SMALL_ACTIVE}"><img src='{SMALL_IMGES}'></a>
						<!-- END imgessmall -->
					</div>
					<!-- END foto_gallery -->
				</div>
			</div>
			<!-- BEGIN localizare_harta -->
			<div id="harta" class="tab-pane fade">
				<div class="embed-responsive embed-responsive-4by3">
					<iframe width="100%" height="360" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/place?q={MAP_QUERY}&key=AIzaSyAIDzm8u_2tDqVML6fpkCmi20ZvkuLi-Rk" allowfullscreen></iframe> 
				 </div>
			</div>
			<!-- END localizare_harta -->
			<!-- BEGIN prezentare_video -->
			<div id="video" class="tab-pane fade">
				<div class="embed-responsive embed-responsive-16by9">
					<!-- BEGIN list_video -->
					<iframe width="100%" height="100%" frameborder="0" style="border:0" src="{VIDEO_PATH}" allowfullscreen></iframe>
					<!-- END list_video -->
				</div>
			</div>
			<!-- END prezentare_video -->
		</div>
	</div>
</div>
<br>
<!-- this is the description info -->
<div class='row small text-justify'>
	<div class='col-xs-12'>
		<p>{DESCRIERE}</p>
		<!-- this is the share buttons block -->
		<!-- Facebook -->
		<a href="https://www.facebook.com/sharer/sharer.php?u={SHARE_URL}" title="Share on Facebook" target="_blank" class="btn btn-facebook btn-sm"><span class="facebook"></i> Facebook</a>
		<!-- Twitter -->
		<a href="https://twitter.com/share?url={SHARE_URL}&text={NUME_FIRMA}&via=&hashtags={NUME_FIRMA}" title="Share on Twitter" target="_blank" class="btn btn-twitter btn-sm"><span class="twitter"></span> Twitter</a>
		<!-- Google+ -->
		<a href="https://plus.google.com/share?url={SHARE_URL}" title="Share on Google+" target="_blank" class="btn btn-googleplus btn-sm"><span class="googleplus"></span> Google+</a>
		<!-- LinkedIn --> 
		<a href="http://www.linkedin.com/shareArticle?url={SHARE_URL}&title={NUME_FIRMA}" title="Share on LinkedIn" target="_blank" class="btn btn-linkedin btn-sm"><span class="linkedin"></span> LinkedIn</a>
		<!-- BEGIN if_recomandari -->
		<div class='hidden-xs visible-sm-block visible-md-block visible-lg-block details_banners'>
			<br>
			<p class='lead orange_title'>Recomandari DentistOnline.ro</p>
			<a href='http://www.qdental.ro' target='_blank' rel='nofollow'><img src="http://www.dentistonline.ro/images/banner/qdental.jpg" onclick="countBannerClicks('163');" class='img-responsive'></a>
			<!-- <a href='http://www.dentistonline.ro/Distribuitori-Materiale/Bihor/Andredent-Srl.html' ><img src="http://www.dentistonline.ro/images/banner/produse-stomatologice-Dentka.jpg" onclick="countBannerClicks('538');" onclick="countBannerClicks('538');" class='img-responsive'></a> -->
			

			<!-- <a href='http://www.gepi-mattout.com/inscription-formation-targu-mures/3' target='_blank' rel='nofollow'>
			<img src="http://www.dentistonline.ro/images/banner/curs-paradontologie2.jpg" onclick="countBannerClicks('528');" class='img-responsive'>	</a> -->
			<!-- <a href='http://www.dentaldigitalsolutions.ro' target='_blank' rel='nofollow'><img src="http://www.dentistonline.ro/images/banner/zirkon-dental.jpg" onclick="countBannerClicks('471');" class='img-responsive'></a>
			<a href="http://dentalmobility.com/parodontoza.html" target="_blank" rel="nofollow"><img src="{SITE_BASEE}/images/banner/electronic-doctor-paradontoza.gif" alt="Tratament sigur si eficient pentru paradontoza,electronic doctor" title="Electronic doctor, tratament pentru paradontoza."  onclick="countBannerClicks('428');" class='img-responsive'></a> -->
		</div>
		<!-- END if_recomandari -->
	</div>
</div>

<!-- this is the servicii&persoanal blocks -->
<br>
<div class='row'>
	<div class='col-sm-12 col-md-6 text-left'>
		<div class='light_green_tab well well-lg lead'>Servicii si tarife</div>
		<div>
			<p class='text-justify small'>{TARIFE}</p>
			<p>{TEXT_DOWNLOAD}<a href="{URL_SERVICII_FILE}" rel="nofollow" class="{CLASS_TYPE}" title="Lista completa a serviciilor stomatologice oferite de catre {NUME_FIRMA}" alt="Servicii stomatologie pentru {NUME_FIRMA}"></a></p>
		</div>
	</div>
	<div class='col-sm-12 col-md-6 text-left'>
		<div class='light_green_tab well well-lg lead'>Personal medical</div>
		<div>
			<p class='text-justify small'>{ECHIPA_MEDICALA}</p>
		</div>
	</div>
</div>

<!-- this is the articole&anunturi blocks -->
<br>
<div class='row'>
	<div class='col-sm-12 col-md-6 text-left'>
		<div class='light_orange_tab well well-lg lead'>Articole publicate</div>
		<div class='list-group'  id='articole_create'>
			<!-- BEGIN articole_create -->
			<a href="{ARTICOL_LINK}" class="list-group-item">
				<p class="list-group-item-heading orange_title"><strong>{ARTICOL_TITLE}</strong></p>
				<p class="list-group-item-text small">{ARTICOL_DESCRIPTION}...</p>
			</a>
			<!-- END articole_create -->
		</div>
	</div>
	<div class='col-sm-12 col-md-6 text-left'>
		<div class='light_orange_tab well well-lg lead'>Anunturi, produse adaugate</div>
		<div class='list-group' id='anunturi_produse'>
			<!-- BEGIN anunturi_create -->
			<a href="{ANUNT_LINK}" class="list-group-item">
				<p class="list-group-item-heading orange_title"><strong>{ANUNT_TITLE}</strong></p>
				<p class="list-group-item-text small">{ANUNT_DESCRIPTION}...</p>
			</a>
			<!-- END anunturi_create -->
		</div>
	</div>
</div>

<!-- this is the featured cabinete blocks -->
<br>
<div class='row related'>
	<div class='col-sm-12 text-left'>
		<h4 class='orange_title'>{TYPE_RELATED} din {JUDET} / {NUME_LOC_SECTOR}</h4>
		<ul class='list-group list-inline small'>
			<!-- BEGIN related_cabinete --> 
			<li class='col-xs-12 col-sm-4 col-md-4'>
				<a href="{CABINET_RELATED_LINK}" class="list-group-item text-center">
					<p class="list-group-item-heading orange_title">{CABINET_RELATED_TITLE}</p>
					<p class="list-group-item-text center-block">
						<img src='{CABINET_RELATED_IMG}' alt='imagine {CABINET_RELATED_TITLE}' title='imagine {CABINET_RELATED_TITLE}' class='img-responsive center-block'>
					</p>
				</a>
			</li>
			<!-- END related_cabinete -->
		</ul>
	</div>
</div>