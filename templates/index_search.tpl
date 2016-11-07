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
	<meta property="fb:admins" content="185728528279543" />
	<link rel="shortcut icon" href="{SITE_BASEE}/favicon.ico" >
	<link rel="stylesheet" href="{SITE_BASEE}/templates/skins/default/style.css" type="text/css" media="screen">
	<link rel="alternate" type="application/xml" title="RSS" href="http://www.dentistonline.ro/rss/feed.xml">

	<!-- OTHER JS FUNCTIONS AND PROTITYPE CLASS -->
	<script type="text/javascript" src="{SITE_BASEE}/templates/js/prototype.js"></script>
	<script type="text/javascript" src="{SITE_BASEE}/templates/js/functions.js"></script>
	
	<script src="{SITE_BASEE}/templates/js/gmap/jquery/lib/jquery-1.5.1.min.js" type="text/javascript">
	<script src="{SITE_BASEE}/templates/js/gmap/jquery/ui/js/jquery-ui-1.8.12.custom.min.js" type="text/javascript">
	<script src="{SITE_BASEE}/templates/js/gmap/jquery/plugins/jquery.cookie.js" type="text/javascript">
	<script src="{SITE_BASEE}/templates/js/gmap/jquery/plugins/jquery.json-2.2.min.js" type="text/javascript">
	<script src="{SITE_BASEE}/templates/js/gmap/init.js" type="text/javascript">

	<!-- TRACKING CODE FOR GOOGLE WEBMASTERS AND ANALITYCS -->
	<meta name="verify-v1" content="67a29diqzvW8c3k/u5upi/L/u2PBlrCxbwAUxrP1ffk=">
	<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
	</script>
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


<script language="JavaScript">
<!--
	function RedirectURL(link,banner_id)
	{
		if(link!="")
		{
			countBannerClicks(banner_id);
			window.open(link,'_blank');
		}
	}
//-->
</script>


</head>
<body>
	<div id='ajax_container'></div>
		<div class="top">
		<div class="top_size">
			<span class="top_left"><h1>{PAGE_TITLE}</h1></span>
			<span class="top_right">
				<a href="{SITE_BASE}/user-submit.html" class="creeaza_btn"></a>
				<a href="{SITE_BASE}/user-login.html" class="administreaza_btn"></a>
			</span>
		</div>
	</div>

	<div class="site">
		<!-- here we have the search box, the logo and the top menu -->
		<div class="top_menu_header">
			<div class="logo">
				<a href="http://www.dentistonline.ro"><img src="{SITE_BASEE}/templates/skins/default/images/logo.png" width="250" height="70"></a>
				<p>Dentistul tau la doar un click distanta.</p>
			</div>
			<div class="top_menu">
				<form method="post" action="{ADVSEARCH_WORD}" name='advsearch_form'>
				<input type='hidden' name='autosuggestion' value=''>
				<div class="new_search">
					<div class="left_search_box rounded-corners2">
						<input type="text" name="search_word" value='{SEARCH_STRING}' placeholder='Cauta cabinet/clinica/articol stomatologie ...' size='54'>
					</div>
					<div class="right_search_box rounded-corners2">
						<input type="text" name="search_location" value='{SEARCH_LOC}' placeholder='Introduceti locatia dorita ...' size='30'>
						<input type="submit" value="">
					</div>
				</div>
				</form>
			</div>
		</div>

		<!-- here start's the left-middle-right content -->
		<div class="main">
			{NAVIGATION}
			{EXPAND_PAGE}{RSS_FILE}
			{MAIN}
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
			<p>Copyright  &#169; DentistOnline.ro 2007 - 2013 . Designed and developed by <a href="http://www.webdesignrr.ro" title="creare site,realizare website" target="_blank" style="font-size:12px;">WebDesignRR</a> . </p>
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