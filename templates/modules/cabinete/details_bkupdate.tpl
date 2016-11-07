<script type="text/javascript" src="{SITE_BASEE}/templates/js/lightbox/prototype.js"></script>
<script type="text/javascript" src="{SITE_BASEE}/templates/js/lightbox/scriptaculous.js?load=effects"></script>
<script type="text/javascript" src="{SITE_BASEE}/templates/js/lightbox/lightbox.js"></script>
<link rel="stylesheet" href="{SITE_BASEE}/templates/js/lightbox/lightbox.css" type="text/css" media="screen" />




<table border="0" cellspacing="0" cellpadding="0" width="100%" align="center">
<tr>
	<td align="left" width="100%" colspan="2">  
				<table border="0" cellspacing="0" cellpadding="0" width="100%" align="left">
				<tr>
					<td class="details_head" ><p>{NUME_FIRMA}</p>
					
					</td>
					<td align="right" >&nbsp;{PARSE_EMAIL}</a> 
				
						<!-- <script type="text/javascript">
				digg_url = '{WEBSITE_URL}';
				digg_bgcolor = '#759f04';
				digg_window = 'new';
				</script>
			<script src="http://digg.com/tools/diggthis.js" type="text/javascript"></script> -->
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<table border="0" cellspacing="0" cellpadding="0" width="100%">
						<tr>
							<td class="details_line_left"></td>
							<td class="details_line">&nbsp;</td>
							<td class="details_line_right"></td>
						</tr>
						</table>
					</td>
				</tr>
				</table>
	</td>
</tr>
<tr>
	<td width="150" align="center" valign="top" >
				<a href="{IMAGENAME_MAIN}" rel="lightbox[imgset]"><img src="{MAIN_PHOTO}" alt="Imagine {NUME_FIRMA}" border='1' name="boatpicture" id="img_stylee"></a>
				<br>
	</br>
	<b>Imagine Localizare</b> </br>
	Click pentru marire</p> <a href="javascript:deschidefereastra()"><img  src="{THUMBNAIL2}"  style="padding: 5px;border: 1px #B1B1B1 solid;" alt="Imagine harta {NUME_FIRMA}"  title="Harta pentru {NUME_FIRMA}" ></a>
					
	</td>
	<td valign="top">
				<!-- BEGIN imgessmall -->
							<a href="{IMAGENAME}" rel="lightbox[imgset]"><img src="{SMALL_IMGES}"></a>
				<!-- END imgessmall -->
				<table border="0" cellspacing="0" cellpadding="0" align="center" class="details_box_border" width="100%">
					<tr>
						<td>&nbsp;</td>
						<td  class="details_dotted_line"><strong>Persoana Contact:</strong></td>
						<td  class="details_dotted_line">{PERS_CONTACT}</td>
						<td>&nbsp;</td>
					</tr>
					<tr >
						<td>&nbsp;</td>
						<td  class="details_dotted_line"><strong>Adresa:</strong></td>
						<td  class="details_dotted_line">{ADRESA_FIRMA}</td>
						<td>&nbsp;</td>
					</tr>
					<tr >
						<td>&nbsp;</td>
						<td class="details_dotted_line"><strong>Judet/Localitate:</strong></td>
						<td class="details_dotted_line">{JUDET}/ {NUME_LOC_SECTOR}</td>
						<td>&nbsp;</td>
					</tr>
					<tr >
						<td>&nbsp;</td>
						<td class="details_dotted_line"><strong>Telefon /Fax:</strong></td>
						<td class="details_dotted_line">{TELEFON}{FAX}</td>
						<td>&nbsp;</td>
					</tr>
					
					<tr >
						<td>&nbsp;</td>
						<td class="details_dotted_line"><strong>Website:</strong></td>
						<td class="details_dotted_line">{ADRESA_WEB}</td>
						<td>&nbsp;</td>
					</tr>
					<tr >
						<td>&nbsp;</td>
						<td class="details_dotted_line"><strong>Vizualizari:</strong></td>
						<td >{NR_VISITS}</td>
						<td>&nbsp;</td>
					</tr>
				</table>
				<br>
				<table border="0" cellspacing="0" cellpadding="0" align="center" class="details_box_border" width="100%">
				<tr>
						<td class="details_subtitle"><strong>Program de lucru</strong></td>
					</tr>
					<tr>
				<td class="details_text">{ORAR}</td>
				</tr>
			</table>

	</td>
</tr>
</table>

<div style="height: 7px;">&nbsp;</div>
<table border="0" cellspacing="0" cellpadding="0" width="100%" class="details_box_border">
<tr>
	<td class="details_subtitle"><strong>Descriere</strong></td>
</tr>
<tr>
	<td class="details_text">{DESCRIERE}</td>
</tr>
<tr>
	<td class="details_subtitle"><strong>Personal medical</strong></td>
</tr>
<tr>
	<td class="details_text">{ECHIPA_MEDICALA}</td>
</tr>
<tr>
	<td class="details_subtitle"><strong>Servici si Tarife</strong></td>
</tr>
<tr>
	<td class="details_text">{TARIFE}</td>
</tr>
</table>

<br />
<!-- BEGIN if_articles -->
<table border="0" cellspacing="4" cellpadding="1" class="details_box_border" width="100%">
<tr>
	<td class="cat_head left_right_top_border"><b>Articole Create </b> </td>
</tr>
<!-- BEGIN articole_create -->
<tr>
	<td>{ARTICOL_DETAILS}</td>
</tr>
<!-- END articole_create -->
</table>
<br>
<!-- END if_articles -->

<!-- BEGIN if_anunturi -->
<table border="0" cellspacing="4" cellpadding="1" class="details_box_border" width="100%">
<tr>
	<td class="cat_head left_right_top_border"><b>Anunturi/Produse adaugate </b> </td>
</tr>
<!-- BEGIN anunturi_create -->
<tr>
	<td>{ANUNTURI_DET}</td>
</tr>
<!-- END anunturi_create -->
</table>
</br>
<!-- END if_anunturi -->

<table border="0" cellspacing="1" cellpadding="4" width="100%" class="details_box_border">
	<tr>
		<td class="cat_head left_right_top_border">{TYPE_RELATED} din {JUDET} / {NUME_LOC_SECTOR}</td>
	</tr>
	<!-- BEGIN related_cabinete --> 
	<tr>
			<td align="left" width="40%"><a href="{CABINET_RELATED_LINK}">{CABINET_RELATED_TITLE}</a></td>
	</tr>
	<!-- END related_cabinete -->
</table>
<br>





	