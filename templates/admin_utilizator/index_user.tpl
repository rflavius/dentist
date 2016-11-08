<html>
<head>
	<title>{SITETITLE}</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<meta http-equiv="Content-Style-Type" content="text/css" />
	<meta name="generator" content="editplus" />
	<meta name="author" content="" />
	<meta name="keywords" content="" />
	<meta name="description" content="" />
	<link type="text/css" href="../templates/admin_utilizator/skins/user/style.css" rel="stylesheet">

	{ADDITIONAL_HEAD_JS}
	<!-- HERE IS THE BOOTSTRAP LIBRARY FOR RESPONSIVE -->
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="{SITE_BASE}/resources/bootstrap-3.3.5/css/bootstrap.min.css">
	
	<!-- jQuery library -->
	<script src="{SITE_BASE}/resources/jquery/1.11.3/jquery.min.js"></script>
	
	<!-- Latest compiled JavaScript -->
	<script src="{SITE_BASE}/resources/bootstrap-3.3.5/js/bootstrap.min.js"></script>
	
	<!-- Font-Awesome CSS -->
	<link rel="StyleSheet" href="{SITE_BASE}/resources/font-awesome/css/font-awesome.css" rel="stylesheet">
	
	<script type="text/javascript" src="{SITE_BASE}/templates/js/functions.js"></script>
	<script src="{SITE_BASE}/templates/js/admin_utilizator/general.js" type="text/javascript"></script>
	<script type="text/javascript" src="{SITE_BASE}/templates/js/mini/overlib_mini.js">
	<!-- overLIB (c) Erik Bosrup --></script>
	
	<script type="text/javascript">
		// display the free package modal
		$(document).ready(function()
				{
					displayUserPanelOfertaModal();
				});
	</script>
	
	
	<script type="text/javascript" src="../jwplayer/jwplayer.js"></script>
	<div id="overDiv" style="position:absolute; visibility:hidden; z-index:1000;"></div>
</head>
<body>
<div id='ajax_container'>{AJAX_RESPONSE}</div>
<table height="100%" width="100%" cellspacing="0" cellpadding="0" align="center">
	<tr>
		<td colspan="2">
			<div class="header_bg">
				<div class="header clearfix">
					<div class="logo"><a href="{SITE_BASE}/admin_utilizator/?page=user.addfirm">Panou Administrare</a></div>
					<div class="header_user_menu">
						<span>Bine ai venit: {USERNAME}</span> | 
						<span><a href="http://www.dentistonline.ro" target="_blank">www.dentistonline.ro</a></span> | 
						<a href="index.php?page=user.logout">Iesire din cont</a>
					</div>
				
					<div class="menu_1">
						{MENU}	
					</div>
				</div>
				{MENU_2}
				
			</div>
		</td>
	</tr>
	<tr height="100%">
		<td>
			<div class="main">
				<div class="content container">
					<h1>{MAIN_TITLE}</h1>
					{MAIN}
					<div>

					<!-- <table border="0" cellspacing="1" cellpadding="4" width="100%" class="big_table form">
					<tr>
						<td class="table_subhead"><b>Acceleratoarele de albire Beyond.</b></td>
					</tr>
					<tr>
						<td>
						<p>	<b><a name="beyond" title="Comanda acum accelaeratorul Beyond">Stimati medici - alaturati-va chiar astazi marii familii Beyond!</a></b><br>
							Albirea dintilor nu a fost niciodata mai simpla si 	mai eficienta - atat pentru medicii dentisti cat si pentru pacienti. Cele peste 15000 de aparate stomatologice Beyond pentru	albirea dintilor vandute in intreaga lume vorbesc de la sine.<br>

							Vreti pur-si-simplu sa faceti cea mai buna afacere posibila pentru cabinetul dvs stomatologic? Contactati-ne chiar acum! Este dovedit ca investitia intr-o lampa pentru albirea dintilor de la Beyond se recupereaza foarte repede datorita interesului ridicat al pacientilor pentru produsele noastre de calitate.
							<br><br>
							Ne puteti contacta de luni pana vineri intre orele 09.00 si 17.30, la urmatoarele numere de telefon:
							<br>
							<b>0733-684466 | 0724-848535 | 0733-967099 &nbsp;&nbsp;    FAX: 0264-424207  &nbsp;&nbsp; E-MAIL:<b>office@beyondromania.ro</b></b><br>
							
							</p>
						</td>
					</tr>
					</table> -->
					</div>
				</div>
			</div>
			
		 </td>
		 <!-- <td> <a href="http://www.dentistonline.ro/admin_utilizator/?page={LINK_BEYOND}#beyond"><img src="../images/banner/albire_beyond.gif"></a> 
		<br>
		<img src="../images/banner/dentalog.jpg"></td>  -->

		<!-- <td>
		
		<a href="http://www.dentistonline.ro/admin_utilizator/?page={LINK_BEYOND}#beyond"><img src="../images/banner/qdental_uti.jpg"></a><br>
		<a href="http://www.dentistonline.ro/admin_utilizator/?page={LINK_BEYOND}#beyond"><img src="../images/banner/vizualdent.jpg"></a><br>
		<a href="http://www.dentistonline.ro/admin_utilizator/?page={LINK_BEYOND}#beyond"><img src="../images/banner/dentalog.jpg"></a><br>
		<br>
		
		</td> -->

		<td>
				 <table>
						<!-- BEGIN bannere_panou_administrare -->
						<tr>
							<td><a href="{LINK_TO_SITE}" rel="nofollow" target="_blank"><img src="../images/banner/{BANNER_IMAGE_NAME}" onclick="countBannerClicks('{BANNER_ID}');"></a><br> <hr></td>
						</tr>
						<!-- END bannere_panou_administrare -->
						
					</table>		
		</td> 
	</tr>

	<tr>
		<td colspan="2">
			<div class="footer">
				Copyright www.dentistonline.ro 2016.
			</div>
		</td>
	</tr>
</table>

<div id='map'></div>

</body>
</html>