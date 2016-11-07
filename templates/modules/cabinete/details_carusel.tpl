<script language="JavaScript" type="text/javascript">
<!--
function switchImage(pic,width,height, name) 
	{
	window.document.images.boatpicture.src='{SITE_BASE}/sources/thumbnails.php?target='+pic+'&max_size={MAXTHUMBNAILSIZE}&folder={FOLDER_ID}';

}

function deschidefereastra()
{
	wnd = window.open('','imgLarge','status,resizable,scrollbars,width=600,height=500,left=400,top=100');
	wnd.document.write('<body>');
	wnd.document.write('<center><h2>'+name+'</h2><center>');
	wnd.document.write('<table width="100%" height="100%"><tr><td valign=middle align=center><img src="{SITE_BASE}/images/users_cabinete/{SRC_FINAL}"></td></tr></table></body>');
	wnd.document.close();
}

function enlarge(boatpic) 
{
	
	var pic = "";
	var width = "";
	var height = "";
	var name = "";
	
	
	wnd = window.open('','imgLarge','status,resizable,width=600,height=550,left=400,top=100');
	wnd.document.write('<body>');
	wnd.document.write('<center><h2>'+name+'</h2><center>');
	wnd.document.write('<table width="100%" height="100%"><tr><td valign=middle align=center><img src="http://www.dentistonline.ro/images/users_cabinete/{FOLDER_ID}/'+boatpic+'"></td></tr></table></body>');
	wnd.document.close();
}

//-->
</script>


<style>

		#main {
				width: 210px;
				background-color: #E8F0FF;
				border: 1px solid #808ea8;
		}

		#container {
				border: 1px solid #808ea8;
		}

		.carousel {
				display:hidden;
				width: 210px;
		}

		.carousel .inner {
				overflow: visible;
		}

		.carousel .middle {
				overflow: hidden;
		}

		/* Example 2 ---------------------------------- */

		#example-2 {
				background-color: #E8F0FF;
				border: 1px solid #AAC8FF;
				height: 50px;
		}

		#example-2 .middle {
				float: left;
				width: 190px;
				height: 48px;
		}

		#example-2 .inner img {
				float: left;
				padding:1px;
				margin-right:2px;
				background:white;
		}

		#example-2 a {
				float: left;
				width: 10px;
				height: 50px;
				background-color: #AAC8FF;
				text-align: center;
				text-decoration: none;    
				font-size: 26px;
				line-height: 50px;
		}

		#example-2 a.next {
				float: right;
		}

		#example-2 a:hover {
				color: #000;
		}

		#tab-2 ul li {
				display: block;
				padding-bottom: 5px;
		}


</style>

<script type="text/javascript" src="{SITE_BASE}/templates/js/carousel/prototype.js"></script>
<script type="text/javascript" src="{SITE_BASE}/templates/js/carousel/scriptaculous.js"></script>
<script type="text/javascript" src="{SITE_BASE}/templates/js/lightbox/lightbox.js"></script>
<script type="text/javascript" src="{SITE_BASE}/templates/js/carousel/carousel.js"></script>


<link rel="stylesheet" href="{SITE_BASE}/templates/js/lightbox/lightbox.css" type="text/css" media="screen" />
<div id="overDiv" style="position:absolute; visibility:hidden; z-index:5;"></div>



<div class="article_details">
	<p class="article_details_title">{NUME_FIRMA}&nbsp;&nbsp;{PARSE_EMAIL}</p>
	<div class="clearfix"></div>

	<div>
		<p>
			<a href="{SITE_BASE}/{MAIN_PHOTO_PATH}" rel="lightbox[imgset]"><img src="{MAIN_PHOTO}" alt="Imagine {NUME_FIRMA}" class="article_details_image" id="img"></a>
			<p>
					<!-- BEGIN imgessmall -->
						<a href="{SMALL_IMGES_PATH}" rel="lightbox[imgset]"><img src="{SMALL_IMGES}" class="cabinet_small_img"></a>
					<!-- END imgessmall -->
					<br>{DESCRIERE}
			</p>
		</p>
	</div>

	<div class="clearfix"></div>

	<div class="article_details_contact ">
		<p style="float:right;width:180px;font-size:11px;line-height:14px !important;"><img  src="{THUMBNAIL2}" class="localizare" alt="Imagine harta {NUME_FIRMA}"  title="Harta pentru {NUME_FIRMA}" onclick="javascript:deschidefereastra()" style="cursor:pointer;"><br>&nbsp;&nbsp;<b>Imagine localizare</b><br>&nbsp;&nbsp;<i>Click pe imagine pentru marire</i></p>

		<p><span><b>Pers. contact:</b></span>&nbsp;&nbsp;{PERS_CONTACT}</p>
		<p><span style="vertical-align:top;"><b>Adresa:</b></span>&nbsp;&nbsp;<span style="width: 220px;">{ADRESA_FIRMA}</span></p>
		<p><span><b>Judet/Localitate:</b></span>&nbsp;&nbsp;{JUDET}/ {NUME_LOC_SECTOR}</p>
		<p><span><b>Telefon/fax:</b></span>&nbsp;&nbsp;{TELEFON}{FAX}</p>
		<p><span><b>Website:</b></span>&nbsp;&nbsp;{ADRESA_WEB}</p>
		<p><span><b>Vizualizari:</b></span>&nbsp;&nbsp;{NR_VISITS}</p>
	</div>
	<div class="clearfix"></div>

	<div class="cabinet_details_servicii">
		<div class="cabinete_servicii_tab rounded-corners"><b>Servici si Tarife</b></div>
		<p>{TARIFE}</p>
		<p><a href="" class="download_pdf"></a></p>
		<p><a href="" class="download_doc"></a></p>
	</div>

	<div class="cabinet_details_servicii">
		<div class="cabinete_servicii_tab rounded-corners"><b>Program de lucru</b></div>
		<p>{ORAR}</p>
	</div>


	<div class="cabinet_details_servicii">
		<div class="cabinete_servicii_tab rounded-corners"><b>Personal medical</b></div>
		<p>{ECHIPA_MEDICALA}</p>
	</div>

</div>

<div class="clearfix"></div>

<div class="cabinet_details_video_tab rounded-corners">Video</div>
<p>&nbsp;</p>



<!-- BEGIN if_articles -->
<div class="cabinet_articole_similare_tab rounded-corners">Articole Create</div>
<ul class="articole_cat_list2">
	<!-- BEGIN articole_create -->
	{ARTICOL_DETAILS}
	<!-- END articole_create -->
</ul>
<!-- END if_articles -->

<!-- BEGIN if_anunturi -->
<div class="anunturi_similare_tab rounded-corners">Anunturi/Produse adaugate</div>
<ul class="articole_cat_list2">
	<!-- BEGIN anunturi_create -->
	{ANUNTURI_DET}
	<!-- END anunturi_create -->
</ul>
<!-- END if_anunturi -->

<div class="articole_similare_tab rounded-corners">{TYPE_RELATED} din {JUDET} / {NUME_LOC_SECTOR}</div>
<ul class="articole_cat_list2">
	<!-- BEGIN related_cabinete --> 
	<li><a href="{CABINET_RELATED_LINK}">{CABINET_RELATED_TITLE}</a></li>
	<!-- END related_cabinete -->
</ul>