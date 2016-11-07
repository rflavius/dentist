<div>
	<h2>{TITLU}</h2>
	<!-- BEGIN if_email -->
	<p><a href="{ANUNTURITRIMEMAIL}" class="article_send_email"></a></p>
	<!-- END if_email -->
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
	
	<div class='article_details_contact small col-xs-12'>

		<!-- BEGIN NOT_AUTOR -->
		<p><span><b>Pers. contact:</b></span>&nbsp;&nbsp;<a href="{AUTOR_LINK}">{CONTACT_PERS}</a></p>
		<p><span><b>Localitate:</b></span>&nbsp;&nbsp;{JUDET}/ {LOCALITATE}</p>
		<!-- END NOT_AUTOR -->

		<!-- BEGIN AUTOR_DET -->
		<p><span><b>Autor:</b></span>&nbsp;&nbsp;<a href="{AUTOR_LINK}">{AUTOR_NAME}</a></p>
		<p><span><b>Adresa:</b></span>&nbsp;&nbsp;{ADRESA}</p>
		<p><span><b>Judet/Localitate:</b></span>&nbsp;&nbsp;{JUDET}/ {LOCALITATE}</p>
		<P>
			<span><b>Telefon/fax:</b></span>
			<button class="btn btn-info btn-sm" type="button" data-html="true" onClick='countPhoneNumberViews("{CAB_ID}","anunt");'  title="" data-original-title='Informatii telefon, fax<button type="button" data-dismiss="popover" id="closePopup" class="close">&times;</button>' data-placement="bottom" data-toggle="popover" data-trigger="click focus" data-content="{TELEFON}{FAX}">
				<span class='glyphicon glyphicon-earphone'></span>&nbsp;Vezi telefon
			</button>
		</P>
		<p><span><b>Website:</b></span>&nbsp;&nbsp;{WEBSITE}</p>
		<!-- END AUTOR_DET -->
		<p><span><b>Categoria:</b></span>&nbsp;&nbsp;<a href="{ANUNTURIBYCAT}">{BIGCAT}</a></p>
		<p class="articole_box_date"> {NR_VIZUALIZARI} vizualizari, adaugat la {DATA_ADAUGARII}, expira in {DATA_EXPIRARII}</p>
	</div>
	
	<ul class="pager">
		<!-- BEGIN previous -->
		<li class="previous"><a href="{PREVIOUS_LINK}">Vezi anuntul anterior</a></li>
		<!-- END previous -->
		<!-- BEGIN next -->
		<li class="next"><a href="{NEXT_LINK}">Vezi anuntul urmator</a></li>
		<!-- END next -->
	</ul>

</div>