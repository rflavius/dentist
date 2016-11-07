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
	if(document.mod_info.adresa.value=="")
	{
		alert('Va rugam sa complectati adresa hotelului,vilei sau pensiunii !');
		error = 1;
	}
	if(document.mod_info.descriere.value=="")
	{
		alert('Va rugam sa complectati descrierea hotelului,vilei sau pensiunii !');
		error = 1;
	}
	if(document.mod_info.zona.value=="")
	{
		alert('Va rugam sa alegeti zona turistica a hotelului,vilei sau pensiunii !');
		error = 1;
	}
	if(document.mod_info.judet.value=="")
	{
		alert('Va rugam sa alegeti judetul hotelului,vilei sau pensiunii !');
		error = 1;
	}

	if(error==0)
	{
		document.mod_info.modify.value='on';
		document.mod_info.submit();
	}
}

function ListLocalitate(val)
{
	if(val!="")
	{
		var target ='localitate_ajax'; 
		var url="../sources/ajax.php?judet="+val;
		var myAjax = new Ajax.Updater(target, url, { method: 'get',
													onLoading: function(){
																			$('load').show();
																		},
													onCompleted: function(){
																			$('load').hide();
																		}
																		});
		$(target).show();
		$('not_localitate').hide();
	}
	else
	{
		alert('Va rugam sa selectati judetul !');
	}
}


//-->
</script>
<h1>Modifica informatii</h1>
<form method="post" action="{EDIT_INFO_FORM}" name="mod_info">
<input type="hidden" name="modify" value="" />
<fieldset>
	<legend>Informatii despre unitate</legend>
	<table border="0" cellspacing="1" cellpadding="0" width="100%" align="center" class="big_table form">
		<tr>
			<td class="row1" style="padding-left: 10px;">Denumire hotel,pensiune,vila :<b class="star">*</b></td>
			<td  class="row1" ><input type="text" name="name" class="loginbox_input" value="{NAME}" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b class="text">ex: Continental</b></td>
		</tr>
		<tr>
			<td  class="row2"  style="padding-left: 10px;">Zona turistica :<b class="star">*</b></td>
			<td  class="row2" >
			<select name="zona" >
				<option value="">- - - - - Alege Zona turistica - - - - - </option>
				<!-- BEGIN zona_list -->
				<option value="{ZONA}" {SEL_ZONA} >{ZONA}</option>
				<!-- END zona_list -->
			</select>
			</td>
		</tr>
		<tr>
			<td class="row1"   style="padding-left: 10px;">Judet :<b class="star">*</b></td>
			<td  class="row1" >
			<select name="judet" >
				<option value="">- - - - - Alege Judetul - - - - - </option>
				<!-- BEGIN judet_list -->
				<option value="{JUDET_CODE}" onclick="ListLocalitate(this.value)" {SEL_JUDET}>{JUDET}</option>
				<!-- END judet_list -->
			</select>
			</td>
		</tr>
		<tr>
			<td class="row2"   style="padding-left: 10px;">Localitate :<b class="star">*</b></td>
			<td class="row2" >
				<div id="localitate_ajax" >
				{LOC_DIV}
				</div>
				<div id="not_localitate">
						<input type="text" name="localitate2" value="{LOCALITATE}" readonly />
				</div>
			</td>
		</tr>
		<tr>
			<td class="row1"   style="padding-left: 10px;">Categorie :<b class="star">*</b></td>
			<td class="row1" >
			<select name="category">
				<!-- BEGIN cat_list -->
				<option value="{CAT}" {SEL_CAT}>{CAT}</option>
				<!-- END cat_list -->
			</select>
			</td>
		</tr>
		<tr>
			<td class="row2"  style="padding-left: 10px;">Stele / Margarete :<b class="star">*</b></td>
			<td class="row2" >
			<select name="star">
				<!-- BEGIN star_list -->
				<option value="{STAR}" {SEL_STAR}>{STAR}</option>
				<!-- END star_list -->
			</select>
			</td>
		</tr>
		<tr>
			<td class="row1"  style="padding-left: 10px;">Persoana de contact :<b class="star">*</b></td>
			<td class="row1" ><input type="text" name="pers_contact" class="loginbox_input" value="{PERS_CONTACT}" /></td>
		</tr>
		<tr>
			<td class="row2"  style="padding-left: 10px;">Adresa :<b class="star">*</b></td>
			<td class="row2" ><textarea name="adresa" rows="3" cols="45">{ADRESA}</textarea></td>
		</tr>
		<tr>
			<td class="row1"  style="padding-left: 10px;">Telefon :</td>
			<td class="row1" ><textarea name="telefon" rows="3" cols="45">{TELEFON}</textarea></td>
		</tr>
		<tr>
			<td class="row2"  style="padding-left: 10px;">Fax :</td>
			<td class="row2" ><input type="text" name="fax" class="loginbox_input" value="{FAX}" /></td>
		</tr>
		<tr>
			<td class="row1"  style="padding-left: 10px;">E-mail :</td>
			<td class="row1" ><input type="text" name="email" class="loginbox_input" value="{EMAIL}"/></td>
		</tr>
		<tr>
			<td class="row2"  style="padding-left: 10px;">WebSite :</td>
			<td class="row2" ><input type="text" name="website" class="loginbox_input" value="{WEBSITE}"/></td>
		</tr>
		<tr>
			<td class="row1"  style="padding-left: 10px;" valign="top">Descriere :<b class="star">*</b></td>
			<td class="row1" ><textarea name="descriere" rows="6" cols="45">{DESCRIERE}</textarea></td>
		</tr>
		<tr>
			<td class="row2"  style="padding-left: 10px;" valign="top"><b>Facilitati</b> :<b class="star">*</b></td>
			<td class="row2" >
			<table border="0" cellspacing="2" cellpadding="3" width="100%">
			<!-- BEGIN facilitati_row -->
			<tr>
				<!-- BEGIN facilitati_item -->
				<td class="text" nowrap><input type="checkbox" name="facilitati[]" value="{FACIL_ID}" {CHECK} />&nbsp;&nbsp;{FACILITATE}</td>
				<!-- END facilitati_item -->
			</tr>
			<!-- END facilitati_row -->
			</table>
			</td>
		</tr>
		<tr>
			<td align="center" class="row1" colspan="2"><input type="button" class="button" value="Modifica" onClick="ValidateStep1();"/></td>
		</tr>
	</table>
</fieldset>
</form>