<script type="text/javascript" src="{SITE_BASE}/templates/js/prototype.js"></script>

<script language="JavaScript" type="text/javascript">
<!--

function CheckThisField(div_id)
{
	var target = 'div_'+div_id;
	if (target=='div_pass_2')
	{
		var url="http://www.turismdevis.ro/sources/check_fields.php?type=new_account&"+div_id+"="+document.getElementById(div_id).value+"&pass_1="+document.getElementById('pass_1').value;
	}
	else
	{
		var url="http://www.turismdevis.ro/sources/check_fields.php?type=new_account&"+div_id+"="+document.getElementById(div_id).value;
	}
	var myAjax = new Ajax.Updater(target, url, {	method: 'get'});
	$(target).show();
}

function ShowThisField(div_id)
{
	var target = 'div_'+div_id;
	$(target).show();
}


//-->
</script>

<h1>Adauga oferta de cazare</h1>
<form method="post" action="{USER_CREATE_LINK}">
<div style="padding-left: 3px;">
	<!-- BEGIN if_error -->
	<table border="0" cellspacing="0" cellpadding="0" width="400" align="center">
	<tr>
		<td class="error">
		<!-- BEGIN error -->
		<div class="text">{ERROR_MSG}</div>
		<!-- END error -->
		</td>
	</tr>
	</table>
	<!-- END if_error -->
	<table border="0" cellspacing="2" cellpadding="2" align="center" width="70%" class="table_content_border">
		<tr>
			<td colspan="2" class="notice"><b>Va rugam sa complectati toate campurile marcate cu </b><b class="star">*</b></td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="2">
			<table border="0" cellspacing="0" cellpadding="0" width="100%" style="padding-left: 10px;">
			<tr>
				<td class="text" width="120" ><b>Nume</b> :<b class="star">*</b></td>
				<td align="left"><input type="text" id="firstname" name="firstname" class="loginbox_input" value="{FIRSTNAME}" onblur="CheckThisField(this.id);" onfocus = "ShowThisField(this.id);"/></td>
			</tr>
			<tr>
				<td colspan="2" class="text"><div id='div_firstname' style="display: none;">Va rugam sa complectati acest camp cu Numele dvs.</div></td>
			</tr>
			</table>
			</td>
		</tr>
		<tr>
			<td colspan="2">
			<table border="0" cellspacing="0" cellpadding="0" width="100%" style="padding-left: 10px;">
			<tr>
				<td class="text" width="120" ><b>Prenume</b> :<b class="star">*</b></td>
				<td align="left"><input type="text" name="lastname" id="lastname" class="loginbox_input" value="{LASTNAME}" onblur="CheckThisField(this.id);" onfocus="ShowThisField(this.id);" /></td>
			</tr>
			<tr>
				<td colspan="2" class="text"><div id='div_lastname' style="display: none;">Va rugam sa complectati acest camp cu Prenumele dvs.</div></td>
			</tr>
			</table>
			</td>
		</tr>
		<tr>
			<td colspan="2">
			<table border="0" cellspacing="0" cellpadding="0" width="100%" style="padding-left: 10px;">
			<tr>
				<td class="text" width="120"><b>E-mail</b> :<b class="star">*</b></td>
				<td align="left"><input type="text" name="email" id="email" class="loginbox_input" value="{EMAIL}" onblur="CheckThisField(this.id);" onfocus = "ShowThisField(this.id);" /></td>
			</tr>
			<tr>
				<td colspan="2" class="text"><div id='div_email' style="display: none;">Va rugam sa complectati acest camp cu adresa dvs de E-mail.<br><b>De preferat sa nu fie o adresa YAHOO !</b></div></td>
			</tr>
			</table>
			</td>
		</tr>
		<tr>
			<td colspan="2">
			<table border="0" cellspacing="0" cellpadding="0" width="100%" style="padding-left: 10px;">
			<tr>
				<td class="text" width="120"><b>Utilizator</b> :<b class="star">*</b></td>
				<td class="text" align="left"><input type="text" name="username" id="username" class="loginbox_input" value="{USERNAME}" onblur="CheckThisField(this.id);" onfocus = "ShowThisField(this.id);" ></td>
			</tr>
			<tr>
				<td colspan="2" class="text"><div id='div_username' style="display: none;">Va rugam sa complectati acest camp cu numele dvs de Utilizator, minim 5 caractere.</div></td>
			</tr>
			</table>
			</td>
		</tr>
		<tr>
			<td colspan="2">
			<table border="0" cellspacing="0" cellpadding="0" width="100%" style="padding-left: 10px;">
			<tr>
				<td class="text" width="120"><b>Parola</b> :<b class="star">*</b></td>
				<td align="left"><input type="password" name="pass_1" id="pass_1" class="loginbox_input" onblur="CheckThisField(this.id);" onfocus = "ShowThisField(this.id);" /></td>
			</tr>
			<tr>
				<td colspan="2" class="text"><div id='div_pass_1' style="display: none;">Va rugam sa complectati acest camp cu Parola dvs,  orice parola, minim 5 caractere.</div></td>
			</tr>
			</table>
			</td>
		</tr>
		<tr>
			<td colspan="2">
			<table border="0" cellspacing="0" cellpadding="0" width="100%" style="padding-left: 10px;">
			<tr>
				<td class="text" width="120"><b>Rescrieti Parola</b> :<b class="star">*</b></td>
				<td align="left"><input type="password" name="pass_2" id="pass_2" class="loginbox_input" onblur="CheckThisField(this.id);" onfocus = "ShowThisField(this.id);" /></td>
			</tr>
			<tr>
				<td colspan="2" class="text"><div id='div_pass_2' style="display: none;">Va rugam sa rescrieti Parola aleasa de dvs in acest camp.</div></td>
			</tr>
			</table>
			</td>
		</tr>
		<tr>
			<td colspan="2">
			<table border="0" cellspacing="0" cellpadding="0" width="100%" style="padding-left: 10px;">
			<tr>
				<td class="text" width="120"><b>Cod de securitate</b> :<b class="star">*</b></td>
				<td align="left"><input type="text" name="security_code" id="security_code" class="loginbox_input" onblur="CheckThisField(this.id);" onfocus = "ShowThisField(this.id);" /></td>
			</tr>
			<tr>
				<td colspan="2" class="text"><div id='div_security_code' style="display: none;">Va rugam sa complecati acest camp cu caracterele din imaginea de mai jos, pentru a fi siguri ca sunteti o persoana reala.</div></td>
			</tr>
			</table>
			</td>
		</tr>
		<tr>
			<td colspan="2" align="center">
				<img src="{SITE_BASE}/security_image.php?code={SECURITYID}" alt="Security Image" style="border:none;">
			</td>
		</tr>
		<tr>
			<td align="center" colspan="2"><input type="submit" class="button" value="Adauga"/></td>
		</tr>
	</table>
</div>
</form>