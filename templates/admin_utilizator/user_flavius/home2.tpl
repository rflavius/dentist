<script type="text/javascript" src="../templates/js/prototype.js"></script>

<script language="JavaScript">
<!--
	function CreatePopUp(user_id)
	{
		//getPageSizeWithScroll();
		var url="../popup.php";
		url=url+"?user_id="+user_id;
		var target = 'popup';
		var myAjax = new Ajax.Updater(target,url, { method: 'get'});
		$(target).show();
	}

	function VoteSondaj(user_id,vot)
	{
		var url="../popup.php";
		url=url+"?user_id="+user_id+"&type=voteaza&vot="+vot;
		var target = 'popup';
		var myAjax = new Ajax.Updater(target,url, { method: 'get'});
		$(target).hide();
	}

	function getPageSizeWithScroll(){
		if (window.innerHeight && window.scrollMaxY) {// Firefox
			yWithScroll = window.innerHeight + window.scrollMaxY;
			xWithScroll = window.innerWidth + window.scrollMaxX;
		} else if (document.body.scrollHeight > document.body.offsetHeight){ // all but Explorer Mac
			yWithScroll = document.body.scrollHeight;
			xWithScroll = document.body.scrollWidth;
		} else { // works in Explorer 6 Strict, Mozilla (not FF) and Safari
			yWithScroll = document.body.offsetHeight;
			xWithScroll = document.body.offsetWidth;
			}
		arrayPageSizeWithScroll = new Array(xWithScroll,yWithScroll);
		document.getElementById('popup_bg').style.height = yWithScroll;
	}


var interval;
/*window.onload = function()
	{
		interval = setInterval("CreatePopUp('{POPUP_USER_ID}')", 60*1000);// 60 secs between requests
	};*/

//-->
</script>

{INFORMATION}
<div id="popup">{POPUP_DIV}</div>
<h2 style='color: #CE0000'><b>NOU !!!</b>    Acum unitatea ta are propriul ei site! <a href="{HOTEL_LINK}" target='_blank'>click aici</a></h2>
<div class="home_special" >
	<table align="center" cellspacing="2" cellpadding="3" width="99%">
	<tr>
		<td><img src="../images/admin/promovare.jpg" style="float: left;" onload="CreatePopUp('{POPUP_USER_ID}')"><p style="float: right;">{NOT_ACTIVE_MSG}{ERROR}</p></td>
	</tr>
	</table>
</div>
<br>
<fieldset>
	<legend>LISTA CU OFERTELE DVS</legend>
	<table cellpadding="0" cellspacing="1" class="big_table" width="100%">
		<tr>
			<td class="table_subhead">#</td>
			<td class="table_subhead"><b>Activ</b></td>
			<td class="table_subhead"><b>Denumire</b></td>
			<td class="table_subhead"><b>Categorie</b></td>
			<td class="table_subhead"><b>Mesaje</b></td>
			<td class="table_subhead"><b>Imagini</b></td>
			<td class="table_subhead"><b>Vizualizari</b></td>
			<td class="table_subhead"><b>ACTIUNI</b></td>
		</tr>
		<!-- BEGIN if_no_records -->
		<tr>
			<td class="row1" colspan="8">{NO_RECORDS}</td>
		</tr>
		<!-- END if_no_records -->
		<!-- BEGIN list_row -->
		<tr>
			<td class="{BGROW}"><a href="{HOTEL_LINK}" target='_blank'>{NR}</a></td>
			<td class="{BGROW}"><b>{STATUS}</b></td>
			<td class="{BGROW}"><a href="{HOTEL_LINK}" target='_blank'>{NAME}</a></td>
			<td class="{BGROW}">{CAT}</td>
			<td class="{BGROW}"><a href="{SITE_BASE}/admin/?page=user.mesaje"><b>{NR_MSG}</b></a></td>
			<td class="{BGROW}"><a href="{IMG_LINK}">{IMG}</a>&nbsp;&nbsp;<a href="{IMG_LINK}">[ modifica ]</a></td>
			<td class="{BGROW}"><b>{VIEWS}</b></td>
			<td nowrap class="{BGROW}">
				<ul>
					<li><a href="{EDIT_INFO_LINK}">[ modifica informatii ]</a></li>
					<li><a href="{EDIT_CAZARE_LINK}">[ modifica oferta cazare ]</a></li>
				</ul>
			</td>
		</tr>
		<!-- END list_row -->
	</table>
</fieldset>
