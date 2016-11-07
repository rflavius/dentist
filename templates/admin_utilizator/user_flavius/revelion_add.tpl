<script type="text/javascript" src="{SITE_BASE}/templates/js/prototype.js"></script>
<script language="JavaScript" type="text/javascript">
<!--
function ValidateStep1()
{
	var error = 0;
	if(document.mod_info.name.value=="")
	{
		alert('Va rugam sa complectati denumirea hotelului,vilei sau pensiunii !');
		error = 1;
	}
	if(document.mod_info.description.value=="")
	{
		alert('Va rugam sa complectati descrierea hotelului,vilei sau pensiunii !');
		error = 1;
	}
	if(document.mod_info.oferta.value=="")
	{
		alert('Va rugam sa complectati datele ofertei dvs pentru Revelion !');
		error = 1;
	}
	if(document.mod_info.contact.value=="")
	{
		alert('Va rugam sa complectati datele de contact !');
		error = 1;
	}

	if(error==0)
	{
		document.mod_info.add.value='on';
		document.mod_info.submit();
	}
}

//-->
</script>
<h1>Adauga oferta pentru Revelion</h1>
<form method="post" action="{EDIT_INFO_FORM}" name="mod_info" enctype="multipart/form-data">
<input type="hidden" name="add" value="" />
<fieldset>
	<legend>Informatii despre unitate</legend>
	<table border="0" cellspacing="1" cellpadding="0" width="100%" align="center" class="big_table form">
		<tr>
			<td class="row1" style="padding-left: 10px;">Denumire hotel,pensiune,vila :<b class="star">*</b></td>
			<td class="row1" ><input type="text" name="name" class="loginbox_input" value="{NAME}" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b class="text">ex: Hotel Continental</b></td>
		</tr>
		<tr>
			<td class="row2" style="padding-left: 10px;">Imagine <b class="star">*</b></td>
			<td class="row2" ><input type="file" name="image_revelion" size='20' value="" ></td>
		</tr>
		<tr>
			<td class="row1"  style="padding-left: 10px;">Nr. Stele / Margarete :<b class="star">*</b></td>
			<td class="row1" >
			<select name="stars" width="50">
				<!-- BEGIN star_list -->
				<option value="{STAR}" {SEL_STAR}>{STAR}</option>
				<!-- END star_list -->
			</select>
			</td>
		</tr>
		<tr>
			<td class="row2"  style="padding-left: 10px;" valign="top">Locatie :<b class="star">*</b></td>
			<td class="row2" >
				<select name="rev_cat">
					<!-- BEGIN list_rev_cat -->
					<option value="{REV_CAT}">{CAT}</option>
					<!-- END list_rev_cat -->
				</select>
			</td>
		</tr>

		<tr>
			<td class="row1"  style="padding-left: 10px;" valign="top">Descriere :<b class="star">*</b></td>
			<td class="row1" ><textarea name="description" rows="6" cols="75">{DESCRIERE}</textarea></td>
		</tr>
		<tr>
			<td class="row2"  style="padding-left: 10px;" valign="top">Oferta Cazare :<b class="star">*</b></td>
			<td class="row2" ><textarea name="oferta" rows="10" cols="75">{CAZARE}</textarea></td>
		</tr>
		<tr>
			<td class="row1"  style="padding-left: 10px;">Date de contact :<b class="star">*</b></td>
			<td class="row1" ><textarea name="contact" rows="6" cols="75">{CONTACT}</textarea></td>
		</tr>
		<tr>
			<td align="center" class="row2" colspan="2"><input type="button" class="button" value="Adauga" onClick="ValidateStep1();"/></td>
		</tr>
	</table>
</fieldset>
</form>