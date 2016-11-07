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
	{ROBOTS_META}
	{PAGINATION_NEXT}
	{PAGINATION_PREV}
	
	<meta name="google-site-verification" content="w58mG8ET81tTPuVhhFmDAooWan8XOFrgOQz59ESmtPE" />
	<meta name="msvalidate.01" content="0A7312E883F0E226280D2AB25D1E3FC0" />
	<meta property="fb:admins" content="185728528279543" />
	
	<link rel="shortcut icon" href="{SITE_BASE}/favicon.ico" >
	<link rel="alternate" type="application/xml" title="RSS" href="http://www.dentistonline.ro/rss/feed.xml">
	
	<link rel="stylesheet" href="{SITE_BASE}/templates/skins/default/style_responsive.css" type="text/css" media="screen">

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="{SITE_BASE}/resources/bootstrap-3.3.5/css/bootstrap.min.css">
	
	<!-- TRACKING CODE FOR GOOGLE WEBMASTERS AND ANALITYCS -->
	<meta name="verify-v1" content="67a29diqzvW8c3k/u5upi/L/u2PBlrCxbwAUxrP1ffk=">
	
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
	
	<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-3181760-1', 'auto');
  ga('send', 'pageview');

</script>
</head>
<body>
	
	<div id='ajax_container'>{OFERTA_MODAL}</div>

	<div class="top">
		<div class="container">
			<span class="col-xs-9 text-left"><h1>{PAGE_TITLE}</h1></span>
			<span class="col-xs-3 text-right small">
				<div class='visible-md-block visible-lg-block hidden-xs hidden-sm'>
					<a href="{SITE_BASE}/user-submit.html" class="top_new_account" title='Creeaza cont nou'>Creeaza cont</a>
					<a href="{SITE_BASE}/user-login.html" class="top_login_btn" title='Autentificare'>Autentificare</a>
				</div>
				<div class='hidden-md hidden-lg visible-xs-block visible-sm-block'>
					<div class="btn-group">
						<button type="button" class="btn btn-info btn-md dropdown-toggle" data-toggle="dropdown">
							<span class='glyphicon glyphicon-user'></span>
							&nbsp;<span class='caret'></span>
						</button>
						<ul class="dropdown-menu" role="menu">
							<li><a href="{SITE_BASE}/user-submit.html">Creeaza cont</a></li>
							<li><a href="{SITE_BASE}/user-login.html">Autentificare</a></li>
						</ul>
	  				</div>
				</div>
			</span>
		</div>
	</div>

	<div class="site">
		<!-- here we have the search box, the logo and the top menu -->
		<div class="container">
			<div class="logo col-xs-4">
				<a href="{SITE_BASE}">
					<img src="{SITE_BASE}/templates/skins/default/images/logo.png" alt='dentistonline logo' class='img-responsive'>
				</a>
			</div>
			{SEARCH_BLOCK}
		</div>
		
		<!-- here start's the middle content -->
		<div class="main container well well-lg">
			<div class="row">
				<div class="col-xs-12 col-md-3 text-left">
					<div class='left_menu'>
						<nav class="navbar navbar-default">
							<div role="navigation">
								<div class="navbar-header">
									<button type="button" class="navbar-toggle pull-left" data-toggle="collapse" data-target="#menu_3" style='margin-left:15px;'>
										<div class='pull-left'>Meniu</div>
										<div class='pull-right' style='padding-top:4px;margin-left:20px;'>
											<span class="sr-only">Navigatie</span>
											<span class="icon-bar">&nbsp;</span>
											<span class="icon-bar">&nbsp;</span>
											<span class="icon-bar">&nbsp;</span>
										</div>
									</button>
								</div>
								<div class="navbar-collapse collapse" id='menu_3'>
									<ul class="nav navbar-nav">
										{DISPLAY_MENU_3}
									</ul>
								</div>
							</div>
						</nav>
					</div>
				</div>
				<div class="col-xs-12 col-md-9 text-left main-col">
					{NAVIGATION}
					{EXPAND_PAGE}
					{ERROR_BLOCK}
					{MAIN}
				</div>
				<div class="col-xs-12 col-md-3 text-left">
					{LATEST_BLOCK_3}
				</div>
			</div>
			<div class="clearfix">&nbsp;</div>
			{FOOTER_BLOCK}
		</div>
		<br>
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
	</div>
	
	<!-- HERE IS THE BOOTSTRAP LIBRARY FOR RESPONSIVE -->
	<!-- OTHER JS FUNCTIONS AND PROTITYPE CLASS -->
	<script type="text/javascript" src="{SITE_BASE}/templates/js/prototype.js"></script>
	
	<!-- jQuery library -->
	<script src="{SITE_BASE}/resources/jquery/1.11.3/jquery.min.js"></script>
	
	<!-- Latest compiled JavaScript -->
	<script src="{SITE_BASE}/resources/bootstrap-3.3.5/js/bootstrap.min.js"></script>

	<script type="text/javascript" src="{SITE_BASE}/templates/js/functions.js"></script>
	
</body>
</html>