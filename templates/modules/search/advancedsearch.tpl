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

			<table border="0" cellspacing="1" cellpadding="4" width="99%" align="center" class="left_right_top_bottom_border">
<tr style="background:#7DBCDF;color:#ffffff;">
	<td style="color:#ffffff;"><b>Cautare avansata</b></td>

</tr>

<tr>
	<td>Cauta in: <input type="radio" name="cabinete"> cabinete <input type="radio" name="anunturi">anunturi <input type="radio" name="articole"> articole</td>
</tr>

<tr>
	<td>
	



<form method="post" action="{SEARCH_WORD}" name="search">
<input type="hidden" name="nume_loc_sector" value="" />
<tr>
	<td valign="top">
	<input type="hidden" name="site_base" value="{SITE_BASEE}" />
	</td>
</tr>
<tr>
	<td >
	<table border="0" cellspacing="1" cellpadding="2" width="224" >
	<tr class="search">
		<td>Categoria:</td>
		<td>
			<select name="category_id" >
			<option value="all">------ Toate -------</option>
			<!-- BEGIN display_caats -->
			<option value="{CAT_ID}" {SELECTED_CAT}>{CAT_NAME}</option>
			<!-- END display_caats -->
			</select>
		</td>
	</tr>
	<tr class="search">
	<td >Judetul:</td>
	<td>
		<select name="judet" id="judet" onchange="CompleteLocalitate();" >
				<option value="alege" >-----Alege judet----</option>
				<!-- BEGIN juudet -->
				<option value="{COD_JUDET}" {SELECTEDCOUNTRY}>{NUMEJUDET}</option>
				<!-- END juudet -->
			</select>
	</td>
	</tr>
	<tr  class="search">
	<td>Localitate:</td>
			<td><div id="localitate_ajax" align="left" >{LOC_DIV}</div></td>
	</tr>
	<tr class="search">
	<td nowrap>Cuvant:</td>
	<td><input type="text" name="search_word" value="{CUVANT_CAUTAT}" size="26" />
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


	</td>
	
</tr>

<tr>
		<td>
				<form method="post" action="{SEARCH_WORD}" name="search">
<input type="hidden" name="nume_loc_sector" value="" />
<tr>
	<td valign="top">
	<input type="hidden" name="site_base" value="{SITE_BASEE}" />
	</td>
</tr>
<tr>
	<td >
	<table border="0" cellspacing="1" cellpadding="2" width="224" >
	<tr class="search">
		<td>Categoria:</td>
		<td>
			<select name="category_id" >
			<option value="all">------ Toate -------</option>
			<!-- BEGIN display_caats -->
			<option value="{CAT_ID}" {SELECTED_CAT}>{CAT_NAME}</option>
			<!-- END display_caats -->
			</select>
		</td>
	</tr>
	<tr class="search">
	<td >Judetul:</td>
	<td>
		<select name="judet" id="judet" onchange="CompleteLocalitate();" >
				<option value="alege" >-----Alege judet----</option>
				<!-- BEGIN juudet -->
				<option value="{COD_JUDET}" {SELECTEDCOUNTRY}>{NUMEJUDET}</option>
				<!-- END juudet -->
			</select>
	</td>
	</tr>
	<tr  class="search">
	<td>Localitate:</td>
			<td><div id="localitate_ajax" align="left" >{LOC_DIV}</div></td>
	</tr>
	<tr class="search">
	<td nowrap>Cuvant:</td>
	<td><input type="text" name="search_word" value="{CUVANT_CAUTAT}" size="26" />
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
</td>
	
</tr>


<tr>
		<td>
				<form method="post" action="{SEARCH_WORD}" name="search">
<input type="hidden" name="nume_loc_sector" value="" />
<tr>
	<td valign="top">
	<input type="hidden" name="site_base" value="{SITE_BASEE}" />
	</td>
</tr>
<tr>
	<td >
	<table border="0" cellspacing="1" cellpadding="2" width="224" >
		<tr class="search">
	<td nowrap>Cuvant:</td>
	<td><input type="text" name="search_word" value="{CUVANT_CAUTAT}" size="26" />
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
</td>
	
</tr>
 </table>

