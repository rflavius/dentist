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
	
	<link rel="alternate" type="application/xml" title="RSS" href="http://www.dentistonline.ro/rss/feed.xml">
	<script type="text/javascript" src="{SITE_BASEE}/templates/js/prototype.js"></script>
	<script type="text/javascript" src="{SITE_BASEE}/templates/js/functions.js"></script>
	<!-- TRACKING CODE FOR GOOGLE WEBMASTERS AND ANALITYCS -->
	<meta name="verify-v1" content="67a29diqzvW8c3k/u5upi/L/u2PBlrCxbwAUxrP1ffk=">
	<script src="http://www.google-analytics.com/urchin.js" type="text/javascript"></script>

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
			<span class="top_right">
				<a href="{SITE_BASE}/user-submit.html" class="top_new_account" title='Creeaza cont nou'>Creeaza cont</a>
				<a href="{SITE_BASE}/user-login.html" class="top_login_btn" title='Autentificare'>Autentificare</a>
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

				<!-- <div class="top_menu_items clearfix">
					{DISPLAY_MENU_1}
				</div> -->
			</div>
		</div>
		<!-- here we have those 2 buttons for add new account, login and the nice big image -->

		<!-- here start's the left-middle-right content -->
		<div class="main rounded-corners2">
			<div class="content_left">
				<div class="categories">
					<!-- <div class="categories_head rounded-corners">Categorii</div> -->
					{DISPLAY_MENU_3}
					<br>
					<div class="left_box_head recomand_head rounded-corners">Va recomandam</div>
					<p>
						<a href='http://www.qdental.ro' target='_blank' rel='nofollow'>
							<img src="http://www.dentistonline.ro/images/banner/qdental.jpg" onclick="countBannerClicks('163');">
						</a>
					</p>
					<p>
						<a href='http://www.dentaldigitalsolutions.ro' target='_blank' rel='nofollow'>
							<img src="http://www.dentistonline.ro/images/banner/zirkon-dental.jpg" onclick="countBannerClicks('471');">
						</a>
					</p>
					<p>
						<a href='http://www.socialdental.ro/' target='_blank' rel='nofollow'>
							<img src="http://www.dentistonline.ro/images/banner/social-dental2.jpg" onclick="countBannerClicks('471');">
						</a>
					</p>
					 <!-- <p><a href='http://www.dentex-flex.ro' target='_blank' rel='nofollow'><img src="http://www.dentistonline.ro/images/banner/dentex-flex-banner.jpg" onclick="countBannerClicks('207');"></a></p>  -->
				</div>
				{LATEST_BLOCK_3}
			</div>
			<div class="content">
				{NAVIGATION}
				{EXPAND_PAGE}{RSS_FILE}
				{MAIN}
			</div>
		</div>
		<div class="clearfix">&nbsp;</div>
		{FOOTER_BLOCK}
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