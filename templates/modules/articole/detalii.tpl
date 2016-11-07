<div>
	<h2>{TITLU}</h2>
	<p>
		<img src="{IMAGINE}" title="{TITLU}" alt="Imagine {TITLU}" class='pull-left img-thumbnail img-responsive' style='margin-right:5px;'>
		<span style="color:#878787;">{ART_DATE}, <b>Vizualizari:</b>&nbsp;&nbsp;{NR_VIZUALIZARI}</span><br>
		{CONTINUT}
	</p>
	<div>
		<!-- this is the share buttons block -->
		<!-- Facebook -->
		<a href="https://www.facebook.com/sharer/sharer.php?u={SHARE_URL}" title="Share on Facebook" target="_blank" class="btn btn-facebook btn-sm"><span class="facebook"></i> Facebook</a>
		<!-- Twitter -->
		<a href="https://twitter.com/share?url={SHARE_URL}&text={TITLU}&via=&hashtags={TITLU}" title="Share on Twitter" target="_blank" class="btn btn-twitter btn-sm"><span class="twitter"></span> Twitter</a>
		<!-- Google+ -->
		<a href="https://plus.google.com/share?url={SHARE_URL}" title="Share on Google+" target="_blank" class="btn btn-googleplus btn-sm"><span class="googleplus"></span> Google+</a>
		<!-- LinkedIn --> 
		<a href="http://www.linkedin.com/shareArticle?url={SHARE_URL}&title={TITLU}" title="Share on LinkedIn" target="_blank" class="btn btn-linkedin btn-sm"><span class="linkedin"></span> LinkedIn</a>
	</div>
	<br>
	
	<!-- BEGIN if_pdf_file -->
	<div>
		<b>DOWNLOAD acum si citeste fisierul complet!!</b>
		<br>
		<a href="{URL_SERVICII_FILE}" class="{CLASS_TYPE}" title="Citeste tot articolul {TITLU}" alt="Informeaza-te despre {TITLU}"></a>
	</div>
	<!-- END if_pdf_file -->
	
	<!-- BEGIN AUTOR_DET -->
	<div class='article_details_contact small col-xs-12'>
		<p><span><b>Autor:</b></span>&nbsp;&nbsp;<a href="{AUTOR_LINK}">{AUTOR_NAME}</a></p>
		<p><span><b>Adresa:</b></span>&nbsp;&nbsp;{ADRESA}</p>
		<p><span><b>Localitate:</b></span>&nbsp;&nbsp;{LOCALITATE}</p>
		
		<p>
			<span><b>Telefon/fax:</b></span>
			<button class="btn btn-info btn-sm" type="button" data-html="true" onClick='countPhoneNumberViews("{CAB_ID}","articol");'  title="" data-original-title='Informatii telefon, fax<button type="button" data-dismiss="popover" id="closePopup" class="close">&times;</button>' data-placement="bottom" data-toggle="popover" data-trigger="click focus" data-content="{TELEFON}{FAX}">
				<span class='glyphicon glyphicon-earphone'></span>&nbsp;Vezi telefon
			</button>
		</p>
		<p><span><b>Website:</b></span>&nbsp;&nbsp;{WEBSITE}</p>
	</div>
	<!-- END AUTOR_DET -->
	<div class='clearfix'></div>
	<br>
	<div class='light_orange_tab well well-lg lead'>Articole similare</div>
	<div class='related'>
		<ul class='list-group list-inline'>
			<!-- BEGIN articole_related -->
			<li class='col-xs-12 col-sm-3 col-md-2'>
				<a href="{ARTICLE_RELATED_LINK}" class="list-group-item text-center small orange_title">{ARTICLE_REALATED_TITLE}</a>
			</li>
			<!-- END articole_related -->
		</ul>
	</div>
</div>