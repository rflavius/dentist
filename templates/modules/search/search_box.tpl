<script language="javascript" type="text/javascript">
<!--
	function CompleteLocalitate()
	{
		var xmlhttp;
		var url = document.search.site_base.value+"/sources/ajax_search.php?tpl_selected=tplsearch&search_judet="+document.search.judet.value;

		if (window.XMLHttpRequest)
			{
			// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
			}
		else if (window.ActiveXObject)
			{
			// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			}
		else
			{
			alert("Your browser does not support XMLHTTP!");
			}
		xmlhttp.onreadystatechange=function()
		{
			if(xmlhttp.readyState==4)
			{
				document.getElementById('localitate_ajax').innerHTML=xmlhttp.responseText;
			}
		}
		xmlhttp.open("GET",url,true);
		xmlhttp.send(null);

		/*var target ='localitate_ajax'; 
		var url = document.search.site_base.value+"/sources/ajax_search.php?tpl_selected=tplsearch&search_judet="+document.search.judet.value;
		var myAjax = new Ajax.Updater(target, url, { method: 'get'}); 
		$(target).show();*/
	}

	function Testing(val)
	{
		document.search.nume_loc_sector.value = val;
	}

//-->
</script>


<form method="post" action="{SEARCH_WORD}" name="search">
<input type="hidden" name="nume_loc_sector" value="" />
<tr>
	<td valign="top">
	<input type="hidden" name="site_base" value="{SITE_BASEE}" />
	<table border="0" cellspacing="0" cellpadding="0" width="100%">
	<tr>
		<td class="search_box_head" width="110" ><p>Cautare</p></td>
		<td align="left"><img src="{SITE_BASEE}/templates/skins/default/images/search_book.jpg" title="Cauta" alt="Cauta"></td>
		<td class="search_box_head" width="12">&nbsp;</td>
	</tr>
	</table>
	</td>
</tr>
<tr>
	<td >
				<table border="0" cellspacing="1" cellpadding="2" width="224" >
			<tr class="search">
				<td>
					<input type="radio" name="cauta_option" value="cabinete" {CHECKED_CABINETE}>Cabinete<input type="radio" name="cauta_option" value="articole" {CHECKED_ARTICOLE}>Articole<input type="radio" name="cauta_option" value="anunturi" {CHECKED_ANUNTURI}>Anunturi
				</td>
			</tr>
			<tr class="search">
			
			<td><input type="text" name="search_word" value="{CUVANT_CAUTAT}" size="40" />
			</tr>
			<tr>
				<td colspan="2" align="center"><input type="submit" name="sbmtbtn" value="Cauta"  class="button"/></td>
			</tr>
			<tr>
				<td colspan="2" style="height: 15px;"></td>
			</tr>
			</table>
	</td>
</tr>
</form>

