<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" >
<html>
<head>
	<title>{PAGETITLE}</title>
	<meta http-equiv="Content-Type" content="text/html;charset=iso-8859-1">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="description" content="{GENERAL_META_DESCRIPTION}">
	<meta name="keywords" content="{GENERAL_META_KEYWORDS}">
	<meta name="language" content="Romanian, ro">
	<meta http-equiv="robots" content="index, follow">
	<meta name="cache-control" content="Public">
	<meta name="Distribution" content="Global">
	<meta name="author" content="Rosu Luminita">
	<meta name="ROBOTS" CONTENT="All">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="google-site-verification" content="w58mG8ET81tTPuVhhFmDAooWan8XOFrgOQz59ESmtPE" />
	<meta name="msvalidate.01" content="0A7312E883F0E226280D2AB25D1E3FC0" />
	<meta property="fb:admins" content="185728528279543" />
	
	<link rel="shortcut icon" href="{SITE_BASEE}/favicon.ico" >
	<link rel="stylesheet" href="{SITE_BASEE}/templates/skins/default/style.css" type="text/css" media="screen">
	<link rel="stylesheet" href="{SITE_BASEE}/templates/skins/default/dojo.css" type="text/css" media="screen">
	
	<link rel="alternate" type="application/xml" title="RSS" href="http://www.dentistonline.ro/rss/feed.xml">
	<script type="text/javascript" src="{SITE_BASEE}/templates/js/prototype.js"></script>
	<script type="text/javascript" src="{SITE_BASEE}/templates/js/functions.js"></script>
	<!-- TRACKING CODE FOR GOOGLE WEBMASTERS AND ANALITYCS -->
	<meta name="verify-v1" content="67a29diqzvW8c3k/u5upi/L/u2PBlrCxbwAUxrP1ffk=">
	<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
	</script>

	<script src="{SITE_BASEE}/templates/js/gmap/jquery/lib/jquery-1.5.1.min.js" type="text/javascript">
	<script src="{SITE_BASEE}/templates/js/gmap/jquery/ui/js/jquery-ui-1.8.12.custom.min.js" type="text/javascript">
	<script src="{SITE_BASEE}/templates/js/gmap/jquery/plugins/jquery.cookie.js" type="text/javascript">
	<script src="{SITE_BASEE}/templates/js/gmap/jquery/plugins/jquery.json-2.2.min.js" type="text/javascript">
	<script src="{SITE_BASEE}/templates/js/gmap/init.js" type="text/javascript">

	</script>
		
	<script>dojoConfig = {parseOnLoad: true}</script>
	<script src="//ajax.googleapis.com/ajax/libs/dojo/1.9.2/dojo/dojo.js"></script>
	<script src="{SITE_BASEE}/templates/js/autosuggestions.js" type="text/javascript"></script>

	

	<script language="JavaScript">
	<!--
		function breakFree()
		{
			var l = top.location;
			if(l.match('facebook')!=null)
			{
			}
			else
			{
				if (top.location) top.location.replace(self.location.href)
				else top.document.location.replace(self.document.location.href);
			}
		}
if (top!= self) breakFree();
	//-->
	</script>
	<script type="text/javascript">
	_uacct = "UA-3181760-1";
	urchinTracker();
	</script>
</head>
<body>
	<div id='ajax_container'></div>
	<div class="top">
		<div class="top_size">
			<span class="top_left"><h1>{PAGE_TITLE}</h1></span>
			<span style="padding-left:25px;">
			<a href="{SITE_BASE}/user-submit.html" class="creeaza_btn"></a></span>
			<span class="top_right">
			<a href="{SITE_BASE}/user-login.html" class="administreaza_btn"></a></span>
		</div>
	</div>

	<div class="site">
		<!-- here we have the search box, the logo and the top menu -->
		<div class="top_menu_header">
			<div class="logo"><a href="http://www.dentistonline.ro"><img src="{SITE_BASEE}/templates/skins/default/images/logo.png" width="250" height="70"></a></div>
			<div class="top_menu">
				<div data-dojo-type="dojo/data/ItemFileReadStore" data-dojo-props="url:'{SITE_BASEE}/sources/autosuggestions.php', urlPreventCache:true, clearOnClose:true" data-dojo-id="aStore"></div>
				<form method="post" action="{ADVSEARCH_WORD}" name='advsearch_form'>
				<input type='hidden' name='autosuggestion' value=''>
				<div class="new_search">
					<div class="left_search_box rounded-corners2">
						<input type="text" name="search_word" value='{SEARCH_STRING}' placeholder='Cauta cabinet/clinica/articol stomatologie ...' size='54'>
					</div>
					<div class="right_search_box rounded-corners2">
						<div data-dojo-type="dijit/form/ComboBox"  name='search_location' id='search_location' data-dojo-props="store:aStore, searchAttr:'location',hasDownArrow:false" placeholder="Introduceti locatia dorita ..." value="{SEARCH_LOC}"></div>
						<input type="submit" value="">
					</div>
				</div>
				</form>

				<div class="top_menu_items clearfix">
					{DISPLAY_MENU_1}
				</div>
			</div>
		</div>
		<!-- here we have those 2 buttons for add new account, login and the nice big image -->

		<!-- BEGIN if_needed_first_head -->
		<div class="mainhead">
			<div class="mainhead_left">
				<div class="mainhead_leftcorner"></div>
				<div class="mainhead_white"></div>
				<div class="mainhead_text">
					<div class="mainhead_text_content">
						<h1>Cei mai buni specialisti din stomatologie la dispozitia ta</h1>
						<h2>Un dentist aproape de tine, la doar un click distanta.</h2>
						<p> Esti medic stomatolog, detii o clinica stomatologica, laborator sau un depozit de materiale stomatologice, si vrei sa beneficiezi de promovare online?</p>
					</div>
					<p><a href="{SITE_BASE}/user-submit.html" class="newaccount_btn"></a>&nbsp;&nbsp;<a href="{SITE_BASE}/user-login.html" class="admin_btn"></a></p>
				</div>
			</div>
			<div class="mainhead_right"></div>
		</div>
		<!-- here are those 3 boxes for the home page -->
		<div class="home_boxes">
			<span class="home_box1">
				<h2>Cabinete Stomatologice</h2>
				<p><a href="http://www.dentistonline.ro/Cabinete-Stomatologice/BUCURESTI.html" title="Cabinete stomatologice din Bucuresti">Cabinete Bucuresti</a>, <a href="http://www.dentistonline.ro/Cabinete-Stomatologice/Cluj.html" title="Cabinete stomatologice din Cluj">Cabinete Cluj</a>,
				<a href="http://www.dentistonline.ro/Cabinete-Stomatologice/Iasi.html" title="Cabinete stomatologice din Iasi">Cabinete Iasi</a>,
				<a href="http://www.dentistonline.ro/Cabinete-Stomatologice/Constanta.html" title="Cabinete stomatologice din Constanta">Cabinete Constanta</a>,
				<a href="http://www.dentistonline.ro/Cabinete-Stomatologice/Bihor.html" title="Cabinete stomatologice din Oradea">Cabinete Oradea</a>,
				<a href="http://www.dentistonline.ro/Cabinete-Stomatologice/Sibiu.html" title="Cabinete stomatologice din Sibiu">Cabinete Sibiu</a>,
				<a href="http://www.dentistonline.ro/Cabinete-Stomatologice/Timis.html" title="Cabinete stomatologice din Timisoara">Cabinete Timisoara</a>,
				<a href="http://www.dentistonline.ro/Cabinete-Stomatologice/Prahova.html" title="Cabinete stomatologice din Ploiesti">Cabinete Ploiesti</a>
				
				</p>
				<p><a href="{SITE_BASE}/Cabinete-Stomatologice.html"><img src="{SITE_BASEE}/templates/skins/default/images/homebox_btn.gif" border="none"></a></p>
			</span>
			<span class="home_box2">
				<h2>Clinici Stomatologice</h2>
				<p><a href="http://www.dentistonline.ro/Clinici-Stomatologice/BUCURESTI.html" title="Clinici stomatologice din Bucuresti">Clinici Bucuresti</a>, <a href="http://www.dentistonline.ro/Clinici-Stomatologice/Constanta.html" title="Clinici stomatologice din Constanta">Clinici Constanta</a>,
				<a href="http://www.dentistonline.ro/Clinici-Stomatologice/Timis.html" title="Clinici stomatologice din Timisoara">Clinici Timisoara</a>,
				<a href="http://www.dentistonline.ro/Clinici-Stomatologice/Cluj.html" title="Clinici stomatologice din Cluj">Clinici Cluj</a>,
				<a href="http://www.dentistonline.ro/Clinici-Stomatologice/Arges.html" title="Clinici stomatologice din judetul Arges">Clinici Pitesti</a>,
				<a href="http://www.dentistonline.ro/Clinici-Stomatologice/Iasi.html" title="Clinici stomatologice din Iasi">Clinici Iasi</a>,
				<a href="http://www.dentistonline.ro/Clinici-Stomatologice/Prahova.html" title="Clinici stomatologice din Ploiesti Prahova">Clinici Ploiesti</a>,
				<a href="http://www.dentistonline.ro/Clinici-Stomatologice/Bihor.html" title="Clinici stomatologice din Oradea Bihor">Clinici Oradea</a>,
				<a href="http://www.dentistonline.ro/Clinici-Stomatologice/Sibiu.html" title="Clinici stomatologice din Sibiu">Clinici Sibiu</a>,
				<a href="http://www.dentistonline.ro/Clinici-Stomatologice/Brasov.html" title="Clinici stomatologice din Brasov">Clinici Brasov</a>
				</p>
				<p><a href="{SITE_BASE}/Clinici-Stomatologice.html"><img src="{SITE_BASEE}/templates/skins/default/images/homebox_btn.gif" border="none"></a></p>
			</span>
			<span class="home_box3">
				<h2>Tehnica dentara</h2>
				<p><a href="http://www.dentistonline.ro/Tehnica-Dentara/BUCURESTI.html" title="Laboaratoare din Bucuresti">Laboratoare Bucuresti</a>, <a href="http://www.dentistonline.ro/Tehnica-Dentara/Timis.html" title="Laboaratoare din Timisoara">Laboratoare Timisoara</a>, <a href="http://www.dentistonline.ro/Tehnica-Dentara/Constanta.html" title="Laboratoare din Constanta">Laboratoare Constanta</a>, <a href="http://www.dentistonline.ro/Tehnica-Dentara/Cluj.html" title="Laboratoare din Cluj">Laboratoare Cluj</a>, <a href="http://www.dentistonline.ro/Tehnica-Dentara/Maramures.html" title="Laboratoare din Baia Mare">Laboratoare Baia Mare</a>, <a href="http://www.dentistonline.ro/Tehnica-Dentara/Prahova.html" title="Laboratoare din Ploiesti">Laboratoare Ploiesti</a></p>
				<p><a href="{SITE_BASE}/Tehnica-Dentara.html"><img src="{SITE_BASEE}/templates/skins/default/images/homebox_btn.gif" border="none"></a></p>
			</span>
		</div>
		<!-- END if_needed_first_head -->

		<!-- BEGIN if_needed_second_head -->
		<div class="secondhead">
			<div class="secondhead_left">
				<div class="secondhead_leftcorner"></div>
				<div class="secondhead_white">&nbsp;</div>
				<div class="secondhead_text secondheader_gradient">
					<div class="secondhead_text_content">
						<h1>Cei mai buni specialisti din stomatologie la dispozitia ta</h1>
						<h2>Un dentist aproape de tine, la doar un click distanta.</h2>
					</div>
					<p><a href="{SITE_BASE}/user-submit.html" class="newaccount_btn2"></a>&nbsp;&nbsp;<a href="{SITE_BASE}/user-login.html" class="admin_btn2"></a></p>
				</div>
			</div>
			<div class="secondhead_right"></div>
		</div>
		<!-- END if_needed_second_head -->

		<!-- BEGIN if_needed_third_head -->
		<div class="secondhead">
			<div class="secondhead_left">
				<div class="secondhead_leftcorner"></div>
				<div class="secondhead_white">&nbsp;</div>
				<div class="secondhead_text secondheader_gradient">
					<div class="secondhead_text_content">
						<h1>Prima alegere in promovarea cabinetului tau www.dentistonline.ro</h1>
						<h2>Site-ul nr 1 din Romania in domeniul stomatologic.</h2>
					</div>
					<p><a href="{SITE_BASE}/user-submit.html" class="newaccount_btn2"></a>&nbsp;&nbsp;<a href="{SITE_BASE}/user-login.html" class="admin_btn2"></a></p>
				</div>
			</div>
			<div class="secondhead_right"></div>
		</div>
		<!-- END if_needed_third_head -->

		<!-- here start's the left-middle-right content -->
		<div class="main">
			<div class="content_left">
				<div class="categories">
					<!-- <div class="categories_head rounded-corners">Categorii</div> -->
					{DISPLAY_MENU_3}
					<div class="left_box_head recomand_head rounded-corners">Va recomandam</div>
					<p><a href='http://www.qdental.ro' target='_blank' rel='nofollow'><img src="http://www.dentistonline.ro/images/banner/qdental.jpg" onclick="countBannerClicks('163');"></a></p>
					<p><a href='http://www.dentaldigitalsolutions.ro' target='_blank' rel='nofollow'><img src="http://www.dentistonline.ro/images/banner/zirkon-dental.jpg" onclick="countBannerClicks('471');"></a></p>

					 <!-- <p><a href='http://www.dentex-flex.ro' target='_blank' rel='nofollow'><img src="http://www.dentistonline.ro/images/banner/dentex-flex-banner.jpg" onclick="countBannerClicks('207');"></a></p>  -->

					
					<!-- BEGIN cab_all_ip -->
					<p><a href="{URL_CATEGORIE}" title="{AHREFCATEGORY_CAB}">{CATEGORY_NAME}</a></div>
					<div class="content_right">
						<a href="{URLCITESTE}" title="{AHREFCABTITLE}"><b>{NUME_FIRMA}</b></a>
						<p><img src="{IMAGE}" title="{NUME_FIRMA}" alt="{NUME_FIRMA}" width="80" height="80"><p>{DESCRIERE} ... <a href="{CITESTEANUNT}">citeste</a></p></p>
					</div></p>
					<!-- END cab_all_ip -->
				</div>
			{LATEST_BLOCK_3}
			
			</div>
			<div class="content">
				{NAVIGATION}
				{EXPAND_PAGE}{RSS_FILE}
				{MAIN}
			</div>

			<div class="content_right">
				<div class="left_box_head evenim_head rounded-corners">Newsletter</div>
				<form method="post" action="{NEWSLETTER_ACTION}">
					<p><b>E-mail</b>:&nbsp;&nbsp;&nbsp;&nbsp;<input type='text' name='email'></p>
					<p><input type='submit' value='Trimite' class='rounded-corners default_btn'></p>
				</form>
				
				<!-- <div class="recomand_list"><a href='http://www.clinica-dentalpraxis.ro' target='_blank' rel='nofollow'><img src="{SITE_BASEE}/images/banner/dental-praxis-stomatologie-bucuresti.gif" title='Dentisti Bucuresti, calitate in realizarea lucrarilor dentare' onclick="countBannerClicks('359');" border='none'></a></div>

				<div class="recomand_list"><a href='http://dentalog.ro/' target='_blank' rel='nofollow'><img src="{SITE_BASEE}/images/banner/Dentalog_software_stomatologic.gif" title='Software pentru cabinetele si clinicile stomatologice' onclick="countBannerClicks('406');" border='none'></a></div> -->

				<!-- <div class="recomand_list"><a href='http://www.vizualdent.ro' target='_blank' rel='nofollow'><img src="{SITE_BASEE}/images/banner/stomatologie-vizualdent.gif" title='Identitate vizuala a cabinetelor stomatologice, vizualdent.ro' onclick="countBannerClicks('404');" border='none'></a></div> -->

				

				<div class="left_box_margins">
					<div class="left_box_head anunt_head rounded-corners">Anunturi recomandate</div>
					<!-- BEGIN list_anunturi_homepg -->
					<div class="anunturi_list">
						<a href="{CITESTEANUNT}" title="{AHREF_ANUNTURI}"><b>{TITLUANUNT}</b></a>
						<img src="{IMAGINEANUNT}" title="{TITLUANUNT}" alt="{TITLUANUNT}" width="80" height="80"><p>{CONTINUT} ... <a href="{CITESTEANUNT}">citeste</a></p>
					</div>
					<!-- END list_anunturi_homepg -->
					   <!-- <div class="anunturi_list">
						<a href="http://www.dentistonline.ro/Anunturi-promotii-stomatologie/BUCURESTI/Black-Friday-30-reducere-la-toate-servciile-stomatologice.html" title="Anunt :Black Friday 30% reducere la toate servciile stomatologice!!"><b>Black Friday 30% reducere la toate servciile stomatologice!!</b></a>
						<img src="http://www.dentistonline.ro/images/smallimages/anunturi/reduceri-stomatologice-sector1.jpg" title="Black Friday 30% reducere la toate servciile stomatologice!!" alt="Black Friday 30% reducere la toate servciile stomatologice!!" height="80" width="80"><p>30% reducere de Black Friday.In fiecare vineri, pana in data de 01.12.2015,  ... <a href="http://www.dentistonline.ro/Anunturi-promotii-stomatologie/BUCURESTI/Black-Friday-30-reducere-la-toate-servciile-stomatologice.html">citeste</a></p>
					</div>  -->
					 <div class="anunturi_list">
						<a href="http://www.dentistonline.ro/Anunturi-angajari/BUCURESTI/Angajam-asistenta-sefa-stomatologie.html" title="Angajam asistenta stomatologie Bucuresti"><b>Angajam asistenta sefa - stomatologie</b></a>
						<img src="http://www.dentistonline.ro/images/smallimages/anunturi/logofataASCLEPIMED.png" title="Black Friday 30% reducere la toate servciile stomatologice!!" alt="Clinica Asclepimed angajeaza asistemta stomatologie" height="80" width="80"><p>Clinica ASCLEPIMED ofera oportunitatea unei doamne asistente de inalta tinuta  ... <a href="http://www.dentistonline.ro/Anunturi-angajari/BUCURESTI/Angajam-asistenta-sefa-stomatologie.html">citeste</a></p>
					</div>  
					
				</div>

				<div class="left_box_margins">
					<div class="left_box_head recomand_head rounded-corners">Va recomandam</div>
					<!-- <div class="recomand_list"><a href="http://www.dentistonline.ro/Anunturi-promotii-stomatologie/BUCURESTI/Promotia-lunii-iunie-Implant-dentar-de-la-300E-Bucuresti.html"><img src="{SITE_BASEE}/images/banner/promotie-implant-bucuresti.jpg" style="cursor: pointer;"></a>
				</div> -->
				 <div class="recomand_list"><a href="http://dentalmobility.com/parodontoza.html" target="_blank" rel="nofollow"><img src="{SITE_BASEE}/images/banner/electronic-doctor-paradontoza.gif" alt="Tratament sigur si eficient pentru paradontoza,electronic doctor" title="Electronic doctor, tratament pentru paradontoza."  onclick="countBannerClicks('428');" style="cursor: pointer;"></a>
				</div> 
				<div class="recomand_list">
					<div class="recomand_list">{RECOMANDAM_BANNER}</div>
					<div class="recomand_list"><a href='http://auto.anunturir.ro' target='_blank' rel='nofollow'><img src="{SITE_BASEE}/images/banner_anunturir.jpg" title='anunturi auto, vanzari auto, preturi vanzari auto' onclick="countBannerClicks('157');" border='none'></a></div>
				</div>

				<div class="left_box_margins">
					<div class="left_box_head articole_head rounded-corners">Articole</div>
					{ARTICOLE_PRIVILEGIATE}
				</div>
			</div>
			<div class="clearfix">&nbsp;</div>
		</div>
		<!-- here start's the footer -->
		<div class="footer">
			<div class="footer_box">
				<span class="footer_box_title"><b>Cabinete Stomatologice</b></span>
				<span class="footer_box_list"><a href="http://www.dentistonline.ro/Cabinete-Stomatologice/BUCURESTI.html" title="Cabinete stomatologice din Bucuresti">Cabinete Bucuresti</a></span>
				<span class="footer_box_list"><a href="http://www.dentistonline.ro/Cabinete-Stomatologice/Constanta.html" title="Cabinete stomatologice din Constanta">Cabinete Constanta</a></span>
				<span class="footer_box_list"><a href="http://www.dentistonline.ro/Cabinete-Stomatologice/Timis.html" title="Cabinete stomatologice din Timisoara">Cabinete Timisoara</a></span>
				<span class="footer_box_list"><a href="http://www.dentistonline.ro/Cabinete-Stomatologice/Prahova.html" title="Cabinete stomatologice din Ploiesti">Cabinete Ploiesti</a></span>
				<span class="footer_box_list"><a href="http://www.dentistonline.ro/Cabinete-Stomatologice/Sibiu.html" title="Cabinete stomatologice din Sibiu">Cabinete Sibiu</a></span>
				<span class="footer_box_list"><a href="http://www.dentistonline.ro/Cabinete-Stomatologice/Cluj.html" title="Cabinete stomatologice din Cluj">Cabinete Cluj</a></span>
				<span class="footer_box_list"><a href="http://www.dentistonline.ro/Cabinete-Stomatologice/Iasi.html" title="Cabinete stomatologice din Iasi">Cabinete Iasi</a></span>
				
			</div>
			<div class="footer_box">
				<span class="footer_box_title"><b>Tehnica dentara</b></span>
				<span class="footer_box_list"><a href="http://www.dentistonline.ro/Tehnica-Dentara/BUCURESTI.html" title="Laboaratoare din Bucuresti">Laboratoare Bucuresti</a></span>
				<span class="footer_box_list"><a href="http://www.dentistonline.ro/Tehnica-Dentara/Timis.html" title="Laboaratoare din Timisoara">Laboratoare Timisoara</a></span>
				<span class="footer_box_list"><a href="http://www.dentistonline.ro/Tehnica-Dentara/Constanta.html" title="Laboratoare din Constanta">Laboratoare Constanta</a></span>
				<span class="footer_box_list"><a href="http://www.dentistonline.ro/Tehnica-Dentara/Maramures.html" title="Laboratoare din Baia Mare">Laboratoare Baia Mare</a></span>
				<span class="footer_box_list"><a href="http://www.dentistonline.ro/Tehnica-Dentara/Prahova.html" title="Laboratoare din Ploiesti">Laboratoare Ploiesti</a></span>
				<span class="footer_box_list"><a href="http://www.dentistonline.ro/Tehnica-Dentara/Cluj.html" title="Laboratoare din Cluj">Laboratoare Cluj</a></span>
				<span class="footer_box_list"><a href="http://www.dentistonline.ro/Tehnica-Dentara/Bacau.html" title="Laboratoare din Bacau">Laboratoare Bacau</a></span>
			</div>
			<div class="footer_box">
				<span class="footer_box_title"><b>Depozite stomatologice</b></span>
				<span class="footer_box_list"><a href="http://www.dentistonline.ro/Distribuitori-Materiale/BUCURESTI.html" title="Distribuitori materiale stomatologice, depozite stomatologie Bucuresti">Distribuitori Bucuresti</a></span>
				<span class="footer_box_list"><a href="http://www.dentistonline.ro/Distribuitori-Materiale/Constanta.html" title="Distribuitori materiale stomatologice, depozite stomatologie Constanta">Distribuitori Constanta</a></span>
				
				<span class="footer_box_list"><a href="http://www.dentistonline.ro/Distribuitori-Materiale/Timis.html" title="Distribuitori materiale stomatologice, depozite stomatologie Timis">Distribuitori Timisoara</a></span>
				<span class="footer_box_list"><a href="http://www.dentistonline.ro/Distribuitori-Materiale/Mures.html" title="Distribuitori materiale stomatologice, depozite stomatologie Targu Mures">Distribuitori Targu Mures</a></span>	
				<span class="footer_box_list"><a href="http://www.dentistonline.ro/Distribuitori-Materiale/Cluj.html" title="Distribuitori materiale stomatologice, depozite stomatologie Cluj">Distribuitori Cluj</a></span>	
				<span class="footer_box_list"><a href="http://www.dentistonline.ro/Distribuitori-Materiale/Sibiu.html" title="Distribuitori materiale stomatologice, depozite stomatologie Sibiu">Distribuitori Sibiu</a></span>	
				<span class="footer_box_list"><a href="http://www.dentistonline.ro/Distribuitori-Materiale/Bihor.html" title="Distribuitori materiale stomatologice, depozite stomatologie Bihor Oradea">Distribuitori Oradea</a></span>
			</div>
			<div class="footer_box">
				<span class="footer_box_title"><b>Clinici stomatologice</b></span>
				<span class="footer_box_list"><a href="http://www.dentistonline.ro/Clinici-Stomatologice/BUCURESTI.html" title="Clinici stomatologice din Bucuresti">Clinici Bucuresti</a></span>
				<span class="footer_box_list"><a href="http://www.dentistonline.ro/Clinici-Stomatologice/Constanta.html" title="Clinici stomatologice din Constanta">Clinici Constanta</a></span>
				<span class="footer_box_list"><a href="http://www.dentistonline.ro/Clinici-Stomatologice/Timis.html" title="Clinici stomatologice din Timisoara">Clinici Timisoara</a></span>
				<span class="footer_box_list"><a href="http://www.dentistonline.ro/Clinici-Stomatologice/Prahova.html" title="Clinici stomatologice din Ploiesti Prahova">Clinici Ploiesti</a></span>
				<span class="footer_box_list"><a href="http://www.dentistonline.ro/Clinici-Stomatologice/Arges.html" title="Clinici stomatologice din judetul Arges">Clinici Pitesti</a></span>
				<span class="footer_box_list"><a href="http://www.dentistonline.ro/Clinici-Stomatologice/Cluj.html" title="Clinici stomatologice din Cluj">Clinici Cluj</a></span>
				<span class="footer_box_list"><a href="http://www.dentistonline.ro/Clinici-Stomatologice/Iasi.html" title="Clinici stomatologice din Iasi">Clinici Iasi</a></span>
				
			</div>
			<div class="footer_box">
				<span class="footer_box_title"><b>Articole stomatologie</b></span>
				<span class="footer_box_list"><a href="http://www.dentistonline.ro/articole-medicale/Stomatologie/tratament-eficient-pentru-paradontoza.html" title="Tratament pentru paradontoza, indicatii solutie unica in Romania">Tratament pentru paradontoza</a></span>
				<span class="footer_box_list"><a href="http://www.dentistonline.ro/articole-medicale/Stomatologie/cat-costa-un-implant-dentar.html" title="Detaliere cat costa un implant dentar">Cat costa un implant dentar</a></span>
				<span class="footer_box_list"><a href="http://www.dentistonline.ro/articole-medicale/Tehnica-dentara/despre-zirconiu--zirconiul-in-tehnica-dentara.html" title="Zirconiul in tehnica dentara, avantaje in stomatologie">Zirconiul in tehnica dentara</a></span>
				<span class="footer_box_list"><a href="http://www.dentistonline.ro/articole-medicale/Stomatologie/7-metode-de-evitare-a-respiratiei-urat-mirositoare.html" title="Respiratia urat mirositoare, metode pentru inlaturarea acesteia">7 metode de evitare a respiratiei urat mirositoare</a></span>
				<span class="footer_box_list"><a href="http://www.dentistonline.ro/articole-medicale/Analize-medicale/igiena-dentara.html" title="Igiena dentara la bebelusi, copii">Igiena dentara copii</a></span>
				<span class="footer_box_list"><a href="http://www.dentistonline.ro/articole-medicale/Stomatologie/albirea-dentara.html" title="Albirea dentara, indicatii ,explicatii">Albirea dentara</a></span>
				
				
				
			</div>
		</div>
		<div class="footer_b">
			<div class="footer_border_left"></div>
			<div class="footer_border">&nbsp;</div>
			<div class="footer_border_right"></div>
		</div>
		<div class="footer_links">
			<p>{DISPLAY_MENU_4}</p>
			<p>Copyright  &#169; DentistOnline.ro 2007 - {CURRENT_YEAR} . Designed and developed by <a href="http://www.webdesignrr.ro" title="creare site,realizare website" target="_blank" style="font-size:12px;">WebDesignRR</a> . </p>
		</div>

		<p><a href="http://www.turismdevis.ro" target="_blank" title="cazare litoral,cazare la munte"><img src="http://www.turismdevis.ro/images/banner_turism.jpg" border="0" title="hoteluri,vile,pensiuni" alt="cazare litoral,cazare la munte"></a><script type="text/javascript">t_rid="dentistonline";</script>
				<script type="text/javascript" src="http://storage.trafic.ro/js/trafic.js"
				></script><noscript><a href="http://www.trafic.ro/top/?rid=dentistonline"
				 target="_blank"><img border="0" alt="trafic ranking"
				 src="http://log.trafic.ro/cgi-bin/pl.dll?rid=dentistonline"/></a>
				<a href="http://www.trafic.ro">Statistici web</a>
				</noscript>
					<img style="border:0;width:88px;height:31px"
						src="{SITE_BASEE}/images/vcss.gif"
						alt="Valid CSS!" />
		</p>
		<p style="font-size:11px;">{PAGEGENERATE}</p> 
	</div>
</body>
</html>